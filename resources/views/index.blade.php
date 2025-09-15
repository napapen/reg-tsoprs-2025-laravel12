@extends('layout')

@section('content')
    <h1>All Regist</h1>
    <a href="{{ route('create')}}" class="btn btn-primary mb-3">+ Create New Regist</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($register->isEmpty())
        <p>No regist found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($register as $regist)
                    <tr>
                        <td>{{ $regist->id }}</td>
                        <td>{{ $regist->title }}</td>
                        <td>{{ Str::limit($regist->content,80) }}</td>
                        <td>
                            <a href="{{ route('show',$regist)}}" class="btn btn-sm btn-secondary">View</a>
                            <a href="{{ route('edit',$regist)}}" class="btn btn-sm btn-warning">Edit</a> 
                            <form action="{{ route('delete',$regist)}}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form> 
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>    
    @endif
@endsection