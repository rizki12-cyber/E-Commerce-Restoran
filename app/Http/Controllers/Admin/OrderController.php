<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Enums\OrderStatus;
use App\Services\ActivityLogService; // TAMBAHAN
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%');
        }

        $orders = $query->paginate(15)->withQueryString();
        $statuses = OrderStatus::cases();

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'payments', 'statusHistories.user']);
        $statuses = OrderStatus::cases();
        
        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|string',
            'note' => 'nullable|string'
        ]);

        $newStatus = $request->status;
        $currentStatus = $order->status->value;

        $allowedTransitions = [
            'pending_payment' => ['cancelled', 'paid'],
            'paid' => ['processing', 'cancelled'],
            'processing' => ['ready', 'on_delivery', 'cancelled'],
            'ready' => ['completed'],
            'on_delivery' => ['completed'],
            'completed' => ['refunded'],
        ];

        if ($newStatus !== $currentStatus && !in_array($newStatus, $allowedTransitions[$currentStatus] ?? [])) {
            return redirect()->back()->with('error', "Tidak dapat mengubah status dari {$currentStatus} ke {$newStatus}.");
        }

        DB::transaction(function () use ($order, $newStatus, $currentStatus, $request) {
            if ($newStatus === 'cancelled' && $currentStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                        
                        InventoryMovement::create([
                            'product_id' => $item->product_id,
                            'product_variant_id' => null,
                            'type' => 'in',
                            'quantity' => $item->quantity,
                            'reason' => 'cancellation',
                            'reference_type' => 'order',
                            'reference_id' => $order->id,
                            'notes' => 'Pesanan dibatalkan oleh admin',
                            'created_by' => auth()->id(),
                        ]);
                    }
                }
            }

            $order->update([
                'status' => $newStatus,
                'completed_at' => $newStatus === 'completed' ? now() : $order->completed_at,
                'cancelled_at' => $newStatus === 'cancelled' ? now() : $order->cancelled_at,
            ]);

            $order->statusHistories()->create([
                'from_status' => $currentStatus,
                'to_status' => $newStatus,
                'changed_by' => auth()->id(),
                'note' => $request->note ?? 'Status diperbarui oleh Admin.',
            ]);

            // Catat Log
            ActivityLogService::log('Ubah Status Pesanan', "Mengubah status pesanan #{$order->order_number} menjadi {$newStatus}", $order);
        });

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}