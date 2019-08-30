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
						id="sector"
						:class="['filter-box-select']"
						:value="filterData.sector"
						:options="sectorOptions"
						:on-select="onSectorSelect"
						placeholder="SECTOR"/>.
				</h5>
				<h5 id="filter-box-b">
					Bringing
					<filter-box-select
						id="services"
						:class="['filter-box-select']"
						:value="filterData.services"
						:options="servicesOptions"
						:on-select="onServicesSelect"
						placeholder="SERVICES"/>
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
import companySectors from "../services/companySectors";
import companyServices from "../services/companyServices";

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
				sector: null,
				services: null,
			},
			sectorOptions: companySectors.toArray(),
			servicesOptions: companyServices.toArray(),
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

		onSectorSelect(sector) {
			this.filterData.sector = sector;
		},

		onServicesSelect(services) {
			this.filterData.services = services;
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
