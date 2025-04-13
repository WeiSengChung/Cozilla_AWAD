<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <script src="{{ asset('js/navigation.js') }}"></script>

<nav class="navbar">
    <button onclick="toggleSideMenu()" class="toggle-button">☰</button>
</nav>

<div id="overlay" class="overlay" onclick="toggleSideMenu()"></div>

<div id="sideMenu" class="side-menu">
    <div class="menuArea">
        <a href="{{ url('/home') }}">
            <img src="{{ asset('images/Cozilla.jpg') }}" alt="Cozilla Logo" class="CozillaLogo">
        </a>
        <ul>
        <li><a href="{{ url('/admin/products/create')}}">Add New Product</a></li>
            <li><a href="{{ url('/admin/manageproducts')}}">Manage Product</a></li>
            <li><a href="{{ url('contactus') }}">Edit Contact Us</a></li>
            <li><a href="{{ url('history') }}">Manage Order</a></li>
        </ul>
    </div>

    

    <div class="logoutArea">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </button>
        </form>
    </div>
</div>
