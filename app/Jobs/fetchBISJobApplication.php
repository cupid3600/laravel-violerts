<?php

namespace App\Jobs;

use App\User; 
use App\Portfolio;
use App\Property; 
use App\BISJobApplication;
use App\BISJApplicant;
use App\BISJFilingRepresentative;
use App\Jobs\updateBISJobApplication;
use App\Jobs\fetchBISPermit;
use App\Jobs\newBISJobApplicationAlert;
use App\Jobs\BISJobApplicationStatusAlert;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class fetchBISJobApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $p; 
    public $timeout = 190;

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
            /*$p_update = json_decode($client->get(env('DOB_API').'/overview?house_number='.$this->p->house_number.'&street='.$this->p->street_name.'&borough='.$this->p->borough)->getBody()->getContents());
            if(!is_null($p_update) && isset($p_update->jobs_filings_uri) && isset($p_update->jobs_filings_total)){ 
                $this->p->jobs_filings_uri = $p_update->jobs_filings_uri;
                $this->p->jobs_filings_endpoint = $p_update->jobs_filings_uri;
                $this->p->jobs_filings_total = $p_update->jobs_filings_total;
                $this->p->save();
            }*/
            $this->p->jobs_filings_endpoint = $this->p->jobs_filings_uri; 
            $this->p->save(); 

            if($this->p->jobs_filings_total > 0){ 
                $count = BISJobApplication::where('property_id', $this->p->id)->get()->count();
                while($this->p->jobs_filings_endpoint != ''){ 
                    $d = json_decode($client->post(env('DOB_API').'/job-application-index', [ 
                        'json' => [ 
                            'endpoint' => $this->p->jobs_filings_endpoint
                        ]
                    ])->getBody()->getContents());
                    if(isset($d->job_applications)){ 
                        if(count($d->job_applications) > 0){ 
                            foreach($d->job_applications as $j){ 
                                $exist = BISJobApplication::where('job_number', $j->job_number)->where('doc_number', $j->doc_number)->where('job_type', $j->job_type)->first();
                                if(is_null($exist)){ 
                                    $new = new BISJobApplication;
                                    $new->property_id = $this->p->id; 
                                    $new->file_date = $j->file_date; 
                                    $new->job_number = $j->job_number; 
                                    if(isset($j->url)){ 
                                        $new->url = $j->url;
                                    }
                                    $new->doc_number = $j->doc_number;
                                    $new->job_type = $j->job_type;
                                    $new->job_status = $j->job_status;
                                    $new->status_date = $j->status_date; 
                                    $new->lic_number = $j->lic_number; 
                                    $new->applicant = $j->applicant;
                                    $new->in_audit = $j->in_audit;
                                    $new->zoning_approval = $j->zoning_approval;
                                    if(isset($j->url)){     
                                        $d = json_decode($client->post(env('DOB_API').'/job-application-record', [
                                            'json' => [ 
                                                'endpoint' => $j->url
                                            ]
                                        ])->getBody()->getContents());
                                        if(isset($d->doc_overview_uri)){ 
                                            $new->doc_overview_uri = $d->doc_overview_uri;
                                        }
                                        if(isset($d->fees_paid_uri)){ 
                                            $new->fees_paid_uri = $d->fees_paid_uri;
                                        }
                                        if(isset($d->crane_information_uri)){ 
                                            $new->crane_information_uri = $d->crane_information_uri;
                                        }
                                        if(isset($d->after_hours_variance_permit_uri)){ 
                                            $new->after_hours_variance_permit_uri = $d->after_hours_variance_permit_uri;
                                        }
                                        if(isset($d->items_required_uri)){ 
                                            $new->items_required_uri = $d->items_required_uri;
                                        }
                                        if(isset($d->forms_received_uri)){ 
                                            $new->forms_received_uri = $d->forms_received_uri;
                                        }
                                        if(isset($d->plan_examination_uri)){ 
                                            $new->plan_examination_uri = $d->plan_examination_uri;
                                        }
                                        if(isset($d->virtual_job_folder_uri)){ 
                                            $new->virtual_job_folder_uri = $d->virtual_job_folder_uri;
                                        }
                                        if(isset($d->all_permits_uri)){ 
                                            $new->all_permits_uri = $d->all_permits_uri;
                                        }
                                        if(isset($d->all_comments_uri)){ 
                                            $new->all_comments_uri = $d->all_comments_uri;
                                        }
                                        if(isset($d->schedule_b_uri)){ 
                                            $new->schedule_b_uri = $d->schedule_b_uri;
                                        }
                                        if(isset($d->plumbing_inspections_uri)){ 
                                            $new->plumbing_inspections_uri = $d->plumbing_inspections_uri;
                                        }
                                        if(isset($d->dob_now_inpsections_uri)){ 
                                            $new->dob_now_inpsections_uri = $d->dob_now_inpsections_uri;
                                        }
                                        if(isset($d->print_letter_of_completion_uri)){ 
                                            $new->print_letter_of_completion_uri = $d->print_letter_of_completion_uri;
                                        }
                                        if(isset($d->last_action)){ 
                                            $new->last_action = $d->last_action;
                                        }
                                        if(isset($d->application_approved_on)){ 
                                            $new->application_approved_on = $d->application_approved_on;
                                        }
                                        if(isset($d->pre_filed_date)){ 
                                            $new->pre_filed_date = $d->pre_filed_date;
                                        }
                                        if(isset($d->building_type)){ 
                                            $new->building_type = $d->building_type;
                                        }
                                        if(isset($d->estimated_total_cost)){ 
                                            $new->estimated_total_cost = $d->estimated_total_cost;
                                        }
                                        if(isset($d->date_filed)){ 
                                            $new->date_filed = $d->date_filed;
                                        }
                                        if(isset($d->electronically_filed)){ 
                                            $new->electronically_filed = $d->electronically_filed;
                                        }
                                        if(isset($d->fee_structure)){ 
                                            $new->fee_structure = $d->fee_structure;
                                        }
                                        if(isset($d->review_is_requested_bldg_code)){ 
                                            $new->review_is_requested_bldg_code = $d->review_is_requested_bldg_code;
                                        }
                                        if(isset($d->house_number)){ 
                                            $new->house_number = $d->house_number;
                                        }
                                        if(isset($d->street_name)){ 
                                            $new->street_name = $d->street_name;
                                        }
                                        if(isset($d->borough)){ 
                                            $new->borough = $d->borough;
                                        }
                                        if(isset($d->block)){ 
                                            $new->block = $d->block;
                                        }
                                        if(isset($d->lot)){ 
                                            $new->lot = $d->lot;
                                        }
                                        if(isset($d->bin)){ 
                                            $new->bin = $d->bin;
                                        }
                                        if(isset($d->cb_number)){ 
                                            $new->cb_number = $d->cb_number;
                                        }
                                        if(isset($d->work_on_floors)){ 
                                            $new->work_on_floors = $d->work_on_floors;
                                        }
                                        if(isset($d->apt_condo_number)){ 
                                            $new->apt_condo_number = $d->apt_condo_number;
                                        }
                                        if(isset($d->zipcode)){ 
                                            $new->zipcode = $d->zipcode;
                                        }
                                        if(isset($d->plans_page_count)){ 
                                            $new->plans_page_count = $d->plans_page_count;
                                        }
                                        if(isset($d->job_description->description)){ 
                                            // create condition to identify when job application doesn't have a description.
                                            $new->job_description = $d->job_description->description;
                                        } else {
                                            $new->job_description = '';
                                        }

                                        // applicant data 
                                        if(isset($d->applicant->name)){ 
                                            // check if applicant already exist using name and license_number
                                            $applicant_exist = BISJApplicant::where('name', $d->applicant->name)->where('license_number', $d->applicant->license_number)->first();
                                            if(is_null($applicant_exist)){ 
                                                $new_applicant = new BISJApplicant;
                                                if(isset($d->applicant->name) && !is_null($d->applicant->name)){ 
                                                    $new_applicant->name = $d->applicant->name;
                                                }
                                                if(isset($d->applicant->business_name) && !is_null($d->applicant->business_name)){ 
                                                    $new_applicant->business_name = $d->applicant->business_name;
                                                }
                                                if(isset($d->applicant->business_phone) && !is_null($d->applicant->business_phone)){ 
                                                    $new_applicant->business_phone = $d->applicant->business_phone;
                                                }
                                                if(isset($d->applicant->business_address) && !is_null($d->applicant->business_address)){ 
                                                    $new_applicant->business_address = $d->applicant->business_address;
                                                }
                                                if(isset($d->applicant->business_fax) && !is_null($d->applicant->business_fax)){ 
                                                    $new_applicant->business_fax = $d->applicant->business_fax;
                                                }
                                                if(isset($d->applicant->email) && !is_null($d->applicant->email)){ 
                                                    $new_applicant->email = $d->applicant->email;
                                                }
                                                if(isset($d->applicant->mobile_phone) && !is_null($d->applicant->mobile_phone)){ 
                                                    $new_applicant->mobile_phone = $d->applicant->mobile_phone;
                                                }
                                                if(isset($d->applicant->license_number) && !is_null($d->applicant->license_number)){ 
                                                    $new_applicant->license_number = $d->applicant->license_number;
                                                }
                                                if(isset($d->applicant->applicant_type) && !is_null($d->applicant->applicant_type)){ 
                                                    $new_applicant->applicant_type = $d->applicant->applicant_type;
                                                }
                                                $new_applicant->save();
                                                $new->bis_j_applicant_id = $new_applicant->id;
                                                $new->save();
                                            } else { 
                                                $new->bis_j_applicant_id = $applicant_exist->id;
                                                $new->save();
                                            }
                                        }

                                        // filing representative data 
                                        if(isset($d->filing_representative)){ 
                                            $filing_rep_exist = BISJFilingRepresentative::where('name', $d->filing_representative->name)->where('registration_number', $d->filing_representative->registration_number)->first();
                                            if(is_null($filing_rep_exist)){ 
                                                $new_filing_rep = new BISJFilingRepresentative;
                                                if(isset($d->filing_representative->name) && !is_null($d->filing_representative->name)){ 
                                                    $new_filing_rep->name = $d->filing_representative->name; 
                                                }
                                                if(isset($d->filing_representative->business_name) && !is_null($d->filing_representative->business_name)){ 
                                                    $new_filing_rep->business_name = $d->filing_representative->business_name; 
                                                }
                                                if(isset($d->filing_representative->business_phone) && !is_null($d->filing_representative->business_phone)){ 
                                                    $new_filing_rep->business_phone = $d->filing_representative->business_phone; 
                                                }
                                                if(isset($d->filing_representative->business_address) && !is_null($d->filing_representative->business_address)){ 
                                                    $new_filing_rep->business_address = $d->filing_representative->business_address; 
                                                }
                                                if(isset($d->filing_representative->business_fax) && !is_null($d->filing_representative->business_fax)){ 
                                                    $new_filing_rep->business_fax = $d->filing_representative->business_fax; 
                                                }
                                                if(isset($d->filing_representative->email) && !is_null($d->filing_representative->email)){ 
                                                    $new_filing_rep->email = $d->filing_representative->email; 
                                                }
                                                if(isset($d->filing_representative->mobile_phone) && !is_null($d->filing_representative->mobile_phone)){ 
                                                    $new_filing_rep->mobile_phone = $d->filing_representative->mobile_phone; 
                                                }
                                                if(isset($d->filing_representative->registration_number) && !is_null($d->filing_representative->registration_number)){ 
                                                    $new_filing_rep->registration_number = $d->filing_representative->registration_number; 
                                                }
                                                if(isset($d->filing_representative->name) && !is_null($d->filing_representative->name)){ 
                                                    $new_filing_rep->save();
                                                    $new->bis_j_filing_representative_id = $new_filing_rep->id; 
                                                    $new->save();
                                                }
                                            } else { 
                                                $new->bis_j_filing_representative_id = $filing_rep_exist->id; 
                                                $new->save();
                                            }
                                        }
                                    }
                                    $new->save();

                                    

                                    if(is_null($new->pre_filed_date) && !is_null($new->url)){ 
                                        updateBISJobApplication::dispatch($new)->onQueue('BISJobApplicationsQueue'); 
                                    } else { 
                                        fetchBISPermit::dispatch($new)->onQueue('BISPermitsQueue');
                                        // new job application alert for subscribed users 
                                        if($new->job_status != 'X SIGNED OFF' && $new->job_status != 'U COMPLETED'){ 
                                            $new->active = true; 
                                            $new->save();
                                            $portfolios = Portfolio::where('property_id', $this->p->id)->where('init_summary', true)->get();
                                            foreach($portfolios as $portfolio){ 
                                                if($portfolio->init_summary == true){ 
                                                    $data = [ 
                                                        'user'            => User::find($portfolio->user_id),
                                                        'property'        => $this->p, 
                                                        'job_application' => $new
                                                    ];
                                                    newBISJobApplicationAlert::dispatch($data)->onQueue('BISAlerts');
                                                }
                                            }
                                        }
                                    }

                                    // prev applicant data

                                    // filing rep data

                                    // additional information data 
                                } else { 
                                    if($exist->job_status != $j->job_status){ 
                                        // add status change here 
                                        $exist->job_status = $j->job_status; 
                                        $exist->save();


                                        // send to email queue
                                         foreach($portfolios as $portfolio){ 
                                            if($portfolio->init_summary == true){ 
                                                $data = [ 
                                                    'user'            => $user = User::find($portfolio->user_id),
                                                    'property'        => $this->p, 
                                                    'job_application' => $exist
                                                ];
                                                BISJobApplicationStatusAlert::dispatch($data)->onQueue('BISAlerts');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if(!is_null($d->nextpage_url)){ 
                        $this->p->jobs_filings_endpoint = $d->nextpage_url;
                        $this->p->save();
                    } else { 
                        $this->p->jobs_filings_endpoint = '';
                        $this->p->save();
                    }
                    
                    $count = BISJobApplication::where('property_id', $this->p->id)->get()->count();
                }
            }
        }
    }
}
