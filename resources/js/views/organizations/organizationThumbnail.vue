<template>
	<div>
		<div v-if="organization"
			class="organization-thumbnail card-shadow"
		>
			<div class="row">
				<div class="col-md-2">
					<div id="organization-img"
						:class="{ dummy: !organization.logo }"
						class="mx-auto cente"
						@click="routeToViewOrganization()">
						<img :src="organization.logo"
							class="mx-auto d-block">
					</div>
				</div>
				<div class="col-md-10 my-auto"
				>
					<div class="organization-details"
						@click="expandThumbnail()">
						<div class="row">
							<div class="col-md-10">
								<h3 id="organization-name"
									class="name">{{ organization.name }}</h3>
								<p id="organization-loc"
									class="location">{{ organizationLocation }}</p>
							</div>
							<div class="col-md-2 my-auto">
								<button id="expand-button"
									class="btn float-md-right"
									@click="routeToViewOrganization()">
									<i class="fas fa-external-link-alt fa-sm float-right"/>
								</button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9">
								<p class="organization-categories float-md-left">
									{{ organization.sector }}
								</p>
							</div>
							<div class="col-md-3 my-auto">
								<div v-if="!expand"
									class="organization-categories float-md-right">
									<!-- To do: Get images from database -->
									<span class="dot"/>
									<span class="dot"/>
									<span class="dot"/>
								</div>
							</div>
						</div>
					</div>
					<div v-if="expand"
						transition="fade"
						class="row">
						<!-- Use for showing sample images -->
						<!-- <div class="col-md-8 my-auto">
							<div class="preview-square"/>
							<div class="preview-square"/>
							<div class="preview-square"/>
						</div> -->
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
		}
	},

	data() {
		return {
			expand: false,
			organizationSaved: false
		};
	},

	computed: {
		organizationLocation() {
			return `${this.organization.address}, ${this.organization.country}`;
		},
		organizationHasLogo() {
			return this.organization.logo != null;
		}
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
		expandThumbnail() {
			// Flip expand property
			this.expand = !this.expand;
		},
		saveOrganization() {
			this.organizationSaved = !this.organizationSaved;
		}
	}

};
</script>

<style lang="scss" scoped>

	.organization-thumbnail {
		padding: 20px;
		margin: 20px 2px;
		background: $white;
		border-radius: 2px;

		#organization-img {
			display: table-cell;
			float: none;
			width: 50px;
			height: 50px;
			vertical-align: middle;
			border-radius: 50%;

			img {
				width: 90%;
			}
		}

		.dummy {
			// width: 50px;
			// height: 50px;
			// margin-top: auto;
			// margin-bottom: auto;
			background-color: #828283;
		}

		#organization-name {
			margin-bottom: 2px;
			font-size: 20px;
		}

		#organization-loc {
			margin-bottom: 2px;
			font-size: 12px;
		}

		#save-text {
			padding-right: 5px;
			font-size: 10px;
		}

		#expand-button {
			padding-right: 6px;
			box-shadow: none;
		}

		.organization-categories {
			padding: 5px;
			padding-top: 0;
			padding-bottom: 0;
			margin: 0.4em;
			margin-left: 0;
			font-size: 10px;
			color: rgb(131, 131, 131);
			background-color: rgb(219, 219, 219);
			border-style: none;
			border-radius: 3px;
		}

		/* always present */
		.fade-transition {
			transition: all 0.3s ease;
		}

		/* .expand-enter defines the starting state for entering */

		/* .expand-leave defines the ending state for leaving */

		.fade-enter,
		.fade-leave {
			height: 0;
			padding: 0 10px;
			opacity: 0;
		}

		.dot {
			display: inline-block;
			width: 3px;
			height: 3px;
			color: #091e35;
			vertical-align: middle;
			background-color: rgb(131, 131, 131);
			border-radius: 50%;
		}

		.preview-square {
			display: inline-block;
			width: 66px;
			height: 66px;
			background-color: #ff525b;
		}
	}
</style>
