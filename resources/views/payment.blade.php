
@include('partials.navigation')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
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
                                    <a href="{{ route('address.form') }}" class="checkout-button" style="margin-top: 10px;">
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
                                        <p class="item-quantity">Quantity: {{ $item['quantity'] }}</p>
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