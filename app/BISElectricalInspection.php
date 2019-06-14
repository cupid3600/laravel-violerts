<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISElectricalInspection extends Model
{
    //
    protected $table = 'b_i_s_electrical_inspections';

    protected $fillable = [
    	'property_id',
    	'bis_electrical_id',
    	'insp_id',
		'field_date',
		'disp_date',
		'fld_disp',
		'obj_disp',
		'enrg_rec',
		'time_insp',
		'reinsp_date',
		'new_obj',
		'appt_flag',
		'inspection_comments',

		'created_at',
		'updated_at'
    ];
    
    public function bis_electrical ()
    {
    	return $this->belongsTo('App\BISElectrical');
    }
}
