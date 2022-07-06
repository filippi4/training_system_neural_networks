@extends('layouts.app')

@section('title-block')Редактирование теста@endsection

@section('content')
    @foreach ($tests as $test)
        <div class="alert alert-secondary">
            <p><h4>{{ $test->name }}</h4></p>
            <a class="btn btn-primary" href="{{ route('change-test', ['test' => $test->id]) }}">Изменить</a>
            <a class="btn btn-danger" href="{{ route('delete-test-form', ['test' => $test->id]) }}">Удалить</a>
        </div>
    @endforeach
    <hr>
    <p><a class="btn btn-primary" href="{{ route('add-test') }}">Добавить тест</a></p>
@endsection