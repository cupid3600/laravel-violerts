<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Property; 
use App\Portfolio;
use App\Jobs\fetchBISComplaint;
use App\Jobs\fetchTOOComplaint;
use App\Jobs\fetchOpenDataComplaint;
use App\Jobs\fetchOpenDataDOBViolation;
use App\Jobs\fetchBISDOBViolation;
use App\Jobs\fetchOpenDataECBViolation;
use App\Jobs\fetchBISECBViolation;
use App\Jobs\fetchOpenDataJobApplication;
use App\Jobs\fetchBISJobApplication;
use App\Jobs\fetchOATHHearingCase;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    //
	public function property (Request $request, $address)
	{ 
		$property = Property::where('address', $address)->first(); 
		if (is_null($property)) { 
			return response([ 
				'property' => null
			], 200);
		}

		return response([ 
			'property' => $property
		], 200);
	}

	public function mapIndex (Request $request, $bin)
	{ 
		$property = Property::where('bin', $bin)
					 ->with(['complaints'])
					 ->with(['dob_violations'])
					 ->with(['ecb_violations'])
					 ->with(['job_applications'])
					 ->with(['bis_complaints'])
					 ->with(['bis_dob_violations'])
					 ->with(['bis_ecb_violations'])
					 ->with(['bis_job_applications'])
					 ->with(['oath_cases'])
					 ->get();

		if (count($property) === 0) { 
			$client = new Client(); 
			$request = $client->get(env('DOB_BIS_API').'/property/bin/'.$bin); 
			$response = json_decode($request->getBody()->getContents());
			if (!is_null($response)) { 
				$property = Property::create([ 
					'house_number' => $response->house_number, 
	    			'street_name' => $response->street_name, 
	    			'borough' => $response->borough,  
	    			'bin' => $response->bin, 
	    			'block' => $response->block, 
	    			'lot' => $response->lot
				]);
			}
		}
		return response([ 
			'property' => $property
		], 200);
	}

	public function indexCheck (Request $request)
	{ 
		if (!is_null($request->address)) { 
            $property = Property::where('address', $request->address)->first(); 

            if (!is_null($property)) { 
                $user = User::find($request->user_id); 
                if (!is_null($user)) { 
                    $alreadyInPortfolio = Portfolio::where('user_id', $user->id)->where('property_id', $property->id)->get();
                    if(count($alreadyInPortfolio) === 0) { 
                        Portfolio::create([ 
                            'user_id' => $user->id, 
                            'property_id' => $property->id
                        ]);
                    }
                } 
                return response()->json($property);
            }

            if (is_null($property)) { 
                return response()->json('');
            }
        }
	} 

    public function create (Request $request) 
    {
    	$user = User::find($request->user_id);
    	$property = Property::where('house_number', $request->house_number)->where('street_name', $request->street_name)->where('borough', $request->borough)->first();
    	if (is_null($property)) { 
	    	$property = Property::create([
	    		'address' => $request->address,
    			'house_number' => $request->house_number, 
    			'street_name' => $request->street_name, 
    			'bin' => $request->bin, 
    			'block' => $request->block, 
    			'lot' => $request->lot,
    			'borough' => $request->borough, 
    			'coo_uri' => $request->coo_uri, 
    			'cross_streets' => $request->cross_streets, 
    			'complaints_uri' => $request->complaints_uri, 
    			'complaints_total' => $request->complaints_total, 
    			'complaints_open' => $request->complaints_open, 
    			'dob_violations_uri' => $request->dob_violations_uri,
    			'dob_violations_total' => $request->dob_violations_total, 
    			'dob_violations_open' => $request->dob_violations_open, 
    			'ecb_violations_uri' => $request->ecb_violations_uri, 
    			'ecb_violations_total' => $request->ecb_violations_total, 
    			'ecb_violations_open' => $request->ecb_violations_open, 
    			'jobs_filings_uri' => $request->jobs_filings_uri, 
    			'jobs_filings_total' => $request->jobs_filings_total, 
    			'ara_laa_uri' => $request->ara_laa_uri, 
    			'total_jobs' => $request->total_jobs, 
    			'actions_uri' => $request->actions_uri, 
    			'actions_total' => $request->action_total, 
    			'elevator_records_uri' => $request->elevator_records_uri, 
    			'electrical_applications_uri' => $request->electrical_applications_uri, 
    			'permits_in_process_uri' => $request->permits_in_process_uri, 
    			'illuminated_signs_permit_uri' => $request->illuminated_signs_permit_uri, 
    			'dep_boiler_information_uri' => $request->dep_boiler_information_uri, 
    			'crane_information_uri' => $request->crane_information_uri, 
    			'after_hours_permit_uri' => $request->after_hours_permit_uri, 
    			'health_area' => $request->health_area, 
    			'census_tract' => $request->census_tract, 
    			'community_board' => $request->community_board, 
    			'buildings_on_lot' => $request->buildings_on_lot, 
    			'condo' => $request->condo, 
    			'vacant' => $request->vacant, 
    			'zoning_docs_uri' => $request->zoning_docs_uri, 
    			'challenge_results_uri' => $request->challenge_results_uri, 
    			'pre_bis_pa_uri' => $request->pre_bis_pa_uri, 
    			'dob_special_name' => $request->dob_special_name, 
    			'dob_building_remarks' => $request->dob_building_remarks, 
    			'landmark_status' => $request->landmark_status, 
    			'special_status' => $request->special_status, 
    			'local_law' => $request->local_law, 
    			'loft_law' => $request->loft_law, 
    			'sro_restricted' => $request->sro_restricted, 
    			'ta_restricted' => $request->ta_restricted, 
    			'ub_restricted' => $request->ub_restricted, 
    			'environmental_restrictions' => $request->environmental_restrictions, 
    			'grandfathered_sign' => $request->grandfathered_sign, 
    			'legal_adult_use' => $request->legal_adult_use, 
    			'city_owned' => $request->city_owned, 
    			'additional_bins' => $request->additional_bins, 
    			'special_district' => $request->special_district, 
    			'building_classification' => $request->building_classification
    		]);

            fetchTOOComplaint::dispatch($property)->onQueue('TOOComplaintsQueue');
            fetchOpenDataComplaint::dispatch($property)->onQueue('OpenDataComplaintsQueue');
            if(!empty($property->complaints_uri)){ 
                fetchBISComplaint::dispatch($property)->onQueue('BISComplaintsQueue');
            }
            fetchOpenDataDOBViolation::dispatch($property)->onQueue('OpenDataDOBViolationsQueue');
            if(!empty($property->dob_violations_uri)){ 
                fetchBISDOBViolation::dispatch($property)->onQueue('BISDOBViolationsQueue');
            }
            fetchOpenDataECBViolation::dispatch($property)->onQueue('OpenDataECBViolationsQueue');
            if(!empty($property->ecb_violations_uri)){ 
                fetchBISECBViolation::dispatch($property)->onQueue('BISECBViolationsQueue');
            }
            fetchOpenDataJobApplication::dispatch($property)->onQueue('OpenDataJobApplicationsQueue');
            if(!empty($property->jobs_filings_uri)){ 
                fetchBISJobApplication::dispatch($property)->onQueue('BISJobApplicationsQueue');
            }
            fetchOATHHearingCase::dispatch($property)->onQueue('OpenDataOATHHearingCasesQueue');



    		if (!empty($user)) { 
    			$alreadyInPortfolio = Portfolio::where('user_id', $user->id)->where('property_id', $property->id)->get();
        		if(count($alreadyInPortfolio) === 0) { 
        			Portfolio::create([ 
	    				'user_id' => $user->id, 
	    				'property_id' => $property->id
	    			]);
        		}
    		}
    	}
    	return response()->json($property);
    }
}
