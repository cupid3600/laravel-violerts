<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISElevatorInspection extends Model
{
    //
    protected $table = 'bis_elevator_inspections';

    protected $fillable = [
        'property_id',
        'b_i_s_elevator_id',
    	'device_number',
    	'inspection_date',
    	'inspection_type',
    	'inspection_disposition',
    	'inspected_by',
    	'performing_elevator_agency',
    	'witnessing_elevator_agency',
    	'remarks',

        'created_at',
        'updated_at'
    ];

    public function elevator ()
    { 
        return $this->belongsTo('App\BISElevator');
    }
}
