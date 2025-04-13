<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
<script src="{{ asset('js/navigation.js') }}"></script>
    <style>
        .large-component {
            margin-left: 80px;
            padding:20px;
        }

        .category-btn {
        background-color: #3d4239;
        color: white;
        padding: 10px 20px;
        border-radius: 15px;
        margin: 5px;
        display: inline-block;
        text-decoration: none;
        font-family: 'Times New Roman', serif;
    }

    .category-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

        
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding-top:10px;
        }

        .product-grid a {
            text-decoration:none;
        }

        .product-card {
            width: 200px;
            text-align: center;
            text-decoration: none;
            color: black;
        }

        img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        
    </style>
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
