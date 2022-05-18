@extends('layouts.app')

@section('title-block')Результаты тестирования@endsection

@section('content')
@if (isset($message))
<div class="alert alert-warning">{{ $message }}</div>
@else
    <h3>Результаты тестирования<h3>
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <th>Время тестирования</th>
            <th colspan="10">Результаты</th>
        </thead>
        <thead>
            <th></th>
            @for ($i = 1; $i <= $data['count']; $i++)
            <th>{{ $i }}</th>
            @endfor
        </thead>
        <tbody>
            @foreach ($data['results'] as $date => $result)
            <tr>
                <td>{{ $date }}</td>
                @foreach ($result as $r)
                @if ($r == "1")
                <td class="table-success">
                @elseif ($r == "0")
                <td class="table-danger">
                @endif
                    {{ $r }}
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    @endif
@endsection