<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('site.sitename') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample10">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('index') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('articles') }}">Articles</a>
                    </li>
                    <li class="nav-item dropdown">
                       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           Dropdown
                       </a>
                       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                           <a class="dropdown-item" href="#">Action</a>
                           <a class="dropdown-item" href="#">Another action</a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="#">Something else here</a>
                       </div>
                    </li>
                </ul>
            </div>
        </nav>   
        <div class="jumbotron">
            <div class="container">
                <h1 class="display-3">{{ config('site.sitename') }}</h1>
                <p>{{ config('site.description')}}</p>
            </div>
        </div>
    </header>

    <div class="container">
        <main role="main">
            <h2>@yield('title')</h2>
            <div class="alert alert-light" role="alert">@yield('subtitle')</div>
            @yield('content')
        </main>
    </div>

    <footer class="footer">
        <div class="container">
            <span class="text-muted">
                {{ config('site.sitename') }} © {{ Date('Y') }}. All Rights Reserved / 
                <a href="{{ route('map') }}">Plan du Site</a> / 
                <a href="{{ route('mentions') }}">Mentions Légales</a> / 
                @if(Auth::user())
                    <a href="{{ route('admin.dashboard') }}">Administration</a>
                @else 
                    <a href="{{ route('login') }}">Connexion</a>
                @endif
            </span>
        </div>
    </footer>

    <!-- Scripts -->
    @yield('jscontent')
</body>
</html>