@extends('layouts.frontend')

@section('title', 'Dashboard')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Section -->
        <div class="mb-8 animate-fade-in-up">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                Welcome back, <span class="text-pink-600">{{ Auth::user()->name }}</span>!
            </h1>
            <p class="text-gray-500 mt-2">Here's what's happening with your account today.</p>
        </div>

        <!-- Analytics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in-up delay-100">
            <!-- Total Orders -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Total Orders</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalOrders }}</p>
                    </div>
                    <div class="p-4 bg-pink-50 rounded-2xl text-pink-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Pending</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $pendingOrders }}</p>
                    </div>
                    <div class="p-4 bg-yellow-50 rounded-2xl text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Total Spent</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-2">${{ number_format($totalSpent, 2) }}</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-2xl text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up delay-200">
            <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Recent Orders</h3>
                    <p class="text-sm text-gray-500 mt-1">Track your latest purchases</p>
                </div>
                <a href="{{ route('orders.index') }}" class="group inline-flex items-center px-4 py-2 bg-pink-50 text-pink-600 rounded-xl font-semibold hover:bg-pink-100 transition duration-300">
                    View All Orders
                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="p-0">
                @if($recentOrders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                    <th class="px-8 py-4">Order ID</th>
                                    <th class="px-8 py-4">Date</th>
                                    <th class="px-8 py-4">Status</th>
                                    <th class="px-8 py-4">Total</th>
                                    <th class="px-8 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($recentOrders as $order)
                                    <tr class="hover:bg-gray-50/80 transition duration-150 group">
                                        <td class="px-8 py-5 font-bold text-gray-900">
                                            #{{ $order->id }}
                                        </td>
                                        <td class="px-8 py-5 text-gray-600">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-8 py-5">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold capitalize
                                                @if($order->status == 'delivered') bg-green-100 text-green-700
                                                @elseif($order->status == 'cancelled') bg-red-100 text-red-700
                                                @elseif($order->status == 'shipped') bg-blue-100 text-blue-700
                                                @else bg-yellow-100 text-yellow-700 @endif">
                                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 
                                                    @if($order->status == 'delivered') bg-green-500
                                                    @elseif($order->status == 'cancelled') bg-red-500
                                                    @elseif($order->status == 'shipped') bg-blue-500
                                                    @else bg-yellow-500 @endif"></span>
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 font-bold text-gray-900">
                                            ${{ number_format($order->total, 2) }}
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <a href="{{ route('orders.show', $order) }}" class="text-pink-500 hover:text-pink-700 font-semibold text-sm hover:underline">
                                                Track & Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-16 px-8">
                        <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-1">No orders placed yet</h4>
                        <p class="text-gray-500 mb-6">Start shopping to see your orders here.</p>
                        <a href="{{ route('shop.index') }}" class="inline-block px-8 py-3 bg-pink-600 text-white rounded-full font-bold shadow-lg shadow-pink-200 hover:bg-pink-700 hover:shadow-xl transition transform hover:-translate-y-0.5">
                            Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
