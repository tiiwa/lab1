<template>
	<div>
		<div v-if="organization"
			class="organization-thumbnail card-shadow">
			<div class="row organization-details">
				<div class="col-md-2">
					<div id="organization-img">
						<img src="/images/blue_circle.png" >
					</div>
				</div>

				<div class="col-md-10">
					<div id="header-row"
						class="row">
						<div class="col-md-9 middle-col">
							<h4 v-if="organization.name"
								id="name">{{ organization.name }}</h4>

							<p v-if="organization.location"
								id="location">
								<!-- {{ organization.location }} -->
								Ibadan, Nigeria
							</p>

							<img :src="organization_flag_url">
						</div>
						<div class="col-md-3">
							<p id="save-later-text"
								class="float-md-right">
								Save for later
							</p>
						</div>
					</div>
					<div class="row">
						<div id="contact"
							class="col-md-6">
							<p v-if="organization.website"
								id="website"><a :href="organization.website">{{ organization.website }}</a></p>
							<p v-if="organization.email"
								id="email"><a :href="'mailto:' + organization.email">{{ organization.email }}</a></p>
							<p v-if="organization.phone"
								id="phone">{{ organization.phone }}</p>

							<br>

							<p id="facebook_profile">
								<a :href="organization.facebook_profile">
									<i v-if="organization.facebook_profile"
										class="fab fa-facebook"/> {{ organization.facebook_profile }}
								</a>
							</p>
							<p id="twitter_profile">
								<a :href="organization.twitter_profile">
									<i v-if="organization.twitter_profile"
										class="fab fa-twitter"/> {{ organization.twitter_profile }}
								</a>
							</p>
							<p id="instagram_profile">
								<a :href="organization.instagram_profile">
									<i v-if="organization.instagram_profile"
										class="fab fa-instagram"/> {{ organization.instagram_profile }}
								</a>
							</p>

							<br>

							<p v-if="organization.size_range"
								id="size_range"><b>Size: </b>{{ organization.size_range }}</p>
							<p v-if="organization.operating_language"
								id="operating_language"><b>Operating Language: </b>{{ organization.operating_language }}</p>
							<p v-if="organization.target_locations"
								id="target_locations"><b>Target Locations: </b>{{ organization.target_locations }}</p>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<p id="header-categories"
										class="float-md-right">
										Sector: {{ organization.sector }}
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div v-for="category in categories"
										:key="category">
										<p id="header-categories"
											class="float-md-right">
											{{ category }}
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 middle-col">
							<div>
								<p v-if="organization.description"
									id="description">{{ organization.description }}</p>
							</div>

							<br>

							<div v-if="organization.director[0] || organization.poc[0]"
								id="people">
								<h5>People</h5>
								<hr>
								<p v-if="organization.director[0]"
									id="director"><b>Director: </b>{{ organization.director[0].first_name }} {{ organization.director[0].last_name }}</p>
								<p v-if="organization.poc[0]"
									id="poc"><b>Contact Person: </b>{{ organization.poc[0].first_name }} {{ organization.poc[0].last_name }}</p>


								<br>
							</div>

							<div id="social">

								<h5> Profile </h5>
								<hr>

								<p v-if="organization.legal_entity_type"
									id="legal_entity_type"><b>Legal Entity Type: </b>{{ organization.legal_entity_type }}</p>
								<p v-if="organization.summary_of_needs"
									id="summary_of_needs"><b>Summary of Needs: </b>{{ organization.summary_of_needs }}</p>
								<p v-if="organization.audience"
									id="audience"><b>Audience: </b>{{ organization.audience }}</p>
								<p v-if="organization.inception_date"
									id="inception_date"><b>Conception Date: </b>{{ organization.inception_date }}</p>
								<p v-if="organization.sector"
									id="sector"><b>Sector: </b>{{ organization.sector }}</p>
								<p v-if="organization.services"
									id="services"><b>Services: </b>{{ organization.services }}</p>
								<p v-if="organization.funding_status"
									id="funding_status"><b>Funding Status: </b>{{ organization.funding_status }}</p>
								<p v-if="organization.funding_type"
									id="funding_type"><b>Funding Type: </b>{{ organization.funding_type }}</p>
								<p v-if="organization.method_of_collection"
									id="method_of_collection"><b>Method of Collection: </b>{{ organization.method_of_collection }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {

	name: "OrganizationDetail",

	data() {
		return {
			organization: null,
			organization_flag_url: null,
			// To do: categories from actual source
			categories: ["Food & Agriculture", "Food Scarcity"]
		};
	},

	// computed: {
	// 	categories(){
	// 			return this.categories;
	// 	}
	// },

	mounted() {
		this.fetch();
	},

	methods: {
		fetch() {
			axios
				.get("/api/org/" + this.$route.params.org_id)
				.then(({data}) => {
					this.organization = data.data;

					// To do: Get flag country code from database
					let country_code = "ng";
					this.organization_flag_url = "https://www.countryflags.io/" + country_code + "/flat/16.png";
				})
				.catch(error => {
					toastr["error"](error.response.data.message);
				});
		}
	}

};
</script>

<style lang="scss" scoped>

	.organization-thumbnail {
		padding: 50px;
		margin: 20px;
		background: $white;
		border-radius: 15px;
	}

	.middle-col {
		padding-left: 0;
	}

	#organization-img img {
		position: relative;
		height: 120px;
		padding: 10px;
		border-radius: 50%;
	}

	#header-row {
		margin-bottom: 5px;
	}

	#name {
		display: inline-block;
		margin-right: 10px;
		margin-bottom: 2px;
	}

	#location {
		display: inline-block;
		margin-bottom: 2px;
		font-size: 16px;
	}

	#contact {
		padding: 10px;
		margin-bottom: 20px;
		font-size: 13px;
		background: #f3f3f3;

		p {
			margin-bottom: 5px;
		}
	}

	#save-later-text {
		display: inline-block;
		margin: 2px;
	}

	#header-categories {
		padding: 5px;
		padding-top: 0;
		padding-bottom: 0;
		margin: 0.3em;
		font-size: 10px;
		color: rgb(160, 160, 160);
		border-color: rgb(140, 140, 140);
		border-style: solid;
		border-width: 1px;
		border-radius: 4px;
	}
</style>
