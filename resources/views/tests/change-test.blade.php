@extends('layouts.app')

@section('title-block')Редактирование теста@endsection

@section('content')
    @foreach ($test->questions()->get() as $question)
        <div class="alert alert-secondary">
            <p><h4>{{ $question->description }}</h4></p>
            <a class="btn btn-primary" href="{{ route('change-question', ['question' => $question->id]) }}">Изменить</a>
            <a class="btn btn-danger" href="{{ route('delete-edit-test-form', $question->id) }}">Удалить</a>
        </div>
    @endforeach
    <hr>
    <p><a class="btn btn-primary" href="{{ route('add-question') }}">Добавить вопрос</a></p>
@endsection