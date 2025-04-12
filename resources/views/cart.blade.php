<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - COZILLA</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f8f8;
            color: #333;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: white;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .menu-icon {
            font-size: 28px;
            cursor: pointer;
            width: 30px;
        }

        .search-container {
            flex-grow: 1;
            margin: 0 20px;
            position: relative;
        }

        .search-bar {
            width: 100%;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 15px;
            border-radius: 25px;
            border: 1px solid #ddd;
            outline: none;
            font-size: 16px;
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
            font-size: 16px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 30px;
            margin-right: 5px;
        }

        .cart-button {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            margin-left: 20px;
            position: relative;
        }

        .cart-icon {
            font-size: 24px;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #4a574b;
            color: white;
            font-size: 12px;
            font-weight: bold;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
            font-weight: normal;
        }

        .alert-success {
            background-color: #f0f7ee;
            border-left: 3px solid #4a574b;
            color: #4a574b;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 3px;
        }

        .cart-layout {
            display: flex;
            gap: 30px;
        }

        .cart-items-container {
            flex: 7;
        }

        .cart-summary-container {
            flex: 3;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 30px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item-image {
            flex: 0 0 120px;
            margin-right: 25px;
        }

        .cart-item-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item-title {
            font-size: 18px;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .cart-item-info {
            margin-bottom: 5px;
            color: #666;
            font-size: 14px;
        }

        .cart-item-price {
            font-size: 16px;
            margin-bottom: 12px;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 400px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            width: 24px;
            height: 24px;
            background-color: transparent;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
        }

        .quantity-input {
            width: 30px;
            text-align: center;
            border: none;
            font-size: 16px;
            background: transparent;
        }

        .remove-btn {
            background-color: rgb(255, 255, 255);
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-summary {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #666;
            font-size: 15px;
        }

        .summary-row.total {
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: 15px;
            font-weight: bold;
            font-size: 20px;
            color: #333;
        }

        /* Updated checkout button styles */
        .checkout-btn {
            background-color: #4a574b;
            color: white;
            border: none;
            padding: 15px 20px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .checkout-btn:hover {
            background-color: #3d4a3e;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Updated add more items button styles */
        .add-more-btn {
            background-color: white;
            color: #4a574b;
            border: 2px solid #4a574b;
            padding: 14px 20px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
        }

        .add-more-btn:hover {
            background-color: #f5f8f5;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }

        .empty-cart {
            text-align: center;
            padding: 50px 20px;
            color: #777;
        }

        .empty-cart-icon {
            font-size: 50px;
            margin-bottom: 20px;
            color: #ddd;
        }

        /* Updated continue shopping button for empty cart */
        .continue-shopping {
            background-color: #4a574b;
            color: white;
            display: inline-block;
            padding: 14px 28px;
            margin-top: 25px;
            text-decoration: none;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .continue-shopping:hover {
            background-color: #3d4a3e;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Add button icons */
        .btn-icon {
            margin-right: 8px;
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .cart-layout {
                flex-direction: column;
            }

            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .cart-item-image {
                margin-bottom: 15px;
                margin-right: 0;
            }

            .cart-item-actions {
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="menu-icon">≡</div>
        <div class="search-container">
            <form action="{{ route('products.search') }}" method="GET">
                <div class="search-bar">
                    <input type="text" name="query" id="search-input" placeholder="Search..."
                        value="{{ request('query') }}">
                    <button type="submit" class="search-icon">🔍</button>
                </div>
            </form>
        </div>
        <a href="/" class="logo">
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
                                <img src="{{ asset('images/'.$item['product']->image_path) }}"
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

                        <a href="#" class="checkout-btn"><span class="btn-icon">✓</span> Check Out</a>
                        <a href="/" class="add-more-btn"><span class="btn-icon">+</span> Add More Items</a>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added any products to your cart yet.</p>
                <a href="/" class="continue-shopping"><span class="btn-icon">🛍️</span> Start Shopping</a>
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