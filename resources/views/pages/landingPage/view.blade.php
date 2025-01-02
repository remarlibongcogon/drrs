@extends('layouts.layout')

@section('content')
    <x-toast />
    <div id="nearAlert"></div>
    @if ($hazardAlert)
        <div class="mt-4 alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-diamond-fill"></i>
            <span>Warning! {{ $latestHazard->hazardName }} occured {{ $latestHazard->updated_at->diffForHumans() }}</span> 
        </div>
    @endif
    <div class="d-flex flex-column mx-md-2">
        <h3 class="text-start mx-2 text-primary">Hazard Map</h3>
        <div class="mx-2 mb-3 p-2">
            <div id="hazard-map" class="border border-success mb-2" style="width: 100%; height: 400px;"></div>
            <div class="d-flex justify-content-around gap-2">
                <div class="alert alert-danger" role="alert">
                    Number of Hazards : {{ $hazards->count()}}
                </div>
                <div class="alert alert-success" role="alert">
                    Number of Shelters : {{ $shelters->count()}}
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column flex-md-row m-md-2 py-2">
        <div class="col-12 px-3 row m-0 d-flex justify-content-center">
            <h3 class="text-primary col-12">Track Incident Report Status</h3>    
            <div class="w-50 col-12">
                <form id="incidentSearchForm" class="row m-0 gap-1">
                    <div class="col-md-7 col-12">
                        <input class="form-control" type="text" name="searchIncident" placeholder="Enter reference code">
                    </div>
                    <div class="col-md-4 col-12 d-flex">
                        <button class="btn btn-outline-primary flex-fill" type="submit">
                            <i class="bi bi-search"></i>
                            Find Incident
                        </button>
                    </div>
                </form>   
            </div>        
        </div>
    </div>

    <div class="d-flex flex-column flex-md-row m-md-2 py-2">
        <div class="col-12 col-md-6 text-start px-3">
            <h3 class="text-primary">Donate</h3>
            <p class="">               
                Your generous donation will directly support our efforts to make a positive impact in the community. Together, we can create lasting change and bring hope to those who need it most.
            </p>
        </div>
        <div class="d-flex justify-content-center align-items-center px-5 col-12 col-md-6">
            <a class="btn btn-outline-primary flex-fill btn-lg" href="{{ route('create.donation') }}">
                Donate
            </a>
        </div>
    </div>

    {{-- modal --}}
    <div id="searchResultModal" class="modal fade" tabindex="-1" aria-labelledby="searchResultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="searchResultModalLabel">Incident Report Status</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="statusMessage" class="text-center fs-5">Searching...</p>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('js')
<script src="{{ asset('js/togglePassword.js') }}"></script>

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

    <script>
        document.getElementById('incidentSearchForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent form from submitting normally

            const searchIncident = document.querySelector('input[name="searchIncident"]').value;

            // Ensure input is not empty
            if (!searchIncident.trim()) {
                alert('Please enter a reference code.');
                return;
            }

            // Perform AJAX request
            $.ajax({
                url: "{{ route('incident_report.find') }}",
                method: "GET",
                data: {
                    searchIncident: searchIncident
                },
                success: function (response) {

                    const statusMessage = document.getElementById('statusMessage');

                    statusMessage.textContent = response.message;
                
                    const modal = new bootstrap.Modal(document.getElementById('searchResultModal'));
                    modal.show();
                },
                error: function (xhr) {
                    console.error(xhr);
                    alert('An error occurred while searching for the incident. Please try again.');
                }
            });
        });
    </script>

    
@endsection