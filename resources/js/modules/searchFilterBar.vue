<template>
	<div id="search-filter-container"
		class="search-filter-bar"
	>
		<p id="search-filter-header">Select multiple tags to filter results</p>

		<filter-box-select
			id="search-filter-industry"
			:class="['filter-box-select', 'my-auto']"
			:value="filterDataIndustry"
			:options="disableIndustryFilter ? [] : industryOptions"
			:on-select="onIndustrySelect"
			placeholder="INDUSTRY"
		/>
		<filter-box-select
			id="search-filter-impact-areas"
			:class="['filter-box-select']"
			:value="filterDataImpactArea"
			:options="disableImpactAreaFilter ? [] : impactAreaOptions"
			:on-select="onImpactAreaSelect"
			placeholder="IMPACT AREA"
		/>
		<span id="sort-text">
			<span class="sort-text">
				Sort
			</span>

			<span id="count">
				{{ resultCount }}
			</span>
		</span>
		<filter-box-select
			id="search-filter-sorter"
			:class="['filter-box-select']"
			:value="sortKey"
			:options="sortKeys"
			:on-select="onSortBySelect"
			placeholder="Companies By ..."
		/>
		<!-- <div class="filter-sorter">
			<multiselect
				v-model="sortKey"
				:options="sortKeys"
				:searchable="true"
				:close-on-select="true"
				:block-keys="['Tab', 'Enter']"
				:custom-label="customLabel"
				:show-labels="false"
				placeholder="Companies By ..."
				@input="onSortBySelect">
			</multiselect>
		</div> -->
	</div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import filterBoxSelect from "./filterBoxSelect";
import search from "../store/modules/search";
import { sortKeys } from "../services/sortKeys";
import { createNamespacedHelpers } from "vuex";
const { mapActions, mapGetters, mapState } = createNamespacedHelpers("search");

export default {
	name: "SearchFilterBar",

	components: {
		filterBoxSelect,
		Multiselect
	},

	data() {
		return {
			sortKey: null,
			industryOptions: organizationIndustries,
			impactAreaOptions: organizationImpactAreas,
			sortKeys: sortKeys,
		};
	},

	computed: {
		...mapGetters([
			"resultCount",
			"searchSource",
		]),

		...mapState({
			disableIndustryFilter: state => state.filterBoxSources.industry,
			disableImpactAreaFilter: state => state.filterBoxSources.impactArea,
			filterDataIndustry: state => state.filter.industry,
			filterDataImpactArea: state => state.filter.impactArea,
		}),
	},

	methods: {
		...mapActions([
			"sortSearchResults",
			"filterSearchResultsByImpactArea",
			"filterSearchResultsByIndustry",
		]),

		onSortBySelect(sortKey) {
			if (sortKey == null) {
				sortKey = "...";
			}
			this.sortKey = "Companies by "+sortKey;
			this.sortSearchResults(sortKey);
		},

		onIndustrySelect(industry) {
			this.filterSearchResultsByIndustry(industry);
		},

		onImpactAreaSelect(impactArea) {
			this.filterSearchResultsByImpactArea(impactArea);
		},

	}
};
</script>

<style lang="scss">
	$select-color: #d3d3d3;
	$select-background: #f6f6f6;
	$select-height: 36px;

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

	// .filter-sorter {
	// 	display: inline-block;
	// 	// height: 23px;

	// 	.multiselect {
	// 		display: inline-block;
	// 		width: unset;
	// 		// height: 23px;
	// 		// min-height: unset;
	// 		// ;
	// 		font-size: 14px;
	// 		color: #2d2d2d;

	// 		.multiselect__tags {
	// 			min-width: 100px;
	// 			padding: 3px 30px 0 10px;
	// 			color: #2d2d2d;
	// 			background: none;
	// 			border-width: 0;
	// 			border-radius: 4px;

	// 			.multiselect__single {
	// 				background: none;
	// 			}

	// 			.multiselect__input {
	// 				width: unset;
	// 				background: none;
	// 			}

	// 			.multiselect__placeholder {
	// 				color: #2d2d2d;
	// 			}
	// 		}

	// 		.multiselect__content-wrapper {
	// 			width: unset;

	// 			.multiselect__content {
	// 				// position: absolute;
	// 				// top: 36px;
	// 				z-index: 1;
	// 				// display: none;
	// 				width: 300px;
	// 				// max-height: 300px;
	// 				// padding: 0;
	// 				// margin: 0 auto;
	// 				// overflow: scroll;
	// 				list-style: none;
	// 				background-color: white;
	// 				border: 1px solid $select-background;

	// 				.multiselect__element {
	// 					margin: 0;
	// 					line-height: 1.5;
	// 					color: darken($select-color, 10);

	// 					.multiselect__option {
	// 						margin: 0;
	// 						line-height: 1.5;
	// 					}

	// 					// &:hover {
	// 					// 	color: $blue;
	// 					// 	background: $select-background;
	// 					// }

	// 					&:not(:first-child) {
	// 						border-top: 1px solid $select-background;
	// 					}
	// 				}
	// 			}
	// 		}

	// 		.multiselect__select {
	// 			&::before {
	// 				top: 10px;
	// 			}
	// 		}
	// 	}
	// }
</style>

<style lang="scss" scoped>
	#search-filter-container {
		min-width: 800px;
	}

	#search-filter-header {
		margin-top: 10px;
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
