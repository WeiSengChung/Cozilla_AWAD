<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body { font-family: Georgia, serif; text-align: center; }
        .info, .orders, .contact-box { margin: 20px auto; max-width: 600px; }
        .icon-row { display: flex; justify-content: space-around; margin-top: 20px; }
        .icon { text-align: center; }
        .icon-button {
            background: none;
            border: none;
            cursor: pointer;
        }
        .icon-button img {
            width: 40px;
        }
        .contact-box { border: 1px solid #000; padding: 20px; border-radius: 10px; }
    </style>
</head>
<body>

    <h2>Welcome , <strong>{{ $user['username'] }}</strong></h2>
    <div class="info">
        <p>Name: {{ $userProfile['first_name'] . $userProfile['last_name']}}</p>
        <p>Email: {{ $user['email'] }}</p>
        <p>
    Address: 
    @if($userAddresses)
        @foreach($userAddresses as $address)
            <div class="address-box">
                <p><strong>Street:</strong> {{ $address['street'] }}</p>
                <p><strong>City:</strong> {{ $address['city'] }}</p>
                <p><strong>State:</strong> {{ $address['state'] }}</p>
                <p><strong>Postcode:</strong> {{ $address['zip_code'] }}</p>
            </div>
        @endforeach
        <a href="{{ route('address.form') }}">Add new address</a>
    @else
        No addresses found <a href="{{route('address.form')}}">Add new address</a>
    @endif
</p>
    </div>

    <h3>My Orders</h3>
    <div class="icon-row">
        <div class="icon">
            <a href="{{ route('cart') }}" class="icon-button">
                <img src="{{ asset('icons/cart.png') }}" alt="Cart">
            </a>
            <br>Cart
        </div>
        <div class="icon">
            <a href="{{ route('status') }}" class="icon-button">
                <img src="{{ asset('icons/status.png') }}" alt="Status">
            </a>
            <br>Status
        </div>
        <div class="icon">
            <a href="{{ route('history') }}" class="icon-button">
                <img src="{{ asset('icons/history.png') }}" alt="History">
            </a>
            <br>History
        </div>
        <div class="icon">
            <a href="{{ route('contact') }}" class="icon-button">
                <img src="{{ asset('icons/contact.png') }}" alt="Contact Us">
            </a>
            <br>Contact Us
        </div>
    </div>

    <h2>Contact Us</h2>
    <div class="contact-box">
        <p><strong>Address:</strong> XXXXX</p>
        <p><strong>Email:</strong> XXXXX</p>
        <p><strong>Company Phone:</strong> XXXX</p>
    </div>

</body>
</html>
