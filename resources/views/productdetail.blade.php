<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - COZILLA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f8f8;
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
        
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: white;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-top: 5px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        
        .search-results.active {
            display: block;
        }
        
        .search-result-item {
            padding: 12px 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
            text-decoration: none;
            color: inherit;
        }
        
        .search-result-item:hover {
            background-color: #f9f9f9;
        }
        
        .search-result-item:last-child {
            border-bottom: none;
        }
        
        .search-result-img {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            object-fit: cover;
            margin-right: 15px;
        }
        
        .search-result-info {
            flex-grow: 1;
        }
        
        .search-result-title {
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .search-result-category {
            font-size: 12px;
            color: #777;
        }
        
        .search-result-price {
            font-weight: bold;
            color: #4a574b;
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
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .breadcrumb {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #777;
        }
        
        .breadcrumb a {
            color: #4a574b;
            text-decoration: none;
            margin: 0 5px;
        }
        
        .breadcrumb a:first-child {
            margin-left: 0;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .breadcrumb span {
            margin: 0 5px;
        }
        
        .product-detail {
            display: flex;
            flex-wrap: wrap;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .product-gallery {
            flex: 1;
            min-width: 300px;
            padding: 20px;
        }
        
        .main-image {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 15px;
            object-fit: cover;
        }
        

        
        .product-info {
            flex: 1;
            min-width: 300px;
            padding: 30px;
        }
        
        .product-title {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .product-category {
            color: #777;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .product-price {
            font-size: 24px;
            font-weight: bold;
            color: #4a574b;
            margin-bottom: 20px;
        }
        
        .product-description {
            color: #555;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        
        .product-meta {
            margin-bottom: 25px;
        }
        
        .product-meta-item {
            display: flex;
            margin-bottom: 10px;
        }
        
        .meta-label {
            width: 100px;
            font-weight: bold;
            color: #555;
        }
        
        .meta-value {
            color: #777;
        }
        
        .product-options {
            margin-bottom: 25px;
        }
        
        .option-label {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        
        .size-options {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .size-option {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .size-option:hover, .size-option.active {
            background-color: #4a574b;
            color: white;
            border-color: #4a574b;
        }
        
        .color-options {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #eee;
            transition: all 0.2s;
        }
        
        .color-option:hover, .color-option.active {
            transform: scale(1.1);
            border-color: #4a574b;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .quantity-btn {
            width: 40px;
            height: 40px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            user-select: none;
        }
        
        .quantity-btn:hover {
            background-color: #eee;
        }
        
        .quantity-input {
            width: 60px;
            height: 40px;
            border: 1px solid #ddd;
            border-left: none;
            border-right: none;
            text-align: center;
            font-size: 16px;
        }
        
        .quantity-input:focus {
            outline: none;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .add-to-cart-btn {
            flex: 1;
            background-color: #4a574b;
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .add-to-cart-btn:hover {
            background-color: #3a4a3b;
        }
        
            @media (max-width: 768px) {
            .product-detail {
                flex-direction: column;
            }
            
            .action-buttons {
                flex-direction: column;
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
                    <input type="text" name="query" id="search-input" placeholder="Search..." value="{{ request('query') }}">
                    <button type="submit" class="search-icon">🔍</button>
                </div>
            </form>
            
            @if(request()->has('query') && request('query') != '')
                <div class="search-results active" id="search-results">
                    @if(isset($products) && count($products) > 0)
                        @foreach($products as $searchProduct)
                            <a href="{{ route('products.show', $searchProduct->id) }}" class="search-result-item">
                                <img src="{{ asset('images/image/'.$searchProduct->image_path) }}" alt="{{ $searchProduct->name }}" class="search-result-img">
                                <div class="search-result-info">
                                    <div class="search-result-title">{{ $searchProduct->name }}</div>
                                    <div class="search-result-category">{{ $searchProduct->gender_category }} > {{ $searchProduct->top_bottom_category }} > {{ str_replace('_', ' ', $searchProduct->clothes_category) }}</div>
                                </div>
                                <div class="search-result-price">${{ number_format($searchProduct->price, 2) }}</div>
                            </a>
                        @endforeach
                    @else
                        <div class="search-result-item">No products found</div>
                    @endif
                </div>
            @endif
        </div>
        <div class="logo">
            <img src="{{ asset('images/image/logo.jpg') }}" alt="COZILLA">
        </div>
    </div>
    
    <div class="container">
        <div class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <a href="#">{{ $product->gender_category }}</a>
            <span>/</span>
            <a href="#">{{ $product->top_bottom_category }}</a>
            <span>/</span>
            <a href="#">{{ str_replace('_', ' ', $product->clothes_category) }}</a>
            <span>/</span>
            <span>{{ $product->name }}</span>
        </div>
        
        <div class="product-detail">
            <div class="product-gallery">
                <img src="{{ asset('images/'.$product->image_path) }}" alt="{{ $product->name }}" class="main-image">
            </div>
            
            <div class="product-info">
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-category">{{ $product->gender_category }} > {{ $product->top_bottom_category }} > {{ str_replace('_', ' ', $product->clothes_category) }}</div>
                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                
                <div class="product-description">
                    @if(!empty($product->description))
                        {{ $product->description }}
                    @else
                        This stylish {{ strtolower(str_replace('_', ' ', $product->clothes_category)) }} is perfect for any occasion. Made with high-quality materials, it offers both comfort and durability. The {{ strtolower($product->gender_category) }}'s design features a modern fit that complements your wardrobe perfectly.
                    @endif
                </div>
                
                <div class="product-meta">
                    <div class="product-meta-item">
                        <div class="meta-label">SKU:</div>
                        <div class="meta-value">{{ strtoupper(substr($product->clothes_category, 0, 3)) }}{{ $product->id }}</div>
                    </div>
                    <div class="product-meta-item">
                        <div class="meta-label">Category:</div>
                        <div class="meta-value">{{ $product->gender_category }}, {{ $product->top_bottom_category }}, {{ str_replace('_', ' ', $product->clothes_category) }}</div>
                    </div>
                    <div class="product-meta-item">
                        <div class="meta-label">Tags:</div>
                        <div class="meta-value">{{ strtolower($product->gender_category) }}, fashion, {{ strtolower(str_replace('_', ' ', $product->clothes_category)) }}</div>
                    </div>
                </div>
                
                <div class="product-options">
                    <div class="option-label">Size:</div>
                    <div class="size-options">
                        <div class="size-option">S</div>
                        <div class="size-option active">M</div>
                        <div class="size-option">L</div>
                        <div class="size-option">XL</div>
                    </div>
                    
                    <div class="option-label">Color:</div>
                    <div class="color-options">
                        <div class="color-option active" style="background-color: #000;"></div>
                        <div class="color-option" style="background-color: #fff; border: 1px solid #ddd;"></div>
                        <div class="color-option" style="background-color: #2d4a58;"></div>
                        <div class="color-option" style="background-color: #924a3f;"></div>
                    </div>
                </div>
                
                <div class="quantity-control">
                    <div class="quantity-btn minus">-</div>
                    <input type="text" class="quantity-input" value="1" readonly>
                    <div class="quantity-btn plus">+</div>
                </div>
                
                <div class="action-buttons">
                    <button class="add-to-cart-btn">Add to Cart</button>
                </div>
                

            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            
            // Size selection
            const sizeOptions = document.querySelectorAll('.size-option');
            sizeOptions.forEach(option => {
                option.addEventListener('click', function() {
                    sizeOptions.forEach(o => o.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Color selection
            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    colorOptions.forEach(o => o.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Quantity controls
            const minusBtn = document.querySelector('.quantity-btn.minus');
            const plusBtn = document.querySelector('.quantity-btn.plus');
            const quantityInput = document.querySelector('.quantity-input');
            
            minusBtn.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });
            
            plusBtn.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                quantityInput.value = value + 1;
            });
            

        });
    </script>
</body>
</html>