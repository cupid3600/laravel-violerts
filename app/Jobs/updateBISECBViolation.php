<?php

namespace App\Jobs;

use App\User; 
use App\Portfolio;
use App\Property; 
use App\BISECBViolation;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class updateBISECBViolation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $record; 
    public $timeout = 120; 


    public function __construct($new)
    {
        //
        $this->record = $new;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if(!is_null($this->record)){
            $client = new Client();
            $new = BISECBViolation::where('id', $this->record->id)->first();
            $d = json_decode($client->post(env('DOB_API').'/ecb-violation-record', [ 
                'json' => [ 
                    'endpoint' => $new->url
                ]
            ])->getBody()->getContents()); 
            if(isset($d->severity) && !is_null($d->severity)){ 
                $new->severity = $d->severity;
            }
            if(isset($d->certification_status) && !is_null($d->certification_status)){ 
                $new->certification_status = $d->certification_status;
            }
            if(isset($d->penalty_balance_due) && !is_null($d->penalty_balance_due)){ 
                $new->penalty_balance_due = $d->penalty_balance_due;
            }
            if(isset($d->hearing_status) && !is_null($d->hearing_status)){ 
                $new->hearing_status = $d->hearing_status;
            }
            if(isset($d->respondent_name) && !is_null($d->respondent_name)){ 
                $new->respondent_name = $d->respondent_name;
            }
            if(isset($d->respondent_mailing_address) && !is_null($d->respondent_mailing_address)){ 
                $new->respondent_mailing_address = $d->respondent_mailing_address;
            }
            if(isset($d->violation_date) && !is_null($d->violation_date)){ 
                $new->violation_date = $d->violation_date;
            }
            if(isset($d->violation_type) && !is_null($d->violation_type)){ 
                $new->violation_type = $d->violation_type;
            }
            if(isset($d->served_date) && !is_null($d->served_date)){ 
                $new->served_date = $d->served_date;
            }
            if(isset($d->inspection_unit) && !is_null($d->inspection_unit)){ 
                $new->inspection_unit = $d->inspection_unit;
            }
            if(isset($d->device_type) && !is_null($d->device_type)){ 
                $new->device_type = $d->device_type;
            }
            if(isset($d->device_number) && !is_null($d->device_number)){ 
                $new->device_number = $d->device_number;
            }

            if(isset($d->section_of_law) && !is_null($d->section_of_law)){ 
                $new->section_of_law = $d->section_of_law;
            }

            if(isset($d->standard_description) && !is_null($d->standard_description)){ 
                $new->standard_description = $d->standard_description;
            }

            if(isset($d->specific_violation_conditions) && !is_null($d->specific_violation_conditions)){ 
                $new->specific_violation_conditions = $d->specific_violation_conditions;
            }
            if(isset($d->issuing_inspector_id) && !is_null($d->issuing_inspector_id)){ 
                $new->issuing_inspector_id = $d->issuing_inspector_id;
            }
            if(isset($d->dob_violation_number) && !is_null($d->dob_violation_number)){ 
                $new->dob_violation_number = $d->dob_violation_number;
            }
            if(isset($d->issued_as_aggravated_level) && !is_null($d->issued_as_aggravated_level)){ 
                $new->issued_as_aggravated_level = $d->issued_as_aggravated_level;
            }
            if(isset($d->compliance_on) && !is_null($d->compliance_on)){ 
                $new->compliance_on = $d->compliance_on;
            }
            if(isset($d->scheduled_hearing_date) && !is_null($d->scheduled_hearing_date)){ 
                $new->scheduled_hearing_date = $d->scheduled_hearing_date;
            }
            if(isset($d->scheduled_hearing_time) && !is_null($d->scheduled_hearing_time)){ 
                $new->scheduled_hearing_time = $d->scheduled_hearing_time;
            }
            if(isset($d->penalty_imposed) && !is_null($d->penalty_imposed)){ 
                $new->penalty_imposed = $d->penalty_imposed;
            }
            if(isset($d->adjustments) && !is_null($d->adjustments)){ 
                $new->adjustments = $d->adjustments;
            }
            if(isset($d->amount_paid) && !is_null($d->amount_paid)){ 
                $new->amount_paid = $d->amount_paid;
            }
            $new->save();

            // new ecb violation alert for subscribed users 
            $property = Property::find($new->property_id);
            $portfolios = Portfolio::where('property_id', $property->id)->where('init_summary', true)->get();
            if(count($portfolios) > 0){ 
                foreach($portfolios as $portfolio){
                    $data = [
                        'user' => User::find($portfolio->user_id), 
                        'ecb_violation' => $new,
                        'property' => $property
                    ];
                    // send to email queue
                    newBISECBViolationAlert::dispatch($data)->onQueue('BISAlerts');
                }
            }
        }
    }
}
