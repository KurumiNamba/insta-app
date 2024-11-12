<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Style CSS --}}
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    {{-- Fontawesome CDN Link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
@guest
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm nav-bar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h1 class="h5 mb-0">{{ config('app.name', 'Laravel') }}</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth    
                        @if (!request()->is('admin/*'))    
                            <ul class="navbar-nav ms-auto">
                                {{--  Search bar here. Show it when the user logs in. --}}
                                <form action="{{route('search')}}" style="width: 300px">
                                    <input type="search" name="search" class="form-control form-control-sm" placeholder="Search...">
                                </form>
                            </ul>
                        @endif
                    @endauth
    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
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
                            {{-- Home --}}
                            <li class="nav-item" title="Home">
                                <a href="{{ route('index') }}" class="nav-link"><i class="fa-solid fa-house text-dark icon-sm"></i></a>
                            </li>
    
                            {{-- Create Post --}}
                            <li class="nav-item" title="Create Post">
                                <a href="{{route('post.create')}}" class="nav-link"><i class="fa-solid fa-circle-plus text-dark icon-sm"></i></a>
                            </li>
    
                            {{-- Change Color --}}
                            <li>
                                <form action="{{ route('changeTheme') }}" method="POST">
                                    @csrf
                                    <button type="submit" name="theme" value="{{ Auth::user()->theme === 'dark' ? 'normal' : 'dark' }}" class="nav-link">
                                        <i class="fa-solid fa-brush text-dark icon-sm"></i>
                                    </button>
                                </form>
                            </li>
    
                            {{-- Account --}}
                            <li class="nav-item dropdown">
                                <button id="account-dropdown" class="btn shadow-none nav-link" data-bs-toggle="dropdown">
                                    @if (Auth::user()->avatar)
                                        <img src="{{Auth::user()->avatar}}" alt="{{Auth::user()->name}}" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                    @endif
                                </button>
    
                                <div class="dropdown-menu dropdown-menu-end" area-labelledby="account-dropdown">
                                    @can('admin')
                                    {{-- Admin Controls --}}
                                    <a href="{{route('admin.users')}}" class="dropdown-item">
                                        <i class="fa-solid fa-user-gear"></i> Admin
                                    </a>
                                    <hr class="dropdown-devider">
                                    @endcan
    
                                    {{-- Profile --}}
                                    <a href="{{route('profile.show', Auth::user()->id)}}" class="dropdown-item">
                                        <i class="fa-solid fa-circle-user"></i> Profile
                                    </a>
    
                                    {{-- Password --}}
                                    <a href="{{route('profile.password', Auth::user()->id)}}" class="dropdown-item">
                                        <i class="fa-solid fa-key"></i> Update Password
                                    </a>
    
                                    {{-- Logout --}}
                                    
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                         <i class="fa-solid fa-right-from-bracket"></i>
                                            {{ __('Logout') }}
                                        </a>
    
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                </div>
    
    
                                {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a> --}}
    
                                
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    
        <main class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    {{--  Admin Menus (col-3) --}}
                    @if (request()->is('admin/*'))    
                    <div class="col-3">
                        <div class="list-group">
                            <a href="{{route('admin.users')}}" class="list-group-item {{request()->is('admin/users') ? 'active':'s'}}">
                                <i class="fa-solid fa-users"></i> Users
                            </a>
                            <a href="{{route('admin.posts')}}" class="list-group-item {{request()->is('admin/posts')?'active':''}}">
                                <i class="fa-solid fa-newspaper"></i> Post
                            </a>
                            <a href="{{route('admin.categories')}}" class="list-group-item {{request()->is('admin/categories')?'active':''}}">
                                <i class="fa-solid fa-tags"></i> Category
                            </a>
                        </div>
                    </div>
                    @endif
    
                    {{-- 
                    
                    Example HTTP request: 
    
                    Pattern: request()->is('admin/*')
    
                    localhost is the as 127.0.0.1
                    http://localhost/post/3/show    [not admin request]
                    http://localhost/admin/users    [admin request]
                    http://localhost/admin           [not admin request]
                    http://localhost/admin/5/update　[admin request]
                    
    
    
    
                    --}}
    
                    <div class="col-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    </body>
@endguest
@auth
@if (Auth::user()->theme == 'normal')
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm nav-bar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <h1 class="h5 mb-0">{{ config('app.name', 'Laravel') }}</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                @auth    
                    @if (!request()->is('admin/*'))    
                        <ul class="navbar-nav ms-auto">
                            {{--  Search bar here. Show it when the user logs in. --}}
                            <form action="{{route('search')}}" style="width: 300px">
                                <input type="search" name="search" class="form-control form-control-sm" placeholder="Search...">
                            </form>
                        </ul>
                    @endif
                @endauth

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
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
                        {{-- Home --}}
                        <li class="nav-item" title="Home">
                            <a href="{{ route('index') }}" class="nav-link"><i class="fa-solid fa-house text-dark icon-sm"></i></a>
                        </li>

                        {{-- Create Post --}}
                        <li class="nav-item" title="Create Post">
                            <a href="{{route('post.create')}}" class="nav-link"><i class="fa-solid fa-circle-plus text-dark icon-sm"></i></a>
                        </li>

                        {{-- Change Color --}}
                        <li>
                            <form action="{{ route('changeTheme') }}" method="POST">
                                @csrf
                                <button type="submit" name="theme" value="{{ Auth::user()->theme === 'dark' ? 'normal' : 'dark' }}" class="nav-link">
                                    <i class="fa-solid fa-moon text-dark icon-sm"></i>
                                </button>
                            </form>
                        </li>

                        {{-- Account --}}
                        <li class="nav-item dropdown">
                            <button id="account-dropdown" class="btn shadow-none nav-link" data-bs-toggle="dropdown">
                                @if (Auth::user()->avatar)
                                    <img src="{{Auth::user()->avatar}}" alt="{{Auth::user()->name}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                @endif
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" area-labelledby="account-dropdown">
                                @can('admin')
                                {{-- Admin Controls --}}
                                <a href="{{route('admin.users')}}" class="dropdown-item">
                                    <i class="fa-solid fa-user-gear"></i> Admin
                                </a>
                                <a href="{{route('reports')}}" class="dropdown-item">
                                    <i class="fa-solid fa-chart-line"></i> Report
                                </a>
                                <hr class="dropdown-devider">
                                @endcan

                                {{-- Profile --}}
                                <a href="{{route('profile.show', Auth::user()->id)}}" class="dropdown-item">
                                    <i class="fa-solid fa-circle-user"></i> Profile
                                </a>

                                {{-- Password --}}
                                <a href="{{route('profile.password', Auth::user()->id)}}" class="dropdown-item">
                                    <i class="fa-solid fa-key"></i> Update Password
                                </a>

                                {{-- Logout --}}
                                
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="fa-solid fa-right-from-bracket"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </div>


                            {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a> --}}

                            
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                {{--  Admin Menus (col-3) --}}
                @if (request()->is('admin/*'))    
                <div class="col-3">
                    <div class="list-group">
                        <a href="{{route('admin.users')}}" class="list-group-item {{request()->is('admin/users') ? 'active':'s'}}">
                            <i class="fa-solid fa-users"></i> Users
                        </a>
                        <a href="{{route('admin.posts')}}" class="list-group-item {{request()->is('admin/posts')?'active':''}}">
                            <i class="fa-solid fa-newspaper"></i> Post
                        </a>
                        <a href="{{route('admin.categories')}}" class="list-group-item {{request()->is('admin/categories')?'active':''}}">
                            <i class="fa-solid fa-tags"></i> Category
                        </a>
                    </div>
                </div>
                @endif

                {{-- 
                
                Example HTTP request: 

                Pattern: request()->is('admin/*')

                localhost is the as 127.0.0.1
                http://localhost/post/3/show    [not admin request]
                http://localhost/admin/users    [admin request]
                http://localhost/admin           [not admin request]
                http://localhost/admin/5/update　[admin request]
                



                --}}

                <div class="col-9">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</div>
