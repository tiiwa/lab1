import createPersistedState from "vuex-persistedstate";
import axios from 'axios';

const SEARCH_SOURCES = {
    SEARCH_BAR: "searchBar",
    FILTER_BOX: "filterBox",
};

const EMPTY_STATE = {
    query: {
        searchSource: SEARCH_SOURCES.SEARCH_BAR,
        searchText: "",
    },
    results: null,
    type: "",
    page: 1,
    numPages: 1,
    isSearching: false,
};

const state = Object.assign({}, EMPTY_STATE);

const mutations = {
    setSearch: (state, searchQuery) => {
        state.query = searchQuery;
    },

    setPerformingSearch: (state) => {
        state.isSearching = true; 
    },

    setSearchCompleted: (state) => {
        state.isSearching = false;
    },

    setSearchResults: (state, searchResults) => {
        state.results = searchResults;

        // For now hard code this. The search Results Response 
        // should provide these values.
        state.numPages = 1;
        state.page = 1;
    },

    setEmptyState: (state) => {
        // This feels like stress having to reset everything to default
        // There is probably a better way.

        state.query.searchText = EMPTY_STATE.query.searchText;
        state.query.searchSource = EMPTY_STATE.query.searchSource;

        state.results = EMPTY_STATE.results;
        state.type = EMPTY_STATE.type;
        state.page = EMPTY_STATE.page;
        state.numPages = EMPTY_STATE.numPages;
        state.isSearching = EMPTY_STATE.isSearching;
    },

    setSearchSource: (state, source) => {
        state.query.searchSource = source;
    }
};

const actions = {
    searchByText: async ({commit}, searchText) => {
        commit('setSearchSource', SEARCH_SOURCES.SEARCH_BAR);

        if (!searchText || searchText.trim() === "") {
            commit('setEmptyState');
            return;
        }

        commit('setSearch', {searchText});
        commit('setPerformingSearch');

        try {
            const response = await axios.get(`/api/search?q=${searchText}`, { timeout: 60000 });
            commit('setSearchResults', response.data.data);

        } catch (error) {
            console.error("Error searching for", searchText, error);
        }

        commit('setSearchCompleted');
    },

    searchByFiltering: ({commit}, searchFilter) => {
        commit('setSearchSource', SEARCH_SOURCES.FILTER_BOX);
        console.log("searchByFiltering", searchFilter);
    },

    // Add more search actions as app progresses
};

const getters = {
    resultCountByCountry: state => {
        const resultCountByCountryMapping = state.results.reduce((countries, result) => {
            const country = result.country;

            if (!countries[country]) {
                countries[country] = 1;
            } else {
                countries[country] = countries[country];
            }
        }, {});

        return Object.keys(resultCountByCountryMapping).map(country => {
            return {
                name: country,
                value: resultCountByCountryMapping[country],
            };
        });
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