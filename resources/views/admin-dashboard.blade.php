@extends('layouts.app')

@section('title-block')Страница администратора@endsection

@section('content')
    <h2>Административная панель</h2>
    <br>
    <h3>Добавление урока</h3>
    <form action="{{ route('add-lesson-form') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="lesson-title">Введите название урока</label>
            <input type="text" name="lesson-title" placeholder="Название урока" id="lesson-title" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="lesson-content">Введите содержание урока</label>
            <textarea name="lesson-content" placeholder="Содержание урока" id="lesson-content" class="form-control" rows=20></textarea>
        </div>

        <div class="form-group">
            <label for="syntax-type-html">html</label>
            <input type="radio" name="syntax-type" id="syntax-type-html" value="html" checked>
            <label for="syntax-type-markdown">Markdown</label>
            <input type="radio" name="syntax-type" id="syntax-type-markdown" value="markdown">
        </div>

        <button type="submit" class="btn btn-success">Отправить</button>
    </form>
@endsection