<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISBoilerInspection extends Model
{
    //
    protected $table = 'bis_boiler_inspections';

    protected $fillable = [
    	'boiler_number',
        'bis_boiler_id',
    	'bin',
    	'inspection_date',
    	'rec_date',
    	'entry_date',
    	'name',
    	'int_ext',
    	'results',
    	'nys_certificate',

        'created_at',
        'updated_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\BISBoiler');
    }
}
