<?php

namespace App\Http\Controllers;

use App\Property; 
use App\TOOComplaint;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TOOComplaintController extends Controller
{
    //
    public function swipeIndex(Request $request, $Id)
    { 
        $complaints = Property::find($Id)->too_complaints; 
        return response($complaints, 200);
    }

    public function get311Complaints (Request $request, $Id)
    { 
    	$property = Property::find($Id);
    	if (!is_null($property)) { 
    		$client = new Client(); 
    		$request = $client->get('https://data.cityofnewyork.us/resource/fhrw-4uyv.json?incident_address='.$property->house_number.' '.strtoupper($property->street_name));
    		$response = json_decode($request->getBody()->getContents());
    		if(!is_null($response)){ 
    			foreach ($response as $data) { 
                    $complaint_exists = TOOComplaint::where('unique_key', $data->unique_key)->get();
    				if (count($complaint_exists) === 0) { 
                        $newTOOComplaint = TOOComplaint::create([ 
                            'property_id' => $property->id
                        ]);

                        if(!empty($data->unique_key)){ 
                            $newTOOComplaint->unique_key = $data->unique_key;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->created_date)){ 
                            $newTOOComplaint->created_date = $data->created_date;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->closed_date)){ 
                            $newTOOComplaint->closed_date = $data->closed_date;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->agency)){ 
                            $newTOOComplaint->agency = $data->agency;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->agency_name)){ 
                            $newTOOComplaint->agency_name = $data->agency_name;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->complaint_type)){ 
                            $newTOOComplaint->complaint_type = $data->complaint_type;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->descriptor)){ 
                            $newTOOComplaint->descriptor = $data->descriptor;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->location_type)){ 
                            $newTOOComplaint->location_type = $data->location_type;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->incident_zip)){ 
                            $newTOOComplaint->incident_zip = $data->incident_zip;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->incident_address)){ 
                            $newTOOComplaint->incident_address = $data->incident_address;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->street_name)){ 
                            $newTOOComplaint->street_name = $data->street_name;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->cross_street_1)){ 
                            $newTOOComplaint->cross_street_1 = $data->cross_street_1;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->cross_street_2)){ 
                            $newTOOComplaint->cross_street_2 = $data->cross_street_2;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->intersection_street_1)){ 
                            $newTOOComplaint->intersection_street_1 = $data->intersection_street_1;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->intersection_street_2)){ 
                            $newTOOComplaint->intersection_street_2 = $data->intersection_street_2;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->address_type)){ 
                            $newTOOComplaint->address_type = $data->address_type;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->city)){ 
                            $newTOOComplaint->city = $data->city;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->landmark)){ 
                            $newTOOComplaint->landmark = $data->landmark;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->facility_type)){ 
                            $newTOOComplaint->facility_type = $data->facility_type;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->status)){ 
                            $newTOOComplaint->status = $data->status;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->due_date)){ 
                            $newTOOComplaint->due_date = $data->due_date;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->resolution_description)){ 
                            $newTOOComplaint->resolution_description = $data->resolution_description;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->resolution_action_updated_date)){ 
                            $newTOOComplaint->resolution_action_updated_date = $data->resolution_action_updated_date;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->community_board)){ 
                            $newTOOComplaint->community_board = $data->community_board;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->bbl)){ 
                            $newTOOComplaint->bbl = $data->bbl;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->borough)){ 
                            $newTOOComplaint->borough = $data->borough;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->x_coordinate_state_plane)){ 
                            $newTOOComplaint->x_coordinate_state_plane = $data->x_coordinate_state_plane;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->y_coordinate_state_plane)){ 
                            $newTOOComplaint->y_coordinate_state_plane = $data->y_coordinate_state_plane;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->open_data_channel_type)){ 
                            $newTOOComplaint->open_data_channel_type = $data->open_data_channel_type;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->latitude)){ 
                            $newTOOComplaint->latitude = $data->latitude;
                            $newTOOComplaint->save();
                        }

                        if(!empty($data->longitude)){ 
                            $newTOOComplaint->longitude = $data->longitude;
                            $newTOOComplaint->save();
                        }
                    }
    			}
    		}
    	}
    	return response(['success' => true], 200);
    }
}
