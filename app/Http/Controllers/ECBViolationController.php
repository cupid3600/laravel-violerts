<?php

namespace App\Http\Controllers;

use App\Property;
use App\ECBViolation; 
use App\BISECBViolation;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ECBViolationController extends Controller
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
        $ecb_violations = Property::find($Id)->ecb_violations; 
        return response($ecb_violations, 200);
    }

    public function swipeIndexBIS(Request $request, $Id)
    { 
        $ecb_violations = Property::find($Id)->bis_ecb_violations; 
        return response($ecb_violations, 200);
    }

    public function getECBViolations (Request $request, $Id)
    { 
        $property = Property::find($Id); 

        if (is_null($property)) { 
            return response([ 
                'success' => false
            ], 200);
        }

        $client = new Client(); 
        $ecb_violation_request = $client->get('https://data.cityofnewyork.us/resource/gq3f-5jm8.json?bin='.$property->bin);
        $ecb_violation_response = json_decode($ecb_violation_request->getBody()->getContents());
        if (!is_null($ecb_violation_response)) { 
            foreach ($ecb_violation_response as $data) { 
                $ECBVioCheck = ECBViolation::where('property_id', $property->id)->where('ecb_violation_number', $data->ecb_violation_number)->get();
                if(count($ECBVioCheck) === 0){ 
                    $ecb_violation = new ECBViolation; 

                    if (!empty($property->id)) { 
                        $ecb_violation->property_id = $property->id; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->isn_doc_bis_extract)) { 
                        $ecb_violation->isn_doc_bis_extract = $data->isn_doc_bis_extract; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->ecb_violation_number)) { 
                        $ecb_violation->ecb_violation_number = $data->ecb_violation_number; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->ecb_violation_status)) { 
                        $ecb_violation->ecb_violation_status = $data->ecb_violation_status; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->ecb_dob_violation_number)) { 
                        $ecb_violation->ecb_dob_violation_number = $data->ecb_dob_violation_number; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->bin)) { 
                        $ecb_violation->bin = $data->bin; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->bin)) { 
                        $ecb_violation->bin = $data->bin; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->lot)) { 
                        $ecb_violation->lot = $data->lot; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->hearing_date)) { 
                        $ecb_violation->hearing_date = $data->hearing_date; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->hearing_time)) { 
                        $ecb_violation->hearing_time = $data->hearing_time; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->served_date)) { 
                        $ecb_violation->served_date = $data->served_date; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->issue_date)) { 
                        $ecb_violation->issue_date = $data->issue_date; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->severity)) { 
                        $ecb_violation->severity = $data->severity; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->violation_type)) { 
                        $ecb_violation->violation_type = $data->violation_type; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->respondent_name)) { 
                        $ecb_violation->respondent_name = $data->respondent_name; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->respondent_house_number)) { 
                        $ecb_violation->respondent_house_number = $data->respondent_house_number; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->respondent_street)) { 
                        $ecb_violation->respondent_street = $data->respondent_street; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->respondent_city)) { 
                        $ecb_violation->respondent_city = $data->respondent_city; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->respondent_zip)) { 
                        $ecb_violation->respondent_zip = $data->respondent_zip; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->violation_description)) { 
                        $ecb_violation->violation_description = $data->violation_description; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->penality_imposed)) { 
                        $ecb_violation->penality_imposed = $data->penality_imposed; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->amount_paid)) { 
                        $ecb_violation->amount_paid = $data->amount_paid; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->balance_due)) { 
                        $ecb_violation->balance_due = $data->balance_due; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->infraction_code1)) { 
                        $ecb_violation->infraction_code1 = $data->infraction_code1; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->section_law_description1)) { 
                        $ecb_violation->section_law_description1 = $data->section_law_description1; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->infraction_code2)) { 
                        $ecb_violation->infraction_code2 = $data->infraction_code2; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->section_law_description2)) { 
                        $ecb_violation->section_law_description2 = $data->section_law_description2; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->infraction_code3)) { 
                        $ecb_violation->infraction_code3 = $data->infraction_code3; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->section_law_description3)) { 
                        $ecb_violation->section_law_description3 = $data->section_law_description3; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->infraction_code4)) { 
                        $ecb_violation->infraction_code4 = $data->infraction_code4; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->section_law_description4)) { 
                        $ecb_violation->section_law_description4 = $data->section_law_description4; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->infraction_code5)) { 
                        $ecb_violation->infraction_code5 = $data->infraction_code5; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->section_law_description5)) { 
                        $ecb_violation->section_law_description5 = $data->section_law_description5; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->infraction_code6)) { 
                        $ecb_violation->infraction_code6 = $data->infraction_code6; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->section_law_description6)) { 
                        $ecb_violation->section_law_description6 = $data->section_law_description6; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->infraction_code7)) { 
                        $ecb_violation->infraction_code7 = $data->infraction_code7; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->section_law_description7)) { 
                        $ecb_violation->section_law_description7 = $data->section_law_description7; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->infraction_code8)) { 
                        $ecb_violation->infraction_code8 = $data->infraction_code8; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->section_law_description8)) { 
                        $ecb_violation->section_law_description8 = $data->section_law_description8; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->infraction_code9)) { 
                        $ecb_violation->infraction_code9 = $data->infraction_code9; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->section_law_description9)) { 
                        $ecb_violation->section_law_description9 = $data->section_law_description9; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->infraction_code10)) { 
                        $ecb_violation->infraction_code10 = $data->infraction_code10; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->section_law_description10)) { 
                        $ecb_violation->section_law_description10 = $data->section_law_description10; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->aggravated_level)) { 
                        $ecb_violation->aggravated_level = $data->aggravated_level; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->hearing_status)) { 
                        $ecb_violation->hearing_status = $data->hearing_status; 
                        $ecb_violation->save();
                    }

                    if (!empty($data->certification_status)) { 
                        $ecb_violation->certification_status = $data->certification_status; 
                        $ecb_violation->save();
                    }
                }
            }
        }
        return response([ 
            'success' => true
        ], 200);
    }

    public function getBISECBViolations (Request $request, $Id)
    { 
        $property = Property::find($Id); 

        if (is_null($property)) { 
            return response([ 
                'success' => false
            ], 200);
        }

        $client = new Client(); 

        $ecb_violations = BISECBViolation::where('property_id', $property->id)->where('uri', '!=', '')->get(); 
        if (!is_null($ecb_violations)) { 
            foreach ($ecb_violations as $ecb_violation) { 
                $client = new Client(); 
                $request = $client->post(env('DOB_BIS_API').'/property/dob-api/ecb-violations/record', [ 
                    'forms_params' => [ 
                        'endpoint' => $ecb_violation->uri
                    ]
                ]);
                $response = json_decode($request->getBody()->getContents());

                if (!is_null($response->certification_status)) { 
                    $ecb_violation->certification_status = $response->certification_status; 
                    $ecb_violation->save();
                }

                if (!is_null($response->hearing_status)) { 
                    $ecb_violation->hearing_status = $response->hearing_status; 
                    $ecb_violation->save();
                }

                if (!is_null($response->mailing_address)) { 
                    $ecb_violation->mailing_address = $response->mailing_address; 
                    $ecb_violation->save();
                }

                if (!is_null($response->served_date)) { 
                    $ecb_violation->served_date = $response->served_date; 
                    $ecb_violation->save();
                }

                if (!is_null($response->violation_type)) {
                    $ecb_violation->violation_type = $response->violation_type; 
                    $ecb_violation->save(); 
                }

                if (!is_null($response->inspection_unit)) { 
                    $ecb_violation->inspection_unit = $response->inspection_unit; 
                    $ecb_violation->save();
                }

                if (!is_null($response->remedy)) { 
                    $ecb_violation->remedy = $response->remedy;
                    $ecb_violation->save(); 
                }

                if (!is_null($response->issuing_inspector_id)) { 
                    $ecb_violation->issuing_inspector_id = $response->issuing_inspector_id; 
                    $ecb_violation->save();
                }

                if (!is_null($response->dob_violation_number)) { 
                    $ecb_violation->dob_violation_number = $response->dob_violation_number;
                    $ecb_violation->save();
                }

                if (!is_null($response->issued_as_aggr_level)) { 
                    $ecb_violation->issued_as_aggr_level = $response->issued_as_aggr_level; 
                    $ecb_violation->save();
                }

                if (!is_null($response->compliance_on)) { 
                    $ecb_violation->compliance_on = $response->compliance_on;
                    $ecb_violation->save();
                }

                if (!is_null($response->cert_submission_date)) { 
                    $ecb_violation->cert_submission_date = $response->cert_submission_date; 
                    $ecb_violation->save();
                }

                if (!is_null($response->scheduled_hearing_date)) { 
                    $ecb_violation->scheduled_hearing_date = $response->scheduled_hearing_date; 
                    $ecb_violation->save();
                }

                if (!is_null($response->penalty_imposed)) { 
                    $ecb_violation->penalty_imposed = $response->penalty_imposed; 
                    $ecb_violation->save();
                }

                if (!is_null($response->adjustments)) { 
                    $ecb_violation->adjustments = $response->adjustments; 
                    $ecb_violation->save();
                }

                if (!is_null($response->penalty_balance_due)) { 
                    $ecb_violation->penalty_balance_due = $response->penalty_balance_due; 
                    $ecb_violation->save();
                }

                if (!is_null($response->amount_paid)) { 
                    $ecb_violation->amount_paid = $response->amount_paid; 
                    $ecb_violation->save();
                }
            }
        }
        
        $bis_uri_request = $client->get(env('DOB_API').'/overview?house_number='.$property->house_number.'&street='.$property->street_name.'&borough='.$property->borough);
        $bis_uri_response = json_decode($bis_uri_request->getBody()->getContents());
        if (!is_null($bis_uri_response)) { 
            if(!empty($bis_uri_response->ecb_violations_uri) && empty($property->ecb_violations_uri)){ 
                $property->ecb_violations_uri = $bis_uri_response->ecb_violations_uri;
                $property->save();
            }

            if(!empty($bis_uri_response->ecb_violations_total)){ 
                $property->ecb_violations_total = $bis_uri_response->ecb_violations_total;
                $property->save();
            }

            if(!empty($bis_uri_response->ecb_violations_open)){ 
                $property->ecb_violations_open = $bis_uri_response->ecb_violations_open;
                $property->save();
            }
        }
        $total_amount_ecb_violations = BISECBViolation::where('property_id', $property->id)->get()->count();
        if ($property->ecb_violations_total > 0) { 
            $property->ecb_violations_endpoint = $property->ecb_violations_uri;
            $property->save();

            while ($total_amount_ecb_violations !== $property->ecb_violations_total && $property->ecb_violations_endpoint != '') { 
                $request = $client->post(env('DOB_BIS_API').'/property/dob-api/ecb-violations/index', [ 
                    'form_params' => [ 
                        'endpoint' => $property->ecb_violations_endpoint
                    ]
                ]); 
                $response = json_decode($request->getBody()->getContents()); 
                if (count($response->ecb_violations) > 0) { 
                    foreach ($response->ecb_violations as $ecb_violation) { 
                        $ecb_violations_exist = BISECBViolation::where('property_id', $property->id)->where('ecb_number', $ecb_violation->ecb_number)->get();
                        if (count($ecb_violations_exist) === 0) { 
                            $new_ecb_violation = BISECBViolation::create([ 
                                'property_id' => $property->id, 
                                'ecb_number' => $ecb_violation->ecb_number,
                                'bvs_status' => $ecb_violation->bvs_status, 
                                'respondent' => $ecb_violation->respondent, 
                                'ecb_status' => $ecb_violation->ecb_status, 
                                'viol_date' => $ecb_violation->viol_date, 
                                'infraction_codes' => $ecb_violation->infraction_codes, 
                                'ecb_penalty_due' => $ecb_violation->ecb_penalty_due
                            ]);

                            if ($ecb_violation->active == true) { 
                                $new_ecb_violation->active = true; 
                                $new_ecb_violation->save();
                            }

                            if (!empty($ecb_violation->ecb_url)) { 
                                $new_ecb_violation->uri = $ecb_violation->ecb_url; 
                                $new_ecb_violation->save();
                            }
                        }
                    }
                }
                if (!empty($response->nextpage_url)) { 
                    $property->ecb_violations_endpoint = $response->nextpage_url; 
                    $property->save();
                }
                if (empty($response->nextpage_url)) { 
                    $property->ecb_violations_endpoint = ''; 
                    $property->save();
                }
                $total_amount_ecb_violations = BISECBViolation::where('property_id', $property->id)->get(); 
            }
        }

        return response([ 
            'success' => true
        ], 200);
    }
}
