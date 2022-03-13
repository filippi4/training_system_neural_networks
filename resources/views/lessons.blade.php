<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block')Уроки@endsection

@section('content')
    @foreach($data as $el)
        <div class="alert alert-info">
            <h4>{{ $el->title }}</h4>
            <p class="d-inline-block text-truncate" style="max-width: 100%;">{{ $el->content }}</p>
            <p><small>{{ $el->created_at }}</small></p>
        </div>
    @endforeach
@endsection