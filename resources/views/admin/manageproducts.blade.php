<div class="container mt-5" style="font-family: 'Times New Roman', Times, serif;">
    <h1 class="mb-4">Manage Products</h1>

    <a style="font-size:25px; font-family: 'Times New Roman', Times, serif; background-color: #4a5643; color: white; padding: 10px 20px; border-radius: 15px; text-decoration: none;" href="{{ route('admin.createproduct') }}">
        Add New Product
    </a>

    @if (session('success'))
        <div style="margin-top: 10px; font-size: 25px; font-family: 'Times New Roman', Times, serif; color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if ($products->isEmpty())
        <p style="font-family: 'Times New Roman', Times, serif;">No products found.</p>
    @else
        <style>
            .custom-bordered-table {
                border-collapse: collapse;
                width: 100%;
                text-align: left;
                margin-top: 20px;
                font-family: 'Times New Roman', Times, serif;
            }

            .custom-bordered-table th,
            .custom-bordered-table td {
                border: 2px solid black;
                padding: 12px;
                vertical-align: middle;
            }

            .custom-bordered-table th {
                background-color: #f2f2f2;
            }

            .custom-button {
                background-color: #4a5643;
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 25px;
                font-weight: bold;
                text-decoration: none;
                display: inline-block;
                font-family: 'Times New Roman', Times, serif;
            }

            .custom-button:hover {
                background-color: #3b4437;
            }

            .action-buttons {
                display: flex;
                gap: 10px;
                align-items: center;
                font-family: 'Times New Roman', Times, serif;
            }

            .action-buttons form {
                margin: 0;
            }

            .delete-button {
                background-color: #c0392b; /* red */
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 25px;
                font-weight: bold;
                text-decoration: none;
                font-family: 'Times New Roman', Times, serif;
            }

            .delete-button:hover {
                background-color: #a93226; /* darker red on hover */
            }

        </style>

        <h3 class="mt-5" style="font-family: 'Times New Roman', Times, serif;"><strong>Product Overview</strong></h3>

        <table class="custom-bordered-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Price (RM)</th>
                    <th>Description</th>
                    <th>Action</th>
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
                            <div class="action-buttons">
                                <a href="{{ route('admin.editproduct', $product->id) }}" class="custom-button">Edit</a>
                                <form action="{{ route('admin.deleteproduct', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
