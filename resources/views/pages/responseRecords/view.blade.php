@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        
        <h3 class="text-start mx-2 text-primary">Response Records</h3>
        @if(session('error'))
            <x-alert response="error" color="danger"/>
        @elseif(session('success'))
            <x-alert response="success" color="success"/>
        @endif
        <x-responses-table label="Response History" :datas="$responseRecords"/>

        {{-- <a href="{{ route('response_records.create') }}" class="btn btn-success mx-2"><i class="bi bi-file-earmark-plus-fill p-2"></i> Create Response Record</a> --}}
    </div>
@endsection

@section('js')
@endsection