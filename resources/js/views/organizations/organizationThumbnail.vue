<template>
	<div>
		<div v-if="organization"
			class="organization-thumbnail card-shadow"
			@click="routeToViewOrganization()">
			<div class="row">
				<div class="col-md-3">
					<div id="organization-img">
						<img src="/images/logo.png" >
					</div>
				</div>
				<div class="col-md-9">
					<div class="organization-details">
						<h3 id="organization-name"
							class="name">{{ organization.name }}</h3>
						<p id="organization-loc"
							class="location">{{ organization.location }}</p>
					</div>
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

		#organization-img img {
			height: 40px;
			border-radius: 50%;
		}

		#organization-name {
			font-size: 20px;
		}

		#organization-loc {
			font-size: 12px;
		}
	}
</style>
