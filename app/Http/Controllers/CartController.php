<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function __construct()
    {
        // Ensure session is started
        if (!session()->isStarted()) {
            session()->start();
        }
    }
    
    public function index()
    {
        // Enhanced Debug session information
        \Log::info('Session ID in index method: ' . session()->getId());
        \Log::info('Session driver: ' . config('session.driver'));
        \Log::info('Cart data in index:', Session::get('cart') ?: ['empty' => true]);
        
        // Get cart items from the session
        $cartItems = $this->getCartItems();
        
        // Debug cart items
        \Log::info('Cart Items Count: ' . (is_array($cartItems) ? count($cartItems) : 'not an array'));
        
        // Calculate cart totals
        $subtotal = 0;
        if (is_array($cartItems) && count($cartItems) > 0) {
            foreach ($cartItems as $item) {
                $subtotal += $item['product']->price * $item['quantity'];
            }
        }
        
        $tax = $subtotal * 0.1; // 10% tax
        $shipping = $subtotal > 0 ? 10 : 0; // $10 shipping fee if cart is not empty
        $total = $subtotal + $tax + $shipping;
        
        // Special debug dump of all variables being passed to the view
        \Log::info('Variables passed to cart view:', [
            'cartItemsCount' => is_array($cartItems) ? count($cartItems) : 'not an array',
            'subtotal' => $subtotal,
        ]);
        
        return view('cart', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }
    
    public function add(Request $request)
    {
        \Log::info('Cart add method called with data:', $request->all());
        \Log::info('Session ID in add method: ' . session()->getId());
        
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string',
            'color' => 'required|string',
        ]);
        
        // Get product using Eloquent
        $product = Product::findOrFail($validated['product_id']);
        \Log::info('Product found:', ['id' => $product->id, 'name' => $product->name]);
        
        // Get current cart from session, ensure array type
        $cart = Session::get('cart', []);
        if (!is_array($cart)) {
            \Log::warning('Cart is not an array, resetting to empty array');
            $cart = [];
        }
        
        \Log::info('Current cart before update:', $cart);
        
        // Generate a unique cart item ID
        $itemId = uniqid();
        
        // Check if product with same size and color already exists in cart
        $existingItemKey = null;
        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $validated['product_id'] && 
                $item['size'] == $validated['size'] && 
                $item['color'] == $validated['color']) {
                $existingItemKey = $key;
                break;
            }
        }
        
        if ($existingItemKey !== null) {
            // Update quantity if item exists
            $cart[$existingItemKey]['quantity'] += $validated['quantity'];
            \Log::info('Updated existing item in cart');
        } else {
            // Add new item to cart
            $cart[] = [
                'id' => $itemId,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'size' => $validated['size'],
                'color' => $validated['color'],
            ];
            \Log::info('Added new item to cart');
        }
        
        // Save cart back to session and force session save
        Session::put('cart', $cart);
        Session::save();
        
        // Flash success message to the session
        Session::flash('success', 'Product added to cart!');
        
        // Redirect to cart page
        return redirect()->route('cart');
    }
    
    public function update(Request $request, $id)
    {
        \Log::info('Cart update method called with data:', [
            'request' => $request->all(),
            'id' => $id
        ]);
        
        $cart = Session::get('cart', []);
        
        if (!is_array($cart)) {
            $cart = [];
        }
        
        foreach ($cart as $key => $item) {
            if ($item['id'] == $id) {
                if ($request->has('change_quantity')) {
                    $change = (int)$request->change_quantity;
                    $newQuantity = $item['quantity'] + $change;
                    
                    if ($newQuantity > 0) {
                        $cart[$key]['quantity'] = $newQuantity;
                    } else {
                        // Remove item if quantity becomes 0 or negative
                        unset($cart[$key]);
                    }
                } else if ($request->has('quantity')) {
                    $newQuantity = (int)$request->quantity;
                    if ($newQuantity > 0) {
                        $cart[$key]['quantity'] = $newQuantity;
                    }
                }
                break;
            }
        }
        
        Session::put('cart', $cart);
        Session::save();
        
        return redirect()->route('cart');
    }
    
    public function remove($id)
    {
        \Log::info('Cart remove method called for item ID: ' . $id);
        
        $cart = Session::get('cart', []);
        
        if (!is_array($cart)) {
            $cart = [];
        }
        
        foreach ($cart as $key => $item) {
            if ($item['id'] == $id) {
                unset($cart[$key]);
                break;
            }
        }
        
        Session::put('cart', $cart);
        Session::save();
        
        return redirect()->route('cart');
    }
    
    // Helper method to get cart items with product details
    private function getCartItems()
    {
        $cart = Session::get('cart', []);
        
        // Ensure cart is an array
        if (!is_array($cart)) {
            \Log::warning('Cart is not an array in getCartItems, returning empty array');
            return [];
        }
        
        \Log::info('Getting cart items for cart with ' . count($cart) . ' items');
        
        $cartItems = [];
        
        foreach ($cart as $item) {
            // Debug each cart item
            \Log::info('Processing cart item:', $item);
            
            // Check if item has required keys
            if (!isset($item['product_id'])) {
                \Log::warning('Cart item missing product_id:', $item);
                continue;
            }
            
            // Use Eloquent to get product
            $product = Product::find($item['product_id']);
            
            // Debug product lookup
            \Log::info('Product lookup result:', [
                'product_id' => $item['product_id'], 
                'found' => ($product ? 'yes' : 'no')
            ]);
            
            if ($product) {
                // Make sure image path exists
                if (!isset($product->image_path) || empty($product->image_path)) {
                    \Log::warning('Product has no image path: ' . $product->id);
                    $product->image_path = 'placeholder.jpg';
                }
                
                // Ensure all required item data exists
                $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
                $size = isset($item['size']) ? $item['size'] : 'Default';
                $color = isset($item['color']) ? $item['color'] : 'Default';
                
                $cartItems[] = [
                    'id' => $item['id'],
                    'product' => $product,
                    'quantity' => $quantity,
                    'size' => $size,
                    'color' => $color,
                ];
                
                \Log::info('Added item to cartItems array');
            } else {
                \Log::warning('Product not found in database: ' . $item['product_id']);
            }
        }
        
        \Log::info('Returning ' . count($cartItems) . ' cart items');
        return $cartItems;
    }
    
    // This helper method provides cart item count for the header
    public function getCartItemCount()
    {
        $cart = Session::get('cart', []);
        
        // Ensure cart is an array
        if (!is_array($cart)) {
            return 0;
        }
        
        return collect($cart)->sum('quantity');
    }
}