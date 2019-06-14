<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISPlumbingInspectionWorkOrder extends Model
{
    //
    protected $table = 'b_i_s_plumbing_inspection_work_orders';

    protected $fillable = [
    	'property_id',
        //update by kemel - needs to be add to migration
        'work_order_number', 
        //end of update by kemel
    	'licensee',
    	'work_description',
    	'inspector_badge',
    	'date_inspected',
    	'inspection_results',
    	'num_meters',
    	'num_meters_location',
    	'num_risers',
    	'num_risers_location',
    	'gas_uses',
    	'comments',
    	'floor_apts_insp_area',
    	'date_of_inspection',
    	'time_scheduled',
    	'inspection_reference_num',
    	'status',
    	'type',
    	'accela_inspection_num',
    	'results_floor',
    	'results_ref_no',
    	'results_system',
    	'results_component',
    	'results_test_inspection',
    	'results_result',

    	'created_at',
    	'updated_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }
}
