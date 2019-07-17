import createPersistedState from "vuex-persistedstate";

const state = {
	first_name: "",
	last_name: "",
	email: "",
	avatar: ""
};

const mutations = {
	setAuthUserDetail(state, auth) {
		for (let key of Object.keys(auth)) {
			state[key] = auth[key];
		}
		if ("avatar" in auth)
			state.avatar = auth.avatar !== null ? auth.avatar : "avatar.png";
	},
	resetAuthUserDetail(state) {
		for (let key of Object.keys(state)) {
			state[key] = "";
		}
	}
};

const actions = {
	setAuthUserDetail({ commit }, auth) {
		commit("setAuthUserDetail", auth);
	},
	resetAuthUserDetail({ commit }) {
		commit("resetAuthUserDetail");
	}
};

const getters = {
	getAuthUser: (state) => (name) => {
		return state[name];
	},
	getAuthUserFullName: (state) => {
		return state["first_name"] + " " + state["last_name"];
	}
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
};
