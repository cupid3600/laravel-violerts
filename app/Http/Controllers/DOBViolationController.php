<?php

namespace App\Http\Controllers;

use App\Property;
use App\DOBViolation;
use App\BISDOBViolation;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Illuminate\Http\Request;

class DOBViolationController extends Controller
{
    //
    public function index (Request $request, $Id)
    { 

    }

    public function BISindex (Request $request, $Id)
    { 

    }

    public function swipeIndexOD (Request $request, $Id)
    { 
        $dob_violations = Property::find($Id)->dob_violations; 
        return response($dob_violations, 200);
    }

    public function swipeIndexBIS (Request $request, $Id)
    { 
        $dob_violations = Property::find($Id)->bis_dob_violations; 
        return response($dob_violations, 200);
    }

    public function getDOBViolations (Request $request, $Id)
    { 
        $property = Property::find($Id); 
        if(is_null($property)) { 
            return response([ 
                'success' => false
            ], 200);
        }

        $client = new Client(); 
        $dob_violations_request = $client->get('https://data.cityofnewyork.us/resource/dvnq-fhaa.json?bin='.$property->bin);
        $dob_violations_response = json_decode($dob_violations_request->getBody()->getContents());
        if (!is_null($dob_violations_response)) { 
            foreach ($dob_violations_response as $data) { 
                $DOBVioCheck = DOBViolation::where('property_id', $property->id)->where('violation_number', $data->violation_number)->where('violation_category', $data->violation_category)->first();
                    
                if (is_null($DOBVioCheck)) { 
                    $dob_violation = new DOBViolation;
                    if (!empty($property->id)) { 
                        $dob_violation->property_id = $property->id;
                        $dob_violation->save();
                    }

                    if (!empty($data->isn_dob_bis_viol)) { 
                        $dob_violation->isn_dob_bis_viol = $data->isn_dob_bis_viol;
                        $dob_violation->save();
                    }

                    if (!empty($data->boro)) { 
                        $dob_violation->boro = $data->boro;
                        $dob_violation->save();  
                    }

                    if (!empty($data->bin)) { 
                        $dob_violation->bin = $data->bin;
                        $dob_violation->save();  
                    }
                    
                    if (!empty($data->block)) { 
                        $dob_violation->block = $data->block;
                        $dob_violation->save();
                    } 

                    if (!empty($data->lot)) { 
                        $dob_violation->lot = $data->lot;
                        $dob_violation->save();
                    }
                    
                    if (!empty($data->issue_date)) { 
                        $dob_violation->issue_date = $data->issue_date;
                        $dob_violation->save();
                    }

                    if (!empty($data->violation_type_code)) { 
                        $dob_violation->violation_type_code = $data->violation_type_code;
                        $dob_violation->save(); 
                    }
                    
                    if (!empty($data->violation_number)) { 
                        $dob_violation->violation_number = $data->violation_number;
                        $dob_violation->save();
                    }
                    
                    if (!empty($data->house_number)) { 
                        $dob_violation->house_number = $data->house_number;
                        $dob_violation->save();
                    }
                    
                    if (!empty($data->street)) { 
                        $dob_violation->street = $data->street;
                        $dob_violation->save();
                    }
                    
                    if (!empty($data->disposition_date)) { 
                        $dob_violation->disposition_date = $data->disposition_date;
                        $dob_violation->save();
                    }
                    
                    if (!empty($data->disposition_comments)) { 
                        $dob_violation->disposition_comments = $data->disposition_comments;
                        $dob_violation->save();
                    }

                    if (!empty($data->device_number)) { 
                        $dob_violation->device_number = $data->device_number;
                        $dob_violation->save();
                    }

                    if (!empty($data->description)) { 
                        $dob_violation->description = $data->description;
                        $dob_violation->save();
                    }
                    
                    if (!empty($data->ecb_number)) { 
                        $dob_violation->ecb_number = $data->ecb_number;
                        $dob_violation->save();
                    }
                    
                    if (!empty($data->number)) { 
                        $dob_violation->number = $data->number;
                        $dob_violation->save();
                    }
                    
                    if (!empty($data->violation_category)) { 
                        $dob_violation->violation_category = $data->violation_category;
                        $dob_violation->save();
                    }
                    
                    if (!empty($data->violation_type)) { 
                        $dob_violation->violation_type = $data->violation_type;
                        $dob_violation->save();
                    }
                }

                if (!is_null($DOBVioCheck)) { 
                    $dob_violation = $DOBVioCheck; 
                    // event - status has changed 
                    if ($dob_violation->violation_category != $data->violation_category) { 
                        $dob_violation->violation_category = $data->violation_category; 
                        $dob_violation->save();
                    }
                }
            }
        } 

        return response([ 
            'success' => true
        ], 200);
    }

