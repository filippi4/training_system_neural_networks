@extends('layouts.app')

@section('title-block')Добавление урока@endsection

@section('content')
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
            <label for="content-type-html">html</label>
            <input type="radio" name="content-type" id="content-type-html" value="html" checked>
            <label for="content-type-markdown">Markdown</label>
            <input type="radio" name="content-type" id="content-type-markdown" value="markdown">
        </div>

        <button type="submit" class="btn btn-success">Добавить</button>
    </form>
@endsection