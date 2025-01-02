@extends('layouts.layout')

@section('content')
    <x-alert response="success" color="success"/>
    <div class="d-flex flex-column m-md-2">
        <h3 class="text-start mx-2 text-primary">Hazard Map</h3>
        <div class="text-start px-3">
            <a href="{{ route('hazard_map.create') }}" class="btn btn-success col-12 col-md-2 my-1"> Add Hazard</a>
            <a href="{{ route('shelter.create') }}" class="btn btn-secondary col-12 col-md-2 my-1"> Add Shelter</a>
            <a href="{{ route('hazard_map.shelter') }}" class="btn btn-warning text-white col-12 col-md-4 my-1"> View Hazards and Shelter</a>
        </div>
        <div class="mx-2 mb-3 p-2">
            <div id="hazard-map" class="border border-success mb-2" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
@endsection

@section('js')
    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    
    <script src="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.js"></script>

    <!-- leaflet draw -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>

    <script src="{{ asset('js/hazard-map.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // pass json data 
            var hazardData = @json($hazards); 
            var shelterData = @json($shelters);
            var incidentData = @json($incidents);
            
            initializeHazardMap(hazardData, shelterData, incidentData, 'hazard-map');
        });
    </script>
@endsection