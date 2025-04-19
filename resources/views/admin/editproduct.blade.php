<link rel="stylesheet" href="{{asset('css/addProduct.css')}}">
@include('partials.navigationAdmin')

<div class="product-form-container">
    <h1 class="form-title">Edit Product</h1>

    @if ($errors->any())
        <div class="alert error-alert">
            <i class="fas fa-exclamation-circle alert-icon"></i>
            <div class="alert-content">
                <strong>Whoops!</strong> Please fix the following errors:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.updateproduct', $product->id) }}" method="POST" class="product-form">
        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{ old('id', $product->id)? old('id', $product->id) : $product['id'] }}">
        
        <div class="form-group">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" value="{{ old('name', $product->name) }}" name="name" class="form-input" id="name"
                required>
        </div>

        <div class="form-group">
            <label for="price" class="form-label">Price (RM)</label>
            <input type="number" step="0.01" value="{{ old('price', $product->price) }}" name="price"
                class="form-input" id="price" required>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-textarea" id="description" rows="4"
                required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn submit-btn">Update Product</button>
            <a href="{{ route('admin.manageproducts') }}" class="btn cancel-btn">Cancel</a>
        </div>
    </form>
</div>

<style>
    /* Modern Form Styling */
    .product-form-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 35px;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
    }

    .form-title {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .alert {
        padding: 18px;
        margin-bottom: 25px;
        border-radius: 8px;
        display: flex;
        align-items: flex-start;
    }

    .alert-icon {
        margin-right: 12px;
        font-size: 20px;
        margin-top: 2px;
    }

    .alert-content {
        flex: 1;
    }

    .error-alert {
        background-color: #ffebee;
        color: #c62828;
        border-left: 4px solid #f44336;
    }

    .error-alert ul {
        margin-top: 10px;
        padding-left: 20px;
    }

    .error-alert li {
        margin-bottom: 5px;
    }

    .product-form {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .form-group {
        margin-bottom: 5px;
    }

    .form-label {
        display: block;
        margin-bottom: 10px;
        font-weight: 500;
        color: #444;
        font-size: 16px;
    }

    .form-input,
    .form-textarea {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s;
        background-color: #f9f9fb;
    }

    .form-input:focus,
    .form-textarea:focus {
        border-color: #4a574b;
        box-shadow: 0 0 0 3px rgba(74, 87, 75, 0.1);
        outline: none;
        background-color: #fff;
    }

    .form-textarea {
        min-height: 150px;
        resize: vertical;
        line-height: 1.5;
    }

    /* Button Styling */
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 10px;
    }

    .btn {
        padding: 12px 28px;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .submit-btn {
        background-color: #4a574b;
        color: white;
        box-shadow: 0 2px 8px rgba(74, 87, 75, 0.2);
    }

    .submit-btn:hover {
        background-color: #3d4a3e;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 87, 75, 0.3);
    }

    .cancel-btn {
        background-color: #f8f9fa;
        color: #495057;
        border: 1px solid #ddd;
    }

    .cancel-btn:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .product-form-container {
            padding: 25px;
            margin: 20px;
            border-radius: 8px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>