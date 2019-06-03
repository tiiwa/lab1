<template>
	<div>
		<div v-if="organization"
			class="organization-thumbnail card-shadow">
			<div class=" row organization-details">
				
				
				<h3 v-if="organization.name"
					id="name">{{ organization.name }}</h3>
				
				<p v-if="organization.location"
					id="location">{{ organization.location }}</p>
				
				<div id="contact"
					class="col-md-5">
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
				
				<br>
				
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
</template>

<script>
export default {

	name: "OrganizationDetail",

	data() {
		return {
			organization: null,
		};
	},

	mounted() {
		this.fetch();
	},

	methods: {
		fetch() {
			axios
				.get("/api/org/" + this.$route.params.org_id)
				.then(({data}) => {
					this.organization = data.data;
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

	#name {
		margin-right: 20px;
	}

	#location {
		line-height: 40px;
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

</style>
