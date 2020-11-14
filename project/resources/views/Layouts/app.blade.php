<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
         .container-fluid {
            display: flex;
            }

        .fixed-bottom-right {
            position: absolute;
            bottom: 0px;
            right: 0px; 
        }

        #showChat{

        }

        #chat:hover{
            color:rgb(189, 189, 189);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #fbc609;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('home') }}">
                    <img src="{{asset('images/szlogo.png')}}" height="28" alt="{{ config('app.name', 'Laravel') }}">
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
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <!--{{ $user = Auth::user()->id }}-->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show', $user) }}"
                                    onclick = "{{ Auth::user()->id }}"> {{ __('Profile')}} </a>

                                    <a class="dropdown-item" href="{{route('chat')}}">Message Center</a>

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

        <main class="">
            <div class="container-fluid py-4">

                <div class="row-fluid">

                    <div id="showChat" class="fixed-bottom-right" class="fa-4x">
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <a id="chat" class="fas fa-comments fa-stack-1x fa-inverse" href="{{route('chat')}}" style="text-decoration: none;"></a>
                        </span>
                    </div>

                    <div class="col">
                        @include('inc.sidebar')
                    </div>

                    <div class="col col-md-8">
                        @yield('content')
                    </div>

                    <div class="col">
                        <!-- Contacts menu on Right-->
                        @include('inc.contactsidebar')
                    </div>

                </div>

            </div>
        </main>
    </div>
</body>
</html>
