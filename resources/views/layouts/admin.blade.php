<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('site.sitename', 'Laravel') }}</title>
    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">    
    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    
    <header>

        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="{{ url('/') }}"> {{ config('site.sitename', 'Laravel') }} </a>

            @if(Auth::user())
                <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item @if(Route::current()->getName() == 'admin.dashboard') active @endif">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Tableau de Bord</a>
                        </li>
                        <li class="nav-item @if(strpos(Route::current()->getName(), 'admin.user') !== false) active @endif">
                            <a class="nav-link" href="{{ route('admin.users') }}">Utilisateurs</a>
                        </li>
                        <li class="nav-item @if(strpos(Route::current()->getName(), 'admin.article') !== false) active @endif">
                            <a class="nav-link" href="{{ route('admin.articles') }}">Articles</a>
                        </li>
                        <li class="nav-item @if(strpos(Route::current()->getName(), 'admin.categor') !== false) active @endif">
                            <a class="nav-link" href="{{ route('admin.categories') }}">Catégories</a>
                        </li>
                        <li class="nav-item @if(strpos(Route::current()->getName(), 'admin.mot') !== false) active @endif">
                            <a class="nav-link" href="{{ route('admin.tags') }}">Mots Clés</a>
                        </li>
                    </ul>
                </div>

                <div class="mt-2 mt-md-0">
                    <div class="collapse navbar-collapse " id="navbarsExampleDefault">
                        <ul class="navbar-nav mr-auto text-right">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.user.edit', Auth::user()->id) }}">
                                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-question-circle"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-power-off"></i>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

        </nav>
    </header>
    
    <div class="container container-admin">
        <div class="row align-items-center">
            <h1 class="col-sm-12 col-md-8">@yield('title')</h1>
            <div class="col-sm-12 col-md-4 text-right">
                @yield('right')
            </div>
        </div>
        <main role="main">
            @include('layouts.errors')
            @yield('content')
        </main>
    </div>

    <footer class="footer">
        <div class="container text-center">
            <p class="text-muted">{{ config('site.sitename', 'Laravel') }} © {{ date('Y') }} - Ketsuka & Ezamux</p>
        </div>
    </footer>
    <!-- Scripts -->
    
    @yield('jscontent')
</body>
</html>
