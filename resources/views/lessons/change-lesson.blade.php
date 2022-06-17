@extends('layouts.app')

@section('title-block')Редактирование урока@endsection

@section('script-src')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
@endsection

@section('content')
<form action="{{ route('save-change-lesson-form', $data->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="lesson-title">Введите название урока</label>
        <input class="form-control" type="text" name="lesson-title" id="lesson-title" placeholder="Название урока" value="{{ $data->title }}">
    </div>
    
    <div class="form-group">
        <label for="lesson-content">Введите содержание урока</label>
        <textarea class="form-control" name="lesson-content" id="lesson-content-editor" placeholder="Содержание урока" rows=20>
            {{ $data->content }}
        </textarea>
    </div>

    <button type="submit" class="btn btn-success">Сохранить</button>
</form>
<script>
    let editor;

        ClassicEditor
            .create( document.querySelector( '#lesson-content-editor' ) )
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            } );
</script>
@endsection