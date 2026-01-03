@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Dashboard Overview</h1>
                <p class="text-slate-500 mt-1">Analytics for {{ now()->format('F Y') }}</p>
            </div>
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200">
                <span class="flex h-3 w-3 relative">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-sm font-semibold text-slate-600">System Live</span>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Revenue Card -->
            <div
                class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg transition duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Revenue</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1">${{ number_format($totalSales, 2) }}</h3>
                    </div>
                    <div
                        class="p-2 bg-indigo-50 rounded-lg text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="text-green-500 font-semibold flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        +${{ number_format($revenueThisMonth, 2) }}
                    </span>
                    <span class="text-slate-400 ml-2">this month</span>
                </div>
            </div>

            <!-- Orders Card -->
            <div
                class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg transition duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Orders</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalOrders) }}</h3>
                    </div>
                    <div
                        class="p-2 bg-pink-50 rounded-lg text-pink-600 group-hover:bg-pink-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="text-green-500 font-semibold flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        +{{ $ordersThisMonth }}
                    </span>
                    <span class="text-slate-400 ml-2">this month</span>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div
                class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg transition duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Pending Orders</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($pendingOrders) }}</h3>
                    </div>
                    <div
                        class="p-2 bg-amber-50 rounded-lg text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="text-slate-400">Needs attention</span>
                </div>
            </div>

            <!-- Customers Card -->
            <div
                class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg transition duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Customers</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalUsers) }}</h3>
                    </div>
                    <div
                        class="p-2 bg-cyan-50 rounded-lg text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="text-slate-400">Active user base</span>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Monthly Revenue Chart -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-6">Revenue Analytics</h2>
                <div class="relative h-80 w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Top Selling Products -->
            <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-6">Top Selling Products</h2>
                <div class="space-y-4">
                    @forelse($topProducts as $item)
                        <div class="flex items-center gap-4 p-3 hover:bg-slate-50 rounded-lg transition">
                            <div class="h-12 w-12 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden">
                                @php
                                    $img = $item->product->images->first()->image ?? null;
                                    $src = $img ? (str_starts_with($img, 'http') ? $img : asset('storage/' . $img)) : null;
                                @endphp
                                @if($src)
                                    <img src="{{ $src }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $item->product->name }}</p>
                                <p class="text-xs text-slate-500">{{ $item->total_sold }} sold</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-indigo-600">${{ number_format($item->total_revenue) }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-slate-400 py-4">No sales data yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-800">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}"
                    class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-semibold">Order ID</th>
                            <th class="px-6 py-4 font-semibold">Customer</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Amount</th>
                            <th class="px-6 py-4 font-semibold">Date</th>
                            <th class="px-6 py-4 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentOrders as $order)
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="px-6 py-4 font-medium text-slate-800">#{{ $order->id }}</td>
                                            <td class="px-6 py-4 text-slate-600">{{ $order->user->name ?? 'Guest' }}</td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-xs font-bold
                                                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' :
                            ($order->status === 'processing' ? 'bg-blue-100 text-blue-700' :
                                ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')) }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 font-semibold text-slate-800">${{ number_format($order->total, 2) }}</td>
                                            <td class="px-6 py-4 text-slate-500 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">View</a>
                                            </td>
                                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');

        // Gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)'); // Indigo
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthLabels) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#6366f1',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 13 },
                        bodyFont: { size: 14 },
                        callbacks: {
                            label: function (context) {
                                return '$' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#e2e8f0' },
                        ticks: { callback: function (value) { return '$' + value; } }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
@endsection