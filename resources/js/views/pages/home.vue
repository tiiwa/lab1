<template>
	<div class="home">
		<div v-if="organizations">
			<div v-for="org in organizations"
				:key="org.id">
				<organizationThumbnail :organization="org"/>
			</div>
		</div>
	</div>
</template>

<script>
import organizationThumbnail from "../organizations/organizationThumbnail";

export default {
	name: "Home",

	components: {
		organizationThumbnail
	},

	data() {
		return {
			endpoint: "home",
			organizations: null,
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
						this.organizations = data.data;
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
