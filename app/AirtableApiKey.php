<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirtableApiKey extends Model
{
    //
	protected $table = 'airtable_api_key';

    protected $fillable = [ 
    	'user_id', 
    	'key', 
    	'name', 
    	'created_at',
    	'updated_at'
    ];

    public function user ()
    { 
    	return $this->belongsTo('App\User');
    }

    public function airtable_bases () 
    { 
    	return $this->hasMany('App\Portfolio', 'airtable_key_id', 'id');
    }
}
