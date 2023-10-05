
<header>
    <nav class="navbar navbar-expand-sm navbar-light bg-light border-bottom border-2 border-primary">
        <div class="container">
            <a class="navbar-brand fs-3" href="{{ url('/') }}">Trunin Blog</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fs-5">
                    <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0">
                        <a class="nav-link" href="{{ url('/') }}">Блог</a>
                    </li>
                    <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0">
                        <a class="nav-link" href="{{ url('/about') }}">Про сайт</a>
                    </li>
                    <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0 dropdown">
                        <a class="nav-link dropdown-toggle pe-auto" id="navbarDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                                Профіль
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile') }}">Мій профіль</a>

                                <li><a class="dropdown-item" href="{{ route('logout') }}">Вихід з профілю</a></li>
                                <li><a class="dropdown-item" href="{{ route('login') }}">Авторизація</a></li>
                                <li><a class="dropdown-item" href="{{ route('registration') }}">Реєстрація</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>