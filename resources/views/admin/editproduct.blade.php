<div class="container mt-5">
    <h1 class="mb-4">Edit Product</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following errors:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.updateproduct', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{ old('id', $product->id)? old('id', $product->id) : $product['id'] }}"><br> <br>
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" value="{{ old('name', $product->name) }}" name="name" class="form-control" id="name"
                required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (RM)</label>
            <input type="number" step="0.01" value="{{ old('price', $product->price) }}" name="price"
                class="form-control" id="price" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="4"
                required>{{ old('description', $product->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('admin.manageproducts') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>