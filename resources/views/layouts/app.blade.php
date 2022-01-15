<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custoButton.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/select2.min.js') }}"></script>
</head>
<body>
    <div id="app">
        <a class="col-12 card disaicBrand" href = "http://www.disaic.cu">
        <img class="disaicLogo" src="{{ asset('logotipo disaic2.png') }}" alt="">
        </a>
        <nav class="navbar navbar-expand-md navbar-light bg-white main-nav shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Plantel Industrial
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item mx-1">
                                <a class="nav-link {{ (request()->is('saclap*')) ? 'active' : '' }}" href="{{url('saclap')}}">Dashboard</a>
                            </li>
                            <li class="nav-item dropdown mx-2">
                                <a class="nav-link dropdown-toggle
                                    {{ (request()->is('organismo*')) ||
                                        (request()->is('osde*')) ||
                                        (request()->is('entidad*')) ||
                                        (request()->is('user*'))
                                        ? 'active' : '' }}"
                                    id="navbarDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">Reportes</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item {{ (request()->is('organismo*')) ? 'active' : '' }}" href="{{url('organismo')}}">
                                            Organismos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ (request()->is('osde*')) ? 'active' : '' }}" href="{{url('osde')}}">
                                            Osdes
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ (request()->is('entidad*')) ? 'active' : '' }}" href="{{url('entidad')}}">
                                            Entidades
                                        </a>
                                    </li>
                                    @if (Auth::user()->role === 'Administrador')
                                    <li>
                                        <a class="dropdown-item {{ (request()->is('user*')) ? 'active' : '' }}" href="{{url('user')}}">
                                            Usuarios
                                        </a>
                                    </li>
                                    @endif

                                </ul>
                            </li>
                            <li class="nav-item dropdown mx-1">
                                <a class="nav-link dropdown-toggle
                                    {{ (request()->is('organismo*')) ||
                                        (request()->is('osde*')) ||
                                        (request()->is('entidad*')) ||
                                        (request()->is('user*'))
                                        ? 'active' : '' }}"
                                    id="navbarDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">Nomencladores</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item {{ (request()->is('organismo*')) ? 'active' : '' }}" href="{{url('organismo')}}">
                                            Organismos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ (request()->is('osde*')) ? 'active' : '' }}" href="{{url('osde')}}">
                                            Osdes
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ (request()->is('entidad*')) ? 'active' : '' }}" href="{{url('entidad')}}">
                                            Entidades
                                        </a>
                                    </li>
                                    @if (Auth::user()->role === 'Administrador')
                                    <li>
                                        <a class="dropdown-item {{ (request()->is('user*')) ? 'active' : '' }}" href="{{url('user')}}">
                                            Usuarios
                                        </a>
                                    </li>
                                    @endif

                                </ul>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link {{ (request()->is('cpcu*')) ? 'active' : '' }}" href="{{url('cpcu')}}">CPCU</a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link {{ (request()->is('saclap*')) ? 'active' : '' }}" href="{{url('saclap')}}">SACLAP</a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link {{ (request()->is('cnae*')) ? 'active' : '' }}" href="{{url('cnae')}}">CNAE</a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link {{ (request()->is('producto*')) ? 'active' : '' }}" href="{{url('producto')}}">Productos</a>
                            </li>
                            <li class="nav-item dropdown mx-1">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
