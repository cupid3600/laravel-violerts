<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ACRISPPL extends Model
{
    //
    protected $table = 'acris_ppls'; 

    protected $fillable = [ 
    	'property_id', 
    	'document_id', 
    	'record_type', 
    	'borough', 
    	'block', 
    	'lot', 
    	'easement', 
    	'partial_lot', 
    	'air_rights', 
    	'subterranean_rights', 
    	'property_type', 
    	'street_number', 
    	'street_name', 
    	'addr_unit', 
    	'good_through_date',
    	'updated_at', 
    	'created_at'
    ];

    public function property () 
    { 
        return $this->belongsTo('App\Property');
    }
}
