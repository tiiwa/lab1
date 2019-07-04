<template>
	<div v-if="home"
		class="home">
		<organizationList/>
	</div>
</template>

<script>
import organizationList from "../admin/organizations";

export default {
	
	name: "Dashboard",
	
	components: {
		organizationList
	},

	data() {
		return {
			endpoint: "home",
			home: null
		};
	},

	mounted() {
		this.fetch();
	},
	methods: {
		fetch() {
			if (this.endpoint) {
				axios
					.get("api/" + this.endpoint)
					.then(({ data }) => {
						this.home = data;
					})
					.catch(error => {
						toastr["error"](error.response.data.message);
					});
			}
		}
	}
};
</script>


<style lang="scss" scoped>
</style>
