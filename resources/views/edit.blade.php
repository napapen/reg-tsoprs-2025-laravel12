@extends('layout')

@section('content')
<h1>Edit Regist</h1>
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('update',$register)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ $register->title }}" required>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content" rows="5" required>{{ $register->content }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{ route('index')}}" class="btn btn-secondary">Back</a>
</form>
@endsection