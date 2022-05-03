<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block')Уроки@endsection

@section('content')

<div class="row  row-cols-1">
    @foreach ($data as $el)
    <div class="col">
        <div class="card text-dark bg-light mb-3">
            <div class="card-header">Урок № {{$el->id }}</div>
            <div class="card-body">
                <h5 class="card-title">{{ $el->title }}</h5>
                <p class="card-text"></p>
                <a href="{{ route('one-lesson', $el->id) }}" class="btn btn-outline-secondary">Читать</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection