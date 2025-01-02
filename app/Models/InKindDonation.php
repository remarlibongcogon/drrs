<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InKindDonation extends Model
{
    protected $table = 'inkind_donations';

    protected $primaryKey = 'donationID';

    public $timestamps = true;

    protected $fillable = [
        'fullname',
        'contactno',
        'donationMode',
        'definition',
        'proof_of_donation',
        'isPickUp'
    ];

    public static function  get_data($id = null){

        $query = InKindDonation::leftJoin('donation_mode', 'inkind_donations.donationMode', '=', 'donation_mode.id')
                ->select('inkind_donations.*', 'donation_mode.description as donationModeDesc')
                ->orderBy('inkind_donations.created_at', 'desc');
        
        if (!is_null($id)) {
            $query->where('inkind_donations.donationID', $id);
        }
    
        return $query->get()->toArray();
        
    }
}
