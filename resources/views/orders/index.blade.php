@extends('layouts.frontend')

@section('title', 'My Orders')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex items-center justify-between animate-fade-in-up">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">My Orders</h1>
                <p class="text-gray-500 mt-2">View your order history and status</p>
            </div>
            <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up delay-100">
            @if($orders->count() > 0)
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
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50/80 transition duration-150 group">
                                    <td class="px-8 py-5 font-bold text-gray-900">
                                        #{{ $order->id }}
                                    </td>
                                    <td class="px-8 py-5 text-gray-600">
                                        {{ $order->created_at->format('M d, Y') }}
                                        <span class="block text-xs text-gray-400 font-normal mt-0.5">{{ $order->created_at->format('h:i A') }}</span>
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
                                        <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-5 py-2 bg-pink-50 text-pink-600 rounded-xl font-semibold text-sm hover:bg-pink-100 hover:text-pink-700 transition duration-200">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-8 py-4 border-t border-gray-100 bg-gray-50/30">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-20 px-8">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No orders found</h3>
                    <p class="text-gray-500 mb-8 max-w-sm mx-auto">It looks like you haven't placed any orders yet. Explore our products and start shopping today.</p>
                    <a href="{{ route('shop.index') }}" class="inline-block px-8 py-3 bg-pink-600 text-white rounded-full font-bold shadow-lg shadow-pink-200 hover:bg-pink-700 hover:shadow-xl transition transform hover:-translate-y-0.5">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
