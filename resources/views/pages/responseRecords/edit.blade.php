@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <div class="d-flex flex-row justify-content-between">
            <h3 class="text-start mx-2 text-primary">Edit Response Record</h3>
            <a class="btn btn-danger col-2 mb-3 " href="{{ route('response_records.index') }}">
                <i class="bi bi-backspace-fill p-2"></i>
                <span class="d-none d-sm-inline">Back</span>
            </a>
        </div>
        <div class="mx-2 mb-3 p-2">
            <form method="post" action="{{ route('response_records.update', ['id' => $record->responseID]) }}" class="needs-validation" novalidate>
                @csrf
                <div class="border container bg-white rounded row mx-2 px-3 pt-5 pb-2">
                    <h4 class="py-2 text-primary text-start">Response Details</h4>
                    <x-input name="date" label="Date" type="date" value="{{ $record->date }}"/>
                    <x-input name="time" label="Time" type="time" value="{{ $record->time }}"/>
                    
                    <x-input name="incidentFrom" label="Incident From" type="text" value="{{ $record->incidentFrom }}"/>
                    <x-input name="takenTo" label="Taken To" type="text" value="{{ $record->takenTo }}"/>

                    <x-input name="callerOrReporter" label="Reporter" type="text" value="{{ $record->callerOrReporter }}"/>
                    <x-input name="patientName" label="Patient" type="text" value="{{ $record->patientName }}"/>
                    <x-input name="patientAge" label="Age" type="number" value="{{ $record->patientAge }}"/>
                    <x-select name="patientGender" label="Gender" :options="$genders" required="true" value="{{ $record->patientGender }}"/>  
                    
                    <x-input name="patientAddress" label="Address" type="text" value="{{ $record->patientAddress }}"/>
                    <x-select name="patientCase" label="Case" :options="$cases" required="true" value="{{ $record->patientCase }}"/> 

                    <x-input name="responders" label="Responders" type="text" value="{{ $record->responders }}"/>
                    <x-input name="actionTaken" label="Action Taken" type="text" value="{{ $record->actionTaken }}"/>

                    <x-textarea label="Remarks" name="remarks" value="{{ $record->remarks }}"/>

                    <div class="d-flex justify-content-end">   
                        <button type="submit" class="btn btn-success mx-2"><i class="bi bi-file-earmark-plus-fill p-2"></i>     Save Changes
                        </button>
                    </div> 
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection