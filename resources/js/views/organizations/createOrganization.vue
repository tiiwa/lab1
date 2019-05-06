<template>
	<div>
		<div id="org_form"
			class="row">
			<div class="page-section col-md-8 offset-md-2">
				
				<h1>Nominate a Company</h1>
				<p>If you know any African Companies that are doing impactful work on the continent, please fill out
				the form with their information and a few words about why you're nominating them. </p>
				
				<br>
				
				<form enctype="multipart/form-data"
					@submit.prevent="submitOrg">
					
					<h3>Your Information</h3>
					<br>
					
					<!-- POC Name -->
					<div class="form-group row">
						<label for="poc_name"
							class="col-md-3 control-label">Your Name</label>
						<input v-validate
							id="poc_name"
							:class="{'has-error': errors.has('poc_name') }"
							v-model="orgForm.poc"
							name="poc_name"
							data-vv-as="submitter name"
							type="text"
							class="col-md-9 form-control"
							placeholder="Enter Your Name"
						>
						<p v-if="errors.has('poc_name')"
							class="validation-error text-danger col-md-9 offset-md-3">{{ errors.first('poc_name') }}</p>
					</div>
					
					<!-- POC Email -->
					<div class="form-group row">
						<label for="poc_email"
							class="col-md-3 control-label">Your Email <span class="required">*</span></label>
						<input v-validate="'required'"
							id="poc_email"
							:class="{'has-error': errors.has('poc_email') }"
							v-model="orgForm.poc_email"
							name="poc_email"
							data-vv-as="submitter email"
							type="email"
							class="col-md-9 form-control"
							placeholder="Enter Your Email"
						>
						<p v-if="errors.has('poc_email')"
							class="validation-error text-danger col-md-9 offset-md-3">{{ errors.first('poc_email')
							}}</p>
					</div>
					
					<br>
					<hr>
					<br>
					
					<h3>Organization Information</h3>
					<br>
					
					<b>Basic Information</b>
					<hr>
					
					<!-- Name -->
					<div class="form-group row">
						<label for="name"
							class="col-md-3 control-label">Name <span class="required">*</span></label>
						<input v-validate="'required'"
							id="name"
							:class="{'has-error': errors.has('name') }"
							v-model="orgForm.name"
							name="name"
							type="text"
							class="col-md-9 form-control"
							placeholder="Enter organization's name"
						>
						<p v-if="errors.has('name')"
							class="validation-error text-danger col-md-9 offset-md-3">{{ errors.first('name') }}</p>
					</div>
					
					<!-- Location -->
					<div class="form-group row">
						<label for="location"
							class="col-md-3 control-label">Location <span class="required">*</span></label>
						<input v-validate="'required'"
							id="location"
							:class="{'has-error': errors.has('location') }"
							v-model="orgForm.location"
							name="location"
							type="text"
							class="col-md-9 form-control"
							placeholder="Where is the organization run from?"
						>
						<p v-if="errors.has('location')"
							class="validation-error text-danger col-md-9 offset-md-3">{{ errors.first('location') }}</p>
					</div>
					
					<!-- Description -->
					<div class="form-group row">
						<label for="description"
							class="col-md-3 control-label">Description <span class="required">*</span></label>
						<textarea v-validate="'max:400'"
							id="description"
							:class="{'has-error': errors.has('description') }"
							v-model="orgForm.description"
							data-vv-validate-on="keyup"
							name="description"
							rows="4"
							class="col-md-9 form-control"
							placeholder="Give a general description of the company"
						/>
						<p v-if="errors.has('description')"
							class="validation-error text-danger col-md-9 offset-md-3">{{ errors.first('description') }}</p>
					</div>
					
					<br>
					<b>Contact</b>
					<p>Fill in at least one of the following: <span class="required">*</span></p>
					<hr>
					
					<!-- Email -->
					<div class="form-group row">
						<label for="email"
							class="col-md-3 control-label">Email</label>
						<input v-validate="'{ rules: { required: this.isPhoneRequired }, email: true }'"
							id="email"
							:class="{'has-error': errors.has('email') }"
							v-model="orgForm.email"
							name="email"
							type="email"
							class="col-md-9 form-control"
							placeholder="Enter organization's email"
						>
						<p v-if="errors.has('email')"
							class="validation-error text-danger col-md-9 offset-md-3">{{ errors.first('email') }}</p>
					</div>
					
					<!-- Phone -->
					<div class="form-group row">
						<label for="phone"
							class="col-md-3 control-label">Phone</label>
						<input v-validate="'{ rules: { required: this.isPhoneRequired } }'"
							id="phone"
							:class="{'has-error': errors.has('phone') }"
							v-model="orgForm.phone"
							name="phone"
							type="tel"
							class="col-md-9 form-control"
							placeholder="Enter organization's contact number including the country code"
						>
						<p v-if="errors.has('phone')"
							class="validation-error text-danger col-md-9 offset-md-3">{{ errors.first('phone') }}</p>
					</div>
					
					<!-- Website -->
					<div class="form-group row">
						<label for="website"
							class="col-md-3 control-label">Website</label>
						<input v-validate="'{ rules: { required: this.isWebsiteRequired, url: true } }'"
							id="website"
							:class="{'has-error': errors.has('website') }"
							v-model="orgForm.website"
							name="website"
							type="url"
							class="col-md-9 form-control"
							placeholder="Enter organization's website URL"
						>
						<p v-if="errors.has('website')"
							class="validation-error text-danger col-md-9 offset-md-3">{{ errors.first('website') }}</p>
					</div>
					
					<br>
					<b>Social</b>
					<hr>
					
					<!-- Facebook -->
					<div class="form-group row">
						<label for="facebook_profile"
							class="col-md-3 control-label">
							<i class="fab fa-2x fa-facebook"/>
						</label>
						<input v-validate="'url'"
							id="facebook_profile"
							:class="{'has-error': errors.has('facebook_profile') }"
							v-model="orgForm.facebook_profile"
							name="facebook_profile"
							type="text"
							class="col-md-9 form-control"
							placeholder="Organizations Facebook URL"
						>
						<p v-if="errors.has('facebook_profile')"
							class="validation-error text-danger col-md-9 offset-md-3">
							{{ errors.first('facebook_profile') }}</p>
					</div>
					
					<!-- Twitter -->
					<div class="form-group row">
						<label for="twitter_profile"
							class="col-md-3 control-label">
							<i class="fab fa-2x fa-twitter"/>
						</label>
						<input v-validate="'url'"
							id="twitter_profile"
							:class="{'has-error': errors.has('twitter_profile') }"
							v-model="orgForm.twitter_profile"
							name="twitter_profile"
							type="text"
							class="col-md-9 form-control"
							placeholder="Organizations Twitter URL"
						>
						<p v-if="errors.has('twitter_profile')"
							class="validation-error text-danger col-md-9 offset-md-3">
							{{ errors.first('twitter_profile') }}
						</p>
					</div>
					
					<!-- Instagram -->
					<div class="form-group row">
						<label for="instagram_profile"
							class="col-md-3 control-label">
							<i class="fab fa-2x fa-instagram"/>
						</label>
						<input v-validate="'url'"
							id="instagram_profile"
							:class="{'has-error': errors.has('instagram_profile') }"
							v-model="orgForm.instagram_profile"
							name="instagram_profile"
							type="text"
							class="col-md-9 form-control"
							placeholder="Organizations Instagram URL"
						>
						<p v-if="errors.has('instagram_profile')"
							class="validation-error text-danger col-md-9 offset-md-3">
							{{ errors.first('instagram_profile') }}
						</p>
					</div>
					
					<br>
					<b>Profile</b>
					<hr>
					
					<!-- Inception Date -->
					<div class="form-group row">
						<label for="inception_date"
							class="col-md-3 control-label">Inception Date</label>
						<v-date-picker v-model="orgForm.inception_date"
							:max-date="new Date()"
							class="col-md-9 p-0"
							mode="single">
							<input v-validate
								id="inception_date"
								:class="{'has-error': errors.has('inception_date') }"
								v-model="formatted_inception_date"
								name="inception_date"
								class="col-md-12 form-control"
								placeholder="Approximate date company was started">
						</v-date-picker>
					</div>
					<p v-if="errors.has('inception_date')"
						class="validation-error text-danger col-md-9 offset-md-3">
						{{ errors.first('inception_date') }}
					</p>
					
					<!-- Operating Languages -->
					<div class="form-group row">
						<label for="operating_language"
							class="col-md-3 control-label">Operating Languages</label>
						<div class="col-md-9 p-0">
							<multiselect v-validate
								id="operating_language"
								v-model="orgForm.operating_language"
								:options="org_operating_languages"
								:show-labels="false"
								:close-on-select="false"
								:multiple="true"
								name="operating_language"
								placeholder="What languages does this organization operate in?"/>
						</div>
					</div>
					
					<!-- Size Range -->
					<div class="form-group row">
						<label for="size_range"
							class="col-md-3 control-label">Size Range</label>
						<div class="col-md-9 p-0">
							<multiselect v-validate
								id="size_range"
								v-model="orgForm.size_range"
								:options="org_sizes"
								:show-labels="false"
								name="size_range"
								placeholder="Select approximate size of organization"/>
						</div>
					</div>
					
					<!-- Sector -->
					<div class="form-group row">
						<label for="sector"
							class="col-md-3 control-label">Sector</label>
						<div class="col-md-9 p-0">
							<multiselect v-validate
								id="sector"
								v-model="orgForm.sector"
								:options="org_sectors"
								:show-labels="false"
								name="sector"
								placeholder="What sector does the organization operate in?"/>
						</div>
					</div>
					
					<!-- Services -->
					<div class="form-group row">
						<label for="services"
							class="col-md-3 control-label">Services</label>
						<textarea v-validate="'max:400'"
							id="services"
							v-model="orgForm.services"
							name="services"
							rows="4"
							class="col-md-9 form-control"
							placeholder="What services does the organization offer?"
						/>
						<p v-if="errors.has('services')"
							class="validation-error text-danger col-md-9 offset-md-3">
							{{ errors.first('services') }}
						</p>
					</div>
					
					<!-- Audience -->
					<div class="form-group row">
						<label for="audience"
							class="col-md-3 control-label">Audience</label>
						<div class="col-md-9 p-0">
							<multiselect v-validate
								id="audience"
								v-model="orgForm.audience"
								:options="org_audiences"
								:show-labels="false"
								name="audience"
								placeholder="Who does this organization cater to?"/>
						</div>
					</div>
					
					<!-- Target Location -->
					<div class="form-group row">
						<label for="target_locations"
							class="col-md-3 control-label">Target Locations</label>
						<input
							id="target_locations"
							:class="{'has-error': errors.has('target_locations') }"
							v-model="orgForm.target_locations"
							name="target_locations"
							type="text"
							class="col-md-9 form-control"
							placeholder="Where are their services located?"
						>
						<p v-if="errors.has('target_locations')"
							class="validation-error text-danger col-md-9 offset-md-3">
							{{ errors.first('target_locations') }}
						</p>
					</div>
					
					<!-- Legal Entity Type -->
					<div class="form-group row">
						<label for="legal_entity_type"
							class="col-md-3 control-label">Legal Entity Type</label>
						<div class="col-md-9 p-0">
							<multiselect v-validate
								id="legal_entity_type"
								v-model="orgForm.legal_entity_type"
								:options="org_legal_entities"
								:show-labels="false"
								name="legal_entity_type"
								placeholder="How is the organization operated?"/>
						</div>
					</div>
					
					<!-- Funding Status -->
					<div class="form-group row">
						<label for="funding_status"
							class="col-md-3 control-label">Funding Status</label>
						<div class="col-md-9 p-0">
							<multiselect v-validate
								id="funding_status"
								v-model="orgForm.funding_status"
								:options="org_funding_statuses"
								:show-labels="false"
								name="funding_status"
								placeholder="What is the current status of the organizations funding?"/>
						</div>
					</div>
					
					<!-- Funding Type -->
					<div class="form-group row">
						<label for="funding_type"
							class="col-md-3 control-label">Funding Type</label>
						<div class="col-md-9 p-0">
							<multiselect v-validate
								id="funding_type"
								v-model="orgForm.funding_type"
								:options="org_funding_types"
								:show-labels="false"
								name="funding_type"
								placeholder="How is the organization funded?"/>
						</div>
					</div>
					
					<!-- Summary of Needs -->
					<div class="form-group row">
						<label for="summary_of_needs"
							class="col-md-3 control-label">Summary of Needs</label>
						<textarea v-validate
							id="summary_of_needs"
							v-model="orgForm.summary_of_needs"
							name="summary_of_needs"
							rows="4"
							class="col-md-9 form-control"
							placeholder="How can this organization be helped?"
						/>
					</div>
					
					<!-- Method of Collection -->
					<div class="form-group row"
						hidden>
						<label for="method_of_collection"
							class="col-md-3 control-label">Method Of Collection</label>
						<input
							id="method_of_collection"
							:class="{'has-error': errors.has('method_of_collection') }"
							v-model="orgForm.method_of_collection"
							name="method_of_collection"
							type="text"
							class="col-md-9 form-control"
							placeholder="Enter title"
						>
						<p v-if="errors.has('method_of_collection')"
							class="validation-error text-danger col-md-9 offset-md-3">
							{{ errors.first('method_of_collection') }}
						</p>
					</div>
					
					
					<br>
					<b>People</b>
					<hr>
					
					<!-- Director -->
					<div class="form-group row">
						<label for="director"
							class="col-md-3 control-label">Director</label>
						<input v-validate
							id="director"
							:class="{'has-error': errors.has('director') }"
							v-model="orgForm.director"
							name="director"
							type="text"
							class="col-md-9 form-control"
							placeholder="Enter Director's Name"
						>
						<p v-if="errors.has('director')"
							class="validation-error text-danger col-md-9 offset-md-3">
							{{ errors.first('director') }}
						</p>
					</div>
					
					<!-- Page action buttons -->
					<div class="row">
						<div class="col-md-12 form-group">
							<button :disabled="!(errors.items.length <= 0) || isSaving || !changed"
								type="button"
								class="btn btn-success"
								@click="submitOrg"
							>
								<i v-if="isSaving"
									class="fas fa-circle-notch fa-spin"/>
								<span>Save</span>
							</button>
							<button type="button"
								class="btn btn-warning">
								<span>Cancel</span>
							</button>
							<button v-if="organization"
								:disabled="isDeleting"
								type="button"
								class="btn btn-danger">
								<span>
									<i v-if="isDeleting"
										class="fas fa-circle-notch fa-spin"/>
									Delete
								</span>
							</button>
						</div>
					</div>
				
				</form>
			
			</div>
		</div>
	</div>
