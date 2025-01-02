@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <div class="d-flex flex-row justify-content-between">
            <h3 class="text-start mx-2 text-primary">Add Response Record</h3>
            <a class="btn btn-danger col-2 mb-3 " href="{{ route('response_records.index') }}">
                <i class="bi bi-backspace-fill p-2"></i>
                <span class="d-none d-sm-inline">Back</span>
            </a>
        </div>
        <x-alert response="error" color="danger"/>
        <div class="mx-2 mb-3 p-2">
            <form method="post" action="{{ route('response_records.store') }}" class="needs-validation" novalidate>
                @csrf
                
                <div class="border container bg-white rounded row mx-2 px-3 pt-5 pb-2">
                    <h4 class="py-2 text-primary text-start">Response Details</h4>
      
                    <x-input name="date" label="Date" type="date" value="{{ now()->toDateString() }}"/>
                    <x-input name="time" label="Time" type="time" value="{{ now()->format('H:i')}}"/>

                    <x-input name="incidentFrom" label="Incident From" type="text" required="true"/>
                    <x-input name="takenTo" label="Taken To" type="text" required="true"/>

                    <x-input name="callerOrReporter" label="Reporter" type="text"/>
                    <x-input name="patientName" label="Patient" type="text" value="{{ $data->patientName ?? '' }}"/>
                    <x-input name="patientAge" label="Age" type="number" value="{{ $data->patientAge ?? '' }}"/>
                    <x-select name="patientGender" label="Gender" :options="$genders" required="true" value="{{ $data->patientGender ?? '' }}"/>  
                    
                    <x-input name="patientAddress" label="Address" type="text" value="{{ $data->patientAddress ?? ''}}"/>
                    <x-select name="patientCase" label="Case" :options="$cases" required="true" value="{{ $data->case ?? ''}}"/> 

                    <x-input name="responders" label="Responders" type="text"  value="{{ isset($data->recorded_by) ? $data->recorded_by->firstname . ' ' . $data->recorded_by->lastname : '' }}"/>
                    <x-input name="actionTaken" label="Action Taken" type="text"/>

                    <x-textarea label="Remarks" name="remarks"/>
                    <div class="d-flex justify-content-end">   
                        <button type="submit" class="btn btn-success mx-2"><i class="bi bi-file-earmark-plus-fill p-2"></i>     Create Response Record
                        </button>
                    </div> 
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/formValidation.js') }}"></script>
@endsection