<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block')Главная страница@endsection

@section('content')
    <h3>Здесь будет список уроков</h3>
    <ul>
        @foreach($data as $el)
        <li><a href="{{ route('one-lesson', $el->id) }}">Урок {{ $el->id .'. '. $el->title }}</a></li>
        @endforeach
    </ul>
@endsection