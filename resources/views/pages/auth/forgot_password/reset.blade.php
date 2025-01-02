@extends('layouts.layout')

@section('content')
<div class="row m-0">
    <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center">
        <img src="images/stories/forgot-password.png" alt="login.jpg" class="img-fluid d-none d-sm-inline" style="width: 400px; object-fit: cover;">
        <h4 class="text-primary d-none d-sm-inline">Forgot Password?</h4>
    </div>
    <div class="col-12 col-md-6 p-md-5 my-5 py-5">
        <div class="border rounded bg-white shadow p-3 mx-md-5">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif                
            <form action="{{ route('password.save') }}" method="POST">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
