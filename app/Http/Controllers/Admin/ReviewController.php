<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $query = Review::with(['user', 'product', 'replies'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->paginate(10)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function updateStatus(Request $request, Review $review): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $review->update(['status' => $request->status]);

        $message = $request->status === 'approved' ? 'Ulasan berhasil disetujui.' : 'Ulasan ditolak.';
        return redirect()->back()->with('success', $message);
    }

    public function reply(Request $request, Review $review): RedirectResponse
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $review->replies()->create([
            'user_id' => auth()->id(),
            'reply' => $request->reply,
        ]);

        return redirect()->back()->with('success', 'Balasan berhasil dikirim.');
    }
}