    public function getBISDOBViolations(Request $request, $Id)
    { 
        $property = Property::find($Id); 
        if (is_null($property)) { 
            return response([ 
                'success' => false
            ], 200); 
        }

        $client = new Client(); 
        
        $bis_uri_request = $client->get(env('DOB_API').'/overview?house_number='.$property->house_number.'&street='.$property->street_name.'&borough='.$property->borough); 
        $bis_uri_response = json_decode($bis_uri_request->getBody()->getContents()); 
        if(!is_null($bis_uri_response)){ 
            if(!empty($bis_uri_response->dob_violations_uri) && empty($property->dob_violations_uri)){ 
                $property->dob_violations_uri = $bis_uri_response->dob_violations_uri;
                $property->save();
            }

            if(!empty($bis_uri_response->dob_violations_total)){ 
                $property->dob_violations_total = $bis_uri_response->dob_violations_total;
                $property->save();
            }

            if(!empty($bis_uri_response->dob_violations_open)){ 
                $property->dob_violations_open = $bis_uri_response->dob_violations_open;
                $property->save();
            }
        }

        $total_amount_dob_violations = BISDOBViolation::where('property_id', $property->id)->get()->count(); 
        if($property->dob_violations_total > 0) { 
            $property->dob_violations_endpoint = $property->dob_violations_uri; 
            $property->save();

            while ($total_amount_dob_violations !== $property->dob_violations_total && $property->dob_violations_endpoint != '') { 
                $request = $client->post(env('DOB_BIS_API').'/property/dob-api/dob-violations/index', [ 
                    'form_params' => [ 
                        'endpoint' => $property->dob_violations_endpoint
                    ]
                ]); 
                $response = json_decode($request->getBody()->getContents()); 
                if (count($response->dob_violations) > 0) { 
                    foreach ($response->dob_violations as $dob_violation) { 
                        $DOBVioCheck = BISDOBViolation::where('property_id', $property->id)->where('number', $dob_violation->number)->get();
                        if (count($DOBVioCheck) === 0) { 
                            $new_dob_violation = BISDOBViolation::create([ 
                                'property_id' => $property->id, 
                                'number' => $dob_violation->number, 
                                'issue_date' => $dob_violation->issue_date, 
                                'type' => $dob_violation->type
                            ]);

                            if (!empty($dob_violation->status)) { 
                                if ($dob_violation->status == true) { 
                                    $new_dob_violation->active = true; 
                                    $new_dob_violation->save();
                                }
                            }

                            if (!empty($dob_violation->url)) { 
                                $new_dob_violation->uri = $dob_violation->url; 
                                $new_dob_violation->save(); 
                            }
                        }
                    }
                }
                if (!empty($response->nextpage_url)) { 
                    $property->dob_violations_endpoint = $response->nextpage_url;
                    $property->save();
                }
                if (empty($response->nextpage_url)) { 
                     $property->dob_violations_endpoint = ''; 
                     $property->save();
                }
                $total_amount_dob_violations = BISDOBViolation::where('property_id', $property->id)->get(); 
            }
        }

        $dob_violations = BISDOBViolation::where('property_id', $property->id)->where('uri', '!=', '')->get();
        if (!is_null($dob_violations)) { 
            foreach ($dob_violations as $dob_violation) { 
                $client = new Client(); 
                $request = $client->post(env('DOB_BIS_API').'/property/dob-api/dob-violations/record', [ 
                    'form_params' => [ 
                        'endpoint' => $dob_violation->uri
                    ]
                ]);
                $response = json_decode($request->getBody()->getContents());

                if (!is_null($response->device_number)) { 
                    $dob_violation->device_number = $response->device_number; 
                    $dob_violation->save();
                }

                if (!is_null($response->ecb_number)) { 
                    $dob_violation->ecb_number = $response->ecb_number; 
                    $dob_violation->save();
                }

                if (!is_null($response->infraction_codes)) { 
                    $dob_violation->infraction_codes = $response->infraction_codes; 
                    $dob_violation->save();
                }

                if (!is_null($response->description)) { 
                    $dob_violation->description = $response->description; 
                    $dob_violation->save();
                }

                if (!is_null($response->disposition_code)) { 
                    $dob_violation->disposition_code = $response->disposition_date; 
                    $dob_violation->save();
                }

                if (!is_null($response->disposition_date)) { 
                    $dob_violation->disposition_date = $response->disposition_date; 
                    $dob_violation->save();
                }

                if (!is_null($response->inspector)) { 
                    $dob_violation->inspector = $response->inspector; 
                    $dob_violation->save();
                }

                if (!is_null($response->comments)) { 
                    $dob_violation->comments = $response->comments; 
                    $dob_violation->save(); 
                }

            }
        } 



        return response([ 
            'success' => true
        ], 200);
    }
}
