<template>
	<div id="results-container">
		<i v-if="isSearching"
			class="fas fa-circle-notch fa-spin"/>
		<p v-if="noResults"
			id="no-results">No results found, try a different query.</p>
		<div v-else>
			<div v-for="org in results"
				:key="org.id">
				<organizationThumbnail :organization="org"/>
			</div>
		</div>
	</div>
</template>

<script>
import organizationThumbnail from "../views/organizations/organizationThumbnail";
import { createNamespacedHelpers } from "vuex";

const { mapState, mapGetters } = createNamespacedHelpers("search");

export default {
	name: "OrganizationSearchResultsContainer",

	components: {
		organizationThumbnail,
	},

	props: {
		results: {
			type: Array,
			default: null,
		},
	},
	computed: {
		...mapState({
			isSearching: state => state.isSearching,
		}),
		
		noResults: function() {
			return this.results && this.results.length === 0;
		},
	},
};
</script>


<style lang="scss" scoped>
	#results-container {
		min-width: 500px;
		max-height: 70vh;
		overflow-x: hidden;
		overflow-y: scroll;
	}

	#no-results {
		padding: 10px;
	}

	@media (max-width: $max-width-for-map) {
		#results-container {
			width: 100%;
			min-width: unset;
		}
	}
</style>
