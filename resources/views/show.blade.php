@extends('layout')

@section('content')

    <h1>{{ $register->title}}</h1>
    <p>{{ $register->content}}</p>
    <a href="{{ route('index')}}" class="btn btn-secondary">Back to All Regist</a>

@endsection