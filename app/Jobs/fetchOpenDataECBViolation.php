<?php

namespace App\Jobs;

use App\Property; 
use App\ECBViolation; 
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class fetchOpenDataECBViolation implements ShouldQueue
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
            $d = json_decode($client->get('https://data.cityofnewyork.us/resource/gq3f-5jm8.json?bin='.$this->p->bin)->getBody()->getContents());
            if(!is_null($d)){ 
                foreach($d as $e){ 
                    $new = new ECBViolation;
                    $new->property_id = $this->p->id; 
                    if (!empty($e->isn_doc_bis_extract)) { 
                        $new->isn_doc_bis_extract = $e->isn_doc_bis_extract; 
                    }

                    if (!empty($e->ecb_violation_number)) { 
                        $new->ecb_violation_number = $e->ecb_violation_number; 
                    }

                    if (!empty($e->ecb_violation_status)) { 
                        $new->ecb_violation_status = $e->ecb_violation_status; 
                    }

                    if (!empty($e->ecb_dob_violation_number)) { 
                        $new->ecb_dob_violation_number = $e->ecb_dob_violation_number; 
                    }

                    if (!empty($e->bin)) { 
                        $new->bin = $e->bin; 
                    }

                    if (!empty($e->bin)) { 
                        $new->bin = $e->bin; 
                    }

                    if (!empty($e->lot)) { 
                        $new->lot = $e->lot; 
                    }

                    if (!empty($e->hearing_date)) { 
                        $new->hearing_date = $e->hearing_date; 
                    }

                    if (!empty($e->hearing_time)) { 
                        $new->hearing_time = $e->hearing_time; 
                    }

                    if (!empty($e->served_date)) { 
                        $new->served_date = $e->served_date; 
                    }

                    if (!empty($e->issue_date)) { 
                        $new->issue_date = $e->issue_date; 
                    }

                    if (!empty($e->severity)) { 
                        $new->severity = $e->severity; 
                    }

                    if (!empty($e->violation_type)) { 
                        $new->violation_type = $e->violation_type; 
                    }

                    if (!empty($e->respondent_name)) { 
                        $new->respondent_name = $e->respondent_name; 
                    }

                    if (!empty($e->respondent_house_number)) { 
                        $new->respondent_house_number = $e->respondent_house_number; 
                    }

                    if (!empty($e->respondent_street)) { 
                        $new->respondent_street = $e->respondent_street; 
                    }

                    if (!empty($e->respondent_city)) { 
                        $new->respondent_city = $e->respondent_city; 
                    }

                    if (!empty($e->respondent_zip)) { 
                        $new->respondent_zip = $e->respondent_zip; 
                    }

                    if (!empty($e->violation_description)) { 
                        $new->violation_description = $e->violation_description; 
                    }

                    if (!empty($e->penality_imposed)) { 
                        $new->penality_imposed = $e->penality_imposed; 
                    }

                    if (!empty($e->amount_paid)) { 
                        $new->amount_paid = $e->amount_paid; 
                    }

                    if (!empty($e->balance_due)) { 
                        $new->balance_due = $e->balance_due; 
                    }

                    if (!empty($e->infraction_code1)) { 
                        $new->infraction_code1 = $e->infraction_code1; 
                    }

                    if (!empty($e->section_law_description1)) { 
                        $new->section_law_description1 = $e->section_law_description1; 
                    }

                    if (!empty($e->infraction_code2)) { 
                        $new->infraction_code2 = $e->infraction_code2; 
                    }

                    if (!empty($e->section_law_description2)) { 
                        $new->section_law_description2 = $e->section_law_description2; 
                    }

                    if (!empty($e->infraction_code3)) { 
                        $new->infraction_code3 = $e->infraction_code3; 
                    }

                    if (!empty($e->section_law_description3)) { 
                        $new->section_law_description3 = $e->section_law_description3; 
                    }

                    if (!empty($e->infraction_code4)) { 
                        $new->infraction_code4 = $e->infraction_code4; 
                    }

                    if (!empty($e->section_law_description4)) { 
                        $new->section_law_description4 = $e->section_law_description4; 
                    }

                    if (!empty($e->infraction_code5)) { 
                        $new->infraction_code5 = $e->infraction_code5; 
                    }

                    if (!empty($e->section_law_description5)) { 
                        $new->section_law_description5 = $e->section_law_description5; 
                    }

                    if (!empty($e->infraction_code6)) { 
                        $new->infraction_code6 = $e->infraction_code6; 
                    }

                    if (!empty($e->section_law_description6)) { 
                        $new->section_law_description6 = $e->section_law_description6; 
                    }

                    if (!empty($e->infraction_code7)) { 
                        $new->infraction_code7 = $e->infraction_code7; 
                    }

                    if (!empty($e->section_law_description7)) { 
                        $new->section_law_description7 = $e->section_law_description7; 
                    }

                    if (!empty($e->infraction_code8)) { 
                        $new->infraction_code8 = $e->infraction_code8; 
                    }

                    if (!empty($e->section_law_description8)) { 
                        $new->section_law_description8 = $e->section_law_description8; 
                    }

                    if (!empty($e->infraction_code9)) { 
                        $new->infraction_code9 = $e->infraction_code9; 
                    }

                    if (!empty($e->section_law_description9)) { 
                        $new->section_law_description9 = $e->section_law_description9; 
                    }

                    if (!empty($e->infraction_code10)) { 
                        $new->infraction_code10 = $e->infraction_code10; 
                    }

                    if (!empty($e->section_law_description10)) { 
                        $new->section_law_description10 = $e->section_law_description10; 
                    }

                    if (!empty($e->aggravated_level)) { 
                        $new->aggravated_level = $e->aggravated_level; 
                    }

                    if (!empty($e->hearing_status)) { 
                        $new->hearing_status = $e->hearing_status; 
                    }

                    if (!empty($e->certification_status)) { 
                        $new->certification_status = $e->certification_status; 
                    }
                    $new->save();
                }
            }
        }
    }
}
