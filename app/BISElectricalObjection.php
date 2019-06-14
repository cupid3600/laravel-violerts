<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISElectricalObjection extends Model
{
    //
    protected $table = 'b_i_s_electrical_objections';

    protected $fillable = [
    	'property_id',
    	'bis_electrical_id',
    	'objection_id',
    	'objection_code',
    	'objection_description_comments',
    	'stat',
    	'first',
    	'latest',
    	'reslvd',

    	'created_at',
    	'updated_at'
    ];

    public function bis_electrical ()
    {
    	return $this->belongsTo('App\BISElectrical');
    }
}
