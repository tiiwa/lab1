import createPersistedState from "vuex-persistedstate";
import axios from "axios";
import { nameToCountryMapping } from "../../services/africanCountries";
import { sortKeysMap } from "../../services/sortKeys";

const SEARCH_SOURCES = {
	SEARCH_BAR: "searchBar",
	FILTER_BOX: "filterBox",
	MAP: "map",
};

const EMPTY_STATE = {
	query: {
		searchSource: SEARCH_SOURCES.SEARCH_BAR,
		searchText: "",
	},

	// Used to track what search filter bar options to disable
	filterBoxSources: {
		industry: false,
		impactArea: false
	},

	filter: {
		industry: null,
		impactArea: null
	},
	organizations: null,
	organizationsUnfiltered: null,
	countryInFocus: null,
	page: 1,
	numPages: 1,
	isSearching: false,
	isEmpty: true,
};

const state = Object.assign({}, EMPTY_STATE);

const mutations = {
	setSearch: (state, searchQuery) => {
		state.query = searchQuery;
		state.isEmpty = false;
	},

	setPerformingSearch: (state) => {
		state.isSearching = true;
		state.isEmpty = false;
	},

	setSearchCompleted: (state) => {
		state.isSearching = false;
		state.isEmpty = false;
	},

	setSearchResults: (state, searchResults) => {
		state.organizationsUnfiltered = searchResults;
		state.organizations = JSON.parse(JSON.stringify(state.organizationsUnfiltered));;
		// For now hard code this. The search Results Response
		// should provide these values.
		state.numPages = 1;
		state.page = 1;
		state.isEmpty = false;
	},

	setEmptyState: (state) => {
		// This feels like stress having to reset everything to default
		// There is probably a better way.

		state.query.searchText = EMPTY_STATE.query.searchText;
		state.query.searchSource = EMPTY_STATE.query.searchSource;

		state.filter.industry = EMPTY_STATE.filter.industry;
		state.filter.impactArea = EMPTY_STATE.filter.impactArea;

		state.organizations = EMPTY_STATE.organizations;
		state.organizations_filtered = EMPTY_STATE.organizations_filtered;
		state.type = EMPTY_STATE.type;
		state.page = EMPTY_STATE.page;
		state.numPages = EMPTY_STATE.numPages;
		state.isSearching = EMPTY_STATE.isSearching;
		state.isEmpty = EMPTY_STATE.isEmpty;
	},

	setSearchSource: (state, source) => {
		state.query.searchSource = source;
		state.isEmpty = false;
	},

	setCountryInFocus: (state, countryCode) => {
		state.countryInFocus = countryCode;
	},

	setFilterIndustry: (state, industry) => {
		state.filter.industry = industry;
	},

	setFilterImpactArea: (state, impactArea) => {
		state.filter.impactArea = impactArea;
	},

	updateFilterBoxSources: (state) => {
		state.filterBoxSources.industry = state.filter.industry != null;
		state.filterBoxSources.impactArea = state.filter.impactArea != null;
	},

	filterSearchResult: (state) => {
		var organizations = state.organizationsUnfiltered;
		if( state.filter.industry != null)
		{
			organizations = organizations.filter(orgs => orgs.industry.toLowerCase() == state.filter.industry.toLowerCase());
		}

		if( state.filter.impactArea != null)
		{
			organizations = organizations.filter(orgs => orgs.impact_area.toLowerCase() == state.filter.impactArea.toLowerCase());
		}

		state.organizations = organizations;
	},

	sortByName: (state) => {
		state.organizations = state.organizations.sort(function(a, b) {
			var textA = a.name.toUpperCase();
			var textB = b.name.toUpperCase();
			return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
		});
	},

	sortByCountry: (state) => {
		state.organizations = state.organizations.sort(function(a, b) {
			var textA = a.country.toUpperCase();
			var textB = b.country.toUpperCase();
			return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
		});
	},

	sortByIndustry: (state) => {
		state.organizations = state.organizations.sort(function(a, b) {
			var textA = a.industry.toUpperCase();
			var textB = b.industry.toUpperCase();
			return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
		});
	},

	sortByImpactArea: (state) => {
		state.organizations = state.organizations.sort(function(a, b) {
			var textA = a.impactArea.toUpperCase();
			var textB = b.impactArea.toUpperCase();
			return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
		});
	},
};

