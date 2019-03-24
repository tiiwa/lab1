<template>
	<div>
		<div class="row page-titles">
			<div class="col-md-6 col-8 align-self-center">
				<h3 class="text-themecolor m-b-0 m-t-0">User</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
					<li class="breadcrumb-item active">User</li>
				</ol>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Filter User</h4>

						<div class="row m-t-40">
							<div class="col-md-3">
								<div class="form-group">
									<label for="">First Name</label>
									<input v-model="filterUserForm.first_name"
										class="form-control"
										@blur="getUsers">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="">Last Name</label>
									<input v-model="filterUserForm.last_name"
										class="form-control"
										@blur="getUsers">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="">Email</label>
									<input v-model="filterUserForm.email"
										class="form-control"
										@blur="getUsers">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="">Status</label>
									<select v-model="filterUserForm.status"
										name="status"
										class="form-control"
										@change="getUsers">
										<option value="">All</option>
										<option value="pending_activation">Pending Activation</option>
										<option value="activated">Activated</option>
										<option value="banned">Banned</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="">Sort By</label>
									<select v-model="filterUserForm.sortBy"
										name="sortBy"
										class="form-control"
										@change="getUsers">
										<option value="first_name">First Name</option>
										<option value="last_name">Last Name</option>
										<option value="email">Email</option>
										<option value="status">Status</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="">Order</label>
									<select v-model="filterUserForm.order"
										name="order"
										class="form-control"
										@change="getUsers">
										<option value="asc">Asc</option>
										<option value="desc">Desc</option>
									</select>
								</div>
							</div>
						</div>

						<h4 class="card-title">User List</h4>
						<h6 v-if="users.total"
							class="card-subtitle">Total {{ users.total }} result found!</h6>
						<h6 v-else
							class="card-subtitle">No result found!</h6>
						<div class="table-responsive">
							<table v-if="users.total"
								class="table">
								<thead>
									<tr>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Date of Birth</th>
										<th>Gender</th>
										<th>Email</th>
										<th>Status</th>
										<th style="width:150px;">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="user in users.data"
										:key="user.id">
										<td v-text="user.profile.first_name"/>
										<td v-text="user.profile.last_name"/>
										<td>{{ user.profile.date_of_birth | moment }}</td>
										<td>{{ user.profile.gender | ucword }}</td>
										<td v-text="user.email"/>
										<td v-html="getUserStatus(user)"/>
										<td>
											<click-confirm yes-class="btn btn-success"
												no-class="btn btn-danger">
												<button class="btn btn-danger btn-sm"
													data-toggle="tooltip"
													title="Delete User"
													@click.prevent="deleteUser(user)"><i class="fa fa-trash"/></button>
											</click-confirm>
										</td>
									</tr>
								</tbody>
							</table>

							<div class="row">
								<div class="col-md-8">
									<pagination :data="users"
										:limit="3"
										@pagination-change-page="getUsers"/>
								</div>
								<div class="col-md-4">
									<div class="float-right">
										<select v-if="users.total"
											v-model="filterUserForm.pageLength"
											name="pageLength"
											class="form-control"
											@change="getUsers">
											<option value="5">5 per page</option>
											<option value="10">10 per page</option>
											<option value="25">25 per page</option>
											<option value="100">100 per page</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import pagination from "laravel-vue-pagination";
import helper from "../../services/helper";
import ClickConfirm from "click-confirm";

export default {
	components : { pagination, ClickConfirm },
	filters: {
		moment(date) {
			return helper.formatDate(date);
		},
		ucword(value) {
			return helper.ucword(value);
		}
	},
	data() {
		return {
			users: {},
			filterUserForm: {
				sortBy : "first_name",
				order: "desc",
				status: "",
				title: "",
				pageLength: 5
			}
		};
	},
	mounted() {
		this.getUsers();
	},
	methods: {
		getUsers(page) {
			if (typeof page === "undefined") {
				page = 1;
			}
			let url = helper.getFilterURL(this.filterUserForm);
			axios.get("/api/user?page=" + page + url)
				.then(response => this.users = response.data );
		},
		deleteUser(user){
			axios.delete("/api/user/"+user.id).then(response => {
				toastr["success"](response.data.message);
				this.getUsers();
			}).catch(error => {
				toastr["error"](error.response.data.message);
			});
		},
		getUserStatus(user){
			if(user.status == "pending_activation")
				return "<span class=\"label label-warning\">Pending Activation</span>";
			else if(user.status == "activated")
				return "<span class=\"label label-success\">Activated</span>";
			else if(user.status == "banned")
				return "<span class=\"label label-danger\">Banned</span>";
			else
				return;
		}
	},
};
</script>
