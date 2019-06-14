<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISDirective14Applicant extends Model
{
    //
    protected $table = 'b_i_s_directive14_applicants';

    protected $fillable = [
    	'bis_job_application_id',
        'd14appInfo',
        'name',
        'business_name',
        'business_phone',
        'business_address',
        'business_email',
        'mobile_phone',
        'applicant_type',
        'license_number',

        'created_at',
        'updated_at'
    ];

    public function job_application ()
    {
    	return $this->belongsTo('App\BISJobApplication');
    }
}
