<?php

namespace App\Console\Commands;

use Mail;
use App\User;
use App\Property;
use App\Portfolio;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\BISECBViolation;
use App\Mail\newBISECBViolation;

use Illuminate\Console\Command;

class checkBISECBViolation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:bisecbviolation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check DOB BIS Website for new/updated ECB violations.';

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
                $request = $client->get(env('DOB_API').'/overview?house_number='.$property->house_number.'&street='.$property->street_name.'&borough='.$property->borough); 
                $response = json_decode($request->getBody()->getContents());
                if (!empty($response->ecb_violations_uri)) { 
                    $property->ecb_violations_total = $response->ecb_violations_total; 
                    $property->ecb_violations_open = $response->ecb_violations_open;
                    $property->ecb_violations_uri = $response->ecb_violations_uri; 
                    $property->save();
                }

                if (!empty($property->ecb_violations_uri)) { 
                    $total_amount_ecb_violations = BISECBViolation::where('property_id', $property->id)->get(); 
                    $property->ecb_violations_endpoint = $property->ecb_violations_uri; 
                    $property->save();

                    while ($total_amount_ecb_violations !== $property->ecb_violations_total && $property->ecb_violations_endpoint != '') { 
                        $request = $client->post(env('ECB_VIO_ALERTS').'/property/dob-api/ecb-violations/index', [ 
                            'form_params' => [ 
                                'endpoint' => $property->ecb_violations_endpoint
                            ]
                        ]); 
                        $response = json_decode($request->getBody()->getContents());
                        if (count($response->ecb_violations) > 0) { 
                            foreach ($response->ecb_violations as $ecb_violation) { 
                                $ecb_violation_exist = BISECBViolation::where('property_id', $property->id)->where('ecb_number', $ecb_violation->ecb_number)->get();

                                if (count($ecb_violation_exist) === 0) { 
                                    $new_ecb_violation = BISECBViolation::create([ 
                                        'property_id' => $property->id, 
                                        'ecb_number' => $ecb_violation->ecb_number,
                                        'bvs_status' => $ecb_violation->bvs_status, 
                                        'respondent' => $ecb_violation->respondent, 
                                        'ecb_status' => $ecb_violation->ecb_status, 
                                        'viol_date' => $ecb_violation->viol_date, 
                                        'infraction_codes' => $ecb_violation->infraction_codes, 
                                        'ecb_penalty_due' => $ecb_violation->ecb_penalty_due
                                    ]);


                                    $client = new Client(); 
                                    $request = $client->post(env('ECB_VIO_ALERTS').'/property/dob-api/ecb-violations/record', [ 
                                        'form_params' => [ 
                                            'endpoint' => $new_ecb_violation->uri
                                        ]
                                    ]);
                                    $response = json_decode($request->getBody()->getContents());
                                    if(!is_null($response)){
                                        if(!is_null($response->certification_status)){ 
                                            $new_ecb_violation->certification_status = $response->certification_status;
                                            $new_ecb_violation->save();
                                        } 
                                        
                                        if(!is_null($response->hearing_status)){ 
                                            $new_ecb_violation->hearing_status = $response->hearing_status;
                                            $new_ecb_violation->save();
                                        }

                                        if(!is_null($response->mailing_address)){ 
                                            $new_ecb_violation->mailing_address = $response->mailing_address;
                                            $new_ecb_violation->save();
                                        } 

                                        if(!is_null($response->served_date)){ 
                                            $new_ecb_violation->served_date = $response->served_date;
                                            $new_ecb_violation->save();
                                        }

                                        if(!is_null($response->violation_type)){
                                            $new_ecb_violation->violation_type = $response->violation_type;
                                            $new_ecb_violation->save();
                                        }
                                         
                                        
                                        if(!is_null($response->inspection_unit)){ 
                                            $new_ecb_violation->inspection_unit = $response->inspection_unit;
                                            $new_ecb_violation->save();
                                        } 

                                        if(!is_null($response->remedy)){ 
                                            $new_ecb_violation->remedy = $response->remedy;
                                            $new_ecb_violation->save();
                                        }
                                         
                                        if(!is_null($response->issuing_inspector_id)){ 
                                            $new_ecb_violation->issuing_inspector_id = $response->issuing_inspector_id;
                                            $new_ecb_violation->save();
                                        }

                                        if(!is_null($response->dob_violation_number)){ 
                                            $new_ecb_violation->dob_violation_number = $response->dob_violation_number;
                                            $new_ecb_violation->save();
                                        }

                                        if(!is_null($response->issued_as_aggr_level)){ 
                                            $new_ecb_violation->issued_as_aggr_level = $response->issued_as_aggr_level;
                                            $new_ecb_violation->save();
                                        }

                                        if(!is_null($response->compliance_on)){ 
                                            $new_ecb_violation->compliance_on = $response->compliance_on;
                                            $new_ecb_violation->save();
                                        }
                                        
                                        if(!is_null($response->cert_submission_date)){ 
                                            $new_ecb_violation->cert_submission_date = $response->cert_submission_date;
                                            $new_ecb_violation->save();
                                        }
                                        
                                        if(!is_null($response->scheduled_hearing_date)){ 
                                            $new_ecb_violation->scheduled_hearing_date = $response->scheduled_hearing_date;
                                            $new_ecb_violation->save();
                                        }
                                         
                                        if(!is_null($response->penalty_imposed)){ 
                                            $new_ecb_violation->penalty_imposed = $response->penalty_imposed;
                                            $new_ecb_violation->save();
                                        } 

                                        if(!is_null($response->adjustments)){
                                            $new_ecb_violation->adjustments = $response->adjustments;
                                            $new_ecb_violation->save();
                                        }
                                        
                                        if(!is_null($response->penalty_balance_due)){ 
                                            $new_ecb_violation->penalty_balance_due; 
                                            $new_ecb_violation->save();
                                        }
                                        
                                        if(!is_null($response->amount_paid)){ 
                                            $new_ecb_violation->amount_paid = $response->amount_paid;  
                                            $new_ecb_violation->save();
                                        }
                                    }
                                    
                                    if ($ecb_violation->active == true) { 
                                        $new_ecb_violation->active = true; 
                                        $new_ecb_violation->save();
                                        
                                        foreach ($portfolios as $portfolio) { 
                                            if($portfolio->init_summary == true){
                                                $user = User::find($portfolio->user_id); 
                                                $content = [ 
                                                    'property' => $property, 
                                                    'ecb_violation' => $ecb_violation
                                                ];
                                                Mail::to($user->email)->send(new newBISECBViolation($content));
                                            }
                                        }
                                    }

                                    if (!empty($ecb_violation->ecb_url)) { 
                                        $new_ecb_violation->uri = $ecb_violation->ecb_url; 
                                        $new_ecb_violation->save();
                                    }
                                }
                            }
                        }

                        if (!empty($response->nextpage_url)) { 
                            $property->ecb_violations_endpoint = $response->nextpage_url; 
                            $property->save();
                        }
                        if (empty($response->nextpage_url)) { 
                            $property->ecb_violations_endpoint = ''; 
                            $property->save();
                        }
                        $total_amount_ecb_violations = BISECBViolation::where('property_id', $property->id)->get(); 
                    }
                }
            }
        }
    }
}
