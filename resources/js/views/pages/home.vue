<template>
	<div class="home">
		<search-bar class="search-bar"/>
		<section>
			
			<div :class="['home-content', mapDisabled ? 'no-map-mode' : '']">
				<search-filter-bar v-if="!isEmpty"/>
				<organization-search-results-container :results="orgs" />
				<filter-box v-if="isEmpty"/>
			</div>
			
			<discover-map-container
				:is-disabled="mapDisabled"
				:on-map-mode-change-requested="onMapModeChangeRequested"
			/>
		</section>
	</div>
</template>

<script>
import searchFilterBar from "../../modules/searchFilterBar";
import searchBar from "../../modules/searchBar";
import filterBox from "../../modules/filterBox";
import discoverMapContainer from "../../modules/discoverMapContainer";
import organizationSearchResultsContainer from "../../modules/organizationSearchResultsContainer";
import { createNamespacedHelpers } from "vuex";

const { mapState, mapGetters } = createNamespacedHelpers("search");

export default {
	name: "Home",

	components: {
		searchBar,
		searchFilterBar,
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
			orgs: state => state.organizations,
			isEmpty: state => state.isEmpty,
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
		position: absolute;
		z-index: 10;
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
