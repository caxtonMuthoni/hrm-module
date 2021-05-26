<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="/imgs/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/imgs/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/imgs/favicons/favicon-16x16.png">
    <link rel="manifest" href="/imgs/favicons/site.webmanifest">
    <link rel="mask-icon" href="/imgs/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/imgs/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/imgs/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <title>HRM | Human resource management</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet"> -->

</head>

<body>
    <div class="welcome" id="app">

        <nav class="nav">
            <div class="nav-bar__logo nav__logo-1 js--logo-1">
                <img src="{{asset('/imgs/svgs/HRM.svg')}}" alt="logo" class="nav-bar__logo-image">
            </div>

            <div class="nav-bar__logo nav__logo-2 js--logo-2">
                <img src="{{asset('/imgs/svgs/HRM.svg')}}" alt="logo" class="nav__logo-2-image">
            </div>

            <ul class="nav-items" id="menucontainer">
                @if (Route::has('login'))
                @auth
                <li class="nav-item"><a href="/home" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="nav-link">Logout</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                @else
                <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
                @if (Route::has('register'))
                <li class="nav-item"><a href="/register" class="nav-link">Register</a></li>
                @endif
                @endauth
                @endif
            </ul>
             <i class="fas fa-bars  nav-icon  js--open-menu"></i>
             <i class="fas fa-window-close nav-small-icon  js--close-menu "></i>
        </nav>

        <header class="header" id="home">
            <div class="header__content">
                <h1 class="heading-1">Human resource management automation</h1>
                <h4 class="heading-4 heading-4--light">Ensuring best work practices are in place at all times made easier with Human resource management System</h4>
                <a href="/login" class="btn__home">Get Started Now</a>
            </div>
            <div class="header__ilust">
                <img src="{{asset('imgs/svgs/home.svg')}}" alt="home">
            </div>
        </header>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/home.js') }}" defer></script>
   
</body>

</html>