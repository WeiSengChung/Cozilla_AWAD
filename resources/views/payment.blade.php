@extends('layouts.app')

@section('title', 'Checkout - COZILLA')

@section('content')
    <style>
        /* All the existing CSS styles remain unchanged */
        /* Base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Poppins', 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        
        /* Container */
        .checkout-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }
        
        /* Header */
        .checkout-header {
            margin-bottom: 25px;
            border-bottom: 1px solid #eaeaea;
            padding-bottom: 15px;
        }
        
        .back-link {
            display: inline-block;
            color: #4a574b;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 10px;
            transition: all 0.2s ease;
            font-size: 14px;
        }
        
        .back-link:hover {
            color: #2c3e2d;
            transform: translateX(-3px);
        }
        
        .back-link i {
            margin-right: 5px;
            transition: transform 0.2s ease;
        }
        
        .back-link:hover i {
            transform: translateX(-2px);
        }
        
        .checkout-title {
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            color: #2c2c2c;
        }
        
        /* Alert messages */
        .alert-error {
            background-color: #fff5f5;
            border-left: 4px solid #ff5252;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            color: #d32f2f;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .alert-error ul {
            margin-left: 20px;
        }
        
        /* Grid layout */
        .checkout-grid {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 25px;
        }
        
        /* Form sections */
        .checkout-section {
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease;
        }
        
        .checkout-section:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c2c2c;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 18px 0 12px;
            color: #333;
        }
        
        .payment-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 18px;
            line-height: 1.5;
        }
        
        /* Form elements */
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .form-group {
            margin-bottom: 18px;
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
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s ease;
            background-color: #fafafa;
        }
        
        input:focus, select:focus {
            border-color: #4a574b;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 87, 75, 0.1);
            background-color: #fff;
        }
        
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23444' d='M10.3 3.3L6 7.6 1.7 3.3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l5 5c.2.2.4.3.7.3s.5-.1.7-.3l5-5c.4-.4.4-1 0-1.4s-1-.4-1.4 0z'/%3E%3C/svg%3E");
            background-position: calc(100% - 12px) center;
            background-repeat: no-repeat;
            padding-right: 35px;
        }
        
        .required {
            color: #e74c3c;
            margin-left: 2px;
        }
        
        /* Bank transfer details */
        .bank-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 18px;
            border-left: 3px solid #4a574b;
        }
        
        .bank-details p {
            margin: 6px 0;
            font-size: 14px;
        }
        
        /* Order summary */
        .order-items {
            margin-bottom: 20px;
            max-height: 350px;
            overflow-y: auto;
            padding-right: 5px;
        }
        
        .order-items::-webkit-scrollbar {
            width: 5px;
        }
        
        .order-items::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }
        
        .order-items::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 5px;
        }
        
        .order-items::-webkit-scrollbar-thumb:hover {
            background: #ccc;
        }
        
        .order-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .item-image {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
            margin-right: 15px;
            border-radius: 5px;
            overflow: hidden;
            border: 1px solid #eee;
        }
        
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .item-details {
            flex-grow: 1;
        }
        
        .item-title {
            font-size: 14px;
            font-weight: 500;
            margin: 0 0 5px;
            color: #333;
        }
        
        .item-meta, .item-quantity {
            font-size: 13px;
            color: #777;
            margin: 0 0 3px;
        }
        
        .item-price {
            font-size: 14px;
            font-weight: 600;
            min-width: 90px;
            text-align: right;
            color: #2c2c2c;
        }
        
        .order-totals {
            margin-top: 20px;
            background-color: #f9f9f9;
            border-radius: 6px;
            padding: 15px;
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
            border-top: 1px solid #e5e5e5;
            padding-top: 12px;
            margin-top: 8px;
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
            padding: 13px 0;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.2s ease;
        }
        
        .checkout-button:hover {
            background-color: #394638;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .checkout-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .checkout-button i {
            margin-right: 10px;
        }
        
        /* Responsive */
        @media (max-width: 900px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
            
            .checkout-details {
                order: 2;
            }
            
            .order-summary {
                order: 1;
            }
        }
        
        @media (max-width: 600px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .checkout-container {
                padding: 0 15px;
                margin: 1rem auto;
            }
            
            .checkout-section {
                padding: 20px;
            }
            
            .item-image {
                width: 50px;
                height: 50px;
                margin-right: 10px;
            }
            
            .section-title {
                font-size: 16px;
            }
            
            .checkout-title {
                font-size: 22px;
            }
        }

        /* Address selector styles */
        .address-selector {
            margin-bottom: 20px;
        }
        
        .address-option {
            margin-bottom: 15px;
        }
        
        .address-card {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .address-card:hover {
            border-color: #4a574b;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .address-card.selected {
            border-color: #4a574b;
            background-color: rgba(74, 87, 75, 0.05);
        }
        
        .address-content {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            margin-top: 10px;
        }
        
        .divider {
            margin: 20px 0;
            border-top: 1px solid #eee;
        }
    </style>

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
                        
                        <div class="address-selector">
                            <label>Select delivery address:</label>
                            
                            <!-- Retrieve user's saved addresses from the database -->
                            @php
                                $user = Auth::user();
                                $userAddresses = App\Models\Address::where('user_id', $user->id)->get();
                                $userProfile = App\Models\UserProfile::where('user_id', $user->id)->first();
                                
                                // Set default selected address (first one or from old input)
                                $selectedAddressId = old('selected_address', $userAddresses->count() > 0 ? $userAddresses->first()->id : null);
                            @endphp
                            
                            @if(count($userAddresses) > 0)
                                @foreach($userAddresses as $address)
                                    <div class="address-option">
                                        <div class="address-card {{ $selectedAddressId == $address->id ? 'selected' : '' }}">
                                            <label>
                                                <input type="radio" name="selected_address" value="{{ $address->id }}" 
                                                    {{ $selectedAddressId == $address->id ? 'checked' : '' }}>
                                                <strong>{{ $address->address_name ?? 'Address ' . $loop->iteration }}</strong>
                                                
                                                <div class="address-content">
                                                    {{ $userProfile->first_name ?? '' }} {{ $userProfile->last_name ?? '' }}<br>
                                                    {{ $address->street }}<br>
                                                    {{ $address->city }}, {{ $address->state }} {{ $address->postcode }}<br>
                                                    {{ $address->country }}<br>
                                                    {{ $userProfile->phone ?? '' }}
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="no-addresses-message">
                                    <p>You don't have any saved addresses. Please add a new address before proceeding with checkout.</p>
                                    <a href="{{ route('user.addresses.create') }}" class="checkout-button" style="margin-top: 10px;">
                                        <i class="fas fa-plus"></i> Add New Address
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="checkout-section">
                        <h2 class="section-title">Payment Method <span class="required">*</span></h2>
                        <div class="form-group">
                            <select name="payment_method" id="payment_method" required onchange="this.form.submit()">
                                <option value="">Select Payment Method</option>
                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                            <noscript>
                                <button type="submit" class="update-method-button">Update Payment Method</button>
                            </noscript>
                        </div>

                        <!-- Credit Card Details (shown only when credit_card is selected) -->
                        @if(old('payment_method') == 'credit_card')
                        <div class="payment-details">
                            <h3>Credit Card Details</h3>
                            <p class="payment-info">Please fill in your credit card information below.</p>
                            
                            <div class="form-group">
                                <label for="card_name">Name on Card <span class="required">*</span></label>
                                <input type="text" id="card_name" name="card_name" required 
                                    value="{{ old('card_name', ($userProfile->first_name ?? '') . ' ' . ($userProfile->last_name ?? '')) }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="card_number">Card Number <span class="required">*</span></label>
                                <input type="text" id="card_number" name="card_number" required placeholder="XXXX XXXX XXXX XXXX" value="{{ old('card_number') }}" maxlength="19">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date <span class="required">*</span></label>
                                    <input type="text" id="expiry_date" name="expiry_date" required placeholder="MM/YY" value="{{ old('expiry_date') }}" maxlength="5">
                                </div>
                                
                                <div class="form-group">
                                    <label for="cvv">CVV <span class="required">*</span></label>
                                    <input type="text" id="cvv" name="cvv" required placeholder="XXX" value="{{ old('cvv') }}" maxlength="4">
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- PayPal Details (shown only when paypal is selected) -->
                        @if(old('payment_method') == 'paypal')
                        <div class="payment-details">
                            <h3>PayPal Details</h3>
                            <p class="payment-info">You will be redirected to PayPal to complete your payment.</p>
                            
                            <div class="form-group">
                                <label for="paypal_email">PayPal Email <span class="required">*</span></label>
                                <input type="email" id="paypal_email" name="paypal_email" required value="{{ old('paypal_email', $user->email ?? '') }}">
                            </div>
                        </div>
                        @endif

                        <!-- Bank Transfer Details (shown only when bank_transfer is selected) -->
                        @if(old('payment_method') == 'bank_transfer')
                        <div class="payment-details">
                            <h3>Bank Transfer Details</h3>
                            <p class="payment-info">Please transfer the total amount to the following bank account:</p>
                            
                            <div class="bank-details">
                                <p><strong>Bank Name:</strong> COZILLA Bank</p>
                                <p><strong>Account Number:</strong> 1234567890</p>
                                <p><strong>Account Name:</strong> COZILLA Sdn Bhd</p>
                                <p><strong>Reference:</strong> Your Email</p>
                            </div>
                            
                            <div class="form-group">
                                <label for="transfer_reference">Transfer Reference <span class="required">*</span></label>
                                <input type="text" id="transfer_reference" name="transfer_reference" required placeholder="Your email or phone number" value="{{ old('transfer_reference', $user->email ?? '') }}">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="order-summary">
                    <div class="checkout-section">
                        <h2 class="section-title">Order Summary</h2>
                        
                        <div class="order-items">
                            @foreach($cartItems as $item)
                                <div class="order-item">
                                    <div class="item-image">
                                        <img src="{{ asset($item['product']->image_path) }}" alt="{{ $item['product']->name }}">
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
                                    
                                    <button type="submit" name="final_submit" value="1" class="checkout-button" {{ count($userAddresses) == 0 ? 'disabled' : '' }}>
                <i class="fas fa-lock"></i> Confirm Order & Pay
            </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
@endsection