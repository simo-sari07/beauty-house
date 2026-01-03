<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Key Performance Indicators (KPIs)
        $totalUsers = User::where('role', 'user')->count();
        $totalOrders = Order::count();
        $totalSales = Order::where('status', '!=', 'cancelled')->where('payment_status', 'paid')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();

        // Revenue this month
        $revenueThisMonth = Order::where('status', '!=', 'cancelled')
            ->where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Orders this month
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // 2. Monthly Revenue Chart Data
        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->where('status', '!=', 'cancelled')
            ->where('payment_status', 'paid')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        // Fill missing months with 0
        $chartData = [];
        $monthLabels = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthLabels[] = date('M', mktime(0, 0, 0, $i, 1));
            $chartData[] = $monthlyRevenue[$i] ?? 0;
        }

        // 3. Top Selling Products
        $topProducts = \App\Models\OrderItem::select('product_id', \DB::raw('SUM(quantity) as total_sold'), \DB::raw('SUM(price * quantity) as total_revenue'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product.images')
            ->take(5)
            ->get();

        // 4. Recent Orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOrders',
            'totalSales',
            'pendingOrders',
            'revenueThisMonth',
            'ordersThisMonth',
            'chartData',
            'monthLabels',
            'topProducts',
            'recentOrders'
        ));
    }
}
