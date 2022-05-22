<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block')Главная страница@endsection

@section('content')
    <ul>
        @foreach($data as $el)
        <li style="list-style-type: none"><a href="{{ route('one-lesson', $el->id) }}">{{ $el->title }}</a></li>
        @endforeach
    </ul>
@endsection