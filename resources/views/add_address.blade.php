<h2>Add New Address</h2>

<form method="POST" action="{{ route('address.store') }}">
        @csrf
        <div>
        <label for="street">Street</label><br>
        <input type="text" name="street" id="street" value="{{ old('street') }}" required>
    </div><br>

    <div>
        <label for="city">City:</label><br>
        <input type="text" name="city" id="city" value="{{ old('city') }}" required>
    </div><br>

    <div>
        <label for="state">State:</label><br>
        <input type="text" name="state" id="state" value="{{ old('state') }}" required>
    </div><br>

    <div>
        <label for="zip_code">Postcode:</label><br>
        <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') }}" required>
    </div><br>
    <button type="submit">Save Address</button>
</form>
