<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <script src="{{ asset('js/navigation.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .info {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .edit-section {
            margin-top: 15px;
        }

        .edit-btn,
        .save-btn,
        .cancel-btn,
        .delete-btn {
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            font-size: 14px;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .save-btn {
            background-color: #2196F3;
            color: white;
            border: none;
        }

        .cancel-btn {
            background-color: #f44336;
            color: white;
            border: none;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
        }

        .address-box {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            position: relative;
        }

        .address-actions {
            margin-top: 10px;
        }

        .form-field {
            margin-bottom: 10px;
        }

        .form-field input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .hidden {
            display: none;
        }

        .orders {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .icon-row {
            display: flex;
            justify-content: space-around;
            margin-top: 15px;
        }

        .icon {
            text-align: center;
        }

        .icon-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            margin: 0 auto;
        }

        .contact-box {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        @include('partials.navigation')
        <h2>Welcome <strong>{{ $userProfile['first_name'] }}</strong> <i class="far fa-smile"></i></h2>

        <!-- Personal Information Section -->
        <div class="info">
            <div id="personal-info-display">
                <p><strong>Name:</strong> {{ $userProfile['first_name'] }} {{ $userProfile['last_name'] }}</p>
                <p><strong>Email:</strong> {{ $user['email'] }}</p>
                <button class="edit-btn" onclick="togglePersonalInfoEdit()"><i class="fas fa-edit"></i> Edit</button>
            </div>

            <div id="personal-info-edit" class="hidden">
                <form action="{{ route('updateProfile', $userProfile->id) }}" method="POST" id="update-profile-form">
                    @csrf
                    @method('PUT')
                    <div class="form-field">
                        <label for="first_name"><strong>First Name:</strong></label>
                        <input type="text" id="first_name" name="first_name" value="{{ $userProfile['first_name'] }}">
                    </div>
                    <div class="form-field">
                        <label for="last_name"><strong>Last Name:</strong></label>
                        <input type="text" id="last_name" name="last_name" value="{{ $userProfile['last_name'] }}">
                    </div>
                    <div class="form-field">
                        <label for="email"><strong>Email:</strong></label>
                        <input type="email" id="email" name="email" value="{{ $user['email'] }}">
                    </div>
                    <button type="submit" class="save-btn" onclick="savePersonalInfo()">Save</button>
                    <button type="button" class="cancel-btn" onclick="togglePersonalInfoEdit()">Cancel</button>
                </form>
            </div>

            <!-- Addresses Section -->
            <div>
                <p><strong>Addresses:</strong></p>
                @if($userAddresses->isNotEmpty())
                    @foreach($userAddresses as $index => $address)
                        <div class="address-box" id="address-display-{{ $index }}">
                            <p><strong>Street:</strong> {{ $address['street'] }}</p>
                            <p><strong>City:</strong> {{ $address['city'] }}</p>
                            <p><strong>State:</strong> {{ $address['state'] }}</p>
                            <p><strong>Postcode:</strong> {{ $address['postcode'] }}</p>
                            <div class="edit-section">
                                <button class="edit-btn" onclick="toggleAddressEdit({{ $index }})"><i class="fas fa-edit"></i>
                                    Edit</button>
                                <button class="delete-btn" onclick="confirmDeleteAddress({{ $index }})"><i
                                        class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>

                        <div class="address-box hidden" id="address-edit-{{ $index }}">
                            <form action="{{ route('updateAddress', $address->id) }}" method="POST"
                                id="update-address-form-{{ $index }}">
                                @csrf
                                @method('PUT')
                                <div class="form-field">
                                    <label for="street-{{ $index }}"><strong>Street:</strong></label>
                                    <input type="text" id="street-{{ $index }}" name="street" value="{{ $address['street'] }}">
                                </div>
                                <div class="form-field">
                                    <label for="city-{{ $index }}"><strong>City:</strong></label>
                                    <input type="text" id="city-{{ $index }}" name="city" value="{{ $address['city'] }}">
                                </div>
                                <div class="form-field">
                                    <label for="state-{{ $index }}"><strong>State:</strong></label>
                                    <input type="text" id="state-{{ $index }}" name="state" value="{{ $address['state'] }}">
                                </div>
                                <div class="form-field">
                                    <label for="postcode-{{ $index }}"><strong>Postcode:</strong></label>
                                    <input type="text" id="postcode-{{ $index }}" name="postcode"
                                        value="{{ $address['postcode'] }}">
                                </div>
                                <button type="submit" class="save-btn" onclick="saveAddress({{ $index }})">Save</button>
                                <button type="button" class="cancel-btn"
                                    onclick="toggleAddressEdit({{ $index }})">Cancel</button>
                            </form>
                        </div>
                    @endforeach
                @else
                    <p>No addresses found.</p>
                @endif

                <div class="address-actions">
                    <a href="{{ route('address.form') }}" class="edit-btn">Add new address</a>
                </div>
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
                    <a href="{{ route('status') }}" class="icon-button">
                        <i class="fas fa-truck"></i>
                    </a>
                    <div>Status</div>
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
            <p><strong>Email:</strong> {{ $companyInfo->email }}</p>
            <p><strong>Company Phone:</strong> {{ $companyInfo->contact_number }}</p>
        </div>
    </div>

    <script>
        // Toggle personal information edit form
        function togglePersonalInfoEdit() {
            const displaySection = document.getElementById('personal-info-display');
            const editSection = document.getElementById('personal-info-edit');

            displaySection.classList.toggle('hidden');
            editSection.classList.toggle('hidden');
        }

        // Save personal information (UI only)
        function savePersonalInfo() {
            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            const email = document.getElementById('email').value;

            // In a real app, you would send this data to the server
            // For now, just update the display
            const displaySection = document.getElementById('personal-info-display');
            displaySection.innerHTML = `
                <p><strong>Name:</strong> ${firstName} ${lastName}</p>
                <p><strong>Email:</strong> ${email}</p>
                <button class="edit-btn" onclick="togglePersonalInfoEdit()"><i class="fas fa-edit"></i> Edit</button>
            `;

            togglePersonalInfoEdit();
            alert('Personal information updated successfully!');
        }

        // Toggle address edit form
        function toggleAddressEdit(index) {
            const displaySection = document.getElementById(`address-display-${index}`);
            const editSection = document.getElementById(`address-edit-${index}`);

            displaySection.classList.toggle('hidden');
            editSection.classList.toggle('hidden');
        }

        // Save address (UI only)
        function saveAddress(index) {
            const street = document.getElementById(`street-${index}`).value;
            const city = document.getElementById(`city-${index}`).value;
            const state = document.getElementById(`state-${index}`).value;
            const postcode = document.getElementById(`postcode-${index}`).value;

            // In a real app, you would send this data to the server
            // For now, just update the display
            const displaySection = document.getElementById(`address-display-${index}`);
            displaySection.innerHTML = `
                <p><strong>Street:</strong> ${street}</p>
                <p><strong>City:</strong> ${city}</p>
                <p><strong>State:</strong> ${state}</p>
                <p><strong>Postcode:</strong> ${postcode}</p>
                <div class="edit-section">
                    <button class="edit-btn" onclick="toggleAddressEdit(${index})"><i class="fas fa-edit"></i> Edit</button>
                    <button class="delete-btn" onclick="confirmDeleteAddress(${index})"><i class="fas fa-trash"></i> Delete</button>
                </div>
            `;

            toggleAddressEdit(index);
            alert('Address updated successfully!');
        }

        // Confirm delete address
        function confirmDeleteAddress(index) {
            if (confirm('Are you sure you want to delete this address?')) {
                // In a real app, you would send a delete request to the server
                // For now, just hide the address
                const displaySection = document.getElementById(`address-display-${index}`);
                const editSection = document.getElementById(`address-edit-${index}`);

                displaySection.style.display = 'none';
                editSection.style.display = 'none';

                alert('Address deleted successfully!');
            }
        }
    </script>
</body>

</html>