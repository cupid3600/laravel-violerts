<?php

namespace App\Http\Controllers;

use App\Property;
use App\JobApplication; 
use App\JobApplication2;
use App\BISJobApplication; 
use App\BISJApplicant;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
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
        $job_applications = Property::find($Id)->job_applications; 
        $job_applications = JobApplication::where('property_id', $Id)
                                          ->where('doc__', '01')
                                          ->where('job_status', '!=', 'X')
                                          ->where('job_status', '!=', 'U')
                                          ->with(['job_application_ext'])
                                          ->get();
        return response($job_applications, 200);
    }

    public function swipeIndexBIS (Request $request, $Id)
    { 
        //$job_applications = Property::find($Id)->bis_job_applications; 
        $job_applications = BISJobApplication::where('property_id', $Id)
                                             ->where('doc_number', '01')
                                             ->where('job_status', '!=', 'X SIGNED OFF')
                                             ->where('job_status', '!=', 'U COMPLETED')
                                             ->with(['applicant'])
                                             ->get();
        return response($job_applications, 200);
    }

    public function getJobApplications (Request $request, $Id)
    { 
        $property = Property::find($Id); 

        if (is_null($property)) { 
            return response([ 
                'success' => false
            ], 200);
        }

        $client = new Client();
        $job_application_request = $client->get('https://data.cityofnewyork.us/resource/rvhx-8trz.json?bin__='.$property->bin); 
        $job_application_response = json_decode($job_application_request->getBody()->getContents()); 
        if (!is_null($job_application_response)) { 
            foreach ($job_application_response as $data) { 
                $job_application_exist = JobApplication::where('property_id', $property->id)->where('job__', $data->job__)->where('doc__', $data->doc__)->first();
                if (is_null($job_application_exist)) { 
                    $job_application = new JobApplication; 
                    $job_application_ext = new JobApplication2; 

                    if (!empty($property->id)) { 
                        $job_application->property_id = $property->id; 
                        $job_application->save();
                    }

                    if (!empty($data->job__)) { 
                        $job_application->job__ = $data->job__; 
                        $job_application->save();
                    }

                    if (!empty($data->doc__)) { 
                        $job_application->doc__ = $data->doc__; 
                        $job_application->save();
                    }

                    if (!empty($data->borough)) { 
                        $job_application->borough = $data->borough; 
                        $job_application->save();
                    }

                    if (!empty($data->house__)) { 
                        $job_application->house__ = $data->house__; 
                        $job_application->save();
                    }

                    if (!empty($data->street_name)) { 
                        $job_application->street_name = $data->street_name; 
                        $job_application->save();
                    }

                    if (!empty($data->block)) { 
                        $job_application->block = $data->block; 
                        $job_application->save();
                    }

                    if (!empty($data->lot)) { 
                        $job_application->lot = $data->lot; 
                        $job_application->save();
                    }

                    if (!empty($data->bin__)) { 
                        $job_application->bin__ = $data->bin__; 
                        $job_application->save();
                    }

                    if (!empty($data->job_status)) { 
                        $job_application->job_status = $data->job_status; 
                        $job_application->save();
                    }

                    if (!empty($data->job_status_descrp)) { 
                        $job_application->job_status_descrp = $data->job_status_descrp; 
                        $job_application->save();
                    }

                    if (!empty($data->latest_action_date)) { 
                        $job_application->latest_action_date = $data->latest_action_date; 
                        $job_application->save();
                    }

                    if (!empty($data->building_type)) { 
                        $job_application->building_type = $data->building_type; 
                        $job_application->save();
                    }

                    if (!empty($data->community_board)) { 
                        $job_application->community_board = $data->community_board; 
                        $job_application->save();
                    }

                    if (!empty($data->cluster)) { 
                        $job_application->cluster = $data->cluster; 
                        $job_application->save();
                    }

                    if (!empty($data->landmarked)) { 
                        $job_application->landmarked = $data->landmarked; 
                        $job_application->save();
                    }

                    if (!empty($data->adult_estab)) { 
                        $job_application->adult_estab = $data->adult_estab; 
                        $job_application->save();
                    }

                    if (!empty($data->loft_board)) { 
                        $job_application->loft_board = $data->loft_board; 
                        $job_application->save();
                    }

                    if (!empty($data->city_owned)) { 
                        $job_application->city_owned = $data->city_owned; 
                        $job_application->save();
                    }

                    if (!empty($data->little_e)) { 
                        $job_application->little_e = $data->little_e; 
                        $job_application->save();
                    }

                    if (!empty($data->pc_filed)) { 
                        $job_application->pc_filed = $data->pc_filed; 
                        $job_application->save();
                    }

                    if (!empty($data->efiling_filed)) { 
                        $job_application->efiling_filed = $data->efiling_filed; 
                        $job_application->save();
                    }

                    if (!empty($data->plumbing)) { 
                        $job_application->plumbing = $data->plumbing; 
                        $job_application->save();
                    }

                    if (!empty($data->mechanical)) { 
                        $job_application->mechanical = $data->mechanical; 
                        $job_application->save();
                    }

                    if (!empty($data->boiler)) { 
                        $job_application->boiler = $data->boiler; 
                        $job_application->save();
                    }

                    if (!empty($data->fuel_burning)) { 
                        $job_application->fuel_burning = $data->fuel_burning; 
                        $job_application->save();
                    }

                    if (!empty($data->fuel_storage)) { 
                        $job_application->fuel_storage = $data->fuel_storage; 
                        $job_application->save();
                    }

                    if (!empty($data->standpipe)) { 
                        $job_application->standpipe = $data->standpipe; 
                        $job_application->save();
                    }

                    if (!empty($data->sprinkler)) { 
                        $job_application->sprinkler = $data->sprinkler; 
                        $job_application->save();
                    }

                    if (!empty($data->fire_alarm)) { 
                        $job_application->fire_alarm = $data->fire_alarm; 
                        $job_application->save();
                    }

                    if (!empty($data->equipment)) { 
                        $job_application->equipment = $data->equipment; 
                        $job_application->save();
                    }

                    if (!empty($data->fire_suppression)) { 
                        $job_application->fire_suppression = $data->fire_suppression; 
                        $job_application->save();
                    }

                    if (!empty($data->curb_cut)) { 
                        $job_application->curb_cut = $data->curb_cut; 
                        $job_application->save();
                    }

                    if (!empty($data->other)) { 
                        $job_application->other = $data->other; 
                        $job_application->save();
                    }

                    if (!empty($data->other_description)) { 
                        $job_application->other_description = $data->other_description; 
                        $job_application->save();
                    }

                    if (!empty($data->applicant_s_first_name)) { 
                        $job_application->applicant_s_first_name = $data->applicant_s_first_name; 
                        $job_application->save();
                    }

                    if (!empty($data->applicant_s_last_name)) { 
                        $job_application->applicant_s_last_name = $data->applicant_s_last_name; 
                        $job_application->save();
                    }

                    if (!empty($data->applicant_professional_title)) { 
                        $job_application->applicant_professional_title = $data->applicant_professional_title; 
                        $job_application->save();
                    }

                    if (!empty($data->applicant_license__)) { 
                        $job_application->applicant_license__ = $data->applicant_license__; 
                        $job_application->save();
                    }

                    if (!empty($data->professional_cert)) { 
                        $job_application->professional_cert = $data->professional_cert; 
                        $job_application->save();
                    }

                    if (!empty($data->pre_filing_date)) { 
                        $job_application->pre_filing_date = $data->pre_filing_date; 
                        $job_application->save();
                    }

                    if (!empty($job_application->id)) { 
                        $job_application_ext->job_application_id = $job_application->id; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->paid)) { 
                        $job_application_ext->paid = $data->paid; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->fully_paid)) { 
                        $job_application_ext->fully_paid = $data->fully_paid; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->assigned)) { 
                        $job_application_ext->assigned = $data->assigned; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->approved)) { 
                        $job_application_ext->approved = $data->approved; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->fully_permitted)) { 
                        $job_application_ext->fully_permitted = $data->fully_permitted; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->initial_cost)) { 
                        $job_application_ext->initial_cost = $data->initial_cost; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->total_est_fee)) { 
                        $job_application_ext->total_est_fee = $data->total_est_fee; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->fee_status)) { 
                        $job_application_ext->fee_status = $data->fee_status; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->existing_zoning_sqft)) { 
                        $job_application_ext->existing_zoning_sqft = $data->existing_zoning_sqft; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->proposed_zoning_sqft)) { 
                        $job_application_ext->proposed_zoning_sqft = $data->proposed_zoning_sqft; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->horizontal_enlrgmt)) { 
                        $job_application_ext->horizontal_enlrgmt = $data->horizontal_enlrgmt; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->vertical_enlrgmt)) { 
                        $job_application_ext->vertical_enlrgmt = $data->vertical_enlrgmt; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->enlargement_sq_footage)) { 
                        $job_application_ext->enlargement_sq_footage = $data->enlargement_sq_footage; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->street_frontage)) { 
                        $job_application_ext->street_frontage = $data->street_frontage; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->existingno_of_stories)) { 
                        $job_application_ext->existingno_of_stories = $data->existingno_of_stories; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->proposed_no_of_stories)) { 
                        $job_application_ext->proposed_no_of_stories = $data->proposed_no_of_stories; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->existing_height)) { 
                        $job_application_ext->existing_height = $data->existing_height; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->proposed_height)) { 
                        $job_application_ext->proposed_height = $data->proposed_height; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->existing_dwelling_units)) { 
                        $job_application_ext->existing_dwelling_units = $data->existing_dwelling_units; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->proposed_dwelling_units)) { 
                        $job_application_ext->proposed_dwelling_units = $data->proposed_dwelling_units; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->existing_occupancy)) { 
                        $job_application_ext->existing_occupancy = $data->existing_occupancy; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->proposed_occupancy)) { 
                        $job_application_ext->proposed_occupancy = $data->proposed_occupancy; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->site_fill)) { 
                        $job_application_ext->site_fill = $data->site_fill; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->zoning_dist1)) { 
                        $job_application_ext->zoning_dist1 = $data->zoning_dist1; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->zoning_dist2)) { 
                        $job_application_ext->zoning_dist2 = $data->zoning_dist2; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->zoning_dist3)) { 
                        $job_application_ext->zoning_dist3 = $data->zoning_dist3; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->special_dist_1)) { 
                        $job_application_ext->special_dist_1 = $data->special_dist_1; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->special_dist_2)) { 
                        $job_application_ext->special_dist_2 = $data->special_dist_2; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->owner_type)) { 
                        $job_application_ext->owner_type = $data->owner_type; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->non_profit)) { 
                        $job_application_ext->non_profit = $data->non_profit; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->owner_s_first_name)) { 
                        $job_application_ext->owner_s_first_name = $data->owner_s_first_name; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->owner_s_last_name)) { 
                        $job_application_ext->owner_s_last_name = $data->owner_s_last_name; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->owner_s_business_name)) { 
                        $job_application_ext->owner_s_business_name = $data->owner_s_business_name; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->owner_s_house_number)) { 
                        $job_application_ext->owner_s_house_number = $data->owner_s_house_number; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->owner_shouse_street_name)) { 
                        $job_application_ext->owner_shouse_street_name = $data->owner_shouse_street_name; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->city__)) { 
                        $job_application_ext->city__ = $data->city__; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->state)) { 
                        $job_application_ext->state = $data->state; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->zip)) { 
                        $job_application_ext->zip = $data->zip; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->owner_sphone)) { 
                        $job_application_ext->owner_sphone = $data->owner_sphone; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->job_description)) { 
                        $job_application_ext->job_description = $data->job_description; 
                        $job_application_ext->save();
                    }

                    if (!empty($data->dobrundate)) { 
                        $job_application_ext->dobrundate = $data->dobrundate; 
                        $job_application_ext->save();
                    }
                }
            }
        }

        return response([ 
            'success' => true
        ], 200);
    }

    public function getBISJobApplicationsIndex ($Id)
    { 
        $property = Property::find($Id); 
        if (!is_null($property)) { 
            $client = new Client();
            $bis_uri_request = $client->get(env('DOB_API').'/overview?house_number='.$property->house_number.'&street='.$property->street_name.'&borough='.$property->borough); 
            $bis_uri_response = json_decode($bis_uri_request->getBody()->getContents()); 
            if(!is_null($bis_uri_response)){ 
                $property->jobs_filings_uri = $bis_uri_response->jobs_filings_uri; 
                $property->jobs_filings_total = $bis_uri_response->jobs_filings_total;
                $property->save();
            }
            $job_application_uri = $property->jobs_filings_uri;
            $job_application_count = BISJobApplication::where('property_id', $property->id)->get()->count();
            if ($property->jobs_filings_total > 0) { 
                while (!empty($job_application_uri) && $job_application_count !== $property->jobs_filings_total) { 
                    $request = $client->post(env('DOB_BIS_API').'/property/dob-api/job-applications/index', [ 
                        'form_params' => [ 
                            'endpoint' => $job_application_uri
                        ]
                    ]);
                    $response = json_decode($request->getBody()->getContents());
                    if(!is_null($response)){ 
                        foreach ($response->job_filings as $job_application) { 
                            $jobApplicationStored = BISJobApplication::where('property_id', $property->id)
                                                                     ->where('job_number', $job_application->job_number)
                                                                     ->where('doc_number', $job_application->doc_number)
                                                                     ->get();
                            if (count($jobApplicationStored) === 0) { 
                                $newJobApplication = BISJobApplication::create([ 
                                    'property_id' => $property->id, 
                                    'file_date' => $job_application->file_date, 
                                    'uri' => $job_application->url, 
                                    'job_number' => $job_application->job_number,
                                    'doc_number' => $job_application->doc_number, 
                                    'job_type' => $job_application->job_type, 
                                    'job_status' => $job_application->job_status, 
                                    'status_date' => $job_application->status_date, 
                                    'lic_number' => $job_application->lic_number, 
                                    'applicant' => $job_application->applicant, 
                                    'in_audit' => $job_application->in_audit, 
                                    'zoning_status' => $job_application->zoning_status
                                ]);
                            }
                        }
                    }

                    if(!empty($response->nextpage_url)) { 
                        $job_application_uri = $response->nextpage_url;
                    }

                    if(empty($response->nextpage_url)) { 
                        $job_application_uri = '';
                    }
                }
            }
        }
        return response([ 
            'success' => true
        ], 200); 
    }

    public function getBISJobApplicationsRecords ($Id)
    { 
        $property = Property::find($Id);
        if(!is_null($property)){ 
            $client = new Client(); 
            $job_applications = BISJobApplication::where('property_id', $property->id)->where('uri', '!=', '')->get();
            if(count($job_applications) > 0){ 
                foreach($job_applications as $job_application){ 
                    $request = $client->post(env('DOB_BIS_API').'/property/dob-api/job-applications/record', [ 
                        'form_params' => [ 
                            'endpoint' => $job_application->uri
                        ]
                    ]);
                    $response = json_decode($request->getBody()->getContents());

                    if (!is_null($response->job_number)) { 
                        $job_application->job_number = $response->job_number;
                        $job_application->save();
                    }

                    if (!is_null($response->last_action)) {
                        $job_application->last_action = $response->last_action;
                        $job_application->save();
                    }

                    if (!is_null($response->application_approved_on)) {
                        $job_application->application_approved_on = $response->application_approved_on;
                        $job_application->save();
                    }

                    if (!is_null($response->building_type)) {
                        $job_application->building_type = $response->building_type;
                        $job_application->save();
                    }

                    if (!is_null($response->estimated_total_cost)) {
                        $job_application->estimated_total_cost = $response->estimated_total_cost;
                        $job_application->save();
                    }

                    if (!is_null($response->electronically_filed)) {
                        $job_application->electronically_filed = $response->electronically_filed;
                        $job_application->save();
                    }


                    if (!is_null($response->pre_filed)) { 
                        $job_application->pre_filed = $response->pre_filed;
                        $job_application->save();
                    }

                    if (!is_null($response->date_filed)) { 
                        $job_application->date_filed = $response->date_filed;
                        $job_application->save();
                    }

                    if (!is_null($response->fee_structure)) { 
                        $job_application->fee_structure = $response->fee_structure;
                        $job_application->save();
                    }

                    if (!is_null($response->review_is_requested_code)) { 
                        $job_application->review_is_requested_code = $response->review_is_requested_code;
                        $job_application->save();
                    }

                    if (!is_null($response->house_number)) { 
                        $job_application->house_number = $response->house_number;
                        $job_application->save();
                    }

                    if (!is_null($response->street_name)) { 
                        $job_application->street_name = $response->street_name;
                        $job_application->save();
                    }

                    if (!is_null($response->borough)) { 
                        $job_application->borough = $response->borough;
                        $job_application->save();
                    }

                    if (!is_null($response->work_on_floors)) { 
                        $job_application->work_on_floors = $response->work_on_floors;
                        $job_application->save();
                    }

                    if (!is_null($response->block)) { 
                        $job_application->block = $response->block;
                        $job_application->save();
                    }

                    if (!is_null($response->lot)) { 
                        $job_application->lot = $response->lot;
                        $job_application->save();
                    }

                    if (!is_null($response->bin)) { 
                        $job_application->bin = $response->bin;
                        $job_application->save();
                    }

                    if (!is_null($response->cb_number)) { 
                        $job_application->cb_number = $response->cb_number;
                        $job_application->save();
                    }

                    if (!is_null($response->condo_number)) { 
                        $job_application->condo_number = $response->condo_number;
                        $job_application->save();
                    }

                    if (!is_null($response->zipcode)) { 
                        $job_application->zipcode = $response->zipcode;
                        $job_application->save();
                    }

                    if (!is_null($response->applicant_name)) { 
                        $job_application->applicant_name = $response->applicant_name;
                        $job_application->save();
                    }

                    if (!is_null($response->applicant_business_name)) { 
                        $job_application->applicant_business_name = $response->applicant_business_name;
                        $job_application->save();
                    }

                    if (!is_null($response->applicant_business_phone)) { 
                        $job_application->applicant_business_phone = $response->applicant_business_phone;
                        $job_application->save();
                    }

                    if (!is_null($response->applicant_business_address)) { 
                        $job_application->applicant_business_address = $response->applicant_business_address;
                        $job_application->save();
                    }

                    if (!is_null($response->applicant_business_fax)) { 
                        $job_application->applicant_business_fax = $response->applicant_business_fax;
                        $job_application->save();
                    }

                    if (!is_null($response->applicant_email)) { 
                        $job_application->applicant_email = $response->applicant_email;
                        $job_application->save();
                    }

                    if (!is_null($response->applicant_mobile_phone)) { 
                        $job_application->applicant_mobile_phone = $response->applicant_mobile_phone;
                        $job_application->save();
                    }

                    if (!is_null($response->applicant_license_number)) { 
                        $job_application->applicant_license_number = $response->applicant_license_number;
                        $job_application->save();
                    }

                    if (!is_null($response->applicant_type)) { 
                        $job_application->applicant_type = $response->applicant_type;
                        $job_application->save();
                    }

                    if (!is_null($response->prev_applicant_name)) { 
                        $job_application->prev_applicant_name = $response->prev_applicant_name;
                        $job_application->save();
                    }

                    if (!is_null($response->prev_applicant_business_name)) { 
                        $job_application->prev_applicant_business_name = $response->prev_applicant_business_name;
                        $job_application->save();
                    }

                    if (!is_null($response->prev_applicant_business_phone)) { 
                        $job_application->prev_applicant_business_phone = $response->prev_applicant_business_phone;
                        $job_application->save();
                    }

                    if (!is_null($response->prev_applicant_business_address)) { 
                        $job_application->prev_applicant_business_address = $response->prev_applicant_business_address;
                        $job_application->save();
                    }

                    if (!is_null($response->prev_applicant_business_fax)) { 
                        $job_application->prev_applicant_business_fax = $response->prev_applicant_business_fax;
                        $job_application->save();
                    }

                    if (!is_null($response->prev_applicant_email)) { 
                        $job_application->prev_applicant_email = $response->prev_applicant_email;
                        $job_application->save();
                    }

                    if (!is_null($response->prev_applicant_mobile_phone)) { 
                        $job_application->prev_applicant_mobile_phone = $response->prev_applicant_mobile_phone;
                        $job_application->save();
                    }

                    if (!is_null($response->prev_applicant_type)) { 
                        $job_application->prev_applicant_type = $response->prev_applicant_type;
                        $job_application->save();
                    }

                    if (!is_null($response->prev_applicant_license_number)) { 
                        $job_application->prev_applicant_license_number = $response->prev_applicant_license_number;
                        $job_application->save();
                    }

                    if (!is_null($response->filing_rep_name)) { 
                        $job_application->filing_rep_name = $response->filing_rep_name;
                        $job_application->save();
                    }

                    if (!is_null($response->filing_rep_business_name)) { 
                        $job_application->filing_rep_business_name = $response->filing_rep_business_name;
                        $job_application->save();
                    }

                    if (!is_null($response->filing_rep_business_phone)) { 
                        $job_application->filing_rep_business_phone = $response->filing_rep_business_phone;
                        $job_application->save();
                    }

                    if (!is_null($response->filing_rep_business_address)) { 
                        $job_application->filing_rep_business_address = $response->filing_rep_business_address;
                        $job_application->save();
                    }

                    if (!is_null($response->filing_rep_business_fax)) { 
                        $job_application->filing_rep_business_fax = $response->filing_rep_business_fax;
                        $job_application->save();
                    }

                    if (!is_null($response->filing_rep_email)) { 
                        $job_application->filing_rep_email = $response->filing_rep_email;
                        $job_application->save();
                    }

                    if (!is_null($response->filing_rep_mobile_phone)) { 
                        $job_application->filing_rep_mobile_phone = $response->filing_rep_mobile_phone;
                        $job_application->save();
                    }

                    if (!is_null($response->filing_rep_registration_number)) { 
                        $job_application->filing_rep_registration_number = $response->filing_rep_registration_number;
                        $job_application->save();
                    }

                    if (!is_null($response->doc_overview_uri)) {
                        $job_application->doc_overview_uri = $response->doc_overview_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->fees_paid_uri)) {
                        $job_application->fees_paid_uri = $response->fees_paid_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->crane_information_uri)) {
                        $job_application->crane_information_uri = $response->crane_information_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->after_hours_variance_permit_uri)) {
                        $job_application->after_hours_variance_permit_uri = $response->after_hours_variance_permit_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->items_required_uri)) {
                        $job_application->items_required_uri = $response->items_required_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->forms_received_uri)) {
                        $job_application->forms_received_uri = $response->forms_received_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->plan_examination_uri)) {
                        $job_application->plan_examination_uri = $response->plan_examination_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->virtual_job_folder_uri)) {
                        $job_application->virtual_job_folder_uri = $response->virtual_job_folder_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->all_permits_uri)) {
                        $job_application->all_permits_uri = $response->all_permits_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->all_comments_uri)) {
                        $job_application->all_comments_uri = $response->all_comments_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->schedule_a_uri)) {
                        $job_application->schedule_a_uri = $response->schedule_a_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->schedule_b_uri)) {
                        $job_application->schedule_b_uri = $response->schedule_b_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->plumbing_inspections_uri)) {
                        $job_application->plumbing_inspections_uri = $response->plumbing_inspections_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->co_summary_uri)) {
                        $job_application->co_summary_uri = $response->co_summary_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->co_preview_uri)) {
                        $job_application->co_preview_uri = $response->co_preview_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->print_letter_of_completion_uri)) {
                        $job_application->print_letter_of_completion_uri = $response->print_letter_of_completion_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->dob_now_inspections_url)) {
                        $job_application->dob_now_inspections_url = $response->dob_now_inspections_url;
                        $job_application->save();
                    }

                    if (!is_null($response->job_application_type_a1_flag)) {
                        $job_application->job_application_type_a1_flag = $response->job_application_type_a1_flag;
                        $job_application->save();
                    }

                    if (!is_null($response->job_application_type_a1_ot_flag)) {
                        $job_application->job_application_type_a1_ot_flag = $response->job_application_type_a1_ot_flag;
                        $job_application->save();
                    }

                    if (!is_null($response->job_application_type_new_building_flag)) {
                        $job_application->job_application_type_a1_new_building_flag = $response->job_application_type_new_building_flag;
                        $job_application->save();
                    }

                    if (!is_null($response->job_application_type_a2_flag)) {
                        $job_application->job_application_type_a2_flag = $response->job_application_type_a2_flag;
                        $job_application->save();
                    }

                    if (!is_null($response->job_application_type_full_demo_flag)) {
                        $job_application->job_application_type_full_demo_flag = $response->job_application_type_full_demo_flag;
                        $job_application->save();
                    }

                    if (!is_null($response->job_application_type_a3_flag)) {
                        $job_application->job_application_type_a3_flag = $response->job_application_type_a3_flag;
                        $job_application->save();
                    }

                    if (!is_null($response->job_application_type_subdivision_improved)) {
                        $job_application->job_application_type_subdivision_improved = $response->job_application_type_subdivision_improved;
                        $job_application->save();
                    }

                    if (!is_null($response->job_application_type_sign)) {
                        $job_application->job_application_type_sign = $response->job_application_type_sign;
                        $job_application->save();
                    }

                    if (!is_null($response->job_application_type_subdivision_condo)) {
                        $job_application->job_application_type_subdivision_condo = $response->job_application_type_subdivision_condo;
                        $job_application->save();
                    }

                    if (!is_null($response->job_application_type_directive_14_acceptance_requested)) {
                        $job_application->job_application_type_directive_14_acceptance_requested = $response->job_application_type_directive_14_acceptance_requested;
                        $job_application->save();
                    }

                    if (!is_null($response->work_boiler)) { 
                        $job_application->work_boiler = $response->work_boiler;
                        $job_application->save();
                    }

                    if (!is_null($response->work_fire_supression)) { 
                        $job_application->work_fire_supression = $response->work_fire_supression;
                        $job_application->save();
                    }

                    if (!is_null($response->work_sprinkler)) { 
                        $job_application->work_sprinkler = $response->work_sprinkler;
                        $job_application->save();
                    }

                    if (!is_null($response->work_ot_general_construction)) { 
                        $job_application->work_general_construction = $response->work_ot_general_construction;
                        $job_application->save();
                    }

                    if (!is_null($response->work_fire_alarm)) { 
                        $job_application->work_fire_alarm = $response->work_fire_alarm;
                        $job_application->save();
                    }

                    if (!is_null($response->work_mechanical)) { 
                        $job_application->work_mechanical = $response->work_mechanical;
                        $job_application->save();
                    }

                    if (!is_null($response->work_construction_equipment)) { 
                        $job_application->work_construction_equipment = $response->work_construction_equipment;
                        $job_application->save();
                    }

                    if (!is_null($response->work_fuel_burning)) { 
                        $job_application->work_fuel_burning = $response->work_fuel_burning;
                        $job_application->save();
                    }

                    if (!is_null($response->work_plumbing)) { 
                        $job_application->work_plumbing = $response->work_plumbing;
                        $job_application->save();
                    }

                    if (!is_null($response->work_curb_cut)) { 
                        $job_application->work_curb_cut = $response->work_curb_cut;
                        $job_application->save();
                    }

                    if (!is_null($response->work_fuel_storage)) { 
                        $job_application->work_fuel_storage = $response->work_fuel_storage;
                        $job_application->save();
                    }

                    if (!is_null($response->work_standpipe)) { 
                        $job_application->work_standpipe = $response->work_standpipe;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_7_plans_page_count)) {
                        $job_application->sec_7_plans_page_count = $response->sec_7_plans_page_count;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_8_enlargement_proposed_yes) and !is_null($response->sec_8_enlargement_proposed_no)) { 
                        if ($response->sec_8_enlargement_proposed_yes) {
                            $job_application->sec_8_enlargement_proposed = true;
                        }
                        if ($response->sec_8_enlargement_proposed_no) {
                            $job_application->sec_8_enlargement_proposed = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_8_horizontal)) { 
                        $job_application->sec_8_horizontal = $response->sec_8_horizontal;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_8_vertical)) { 
                        $job_application->sec_8_vertical = $response->sec_8_vertical;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_8_total_bldg_square_footage)) { 
                        $job_application->sec_8_total_bldg_square_footage = $response->sec_8_total_bldg_square_footage;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_8_total_construction_floor_area)) { 
                        $job_application->sec_8_total_construction_floor_area = $response->sec_8_total_construction_floor_area;
                        $job_application->save();
                    }

                    if (!is_null($response->alt_required_new_building_yes) and !is_null($response->alt_required_new_building_no)) { 
                        if ($response->alt_required_new_building_yes) {
                            $job_application->alt_required_new_building = true;
                        }
                        if ($response->alt_required_new_building_no) {
                            $job_application->alt_required_new_building = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->alt_is_major_yes) and !is_null($response->alt_is_major_no)) { 
                        if ($response->alt_is_major_yes) {
                            $job_application->alt_is_major = true;
                        }
                        if ($response->alt_is_major_no) {
                            $job_application->alt_is_major = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->change_in_dwelling_unit_yes) and !is_null($response->change_in_dwelling_unit_no)) { 
                        if ($response->change_in_dwelling_unit_yes) {
                            $job_application->change_in_dwelling_unit = true;
                        }
                        if ($response->change_in_dwelling_unit_no) {
                            $job_application->change_in_dwelling_unit = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->change_in_occupancy_use_yes) and !is_null($response->change_in_occupancy_use_no)) { 
                        if ($response->change_in_occupancy_use_yes) {
                            $job_application->change_in_occupancy_use = true;
                        }
                        if ($response->change_in_occupancy_use_no) {
                            $job_application->change_in_occupancy_use = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->change_is_inconsistent_yes) and !is_null($response->change_is_inconsistent_no)) { 
                        if ($response->change_is_inconsistent_yes) {
                            $job_application->change_is_inconsistent = true;
                        }
                        if ($response->change_is_inconsistent_no) {
                            $job_application->change_is_inconsistent = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->change_in_stories_yes) and !is_null($response->change_in_stories_no)) { 
                        if ($response->change_in_stories_yes) {
                            $job_application->change_in_stories = true;
                        }
                        if ($response->change_in_stories_no) {
                            $job_application->change_in_stories = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->facade_alteration_yes) and !is_null($response->facade_alteration_no)) { 
                        if ($response->facade_alteration_yes) {
                            $job_application->facade_alteration = true;
                        }
                        if ($response->facade_alteration_no) {
                            $job_application->facade_alteration = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->infill_zoning_yes) and !is_null($response->infill_zoning_no)) { 
                        if ($response->infill_zoning_yes) {
                            $job_application->infill_zoning = true;
                        }
                        if ($response->infill_zoning_no) {
                            $job_application->infill_zoning = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->adult_estab_yes) and !is_null($response->adult_estab_no)) { 
                        if ($response->adult_estab_yes) {
                            $job_application->adult_estab = true;
                        }
                        if ($response->adult_estab_no) {
                            $job_application->adult_estab = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->loft_board_yes) and !is_null($response->loft_board_no)) { 
                        if ($response->loft_board_yes) {
                            $job_application->loft_board = true;
                        }
                        if ($response->loft_board_no) {
                            $job_application->loft_board = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->comp_development_yes) and !is_null($response->comp_development_no)) { 
                        if ($response->comp_development_yes) {
                            $job_application->comp_development = true;
                        }
                        if ($response->comp_development_no) {
                            $job_application->comp_development = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->quality_housing_yes) and !is_null($response->quality_housing_no)) { 
                        if ($response->quality_housing_yes) {
                            $job_application->quality_housing = true;
                        }
                        if ($response->quality_housing_no) {
                            $job_application->quality_housing = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->low_income_yes) and !is_null($response->low_income_no)) { 
                        if ($response->low_income_yes) {
                            $job_application->low_income = true;
                        }
                        if ($response->low_income_no) {
                            $job_application->low_income = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->site_safety_yes) and !is_null($response->site_safety_no)) { 
                        if ($response->site_safety_yes) {
                            $job_application->site_safety = true;
                        }
                        if ($response->site_safety_no) {
                            $job_application->site_safety = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sro_multiple_yes) and !is_null($response->sro_multiple_no)) { 
                        if ($response->sro_multiple_yes) {
                            $job_application->sro_multiple = true;
                        }
                        if ($response->sro_multiple_no) {
                            $job_application->sro_multiple = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->included_lmccc_yes) and !is_null($response->included_lmccc_no)) { 
                        if ($response->included_lmccc_yes) {
                            $job_application->included_lmccc = true;
                        }
                        if ($response->included_lmccc_no) {
                            $job_application->included_lmccc = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->filing_includes_lot_merge_yes) and !is_null($response->filing_includes_lot_merge_no)) { 
                        if ($response->filing_includes_lot_merge_yes) {
                            $job_application->filing_includes_lot_merge = true;
                        }
                        if ($response->filing_includes_lot_merge_no) {
                            $job_application->filing_includes_lot_merge = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->filing_includes_lot_merge_yes) and !is_null($response->filing_includes_lot_merge_no)) { 
                        if ($response->filing_includes_lot_merge_yes) {
                            $job_application->filing_includes_lot_merge = true;
                        }
                        if ($response->filing_includes_lot_merge_no) {
                            $job_application->filing_includes_lot_merge = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->prefab_wood_yes) and !is_null($response->prefab_wood_no)) { 
                        if ($response->prefab_wood_yes) {
                            $job_application->prefab_wood = true;
                        }
                        if ($response->prefab_wood_no) {
                            $job_application->prefab_wood = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->structural_cold_steel_yes) and !is_null($response->structural_cold_steel_no)) { 
                        if ($response->structural_cold_steel_yes) {
                            $job_application->structural_cold_steel = true;
                        }
                        if ($response->structural_cold_steel_no) {
                            $job_application->structural_cold_steel = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->open_web_steel_yes) and !is_null($response->open_web_steel_no)) { 
                        if ($response->open_web_steel_yes) {
                            $job_application->open_web_steel = true;
                        }
                        if ($response->open_web_steel_no) {
                            $job_application->open_web_steel = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->landmark_yes) and !is_null($response->landmark_no)) { 
                        if ($response->landmark_yes) {
                            $job_application->landmark = true;
                        }
                        if ($response->landmark_no) {
                            $job_application->landmark = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->landmark_docket_number)) { 
                        $job_application->landmark_docket_number = $response->landmark_docket_number;
                        $job_application->save();
                    }

                    if (!is_null($response->environ_restrictions_yes) and !is_null($response->environ_restrictions_no)) { 
                        if ($response->environ_restrictions_yes) {
                            $job_application->environ_restrictions = true;
                        }
                        if ($response->environ_restrictions_no) {
                            $job_application->environ_restrictions = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->unmapped_cco_yes) and !is_null($response->unmapped_cco_no)) { 
                        if ($response->unmapped_cco_yes) {
                            $job_application->unmapped_cco = true;
                        }
                        if ($response->unmapped_cco_no) {
                            $job_application->unmapped_cco = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->legalization_yes) and !is_null($response->legalization_no)) { 
                        if ($response->legalization_yes) {
                            $job_application->legalization = true;
                        }
                        if ($response->legalization_no) {
                            $job_application->legalization = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->other_specify_yes) and !is_null($response->other_specify_no)) { 
                        if ($response->other_specify_yes) {
                            $job_application->other_specify = true;
                        }
                        if ($response->other_specify_no) {
                            $job_application->other_specify = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->filed_comply_local_law_yes) and !is_null($response->filed_comply_local_law_no)) { 
                        if ($response->filed_comply_local_law_yes) {
                            $job_application->filed_comply_local_law = true;
                        }
                        if ($response->filed_comply_local_law_no) {
                            $job_application->filed_comply_local_law = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->restrict_dec_easement_yes) and !is_null($response->restrict_dec_easement_no)) { 
                        if ($response->restrict_dec_easement_yes) {
                            $job_application->restrict_dec_easement = true;
                        }
                        if ($response->restrict_dec_easement_no) {
                            $job_application->restrict_dec_easement = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->zoning_exhibit_record_yes) and !is_null($response->zoning_exhibit_record_no)) { 
                        if ($response->zoning_exhibit_record_yes) {
                            $job_application->zoning_exhibit_record = true;
                        }
                        if ($response->zoning_exhibit_record_no) {
                            $job_application->zoning_exhibit_record = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->filed_to_address_vios_yes) and !is_null($response->filed_to_address_vios_no)) { 
                        if ($response->filed_to_address_vios_yes) {
                            $job_application->filed_to_address_vios = true;
                        }
                        if ($response->filed_to_address_vios_no) {
                            $job_application->filed_to_address_vios = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->work_includes_lighting_fixture_yes) and !is_null($response->work_includes_lighting_fixture_no)) { 
                        if ($response->work_includes_lighting_fixture_yes) {
                            $job_application->work_includes_lighting_fixture = true;
                        }
                        if ($response->work_includes_lighting_fixture_no) {
                            $job_application->work_includes_lighting_fixture = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->modular_construction_ny_state_yes) and !is_null($response->modular_construction_ny_state_no)) { 
                        if ($response->modular_construction_ny_state_yes) {
                            $job_application->modular_construction_ny_state = true;
                        }
                        if ($response->modular_construction_ny_state_no) {
                            $job_application->modular_construction_ny_state = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->modular_construction_ny_city_yes) and !is_null($response->modular_construction_ny_city_no)) { 
                        if ($response->modular_construction_ny_city_yes) {
                            $job_application->modular_construction_ny_city = true;
                        }
                        if ($response->modular_construction_ny_city_no) {
                            $job_application->modular_construction_ny_city = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->structural_peer_review_required_yes) and !is_null($response->structural_peer_review_required_no)) { 
                        if ($response->structural_peer_review_required_yes) {
                            $job_application->structural_peer_review_required = true;
                        }
                        if ($response->structural_peer_review_required_no) {
                            $job_application->structural_peer_review_required = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->work_includes_permanent_removal_yes) and !is_null($response->work_includes_permanent_removal_no)) { 
                        if ($response->work_includes_permanent_removal_yes) {
                            $job_application->work_includes_permanent_removal = true;
                        }
                        if ($response->work_includes_permanent_removal_no) {
                            $job_application->work_includes_permanent_removal = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->work_includes_partial_demo_yes) and !is_null($response->work_includes_partial_demo_no)) { 
                        if ($response->work_includes_partial_demo_yes) {
                            $job_application->work_includes_partial_demo = true;
                        }
                        if ($response->work_includes_partial_demo_no) {
                            $job_application->work_includes_partial_demo = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->structural_stability_affected_yes) and !is_null($response->structural_stability_affected_no)) { 
                        if ($response->structural_stability_affected_yes) {
                            $job_application->structural_stability_affected = true;
                        }
                        if ($response->structural_stability_affected_no) {
                            $job_application->structural_stability_affected = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->structural_stability_affected_yes) and !is_null($response->structural_stability_affected_no)) { 
                        if ($response->structural_stability_affected_yes) {
                            $job_application->structural_stability_affected = true;
                        }
                        if ($response->structural_stability_affected_no) {
                            $job_application->structural_stability_affected = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_in_compliance_with_NYCECC)) { 
                        $job_application->sec_10_in_compliance_with_NYCECC = $response->sec_10_in_compliance_with_NYCECC;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_energy_analysis_on_another_job_number)) { 
                        $job_application->sec_10_energy_analysis_on_another_job_number = $response->sec_10_energy_analysis_on_another_job_number;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_exempt_from_NYCECC)) { 
                        $job_application->sec_10_exempt_from_NYCECC = $response->sec_10_exempt_from_NYCECC;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_utilizes_tradeoffs_different_major_systems)) { 
                        $job_application->sec_10_utilizes_tradeoffs_different_major_systems = $response->sec_10_utilizes_tradeoffs_different_major_systems;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_utilizes_tradeoffs_single_major_system)) { 
                        $job_application->sec_10_utilizes_tradeoffs_single_major_system = $response->sec_10_utilizes_tradeoffs_single_major_system;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_alteration_of_state_or_national)) { 
                        $job_application->sec_10_alteration_of_state_or_national = $response->sec_10_alteration_of_state_or_national;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_cc_path_nycecc)) { 
                        $job_application->sec_10_cc_path_nycecc = $response->sec_10_cc_path_nycecc;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_cc_path_ashare)) { 
                        $job_application->sec_10_cc_path_ashare = $response->sec_10_cc_path_ashare;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_ea_tabular)) { 
                        $job_application->sec_10_ea_tabular = $response->sec_10_ea_tabular;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_ea_rescheck)) { 
                        $job_application->sec_10_ea_rescheck = $response->sec_10_ea_rescheck;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_ea_comcheck)) { 
                        $job_application->sec_10_ea_comcheck = $response->sec_10_ea_comcheck;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_10_ea_energy_modeling)) { 
                        $job_application->sec_10_ea_energy_modeling = $response->sec_10_ea_energy_modeling;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_11_job_description)) { 
                        $job_application->sec_11_job_description = $response->sec_11_job_description;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_11_related_bis_job_numbers_uri)) { 
                        $job_application->sec_11_related_bis_job_numbers_uri = $response->sec_11_related_bis_job_numbers_uri;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_11_primary_app_job_number)) { 
                        $job_application->sec_11_primary_app_job_number = $response->sec_11_primary_app_job_number;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_zoning_characteristics_districts)) { 
                        $job_application->sec_12_zoning_characteristics_districts = $response->sec_12_zoning_characteristics_districts;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_special_districts)) { 
                        $job_application->sec_12_special_districts = $response->sec_12_special_districts;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_overlays)) { 
                        $job_application->sec_12_overlays = $response->sec_12_overlays;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_map_no)) { 
                        $job_application->sec_12_map_no = $response->sec_12_map_no;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_street_legal_width)) { 
                        $job_application->sec_12_street_legal_width = $response->sec_12_street_legal_width;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_zoning_includes_tax_lots)) { 
                        $job_application->sec_12_zoning_includes_tax_lots = $response->sec_12_zoning_includes_tax_lots;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_zoning_street_status_public)) { 
                        $job_application->sec_12_zoning_street_status_public = $response->sec_12_zoning_street_status_public;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_zoning_street_status_private)) { 
                        $job_application->sec_12_zoning_street_status_private = $response->sec_12_zoning_street_status_private;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_lot_details_corner)) { 
                        $job_application->sec_12_proposed_lot_details_corner = $response->sec_12_proposed_lot_details_corner;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_lot_details_interior)) { 
                        $job_application->sec_12_proposed_lot_details_interior = $response->sec_12_proposed_lot_details_interior;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_lot_details_through)) { 
                        $job_application->sec_12_proposed_lot_details_through = $response->sec_12_proposed_lot_details_through;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_use)) { 
                        $job_application->sec_12_proposed_use = $response->sec_12_proposed_use;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_use_zoning)) { 
                        if($response->sec_12_proposed_use_zoning == true){ 
                            $job_application->sec_12_proposed_use_zoning = true;
                            $job_application->save();
                        }
                    }

                    if (!is_null($response->sec_12_proposed_use_district)) { 
                        if($response->sec_12_proposed_use_district == true){ 
                            $job_application->sec_12_proposed_use_district = true;
                            $job_application->save();
                        }
                    }

                    if (!is_null($response->sec_12_proposed_use_FAR)) { 
                        if ($response->sec_12_proposed_use_FAR == true) {
                            $job_application->sec_12_proposed_use_FAR = true;
                            $job_application->save();
                        }
                    }

                    if (!is_null($response->sec_12_zoning_area_proposed_total)) {
                        if ($response->sec_12_zoning_area_proposed_total == true) {
                            $job_application->sec_12_zoning_area_proposed_total = $response->sec_12_zoning_area_proposed_total;
                            $job_application->save();
                        }
                    }

                    if (!is_null($response->sec_12_district_area_proposed_total)) { 
                        $job_application->sec_12_district_area_proposed_total = $response->sec_12_district_area_proposed_total;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_FAR_area_proposed_total)) { 
                        $job_application->sec_12_FAR_area_proposed_total = $response->sec_12_FAR_area_proposed_total;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_zoning_area_existing_total)) { 
                        $job_application->sec_12_zoning_area_existing_total = $response->sec_12_zoning_area_existing_total;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_district_area_existing_total)) { 
                        $job_application->sec_12_district_area_existing_total = $response->sec_12_district_area_existing_total;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_FAR_area_existing_total)) { 
                        $job_application->sec_12_FAR_area_existing_total = $response->sec_12_FAR_area_existing_total;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_lot_coverage)) { 
                        $job_application->sec_12_proposed_lot_coverage = $response->sec_12_proposed_lot_coverage;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_lot_area)) { 
                        $job_application->sec_12_proposed_lot_area = $response->sec_12_proposed_lot_area;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_lot_width)) { 
                        $job_application->sec_12_proposed_lot_width = $response->sec_12_proposed_lot_width;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_yard_details_no_yards)) { 
                        $job_application->sec_12_proposed_yard_details_no_yards = $response->sec_12_proposed_yard_details_no_yards;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_yard_front)) { 
                        $job_application->sec_12_proposed_yard_front = $response->sec_12_proposed_yard_front;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_yard_rear)) { 
                        $job_application->sec_12_proposed_yard_rear = $response->sec_12_proposed_yard_rear;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_yard_rear_equivalent)) { 
                        $job_application->sec_12_proposed_yard_rear_equivalent = $response->sec_12_proposed_yard_rear_equivalent;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_yard_side1)) { 
                        $job_application->sec_12_proposed_yard_side1 = $response->sec_12_proposed_yard_side1;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_yard_side2)) { 
                        $job_application->sec_12_proposed_yard_side2 = $response->sec_12_proposed_yard_side2;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_other_perimeter_wall_height)) { 
                        $job_application->sec_12_proposed_other_perimeter_wall_height = $response->sec_12_proposed_other_perimeter_wall_height;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_other_details_enclosed_parking_yes) and !is_null($response->sec_12_proposed_other_details_enclosed_parking_no)) { 
                        if ($response->sec_12_proposed_other_details_enclosed_parking_yes) {
                            $job_application->sec_12_proposed_other_details_enclosed_parking = true;
                        }
                        if ($response->sec_12_proposed_other_details_enclosed_parking_no) {
                            $job_application->sec_12_proposed_other_details_enclosed_parking = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_12_proposed_other_details_number_of_parking_spaces)) { 
                        $job_application->sec_12_proposed_other_details_number_of_parking_spaces = $response->sec_12_proposed_other_details_number_of_parking_spaces;
                        $job_application->save();
                    } 
                    
                    if (!is_null($response->sec_13_occ_class_existing_text)) { 
                        $job_application->sec_13_occ_class_existing_text = $response->sec_13_occ_class_existing_text;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_occ_class_2014_2008_code_designations_yes) and !is_null($response->sec_13_occ_class_2014_2008_code_designations_no)) { 
                        if ($response->sec_13_occ_class_2014_2008_code_designations_yes) {
                            $job_application->sec_13_occ_class_2014_2008_code_designations = true;
                        }
                        if ($response->sec_13_occ_class_2014_2008_code_designations_no) {
                            $job_application->sec_13_occ_class_2014_2008_code_designations = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_occ_class_proposed_text)) { 
                        $job_application->sec_13_occ_class_proposed_text = $response->sec_13_occ_class_proposed_text;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_con_class_existing_text)) { 
                        $job_application->sec_13_con_class_existing_text = $response->sec_13_con_class_existing_text;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_con_class_2014_2008_code_designations_yes) and !is_null($response->sec_13_con_class_2014_2008_code_designations_no)) { 
                        if ($response->sec_13_con_class_2014_2008_code_designations_yes) {
                            $job_application->sec_13_con_class_2014_2008_code_designations = true;
                        }
                        if ($response->sec_13_con_class_2014_2008_code_designations_no) {
                            $job_application->sec_13_con_class_2014_2008_code_designations = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_con_class_proposed_text)) { 
                        $job_application->sec_13_con_class_proposed_text = $response->sec_13_con_class_proposed_text;
                        $job_application->save();
                    } 

                    if (!is_null($response->sec_13_multi_dwelling_class_existing_text)) { 
                        $job_application->sec_13_multi_dwelling_class_existing_text = $response->sec_13_multi_dwelling_class_existing_text;
                        $job_application->save();
                    } 

                    if (!is_null($response->sec_13_multi_dwelling_class_proposed_text)) { 
                        $job_application->sec_13_multi_dwelling_class_proposed_text = $response->sec_13_multi_dwelling_class_proposed_text;
                        $job_application->save();
                    } 

                    if (!is_null($response->sec_13_building_height_existing_text)) { 
                        $job_application->sec_13_building_height_existing_text = $response->sec_13_building_height_existing_text;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_building_height_proposed_text)) { 
                        $job_application->sec_13_building_height_proposed_text = $response->sec_13_building_height_proposed_text;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_building_stories_existing_text)) { 
                        $job_application->sec_13_building_stories_existing_text = $response->sec_13_building_stories_existing_text;
                        $job_application->save();
                    } 

                    if (!is_null($response->sec_13_building_stories_proposed_text)) { 
                        $job_application->sec_13_building_stories_proposed_text = $response->sec_13_building_stories_proposed_text;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_dwelling_units_existing_text)) { 
                        $job_application->sec_13_dwelling_units_existing_text = $response->sec_13_dwelling_units_existing_text;
                        $job_application->save();
                    } 

                    if (!is_null($response->sec_13_dwelling_units_proposed_text)) { 
                        $job_application->sec_13_dwelling_units_proposed_text = $response->sec_13_dwelling_units_proposed_text;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_erected_pursuant_to_bc_2014)) { 
                        $job_application->sec_13_erected_pursuant_to_bc_2014 = $response->sec_13_erected_pursuant_to_bc_2014;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_erected_pursuant_to_bc_2008)) { 
                        $job_application->sec_13_erected_pursuant_to_bc_2008 = $response->sec_13_erected_pursuant_to_bc_2008;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_erected_pursuant_to_bc_1968)) { 
                        $job_application->sec_13_erected_pursuant_to_bc_1968 = $response->sec_13_erected_pursuant_to_bc_1968;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_erected_pursuant_to_bc_before_1968)) { 
                        $job_application->sec_13_erected_pursuant_to_bc_before_1968 = $response->sec_13_erected_pursuant_to_bc_before_1968;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_earliest_code_required_2014)) { 
                        $job_application->sec_13_earliest_code_required_2014 = $response->sec_13_earliest_code_required_2014;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_earliest_code_required_2008)) { 
                        $job_application->sec_13_earliest_code_required_2008 = $response->sec_13_earliest_code_required_2008;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_earliest_code_required_1968)) { 
                        $job_application->sec_13_earliest_code_required_1968 = $response->sec_13_earliest_code_required_1968;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_earliest_code_required_before_1968)) { 
                        $job_application->sec_13_earliest_code_required_before_1968 = $response->sec_13_earliest_code_required_before_1968;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_13_mixed_use_building_yes) and !is_null($response->sec_13_mixed_use_building_no)) { 
                        if ($response->sec_13_mixed_use_building_yes) {
                            $job_application->sec_13_mixed_use_building = true;
                        }
                        if ($response->sec_13_mixed_use_building_no) {
                            $job_application->sec_13_mixed_use_building = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_14_fill_not_applicable)) { 
                        $job_application->sec_14_fill_not_applicable = $response->sec_14_fill_not_applicable;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_14_fill_off_site)) { 
                        $job_application->sec_14_fill_off_site = $response->sec_14_fill_off_site;
                        $job_application->save();
                    } 

                    if (!is_null($response->sec_14_fill_on_site)) { 
                        $job_application->sec_14_fill_on_site = $response->sec_14_fill_on_site;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_14_fill_under_300_cubic_yds)) { 
                        $job_application->sec_14_fill_under_300_cubic_yds = $response->sec_14_fill_under_300_cubic_yds;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_15_construction_equipment_chute)) { 
                        $job_application->sec_15_construction_equipment_chute = $response->sec_15_construction_equipment_chute;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_15_construction_equipment_sidewalk_shed)) { 
                        $job_application->sec_15_construction_equipment_sidewalk_shed = $response->sec_15_construction_equipment_sidewalk_shed;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_15_construction_equipment_fence)) { 
                        $job_application->sec_15_construction_equipment_fence = $response->sec_15_construction_equipment_fence;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_15_construction_equipment_supported_scaffold)) { 
                        $job_application->sec_15_construction_equipment_supported_scaffold = $response->sec_15_construction_equipment_supported_scaffold;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_15_construction_equipment_other)) { 
                        $job_application->sec_15_construction_equipment_other = $response->sec_15_construction_equipment_other;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_16_size_of_cut_splays)) { 
                        $job_application->sec_16_size_of_cut_splays = $response->sec_16_size_of_cut_splays;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_16_curbcut_text)) { 
                        $job_application->sec_16_curbcut_text = $response->sec_16_curbcut_text;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_16_distance_from_nearest_corner)) { 
                        $job_application->sec_16_distance_from_nearest_corner = $response->sec_16_distance_from_nearest_corner;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_18_fire_alarm_existing_yes) and !is_null($response->sec_18_fire_alarm_existing_no)) { 
                        if ($response->sec_18_fire_alarm_existing_yes) {
                            $job_application->sec_18_fire_alarm_existing = true;
                        }
                        if ($response->sec_18_fire_alarm_existing_no) {
                            $job_application->sec_18_fire_alarm_existing = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_18_fire_alarm_proposed_yes) and !is_null($response->sec_18_fire_alarm_proposed_no)) { 
                        if ($response->sec_18_fire_alarm_proposed_yes) {
                            $job_application->sec_18_fire_alarm_proposed = true;
                        }
                        if ($response->sec_18_fire_alarm_proposed_no) {
                            $job_application->sec_18_fire_alarm_proposed = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_18_sprinkler_existing_yes) and !is_null($response->sec_18_sprinkler_existing_no)) { 
                        if ($response->sec_18_sprinkler_existing_yes) {
                            $job_application->sec_18_sprinkler_existing = true;
                        }
                        if ($response->sec_18_sprinkler_existing_no) {
                            $job_application->sec_18_sprinkler_existing = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_18_sprinkler_proposed_yes) and !is_null($response->sec_18_sprinkler_proposed_no)) { 
                        if ($response->sec_18_sprinkler_proposed_yes) {
                            $job_application->sec_18_sprinkler_proposed = true;
                        }
                        if ($response->sec_18_sprinkler_proposed_no) {
                            $job_application->sec_18_sprinkler_proposed = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_18_sprinkler_proposed_yes) and !is_null($response->sec_18_sprinkler_proposed_no)) { 
                        if ($response->sec_18_sprinkler_proposed_yes) {
                            $job_application->sec_18_sprinkler_proposed = true;
                        }
                        if ($response->sec_18_sprinkler_proposed_no) {
                            $job_application->sec_18_sprinkler_proposed = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_18_fire_suppression_existing_yes) and !is_null($response->sec_18_fire_suppression_existing_no)) { 
                        if ($response->sec_18_fire_suppression_existing_yes) {
                            $job_application->sec_18_fire_suppression_existing = true;
                        }
                        if ($response->sec_18_fire_suppression_existing_no) {
                            $job_application->sec_18_fire_suppression_existing = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_18_fire_suppression_proposed_yes) and !is_null($response->sec_18_fire_suppression_proposed_no)) { 
                        if ($response->sec_18_fire_suppression_proposed_yes) {
                            $job_application->sec_18_fire_suppression_proposed = true;
                        }
                        if ($response->sec_18_fire_suppression_proposed_no) {
                            $job_application->sec_18_fire_suppression_proposed = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_18_standpipe_existing_yes) and !is_null($response->sec_18_standpipe_existing_no)) { 
                        if ($response->sec_18_standpipe_existing_yes) {
                            $job_application->sec_18_standpipe_existing = true;
                        }
                        if ($response->sec_18_standpipe_existing_no) {
                            $job_application->sec_18_standpipe_existing = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_18_standpipe_proposed_yes) and !is_null($response->sec_18_standpipe_proposed_no)) { 
                        if ($response->sec_18_standpipe_proposed_yes) {
                            $job_application->sec_18_standpipe_proposed = true;
                        }
                        if ($response->sec_18_standpipe_proposed_no) {
                            $job_application->sec_18_standpipe_proposed = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_20_tidal_wetlands_yes) and !is_null($response->sec_20_tidal_wetlands_no)) { 
                        if ($response->sec_20_tidal_wetlands_yes) {
                            $job_application->sec_20_tidal_wetlands = true;
                        }
                        if ($response->sec_20_tidal_wetlands_no) {
                            $job_application->sec_20_tidal_wetlands = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_20_freshwater_wetlands_yes) and !is_null($response->sec_20_freshwater_wetlands_no)) { 
                        if ($response->sec_20_freshwater_wetlands_yes) {
                            $job_application->sec_20_freshwater_wetlands = true;
                        }
                        if ($response->sec_20_freshwater_wetlands_no) {
                            $job_application->sec_20_freshwater_wetlands = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_20_coastal_erosion_hazard_yes) and !is_null($response->sec_20_coastal_erosion_hazard_no)) { 
                        if ($response->sec_20_coastal_erosion_hazard_yes) {
                            $job_application->sec_20_coastal_erosion_hazard = true;
                        }
                        if ($response->sec_20_coastal_erosion_hazard_no) {
                            $job_application->sec_20_coastal_erosion_hazard = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_20_urban_renewal_yes) and !is_null($response->sec_20_urban_renewal_no)) { 
                        if ($response->sec_20_urban_renewal_yes) {
                            $job_application->sec_20_urban_renewal = true;
                        }
                        if ($response->sec_20_urban_renewal_no) {
                            $job_application->sec_20_urban_renewal = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_20_fire_district_yes) and !is_null($response->sec_20_fire_district_no)) { 
                        if ($response->sec_20_fire_district_yes) {
                            $job_application->sec_20_fire_district = true;
                        }
                        if ($response->sec_20_fire_district_no) {
                            $job_application->sec_20_fire_district = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_20_flood_hazard_yes) and !is_null($response->sec_20_flood_hazard_no)) { 
                        if ($response->sec_20_flood_hazard_yes) {
                            $job_application->sec_20_flood_hazard = true;
                        }
                        if ($response->sec_20_flood_hazard_no) {
                            $job_application->sec_20_flood_hazard = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_20_substantial_improvement_yes) and !is_null($response->sec_20_substantial_improvement_no)) { 
                        if ($response->sec_20_substantial_improvement_yes) {
                            $job_application->sec_20_substantial_improvement = true;
                        }
                        if ($response->sec_20_substantial_improvement_no) {
                            $job_application->sec_20_substantial_improvement = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_20_substantially_damaged_yes) and !is_null($response->sec_20_substantially_damaged_no)) { 
                        if ($response->sec_20_substantially_damaged_yes) {
                            $job_application->sec_20_substantially_damaged = true;
                        }
                        if ($response->sec_20_substantially_damaged_no) {
                            $job_application->sec_20_substantially_damaged = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_20_floodshields_yes) and !is_null($response->sec_20_floodshields_no)) { 
                        if ($response->sec_20_floodshields_yes) {
                            $job_application->sec_20_floodshields = true;
                        }
                        if ($response->sec_20_floodshields_no) {
                            $job_application->sec_20_floodshields = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_21_affects_exterior_yes) and !is_null($response->sec_21_affects_exterior_no)) { 
                        if ($response->sec_21_affects_exterior_yes) {
                            $job_application->sec_21_affects_exterior = true;
                        }
                        if ($response->sec_21_affects_exterior_no) {
                            $job_application->sec_21_affects_exterior = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_21_involves_raising_yes) and !is_null($response->sec_21_involves_raising_no)) { 
                        if ($response->sec_21_involves_raising_yes) {
                            $job_application->sec_21_involves_raising = true;
                        }
                        if ($response->sec_21_involves_raising_no) {
                            $job_application->sec_21_involves_raising = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_22_requires_asbestos_abatement)) { 
                        $job_application->sec_22_requires_asbestos_abatement = $response->sec_22_requires_asbestos_abatement;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_purpose_adveritising)) { 
                        $job_application->sec_23_purpose_advertising = $response->sec_23_purpose_adveritising;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_purpose_non_advertising)) { 
                        $job_application->sec_23_purpose_non_advertising = $response->sec_23_purpose_non_advertising;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_type_illuminated)) { 
                        $job_application->sec_23_type_illuminated = $response->sec_23_type_illuminated;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_type_non_illuminated)) { 
                        $job_application->sec_23_type_non_illuminated = $response->sec_23_type_non_illuminated;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_illuminated_type_direct)) { 
                        $job_application->sec_23_illuminated_type_direct = $response->sec_23_illuminated_type_direct;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_illuminated_type_flashing)) { 
                        $job_application->sec_23_illuminated_type_flashing = $response->sec_23_illuminated_type_flashing;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_illuminated_type_indirect)) { 
                        $job_application->sec_23_illuminated_type_indirect = $response->sec_23_illuminated_type_indirect;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_location_ground)) { 
                        $job_application->sec_23_location_ground = $response->sec_23_location_ground;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_location_roof)) { 
                        $job_application->sec_23_location_roof = $response->sec_23_location_roof;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_location_wall)) { 
                        $job_application->sec_23_location_wall = $response->sec_23_location_wall;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_estimated_cost)) { 
                        $job_application->sec_23_estimated_cost = $response->sec_23_estimated_cost;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_total_sq_ft)) { 
                        $job_application->sec_23_total_sq_ft = $response->sec_23_total_sq_ft;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_height_above_curb)) { 
                        $job_application->sec_23_height_above_curb = $response->sec_23_height_above_curb;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_height_above_roof)) { 
                        $job_application->sec_23_height_above_roof = $response->sec_23_height_above_roof;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_inside_building_line_yes) and !is_null($response->sec_23_inside_building_line_no)) { 
                        if ($response->sec_23_inside_building_line_yes) {
                            $job_application->sec_23_inside_building_line = true;
                        }
                        if ($response->sec_23_inside_building_line_no) {
                            $job_application->sec_23_inside_building_line = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_inside_building_line_text)) { 
                        $job_application->sec_23_inside_building_line_text = $response->sec_23_inside_building_line_text;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_owner_billed_for_annual_permit_yes) and !is_null($response->sec_23_owner_billed_for_annual_permit_no)) { 
                        if ($response->sec_23_owner_billed_for_annual_permit_yes) {
                            $job_application->sec_23_owner_billed_for_annual_permit = true;
                        }
                        if ($response->sec_23_owner_billed_for_annual_permit_no) {
                            $job_application->sec_23_owner_billed_for_annual_permit = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_sign_tight_closed_or_solid_yes) and !is_null($response->sec_23_sign_tight_closed_or_solid_no)) { 
                        if ($response->sec_23_sign_tight_closed_or_solid_yes) {
                            $job_application->sec_23_sign_tight_closed_or_solid = true;
                        }
                        if ($response->sec_23_sign_tight_closed_or_solid_no) {
                            $job_application->sec_23_sign_tight_closed_or_solid = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_changeable_copy_yes) and !is_null($response->sec_23_changeable_copy_no)) { 
                        if ($response->sec_23_changeable_copy_yes) {
                            $job_application->sec_23_changeable_copy = true;
                        }
                        if ($response->sec_23_changeable_copy_no) {
                            $job_application->sec_23_changeable_copy = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_sign_wording_text)) { 
                        $job_application->sec_23_sign_wording_text = $response->sec_23_sign_wording_text;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_oac_interest_yes) and !is_null($response->sec_23_oac_interest_no)) { 
                        if ($response->sec_23_oac_interest_yes) {
                            $job_application->sec_23_oac_interest = true;
                        }
                        if ($response->sec_23_oac_interest_no) {
                            $job_application->sec_23_oac_interest = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_oac_registration_number)) { 
                        $job_application->sec_23_oac_registration_number = $response->sec_23_oac_registration_number;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_within_900_yes) and !is_null($response->sec_23_within_900_no)) { 
                        if ($response->sec_23_within_900_yes) {
                            $job_application->sec_23_within_900 = true;
                        }
                        if ($response->sec_23_within_900_no) {
                            $job_application->sec_23_within_900 = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_within_900_distance)) { 
                        $job_application->sec_23_within_900_distance = $response->sec_23_within_900_distance;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_within_200_yes) and !is_null($response->sec_23_within_200_no)) { 
                        if ($response->sec_23_within_200_yes) {
                            $job_application->sec_23_within_200 = true;
                        }
                        if ($response->sec_23_within_200_no) {
                            $job_application->sec_23_within_200 = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_23_within_200_distance)) { 
                        $job_application->sec_23_within_200_distance = $response->sec_23_within_200_distance;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_24_comments)) { 
                        $job_application->sec_24_comments = $response->sec_24_comments;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_25_nb_a1_yes) and !is_null($response->sec_25_nb_a1_no)) { 
                        if ($response->sec_25_nb_a1_yes) {
                            $job_application->sec_25_nb_a1 = true;
                        }
                        if ($response->sec_25_nb_a1_no) {
                            $job_application->sec_25_nb_a1 = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_25_directive_14_yes) and !is_null($response->sec_25_directive_14_no)) { 
                        if ($response->sec_25_directive_14_yes) {
                            $job_application->sec_25_directive_14 = true;
                        }
                        if ($response->sec_25_directive_14_no) {
                            $job_application->sec_25_directive_14 = false;
                        }
                        $job_application->save();
                    }

                    if (!is_null($response->sec_26_name)) { 
                        $job_application->sec_26_name = $response->sec_26_name;
                        $job_application->save();
                    } 
                    
                    if (!is_null($response->sec_26_relationship_to_owner)) { 
                        $job_application->sec_26_relationship_to_owner = $response->sec_26_relationship_to_owner;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_26_business_name)) { 
                        $job_application->sec_26_business_name = $response->sec_26_business_name;
                        $job_application->save();
                    } 

                    if (!is_null($response->sec_26_business_phone)) { 
                        $job_application->sec_26_business_phone = $response->sec_26_business_phone;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_26_business_address)) { 
                        $job_application->sec_26_business_address = $response->sec_26_business_address;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_26_business_fax)) { 
                        $job_application->sec_26_business_fax = $response->sec_26_business_fax;
                        $job_application->save();
                    } 

                    if (!is_null($response->sec_26_email)) { 
                        $job_application->sec_26_email = $response->sec_26_email;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_26_owner_type)) { 
                        $job_application->sec_26_owner_type = $response->sec_26_owner_type;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_27_metes_and_bounds_text)) { 
                        $job_application->sec_27_metes_and_bounds_text = $response->sec_27_metes_and_bounds_text;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_27_metes_and_bounds_running_thence_1)) { 
                        $job_application->sec_27_metes_and_bounds_running_thence_1 = $response->sec_27_metes_and_bounds_running_thence_1;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_27_metes_and_bounds_thence_1)) { 
                        $job_application->sec_27_metes_and_bounds_thence_1 = $response->sec_27_metes_and_bounds_thence_1;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_27_metes_and_bounds_running_thence_2)) { 
                        $job_application->sec_27_metes_and_bounds_running_thence_2 = $response->sec_27_metes_and_bounds_running_thence_2;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_27_metes_and_bounds_thence_2)) { 
                        $job_application->sec_27_metes_and_bounds_thence_2 = $response->sec_27_metes_and_bounds_thence_2;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_27_metes_and_bounds_running_thence_3)) { 
                        $job_application->sec_27_metes_and_bounds_running_thence_3 = $response->sec_27_metes_and_bounds_running_thence_3;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_27_metes_and_bounds_thence_3)) { 
                        $job_application->sec_27_metes_and_bounds_thence_3 = $response->sec_27_metes_and_bounds_thence_3;
                        $job_application->save();
                    } 

                    if (!is_null($response->sec_27_metes_and_bounds_running_thence_4)) { 
                        $job_application->sec_27_metes_and_bounds_running_thence_4 = $response->sec_27_metes_and_bounds_running_thence_4;
                        $job_application->save();
                    }

                    if (!is_null($response->sec_27_metes_and_bounds_thence_4)) { 
                        $job_application->sec_27_metes_and_bounds_thence_4 = $response->sec_27_metes_and_bounds_thence_4;
                        $job_application->save();
                    }

                    if($job_application->doc_number === '01' && strpos($job_application->job_status, 'X SIGNED OFF') == false && strpos($job_application->sec_24_comments, 'JOB WITHDRAWN') == false) { 
                        $job_application->active = true; 
                        $job_application->save();
                    } else { 
                        $job_application->active = false; 
                        $job_application->save();
                    }

                }
            }
        }

        return response([ 
            'success' => true
        ], 200);
    }
}
