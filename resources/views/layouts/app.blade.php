<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Agenda V2') . ' - '}} @yield('title') </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Agenda V2') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('calendario')}}">
                                    Calendario
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Reuniones y Documentos
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Reuniones</a>
                                    <a class="dropdown-item" href="#">Minutas</a>
                                    <a class="dropdown-item" href="#">Órdenes del día</a>
                                    <a class="dropdown-item" href="#">Asuntos Pendientes</a>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('divisions.index')}}">Estructura de la FI</a>
                            </li>

                            @can('viewAny', App\User::class)
                            <li class="nav-item">
                                    <a class="nav-link" href="{{route('users.index')}}">Usuarios</a>
                            </li>
                            @endcan
                        </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">@lang('strings.login')</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->grado . ' ' . Auth::user()->nombre }}
                                    <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        @lang('strings.logout')
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-12 col-lg-10">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="pt-2">
                                   @yield('title')
                                </h5>
                            </div>
                            <div class="card-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="page-footer font-small blue pt-6">
            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">Todos los derechos reservados © 1999 - 2019 / Facultad de Ingeniería/UNAM/</div>
            <div class="container">
                <div class="small">
                        Esta es la página electrónica institucional de la Facultad de Ingeniería de la UNAM. Puede ser reproducida con fines no lucrativos, siempre y cuando no se mutile, se cite la fuente completa y su dirección electrónica. Contiene enlaces con diversos portales de entidades y organizaciones académicas, estudiantiles y profesionales, así como con páginas personales de profesores e investigadores cuyos contenidos son de la responsabilidad exclusiva de sus titulares.
                </div>
            </div>
            <!-- Copyright -->
        </footer>
        <!-- Footer -->
    </div>
</body>
</html>
