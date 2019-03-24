<template>
	<section id="wrapper">
		<div class="login-register">
			<div class="login-box card">
				<div class="card-body">
					<h3 class="box-title m-b-20 text-center">Account Activation</h3>
					<h4 v-if="status"
						class="text-center m-t-20 m-b-20 alert alert-success"
						v-text="message"/>
					<h4 v-else
						class="text-center m-t-20 m-b-20 alert alert-danger"
						v-text="message"/>

					<div class="form-group m-b-0">
						<div class="col-sm-12 text-center">
							<p>Back to Login? <router-link to="/login"
								class="text-info m-l-5"><b>Sign In</b></router-link></p>
						</div>
					</div>
				</div>
				<guest-footer/>
			</div>
		</div>

	</section>
</template>

<script>
import GuestFooter from "../../layouts/footer.vue";

export default {
	components: {
		GuestFooter
	},
	data() {
		return {
			token:this.$route.params.token,
			message: "Processing...",
			status: true
		};
	},
	mounted(){
		axios.get("/api/auth/activate/"+this.token).then(response =>  {
			this.message = response.data.message;
		}).catch(error => {
			this.message = error.response.data.message;
			this.status = false;
		});
	}
};
</script>
