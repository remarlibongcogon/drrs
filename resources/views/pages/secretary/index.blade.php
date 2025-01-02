@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <h3 class="text-start mx-2 text-primary">Donation Records</h3>
        <div id="alert-container">
            @if(session('error'))
                <x-alert response="error" color="danger"/>
            @elseif(session('success'))
                <x-alert response="success" color="success"/>
            @endif
        </div>
        
        <x-select name="donation_type" label="Donation Type" :options="$type" sizeMd="3" required="true" onchange="toggleFields(this.value)"/> 

        <!-- Cash Fields -->
        <div id="1-fields" class="donation-fields d-none">
            <div class="row m-0">
                <x-donations-table label="Cash Donations" :datas="$cashDonations" :type="1"/>
            </div>
        </div>
        
        <!-- Inkind Fields -->
        <div id="2-fields" class="donation-fields d-none">
            <div class="row m-0">
                <x-donations-table label="Inkind Donations" :datas="$inkindDonations" :type="2"/>
            </div>  
        </div>

         <!-- Ecash Fields -->
         <div id="3-fields" class="donation-fields d-none">
            <div class="row m-0">
                <x-donations-table label="E-cash Donations" :datas="$ecashDonations" :type="3"/>
            </div>  
        </div>
    </div>
@endsection

@section('js')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const incidentTypeSelect = document.getElementById('donation_type');
        const incidentFields = document.querySelectorAll('.donation-fields');
 
        // Function to show/hide fields based on selected incident type
        function toggleFields() {
            incidentFields.forEach(field => field.classList.add('d-none')); // Hide all fields
            const selectedType = incidentTypeSelect.value;
            if (selectedType) {
                const selectedField = document.getElementById(`${selectedType}-fields`);
                if (selectedField) selectedField.classList.remove('d-none'); // Show selected field
            }
        }
 
        // Initial load
        toggleFields();
 
        // On change of select
        incidentTypeSelect.addEventListener('change', toggleFields);
    });
 </script>
 <script>
    function submitPickupForm(donationID, type) {
        
        let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url:  `{{ url('/pickup/donation')}}`,
            type: "POST",
            data: {
                _token: _token,
                id: donationID,
                type: type
            },
            success: function(response) {
                console.log(response.message);
                if (response.success) {
                    showAlert('success', response.message);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000); 
                } else {
                    showAlert('error', response.message);
                }
            }
        });
        
    }

    function showAlert(type, message) {
        let alertClass = type === 'success' ? 'alert-success' : 'alert-danger'; 
        let alertElement = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        // Fix: Use #alert-container instead of .alert-container
        document.querySelector('#alert-container').innerHTML = alertElement;
    }
 </script>
@endsection
