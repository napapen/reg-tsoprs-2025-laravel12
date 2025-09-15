@extends('layouts.app')

@section('title', 'Online Registration')

@section('content')
    <h1>ลงทะเบียน Online</h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('online.store') }}">
        @csrf
        <label>Full Name*</label>
        <input type="text" name="full_name" required><br><br>

        <label>Email*</label>
        <input type="email" name="email" required><br><br>

        <label>Mobile/WhatsApp/LINE</label>
        <input type="text" name="mobile"><br><br>

        <label>Upload Photo</label>
        <input type="file" name="photo"><br><br>

        <button type="submit">Register</button>
    </form>
@endsection
