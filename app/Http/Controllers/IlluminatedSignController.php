<?php

namespace App\Http\Controllers;


use App\Property; 
use App\BISIlluminatedSign;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class IlluminatedSignController extends Controller
{
    //
    public function swipeIndex (Request $request, $Id)
    { 
        $signs = BISIlluminatedSign::where('property_id', $Id)->get(); 
        return response($signs, 200);
    }

    public function getIlluminatedSigns ($Id)
    { 
    	$property = Property::find($Id); 
    	if(!is_null($property)){ 
    		$client = new Client(); 
    		$request = $client->post(env('DOB_BIS_API').'/property/dob-api/illuminated-signs/index', [ 
    			'form_params' => [ 
    				'endpoint' => $property->illuminated_signs_permit_uri
    			]
    		]);
    		$response = json_decode($request->getBody()->getContents()); 
    		if(!is_null($response)){ 
    			if(count($response->illuminated_signs) > 0){ 
    				foreach($response->illuminated_signs as $illuminated_sign) { 
    					$newIlluminatedSign = BISIlluminatedSign::create([ 
    						'property_id' => $property->id, 
    						'seq_no' => $illuminated_sign->seq, 
    						'uri' => $illuminated_sign->uri, 
    						'job_number' => $illuminated_sign->job_number, 
    						'job_number_uri' => $illuminated_sign->job_number_uri, 
    						'square_footage' => $illuminated_sign->sq_foot, 
    						'sign_wording' => $illuminated_sign->sign_wording
    					]);
    				}
    			}

    			$illuminated_signs = BISIlluminatedSign::where('property_id', $property->id)->get();
    			if(count($illuminated_signs) > 0) { 
    				foreach ($illuminated_signs as $illuminated_sign) { 
    					$client = new Client();
    					$request = $client->post(env('DOB_BIS_API').'/property/dob-api/illuminated-signs/record', [ 
    						'form_params' => [ 
    							'endpoint' => $illuminated_sign->uri
    						]
    					]);
    					$response = json_decode($request->getBody()->getContents());
    					if(!is_null($response)){ 
    						$illuminated_sign->added_on = $response->added_on;
    						$illuminated_sign->last_modified = $response->last_modified;
    						$illuminated_sign->address = $response->address;
    						$illuminated_sign->zip = $response->zip;
    						$illuminated_sign->bbl_seqno = $response->bbl_seqno;
    						$illuminated_sign->illumination = $response->illumination;
    						$illuminated_sign->amount_due = $response->amount_due;
    						$illuminated_sign->bin = $response->bin;
    						$illuminated_sign->last_billed_on = $response->last_billed_on;
    						$illuminated_sign->last_bill_amount = $response->last_bill_amount;
    						$illuminated_sign->billing_code = $response->billing_code;
    						$illuminated_sign->last_permit_issued = $response->last_permit_issued;
    						$illuminated_sign->permit_code = $response->permit_code;
    						$illuminated_sign->annual_permit_number = $response->annual_permit_number;
    						$illuminated_sign->expires = $response->expires;
    						$illuminated_sign->comment = $response->comment;
    						$illuminated_sign->owner_last_name = $response->owner_last_name;
    						$illuminated_sign->owner_first_name = $response->owner_first_name;
    						$illuminated_sign->owner_business = $response->owner_business;
    						$illuminated_sign->owner_address = $response->owner_address;
    						$illuminated_sign->save();
    					}
    				}
    			}
    		}
    	}
    	return response([ 
    		'success' => true
    	], 200);
    }
}
