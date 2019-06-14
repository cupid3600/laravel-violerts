<?php

namespace App\Jobs;

use App\User; 
use App\Portfolio;
use App\Property; 
use App\BISComplaint;
use App\Jobs\newBISComplaintAlert;
use App\Jobs\BISComplaintStatusAlert;
use App\Jobs\updateBISComplaint;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class fetchBISComplaint implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $p;
    public $timeout = 120;

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
            if(!is_null($p_update) && isset($p_update->complaints_uri) && isset($p_update->complaints_total) && isset($p_update->complaints_open)){
                $this->p->complaints_uri = $p_update->complaints_uri; 
                $this->p->complaints_endpoint = $p_update->complaints_uri;
                $this->p->complaints_total = $p_update->complaints_total; 
                $this->p->complaints_open = $p_update->complaints_open; 
                $this->p->save();
            }*/
            $this->p->complaints_endpoint = $this->p->complaints_uri; 
            $this->p->save();

            if($this->p->complaints_total > 0){ 
                $count = BISComplaint::where('property_id', $this->p->id)->get()->count();
                while($this->p->complaints_endpoint != ''){
                    $d = json_decode($client->post(env('DOB_API').'/complaint-index', [ 
                        'json' => [ 
                            'endpoint' => $this->p->complaints_endpoint
                        ]
                    ])->getBody()->getContents());
                    if(isset($d->complaints)){ 
                        if(count($d->complaints) > 0){ 
                            foreach($d->complaints as $c){ 
                                $exist = BISComplaint::where('property_id', $this->p->id)->where('complaint_number', $c->complaint_number)->first();
                                if(is_null($exist)){ 
                                    $new = new BISComplaint;
                                    $new->property_id = $this->p->id;
                                    $new->complaint_number = $c->complaint_number; 
                                    $new->url = $c->url; 
                                    $new->address = $c->address; 
                                    $new->date_entered = $c->date_entered; 
                                    $new->category = $c->category; 
                                    $new->inspection_date = $c->inspection_date; 
                                    $new->status = $c->status; 
                                    if($new->status === 'ACT'){ 
                                        $new->active = true;
                                    }
                                    if(isset($c->url)){ 
                                        $d = json_decode($client->post(env('DOB_API').'/complaint-record', [ 
                                            'json' => [ 
                                                'endpoint' => $c->url
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
                                    }
                                    $new->save();

                                    // queue for failed jobs goes here. 
                                    if(empty($new->community_board)){ 
                                        updateBISComplaint::dispatch($new)->onQueue('BISComplaintsQueue');
                                    } else { 
                                        // new complaint alert for subscribed users 
                                        $portfolios = Portfolio::where('property_id', $this->p->id)->where('init_summary', true)->get();
                                        if(count($portfolios) > 0){ 
                                            foreach($portfolios as $portfolio){
                                                $data = [ 
                                                    'user' => User::find($portfolio->user_id),
                                                    'property' => $this->p,
                                                    'complaint' => $new
                                                ];
                                                newBISComplaintAlert::dispatch($data)->onQueue('BISAlerts');
                                            }
                                        }
                                    }



                                    
                                } else { // change in status notification goes here.
                                    if($exist->status != $c->status){ 
                                        // send to email queue 
                                        $exist->status = $c->status;
                                        $exist->save();
                                        $portfolios = Portfolio::where('property_id', $this->p->id)->where('init_summary', true)->get();
                                        if(count($portfolios) > 0){ 
                                            foreach($portfolios as $portfolio){
                                                $data = [ 
                                                    'user' => User::find($portfolio->user_id),
                                                    'property' => $this->p,
                                                    'complaint' => $exist
                                                ];
                                                BISComplaintStatusAlert::dispatch($data)->onQueue('BISAlerts');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if(!is_null($d->nextpage_url)){ 
                            $this->p->complaints_endpoint = $d->nextpage_url;
                        } else { 
                            $this->p->complaints_endpoint = '';
                        }
                        $this->p->save();
                        $count = BISComplaint::where('property_id', $this->p->id)->get()->count();
                    }
                }
            }
        }

    }
}
