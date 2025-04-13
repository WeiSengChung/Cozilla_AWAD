
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="{{ asset('css/productsDetail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <script src="{{ asset('js/navigation.js') }}"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - COZILLA</title>
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
            <a href="/homepage"><img src="{{ asset('images/image/logo.jpg') }}" alt="COZILLA"></a>
        </div>
        <a href="{{ route('cart') }}" class="cart-button">
            <div class="cart-icon">🛒</div>
            <div class="cart-count">{{ $cartItemCount ?? 0 }}</div>
        </a>
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
                <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="main-image">
            </div>

            <div class="product-info">
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-category">{{ $product->gender_category }} > {{ $product->top_bottom_category }} >
                    {{ str_replace('_', ' ', $product->clothes_category) }}
                </div>
                <div class="product-price">RM{{ number_format($product->price, 2) }}</div>

                <div class="product-description">
                    @if(! empty($product->description))
                        {{ $product->description }}
                    @else
                        This stylish {{ strtolower(str_replace('_', ' ', $product->clothes_category)) }} is perfect for any
                        occasion. Made with high-quality materials, it offers both comfort and durability. The
                        {{ strtolower($product->gender_category) }}'s design features a modern fit that complements your
                        wardrobe perfectly.
                    @endif
                </div>

                <div class="product-meta">
                    <div class="product-meta-item">
                        <div class="meta-label">SKU:</div>
                        <div class="meta-value">
                            {{ strtoupper(substr($product->clothes_category, 0, 3)) }}{{ $product->id }}
                        </div>
                    </div>
                    <div class="product-meta-item">
                        <div class="meta-label">Category:</div>
                        <div class="meta-value">{{ $product->gender_category }}, {{ $product->top_bottom_category }},
                            {{ str_replace('_', ' ', $product->clothes_category) }}
                        </div>
                    </div>
                    <div class="product-meta-item">
                        <div class="meta-label">Tags:</div>
                        <div class="meta-value">{{ strtolower($product->gender_category) }}, fashion,
                            {{ strtolower(str_replace('_', ' ', $product->clothes_category)) }}
                        </div>
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="product-options">
                        <div class="option-label">Size:</div>
                        <div class="size-options">
                            <div class="size-option" data-size="XS" onclick="selectSize(this, 'XS')">XS</div>
                            <div class="size-option" data-size="S" onclick="selectSize(this, 'S')">S</div>
                            <div class="size-option active" data-size="M" onclick="selectSize(this, 'M')">M</div>
                            <div class="size-option" data-size="L" onclick="selectSize(this, 'L')">L</div>
                            <div class="size-option" data-size="XL" onclick="selectSize(this, 'XL')">XL</div>
                        </div>
                        <input type="hidden" name="size" id="selected-size" value="M">

                        <div class="option-label">Color:</div>
                        <div class="color-options">
                            <div class="color-option active" data-color="Black" style="background-color: #000;"
                                onclick="selectColor(this, 'black')"></div>
                            <div class="color-option" data-color="White"
                                style="background-color: #fff; border: 1px solid #ddd;"
                                onclick="selectColor(this, 'white')"></div>
                            <div class="color-option" data-color="Red" style="background-color: red;"
                                onclick="selectColor(this, 'red')"></div>
                            <div class="color-option" data-color="Green" style="background-color: green;"
                                onclick="selectColor(this, 'green')"></div>
                            <div class="color-option" data-color="Blue" style="background-color: blue;"
                                onclick="selectColor(this, 'blue')"></div>
                        </div>
                        <input type="hidden" name="color" id="selected-color" value="Black">
                    </div>

                    <div class="quantity-control">
                        <div class="quantity-btn minus" onclick="changeQuantity(-1)">-</div>
                        <input type="text" name="quantity" id="quantity" class="quantity-input" value="1" readonly>
                        <div class="quantity-btn plus" onclick="changeQuantity(1)">+</div>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Size selection
        function selectSize(element, size) {
            // Remove active class from all size options
            document.querySelectorAll('.size-option').forEach(option => {
                option.classList.remove('active');
            });

            // Add active class to selected option
            element.classList.add('active');

            // Update hidden input with selected size
            document.getElementById('selected-size').value = size;
        }

        // Color selection
        function selectColor(element, color) {
            // Remove active class from all color options
            document.querySelectorAll('.color-option').forEach(option => {
                option.classList.remove('active');
            });

            // Add active class to selected option
            element.classList.add('active');

            // Update hidden input with selected color
            document.getElementById('selected-color').value = color;
        }

        // Quantity controls
        function changeQuantity(change) {
            const quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value);

            quantity += change;

            // Ensure quantity is at least 1
            if (quantity < 1) {
                quantity = 1;
            }

            quantityInput.value = quantity;
        }
    </script>
</body>

</html>