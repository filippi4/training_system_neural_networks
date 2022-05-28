<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block')Тестирование@endsection

@section('content')
    <h3>Тесты для проверки полученных знаний</h3>
    <br>
    <a  class="btn btn-success" href="{{ route('test', 'theor') }}" title="Тест на знание теории">
        Теоретический тест
    </a>
    <a  class="btn btn-success" href="{{ route('test', 'math') }}" title="Тест на знание формул">
        Математический тест
    </a>
@endsection