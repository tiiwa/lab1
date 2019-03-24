<template>
	<section id="wrapper">
		<div class="login-register"
			style="background-image:url(/images/background/background.png);">
			<div class="login-box card">
				<div class="card-body">
					<form id="passwordform"
						class="form-horizontal form-material"
						@submit.prevent="submit">
						<h3 class="box-title m-b-20">Reset Password</h3>
						<div class="form-group ">
							<div class="col-xs-12">
								<input v-model="passwordForm.email"
									type="text"
									name="email"
									class="form-control"
									placeholder="Email"> </div>
						</div>
						<div class="form-group text-center m-t-20">
							<div class="col-xs-12">
								<button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"
									type="submit">Reset Password</button>
							</div>
						</div>
						<div class="form-group m-b-0">
							<div class="col-sm-12 text-center">
								<p>Back to Login? <router-link to="/login"
									class="text-info m-l-5"><b>Sign In</b></router-link></p>
							</div>
						</div>
					</form>
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
			passwordForm: {
				email: ""
			}
		};
	},
	mounted(){
	},
	methods: {
		submit(e){
			axios.post("/api/auth/password", this.passwordForm).then(response =>  {
				toastr["success"](response.data.message);
				this.$router.push("/login");
			}).catch(error => {
				toastr["error"](error.response.data.message);
			});
		}
	}
};
</script>
