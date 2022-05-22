@extends('layouts.app')

@section('title-block')Редактирование урока@endsection

@section('content')
<form action="{{ route('save-change-lesson-form', $data->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="lesson-title">Введите название урока</label>
        <input class="form-control" type="text" name="lesson-title" id="lesson-title" placeholder="Название урока" value="{{ $data->title }}">
    </div>
    
    <div class="form-group">
        <label for="lesson-content">Введите содержание урока</label>
        <textarea class="form-control" name="lesson-content" id="lesson-content" placeholder="Содержание урока" rows=20>{{ $data->content }}</textarea>
    </div>

    <div class="form-group">
        <label for="content-type-html">html</label>
        <input type="radio" name="content-type" id="content-type-html" value="html" checked>
        <label for="content-type-markdown">Markdown</label>
        <input type="radio" name="content-type" id="content-type-markdown" value="markdown">
    </div>

    <button type="submit" class="btn btn-success">Сохранить</button>
</form>
<script>
    var content_type = "<?php echo $data->content_type; ?>";
    window.addEventListener("load", function(){
        if (content_type == "html") {
            document.getElementById("content-type-html").checked = true;
            document.getElementById("content-type-markdown").checked = false;

        } else if (content_type == "markdown") {
            document.getElementById("content-type-markdown").checked = true;
            document.getElementById("content-type-html").checked = false;
        }
    }, false);
</script>
@endsection