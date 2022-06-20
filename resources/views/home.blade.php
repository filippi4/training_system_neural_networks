<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block')Главная страница@endsection

@section('content')

    @foreach ($tags as $tag)
    @php
    $name = '';
    switch ($tag->name) {
        case 'Урок': $name = 'Уроки'; break;
        case 'Статья': $name = 'Статьи'; break;
        case 'Python': $name = 'Python'; break;
        case 'Датасеты': $name = 'Датасеты'; break;
    }
    @endphp
    <div class="row">
        <div class="col-lg-6">
            <h4>{{ $name }}</h4>
            <ul style="list-style-type:none;">
            @foreach ($tag->lessons()->get() as $lesson)
                <li><a href="{{ route('one-lesson', $lesson->id) }}">{{ $lesson->title }}</a></li>
            @endforeach
            </ul>
        </div>
    </div>
    @endforeach
@endsection