const actions = {
	searchByText: async ({commit}, searchText) => {
		commit("setEmptyState");
		commit("setSearchSource", SEARCH_SOURCES.SEARCH_BAR);

		if (!searchText || searchText.trim() === "") {
			commit("setEmptyState");
			return;
		}

		commit("setSearch", {searchText});
		commit("setPerformingSearch");

		try {
			const response = await axios.get(`/api/search?q=${searchText}`, { timeout: 60000 });
			commit("setSearchResults", response.data.data);

		} catch (error) {
			console.error("Error searching for", searchText, error);
		}

		commit("setSearchCompleted");
	},

	searchByFiltering: async ({commit}, searchFilter) => {
		commit("setEmptyState");
		commit("setSearchSource", SEARCH_SOURCES.FILTER_BOX);
		commit("setFilterIndustry", searchFilter.industry);
		commit("setFilterImpactArea", searchFilter.impactArea);
		commit("updateFilterBoxSources");
		commit("setCountryInFocus", searchFilter.country);
		commit("setPerformingSearch");

		try {
			const response = await axios.post("/api/search", { searchFilter, timeout: 60000 });

			commit("setSearchResults", response.data.data);
		} catch (error) {
			console.error("Error running search filter", error);
		}

		commit("setSearchCompleted");

	},

	filterSearchResultsByIndustry: ({state, commit}, industry) => {
		if (state.organizations === null) return;

		commit("setFilterIndustry", industry);
		commit("filterSearchResult");
	},

	filterSearchResultsByImpactArea: ({state, commit}, impactArea) => {
		if (state.organizations === null) return;

		commit("setFilterImpactArea", impactArea);
		commit("filterSearchResult");
	},

	sortSearchResults: ({state, commit}, sortKey) => {
		if (state.organizations === null) return;

		switch (sortKey) {
		case sortKeysMap.NAME:
			commit("sortByName");
			break;
		case sortKeysMap.COUNTRY:
			commit("sortByCountry");
			break;
		case sortKeysMap.INDUSTRY:
			commit("sortByIndustry");
			break;
		case sortKeysMap.IMPACT_AREA:
			commit("sortByImpactArea");
		default:
			pass;
		}
	},

	searchByMapCountry: async ({ commit }, country) => {
		commit("setEmptyState");
		commit("setSearchSource", SEARCH_SOURCES.MAP);
		commit("setCountryInFocus", country.id);
		commit("setPerformingSearch");

		const searchFilter = {
			country: country.name,
		};

		try {
			const response = await axios.post("/api/search", { searchFilter, timeout: 60000 });

			commit("setSearchResults", response.data.data);
		} catch (error) {
			console.error("Error running search filter", error);
		}

		commit("setSearchCompleted");

	},

	// Add more search actions as app progresses
};

const getters = {
	resultCountByCountry: state => {
		if (state.organizations === null) return [];

		const resultCountByCountryMapping = state.organizations.reduce((countries, result) => {
			const country = result.country;

			if (!countries[country]) {
				countries[country] = 1;
			} else {
				countries[country] = countries[country] + 1;
			}

			return countries;
		}, {});

		return Object.keys(resultCountByCountryMapping).map(country => {
			return {
				id: nameToCountryMapping.get(country).iso2Code,
				value: resultCountByCountryMapping[country],
			};
		});
	},

	resultCount: state => {
		if (state.organizations === null) return 0;

		return state.organizations.length;
	},

	searchText: state => {
		return state.query.searchText;
	},

	searchSource: state => {
		return state.query.searchSource;
	},
};

const plugins = [
	createPersistedState({ storage: window.sessionStorage })
];

export default {
	namespaced: true,
	state,
	mutations,
	actions,
	getters,
	plugins,
	SEARCH_SOURCES,
};
