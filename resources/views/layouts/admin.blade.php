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

        {{-- <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-2 shadow">
      <div class="row justify-content-between">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">BoolBnB</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
          data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="navbar-nav">
        <div class="nav-item text-nowrap ms-2">
          <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </div>
    </header> --}}

        <div class="container-fluid vh-100">
            <div class="row h-100">
                <!-- Definire solo parte del menu di navigazione inizialmente per poi
        aggiungere i link necessari giorno per giorno
        -->
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark navbar-dark sidebar collapse">
                    <div>
                        <a href="http://localhost:5174">
                            <img class="w-100" src="{{ url('boolbnb_logo.png') }}" alt=""></a>
                    </div>
                    <div class="position-sticky">
                        <ul class="nav flex-column">
                            <div class="separator"></div>
                            <li class="nav-item mt-1 mb-1">
                                <a class="nav-link {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            {{-- <li class="nav-item mt-1 mb-1">
                                <a class="nav-link {{ Route::currentRouteName() == 'admin.apartments.potato' ? 'active' : '' }}"
                                    href="{{ route('admin.apartments.index') }}">
                                    <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i>
                                    <span>Messaggi</span>
                                </a>
                            </li> --}}
                            <div class="separator"></div>
                            
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'admin.apartments.index' ? 'active' : '' }}"
                                    href="{{ route('admin.apartments.index') }}">
                                    <i class="fa-solid fa-house fs-5"></i>
                                    <span>Appartamenti</span>
                                </a>
                            </li>
                            <li class="nav-item mt-1 mb-1">
                                <a class="nav-link {{ Route::currentRouteName() == 'admin.apartments.create' ? 'active' : '' }}"
                                    href="{{ route('admin.apartments.create') }}">
                                    <i class="fa-solid fa-plus fs-5"></i>
                                    <span>Aggiungi appartamento</span>
                                </a>
                            </li>
                            {{-- <li class="nav-item mt-1 mb-1">
                                <a class="nav-link {{ Route::currentRouteName() == 'admin.apartments.list_sponsor' ? 'active' : '' }}"
                                    href="{{ route('admin.apartments.list_sponsor', ['apartment' => $apartment->slug]) }}">
                                    <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i>
                                    <span>Sponsorship</span>
                                </a>
                            </li> --}}
                            <div class="separator"></div>
                            {{-- <li class="nav-item mt-1 mb-1">
                                <a class="nav-link {{ Route::currentRouteName() == 'admin.apartments.potato' ? 'active' : '' }}"
                                    href="{{ route('admin.apartments.index') }}">
                                    <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i>
                                    <span>Impostazioni</span>
                                </a>
                            </li> --}}
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
