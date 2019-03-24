<template>
	<div class="login-register row align-items-center align-middle h-100" >
		<div align="center"
			class="login-box col-md-6 card mx-auto">
			<div class="card-body">
				<form id="loginform"
					class="form-horizontal form-material"
					@submit.prevent="submit">
					<h3 class="box-title m-b-20">Sign In</h3>
					<div class="form-group ">
						<div class="col-xs-12">
							<input v-model="loginForm.email"
								type="text"
								name="email"
								class="form-control"
								placeholder="Email"> </div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<input v-model="loginForm.password"
								type="password"
								name="password"
								class="form-control"
								placeholder="Password"> </div>
					</div>
					<div class="form-group text-center m-t-20">
						<div class="col-xs-12">
							<button
								class="red-button"
								type="submit">Log In</button>
						</div>
					</div>

					<div class="form-group m-b-0">
						<div class="col-sm-12 text-center">
							<p>Forgot your password?
								<router-link to="/password">
									Reset here!
								</router-link>
							</p>
							<p>Don't have an account?
								<router-link to="/register">
									Sign Up
								</router-link>
							</p>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
import helper from "../../services/helper";
import GuestFooter from "../../layouts/footer.vue";

export default {
	data() {
		return {
			loginForm: {
				email: "",
				password: ""
			}
		};
	},
	mounted(){
	},
	methods: {
		submit(e){
			axios.post("/api/auth/login", this.loginForm).then(response =>  {
				localStorage.setItem("auth_token",response.data.token);
				axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("auth_token");
				toastr["success"](response.data.message);
				this.$router.push("/dashboard");
			}).catch(error => {
				toastr["error"](error.response.data.message);
			});
		}
	}
};
</script>


<style lang="scss" scoped>
	#wrapper {
		background-size: cover;

		.login-box {
			height: 350px;
		}
	}
</style>
