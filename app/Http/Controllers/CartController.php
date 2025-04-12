<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
    // Show the cart contents
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart', compact('cart')); // Changed from 'cart.index' to 'cart'
    }
    // Add an item to the cart
    public function addToCart(Request $request)
{
    $request->validate([
        'product_id' => 'required|integer|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'size' => 'required|string',
        'color' => 'required|string',
    ]);

    $product = \App\Models\Product::findOrFail($request->product_id);
    $cart = Session::get('cart', []);
    $id = $request->product_id;

    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += $request->quantity;
    } else {
        $cart[$id] = [
            'product_id' => $id,
            'quantity' => $request->quantity,
            'name' => $product->name,
            'price' => $product->price,
            'size' => $request->size,
            'color' => $request->color,
        ];
    }

    Session::put('cart', $cart);
    return redirect()->route('cart')->with('success', 'Item added to cart successfully!');
}
    // Update an item in the cart
    public function update(Request $request, $id)
    {
        $change = $request->input('change');
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            // Change the quantity of the cart item
            $newQuantity = $cart[$id]['quantity'] + $change;

            // Ensure the quantity is positive
            if ($newQuantity > 0) {
                $cart[$id]['quantity'] = $newQuantity;
            } else {
                unset($cart[$id]);
            }

            // Update session with the new cart
            Session::put('cart', $cart);
        }

        // Redirect to the cart page
        return redirect()->route('cart');
    }

    // Remove an item from the cart
    public function remove($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        // Redirect to the cart page
        return redirect()->route('cart');
    }

    // Helper method to get cart item count for displaying in the header
    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        $count = 0;

        foreach ($cart as $item) {
            $count += $item['quantity'];
        }

        return $count;
    }

    // Get the total number of items in the cart
    public function getCartItemCount()
    {
        $cart = Session::get('cart', []);
        $itemCount = 0;

        foreach ($cart as $details) {
            $itemCount += $details['quantity'];
        }

        return $itemCount;
    }
}
