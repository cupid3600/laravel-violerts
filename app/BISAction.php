<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISAction extends Model
{
    //
    protected $table = 'b_i_s_actions';

    protected $fillable = [
    	'property_id',
    	'number',
    	'number_uri',
    	'type',
    	'file_date',
    	'pdf_page_uri',
    	'lno_use',
    	'lno_floor',
    	'comments',
    	'dismissal_date',
    	'closure_date',
    	'agency_license',
    	'badge_number',

        'created_at',
        'updated_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }
}
