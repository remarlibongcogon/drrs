<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DonationMode;

class CashDonation extends Model
{
    protected $table = 'cash_donations';

    protected $primaryKey = 'donationID';

    public $timestamps = true;

    protected $fillable = [
        'fullname',
        'contactno',
        'donationMode',
        'amount',
        'isPickUp'
    ];

    public static function get_data($id = null){
        $query =  CashDonation::leftJoin('donation_mode', 'cash_donations.donationMode', '=', 'donation_mode.id')
                        ->select('cash_donations.*', 'donation_mode.description as donationModeDesc')
                        ->orderBy('cash_donations.created_at', 'desc');

        if (!is_null($id)) {
            $query->where('cash_donations.donationID', $id);
        }
    
        return $query->get()->toArray();
     }

  
}
