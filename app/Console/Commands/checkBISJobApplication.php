<?php

namespace App\Console\Commands;

use Mail; 
use App\User; 
use App\Property;
use App\Portfolio;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\BISJobApplication;

use Illuminate\Console\Command;

class checkBISJobApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:bisjobapplication';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check DOB BIS Website for new/updated Job Applications.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $properties = Property::all();

        if (!empty($properties)) { 
            foreach ($properties as $property) { 
                $client = new Client(); 
                $bis_uri_request = $client->get(env('DOB_API').'/overview?house_number='.$property->house_number.'&street='.$property->street_name.'&borough='.$property->borough); 
                $bis_uri_response = json_decode($bis_uri_request->getBody()->getContents()); 
                if(!is_null($bis_uri_response)){ 
                    $property->jobs_filings_uri = $bis_uri_response->jobs_filings_uri; 
                    $property->jobs_filings_total = $bis_uri_response->jobs_filings_total;
                    $property->save();
                }
                $portfolios = Portfolio::where('property_id', $property->id)->get(); 
                
                if (!empty($property->jobs_filings_uri)) { 
                    $total_amount_job_applications = BISJobApplication::where('property_id', $property->id)->get();
                    if (!is_null($total_amount_job_applications)) { 
                        $property->jobs_filings_endpoint = $property->jobs_filings_uri; 
                        $property->save();
                        while ($total_amount_job_applications !== $property->jobs_filings_total && $property->jobs_filings_endpoint != '') { 
                            $request = $client->post(env('JOB_APPS_ALERTS').'/property/dob-api/job-applications/index', [ 
                                'form_params' => [ 
                                    'endpoint' => $property->jobs_filings_endpoint
                                ]
                            ]);
                            $response = json_decode($request->getBody()->getContents());
                            if (count($response->job_filings) > 0) { 
                                foreach ($response->job_filings as $job_application) { 
                                    $job_application_exist = BISJobApplication::where('property_id', $property->id)->where('job_number', $job_application->job_number)->where('doc_number', $job_application->doc_number)->get();
                                    if (is_null($job_application_exist)) { 
                                        $new_job_application = BISJobApplication::create([ 
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

                                        $client = new Client(); 
                                        $request = $client->post(env('JOB_APPS_ALERTS').'/property/dob-api/job-applications/record', [ 
                                            'form_params' => [ 
                                                'endpoint' => $job_application->uri
                                            ]
                                        ]);
                                        $response = json_decode($request->getBody()->getContents()); 
                                        if(!is_null($response)){ 
                                            if (!is_null($response->job_number)) { 
                                                $new_job_application->job_number = $response->job_number;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->last_action)) {
                                                $new_job_application->last_action = $response->last_action;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->application_approved_on)) {
                                                $new_job_application->application_approved_on = $response->application_approved_on;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->building_type)) {
                                                $new_job_application->building_type = $response->building_type;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->estimated_total_cost)) {
                                                $new_job_application->estimated_total_cost = $response->estimated_total_cost;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->electronically_filed)) {
                                                $new_job_application->electronically_filed = $response->electronically_filed;
                                                $new_job_application->save();
                                            }


                                            if (!is_null($response->pre_filed)) { 
                                                $new_job_application->pre_filed = $response->pre_filed;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->date_filed)) { 
                                                $new_job_application->date_filed = $response->date_filed;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->fee_structure)) { 
                                                $new_job_application->fee_structure = $response->fee_structure;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->review_is_requested_code)) { 
                                                $new_job_application->review_is_requested_code = $response->review_is_requested_code;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->house_number)) { 
                                                $new_job_application->house_number = $response->house_number;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->street_name)) { 
                                                $new_job_application->street_name = $response->street_name;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->borough)) { 
                                                $new_job_application->borough = $response->borough;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_on_floors)) { 
                                                $new_job_application->work_on_floors = $response->work_on_floors;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->block)) { 
                                                $new_job_application->block = $response->block;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->lot)) { 
                                                $new_job_application->lot = $response->lot;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->bin)) { 
                                                $new_job_application->bin = $response->bin;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->cb_number)) { 
                                                $new_job_application->cb_number = $response->cb_number;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->condo_number)) { 
                                                $new_job_application->condo_number = $response->condo_number;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->zipcode)) { 
                                                $new_job_application->zipcode = $response->zipcode;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->applicant_name)) { 
                                                $new_job_application->applicant_name = $response->applicant_name;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->applicant_business_name)) { 
                                                $new_job_application->applicant_business_name = $response->applicant_business_name;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->applicant_business_phone)) { 
                                                $new_job_application->applicant_business_phone = $response->applicant_business_phone;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->applicant_business_address)) { 
                                                $new_job_application->applicant_business_address = $response->applicant_business_address;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->applicant_business_fax)) { 
                                                $new_job_application->applicant_business_fax = $response->applicant_business_fax;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->applicant_email)) { 
                                                $new_job_application->applicant_email = $response->applicant_email;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->applicant_mobile_phone)) { 
                                                $new_job_application->applicant_mobile_phone = $response->applicant_mobile_phone;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->applicant_license_number)) { 
                                                $new_job_application->applicant_license_number = $response->applicant_license_number;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->applicant_type)) { 
                                                $new_job_application->applicant_type = $response->applicant_type;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->prev_applicant_name)) { 
                                                $new_job_application->prev_applicant_name = $response->prev_applicant_name;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->prev_applicant_business_name)) { 
                                                $new_job_application->prev_applicant_business_name = $response->prev_applicant_business_name;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->prev_applicant_business_phone)) { 
                                                $new_job_application->prev_applicant_business_phone = $response->prev_applicant_business_phone;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->prev_applicant_business_address)) { 
                                                $new_job_application->prev_applicant_business_address = $response->prev_applicant_business_address;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->prev_applicant_business_fax)) { 
                                                $new_job_application->prev_applicant_business_fax = $response->prev_applicant_business_fax;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->prev_applicant_email)) { 
                                                $new_job_application->prev_applicant_email = $response->prev_applicant_email;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->prev_applicant_mobile_phone)) { 
                                                $new_job_application->prev_applicant_mobile_phone = $response->prev_applicant_mobile_phone;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->prev_applicant_type)) { 
                                                $new_job_application->prev_applicant_type = $response->prev_applicant_type;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->prev_applicant_license_number)) { 
                                                $new_job_application->prev_applicant_license_number = $response->prev_applicant_license_number;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filing_rep_name)) { 
                                                $new_job_application->filing_rep_name = $response->filing_rep_name;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filing_rep_business_name)) { 
                                                $new_job_application->filing_rep_business_name = $response->filing_rep_business_name;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filing_rep_business_phone)) { 
                                                $new_job_application->filing_rep_business_phone = $response->filing_rep_business_phone;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filing_rep_business_address)) { 
                                                $new_job_application->filing_rep_business_address = $response->filing_rep_business_address;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filing_rep_business_fax)) { 
                                                $new_job_application->filing_rep_business_fax = $response->filing_rep_business_fax;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filing_rep_email)) { 
                                                $new_job_application->filing_rep_email = $response->filing_rep_email;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filing_rep_mobile_phone)) { 
                                                $new_job_application->filing_rep_mobile_phone = $response->filing_rep_mobile_phone;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filing_rep_registration_number)) { 
                                                $new_job_application->filing_rep_registration_number = $response->filing_rep_registration_number;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->doc_overview_uri)) {
                                                $new_job_application->doc_overview_uri = $response->doc_overview_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->fees_paid_uri)) {
                                                $new_job_application->fees_paid_uri = $response->fees_paid_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->crane_information_uri)) {
                                                $new_job_application->crane_information_uri = $response->crane_information_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->after_hours_variance_permit_uri)) {
                                                $new_job_application->after_hours_variance_permit_uri = $response->after_hours_variance_permit_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->items_required_uri)) {
                                                $new_job_application->items_required_uri = $response->items_required_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->forms_received_uri)) {
                                                $new_job_application->forms_received_uri = $response->forms_received_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->plan_examination_uri)) {
                                                $new_job_application->plan_examination_uri = $response->plan_examination_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->virtual_job_folder_uri)) {
                                                $new_job_application->virtual_job_folder_uri = $response->virtual_job_folder_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->all_permits_uri)) {
                                                $new_job_application->all_permits_uri = $response->all_permits_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->all_comments_uri)) {
                                                $new_job_application->all_comments_uri = $response->all_comments_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->schedule_a_uri)) {
                                                $new_job_application->schedule_a_uri = $response->schedule_a_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->schedule_b_uri)) {
                                                $new_job_application->schedule_b_uri = $response->schedule_b_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->plumbing_inspections_uri)) {
                                                $new_job_application->plumbing_inspections_uri = $response->plumbing_inspections_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->co_summary_uri)) {
                                                $new_job_application->co_summary_uri = $response->co_summary_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->co_preview_uri)) {
                                                $new_job_application->co_preview_uri = $response->co_preview_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->print_letter_of_completion_uri)) {
                                                $new_job_application->print_letter_of_completion_uri = $response->print_letter_of_completion_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->dob_now_inspections_url)) {
                                                $new_job_application->dob_now_inspections_url = $response->dob_now_inspections_url;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->job_application_type_a1_flag)) {
                                                $new_job_application->job_application_type_a1_flag = $response->job_application_type_a1_flag;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->job_application_type_a1_ot_flag)) {
                                                $new_job_application->job_application_type_a1_ot_flag = $response->job_application_type_a1_ot_flag;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->job_application_type_new_building_flag)) {
                                                $new_job_application->job_application_type_a1_new_building_flag = $response->job_application_type_new_building_flag;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->job_application_type_a2_flag)) {
                                                $new_job_application->job_application_type_a2_flag = $response->job_application_type_a2_flag;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->job_application_type_full_demo_flag)) {
                                                $new_job_application->job_application_type_full_demo_flag = $response->job_application_type_full_demo_flag;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->job_application_type_a3_flag)) {
                                                $new_job_application->job_application_type_a3_flag = $response->job_application_type_a3_flag;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->job_application_type_subdivision_improved)) {
                                                $new_job_application->job_application_type_subdivision_improved = $response->job_application_type_subdivision_improved;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->job_application_type_sign)) {
                                                $new_job_application->job_application_type_sign = $response->job_application_type_sign;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->job_application_type_subdivision_condo)) {
                                                $new_job_application->job_application_type_subdivision_condo = $response->job_application_type_subdivision_condo;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->job_application_type_directive_14_acceptance_requested)) {
                                                $new_job_application->job_application_type_directive_14_acceptance_requested = $response->job_application_type_directive_14_acceptance_requested;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_boiler)) { 
                                                $new_job_application->work_boiler = $response->work_boiler;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_fire_supression)) { 
                                                $new_job_application->work_fire_supression = $response->work_fire_supression;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_sprinkler)) { 
                                                $new_job_application->work_sprinkler = $response->work_sprinkler;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_ot_general_construction)) { 
                                                $new_job_application->work_general_construction = $response->work_ot_general_construction;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_fire_alarm)) { 
                                                $new_job_application->work_fire_alarm = $response->work_fire_alarm;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_mechanical)) { 
                                                $new_job_application->work_mechanical = $response->work_mechanical;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_construction_equipment)) { 
                                                $new_job_application->work_construction_equipment = $response->work_construction_equipment;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_fuel_burning)) { 
                                                $new_job_application->work_fuel_burning = $response->work_fuel_burning;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_plumbing)) { 
                                                $new_job_application->work_plumbing = $response->work_plumbing;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_curb_cut)) { 
                                                $new_job_application->work_curb_cut = $response->work_curb_cut;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_fuel_storage)) { 
                                                $new_job_application->work_fuel_storage = $response->work_fuel_storage;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_standpipe)) { 
                                                $new_job_application->work_standpipe = $response->work_standpipe;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_7_plans_page_count)) {
                                                $new_job_application->sec_7_plans_page_count = $response->sec_7_plans_page_count;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_8_enlargement_proposed_yes) and !is_null($response->sec_8_enlargement_proposed_no)) { 
                                                if ($response->sec_8_enlargement_proposed_yes) {
                                                    $new_job_application->sec_8_enlargement_proposed = true;
                                                }
                                                if ($response->sec_8_enlargement_proposed_no) {
                                                    $new_job_application->sec_8_enlargement_proposed = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_8_horizontal)) { 
                                                $new_job_application->sec_8_horizontal = $response->sec_8_horizontal;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_8_vertical)) { 
                                                $new_job_application->sec_8_vertical = $response->sec_8_vertical;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_8_total_bldg_square_footage)) { 
                                                $new_job_application->sec_8_total_bldg_square_footage = $response->sec_8_total_bldg_square_footage;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_8_total_construction_floor_area)) { 
                                                $new_job_application->sec_8_total_construction_floor_area = $response->sec_8_total_construction_floor_area;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->alt_required_new_building_yes) and !is_null($response->alt_required_new_building_no)) { 
                                                if ($response->alt_required_new_building_yes) {
                                                    $new_job_application->alt_required_new_building = true;
                                                }
                                                if ($response->alt_required_new_building_no) {
                                                    $new_job_application->alt_required_new_building = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->alt_is_major_yes) and !is_null($response->alt_is_major_no)) { 
                                                if ($response->alt_is_major_yes) {
                                                    $new_job_application->alt_is_major = true;
                                                }
                                                if ($response->alt_is_major_no) {
                                                    $new_job_application->alt_is_major = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->change_in_dwelling_unit_yes) and !is_null($response->change_in_dwelling_unit_no)) { 
                                                if ($response->change_in_dwelling_unit_yes) {
                                                    $new_job_application->change_in_dwelling_unit = true;
                                                }
                                                if ($response->change_in_dwelling_unit_no) {
                                                    $new_job_application->change_in_dwelling_unit = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->change_in_occupancy_use_yes) and !is_null($response->change_in_occupancy_use_no)) { 
                                                if ($response->change_in_occupancy_use_yes) {
                                                    $new_job_application->change_in_occupancy_use = true;
                                                }
                                                if ($response->change_in_occupancy_use_no) {
                                                    $new_job_application->change_in_occupancy_use = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->change_is_inconsistent_yes) and !is_null($response->change_is_inconsistent_no)) { 
                                                if ($response->change_is_inconsistent_yes) {
                                                    $new_job_application->change_is_inconsistent = true;
                                                }
                                                if ($response->change_is_inconsistent_no) {
                                                    $new_job_application->change_is_inconsistent = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->change_in_stories_yes) and !is_null($response->change_in_stories_no)) { 
                                                if ($response->change_in_stories_yes) {
                                                    $new_job_application->change_in_stories = true;
                                                }
                                                if ($response->change_in_stories_no) {
                                                    $new_job_application->change_in_stories = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->facade_alteration_yes) and !is_null($response->facade_alteration_no)) { 
                                                if ($response->facade_alteration_yes) {
                                                    $new_job_application->facade_alteration = true;
                                                }
                                                if ($response->facade_alteration_no) {
                                                    $new_job_application->facade_alteration = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->infill_zoning_yes) and !is_null($response->infill_zoning_no)) { 
                                                if ($response->infill_zoning_yes) {
                                                    $new_job_application->infill_zoning = true;
                                                }
                                                if ($response->infill_zoning_no) {
                                                    $new_job_application->infill_zoning = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->adult_estab_yes) and !is_null($response->adult_estab_no)) { 
                                                if ($response->adult_estab_yes) {
                                                    $new_job_application->adult_estab = true;
                                                }
                                                if ($response->adult_estab_no) {
                                                    $new_job_application->adult_estab = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->loft_board_yes) and !is_null($response->loft_board_no)) { 
                                                if ($response->loft_board_yes) {
                                                    $new_job_application->loft_board = true;
                                                }
                                                if ($response->loft_board_no) {
                                                    $new_job_application->loft_board = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->comp_development_yes) and !is_null($response->comp_development_no)) { 
                                                if ($response->comp_development_yes) {
                                                    $new_job_application->comp_development = true;
                                                }
                                                if ($response->comp_development_no) {
                                                    $new_job_application->comp_development = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->quality_housing_yes) and !is_null($response->quality_housing_no)) { 
                                                if ($response->quality_housing_yes) {
                                                    $new_job_application->quality_housing = true;
                                                }
                                                if ($response->quality_housing_no) {
                                                    $new_job_application->quality_housing = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->low_income_yes) and !is_null($response->low_income_no)) { 
                                                if ($response->low_income_yes) {
                                                    $new_job_application->low_income = true;
                                                }
                                                if ($response->low_income_no) {
                                                    $new_job_application->low_income = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->site_safety_yes) and !is_null($response->site_safety_no)) { 
                                                if ($response->site_safety_yes) {
                                                    $new_job_application->site_safety = true;
                                                }
                                                if ($response->site_safety_no) {
                                                    $new_job_application->site_safety = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sro_multiple_yes) and !is_null($response->sro_multiple_no)) { 
                                                if ($response->sro_multiple_yes) {
                                                    $new_job_application->sro_multiple = true;
                                                }
                                                if ($response->sro_multiple_no) {
                                                    $new_job_application->sro_multiple = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->included_lmccc_yes) and !is_null($response->included_lmccc_no)) { 
                                                if ($response->included_lmccc_yes) {
                                                    $new_job_application->included_lmccc = true;
                                                }
                                                if ($response->included_lmccc_no) {
                                                    $new_job_application->included_lmccc = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filing_includes_lot_merge_yes) and !is_null($response->filing_includes_lot_merge_no)) { 
                                                if ($response->filing_includes_lot_merge_yes) {
                                                    $new_job_application->filing_includes_lot_merge = true;
                                                }
                                                if ($response->filing_includes_lot_merge_no) {
                                                    $new_job_application->filing_includes_lot_merge = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filing_includes_lot_merge_yes) and !is_null($response->filing_includes_lot_merge_no)) { 
                                                if ($response->filing_includes_lot_merge_yes) {
                                                    $new_job_application->filing_includes_lot_merge = true;
                                                }
                                                if ($response->filing_includes_lot_merge_no) {
                                                    $new_job_application->filing_includes_lot_merge = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->prefab_wood_yes) and !is_null($response->prefab_wood_no)) { 
                                                if ($response->prefab_wood_yes) {
                                                    $new_job_application->prefab_wood = true;
                                                }
                                                if ($response->prefab_wood_no) {
                                                    $new_job_application->prefab_wood = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->structural_cold_steel_yes) and !is_null($response->structural_cold_steel_no)) { 
                                                if ($response->structural_cold_steel_yes) {
                                                    $new_job_application->structural_cold_steel = true;
                                                }
                                                if ($response->structural_cold_steel_no) {
                                                    $new_job_application->structural_cold_steel = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->open_web_steel_yes) and !is_null($response->open_web_steel_no)) { 
                                                if ($response->open_web_steel_yes) {
                                                    $new_job_application->open_web_steel = true;
                                                }
                                                if ($response->open_web_steel_no) {
                                                    $new_job_application->open_web_steel = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->landmark_yes) and !is_null($response->landmark_no)) { 
                                                if ($response->landmark_yes) {
                                                    $new_job_application->landmark = true;
                                                }
                                                if ($response->landmark_no) {
                                                    $new_job_application->landmark = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->landmark_docket_number)) { 
                                                $new_job_application->landmark_docket_number = $response->landmark_docket_number;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->environ_restrictions_yes) and !is_null($response->environ_restrictions_no)) { 
                                                if ($response->environ_restrictions_yes) {
                                                    $new_job_application->environ_restrictions = true;
                                                }
                                                if ($response->environ_restrictions_no) {
                                                    $new_job_application->environ_restrictions = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->unmapped_cco_yes) and !is_null($response->unmapped_cco_no)) { 
                                                if ($response->unmapped_cco_yes) {
                                                    $new_job_application->unmapped_cco = true;
                                                }
                                                if ($response->unmapped_cco_no) {
                                                    $new_job_application->unmapped_cco = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->legalization_yes) and !is_null($response->legalization_no)) { 
                                                if ($response->legalization_yes) {
                                                    $new_job_application->legalization = true;
                                                }
                                                if ($response->legalization_no) {
                                                    $new_job_application->legalization = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->other_specify_yes) and !is_null($response->other_specify_no)) { 
                                                if ($response->other_specify_yes) {
                                                    $new_job_application->other_specify = true;
                                                }
                                                if ($response->other_specify_no) {
                                                    $new_job_application->other_specify = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filed_comply_local_law_yes) and !is_null($response->filed_comply_local_law_no)) { 
                                                if ($response->filed_comply_local_law_yes) {
                                                    $new_job_application->filed_comply_local_law = true;
                                                }
                                                if ($response->filed_comply_local_law_no) {
                                                    $new_job_application->filed_comply_local_law = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->restrict_dec_easement_yes) and !is_null($response->restrict_dec_easement_no)) { 
                                                if ($response->restrict_dec_easement_yes) {
                                                    $new_job_application->restrict_dec_easement = true;
                                                }
                                                if ($response->restrict_dec_easement_no) {
                                                    $new_job_application->restrict_dec_easement = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->zoning_exhibit_record_yes) and !is_null($response->zoning_exhibit_record_no)) { 
                                                if ($response->zoning_exhibit_record_yes) {
                                                    $new_job_application->zoning_exhibit_record = true;
                                                }
                                                if ($response->zoning_exhibit_record_no) {
                                                    $new_job_application->zoning_exhibit_record = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->filed_to_address_vios_yes) and !is_null($response->filed_to_address_vios_no)) { 
                                                if ($response->filed_to_address_vios_yes) {
                                                    $new_job_application->filed_to_address_vios = true;
                                                }
                                                if ($response->filed_to_address_vios_no) {
                                                    $new_job_application->filed_to_address_vios = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_includes_lighting_fixture_yes) and !is_null($response->work_includes_lighting_fixture_no)) { 
                                                if ($response->work_includes_lighting_fixture_yes) {
                                                    $new_job_application->work_includes_lighting_fixture = true;
                                                }
                                                if ($response->work_includes_lighting_fixture_no) {
                                                    $new_job_application->work_includes_lighting_fixture = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->modular_construction_ny_state_yes) and !is_null($response->modular_construction_ny_state_no)) { 
                                                if ($response->modular_construction_ny_state_yes) {
                                                    $new_job_application->modular_construction_ny_state = true;
                                                }
                                                if ($response->modular_construction_ny_state_no) {
                                                    $new_job_application->modular_construction_ny_state = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->modular_construction_ny_city_yes) and !is_null($response->modular_construction_ny_city_no)) { 
                                                if ($response->modular_construction_ny_city_yes) {
                                                    $new_job_application->modular_construction_ny_city = true;
                                                }
                                                if ($response->modular_construction_ny_city_no) {
                                                    $new_job_application->modular_construction_ny_city = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->structural_peer_review_required_yes) and !is_null($response->structural_peer_review_required_no)) { 
                                                if ($response->structural_peer_review_required_yes) {
                                                    $new_job_application->structural_peer_review_required = true;
                                                }
                                                if ($response->structural_peer_review_required_no) {
                                                    $new_job_application->structural_peer_review_required = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_includes_permanent_removal_yes) and !is_null($response->work_includes_permanent_removal_no)) { 
                                                if ($response->work_includes_permanent_removal_yes) {
                                                    $new_job_application->work_includes_permanent_removal = true;
                                                }
                                                if ($response->work_includes_permanent_removal_no) {
                                                    $new_job_application->work_includes_permanent_removal = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->work_includes_partial_demo_yes) and !is_null($response->work_includes_partial_demo_no)) { 
                                                if ($response->work_includes_partial_demo_yes) {
                                                    $new_job_application->work_includes_partial_demo = true;
                                                }
                                                if ($response->work_includes_partial_demo_no) {
                                                    $new_job_application->work_includes_partial_demo = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->structural_stability_affected_yes) and !is_null($response->structural_stability_affected_no)) { 
                                                if ($response->structural_stability_affected_yes) {
                                                    $new_job_application->structural_stability_affected = true;
                                                }
                                                if ($response->structural_stability_affected_no) {
                                                    $new_job_application->structural_stability_affected = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->structural_stability_affected_yes) and !is_null($response->structural_stability_affected_no)) { 
                                                if ($response->structural_stability_affected_yes) {
                                                    $new_job_application->structural_stability_affected = true;
                                                }
                                                if ($response->structural_stability_affected_no) {
                                                    $new_job_application->structural_stability_affected = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_in_compliance_with_NYCECC)) { 
                                                $new_job_application->sec_10_in_compliance_with_NYCECC = $response->sec_10_in_compliance_with_NYCECC;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_energy_analysis_on_another_job_number)) { 
                                                $new_job_application->sec_10_energy_analysis_on_another_job_number = $response->sec_10_energy_analysis_on_another_job_number;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_exempt_from_NYCECC)) { 
                                                $new_job_application->sec_10_exempt_from_NYCECC = $response->sec_10_exempt_from_NYCECC;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_utilizes_tradeoffs_different_major_systems)) { 
                                                $new_job_application->sec_10_utilizes_tradeoffs_different_major_systems = $response->sec_10_utilizes_tradeoffs_different_major_systems;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_utilizes_tradeoffs_single_major_system)) { 
                                                $new_job_application->sec_10_utilizes_tradeoffs_single_major_system = $response->sec_10_utilizes_tradeoffs_single_major_system;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_alteration_of_state_or_national)) { 
                                                $new_job_application->sec_10_alteration_of_state_or_national = $response->sec_10_alteration_of_state_or_national;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_cc_path_nycecc)) { 
                                                $new_job_application->sec_10_cc_path_nycecc = $response->sec_10_cc_path_nycecc;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_cc_path_ashare)) { 
                                                $new_job_application->sec_10_cc_path_ashare = $response->sec_10_cc_path_ashare;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_ea_tabular)) { 
                                                $new_job_application->sec_10_ea_tabular = $response->sec_10_ea_tabular;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_ea_rescheck)) { 
                                                $new_job_application->sec_10_ea_rescheck = $response->sec_10_ea_rescheck;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_ea_comcheck)) { 
                                                $new_job_application->sec_10_ea_comcheck = $response->sec_10_ea_comcheck;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_10_ea_energy_modeling)) { 
                                                $new_job_application->sec_10_ea_energy_modeling = $response->sec_10_ea_energy_modeling;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_11_job_description)) { 
                                                $new_job_application->sec_11_job_description = $response->sec_11_job_description;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_11_related_bis_job_numbers_uri)) { 
                                                $new_job_application->sec_11_related_bis_job_numbers_uri = $response->sec_11_related_bis_job_numbers_uri;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_11_primary_app_job_number)) { 
                                                $new_job_application->sec_11_primary_app_job_number = $response->sec_11_primary_app_job_number;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_zoning_characteristics_districts)) { 
                                                $new_job_application->sec_12_zoning_characteristics_districts = $response->sec_12_zoning_characteristics_districts;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_special_districts)) { 
                                                $new_job_application->sec_12_special_districts = $response->sec_12_special_districts;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_overlays)) { 
                                                $new_job_application->sec_12_overlays = $response->sec_12_overlays;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_map_no)) { 
                                                $new_job_application->sec_12_map_no = $response->sec_12_map_no;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_street_legal_width)) { 
                                                $new_job_application->sec_12_street_legal_width = $response->sec_12_street_legal_width;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_zoning_includes_tax_lots)) { 
                                                $new_job_application->sec_12_zoning_includes_tax_lots = $response->sec_12_zoning_includes_tax_lots;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_zoning_street_status_public)) { 
                                                $new_job_application->sec_12_zoning_street_status_public = $response->sec_12_zoning_street_status_public;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_zoning_street_status_private)) { 
                                                $new_job_application->sec_12_zoning_street_status_private = $response->sec_12_zoning_street_status_private;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_lot_details_corner)) { 
                                                $new_job_application->sec_12_proposed_lot_details_corner = $response->sec_12_proposed_lot_details_corner;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_lot_details_interior)) { 
                                                $new_job_application->sec_12_proposed_lot_details_interior = $response->sec_12_proposed_lot_details_interior;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_lot_details_through)) { 
                                                $new_job_application->sec_12_proposed_lot_details_through = $response->sec_12_proposed_lot_details_through;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_use)) { 
                                                $new_job_application->sec_12_proposed_use = $response->sec_12_proposed_use;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_use_zoning)) { 
                                                if($response->sec_12_proposed_use_zoning == true){ 
                                                    $new_job_application->sec_12_proposed_use_zoning = true;
                                                    $new_job_application->save();
                                                }
                                            }

                                            if (!is_null($response->sec_12_proposed_use_district)) { 
                                                if($response->sec_12_proposed_use_district == true){ 
                                                    $new_job_application->sec_12_proposed_use_district = true;
                                                    $new_job_application->save();
                                                }
                                            }

                                            if (!is_null($response->sec_12_proposed_use_FAR)) { 
                                                if ($response->sec_12_proposed_use_FAR == true) {
                                                    $new_job_application->sec_12_proposed_use_FAR = true;
                                                    $new_job_application->save();
                                                }
                                            }

                                            if (!is_null($response->sec_12_zoning_area_proposed_total)) {
                                                if ($response->sec_12_zoning_area_proposed_total == true) {
                                                    $new_job_application->sec_12_zoning_area_proposed_total = $response->sec_12_zoning_area_proposed_total;
                                                    $new_job_application->save();
                                                }
                                            }

                                            if (!is_null($response->sec_12_district_area_proposed_total)) { 
                                                $new_job_application->sec_12_district_area_proposed_total = $response->sec_12_district_area_proposed_total;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_FAR_area_proposed_total)) { 
                                                $new_job_application->sec_12_FAR_area_proposed_total = $response->sec_12_FAR_area_proposed_total;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_zoning_area_existing_total)) { 
                                                $new_job_application->sec_12_zoning_area_existing_total = $response->sec_12_zoning_area_existing_total;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_district_area_existing_total)) { 
                                                $new_job_application->sec_12_district_area_existing_total = $response->sec_12_district_area_existing_total;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_FAR_area_existing_total)) { 
                                                $new_job_application->sec_12_FAR_area_existing_total = $response->sec_12_FAR_area_existing_total;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_lot_coverage)) { 
                                                $new_job_application->sec_12_proposed_lot_coverage = $response->sec_12_proposed_lot_coverage;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_lot_area)) { 
                                                $new_job_application->sec_12_proposed_lot_area = $response->sec_12_proposed_lot_area;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_lot_width)) { 
                                                $new_job_application->sec_12_proposed_lot_width = $response->sec_12_proposed_lot_width;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_yard_details_no_yards)) { 
                                                $new_job_application->sec_12_proposed_yard_details_no_yards = $response->sec_12_proposed_yard_details_no_yards;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_yard_front)) { 
                                                $new_job_application->sec_12_proposed_yard_front = $response->sec_12_proposed_yard_front;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_yard_rear)) { 
                                                $new_job_application->sec_12_proposed_yard_rear = $response->sec_12_proposed_yard_rear;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_yard_rear_equivalent)) { 
                                                $new_job_application->sec_12_proposed_yard_rear_equivalent = $response->sec_12_proposed_yard_rear_equivalent;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_yard_side1)) { 
                                                $new_job_application->sec_12_proposed_yard_side1 = $response->sec_12_proposed_yard_side1;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_yard_side2)) { 
                                                $new_job_application->sec_12_proposed_yard_side2 = $response->sec_12_proposed_yard_side2;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_other_perimeter_wall_height)) { 
                                                $new_job_application->sec_12_proposed_other_perimeter_wall_height = $response->sec_12_proposed_other_perimeter_wall_height;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_other_details_enclosed_parking_yes) and !is_null($response->sec_12_proposed_other_details_enclosed_parking_no)) { 
                                                if ($response->sec_12_proposed_other_details_enclosed_parking_yes) {
                                                    $new_job_application->sec_12_proposed_other_details_enclosed_parking = true;
                                                }
                                                if ($response->sec_12_proposed_other_details_enclosed_parking_no) {
                                                    $new_job_application->sec_12_proposed_other_details_enclosed_parking = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_12_proposed_other_details_number_of_parking_spaces)) { 
                                                $new_job_application->sec_12_proposed_other_details_number_of_parking_spaces = $response->sec_12_proposed_other_details_number_of_parking_spaces;
                                                $new_job_application->save();
                                            } 
                                            
                                            if (!is_null($response->sec_13_occ_class_existing_text)) { 
                                                $new_job_application->sec_13_occ_class_existing_text = $response->sec_13_occ_class_existing_text;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_occ_class_2014_2008_code_designations_yes) and !is_null($response->sec_13_occ_class_2014_2008_code_designations_no)) { 
                                                if ($response->sec_13_occ_class_2014_2008_code_designations_yes) {
                                                    $new_job_application->sec_13_occ_class_2014_2008_code_designations = true;
                                                }
                                                if ($response->sec_13_occ_class_2014_2008_code_designations_no) {
                                                    $new_job_application->sec_13_occ_class_2014_2008_code_designations = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_occ_class_proposed_text)) { 
                                                $new_job_application->sec_13_occ_class_proposed_text = $response->sec_13_occ_class_proposed_text;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_con_class_existing_text)) { 
                                                $new_job_application->sec_13_con_class_existing_text = $response->sec_13_con_class_existing_text;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_con_class_2014_2008_code_designations_yes) and !is_null($response->sec_13_con_class_2014_2008_code_designations_no)) { 
                                                if ($response->sec_13_con_class_2014_2008_code_designations_yes) {
                                                    $new_job_application->sec_13_con_class_2014_2008_code_designations = true;
                                                }
                                                if ($response->sec_13_con_class_2014_2008_code_designations_no) {
                                                    $new_job_application->sec_13_con_class_2014_2008_code_designations = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_con_class_proposed_text)) { 
                                                $new_job_application->sec_13_con_class_proposed_text = $response->sec_13_con_class_proposed_text;
                                                $new_job_application->save();
                                            } 

                                            if (!is_null($response->sec_13_multi_dwelling_class_existing_text)) { 
                                                $new_job_application->sec_13_multi_dwelling_class_existing_text = $response->sec_13_multi_dwelling_class_existing_text;
                                                $new_job_application->save();
                                            } 

                                            if (!is_null($response->sec_13_multi_dwelling_class_proposed_text)) { 
                                                $new_job_application->sec_13_multi_dwelling_class_proposed_text = $response->sec_13_multi_dwelling_class_proposed_text;
                                                $new_job_application->save();
                                            } 

                                            if (!is_null($response->sec_13_building_height_existing_text)) { 
                                                $new_job_application->sec_13_building_height_existing_text = $response->sec_13_building_height_existing_text;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_building_height_proposed_text)) { 
                                                $new_job_application->sec_13_building_height_proposed_text = $response->sec_13_building_height_proposed_text;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_building_stories_existing_text)) { 
                                                $new_job_application->sec_13_building_stories_existing_text = $response->sec_13_building_stories_existing_text;
                                                $new_job_application->save();
                                            } 

                                            if (!is_null($response->sec_13_building_stories_proposed_text)) { 
                                                $new_job_application->sec_13_building_stories_proposed_text = $response->sec_13_building_stories_proposed_text;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_dwelling_units_existing_text)) { 
                                                $new_job_application->sec_13_dwelling_units_existing_text = $response->sec_13_dwelling_units_existing_text;
                                                $new_job_application->save();
                                            } 

                                            if (!is_null($response->sec_13_dwelling_units_proposed_text)) { 
                                                $new_job_application->sec_13_dwelling_units_proposed_text = $response->sec_13_dwelling_units_proposed_text;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_erected_pursuant_to_bc_2014)) { 
                                                $new_job_application->sec_13_erected_pursuant_to_bc_2014 = $response->sec_13_erected_pursuant_to_bc_2014;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_erected_pursuant_to_bc_2008)) { 
                                                $new_job_application->sec_13_erected_pursuant_to_bc_2008 = $response->sec_13_erected_pursuant_to_bc_2008;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_erected_pursuant_to_bc_1968)) { 
                                                $new_job_application->sec_13_erected_pursuant_to_bc_1968 = $response->sec_13_erected_pursuant_to_bc_1968;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_erected_pursuant_to_bc_before_1968)) { 
                                                $new_job_application->sec_13_erected_pursuant_to_bc_before_1968 = $response->sec_13_erected_pursuant_to_bc_before_1968;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_earliest_code_required_2014)) { 
                                                $new_job_application->sec_13_earliest_code_required_2014 = $response->sec_13_earliest_code_required_2014;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_earliest_code_required_2008)) { 
                                                $new_job_application->sec_13_earliest_code_required_2008 = $response->sec_13_earliest_code_required_2008;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_earliest_code_required_1968)) { 
                                                $new_job_application->sec_13_earliest_code_required_1968 = $response->sec_13_earliest_code_required_1968;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_earliest_code_required_before_1968)) { 
                                                $new_job_application->sec_13_earliest_code_required_before_1968 = $response->sec_13_earliest_code_required_before_1968;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_13_mixed_use_building_yes) and !is_null($response->sec_13_mixed_use_building_no)) { 
                                                if ($response->sec_13_mixed_use_building_yes) {
                                                    $new_job_application->sec_13_mixed_use_building = true;
                                                }
                                                if ($response->sec_13_mixed_use_building_no) {
                                                    $new_job_application->sec_13_mixed_use_building = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_14_fill_not_applicable)) { 
                                                $new_job_application->sec_14_fill_not_applicable = $response->sec_14_fill_not_applicable;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_14_fill_off_site)) { 
                                                $new_job_application->sec_14_fill_off_site = $response->sec_14_fill_off_site;
                                                $new_job_application->save();
                                            } 

                                            if (!is_null($response->sec_14_fill_on_site)) { 
                                                $new_job_application->sec_14_fill_on_site = $response->sec_14_fill_on_site;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_14_fill_under_300_cubic_yds)) { 
                                                $new_job_application->sec_14_fill_under_300_cubic_yds = $response->sec_14_fill_under_300_cubic_yds;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_15_construction_equipment_chute)) { 
                                                $new_job_application->sec_15_construction_equipment_chute = $response->sec_15_construction_equipment_chute;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_15_construction_equipment_sidewalk_shed)) { 
                                                $new_job_application->sec_15_construction_equipment_sidewalk_shed = $response->sec_15_construction_equipment_sidewalk_shed;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_15_construction_equipment_fence)) { 
                                                $new_job_application->sec_15_construction_equipment_fence = $response->sec_15_construction_equipment_fence;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_15_construction_equipment_supported_scaffold)) { 
                                                $new_job_application->sec_15_construction_equipment_supported_scaffold = $response->sec_15_construction_equipment_supported_scaffold;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_15_construction_equipment_other)) { 
                                                $new_job_application->sec_15_construction_equipment_other = $response->sec_15_construction_equipment_other;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_16_size_of_cut_splays)) { 
                                                $new_job_application->sec_16_size_of_cut_splays = $response->sec_16_size_of_cut_splays;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_16_curbcut_text)) { 
                                                $new_job_application->sec_16_curbcut_text = $response->sec_16_curbcut_text;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_16_distance_from_nearest_corner)) { 
                                                $new_job_application->sec_16_distance_from_nearest_corner = $response->sec_16_distance_from_nearest_corner;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_18_fire_alarm_existing_yes) and !is_null($response->sec_18_fire_alarm_existing_no)) { 
                                                if ($response->sec_18_fire_alarm_existing_yes) {
                                                    $new_job_application->sec_18_fire_alarm_existing = true;
                                                }
                                                if ($response->sec_18_fire_alarm_existing_no) {
                                                    $new_job_application->sec_18_fire_alarm_existing = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_18_fire_alarm_proposed_yes) and !is_null($response->sec_18_fire_alarm_proposed_no)) { 
                                                if ($response->sec_18_fire_alarm_proposed_yes) {
                                                    $new_job_application->sec_18_fire_alarm_proposed = true;
                                                }
                                                if ($response->sec_18_fire_alarm_proposed_no) {
                                                    $new_job_application->sec_18_fire_alarm_proposed = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_18_sprinkler_existing_yes) and !is_null($response->sec_18_sprinkler_existing_no)) { 
                                                if ($response->sec_18_sprinkler_existing_yes) {
                                                    $new_job_application->sec_18_sprinkler_existing = true;
                                                }
                                                if ($response->sec_18_sprinkler_existing_no) {
                                                    $new_job_application->sec_18_sprinkler_existing = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_18_sprinkler_proposed_yes) and !is_null($response->sec_18_sprinkler_proposed_no)) { 
                                                if ($response->sec_18_sprinkler_proposed_yes) {
                                                    $new_job_application->sec_18_sprinkler_proposed = true;
                                                }
                                                if ($response->sec_18_sprinkler_proposed_no) {
                                                    $new_job_application->sec_18_sprinkler_proposed = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_18_sprinkler_proposed_yes) and !is_null($response->sec_18_sprinkler_proposed_no)) { 
                                                if ($response->sec_18_sprinkler_proposed_yes) {
                                                    $new_job_application->sec_18_sprinkler_proposed = true;
                                                }
                                                if ($response->sec_18_sprinkler_proposed_no) {
                                                    $new_job_application->sec_18_sprinkler_proposed = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_18_fire_suppression_existing_yes) and !is_null($response->sec_18_fire_suppression_existing_no)) { 
                                                if ($response->sec_18_fire_suppression_existing_yes) {
                                                    $new_job_application->sec_18_fire_suppression_existing = true;
                                                }
                                                if ($response->sec_18_fire_suppression_existing_no) {
                                                    $new_job_application->sec_18_fire_suppression_existing = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_18_fire_suppression_proposed_yes) and !is_null($response->sec_18_fire_suppression_proposed_no)) { 
                                                if ($response->sec_18_fire_suppression_proposed_yes) {
                                                    $new_job_application->sec_18_fire_suppression_proposed = true;
                                                }
                                                if ($response->sec_18_fire_suppression_proposed_no) {
                                                    $new_job_application->sec_18_fire_suppression_proposed = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_18_standpipe_existing_yes) and !is_null($response->sec_18_standpipe_existing_no)) { 
                                                if ($response->sec_18_standpipe_existing_yes) {
                                                    $new_job_application->sec_18_standpipe_existing = true;
                                                }
                                                if ($response->sec_18_standpipe_existing_no) {
                                                    $new_job_application->sec_18_standpipe_existing = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_18_standpipe_proposed_yes) and !is_null($response->sec_18_standpipe_proposed_no)) { 
                                                if ($response->sec_18_standpipe_proposed_yes) {
                                                    $new_job_application->sec_18_standpipe_proposed = true;
                                                }
                                                if ($response->sec_18_standpipe_proposed_no) {
                                                    $new_job_application->sec_18_standpipe_proposed = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_20_tidal_wetlands_yes) and !is_null($response->sec_20_tidal_wetlands_no)) { 
                                                if ($response->sec_20_tidal_wetlands_yes) {
                                                    $new_job_application->sec_20_tidal_wetlands = true;
                                                }
                                                if ($response->sec_20_tidal_wetlands_no) {
                                                    $new_job_application->sec_20_tidal_wetlands = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_20_freshwater_wetlands_yes) and !is_null($response->sec_20_freshwater_wetlands_no)) { 
                                                if ($response->sec_20_freshwater_wetlands_yes) {
                                                    $new_job_application->sec_20_freshwater_wetlands = true;
                                                }
                                                if ($response->sec_20_freshwater_wetlands_no) {
                                                    $new_job_application->sec_20_freshwater_wetlands = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_20_coastal_erosion_hazard_yes) and !is_null($response->sec_20_coastal_erosion_hazard_no)) { 
                                                if ($response->sec_20_coastal_erosion_hazard_yes) {
                                                    $new_job_application->sec_20_coastal_erosion_hazard = true;
                                                }
                                                if ($response->sec_20_coastal_erosion_hazard_no) {
                                                    $new_job_application->sec_20_coastal_erosion_hazard = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_20_urban_renewal_yes) and !is_null($response->sec_20_urban_renewal_no)) { 
                                                if ($response->sec_20_urban_renewal_yes) {
                                                    $new_job_application->sec_20_urban_renewal = true;
                                                }
                                                if ($response->sec_20_urban_renewal_no) {
                                                    $new_job_application->sec_20_urban_renewal = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_20_fire_district_yes) and !is_null($response->sec_20_fire_district_no)) { 
                                                if ($response->sec_20_fire_district_yes) {
                                                    $new_job_application->sec_20_fire_district = true;
                                                }
                                                if ($response->sec_20_fire_district_no) {
                                                    $new_job_application->sec_20_fire_district = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_20_flood_hazard_yes) and !is_null($response->sec_20_flood_hazard_no)) { 
                                                if ($response->sec_20_flood_hazard_yes) {
                                                    $new_job_application->sec_20_flood_hazard = true;
                                                }
                                                if ($response->sec_20_flood_hazard_no) {
                                                    $new_job_application->sec_20_flood_hazard = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_20_substantial_improvement_yes) and !is_null($response->sec_20_substantial_improvement_no)) { 
                                                if ($response->sec_20_substantial_improvement_yes) {
                                                    $new_job_application->sec_20_substantial_improvement = true;
                                                }
                                                if ($response->sec_20_substantial_improvement_no) {
                                                    $new_job_application->sec_20_substantial_improvement = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_20_substantially_damaged_yes) and !is_null($response->sec_20_substantially_damaged_no)) { 
                                                if ($response->sec_20_substantially_damaged_yes) {
                                                    $new_job_application->sec_20_substantially_damaged = true;
                                                }
                                                if ($response->sec_20_substantially_damaged_no) {
                                                    $new_job_application->sec_20_substantially_damaged = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_20_floodshields_yes) and !is_null($response->sec_20_floodshields_no)) { 
                                                if ($response->sec_20_floodshields_yes) {
                                                    $new_job_application->sec_20_floodshields = true;
                                                }
                                                if ($response->sec_20_floodshields_no) {
                                                    $new_job_application->sec_20_floodshields = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_21_affects_exterior_yes) and !is_null($response->sec_21_affects_exterior_no)) { 
                                                if ($response->sec_21_affects_exterior_yes) {
                                                    $new_job_application->sec_21_affects_exterior = true;
                                                }
                                                if ($response->sec_21_affects_exterior_no) {
                                                    $new_job_application->sec_21_affects_exterior = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_21_involves_raising_yes) and !is_null($response->sec_21_involves_raising_no)) { 
                                                if ($response->sec_21_involves_raising_yes) {
                                                    $new_job_application->sec_21_involves_raising = true;
                                                }
                                                if ($response->sec_21_involves_raising_no) {
                                                    $new_job_application->sec_21_involves_raising = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_22_requires_asbestos_abatement)) { 
                                                $new_job_application->sec_22_requires_asbestos_abatement = $response->sec_22_requires_asbestos_abatement;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_purpose_adveritising)) { 
                                                $new_job_application->sec_23_purpose_advertising = $response->sec_23_purpose_adveritising;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_purpose_non_advertising)) { 
                                                $new_job_application->sec_23_purpose_non_advertising = $response->sec_23_purpose_non_advertising;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_type_illuminated)) { 
                                                $new_job_application->sec_23_type_illuminated = $response->sec_23_type_illuminated;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_type_non_illuminated)) { 
                                                $new_job_application->sec_23_type_non_illuminated = $response->sec_23_type_non_illuminated;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_illuminated_type_direct)) { 
                                                $new_job_application->sec_23_illuminated_type_direct = $response->sec_23_illuminated_type_direct;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_illuminated_type_flashing)) { 
                                                $new_job_application->sec_23_illuminated_type_flashing = $response->sec_23_illuminated_type_flashing;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_illuminated_type_indirect)) { 
                                                $new_job_application->sec_23_illuminated_type_indirect = $response->sec_23_illuminated_type_indirect;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_location_ground)) { 
                                                $new_job_application->sec_23_location_ground = $response->sec_23_location_ground;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_location_roof)) { 
                                                $new_job_application->sec_23_location_roof = $response->sec_23_location_roof;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_location_wall)) { 
                                                $new_job_application->sec_23_location_wall = $response->sec_23_location_wall;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_estimated_cost)) { 
                                                $new_job_application->sec_23_estimated_cost = $response->sec_23_estimated_cost;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_total_sq_ft)) { 
                                                $new_job_application->sec_23_total_sq_ft = $response->sec_23_total_sq_ft;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_height_above_curb)) { 
                                                $new_job_application->sec_23_height_above_curb = $response->sec_23_height_above_curb;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_height_above_roof)) { 
                                                $new_job_application->sec_23_height_above_roof = $response->sec_23_height_above_roof;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_inside_building_line_yes) and !is_null($response->sec_23_inside_building_line_no)) { 
                                                if ($response->sec_23_inside_building_line_yes) {
                                                    $new_job_application->sec_23_inside_building_line = true;
                                                }
                                                if ($response->sec_23_inside_building_line_no) {
                                                    $new_job_application->sec_23_inside_building_line = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_inside_building_line_text)) { 
                                                $new_job_application->sec_23_inside_building_line_text = $response->sec_23_inside_building_line_text;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_owner_billed_for_annual_permit_yes) and !is_null($response->sec_23_owner_billed_for_annual_permit_no)) { 
                                                if ($response->sec_23_owner_billed_for_annual_permit_yes) {
                                                    $new_job_application->sec_23_owner_billed_for_annual_permit = true;
                                                }
                                                if ($response->sec_23_owner_billed_for_annual_permit_no) {
                                                    $new_job_application->sec_23_owner_billed_for_annual_permit = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_sign_tight_closed_or_solid_yes) and !is_null($response->sec_23_sign_tight_closed_or_solid_no)) { 
                                                if ($response->sec_23_sign_tight_closed_or_solid_yes) {
                                                    $new_job_application->sec_23_sign_tight_closed_or_solid = true;
                                                }
                                                if ($response->sec_23_sign_tight_closed_or_solid_no) {
                                                    $new_job_application->sec_23_sign_tight_closed_or_solid = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_changeable_copy_yes) and !is_null($response->sec_23_changeable_copy_no)) { 
                                                if ($response->sec_23_changeable_copy_yes) {
                                                    $new_job_application->sec_23_changeable_copy = true;
                                                }
                                                if ($response->sec_23_changeable_copy_no) {
                                                    $new_job_application->sec_23_changeable_copy = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_sign_wording_text)) { 
                                                $new_job_application->sec_23_sign_wording_text = $response->sec_23_sign_wording_text;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_oac_interest_yes) and !is_null($response->sec_23_oac_interest_no)) { 
                                                if ($response->sec_23_oac_interest_yes) {
                                                    $new_job_application->sec_23_oac_interest = true;
                                                }
                                                if ($response->sec_23_oac_interest_no) {
                                                    $new_job_application->sec_23_oac_interest = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_oac_registration_number)) { 
                                                $new_job_application->sec_23_oac_registration_number = $response->sec_23_oac_registration_number;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_within_900_yes) and !is_null($response->sec_23_within_900_no)) { 
                                                if ($response->sec_23_within_900_yes) {
                                                    $new_job_application->sec_23_within_900 = true;
                                                }
                                                if ($response->sec_23_within_900_no) {
                                                    $new_job_application->sec_23_within_900 = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_within_900_distance)) { 
                                                $new_job_application->sec_23_within_900_distance = $response->sec_23_within_900_distance;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_within_200_yes) and !is_null($response->sec_23_within_200_no)) { 
                                                if ($response->sec_23_within_200_yes) {
                                                    $new_job_application->sec_23_within_200 = true;
                                                }
                                                if ($response->sec_23_within_200_no) {
                                                    $new_job_application->sec_23_within_200 = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_23_within_200_distance)) { 
                                                $new_job_application->sec_23_within_200_distance = $response->sec_23_within_200_distance;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_24_comments)) { 
                                                $new_job_application->sec_24_comments = $response->sec_24_comments;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_25_nb_a1_yes) and !is_null($response->sec_25_nb_a1_no)) { 
                                                if ($response->sec_25_nb_a1_yes) {
                                                    $new_job_application->sec_25_nb_a1 = true;
                                                }
                                                if ($response->sec_25_nb_a1_no) {
                                                    $new_job_application->sec_25_nb_a1 = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_25_directive_14_yes) and !is_null($response->sec_25_directive_14_no)) { 
                                                if ($response->sec_25_directive_14_yes) {
                                                    $new_job_application->sec_25_directive_14 = true;
                                                }
                                                if ($response->sec_25_directive_14_no) {
                                                    $new_job_application->sec_25_directive_14 = false;
                                                }
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_26_name)) { 
                                                $new_job_application->sec_26_name = $response->sec_26_name;
                                                $new_job_application->save();
                                            } 
                                            
                                            if (!is_null($response->sec_26_relationship_to_owner)) { 
                                                $new_job_application->sec_26_relationship_to_owner = $response->sec_26_relationship_to_owner;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_26_business_name)) { 
                                                $new_job_application->sec_26_business_name = $response->sec_26_business_name;
                                                $new_job_application->save();
                                            } 

                                            if (!is_null($response->sec_26_business_phone)) { 
                                                $new_job_application->sec_26_business_phone = $response->sec_26_business_phone;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_26_business_address)) { 
                                                $new_job_application->sec_26_business_address = $response->sec_26_business_address;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_26_business_fax)) { 
                                                $new_job_application->sec_26_business_fax = $response->sec_26_business_fax;
                                                $new_job_application->save();
                                            } 

                                            if (!is_null($response->sec_26_email)) { 
                                                $new_job_application->sec_26_email = $response->sec_26_email;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_26_owner_type)) { 
                                                $new_job_application->sec_26_owner_type = $response->sec_26_owner_type;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_27_metes_and_bounds_text)) { 
                                                $new_job_application->sec_27_metes_and_bounds_text = $response->sec_27_metes_and_bounds_text;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_27_metes_and_bounds_running_thence_1)) { 
                                                $new_job_application->sec_27_metes_and_bounds_running_thence_1 = $response->sec_27_metes_and_bounds_running_thence_1;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_27_metes_and_bounds_thence_1)) { 
                                                $new_job_application->sec_27_metes_and_bounds_thence_1 = $response->sec_27_metes_and_bounds_thence_1;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_27_metes_and_bounds_running_thence_2)) { 
                                                $new_job_application->sec_27_metes_and_bounds_running_thence_2 = $response->sec_27_metes_and_bounds_running_thence_2;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_27_metes_and_bounds_thence_2)) { 
                                                $new_job_application->sec_27_metes_and_bounds_thence_2 = $response->sec_27_metes_and_bounds_thence_2;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_27_metes_and_bounds_running_thence_3)) { 
                                                $new_job_application->sec_27_metes_and_bounds_running_thence_3 = $response->sec_27_metes_and_bounds_running_thence_3;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_27_metes_and_bounds_thence_3)) { 
                                                $new_job_application->sec_27_metes_and_bounds_thence_3 = $response->sec_27_metes_and_bounds_thence_3;
                                                $new_job_application->save();
                                            } 

                                            if (!is_null($response->sec_27_metes_and_bounds_running_thence_4)) { 
                                                $new_job_application->sec_27_metes_and_bounds_running_thence_4 = $response->sec_27_metes_and_bounds_running_thence_4;
                                                $new_job_application->save();
                                            }

                                            if (!is_null($response->sec_27_metes_and_bounds_thence_4)) { 
                                                $new_job_application->sec_27_metes_and_bounds_thence_4 = $response->sec_27_metes_and_bounds_thence_4;
                                                $new_job_application->save();
                                            }

                                            if ($new_job_application->job_status != 'X SIGNED OFF' && $new_job_application->job_status != 'U COMPLETED') { 
                                                if(strpos($new_job_application->sec_24_comments, 'WITHDRAWAL') == false){ 
                                                    $new_job_application->active = true;
                                                    $new_job_application->save();
                                                }
                                            }
                                        }
                                        
                                        if($new_job_application->job_status != 'X SIGNED OFF' && $new_job_application->job_status != 'U COMPLETED'){ 
                                            if(strpos($new_job_application->sec_24_comments, 'WITHDRAWAL') == false){ 
                                                $new_job_application->active = true; 
                                                $new_job_application->save();

                                                foreach($portfolios as $portfolio){ 
                                                    if($portfolio->init_summary == true){ 
                                                        $user = User::find($portfolio->user_id); 
                                                        $content = [ 
                                                            'property'        => $property, 
                                                            'job_application' => $new_job_application
                                                        ];
                                                        Mail::to($user->email)->send(new newBISJobApplication($content));
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            if (!empty($response->nextpage_url)) { 
                                $property->jobs_filings_endpoint = $response->nextpage_url;
                                $property->save();
                            }
                            if (empty($response->nextpage_url)) { 
                                $property->jobs_filings_endpoint = ''; 
                                $property->save();
                            }
                            $total_amount_job_applications = BISJobApplication::where('property_id', $property->id)->get()->count(); 
                        }
                    }
                }
            }
        }

    }
}
