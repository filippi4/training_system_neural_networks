<!-- Домашняя страница -->
@extends('layouts.app')

@section('title-block'){{ $data['definition'] }}@endsection

@section('content')
<h4>{{ $data['definition'] }}</h4>
<p>{{ $data['description'] }}</p>
@endsection