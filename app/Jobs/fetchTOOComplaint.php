<?php

namespace App\Jobs;

use App\Property;
use App\TOOComplaint; 
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class fetchTOOComplaint implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $p;

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
            $res = json_decode($client->get('https://data.cityofnewyork.us/resource/fhrw-4uyv.json?incident_address='.$this->p->house_number.' '.strtoupper($this->p->street_name))->getBody()->getContents());
            if(!is_null($res)){ 
                foreach($res as $d){
                    $exist = TOOComplaint::where('unique_key', $d->unique_key)->get()->count();
                    if($exist <= 0){ 
                        $new = TOOComplaint::create([ 'property_id' => $this->p->id ]);
                        if(!empty($d->unique_key)){ 
                            $new->unique_key = $d->unique_key;
                        }

                        if(!empty($d->created_date)){ 
                            $new->created_date = $d->created_date;
                        }

                        if(!empty($d->closed_date)){ 
                            $new->closed_date = $d->closed_date;
                        }

                        if(!empty($d->agency)){ 
                            $new->agency = $d->agency;
                        }

                        if(!empty($d->agency_name)){ 
                            $new->agency_name = $d->agency_name;
                        }

                        if(!empty($d->complaint_type)){ 
                            $new->complaint_type = $d->complaint_type;
                        }

                        if(!empty($d->descriptor)){ 
                            $new->descriptor = $d->descriptor;
                        }

                        if(!empty($d->location_type)){ 
                            $new->location_type = $d->location_type;
                        }

                        if(!empty($d->incident_zip)){ 
                            $new->incident_zip = $d->incident_zip;
                        }

                        if(!empty($d->incident_address)){ 
                            $new->incident_address = $d->incident_address;
                        }

                        if(!empty($d->street_name)){ 
                            $new->street_name = $d->street_name;
                        }

                        if(!empty($d->cross_street_1)){ 
                            $new->cross_street_1 = $d->cross_street_1;
                        }

                        if(!empty($d->cross_street_2)){ 
                            $new->cross_street_2 = $d->cross_street_2;
                        }

                        if(!empty($d->intersection_street_1)){ 
                            $new->intersection_street_1 = $d->intersection_street_1;
                        }

                        if(!empty($d->intersection_street_2)){ 
                            $new->intersection_street_2 = $d->intersection_street_2;
                        }

                        if(!empty($d->address_type)){ 
                            $new->address_type = $d->address_type;
                        }

                        if(!empty($d->city)){ 
                            $new->city = $d->city;
                        }

                        if(!empty($d->landmark)){ 
                            $new->landmark = $d->landmark;
                        }

                        if(!empty($d->facility_type)){ 
                            $new->facility_type = $d->facility_type;
                        }

                        if(!empty($d->status)){ 
                            $new->status = $d->status;
                        }

                        if(!empty($d->due_date)){ 
                            $new->due_date = $d->due_date;
                        }

                        if(!empty($d->resolution_description)){ 
                            $new->resolution_description = $d->resolution_description;
                        }

                        if(!empty($d->resolution_action_updated_date)){ 
                            $new->resolution_action_updated_date = $d->resolution_action_updated_date;
                        }

                        if(!empty($d->community_board)){ 
                            $new->community_board = $d->community_board;
                        }

                        if(!empty($d->bbl)){ 
                            $new->bbl = $d->bbl;
                        }

                        if(!empty($d->borough)){ 
                            $new->borough = $d->borough;
                        }

                        if(!empty($d->x_coordinate_state_plane)){ 
                            $new->x_coordinate_state_plane = $d->x_coordinate_state_plane;
                        }

                        if(!empty($d->y_coordinate_state_plane)){ 
                            $new->y_coordinate_state_plane = $d->y_coordinate_state_plane;
                        }

                        if(!empty($d->open_data_channel_type)){ 
                            $new->open_data_channel_type = $d->open_data_channel_type;
                        }

                        if(!empty($d->latitude)){ 
                            $new->latitude = $d->latitude;
                        }

                        if(!empty($d->longitude)){ 
                            $new->longitude = $d->longitude;
                        }

                        $new->save();
                    }
                }
            }
        }
    }
}
