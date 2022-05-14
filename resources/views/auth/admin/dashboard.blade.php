@extends('layouts.app')

@section('title-block')
    Панель управления администратора
@endsection

@section('content')
<div class="row">
    <div class="col-md-5 col-md-offset-4">
        <h4>Панель управления администратора</h4>
        <hr>
        <table class="table">
            <thead>
                <th>Имя</th>
                <th>Email</th>
                <th>Действие</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                    <td><a href="{{ route('admin-dashboard') }}">Панель управления</a></td>
                    <td><a href="{{ route('edit-test') }}">Редактировать тест</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection