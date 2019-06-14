<?php

namespace App\Http\Controllers;

use App\Property; 
use App\BISBoiler;
use App\BISBoilerInspection;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BoilerController extends Controller
{
    //
    public function getBoilers (Request $request, $Id)
    { 
    	$property = Property::find($Id);
    	if(!is_null($property)){ 
    		$client = new Client(); 
    		$request = $client->post(env('DOB_BIS_API').'/property/dob-api/boilers/index', [ 
    			'form_params' => [ 
    				'endpoint' => $property->boiler_records_uri
    			]
    		]); 
    		$response = $request->getBody()->getContents();
    		if(!is_null($response)){ 
    			foreach($response->boilers as $boiler){ 
    				$newBoiler = BISBoiler::create([ 
    					'property_id' => $property->id, 
						'viol' => $boiler->viol, 
						'num' => $boiler->num,
						'num_uri' => $boiler->num_uri, 
						'md' => $boiler->md, 
						'serial_number' => $boiler->ser_num, 
						'status' => $boiler->staus, 
						'last_insp_date' => $boiler->insp_date, 
						'last_recv_date' => $boiler->recv_date, 
						'name' => $boiler->name,
						'bin' => $property->bin    					
    				]);
    			}
    		}

   			$boilers = BISBoiler::where('property_id', $property->id)->get();
   			if(count($boilers) > 0){ 
   				foreach ($boilers as $boiler) { 
   					$client = new Client(); 
   					$request = $client->post(env('DOB_BIS_API').'/property/dob-api/boilers/record', [ 
   						'form_params' => [ 
   							'endpoint' => $boiler->num_uri
   						]
   					]); 
   					$response = $request->getBody()->getContents(); 
   					if(!is_null($response)){ 
   						$boiler->type = $response->type;
   						$boiler->review_required = $response->review_required;
   						$boiler->filed_at = $response->filed_at;
   						$boiler->located_in = $response->located_in;
   						$boiler->make_of_boiler = $response->make_of_boiler;
   						$boiler->year = $response->year;
   						$boiler->over_6 = $response->over_6;
   						$boiler->no_of_boilers = $response->no_of_boilers;
   						$boiler->fee = $response->fee;
   						$boiler->school = $response->school;
   						$boiler->save();

   						if (!is_null($response->inspections)) { 
   							foreach ($response->inspections as $inspection) { 
   								$newBoilerInspection = BISBoilerInspection::create([ 
   									'boiler_number' => $boiler->num, 
   									'bis_boiler_id' => $boiler->id, 
   									'bin' => $boiler->bin, 
   									'inspection_date' => $inspection->insp_date, 
   									'rec_date' => $inspection->rec_date, 
   									'entry_date' => $inspection->entry_date, 
   									'name' => $inspection->name, 
   									'int_ext' => $inspection->int_ext, 
   									'results' => $inspection->results, 
   									'nys_certificate' => $inspection->nys_ceritifcate
   								]);
   							}
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
