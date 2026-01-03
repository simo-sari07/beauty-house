<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        $cartItems = $cart->items()->with('product.images')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $addresses = Address::where('user_id', Auth::id())->get();

        return view('frontend.checkout', compact('cartItems', 'total', 'addresses'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cod,stripe',
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        DB::beginTransaction();

        try {
            // Save address
            Address::create([
                'user_id' => Auth::id(),
                'fullname' => $validated['fullname'],
                'phone' => $validated['phone'],
                'city' => $validated['city'],
                'address' => $validated['address'],
            ]);

            // Calculate total
            $total = $cart->items->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Validate Stock Availability BEFORE creating order
            foreach ($cart->items as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Product '{$item->product->name}' is out of stock or requested quantity unavailable.");
                }
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] == 'cod' ? 'pending' : 'pending',
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
            }

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'method' => $validated['payment_method'],
                'status' => 'pending',
            ]);

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('order.success', $order->id)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function success($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('frontend.order-success', compact('order'));
    }
}
