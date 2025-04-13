<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
<script src="{{ asset('js/navigation.js') }}"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - COZILLA</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="header">
        <div class="menu-icon">@include('partials.navigation')</div>
        <div class="search-container">
            <form action="{{ route('products.search') }}" method="GET">
                <div class="search-bar">
                    <input type="text" name="query" id="search-input" placeholder="Search..."
                        value="{{ request('query') }}">
                    <button type="submit" class="search-icon">🔍</button>
                </div>
            </form>
        </div>
        <a href="/homepage" class="logo">
            <img src="{{ asset('images/image/logo.jpg') }}" alt="COZILLA">
        </a>
        <a href="{{ route('cart') }}" class="cart-button">
            <div class="cart-icon">🛒</div>
            <div class="cart-count">{{ $cartItemCount ?? 0 }}</div>
        </a>
    </div>

    <div class="container">
        <h1 class="page-title">Your Shopping Cart</h1>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(isset($cartItems) && count($cartItems) > 0)
            <div class="cart-layout">
                <div class="cart-items-container">
                    @foreach($cartItems as $item)
                        <div class="cart-item">
                            <div class="cart-item-image">
                                <img src="{{ asset($item['product']->image_path) }}"
                                    alt="{{ $item['product']->name }}">
                            </div>

                            <div class="cart-item-details">
                                <h3 class="cart-item-title">{{ $item['product']->name }}</h3>
                                <div class="cart-item-info">
                                    Colour: {{ $item['color'] }}
                                </div>
                                <div class="cart-item-info">
                                    Size: {{ $item['size'] }}
                                </div>
                                <div class="cart-item-price">
                                    RM {{ number_format($item['product']->price, 2) }}
                                </div>

                                <div class="cart-item-actions">
                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST"
                                        class="quantity-control">
                                        @csrf
                                        <button type="submit" name="change_quantity" value="-1" class="quantity-btn">-</button>
                                        <input type="text" class="quantity-input" value="{{ $item['quantity'] }}" readonly>
                                        <button type="submit" name="change_quantity" value="1" class="quantity-btn">+</button>
                                    </form>

                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="remove-btn"><i style="color:red;"
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cart-summary-container">
                    <div class="cart-summary">
                        <div class="summary-row">
                            <div>Order value</div>
                            <div>RM {{ number_format($subtotal, 2) }}</div>
                        </div>

                        <div class="summary-row">
                            <div>Delivery</div>
                            <div>RM {{ number_format($shipping, 2) }}</div>
                        </div>

                        <div class="summary-row total">
                            <div>Total</div>
                            <div>RM {{ number_format($total, 2) }}</div>
                        </div>

                        <a href="{{ route('payment') }}" class="checkout-btn"><span class="btn-icon">✓</span> Check Out</a>
                        <a href="/homepage" class="add-more-btn"><span class="btn-icon">+</span> Add More Items</a>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added any products to your cart yet.</p>
                <a href="/homepage" class="continue-shopping"><span class="btn-icon">🛍️</span> Start Shopping</a>
            </div>
        @endif
    </div>

    <script>
        // Flash message auto-hide
        document.addEventListener('DOMContentLoaded', function () {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 3000);
            }
        });
    </script>
</body>

</html>