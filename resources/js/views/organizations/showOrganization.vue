<template>
	<div>
		<div v-if="organization"
			class="organization-thumbnail">
			<div class="organization-details">
				<h3 v-if="organization.name"
					class="name">{{ organization.name }}</h3>
				<p v-if="organization.location"
					class="location">{{ organization.location }}</p>
				<p v-if="organization.description"
					class="description">{{ organization.description }}</p>
				<div class="people">
					<p v-if="organization.director[0]"
						class="director"><b>Director: </b>{{ organization.director[0].first_name }} {{ organization.director[0].last_name }}</p>
					<p v-if="organization.poc[0]"
						class="poc"><b>Contact Person: </b>{{ organization.poc[0].first_name }} {{ organization.poc[0].last_name }}</p>
				</div>
				<div class="contact">
					<p v-if="organization.phone"
						class="phone"><b>Phone: </b>{{ organization.phone }}</p>
					<p v-if="organization.email"
						class="email"><b>Email: </b>{{ organization.email }}</p>
					<p v-if="organization.website"
						class="website"><b>Website: </b>{{ organization.website }}</p>
					<p v-if="organization.size_range"
						class="size_range"><b>Size Range: </b>{{ organization.size_range }}</p>
					<p v-if="organization.legal_entity_type"
						class="legal_entity_type"><b>Legal Entity Type: </b>{{ organization.legal_entity_type }}</p>
					<p v-if="organization.summary_of_needs"
						class="summary_of_needs"><b>Summary of Needs: </b>{{ organization.summary_of_needs }}</p>
					<p v-if="organization.audience"
						class="audience"><b>Audience: </b>{{ organization.audience }}</p>
					<p v-if="organization.inception_date"
						class="inception_date"><b>Conception Date: </b>{{ organization.inception_date }}</p>
					<p v-if="organization.target_locations"
						class="target_locations"><b>Target Locations: </b>{{ organization.target_locations }}</p>
					<p v-if="organization.sector"
						class="sector"><b>Sector: </b>{{ organization.sector }}</p>
					<p v-if="organization.services"
						class="services"><b>Services: </b>{{ organization.services }}</p>
					<p class="facebook_profile">
						<i v-if="organization.facebook_profile"
							class="fab fa-facebook"/> {{ organization.facebook_profile }}
					</p>
					<p class="twitter_profile">
						<i v-if="organization.twitter_profile"
							class="fab fa-twitter"/> {{ organization.twitter_profile }}
					</p>
					<p class="instagram_profile">
						<i v-if="organization.instagram_profile"
							class="fab fa-instagram"/> {{ organization.instagram_profile }}
					</p>
					<p v-if="organization.funding_status"
						class="funding_status"><b>Funding Status: </b>{{ organization.funding_status }}</p>
					<p v-if="organization.funding_type"
						class="funding_type"><b>Funding Type: </b>{{ organization.funding_type }}</p>
					<p v-if="organization.operating_language"
						class="operating_language"><b>Operating Language: </b>{{ organization.operating_language }}</p>
					<p v-if="organization.method_of_collection"
						class="method_of_collection"><b>Method of Collection: </b>{{ organization.method_of_collection }}</p>
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
		padding: 20px;
		margin: 20px;
		background: $white;
		border-radius: 15px;
	}

</style>
