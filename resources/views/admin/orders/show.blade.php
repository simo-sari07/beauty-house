@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('admin.orders.index') }}"
                    class="p-2 bg-white rounded-full text-gray-500 hover:text-pink-600 hover:bg-pink-50 transition shadow-sm border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Order #{{ $order->id }}</h1>
            </div>
            <p class="text-sm text-gray-500 ml-11">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-5 py-2.5 bg-white border border-red-200 text-red-600 font-medium rounded-xl hover:bg-red-50 hover:border-red-300 transition shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Delete Order
                </button>
            </form>
            <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank"
                class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:text-pink-600 hover:border-pink-200 transition shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z">
                    </path>
                </svg>
                Print Invoice
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Left Column: Products & Totals -->
        <div class="xl:col-span-2 space-y-8">
            <!-- Order Items -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-800">Products Ordered</h2>
                    <span
                        class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">{{ $order->items->count() }}
                        items</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($order->items as $item)
                        <a href="{{ route('admin.products.edit', $item->product) }}" class="block text-inherit group">
                            <div
                                class="p-6 flex flex-col sm:flex-row items-center sm:items-start gap-6 hover:bg-gray-50 transition duration-150">
                                <div
                                    class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 border border-gray-200 group-hover:border-pink-200 transition">
                                    @php
                                        $productImage = $item->product->images->first();
                                        $imageSrc = $productImage ? (str_starts_with($productImage->image, 'http') ? $productImage->image : asset('storage/' . $productImage->image)) : 'https://via.placeholder.com/150';
                                    @endphp
                                    <img src="{{ $imageSrc }}" alt="{{ $item->product->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 text-center sm:text-left">
                                    <h3 class="font-bold text-gray-900 text-lg mb-1 group-hover:text-pink-600 transition">
                                        {{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-500 mb-2">Unit Price: ${{ number_format($item->price, 2) }}</p>
                                    <div
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                        Qty: {{ $item->quantity }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-900">
                                        ${{ number_format($item->price * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <p>No items found for this order. (Data may be incomplete)</p>
                        </div>
                    @endforelse
                </div>

                <!-- Summary Footer -->
                <div class="bg-gray-50 px-8 py-6 border-t border-gray-100">
                    <div class="flex flex-col gap-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium text-gray-900">${{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium text-green-600">Free</span>
                        </div>
                        <div class="border-t border-gray-200 my-2"></div>
                        <div class="flex justify-between items-center text-xl font-extrabold text-gray-900">
                            <span>Total</span>
                            <span class="text-pink-600">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Customer & Actions -->
        <div class="space-y-8">
            <!-- Order Status Action -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-800">Update Status</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                            <select name="status"
                                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 transition">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                                </option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full py-3 px-4 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-bold rounded-xl shadow-lg shadow-pink-500/30 transition transform hover:-translate-y-0.5">
                            Update Order Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">Customer Details</h3>
                    <div class="bg-blue-100 p-1.5 rounded-lg text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide mb-1">Full Name</p>
                            <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide mb-1">Contact Info</p>
                            <div class="space-y-1">
                                <p class="text-sm text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ $order->user->email }}
                                </p>
                                <p class="text-sm text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    {{ $order->user->phone ?? 'No Phone' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wide mb-2">Shipping Address</p>
                        @if($order->user->address)
                            <p class="text-sm text-gray-800 leading-relaxed">
                                {{ $order->user->address }}<br>
                                {{ $order->user->city }}
                            </p>
                        @else
                            <p class="text-sm text-gray-400 italic">No address provided</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">Payment Info</h3>
                    <div class="bg-green-100 p-1.5 rounded-lg text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide mb-1">Method</p>
                            <p class="font-bold text-gray-900">{{ strtoupper($order->payment_method) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide mb-1">Status</p>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection