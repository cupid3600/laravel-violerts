<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISIlluminatedSign extends Model
{
    //
    protected $table = 'b_i_s_illuminated_signs';

    protected $fillable = [
    	'property_id',
        # modified by kemel
        'uri',
        'job_number', 
        'job_number_uri',
        'seq_no', 
        # end of kemel modification
    	'added_on',
    	'last_modified',
    	'address',
    	'zip',
    	'bbl_seqno',
    	'sign_wording',
    	'illumination',
    	'square_footage',
    	'amount_due',
    	'bin',
    	'last_billed_on',
    	'last_bill_amount',
    	'billing_code',
    	'last_permit_issued',
    	'permit_code',
    	'annual_permit_number',
    	'expires',
    	'comment',
    	'owner_last_name',
    	'owner_first_name',
    	'owner_business',
    	'owner_address',

    	'created_at',
    	'updated_at'
    ];

    public function property ()
    {
    	return $this->belongsTo('App\Property');
    }
}
