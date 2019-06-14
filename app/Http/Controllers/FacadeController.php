<?php

namespace App\Http\Controllers;

use App\Property; 
use App\BISFacade;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FacadeController extends Controller
{
    //
    public function getFacades (Request $request, $Id)
    { 
    	$property = Property::find($Id); 
    	if(!is_null($property)){ 
    		$client = new Client(); 
    		$request = $client->post(env('DOB_BIS_API').'/property/dob-api/facades/index', [ 
    			'form_params' => $property->facades_uri
    		]);
    		$response = $request->getBody()->getContents(); 
    		if(!is_null($response)){ 
    			foreach($response->facades as $facade){ 
    				$newFacade = BISFacade::create([ 
    					'property_id' $property->id, 
    					'cycle' => $facade->cycle, 
    					'sub_cycle' => $facade->sub_cycle, 
    					'control_number' => $facade->control_number, 
    					'control_number_uri' => $facade->control_number_uri, 
    					'house_number' => $facade->house_number, 
    					'street_name' => $facade->street_name, 
    					'bbl_seqno' => $facade->bbl_seqno, 
    					'current_status' => $facade->current_status, 
    					'bin' => $facade->bin, 
    					'num_stories' => $facade->num_stories, 
    					'init_file_date' => $facade->init_file_date
    				]);
    			}
    		}

    		$facades = BISFacade::where('property_id', $property->id)->get();
    		if(count($facades) > 0){ 
    			foreach ($facades as $facade) { 
    				$client = new Client();
	    			$request = $client->post(env('DOB_BIS_API').'/property/dob-api/facades/record', [ 
	    				'form_params' => $facade->control_number_uri
	    			]);
	    			$response = $request->getBody()->getContents(); 
	    			if(!is_null($response)){ 
	    				$facade->filed_at = $response->filed_at;
	    				$facade->seq_no = $response->seq_no;
	    				$facade->submitted_on = $response->submitted_on;
	    				$facade->current_status = $response->current_status;
	    				$facade->applicant_name = $response->applicant_name;
	    				$facade->nys_license_number = $response->nys_license_number;
	    				$facade->applicant_business = $response->applicant_business;
	    				$facade->owner_name = $response->owner_name;
	    				$facade->owner_business = $response->owner_business;
	    				$facade->exterior_wall_types = $response->exterior_wall_types;
	    				$facade->late_filing = $response->late_filing;
	    				$facade->late_filing_amount = $response->late_filing_amount;
	    				$facade->late_filing_fee_paid = $response->late_filing_fee_paid;
	    				$facade->failure_to_file = $response->failure_to_file;
	    				$facade->failure_to_file_amount = $response->failure_to_file_amount;
	    				$facade->failure_to_file_fee_paid = $response->failure_to_file_fee_paid;
	    				$facade->failure_to_correct = $response->failure_to_correct;
	    				$facade->failure_to_correct_amount = $response->failure_to_correct_amount;
	    				$facade->failure_to_correct_fee_paid = $response->failure_to_correct_fee_paid;
	    				$facade->initial_filing_date = $response->initial_filing_date;
	    				$facade->initial_filing_status = $response->initial_filing_status;
	    				$facade->amended_filing_date = $response->amended_filing_date;
	    				$facade->amended_filing_status = $response->amended_filing_status;
	    				$facade->subsequent_filing_date = $response->subsequent_filing_date;
	    				$facade->subsequent_filing_status = $response->subsequent_filing_status;
	    				$facade->prior_cycle_filing_date = $response->prior_cycle_filing_date;
	    				$facade->prior_status = $response->prior_status;
	    				$facade->field_inspection_completed_date = $response->field_inspection_completed_date;
	    				$facade->qewi_signed_date = $response->qewi_signed_date;
	    				$facade->save();
	    			}
    			}
    		}
    	}
    	return response([
    		'success' => true
    	], 200);
    }
}
