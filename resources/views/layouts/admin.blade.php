<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fontawesome 6 cdn -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css'
        integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=='
        crossorigin='anonymous' referrerpolicy='no-referrer' />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">

        <header class="navbar sticky-top bg-light p-2 shadow d-md-none">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="w-25">
                    <a href="{{ route('admin.apartments.index') }}">
                        <img class="w-100" src="{{ asset('boolbnb_logo.png') }}" alt="Logo">
                    </a>
                </div>
                <div>
                    <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </header>


        <div class="container-fluid vh-100">
            <div class="row h-100">
                <!-- Definire solo parte del menu di navigazione inizialmente per poi
        aggiungere i link necessari giorno per giorno
        -->
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    <div class="position-sticky">
                        {{-- LOGO-HOME --}}
                        <a class="d-none d-md-block" href="{{ route('admin.apartments.index') }}">
                            <img src="{{ asset('boolbnb_logo.png') }}" alt="" class="container-fluid">
                        </a>

                        <div class="separator d-none d-md-block"></div>

                        {{-- NAV ITEMS --}}
                        <ul class="nav flex-column">

                            {{-- DASHBOARD WELCOME --}}
                            <li class="nav-item mt-1 mb-1">
                                <a class="nav-link {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="fa-solid fa-tachometer-alt fs-5 fa-fw"></i>
                                    <span class="fs-5 ps-2">Dashboard</span>
                                </a>
                            </li>
                            {{-- DASHBOARD WELCOME --}}


                            <div class="separator"></div>

                            {{-- INDEX --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'admin.apartments.index' ? 'active' : '' }}"
                                    href="{{ route('admin.apartments.index') }}">
                                    <i class="fa-solid fa-house fa-fw fs-5"></i>
                                    <span class="fs-5 ps-2">  Appartamenti</span>
                                </a>
                            </li>
                            {{-- INDEX --}}

                            {{-- ADD --}}
                            <li class="nav-item mt-1 mb-1">
                                <a class="nav-link {{ Route::currentRouteName() == 'admin.apartments.create' ? 'active' : '' }}"
                                    href="{{ route('admin.apartments.create') }}">
                                    <i class="fa-solid fa-plus fa-fw fs-5"></i>
                                    <span class="fs-5 ps-2">  Aggiungi</span>
                                </a>
                            </li>
                            {{-- ADD --}}

                            {{-- SPONSORSHIP --}}
                            <li class="nav-item mt-1 mb-1">
                                <a class="nav-link {{ Route::currentRouteName() == 'admin.sponsorship' ? 'active' : '' }}"
                                    href="{{ route('admin.sponsorship') }}">
                                    <i class="fa-solid fa-money-bill-trend-up fa-fw fs-5"></i>
                                    <span class="fs-5 ps-2"> Sponsorizza</span>
                                </a>
                            </li>
                            {{-- SPONSORSHIP --}}

                            <div class="separator"></div>

                            {{-- LOGOOUT --}}
                            <li class="nav-item mt-1 mb-1">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket fa-fw fs-5"></i>
                                    <span class="fs-5 ps-2"> {{ __('Logout') }} </span> 
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            {{-- LOGOOUT --}}
                        </ul>



                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main_container">
                    @yield('content')
                </main>
            </div>
        </div>

    </div>
</body>

</html>
