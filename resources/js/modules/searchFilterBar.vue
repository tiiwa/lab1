<template>
	<div id="search-filter-container"
		class="search-filter-bar"
	>
		<p id="search-filter-header">Select multiple tags to filter results</p>

		<filter-box-select
			id="search-filter-industry"
			:class="['filter-box-select', 'my-auto']"
			:value="filterData.industry"
			:options="industryOptions"
			:on-select="onIndustrySelect"
			placeholder="INDUSTRY"
		/>
		<filter-box-select
			id="search-filter-impact-areas"
			:class="['filter-box-select']"
			:value="filterData.impact_areas"
			:options="impactAreaOptions"
			:on-select="onImpactAreasSelect"
			placeholder="IMPACT_AREAS"
		/>
		<span id="sort-text">
			<span class="sort-text">
				Sort
			</span>

			<span id="count">
				{{ resultCount }}
			</span>
			<!-- <span class="sort-text">
				Companies by
			</span> -->
		</span>
		<filter-box-select
			id="search-filter-sorter"
			:class="['filter-box-select']"
			:value="sortKey"
			:options="sortKeys"
			:on-select="onSortBySelect"
			placeholder="Companies By ..."
		/>
	</div>
</template>

<script>
import filterBoxSelect from "./filterBoxSelect";
import companyIndustries from "../services/organizationIndustries";
import companyImpactAreas from "../services/organizationImpactAreas";
import { sortKeys } from "../services/sortKeys";
import { createNamespacedHelpers } from "vuex";
const { mapActions, mapGetters } = createNamespacedHelpers("search");

export default {
	name: "SearchFilterBar",

	components: {
		filterBoxSelect,
	},

	data() {
		return {
			filterData: {
				industry: null,
				impact_areas: null,
			},
			sortKey: null,
			industryOptions: companyIndustries.toArray(),
			impactAreaOptions: companyImpactAreas.toArray(),
			sortKeys: sortKeys,
		};
	},

	computed: {
		...mapGetters([
			"resultCount",
		]),
	},

	methods: {
		...mapActions([
			"sortSearchResults",
		]),

		onSortBySelect(sortKey) {

			if (sortKey == null) {
				sortKey = "...";
			}
			this.sortKey = "Companies by "+sortKey;
			this.sortSearchResults(sortKey);
		},

		onIndustrySelect(industry) {
			this.filterData.industry = industry;
		},

		onImpactAreasSelect(impact_areas) {
			this.filterData.impact_areas = impact_areas;
		},

	}
};
</script>



// top: 252px;
// left: 138px;


<style lang="scss">
	#search-filter-industry {
		display: inline-block;
		margin-right: 25px;
		font-size: 10px;

		.filter-box-select-styled {
			top: 12px;
			min-width: 88px;
			height: 23px;
			padding: 5px 30px 0 15px;
			font-weight: bold;
			color: #050810;
			background: #e2e1e2 0% 0% no-repeat padding-box;
			border-radius: 3px;
			opacity: 1;

			&::after {
				top: 10px;
				border-color: #2d2d2d transparent transparent transparent;
			}
		}
	}

	#search-filter-impact-areas {
		margin-right: 25px;
		font-size: 10px;

		.filter-box-select-styled {
			min-width: 88px;
			height: 23px;
			padding: 5px 30px 0 15px;
			font-weight: bold;
			color: #2d2d2d;
			background: #e2e1e2 0% 0% no-repeat padding-box;
			border-radius: 3px;
			opacity: 1;

			&::after {
				top: 10px;
				border-color: #2d2d2d transparent transparent transparent;
			}
		}
	}

	#search-filter-sorter {
		font-size: 14px;

		.filter-box-select-styled {
			min-width: 100px;
			height: 23px;
			padding: 3px 30px 0 10px;
			color: #2d2d2d;
			background: none;
			border-radius: 4px;

			&::after {
				top: 10px;
				border-color: #2d2d2d transparent transparent transparent;
			}
		}
	}
</style>

<style lang="scss" scoped>
	#search-filter-container {
		min-width: 800px;
	}

	#search-filter-header {
		margin-top: 25px;
		margin-bottom: 5px;
		font-size: 15px;
	}

	#count {
		display: inline-block;
		width: 40px;
		height: 23px;
		font-weight: bold;
		color: #2d2d2d;
		text-align: center;
		letter-spacing: 1.5px;
		background: #e2e1e2 0% 0% no-repeat padding-box;
		border-radius: 3px;
		opacity: 1;
	}

	#sort-text {
		margin-left: 0;
		font-size: 15px;
	}

	.sort-text {
		margin-right: 7px;
	}

</style>
