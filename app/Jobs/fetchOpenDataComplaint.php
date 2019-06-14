<?php

namespace App\Jobs;

use App\Portfolio;
use App\Property;
use App\Complaint;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class fetchOpenDataComplaint implements ShouldQueue
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
            $res = json_decode($client->get('https://data.cityofnewyork.us/resource/muk7-ct23.json?bin='.$this->p->bin)->getBody()->getContents());
            if(!is_null($res)){ 
                foreach($res as $d){ 
                    $exist = Complaint::where('property_id', $this->p->id)->where('complaint_number', $d->complaint_number)->first();
                    if(is_null($exist)){ 
                        $c = new Complaint;
                        $c->property_id = $this->p->id; 

                        if (!empty($d->complaint_number)) { 
                            $c->complaint_number = $d->complaint_number;
                        }

                        if (!empty($d->status)) { 
                            $c->status = $d->status;
                        }

                        if (!empty($d->date_entered)) { 
                            $c->date_entered = $d->date_entered;
                        }

                        if (!empty($d->house_number)) { 
                            $c->house_number = $d->house_number;
                        }

                        if (!empty($d->zip_code)) { 
                            $c->zip_code = $d->zip_code;
                        }

                        if (!empty($d->house_street)) { 
                            $c->house_street = $d->house_street;
                        }

                        if (!empty($d->bin)) { 
                            $c->bin = $d->bin;
                        }

                        if (!empty($d->community_board)) { 
                            $c->community_board = $d->community_board;
                        }

                        if (!empty($d->special_district)) { 
                            $c->special_district = $d->special_district;
                        }

                        if (!empty($d->complaint_category)) { 
                            $c->complaint_category = $d->complaint_category;
                        }

                        if (!empty($d->unit)) { 
                            $c->unit = $d->unit;
                        }

                        if (!empty($d->disposition_date)) { 
                            $c->disposition_date = $d->disposition_date;
                        }

                        if (!empty($d->disposition_code)) { 
                            $c->disposition_code = $d->disposition_code;
                        }

                        if (!empty($d->inspection_date)) { 
                            $c->inspection_date = $d->inspection_date;
                        }

                        if (!empty($d->dobrundate)) { 
                            $c->dobrundate = $d->dobrundate;
                        }
                        $c->save();
                    }

                    if(!is_null($exist)){
                        if($exist->status != $d->status){ 
                            // add notification script here.
                            $exist->status = $d->status;
                            $exist->save();
                        }
                    }
                }
            }
        }
    }
}
