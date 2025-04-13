<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\UserProfile;
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
        // Check if this is just a payment method selection without final submission
        if ($request->has('payment_method') && !$request->has('final_submit')) {
            // Just updating the payment method display, store in session and return
            session(['payment_method' => $request->payment_method]);
            return redirect()->back()->withInput();
        }
        
        // Initialize validation rules for the address
        $rules = [
            'selected_address' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
        ];
        
        // Add payment-specific validation rules only if final submission
        if ($request->has('final_submit')) {
            if ($request->payment_method == 'credit_card') {
                $rules['card_name'] = 'required';
                $rules['card_number'] = 'required';
                $rules['expiry_date'] = 'required';
                $rules['cvv'] = 'required|numeric';
            } elseif ($request->payment_method == 'paypal') {
                $rules['paypal_email'] = 'required|email';
            } elseif ($request->payment_method == 'bank_transfer') {
                $rules['transfer_reference'] = 'required';
            }
        }
        
        // Perform validation
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Continue with order creation within a database transaction
        return DB::transaction(function() use ($request) {
            // Get the selected address from database
            $selectedAddress = Address::findOrFail($request->selected_address);
            $userProfile = UserProfile::where('user_id', Auth::id())->first();
            
            // Get cart and calculate totals
            $cart = Cart::where('user_id', Auth::id())->first();
            if (!$cart) {
                return redirect()->route('cart')->with('error', 'Your cart is empty.');
            }
            
            $cartItems = $cart->cartItems()->with('product')->get();
            
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item->product->price * $item->quantity;
            }
            
            $shipping = $cartItems->count() > 0 ? 10.00 : 0;
            $total = $subtotal + $shipping;
            
            // Create new order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->address_id = $selectedAddress->id;
            $order->payment_method = $request->payment_method;
            $order->status = 'pending';
            $order->order_date = now();
            $order->total_amount = $total;
            
            // Store payment details based on the payment method
            if ($request->payment_method == 'credit_card') {
                $order->payment_details = json_encode([
                    'card_name' => $request->card_name,
                    'card_number' => substr($request->card_number, -4), // Store only last 4 digits for security
                    'expiry_date' => $request->expiry_date
                ]);
            } elseif ($request->payment_method == 'paypal') {
                $order->payment_details = json_encode(['paypal_email' => $request->paypal_email]);
            } elseif ($request->payment_method == 'bank_transfer') {
                $order->payment_details = json_encode(['transfer_reference' => $request->transfer_reference]);
            }
            
            $order->save();
            
            // Add order items
            foreach ($cartItems as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->product->id;
                $orderItem->quantity = $item->quantity;
                $orderItem->price = $item->product->price;
                $orderItem->size = $item->size;
                $orderItem->color = $item->color;
                $orderItem->save();
            }
            
            // Clear the cart
            $cart->cartItems()->delete();
            $cart->delete();
            
            // Redirect to order confirmation
            return redirect()->route('orders.confirmation', $order->id)
                ->with('success', 'Your order has been placed successfully!');
        });
    }
}