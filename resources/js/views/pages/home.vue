<template>
	<div class="home">
		<search-bar/>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<filter-box/>

					<div id="results-container">
						<p v-if="noResults"
							id="no-results">No results found, try a different query.</p>
						<div v-if="orgs">
							<div v-for="org in orgs"
								:key="org.id">
								<organizationThumbnail :organization="org"/>
							</div>
						</div>
					</div>
					
				</div>

				<div class="col-md-8">
					<discover-map />
				</div>
			
			</div>
		</div>
	</div>
</template>

<script>
import organizationThumbnail from "../organizations/organizationThumbnail";
import searchBar from "../../modules/searchBar";
import filterBox from "../../modules/filterBox";
import discoverMap from "../../modules/discoverMap";
import { createNamespacedHelpers } from 'vuex';

const { mapState } = createNamespacedHelpers('search');


export default {
	name: "Home",

	components: {
		organizationThumbnail,
		searchBar,
		filterBox,
		discoverMap,
	},
	
	computed: {
		...mapState({
			orgs: state => state.results,
		}),

		noResults() {
			return this.orgs && this.orgs.length === 0;
		},
	},

	mounted() {},

	methods: {
		clearSearch() {
			
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
