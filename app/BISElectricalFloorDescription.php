<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISElectricalFloorDescription extends Model
{
    //
    protected $table = 'b_i_s_electrical_floor_descriptions';

    protected $fillable = [
    	'property_id',
    	'bis_electrical_id',

    	'floor',
        'apt',
        'fixt',
        'att',
        'ac',
        'switch',
        'num_fixtures',
        'motors_generators_num',
        'motors_generators_total_hp_kw',
        'heaters_num',
        'heaters_total_kw',
        'transformers_num',
        'transformers_total_kva',

    	'created_at',
    	'updated_at'
    ];

    public function bis_electrical ()
    {
    	return $this->belongsTo('App\BISElectrical');
    }
}
