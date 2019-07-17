<template>
	<div id="results-container">
		<p v-if="noResults" id="no-results">No results found, try a different query.</p>
		<div v-else>
            <div v-for="org in results" :key="org.id">
                <organizationThumbnail :organization="org"/>
            </div>
        </div>
    </div>
</template>

<script>
import organizationThumbnail from "../views/organizations/organizationThumbnail";


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
		noResults: function() {
			return this.results && this.results.length === 0;
		},
	},
};
</script>


<style lang="scss" scoped>
	#no-results {
		margin: 20px;
	}
</style>
