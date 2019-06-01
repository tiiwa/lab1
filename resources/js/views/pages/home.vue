<template>
	<div class="home">
		<search-bar @search-results="setSearchResults"
			@clear-search="clearSearch"/>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div v-if="orgs">
						<div v-for="org in organizations"
							:key="org.id">
							<organizationThumbnail :organization="org"/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import organizationThumbnail from "../organizations/organizationThumbnail";
import searchBar from "../../modules/searchBar";

export default {
	name: "Home",

	components: {
		organizationThumbnail,
		searchBar
	},

	data() {
		return {
			endpoint: "home",
			organizations: null,
			default_orgs: null
		};
	},
	
	computed: {
		orgs(){
			if (this.organizations === null || !this.organizations.length ){
				return this.organizations;
			}
			else {
				return this.default_orgs;
			}
		}
	},

	mounted() {
		this.fetch();
	},
	methods: {
		fetch() {
			if (this.endpoint) {
				axios
					.get("api/" + this.endpoint)
					.then(({ data }) => {
						this.organizations = data.data;
						this.default_orgs = data.data;
					})
					.catch(error => {
						toastr["error"](error.response.data.message);
					});
			}
		},
		
		setSearchResults($results) {
			this.organizations = $results;
		},
		
		clearSearch() {
			this.organizations = this.default_orgs;
		}
	}
};
</script>


<style lang="scss" scoped>
</style>
