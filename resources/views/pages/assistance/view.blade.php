@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <div class="d-flex flex-row justify-content-between">
            <h3 class="text-start mx-2 text-primary">Family Assistance Form</h3>
            <a class="btn btn-danger col-4 col-md-2 mb-3 " href="{{ url()->previous() }}">
                <i class="bi bi-backspace-fill p-2"></i>
                Back
            </a>
        </div>
        <div class="mx-2 mb-3 p-2">
            <form method="post" action="{{ route('family.assistance.print') }}">
                @csrf
                <div class="border container bg-white rounded row mx-2 px-3 pt-5 pb-2">

                    {{-- <hr class="border border-2 border-dark"> --}}
                    <h6 class="text-start mx-2 text-primary">LOCATION OF THE AFFECTED FAMILY</h6>
                    <x-input name="region" label="Region" type="text" value="{{$data['region']}}" readOnly="true"/>
                    <x-input name="city_municipality" label="City/Municipality" type="text" value="{{$data['city_municipality']}}" readOnly="true"/>
                    <x-input name="province" label="Province" type="text" value="{{$data['province']}}" readOnly="true"/>
                    <x-input name="barangay" label="Barangay" type="text" value="{{$data['barangay']}}" readOnly="true"/>
                    <x-input name="district" label="District" type="text" value="{{$data['district']}}" readOnly="true"/>
                    <x-input name="evacuation_center" label="Evacuation Center" type="text" value="{{$data['evacuation_center']}}" readOnly="true"/>

                    <div class="mb-4"></div>
                    <h6 class="text-start mx-2 text-primary">HEAD OF THE FAMILY</h6>
                    <x-input name="first_name" label="First Name" type="text" mdSize="3" value="{{$data['first_name']}}" readOnly="true"/>
                    <x-input name="middle_name" label="Middle Name" type="text" mdSize="3" value="{{$data['middle_name']}}" readOnly="true"/>
                    <x-input name="last_name" label="Last Name" type="text" mdSize="3" value="{{$data['last_name']}}" readOnly="true"/>
                    <x-input name="suffix" label="Name Ext. (Jr.,Sr.)" type="text" mdSize="3" value="{{$data['suffix']}}" readOnly="true"/>

                    <x-input name="birthdate" label="Birthdate" type="date" mdSize="3" value="{{$data['birthdate']}}" readOnly="true"/>
                    <x-input name="age" label="Age" type="number" mdSize="2" value="{{$data['age']}}" readOnly="true"/>
                    <x-input name="birthplace" label="Birth Place" type="text" mdSize="7" value="{{$data['birthplace']}}" readOnly="true"/>

                    <x-input name="gender" label="Sex" type="text" mdSize="2" value="{{$data['genderDesc']}}" readOnly="true"/>
                    <x-input name="civil_status" label="Civil Status" type="text" mdSize="2" value="{{$data['civilStatus']}}" readOnly="true"/>
                    <x-input name="religion" label="Religion" type="text" mdSize="2" value="{{$data['religion']}}" readOnly="true"/>
                    <x-input name="occupation" label="Occupation" type="text" mdSize="3" value="{{$data['occupation']}}" readOnly="true"/>
                    <x-input name="monthly_family_net_income" label="Monthly Family Net Income" type="number" mdSize="3" value="{{$data['monthly_family_net_income']}}" readOnly="true"/>

                    <x-input name="primary_contact_no" label="Primary Contact Number" type="number" mdSize="2" value="{{$data['primary_contact_no']}}" readOnly="true"/>
                    <x-input name="alternate_contact_no" label="Alternate Contact Number" type="number" mdSize="2" value="{{$data['alternate_contact_no']}}" readOnly="true"/>
                    <x-input name="mother_maiden_name" label="Mother's Maiden Name" type="text" mdSize="3" value="{{$data['mother_maiden_name']}}" readOnly="true"/>
                    <x-input name="permanent_address" label="Permanent Address" type="text" mdSize="5" value="{{$data['permanent_address']}}" readOnly="true"/>

                    <x-input name="id_card_presented" label="ID Card Presented" type="text" mdSize="3" value="{{$data['id_card_presented']}}" readOnly="true"/>
                    <x-input name="id_card_number" label="ID Card Number" type="text" mdSize="3" value="{{$data['id_card_number']}}" readOnly="true"/>
                    <x-single-checkbox label="4Ps Beneficiary" name="is4PsBenef" mdSize="2" :checked="$data['is4PsBenef'] == 1" />
                    <x-single-checkbox label="IP" name="isIP" mdSize="2" :checked="$data['isIP'] == 1" />
                    <x-input name="ethnicity" label="Type of Ethnicity" type="text" mdSize="2" value="{{$data['ethnicity']}}" readOnly="true"/>

                    <x-input name="total_older_person" label="No. of Older Person" type="number" mdSize="2" value="{{$data['total_older_person']}}" readOnly="true"/>
                    <x-input name="total_preg_women" label="No. of Pregnant Women" type="number" mdSize="2" value="{{$data['total_preg_women']}}" readOnly="true"/>
                    <x-input name="total_lactating_women" label="No. of Lactating Women" type="number" mdSize="2" value="{{$data['total_lactating_women']}}" readOnly="true"/>
                    <x-input name="total_PWD" label="No. of PWDs due to Medical Condition" type="number" mdSize="2" value="{{$data['total_PWD']}}" readOnly="true"/>
                    <x-input name="house_ownership" label="House Ownership" type="text" mdSize="2" value="{{$data['houseOwnershipDesc']}}" readOnly="true"/>
                    <x-input name="shelter_damage" label="Shelter Damage" type="text" mdSize="2" value="{{$data['shelterDamageDesc']}}" readOnly="true"/>


                    <div class="mb-4"></div>
                    <h6 class="text-start mx-2 text-primary">FAMILY INFORMATION</h6>
                    
                    <table class="table table-bordered" id="familyTable">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($family_member as $member)
                                <tr>
                                    <td>{{ $member['fullname'] }}</td>
                                    <td>{{ $member['relation'] }}</td>
                                    <td>{{ $member['birthdate'] }}</td>
                                    <td>{{ $member['age'] }}</td>
                                    <td>{{ $member['genderDesc'] }}</td>
                                    <td>{{ $member['educational_attainment'] }}</td>
                                    <td>{{ $member['occupation'] }}</td>
                                    <td>{{ $member['remarks'] }}</td>

                                    <input type="hidden" name="family_member[{{ $loop->index }}][fullname]" value="{{ $member['fullname'] }}">
                                    <input type="hidden" name="family_member[{{ $loop->index }}][relation]" value="{{ $member['relation'] }}">
                                    <input type="hidden" name="family_member[{{ $loop->index }}][birthdate]" value="{{ $member['birthdate'] }}">
                                    <input type="hidden" name="family_member[{{ $loop->index }}][age]" value="{{ $member['age'] }}">
                                    <input type="hidden" name="family_member[{{ $loop->index }}][genderDesc]" value="{{ $member['genderDesc'] }}">
                                    <input type="hidden" name="family_member[{{ $loop->index }}][educational_attainment]" value="{{ $member['educational_attainment'] }}">
                                    <input type="hidden" name="family_member[{{ $loop->index }}][occupation]" value="{{ $member['occupation'] }}">
                                    <input type="hidden" name="family_member[{{ $loop->index }}][remarks]" value="{{ $member['remarks'] }}">
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-end">   
                        <button id="submit-btn" class="btn btn-success mx-2"><i class="bi bi-file-earmark-plus-fill p-2"></i>  Print Form
                        </button>
                    </div> 
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection