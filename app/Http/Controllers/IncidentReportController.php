<?php

namespace App\Http\Controllers;

use App\Models\IncidentReport;
use App\Models\IncidentCase;
use App\Models\DisasterIR;
use App\Models\ObstetricsIR;
use App\Models\MedicalIR;
use App\Models\InjuryTraumaIR;
use App\Models\DisasterIRPatients;
use App\Models\CardiaIR;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Validator;

class IncidentReportController extends Controller
{

    public function showAllReports()
    {
        $incidentReports = IncidentReport::with('incidentCase')->orderBy('date', 'desc')->get();

        return view('pages.incident.view', compact('incidentReports'));
    }

    public function create(){

        $cases = map_options(IncidentCase::class, 'id', 'description');
        $disaster_types = map_options_raw('disaster_type', 'id', 'description');
 
        return view('pages.incident.add', compact('cases', 'disaster_types'));
    }

    public function store(Request $request){

        try{

            $validator = Validator::make($request->all(), [
                'reporter_contactno' => 'required|numeric|digits_between:7,15',
            ]);

            if ($validator->fails()) {
                return back()->with('error', implode('<br>', $validator->errors()->all()));
            }

            $case = $request->incident_type;

            $coordinates = "[$request->latitude,$request->longitude]";
            $referenceCode = Str::random(8);
            
            $incidentReport = IncidentReport::create([
                'typeOfIncident' => $case,
                'incidentPlace' => $request->place,
                'landmark' => $request->landmark,
                'numberOfCasualties'=> $request->number_casualties,
                'reporterFullName' =>$request->reporter_name,
                'reporterContactNumber'=> $request->reporter_contactno,
                'referenceCode' => $referenceCode,
                'date' => $request->date,
                'time' => $request->time,
                'isConfirmed' => 0,
                'coordinates' => $case == 3 ? $coordinates : null
            ]);

            if($case == 1){

                ObstetricsIR::create([
                    'reportID' => $incidentReport->reportID,
                    'fullName' => $request->obstetrics_full_name,
                    'age' => $request->obstetrics_age,
                    'monthsPregnant' => $request->obstetrics_months_pregnant,
                    'numberOfBirths' => $request->obstetrics_number_births,
                    'prenatalCareLocation' => $request->obstetrics_prenatal_care_location,
                ]);
            } else if($case == 2){

                $medicalData = $request->medical;
                foreach($medicalData as $data){

                    MedicalIR::create([
                        'reportID' => $incidentReport->reportID, 
                        'fullName' => $data['full_name'],  
                        'shortnessOfBreath' => array_key_exists('shortness_breath', $data) ? 1 : 0 ,
                        'paleness' => array_key_exists('paleness', $data) ? 1 : 0,
                        'heartRate' => $data['heart_rate'],
                    ]);
                }
               
            }else if($case == 3){

                $injury_traumaData = $request->injury_trauma;
                foreach($injury_traumaData as $data){
                    InjuryTraumaIR::create([
                        'reportID' => $incidentReport->reportID, 
                        'fullName' => $data['full_name'],  
                        'shortnessOfBreath' => array_key_exists('shortness_breath', $data) ? 1 : 0 ,
                        'paleness' => array_key_exists('paleness', $data) ? 1 : 0,
                        'heartRate' => $data['heart_rate'],
                    ]);
                }
               
            }else if($case == 4){

                $cardiaData = $request->cardia;
                foreach($cardiaData as $data){
                    CardiaIR::create([
                        'reportID' => $incidentReport->reportID, 
                        'fullName' => $data['full_name'],  
                        'shortnessOfBreath' => array_key_exists('shortness_breath', $data) ? 1 : 0 ,
                        'paleness' => array_key_exists('paleness', $data) ? 1 : 0,
                        'heartRate' => $data['heart_rate'],
                    ]);
                }
               
            }else if($case == 5){

                $path = null;
                if ($request->hasFile('disaster_image') && $request->file('disaster_image')->isValid()){

                    $request->validate([
                        'disaster_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', 
                    ]);
    
                    $file = $request->file('disaster_image');
                    $extension = $file->getClientOriginalExtension();
                    $formattedDateTime = Carbon::now()->format('Y-m-d_H-i-s');
    
                    // customized file name using date and reporter_name
                    $fileName = $formattedDateTime . '_' . $request->reporter_name . '.' . $extension;
    
                    $path = $file->storeAs('incident', $fileName, 'public');
                  
                }
                
                DisasterIR::create([
                    'reportID' => $incidentReport->reportID, 
                    'photoPathFile' => $path,  
                    'description' => $request->description ,
                    'disasterTypeID' => $request->disaster_type,
                ]);

                $disasterData = $request->disaster;
                foreach($disasterData as $data){

                    DisasterIRPatients::create([
                        'reportID' => $incidentReport->reportID, 
                        'fullName' => $data['full_name'],  
                        'shortnessOfBreath' => array_key_exists('shortness_breath', $data) ? 1 : 0 ,
                        'paleness' => array_key_exists('paleness', $data) ? 1 : 0,
                        'heartRate' => $data['heart_rate'],
                    ]);
                }

            }

            $sms_incident_type = IncidentCase::where('id', $case)->pluck('description')[0];
            $sms_incident_location = $request->place;
            $sms_reported_by = $request->reporter_name;
            $sms_incident_time = $request->time;

            $this->sendSms($sms_incident_type, $sms_incident_location, $sms_reported_by, $sms_incident_time);

            return redirect()->route('landingPage')->with('success', 'Keep this code for report monitoring. Reference Code:    ' . $referenceCode . "");

        }catch(\Exception $e){
            \Log::error('Error: '. $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function sendSms($sms_incident_type, $sms_incident_location, $sms_reported_by, $sms_incident_time)
    {
        $twilioService = app(TwilioService::class);

        $phoneNumbers = explode(',', env('SMSNUMBERS'));
        
        $message = "New Incident Report - Type: " . $sms_incident_type . ", By: " . $sms_reported_by;

        foreach ($phoneNumbers as $to) {
            $response = $twilioService->sendSms($to, $message);
        }

        return response()->json(['status' => 'OK']);
    }

    // Deleteincident report
    public function delete($type, $id)
    {
        try{
           
            $incidentReport = IncidentReport::findOrFail($id);

            if($type == 1){ 

                $incidentReport->deleteObstetrics()->where('reportID', $id)->delete();
    
            }else if($type == 2){ 
                
                $incidentReport->deleteMedical()->where('reportID', $id)->delete();
    
            }else if($type == 3) {
    
                $incidentReport->deleteInjury_trauma()->where('reportID', $id)->delete();
    
            }else if($type == 4){
    
                $incidentReport->deleteCardia()->where('reportID', $id)->delete();
            }else if($type == 5){

                $incidentReport->deleteDisaster()->where('reportID', $id)->delete();

            }else{
                return back()->with('error', 'No data found');
            }

            $incidentReport->delete();

            return redirect()->back()->with('success', 'Incident report deleted successfully.');

        }catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }


    }

   // display a specific incident report
    public function showReport($type, $id)
    {
        try{
            if($type == 1){ 

                $incidentReport = IncidentReport::with('obstetrics')->where('reportID', $id)->get()[0];
    
            }else if($type == 2){ 
                
                $incidentReport = IncidentReport::with('medical')->where('reportID', $id)->get()[0];
    
            }else if($type == 3) {
    
                $incidentReport = IncidentReport::with('injury_trauma')->where('reportID', $id)->get()[0];
    
            }else if($type == 4){
    
                $incidentReport = IncidentReport::with('cardia')->where('reportID', $id)->get()[0];
            
            }else if($type == 5){

                $incidentReport = IncidentReport::with(['disaster.disasterType', 'disaster_patients'])->where('reportID', $id)->first();
            }else{
                return back()->with('error', 'No data found');
            }

            return view('pages.incident.details', compact('incidentReport'));
        }catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function confirmReport($id){

        try {
            $incident = IncidentReport::findOrFail($id);

            if($incident){
                $incident->update([
                    'isConfirmed' => 1
                ]);
            }else{
                return back()->with('error', 'No data found');
            }

            return redirect()->back()->with('success', 'The incident report has been successfully confirmed.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    //   generate  monthly incident report, BUILT-IN
    public function generateMonthlyReport(Request $request)
    {
        $selectedMonth = $request->query('month');

        if (!$selectedMonth) {
            return redirect()->back()->with('error', 'Please select a valid month.');
        }

        [$year, $month] = explode('-', $selectedMonth);

        $reports = IncidentReport::with(['incidentCase', 'obstetrics','medical', 'injury_trauma', 'cardia', 'disaster', 'disaster_patients'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()->toArray();
        // dd($reports);
        if(empty($reports)){
            return redirect()->back()->with('error', 'No data found for the specified month.');
        }

        // Convert the date to a Carbon instance
        foreach ($reports as $report) {
            $report['date'] = Carbon::parse($report['date']);
        }

        $csvData = $this->convertToCsv($reports);

        $fileName = "reports_{$year}_{$month}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->make($csvData, 200, $headers);
    }

    private function convertToCsv($data)
    {
        $tempFile = tmpfile();


        if (!empty($data)) {

            fputcsv($tempFile, [
                'ID', 'Date', 'Time', 'Incident Place', 'Landmark', 'Number of Casualties', 'Reporter Name', 'Reporter ContactNo', 'Incident Type',
                'Patient Name', 'OB Age', 'OB Month/s Pregnant', 'OB Number of Births', 'OB Parental Care Location', //obstetrics
                'Heart Rate', 'Shortness of Breath', 'Paleness', 'Disaster Description'
            ]);
        
            foreach ($data as $row) {
                $groups = ['medical', 'injury_trauma', 'cardia', 'disaster_patients'];
                $hasRows = false;
        
                foreach ($groups as $group) {
                    if (isset($row[$group]) && is_array($row[$group])) {
                        foreach ($row[$group] as $entry) {
                            $hasRows = true;
                            fputcsv($tempFile, [
                                $row['reportID'],
                                $row['date'],
                                $row['time'],
                                $row['incidentPlace'],
                                $row['landmark'],
                                $row['numberOfCasualties'],
                                $row['reporterFullName'],
                                $row['reporterContactNumber'],
                                $row['incident_case']['description'],
                                $entry['fullName'] ?? '',
                                $row['obstetrics']['age'] ?? '',
                                $row['obstetrics']['monthsPregnant'] ?? '',
                                $row['obstetrics']['numberOfBirths'] ?? '',
                                $row['obstetrics']['prenatalCareLocation'] ?? '',
                                $entry['heartRate'] ?? '',
                                isset($entry['shortnessOfBreath']) && $entry['shortnessOfBreath'] == 1 ? '/' : '',
                                isset($entry['paleness']) && $entry['paleness'] == 1 ? '/' : '',
                                $row['disaster']['description'] ?? '' 
                            ]);
                        }
                    }
                }
        
                // single row 
                if (!$hasRows) {
                    fputcsv($tempFile, [
                        $row['reportID'],
                        $row['date'],
                        $row['time'],
                        $row['incidentPlace'],
                        $row['landmark'],
                        $row['numberOfCasualties'],
                        $row['reporterFullName'],
                        $row['reporterContactNumber'],
                        $row['incident_case']['description'],
                        $row['obstetrics']['fullName'] ?? '',
                        $row['obstetrics']['age'] ?? '',
                        $row['obstetrics']['monthsPregnant'] ?? '',
                        $row['obstetrics']['numberOfBirths'] ?? '',
                        $row['obstetrics']['prenatalCareLocation'] ?? '',
                        '','','',
                        $row['disaster']['description'] ?? '' 
                    ]);
                }
            }
        }
        


        rewind($tempFile);
        $csvData = stream_get_contents($tempFile);
        fclose($tempFile);

        return $csvData;
    }

    public function findReport(Request $request) {

        $request->validate([
            'searchIncident' => 'required|string'
        ]);

        $status = IncidentReport::where('referenceCode', $request->searchIncident)
                                ->pluck('isConfirmed')
                                ->first();
        // return [$status];
        // Check if a record was found
        if ($status !== null) {
            return response()->json(['message' => $status == 1 ? 'The incident report has been confirmed.' : 'The incident report is still pending.']);
        }

        return response()->json(['message' => 'No incident found with the provided reference code.']);
        
        // Check the status value and return the corresponding message
        // if ($status === 1) {
        //     return response()->json(['message' => 'The report has been verified and confirmed.']);
        // } elseif ($status === 0) {
        //     return response()->json(['message' => 'The report is pending.']);
        // } else {
        //     return response()->json(['message' => 'Report not found or status is unknown.']);
        // }
    }
    
}
