<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Georgia, serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2,
        h3 {
            color: #333;
        }

        .info,
        .orders,
        .contact-box {
            margin-bottom: 30px;
            text-align: left;
        }

        .info p,
        .contact-box p {
            margin: 8px 0;
            color: #444;
        }

        .address-box {
            border: 1px solid #ccc;
            padding: 12px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 12px;
        }

        .address-actions {
            margin-top: 10px;
        }

        .address-actions a {
            color: #007BFF;
            text-decoration: none;
        }

        .address-actions a:hover {
            text-decoration: underline;
        }

        .icon-row {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .icon {
            text-align: center;
            margin: 10px;
        }

        .icon-button {
            background: none;
            border: none;
            cursor: pointer;
        }

        .icon-button img {
            width: 50px;
            height: 50px;
        }

        .contact-box {
            border: 1px solid #000;
            padding: 20px;
            border-radius: 10px;
            background-color: #fafafa;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Welcome <strong>{{ $userProfile['first_name'] }}</strong>,</h2>

        <div class="info">
            <p><strong>Name:</strong> {{ $userProfile['first_name'] }} {{ $userProfile['last_name'] }}</p>
            <p><strong>Email:</strong> {{ $user['email'] }}</p>
            <div>
                <p><strong>Addresses:</strong></p>
                @if($userAddresses->isNotEmpty())
                    @foreach($userAddresses as $address)
                        <div class="address-box">
                            <p><strong>Street:</strong> {{ $address['street'] }}</p>
                            <p><strong>City:</strong> {{ $address['city'] }}</p>
                            <p><strong>State:</strong> {{ $address['state'] }}</p>
                            <p><strong>Postcode:</strong> {{ $address['zip_code'] }}</p>
                        </div>
                    @endforeach
                    <div class="address-actions">
                        <a href="{{ route('address.form') }}">Add new address</a>
                    </div>
                @else
                    <p>No addresses found.</p>
                    <div class="address-actions">
                        <a href="{{ route('address.form') }}">Add new address</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="orders">
            <h3>My Orders</h3>
            <div class="icon-row">
                <div class="icon">
                    <a href="{{ route('cart') }}" class="icon-button">
                        <img src="{{ asset('icons/cart.png') }}" alt="Cart">
                    </a>
                    <div>Cart</div>
                </div>
                <div class="icon">
                    <a href="{{ route('status') }}" class="icon-button">
                        <img src="{{ asset('icons/status.png') }}" alt="Status">
                    </a>
                    <div>Status</div>
                </div>
                <div class="icon">
                    <a href="{{ route('history') }}" class="icon-button">
                        <img src="{{ asset('icons/history.png') }}" alt="History">
                    </a>
                    <div>History</div>
                </div>
                <div class="icon">
                    <a href="{{ route('contact') }}" class="icon-button">
                        <img src="{{ asset('icons/contact.png') }}" alt="Contact Us">
                    </a>
                    <div>Contact Us</div>
                </div>
            </div>
        </div>

        <div class="contact-box">
            <h2>Contact Us</h2>
            <p><strong>Address:</strong> XXXXX</p>
            <p><strong>Email:</strong> XXXXX</p>
            <p><strong>Company Phone:</strong> XXXX</p>
        </div>
    </div>

</body>

</html>