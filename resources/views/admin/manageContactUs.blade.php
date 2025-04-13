@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/contactUs.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navigationAdmin.css') }}">
    <script src="{{ asset('js/navigation.js') }}"></script>
    @include('partials.navigationAdmin')

    <div class="contactUs-container">
        <div class="contactUs-content">
            <h2 class = 'contactUsTitle'>Edit Contact Us Information</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="contactus" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="company_address">Company Address</label>
                    <input type="text" name="company_address" class="form-control" value="{{ old('company_address', $contact->company_address ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $contact->email ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $contact->contact_number ?? '') }}" required>
                </div>

                <button type="submit" class="submit-button">Update</button>
            </form>
        </div>
    </div>
@endsection
