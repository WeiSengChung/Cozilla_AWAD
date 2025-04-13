<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
<link rel = "stylesheet" href = "{{asset('css/product.css')}}">
<script src="{{ asset('js/navigation.js') }}"></script>

</head>
<body>

        <div class = container>
        @include('partials.navigation')
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

</body>
</html>
