<?php

namespace App\Http\Controllers;

use App\Property; 
use App\BISElevator;
use App\BISElevatorInspection; 
use App\BISElevatorViolation;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ElevatorController extends Controller
{
    //
    public function swipeIndexRecord (Request $request, $Id)
    { 
        $records = BISElevator::where('property_id', $Id)->get(); 
        return response($records, 200);
    }

    public function swipeIndexInspection (Request $request, $Id)
    { 
        $inspections = BISElevatorInspection::where('property_id', $Id)->get(); 
        return response($inspections, 200);
    }

    public function swipeIndexViolation (Request $request, $Id)
    {
        $violations = BISElevatorViolation::where('property_id', $Id)->get(); 
        return response($violations, 200);
    }

    public function getElevatorIndex(Request $request, $Id)
    { 
    	$property = Property::find($Id); 
    	if(!is_null($property)) { 

    		# requesting general index information
    		$client = new Client(); 
    		$request = $client->post(env('DOB_BIS_API').'/property/dob-api/elevators/index', [ 
    			'form_params' => [ 
    				'endpoint' => $property->elevator_records_uri
    			]
    		]);
    		$response = json_decode($request->getBody()->getContents());
    		if(!is_null($response)) { 
    			# general elevator index information variable
    			$general = $response;

    			
    			if (isset($general->num_devices_uri)) {
                    
                    # request general elevator device index information
                    $request = $client->post(env('DOB_BIS_API').'/property/dob-api/elevators/devices/index', [ 
                        'form_params' => [ 
                            'endpoint' => $general->num_devices_uri
                        ]
                    ]);

                    # creating elevator objects per device object returned from request
                    $response = json_decode($request->getBody()->getContents()); 
                    if(!is_null($response)){ 
                        foreach($response->elevators as $elevator){ 
                            $elevator_exists = BISElevator::where('elevator_record_number', $general->record_number)
                                                          ->where('device_number', $elevator->device_number)
                                                          ->get();
                            if (count($elevator_exists) === 0) { 
                                $newElevator = BISElevator::create([ 
                                    'property_id' => $property->id, 
                                    'elevator_inspections_uri' => $general->elevator_inspections_uri, 
                                    'elevator_violations_uri' => $general->elevator_violations_uri, 
                                    'elevator_record_number' => $general->record_number, 
                                    'elevator_devices_uri' => $general->num_devices_uri, 
                                    'device_number' => $elevator->device_number, 
                                    'device_number_uri' => $elevator->device_number_uri, 
                                    'device_status' => $elevator->status
                                ]);
                            }
                        }
                    }

                    # requesting and storing device/elevator details per existing elevator record
                    $elevators = BISElevator::where('property_id', $property->id)->get();
                    if(count($elevators) > 0){ 
                        foreach($elevators as $elevator){ 
                            $request = $client->post(env('DOB_BIS_API').'/property/dob-api/elevators/devices/record', [ 
                                'form_params' => [ 
                                    'endpoint' => $elevator->device_number_uri
                                ]
                            ]);
                            $response = json_decode($request->getBody()->getContents());
                            if(!is_null($response)){
                                if(!empty($response->device_type)){ 
                                    $elevator->device_type = $response->device_type;
                                    $elevator->save();
                                }

                                if(!empty($response->record)){ 
                                    $elevator->record = $response->record;
                                    $elevator->save();
                                }

                                if(!empty($response->status)){ 
                                    $elevator->device_status = $response->status;
                                    $elevator->save();
                                }

                                if(!empty($response->status_date)){ 
                                    $elevator->status_date = $response->status_date;
                                    $elevator->save();
                                }

                                if(!empty($response->stat_comm)){ 
                                    $elevator->stat_comm = $response->stat_comm;
                                    $elevator->save();
                                }

                                if(!empty($response->approval)){ 
                                    $elevator->approval_date = $response->approval;
                                    $elevator->save();
                                }

                                if(!empty($response->floor_from)){ 
                                    $elevator->floor_from = $response->floor_from;
                                    $elevator->save();
                                }

                                if(!empty($response->floor_to)){ 
                                    $elevator->floor_to = $response->floor_to;
                                    $elevator->save();
                                }

                                if(!empty($response->travel_distance)){ 
                                    $elevator->travel_distance = $response->travel_distance;
                                    $elevator->save();
                                }

                                if(!empty($response->speed_fpm)){ 
                                    $elevator->speed_fpm = $response->speed_fpm;
                                    $elevator->save();
                                }

                                if(!empty($response->car_entrances)){ 
                                    $elevator->car_entrances = $response->car_entrances;
                                    $elevator->save();
                                }

                                if(!empty($response->capacity_lbs)){ 
                                    $elevator->capacity_lbs = $response->capacity_lbs;
                                    $elevator->save();
                                }

                                if(!empty($response->hoist_ropes_quantity)){ 
                                    $elevator->hoist_ropes_quantity = $response->hoist_ropes_quantity;
                                    $elevator->save();
                                }

                                if(!empty($response->hoist_ropes_size)){ 
                                    $elevator->hoist_ropes_size = $response->hoist_ropes_size;
                                    $elevator->save();
                                }

                                if(!empty($response->hoist_ropes_kind)){ 
                                    $elevator->hoist_ropes_kind = $response->hoist_ropes_kind;
                                    $elevator->save();
                                }

                                if(!empty($response->car_cntwt_ropes_quantity)){ 
                                    $elevator->car_cntwt_ropes_quantity = $response->car_cntwt_ropes_quantity;
                                    $elevator->save();
                                }

                                if(!empty($response->car_cntwt_ropes_size)){ 
                                    $elevator->car_cntwt_ropes_size = $response->car_cntwt_ropes_size;
                                    $elevator->save();
                                }

                                if(!empty($response->car_cntwt_ropes_kind)){ 
                                    $elevator->car_cntwt_ropes_kind = $response->car_cntwt_ropes_kind;
                                    $elevator->save();
                                }

                                if(!empty($response->machn_cntwt_ropes_quantity)){ 
                                    $elevator->machn_cntwt_ropes_quantity = $response->machn_cntwt_ropes_quantity;
                                    $elevator->save();
                                }

                                if(!empty($response->machn_cntwt_ropes_size)){ 
                                    $elevator->machn_cntwt_ropes_size = $response->machn_cntwt_ropes_size;
                                    $elevator->save();
                                }

                                if(!empty($response->machn_cntwt_ropes_kind)){ 
                                    $elevator->machn_cntwt_ropes_kind = $response->machn_cntwt_ropes_kind;
                                    $elevator->save();
                                }

                                if(!empty($response->backdrum_ropes_quantity)){ 
                                    $elevator->backdrum_ropes_quantity = $response->backdrum_ropes_quantity;
                                    $elevator->save();
                                }

                                if(!empty($response->backdrum_ropes_size)){ 
                                    $elevator->backdrum_ropes_size = $response->backdrum_ropes_size;
                                    $elevator->save();
                                }

                                if(!empty($response->backdrum_ropes_kind)){ 
                                    $elevator->backdrum_ropes_kind = $response->backdrum_ropes_kind;
                                    $elevator->save();
                                }

                                if(!empty($response->governor_ropes_quantity)){ 
                                    $elevator->governor_ropes_quantity = $response->governor_ropes_quantity;
                                    $elevator->save();
                                }

                                if(!empty($response->governor_ropes_size)){ 
                                    $elevator->governor_ropes_size = $response->governor_ropes_size;
                                    $elevator->save();
                                }

                                if(!empty($response->governor_ropes_kind)){ 
                                    $elevator->governor_ropes_kind = $response->governor_ropes_kind;
                                    $elevator->save();
                                }

                                if(!empty($response->governor_type)){ 
                                    $elevator->governor_type = $response->governor_type;
                                    $elevator->save();
                                }

                                if(!empty($response->safety_type)){ 
                                    $elevator->safety_type = $response->safety_type;
                                    $elevator->save();
                                }

                                if(!empty($response->machine_type)){ 
                                    $elevator->machine_type = $response->machine_type;
                                    $elevator->save();
                                }

                                if(!empty($response->mode_operation)){ 
                                    $elevator->mode_operation = $response->mode_operation;
                                    $elevator->save();
                                }

                                if(!empty($response->car_buffer_type)){ 
                                    $elevator->car_buffer_type = $response->car_buffer_type;
                                    $elevator->save();
                                }

                                if(!empty($response->firemans_service)){ 
                                    $elevator->firemans_service = $response->firemans_service;
                                    $elevator->save();
                                }

                                if(!empty($response->working_pressure)){ 
                                    $elevator->working_pressure = $response->working_pressure;
                                    $elevator->save();
                                }

                                if(!empty($response->manufacturer)){ 
                                    $elevator->manufacturer = $response->manufacturer;
                                    $elevator->save();
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
    	return response([
    		'success' => false
    	], 200);
    }

    public function getElevatorInspections(Request $request, $Id)
    { 
    	$property = Property::find($Id); 

    	if(!is_null($property)) { 
    		$elevators = BISElevator::where('property_id', $property->id)->get();
    		if(count($elevators) > 0){
    			foreach($elevators as $elevator){ 
    				$inspection_uri = $elevator->elevator_inspections_uri;
    				while (!empty($inspection_uri)) { 
    					$client = new Client(); 
			    		$request = $client->post(env('DOB_BIS_API').'/property/dob-api/elevators/inspections/index', [ 
			    			'form_params' => [ 
			    				'endpoint' => $inspection_uri
			    			]
			    		]);
			    		$response = json_decode($request->getBody()->getContents());
			    		if(!is_null($response)){ 
			    			foreach($response->inspections as $inspection) { 
                                $inspection_exists = BISElevatorInspection::where('device_number', $inspection->device_number)
                                                                          ->where('inspection_date', $inspection->inspection_date)
                                                                          ->where('inspection_type', $inspection->inspection_type)
                                                                          ->where('inspection_disposition', $inspection->inspection_disposition)
                                                                          ->get();
			    				if (count($inspection_exists) === 0) { 
                                    if ($elevator->device_number === $inspection->device_number) { 
                                        $newInspection = BISElevatorInspection::create([ 
                                            'property_id' => $property->id,
                                            'b_i_s_elevator_id' => $elevator->id, 
                                            'device_number' => $inspection->device_number, 
                                            'inspection_date' => $inspection->inspection_date, 
                                            'inspection_type' => $inspection->inspection_type, 
                                            'inspection_disposition' => $inspection->inspection_disposition, 
                                        ]);

                                        if(isset($inspection->inspected_by) && !is_null($inspection->inspected_by)){
                                            $newInspection->inspected_by = $inspection->inspected_by;
                                            $newInspection->save();
                                        }
                                    }
                                }
			    			}

			    			if(!empty($response->nextpage_url)){ 
			    				$inspection_uri = $response->nextpage_url;
			    			}

			    			if(empty($response->nextpage_url)){ 
			    				$inspection_uri = '';
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

    public function getElevatorViolations(Request $request, $Id)
    { 
    	$property = Property::find($Id); 
    	if(!is_null($property)){ 
    		$elevators = BISElevator::where('property_id', $property->id)->get(); 
    		if(count($elevators) > 0){ 
    			foreach($elevators as $elevator){ 
    				$violations_uri = $elevator->elevator_violations_uri; 
    				while(!empty($violations_uri)){ 
    					$client = new Client(); 
    					$request = $client->post(env('DOB_BIS_API').'/property/dob-api/elevators/violations/index', [ 
    						'form_params' => [ 
    							'endpoint' => $violations_uri
    						]
    					]);
    					$response = json_decode($request->getBody()->getContents()); 
    					if(!is_null($response)){ 
    						foreach ($response->violations as $violation){ 
                                $violation_exists = BISElevatorViolation::where('device_number', $violation->device_number)
                                                                        ->where('violation_number', $violation->violation_number)
                                                                        ->get();
    							if ($elevator->device_number === $violation->device_number) { 
    								$newViolation = BISElevatorViolation::create([ 
                                        'property_id' => $property->id,
	    								'b_i_s_elevator_id' => $elevator->id, 
	    								'device_number' => $violation->device_number, 
	    								'violation_number' => $violation->violation_number, 
	    								'svr_code' => $violation->svr_code, 
	    								'disposition_code' => $violation->disp_code, 
	    								'disposition_date' => $violation->disp_date, 
	    								'diposition_badge' => $violation->disp_badge
	    							]);
    							}
    						}

    						if(!empty($response->nextpage_url)){ 
			    				$violations_uri = $response->nextpage_url;
			    			}

			    			if(empty($response->nextpage_url)){ 
			    				$violations_uri = '';
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
