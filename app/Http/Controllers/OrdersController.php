<?php

namespace App\Http\Controllers;

use App\Models\ProductSpecific;
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
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product']);

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Order by latest first
        $query->orderBy('created_at', 'desc');

        // Paginate results
        $orders = $query->paginate(10);

        return view('admin.manageorders', compact('orders'));
    }

    public function getOrderDetails($id)
    {
        $order = Order::with([
            'user',
            'orderItems.product'
        ])->findOrFail($id);

        return response()->json($order);
    }

    /**
     * Update the status of an order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->status = $request->status;
        $order->save();

        // If status is "delivered", you might want to update the delivery date
        if ($request->status == 'delivered') {
            $order->delivered_at = now();
            $order->save();
        }

        // Optionally, send notification to customer about status change
        // ... notification code here ...

        return redirect()->route('admin.manageorders')->with('success', "Order #$order->id status updated to ".ucfirst($order->status));
    }

    /**
     * Show the payment page
     */
    public function payment()
    {
        // Get the user's cart using Eloquent
        $cart = Cart::where('user_id', Auth::id())->first();

        if (! $cart || $cart->cartItems()->count() === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Get cart items with product details using Eloquent relationships
        $cartItems = $cart->cartItems()->with('product')->get()->map(function ($item) {
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
        if ($request->has('payment_method') && ! $request->has('final_submit')) {
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
        return DB::transaction(function () use ($request) {
            // Get the selected address from database
            $selectedAddress = Address::findOrFail($request->selected_address);
            $userProfile = UserProfile::where('user_id', Auth::id())->first();

            // Get cart and calculate totals
            $cart = Cart::where('user_id', Auth::id())->first();
            if (! $cart) {
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
            $order->status = 'pending';
            $order->order_date = now();
            $order->total_amount = $total;
            $order_success = $order->save();

            if ($order_success) {
                // Add order items - removed size and color fields
                foreach ($cartItems as $item) {
                    ProductSpecific::where(['product_id' => $item->product->id, 'size' => $item->size, 'color' => $item->color])->decrement('stock_quantity', $item->quantity);
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->color = $item->color; // Assuming color is a string in the order_items table
                    $orderItem->size = $item->size; // Assuming size is a string in the order_items table
                    $orderItem->product_id = $item->product->id;
                    $orderItem->quantity = $item->quantity;
                    $orderItem->price = $item->product->price;
                    // Removed size and color as they don't exist in the order_items table
                    $orderItem->save();
                }

                // Clear the cart
                $cart->cartItems()->delete();
                $cart->delete();

                // Try using a different approach to set the flash message
                Session::flash('success', 'Your payment was successful! Thank you for your order.');

                // Redirect to the home page
                return redirect('/homepage');
            } else {
                return redirect()->back()->with('error', 'There was an error processing your order. Please try again.');
            }
        });
    }

    public function showStatus()
    {
        $orders = Order::where('user_id', Auth::id())->with('orderItems.product')->get();

        if ($orders->isEmpty()) {
            return redirect()->route('homepage')->with('error', 'You have no orders.');
        }

        return view('status', ['orders' => $orders]); // ✅ use the correct view name
    }

    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderByDesc('order_date')
            ->get();

        return view('history', compact('orders'));
    }
}