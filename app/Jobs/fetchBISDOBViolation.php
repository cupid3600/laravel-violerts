<?php

namespace App\Jobs;

use App\User;
use App\Portfolio; 
use App\Property; 
use App\BISDOBViolation;
use App\Jobs\updateBISDOBViolation;
use App\Jobs\newBISDOBViolationAlert;
use App\Jobs\BISDOBViolationStatusAlert;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class fetchBISDOBViolation implements ShouldQueue
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
            /*$p_update = json_decode($client->get(env('DOB_API').'/overview?house_number='.$this->p->house_number.'&street='.$this->p->street_name.'&borough='.$this->p->borough)->getBody()->getContents());
            if(!is_null($p_update) && isset($p_update->dob_violations_uri) && isset($p_update->dob_violations_total) && isset($p_update->dob_violations_open)){ 
                $this->p->dob_violations_uri = $p_update->dob_violations_uri; 
                $this->p->dob_violations_endpoint = $p_update->dob_violations_uri;
                $this->p->dob_violations_total = $p_update->dob_violations_total; 
                $this->p->dob_violations_open = $p_update->dob_violations_open; 
                $this->p->save();
            }*/

            $this->p->dob_violations_endpoint = $this->p->dob_violations_uri; 
            $this->p->save();


            if($this->p->dob_violations_total > 0){ 
                $count = BISDOBViolation::where('property_id', $this->p->id)->get()->count(); 
                while($this->p->dob_violations_endpoint != ''){
                    $d = json_decode($client->post(env('DOB_API').'/dob-violation-index', [ 
                        'json' => [ 
                            'endpoint' => $this->p->dob_violations_endpoint
                        ]
                    ])->getBody()->getContents());
                    if(isset($d->dob_violations)){ 
                        if(count($d->dob_violations) > 0){ 
                            foreach($d->dob_violations as $dob){ 
                                $exist = BISDOBViolation::where('property_id', $this->p->id)->where('dob_violation_number', $dob->dob_violation_number)->first();
                                if(is_null($exist)){ 
                                    $new = new BISDOBViolation; 
                                    $new->property_id = $this->p->id; 
                                    $new->dob_violation_number = $dob->dob_violation_number; 
                                    if(isset($dob->url)){ 
                                        $new->url = $dob->url;
                                    }
                                    $new->type = $dob->type; 
                                    $new->status = $dob->status;
                                    if($new->status === 'ACTIVE'){ 
                                        $new->active = true;
                                    } 
                                    $new->file_date = $dob->file_date; 
                                    if(isset($dob->url)){ 
                                        if(!is_null($dob->url)){ 
                                            $res = json_decode($client->post(env('DOB_API').'/dob-violation-record', [ 
                                                'json' => [ 
                                                    'endpoint' => $dob->url
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
                                        }
                                    }
                                    $new->save();

                                    if(empty($res->violation_type)){ 
                                        updateBISDOBViolation::dispatch($new)->onQueue('BISDOBViolationsQueue');
                                    } else { 
                                        // new dob violation alert for subscribed users 
                                        $portfolios = Portfolio::where('property_id', $this->p->id)->where('init_summary', true)->get();
                                        if(count($portfolios) > 0){ 
                                            foreach($portfolios as $portfolio){
                                                $data = [
                                                    'user' => User::find($portfolio->user_id), 
                                                    'property' => $this->p,
                                                    'dob_violation' => $new
                                                ];
                                                // send to email queue
                                                newBISDOBViolationAlert::dispatch($data)->onQueue('BISAlerts');
                                            }
                                        }
                                    }

                                    
                                } else { 
                                    if($exist->status != $dob->status){ 
                                        // send to email queue 
                                        $exist->status = $dob->status;
                                        $exist->save();
                                        $portfolios = Portfolio::where('property_id', $this->p->id)->where('init_summary', true)->get();
                                        if(count($portfolios) > 0){ 
                                            foreach($portfolios as $portfolio){
                                                $data = [
                                                    'user' => User::find($portfolio->user_id), 
                                                    'property' => $this->p,
                                                    'dob_violation' => $exist
                                                ];
                                                // send to email queue
                                                BISDOBViolationStatusAlert::dispatch($data)->onQueue('BISAlerts');
                                            }
                                        }
                                        
                                    }
                                }
                            }
                        }

                        if(!is_null($d->nextpage_url)){ 
                            $this->p->dob_violations_endpoint = $d->nextpage_url;
                        } else { 
                            $this->p->dob_violations_endpoint = '';
                        }

                        $this->p->save();
                        $count = BISDOBViolation::where('property_id', $this->p->id)->get()->count(); 
                    }
                }
            }
        }
    }
}
