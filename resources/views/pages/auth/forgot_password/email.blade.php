@extends('layouts.layout')

@section('content')
<div class="row m-0">
    <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center">
        <img src="images/stories/forgot-password.png" alt="login.jpg" class="img-fluid d-none d-sm-inline" style="width: 400px; object-fit: cover;">
        <h4 class="text-primary d-none d-sm-inline">Forgot Password?</h4>
    </div>
    <div class="col-12 col-md-6 p-md-5 my-5 py-5">
        <div class="border rounded bg-white shadow p-3 mx-md-5">          
            @if(session('error'))
                <x-alert response="error" color="danger"/>
            @elseif(session('success'))
                <x-alert response="success" color="success"/>
            @endif
            
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-3 row m-0 text-primary">  
                    <label for="email" class="form-label text-start">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
            </form>
        </div>
    </div>
</div>

@endsection
