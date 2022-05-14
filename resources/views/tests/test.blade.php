@extends('layouts.app')

@section('title-block')Тест@endsection

@section('content')
<form action="{{ route('check-test-form') }}" method="post">
    @csrf
    @foreach ($data as $id => $value)
    <p>
    <h3>{{ $id .'. '. $value['title'] }}</h3>
        @foreach ($value['answers'] as $index => $answer)
        <label for="answer-{{ $id . '-' . $index}}">{{ $index+1 .') '. $answer }}</label>
        <input type="radio" name="question-{{ $id }}" id="answer-{{ $id . '-' . $index}}" value="{{ $index }}">
        <br>
        @endforeach
    </p>
    @endforeach
    <button class="btn btn-primary" type="submit">Проверить</button>
</form>
@endsection