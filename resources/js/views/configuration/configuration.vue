<template>
	<div>
		<div class="row page-titles">
			<div class="col-md-6 col-8 align-self-center">
				<h3 class="text-themecolor m-b-0 m-t-0">Configuration</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
					<li class="breadcrumb-item active">Configuration</li>
				</ol>
			</div>
		</div>

		<div class="row">
			<div class="col-6">
				<div class="card">
					<div class="card-body">
						<form @submit.prevent="saveConfiguration">
							<div class="form-group">
								<label for="">Company Name</label>
								<input v-model="configForm.company_name" 
									class="form-control" 
									type="text" 
									value="">
							</div>
							<div class="form-group">
								<label for="">Contact Person</label>
								<input v-model="configForm.contact_person" 
									class="form-control" 
									type="text" 
									value="">
							</div>
							<button type="submit" 
								class="btn btn-info waves-effect waves-light m-t-10">Save</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import helper from "../../services/helper";

export default {
	components : { },
	data() {
		return {
			configForm: new Form({
				company_name : "",
				contact_person: "",
			}, false)
		};
	},
	mounted(){
		axios.get("/api/configuration/fetch").then(response => {
			this.configForm = helper.formAssign(this.configForm, response.data.config);
		}).catch();
	},
	methods: {
		saveConfiguration(){
			this.configForm.post("/api/configuration").then(response => {
				this.$store.dispatch("setConfig",this.configForm);
				toastr["success"](response.message);
			}).catch(response => {
				toastr["error"](response.message);
			});
		}
	}
};
</script>
