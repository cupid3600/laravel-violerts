<?php

namespace App\Jobs;

use App\Property; 
use App\OATHCase; 
use App\OATHCase2;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class fetchOATHHearingCase implements ShouldQueue
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
        $this->p = $this->p;
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
            $block = $this->p->block; 
            $lot = $this->p->lot; 

            if(strlen($this->p->block) === 3) { 
                $block = '00'.$this->p->block;
            }

            if(strlen($this->p->block) === 4) { 
                $block = '0'.$this->p->block;
            }

            if(strlen($this->p->lot) === 2) { 
                $lot = '00'.$this->p->lot;
            }

            if(strlen($this->p->lot) === 3) { 
                $lot = '0'.$this->p->lot;
            }

            $d = json_decode($client->get('https://data.cityofnewyork.us/resource/gszd-efwt.json?violation_location_block_no='.$block.'&violation_location_lot_no='.$lot)->getBody()->getContents());
            if(!is_null($d)){ 
                foreach($d as $o){ 
                    $new = new OATHCase; 
                    $new_ext = new OATHCase2; 
                    $new->property_id = $this->p->id; 
                    if (!empty($o->ticket_number)) { 
                        $new->ticket_number = $o->ticket_number; 
                    }

                    if (!empty($o->violation_date)) { 
                        $new->violation_date = $o->violation_date; 
                    }

                    if (!empty($o->violation_time)) { 
                        $new->violation_time = $o->violation_time; 
                    }

                    if (!empty($o->issuing_agency)) { 
                        $new->issuing_agency = $o->issuing_agency; 
                    }

                    if (!empty($o->respondent_first_name)) { 
                        $new->respondent_first_name = $o->respondent_first_name; 
                    }

                    if (!empty($o->respondent_last_name)) { 
                        $new->respondent_last_name = $o->respondent_last_name;  
                    }

                    if (!empty($o->balance_due)) { 
                        $new->balance_due = $o->balance_due; 
                    }

                    if (!empty($o->violation_location_borough)) { 
                        $new->violation_location_borough = $o->violation_location_borough; 
                    }

                    if (!empty($o->violation_location_block_no)) { 
                        $new->violation_location_block_no = $o->violation_location_block_no; 
                    }

                    if (!empty($o->violation_location_lot_no)) { 
                        $new->violation_location_lot_no = $o->violation_location_lot_no; 
                    }

                    if (!empty($o->violation_location_house)) { 
                        $new->violation_location_house = $o->violation_location_house; 
                    }

                    if (!empty($o->violation_location_street_name)) { 
                        $new->violation_location_street_name = $o->violation_location_street_name; 
                    }

                    if (!empty($o->violation_location_floor)) { 
                        $new->violation_location_floor = $o->violation_location_floor; 
                    }

                    if (!empty($o->violation_location_city)) { 
                        $new->violation_location_city = $o->violation_location_city; 
                    }

                    if (!empty($o->violation_location_zip_code)) { 
                        $new->violation_location_zip_code = $o->violation_location_zip_code; 
                    }

                    if (!empty($o->violation_location_state_name)) { 
                        $new->violation_location_state_name = $o->violation_location_state_name; 
                    }

                    if (!empty($o->hearing_status)) { 
                        $new->hearing_status = $o->hearing_status; 
                    }

                    if (!empty($o->hearing_result)) { 
                        $new->hearing_result = $o->hearing_result; 
                    }

                    if (!empty($o->scheduled_hearing_location)) { 
                        $new->scheduled_hearing_location = $o->scheduled_hearing_location; 
                    }

                    if (!empty($o->hearing_date)) { 
                        $new->hearing_date = $o->hearing_date; 
                    }

                    if (!empty($o->hearing_time)) { 
                        $new->hearing_time = $o->hearing_time; 
                    }

                    if (!empty($o->decision_location_borough)) { 
                        $new->decision_location_borough = $o->decision_location_borough; 
                    }

                    if (!empty($o->decision_date)) { 
                        $new->decision_date = $o->decision_date; 
                    }

                    if (!empty($o->total_violation_amount)) { 
                        $new->total_violation_amount = $o->total_violation_amount; 
                    }

                    if (!empty($o->violation_details)) { 
                        $new->violation_details = $o->violation_details; 
                    }

                    if (!empty($o->date_judgement_docketed)) { 
                        $new->date_judgement_docketed = $o->date_judgement_docketed; 
                    }

                    if (!empty($o->respondent_address_or_facility_number_for_fdny_and_dob_tickets)) { 
                        $new->respondent_address_or_facility_number_for_fdny_and_dob_tickets = $o->respondent_address_or_facility_number_for_fdny_and_dob_tickets;  
                    }

                    if (!empty($o->penalty_imposed)) { 
                        $new->penalty_imposed = $o->penalty_imposed; 
                    }

                    if (!empty($o->paid_amount)) { 
                        $new->paid_amount = $o->paid_amount; 
                    }

                    if (!empty($o->additional_penalties_late_fees)) { 
                        $new->additional_penalties_late_fees = $o->additional_penalties_late_fees; 
                    }

                    if (!empty($o->compliance_status)) { 
                        $new->compliance_status = $o->compliance_status; 
                    }

                    if (!empty($o->violation_description)) { 
                        $new->violation_description = $o->violation_description; 
                    }

                    $new->save();

                    if (!empty($new->id)) { 
                        $new_ext->oath_case_id = $new->id; 
                    }

                    if (!empty($o->charge_1_code)) { 
                        $new_ext->charge_1_code = $o->charge_1_code; 
                    }

                    if (!empty($o->charge_1_code_section)) { 
                        $new_ext->charge_1_code_section = $o->charge_1_code_section; 
                    }

                    if (!empty($o->charge_1_code_description)) { 
                        $new_ext->charge_1_code_description = $o->charge_1_code_description; 
                    }

                    if (!empty($o->charge_1_infraction_amount)) { 
                        $new_ext->charge_1_infraction_amount = $o->charge_1_infraction_amount; 
                    }

                    if (!empty($o->charge_2_code)) { 
                        $new_ext->charge_2_code = $o->charge_2_code; 
                    }

                    if (!empty($o->charge_2_code_section)) { 
                        $new_ext->charge_2_code_section = $o->charge_2_code_section; 
                    }

                    if (!empty($o->charge_2_code_description)) { 
                        $new_ext->charge_2_code_description = $o->charge_2_code_description; 
                    }

                    if (!empty($o->charge_2_infraction_amount)) { 
                        $new_ext->charge_2_infraction_amount = $o->charge_2_infraction_amount; 
                    }

                    if (!empty($o->charge_3_code)) { 
                        $new_ext->charge_3_code = $o->charge_3_code; 
                    }

                    if (!empty($o->charge_3_code_section)) { 
                        $new_ext->charge_3_code_section = $o->charge_3_code_section; 
                    }

                    if (!empty($o->charge_3_code_description)) { 
                        $new_ext->charge_3_code_description = $o->charge_3_code_description; 
                    }

                    if (!empty($o->charge_3_infraction_amount)) { 
                        $new_ext->charge_3_infraction_amount = $o->charge_3_infraction_amount; 
                    }

                    if (!empty($o->charge_4_code)) { 
                        $new_ext->charge_4_code = $o->charge_4_code; 
                    }

                    if (!empty($o->charge_4_code_section)) { 
                        $new_ext->charge_4_code_section = $o->charge_4_code_section; 
                    }

                    if (!empty($o->charge_4_code_description)) { 
                        $new_ext->charge_4_code_description = $o->charge_4_code_description; 
                    }

                    if (!empty($o->charge_4_infraction_amount)) { 
                        $new_ext->charge_4_infraction_amount = $o->charge_4_infraction_amount; 
                    }

                    if (!empty($o->charge_5_code)) { 
                        $new_ext->charge_5_code = $o->charge_5_code; 
                    }

                    if (!empty($o->charge_5_code_section)) { 
                        $new_ext->charge_5_code_section = $o->charge_5_code_section; 
                    }

                    if (!empty($o->charge_5_code_description)) { 
                        $new_ext->charge_5_code_description = $o->charge_5_code_description; 
                    }

                    if (!empty($o->charge_5_infraction_amount)) { 
                        $new_ext->charge_5_infraction_amount = $o->charge_5_infraction_amount; 
                    }

                    if (!empty($o->charge_6_code)) { 
                        $new_ext->charge_6_code = $o->charge_6_code; 
                    }

                    if (!empty($o->charge_6_code_section)) { 
                        $new_ext->charge_6_code_section = $o->charge_6_code_section; 
                    }

                    if (!empty($o->charge_6_code_description)) { 
                        $new_ext->charge_6_code_description = $o->charge_6_code_description; 
                    }

                    if (!empty($o->charge_6_infraction_amount)) { 
                        $new_ext->charge_6_infraction_amount = $o->charge_6_infraction_amount; 
                    }

                    if (!empty($o->charge_7_code)) { 
                        $new_ext->charge_7_code = $o->charge_7_code; 
                    }

                    if (!empty($o->charge_7_code_section)) { 
                        $new_ext->charge_7_code_section = $o->charge_7_code_section; 
                    }

                    if (!empty($o->charge_7_code_description)) { 
                        $new_ext->charge_7_code_description = $o->charge_7_code_description; 
                    }

                    if (!empty($o->charge_7_infraction_amount)) { 
                        $new_ext->charge_7_infraction_amount = $o->charge_7_infraction_amount; 
                    }

                    if (!empty($o->charge_8_code)) { 
                        $new_ext->charge_8_code = $o->charge_8_code; 
                    }

                    if (!empty($o->charge_8_code_section)) { 
                        $new_ext->charge_8_code_section = $o->charge_8_code_section; 
                    }

                    if (!empty($o->charge_8_code_description)) { 
                        $new_ext->charge_8_code_description = $o->charge_8_code_description; 
                    }

                    if (!empty($o->charge_8_infraction_amount)) { 
                        $new_ext->charge_8_infraction_amount = $o->charge_8_infraction_amount; 
                    }

                    if (!empty($o->charge_9_code)) { 
                        $new_ext->charge_9_code = $o->charge_9_code; 
                    }

                    if (!empty($o->charge_9_code_section)) { 
                        $new_ext->charge_9_code_section = $o->charge_9_code_section; 
                    }

                    if (!empty($o->charge_9_code_description)) { 
                        $new_ext->charge_9_code_description = $o->charge_9_code_description; 
                    }

                    if (!empty($o->charge_9_infraction_amount)) { 
                        $new_ext->charge_9_infraction_amount = $o->charge_9_infraction_amount; 
                    }

                    if (!empty($o->charge_10_code)) { 
                        $new_ext->charge_10_code = $o->charge_10_code; 
                    }

                    if (!empty($o->charge_10_code_section)) { 
                        $new_ext->charge_10_code_section = $o->charge_10_code_section; 
                    }

                    if (!empty($o->charge_10_code_description)) { 
                        $new_ext->charge_10_code_description = $o->charge_10_code_description; 
                    }

                    if (!empty($o->charge_10_infraction_amount)) { 
                        $new_ext->charge_10_infraction_amount = $o->charge_10_infraction_amount; 
                    }

                    $new_ext->save();
                }
            }
        }
    }
}
