@section('navigation')

<nav class="navbar navbar-default navbar-static-top">
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
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'HMS') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            @if ( !Auth::guest())
                <ul class="nav navbar-nav">
                    <!--&nbsp;-->
                    <li><a href="{{ route('holidays') }}">Заявки</a></li>
                    @if (Auth::user()->can('is-leader'))
                        <li><a href="{{ route('users') }}">Пользователи</a></li>
                        <li><a href="{{ route('positions') }}">Справочник должностей</a></li>
                        <li><a href="{{ route('settings') }}">Система</a></li>
                    @endif
                </ul>
            @endif

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="{{ route('auth.login') }}">Вход</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->email }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('profile') }}">Профиль</a>
                            </li>
                            <li>
                                @if (Auth::user()->can('is-leader'))
                                    <a href="{{ route('settings') }}">Параметры системы</a>
                                @endif
                            </li>
                            <li>
                                <!--a href="{{ route('auth.logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a-->

                                <!--form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form-->
                                <a href="{{ route('auth.logout') }}">Выход</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@endsection
