<template>
	<div class="form-group m-form__group d-print-none" id="propertySearchInput">
		<div class="input-group">
			<vue-google-autocomplete
				ref="address"
				id="map"
				classname="form-control"
				placeholder="Enter an address"
				v-on:placechanged="getAddressData"
                v-on:error="onError"
				country="us"
				locality="ny"
				sublocality="ny"
				autofocus="true"
			></vue-google-autocomplete>
			<div class="input-group-append">
				<button type="button" class="btn btn-success" @click="search(property)" :disabled="isLoading == 1">
					<i class="fa fa-search" v-if="isLoading == false"></i>
					<div class="text-center" v-if="isLoading">
						<i class="fa fa-circle-o-notch fa-spin"></i>
					</div>
				</button>
			</div>
		</div>
		<strong class="m-form__help" v-if="isInvalid == true">
			Invalid address entered...
		</strong>
	</div>
</template>
<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete'
export default {
    data() {
        return {
            user: {},
            isLoading: false,
            isInvalid: false,
            address: '',
            property: {
                id: '',
                address: '',
                house_number: '',
                street_name: '',
                borough: '',
                bin: '',
                block: '',
                lot: '',
                coo_uri: '',
                cross_streets: '',
                complaints_uri: '',
                complaints_total: '',
                complaints_open: '',
                dob_violations_uri: '',
                dob_violations_total: '',
                dob_violations_open: '',
                ecb_violations_uri: '',
                ecb_violations_total: '',
                ecb_violations_open: '',
                jobs_filings_uri: '',
                jobs_filings_total: '',
                ara_laa_uri: '',
                total_jobs: '',
                actions_uri: '',
                actions_total: '',
                elevator_records_uri: '',
                electrical_applications_uri: '',
                permits_in_process_uri: '',
                illuminated_signs_permit_uri: '',
                dep_boiler_information_uri: '',
                crane_information_uri: '',
                after_hours_permit_uri: '',
                health_area: '',
                census_tract: '',
                community_board: '',
                buildings_on_lot: '',
                condo: '',
                vacant: '',
                zoning_docs_uri: '',
                challenge_results_uri: '',
                pre_bis_pa_uri: '',
                dob_special_name: '',
                dob_building_remarks: '',
                landmark_status: '',
                special_status: '',
                local_law: '',
                loft_law: '',
                sro_restricted: '',
                ta_restricted: '',
                ub_restricted: '',
                environmental_restrictions: '',
                grandfathered_sign: '',
                legal_adult_use: '',
                city_owned: '',
                additional_bins: '',
                special_district: '',
                building_classification: ''
            }
        }
    },
    methods: {
        onError(error) {
            this.isLoading = false
            this.$emit('error', error)
        },
        getAddressData(addressData, placeResultData, id) {
            this.address = addressData
            let borough
            // Manhattan
            if (placeResultData.address_components[2].long_name === 'Manhattan') {
                borough = 1
            }
            // Bronx
            if (placeResultData.address_components[3].long_name === 'Bronx') {
                borough = 2
            }
            // Brooklyn
            if (placeResultData.address_components[3].long_name === 'Brooklyn') {
                borough = 3
            }
            // Queens
            if (placeResultData.address_components[3].long_name === 'Queens') {
                borough = 4
            }
            // Staten Island
            if (placeResultData.address_components[3].long_name === 'Staten Island') {
                borough = 5
            }
            this.property.house_number = addressData.street_number
            this.property.street_name = addressData.route.toUpperCase()
            this.property.borough = borough
            this.property.address = placeResultData.formatted_address.replace(', USA', '')
            console.log('property address from google place api ', placeResultData.formatted_address.replace(', USA', ''))
            this.search(this.property)
        },
        getUser() {
            if (this.$auth.check()) {
                axios.get('/api/auth/user').then((response) => {
                    this.user = response.data.data
                }).catch((error) => this.onError(error))
            }
        },
        search(property) {
            var self = this
            this.isLoading = true
            this.isInvalid = false
            if (property.house_number === '' && property.street_name === '' && property.borough === '') {
                this.isInvalid = true
                this.isLoading = false
            } else {
                axios.post('/api/check/property', {
                    user_id: self.user.id,
                    address: self.property.address
                }).then((response) => {
                    if (response.data.address) {
                        self.isLoading = false
                        console.log('excuted from search method (property already stored) ', response.data)
                        self.$router.push({name: 'overview', params: { address: response.data.address }})
                    }
                    if (response.data === '') {
                        console.log('excuted from search method (property not stored) ', self.property)
                        self.parse(self.property)
                    }
                }).catch((error) => this.onError(error))
            }
        },
        parse(property) {
            var self = this
            fetch(`https://itnqkr2qjj.execute-api.us-east-1.amazonaws.com/dev/overview?house_number=${property.house_number}&street=${property.street_name}&borough=${property.borough}`, {
                method: 'GET'
            }).then((response) => {
                return response.json()
            })
                .then((data) => {
                    console.log('property data returned from property-overview microservice ', data)
                    property.house_number = data.house_number
                    property.street_name = data.street_name
                    property.bin = data.bin
                    property.block = data.block
                    property.lot = data.lot
                    property.borough = data.borough
                    property.coo_uri = data.coo_uri
                    property.cross_streets = data.cross_streets
                    property.complaints_uri = data.complaints_uri
                    property.complaints_total = data.complaints_total
                    property.complaints_open = data.complaints_open
                    property.dob_violations_uri = data.dob_violations_uri
                    property.dob_violations_total = data.dob_violations_total
                    property.dob_violations_open = data.dob_violations_open
                    property.dob_violations_total = data.dob_violations_total
                    property.ecb_violations_uri = data.ecb_violations_uri
                    property.ecb_violations_open = data.ecb_violations_open
                    property.ecb_violations_total = data.ecb_violations_total
                    property.jobs_filings_uri = data.jobs_filings_uri
                    property.jobs_filings_total = data.jobs_filings_total
                    property.ara_laa_uri = data.ara_laa_uri
                    property.total_jobs = data.total_jobs
                    property.actions_uri = data.actions_uri
                    property.actions_total = data.actions_total
                    property.elevator_records_uri = data.elevator_records_uri
                    property.electrical_applications_uri = data.electrical_applications_uri
                    property.permits_in_process_uri = data.permits_in_process_uri
                    property.illuminated_signs_permit_uri = data.illuminated_signs_permit_uri
                    property.dep_boiler_information_uri = data.dep_boiler_information_uri
                    property.crane_information_uri = data.crane_information_uri
                    property.after_hours_permit_uri = data.after_hours_permit_uri
                    property.health_area = data.health_area
                    property.census_tract = data.census_tract
                    property.community_board = data.community_board
                    property.buildings_on_lot = data.buildings_on_lot
                    property.condo = data.condo
                    property.vacant = data.vacant
                    property.zoning_docs_uri = data.zoning_docs_uri
                    property.challenge_results_uri = data.challenge_results_uri
                    property.pre_bis_pa_uri = data.pre_bis_pa_uri
                    property.dob_special_name = data.dob_special_name
                    property.dob_building_remarks = data.dob_building_remarks
                    property.landmark_status = data.landmark_status
                    property.special_status = data.special_status
                    property.local_law = data.local_law
                    property.loft_law = data.loft_law
                    property.sro_restricted = data.sro_restricted
                    property.ta_restricted = data.ta_restricted
                    property.ub_restricted = data.ub_restricted
                    property.environmental_restrictions = data.environmental_restrictions
                    property.grandfathered_sign = data.grandfathered_sign
                    property.legal_adult_use = data.legal_adult_use
                    property.city_owned = data.city_owned
                    property.additional_bins = data.additional_bins
                    property.special_district = data.special_district
                    property.building_classification = data.building_classification
                }).catch((error) => console.error('parse()', error))
        },
        store() {
            var self = this
            console.log('property before being sent to the endpoint ', self.property)
            axios.post('/api/new/property', {
                user_id: self.user.id,
                address: self.property.address,
                house_number: self.property.house_number,
                street_name: self.property.street_name,
                bin: self.property.bin,
                block: self.property.block,
                lot: self.property.lot,
                borough: self.property.borough,
                coo_uri: self.property.coo_uri,
                cross_streets: self.property.cross_streets,
                complaints_uri: self.property.complaints_uri,
                complaints_total: self.property.complaints_total,
                complaints_open: self.property.complaints_open,
                dob_violations_uri: self.property.dob_violations_uri,
                dob_violations_total: self.property.dob_violations_total,
                dob_violations_open: self.property.dob_violations_open,
                ecb_violations_uri: self.property.ecb_violations_uri,
                ecb_violations_total: self.property.ecb_violations_total,
                ecb_violations_open: self.property.ecb_violations_open,
                jobs_filings_uri: self.property.jobs_filings_uri,
                jobs_filings_total: self.property.jobs_filings_total,
                ara_laa_uri: self.property.ara_laa_uri,
                total_jobs: self.property.total_jobs,
                actions_uri: self.property.actions_uri,
                actions_total: self.property.actions_total,
                elevator_records_uri: self.property.elevator_records_uri,
                electrical_applications_uri: self.property.electrical_applications_uri,
                permits_in_process_uri: self.property.permits_in_process_uri,
                illuminated_signs_permit_uri: self.property.illuminated_signs_permit_uri,
                dep_boiler_information_uri: self.property.dep_boiler_information_uri,
                crane_information_uri: self.property.crane_information_uri,
                after_hours_permit_uri: self.property.after_hours_permit_uri,
                health_area: self.property.health_area,
                census_tract: self.property.census_tract,
                community_board: self.property.community_board,
                buildings_on_lot: self.property.buildings_on_lot,
                condo: self.property.condo,
                vacant: self.property.vacant,
                zoning_docs_uri: self.property.zoning_docs_uri,
                challenge_results_uri: self.property.challenge_results_uri,
                pre_bis_pa_uri: self.property.pre_bis_pa_uri,
                dob_special_name: self.property.dob_special_name,
                dob_building_remarks: self.property.dob_building_remarks,
                landmark_status: self.property.landmark_status,
                special_status: self.property.special_status,
                local_law: self.property.local_law,
                loft_law: self.property.loft_law,
                sro_restricted: self.property.sro_restricted,
                ta_restricted: self.property.ta_restricted,
                ub_restricted: self.property.ub_restricted,
                environmental_restrictions: self.property.environmental_restrictions,
                grandfathered_sign: self.property.grandfathered_sign,
                legal_adult_use: self.property.legal_adult_use,
                city_owned: self.property.city_owned,
                additional_bins: self.property.additional_bins,
                special_district: self.property.special_district,
                building_classification: self.property.building_classification
            }).then((response) => {
                self.isLoading = false
                console.log('excuted from store method ', response.data.address)
                self.$router.push({name: 'overview', params: { address: response.data.address }})
            }).catch((error) => this.onError(error))
        },
        result(address) {
            this.$router.push({name: 'overview', params: { address: address }})
        }
    },
    components: {
        VueGoogleAutocomplete
    },
    watch: {
        'property.bin': 'store'
    },
    mounted() {
        this.getUser()
    }
}
</script>
<style>
	#propertySearchInput .btn { 
		padding-top: 0 !important;
		padding-bottom: 0 !important;
	}

	.pac-container {
		z-index: 1051 !important;
	}


	.pac-container .pac-item { 	
		padding-top: 5px !important;
		padding-bottom: 5px !important;
	}

	.pac-container .pac-item:nth-child(1) { 
		border-top: 0 !important;
	}


	.pac-container:after {
	    content:none !important;
	}

	.m-form__help { 
		display: block !important;
		color: #f4516c !important;
		font-weight: 600 !important;
	}

	.form-group { 
		margin-bottom: 0 !important;
	} 
</style>
