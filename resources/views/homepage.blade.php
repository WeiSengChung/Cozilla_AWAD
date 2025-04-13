<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/productsDetail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <script src="{{ asset('js/navigation.js') }}"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
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

                    @if(request()->has('query') && request('query') != '')
                    <div class="search-results active" id="search-results">
                        @if(isset($products) && count($products ?? []) > 0)
                            @foreach($products as $searchProduct)
                                <a href="{{ route('products.show', $searchProduct->id) }}" class="search-result-item">
                                    <img src="{{ asset($searchProduct->image_path) }}" alt="{{ $searchProduct->name }}"
                                        class="search-result-img">
                                    <div class="search-result-info">
                                        <div class="search-result-title">{{ $searchProduct->name }}</div>
                                        <div class="search-result-category">{{ $searchProduct->gender_category }} >
                                            {{ $searchProduct->top_bottom_category }} >
                                            {{ str_replace('_', ' ', $searchProduct->clothes_category) }}
                                        </div>
                                    </div>
                                    <div class="search-result-price">RM{{ number_format($searchProduct->price, 2) }}</div>
                                </a>
                            @endforeach
                        @else
                            <div class="search-result-item">No products found</div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="logo">
                <a href="/homepage"><img src="{{ asset('images/image/logo.jpg') }}" alt="COZILLA"></a>
            </div>
            <a href="{{ route('cart') }}" class="cart-button">
                <div class="cart-icon">🛒</div>
                <div class="cart-count">{{ $cartItemCount ?? 0 }}</div>
            </a>
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
            <p class="testimonial-text">Comfortable price and fast shipping</p>
            <div class="rating">★★★★★</div>
        </div>
    </div>
</body>

</html>