</template>

<script>

import Multiselect from "vue-multiselect";

export default {
	
	name: "OrganizationForm",
	
	components: {
		Multiselect,
	},
	
	data() {
		return {
			organization: null,
			orgForm: new Form({
				autoReset: false,
				name: "",
				location: "",
				description: "",
				phone: "",
				email: "",
				website: "",
				size_range: "",
				legal_entity_type: "",
				summary_of_needs: "",
				audience: "",
				inception_date: null,
				target_locations: "",
				sector: "",
				services: "",
				facebook_profile: "",
				twitter_profile: "",
				instagram_profile: "",
				funding_status: "",
				funding_type: "",
				operating_language: "",
				method_of_collection: "",
				director: "",
				poc: "",
			}),
			org_sizes: ["1-5", "5-15", "15-50", "50-500", "500-1000", "1000+"],
			org_legal_entities: ["Non-Profit", "For-Profit", "Charitable", "Trust", "Foundation"],
			org_audiences: ["Other Businesses", "Consumer classes", "Government/Policy", "Underserved"],
			org_funding_statuses: ["Fundraising", "Fully Funded", "Private Equity", "Public"],
			org_funding_types: ["Grants", "Donations", "Debt"],
			org_sectors: ["Graphic Design", "Professional Practice", "Finance & Investments",
				"Metals & Base Metals", "Environmental Chemistry", "Computer Science", "Electrical & Electronics Engineering",
				"Environmental Management", "Environmental Science", "World Trade Associations",],
			org_operating_languages: ["English", "French", "Swahili", "Portuguese", "Arabic", "Amharic"],
			isSaving: false,
			isDeleting: false,
		};
	},
	
	computed: {
		
		isEmailRequired() {
			return this.orgForm.phone === "" && this.orgForm.website === "";
		},
		
		isPhoneRequired() {
			return this.orgForm.email === "" && this.orgForm.website === "";
		},
		
		isWebsiteRequired() {
			return this.orgForm.phone === "" && this.orgForm.email === "";
		},
		
		formatted_inception_date() {
			
			if (this.orgForm.inception_date) {
				const monthNames = ["January", "February", "March", "April", "May", "June",
					"July", "August", "September", "October", "November", "December"
				];
				
				
				let i = this.orgForm.inception_date.getDate(),
					j = i % 10,
					k = i % 100,
					sufx = "th";
				if (j === 1 && k !== 11) {
					sufx = "st";
				}
				if (j === 2 && k !== 12) {
					sufx = "nd";
				}
				if (j === 3 && k !== 13) {
					sufx = + "rd";
				}
				
				return i + sufx + " " +
					(monthNames[this.orgForm.inception_date.getMonth()]) + " " +
						this.orgForm.inception_date.getFullYear();
			}
		},
		
		changed() {
			return Object.keys(this.fields).some(key => this.fields[key].dirty);
		}
	},
	
	mounted() {
		// this.fetch();
	},
	
	methods: {
		submitOrg() {
			axios
				.post("/api/org/")
				.then(({data}) => {
					this.organization = data.data;
				})
				.catch(error => {
					toastr["error"](error.response.data.message);
				});
		},
		
		
		// Delete lesson
		deleteOrg() {
			this.isDeleting = true;
			try {
				return axios
					.delete(`/api/lesson/${this.organization.id}`)
					.then(data => {
						this.$router.replace({
							path: "/"
						});
						this.isSaving = false;
					});
			} catch (error) {
				this.isDeleting = false;
				return toastr["error"](
					"An error occurred while deleting lesson"
				);
			}
		},
	}
	
};
</script>

<style lang="scss" scoped>

</style>
