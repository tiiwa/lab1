<template>
	<div>
		<div v-if="organization"
			class="organization-thumbnail"
			@click="routeToViewOrganization()">
			<div class="organization-details">
				<h3 class="name">{{ organization.name }}</h3>
				<p class="location">{{ organization.location }}</p>
				<p class="description">{{ organization.description }}</p>
				<div class="contact">
					<p class="website">{{ organization.website }}</p>
					<p class="email">{{ organization.email }}</p>
					<p class="phone">{{ organization.phone }}</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {

	name: "OrganizationThumbnail",

	props: {
		organization: {
			type: Object,
			default: null,
		},
	},

	data() {
		return {
		};
	},

	mounted() {
	},

	methods: {
		routeToViewOrganization() {
			return this.$router.push({
				name: "showOrganization",
				params: {
					org_id: this.organization.id,
				}
			});

		},
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
