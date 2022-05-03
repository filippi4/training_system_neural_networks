<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block')Тестирование@endsection

@section('content')
    <h3>Тест для проверки полученных знаний</h3>
    <br>
    <a  class="btn btn-success" href="{{ route('test') }}">Начать тестирование</a>
@endsection