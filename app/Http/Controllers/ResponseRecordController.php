<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Gender;
use App\Models\PatientCareReport;
use Illuminate\Http\Request;
use App\Models\ResponseRecord;
use App\Models\IncidentReport;
use Carbon\Carbon;
use App\Exports\MonthlyReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ResponseRecordController extends Controller
{
    public function index()
    {
        $responseRecords = ResponseRecord::all();

        return view('pages.responseRecords.view', compact('responseRecords'));
    }
  
    public function create()
    {
        $cases = map_options(Cases::class, 'id', 'description');
        $genders = map_options(Gender::class, 'id', 'description');

        return view('pages.responseRecords.add', compact( 'cases', 'genders'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'date' => 'required|date',
                'time' => 'nullable|string|max:50',
                'incidentFrom' => 'required|string|max:50',
                'takenTo' => 'required|string|max:50',
                'callerOrReporter' => 'nullable|string|max:50',
                'patientName' => 'required|string|max:50',
                'patientAge' => 'nullable|integer',
                'patientAddress' => 'nullable|string|max:50',
                'patientCase' => 'required|string|max:50',
                'patientGender' => 'required|string|max:50',
                'responders' => 'required|string|max:255',
                'actionTaken' => 'nullable|string|max:50',
                'remarks' => 'nullable|string|max:50',
            ]);
    
            ResponseRecord::create($request->all());
    
            return redirect()->route('response_records.index')->with('success', 'Response Record created successfully.');
        }catch(\Exception $e) {
            \Log::error('Error on saving response record: '.$e->getMessage());
            return redirect()->back()->with('error','Oh no! An error occured.');
        }
    }

    //display specific record
    public function edit($id)
    {
        $record = ResponseRecord::findOrFail($id);

        $cases = map_options(Cases::class, 'id', 'description');
        $genders = map_options(Gender::class, 'id', 'description');

        return view('pages.responseRecords.edit', compact('record', 'cases', 'genders'));
    }

    //update record
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|string|max:50',
            'incidentFrom' => 'required|string|max:50',
            'takenTo' => 'required|string|max:50',
            'callerOrReporter' => 'required|string|max:50',
            'patientName' => 'required|string|max:50',
            'patientAge' => 'required|integer',
            'patientAddress' => 'required|string|max:50',
            'patientCase' => 'required|string|max:50',
            'patientGender' => 'required|string|max:50',
            'responders' => 'required|string|max:50',
            'actionTaken' => 'required|string|max:50',
            'remarks' => 'nullable|string|max:50',
        ]);

        $record = ResponseRecord::findOrFail($id);
        $record->update($request->all());

        return redirect()->route('response_records.index')->with('success', 'Response Record updated successfully.');
    }

    //download the specified response record as a file (PDF).
    public function download($id)
    {
        $record = ResponseRecord::findOrFail($id);
        
        $pdf = app('dompdf.wrapper')->loadView('response_records.pdf', compact('record'));

        return $pdf->download("response_record_{$id}.pdf");
    }

    public function patient_care_response_create($id)
    {
        $locations = [
            ['id' => 1, 'name' => 'location 1'],
            ['id' => 2, 'name' => 'location 2'],
        ];
        $cases = map_options(Cases::class, 'id', 'description');
        $genders = map_options(Gender::class, 'id', 'description');

        $data = PatientCareReport::findOrFail($id);

        if (!$data)
        {
            return redirect()->back()->with('error', 'Patient care report not found!');
        }

        return view('pages.responseRecords.add', compact('data', 'locations', 'cases', 'genders'));
    }

    public function incident_response_create($type, $id){

        if($type == 1){ 

            $data = IncidentReport::with('obstetrics')->where('reportID', $id)->get()[0];

        }else if($type == 2){ 
            
            $data = IncidentReport::with('medical')->where('reportID', $id)->get()[0];

        }else if($type == 3) {

            $data = IncidentReport::with('injury_trauma')->where('reportID', $id)->get()[0];

        }else if($type == 4){

            $data = IncidentReport::with('cardia')->where('reportID', $id)->get()[0];
        }else{
            return back()->with('error', 'No data found');
        }
        
        $locations = [
            ['id' => 1, 'name' => 'location 1'],
            ['id' => 2, 'name' => 'location 2'],
        ];
        $cases = map_options(Cases::class, 'id', 'description');
        $genders = map_options(Gender::class, 'id', 'description');

        return view('pages.responseRecords.add_incident', compact('data', 'locations', 'cases', 'genders'));
    }

    //generate monthly - THIRD PARTY PACKAGE
    public function generateMonthlyReport(Request $request)
    {
        $selectedMonth = $request->query('month');

        if (!$selectedMonth) {
            return redirect()->back()->with('error', 'Please select a valid month.');
        }

        [$year, $month] = explode('-', $selectedMonth);

        $reports = ResponseRecord::with(['gender', 'case'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->map(function ($report) {
                return [
                    $report->responseID,
                    $report->date,
                    $report->time,
                    $report->incidentFrom,
                    $report->takenTo,
                    $report->callerOrReporter,
                    $report->patientName,
                    $report->patientAge,
                    $report->gender->description ?? '',
                    $report->patientAddress,
                    $report->case->description ?? '',
                    $report->responders,
                    $report->actionTaken,
                    $report->remarks,
                ];
            })
            ->toArray();

        if (empty($reports)) {
            return redirect()->back()->with('error', 'No data found for the specified month.');
        }

        $fileName = "Monthly_Report_{$year}_{$month}.xlsx";

        return Excel::download(new MonthlyReportExport($reports), $fileName);
    }

}
