<template>
	<section id="wrapper">
		<div class="login-register"
			style="background-image:url(/images/background/background.png);">
			<div class="login-box card">
				<div class="card-body">
					<h3 class="box-title m-b-20 text-center">Reset Password</h3>
					<div v-if="!showMessage">
						<form id="resetform"
							class="form-horizontal form-material"
							@submit.prevent="submit">
							<div class="form-group ">
								<div class="col-xs-12">
									<input v-model="resetForm.email"
										type="text"
										name="email"
										class="form-control"
										placeholder="Email"> </div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<input v-model="resetForm.password"
										type="password"
										name="password"
										class="form-control"
										placeholder="Password"> </div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<input v-model="resetForm.password_confirmation"
										type="password"
										name="password"
										class="form-control"
										placeholder="Password"> </div>
							</div>
							<div class="form-group text-center m-t-20">
								<div class="col-xs-12">
									<button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"
										type="submit">Reset Password</button>
								</div>
							</div>
						</form>
					</div>
					<div v-else
						class="text-center">
						<h4 v-if="status"
							class="alert alert-success"
							v-text="message"/>
						<h4 v-else
							class="alert alert-danger"
							v-text="message"/>
					</div>
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
			resetForm: {
				email: "",
				password: "",
				password_confirmation: "",
				token:this.$route.params.token,
			},
			message: "",
			status: true,
			showMessage: false
		};
	},
	mounted(){
		axios.post("/api/auth/validate-password-reset",{
			token: this.reset.token
		}).then(response => {
			this.showMessage = false;
		}).catch(error => {
			this.message = error.response.data.message;
			this.showMessage = true;
			this.status = false;
		});
	},
	methods: {
		submit(e){
			axios.post("/api/auth/reset", this.resetForm).then(response =>  {
				this.message = response.data.message;
				this.showMessage = true;
				this.status = true;
			}).catch(error => {
				toastr["error"](error.response.data.message);
			});
		}
	}
};
</script>
