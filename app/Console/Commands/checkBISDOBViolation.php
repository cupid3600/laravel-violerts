<?php

namespace App\Console\Commands;

use Mail;
use App\User;
use App\Property;
use App\Portfolio;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\BISDOBViolation;
use App\Mail\newBISDOBViolation;

use Illuminate\Console\Command;

class checkBISDOBViolation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:bisdobviolation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check DOB BIS Website for new/updated DOB violations.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $properties = Property::all();

        if (!empty($properties)) { 
            foreach ($properties as $property) { 
                $client = new Client();
                $portfolios = Portfolio::where('property_id', $property->id)->get();
                $request = $client->get(env('DOB_VIO_ALERTS').'/property/'.$property->house_number.'/'.$property->street_name.'/'.$property->borough); 
                $response = json_decode($request->getBody()->getContents());
                if (!empty($response->dob_violations_uri)) { 
                    $property->dob_violations_total = $response->dob_violations_total; 
                    $property->dob_violations_open = $response->dob_violations_open; 
                    $property->dob_violations_uri = $response->dob_violations_uri;
                    $property->save();
                }

                if (!empty($property->dob_violations_uri)) { 
                    $total_amount_dob_violations = BISDOBViolation::where('property_id', $property->id)->get(); 
                    $property->dob_violations_endpoint = $property->dob_violations_uri; 
                    $property->save();
                    while ($total_amount_dob_violations !== $property->dob_violations_total && $property->dob_violations_endpoint != '') { 
                        $request = $client->post(env('DOB_VIO_ALERTS').'/property/dob-api/dob-violations/index', [ 
                            'form_params' => [ 
                                'endpoint' => $property->dob_violations_endpoint
                            ]
                        ]); 
                        $response = json_decode($request->getBody()->getContents());
                        if (count($response->dob_violations) > 0) { 
                            foreach ($response->dob_violations as $dob_violation) { 
                                $dob_violation_exist = BISDOBViolation::where('property_id', $property->id)->where('number', $dob_violation->number)->get();

                                if(count($dob_violation_exist) === 0){ 
                                    $new_dob_violation = BISDOBViolation::create([ 
                                        'property_id' => $property->id, 
                                        'number' => $dob_violation->number, 
                                        'issue_date' => $dob_violation->issue_date, 
                                        'type' => $dob_violation->type
                                    ]);


                                    $client = new Client(); 
                                    $request = $client->post(env('DOB_VIO_ALERTS').'/property/dob-api/dob-violations/record', [ 
                                        'form_params' => [ 
                                            'endpoint' => $new_dob_violation->uri
                                        ]
                                    ]); 
                                    $response = json_decode($request->getBody()->getContents());
                                    if(!is_null($response)){ 
                                        $new_dob_violation->device_number = $response->device_number; 
                                        $new_dob_violation->ecb_number = $response->ecb_number; 
                                        $new_dob_violation->infraction_codes = $response->infraction_codes; 
                                        $new_dob_violation->description = $response->description; 
                                        $new_dob_violation->disposition_code = $response->disposition_code; 
                                        $new_dob_violation->disposition_date = $response->disposition_date;
                                        $new_dob_violation->inspector = $response->inspector; 
                                        $new_dob_violation->comments = $response->comments; 
                                        $new_dob_violation->save();
                                    }

                                    if (!empty($dob_violation->status)) { 
                                        if ($dob_violation->status == true) { 
                                            $new_dob_violation->active = true; 
                                            $new_dob_violation->save();
                                            
                                            foreach ($portfolios as $portfolio) { 
                                                if($portfolio->init_summary == true){ 
                                                    $user = User::find($portfolio->user_id); 
                                                    $content = [ 
                                                        'property' => $property, 
                                                        'dob_violation' => $dob_violation
                                                    ];
                                                    Mail::to($user->email)->send(new newBISDOBViolation($content));
                                                }
                                            }
                                        }
                                    }

                                    if (!empty($dob_violation->url)) { 
                                        $new_dob_violation->uri = $dob_violation->url; 
                                        $new_dob_violation->save(); 
                                    }
                                }   
                            } 
                        }

                        if (!empty($response->nextpage_url)) { 
                            $property->dob_violations_endpoint = $response->nextpage_url;
                            $property->save();
                        }
                        if (empty($response->nextpage_url)) { 
                             $property->dob_violations_endpoint = ''; 
                             $property->save();
                        }
                        $total_amount_dob_violations = BISDOBViolation::where('property_id', $property->id)->get(); 
                    }
                }
            }
        }
    }
}
