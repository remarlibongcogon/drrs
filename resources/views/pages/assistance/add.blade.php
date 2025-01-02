@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <div class="d-flex flex-row justify-content-between">
            <h3 class="text-start mx-2 text-primary">Family Assistance</h3>
            <a class="btn btn-danger col-2 mb-3 " href="{{ route('landingPage') }}">
                <i class="bi bi-backspace-fill p-2"></i>
                <span class="d-none d-sm-inline">Back</span>
            </a>
        </div>
        <!-- Display success or error message -->
        @if(session('error'))
            <x-alert response="error" color="danger"/>
        @elseif(session('success'))
            <x-alert response="success" color="success"/>
        @endif
        <div class="mx-2 mb-3 p-2">
            <form method="post" action="{{ route('store.family.assistance') }}" class="needs-validation" novalidate>
                @csrf
                <div class="border bg-white rounded row m-0 px-3 pt-5 pb-2">
                    <h3 class="text-primary text-start mb-3">Family Assistance Form</h3>
                    {{-- <hr class="border border-2 border-dark"> --}}
                    <h6 class="text-start mx-2 text-primary">LOCATION OF THE AFFECTED FAMILY</h6>
                    <x-input name="region" label="Region" type="text" required="true"/>
                    <x-input name="city_municipality" label="City/Municipality" type="text" required="true"/>

                    <x-input name="province" label="Province" type="text" required="true"/>
                    <x-input name="barangay" label="Barangay" type="text" required="true"/>

                    <x-input name="district" label="District" type="text" required="true"/>
                    <x-input name="evacuation_center" label="Evacuation Center" type="text"/>

                    <div class="mb-4"></div>
                    <h6 class="text-start mx-2 text-primary">HEAD OF THE FAMILY</h6>
                    <x-input name="first_name" label="First Name" type="text" mdSize="3" required="true"/>
                    <x-input name="middle_name" label="Middle Name" type="text" mdSize="3"/>
                    <x-input name="last_name" label="Last Name" type="text" mdSize="3" required="true"/>
                    <x-input name="suffix" label="Name Ext. (Jr.,Sr.)" type="text" mdSize="3"/>

                    <x-input name="birthdate" label="Birthdate" type="date" mdSize="3" required="true"/>
                    <x-input name="age" label="Age" type="number" mdSize="2" required="true"/>
                    <x-input name="birthplace" label="Birth Place" type="text" mdSize="7" required="true"/>

                    <x-select name="gender" label="Sex" :options="$genders" sizeMd="2" required="true"/>
                    <x-select name="civil_status" label="Civil Status" :options="$civil_status" sizeMd="2" required="true"/>
                    <x-input name="religion" label="Religion" type="text" mdSize="2"/>
                    <x-input name="occupation" label="Occupation" type="text" mdSize="3" required="true"/>
                    <x-input name="monthly_family_net_income" label="Monthly Family Net Income" type="number" mdSize="3" required="true"/>
                    
                    <x-input name="primary_contact_no" label="Primary Contact Number" type="number" mdSize="2" required="true"/>
                    <x-input name="alternate_contact_no" label="Alternate Contact Number" type="number" mdSize="2"/>
                    <x-input name="mother_maiden_name" label="Mother's Maiden Name" type="text" mdSize="3"/>
                    <x-input name="permanent_address" label="Permanent Address" type="text" mdSize="5" required="true"/>

                    <x-input name="id_card_presented" label="ID Card Presented" type="text" mdSize="3"/>
                    <x-input name="id_card_number" label="ID Card Number" type="text" mdSize="3"/>
                    <x-single-checkbox label="4Ps Beneficiary" name="is4PsBenef" mdSize="2"/> 
                    <x-single-checkbox label="IP" name="isIP" mdSize="2"/> 
                    <x-input name="ethnicity" label="Type of Ethnicity" type="text" mdSize="2"/>

                    <x-input name="total_older_person" label="No. of Older Person" type="number" mdSize="2"/>
                    <x-input name="total_preg_women" label="No. of Pregnant Women" type="number" mdSize="2"/>
                    <x-input name="total_lactating_women" label="No. of Lactating Women" type="number" mdSize="2"/>
                    <x-input name="total_PWD" label="No. of PWDs due to Medical Condition" type="number" mdSize="2"/>
                    <x-select name="house_ownership" label="House Ownership" :options="$house_ownership" sizeMd="2" required="true"/>
                    <x-select name="shelter_damage" label="Shelter Damage" :options="$shelter_damage" sizeMd="2" required="true"/>

                    <div class="mb-4"></div>
                    <h6 class="text-start mx-2 text-primary">FAMILY INFORMATION</h6>
                    <!-- add table-responsive class to not overflow -->
                    <div class="table-responsive">                  
                        <table class="table table-responsive table-bordered" id="familyTable">
                            <thead>
                                <tr>
                                    <th>Family Member</th>
                                    <th>Relation To Head Member</th>
                                    <th>Birthdate</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Highest Educational Attainment</th>
                                    <th>Occupation</th>
                                    <th>Remarks</th>
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div> 
            
                    <button class="btn btn-success mb-3" id="addRowBtn" type="button">
                        + Add Member
                    </button>
                    
                    <div class="d-flex justify-content-end">   
                        <button id="submit-btn" class="btn btn-success mx-2">
                            <i class="bi bi-postcard-heart-fill"></i>
                            <span class="d-none d-sm-inline">Send Form</span>
                        </button>
                    </div> 
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let genders = @json($genders);
    </script>

    <script src="{{ asset('js/add-row-assistance.js') }}"></script>
    <script src="{{ asset('js/formValidation.js') }}"></script>
@endsection