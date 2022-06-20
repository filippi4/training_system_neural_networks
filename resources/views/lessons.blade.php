<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block')Уроки@endsection

@section('content')
@foreach ($lessons as $lesson)
<div class="alert alert-dark">
    <p><h4>{{ $lesson->title }}</h4></p>
    <a class="btn btn-dark" href="{{ route('one-lesson', $lesson->id) }}">Читать</a>
</div>
@endforeach
@endsection