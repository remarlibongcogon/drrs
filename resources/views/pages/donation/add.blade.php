@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">

        <div class="d-flex flex-row justify-content-between">
            <h3 class="text-start mx-2 text-primary">Send Donation</h3>
            <a class="btn btn-danger col-2 mb-3" href="{{  route('landingPage') }}">
                <i class="bi bi-backspace-fill p-2"></i>
                <span class="d-none d-sm-inline">Back</span>
            </a>
        </div>

        @if(session('error'))
            <x-alert response="error" color="danger"/>
        @elseif(session('success'))
            <x-alert response="success" color="success"/>
        @endif

        <div class="mx-2 mb-3 p-2">
            <form method="post" action="{{ route('store.donation') }}" class="needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                
                <div class="border bg-white rounded row mx-2 px-3 pt-5 pb-2">
                    <h3 class="text-primary text-start mb-3">Donation Form</h3>
                    <x-input name="fullname" label="Complete Name" type="text" required="true"/>
                    <x-input name="contactno" label="Contact Number" type="tel" pattern="^(09|\+639)\d{9}$" minLength="7" maxLength="15"/>
                    <x-select name="donationMode" id="donation_mode" label="Donation Mode" :options="$donation_mode" onchange="toggleDonationField(this.value)" required="true"/> 

                    <x-select name="donation_type" label="Donation Type" :options="$type"  onchange="toggleField(this.value)" dNone="false"/>

                    <!-- Cash Fields -->
                    <x-input id="amount" name="amount" label="Amount" type="number" dNone="true" />
                 
                    <!-- Inkind Fields -->
                    <x-input id="definition" name="definition" label="Define your Donation" type="text" dNone="true" />

                    <!-- Proof of Donation Field (Image Upload) -->
                    <x-input id="proof_of_donation" name="proof_of_donation" label="Proof of Donation" type="file" accept="image/*" dNone="true"/>

                    <div class="d-flex justify-content-end">   
                        <button id="submit-btn" class="btn btn-success">
                            <i class="bi bi-box2-heart-fill"></i>  
                            <span class="d-none d-sm-inline">Send Donations</span>
                        </button>
                    </div> 
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('js/formValidation.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const donationTypeSelect = document.getElementById('donation_type');
        const amountField = document.getElementById('amount');
        const definitionField = document.getElementById('definition');
        const proofOfDonation = document.getElementById('proof_of_donation');

        function toggleField(selectedType) {
            
            if (selectedType === "1") {
                amountField.closest('div').classList.remove('d-none'); 
                definitionField.closest('div').classList.add('d-none'); 
                proofOfDonation.closest('div').classList.add('d-none'); 
            } else if(selectedType === "2") {
                amountField.closest('div').classList.add('d-none'); 
                proofOfDonation.closest('div').classList.remove('d-none'); 
                definitionField.closest('div').classList.remove('d-none');
            }
        }

        // Initial load
        toggleField(donationTypeSelect.value);

        // On change of select
        donationTypeSelect.addEventListener('change', function () {
            toggleField(this.value);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const donationModeSelect = document.getElementById('donationMode');
        const donationTypeSelect = document.getElementById('donation_type');
        const proofOfDonation = document.getElementById('proof_of_donation');
        const amountField = document.getElementById('amount');
        const definitionField = document.getElementById('definition');

        function toggleDonationField(selectedType) {
            
            if (selectedType === "3") {
                proofOfDonation.closest('div').classList.remove('d-none'); 
                donationTypeSelect.closest('div').classList.add('d-none'); 
                amountField.closest('div').classList.remove('d-none'); 
                definitionField.closest('div').classList.add('d-none'); 
            }else{
                proofOfDonation.closest('div').classList.add('d-none'); 
                donationTypeSelect.closest('div').classList.remove('d-none');
                amountField.closest('div').classList.add('d-none'); 
            }
        }

        // Initial load
        toggleDonationField(donationModeSelect.value);

        // On change of select
        donationModeSelect.addEventListener('change', function () {
            toggleDonationField(this.value);
        });
    });
</script>
 
@endsection