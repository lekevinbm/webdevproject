<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>#FIFAISBAE Fotowedstrijd</title>

        <!-- Fonts -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" >
       <link href="https://fonts.googleapis.com/css?family=Muli:400,700,800,900" rel="stylesheet">
        
    </head>
    <body>
        <nav id="nav" class="navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">#FIFAISBAE</a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav"></ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                    <li><a href="/openAllPictures">Alle inzendingen</a></li>
                    <li><a href="/newParticipant">Een foto Inzenden</a></li>
                    @guest
                        <li><a href="/login"></i>Aanmelden</a></li>
                    @endguest
                    
                    
                    </span>

                        <!-- Authentication Links -->
                        
                        @auth
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    @if(Auth::user()->isAdmin)
                                        <li><a class="btn" href="/allParticipants">Gebruikers beheren</a></li>                                </li>
                                    @endif
                                    @if(Auth::user()->isParticipant)
                                        <li><a class="btn" href="/openPicturesParticipent">Mijn inzendingen</a></li>                                </li>
                                    @endif
                                    <li><a class="btn" href="{{ route('logout') }}">Uitloggen</a></li>
                                    <li>
                                        
                                    </li>
                                </ul>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
         <div id="header-div">
            <a href="{{ url('/') }}"><img id="header-image" src="{{ asset('img/Ronaldo-header.png') }}"></a>
        </div>
        <div class="content container">
        @yield('content')
        </div>
        <footer>
            <div class="container">
                <div class="col-md-9">
                    <h6>De #FIFAISBAE fotowedstrijd is een initiatief van <a href="https://www.easports.com/fifa/">EA Sports</a>.</h6>
                </div>
            </div>
        </footer>
    </body>
</html>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>