<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COZILLA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #fff;
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
        
        .carousel-container {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            padding: 0;
            margin: 0;
            gap: 10px;
            padding: 10px;
        }
        
        .carousel-container::-webkit-scrollbar {
            display: none;
        }
        
        .carousel-item {
            flex: 0 0 auto;
            width: 33.333%;
            position: relative;
            scroll-snap-align: start;
        }
        
        .carousel-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 0;
        }
        
        .carousel-content {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: white;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
        
        .testimonials {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 10px;
            gap: 10px;
            margin-top: 20px;
        }
        
        .testimonial-card {
            background-color: #4a574b;
            color: white;
            border-radius: 10px;
            padding: 20px;
            flex: 1 1 300px;
            display: flex;
            flex-direction: column;
        }
        
        .testimonial-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }
        
        .testimonial-name {
            font-weight: bold;
            font-size: 18px;
            color: white;
        }
        
        .testimonial-text {
            margin-top: 0;
            line-height: 1.5;
            font-style: italic;
            font-size: 16px;
        }
        
        .rating {
            color: white;
            margin-top: 15px;
            font-size: 18px;
            letter-spacing: 2px;
        }
        
        @media (max-width: 768px) {
            .carousel-item {
                width: 100%;
            }
            
            .testimonials {
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
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product->id) }}" class="search-result-item">
                                <img src="{{ asset('images/image/'.$product->image_path) }}" alt="{{ $product->name }}" class="search-result-img">
                                <div class="search-result-info">
                                    <div class="search-result-title">{{ $product->name }}</div>
                                    <div class="search-result-category">{{ $product->gender_category }} > {{ $product->top_bottom_category }} > {{ str_replace('_', ' ', $product->clothes_category) }}</div>
                                </div>
                                <div class="search-result-price">${{ number_format($product->price, 2) }}</div>
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
    
    <div class="carousel-container">
        <div class="carousel-item">
            <img src="{{ asset('images/image/fashionsale.jpg') }}" alt="Summer Fashion Sale">
            <div class="carousel-content">
                <h2>Summer FASHION SALE</h2>
                <p>UP TO 70% OFF</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/image/summerClassic.jpg') }}" alt="Summer Classics">
            <div class="carousel-content">
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/image/offer50.jpg') }}" alt="H&M Sale">
            <div class="carousel-content">
            </div>
        </div>
    </div>

    <div class="testimonials">
        <div class="testimonial-card">
            <div class="testimonial-header">
                <img src="{{ asset('images/image/julie.jpg') }}" alt="Julia" class="testimonial-avatar">
                <h3 class="testimonial-name">Julia</h3>
            </div>
            <p class="testimonial-text">"The quality of this attire is exceptional; it feels durable and well-made."</p>
            <div class="rating">★★★★☆</div>
        </div>
        
        <div class="testimonial-card">
            <div class="testimonial-header">
                <img src="{{ asset('images/image/emerson.jpg') }}" alt="Amerson" class="testimonial-avatar">
                <h3 class="testimonial-name">Amerson</h3>
            </div>
            <p class="testimonial-text">"I love the design of this outfit; it's stylish and unique."</p>
            <div class="rating">★★★★★</div>
        </div>
        
        <div class="testimonial-card">
            <div class="testimonial-header">
                <img src="{{ asset('images/image/pewds.jpg') }}" alt="Elicia" class="testimonial-avatar">
                <h3 class="testimonial-name">Elicia</h3>
            </div>
            <p class="testimonial-text">Confortable price and fast shipping</p>
            <div class="rating">★★★★★</div>
        </div>
    </div>
</body>
</html>