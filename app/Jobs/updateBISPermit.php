<?php

namespace App\Jobs;

use App\BISJobApplication; 
use App\BISPermit;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class updateBISPermit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $new;
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
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
            $new = BISPermit::where('id', $this->record->id)->first(); 
            $d = json_decode($client->post(env('DOB_API').'/permit-record', [ 
                'json' => [ 
                    'endpoint' => $new->url
                ]
            ])->getBody()->getContents()); 
            if(isset($d->dob_now_inspection_uri) && !is_null($d->dob_now_inspection_uri)){ $new->dob_now_inspection_uri = $d->dob_now_inspection_uri; }
            if(isset($d->job_number) && !is_null($d->job_number)){ $new->job_number = $d->job_number; }
            if(isset($d->fee) && !is_null($d->fee)){ $new->fee = $d->fee; }
            if(isset($d->issued) && !is_null($d->issued)){ $new->issued = $d->issued; }
            if(isset($d->expires) && !is_null($d->expires)){ $new->expires = $d->expires; }
            if(isset($d->filing_date) && !is_null($d->filing_date)){ $new->filing_date = $d->filing_date; }
            if(isset($d->proposed_job_start) && !is_null($d->proposed_job_start)){ $new->proposed_job_start = $d->proposed_job_start; }
            if(isset($d->work_approved) && !is_null($d->work_approved)){ $new->work_approved = $d->work_approved; }
            if(isset($d->issued_to) && !is_null($d->issued_to)){ $new->issued_to = $d->issued_to; }
            if(isset($d->general_contractor_registered) && !is_null($d->general_contractor_registered)){ $new->general_contractor_registered = $d->general_contractor_registered; }
            if(isset($d->business_name) && !is_null($d->business_name)){ $new->business_name = $d->business_name; }
            if(isset($d->business_address) && !is_null($d->business_address)){ $new->business_address = $d->business_address; }
            if(isset($d->phone) && !is_null($d->phone)){ $new->phone = $d->phone; }
            $new->save();
        }
    }
}
