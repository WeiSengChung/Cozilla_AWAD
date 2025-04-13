@include('partials.navigation')
<link rel="stylesheet" href="{{ asset('css/addAddress.css') }}">

<h2 class="addressTitle">Add New Address</h2>

<form method="POST" action="{{ route('address.store') }}" class="addressForm">
    @csrf
    <div class="addressField">
        <p class="addressLabel">Street</p>
        <input type="text" name="street" id="street" class="addressInput" value="{{ old('street') }}" required>
    </div>

    <div class="addressField">
        <p class="addressLabel">City</p>
        <input type="text" name="city" id="city" class="addressInput" value="{{ old('city') }}" required>
    </div>

    <div class="addressField">
        <p class="addressLabel">State</p>
        <input type="text" name="state" id="state" class="addressInput" value="{{ old('state') }}" required>
    </div>

    <div class="addressField">
        <p class="addressLabel">Postcode</p>
        <input type="text" name="postcode" id="postcode" class="addressInput" value="{{ old('postcode') }}" required>
    </div>

    <button type="submit" class="saveButton">Save Address</button>
</form>
