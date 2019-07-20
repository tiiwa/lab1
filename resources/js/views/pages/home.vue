<template>
	<div class="home">
		<search-bar/>
		<section>
			<discover-map-container
				:isDisabled="mapDisabled"
				:onMapModeChangeRequested="onMapModeChangeRequested"
			/>

			<div :class="['home-content', mapDisabled ? 'no-map-mode' : '']">
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

	data() {
		return {
			mapDisabled: false,
		};
	},

	computed: {
		...mapState({
			orgs: state => state.results,
		}),
	},

	methods: {
		onMapModeChangeRequested: function() {
			this.mapDisabled = !this.mapDisabled;
		},
	},
};
</script>


<style lang="scss" scoped>
	.home-content {
		width: 420px;
		transition: all 250ms ease;
	}

	.no-map-mode {
		width: 70%;
	}

	@media (max-width: $max-width-for-map) {
		.home-content {
			width: 100%;
		}
	}
</style>
