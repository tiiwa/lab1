<template>
	<div>
		<div class="row page-titles">
			<div class="col-md-6 col-8 align-self-center">
				<h3 class="text-themecolor m-b-0 m-t-0">Profile</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
					<li class="breadcrumb-item active">Profile</li>
				</ol>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Edit Profile</h4>
						<form @submit.prevent="updateProfile">
							<div class="form-group">
								<label for="">First Name</label>
								<input v-model="profileForm.first_name" 
									class="form-control" 
									type="text" 
									value="">
							</div>
							<div class="form-group">
								<label for="">Last Name</label>
								<input v-model="profileForm.last_name" 
									class="form-control" 
									type="text" 
									value="">
							</div>
							<div class="form-group">
								<label for="">Date of Birth</label>
								<datepicker v-model="profileForm.date_of_birth" 
									:bootstrap-styling="true"/>
							</div>
							<div class="form-group">
								<label for="">Gender</label>
								<div class="radio radio-info">
									<input id="gender_male" 
										v-model="profileForm.gender" 
										:checked="profileForm.gender === 'male'" 
										type="radio" 
										value="male">
									<label for="gender_male"> Male </label>
								</div>
								<div class="radio radio-success">
									<input id="gender_female" 
										v-model="profileForm.gender" 
										:checked="profileForm.gender === 'female'" 
										type="radio" 
										value="female">
									<label for="gender_female"> Female </label>
								</div>
							</div>
							<div class="form-group">
								<label for="">Facebook Profile</label>
								<input v-model="profileForm.facebook_profile" 
									class="form-control" 
									type="text" 
									value="">
							</div>
							<div class="form-group">
								<label for="">Twitter Profile</label>
								<input v-model="profileForm.twitter_profile" 
									class="form-control" 
									type="text" 
									value="">
							</div>
							<div class="form-group">
								<label for="">Google Plus Profile</label>
								<input v-model="profileForm.google_plus_profile" 
									class="form-control" 
									type="text" 
									value="">
							</div>
							<button type="submit" 
								class="btn btn-info waves-effect waves-light m-t-10">Update</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<div class="pull-right">
							<click-confirm yes-class="btn btn-success" 
								no-class="btn btn-danger">
								<button v-if="defaultAvatar" 
									type="button" 
									class="btn btn-sm btn-danger waves-effect waves-light m-t-10" 
									@click="removeAvatar">Remove Avatar</button>
							</click-confirm>
						</div>
						<h4 class="card-title">Upload Avatar</h4>
						<div class="form-group text-center m-t-20">
							<span id="fileselector">
								<label class="btn btn-info">
									<input id="avatarUpload" 
										type="file" 
										class="upload-button" 
										@change="previewAvatar">
									<i class="fa fa-upload margin-correction"/>Choose Avatar
								</label>
							</span>
						</div>
						<div class="form-group text-center">
							<img :src="avatar" 
								class="img-responsive" 
								style="max-width:200px;">
						</div>
						<div class="text-center">
							<button v-if="avatar" 
								type="submit" 
								class="btn btn-info waves-effect waves-light m-t-10" 
								@click="uploadAvatar">Upload</button>
							<button v-if="avatar" 
								type="button" 
								class="btn btn-danger waves-effect waves-light m-t-10" 
								@click="cancelUploadAvatar">Cancel Upload</button>
						</div>
					</div>
				</div>
				<div v-if="!social_auth" 
					class="card">
					<div class="card-body">
						<h4 class="card-title">Change Password</h4>
						<form @submit.prevent="changePassword">
							<div class="form-group">
								<label for="">Current Password</label>
								<input v-model="passwordForm.current_password" 
									class="form-control" 
									type="password" 
									value="">
							</div>
							<div class="form-group">
								<label for="">New Password</label>
								<input v-model="passwordForm.new_password" 
									class="form-control" 
									type="password" 
									value="">
							</div>
							<div class="form-group">
								<label for="">Confirm Password</label>
								<input v-model="passwordForm.new_password_confirmation" 
									class="form-control" 
									type="password" 
									value="">
							</div>
							<button type="submit" 
								class="btn btn-info waves-effect waves-light m-t-10">Change Password</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import datepicker from "vuejs-datepicker";
import ClickConfirm from "click-confirm";

export default {
	components : { datepicker, ClickConfirm },
	data() {
		return {
			passwordForm: new Form({
				current_password : "",
				new_password : "",
				new_password_confirmation : ""
			}),
			profileForm: new Form({
				first_name : "",
				last_name : "",
				date_of_birth : "",
				gender : "",
				facebook_profile : "",
				twitter_profile : "",
				google_plus_profile : ""
			}, false),
			avatar: "",
			social_auth: 0
		};
	},
	computed: {
		defaultAvatar(){
			return this.getAuthUser("avatar") !== "avatar.png" ? true : false;
		}
	},
	mounted(){
		axios.get("/api/auth/user").then(response => response.data).then(response => {
			this.profileForm.first_name = response.profile.first_name;
			this.profileForm.last_name = response.profile.last_name;
			this.profileForm.date_of_birth = response.profile.date_of_birth;
			this.profileForm.gender = response.profile.gender;
			this.profileForm.facebook_profile = response.profile.facebook_profile;
			this.profileForm.twitter_profile = response.profile.twitter_profile;
			this.profileForm.google_plus_profile = response.profile.google_plus_profile;
			this.social_auth = response.social_auth;
		});
	},
	methods: {
		changePassword() {
			this.passwordForm.post("/api/user/change-password").then(response => {
				toastr["success"](response.message);
			}).catch(response => {
				toastr["error"](response.message);
			});
		},
		updateProfile() {
			this.profileForm.date_of_birth = moment(this.profileForm.date_of_birth).format("YYYY-MM-DD");
			this.profileForm.post("/api/user/update-profile").then(response => {
				toastr["success"](response.message);
				this.$store.dispatch("setAuthUserDetail",{
					first_name: this.profileForm.first_name,
					last_name: this.profileForm.last_name
				});
			}).catch(response => {
				toastr["error"](response.message);
			});
		},
		previewAvatar(e) {
			let files = e.target.files || e.dataTransfer.files;
			if (!files.length)
				return;
			this.createAvatar(files[0]);
		},
		createAvatar(file) {
			let reader = new FileReader();
			reader.onload = (e) => {
				this.avatar = e.target.result;
			};
			reader.readAsDataURL(file);
		},
		cancelUploadAvatar(){
			this.avatar = "";
		},
		uploadAvatar() {
			let data = new FormData();
			data.append("avatar", $("#avatarUpload")[0].files[0]);
			axios.post("/api/user/update-avatar",data)
				.then(response => {
					this.$store.dispatch("setAuthUserDetail",{
						avatar: response.data.profile.avatar
					});
					toastr["success"](response.data.message);
					this.avatar = "";
					$("#avatarUpload").val("");
				}).catch(error => {
					toastr["error"](error.response.data.message);
				});
		},
		removeAvatar() {
			axios.post("/api/user/remove-avatar")
				.then(response => {
					this.$store.dispatch("setAuthUserDetail",{
						avatar: null
					});
					toastr["success"](response.data.message);
				}).catch(error => {
					toastr["error"](error.response.data.message);
				});
		},
		getAuthUser(name){
			return this.$store.getters.getAuthUser(name);
		}
	},
};
</script>
