<nav class="py-2 bg-light border-bottom">
    <div class="container d-flex flex-wrap">
      <ul class="nav me-auto">
        <li class="nav-item"><a href="{{ route('home')}}" class="nav-link link-dark px-2 active" aria-current="page">Главная</a></li>
        <li class="nav-item"><a href="{{ route('lessons')}}" class="nav-link link-dark px-2">Уроки</a></li>
        <li class="nav-item"><a href="{{ route('testing')}}" class="nav-link link-dark px-2">Тестирование</a></li>
        <li class="nav-item"><a href="{{ route('glossary')}}" class="nav-link link-dark px-2">Глоссарий</a></li>
        <li class="nav-item"><a href="{{ route('about')}}" class="nav-link link-dark px-2">О сайте</a></li>
      </ul>
      <ul class="nav">
        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link link-dark px-2">Вход</a></li>
        <li class="nav-item"><a href="{{ route('registration') }}" class="nav-link link-dark px-2">Регистрация</a></li>
      </ul>
    </div>
  </nav>