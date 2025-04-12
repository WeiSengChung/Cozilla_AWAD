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

    <form action="{{ route('admin.storeproduct') }}" method="POST" enctype="multipart/form-data">
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

        <div class="mb-3">
            <label for="gender_category" class="form-label">Gender Category</label>
            <select name="gender_category" id="gender_category" class="form-select" required>
                <option value="">-- Select Gender --</option>
                <option value="men" {{ old('gender_category') == 'men' ? 'selected' : '' }}>men</option>
                <option value="women" {{ old('gender_category') == 'women' ? 'selected' : '' }}>women</option>
                <option value="kids" {{ old('gender_category') == 'kids' ? 'selected' : '' }}>kids</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="top_bottom_category" class="form-label">Top or Bottom</label>
            <select name="top_bottom_category" id="top_bottom_category" class="form-select" required>
                <option value="">-- Select Option --</option>
                <option value="top" {{ old('top_bottom_category') == 'top' ? 'selected' : '' }}>Top</option>
                <option value="bottom" {{ old('top_bottom_category') == 'bottom' ? 'selected' : '' }}>Bottom</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="clothes_category" class="form-label">Clothes Category</label>
            <select name="clothes_category" id="clothes_category" class="form-select" required>
                <option value="">-- Select Category --</option>
                <option value="tshirt" {{ old('clothes_category') == 'tshirt' ? 'selected' : '' }}>T-shirt</option>
                <option value="pants" {{ old('clothes_category') == 'pants' ? 'selected' : '' }}>Pants</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" name="image" class="form-control" id="image" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
        <a href="{{ route('admin.manageproducts') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>