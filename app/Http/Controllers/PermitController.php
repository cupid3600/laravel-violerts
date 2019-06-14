<?php

namespace App\Http\Controllers;

use App\Property; 
use App\BISJobApplication;
use App\BISPermit;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PermitController extends Controller
{
    //
    public function getPermitsIndex ($Id)
    { 
    	$property = Property::find($Id);
        if (!is_null($property)) { 
            $job_applications = BISJobApplication::where('property_id', $property->id)
                                                 ->where('all_permits_uri', '!=', '')
                                                 ->get(); 
            if(!is_null($job_applications)){ 
                foreach ($job_applications as $job_application) { 
                    $permit_uri = $job_application->all_permits_uri;
                    while (!empty($permit_uri)) { 
                        $client = new Client();
                        $request = $client->post(env('DOB_BIS_API').'/property/dob-api/permits/index', [
                            'form_params' => [ 
                                'endpoint' => $permit_uri
                            ]
                        ]); 
                        $response = json_decode($request->getBody()->getContents()); 
                        if(!is_null($response)){ 
                            foreach ($response->permits as $permit) { 
                                $permit_exists = BISPermit::where('property_id', $property->id)
                                                          ->where('bis_job_application_id', $job_application->id)
                                                          ->where('permit_number', $permit->number)
                                                          ->get();
                                if(count($permit_exists) === 0){ 
                                    $newPermit = BISPermit::create([ 
                                        'property_id' => $property->id, 
                                        'bis_job_application_id' => $job_application->id, 
                                        'job_number' => $job_application->job_number, 
                                        'job_number_uri' => $job_application->uri,
                                        'permit_number' => $permit->number, 
                                        'permit_uri' => $permit->uri, 
                                        'history_uri' => $permit->history, 
                                        'seq_no' => $permit->seq_no, 
                                        'first_issue_date' => $permit->first_issue_date, 
                                        'last_issue_date' => $permit->last_issue_date, 
                                        'status' => $permit->status, 
                                        'applicant' => $permit->applicant
                                    ]);
                                }
                            }
                        }

                        if(!empty($response->nextpage_url)){ 
                            $permit_uri = $response->nextpage_url;
                        }

                        if(empty($response->nextpage_url)){ 
                            $permit_uri = '';
                        }
                    }
                }
            }
        }
        return response([ 
            'success' => true
        ], 200);
    	
    }

    public function getPermitsRecords ($Id)
    { 
        $property = Property::find($Id); 
        if(!is_null($property)){ 
            $bis_permits = BISPermit::where('property_id', $property->id)
                                    ->get();

            if(count($bis_permits) > 0){ 
                $client = new Client(); 
                foreach ($bis_permits as $bis_permit){ 
                    if (!is_null($bis_permit->permit_uri)) { 

                        $request = $client->post(env('DOB_BIS_API').'/property/dob-api/permits/record', [ 
                            'form_params' => [ 
                                'endpoint' => $bis_permit->permit_uri
                            ]
                        ]); 
                        $response = json_decode($request->getBody()->getContents());
                        if(!is_null($response)){ 
                            $bis_permit->fee = $response->fee;
                            $bis_permit->expires_date = $response->expiration_date;
                            $bis_permit->work_approved_date = $response->work_approved;
                            $bis_permit->work_description = $response->work_description;
                            $bis_permit->proposed_job_start_date = $response->proposed_job_start;
                            $bis_permit->use = $response->use;
                            $bis_permit->landmark = $response->landmark;
                            $bis_permit->stories = $response->stories;
                            $bis_permit->site_fill = $response->site_fill;
                            $bis_permit->review_is_requested_under_building_code = $response->review_building_code;
                            $bis_permit->adding_more_than_3_stories = $response->add_more_than_3_stories;
                            $bis_permit->removing_one_or_more_stories = $response->remove_one_or_more_stories;
                            $bis_permit->performing_work_in_50_percent_or_more_of_building_area = $response->perform_work_in_50;
                            $bis_permit->demolishing_50_percent_or_more_of_building_area = $response->demolish_50;
                            $bis_permit->performing_vertical_horizontal_enlargement = $response->perform_vertical_or_horizontal;
                            $bis_permit->mech_equipment_other_than_handheld = $response->mech_equipment_other_than_handheld;
                            $bis_permit->approved_work_includes_concrete = $response->approved_work_includes_concrete;
                            $bis_permit->concrete_work_completed = $response->concrete_work_has_been_completed;
                            $bis_permit->requesting_concrete_exclusion = $response->requesting_concrete_exclusion;
                            $bis_permit->work_includes_2000_cubic_yds_or_more_of_concrete = $response->work_includes_2000;
                            $bis_permit->issued_to = $response->issued_to;
                            $bis_permit->business = $response->business;
                            $bis_permit->gc_safety_registration = $response->gc_safety_registration_number;
                            $bis_permit->gc_safety_registration_uri = $response->gc_safety_registration_number_uri;
                            $bis_permit->phone = $response->phone;
                            $bis_permit->save();
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
