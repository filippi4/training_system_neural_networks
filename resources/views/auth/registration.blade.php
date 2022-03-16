@extends('layouts.app')

@section('title-block')Регистрация@endsection

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h4>Регистрация</h4>
        <hr>
        @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <form action="{{ route('register-user') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Введите имя">
                <span class="text-danger">@error('name'){{ $message }}@enderror</span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Введите email">
                <span class="text-danger">@error('email'){{ $message }}@enderror</span>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль">
                <span class="text-danger">@error('password'){{ $message }}@enderror</span>
            </div>
            <button type="submit" class="btn btn-block btn-primary">Зарегистрироваться</button>
            <br>
            <a href="{{ route('login') }}">Уже есть аккаунт? Войти</a>
        </form>
    </div>
</div>
@endsection