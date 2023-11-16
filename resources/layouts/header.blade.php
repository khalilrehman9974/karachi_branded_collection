<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'User Automation') }}</title>


</head>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="background-color: #3c8dbc !important; height: 55px; margin-left: 242px ">


    <div class="container">


        {{--                <img src="{{asset('/images/logo.jpg')}}" alt="" style="width: 80px"/>--}}
       {{-- <a class="navbar-brand" href="{{ url('/') }}" style="color: #ffffff !important;">
            {{ config('app.name', 'Laravel') }}
        </a>--}}
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
                    {{--@if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif--}}
                @else
{{--                    <li class="nav-item dropdown">--}}
{{--                        <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">--}}
                        {{--<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="color: #ffffff">
                            {{ Auth::user()->name }}
                        </a>--}}

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="color: #ffffff">
                            <img src="{{ asset('images/avatar.jpg') }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu" style="width: 50px">
                            <!-- User image -->
                            {{--<li class="user-header">
                                <img src="{{ asset('images/avatar.jpg') }}" class="img-circle" alt="User Image">

                                <p>
                                    {{ Auth::user()->name }}
--}}{{--                                    <small>Member since Nov. 2012</small>--}}{{--
                                </p>
                            </li>--}}
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
{{--                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>--}}
                                    <a class="" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="float: left; width: 50px">
                                        {{ __('Logout') }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>

                      {{--  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>--}}
{{--                    </li>--}}
                @endguest
            </ul>

        </div>



    </div>

</nav>
