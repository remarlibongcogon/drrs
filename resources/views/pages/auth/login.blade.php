@extends('layouts.layout')

@section('content')
    <div class="row m-0 w-100 h-100">
        <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center d-none d-sm-inline">
            <img src="images/stories/login.png" alt="login.jpg" class="img-fluid" style="width: 400px; object-fit: cover;">
            <h4 class="text-primary">Disaster Respose and Recovery on your hands!</h4>
        </div>
        <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center">
            <div class="w-75 mb-2">
                <h1><code class="text-primary">Welcome to DRRS</code></h1>
            </div>
            <div class="border rounded bg-white w-75 shadow p-3 mx-md-5">     
                <x-alert response="error" color="danger"/>
                <x-alert response="success" color="success"/>
                
                <form method="post" action="{{ route('login') }}" class="needs-validation" novalidate>
                    @csrf               
                    <x-floating-input type="text" name="username" label="Username"/>
                    <x-floating-input type="password" name="password" label="Password"/>

                       <!-- Forgot Password and Show Password -->
                        <div class="text-primary text-start mb-2">
                            <input type="checkbox" class="form-check-input" id="showPassword" name="showPassword" value="1">
                            <label for="showPassword" class="ms-2">Show Password</label>
                        </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-lg btn-outline-primary">Login</button>
                    </div>
                    <div class="mt-2">
                        <small>
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">Forgot Password?</a>
                        </small>
                    </div>  
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Import password toggle js -->
    <script src="{{ asset('js/togglePassword.js') }}"></script>
@endsection