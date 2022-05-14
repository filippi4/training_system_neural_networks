<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block')Глоссарий@endsection

@section('content')
    <h3>Глоссарий</h3>
    <ul>
        <h4>Б</h4>
        <li><a href="{{ route('definition-glossary', 'Бесполезный нейрон') }}">Бесполезный нейрон</a></li>
        <h4>Г</h4>
        <li><a href="{{ route('definition-glossary', 'Гиперплоскость') }}">Гиперплоскость</a></li>
        <h4>Н</h4>
        <li><a href="{{ route('definition-glossary', 'Нейрон') }}">Нейрон</a></li>
        <h4>П</h4>
        <li><a href="{{ route('definition-glossary', 'Переобученность нейронной сети') }}">Переобученность нейронной сети</a></li>
        <li><a href="{{ route('definition-glossary', 'Полносвязная сеть прямого распространения') }}">Полносвязная сеть прямого распространения</a></li>
        <h4>С</h4>
        <li><a href="{{ route('definition-glossary', 'Среднеквадратичная ошибка') }}">Среднеквадратичная ошибка</a></li>
        <li><a href="{{ route('definition-glossary', 'Симплекс') }}">Симплекс</a></li>
    </ul>
@endsection