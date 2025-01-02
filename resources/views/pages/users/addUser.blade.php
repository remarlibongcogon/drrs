@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <div class="d-flex flex-row justify-content-between">
            <h3 class="text-start mx-2 text-primary">Add User</h3>
            <a class="btn btn-danger col-2 mb-3 " href="{{ route('users') }}">
                <i class="bi bi-backspace-fill p-2"></i>
                <span class="d-none d-sm-inline">Back</span>
            </a>
        </div>

        <x-alert response="error"/> 
            
        <div class="mx-0 mb-3 p-0">
            <form method="post" action="{{ route('users.add') }}" class="needs-validation" novalidate>
                @csrf
                <div class="border container bg-white rounded row mx-0 p-3">
                    <h4 class="py-2 text-primary text-start">User Information</h4>

                    <x-input name="firstname"   label="First Name" type="text"/>
                    <x-input name="lastname" label="Last Name" type="text"/>

                    <x-input name="username" label="Username" type="text" required="true"/>
                    <div class="col-6 d-none d-sm-inline"></div>
                    <x-input name="emailaddress" label="Email" type="email" required="true"/>            
                    <x-select name="role" label="Role" :options="$roles" required="true"/>

                    <x-input name="password" label="Temporary Password" type="text" value="{{$generated_password}}" readOnly="true"/>
                    {{-- <x-input name="password_confirmation" label="Confirm Password" type="password"/> --}}


                    <div class="d-flex justify-content-end">   
                        <button type="submit" class="btn btn-success mx-2"><i class="bi bi-person-fill-add p-2"></i> Add User</button>
                    </div> 
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/formValidation.js') }}"></script>
@endsection