<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ECashDonation extends Model
{
    protected $table = 'ecash_donations';

    protected $primaryKey = 'donationID';

    public $timestamps = true;

    protected $fillable = [
        'fullname',
        'contactno',
        'donationMode',
        'proof_of_donation',
        'amount',
        'isPickUp'
    ];

    public static function get_data($id = null){
        $query =  ECashDonation::leftJoin('donation_mode', 'ecash_donations.donationMode', '=', 'donation_mode.id')
                        ->select('ecash_donations.*', 'donation_mode.description as donationModeDesc')
                        ->orderBy('ecash_donations.donationID', 'DESC');

        if (!is_null($id)) {
            $query->where('ecash_donations.donationID', $id);
        }
    
        return $query->get()->toArray();
     }
}
