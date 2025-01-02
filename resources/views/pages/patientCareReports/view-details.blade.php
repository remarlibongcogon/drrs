@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <div class="d-flex flex-row justify-content-between">
            <h3 class="text-start mx-2 text-primary">Patient Care Report</h3>
            <a class="btn btn-danger col-2 mb-3 " href="{{ route('patient_care.index') }}">
                <i class="bi bi-backspace-fill p-2"></i>
                <span class="d-none d-sm-inline">Back</span>
            </a>
        </div>

        <!-- Display success or error message -->
        <x-alert response="error"/>
        <div class="container bg-white rounded mx-2  py-2 row">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="text-start mx-2 text-primary pt-3">Patient Care Report Details</h4>
                <a class="btn btn-success col-2 col-md-2 mb-3 " href="{{ route('response_records.patient_care.create', ['id' => $patientCare->patientCareID]) }}">
                    <i class="bi bi-file-earmark-plus-fill p-2"></i>
                    <span class="d-none d-sm-inline">Add Response</span>
                </a>
            </div>    
            <x-input name="patientName" value="{{ $patientCare->patientName }}" label="Patient Name" type="text" mdSize="12" readOnly="true"/>

            <x-input name="patientAge" value="{{ $patientCare->patientAge }}" label="Age" type="text" mdSize="2" readOnly="true"/>
            <x-select name="patientGender" value="{{ $patientCare->patientGender }}" label="Gender" :options="$genders" readOnly="true" sizeMd="4"/>
            <x-input name="patientAddress" value="{{ $patientCare->patientAddress }}" label="Patient Address" type="text" mdSize="6" readOnly="true"/> 

            <x-input name="patientContactPerson" value="{{ $patientCare->patientContactPerson }}" label="Contact Person" type="text" mdSize="6" readOnly="true"/>
            <x-input name="contactNumber" value="{{ $patientCare->contactNumber }}" label="Contact Number" type="number" mdSize="6" readOnly="true"/>
                    
            <x-input name="incidentPlace" value="{{ $patientCare->incidentPlace }}" label="Place of Incident" type="text" mdSize="6" required="true" readOnly="true"/>
            <x-input name="incidentDate" value="{{ $patientCare->incidentDate }}" label="Date of Incident" type="date" mdSize="4" required="true" readOnly="true"/>
            <x-input name="incidentTime" value="{{ $patientCare->incidentTime }}" label="Time of Incident" type="time" mdSize="2" readOnly="true"/>

            <x-select name="case" value="{{ $patientCare->case }}" label="Case" :options="$cases" required="true" readOnly="true"/>
            <div class="d-none d-sm-inline col-6"></div>

            <div class="text-start text-primary">
                <div class="row px-2">
                <x-checkbox-readonly label="Alertness" :datas="$alertnessFields" namePrefix="alertness" :consciousnessStatus="$consciousnessStatus"/>
                <x-input-group-readonly label="Sample History" :datas="$sampleFields" namePrefix="sample" :fieldValues="$sampleData" readOnly="true"/>
                </div>
            </div>

            <div class="text-start text-primary">
                <div class="row px-2">
                <x-input-group-readonly label="Pain Assessment" :datas="$painAssessmentFields" namePrefix="painAssessment" :fieldValues="$painAssessmentData" readOnly="true"/>
                <x-radio-hybrid label="Injury Type" :datas="$injuryTypeFields" :fieldValues="$injuryTypeData" name="injury_type" readOnly="true"/> 
                </div>
            </div> 

            <div class="text-start text-primary">
                <div class="row px-2">
                    <x-checkbox-readonly label="DCAP - BTLS" :datas="$dcapbtlsFields" namePrefix="dcapbtls" :consciousnessStatus="$dcapbtlsData"/>
                    <x-bfast label="Spot Stroke" :datas="$spotStrokeFields" :bfastValues="$spotStrokeData" namePrefix="spotStroke" readOnly="true"/>    
                </div>
            </div>

            <div class="text-start text-primary" id="injury">
                <div class="row px-2">
                <x-input-group-readonly label="Vital Signs" :datas="$vitalsFields" namePrefix="vitals" :fieldValues="$vitalsData" readOnly="true"/>
                    <div class="col-12 col-md-6 mb-2 pt-4">
                        <x-input name="others" label="Others" type="text" value="{{ $patientCare->others }}" mdSize="12" readOnly="true"/>
                        <x-input name="responder" label="Responder/s" value="{{ $patientCare->recordedBy }}" type="text" mdSize="12" readOnly="true"/>
                        <x-input name="recievedBy" label="Recieved By" type="text" value="{{ $patientCare->recievedBy }}" mdSize=12 readOnly="true"/>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end row m-0">   
                <a target="_blank" type="submit" class="btn btn-primary col-12 col-sm-2" href="{{ route('patient_care.download', $patientCare->patientCareID) }}">
                    <i class="bi bi-download px-2"></i>
                    Download
                </a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/formValidation.js') }}"></script>
@endsection
