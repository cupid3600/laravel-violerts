<?php

namespace App\Jobs;

use App\Property; 
use App\BISComplaint;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class checkBISComplaint implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $new; 
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
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
            $new = BISComplaint::where('id', $this->record->id)->first(); 
            $d = json_decode($client->post(env('DOB_API').'/complaint-record', [ 
                'json' => [ 
                    'endpoint' => $new->url
                ]
            ])->getBody()->getContents());
            if(isset($d->description) && !is_null($d->description)){ 
                $new->description = $d->description;
            }

            if(isset($d->category_code) && !is_null($d->category_code)){
                $new->category_code = $d->category_code; 
            }
            if(isset($d->category_code_description) && !is_null($d->category_code_description)){ 
                $new->category_code_description = $d->category_code_description; 
            }
            if(isset($d->assigned_to) && !is_null($d->assigned_to)){ 
                $new->assigned_to = $d->assigned_to;
            } 
            if(isset($d->received) && !is_null($d->received)){ 
                $new->received = $d->received;
            } 
            if(isset($d->owner) && !is_null($d->owner)){ 
                $new->owner = $d->owner;
            }
            if(isset($d->disposition) && !is_null($d->disposition)){ 
                $new->disposition = $d->disposition;
            }
            if(isset($d->disposition_date) && !is_null($d->disposition_date)){ 
                $new->disposition_date = $d->disposition_date;
            }
            if(isset($d->disposition_description) && !is_null($d->disposition_description)){ 
                $new->disposition_description = $d->disposition_description;
            }
            if(isset($d->too_reference_number) && !is_null($d->too_reference_number)){ 
                $new->too_reference_number = $d->too_reference_number;
            }
            if(isset($d->priority) && !is_null($d->priority)){ 
                $new->priority = $d->priority;
            }
            if(isset($d->last_inspection) && !is_null($d->last_inspection)){ 
                $new->last_inspection = $d->last_inspection;
            }
            if(isset($d->comments) && !is_null($d->comments)){ 
                $new->comments = $d->comments;
            }
            if(isset($d->job_number) && !is_null($d->job_number)){ 
                $new->job_number = $d->job_number;
            }
            if(isset($d->permit_number) && !is_null($d->permit_number)){ 
                $new->permit_number = $d->permit_number;
            }
            if(isset($d->badge_number) && !is_null($d->badge_number)){ 
                $new->badge_number = $d->badge_number;
            }
            if(isset($d->community_board) && !is_null($d->community_board)){
                $new->community_board = $d->community_board; 
            }
            if(isset($d->dob_violation_number) && !is_null($d->dob_violation_number)){ 
                $new->dob_violation_number = $d->dob_violation_number;
            }
            if(isset($d->ecb_violation_number) && !is_null($d->ecb_violation_number)){ 
                $new->ecb_violation_number = $d->ecb_violation_number;
            }
            if(isset($d->prev_dob_violation_number) && !is_null($d->prev_dob_violation_number)){ 
                $new->prev_dob_violation_number = $d->prev_dob_violation_number;
            }
            if(isset($d->prev_ecb_violation_number) && !is_null($d->prev_ecb_violation_number)){ 
                $new->prev_ecb_violation_number = $d->prev_ecb_violation_number;
            }
            if(isset($d->electrical_violation_number) && !is_null($d->electrical_violation_number)){ 
                $new->electrical_violation_number = $d->electrical_violation_number;
            }
            $new->save();
        }
    }
}
