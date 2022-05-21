@extends('layouts.app')

@section('title-block')Редактирование теста@endsection

@section('content')
@if (isset($message))
<div class="alert alert-warning">{{ $message }}</div>
@else
<p>
    <a class="btn btn-primary" href="{{ route('add-edit-test') }}">Добавить</a>
    <a class="btn btn-primary" href="{{ route('remove-edit-test') }}">Удалить</a>
</p>
<form action="{{ route('change-test-form') }}" method="post">
    @csrf
    @foreach ($data as $id => $value)
    <textarea name="question-{{ $id }}" cols="60" rows="1">
        {{ $value['title'] }}
    </textarea>
        @foreach ($value['answers'] as $index => $answer)
        <textarea name="answer-{{ $id . '-' . $index}}" cols="40" rows="1">
            {{ $answer }}
        </textarea>
        @endforeach
    @endforeach
    <br>
    <button class="btn btn-success" type="submit">Сохранить</button>
@endif
@endsection