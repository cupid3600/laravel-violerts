<?php

namespace App\Jobs;

use App\User; 
use App\Portfolio;
use App\Property; 
use App\BISDOBViolation;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class updateBISDOBViolation implements ShouldQueue
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
            $new = BISDOBViolation::where('id', $this->record->id)->first(); 
            $res = json_decode($client->post(env('DOB_API').'/dob-violation-record', [ 
                'json' => [ 
                    'endpoint' => $new->url
                ]
            ])->getBody()->getContents());
            if(isset($res->issue_date) && !is_null($res->issue_date)){ 
                $new->issue_date = $res->issue_date;
            }
            if(isset($res->violation_type_code) && !is_null($res->violation_type_code)){ 
                $new->violation_type_code = $res->violation_type_code;
            }
            if(isset($res->violation_type) && !is_null($res->violation_type)){ 
                $new->violation_type = $res->violation_type;
            }
            if(isset($res->ecb_violation_number) && !is_null($res->ecb_violation_number)){ 
                $new->ecb_violation_number = $res->ecb_violation_number;
            }
            if(isset($res->infraction_codes) && !is_null($res->infraction_codes)){ 
                $new->infraction_codes = $res->infraction_codes;
            }
            if(isset($res->description) && !is_null($res->description)){ 
                $new->description = $res->description;
            }
            if(isset($res->violation_category) && !is_null($res->violation_category)){ 
                $new->violation_category = $res->violation_category;
            }
            if(isset($res->device_number) && !is_null($res->device_number)){ 
                $new->device_number = $res->device_number;
            }
            if(isset($res->disposition_code) && !is_null($res->disposition_code)){ 
                $new->disposition_code = $res->disposition_code;
            }
            if(isset($res->disposition_date) && !is_null($res->disposition_date)){ 
                $new->disposition_date = $res->disposition_date;
            }
            if(isset($res->disposition_inspector) && !is_null($res->disposition_inspector)){ 
                $new->disposition_inspector = $res->disposition_inspector;
            }
            if(isset($res->disposition_comments) && !is_null($res->disposition_comments)){ 
                $new->disposition_comments = $res->disposition_comments;
            }

            $new->save();

            // new dob violation alert for subscribed users 
            $property = Property::find($new->property_id);
            $portfolios = Portfolio::where('property_id', $property)->where('init_summary', true)->get();
            if(count($portfolios) > 0){ 
                foreach($portfolios as $portfolio){
                    $data = [
                        'user' => User::find($portfolio->user_id), 
                        'property' => $property,
                        'dob_violation' => $new
                    ];
                    // send to email queue
                    newBISDOBViolationAlert::dispatch($data)->onQueue('BISAlerts');
                }
            }
        }
    }
}
