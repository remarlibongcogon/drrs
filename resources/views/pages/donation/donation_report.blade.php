<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            margin: 0 auto; 
        }
        .report-table td{
            border: 1px solid black; 
            padding: 8px;
            text-align: left;
        }
        th {
            padding: 10px; 
            font-weight: bold;
            font-size: 18px;
            border: 1px solid black;
            text-align: center;
        }
    </style>
</head>
<body>
    <table class="report-table">
        <tr>
            <th colspan="2">DONATION REPORT</th>
        </tr>
        <tr>
            <td style="width: 50%;"><strong>Name: </strong>{{ $datas['fullname'] }}</td>
            <td style="width: 50%;"><strong>Contact No.: </strong>{{ $datas['contactno'] }}</td>
        </tr>
        @if($type == 1)
            <tr>
                <td><strong>Donated Amount: </strong>{{ $datas['amount'] }}</td>
                <td><strong>Mode: </strong>{{ $datas['donationModeDesc'] }}</td>
            </tr>
        @elseif($type == 2)
            <tr>
                <td colspan="2" style="border: 1px solid #000; text-align: center;">
                    <strong>Proof of Donation:</strong>
                    @if(!empty($datas['proof_of_donation']))
                        <div style="margin-top: 10px;">
                            <img src="{{ public_path('storage/' . $datas['proof_of_donation']) }}" 
                                alt="Proof of Donation" 
                                style="max-width: 300px; max-height: 300px; border: 1px solid #ddd; padding: 5px;">
                        </div>
                    @else
                        <div style="margin-top: 10px;">No proof of donation provided.</div>
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong>Definition: </strong>{{ $datas['definition'] }}</td>
            </tr>
            <tr>
                <td><strong>Mode: </strong>{{ $datas['donationModeDesc'] }}</td>
                <td><strong>Date: </strong>{{ \Carbon\Carbon::parse($datas['created_at'])->format('F j, Y') }}</td>
            </tr>
        @elseif($type == 3)
            <tr>
                <td colspan="2" style="border: 1px solid #000; text-align: center;">
                    <strong>Proof of Donation:</strong>
                    @if(!empty($datas['proof_of_donation']))
                        <div style="margin-top: 10px;">
                            <img src="{{ public_path('storage/' . $datas['proof_of_donation']) }}" 
                                 alt="Proof of Donation" 
                                 style="max-width: 300px; max-height: 300px; border: 1px solid #ddd; padding: 5px;">
                        </div>
                    @else
                        <div style="margin-top: 10px;">No proof of donation provided.</div>
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Donated Amount: </strong>{{ $datas['amount'] }}</td>
                <td><strong>Date: </strong>{{ \Carbon\Carbon::parse($datas['created_at'])->format('F j, Y') }}</td>
            </tr>
        @endif
        @if($type == 1)
            <tr>
                <td colspan="2"><strong>Date: </strong>{{ \Carbon\Carbon::parse($datas['created_at'])->format('F j, Y') }}</td>
            </tr>
        @endif
    </table>
</body>
</html>
