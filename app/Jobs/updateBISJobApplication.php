<?php

namespace App\Jobs;
use App\User; 
use App\Property;
use App\Portfolio;
use App\BISJobApplication; 
use App\BISJApplicant;
use App\BISJFilingRepresentative;
use App\Jobs\newBISJobApplicationAlert;
use App\Jobs\fetchBISPermit;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class updateBISJobApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $record; 
    public $timeout = 190;

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
            $new = BISJobApplication::where('id', $this->record->id)->first();
            $d = json_decode($client->post(env('DOB_API').'/job-application-record', [
                'json' => [ 
                    'endpoint' => $new->url
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

            $new->save();
            fetchBISPermit::dispatch($new)->onQueue('BISPermitsQueue');

            // new job application alert for subscribed users 
            if($new->job_status != 'X SIGNED OFF' && $new->job_status != 'U COMPLETED'){ 
                $new->active = true; 
                $new->save();
                $property = Property::find($new->property_id);
                $portfolios = Portfolio::where('property_id', $property->id)->where('init_summary', true)->get();
                foreach($portfolios as $portfolio){ 
                    if($portfolio->init_summary == true){ 
                        $data = [ 
                            'user'            => $user = User::find($portfolio->user_id),
                            'property'        => $property, 
                            'job_application' => $new
                        ];
                        newBISJobApplicationAlert::dispatch($data)->onQueue('BISAlerts');
                    }
                }
            }
        }
    }
}
