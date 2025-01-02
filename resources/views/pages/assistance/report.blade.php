<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistance Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .report-table, .family-member-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
            margin: 0 auto; 
        }
        .report-table td{
            border: 1px solid rgb(44, 44, 44); 
            padding: 8px;
            text-align: left;
        }

        .family-member-table td {
            border: 1px solid rgb(44, 44, 44); 
            padding: 1px;
            text-align: center;
        }

        th {
            padding: 25px; 
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            border: 1px solid black; 
        }
        input {
            width: 2%;
            vertical-align: middle;
        }

        label {
            vertical-align: middle;
        }

        .no-padding {
            padding: 1 !important;
        }

        /* Optionally, remove margin and padding from labels and inputs */
        .no-padding label,
        .no-padding input {
            margin: 0;
            padding: 1;
        }
    
    </style>
</head>
<body>
    <table class="report-table">
        <tr>
            <th colspan="2">
                Republic of the Philippines <br>
                Department of Social Welfare and Development <br>
                FAMILY ASSISTANCE CARD IN EMERGENCIES AND DISASTERS (FACED)
            </th>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold;">LOCATION OF THE AFFECTED FAMILY</td>
        </tr>
        <tr>
            <td><strong>Region:</strong> {{ $data['region'] }}</td>
            <td><strong>City/Municipality:</strong> {{ $data['city_municipality'] }}</td>
        </tr>
        <tr>
            <td><strong>Province:</strong> {{ $data['province'] }}</td>
            <td><strong>Barangay:</strong> {{ $data['barangay'] }}</td>
        </tr>
        <tr>
            <td><strong>District:</strong> {{ $data['district'] }}</td>
            <td><strong>Evacuation Center:</strong> {{ $data['evacuation_center'] }}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold;">HEAD OF THE FAMILY</td>
        </tr>
        <tr>
            <td><strong>Last Name:</strong> {{ $data['last_name'] }}</td>
            <td><strong>Civil Status:</strong> {{ $data['civil_status'] }}</td>
        </tr>
        <tr>
            <td><strong>First Name:</strong> {{ $data['first_name'] }}</td>
            <td><strong>Mother's Maiden Name:</strong> {{ $data['mother_maiden_name'] }}</td>
        </tr>
        <tr>
            <td><strong>Middle Name:</strong> {{ $data['middle_name'] }}</td>
            <td><strong>Religion:</strong> {{ $data['religion'] }}</td>
        </tr>
        <tr>
            <td><strong>Name Ext.:</strong> {{ $data['suffix'] }}</td>
            <td><strong>Occupation:</strong> {{ $data['occupation'] }}</td>
        </tr>
        <tr>
            <td><strong>Birthdate:</strong> {{ \Carbon\Carbon::parse($data['birthdate'])->format('F j, Y') }}</td>
            <td><strong>Monthly Family Net Income:</strong> {{ $data['monthly_family_net_income'] }}</td>
        </tr>
        <tr>
            <td><strong>Age:</strong> {{ $data['age'] }}</td>
            <td><strong>ID Card Presented:</strong> {{ $data['id_card_presented'] }}</td>
        </tr>
        <tr>
            <td><strong>Birth Place:</strong> {{ $data['birthplace'] }}</td>
            <td><strong>ID Card Number:</strong> {{ $data['id_card_number'] }}</td>
        </tr>
        <tr>
            <td><strong>Sex:</strong> {{ $data['gender'] }}</td>
            <td><strong>Primary Contact No.:</strong> {{ $data['alternate_contact_no'] }}</td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="is4PsBenef" name="is4PsBenef" @if(isset($data['is4PsBenef'])) checked @endif>
                &nbsp;&nbsp;
                <label for="is4PsBenef">4Ps Beneficiary</label>
                &nbsp;&nbsp;
                <input type="checkbox" id="isIP" name="isIP" @if(isset($data['isIP'])) checked @endif>
                &nbsp;&nbsp;
                <label for="isIP">IP</label>
                &nbsp;&nbsp;
                <strong>Ethnicity:</strong> {{ $data['ethnicity'] }}
            </td>
            <td><strong>Alternate Contact No.:</strong> {{ $data['alternate_contact_no'] }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Permanent Address:</strong> {{ $data['permanent_address'] }}</td>
        </tr>
    </table>
        <table class="family-member-table">
            @if(isset($data['family_member']))
                <tr>
                    <td><strong>Family Members</strong></td>
                    <td><strong>Relation to Family Head</strong></td>
                    <td><strong>Birthdate</strong></td>
                    <td><strong>Age</strong></td>
                    <td><strong>Sex</strong></td>
                    <td><strong>Highest Educational Attainment</strong></td>
                    <td><strong>Occupation</strong></td>
                    <td><strong>Remarks</strong></td>
                </tr>
                @foreach($data['family_member'] as $member)
                    <tr>
                        <td>{{ $member['fullname'] }}</td>
                        <td>{{ $member['relation'] }}</td>
                        <td>{{ $member['birthdate'] }}</td>
                        <td>{{ $member['age'] }}</td>
                        <td>{{ $member['genderDesc'] }}</td>
                        <td>{{ $member['educational_attainment'] }}</td>
                        <td>{{ $member['occupation'] }}</td>
                        <td>{{ $member['remarks'] }}</td>
                    </tr>
                @endforeach
            @endif
                <tr>
                    <td colspan="8" class="vulnerable_td no-padding">
                        <label><strong>No of Vulnerable Family Members:</strong> </label>
                        &nbsp;&nbsp;

                        <label for="total_older_person">Older Person</label>
                        <input type="number" id="total_older_person" name="total_older_person" 
                            value="{{ $data['total_older_person'] ?? 0 }}" readonly>
                        &nbsp;&nbsp;

                        <label for="total_preg_women">Pregnant Women</label>
                        <input type="number" id="total_preg_women" name="total_preg_women" 
                            value="{{ $data['total_preg_women'] ?? 0 }}" readonly>
                        <br>

                        <label for="total_lactating_women">Lactating Women</label>
                        <input type="number" id="total_lactating_women" name="total_lactating_women" 
                            value="{{ $data['total_lactating_women'] ?? 0 }}" readonly>
                        &nbsp;&nbsp;

                        <label for="total_PWD">PWDs due to Medical Condition/s</label>
                        <input type="number" id="total_PWD" name="total_PWD" 
                            value="{{ $data['total_PWD'] ?? 0 }}" readonly>

                    </td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Houser Ownership:</strong> {{ $data['house_ownership'] }}</td>
                    <td colspan="4"><strong>Shelter Damage Classification:</strong> {{ $data['shelter_damage'] }}</td>
                </tr>
        </table>
</body>
</html>
