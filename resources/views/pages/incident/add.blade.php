@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">

        <div class="d-flex flex-row justify-content-between">
            <h3 class="text-start mx-2 text-primary">Report Incident</h3>
            <a class="btn btn-danger col-4 col-md-2 mb-3 " href="{{ route('landingPage') }}">
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
            <form method="post" action="{{ route('incident_report.store') }}" class="needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="border bg-white rounded row mx-2 px-3 pt-5 pb-2">
                    <h3 class="text-start text-primary mb-3">Incident Report</h3>
                    <x-select name="incident_type" label="Type of Incident" :options="$cases" required="true" onchange="toggleFields(this.value)"/> 
                    <x-input name="place" label="Place of Incident" type="text"/>
                    <x-input name="date" label="Date" type="date" value="{{ \Carbon\Carbon::now()->toDateString() }}"/>
                    <x-input name="time" label="Time" type="time" value="{{ \Carbon\Carbon::now()->format('H:i')}}"/>
                    <x-input name="landmark" label="Landmark" type="text"/>
                    <x-input name="number_casualties" label="Number of Casualties" type="number" dNone="true"/>
                    <x-input name="reporter_name" label="Reporter FullName" type="text"/>
                    <x-input name="reporter_contactno" label="Reporter Contact Number" type="number" pattern="^(09|\+639)\d{9}$" minLength="7" maxLength="15"/>
                    <div class="mb-4"></div>

                    <!-- Obstetrics Fields -->
                    <div id="1-fields" class="incident-fields d-none">
                        <div class="row">
                            <x-input name="obstetrics_full_name" label="Patient Full Name" type="text" />
                            <x-input name="obstetrics_age" label="Patient Age" type="number" />
                            <x-input name="obstetrics_months_pregnant" label="Months Pregnant" type="number" />
                            <x-input name="obstetrics_number_births" label="Number of Births" type="number" />
                            <x-input name="obstetrics_prenatal_care_location" label="Prenatal Care Location" type="text" />
                        </div>
                    </div>
                 
                    <!-- Medical Fields -->
                    <div id="2-fields" class="incident-fields d-none">
                        <div id="medical-container"></div>
                    </div>

                    <!-- Injury/Trauma Fields -->
                    <div id="3-fields" class="incident-fields d-none">
                        <div id="injury-trauma-container"></div>

                          <!-- Incident Location Section -->
                        {{-- <div class="form-group">
                            <h5>Select Incident Location</h5>
                            <p>Are you at the exact location of the incident?</p>
                            <div class="d-flex justify-content-around mb-3">
                                <button type="button" class="btn btn-success" id="exactLocationBtn">Use My Current Location</button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mapModal">
                                    Pin Location on Map
                                </button>
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <h5 class="mb-3 mt-3">Incident Location</h5>
                            <p class="text-muted">Are you at the exact location of the incident?</p>
                            <div class="d-flex justify-content-center gap-3 mb-4">
                                <!-- Use Current Location (Yes) Button -->
                                <button 
                                    type="button" 
                                    class="btn btn-success px-4 py-2" 
                                    id="exactLocationBtn" 
                                    title="Automatically use your current GPS location"
                                    aria-label="Use My Current Location">
                                    <i class="bi bi-geo-alt-fill me-1"></i> Yes
                                </button>
                        
                                <!-- Pin Location (No) Button -->
                                <button 
                                    type="button" 
                                    class="btn btn-danger px-4 py-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#mapModal" 
                                    title="Manually select the location on the map"
                                    aria-label="Pin Location on Map">
                                    <i class="bi bi-map-fill me-1"></i> No
                                </button>
                            </div>
                        </div>
                        
                        
                    </div>

                    <!-- Cardia Fields -->
                    <div id="4-fields" class="incident-fields d-none">
                        <div id="cardia-container"></div>
                    </div>

                    <div id="5-fields" class="incident-fields d-none">

                        <div class="row patient-row">
                            <x-select name="disaster_type" label="Type of Disaster" :options="$disaster_types" required="true"/>
                            <x-input name="disaster_image" label="Photo" type="file" accept="image/*"/>
                            <x-input name="description" label="Description" type="text" mdSize="12"/>
                             

                            <input id="latitude" name="latitude" label="Latitude" type="text" mdSize="5" readOnly="true" hidden />
                            <input id="longitude" name="longitude" label="Longitude" type="text" mdSize="5" readOnly="true" hidden />
                            
                        </div>
                        
                        <div id="disaster-container" class="patient-container">
                            
                        </div>
                    </div>

                    <!-- Modal for Map -->
                    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mapModalLabel">Pin Location</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="map" style="width: 100%; height: 400px; border: 1px solid #ddd;"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex justify-content-end">
                        <button id="submit-btn" class="btn btn-success mx-2"><i class="bi bi-file-earmark-plus-fill p-2"></i> Send Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

    @section('js')
    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script src="{{ asset('js/incident-btn.js') }}"></script>
    <script src="{{ asset('js/incident-geo-api.js') }}"></script>
    @endsection
