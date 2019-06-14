<?php

namespace App\Http\Controllers;

use App\Property; 
use App\BISElectrical; 
use App\BISElectricalFloorDescription; 
use App\BISElectricalInspection; 
use App\BISElectricalObjection; 
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ElectricalController extends Controller
{
    //
    public function getElectricalRecords (Request $request, $Id)
    { 
    	$property = Property::find($Id); 
    	if(!is_null($property)){ 
    		$electrical_uri = $property->electrical_applications_uri;
    		while (!empty($electrical_uri)) { 
    			$client = new Client();
	    		$request = $client->post(env('DOB_BIS_API').'/property/dob-api/electrical/index', [ 
	    			'form_params' => [ 
	    				'endpoint' => $electrical_uri
	    			]
	    		]); 
	    		$response = $request->getBody()->getContents(); 
	    		if(!is_null($response)){ 
	    			foreach ($response->electrical_applications as $electrical_application) { 
	    				$newElectricalApplication = BISElectrical::create([ 
	    					'property_id' => $property->id,
	    					'uri' => $electrical_application->uri
	    				]);
	    			}

	    			if(!empty($response->nextpage_url)){ 
	    				$electrical_uri = $response->nextpage_url;
	    			}

	    			if(empty($response->nextpage_url)) { 
	    				$electrical_uri = $response->nextpage_url;
	    			}
	    		}
    		}

    		$electrical_applications = BISElectrical::where('property_id', $property->id)->get();

    		if (count($electrical_applications) > 0) { 
    			foreach ($electrical_applications as $electrical_application) { 
    				$client = new Client(); 
    				$request = $client->post(env('DOB_BIS_API').'/property/dob-api/electrical/record', [ 
    					'form_params' => [ 
    						'endpoint' => $electrical_application->uri
    					]
    				]); 
    				$response = $request->getBody()->getContents(); 
    				if (!is_null($response)) { 
    					$electrical_application->dob_cross_streets = $response->dob_cross_streets;
    					$electrical_application->status = $response->status;
    					$electrical_application->request_type = $response->request_type;
    					$electrical_application->efiled = $response->efiled;
    					$electrical_application->permit_issued = $response->permit_issued;
    					$electrical_application->application_entered = $response->application_entered;
    					$electrical_application->job_start_date = $response->job_start_date;
    					$electrical_application->last_change = $response->last_change;
    					$electrical_application->job_end_date = $response->job_end_date;
    					$electrical_application->appointment_status = $response->appointment_status;
    					$electrical_application->last_inspection_by = $response->last_inspection_by;
    					$electrical_application->last_inspection_by_on = $response->last_inspection_by_on;
    					$electrical_application->field_disp = $response->field_disp;
    					$electrical_application->energize_recommendation = $response->energize_recommendation;
    					$electrical_application->objection_disposition = $response->objection_disposition;
    					$electrical_application->license_number = $response->license_number;
    					$electrical_application->license_number_uri = $response->license_number_uri;
    					$electrical_application->licensee_name = $response->licensee_name;
    					$electrical_application->firm_number = $response->firm_number;
    					$electrical_application->firm_number_uri = $response->firm_number_uri;
    					$electrical_application->firm_name = $response->firm_name;
    					$electrical_application->firm_phone = $response->firm_phone;
    					$electrical_application->firm_address = $response->firm_address;
    					$electrical_application->firm_work_started_or_filed_by_others = $response->firm_work_started_or_filed_by_others;
    					$electrical_application->work_category = $response->work_category;
    					$electrical_application->work_to_be_done = $response->work_to_be_done;
    					$electrical_application->total_fee = $response->total_fee;
    					$electrical_application->other_work = $response->other_work;
    					$electrical_application->work_related_new_amended_coo = $response->work_related_new_amended_coo;
    					$electrical_application->job_regulated_by_nycecc = $response->job_regulated_by_nycecc;
    					$electrical_application->building_used_as = $response->building_used_as;
    					$electrical_application->store_other = $response->store_other;
    					$electrical_application->special_cert_approval = $response->special_cert_approval;
    					$electrical_application->advisory_board_approval = $response->advisory_board_approval;
    					$electrical_application->owner_occup = $response->owner_occup;
    					$electrical_application->owner_business_name = $response->owner_business_name;
    					$electrical_application->authorized_rep = $response->authorized_rep;
    					$electrical_application->relationship_to_owner = $response->relationship_to_owner;

    					# work description
    					$electrical_application->up_to_100_amp_quantity = $response->up_to_100_amp_quantity; 
    					$electrical_application->up_to_100_amp_description = $response->up_to_100_amp_description;
    					$electrical_application->from_101_up_to_200_amp_quantity = $response->from_101_up_to_200_amp_quantity;
    					$electrical_application->from_101_up_to_200_amp_description = $response->from_101_up_to_200_amp_description;
    					$electrical_application->from_201_up_to_600_amp_quantity = $response->from_201_up_to_600_amp_quantity;
    					$electrical_application->from_201_up_to_600_amp_description = $response->from_201_up_to_600_amp_description;
    					$electrical_application->from_601_up_to_1200_amp_quanity = $response->from_601_up_to_1200_amp_quantity;
    					$electrical_application->from_601_up_to_1200_amp_description = $response->from_601_up_to_1200_amp_description;
    					$electrical_application->over_1200_amp_quantity = $response->over_1200_amp_quantity;
    					$electrical_application->over_1200_amp_description = $response->over_1200_amp_description;
    					$electrical_application->up_to_2_conductor_quantity = $response->up_to_2_conductor_quantity;
    					$electrical_application->up_to_2_conductor_description = $response->up_to_2_conductor_description;
    					$electrical_application->over_2_to_10_quantity = $response->over_2_to_10_quantity;
    					$electrical_application->over_2_to_10_description = $response->over_2_to_10_description;
    					$electrical_application->over_10_to_250_mcm_quantity = $response->over_10_to_250_quantity;
    					$electrical_application->over_10_to_250_mcm_description = $response->over_10_to_250_description;
    					$electrical_application->one_phase_up_to_20_pole_brkrs_quantity = $response->one_phase_up_to_20_pole_brkrs_quantity;
    					$electrical_application->one_phase_up_to_20_pole_brkrs_description = $response->one_phase_up_to_20_pole_brkrs_description;
    					$electrical_application->one_phase_up_to_21_pole_brkrs_quantity = $response->one_phase_up_to_20_pole_brkrs_quantity;
    					$electrical_application->one_phase_up_to_21_pole_brkrs_description = $response->one_phase_up_to_20_pole_brkrs_description;
    					$electrical_application->three_phase_up_to_225_amps_quantity = $response->three_phase_up_to_225_amps_quantity;
    					$electrical_application->three_phase_up_to_225_amps_description = $response->three_phase_up_to_225_amps_description;
    					$electrical_application->three_phase_over_225_amps_quantity = $response->three_phase_over_225_amps_quantity;
						$electrical_application->three_phase_over_225_amps_description = $response->three_phase_over_225_amps_description;
						$electrical_application->total_elevators_escalators_material_lifts_quantity = $response->total_elevators_escalators_material_lifts_quantity;
						$electrical_application->total_elevators_escalators_material_lifts_description = $response->total_elevators_escalators_material_lifts_description;
						$electrical_application->each_additional_10_floors_or_less_quantity = $response->each_additional_10_floors_or_less_quantity;
						$electrical_application->each_additional_10_floors_or_less_description = $response->each_additional_10_floors_or_less_description;

						# signs
						$electrical_application->signs_fieldconnect_field_inspect_tags = $response->signs_fieldconnect_field_inspect_tags;

						# service / meter equipment
						$electrical_application->service_meter_3_wire = $response->service_meter_3_wire;
						$electrical_application->service_meter_4_wire = $response->service_meter_4_wire;
						$electrical_application->service_meter_10_wire = $response->service_meter_10_wire;
						$electrical_application->service_meter_existing_meters = $response->service_meter_existing_meters;
						$electrical_application->service_meter_new_meters = $response->service_meter_new_meters;
						$electrical_application->service_meter_removed_meters = $response->service_meter_removed_meters;
						$electrical_application->service_meter_total_meters = $response->service_meter_total_meters;
						$electrical_application->service_meter_power_auth_flag = $response->service_meter_power_auth_flag;
						$electrical_application->service_meter_objection_flag = $response->service_meter_objection_flag;
						$electrical_application->service_meter_power_requested = $response->service_meter_power_requested;
						$electrical_application->service_meter_notice = $response->service_meter_notice; 
						$electrical_application->service_meter_power_issued = $response->service_meter_power_issued;
						$electrical_application->service_meter_response = $response->service_meter_response;
						$electrical_application->service_meter_follow_up = $response->service_meter_follow_up;
						$electrical_application->service_meter_wires_comments = $response->service_meter_wires;
						$electrical_application->service_meter_contractors_comments = $response->service_meter_contractors_comments;
						$electrical_application->inspection_details_uri = $response->inspection_details_uri;
    					$electrical_application->save();


    					if(count($response->floor_descriptions) > 0) { 
    						foreach ($response->floor_descriptions as $floor_description) { 
    							$newFloorDescription = BISElectricalFloorDescription::create([ 
    								'property_id' => $property->id, 
    								'bis_electrical_id' => $electrical_application->id, 
    								'floor' => $floor_description->floor, 
    								'apt' => $floor->apt, 
    								'fixt' => $floor_description->fixt, 
    								'att' => $floor_description->att, 
    								'ac' => $floor_description->ac, 
    								'switch' => $floor_description->switch,
    								'num_fixtures' => $floor_description->num_fixtures, 
    								'motors_generators_num' => $floor_description->motors_generators_num, 
    								'motors_generators_total_hp_kw' => $floor_description->motors_generators_total_hp_kw, 
    								'heaters_num' => $floor_description->heaters_num, 
    								'heaters_total_kw' => $floor_description->heaters_total_kw, 
    								'transformers_num' => $floor_description->transformers_num, 
    								'transformers_total_kva' => $floor_description->transformers_total_kva 
    							]);
    						}
    					}

    					if(count($response->inspections_for_application) > 0) { 
    						foreach ($response->inspections_for_application as $inspection) { 
    							$newInspection = BISElectricalInspection::create([ 
    								'property_id' => $property->id, 
    								'bis_electrical_id' => $electrical_application->id, 
    								'insp_id' => $inspection->insp_id, 
    								'field_date' => $inspection->field_date, 
    								'disp_date' => $inspection->disp_date, 
    								'fld_disp' => $inspection->fld_disp, 
    								'obj_disp' => $inspection->obj_disp, 
    								'enrg_rec' => $inspection->enrg_rec, 
    								'time_insp' => $inspection->time_insp, 
    								'reinsp_date' => $inspection->reinsp_date, 
    								'new_obj' => $inspection->new_obj, 
    								'appt_flag' => $inspection->appt_flag,
    								'inspection_comments' => $inspection->inspection_comments
    							]);
    						}
    					}

    					if(count($response->objections_for_application) > 0) { 
    						foreach ($response->objections_for_application as $objection) { 
    							$newObjection = BISElectricalObjection::create([ 
    								'property_id' => $property->id, 
    								'bis_electrical_id' => $electrical_application->id, 
    								'objection_id' => $objection->objection_id, 
    								'objection_code' => $objection->code, 
    								'objection_description_comments' => $objection->objection_description_comments, 
    								'stat' => $objection->stat, 
    								'first' => $objection->first,
    								'latest' => $objection->latest, 
    								'reslvd' => $objection->reslvd, 
    							]);
    						}
    					}
     				}
    			}
    		}
    	}

    	return response([ 
    		'success' => true
    	], 200);
    }
}
