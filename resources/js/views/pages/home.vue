<template>
	<div class="home">
		<search-bar/>
		<section>
			<discover-map-container />

			<div class="home-content">
				<filter-box/>
				<organization-search-results-container :results="orgs" />
			</div>

		</section>
	</div>
</template>

<script>
import searchBar from "../../modules/searchBar";
import filterBox from "../../modules/filterBox";
import discoverMapContainer from "../../modules/discoverMapContainer";
import organizationSearchResultsContainer from "../../modules/organizationSearchResultsContainer";
import { createNamespacedHelpers } from 'vuex';

const { mapState } = createNamespacedHelpers('search');


export default {
	name: "Home",

	components: {
		searchBar,
		filterBox,
		discoverMapContainer,
		organizationSearchResultsContainer,
	},

	computed: {
		...mapState({
			orgs: state => state.results,
		}),
	},
};
</script>


<style lang="scss" scoped>
	#results-container {
		overflow: scroll;
	}

	#no-results {
		padding: 10px;
		text-align: center;
	}

	.home-content {
		position: relative;
	}

	.aside {
		width: 50%;
	}
</style>
