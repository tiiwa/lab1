import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

const store = new Vuex.Store({
	state: {
		auth: {
			first_name: "",
			last_name: "",
			email: "",
			avatar: ""
		}
	},
	mutations: {
		setAuthUserDetail(state, auth) {
			for (let key of Object.keys(auth)) {
				state.auth[key] = auth[key];
			}
			if ("avatar" in auth)
				state.auth.avatar = auth.avatar !== null ? auth.avatar : "avatar.png";
		},
		resetAuthUserDetail(state) {
			for (let key of Object.keys(state.auth)) {
				state.auth[key] = "";
			}
		}
	},
	actions: {
		setAuthUserDetail({commit}, auth) {
			commit("setAuthUserDetail", auth);
		},
		resetAuthUserDetail({commit}) {
			commit("resetAuthUserDetail");
		}
	},
	getters: {
		getAuthUser: (state) => (name) => {
			return state.auth[name];
		},
		getAuthUserFullName: (state) => {
			return state.auth["first_name"] + " " + state.auth["last_name"];
		}
	},
	plugins: [
		createPersistedState({storage: window.sessionStorage})
	]
});

export default store;
