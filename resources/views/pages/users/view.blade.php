@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <h3 class="text-start mx-2 text-primary">Manage Users</h3>
        <x-alert response="success" color="success"/>
        <x-alert response="error" color="danger"/>
        
        <x-users-table label="Active Users" :datas="$users"/>

        <a href="{{ route('users.create') }}" class="btn btn-success mx-2"><i class="bi bi-person-fill-add p-2"></i> Add User</a>
    </div>
@endsection

@section('js')
@endsection