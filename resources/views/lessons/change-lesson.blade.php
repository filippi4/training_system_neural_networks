@extends('layouts.app')

@section('title-block')Редактирование урока@endsection

@section('script-src')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
@endsection

@section('content')
<form action="{{ route('save-change-lesson-form', $lesson->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="lesson-title">
            Введите название урока
        </label>
        <input class="form-control" type="text" name="lesson-title" id="lesson-title" placeholder="Название урока" value="{{ $lesson->title }}">
    </div>

    <div class="form-group">
            <span>Выберите теги:</span>
            @foreach($tags as $tag)
            <label for="tag-{{ $tag->id }}">
                {{ $tag->name }}
                <input type="checkbox" name="tags[{{ $tag->id }}]" id="tag-{{ $tag->id }}" class="checkbox-control">
            </label>
            @endforeach
        </div>
    
    <div class="form-group">
        <label for="lesson-content">
            Введите содержание урока
            <textarea class="form-control" name="lesson-content" id="lesson-content-editor" placeholder="Содержание урока" rows=20>
                {{ $lesson->content }}
            </textarea>
        </label>
    </div>

    <button type="submit" class="btn btn-success">Сохранить</button>
</form>
<script>
    <?php
        $tags_id = json_encode($lesson->tags()->get()->map(function ($item) { return $item->id; })->all());
        echo "let tags_id = " . $tags_id . ";\n";
    ?>

     window.addEventListener("load", function(){
        // set checked
        tags_id.forEach(function (id) {
            document.getElementById('tag-' + id).checked = true;
        });
    }, false);

    // CKEditor
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