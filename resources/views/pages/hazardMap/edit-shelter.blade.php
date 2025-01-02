@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <div class="d-flex flex-row justify-content-between">
            <h3 class="text-start mx-2 text-primary">Edit Shelter</h3>
            <a class="btn btn-danger col-2 mb-3 " href="{{ route('hazard_map.shelter') }}">
                <i class="bi bi-backspace-fill p-2"></i>
                <span class="d-none d-sm-inline">Back</span>
            </a>
        </div>
        <x-alert response="error" color="danger"/> 
        
        <div class="mx-2 mb-3 p-2">
            <div id="hazard-map" class="border border-success mb-2" style="width: 100%; height: 300px;" ></div>
            <!-- Shelter Form -->
            <form method="post" id="hazard-form" action="{{ route('shelter.update', ['id' => $shelter->shelterID]) }}" class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf
                <div class="border container bg-white rounded row mx-0 px-3 pt-2 pb-2">
                    <h4 class="py-2 text-primary text-start">Shelter Details</h4>
                    <x-input type="text" name="shelterName" label="Shelter Name" required="true" value="{{ $shelter->shelterName }}"/>
                    <x-input type="text" name="shelterCoordinates" label="Shelter Coordinates" readOnly="true" required="true" value="{{ $shelter->shelterCoordinates }}"/>

                    <x-input type="file" name="shelterImagePath" label="Shelter Image"/>
                    <!-- image container -->
                    <div class="col-12 col-md-6">
                        <img id="imagePreview" src="{{ !is_null($shelter['shelterImagePath']) ? asset('storage/'.$shelter['shelterImagePath']) : '' }}" alt="Image Preview" class="img-fluid" style="display: block; max-height: 200px;">
                    </div>
                    
                    <div class="d-flex justify-content-end">   
                        <button type="submit" class="btn btn-success mx-2">
                            <i class="bi bi-geo-fill p-2"></i>
                            Save Changes
                        </button>
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

    <!-- leaflet draw (not needed here for just pinning) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>

    <script src="{{ asset('js/hazard-map-pin.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initializeHazardMapPin('hazard-map', 'shelterCoordinates');

            // Image preview functionality
            const imageInput = document.getElementById('shelterImagePath');
            const imagePreview = document.getElementById('imagePreview');

            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                }
            });
        });
    </script>

    <script src="{{ asset('js/formValidation.js') }}"></script>
@endsection