</body>

{{-- design for dark mode --}}
@else
<body class="dark-mode-bg">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm nav-bar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <h1 class="h5 mb-0 text-white">{{ config('app.name', 'Laravel') }}</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                @auth    
                    @if (!request()->is('admin/*'))    
                        <ul class="navbar-nav ms-auto">
                            {{--  Search bar here. Show it when the user logs in. --}}
                            <form action="{{route('search')}}" style="width: 300px">
                                <input type="search" name="search" class="form-control form-control-sm" placeholder="Search...">
                            </form>
                        </ul>
                    @endif
                @endauth

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
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
                        {{-- Home --}}
                        <li class="nav-item" title="Home">
                            <a href="{{ route('index') }}" class="nav-link"><i class="fa-solid fa-house text-white icon-sm"></i></a>
                        </li>

                        {{-- Create Post --}}
                        <li class="nav-item" title="Create Post">
                            <a href="{{route('post.create')}}" class="nav-link"><i class="fa-solid fa-circle-plus text-white icon-sm"></i></a>
                        </li>

                        {{-- Change Color --}}
                        <li>
                            <form action="{{ route('changeTheme') }}" method="POST">
                                @csrf
                                <button type="submit" name="theme" value="{{ Auth::user()->theme === 'dark' ? 'normal' : 'dark' }}" class="nav-link">
                                    <i class="fa-solid fa-sun text-white icon-sm"></i>
                                </button>
                            </form>
                        </li>

                        {{-- Account --}}
                        <li class="nav-item dropdown">
                            <button id="account-dropdown" class="btn shadow-none nav-link" data-bs-toggle="dropdown">
                                @if (Auth::user()->avatar)
                                    <img src="{{Auth::user()->avatar}}" alt="{{Auth::user()->name}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-white icon-sm"></i>
                                @endif
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" area-labelledby="account-dropdown">
                                @can('admin')
                                {{-- Admin Controls --}}
                                <a href="{{route('admin.users')}}" class="dropdown-item">
                                    <i class="fa-solid fa-user-gear"></i> Admin
                                </a>
                                <hr class="dropdown-devider">
                                @endcan

                                {{-- Profile --}}
                                <a href="{{route('profile.show', Auth::user()->id)}}" class="dropdown-item">
                                    <i class="fa-solid fa-circle-user"></i> Profile
                                </a>

                                {{-- Password --}}
                                <a href="{{route('profile.password', Auth::user()->id)}}" class="dropdown-item">
                                    <i class="fa-solid fa-key"></i> Update Password
                                </a>

                                {{-- Logout --}}
                                
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="fa-solid fa-right-from-bracket"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </div>


                            {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a> --}}

                            
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                {{--  Admin Menus (col-3) --}}
                @if (request()->is('admin/*'))    
                <div class="col-3">
                    <div class="list-group">
                        <a href="{{route('admin.users')}}" class="list-group-item {{request()->is('admin/users') ? 'active':'s'}}">
                            <i class="fa-solid fa-users"></i> Users
                        </a>
                        <a href="{{route('admin.posts')}}" class="list-group-item {{request()->is('admin/posts')?'active':''}}">
                            <i class="fa-solid fa-newspaper"></i> Post
                        </a>
                        <a href="{{route('admin.categories')}}" class="list-group-item {{request()->is('admin/categories')?'active':''}}">
                            <i class="fa-solid fa-tags"></i> Category
                        </a>
                    </div>
                </div>
            </div>
                @endif

                {{-- 
                
                Example HTTP request: 

                Pattern: request()->is('admin/*')

                localhost is the as 127.0.0.1
                http://localhost/post/3/show    [not admin request]
                http://localhost/admin/users    [admin request]
                http://localhost/admin           [not admin request]
                http://localhost/admin/5/update　[admin request]
                



                --}}

                <div class="col-9">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</div>
@endif
@endauth
    
</body>
</html>
