@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <h3 class="text-start mx-2 text-primary">Add Response Record</h3>
        @if(session('error'))
            <x-alert response="error" color="danger"/>
        @elseif(session('success'))
            <x-alert response="success" color="success"/>
        @endif
        <div class="mx-2 mb-3 p-2">
            <form method="post" action="{{ route('response_records.store') }}" class="needs-validation" novalidate>
                @csrf
                
                <div class="border container bg-white rounded row mx-2 px-3 pt-5 pb-2">
                    <h4 class="py-2 text-primary text-start">Response Details</h4>
      
                    <x-input name="date" label="Date" type="date" value="{{ date('Y-m-d', strtotime(isset($data->date))) ?? '' }}"/>
                    <x-input name="time" label="Time" type="time" value="{{ date('H:i', strtotime(isset($data->time))) ?? ''}}"/>

                    <x-input name="incidentFrom" label="Incident From" type="text" required="true"/>
                    <x-input name="takenTo" label="Taken To" type="text" required="true"/>

                    <x-input name="callerOrReporter" label="Reporter" type="text" value="{{ $data->reporterFullName ?? '' }}"/>
                    <x-input name="patientName" label="Patient" type="text" value="{{ $data->obstetrics->fullName ?? '' }}"/>
                    <x-input name="patientAge" label="Age" type="number" value="{{ $data->obstetrics->age ?? '' }}"/>
                    <x-select name="patientGender" label="Gender" :options="$genders" required="true"/>  
                    
                    <x-input name="patientAddress" label="Address" type="text"/>
                    <x-select name="patientCase" label="Case" :options="$cases"/> 

                    <x-input name="responders" label="Responders" type="text" />
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