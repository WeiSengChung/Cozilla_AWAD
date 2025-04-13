<div class="container mt-5" style="font-family: 'Times New Roman', Times, serif;">
    <h1 class="mb-4">Manage Products</h1>

    <a style="font-size:25px; font-family: 'Times New Roman', Times, serif; background-color: #4a5643; color: white; padding: 10px 20px; border-radius: 15px; text-decoration: none;"
        href="{{ route('admin.createproduct') }}">
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
                margin-right: 5px;
            }

            .custom-button:hover {
                background-color: #3b4437;
            }

            .inventory-button {
                background-color: #3498db;
                /* blue */
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 25px;
                font-weight: bold;
                text-decoration: none;
                display: inline-block;
                font-family: 'Times New Roman', Times, serif;
                margin-right: 5px;
            }

            .inventory-button:hover {
                background-color: #2980b9;
                /* darker blue on hover */
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
                background-color: #c0392b;
                /* red */
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 25px;
                font-weight: bold;
                text-decoration: none;
                font-family: 'Times New Roman', Times, serif;
            }

            .delete-button:hover {
                background-color: #a93226;
                /* darker red on hover */
            }

            /* Modal Styles */
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.4);
            }

            .modal-content {
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                max-width: 800px;
                border-radius: 10px;
                font-family: 'Times New Roman', Times, serif;
            }

            .close-button {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close-button:hover,
            .close-button:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }

            .variation-grid {
                display: grid;
                grid-template-columns: repeat(6, 1fr);
                gap: 10px;
                margin-top: 20px;
            }

            .variation-grid-header {
                font-weight: bold;
                background-color: #f2f2f2;
                padding: 8px;
                text-align: center;
                border: 1px solid #ddd;
            }

            .variation-cell {
                padding: 8px;
                text-align: center;
                border: 1px solid #ddd;
            }

            .stock-input {
                width: 60px;
                text-align: center;
                padding: 4px;
            }

            .variation-form {
                margin-top: 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            .save-inventory-button {
                background-color: #27ae60;
                /* green */
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 25px;
                font-weight: bold;
                margin-top: 15px;
                cursor: pointer;
                font-family: 'Times New Roman', Times, serif;
            }

            .save-inventory-button:hover {
                background-color: #219653;
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
                                <a href="#" class="inventory-button"
                                    onclick="openInventoryModal({{ $product->id }}, '{{ $product->name }}')">Manage Stock</a>
                                <form action="{{ route('admin.deleteproduct', $product->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
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

    <!-- Inventory Management Modal -->
    <div id="inventoryModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeInventoryModal()">&times;</span>
            <h2 id="modalProductName">Manage Stock for Product</h2>

            <form id="inventoryForm" action="{{ route('admin.updateinventory') }}" method="POST">
                @csrf
                <input type="hidden" id="productId" name="product_id">

                <div class="variation-grid">
                    <div class="variation-grid-header">Size/Color</div>
                    <div class="variation-grid-header">Black</div>
                    <div class="variation-grid-header">White</div>
                    <div class="variation-grid-header">Red</div>
                    <div class="variation-grid-header">Green</div>
                    <div class="variation-grid-header">Blue</div>

                    <div class="variation-grid-header">XS</div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[XS][black]" id="stock-XS-black">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[XS][white]" id="stock-XS-white">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[XS][red]" id="stock-XS-red">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[XS][green]" id="stock-XS-green">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[XS][blue]" id="stock-XS-blue">
                    </div>

                    <div class="variation-grid-header">S</div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[S][black]" id="stock-S-black">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[S][white]" id="stock-S-white">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[S][red]" id="stock-S-red">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[S][green]" id="stock-S-green">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[S][blue]" id="stock-S-blue">
                    </div>

                    <div class="variation-grid-header">M</div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[M][black]" id="stock-M-black">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[M][white]" id="stock-M-white">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[M][red]" id="stock-M-red">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[M][green]" id="stock-M-green">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[M][blue]" id="stock-M-blue">
                    </div>

                    <div class="variation-grid-header">L</div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[L][black]" id="stock-L-black">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[L][white]" id="stock-L-white">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[L][red]" id="stock-L-red">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[L][green]" id="stock-L-green">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[L][blue]" id="stock-L-blue">
                    </div>

                    <div class="variation-grid-header">XL</div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[XL][black]" id="stock-XL-black">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[XL][white]" id="stock-XL-white">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[XL][red]" id="stock-XL-red">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[XL][green]" id="stock-XL-green">
                    </div>
                    <div class="variation-cell">
                        <input type="number" min="0" class="stock-input" name="stock[XL][blue]" id="stock-XL-blue">
                    </div>
                </div>

                <button type="submit" class="save-inventory-button">Save Stock Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Get the modal
        const inventoryModal = document.getElementById("inventoryModal");

        // Function to open the modal
        function openInventoryModal(productId, productName) {
            console.log(productId);
            document.getElementById("modalProductName").textContent = `Manage Stock for ${productName}`;
            document.getElementById("productId").value = productId;
            inventoryModal.style.display = "block";

            // Fetch existing stock quantities
            fetchProductInventory(productId);
        }

        // Function to close the modal
        function closeInventoryModal() {
            inventoryModal.style.display = "none";
        }

        // Close the modal if clicked outside
        window.onclick = function (event) {
            if (event.target == inventoryModal) {
                closeInventoryModal();
            }
        }

        // Function to fetch product inventory from server
        function fetchProductInventory(productId) {
            // AJAX request to get current inventory
            fetch(`{{ url('admin/productinventory') }}/${productId}`)
                .then(response => response.json())
                .then(data => {
                    // Fill inputs with existing inventory data
                    const sizes = ['XS', 'S', 'M', 'L', 'XL'];
                    const colors = ['black', 'white', 'red', 'green', 'blue'];

                    sizes.forEach(size => {
                        colors.forEach(color => {
                            const inputId = `stock-${size}-${color}`;
                            // Find matching inventory item or default to 0
                            const inventoryItem = data.find(item =>
                                item.size === size && item.color === color
                            );

                            document.getElementById(inputId).value =
                                inventoryItem ? inventoryItem.stock_quantity : 0;
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching inventory:', error);
                    alert('Could not fetch inventory data. Please try again.');
                });
        }
    </script>
</div>