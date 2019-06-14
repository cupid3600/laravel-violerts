<?php

namespace App\Http\Controllers;

use App\User; 
use App\Portfolio; 
use App\BISJobApplication;
use Validator;
use App\AirtableApiKey;
use App\Property;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    //
	public function settings (Request $request, $Id)
	{ 
		$portfolio = Portfolio::find($Id); 
		return response($portfolio, 200);
	}

	public function remove (Request $request, $PropertyId) 
	{ 
		$portfolio = Portfolio::find($PropertyId); 
		if (!is_null($portfolio)) { 
			$portfolio->delete();
			return response([ 
				'msg' => 'Property was successfully removed from your portfolio.'
			], 200);
		}
		return response([ 
			'msg' => 'This property has already been removed.'
		], 200);
	}

	public function enableAirtable (Request $request, $Id) 
	{ 

		$portfolio = Portfolio::find($Id); 
		$data = $request->all(); 
		if(!is_null($portfolio) && !is_null($request->airtable_base_id)){ 
			$user = User::find($portfolio->user_id); 
			if($user->user_group === '4') { 
				$client = new Client();
				$AirtableApiKey = AirtableApiKey::find($request->airtable_key_id);
				$verification = json_decode($client->get(env('AIRTABLE_API').'/airtable/sync/status/'.$AirtableApiKey->key.'/'.$request->airtable_base_id)->getBody()->getContents()); 
				if(!is_null($verification) && isset($verification->pageReq) && $verification->pageReq == true){ 
					$portfolio->airtable_key_id = $request->airtable_key_id;
					$portfolio->airtable_base_id = $request->airtable_base_id;
					$portfolio->airtable_enabled = true;
					$portfolio->save();
					$property = Property::find($portfolio->property_id);
					$job_applications = BISJobApplication::where('property_id', $property->id)->with(['applicant'])->with(['permits'])->with(['filing_representative'])->where('doc_number', '01')->where('job_status', '!=', 'X SIGNED OFF')->where('job_status', '!=', 'U COMPLETED')->get();
					$response = json_decode($client->post(env('AIRTABLE_API').'/airtable/create/base/'.$AirtableApiKey->key.'/'.$portfolio->airtable_base_id, [ 'form_params' => [ 'job_applications' => json_encode($job_applications)]])->getBody()->getContents());
					if(!is_null($response)){ 
						return response([ 
							'success' => $response, 
							'airtable_base_id' => $portfolio->airtable_base_id
						], 200);
					}
				}

			}
		}
		return response([ 
			'success' => false
		], 200);

	}

	public function disableAirtable (Request $request, $Id)
	{ 
		$portfolio = Portfolio::find($Id); 
		$portfolio->airtable_enabled = false; 
		$portfolio->save(); 

		return response($portfolio, 200);
	}

	public function removeAirtable (Request $request, $Id)
	{ 
		$portfolio = Portfolio::find($Id); 
		$portfolio->airtable_base_id = null; 
		$portfolio->airtable_enabled = false; 
		$portfolio->save();
		return response($portfolio, 200);
	}
}
