<!DOCTYPE html>
<html>
<head>
    
<link rel = "stylesheet" href = "{{asset('css/product.css')}}">
<link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
<link rel = "stylesheet" href = "{{asset('css/productsDetail.css')}}">
<script src="{{ asset('js/navigation.js') }}"></script>

</head>
<body>

    <div class="top-bar">
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

        <div class="logo">
            <a href="/homepage"><img src="{{ asset('images/image/logo.jpg') }}" alt="COZILLA"></a>
        </div>
        <a href="{{ route('cart') }}" class="cart-button">
            <div class="cart-icon">🛒</div>
            <div class="cart-count">{{ $cartItemCount ?? 0 }}</div>
        </a>
    </div>

    @if(request()->has('query') && request('query') != '')
        <div class="search-results active" id="search-results">
            @if(isset($products) && count($products ?? []) > 0)
                @foreach($products as $searchProduct)
                    <a href="{{ route('products.show', $searchProduct->id) }}" class="search-result-item">
                        <img src="{{ asset($searchProduct->image_path) }}" alt="{{ $searchProduct->name }}" class="search-result-img">
                        <div class="search-result-info">
                            <div class="search-result-title">{{ $searchProduct->name }}</div>
                            <div class="search-result-category">{{ $searchProduct->gender_category }} >
                                {{ $searchProduct->top_bottom_category }} >
                                {{ str_replace('_', ' ', $searchProduct->clothes_category) }}
                            </div>
                        </div>
                        <div class="search-result-price">${{ number_format($searchProduct->price, 2) }}</div>
                    </a>
                @endforeach
            @else
                <div class="search-result-item">No products found</div>
            @endif
        </div>
    @endif

        <div class = sub-container>
            <div class="large-component">
                    @foreach ($category as $cat)
                    @if (!empty($cat['clothes_category']))
                        <a href="{{ route('category', ['gender_category' => request()->gender_category ?? $products->first()->gender_category ?? '']) }}?category={{ $cat['clothes_category'] }}" class="category-btn">
                            {{ ucwords(str_replace(['_', '-'], ' ', $cat['clothes_category'])) }}
                        </a>
                    @endif
                    @endforeach
                

                <!-- Products Grid -->
                <div class="product-grid">
                    @foreach ($products as $product)
                    <a href = '{{route("products.show", $product -> id)}}'>
                            <div class="product-card">
                                <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
                                <h3>{{ $product->name }}</h3>
                                <p>RM {{ number_format($product->price, 2) }}</p>
                            </div>

                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</body>
</html>
