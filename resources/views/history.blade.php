@foreach ($orders as $order)
    <div style="border: 2px solid #333; border-radius: 15px; padding: 20px; margin: 20px 0; font-family: 'Times New Roman', Times, serif;">
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Product Name:</strong> {{ $order->product_name }}</p>
        <p><strong>Product Quantity:</strong> {{ $order->quantity }}</p>
        <p><strong>Total Price:</strong> RM {{ number_format($order->total_price, 2) }}</p>

        <form action="{{ route('user.order.received', $order->id) }}" method="POST" style="text-align: right;" onsubmit="handleReceived(event, this)">
            @csrf
            <button type="submit"
                style="background-color: #4a5643; color: white; padding: 8px 20px; font-size: 16px; border: none; border-radius: 2px;"
                class="received-btn">
                Order Received
            </button>
        </form>
    </div>
@endforeach

<script>
    function handleReceived(event, form) {
        event.preventDefault(); // prevent form from submitting normally

        const button = form.querySelector('.received-btn');
        button.innerText = 'Received ✅';
        button.style.backgroundColor = '#2f3a29'; // darker green
        button.disabled = true;

        // Optionally submit the form after changing button text
        // setTimeout(() => { form.submit(); }, 500);
    }
</script>
