@extends('layouts.app')

@section('title-block')Вход@endsection

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h4>Вход</h4>
        <hr>
        <form action="{{ route('login-user') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Введите email">
                <span class="text-danger">@error('email'){{ $message }}@enderror</span>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" value="" placeholder="Введите пароль">
                <span class="text-danger">@error('password'){{ $message }}@enderror</span>
            </div>
            <button type="submit" class="btn btn-block btn-primary">Войти</button>
            <br>
            <a href="{{ route('registration') }}">Зарегистрировать аккаунт</a>
        </form>
    </div>
</div>
@endsection