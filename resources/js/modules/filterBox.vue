<template>
	<div id="filter-box-container"
		class="card-shadow">
		<div class="row">
			<div>
				<h5 id="filter-box-a">
					Looking for a company in
					<filter-box-select
						:class="['filter-box-select']"
						id="country"
						:value="filterData.country"
						:options="countryOptions"
						:onSelect="onCountrySelect"
						placeholder="LOCATION"/>
					and working in
					<filter-box-select
						:class="['filter-box-select']"
						id="sector"
						:value="filterData.sector"
						:options="sectorOptions"
						:onSelect="onSectorSelect"
						placeholder="SECTOR"/>.
				</h5>
				<h5 id="filter-box-b">
					Bringing
					<filter-box-select
						:class="['filter-box-select']"
						id="services"
						:value="filterData.services"
						:options="servicesOptions"
						:onSelect="onServicesSelect"
						placeholder="SERVICES"/>
					to Africa.
				</h5>

				<button id="filter-button"
					class="btn-primary"
					@click="filter">
					Find <i class="fas fa-arrow-right"></i>
				</button>
			</div>
		</div>
	</div>
</template>

<script>
import { createNamespacedHelpers } from 'vuex';
import filterBoxSelect from "./filterBoxSelect";
import africanCountries from "../services/africanCountries";
import companySectors from "../services/companySectors";
import companyServices from "../services/companyServices";

const { mapActions } = createNamespacedHelpers('search');


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
		 * to fit the needs of all components. But this works for now.
		 */
		countryOptions: function() {
			const countries = [];

			Array.from(africanCountries.keys()).forEach(key =>
				countries.push(africanCountries.get(key).name)
			);

			return countries.sort();
		},
	},

	methods: {
		...mapActions([
			'searchByFiltering',
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
		width: 420px;
		padding: 50px;
		margin: 20px 0;
		background: $white;
		border-radius: 4px;
	}

	#filter-button {
		float: right;
		height: 36px;
		padding: 0 35px;
		background-color: $red;
		border: none;
		border-radius: 3px;
	}

	@media (max-width: $max-width-for-map) {
		#filter-box-container {
			width: 100%;
		}
	}
</style>
