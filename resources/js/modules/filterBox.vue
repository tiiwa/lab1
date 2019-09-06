<template>
	<div id="filter-box-container"
		class="card-shadow">
		<div class="row">
			<div>
				<h5 id="filter-box-a">
					Looking for a company in
					<filter-box-select
						id="country"
						:class="['filter-box-select']"
						:value="filterData.country"
						:options="countryOptions"
						:on-select="onCountrySelect"
						placeholder="LOCATION"/>
					and working in
					<filter-box-select
						id="industry"
						:class="['filter-box-select']"
						:value="filterData.industry"
						:options="industryOptions"
						:on-select="onIndustrySelect"
						placeholder="INDUSTRY"/>.
				</h5>
				<h5 id="filter-box-b">
					Bringing
					<filter-box-select
						id="impact_area"
						:class="['filter-box-select']"
						:value="filterData.impact_area"
						:options="impactAreaOptions"
						:on-select="onImpactAreaSelect"
						placeholder="IMPACT AREA"/>
					to Africa.
				</h5>

				<button id="filter-button"
					class="btn-primary"
					@click="filter">
					Find <i class="fas fa-arrow-right"/>
				</button>
			</div>
		</div>
	</div>
</template>

<script>
import { createNamespacedHelpers } from "vuex";
import filterBoxSelect from "./filterBoxSelect";
import { iso2CodeToCountryMapping, nameToCountryMapping } from "../services/africanCountries";

const { mapActions } = createNamespacedHelpers("search");

const COUNTRIES = Array.from(nameToCountryMapping.keys()).sort();


export default {
	name: "FilterBox",

	components: {
		filterBoxSelect,
	},

	data() {
		return {
			filterData: {
				country: null,
				industry: null,
				impact_area: null,
			},
			industryOptions: organizationIndustries,
			impactAreaOptions: organizationImpactAreas,
		};
	},

	computed: {
		/**
		 * TODO(joshua): This is not nice. Refactor africanCountries.js
		 * to fit the needs of all components. But this works for now. This is tech debt
		 */
		countryOptions: function() {
			return COUNTRIES;
		},
	},

	methods: {
		...mapActions([
			"searchByFiltering",
		]),

		filter() {
			this.searchByFiltering({...this.filterData});
		},

		onCountrySelect(country) {
			this.filterData.country = country;
		},

		onIndustrySelect(industry) {
			this.filterData.industry = industry;
		},

		onImpactAreaSelect(impact_area) {
			this.filterData.impact_area = impact_area;
		},
	}
};
</script>

<style lang="scss" scoped>

	#filter-box-container {
		padding: 50px;
		background: $white;
		border-radius: 2px;
	}

	#filter-button {
		float: right;
		height: 36px;
		padding: 0 35px;
		background-color: $red;
		border: none;
		border-radius: 3px;
	}
</style>
