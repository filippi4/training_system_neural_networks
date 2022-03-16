@extends('layouts.app')

@section('title-block')Dashboard@endsection

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h4>Dashboard</h4>
        <hr>
        @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
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
                    <td><a href="{{ route('logout-user') }}">Logout</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection