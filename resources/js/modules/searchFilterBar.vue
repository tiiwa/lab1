<template>
	<div class="search-filter-bar"
		id="search-filter-container"
	>
		<p>Select multiple tags to filter results</p>
		<!-- <br> -->
		<filter-box-select
			id="search-filter-industry"
			:class="['filter-box-select']"
			:value="filterData.industry"
			:options="industryOptions"
			:on-select="onIndustrySelect"
			placeholder="INDUSTRY"
		/>
		<filter-box-select
			id="search-filter-impact_areas"
			:class="['filter-box-select']"
			:value="filterData.impact_areas"
			:options="impact_areasOptions"
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
			placeholder="Companies By ...."
		/>
	</div>
</template>

<script>
import filterBoxSelect from "./filterBoxSelect";
import companyIndustrys from "../impact_areas/companyIndustrys";
import companyImpactAreas from "../impact_areas/companyImpactAreas";
import sortKeys from "../impact_areas/sortKeys"
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
			impact_areasOptions: companyImpactAreas.toArray(),
			sortKeys: sortKeys.toArray(),
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



<style lang="scss">
	#search-filter-industry {
		margin-right: 14px;
		font-size: 12px;

		.filter-box-select-styled {
			height: 24px;
			padding: 3px 35px 0 10px;
			color: #050810;
			background-color: #d3d3d3;
			border-radius: 4px;

			&::after {
				top: 10px;
				border-color: #050810 transparent transparent transparent;
			}
		}
	}

	#search-filter-impact_areas {
		margin-right: 14px;
		font-size: 12px;

		.filter-box-select-styled {
			height: 24px;
			padding: 3px 35px 0 10px;
			color: #050810;
			background-color: #d3d3d3;
			border-radius: 4px;

			&::after {
				top: 10px;
				border-color: #050810 transparent transparent transparent;
			}
		}
	}

	#search-filter-sorter {
		font-size: 14px;

		.filter-box-select-styled {
			height: 24px;
			padding: 3px 35px 0 10px;
			color: #050810;
			background: none;
			border-radius: 4px;

			&::after {
				top: 12px;
				border-color: #050810 transparent transparent transparent;
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
		padding: 1px;
		padding-right: 5px;
		padding-left: 5px;
		color: #050810;
		background-color: #d3d3d3;
		border-radius: 4px;
	}

	#sort-text {
		font-size: 14px;
	}

	.sort-text {
		margin-right: 5px;
		margin-left: 5px;
	}

</style>
