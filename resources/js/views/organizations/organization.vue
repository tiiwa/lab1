<template>
	<div>
		<router-view/>
	</div>
</template>

<script>
export default {

	name: "Organization",

	data() {
		return {
			organization: null,
		};
	},

	mounted() {
		// this.fetch();
	},

	methods: {
		// fetch() {
		// 	axios
		// 		.get("api/org/" + this.$route.params.org_id)
		// 		.then(({ data }) => {
		// 			this.organization = data.data;
		// 		})
		// 		.catch(error => {
		// 			toastr["error"](error.response.data.message);
		// 		});
	}

};
</script>

<style lang="scss" scoped>

</style>
