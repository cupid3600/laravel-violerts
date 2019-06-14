<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TOOComplaint extends Model
{
    //
    protected $table = 'too_complaints'; 


    protected $fillable = [ 
        'property_id',
        'unique_key',
        'created_date',
        'closed_date',
        'agency',
        'agency_name',
        'complaint_type',
        'descriptor',
        'location_type',
        'incident_zip',
        'incident_address',
        'street_name',
        'cross_street_1',
        'cross_street_2',
        'intersection_street_1',
        'intersection_street_2',
        'address_type',
        'city',
        'landmark',
        'facility_type',
        'status',
        'due_date',
        'resolution_description',
        'resolution_action_updated_date',
        'community_board',
        'bbl',
        'borough',
        'x_coordinate_state_plane',
        'y_coordinate_state_plane',
        'open_data_channel_type',
        'latitude',
        'longitude',

        'created_at',
        'updated_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }
}
