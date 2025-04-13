<div class="contact-form-container">
    <h1 class="form-title">Edit Contact Us</h1>

    @if ($error->any())
        <div class="alert error-alert">
            <i class="fas fa-exclamation-circle alert-icon"></i>
            <div class="alert-content">
                <strong>Whoops!</strong> Please fix the following errors:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.updatecontactus', $product->id)}}" method="POST" class="contact-form">
        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{ old('id', $contactus->id)? old('id', $contactus->id) : $contactus['id'] }}">

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $contactus->address) }}" placeholder="Enter address">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $contactus->email) }}" placeholder="Enter email">
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $contactus->phone) }}" placeholder="Enter phone number">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.contactus') }}" class="btn btn-secondary">Cancel</a>
        </div>