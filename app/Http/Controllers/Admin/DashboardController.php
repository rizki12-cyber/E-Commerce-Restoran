<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
       public function index(): View
    {
        // 1. Ringkasan Statistik
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending_payment')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalProducts = Product::count();

        // 2. Data Grafik (7 Hari Terakhir)
        $chartData = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = [];
        $chartValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $label = Carbon::now()->subDays($i)->format('d M');
            $found = $chartData->firstWhere('date', $date);
            $chartLabels[] = $label;
            $chartValues[] = $found ? $found->total : 0;
        }

        // 3. DATA TAMBAHAN UNTUK DASHBOARD OPTIMAL
        $recentOrders = Order::latest()->take(5)->get(); // 5 Pesanan Terbaru
        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')->orderBy('stock', 'asc')->take(5)->get(); // 5 Produk Stok Menipis

        return view('admin.dashboard', compact(
            'totalRevenue', 
            'totalOrders', 
            'pendingOrders', 
            'totalCustomers', 
            'totalProducts',
            'chartLabels',
            'chartValues',
            'recentOrders',      // TAMBAHKAN INI
            'lowStockProducts'   // TAMBAHKAN INI
        ));
    }
}