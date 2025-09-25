@extends('layouts.login')

@section('content')
    <section class="py-3 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Login</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login.post') }}">
                                @csrf
                                @session('error')
                                <div class="alert alert-danger" role="alert"> 
                                    {{ $value }}
                                </div>
                                @endsession
                                <div>
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                                {{-- <div class="mt-3">
                                    <a href="{{ route('register') }}">Don't have an account? Register here</a>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection