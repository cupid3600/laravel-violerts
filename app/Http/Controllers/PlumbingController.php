<?php

namespace App\Http\Controllers;

use App\Property; 
use App\BISPlumbingInspectionPermit; 
use App\App\BISPlumbingInspectionWorkOrder;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PlumbingController extends Controller
{
    //
    public function getPlumbingInspectionIndex (Request $request, $Id)
    { 
        $property = Property::find($Id);
        if(!is_null($property)){ 
            $inspection_uri = $property->plumbing_inspections_uri
            while (!empty($inspection_uri)) { 
                $client = new Client(); 
                $request = $client->post(env('DOB_BIS_API').'/property/dob-api/plumbing-inspections/index', [ 
                    'form_params' => [ 
                        'endpoint' => $inspection_uri
                    ]
                ]); 
                $response = $request->getBody()->getContents(); 
                if(!is_null($response)){ 
                    foreach($response->plumbing_inspections as $plumbing_inspection) { 
                        $newPlumbingInspection = BISPlumbingInspectionPermit::create([ 
                            'property_id' => $property->id,
                            'permit_number' => $plumbing_inspection->permit,
                            'permit_uri' => $plumbing_inspection->permit_uri,
                            'inspection_date' => $plumbing_inspection->insp_date_time,
                            'inspection_status' => $plumbing_inspection->status, 
                            'work_order' => $plumbing_inspection->work_order, 
                            'work_order_uri' => $plumbing_inspection->work_order_uri, 
                            'badge' => $plumbing_inspection->badge, 
                            'job_number' => $plumbing_inspection->job_number, 
                            'job_number_uri' => $plumbing_inspection->job_number_uri,
                            'status' => $plumbing_inspection->status
                        ]); 

                        if ($plumbing_inspection->gas === 'Y') { 
                            $newPlumbingInspection->gas = true; 
                            $newPlumbingInspection->save();
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

        // add response here 
        return response([ 
            'success' => true
        ], 200);
    }

    public function getPlumbingPermits (Request $request, $Id)
    { 
        $property = Property::find($Id); 
        if(!is_null($property)){ 
            $plumbing_permits = BISPlumbingInspectionPermit::where('property_id', $property->id)->get(); 
            if($count($plumbing_permits) > 0) { 
                foreach ($plumbing_permits as $plumbing_permit) { 
                    $client = new Client(); 
                    $request = $client->post(env('DOB_BIS_API').'/property/dob-api/plumbing-inspections/permits/index', [ 
                        'form_params' => $plumbing_permit->permit_uri
                    ]);
                    $response = $request->getBody()->getContents(); 
                    if(!is_null($response)){ 
                        $permit_uri = $response->permit_number_uri; 
                        $client = new Client(); 
                        $request = $client->post(env('DOB_BIS_API').'/property/dob-api/plumbing-inspections/permits/record', [ 
                            'form_params' => $permit_uri
                        ]);
                        $response = $request->getBody()->getContents();
                        if(!is_null($response)){ 
                            $plumbing_permit->pltype = $response->pltype; 
                            $plumbing_permit->plid = $response->plid;
                            $plumbing_permit->save();
                        }
                    }
                }
            }
        }
        return response([
            'success' => true
        ], 200);
    }

    public function getPlumbingWorkOrders (Request $request, $Id)
    { 
        $property = Property::find($Id); 
        if(!is_null($property)){ 
            $plumbing_permits = BISPlumbingInspectionPermit::where('property_id', $property->id)->get(); 
            if(count($plumbing_permits) > 0) { 
                foreach ($plumbing_permits as $plumbing_permit) { 
                    $client = new Client();
                    $request = $client->post(env('DOB_BIS_API').'/property/dob-api/plumbing-inspections/work-order', [ 
                        'form_params' => $plumbing_permit->work_order_uri
                    ]); 
                    $response = $request->getBody()->getContents(); 
                    if(!is_null($response)){ 
                        $newPlumbingWorkOrder = BISPlumbingInspectionWorkOrder::create([ 
                            'property_id' => $property->id, 
                            'work_order_number' => $plumbing_permit->work_order_number, 
                            'licensee' => $response->licensee, 
                            'work_description' => $response->work_description, 
                            'inspector_badge' => $plumbing_permit->badge, 
                            'date_inspected' => $response->date_inspected, 
                            'inspection_results' => $response->inspection_results, 
                            'num_meters' => $response->num_meters, 
                            'num_meters_location' => $response->num_meters_location, 
                            'num_risers' => $response->num_risers, 
                            'num_risers_location' => $response->num_risers_location, 
                            'gas_uses' => $response->gas_uses, 
                            'comments' => $response->comments, 
                            'floor_apts_insp_area' => $response->floor_apts_insp_area, 
                            'date_of_inspection' => $response->date_of_inspection, 
                            'time_scheduled' => $response->time_scheduled, 
                            'inspection_reference_num' => $response->inspection_reference_num, 
                            'status' => $response->status, 
                            'type' => $response->type, 
                            'accela_inspection_num' => $response->accela_inspection_num, 
                            'results_floor' => $response->results->floor, 
                            'results_ref_no' => $response->results->ref_no, 
                            'results_system' => $response->results->system, 
                            'results_component' => $response->results->component, 
                            'resuts_test_inspection' => $response->results->test_inspection, 
                            'results_result' => $response->results->result
                        ]);
                    }
                }
            }
        }
        return response([ 
            'success' => true
        ], 200);
    }
}
