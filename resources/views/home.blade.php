<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block')Главная страница@endsection

@section('content')
    @if (Session::has('loginId'))
    <h4>Список уроков, галочкой отмечены прочитанные уроки:</h4>
    @else
    <h4>Список уроков:</h4>
    @endif
    <ul>
        @foreach($data as $el)
        <li style="list-style-type: none; font-size: 1.5em">
            <a class="link-dark" href="{{ route('one-lesson', $el['id']) }}">{{ $el['title'] }}</a>
            @if ($el['delivered'] ?? '')
            &#10004;
            @endif
        </li>
        @endforeach
    </ul>
@endsection