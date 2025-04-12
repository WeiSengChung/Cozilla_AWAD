<div class="container mt-5">
    <h1 class="mb-4">Add New Product</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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

    <form action="{{ route('admin.storeproduct') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" id="name" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (RM)</label>
            <input type="number" name="price" class="form-control" id="price" step="0.01" min="0" required
                value="{{ old('price') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="4"
                required>{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
        <a href="{{ route('admin.manageproducts') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>