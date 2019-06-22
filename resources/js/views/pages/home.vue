<template>
	<div class="home">
		<search-bar @search-results="setSearchResults"
			@clear-search="clearSearch"/>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<filter-box @search-results="setSearchResults"
						@clear-search="clearSearch"/>

					<div id="results-container">
						<p v-if="no_results"
							id="no-results">No results found, try a different query.</p>
						<div v-if="orgs">
							<div v-for="org in orgs"
								:key="org.id">
								<organizationThumbnail :organization="org"/>
							</div>
						</div>
					</div>
					
				</div>

				<div class="col-md-6">
					<map-component />
				</div>
			
			</div>
		</div>
	</div>
</template>

<script>
import organizationThumbnail from "../organizations/organizationThumbnail";
import searchBar from "../../modules/searchBar";
import filterBox from "../../modules/filterBox";
import mapComponent from "../../modules/mapComponent";


export default {
	name: "Home",

	components: {
		organizationThumbnail,
		searchBar,
		filterBox,
		mapComponent,
	},

	data() {
		return {
			endpoint: "home",
			organizations: [],
			default_orgs: null,
			no_results: false,
		};
	},
	
	computed: {
		orgs(){
			if (this.no_results){
				return this.default_orgs;
			}
			else {
				return this.organizations;
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
			if ($results === [] || $results.length === 0 ){
				this.no_results = true;
			} else {
				this.no_results = false;
				this.organizations = $results;
			}
			
		},
		
		clearSearch() {
			this.organizations = this.default_orgs;
		}
	}
};
</script>


<style lang="scss" scoped>
	#results-container {
		height: 700px;
		overflow: scroll;
	}

	#no-results {
		padding: 10px;
		text-align: center;
	}
</style>
