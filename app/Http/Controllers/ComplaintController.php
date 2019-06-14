<?php

namespace App\Http\Controllers;

use App\Property;
use App\Complaint; 
use App\BISComplaint;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    //
	public function index(Request $request, $Id)
	{ 
        $complaints = Complaint::where('property_id', $Id)->get();
        if(is_null($complaints)){ 
            response([ 
                'complaints' => null
            ], 200);
        }
        response([ 
            'complaints' => $complaints
        ], 200);
	}

    public function swipeIndexOD(Request $request, $Id)
    { 
        $complaints = Property::find($Id)->complaints; 
        return response($complaints, 200);
    }

    public function swipeIndexBIS(Request $request, $Id)
    { 
        $complaints = Property::find($Id)->bis_complaints; 
        return response($complaints, 200);
    }

	public function BISindex(Request $request, $Id)
	{ 
		$complaints = BISComplaint::where('property_id', $Id)->get();
        if(is_null($complaints)){ 
            response([ 
                'complaints' => null
            ], 200);
        }
        response([ 
            'complaints' => $complaints
        ], 200);
	}


    public function getComplaints(Request $request, $Id)
    { 
    	$property = Property::find($Id);
        
        if(is_null($property)) { 
            return response([ 
                'success' => false, 
            ], 200);
        }

        $client = new Client(); 
        $complaint_request = $client->get('https://data.cityofnewyork.us/resource/muk7-ct23.json?bin='.$property->bin); 
        $complaint_response = json_decode($complaint_request->getBody()->getContents());
        if (!is_null($complaint_response)){ 
            foreach ($complaint_response as $data) { 
                $complaintCheck = Complaint::where('property_id', $property->id)
                                           ->where('complaint_number', $data->complaint_number)
                                           ->first();
                
                if (is_null($complaintCheck)) { 
                    $complaint = new Complaint; 

                    if (!empty($property->id)) { 
                        $complaint->property_id = $property->id; 
                        $complaint->save();
                    }

                    if (!empty($data->complaint_number)) { 
                        $complaint->complaint_number = $data->complaint_number;
                        $complaint->save();
                    }

                    if (!empty($data->status)) { 
                        $complaint->status = $data->status;
                        $complaint->save();
                    }

                    if (!empty($data->date_entered)) { 
                        $complaint->date_entered = $data->date_entered;
                        $complaint->save();
                    }

                    if (!empty($data->house_number)) { 
                        $complaint->house_number = $data->house_number;
                        $complaint->save();
                    }

                    if (!empty($data->zip_code)) { 
                        $complaint->zip_code = $data->zip_code;
                        $complaint->save();
                    }

                    if (!empty($data->house_street)) { 
                        $complaint->house_street = $data->house_street;
                        $complaint->save();
                    }

                    if (!empty($data->bin)) { 
                        $complaint->bin = $data->bin;
                        $complaint->save();
                    }

                    if (!empty($data->community_board)) { 
                        $complaint->community_board = $data->community_board;
                        $complaint->save();
                    }

                    if (!empty($data->special_district)) { 
                        $complaint->special_district = $data->special_district;
                        $complaint->save();
                    }

                    if (!empty($data->complaint_category)) { 
                        $complaint->complaint_category = $data->complaint_category;
                        $complaint->save();
                    }

                    if (!empty($data->unit)) { 
                        $complaint->unit = $data->unit;
                        $complaint->save();
                    }

                    if (!empty($data->disposition_date)) { 
                        $complaint->disposition_date = $data->disposition_date;
                        $complaint->save();
                    }

                    if (!empty($data->disposition_code)) { 
                        $complaint->disposition_code = $data->disposition_code;
                        $complaint->save();
                    }

                    if (!empty($data->inspection_date)) { 
                        $complaint->inspection_date = $data->inspection_date;
                        $complaint->save();
                    }

                    if (!empty($data->dobrundate)) { 
                        $complaint->dobrundate = $data->dobrundate;
                        $complaint->save();
                    }
                }

                if (!is_null($complaintCheck)) { 
                    $complaint = $complaintCheck; 
                    // event - status has changed
                    if($complaint->status != $data->status){ 
                        $complaint->status = $data->status; 
                        $complaint->save();
                    }
                } 
            }
        }
        return response([ 
            'success' => true
        ], 200);
    }

    public function getBISComplaints($Id)
    { 
    	$p = Property::find($Id); 

        if (is_null($p)) { 
            return response([ 
                'success' => false,
            ], 200);
        }

        $client = new Client();
        $p_update = json_decode($client->get(env('DOB_API').'/overview?house_number='.$p->house_number.'&street='.$p->street_name.'&borough='.$p->borough)->getBody()->getContents());
        if(!is_null($p_update) && isset($p_update->complaints_uri) && isset($p_update->complaints_total) && isset($p_update->complaints_open)){
            $p->complaints_uri = $p_update->complaints_uri; 
            $p->complaints_endpoint = $p_update->complaints_uri;
            $p->complaints_total = $p_update->complaints_total; 
            $p->complaints_open = $p_update->complaints_open; 
            $p->save();
        }

        if($p->complaints_total > 0){ 
            $count = $p->bis_complaints->count();
            while($count !== $p->complaints_total && $p->complaints_endpoint != ''){
                $d = json_decode($client->post(env('DOB_API').'/complaint-index', [ 
                    'json' => [ 
                        'endpoint' => $p->complaints_endpoint
                    ]
                ])->getBody()->getContents());
                if(isset($d->complaints)){ 
                    if(count($d->complaints) > 0){ 
                        foreach($d->complaints as $c){ 
                            $exist = BISComplaint::where('property_id', $p->id)->where('complaint_number', $c->complaint_number)->get()->count();
                            if($exist <= 0){ 
                                $new = new BISComplaint;
                                $new->property_id = $p->id;
                                $new->complaint_number = $c->complaint_number; 
                                $new->url = $c->url; 
                                $new->address = $c->address; 
                                $new->date_entered = $c->date_entered; 
                                $new->category = $c->category; 
                                $new->inspection_date = $c->inspection_date; 
                                $new->status = $c->status;
                                $new->save();
                                if($new->status === 'ACT'){ 
                                    $new->active = 1;
                                    $new->save();
                                }
                            }
                        }
                    }
                    $p->complaints_endpoint = $d->nextpage_url;
                    $p->save();
                    $count = $p->bis_complaints->count();
                }
            }
        }

        $bis_complaints = BISComplaint::where('property_id', $p->id)->get();
        if(count($bis_complaints) > 0){ 
            foreach($bis_complaints as $c){ 
                $client = new Client();
                if(!is_null($c->url)){ 
                    $d = json_decode($client->post(env('DOB_API').'/complaint-record', [ 
                        'json' => [ 
                            'endpoint' => $c->url
                        ]
                    ])->getBody()->getContents());
                     
                    if(isset($d->description) && !is_null($d->description)){ 
                        $c->description = $d->description;
                        $c->save();
                    }

                    if(isset($d->category_code) && !is_null($d->category_code)){
                        $c->category_code = $d->category_code; 
                    }
                    if(isset($d->category_code_description) && !is_null($d->category_code_description)){ 
                        $c->category_code_description = $d->category_code_description; 
                        $c->save();
                    }
                    if(isset($d->assigned_to) && !is_null($d->assigned_to)){ 
                        $c->assigned_to = $d->assigned_to;
                        $c->save();
                    } 
                    if(isset($d->received) && !is_null($d->received)){ 
                        $c->received = $d->received;
                        $c->save();
                    } 
                    if(isset($d->owner) && !is_null($d->owner)){ 
                        $c->owner = $d->owner;
                        $c->save();
                    }
                    if(isset($d->disposition) && !is_null($d->disposition)){ 
                        $c->disposition = $d->disposition;
                        $c->save();
                    }
                    if(isset($d->disposition_date) && !is_null($d->disposition_date)){ 
                        $c->disposition_date = $d->disposition_date;
                        $c->save();
                    }
                    if(isset($d->disposition_description) && !is_null($d->disposition_description)){ 
                        $c->disposition_description = $d->disposition_description;
                        $c->save();
                    }
                    if(isset($d->too_reference_number) && !is_null($d->too_reference_number)){ 
                        $c->too_reference_number = $d->too_reference_number;
                        $c->save();
                    }
                    if(isset($d->priority) && !is_null($d->priority)){ 
                        $c->priority = $d->priority;
                        $c->save();
                    }
                    if(isset($d->last_inspection) && !is_null($d->last_inspection)){ 
                        $c->last_inspection = $d->last_inspection;
                        $c->save();
                    }
                    if(isset($d->comments) && !is_null($d->comments)){ 
                        $c->comments = $d->comments;
                        $c->save();
                    }
                    if(isset($d->job_number) && !is_null($d->job_number)){ 
                        $c->job_number = $d->job_number;
                        $c->save();
                    }
                    if(isset($d->permit_number) && !is_null($d->permit_number)){ 
                        $c->permit_number = $d->permit_number;
                        $c->save();
                    }
                    if(isset($d->badge_number) && !is_null($d->badge_number)){ 
                        $c->badge_number = $d->badge_number;
                        $c->save();
                    }
                    if(isset($d->community_board) && !is_null($d->community_board)){
                        $c->community_board = $d->community_board; 
                        $c->save();
                    }
                    if(isset($d->dob_violation_number) && !is_null($d->dob_violation_number)){ 
                        $c->dob_violation_number = $d->dob_violation_number;
                        $c->save();
                    }
                    if(isset($d->ecb_violation_number) && !is_null($d->ecb_violation_number)){ 
                        $c->ecb_violation_number = $d->ecb_violation_number;
                        $c->save();
                    }
                    if(isset($d->prev_dob_violation_number) && !is_null($d->prev_dob_violation_number)){ 
                        $c->prev_dob_violation_number = $d->prev_dob_violation_number;
                        $c->save();
                    }
                    if(isset($d->prev_ecb_violation_number) && !is_null($d->prev_ecb_violation_number)){ 
                        $c->prev_ecb_violation_number = $d->prev_ecb_violation_number;
                        $c->save();
                    }
                    if(isset($d->electrical_violation_number) && !is_null($d->electrical_violation_number)){ 
                        $c->electrical_violation_number = $d->electrical_violation_number;
                        $c->save();
                    }
                }
            }
        }

        return response([ 
            'success' => true
        ], 200);
    } 
}
