@extends('layouts.app')

@section('content')
    <h3>{{ $data->title }}</h3>
    <br>
    <p>
        {!! $data->content !!}
    </p>
@endsection