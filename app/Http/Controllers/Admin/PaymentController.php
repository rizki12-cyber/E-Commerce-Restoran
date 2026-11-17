<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Enums\PaymentStatus;
use App\Enums\OrderStatus;
use App\Services\ActivityLogService; // TAMBAHAN
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with(['order'])
            ->whereNotNull('proof_image')
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment): View
    {
        $payment->load(['order.items', 'order.statusHistories']);
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment): RedirectResponse
    {
        if ($payment->status->value === 'paid') {
            return redirect()->back()->with('error', 'Pembayaran ini sudah diverifikasi.');
        }

        DB::transaction(function () use ($payment) {
            $payment->update([
                'status' => PaymentStatus::PAID->value,
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);

            $order = $payment->order;
            $order->update([
                'payment_status' => PaymentStatus::PAID->value,
                'status' => OrderStatus::PAID->value,
                'paid_at' => now(),
            ]);

            $order->statusHistories()->create([
                'from_status' => OrderStatus::PENDING_PAYMENT->value,
                'to_status' => OrderStatus::PAID->value,
                'changed_by' => auth()->id(),
                'note' => 'Pembayaran diverifikasi oleh Admin.',
            ]);

            // Catat Log
            ActivityLogService::log('Verifikasi Pembayaran', 'Memverifikasi pembayaran pesanan #' . $order->order_number, $order);
        });

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(Request $request, Payment $payment): RedirectResponse
    {
        $request->validate(['rejection_reason' => 'required|string']);

        $payment->update([
            'status' => PaymentStatus::REJECTED->value,
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Catat Log
        ActivityLogService::log('Tolak Pembayaran', 'Menolak pembayaran pesanan #' . $payment->order->order_number, $payment->order);

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran ditolak. Customer diminta mengunggah ulang.');
    }
}