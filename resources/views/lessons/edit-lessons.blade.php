@extends('layouts.app')

@section('title-block')Редактирование уроков@endsection

@section('content')
@if (isset($message))
    <div class="alert alert-warning">{{ $message }}</div>
@else
    @foreach ($data as $lesson)
        <div class="alert alert-dark">
            <p><h4>{{ $lesson->title }}</h4></p>
            <a class="btn btn-primary" href="{{ route('change-lesson', $lesson->id) }}">Изменить</a>
            <a class="btn btn-danger" href="{{ route('remove-lesson-form', $lesson->id) }}">Удалить</a>
        </div>
    @endforeach
    <hr>
    <p>
        <a class="btn btn-primary" href="{{ route('add-lesson', $lesson->id) }}">Добавить урок</a>
    </p>
@endif
@endsection