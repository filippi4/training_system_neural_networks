@extends('layouts.app')

@section('title-block')Тест@endsection

@section('content')
<form action="{{ route('check-test-form') }}" method="post">
    @csrf
    @php $number = 1 @endphp
    @foreach ($data as $title => $answers)
    <p>
    <h3>{{ $number .'. '. $title }}</h3>
        @foreach ($answers as $index => $answer)
        <label for="answer-{{ $number . '-' . $index }}">{{ $index+1 .') '. $answer }}</label>
        <input type="radio" name="question-{{ $number }}" id="answer-{{ $number . '-' . $index }}" value="{{ $index }}">
        <br>
        @endforeach
    </p>
    @php $number++ @endphp
    @endforeach
    <button class="btn btn-primary" type="submit">Проверить</button>
</form>
@endsection