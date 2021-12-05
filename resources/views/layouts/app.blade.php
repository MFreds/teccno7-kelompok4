<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/card-styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/general.css') }}" rel="stylesheet">

    {{-- ajax jquery --}}
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    @yield('styles')

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item dropdown">
                            <a id="dropdownService" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Hampers') }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownService">

                                <a class="dropdown-item" href="{{ route('admin.home') }}">
                                    {{ __('Katalog') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.home') }}">
                                    {{ __('Custom') }}
                                </a>

                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="dropdownService" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Cetak 3D') }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownService">

                                <a class="dropdown-item" href="{{ route('admin.home') }}">
                                    {{ __('Cetak Model 3D') }}
                                </a>

                            </div>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                @if(Auth::user()->is_admin == "1")
                                <a class="dropdown-item" href="{{ route('admin.home') }}">
                                    {{ __('Home admin') }}
                                </a>
                                @endif
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- alert template --}}
        {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
            Error message
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
            <strong>Success!</strong>Article was added successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div> --}}

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="w-100 py-4 flex-shrink-0">
            <div class="container py-4">
                <div class="row gy-4 gx-5">
                    <div class="col-lg-4 col-md-6">
                        <h5 class="h1 text-white">Merchoon.</h5>
                        <p class="small text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt.</p>
                        <p class="small text-muted mb-0">&copy; Copyrights. All rights reserved. <a class="text-primary"
                                href="#">merchoon.com</a></p>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <h5 class="text-white mb-3">Quick links</h5>
                        <ul class="list-unstyled text-muted">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Get started</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <h5 class="text-white mb-3">Quick links</h5>
                        <ul class="list-unstyled text-muted">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Get started</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                    {{-- <div class="col-lg-4 col-md-6">
                        <h5 class="text-white mb-3">Newsletter</h5>
                        <p class="small text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt.</p>
                        <form action="#">
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" placeholder="Recipient's username"
                                    aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-primary" id="button-addon2" type="button"><i
                                        class="fas fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div> --}}
                </div>
            </div>
        </footer>
    </div>
    @yield('script')
</body>

</html>
