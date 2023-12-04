<header>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark border-bottom border-2 border-danger">
        <div class="container">
            <a class="navbar-brand fs-3 text-light" href="{{ url('/') }}">Nosebook</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-light"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fs-5">
                    <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0">
                        <a class="nav-link text-light" href="{{ url('/') }}">Стрічка</a>
                    </li>
                    <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0 dropdown">
                        <a class="nav-link dropdown-toggle pe-auto text-light" id="navbarDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                           @if(Auth::check())
                               {{ Auth::user()->login }}
                           @else
                               Профіль
                           @endif
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if(Auth::check())
                                <li><a class="dropdown-item" href="{{ route('profile', Auth::user()->id) }}">Мій профіль</a></li>
                                <li><a class="dropdown-item" href="{{ route('friends') }}">Мої друзі</a></li>
                                <li><a class="dropdown-item" href="{{ route('friend-requests') }}">Запити в друзі</a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Вихід з профілю</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('loginView') }}">Авторизація</a></li>
                                <li><a class="dropdown-item" href="{{ route('registrationView') }}">Реєстрація</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
