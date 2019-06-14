<?php

namespace App\Console\Commands;

use Mail;
use App\User;
use App\Property;
use App\Portfolio;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\BISComplaint;
use App\Mail\newBISComplaint;

use Illuminate\Console\Command;

class checkBISComplaint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:biscomplaint';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check DOB BIS Website for new/updated complaints.';

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
        $client = new Client(); 
        $properties = Property::all();

        if (!empty($properties)) { 
            foreach ($properties as $property) { 
                $client = new Client();
                $portfolios = Portfolio::where('property_id', $property->id)->get();
                $request = $client->get(env('DOB_API').'/overview?house_number='.$property->house_number.'&street='.$property->street_name.'&borough='.$property->borough); 
                $response = json_decode($request->getBody()->getContents());
                if (!empty($response->complaints_uri)) { 
                    $property->complaints_total = $response->complaints_total;
                    $property->complaints_open = $response->complaints_open; 
                    $property->complaints_uri = $response->complaints_uri;
                    $property->save();
                }

                if (!empty($property->complaints_uri)) { 
                    $total_amount_complaints = BISComplaint::where('property_id', $property->id)->get();
                    $property->complaints_endpoint = $property->complaints_uri;
                    $property->save();
                    while ($total_amount_complaints !== $property->complaints_total && $property->complaints_endpoint != '') { 
                        $request = $client->post(env('COMPLAINTS_ALERTS').'/property/dob-api/complaints/index', [ 
                            'form_params' => [ 
                                'endpoint' => $property->complaints_endpoint
                            ]
                        ]);
                        $response = json_decode($request->getBody()->getContents());
                        if (count($response->complaints) > 0) {

                            foreach ($response->complaints as $complaint) { 
                                $complaint_exist = BISComplaint::where('property_id', $property->id)->where('complaint_number', $complaint->id)->get();
                                if (count($complaint_exist) === 0) { 
                                    $new_complaint = BISComplaint::create([ 
                                        'property_id' => $property->id, 
                                        'complaint_number' => $complaint->id, 
                                        'uri' => $complaint->url, 
                                        'address' => $complaint->address, 
                                        'date_entered' => $complaint->date_entered, 
                                        'category' => $complaint->category, 
                                        'disposition' => $complaint->disposition, 
                                        'status' => $complaint->status, 
                                        'description' => $complaint->description
                                    ]);

                                    $client = new Client(); 
                                    $request = $client->post(env('COMPLAINTS_ALERTS').'/property/dob-api/complaints/record', [ 
                                        'form_params' => [ 
                                            'endpoint' => $new_complaint->uri
                                        ]
                                    ]); 
                                    $response = json_decode($request->getBody()->getContents());
                                    if(!is_null($response)){ 
                                        $new_complaint->last_inspection = $response->last_inspection;
                                        $new_complaint->comments = $response->comments; 
                                        $new_complaint->priority = $response->priority; 
                                        $new_complaint->community_board = $response->community_board;
                                        $new_complaint->dob_violation_number = $response->dob_violation_number;
                                        $new_complaint->ecb_violation_number = $response->ecb_violation_number; 
                                        $new_complaint->job_number = $response->job_number; 
                                        $new_complaint->save();
                                    }

                                    if (!empty($new_complaint->inspection_date)) { 
                                        $new_complaint->inspection_date = $complaint->inspection_date;
                                        $new_complaint->save();
                                    }

                                    if ($new_complaint->status === 'ACT') { 
                                        $new_complaint->active = 1; 
                                        $new_complaint->save();

                                        foreach ($portfolios as $portfolio) { 
                                            if($portfolio->init_summary == true){ 
                                                $user = User::find($portfolio->user_id);
                                                $content = [ 
                                                    'property' => $property, 
                                                    'complaint' => $new_complaint, 
                                                ];
                                                Mail::to($user->email)->send(new newBISComplaint($content));
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if (!empty($response->nextpage_url)) { 
                            $property->complaints_endpoint = $response->nextpage_url;
                            $property->save();
                        }
                        if (empty($response->nextpage_url)) { 
                            $property->complaints_endpoint = '';
                            $property->save();
                        }
                        $total_amount_complaints = BISComplaint::where('property_id', $property->id)->get()->count();
                    } 
                }
            }
        }
    }
}
