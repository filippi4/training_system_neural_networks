@extends('layouts.app')

@section('content')
    <h3>{{ $lesson->title }}</h3>
    <p>Теги: 
    @php
    $tags_name = [];
    foreach ($lesson->tags()->get() as $tag) {
        $tags_name[] = $tag->name;
    }
    echo implode(', ', $tags_name);
    @endphp
    </p>
    <p>
        {!! $lesson->content !!}
    </p>
@endsection