<link rel="stylesheet" href="{{ asset('css/navigationAdmin.css') }}">
<link rel="stylesheet" href="{{asset('css/manageProducts.css')}}">
<link rel="stylesheet" href="{{ asset('css/manageOrder.css') }}">
<script src="{{ asset('js/navigation.js') }}"></script>
@include('partials.navigationAdmin')
<div class="container mt-5" style="font-family: 'Times New Roman', Times, serif;">
    <h1 class="mb-4">Manage Orders</h1>

    @if (session('success'))
        <div
            style="margin-top: 10px; font-size: 20px; font-family: 'Times New Roman', Times, serif; color: green; padding: 10px; background-color: #f0fff0; border-radius: 5px; border: 1px solid #90ee90;">
            {{ session('success') }}
        </div>
    @endif

    <div class="filters mb-4">
        <h3 class="mb-3">Filter Orders</h3>
        <form action="{{ route('admin.manageorders') }}" method="GET" class="d-flex flex-wrap gap-3">
            <div style="margin-right: 15px;">
                <label for="status" style="display: block; margin-bottom: 5px; font-weight: bold;">Status:</label>
                <select name="status" id="status"
                    style="padding: 8px; border-radius: 5px; border: 1px solid #ccc; width: 150px;">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                    </option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div style="margin-right: 15px;">
                <label for="date_from" style="display: block; margin-bottom: 5px; font-weight: bold;">From Date:</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                    style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
            </div>

            <div style="margin-right: 15px;">
                <label for="date_to" style="display: block; margin-bottom: 5px; font-weight: bold;">To Date:</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                    style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
            </div>

            <div style="align-self: flex-end; margin-bottom: 1px;">
                <button type="submit"
                    style="background-color: #4a5643; color: white; border: none; padding: 10px 16px; border-radius: 25px; font-weight: bold; cursor: pointer;">
                    Apply Filters
                </button>
                <a href="{{ route('admin.manageorders') }}"
                    style="background-color: #6c757d; color: white; border: none; padding: 10px 16px; border-radius: 25px; font-weight: bold; text-decoration: none; margin-left: 10px;">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    @if ($orders->isEmpty())
        <div style="padding: 20px; background-color: #f8f9fa; border-radius: 5px; text-align: center; margin-top: 20px;">
            <p style="font-size: 18px; margin: 0;">No orders found with the selected filters.</p>
        </div>
    @else
        
        <h3 class="mt-5" style="font-family: 'Times New Roman', Times, serif;"><strong>Order List</strong></h3>

        <table class="custom-bordered-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->id }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>RM {{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="#" class="view-button" onclick="openOrderModal({{ $order->id }})">Manage</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination mt-4">
            {{ $orders->links() }}
        </div>
    @endif

    <!-- Order Management Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeOrderModal()">&times;</span>
            <h2>Order Details <span id="orderId"></span></h2>

            <div id="orderDetails">
                <div class="d-flex justify-content-between">
                    <div>
                        <p><strong>Customer:</strong> <span id="customerName"></span></p>
                        <p><strong>Email:</strong> <span id="customerEmail"></span></p>
                    </div>
                    <div>
                        <p><strong>Order Date:</strong> <span id="orderDate"></span></p>
                        <p><strong>Total:</strong> RM <span id="orderTotal"></span></p>
                    </div>
                </div>

                <h4 class="mt-4">Shipping Address</h4>
                <div id="shippingAddress" style="padding: 10px; background-color: #f8f9fa; border-radius: 5px;"></div>

                <h4 class="mt-4">Order Items</h4>
                <div id="orderItems" class="order-details-section"></div>

                <h4 class="mt-4">Update Order Status</h4>
                <form id="updateStatusForm" action="{{ route('admin.updateOrderStatus') }}" method="POST">
                    @csrf
                    <input type="hidden" id="modalOrderId" name="order_id">
                    <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-top: 10px;">
                        <button type="button" class="status-button btn-pending" data-status="pending"
                            onclick="selectStatus('pending')">Pending</button>
                        <button type="button" class="status-button btn-processing" data-status="processing"
                            onclick="selectStatus('processing')">Processing</button>
                        <button type="button" class="status-button btn-shipped" data-status="shipped"
                            onclick="selectStatus('shipped')">Shipped</button>
                        <button type="button" class="status-button btn-delivered" data-status="delivered"
                            onclick="selectStatus('delivered')">Delivered</button>
                        <button type="button" class="status-button btn-cancelled" data-status="cancelled"
                            onclick="selectStatus('cancelled')">Cancelled</button>
                    </div>
                    <input type="hidden" id="selectedStatus" name="status" value="">

                    <div style="text-align: center; margin-top: 20px;">
                        <button type="submit"
                            style="background-color: #28a745; color: white; border: none; padding: 10px 24px; border-radius: 25px; font-weight: bold; cursor: pointer; font-size: 16px;">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Get the modal
        const orderModal = document.getElementById("orderModal");

        // Function to open the modal and load order details
        function openOrderModal(orderId) {
            document.getElementById("orderId").textContent = '#' + orderId;
            document.getElementById("modalOrderId").value = orderId;
            orderModal.style.display = "block";

            // Fetch order details
            fetchOrderDetails(orderId);
        }

        // Function to close the modal
        function closeOrderModal() {
            orderModal.style.display = "none";
        }

        // Close the modal if clicked outside
        window.onclick = function (event) {
            if (event.target == orderModal) {
                closeOrderModal();
            }
        }

        // Function to fetch order details from server
        function fetchOrderDetails(orderId) {
            // AJAX request to get order details
            fetch(`{{ url('admin/order-details') }}/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    fetch(`{{ url('admin/address') }}/${data.address_id}`)
                        .then(response => response.json())
                        .then(addressData => {
                            document.getElementById("shippingAddress").textContent = addressData.street + ", " + addressData.city + ", " + addressData.postcode + ", " + addressData.state;
                        })
                    // Fill order details
                    document.getElementById("customerName").textContent = data.user.id;
                    document.getElementById("customerEmail").textContent = data.user.email;
                    document.getElementById("orderDate").textContent = new Date(data.created_at).toLocaleDateString();
                    document.getElementById("orderTotal").textContent = parseFloat(data.total_amount).toFixed(2);

                    // Fill shipping address

                    // Fill order items
                    const orderItemsContainer = document.getElementById("orderItems");
                    orderItemsContainer.innerHTML = '';

                    data.order_items.forEach(item => {
                        const itemElement = document.createElement('div');
                        itemElement.className = 'order-item';
                        itemElement.innerHTML = `
                            <div class="item-details">
                                <div><strong>${item.product.name}</strong></div>
                                <div>Size: ${item.size} | Color: ${item.color}</div>
                                <div>Quantity: ${item.quantity}</div>
                            </div>
                            <div class="item-price">RM ${parseFloat(item.price).toFixed(2)}</div>
                        `;
                        orderItemsContainer.appendChild(itemElement);
                    });

                    // Set active status button
                    selectStatus(data.status);
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                    alert('Could not fetch order details. Please try again.');
                });
        }

        // Function to select status
        function selectStatus(status) {
            // Remove active class from all buttons
            const statusButtons = document.querySelectorAll('.status-button');
            statusButtons.forEach(button => {
                button.classList.remove('active');
            });

            // Add active class to selected button
            const selectedButton = document.querySelector(`.status-button[data-status="${status}"]`);
            if (selectedButton) {
                selectedButton.classList.add('active');
            }

            // Set hidden input value
            document.getElementById('selectedStatus').value = status;
        }
    </script>
</div>