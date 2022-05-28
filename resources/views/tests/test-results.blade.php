@extends('layouts.app')

@section('title-block')Тест@endsection

@section('content')
    <h3>Результаты теста<h3>
    <table class="table">
        <thead>
            <th>Номер вопроса</th>
            <th>Правильность</th>
        </thead>
        <tbody>
            @php $number = 1 @endphp
            @foreach($data as $key => $value)
            <tr>
                <td>{{ $number++ }}</td>
                @if ($value == true)
                <td class="table-success">Да</td>
                @else
                <td class="table-danger">Нет</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @if (Session::has('loginId'))
    <p><a style="font-size: 0.8em" href="{{ route('user-test-results') }}">Посмотреть все результаты тестирования</a></p>
    @endif
@endsection