@extends('layouts.app')

@section('title', 'Checkout - COZILLA')

@section('content')
    <div class="checkout-container">
        <div class="checkout-header">
            <a href="{{ route('cart') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Cart
            </a>
            <h1 class="checkout-title">Checkout</h1>
        </div>

        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
            @csrf
            <div class="checkout-grid">
                <div class="checkout-details">
                    <div class="checkout-section">
                        <h2 class="section-title">Shipping Address</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">First Name <span class="required">*</span></label>
                                <input type="text" id="first_name" name="first_name" required value="{{ old('first_name') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="last_name">Last Name <span class="required">*</span></label>
                                <input type="text" id="last_name" name="last_name" required value="{{ old('last_name') }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address <span class="required">*</span></label>
                            <input type="text" id="address" name="address" required value="{{ old('address') }}">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City <span class="required">*</span></label>
                                <input type="text" id="city" name="city" required value="{{ old('city') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="state">State <span class="required">*</span></label>
                                <input type="text" id="state" name="state" required value="{{ old('state') }}">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="postal_code">Postal Code <span class="required">*</span></label>
                                <input type="text" id="postal_code" name="postal_code" required value="{{ old('postal_code') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="country">Country <span class="required">*</span></label>
                                <input type="text" id="country" name="country" required value="{{ old('country', 'Malaysia') }}">
                            </div>
                        </div>
                    </div>

                    <div class="checkout-section">
                        <h2 class="section-title">Payment Method <span class="required">*</span></h2>
                        <div class="form-group">
                            <select name="payment_method" id="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                        </div>

                        <div class="payment-details">
                            <h3>Payment Details</h3>
                            <p class="payment-info">Please fill in the details below based on your selected payment method.</p>
                            
                            <div class="form-group">
                                <label for="card_name">Name on Card</label>
                                <input type="text" id="card_name" name="card_name" value="{{ old('card_name') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="card_number">Card Number</label>
                                <input type="text" id="card_number" name="card_number" placeholder="XXXX XXXX XXXX XXXX" value="{{ old('card_number') }}">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date</label>
                                    <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" value="{{ old('expiry_date') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="cvv">CVV</label>
                                    <input type="text" id="cvv" name="cvv" placeholder="XXX" value="{{ old('cvv') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-summary">
                    <div class="checkout-section">
                        <h2 class="section-title">Order Summary</h2>
                        
                        <div class="order-items">
                            @foreach($cartItems as $item)
                                <div class="order-item">
                                    <div class="item-image">
                                        <img src="{{ asset('images/'.$item['product']->image_path) }}" alt="{{ $item['product']->name }}">
                                    </div>
                                    <div class="item-details">
                                        <h4 class="item-title">{{ $item['product']->name }}</h4>
                                        <p class="item-meta">Size: {{ $item['size'] }} | Color: {{ $item['color'] }}</p>
                                        <p class="item-quantity">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                    <div class="item-price">
                                        RM {{ number_format($item['product']->price * $item['quantity'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="order-totals">
                            <div class="total-row">
                                <span>Subtotal</span>
                                <span>RM {{ number_format($subtotal, 2) }}</span>
                            </div>
                            
                            <div class="total-row">
                                <span>Shipping</span>
                                <span>RM {{ number_format($shipping, 2) }}</span>
                            </div>
                            
                            <div class="total-row grand-total">
                                <span>Total</span>
                                <span>RM {{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="checkout-button">
                            <i class="fas fa-lock"></i> Confirm Order & Pay
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<style>
    /* Base styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    
    body {
        font-family: 'Helvetica Neue', Arial, sans-serif;
        background-color: #f7f7f7;
        color: #333;
        line-height: 1.6;
    }
    
    /* Container */
    .checkout-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px 20px;
    }
    
    /* Header */
    .checkout-header {
        margin-bottom: 25px;
    }
    
    .back-link {
        display: inline-block;
        color: #4a574b;
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 15px;
        transition: color 0.2s;
    }
    
    .back-link:hover {
        color: #3a463b;
    }
    
    .checkout-title {
        font-size: 28px;
        font-weight: 600;
        margin: 0;
        color: #2c2c2c;
    }
    
    /* Alert messages */
    .alert-error {
        background-color: #fff2f2;
        border-left: 4px solid #ff5252;
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        color: #d32f2f;
    }
    
    .alert-error ul {
        margin-left: 20px;
    }
    
    /* Grid layout */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
    }
    
    /* Form sections */
    .checkout-section {
        background-color: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #2c2c2c;
    }
    
    h3 {
        font-size: 16px;
        font-weight: 600;
        margin: 20px 0 10px;
    }
    
    .payment-info {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }
    
    /* Form elements */
    .form-row {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .form-group {
        margin-bottom: 15px;
        flex: 1;
    }
    
    label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 6px;
        color: #444;
    }
    
    input, select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 15px;
        transition: border-color 0.3s;
    }
    
    input:focus, select:focus {
        border-color: #4a574b;
        outline: none;
        box-shadow: 0 0 0 2px rgba(74, 87, 75, 0.1);
    }
    
    .required {
        color: #e74c3c;
    }
    
    /* Order summary */
    .order-items {
        margin-bottom: 20px;
    }
    
    .order-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }
    
    .item-image {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        margin-right: 12px;
    }
    
    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 3px;
    }
    
    .item-details {
        flex-grow: 1;
    }
    
    .item-title {
        font-size: 14px;
        font-weight: 500;
        margin: 0 0 3px;
    }
    
    .item-meta, .item-quantity {
        font-size: 12px;
        color: #666;
        margin: 0 0 3px;
    }
    
    .item-price {
        font-size: 14px;
        font-weight: 500;
        min-width: 80px;
        text-align: right;
    }
    
    .order-totals {
        margin-top: 15px;
    }
    
    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        color: #555;
        font-size: 14px;
    }
    
    .grand-total {
        font-weight: 600;
        font-size: 16px;
        color: #2c2c2c;
        border-top: 1px solid #eee;
        padding-top: 10px;
        margin-top: 5px;
    }
    
    /* Button */
    .checkout-button {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        background-color: #4a574b;
        color: white;
        border: none;
        padding: 12px 0;
        font-size: 15px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 20px;
        transition: background-color 0.3s, transform 0.2s;
    }
    
    .checkout-button:hover {
        background-color: #394638;
        transform: translateY(-1px);
    }
    
    .checkout-button i {
        margin-right: 8px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
        
        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
</style>
@endpush