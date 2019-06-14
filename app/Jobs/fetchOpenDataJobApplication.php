<?php

namespace App\Jobs;

use App\Property; 
use App\JobApplication; 
use App\JobApplication2;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class fetchOpenDataJobApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $p;
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($property)
    {
        //
        $this->p = $property;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if(!is_null($this->p)){ 
            $client = new Client();
            $d = json_decode($client->get('https://data.cityofnewyork.us/resource/rvhx-8trz.json?bin__='.$this->p->bin)->getBody()->getContents());
            if(!is_null($d)){ 
                foreach($d as $j){ 
                    $exist = JobApplication::where('property_id', $this->p->id)->where('job__', $j->job__)->where('doc__', $j->doc__)->first();
                    if(is_null($exist)){ 
                        $new = new JobApplication; 
                        $new_ext = new JobApplication2;
                        $new->property_id = $this->p->id; 
                        if (!empty($j->job__)) { 
                            $new->job__ = $j->job__; 
                        }

                        if (!empty($j->doc__)) { 
                            $new->doc__ = $j->doc__; 
                        }

                        if (!empty($j->borough)) { 
                            $new->borough = $j->borough; 
                        }

                        if (!empty($j->house__)) { 
                            $new->house__ = $j->house__; 
                        }

                        if (!empty($j->street_name)) { 
                            $new->street_name = $j->street_name; 
                        }

                        if (!empty($j->block)) { 
                            $new->block = $j->block; 
                        }

                        if (!empty($j->lot)) { 
                            $new->lot = $j->lot; 
                        }

                        if (!empty($j->bin__)) { 
                            $new->bin__ = $j->bin__; 
                        }

                        if (!empty($j->job_type)) { 
                            $new->job_type = $j->job_type; 
                        }

                        if (!empty($j->job_status)) { 
                            $new->job_status = $j->job_status; 
                        }

                        if (!empty($j->job_status_descrp)) { 
                            $new->job_status_descrp = $j->job_status_descrp; 
                        }

                        if (!empty($j->latest_action_date)) { 
                            $new->latest_action_date = $j->latest_action_date; 
                        }

                        if (!empty($j->building_type)) { 
                            $new->building_type = $j->building_type; 
                        }

                        if (!empty($j->community_board)) { 
                            $new->community_board = $j->community_board; 
                        }

                        if (!empty($j->cluster)) { 
                            $new->cluster = $j->cluster; 
                        }

                        if (!empty($j->landmarked)) { 
                            $new->landmarked = $j->landmarked; 
                        }

                        if (!empty($j->adult_estab)) { 
                            $new->adult_estab = $j->adult_estab; 
                        }

                        if (!empty($j->loft_board)) { 
                            $new->loft_board = $j->loft_board; 
                        }

                        if (!empty($j->city_owned)) { 
                            $new->city_owned = $j->city_owned; 
                        }

                        if (!empty($j->little_e)) { 
                            $new->little_e = $j->little_e; 
                        }

                        if (!empty($j->pc_filed)) { 
                            $new->pc_filed = $j->pc_filed; 
                        }

                        if (!empty($j->efiling_filed)) { 
                            $new->efiling_filed = $j->efiling_filed; 
                        }

                        if (!empty($j->plumbing)) { 
                            $new->plumbing = $j->plumbing; 
                        }

                        if (!empty($j->mechanical)) { 
                            $new->mechanical = $j->mechanical; 
                        }

                        if (!empty($j->boiler)) { 
                            $new->boiler = $j->boiler; 
                        }

                        if (!empty($j->fuel_burning)) { 
                            $new->fuel_burning = $j->fuel_burning; 
                        }

                        if (!empty($j->fuel_storage)) { 
                            $new->fuel_storage = $j->fuel_storage; 
                        }

                        if (!empty($j->standpipe)) { 
                            $new->standpipe = $j->standpipe; 
                        }

                        if (!empty($j->sprinkler)) { 
                            $new->sprinkler = $j->sprinkler; 
                        }

                        if (!empty($j->fire_alarm)) { 
                            $new->fire_alarm = $j->fire_alarm; 
                        }

                        if (!empty($j->equipment)) { 
                            $new->equipment = $j->equipment; 
                        }

                        if (!empty($j->fire_suppression)) { 
                            $new->fire_suppression = $j->fire_suppression; 
                        }

                        if (!empty($j->curb_cut)) { 
                            $new->curb_cut = $j->curb_cut; 
                        }

                        if (!empty($j->other)) { 
                            $new->other = $j->other; 
                        }

                        if (!empty($j->other_description)) { 
                            $new->other_description = $j->other_description; 
                        }

                        if (!empty($j->applicant_s_first_name)) { 
                            $new->applicant_s_first_name = $j->applicant_s_first_name; 
                        }

                        if (!empty($j->applicant_s_last_name)) { 
                            $new->applicant_s_last_name = $j->applicant_s_last_name; 
                        }

                        if (!empty($j->applicant_professional_title)) { 
                            $new->applicant_professional_title = $j->applicant_professional_title; 
                        }

                        if (!empty($j->applicant_license__)) { 
                            $new->applicant_license__ = $j->applicant_license__; 
                        }

                        if (!empty($j->professional_cert)) { 
                            $new->professional_cert = $j->professional_cert; 
                        }

                        if (!empty($j->pre__filing_date)) { 
                            $new->pre_filing_date = $j->pre__filing_date; 
                        }

                        $new->save();

                        if (!empty($new->id)) { 
                            $new_ext->job_application_id = $new->id; 
                        }

                        if (!empty($j->paid)) { 
                            $new_ext->paid = $j->paid; 
                        }

                        if (!empty($j->fully_paid)) { 
                            $new_ext->fully_paid = $j->fully_paid; 
                        }

                        if (!empty($j->assigned)) { 
                            $new_ext->assigned = $j->assigned; 
                        }

                        if (!empty($j->approved)) { 
                            $new_ext->approved = $j->approved; 
                        }

                        if (!empty($j->fully_permitted)) { 
                            $new_ext->fully_permitted = $j->fully_permitted; 
                        }

                        if (!empty($j->initial_cost)) { 
                            $new_ext->initial_cost = $j->initial_cost; 
                        }

                        if (!empty($j->total_est_fee)) { 
                            $new_ext->total_est_fee = $j->total_est_fee; 
                        }

                        if (!empty($j->fee_status)) { 
                            $new_ext->fee_status = $j->fee_status; 
                        }

                        if (!empty($j->existing_zoning_sqft)) { 
                            $new_ext->existing_zoning_sqft = $j->existing_zoning_sqft; 
                        }

                        if (!empty($j->proposed_zoning_sqft)) { 
                            $new_ext->proposed_zoning_sqft = $j->proposed_zoning_sqft; 
                        }

                        if (!empty($j->horizontal_enlrgmt)) { 
                            $new_ext->horizontal_enlrgmt = $j->horizontal_enlrgmt; 
                        }

                        if (!empty($j->vertical_enlrgmt)) { 
                            $new_ext->vertical_enlrgmt = $j->vertical_enlrgmt; 
                        }

                        if (!empty($j->enlargement_sq_footage)) { 
                            $new_ext->enlargement_sq_footage = $j->enlargement_sq_footage; 
                        }

                        if (!empty($j->street_frontage)) { 
                            $new_ext->street_frontage = $j->street_frontage; 
                        }

                        if (!empty($j->existingno_of_stories)) { 
                            $new_ext->existingno_of_stories = $j->existingno_of_stories; 
                        }

                        if (!empty($j->proposed_no_of_stories)) { 
                            $new_ext->proposed_no_of_stories = $j->proposed_no_of_stories; 
                        }

                        if (!empty($j->existing_height)) { 
                            $new_ext->existing_height = $j->existing_height; 
                        }

                        if (!empty($j->proposed_height)) { 
                            $new_ext->proposed_height = $j->proposed_height; 
                        }

                        if (!empty($j->existing_dwelling_units)) { 
                            $new_ext->existing_dwelling_units = $j->existing_dwelling_units; 
                        }

                        if (!empty($j->proposed_dwelling_units)) { 
                            $new_ext->proposed_dwelling_units = $j->proposed_dwelling_units; 
                        }

                        if (!empty($j->existing_occupancy)) { 
                            $new_ext->existing_occupancy = $j->existing_occupancy; 
                        }

                        if (!empty($j->proposed_occupancy)) { 
                            $new_ext->proposed_occupancy = $j->proposed_occupancy; 
                        }

                        if (!empty($j->site_fill)) { 
                            $new_ext->site_fill = $j->site_fill; 
                        }

                        if (!empty($j->zoning_dist1)) { 
                            $new_ext->zoning_dist1 = $j->zoning_dist1; 
                        }

                        if (!empty($j->zoning_dist2)) { 
                            $new_ext->zoning_dist2 = $j->zoning_dist2; 
                        }

                        if (!empty($j->zoning_dist3)) { 
                            $new_ext->zoning_dist3 = $j->zoning_dist3; 
                        }

                        if (!empty($j->special_dist_1)) { 
                            $new_ext->special_dist_1 = $j->special_dist_1; 
                        }

                        if (!empty($j->special_dist_2)) { 
                            $new_ext->special_dist_2 = $j->special_dist_2; 
                        }

                        if (!empty($j->owner_type)) { 
                            $new_ext->owner_type = $j->owner_type; 
                        }

                        if (!empty($j->non_profit)) { 
                            $new_ext->non_profit = $j->non_profit; 
                        }

                        if (!empty($j->owner_s_first_name)) { 
                            $new_ext->owner_s_first_name = $j->owner_s_first_name; 
                        }

                        if (!empty($j->owner_s_last_name)) { 
                            $new_ext->owner_s_last_name = $j->owner_s_last_name; 
                        }

                        if (!empty($j->owner_s_business_name)) { 
                            $new_ext->owner_s_business_name = $j->owner_s_business_name; 
                        }

                        if (!empty($j->owner_s_house_number)) { 
                            $new_ext->owner_s_house_number = $j->owner_s_house_number; 
                        }

                        if (!empty($j->owner_shouse_street_name)) { 
                            $new_ext->owner_shouse_street_name = $j->owner_shouse_street_name; 
                        }

                        if (!empty($j->city__)) { 
                            $new_ext->city__ = $j->city__; 
                        }

                        if (!empty($j->state)) { 
                            $new_ext->state = $j->state; 
                        }

                        if (!empty($j->zip)) { 
                            $new_ext->zip = $j->zip; 
                        }

                        if (!empty($j->owner_sphone)) { 
                            $new_ext->owner_sphone = $j->owner_sphone; 
                        }

                        if (!empty($j->job_description)) { 
                            $new_ext->job_description = $j->job_description; 
                        }

                        if (!empty($j->dobrundate)) { 
                            $new_ext->dobrundate = $j->dobrundate; 
                        }

                        if (!empty($j->total_construction_floor_area)) { 
                            $new_ext->total_construction_floor_area = $j->total_construction_floor_area;
                        }

                        $new_ext->save();
                    }
                }
            }
        }
    }
}
