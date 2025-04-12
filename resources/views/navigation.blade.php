<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <!-- log out icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <button onclick="toggleSideMenu()" class="toggle-button">☰</button>
    </nav>

    <div id="overlay" class="overlay" onclick="toggleSideMenu()"></div>

    <div id="sideMenu" class="side-menu">
        <div class="menuArea">
                <a href = "{{url('/')}}">
                <img src="{{ asset('images/Cozilla.jpg') }}" alt="Cozilla Logo" class="CozillaLogo"></a>
            <ul>
                <li><a href="{{ route('category', ['gender_category' => 'women']) }}">Women</a></li>
                <li><a href="{{ route('category', ['gender_category' => 'men']) }}">Men</a></li>
                <li><a href="{{ route('category', ['gender_category' => 'kids']) }}">Kids</a></li>
            </ul>
        </div>

        <div class="myAccountArea">
            <form id="myAccount" action="{{route('profile')}}" method="GET" style="display:inline;">
                @csrf
                <button type="submit" class="profile-button">
                    <i class="fas fa-user"></i> My Account
                </button>
            </form>
        

        <div class="logoutArea">
            <form id="logout-form" action="{{route('logout')}}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/navigation.js') }}"></script>
</body>
</html>
