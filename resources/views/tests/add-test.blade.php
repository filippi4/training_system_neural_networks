@extends('layouts.app')

@section('title-block')Добавление теста@endsection

@section('content')
<form action="{{ route('add-test-form') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="name">
            Введите название теста
            <input type="text" name="name" id="name" class="form-control">
        </label>
    </div>
    <br>
    <button class="btn btn-primary" type="submit">Добавить тест</button>
</form>
@endsection