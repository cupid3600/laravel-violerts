<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISElevator extends Model
{
    //
    protected $table = 'bis_elevators';

    protected $fillable = [
    	'property_id',
        'elevator_inspections_uri',
        'elevator_violations_uri',
        'elevator_record_number',
        'elevator_devices_uri',
        'device_number',
        'device_number_uri',
        'device_type',
        'record',
        'device_status',
        'status_date',
        'stat_comm',
        'approval_date',
        'alteration',
        'floor_from',
        'floor_to',
        'travel_distance',
        'speed_fpm',
        'car_entrances',
        'capacity_lbs',
        'hoist_ropes_quantity',
        'hoist_ropes_size',
        'hoist_ropes_kind',
        'car_cntwt_ropes_quantity',
        'car_cntwt_ropes_size',
        'car_cntwt_ropes_kind',
        'machn_cntwt_ropes_quantity',
        'machn_cntwt_ropes_size',
        'machn_cntwt_ropes_kind',
        'backdrum_ropes_quantity',
        'backdrum_ropes_size',
        'backdrum_ropes_kind',
        'governor_ropes_quantity',
        'governor_ropes_size',
        'governor_ropes_kind',
        'governor_type',
        'safety_type',
        'machine_type',
        'mode_operation',
        'car_buffer_type',
        'firemans_service',
        'working_pressure',
        'manufacturer',
        'status',

        'created_at',
        'updated_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }

    public function violations ()
    {
    	return $this->hasMany('App\BISElevatorViolation');
    }

    public function inspections ()
    {
        return $this->hasMany('App\BISElevatorInspection');
    }
}
