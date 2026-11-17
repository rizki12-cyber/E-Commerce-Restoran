<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $movements = InventoryMovement::with(['product', 'admin'])->latest()->paginate(15);
        $products = Product::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.inventory.index', compact('movements', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::lockForUpdate()->findOrFail($request->product_id);
            
            $qty = $request->quantity;
            
            // Logika pengurangan/penambahan stok
            if ($request->type === 'in') {
                $product->increment('stock', $qty);
            } elseif ($request->type === 'out') {
                if ($product->stock < $qty) {
                    throw new \Exception('Stok tidak mencukupi untuk dikurangi.');
                }
                $product->decrement('stock', $qty);
            } else {
                // Adjustment: jika type adjustment, quantity bisa berupa angka minus dari input (misal -5)
                // Tapi untuk amannya, kita anggap input selalu positif, dan sesuaikan stok akhirnya.
                // Di sini kita asumsikan 'in' dan 'out' yang dipakai.
            }

            InventoryMovement::create([
                'product_id' => $product->id,
                'type' => $request->type,
                'quantity' => $qty,
                'reason' => $request->reason,
                'notes' => $request->notes,
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()->back()->with('success', 'Stok berhasil diperbarui.');
    }
}