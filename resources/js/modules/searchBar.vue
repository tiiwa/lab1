<template>
	<form @submit.prevent="search">
		<div class="input-group md-form form-sm form-1 pl-0">
			<div class="input-group-prepend">
				<span id="search-icon"
					class="input-group-text purple lighten-3"><i class="fas fa-search"
						aria-hidden="true"/></span>
			</div>
			<input
				id="search-bar-input"
				v-model="searchBarText"
				type="text"
				class="form-control col-xs-1"
				placeholder="Search"
				@input="search">
		</div>
	</form>
</template>

<script>
import _ from "lodash";
import Multiselect from "vue-multiselect";
import { createNamespacedHelpers } from "vuex";

const { mapActions, mapState, mapGetters } = createNamespacedHelpers("search");


export default {

	name: "SearchBar",

	components: {
		Multiselect,
	},
	
	data() {
		return {
			searchBarText: "",
		};
	},

	computed: {
		...mapGetters([
			"searchText",
		]),
	},

	methods: {
		...mapActions([
			"searchByText"
		]),

		// when the input has been changed
		search: _.debounce(function(e) {
			this.searchByText(this.searchBarText);
		}, 300),
	},

};
</script>

<style lang="scss" scoped>
	.input-group {
		padding: 10px;
		color: $dark-blue;
		background: rgb(246, 246, 246);
		border-radius: 5px;

		#search-icon {
			background: none;
			border: none;

			i {
				color: #071021;
			}
		}

		input {
			font-weight: bold;
			color: #071021;
			background: none;
			border: none;

			&::placeholder {
				color: $dark-blue;
			}
		}
	}
</style>
