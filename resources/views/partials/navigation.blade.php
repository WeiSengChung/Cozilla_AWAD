<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <script src="{{ asset('js/navigation.js') }}"></script>

<nav class="navbar">
    <button onclick="toggleSideMenu()" class="toggle-button">☰</button>
</nav>

<div id="overlay" class="overlay" onclick="toggleSideMenu()"></div>

<div id="sideMenu" class="side-menu">
    <div class="menuArea">
        <a href="{{ url('/homepage') }}">
            <img src="{{ asset('images/Cozilla.jpg') }}" alt="Cozilla Logo" class="CozillaLogo">
        </a>
        <ul>
            <li><a href="{{ route('category', ['gender_category' => 'women']) }}">Women</a></li>
            <li><a href="{{ route('category', ['gender_category' => 'men']) }}">Men</a></li>
            <li><a href="{{ route('category', ['gender_category' => 'kids']) }}">Kids</a></li>
        </ul>
    </div>

    <div class="myAccountArea">
        <form action="{{ route('profile') }}" method="GET">
            @csrf
            <button type="submit" class="profile-button">
                <i class="fas fa-user"></i> My Account
            </button>
        </form>
    </div>

    @auth
        <div class="logoutArea">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </button>
            </form>
        </div>
    @else
        <div class="logoutArea">
            <form action="{{ route('login') }}" method="GET">
                @csrf
                <button type="submit" class="logout-button">
                    <i class="fas fa-sign-in-alt"></i> Log In
                </button>
            </form>
        </div>
    @endauth
</div>