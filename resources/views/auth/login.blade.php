<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozilla Log In</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

@extends('layouts.app')

@section('content')
    @if (session("message"))
        <div id="slide-alert" class="slide-alert">
            {{session("message")}}
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alertBox = document.getElementById('slide-alert');
            if (alertBox) {
                alertBox.classList.add('show');
                setTimeout(() => {
                    alertBox.classList.remove('show');
                }, 4000);
            }
        });
    </script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class='loginTitle'>
                        <div class="card-header">{{ __('Login') }}</div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group text-center">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-start">{{ __('Email Address') }}</label>

                                <div class="col-md-6 mx-auto">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-start">{{ __('Password') }}</label>

                                <div class="col-md-6 mx-auto">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    <br>
                                </div>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="loginButtonContainer">
                                    <div class="loginButton">
                                        <button type="submit" class="login-Button">
                                            {{ __('Login') }}
                                        </button>
                                    </div>

                                    <div class="forgetPassword-Container">
                                        <div class="auth-links">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('register') }}" class="btn-btn-link">Register</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection