<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISJobApplication extends Model
{
    //
    protected $table = 'bis_job_applications'; 

    protected $fillable = [ 
    	'property_id',
        'bis_j_applicant_id',
        'bis_j_filing_representative_id',
        # data collected from index
		'file_date',
		'job_number',
		'url', // changed from uri to url 
        'doc_number',
        'job_type',
        'job_status',
        'status_date',
        'lic_number',
        'applicant',
        'in_audit',
        'zoning_approval', // changed from zoning_status to zoning_approval


        # data collected from record 
        'doc_overview_uri',
        'fees_paid_uri',
        'crane_information_uri',
        'after_hours_variance_permit_uri', // changed from after_hours_variance_permit_uri to after_hours_variance_permits_uri


        

        
		'items_required_uri',
		'forms_received_uri',
        'plan_examination_uri',
        'virtual_job_folder_uri',
        'all_permits_uri',
        'all_comments_uri',
        'schedule_b_uri',
        'plumbing_inspections_uri',
        'dob_now_inspections_uri', // changed from dob_now_inspection_url to dob_now_inspection_uri
        'print_letter_of_completion_uri', 
        'last_action',
        'application_approved_on', 
        'pre_filed_date', // changed from pre_filed to pre_filed_date
        'building_type',
        'estimated_total_cost',
        'date_filed',
        'electronically_filed',
        'fee_structure', 
        'review_is_requested_bldg_code', // changed from review_is_requested_code to review_is_requested_bldg_code
        'house_number', 
        'street_name', 
        'borough', 
        'block', 
        'lot', 
        'bin',
        'cb_number', 
        'work_on_floors', 
        'apt_condo_number', // changed from condo_number to apt_condo_number
        'zipcode',
        'job_description',
        
        
        
        

        // create new data model and migration
		'prev_applicant_name', 
		'prev_applicant_business_name', 
		'prev_applicant_business_phone', 
		'prev_applicant_business_address', 
		'prev_applicant_business_fax', 
		'prev_applicant_email', 
		'prev_applicant_mobile_phone', 
		'prev_applicant_type', 
		'prev_applicant_license_number', 

        // create new data model and migration - filing_representatitve
		'filing_rep_name', 
		'filing_rep_business_name', 
		'filing_rep_business_phone', 
		'filing_rep_business_address', 
		'filing_rep_business_fax', 
		'filing_rep_email', 
		'filing_rep_mobile_phone', 
		'filing_rep_registration_number', 

		



        'sec_7_plans_page_count', // changed from sec_7_plans_page_count to plans_page_count

        // create new data model and migration - additional_information
        'sec_8_enlargement_proposed',  
        'sec_8_horizontal',
        'sec_8_vertical',

        /*'work_boiler', remove all and replace with work_type
        'work_fire_supression', 
        'work_sprinkler', 
        'work_general_construction', 
        'work_fire_alarm', 
        'work_mechanical', 
        'work_construction_equipment', 
        'work_fuel_burning', 
        'work_plumbing', 
        'work_curb_cut', 
        'work_fuel_storage',
        'work_standpipe',*/ 


        /*'alt_required_new_building', - modify once addition_consideration is corrected.
        'alt_is_major', 
        'change_in_dwelling_unit', 
        'change_in_occupancy_use', 
        'change_is_inconsistent', 
        'change_in_stories', 
        'facade_alteration', 
        'adult_estab', 
        'comp_development', 
        'low_income', 
        'sro_multiple', 
        'filing_includes_lot_merge', 
        'infill_zoning', 
        'loft_board', 
        'quality_housing', 
        'site_safety', 
        'included_lmccc', 
        'prefab_wood', 
        'structural_cold_steel', 
        'open_web_steel',*/
        
        
        // create new data model and migration for nycecc_compliance

        /*'landmark', remove all
        'schedule_a_uri', // remove
        'co_summary_uri', // remove
        'co_preview_uri', // remove
        'directive_14_applicant', // remove 
        'job_application_type_a1_flag',
        'job_application_type_a1_ot_flag',
        'job_application_type_a1_new_building_flag',
        'job_application_type_a2_flag',
        'job_application_type_full_demo_flag',
        'job_application_type_a3_flag',
        'job_application_type_subdivision_improved',
        'job_application_type_sign',
        'job_application_type_subdivision_condo',
        'job_application_type_directive_14_acceptance_requested',
        'sec_8_total_bldg_square_footage',
        'sec_8_total_construction_floor_area',
        'landmark_docket_number',
        'environ_restrictions',
        'unmapped_cco',
        'legalization',
        'other_specify',
        'filed_comply_local_law',
        'restrict_dec_easement',
        'zoning_exhibit_record',
        'filed_to_address_vios',
        'work_includes_lighting_fixture',
        'modular_construction_ny_state',
        'modular_construction_ny_city',
        'structural_peer_review_required',
        'work_includes_permanent_removal',
        'work_includes_partial_demo',
        'structural_stability_affected',

        'sec_10_in_compliance_with_NYCECC',
        'sec_10_energy_analysis_on_another_job_number',
        'sec_10_exempt_from_NYCECC',
        'sec_10_utilizes_tradeoffs_different_major_systems',
        'sec_10_utilizes_tradeoffs_single_major_system',
        'sec_10_alteration_of_state_or_national',
        'sec_10_cc_path_nycecc',
        'sec_10_cc_path_ashare',
        'sec_10_ea_tabular',
        'sec_10_ea_rescheck',
        'sec_10_ea_comcheck',
        'sec_10_ea_energy_modeling',
        'sec_11_job_description',
        'sec_11_related_bis_job_numbers_uri',
        'sec_11_primary_app_job_number',
        'sec_12_zoning_characteristics_districts',
        'sec_12_special_districts',
        'sec_12_overlays',
        'sec_12_map_no',
        'sec_12_street_legal_width',
        'sec_12_zoning_includes_tax_lots',
        'sec_12_zoning_street_status_public',
        'sec_12_zoning_street_status_private',
        'sec_12_proposed_lot_details_corner',
        'sec_12_proposed_lot_details_interior',
        'sec_12_proposed_lot_details_through',
        'sec_12_proposed_use',
        'sec_12_proposed_use_zoning',
        'sec_12_proposed_use_district',
        'sec_12_proposed_use_FAR',
        'sec_12_zoning_area_proposed_total',
        'sec_12_district_area_proposed_total',
        'sec_12_FAR_area_proposed_total',
        'sec_12_zoning_area_existing_total',
        'sec_12_district_area_existing_total',
        'sec_12_FAR_area_existing_total',
        'sec_12_proposed_lot_coverage',
        'sec_12_proposed_lot_area',
        'sec_12_proposed_lot_width',
        'sec_12_proposed_yard_details_no_yards',
        'sec_12_proposed_yard_front',
        'sec_12_proposed_yard_rear',
        'sec_12_proposed_yard_rear_equivalent',
        'sec_12_proposed_yard_side1',
        'sec_12_proposed_yard_side2',
        'sec_12_proposed_other_perimeter_wall_height',
        'sec_12_proposed_other_details_enclosed_parking',
        'sec_12_proposed_other_details_number_of_parking_spaces',
        'sec_13_occ_class_existing_text',
        'sec_13_occ_class_2014_2008_code_designations',
        'sec_13_occ_class_proposed_text',
        'sec_13_con_class_existing_text',
        'sec_13_con_class_2014_2008_code_designations',
        'sec_13_con_class_proposed_text',






        'sec_13_multi_dwelling_class_existing_text',
        'sec_13_multi_dwelling_class_proposed_text',
        'sec_13_building_height_existing_text',
        'sec_13_building_height_proposed_text',
        'sec_13_building_stories_existing_text',
        'sec_13_building_stories_proposed_text',


        'sec_13_dwelling_units_existing_text',
        'sec_13_dwelling_units_proposed_text',
        'sec_13_erected_pursuant_to_bc_2014',
        'sec_13_erected_pursuant_to_bc_2008',
        'sec_13_erected_pursuant_to_bc_1968',
        'sec_13_erected_pursuant_to_bc_before_1968',
        'sec_13_earliest_code_required_2014',
        'sec_13_earliest_code_required_2008',
        'sec_13_earliest_code_required_1968',
        'sec_13_earliest_code_required_before_1968',
        'sec_13_mixed_use_building',





        'sec_14_fill_not_applicable',
        'sec_14_fill_off_site',
        'sec_14_fill_on_site',
        'sec_14_fill_under_300_cubic_yds',




        'sec_15_construction_equipment_chute',
        'sec_15_construction_equipment_sidewalk_shed',
        'sec_15_construction_equipment_fence',
        'sec_15_construction_equipment_supported_scaffold',
        'sec_15_construction_equipment_other',
        'sec_16_size_of_cut_splays',
        'sec_16_curbcut_text',
        'sec_16_distance_from_nearest_corner',




        'sec_18_fire_alarm_existing',
        'sec_18_fire_alarm_proposed',
        'sec_18_sprinkler_existing',
        'sec_18_sprinkler_proposed',
        'sec_18_fire_suppression_existing',
        'sec_18_fire_suppression_proposed',
        'sec_18_standpipe_existing',
        'sec_18_standpipe_proposed',




        'sec_20_tidal_wetlands',
        'sec_20_freshwater_wetlands',
        'sec_20_coastal_erosion_hazard',
        'sec_20_urban_renewal',
        'sec_20_fire_district',
        'sec_20_flood_hazard',
        'sec_20_substantial_improvement',
        'sec_20_substantially_damaged',
        'sec_20_floodshields',







        'sec_21_affects_exterior',
        'sec_21_involves_raising',







        'sec_22_requires_asbestos_abatement',







        'sec_23_purpose_advertising',
        'sec_23_purpose_non_advertising',
        'sec_23_type_illuminated',
        'sec_23_type_non_illuminated',
        'sec_23_illuminated_type_direct',
        'sec_23_illuminated_type_flashing',
        'sec_23_illuminated_type_indirect',
        'sec_23_location_ground',
        'sec_23_location_roof',
        'sec_23_location_wall',
        'sec_23_estimated_cost',
        'sec_23_total_sq_ft',
        'sec_23_height_above_curb',
        'sec_23_height_above_roof',
        'sec_23_inside_building_line',
        'sec_23_inside_building_line_text',
        'sec_23_owner_billed_for_annual_permit',
        'sec_23_sign_tight_closed_or_solid',
        'sec_23_changeable_copy',
        'sec_23_sign_wording_text',
        'sec_23_oac_interest',
        'sec_23_oac_registration_number',
        'sec_23_within_900',
        'sec_23_within_900_distance',
        'sec_23_within_200',
        'sec_23_within_200_distance',




        'sec_24_comments',





        'sec_25_nb_a1',
        'sec_25_directive_14',






        'sec_26_name',
        'sec_26_relationship_to_owner',
        'sec_26_business_name',
        'sec_26_business_phone',
        'sec_26_business_address',
        'sec_26_business_fax',
        'sec_26_email',
        'sec_26_owner_type',





        'sec_27_metes_and_bounds_text',
        'sec_27_metes_and_bounds_running_thence_1',
        'sec_27_metes_and_bounds_thence_1',
        'sec_27_metes_and_bounds_running_thence_2',
        'sec_27_metes_and_bounds_thence_2',
        'sec_27_metes_and_bounds_running_thence_3',
        'sec_27_metes_and_bounds_thence_3',
        'sec_27_metes_and_bounds_running_thence_4',
        'sec_27_metes_and_bounds_thence_4',*/



		'active',

		'created_at',
		'updated_at'
    ];

    public function property() 
    { 
    	return $this->belongsTo('App\Property');
    }

    public function applicant ()
    { 
        return $this->belongsTo('App\BISJApplicant', 'bis_j_applicant_id'); 
    }

    public function filing_representative ()
    { 
        return $this->belongsTo('App\BISJFilingRepresentative', 'bis_j_filing_representative_id');
    }

    public function directive_14_applicants()
    {
        return $this->hasMany('App\BISDirective14Applicant');
    }

    public function permits()
    { 
        return $this->hasMany('App\BISPermit', 'bis_job_application_id');
    }
}
