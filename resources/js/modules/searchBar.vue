<template>
	<form>
		<div class="input-group md-form form-sm form-1 pl-0">
			<div class="input-group-prepend">
				<span id="search-icon"
					class="input-group-text purple lighten-3"><i class="fas fa-search text-white"
						aria-hidden="true"/></span>
			</div>
			<input
				id="search-bar-input"
				v-model="search"
				type="text"
				class="form-control col-xs-1"
				placeholder="Search"
				@input="onChange"
				@keydown.down="onArrowDown"
				@keydown.up="onArrowUp"
				@keydown.enter.prevent="onEnter">
		</div>
	</form>
</template>

<script>
import Multiselect from "vue-multiselect";
import debounce from "../services/debounce";

export default {
	
	name: "SearchBar",
	
	components: {
		Multiselect,
	},
	
	data() {
		return {
			search: "",
			results: [],
			isSearching: false,
		};
	},
	
	methods: {
		// when the input has been changed
		onChange() {
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
		// to perform action on selected result
		searchResult(result) {
			this.search = result;
			this.isOpen = false;
		},
		
		clearSearch() {
			this.$emit("clear-search");
			this.search = "";
			this.results = [];
			this.isSearching = false;
		},
	}
	
};
</script>

<style lang="scss" scoped>
	.input-group {
		background: rgba(0, 0, 0, 0.75);
		border-radius: 5px;

		#search-icon {
			background: none;
			border: none;
		}

		input {
			background: none;
			border: none;
		}
	}
</style>
