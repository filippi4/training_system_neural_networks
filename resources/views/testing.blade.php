@extends('layouts.app')

@section('title-block')Тестирование@endsection

@section('content')
    <h3>Тесты для проверки полученных знаний</h3>
    <br>
    @foreach ($tests as $test)
    <p>
        <a  class="btn btn-success" href="{{ route('test', ['test' => $test->id]) }}">
            {{ $test->name }}
        </a>
    </p>
    @endforeach
@endsection