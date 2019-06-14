<?php

namespace App\Http\Controllers;

use App\Property;
use App\ACRISPPL; 
use App\ACRISRPL;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ACRISController extends Controller
{
    //
    public function swipeIndexRPL(Request $request, $Id)
    { 
        $acris_rpl = Property::find($Id)->acris_rpls;
        return response($acris_rpl, 200);
    }

    public function swipeIndexPPL(Request $request, $Id)
    { 
        $acris_ppl = Property::find($Id)->acris_ppls;
        return response($acris_ppl, 200);
    }

    public function getACRISRPL (Request $request, $Id)
    { 
    	$property = Property::find($Id);

    	if (is_null($property)) { 
    		return response([ 
    			'success' => false
    		], 200);
    	}

    	$block = $property->block; 
        $lot = $property->lot; 

        if(strlen($property->block) === 3) { 
            $block = '00'.$property->block;
        }

        if(strlen($property->block) === 4) { 
            $block = '0'.$property->block;
        }

        if(strlen($property->lot) === 2) { 
            $lot = '00'.$property->lot;
        }

        if(strlen($property->lot) === 3) { 
            $lot = '0'.$property->lot;
        }

    	$client = new Client();

    	$acris_request = $client->get('https://data.cityofnewyork.us/resource/8h5j-fqxa.json?block='.$block.'&lot='.$lot);
    	$acris_response = json_decode($acris_request->getBody()->getContents());
    	if (!is_null($acris_response)) {
    		foreach ($acris_response as $data) { 
    			$acris_exist = ACRISRPL::where('property_id', $property->id)->where('document_id', $data->document_id)->first();
    			if(is_null($acris_exist)){ 
    				$acris_rpl = new ACRISRPL; 

                    if (!empty($property->id)) { 
                        $acris_rpl->property_id = $property->id; 
                        $acris_rpl->save();
                    }

                    if (!empty($data->document_id)) { 
                        $acris_rpl->document_id = $data->document_id;
                        $acris_rpl->save();
                    }

                    if (!empty($data->record_type)) { 
                        $acris_rpl->record_type = $data->record_type;
                        $acris_rpl->save();
                    }

                    if (!empty($data->borough)) { 
                        $acris_rpl->borough = $data->borough;
                        $acris_rpl->save();
                    }

                    if (!empty($data->block)) { 
                        $acris_rpl->block = $data->block;
                        $acris_rpl->save();
                    }

                    if (!empty($data->lot)) { 
                        $acris_rpl->lot = $data->lot;
                        $acris_rpl->save();
                    }

                    if (!empty($data->easement)) { 
                        $acris_rpl->easement = $data->easement;
                        $acris_rpl->save();
                    }

                    if (!empty($data->partial_lot)) { 
                        $acris_rpl->partial_lot = $data->partial_lot;
                        $acris_rpl->save();
                    }

                    if (!empty($data->air_rights)) { 
                        $acris_rpl->air_rights = $data->air_rights;
                        $acris_rpl->save();
                    }

                    if (!empty($data->subterranean_rights)) { 
                        $acris_rpl->subterranean_rights = $data->subterranean_rights;
                        $acris_rpl->save();
                    }

                    if (!empty($data->property_type)) { 
                        $acris_rpl->property_type = $data->property_type;
                        $acris_rpl->save();
                    }

                    if (!empty($data->street_number)) { 
                        $acris_rpl->street_number = $data->street_number;
                        $acris_rpl->save();
                    }

                    if (!empty($data->street_name)) { 
                        $acris_rpl->street_name = $data->street_name;
                        $acris_rpl->save();
                    }

                    if (!empty($data->addr_unit)) { 
                        $acris_rpl->addr_unit = $data->addr_unit;
                        $acris_rpl->save();
                    }

                    if (!empty($data->good_through_date)) { 
                        $acris_rpl->good_through_date = $data->good_through_date;
                        $acris_rpl->save();
                    }
    			}
    		}
    	}
    }

    public function getACRISPPL (Request $request, $Id)
    { 
    	$property = Property::find($Id);

    	if (is_null($property)) { 
    		return response([ 
    			'success' => false
    		], 200);
    	}

    	$block = $property->block; 
        $lot = $property->lot; 

        if(strlen($property->block) === 3) { 
            $block = '00'.$property->block;
        }

        if(strlen($property->block) === 4) { 
            $block = '0'.$property->block;
        }

        if(strlen($property->lot) === 2) { 
            $lot = '00'.$property->lot;
        }

        if(strlen($property->lot) === 3) { 
            $lot = '0'.$property->lot;
        }

    	$client = new Client();

    	$acris_request = $client->get('https://data.cityofnewyork.us/resource/uqqa-hym2.json?block='.$block.'&lot='.$lot);
    	$acris_response = json_decode($acris_request->getBody()->getContents());
    	if (!is_null($acris_response)) {
    		foreach ($acris_response as $data) { 
    			$acris_exist = ACRISPPL::where('property_id', $property->id)->where('document_id', $data->document_id)->first();
    			if(is_null($acris_exist)){ 
    				$acris_ppl = new ACRISPPL; 

                    if (!empty($property->id)) { 
                        $acris_ppl->property_id = $property->id; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->document_id)) { 
                        $acris_ppl->document_id = $data->document_id; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->record_type)) { 
                        $acris_ppl->record_type = $data->record_type; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->borough)) { 
                        $acris_ppl->borough = $data->borough; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->block)) { 
                        $acris_ppl->block = $data->block; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->lot)) { 
                        $acris_ppl->lot = $data->lot; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->easement)) { 
                        $acris_ppl->easement = $data->easement; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->partial_lot)) { 
                        $acris_ppl->partial_lot = $data->partial_lot; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->air_rights)) { 
                        $acris_ppl->air_rights = $data->air_rights; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->subterranean_rights)) { 
                        $acris_ppl->subterranean_rights = $data->subterranean_rights; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->property_type)) { 
                        $acris_ppl->property_type = $data->property_type; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->street_number)) { 
                        $acris_ppl->street_number = $data->street_number; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->street_name)) { 
                        $acris_ppl->street_name = $data->street_name; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->addr_unit)) { 
                        $acris_ppl->addr_unit = $data->addr_unit; 
                        $acris_ppl->save();
                    }

                    if (!empty($data->good_through_date)) { 
                        $acris_ppl->good_through_date = $data->good_through_date; 
                        $acris_ppl->save();
                    }
    			}
    		}
    	}
    }
}
