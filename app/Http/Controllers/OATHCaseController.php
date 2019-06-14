<?php

namespace App\Http\Controllers;

use App\Property;
use App\OATHCase; 
use App\OATHCase2;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class OATHCaseController extends Controller
{
    //
    public function swipeIndexOD (Request $request, $Id)
    { 
        $oath_cases = Property::find($Id)->oath_cases; 
        return response($oath_cases, 200);
    }

    public function getOATHCases (Request $request, $Id)
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
		$oath_request = $client->get('https://data.cityofnewyork.us/resource/gszd-efwt.json?violation_location_block_no='.$block.'&violation_location_lot_no='.$lot);	
		$oath_response = json_decode($oath_request->getBody()->getContents());
		if (!is_null($oath_response)) { 
			foreach ($oath_response as $data) { 
				$oath_case_check = OATHCase::where('property_id', $property->id)->where('ticket_number', $data->ticket_number)->first();
				if(is_null($oath_case_check)) { 
					$oath = new OATHCase; 
                    $oath_ext = new OATHCase2;

                    if (!empty($property->id)) { 
                        $oath->property_id = $property->id; 
                        $oath->save();
                    }

                    if (!empty($data->ticket_number)) { 
                        $oath->ticket_number = $data->ticket_number; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_date)) { 
                        $oath->violation_date = $data->violation_date; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_time)) { 
                        $oath->violation_time = $data->violation_time; 
                        $oath->save(); 
                    }

                    if (!empty($data->issuing_agency)) { 
                        $oath->issuing_agency = $data->issuing_agency; 
                        $oath->save(); 
                    }

                    if (!empty($data->respondent_first_name)) { 
                        $oath->respondent_first_name = $data->respondent_first_name; 
                        $oath->save(); 
                    }

                    if (!empty($data->respondent_last_name)) { 
                        $oath->respondent_last_name = $data->respondent_last_name; 
                        $oath->save(); 
                    }

                    if (!empty($data->balance_due)) { 
                        $oath->balance_due = $data->balance_due; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_location_borough)) { 
                        $oath->violation_location_borough = $data->violation_location_borough; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_location_block_no)) { 
                        $oath->violation_location_block_no = $data->violation_location_block_no; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_location_lot_no)) { 
                        $oath->violation_location_lot_no = $data->violation_location_lot_no; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_location_house)) { 
                        $oath->violation_location_house = $data->violation_location_house; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_location_street_name)) { 
                        $oath->violation_location_street_name = $data->violation_location_street_name; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_location_floor)) { 
                        $oath->violation_location_floor = $data->violation_location_floor; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_location_city)) { 
                        $oath->violation_location_city = $data->violation_location_city; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_location_zip_code)) { 
                        $oath->violation_location_zip_code = $data->violation_location_zip_code; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_location_state_name)) { 
                        $oath->violation_location_state_name = $data->violation_location_state_name; 
                        $oath->save(); 
                    }

                    if (!empty($data->hearing_status)) { 
                        $oath->hearing_status = $data->hearing_status; 
                        $oath->save(); 
                    }

                    if (!empty($data->hearing_result)) { 
                        $oath->hearing_result = $data->hearing_result; 
                        $oath->save(); 
                    }

                    if (!empty($data->scheduled_hearing_location)) { 
                        $oath->scheduled_hearing_location = $data->scheduled_hearing_location; 
                        $oath->save(); 
                    }

                    if (!empty($data->hearing_date)) { 
                        $oath->hearing_date = $data->hearing_date; 
                        $oath->save(); 
                    }

                    if (!empty($data->hearing_time)) { 
                        $oath->hearing_time = $data->hearing_time; 
                        $oath->save(); 
                    }

                    if (!empty($data->decision_location_borough)) { 
                        $oath->decision_location_borough = $data->decision_location_borough; 
                        $oath->save(); 
                    }

                    if (!empty($data->decision_date)) { 
                        $oath->decision_date = $data->decision_date; 
                        $oath->save(); 
                    }

                    if (!empty($data->total_violation_amount)) { 
                        $oath->total_violation_amount = $data->total_violation_amount; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_details)) { 
                        $oath->violation_details = $data->violation_details; 
                        $oath->save(); 
                    }

                    if (!empty($data->date_judgement_docketed)) { 
                        $oath->date_judgement_docketed = $data->date_judgement_docketed; 
                        $oath->save(); 
                    }

                    if (!empty($data->respondent_address_or_facility_number_for_fdny_and_dob_tickets)) { 
                        $oath->respondent_address_or_facility_number_for_fdny_and_dob_tickets = $data->respondent_address_or_facility_number_for_fdny_and_dob_tickets; 
                        $oath->save(); 
                    }

                    if (!empty($data->penalty_imposed)) { 
                        $oath->penalty_imposed = $data->penalty_imposed; 
                        $oath->save(); 
                    }

                    if (!empty($data->paid_amount)) { 
                        $oath->paid_amount = $data->paid_amount; 
                        $oath->save(); 
                    }

                    if (!empty($data->additional_penalties_late_fees)) { 
                        $oath->additional_penalties_late_fees = $data->additional_penalties_late_fees; 
                        $oath->save(); 
                    }

                    if (!empty($data->compliance_status)) { 
                        $oath->compliance_status = $data->compliance_status; 
                        $oath->save(); 
                    }

                    if (!empty($data->violation_description)) { 
                        $oath->violation_description = $data->violation_description; 
                        $oath->save(); 
                    }

                    if (!empty($oath->id)) { 
                        $oath_ext->oath_case_id = $oath->id; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_1_code)) { 
                        $oath_ext->charge_1_code = $data->charge_1_code; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_1_code_section)) { 
                        $oath_ext->charge_1_code_section = $data->charge_1_code_section; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_1_code_description)) { 
                        $oath_ext->charge_1_code_description = $data->charge_1_code_description; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_1_infraction_amount)) { 
                        $oath_ext->charge_1_infraction_amount = $data->charge_1_infraction_amount; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_2_code)) { 
                        $oath_ext->charge_2_code = $data->charge_2_code; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_2_code_section)) { 
                        $oath_ext->charge_2_code_section = $data->charge_2_code_section; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_2_code_description)) { 
                        $oath_ext->charge_2_code_description = $data->charge_2_code_description; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_2_infraction_amount)) { 
                        $oath_ext->charge_2_infraction_amount = $data->charge_2_infraction_amount; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_3_code)) { 
                        $oath_ext->charge_3_code = $data->charge_3_code; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_3_code_section)) { 
                        $oath_ext->charge_3_code_section = $data->charge_3_code_section; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_3_code_description)) { 
                        $oath_ext->charge_3_code_description = $data->charge_3_code_description; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_3_infraction_amount)) { 
                        $oath_ext->charge_3_infraction_amount = $data->charge_3_infraction_amount; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_4_code)) { 
                        $oath_ext->charge_4_code = $data->charge_4_code; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_4_code_section)) { 
                        $oath_ext->charge_4_code_section = $data->charge_4_code_section; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_4_code_description)) { 
                        $oath_ext->charge_4_code_description = $data->charge_4_code_description; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_4_infraction_amount)) { 
                        $oath_ext->charge_4_infraction_amount = $data->charge_4_infraction_amount; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_5_code)) { 
                        $oath_ext->charge_5_code = $data->charge_5_code; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_5_code_section)) { 
                        $oath_ext->charge_5_code_section = $data->charge_5_code_section; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_5_code_description)) { 
                        $oath_ext->charge_5_code_description = $data->charge_5_code_description; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_5_infraction_amount)) { 
                        $oath_ext->charge_5_infraction_amount = $data->charge_5_infraction_amount; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_6_code)) { 
                        $oath_ext->charge_6_code = $data->charge_6_code; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_6_code_section)) { 
                        $oath_ext->charge_6_code_section = $data->charge_6_code_section; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_6_code_description)) { 
                        $oath_ext->charge_6_code_description = $data->charge_6_code_description; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_6_infraction_amount)) { 
                        $oath_ext->charge_6_infraction_amount = $data->charge_6_infraction_amount; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_7_code)) { 
                        $oath_ext->charge_7_code = $data->charge_7_code; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_7_code_section)) { 
                        $oath_ext->charge_7_code_section = $data->charge_7_code_section; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_7_code_description)) { 
                        $oath_ext->charge_7_code_description = $data->charge_7_code_description; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_7_infraction_amount)) { 
                        $oath_ext->charge_7_infraction_amount = $data->charge_7_infraction_amount; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_8_code)) { 
                        $oath_ext->charge_8_code = $data->charge_8_code; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_8_code_section)) { 
                        $oath_ext->charge_8_code_section = $data->charge_8_code_section; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_8_code_description)) { 
                        $oath_ext->charge_8_code_description = $data->charge_8_code_description; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_8_infraction_amount)) { 
                        $oath_ext->charge_8_infraction_amount = $data->charge_8_infraction_amount; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_9_code)) { 
                        $oath_ext->charge_9_code = $data->charge_9_code; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_9_code_section)) { 
                        $oath_ext->charge_9_code_section = $data->charge_9_code_section; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_9_code_description)) { 
                        $oath_ext->charge_9_code_description = $data->charge_9_code_description; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_9_infraction_amount)) { 
                        $oath_ext->charge_9_infraction_amount = $data->charge_9_infraction_amount; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_10_code)) { 
                        $oath_ext->charge_10_code = $data->charge_10_code; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_10_code_section)) { 
                        $oath_ext->charge_10_code_section = $data->charge_10_code_section; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_10_code_description)) { 
                        $oath_ext->charge_10_code_description = $data->charge_10_code_description; 
                        $oath_ext->save(); 
                    }

                    if (!empty($data->charge_10_infraction_amount)) { 
                        $oath_ext->charge_10_infraction_amount = $data->charge_10_infraction_amount; 
                        $oath_ext->save(); 
                    }
				}
			}
		} 
		return response([ 
			'success' => true
		], 200);
    } 
}
