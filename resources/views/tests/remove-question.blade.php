@extends('layouts.app')

@section('title-block')Удаление вопроса@endsection

@section('content')
@if (isset($message))
<div class="alert alert-warning">{{ $message }}</div>
    @else
    <table class="table">
        @php $number = 1 @endphp
        @foreach ($data as $id => $title)
        <form action="{{ route('remove-edit-test-form', $id) }}" method="post">
            @csrf
            <tr>
                <td>{{ $number++ }}. {{ $title }}</td>
                <td><button class="btn btn-success" type="submit">Удалить</button></td>
            </tr>
        </form>
        @endforeach
    </table>
@endif
@endsection