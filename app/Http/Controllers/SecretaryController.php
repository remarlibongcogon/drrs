<?php

namespace App\Http\Controllers;

use App\Models\CashDonation;
use App\Models\InKindDonation;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecretaryController extends Controller
{
    public function index(){
        
        $donation_mode = map_options_raw('donation_mode', 'id', 'description');
        $categories = map_options_raw('donation_category', 'id', 'description');

        $type = [
            ['id' => 1, 'name' => 'Cash'],
            ['id' => 2, 'name' => 'In-kind']
        ];

        $cashDonations = CashDonation::get_data();
        $inkindDonations = InKindDonation::get_data();

        // dd($inkindDonations, $cashDonations);
        return view('pages.secretary.index', compact('type', 'donation_mode', 'categories', 'cashDonations', 'inkindDonations'));
    }

    public function view($type, $id){
        
        $data = $type == 1 ? CashDonation::get_data($id) : InKindDonation::get_data($id);

        $donation = $data[0];
        // dd($donation);
        return view('pages.donation.view_donation', compact('donation', 'type'));
    }

    public function pickup_donation($type, $id){
        
        try{
            $data = $type == 1 ?  CashDonation::find($id) : InKindDonation::find($id);

            $data->update([
                'isPickUp' => 1
            ]);

            return redirect()->route('donations')->with('success', 'Donation pickup successfully confirmed.');

        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    public function print_donation_report($type, $id){
        $data = $type == 1 ? CashDonation::get_data($id) : InKindDonation::get_data($id);
        $datas = $data[0];
        // dd($datas);
        $pdf = app('dompdf.wrapper')->loadView('pages.donation.donation_report', compact('datas'))
                ->setPaper('A5', 'portrait');;

        // Download the generated PDF
        return $pdf->download('invoice_' . $datas['fullname'] . '.pdf');
    }
}
