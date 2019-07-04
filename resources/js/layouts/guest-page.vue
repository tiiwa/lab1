<template>
	<div id="main-wrapper"
		class="container"
		style="background-image:url(/images/background/background.png);">
		<app-header-auth v-if="auth"/>
		<app-header v-else/>
		<div class="container-fluid">
			<router-view/>
		</div>
		<app-footer/>
	</div>
</template>

<script>

import AppHeader from "./guest-header.vue";
import AppFooter from "./footer.vue";
import AppHeaderAuth from "./header.vue";
import helper from "../services/helper";


export default {

	components: {
		AppHeader,
		AppFooter,
		AppHeaderAuth
	},
	
	data() {
		return {
			auth: false,
		};
	},

	mounted() {
		this.authCheck();
		this.notification();
	},


	methods : {
		authCheck() {
			helper.check().then(response => {
				if(!response){
					this.auth = false;
				} else {
					this.auth = true;
				}
			});
		},
		
		notification() {
			toastr.options = {
				"positionClass": "toast-top-right"
			};

			$("[data-toastr]").on("click",function(){
				var type = $(this).data("toastr"),message = $(this).data("message"),title = $(this).data("title");
				toastr[type](message, title);
			});
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
