<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BestRide') }}</title>

    <!-- Scripts -->
{{--<script src="{{ asset('js/app.js') }}" defer></script>--}}

<!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('js/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/jquery-ui/jquery-ui.structure.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/jquery-ui/jquery-ui.theme.min.css') }}">

    {{--<link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    @stack('styles')
</head>
<body>
@if(session()->has('popup_msg'))
    {!!  session()->get('popup_msg')  !!}
@endif

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('index') }}"><img src="{{ asset('img/BestRide_logo.png') }}"
                                                                     alt="BestRide Logo"></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <form class="navbar-form navbar-left" method="get" action="{{ route('index') }}">
                <h2 class="h4">Find your ride</h2>
                <div class="form-group">
                    <input type="text" value="{{ \Request::get('search') }}" class="form-control" placeholder="Search" name="search" id="autocomplete">
                </div>
                @push('scripts')
                    <script>
                        $(document).ready(function () {
                            let autocomplete = [
                                <?php
                                $origins = \DB::table('rides')
                                    ->selectRaw('DISTINCT origin');
                                $citys = \DB::table('rides')
                                    ->selectRaw('DISTINCT destination as name')
                                    ->union($origins)
                                    ->orderBy('name')
                                    ->get();
                                foreach ($citys as $city)
                                    echo '"' . $city->name . '",';
                                ?>
                            ];

                            $('#autocomplete').autocomplete({
                                source: autocomplete
                            });
                        });
                    </script>
                @endpush
                <select class="form-control" title="" name="filter">
                    <option value="default"
                    @if(\Request::get('filter') === 'default' || \Request::get('filter') === null)
                        selected
                    @endif
                    >Registration date</option>
                    <option value="lower_price"
                    @if(\Request::get('filter') === 'lower_price')
                        selected
                    @endif
                    >Lower Price</option>
                    <option value="high_price"
                    @if(\Request::get('filter') === 'high_price')
                          selected
                    @endif
                    >Highest Price</option>
                </select>
                <button type="submit" class="btn btn-default">Search</button>
            </form>

            @guest
                <form class="navbar-right" action="{{ route('login') }}" method="POST">
                    <div class="heading-links">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="login" data-toggle="dropdown" role="button" aria-haspopup="true"
                                   aria-expanded="false">
                                    Login
                                </a>

                                <div class="dropdown-menu dropdown-login">
                                    <div class="form-group">
                                        @csrf
                                        <input type="text" class="form-control" placeholder="E-mail" name="email">
                                        <input type="password" class="form-control" placeholder="Password"
                                               name="password">
                                    </div>
                                    <button type="submit" class="btn btn-default">OK</button>
                                </div>
                            </li>

                            <li>
                                <a href="{{ route('register') }}" class="btn">Register</a>
                            </li>
                        </ul>

                    </div>
                </form>
            @else
                <form class="navbar-right">
                    <div class="heading-links pull-left">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">
                                    <img style="width: 40px; height: 40px;" class="img-circle"
                                         src="{{ asset('img/avatars/'.Auth::user()->avatar) }}" alt="Avatar"/>
                                    {{ Auth::user()->name }} Age: {{ getAge(Auth::user()->birthdate) }}<span
                                            class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('profile.index') }}">Manage Rides</a></li>
                                    <li><a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit(); ">Выйти</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </form>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </div>
    </div>
</nav>
<div id="app">
    <main class="py-4">
        @yield('content')
    </main>
</div>

<footer class="footer">
    <div class="container">© BestRide 2017</div>
</footer>

<script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
<script src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/ClassValidation.js') }}"></script>
<script src="{{ asset('js/ClassCustomConfirm.js') }}"></script>
<script src="{{ asset('js/ActionRides.js') }}"></script>

@stack('scripts')
</body>
</html>
