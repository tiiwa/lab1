import createPersistedState from "vuex-persistedstate";
import axios from "axios";
import { nameToCountryMapping } from "../../services/africanCountries";

const SEARCH_SOURCES = {
	SEARCH_BAR: "searchBar",
	FILTER_BOX: "filterBox",
	MAP: "map",
};

const SORT_KEYS = {
	NAME: "Name",
	COUNTRY: "Country",
	INDUSTRY: "Industry",
	IMPACT_AREA: "Services"
};

const EMPTY_STATE = {
	query: {
		searchSource: SEARCH_SOURCES.SEARCH_BAR,
		searchText: "",
	},
	organizations: null,
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
		state.organizations = searchResults;

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

		state.organizations = EMPTY_STATE.organizations;
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

	sortByName: (state) => {
		console.log("Sorting");
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
};

const actions = {
	searchByText: async ({commit}, searchText) => {
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

	sortSearchResults: ({state, commit}, sortKey) => {
		if (state.organizations === null) return;

		switch(sortKey) {
		case SORT_KEYS.NAME:
			commit("sortByName");
			break;
		case SORT_KEYS.COUNTRY:
			commit("sortByCountry");
			break;
		case SORT_KEYS.INDUSTRY:
			commit("sortByIndustry");
			break;
		default:
			console.log("Default");
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
