<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISBoiler extends Model
{
    //
    protected $table = 'bis_boilers';

    protected $fillable = [
        'property_id',
    	'viol',
    	'num',
    	'uri',
    	'md',
    	'serial_number',
    	'status',
    	'last_insp_date',
    	'last_recv_date',
    	'name',
    	'boiler_no',
    	'type',
    	'review_required',
    	'filed_at',
    	'bin',
    	'bbl',
    	'located_in',
    	'make_of_boiler',
    	'year',
    	'over6',
    	'no_of_boilers',
    	'fee',
    	'school',

        'created_at',
        'updated_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }

    public function bis_boiler_inspections ()
    {
    	return $this->hasMany('App\BISBoilerInspection');
    }
}
