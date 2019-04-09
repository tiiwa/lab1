<template>
	<div>
		<div v-if="organization"
			class="organization-thumbnail"
			@click="routeToViewOrganization()">
			<div class="organization-details">
				<h3 class="name">{{ organization.name }}</h3>
				<p class="location">{{ organization.location }}</p>
				<p class="description">{{ organization.description }}</p>
				<div class="people">
					<p class="director"><b>Director: </b>{{ organization.director.name }}</p>
					<p class="poc"><b>Contact Person: </b>{{ organization.poc.name }}</p>
				</div>
				<div class="details">
					<p class="phone"><b>Phone: </b>{{ organization.phone }}</p>
					<p class="email"><b>Email: </b>{{ organization.email }}</p>
					<p class="website"><b>Website: </b>{{ organization.website }}</p>
					<p class="size_range"><b>Size Range: </b>{{ organization.size_range }}</p>
					<p class="legal_entity_type"><b>Legal Entity Type: </b>{{ organization.legal_entity_type }}</p>
					<p class="summary_of_needs"><b>Summary of Needs: </b>{{ organization.summary_of_needs }}</p>
					<p class="audience"><b>Audience: </b>{{ organization.audience }}</p>
					<p class="inception_date"><b>Conception Date: </b>{{ organization.inception_date }}</p>
					<p class="target_locations"><b>Target Locations: </b>{{ organization.target_locations }}</p>
					<p class="sector"><b>Sector: </b>{{ organization.sector }}</p>
					<p class="services"><b>Services: </b>{{ organization.services }}</p>
					<p class="facebook_profile">
						<i class="fab fa-facebook"/> {{ organization.facebook_profile }}
					</p>
					<p class="twitter_profile">
						<i class="fab fa-twitter"/> {{ organization.twitter_profile }}
					</p>
					<p class="instagram_profile">
						<i class="fab fa-instagram"/> {{ organization.instagram_profile }}
					</p>
					<p class="funding_status"><b>Funding_status: </b>{{ organization.funding_status }}</p>
					<p class="funding_type"><b>Funding_type: </b>{{ organization.funding_type }}</p>
					<p class="operating_language"><b>Operating_language: </b>{{ organization.operating_language }}</p>
					<p class="method_of_collection"><b>Method_of_collection: </b>{{ organization.method_of_collection }}</p>
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
