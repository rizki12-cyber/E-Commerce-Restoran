<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Order $order, OrderItem $orderItem): View|RedirectResponse
    {
        if ($order->user_id !== Auth::id() || $orderItem->order_id !== $order->id) {
            abort(403);
        }

        if ($order->status->value !== 'completed') {
            return redirect()->back()->with('error', 'Pesanan belum selesai.');
        }

        $hasReviewed = Review::where('order_item_id', $orderItem->id)->exists();
        if ($hasReviewed) {
            return redirect()->back()->with('error', 'Anda sudah mereview item ini.');
        }

        return view('customer.reviews.create', compact('order', 'orderItem'));
    }

    public function store(Request $request, ReviewService $reviewService): RedirectResponse
    {
        $validated = $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'order_number' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        try {
            $reviewService->createReview($validated);
            
            return redirect()->route('customer.orders.show', $validated['order_number'])
                ->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim dan menunggu persetujuan Admin.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}