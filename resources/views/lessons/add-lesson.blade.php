@extends('layouts.app')

@section('title-block')Добавление урока@endsection

@section('script-src')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
@endsection

@section('content')
    <form action="{{ route('add-lesson-form') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="lesson-title">Введите название урока</label>
            <input type="text" name="lesson-title" placeholder="Название урока" id="lesson-title" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="lesson-content-editor">Введите содержание урока</label>
            <textarea name="lesson-content" placeholder="Содержание урока" id="lesson-content-editor" class="form-control" rows=20></textarea>
        </div>

        <button type="submit" id="btn-submit" class="btn btn-success">Добавить</button>
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

        // // Assuming there is a <button id="submit">Submit</button> in your application.
        // document.querySelector( '#btn-submit' ).addEventListener( 'click', () => {
        //     lesson_content_json = document.getElementById( 'lesson-content-json' ).value = JSON.stringify(editor);
        //     alert(lesson_content_json);

        //     // ...
        // } );
    </script>
@endsection