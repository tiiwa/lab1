<template>
	<div class="search-filter-bar"
		id="search-filter-container"
	>
		<p>Select multiple tags to filter results</p>

		<filter-box-select
<<<<<<< HEAD
			id="search-filter-industry"
			:class="['filter-box-select']"
			:value="filterData.industry"
			:options="industryOptions"
			:on-select="onIndustrySelect"
			placeholder="INDUSTRY"
=======
			id="search-filter-sector"
			:class="['filter-box-select', 'my-auto']"
			:value="filterData.sector"
			:options="sectorOptions"
			:on-select="onSectorSelect"
			placeholder="SECTOR"
>>>>>>> Style modifications for search filter bar
		/>
		<filter-box-select
			id="search-filter-impact_areas"
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
import companySectors from "../services/companyIndustrys";
import companyServices from "../services/companyImpactAreas";
import { sortKeys } from "../services/sortKeys"
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
			industryOptions: companyIndustrys.toArray(),
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
<<<<<<< HEAD
	#search-filter-industry {
		margin-right: 14px;
		font-size: 12px;
=======
	#search-filter-sector {
		display: inline-block;
		margin-right: 25px;
		font-size: 10px;
>>>>>>> Style modifications for search filter bar

		.filter-box-select-styled {
			top: 12px;
			min-width: 88px;
			height: 23px;
			padding: 5px 30px 0 15px;
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

<<<<<<< HEAD
	#search-filter-impact_areas {
		margin-right: 14px;
		font-size: 12px;
=======
	#search-filter-services {
		margin-right: 31px;
		font-size: 10px;
>>>>>>> Style modifications for search filter bar

		.filter-box-select-styled {
			min-width: 88px;
			height: 23px;
			padding: 5px 30px 0 15px;
			color: #2d2d2d;
			background: #e2e1e2 0% 0% no-repeat padding-box;
			border-radius: 3px;
			opacity: 1;

			&::after {
				top: 10px;
				border: 5px solid transparent;
				border-color: #2d2d2d transparent transparent transparent;
			}
		}
	}

	#search-filter-sorter {
		font-size: 14px;

		.filter-box-select-styled {
			min-width: 150px;
			height: 23px;
			padding: 3px 35px 0 10px;
			color: #2d2d2d;
			background: none;
			border-radius: 4px;

			&::after {
				top: 10px;
			}
		}
	}
</style>

<style lang="scss" scoped>
	#search-filter-container {
		min-width: 500px;
		// overflow-x: hidden;
		// overflow-y: scroll;
	}

	#count {
		display: inline-block;
		width: 40px;
		height: 23px;
		color: #2d2d2d;
		text-align: center;
		background: #e2e1e2 0% 0% no-repeat padding-box;
		border-radius: 3px;
		opacity: 1;
	}

	#sort-text {
		font-size: 15px;
	}

	.sort-text {
		margin-right: 7px;
	}

</style>
