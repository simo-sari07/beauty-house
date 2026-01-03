<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function invoice(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.invoice', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update($validated);
        $newStatus = $validated['status'];

        // STOCK MANAGEMENT LOGIC
        // 1. Pending -> Confirmed/Shipped/Delivered : DEDUCT STOCK
        if ($oldStatus === 'pending' && in_array($newStatus, ['confirmed', 'shipped', 'delivered'])) {
            foreach ($order->items as $item) {
                // Decrement stock, ensuring it doesn't go below 0 (though checkout check should prevent this)
                if ($item->product->stock >= $item->quantity) {
                    $item->product->decrement('stock', $item->quantity);
                } else {
                    // Fallback: Set to 0 if weird data inconsistency
                    $item->product->update(['stock' => 0]);
                }
            }
        }

        // 2. Confirmed/Shipped -> Cancelled : RESTORE STOCK
        // Only restore if it was previously deducted (i.e., not pending)
        if (in_array($oldStatus, ['confirmed', 'shipped', 'delivered']) && $newStatus === 'cancelled') {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        // Auto-update payment status for COD if delivered
        if ($validated['status'] === 'delivered' && $order->payment_method === 'cod') {
            $order->update(['payment_status' => 'paid']);
        }

        return back()->with('success', 'Order status updated successfully!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }
}
