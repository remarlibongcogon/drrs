<div style="font-family: Arial, sans-serif; border: 1px solid black; padding: 10px; width: 100%; font-size: 12px;">
    <h2 style="text-align: center; margin-bottom: 10px;">PATIENT CARE REPORT</h2>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 50%;"><strong>Name of Patient: </strong>{{ $patientCareReport->patientName }}</td>
            <td style="width: 50%;"><strong>Address: </strong>{{ $patientCareReport->patientAddress }}</td>
        </tr>
        <tr>
            <td><strong>Contact Person: </strong>{{ $patientCareReport->patientContactPerson }}</td>
            <td><strong>Contact number: </strong>{{ $patientCareReport->contactNumber }}</td>
        </tr>
        <tr>
            <td><strong>Place of Incident: </strong>{{ $patientCareReport->incidentPlace }}</td>
            <td><strong>Gender: </strong>{{ $patientCareReport->gender->description }}</td>
        </tr>
        <tr>
            <td><strong>Time of Incident: </strong>{{ date('gA', strtotime($patientCareReport->time)) }}</td>
            <td><strong>Age: </strong>{{ $patientCareReport->patientAge }}</td>
        </tr>
    </table>
    <hr>
    <h3>Case</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td><strong>O.B </strong>[ {{ $patientCareReport->case == 1 ? ' / ' : '  ' }} ]</td>
            <td><strong>Medical </strong>[ {{ $patientCareReport->case == 2 ? ' / ' : '  ' }} ]</td>
            <td><strong>Injury/Trauma </strong>[ {{ $patientCareReport->case == 3 ? ' / ' : '  ' }} ]</td>
            <td><strong>Cardiac </strong>[ {{ $patientCareReport->case == 4 ? ' / ' : '  ' }} ]</td>
        </tr>
    </table>
    <br>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td><strong>Alertness</strong></td>
            <td><strong>SAMPLE</strong></td>
            <td><strong>Pain Assessment</strong></td>
            <td><strong>Type</strong></td>
            <td><strong>DCAP - BTLS</strong></td>
            <td><strong>BFAST</strong></td>
        </tr>
        <tr>
            <td><strong>A</strong> [ {{ $patientCareReport->consciousness_lvl->A == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>S</strong>: {{ $patientCareReport->sample_history->S }}</td>
            <td><strong>O</strong>: {{ $patientCareReport->pain_assessment->O }}</td>
            <td><strong>Vehicular</strong> [ {{ !is_null($patientCareReport->injury_dtl->vehicular) ? '[ / ] (' . $patientCareReport->injury_dtl->vehicular_type->description . ')' : '[  ]' }} ]</td>
            <td><strong>D</strong> [ {{ $patientCareReport->dcapbtls->D == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>B</strong> [ {{ $patientCareReport->spotStroke->B == 1 ? ' / ' : ' ' }} ]</td>
        </tr>
        <tr>
            <td><strong>V</strong> [ {{ $patientCareReport->consciousness_lvl->V == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>A</strong>: {{ $patientCareReport->sample_history->A }}</td>
            <td><strong>P</strong>: {{ $patientCareReport->pain_assessment->P }}</td>
            <td><strong>Fall</strong> [ {{ $patientCareReport->injury_dtl->fall == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>C</strong> [ {{ $patientCareReport->dcapbtls->C == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>F</strong> [ {{ $patientCareReport->spotStroke->F == 1 ? ' / ' : ' ' }} ]</td>
        </tr>
        <tr>
            <td><strong>P</strong> [ {{ $patientCareReport->consciousness_lvl->P == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>M</strong>: {{ $patientCareReport->sample_history->M }}</td>
            <td><strong>Q</strong>: {{ $patientCareReport->pain_assessment->Q }}</td>
            <td><strong>Cut</strong> [ {{ $patientCareReport->injury_dtl->cut == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>A</strong> [ {{ $patientCareReport->dcapbtls->A == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>A</strong> [ {{ $patientCareReport->spotStroke->A == 1 ? ' / ' : ' ' }} ]</td>
        </tr>
        <tr>
            <td><strong>U</strong> [ {{ $patientCareReport->consciousness_lvl->U == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>P</strong>: {{ $patientCareReport->sample_history->P }}</td>
            <td><strong>R</strong>: {{ $patientCareReport->pain_assessment->R }}</td>
            <td><strong>Broken</strong> [ {{ !is_null($patientCareReport->injury_dtl->broken) ? '[ / ] (' . $patientCareReport->injury_dtl->broken . ')' : '[  ]' }} ]</td>
            <td><strong>P</strong> [ {{ $patientCareReport->dcapbtls->P == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>S</strong> [ {{ $patientCareReport->spotStroke->S == 1 ? ' / ' : ' ' }} ]</td>
        </tr>
        <tr>
            <td></td>
            <td><strong>L</strong>: {{ $patientCareReport->sample_history->L }}</td>
            <td><strong>S</strong>: {{ $patientCareReport->pain_assessment->S }}</td>
            <td><strong>Gunshot</strong> [ {{ $patientCareReport->injury_dtl->gunshot == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>B</strong> [ {{ $patientCareReport->dcapbtls->B == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>T</strong> [ {{ !is_null($patientCareReport->spotStroke->T) ? ' / ' : ' ' }} ] ( {{ $patientCareReport->spotStroke->T }} )</td>
        </tr>
        <tr>
            <td></td>
            <td><strong>E</strong>: {{ $patientCareReport->sample_history->E }}</td>
            <td><strong>T</strong>: {{ $patientCareReport->pain_assessment->T }}</td>
            <td><strong>Drowning</strong> [ {{ $patientCareReport->injury_dtl->drowning == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>T</strong> [ {{ $patientCareReport->dcapbtls->T == 1 ? ' / ' : ' ' }} ]</td>
        </tr>
        <tr>
            <td></td>
            <td><strong>E</strong>: {{ $patientCareReport->sample_history->E }}</td>
            <td></td>
            <td><strong>Electrocuted</strong> [ {{ $patientCareReport->injury_dtl->electrocuted == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>L</strong> [ {{ $patientCareReport->dcapbtls->L == 1 ? ' / ' : ' ' }} ]</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Suicide</strong> [ {{ $patientCareReport->injury_dtl->suicide == 1 ? ' / ' : ' ' }} ]</td>
            <td><strong>S</strong> [ {{ $patientCareReport->dcapbtls->S == 1 ? ' / ' : ' ' }} ]</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Burns</strong> [ {{ $patientCareReport->injury_dtl->burns == 1 ? ' / ' : ' ' }} ]</td>
            <td></td>
        </tr>
    </table>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td><strong>Vital Signs</strong></td>
            <td></td>
        </tr>
        <tr>
            <td><strong>BP</strong>: {{ $patientCareReport->vitals->BP }}</td>
            <td></td>
        </tr>
        <tr>
            <td><strong>TEMP</strong>: {{ $patientCareReport->vitals->TEMP }}</td>
            <td></td>
        </tr>
        <tr>
            <td><strong>HR</strong>: {{ $patientCareReport->vitals->HR }}</td>
            <td></td>
        </tr>
        <tr>
            <td><strong>SPo2</strong>: {{ $patientCareReport->vitals->SPo2 }}</td>
            <td></td>
        </tr>
        <tr>
            <td><strong>R.R</strong>: {{ $patientCareReport->vitals->RR }}</td>
            <td><strong>Others</strong>: {{ $patientCareReport->others }}</td>
        </tr>
    </table>
    <br>
    <p style="text-align: start;">Date: {{ \Carbon\Carbon::parse($patientCareReport->incidentDate)->format('M. j, Y') }}</p>
    <p style="text-align: start;">Recorded by: {{ $patientCareReport->recordedBy }}</p>
    <p style="text-align: start; margin-top:20px;">Received by (Hospital Staff): {{ $patientCareReport->recievedBy }}</p>
</div>
