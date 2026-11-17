<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Contracts\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = User::where('role', 'customer')
            ->withCount(['orders' => function($query) {
                $query->whereIn('status', ['paid', 'processing', 'ready', 'on_delivery', 'completed']);
            }])
            ->withSum(['orders' => function($query) {
                $query->whereIn('status', ['paid', 'processing', 'ready', 'on_delivery', 'completed']);
            }], 'total_amount')
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user): View
    {
        if ($user->role !== 'customer') {
            abort(404);
        }

        $user->load('addresses');
        
        // Ambil data pesanan secara langsung (mencegah duplikat)
        $orders = Order::where('user_id', $user->id)->latest()->get();

        // Hitung total belanja secara langsung via database (mencegah error Enum)
        $totalSpent = Order::where('user_id', $user->id)
            ->whereIn('status', ['paid', 'processing', 'ready', 'on_delivery', 'completed'])
            ->sum('total_amount');

        return view('admin.customers.show', compact('user', 'orders', 'totalSpent'));
    }
}