@extends('layouts.app')

@section('title-block')Тест@endsection

@section('content')
    <h3>Результаты теста<h3>
    <table class="table">
        <thead>
            <th>Название теста</th>
            <th>Количество попыток</th>
            <th>Правильных/всего ответов</th>
            <th>Оценка</th>
            <th>Время</th>
        </thead>
        <tbody>
            <tr>
                <td>{{ $test_result->test()->get()->first()->name }}</td>
                <td>{{ $test_result->tries }}</td>
                <td>{{ $test_result->amount_right_questions }}/{{ $test_result->test()->get()->first()->amount_questions }}</td>
                <td>{{ $test_result->score }}</td>
                <td>{{ $test_result->updated_at }}</td>
            </tr>
        </tbody>
    </table>
@endsection