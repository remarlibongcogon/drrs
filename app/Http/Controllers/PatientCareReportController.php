<?php

namespace App\Http\Controllers;

use App\Models\ConsciousnessLevel;
use App\Models\DCAPBLTS;
use App\Models\Gender;
use App\Models\InjuryDtl;
use App\Models\PainAssessment;
use App\Models\PatientCareCase;
use App\Models\SampleHistory;
use App\Models\SpotStroke;
use App\Models\VehicularAccidentTypes;
use App\Models\Vitals;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\PatientCareReport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\PDF;

class PatientCareReportController extends Controller
{

    public function index()
    {
        $cases = map_options(PatientCareCase::class, 'id', 'description');
        $genders = map_options(Gender::class, 'id', 'description');
        
        $alertnessData = create_collection(['A', 'V', 'P', 'U']);
        $painAssessmentData = create_collection(['O', 'P', 'Q', 'R', 'S', 'T']);
        $sample = create_collection(['S', 'A', 'M', 'P', 'L', 'E']);
        $dcapbtls = create_collection(['D', 'C', 'A', 'P', 'B', 'T', 'L', 'S']);
        $spotStroke = create_collection(['B', 'F', 'A', 'S', 'T']);
        $vitals = create_collection(['BP', 'TEMP', 'HR', 'SPo2', 'RR']);
        
        $injuryTypes = [
            ['id' => 1, 'name' => 'Vehicular', 'subdata' => map_options(VehicularAccidentTypes::class, 'id', 'description')],
            ['id' => 2, 'name' => 'Fall'], ['id' => 3, 'name' => 'Cut'],
            ['id' => 4, 'name' => 'Broken'], ['id' => 5, 'name' => 'Drowning'], 
            ['id' => 6, 'name' => 'Electrecuted'], ['id' => 7, 'name' => 'Suicide'], 
            ['id' => 8, 'name' => 'Burns']
        ];

        $patientCareReports = PatientCareReport::all();

        return view('pages.patientCareReports.view', compact(
            'cases', 'alertnessData', 'sample', 'painAssessmentData', 'dcapbtls', 'injuryTypes', 
            'spotStroke', 'vitals', 'genders', 'patientCareReports'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patientName' => 'required|string|max:50',
            'patientAge' => 'required|integer|max:999',
            'patientGender' => 'required|integer|max:3', 
            'patientAddress' => 'required|string|max:50',
            'patientContactPerson' => 'nullable|string|max:255',
            'contactNumber' => 'nullable|string|max:11',
            'incidentPlace' => 'required|string|max:200',
            'incidentDate' => 'required|date',
            'time' => 'required|string',
            'case' => 'required|integer',
            'others' => 'nullable|string|max:100',
            'responder' => 'required|string|max:255',
            'recievedBy' => 'nullable|string|max:100',

            'alertness' => 'nullable|array',
            'sample' => 'nullable|array',
            'painAssessment' => 'nullable|array',
            'injury_type' => 'nullable|integer',
            'injury_type_sub' => 'nullable|integer',
            'injury_type_broken' => 'nullable|string',
            'dcapbtls' => 'nullable|array',
            'spotStroke' => 'nullable|array',
            'vitals' => 'nullable|array'
            
        ]);
        // dd($request->all());
        if ($validator->fails()) {
            \Log::error('Errors: '. $validator->errors());
            return redirect()->back()->with('error', 'Oh no! An error has occured');
        }

        DB::beginTransaction();

        try {
            // save PatientCare report
            $patientCareReport = PatientCareReport::create([
                'patientName' => $request->patientName,
                'patientAge' => $request->patientAge,
                'patientGender' => $request->patientGender,
                'patientAddress' => $request->patientAddress,
                'patientContactPerson' => $request->patientContactPerson,
                'contactNumber' => $request->contactNumber,
                'incidentPlace' => $request->incidentPlace,
                'incidentDate' => $request->incidentDate,
                'time' => $request->time,
                'case' => $request->case,
                'others' => $request->others,
                'recordedBy' => $request->responder,
                'recievedBy' => $request->recievedBy,
            ]);

            $alertnessData = [
                'A' => isset($request->alertness['A']) ? 1 : 0,
                'V' => isset($request->alertness['V']) ? 1 : 0,
                'P' => isset($request->alertness['P']) ? 1 : 0,
                'U' => isset($request->alertness['U']) ? 1 : 0,
            ];
        
            ConsciousnessLevel::create([
                'patientCareID' => $patientCareReport->patientCareID,
                'A' => $alertnessData['A'],
                'V' => $alertnessData['V'],
                'P' => $alertnessData['P'],
                'U' => $alertnessData['U'],
            ]);

            $alertnessData = [
                'S' => isset($request->sample['s']) ? $request->sample['s'] : null,
                'A' => isset($request->sample['a']) ? $request->sample['a'] : null,
                'M' => isset($request->sample['m']) ? $request->sample['m'] : null,
                'P' => isset($request->sample['p']) ? $request->sample['p'] : null,
                'L' => isset($request->sample['l']) ? $request->sample['l'] : null,
                'E' => isset($request->sample['e']) ? $request->sample['e'] : null,
            ];

            SampleHistory::create([
                'patientCareID' => $patientCareReport->patientCareID,
                'S' => $alertnessData['S'],
                'A' => $alertnessData['A'],
                'M' => $alertnessData['M'],
                'P' => $alertnessData['P'],
                'L' => $alertnessData['L'],
                'E' => $alertnessData['E'],
            ]);

            $paintAssessment = [
                'O' => isset($request->painAssessment['o']) ? $request->painAssessment['o'] : null,
                'P' => isset($request->painAssessment['p']) ? $request->painAssessment['p'] : null,
                'Q' => isset($request->painAssessment['q']) ? $request->painAssessment['q'] : null,
                'R' => isset($request->painAssessment['r']) ? $request->painAssessment['r'] : null,
                'S' => isset($request->painAssessment['s']) ? $request->painAssessment['s'] : null,
                'T' => isset($request->painAssessment['t']) ? $request->painAssessment['t'] : null,
            ];

            PainAssessment::create([
                'patientCareID' => $patientCareReport->patientCareID,
                'O' => $paintAssessment['O'],
                'P' => $paintAssessment['P'],
                'Q' => $paintAssessment['Q'],
                'R' => $paintAssessment['R'],
                'S' => $paintAssessment['S'],
                'T' => $paintAssessment['T'],
            ]);

            $injuryType = $request->input('injury_type');
            $injuryDtlData = [
                'patientCareID' => $patientCareReport->patientCareID,
                'vehicular' => null,
                'fall' => 0,
                'cut' => 0,
                'broken' => null,
                'gunshot' => 0,
                'drowning' => 0,
                'electrocuted' => 0,
                'suicide' => 0,
                'burns' => 0
            ];

            switch ($injuryType) {
                case "1": 
                    $injuryDtlData['vehicular'] = (int) $request->injury_type_sub;
                    //dd($injuryDtlData['vehicular']);
                    break;
                case "2":
                    $injuryDtlData['fall'] = 1;
                    $injuryDtlData['broken'] = null;
                    break;
                case "3": 
                    $injuryDtlData['cut'] = 1;
                    $injuryDtlData['broken'] = null;
                    break;
                case "4":
                    $injuryDtlData['broken'] = $request->input('injury_type_broken');
                    break;
                case "5": 
                    $injuryDtlData['gunshot'] = 1;
                    break;
                case "6": 
                    $injuryDtlData['drowning'] = 1;
                    break;
                case "7": 
                    $injuryDtlData['electrocuted'] = 1;
                    break;
                case "8":
                    $injuryDtlData['suicide'] = 1;
                    break;
                case "9":
                    $injuryDtlData['burns'] = 1;
                    break;
            }

            InjuryDtl::create($injuryDtlData);

            $dcapbtlsData = [
                'D' => isset($request->dcapbtls['D']) ? 1 : 0,
                'C' => isset($request->dcapbtls['C']) ? 1 : 0,
                'A' => isset($request->dcapbtls['A']) ? 1 : 0,
                'P' => isset($request->dcapbtls['P']) ? 1 : 0,
                'B' => isset($request->dcapbtls['B']) ? 1 : 0,
                'L' => isset($request->dcapbtls['L']) ? 1 : 0,
                'T' => isset($request->dcapbtls['T']) ? 1 : 0,
                'S' => isset($request->dcapbtls['S']) ? 1 : 0,
            ];

            DCAPBLTS::create([
                'patientCareID' => $patientCareReport->patientCareID,
                'D' => $dcapbtlsData['D'],
                'C' => $dcapbtlsData['C'],
                'A' => $dcapbtlsData['A'],
                'P' => $dcapbtlsData['P'],
                'B' => $dcapbtlsData['B'],
                'L' => $dcapbtlsData['L'],
                'T' => $dcapbtlsData['T'],
                'S' => $dcapbtlsData['S'],
            ]);

            $spotStrokeData = [
                'B' => isset($request->dcapbtls['B']) ? 1 : 0,
                'F' => isset($request->dcapbtls['F']) ? 1 : 0,
                'A' => isset($request->dcapbtls['A']) ? 1 : 0,
                'S' => isset($request->dcapbtls['S']) ? 1 : 0,
                'T' => isset($request->spotStroke_T) ? $request->spotStroke_T : null,
            ];

            SpotStroke::create([
                'patientCareID' => $patientCareReport->patientCareID,
                'B' => $spotStrokeData['B'],
                'F' => $spotStrokeData['F'],
                'A' => $spotStrokeData['A'],
                'S' => $spotStrokeData['S'],
                'T' => $spotStrokeData['T'],
            ]);

            $vitalsData = [
                'BP' => isset($request->vitals['bp']) ? $request->vitals['bp'] : null,
                'TEMP' => isset($request->vitals['bp']) ? $request->vitals['temp'] : null,
                'HR' => isset($request->vitals['bp']) ? $request->vitals['hr'] : null,
                'SPo2' => isset($request->vitals['bp']) ? $request->vitals['spo2'] : null,
                'RR' => isset($request->vitals['bp']) ? $request->vitals['rr'] : null,
            ];

            Vitals::create([
                'patientCareID' => $patientCareReport->patientCareID,
                'BP' => $vitalsData['BP'],
                'TEMP' => $vitalsData['TEMP'],
                'HR' => $vitalsData['HR'],
                'SPo2' => $vitalsData['SPo2'],
                'RR' => $vitalsData['RR'],
            ]);

            DB::commit(); // commit changes if db saving is success!

            return redirect()->route('patient_care.index')->with('success', 'Patient care report created successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack(); // rollback if saving to db fails
            \Log::error('Error on saving patient care report: '. $e->getMessage()); // Log details on error.
            return back()->with('error', 'Error saving patient care report.');
        }
    }

    public function show($id)
    {
        $patientCare = PatientCareReport::findOrFail($id);
        $consciousnessData = $patientCare->consciousness_lvl;
        $sampleData = $patientCare->sample_history;
        $painAssessmentData = $patientCare->pain_assessment;
        $injuryTypeData = $patientCare->injury_dtl;
        $dcapbtlsData = $patientCare->dcapbtls;
        $spotStrokeData = $patientCare->spotStroke;
        $vitalsData = $patientCare->vitals;
        // dd($vitalsData);

        $cases = map_options(PatientCareCase::class, 'id', 'description');
        $genders = map_options(Gender::class, 'id', 'description');

        $alertnessFields = create_collection(['A', 'V', 'P', 'U']);
        $sampleFields = create_collection(['S', 'A', 'M', 'P', 'L', 'E']);
        $painAssessmentFields = create_collection(['O', 'P', 'Q', 'R', 'S', 'T']);
        $dcapbtlsFields = create_collection(['D', 'C', 'A', 'P', 'B', 'T', 'L', 'S']);
        $spotStrokeFields = create_collection(['B', 'F', 'A', 'S', 'T']);

        $injuryTypeFields = [
            ['id' => 1, 'name' => 'Vehicular', 'subdata' => map_options(VehicularAccidentTypes::class, 'id', 'description')],
            ['id' => 2, 'name' => 'Fall'], ['id' => 3, 'name' => 'Cut'],
            ['id' => 4, 'name' => 'Broken'], ['id' => 5, 'name' => 'Drowning'], 
            ['id' => 6, 'name' => 'Electrecuted'], ['id' => 7, 'name' => 'Suicide'], 
            ['id' => 8, 'name' => 'Burns']
        ];
        $consciousnessStatus = [
            'A' => $consciousnessData->A ?? 0,
            'V' => $consciousnessData->V ?? 0,
            'P' => $consciousnessData->P ?? 0,
            'U' => $consciousnessData->U ?? 0,
        ];
        $vitalsFields = create_collection(['BP', 'TEMP', 'HR', 'SPo2', 'RR']);

        $patientCareReports = PatientCareReport::all();

        return view('pages.patientCareReports.view-details', compact(
            'consciousnessStatus', 'patientCareReports', 'cases', 'genders', 'patientCare', 'alertnessFields', 'sampleFields', 'sampleData', 'painAssessmentData', 'painAssessmentFields', 'injuryTypeFields', 'injuryTypeData', 'dcapbtlsData', 'dcapbtlsFields', 'spotStrokeFields', 'spotStrokeData','vitalsFields', 'vitalsData'
        ));
    }

    public function download($id)
    {
        $patientCareReport = PatientCareReport::findOrFail($id);

        $dompdf = new Dompdf();

        $html = view('pages.patientCareReports.patient-care-report-pdf', compact('patientCareReport'))->render();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        return $dompdf->stream('patient_care_report.pdf', ['Attachment' => false]);
    }
}
