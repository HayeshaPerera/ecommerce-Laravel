<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderManager extends Controller
{
    public function showCheckout()
    {
        return view("checkout");
    }

    public function checkoutPost(Request $request)
    {
        // Validation
        $request->validate([
            'address' => 'required',
            'pincode' => 'required',
            'phone' => 'required',
            'payment_method' => 'required|in:cod,online',  // Ensuring the payment method is either 'cod' or 'online'
        ], [
            'address.required' => 'Address is required.',
            'pincode.required' => 'Pin code is required.',
            'phone.required' => 'Phone number is required.',
            'payment_method.required' => 'Please select a payment method.',
            'payment_method.in' => 'Invalid payment method selected.',
        ]);

        // Get cart items
        $cartItems = DB::table('cart')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->select(
                'cart.product_id',
                DB::raw('count(*) as quantity'),
                'products.title',
                'products.price'
            )
            ->where('cart.user_id', auth()->user()->id)
            ->groupBy('cart.product_id', 'products.title', 'products.price')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect(route('checkout.show'))->with('error', 'Your cart is empty. Please add items before proceeding.');
        }

        $productIds = [];
        $quantities = [];
        $totalPrice = 0;

        // Calculate total price and prepare order details
        foreach ($cartItems as $cartItem) {
            $productIds[] = $cartItem->product_id;
            $quantities[] = $cartItem->quantity;
            $totalPrice += $cartItem->price * $cartItem->quantity;
        }

        // Create a new order
        $order = new Orders();
        $order->address = $request->address;
        $order->user_id = auth()->user()->id;
        $order->pincode = $request->pincode;
        $order->phone = $request->phone;
        $order->quantity = json_encode($quantities);
        $order->product_id = json_encode($productIds);
        $order->total_price = $totalPrice;

        // Handle payment method (COD or Online Payment)
        $order->payment_method = $request->payment_method;

        if ($order->save()) {
            // Empty the cart after successful order placement
            DB::table('cart')->where('user_id', auth()->user()->id)->delete();
            
            // Redirect to checkout page with success message
            return redirect(route('checkout.show'))->with('success', 'Order placed successfully!');

        }

        // Return error message in case of failure
        return redirect(route('checkout.show'))->with('error', 'An error occurred while placing your order.');
    }
}
