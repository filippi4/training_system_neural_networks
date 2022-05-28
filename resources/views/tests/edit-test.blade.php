@extends('layouts.app')

@section('title-block')Редактирование теста@endsection

@section('content')
@if (isset($message))
    <div class="alert alert-warning">{{ $message }}</div>
@else
    @foreach ($data as $id => $value)
        <div class="alert alert-secondary">
            <p><h4>{{ $value['title']}}</h4></p>
            <a class="btn btn-primary" href="{{ route('change-question', $id) }}">Изменить</a>
            <a class="btn btn-danger" href="{{ route('remove-edit-test-form', $id) }}">Удалить</a>
            <button style="float: right; background-color: #b60aff" class="btn btn-secondary" disabled>
            @if ($value['type'] == "theor")
            Теоретический
            @elseif ($value['type'] == "math")
            Математический
            @endif
            </button>
        </div>
    @endforeach
    <hr>
    <p>
        <a class="btn btn-primary" href="{{ route('add-edit-test') }}">Добавить вопрос</a>
    </p>
@endif
@endsection