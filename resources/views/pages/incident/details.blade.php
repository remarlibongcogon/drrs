@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <div class="d-flex flex-row justify-content-between">
            <h3 class="text-start mx-2 text-primary">Incident Report Details</h3>
            <a class="btn btn-danger col-4 col-md-2 mb-3 " href="{{ route('incident_report.show_all')}}">
                <i class="bi bi-backspace-fill p-2"></i>
                Back
            </a>
        </div>
        
        @if(session('error'))
            <x-alert response="error" color="danger"/>
        @elseif(session('success'))
            <x-alert response="success" color="success"/>
        @endif

        <div class="mx-2 mb-3 p-2">
            <form method="post" action="" class="needs-validation" novalidate>
                @csrf
                <div class="border container bg-white rounded row mx-2 px-3 pt-5 pb-2">

                    @if($incidentReport->typeOfIncident == 1)
                        <x-input name="patientName" type="input" label="Patient Name" value="{{ $incidentReport->obstetrics->fullName }}" readOnly/>
                        <x-input name="patientAge" type="input" label="Patient Age" value="{{ $incidentReport->obstetrics->age }}" readOnly/>
                        <x-input name="monthsPregnant" type="input"    label="Months Pregnant" value="{{ $incidentReport->obstetrics->monthsPregnant }}" readOnly/>
                        <x-input name="numberOfBirths" type="input" label="Number of Births" value="{{ $incidentReport->obstetrics->numberOfBirths }}" readOnly/>
                        <x-input name="prenatalCareLocation" type="input" label="Prenatal Care Location" value="{{ $incidentReport->obstetrics->prenatalCareLocation }}" readOnly/>
                    
                    @elseif($incidentReport->typeOfIncident == 2)
                        @foreach($incidentReport->medical as $data)
                            <x-input name="patientName" type="input" label="Patient Name" value="{{ $data['fullName']}}" mdSize="4" readOnly />
                            <x-input name="heartRate" type="input" label="Heart Rate (BPM)" value="{{ $data['heartRate'] }}" mdSize="4" readOnly/>
                            <x-single-checkbox label="Shortness of Breath" name="shortnessOfBreath" mdSize="2" :checked="$data['shortnessOfBreath'] == 1" />
                            <x-single-checkbox label="Paleness" name="paleness" mdSize="2" :checked="$data['paleness'] == 1" />
                        @endforeach

                    @elseif($incidentReport->typeOfIncident == 3)
                        @foreach($incidentReport->injury_trauma as $data)
                            <x-input name="patientName" type="input" label="Patient Name" value="{{ $data['fullName']}}" mdSize="4" readOnly />
                            <x-input name="heartRate" type="input" label="Heart Rate (BPM)" value="{{ $data['heartRate'] }}" mdSize="4" readOnly/>
                            <x-single-checkbox label="Shortness of Breath" name="shortnessOfBreath" mdSize="2" :checked="$data['shortnessOfBreath'] == 1" />
                            <x-single-checkbox label="Paleness" name="paleness" mdSize="2" :checked="$data['paleness'] == 1" />
                        @endforeach

                    
                    @elseif($incidentReport->typeOfIncident == 4)
                        @foreach($incidentReport->cardia as $data)
                            <x-input name="patientName" type="input" label="Patient Name" value="{{ $data['fullName']}}" mdSize="4" readOnly />
                            <x-input name="heartRate" type="input" label="Heart Rate (BPM)" value="{{ $data['heartRate'] }}" mdSize="4" readOnly/>
                            <x-single-checkbox label="Shortness of Breath" name="shortnessOfBreath" mdSize="2" :checked="$data['shortnessOfBreath'] == 1" />
                            <x-single-checkbox label="Paleness" name="paleness" mdSize="2" :checked="$data['paleness'] == 1" />
                        @endforeach

                    @elseif($incidentReport->typeOfIncident == 5)
                        @foreach($incidentReport->disaster_patients as $data)
                            <x-input name="patientName" type="input" label="Patient Name" value="{{ $data['fullName']}}" mdSize="4" readOnly />
                            <x-input name="heartRate" type="input" label="Heart Rate (BPM)" value="{{ $data['heartRate'] }}" mdSize="4" readOnly/>
                            <x-single-checkbox label="Shortness of Breath" name="shortnessOfBreath" mdSize="2" :checked="$data['shortnessOfBreath'] == 1" />
                            <x-single-checkbox label="Paleness" name="paleness" mdSize="2" :checked="$data['paleness'] == 1" />
                        @endforeach


                        <x-input name="disasterType" type="input" label="Disaster Type" value="{{ $incidentReport->disaster->disasterType->description }}" readOnly/>
                        <x-input name="description" type="input" label="Description" value="{{ $incidentReport->disaster->description }}" readOnly/>
                    @endif
                    
                    <x-input name="incidentPlace" type="input" label="Place of Incident" value="{{ $incidentReport->incidentPlace }}" readOnly/>
                    <x-input name="landmark" type="input" label="Landmark" value="{{ $incidentReport->landmark }}" readOnly/>
                    <x-input name="date" label="Date" type="date" value="{{ $incidentReport->date }}" readOnly/>
                    <x-input name="time" label="Time" type="time" value="{{ $incidentReport->time }}" readOnly/>
                    <x-input name="reporterFullName" type="input" label="Reporter Name" value="{{ $incidentReport->reporterFullName }}" readOnly/>
                    <x-input name="reporterContactNumber" type="input" label="Reporter Contact Number" value="{{ $incidentReport->reporterContactNumber }}" readOnly/>
                    @if($incidentReport->typeOfIncident != 1)
                        <x-input name="numberOfCasualties" type="input"  label="Number of Casualties" value="{{ $incidentReport->numberOfCasualties }}" readOnly/>
                    @endif
                    <x-input name="referenceCode" type="input" label="Reference Code" value="{{ $incidentReport->referenceCode }}" readOnly/>

                    @if($incidentReport->typeOfIncident == 5)
                        <div class="col-12 mb-3">
                            <img src="{{ asset('storage/' . $incidentReport->disaster->photoPathFile) }}" alt="Disaster Image" class="img-fluid border" style="max-width: 500px; max-height: 500px;">
                        </div>                   
                    @endif

                    <div class="row d-flex justify-content-between mt-2">
                        <div class="col mb-2">
                            <a href="{{ route('response_records.incident.create', ['case' => $incidentReport->typeOfIncident ,'id' => $incidentReport->reportID]) }}" class="btn btn-success">
                                <i class="bi bi-file-earmark-plus-fill p-2"></i> Create Response Record
                            </a>
                        </div>

                        @if($incidentReport->isConfirmed == 0)
                            <div class="col mb-2">
                                <a href="{{ route('incident_report.confirm', ['id' => $incidentReport->reportID]) }}" class="btn btn-warning">
                                    <i class="bi bi-check-circle-fill p-2"></i> Confirm Incident Report
                                </a>
                            </div>
                        @endif
                    </div> 
                </div>  
            </form>        
        </div>
    </div>
@endsection

@section('js')
@endsection