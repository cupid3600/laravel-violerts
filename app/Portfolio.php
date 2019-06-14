<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    //
    protected $table = 'portfolios'; 

    protected $fillable = [ 
    	'user_id', 
    	'property_id',
        'airtable_base_id',
        'airtable_key_id',
        'init_summary',
        'email_alerts_enabled', 
        'sms_alerts_enabled', 
        'airtable_enabled',
    	'created_at', 
    	'updated_at'
    ];

    public function user () 
    { 
    	return $this->belongsTo('App\User');
    }

    public function property ()
    { 
        return $this->belongsTo('App\Property');
    }

    public function AirtableAccount ()
    { 
        return $this->belongsTo('App\AirtableApiKey', 'id', 'airtable_key_id');
    }
}
