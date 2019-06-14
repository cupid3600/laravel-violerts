<?php

namespace App\Jobs;

use App\Property; 
use App\DOBViolation;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class fetchOpenDataDOBViolation implements ShouldQueue
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
            $res = json_decode($client->get('https://data.cityofnewyork.us/resource/dvnq-fhaa.json?bin='.$this->p->bin)->getBody()->getContents());
            if(!is_null($res)){ 
                foreach($res as $d){ 
                    $exist = DOBViolation::where('property_id', $this->p->property_id)->where('violation_number', $d->violation_number)->first();
                    if(is_null($exist)){ 
                        $new = new DOBViolation;
                        $new->property_id = $this->p->id;
                        if (!empty($d->isn_dob_bis_viol)) { 
                            $new->isn_dob_bis_viol = $d->isn_dob_bis_viol;
                        }

                        if (!empty($d->boro)) { 
                            $new->boro = $d->boro;  
                        }

                        if (!empty($d->bin)) { 
                            $new->bin = $d->bin;  
                        }
                        
                        if (!empty($d->block)) { 
                            $new->block = $d->block;
                        } 

                        if (!empty($d->lot)) { 
                            $new->lot = $d->lot;
                        }
                        
                        if (!empty($d->issue_date)) { 
                            $new->issue_date = $d->issue_date;
                        }

                        if (!empty($d->violation_type_code)) { 
                            $new->violation_type_code = $d->violation_type_code; 
                        }
                        
                        if (!empty($d->violation_number)) { 
                            $new->violation_number = $d->violation_number;
                        }
                        
                        if (!empty($d->house_number)) { 
                            $new->house_number = $d->house_number;
                        }
                        
                        if (!empty($d->street)) { 
                            $new->street = $d->street;
                        }
                        
                        if (!empty($d->disposition_date)) { 
                            $new->disposition_date = $d->disposition_date;
                        }
                        
                        if (!empty($d->disposition_comments)) { 
                            $new->disposition_comments = $d->disposition_comments;
                        }

                        if (!empty($d->device_number)) { 
                            $new->device_number = $d->device_number;
                        }

                        if (!empty($d->description)) { 
                            $new->description = $d->description;
                        }
                        
                        if (!empty($d->ecb_number)) { 
                            $new->ecb_number = $d->ecb_number;
                        }
                        
                        if (!empty($d->number)) { 
                            $new->number = $d->number;
                        }
                        
                        if (!empty($d->violation_category)) { 
                            $new->violation_category = $d->violation_category;
                        }
                        
                        if (!empty($d->violation_type)) { 
                            $new->violation_type = $d->violation_type;
                        }
                        $new->save();
                    }
                }
            }
        }
    }
}
