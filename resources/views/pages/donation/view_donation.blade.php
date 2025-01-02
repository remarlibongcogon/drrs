@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">

        <div class="d-flex flex-row justify-content-between">
            <h3 class="text-start mx-2 text-primary">Donation Form</h3>
            <a class="btn btn-danger col-4 col-md-2 mb-3 " href="{{  route('landingPage') }}">
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
            <form method="post" action="{{ route('store.donation') }}" class="needs-validation" novalidate>
                @csrf
                <div class="border container bg-white rounded row mx-2 px-3 pt-5 pb-2">             
                    <x-input name="fullname" label="Complete Name" type="text" value="{{$donation['fullname']}}" readOnly="true"/>
                    <x-input name="contactno" label="Contact Number" value="{{$donation['contactno']}}" type="number" readOnly="true"/>
                    <x-input name="donationMode" label="Donation Mode" value="{{$donation['donationModeDesc']}}" type="text" readOnly="true"/>

                     <!-- Cash Field -->
                    @if($type == 1)
                        <x-input name="amount" label="Amount" type="number" readOnly="true"/>
                    @endif
                 
                    <!-- Inkind Fields -->
                   @if($type == 2)
                        <x-input name="category" label="Item Name" type="text" value="{{$donation['categoryDesc']}}" readOnly="true"/>
                        <x-input name="itemName" label="Item Name" type="text" value="{{$donation['itemName']}}" readOnly="true"/>
                        <x-input name="quantity" label="Quantity" type="text" value="{{$donation['quantity']}}" readOnly="true"/>
                    @endif

                    <div class="d-flex justify-content-end">   
                        <button id="submit-btn" class="btn btn-success mx-2"><i class="bi bi-file-earmark-plus-fill p-2"></i>  Send Report
                        </button>
                    </div> 
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
 
@endsection