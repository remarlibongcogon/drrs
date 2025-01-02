<?php

namespace App\Http\Controllers;

use App\Models\InKindDonation;
use App\Models\CashDonation;
use App\Models\DonationMode;
use App\Models\ECashDonation;
use App\Models\DonationCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DonationController extends Controller
{
    public function create(){

        $type = [
            ['id' => 1, 'name' => 'Cash'],
            ['id' => 2, 'name' => 'In-kind']
        ];

        $donation_mode = map_options(DonationMode::class, 'id', 'description');
        $categories = map_options(DonationCategory::class, 'id', 'description');

        return view ('pages.donation.add', compact('type', 'donation_mode', 'categories'));
    }

    public function store(Request $request){
        
        try{
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|string|max:255',
                'contactno' => 'required|string|regex:/^[0-9]{10,11}$/',
                'donationMode' => 'required|integer', 
            ]);
    
            if ($validator->fails()) {
                return back()->with('error', implode('<br>', $validator->errors()->all()));
            }

            if($request->donationMode == 3){
                // dd($request->proof_of_donation);
                $validator = Validator::make($request->all(), [
                    'proof_of_donation' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', 
                ]);

                if ($validator->fails()) {
                    return back()->with('error', implode('<br>', $validator->errors()->all()));
                }

                $file = $request->file('proof_of_donation');
                $extension = $file->getClientOriginalExtension();
                $formattedDateTime = Carbon::now()->format('Y-m-d_H-i-s');

                // customized file name using date and donor_name
                $fileName = $formattedDateTime . '_' . $request->fullname . '.' . $extension;

                $path = $file->storeAs('donation', $fileName, 'public');

                ECashDonation::create([
                    'fullname' => $request->fullname, 
                    'contactno' => $request->contactno, 
                    'donationMode' => $request->donationMode, 
                    'proof_of_donation' => $path,
                    'amount' => $request->amount,
                    'isPickUp' => 0
                ]);

            }else{

                $validator = Validator::make($request->all(), [
                    'donation_type' => 'required|integer',
                ]);

                if($request->donation_type == 2){
    
                    $validator = Validator::make($request->all(), [
                        'definition' => 'required|string',
                        'proof_of_donation' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', 
                    ]);
        
                    if ($validator->fails()) {
                        return back()->with('error', implode('<br>', $validator->errors()->all()));
                    }

                    $file = $request->file('proof_of_donation');
                    $extension = $file->getClientOriginalExtension();
                    $formattedDateTime = Carbon::now()->format('Y-m-d_H-i-s');

                    // customized file name using date and donor_name
                    $fileName = $formattedDateTime . '_' . $request->fullname . '.' . $extension;

                    $path = $file->storeAs('donation', $fileName, 'public');
        
                    InKindDonation::create([
                        'fullname' => $request->fullname, 
                        'contactno' => $request->contactno, 
                        'donationMode' => $request->donationMode, 
                        'definition' => $request->definition, 
                        'proof_of_donation' => $path,
                        'isPickUp' => 0
                    ]);
        
                }else{
                    CashDonation::create([
                        'fullname' => $request->fullname, 
                        'contactno' => $request->contactno, 
                        'donationMode' => $request->donationMode, 
                        'amount' => $request->amount, 
                        'isPickUp' => 0 
                    ]);
                }
            }            
    
            return redirect()->route('create.donation')->with('success', 'Your donation has been successfully submitted. Thank you for your kind contribution and support!');

        }catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function index(){
        
        try {
            $donation_mode = map_options_raw('donation_mode', 'id', 'description');

            $type = [
                ['id' => 1, 'name' => 'Cash'],
                ['id' => 2, 'name' => 'In-kind'],
                ['id' => 3, 'name' => 'E-cash']
            ];

            $cashDonations = CashDonation::get_data();
            $inkindDonations = InKindDonation::get_data();
            $ecashDonations = ECashDonation::get_data();
            // dd($ecashDonations);

            // dd($inkindDonations, $cashDonations);
            return view('pages.secretary.index', compact('type', 'donation_mode', 'cashDonations', 'inkindDonations', 'ecashDonations'));

        }catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function view($type, $id){
        
        $data = $type == 1 ? CashDonation::get_data($id) : InKindDonation::get_data($id);

        $donation = $data ?? $data[0];

        return view('pages.donation.view_donation', compact('donation', 'type'));
    }

    public function pickup_donation(Request $request){
        
        try{
            $type = $request->type;
            $id = $request->id;

            $models = [
                1 => CashDonation::class,
                2 => InKindDonation::class,
                3 => ECashDonation::class,
            ];
            
            $data = isset($models[$type]) ? $models[$type]::find($id) : null;

            $data->update([
                'isPickUp' => 1
            ]);

            // return redirect()->route('donations')->with('success', 'Donation pickup successfully confirmed.');
            return response()->json([
                'success' => true,
                'message' => 'Donation Received!'
            ]);
            
        } catch(\Exception $e) {
            // return back()->with('error', $e->getMessage());

            return response()->json([
                'success' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function print_donation_report($type, $id){
        
        $models = [
            1 => CashDonation::class,
            2 => InKindDonation::class,
            3 => ECashDonation::class,
        ];
    
        $data = isset($models[$type]) ? $models[$type]::get_data($id) : [];

        $datas = $data[0];

        $pdf = app('dompdf.wrapper')->loadView('pages.donation.donation_report', compact('datas', 'type'))
                ->setPaper([0, 0, 612, 792], 'portrait');
   
        // download the generated PDF
        return $pdf->download('donation_' . $datas['fullname'] . '.pdf');
    }
}
