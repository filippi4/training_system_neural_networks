@extends('layouts.app')

@section('content')
    <h3>{{ $data['lesson']->title }}</h3>
    <br>
    <p>
        {!! $data['lesson']->content !!}
    </p>
    @if (Session::has('loginId'))
    <form action="{{ route('delivered-lesson', $data['lesson']->id)}}" method="post">
        @csrf
        <input type="hidden" name="lesson-id" value="{{ $data['lesson']->id }}">
        <p>
            @if (!$data['delivered'])
            <button class="btn btn-primary" id="btn-delivered" name="delivered">Прочитано</button></p>
            @else
            <button class="btn btn-primary" id="btn-delivered" name="delivered" disabled>Прочитано</button></p>
            @endif
    </form>
    @endif
@endsection