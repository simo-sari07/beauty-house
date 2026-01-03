<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - BeautyHouse</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 0;
                background: white;
            }

            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 0;
            }
        }
    </style>
</head>

<body class="bg-gray-100 py-10 print:py-0 print:bg-white text-gray-800">

    <div
        class="invoice-container max-w-4xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden print:shadow-none print:rounded-none">

        <!-- Action Bar (Hidden in Print) -->
        <div class="no-print bg-gray-800 text-white p-4 flex justify-between items-center">
            <a href="{{ route('admin.orders.show', $order) }}"
                class="text-sm hover:text-gray-300 flex items-center gap-2">
                &larr; Back to Order
            </a>
            <button onclick="window.print()"
                class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-lg font-medium transition shadow-lg shadow-pink-900/50 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Print Invoice
            </button>
        </div>

        <!-- Invoice Content -->
        <div class="p-12">
            <!-- Header -->
            <div class="flex justify-between items-start border-b border-gray-100 pb-8 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-pink-600 rounded-lg print:hidden">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900">BeautyHouse</h1>
                    </div>
                    <p class="text-sm text-gray-500 max-w-xs leading-relaxed">
                        123 Beauty Avenue,<br>
                        Fashion District, NY 10001<br>
                        support@beautyhouse.com<br>
                        +1 (555) 123-4567
                    </p>
                </div>
                <div class="text-right">
                    <h2 class="text-4xl font-extrabold text-gray-200 uppercase tracking-widest mb-1">Invoice</h2>
                    <p class="text-lg font-bold text-gray-900">#INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm text-gray-500 mt-1">Date: {{ $order->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Billing & Shipping -->
            <div class="grid grid-cols-2 gap-12 mb-10">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Bill To</h3>
                    <p class="font-bold text-gray-900">{{ $order->user->name }}</p>
                    <p class="text-gray-600 text-sm mt-1">{{ $order->user->email }}</p>
                    <p class="text-gray-600 text-sm mt-1">{{ $order->user->phone ?? 'No phone provided' }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Ship To</h3>
                    @if($order->user->address)
                        <p class="font-bold text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-gray-600 text-sm mt-1">
                            {{ $order->user->address }}<br>
                            {{ $order->user->city }}
                        </p>
                    @else
                        <p class="text-gray-400 text-sm italic">No shipping address provided</p>
                    @endif
                </div>
            </div>

            <!-- Order Table -->
            <table class="w-full text-left mb-10">
                <thead>
                    <tr class="border-b-2 border-gray-100">
                        <th class="py-3 text-xs font-bold text-gray-400 uppercase tracking-wider w-1/2">Item Description
                        </th>
                        <th class="py-3 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Qty</th>
                        <th class="py-3 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Unit Price
                        </th>
                        <th class="py-3 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($order->items as $item)
                        <tr>
                            <td class="py-4">
                                <p class="font-bold text-gray-800">{{ $item->product->name }}</p>
                                <!-- <p class="text-xs text-gray-400">SKU: {{ $item->product->id }}</p> -->
                            </td>
                            <td class="py-4 text-center text-gray-600">{{ $item->quantity }}</td>
                            <td class="py-4 text-right text-gray-600">${{ number_format($item->price, 2) }}</td>
                            <td class="py-4 text-right font-medium text-gray-900">
                                ${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-400">No items found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Totals -->
            <div class="flex justify-end">
                <div class="w-64 space-y-3">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-medium">${{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Shipping</span>
                        <span class="font-medium text-green-600">Free</span>
                    </div>
                    <div class="border-t border-gray-100 my-2"></div>
                    <div class="flex justify-between text-lg font-bold text-gray-900">
                        <span>Total Due</span>
                        <span class="text-pink-600">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-16 pt-8 border-t border-gray-100 text-center text-sm text-gray-400">
                <p>Thank you for your business!</p>
                <p class="mt-1">For any queries, please contact support@beautyhouse.com</p>
            </div>
        </div>
    </div>

    <script>
        // Optional: Auto-print when opened if query param exists
        if (window.location.search.includes('print=true')) {
            window.print();
        }
    </script>
</body>

</html>