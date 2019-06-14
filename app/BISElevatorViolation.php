<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISElevatorViolation extends Model
{
    //
    protected $table = 'bis_elevator_violations';

    protected $fillable = [
        'property_id',
        'b_i_s_elevator_id',
    	'device_number',
        'violation_number',
        'svr_code',
        'disposition_code',
        'disposition_date',
        'disposition_badge',

        'created_at',
        'updated_at'
    ];

    public function elevator ()
    { 
        return $this->belongsTo('App\BISElevator');
    }
}
