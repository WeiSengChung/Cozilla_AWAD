<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    // Show the cart contents
    public function index()
    {
        // Get the user's cart
        $cart = Cart::where('user_id', Auth::id())->first();
        
        $cartItems = [];
        $subtotal = 0;
        $shipping = 0;
        $total = 0;
        
        if ($cart) {
            // Get cart items with product details
            $cartItems = CartItem::where('cart_id', $cart->id)
                ->with('product')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product' => $item->product,
                        'quantity' => $item->quantity,
                        'size' => $item->size,
                        'color' => $item->color
                    ];
                })
                ->toArray();
                
            // Calculate totals
            foreach ($cartItems as $item) {
                $subtotal += $item['product']->price * $item['quantity'];
            }
            
            // Set shipping cost (could be dynamic based on rules)
            $shipping = count($cartItems) > 0 ? 10.00 : 0;
            
            // Calculate total
            $total = $subtotal + $shipping;
        }
        
        // Get cart item count for header display
        $cartItemCount = $this->getCartItemCount();
        
        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'total', 'cartItemCount'));
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

        $product = Product::findOrFail($request->product_id);
        
        // Get or create user's cart
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = Auth::id();
            $cart->save();
        }

        // Check if this exact same cart item already exists
        $existingCartItem = CartItem::where([
            'cart_id' => $cart->id, 
            'product_id' => $request->product_id, 
            'size' => $request->size, 
            'color' => $request->color
        ])->first();

        if ($existingCartItem) {
            // Update the quantity of existing item
            $existingCartItem->quantity += $request->quantity;
            $existingCartItem->save();
        } else {
            // Create a new cart item
            $newCartItem = new CartItem();
            $newCartItem->product_id = $request->product_id;
            $newCartItem->quantity = $request->quantity;
            $newCartItem->size = $request->size;
            $newCartItem->color = $request->color;
            $newCartItem->cart_id = $cart->id;
            $newCartItem->save();
        }

        return redirect()->route('cart')->with('success', 'Item added to cart successfully!');
    }
    
    // Update item quantity in cart
    public function update(Request $request, $id)
    {
        $change = $request->input('change_quantity');
        
        $cartItem = CartItem::findOrFail($id);
        $newQuantity = $cartItem->quantity + $change;
        
        if ($newQuantity > 0) {
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            // If quantity would be 0 or less, remove the item
            $cartItem->delete();
        }

        return redirect()->route('cart');
    }

    // Remove an item from the cart
    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart')->with('success', 'Item removed from cart!');
    }

    // Helper method to get cart item count for displaying in the header
    public function getCartItemCount()
    {
        if (!Auth::check()) {
            return 0;
        }
        
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart) {
            return 0;
        }
        
        // Sum the quantities of all items in the cart
        return CartItem::where('cart_id', $cart->id)->sum('quantity');
    }
    
    // Method to retrieve cart item count for middleware or view composers
    public static function getCartCount()
    {
        if (!Auth::check()) {
            return 0;
        }
        
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart) {
            return 0;
        }
        
        return CartItem::where('cart_id', $cart->id)->sum('quantity');
    }
    
    /**
     * Display the checkout/payment page
     *
     * @return \Illuminate\View\View
     */
    public function payment()
{
    // Get the user's cart
    $cart = Cart::where('user_id', Auth::id())->first();
    
    if (!$cart) {
        return redirect()->route('cart')->with('error', 'Your cart is empty. Please add items before checkout.');
    }
    
    // Get cart items with product details
    $cartItems = CartItem::where('cart_id', $cart->id)
        ->with('product')
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'product' => $item->product,
                'quantity' => $item->quantity,
                'size' => $item->size,
                'color' => $item->color
            ];
        })
        ->toArray();
        
    // If cart is empty, redirect back to cart page
    if (empty($cartItems)) {
        return redirect()->route('cart')->with('error', 'Your cart is empty. Please add items before checkout.');
    }
    
    // Get user's addresses from the addresses table
    $addresses = \App\Models\Address::where('user_id', Auth::id())->get();
    
    // Calculate totals
    $subtotal = 0;
    foreach ($cartItems as $item) {
        $subtotal += $item['product']->price * $item['quantity'];
    }
    
    // Set shipping cost
    $shipping = 10.00;
    
    // Calculate total
    $total = $subtotal + $shipping;
    
    // Get cart item count for header display
    $cartItemCount = $this->getCartItemCount();
    
    return view('payment', compact('cartItems', 'subtotal', 'shipping', 'total', 'cartItemCount', 'addresses'));
}
    
    /**
     * Process the order from checkout form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeOrder(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
        ]);
        
        // Additional validation based on payment method
        if ($request->payment_method == 'credit_card') {
            $validator->addRules([
                'card_name' => 'required|string|max:255',
                'card_number' => 'required|string|max:19',
                'expiry_date' => 'required|string|max:5',
                'cvv' => 'required|string|max:4',
            ]);
        } elseif ($request->payment_method == 'paypal') {
            $validator->addRules([
                'paypal_email' => 'required|email|max:255',
            ]);
        } elseif ($request->payment_method == 'bank_transfer') {
            $validator->addRules([
                'transfer_reference' => 'required|string|max:255',
            ]);
        }
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Get the selected address and verify it belongs to the authenticated user
        $address = \App\Models\Address::findOrFail($request->address_id);
        if ($address->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Invalid address selected.');
        }
        
        // Get the user's cart
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Please add items before checkout.');
        }
        
        // Get cart items
        $cartItems = CartItem::where('cart_id', $cart->id)
            ->with('product')
            ->get();
            
        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }
        
        $shipping = 10.00; // Fixed shipping rate
        $total = $subtotal + $shipping;
        
        // Create order
        try {
            // Create the order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->address_id = $address->id;
            $order->subtotal = $subtotal;
            $order->total = $total;
            $order->status = 'pending';
            $order->save();
            
            // Create order items
            foreach ($cartItems as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->product_id;
                $orderItem->quantity = $item->quantity;
                $orderItem->price = $item->product->price;
                $orderItem->size = $item->size;
                $orderItem->color = $item->color;
                $orderItem->save();
            }
            
            // Clear the cart after successful order
            foreach ($cartItems as $item) {
                $item->delete();
            }
            
            // Redirect to thank you page or order confirmation
            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Your order has been placed successfully!');
                
        } catch (\Exception $e) {
            // Handle any errors
            return redirect()->back()
                ->with('error', 'There was a problem processing your order: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Display the order confirmation page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function orderConfirmation($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        
        // Make sure the order belongs to the logged in user
        if ($order->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Get cart item count for header display
        $cartItemCount = $this->getCartItemCount();
        
        return view('order.confirmation', compact('order', 'cartItemCount'));
    }
}