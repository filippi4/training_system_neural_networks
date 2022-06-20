<header class="py-2">
    <div class="container d-flex flex-wrap justify-content-center">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 me-lg-auto text-dark text-decoration-none">
            <span class="fs-4"><strong>Обучение теории нейронных сетей</strong></span>
        </a>
        <ul class="nav">
        @if (!Session::has('loginId'))
            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link link-dark px-2">Вход</a></li>
            <li class="nav-item"><a href="{{ route('registration') }}" class="nav-link link-dark px-2">Регистрация</a></li>
        @else
            <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link link-dark px-2">{{ Session::get('userName') }}</a></li>
            <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link link-dark px-2">Выйти</a></li>
        @endif
        </ul>
    </div>
</header>