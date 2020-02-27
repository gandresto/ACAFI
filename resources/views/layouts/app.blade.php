<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- API Token -->
    @auth
        <meta name="api-token" content="{{ Auth::user()->api_token }}">
    @endauth

    <title>{{ config('app.name', 'Agenda V2') . ' - '}} @yield('title') </title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('js/bootstrap.js') }}" defer></script> --}}
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('page-styles')

</head>
<body>
    <div id="app">
        
        {{-- -------------- --------- BARRA DE NAVEGACIÓN ---------------------------------- --}}
        <nav class="navbar navbar-expand-md navbar-dark bg-red shadow-sm">
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
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('reuniones.index')}}">
                                    Reuniones
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Minutas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Reportes
                                </a>
                            </li> --}}
                            
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Reuniones y Documentos
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('reuniones.index')}}">Reuniones</a>
                                    <a class="dropdown-item" href="#">Minutas</a>
                                    <a class="dropdown-item" href="#">Órdenes del día</a>
                                    <a class="dropdown-item" href="#">Asuntos Pendientes</a>
                                </div>
                            </li> --}}

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('divisions.index')}}">Estructura FI</a>
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
                                <a id="dropdownUser" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->grado . ' ' . Auth::user()->nombre }}
                                    <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUser">
                                    <a class="dropdown-item" href="{{route('users.show', Auth::user())}}">
                                        Perfil
                                    </a>
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

        {{-- -----------------------    CONTENIDO PRINCIPAL    ------------------- --}}
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="pt-2">
                                    <a href="{{url()->previous()}}" class="button mr-3">
                                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                    </a>
                                    @yield('title')
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="page-footer font-small blue pt-6">
            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">Copyright 2019 {{config('license.owner')}}</div>
            {{-- <div class="container">
                <div class="small">
                    Autorizado en virtud de la Licencia de Apache, Versión 2.0 (la "Licencia"); se prohíbe utilizar este archivo excepto en cumplimiento de la Licencia. Podrá obtener una copia de la Licencia en:<br>
                    <a href="http://www.apache.org/licenses/LICENSE-2.0">http://www.apache.org/licenses/LICENSE-2.0</a><br>
                    A menos que lo exijan las leyes pertinentes o se haya establecido por escrito, el software distribuido en virtud de la Licencia se distribuye “TAL CUAL”, SIN GARANTÍAS NI CONDICIONES DE NINGÚN TIPO, ya sean expresas o implícitas. Véase la Licencia para consultar el texto específico relativo a los permisos y limitaciones establecidos en la Licencia.
                </div>
            </div> --}}
            <!-- Copyright -->
        </footer>
        <!-- Footer -->
    </div>  
    <script>
        window.Laravel = {
            'authUserId' : {{ Auth::user()->id ?? null }}
        };
    </script>
    @yield('page-scripts')
</body>
</html>
