<div class="container mt-5">
    <h1 class="mb-4">Manage Products</h1>

    <a style="font-size:25px;font-family:Arial;" href="{{ route('admin.createproduct') }}"
        class="btn btn-success mt-3">Add New
        Product</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($products->isEmpty())
        <p>No products found.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price (RM)</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->description }}</td>
                        <td>
                            <a href="{{ route('admin.editproduct', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.deleteproduct', $product->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>