@extends('layouts.app')

@section('title', 'Onsite Registration')

@section('content')
    <h2>ลงทะเบียน Onsite</h2>
    <form method="POST" enctype="multipart/form-data" action="{{ route('onsite.store') }}">
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