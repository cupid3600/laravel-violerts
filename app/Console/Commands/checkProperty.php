<?php

namespace App\Console\Commands;

use Mail; 
use App\User; 
use App\Portfolio; 
use App\Property; 
use App\BISComplaint; 
use App\BISDOBViolation; 
use App\BISECBViolation; 
use App\BISJobApplication; 
use App\Jobs\fetchBISComplaint; 
use App\Jobs\fetchBISDOBViolation;
use App\Jobs\fetchBISECBViolation;
use App\Jobs\fetchBISJobApplication;
use App\Jobs\fetchOpenDataComplaint; 
use App\Jobs\fetchOpenDataDOBViolation; 
use App\Jobs\fetchOpenDataECBViolation; 
use App\Jobs\fetchOpenDataJobApplication;
use App\Mail\PropertySummary;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Illuminate\Console\Command;

class checkProperty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:bisproperty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check DOB BIS Website for new/updated property.';

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
        if (!is_null($properties)) { 
            foreach ($properties as $property) { 
                $portfolios = Portfolio::where('property_id', $property->id)->get();
                if (count($portfolios) > 0) { 
                    $client = new Client(); 
                    $d = json_decode($client->get(env('DOB_API').'/overview?house_number='.$property->house_number.'&street='.$property->street_name.'&borough='.$property->borough)->getBody()->getContents());
                    foreach ($portfolios as $portfolio) { 
                        if (!is_null($d->bin)) { 
                            if ($portfolio->init_summary == false) { 
                                $user = User::find($portfolio->user_id);
                                $property = Property::find($portfolio->property_id);
                                $active_complaints = BISComplaint::where('property_id', $property->id)->where('active', true)->get(); 
                                $active_dob_violations = BISDOBViolation::where('property_id', $property->id)->where('active', true)->get(); 
                                $active_ecb_violations = BISECBViolation::where('property_id', $property->id)->where('active', true)->get(); 
                                $active_job_applications = BISJobApplication::where('property_id', $property->id)->where('active', true)->get();

                                $content = [ 
                                    'property'              =>      $property, 
                                    'complaints'            =>      $active_complaints, 
                                    'dob_violations'        =>      $active_dob_violations, 
                                    'ecb_violations'        =>      $active_ecb_violations, 
                                    'job_applications'      =>      $active_job_applications
                                ];

                                // Mail alert goes here
                                Mail::to($user->email)->send(new PropertySummary($content));
                                $portfolio->init_summary = true;
                                $portfolio->save();
                            } else { 
                                // bis complaint
                                if(isset($d->complaint_total) && !is_null($d->complaint_total) && $property->complaint_total != $d->complaint_total){
                                    $property->complaints_uri = $d->complaints_uri; 
                                    $property->complaints_open = $d->complaints_open; 
                                    $property->complaints_total = $d->complaints_total; 
                                    $property->save(); 
                                    // queue dispatch goes here
                                    fetchBISComplaint::dispatch($property)->onQueue('BISComplaintsQueue');
                                } 

                                // bis dob violation 
                                if(isset($d->dob_violations_total) && !is_null($d->dob_violations_total) && $property->dob_violations_total != $d->dob_violations_total){
                                    $property->dob_violations_uri = $d->dob_violations_uri; 
                                    $property->dob_violations_open = $d->dob_violations_open;
                                    $property->dob_violations_total = $d->dob_violations_total;
                                    $property->save(); 
                                    // queue dispatch goes here
                                    fetchBISDOBViolation::dispatch($property)->onQueue('BISDOBViolationsQueue');
                                }

                                // bis ecb violation 
                                if(isset($d->ecb_violation_total) && !is_null($d->ecb_violation_total) && $property->ecb_violation_total != $d->ecb_violation_total){
                                    $property->ecb_violations_uri = $d->ecb_violations_uri; 
                                    $property->ecb_violations_open = $d->ecb_violations_open;
                                    $property->ecb_violations_total = $d->ecb_violations_total;
                                    $property->save(); 
                                    // queue dispatch goes here
                                    fetchBISECBViolation::dispatch($property)->onQueue('BISECBViolationsQueue');

                                }

                                // bis job application
                                if(isset($d->jobs_filings_total) && !is_null($d->jobs_filings_total) && $property->jobs_filings_total != $d->jobs_filings_total){
                                    $property->jobs_filings_uri = $d->jobs_filings_uri;
                                    $property->jobs_filings_total = $d->jobs_filings_total; 
                                    $property->save(); 
                                    // queue dispatch goes here
                                    fetchBISJobApplication::dispatch($property)->onQueue('BISJobApplicationsQueue');

                                }

                            }

                        }



                    }   
                }

            }   
        }
 
    }
}
    