@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h2>เลือกประเภทการเข้าร่วม</h2>
    <ul>
        <li><a href="{{ route('onsite.form') }}">Onsite</a></li>
        <li><a href="{{ route('online.form') }}">Online</a></li>
        <li><a href="{{ route('workshop.form') }}">Workshop</a></li>
    </ul>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
@endsection