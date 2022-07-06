@extends('layouts.app')

@section('title-block')Тест@endsection

@section('content')
<form action="{{ route('check-test-form', ['test' => $test->id]) }}" method="post">
    @csrf
    @foreach ($test->questions()->get() as $question_index => $question)
    <p>
        <h3>{{ $question_index+1 }}. {{ $question->description }}</h3>
        <div class="form-check">
        @foreach ($question->answers()->get() as $answer_index => $answer)
            <input class="form-check-input" type="checkbox" 
                   name="question_{{ $question->id }}-answer_{{ $answer->id }}" 
                   id="question_{{ $question->id }}-answer_{{ $answer->id }}">
            <label class="form-check-label" for="question_{{ $question->id }}-answer_{{ $answer->id }}">
                {{ $answer_index+1 }}) {{ $answer->text }}
            </label>
            <br>
        @endforeach
        </div>
    </p>
    @endforeach
    <button class="btn btn-primary" type="submit">Проверить</button>
</form>
@endsection