<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        // Pastikan customer hanya bisa melihat pesanannya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'payments', 'statusHistories']);

        return view('customer.orders.show', compact('order'));
    }

    public function uploadPayment(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status->value !== 'unpaid') {
            return redirect()->back()->with('error', 'Pesanan ini sudah dibayar atau diproses.');
        }

        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ]);

        $payment = $order->payments()->latest()->first();

        if ($payment->proof_image) {
            Storage::disk('public')->delete($payment->proof_image);
        }

        $path = $request->file('proof_image')->store('payments', 'public');

        $payment->update([
            'proof_image' => $path,
        ]);

        // Update status history
        $order->statusHistories()->create([
            'from_status' => $order->status->value,
            'to_status' => $order->status->value, // Status pesanan tetap pending_payment, tapi bukti sudah diunggah
            'changed_by' => Auth::id(),
            'note' => 'Customer mengunggah bukti pembayaran.',
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah. Mohon tunggu verifikasi dari Admin.');
    }
}