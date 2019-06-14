<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISFacade extends Model
{
    //
    protected $table = 'bis_facades'; 

    protected $fillable = [
        'property_id',
    	'cycle',
    	'sub_cycle',
    	'control_number',
    	'control_number_uri',
    	'filed_at',
    	'seq_no',
    	'submitted_on',
    	'current_status',
    	'applicant_name',
    	'nys_license_number',
    	'applicant_business',
    	'owner_name',
    	'owner_business',
    	'exterior_wall_types',
    	'late_filing',
    	'late_filing_amount',
    	'late_filing_fee_paid',
    	'failure_to_file',
    	'failure_to_file_amount',
    	'failure_to_file_fee_paid',
    	'failure_to_correct',
    	'failure_to_correct_amount',
    	'failure_to_correct_fee_paid',
    	'initial_filing_date',
    	'initial_filing_status',
    	'amended_filing_date',
    	'amended_filing_status',
    	'subsequent_filing_date',
    	'subsequent_filing_status',
    	'prior_cycle_filing_date',
    	'prior_status',
    	'field_inspection_completed_date',
    	'qewi_signed_date',
    	
    	'house_number',
    	'street_name',
    	'bbl_seqno',
    	'bin',
    	'num_stories',
    	'init_file_date',
        'created_at',
        'updated_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }
}
