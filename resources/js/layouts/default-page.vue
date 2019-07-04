<template>
	<div id="main-wrapper"
		class="container h-100">
		<!-- //TODO: Swap out header for logged out user -->
		<app-header/>
		<div class="container-fluid">
			<router-view/>
		</div>
		<app-footer/>
	</div>
</template>

<script>
import AppHeader from "./header.vue";
import GuestAppHeader from "./guest-header.vue";
import AppFooter from "./footer.vue";
import helper from "../services/helper";

export default {
	components: {
		AppHeader, AppFooter, GuestAppHeader
	},
	mounted() {
		if(!this.getAuthUser("email")){
			helper.authUser().then(response => {
				this.$store.dispatch("setAuthUserDetail",{
					first_name: response.first_name,
					last_name: response.last_name,
					email: response.user.email,
					avatar:response.avatar
				});
			});
		}
	},
	methods : {
		notification(){
			toastr.options = {
				"positionClass": "toast-top-right"
			};

			$("[data-toastr]").on("click",function(){
				var type = $(this).data("toastr"),message = $(this).data("message"),title = $(this).data("title");
				toastr[type](message, title);
			});
		},
		getAuthUser(name){
			return this.$store.getters.getAuthUser(name);
		}
	},
};
</script>

<style lang="scss" scoped>
	#main-wrapper {
		padding-top: $header-height + 20px;
		padding-bottom: $footer-height + 20px;
		background-attachment: fixed;
	}
</style>
