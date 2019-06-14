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

class fetchBISPermit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $job_application;
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($new)
    {
        //
        $this->job_application = $new;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if(!is_null($this->job_application) && !is_null($this->job_application->all_permits_uri)){ 
            $client = new Client();
            $i = json_decode($client->post(env('DOB_API').'/permit-index', [ 
                'json' => [ 
                    'endpoint' => $this->job_application->all_permits_uri
                ]
            ])->getBody()->getContents());
            if(isset($i->permits)){ 
                foreach($i->permits as $permit){ 
                    $new = new BISPermit; 
                    $new->property_id = $this->job_application->property_id;
                    $new->bis_job_application_id = $this->job_application->id;
                    if(isset($permit->number_doc_type) && !is_null($permit->number_doc_type)){ $new->number_doc_type = $permit->number_doc_type; }
                    if(isset($permit->url) && !is_null($permit->url)){ $new->url = $permit->url; }
                    if(isset($permit->history_url) && !is_null($permit->history_url)){ $new->history_url = $permit->history_url; }
                    if(isset($permit->seq_no) && !is_null($permit->seq_no)){ $new->seq_no = $permit->seq_no; }
                    if(isset($permit->first_issue_date) && !is_null($permit->first_issue_date)){ $new->first_issue_date = $permit->first_issue_date; }
                    if(isset($permit->last_issue_date) && !is_null($permit->last_issue_date)){ $new->last_issue_date = $permit->last_issue_date; }
                    if(isset($permit->status) && !is_null($permit->status)){ $new->status = $permit->status; }
                    if(isset($permit->applicant) && !is_null($permit->applicant)){ $new->applicant = $permit->applicant; }
                    if(isset($permit->url) && !is_null($permit->url)){ 
                        $client = new client();
                        $d = json_decode($client->post(env('DOB_API').'/permit-record', [ 
                            'json' => [ 
                                'endpoint' => $permit->url
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
                    }
                    $new->save();
                }
            }
        }
    }
}
