@include('partials.navigation')
<link rel="stylesheet" href="{{ asset('css/status.css') }}">
@section('content')
<div class="container">
    <h2 class="order-title">Your Order Status</h2>
    
    @forelse($orders as $order)
        <div class="order-item">
            <div class="order-content">
                <div class="order-row">
                    <div class="order-label">Order ID:</div>
                    <div class="order-value">{{ $order->id }}</div>
                </div>
                <div class="order-row">
                    <div class="order-label">Date:</div>
                    <div class="order-value">{{ Carbon\Carbon::parse($order->order_date)->timezone('GMT+8')->format('F j, Y \a\t g:i A') }}</div>
                </div>
                <div class="order-row">
                    <div class="order-label">Total:</div>
                    <div class="order-value">RM {{ number_format($order->total_amount, 2) }}</div>
                </div>
                <div class="order-row">
                    <div class="order-label">Status:</div>
                    <div class="order-value status-badge status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</div>
                </div>
            </div>
        </div>
    @empty
        <div class="no-orders">
            <p>No orders found.</p>
        </div>
    @endforelse
    
    <div class="action-area">
        <a href="{{ route('profile') }}" class="btn-cancel">Back to Profile</a>
    </div>
</div>

