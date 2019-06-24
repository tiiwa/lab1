<template>
	<div>
		<div v-if="organization"
			class="organization-thumbnail card-shadow"
		>
			<div class="row">
				<div class="col-md-2">
					<div id="organization-img"
						@click="routeToViewOrganization()">
						<!-- <img class="mx-auto d-block" src="/images/logo.png"> -->
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
									class="location">{{ organization.location }}</p>
							</div>
							<div class="col-md-2">
								<button class="btn"
									@click="routeToViewOrganization()">
									<i class="fas fa-external-link-alt fa-xs float-right"/>
								</button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9">
								<p id="organization-categories"
									class="float-md-left">
									{{ organization.sector }}
								</p>
							</div>
							<div class="col-md-3 my-auto">
								<div v-if="!expand" 
									id="organization-categories"
									class="float-md-right">
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
						<div class="col-md-8 my-auto">
							<div class="square"/>
							<div class="square"/>
							<div class="square"/>
						</div>
						<div class="col-md-4 my-auto">
							<button id="save-button" 
								class="btn float-md-right"
								@click="saveOrganization()">
								<span id="save-text">Save</span>
								<i :class="[organizationSaved ? 'fas fa-heart' : 'far fa-heart', ' align-middle']"
								/>
							</button>

						</div>
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
			console.log("Expand");

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
		margin: 20px;
		background: $white;
		border-radius: 3px;

		#organization-img {
			width: 50px;
			height: 50px;
			margin-top: auto;
			margin-bottom: auto;
			background-color: rgb(58, 96, 179);
			border-radius: 50%;

			img {
				width: 80%;
				// height: 30px;
			}
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

		#save-button {
			padding-right: 6px;
			box-shadow: none;
		}

		#organization-categories {
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
			vertical-align: middle;
			background-color: rgb(131, 131, 131);
			border-radius: 50%;
		}

		// Temporary
		.square {
			display: inline-block;
			width: 60px;
			height: 60px;
			background-color: rgb(58, 96, 179);
		}
	}
</style>
