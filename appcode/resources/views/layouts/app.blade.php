<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('/assets/images/favicon.png') }}" sizes="16x16 32x32" type="image/png">

    <!-- Scripts -->
    <script src="{{ asset('/assets/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand navbar-brand-color" href="{{ url('/') }}">
                    <i class="fa fa-futbol-o" aria-hidden="true"></i> {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if(Route::current()->getName() == 'home')
                                <li class="nav-item">
                                    <a class="nav-link nav-link-color" href="{{ route('login') }}"><i class="fa fa-sign-in fa-fw fa-1x"></i> {{ __('Login') }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link nav-link-color" href="{{ route('home') }}"><i class="fa fa-home fa-fw fa-1x"></i> {{ __('Home') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link nav-link-color" href="#">Hey! {{ Auth::user()->name }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-color" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }} <i class="fa fa-sign-out fa-fw"></i></a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @if(Route::current()->getName() == 'home')
            <div class="container">
                <img src="{{ asset(Config::get('constants.SITE_LOGO')) }}"/>
            </div>
        @endif
        
        @auth
            @if((Route::current()->getName() != 'home') and (Route::current()->getName() != 'detail'))
            <div class="container-fluid rowMenu">
                <ul class="ulMenu">
                    <li class="liMenu"><a class="{{ Route::current()->getName() ==  'dashboard' ? 'active' : ''  }}" href="/dashboard">Dashboard</a></li>
                    <li class="liMenu"><a class="{{ Route::current()->getName() ==  'team' ? 'active' : ''  }}" href="/team">Team</a></li>
                    <li class="liMenu"><a class="{{ Route::current()->getName() ==  'player' ? 'active' : ''  }}" href="/player">Player</a></li>
                </ul>
            </div>
            @endif
        @endauth

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
