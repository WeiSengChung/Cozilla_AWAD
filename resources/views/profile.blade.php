<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <script src="{{ asset('js/navigation.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>User Dashboard</title>

</head>

<body>

    <div class="container">
        @include('partials.navigation')
        <h2>Welcome <strong>{{ $userProfile['first_name'] }}</strong> <i class="far fa-smile"></i></h2>

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
                            <p><strong>Postcode:</strong> {{ $address['postcode'] }}</p>
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
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <div>Cart</div>
                </div>
                <div class="icon">
                    <a href="{{ route('history') }}" class="icon-button">
                        <i class="fas fa-history"></i>
                    </a>
                    <div>History</div>
                </div>
            </div>
        </div>

        <div class="contact-box">
            <h2>Contact Us</h2>
            <p><strong>Address:</strong> {{ $companyInfo->company_address }}</p>
            <p><strong>Email:</strong>{{ $companyInfo->email}}</p>
            <p><strong>Company Phone:</strong> {{ $companyInfo->contact_number }}</p>
        </div>
    </div>

</body>

</html>