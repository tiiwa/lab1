<template>
	<div id="main-wrapper"
		class="container h-100"
		style="background-image:url(/images/background/background.png);">
		<app-header/>
		<div class="container-fluid">
			<router-view/>
		</div>
		<app-footer/>
	</div>
</template>

<script>

import AppHeader from "./guest-header.vue";
import AppFooter from "./footer.vue";

export default {

	components: {
		AppHeader, AppFooter
	},

	mounted() {
		this.notification();
	},

	destroyed(){
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
		}
	},
};
</script>

<style lang="scss" scoped>
	.container-fluid {
		height: 90%;
	}

</style>
