<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block')Тестирование@endsection

@section('content')
    <h3>Тест для проверки полученных знаний</h3>
    <br>
    <a href="{{ route('test') }}"><button class="btn btn-success"><h1>Начать тестирование</h1></button></a>
@endsection