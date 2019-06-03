<template>
	<div id="filter-box-container"
		class="card-shadow">
		<div class="row">
			<div>
				<h5 id="filter-box-a">
					Looking for a company in
					<multiselect v-validate
						id="country"
						v-model="filterForm.location"
						:options="org_countries"
						:show-labels="false"
						:allow-empty="false"
						name="sector"
						placeholder="Location"/>
					<br>
					and working in
					<multiselect v-validate
						id="sector"
						v-model="filterForm.sector"
						:options="org_sectors"
						:show-labels="false"
						:allow-empty="false"
						name="sector"
						placeholder="Sector"/>
				</h5>
				<br>
				<h5 id="filter-box-b">
					Bringing
					<multiselect v-validate
						id="services"
						v-model="filterForm.services"
						:options="org_services"
						:show-labels="false"
						:allow-empty="false"
						name="sector"
						placeholder="Services"/>
					<br>
					to Africa.
				</h5>
				<br>
				<button id="filter-button"
					class="btn-primary"
					@click="filter">
					Find
				</button>
			</div>
		</div>
	</div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
	name: "FilterBox",
	
	components: {
		Multiselect,
	},
	
	data() {
		return {
			organizations: null,
			filterForm:  new Form({
				autoReset: false,
				location: "",
				sector: "",
				services: "",
			}),
			org_countries: ["Algeria","Angola","Benin","Botswana","Burkina Faso","Burundi","Cameroon","Canary Islands","Cape Verde","Central African Republic","Ceuta","Chad","Comoros","Côte d'Ivoire","Democratic Republic of the Congo","Djibouti","Egypt","Equatorial Guinea","Eritrea","Ethiopia","Gabon","Gambia","Ghana","Guinea","Guinea-Bissau","Kenya","Lesotho","Liberia","Libya","Madagascar","Madeira","Malawi","Mali","Mauritania","Mauritius","Mayotte","Melilla","Morocco","Mozambique","Namibia","Niger","Nigeria","Republic of the Congo","Réunion","Rwanda","Saint Helena","São Tomé and Príncipe","Senegal","Seychelles","Sierra Leone","Somalia","South Africa","Sudan","Swaziland","Tanzania","Togo","Tunisia","Uganda","Western Sahara","Zambia","Zimbabwe",],
			org_sectors: ["Graphic Design", "Professional Practice", "Finance & Investments",
				"Metals & Base Metals", "Environmental Chemistry", "Computer Science", "Electrical & Electronics Engineering",
				"Environmental Management", "Environmental Science", "World Trade Associations",],
			org_services: ["Abortion Policy/Anti-Abortion","Abortion Policy/Pro-Abortion Rights","Accountants","Advertising/Public Relations","Aerospace, Defense Contractors","Agribusiness","Agricultural Services & Products","Agriculture","Air Transport","Air Transport Unions","Airlines","Alcoholic Beverages","Alternative Energy Production & Services","Architectural Services","Attorneys/Law Firms","Auto Dealers","Auto Dealers, Japanese","Auto Manufacturers","Automotive","Banking, Mortgage","Banks, Commercial","Banks, Savings & Loans","Bars & Restaurants","Beer, Wine & Liquor","Books, Magazines & Newspapers","Broadcasters, Radio/TV","Builders/General Contractors","Builders/Residential","Building Materials & Equipment","Building Trade Unions ","Business Associations","Business Services","Cable & Satellite TV Production & Distribution","Candidate Committees ","Candidate Committees, Democratic","Candidate Committees, Republican","Car Dealers","Car Dealers, Imports","Car Manufacturers","Casinos / Gambling","Cattle Ranchers/Livestock","Chemical & Related Manufacturing","Chiropractors","Civil Servants/Public Officials","Clergy & Religious Organizations ","Clothing Manufacturing","Coal Mining","Colleges, Universities & Schools","Commercial Banks","Commercial TV & Radio Stations","Communications/Electronics","Computer Software","Conservative/Republican","Construction","Construction Services","Construction Unions","Credit Unions","Crop Production & Basic Processing","Cruise Lines","Cruise Ships & Lines","Dairy","Defense","Defense Aerospace","Defense Electronics","Defense/Foreign Policy Advocates","Democratic Candidate Committees ","Democratic Leadership PACs","Democratic/Liberal ","Dentists","Doctors & Other Health Professionals","Drug Manufacturers","Education ","Electric Utilities","Electronics Manufacturing & Equipment","Electronics, Defense Contractors","Energy & Natural Resources","Entertainment Industry","Environment ","Farm Bureaus","Farming","Finance / Credit Companies","Finance, Insurance & Real Estate","Food & Beverage","Food Processing & Sales","Food Products Manufacturing","Food Stores","For-profit Education","For-profit Prisons","Foreign & Defense Policy ","Forestry & Forest Products","Foundations, Philanthropists & Non-Profits","Funeral Services","Gambling & Casinos","Gambling, Indian Casinos","Garbage Collection/Waste Management","Gas & Oil","Gay & Lesbian Rights & Issues","General Contractors","Government Employee Unions","Government Employees","Gun Control ","Gun Rights ","Health","Health Professionals","Health Services/HMOs","Hedge Funds","HMOs & Health Care Services","Home Builders","Hospitals & Nursing Homes","Hotels, Motels & Tourism","Human Rights ","Ideological/Single-Issue","Indian Gaming","Industrial Unions ","Insurance","Internet","Israel Policy","Labor","Lawyers & Lobbyists","Lawyers / Law Firms","Leadership PACs ","Liberal/Democratic","Liquor, Wine & Beer","Livestock","Lobbyists","Lodging / Tourism","Logging, Timber & Paper Mills","Manufacturing, Misc","Marine Transport","Meat processing & products","Medical Supplies","Mining","Misc Business","Misc Finance","Misc Manufacturing & Distributing ","Misc Unions ","Miscellaneous Defense","Miscellaneous Services","Mortgage Bankers & Brokers","Motion Picture Production & Distribution","Music Production","Natural Gas Pipelines","Newspaper, Magazine & Book Publishing","Non-profits, Foundations & Philanthropists","Nurses","Nursing Homes/Hospitals","Nutritional & Dietary Supplements","Oil & Gas","Other","Payday Lenders","Pharmaceutical Manufacturing","Pharmaceuticals / Health Products","Phone Companies","Physicians & Other Health Professionals","Postal Unions","Poultry & Eggs","Power Utilities","Printing & Publishing","Private Equity & Investment Firms","Pro-Israel ","Professional Sports, Sports Arenas & Related Equipment & Services","Progressive/Democratic","Public Employees","Public Sector Unions ","Publishing & Printing","Radio/TV Stations","Railroads","Real Estate","Record Companies/Singers","Recorded Music & Music Production","Recreation / Live Entertainment","Religious Organizations/Clergy","Republican Candidate Committees ","Republican Leadership PACs","Republican/Conservative ","Residential Construction","Restaurants & Drinking Establishments","Retail Sales","Retired ","Savings & Loans","Schools/Education","Sea Transport","Securities & Investment","Special Trade Contractors","Sports, Professional","Steel Production ","Stock Brokers/Investment Industry","Student Loan Companies","Sugar Cane & Sugar Beets","Teachers Unions","Teachers/Education","Telecom Services & Equipment","Telephone Utilities","Textiles ","Timber, Logging & Paper Mills","Tobacco","Transportation","Transportation Unions ","Trash Collection/Waste Management","Trucking","TV / Movies / Music","TV Production","Unions","Unions, Airline","Unions, Building Trades","Unions, Industrial","Unions, Misc","Unions, Public Sector","Unions, Teacher","Unions, Transportation","Universities, Colleges & Schools","Vegetables & Fruits","Venture Capital","Waste Management","Wine, Beer & Liquor","Women's Issues ",],
			isSaving: false,
			isDeleting: false,
		};
	},
	
	methods: {
		// when the input has been changed
		filter() {
			if(this.search === ""){
				this.clearSearch();
			}
			this.isSearching = true;
			debounce({
				method: "get",
				url: `/api/search?q=${this.search}`,
				timeout: 60000
			})
				.then(({ data }) => {
					this.isSearching = false;
					this.results = data.data;
					this.$emit("search-results", data.data);
				})
				.catch(error => {
					this.isLoading = false;
				});
		},
	}
};
</script>



<style lang="scss" scoped>

	#filter-box-container {
		padding: 50px;
		margin: 20px;
		background: $white;
		border-radius: 15px;
	}

	#sector {
		font-size: 16px;
	}

	#filter-button {
		padding: 10px 35px;
	}

	.multiselect {
		float: left;
		margin-top: 5px;
		margin-bottom: 15px;
	}
</style>
