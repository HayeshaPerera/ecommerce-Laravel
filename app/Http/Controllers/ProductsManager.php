<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsManager extends Controller
{
    public function index()
    {
        $products = Product::paginate(6);
        return view('products', compact('products'));
    }

    public function details($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('details', compact('product'));
    }

    public function addToCart($id)
    {
        try {
            $existingCartItem = Cart::where('user_id', auth()->user()->id)
                ->where('product_id', $id)
                ->first();
    
            if ($existingCartItem) {
                $existingCartItem->quantity += 1;
                $existingCartItem->save();
    
                session()->flash('success', 'Product quantity increased in the cart!');
                logger()->info('Success Flash Message: Product quantity increased in the cart!');
                return redirect()->route('cart.show');
            }
    
            $cart = new Cart();
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $id;
            $cart->quantity = 1;
    
            if ($cart->save()) {
                session()->flash('success', 'Product added to cart!');
                logger()->info('Success Flash Message: Product added to cart!');
                return redirect()->route('cart.show');
            }
    
            session()->flash('error', 'Failed to add product to cart.');
            logger()->info('Error Flash Message: Failed to add product to cart.');
            return redirect()->route('cart.show');
        } catch (\Exception $e) {
            logger()->error('Add to cart error: ' . $e->getMessage());
            session()->flash('error', 'An error occurred. Please try again.');
            return redirect()->route('cart.show');
        }
    }
    


    public function showCart()
    {
        // Fetch cart items with correct quantities
        $cartItems = DB::table('cart')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->select(
                'products.title',
                'cart.product_id',
                DB::raw('SUM(cart.quantity) as quantity'),
                'products.price'
            )
            ->where('cart.user_id', auth()->user()->id)
            ->groupBy('cart.product_id', 'products.title', 'products.price')
            ->get();

        return view('cart', compact('cartItems'));
    }

    public function removeFromCart($product_id)
    {
        Cart::where('user_id', auth()->user()->id)
            ->where('product_id', $product_id)
            ->delete();

        return redirect()->route('cart.show')->with('success', 'Item removed from cart.');
    }

    public function updateCart(Request $request, $product_id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1', // Validate quantity
    ]);

    // Find the cart item for the user and product
    $cartItem = Cart::where('user_id', auth()->user()->id)
        ->where('product_id', $product_id)
        ->first();

    if ($cartItem) {
        $cartItem->quantity = $request->quantity;  // Update quantity
        $cartItem->save();  // Save the updated item

        return redirect()->route('cart.show')->with('success', 'Quantity updated successfully!');
    }

    // If cart item is not found
    return redirect()->route('cart.show')->with('error', 'Product not found in cart.');
}

}
