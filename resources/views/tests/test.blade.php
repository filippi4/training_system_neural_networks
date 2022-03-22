@extends('layouts.app')

@section('title-block')Тест@endsection

@section('content')
@foreach ($data as $id => $value)
<p>
<h3>{{ $value['title'] }}</h3>
    @foreach ($value['answers'] as $index => $answer)
    <label for="answer-{{ $id . '-' . $index}}">{{ $answer }}</label>
    <input type="radio" name="question-{{ $id }}" id="answer-{{ $id . '-' . $index}}" value="{{ $id . '-' . $index}}">
    <br>
    @endforeach
</p>
@endforeach
<button class="btn btn-primary" type="submit">Проверить</button>
@endsection