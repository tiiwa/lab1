<template>
	<div v-if="home"
		class="home">
		<h1>Hello Tiiwa</h1>
	</div>
</template>

<script>

export default {

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
