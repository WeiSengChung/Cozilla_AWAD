<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Show the payment page
     */
    public function payment()
    {
        // Get the user's cart using Eloquent
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->cartItems()->count() === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }
        
        // Get cart items with product details using Eloquent relationships
        $cartItems = $cart->cartItems()->with('product')->get()->map(function($item) {
            return [
                'id' => $item->id,
                'product' => $item->product,
                'quantity' => $item->quantity,
                'size' => $item->size,
                'color' => $item->color
            ];
        });
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['product']->price * $item['quantity'];
        }
        
        // Set shipping cost
        $shipping = count($cartItems) > 0 ? 10.00 : 0;
        
        // Calculate total
        $total = $subtotal + $shipping;
        
        return view('payment', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total
        ]);
    }

    /**
     * Store a new order
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer',
        ]);
        
        // Get the user's cart
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->cartItems()->count() === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }
        
        // Get cart items with product details using Eloquent relationships
        $cartItems = $cart->cartItems()->with('product')->get();
        
        // Calculate total amount
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }
        $shipping = 10.00; // Fixed shipping cost
        $total = $subtotal + $shipping;
        
        // Begin database transaction
        DB::beginTransaction();
        
        try {
            // Concatenate address fields
            $fullAddress = $validated['address'] . ', ' . 
                           $validated['city'] . ', ' . 
                           $validated['state'] . ', ' . 
                           $validated['postal_code'] . ', ' . 
                           $validated['country'];
            
            // Create new order using Eloquent
            $order = new Order();
            $order->user_id = Auth::id();
            $order->address_id = $fullAddress; // This would normally be an ID from an addresses table
            $order->order_date = now();
            $order->total_amount = $total;
            $order->status = 'pending';
            $order->payment_method = $validated['payment_method'];
            $order->save();
            
            // Create order items from cart items using Eloquent
            foreach ($cartItems as $cartItem) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cartItem->product_id;
                $orderItem->quantity = $cartItem->quantity;
                $orderItem->price = $cartItem->product->price;
                $orderItem->size = $cartItem->size;
                $orderItem->color = $cartItem->color;
                $orderItem->save();
            }
            
            // Clear the cart
            $cart->cartItems()->delete();
            
            // Commit transaction
            DB::commit();
            
            // Redirect to home page with success message instead of confirmation page
            return redirect()->route('home')
                ->with('success', 'Order placed successfully! Your order ID is #' . $order->id);
                
        } catch (\Exception $e) {
            // Rollback transaction on failure
            DB::rollBack();
            
            return redirect()->back()->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }
}