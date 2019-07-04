<template>
	<div>
		<h1>All Organizations</h1>
		<table class="table table-striped table-hover">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Location</th>
					<th scope="col">Approved?</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="org in organizations"
					:key="org.id"
					@click="routeToViewOrganization(org.id)">
					<th scope="row">
						{{ org.name }}
					</th>
					<td>{{ org.location }}</td>
					<td>
						<input id="approved"
							v-model="org.approved"
							type="checkbox"
							@click.stop="toggleApproval(org)">
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
import organizationThumbnail from "../organizations/organizationThumbnail";

export default {
	name: "Organizations",
	
	components: {
		organizationThumbnail,
	},
	
	data() {
		return {
			endpoint: "org/all",
			organizations: [],
			default_orgs: null,
			no_results: false,
		};
	},
	
	computed: {
		orgs(){
			if (this.no_results){
				return this.default_orgs;
			}
			else {
				return this.organizations;
			}
		}
	},
	
	mounted() {
		this.fetch();
	},
	methods: {
		fetch() {
			if (this.endpoint) {
				axios
					.get("api/" + this.endpoint)
					.then(({ data }) => {
						this.organizations = data.data;
						this.default_orgs = data.data;
					})
					.catch(error => {
						toastr["error"](error.response.data.message);
					});
			}
		},
		
		routeToViewOrganization(orgId) {
			return this.$router.push({
				name: "showOrganization",
				params: {
					org_id: orgId,
				}
			});
			
		},
		
		toggleApproval(org){
			if(org.approved){
				this.disapproveOrg(org.id);
			} else {
				this.approveOrg(org.id);
			}
		},
		
		approveOrg(orgId) {
			axios
				.get("api/org/" + orgId + "/approve")
				.then(({data}) => {
					toastr["success"](data.message);
				})
				.catch(error => {
					toastr["error"](error.message);
				});
		},
		
		disapproveOrg(orgId) {
			axios
				.get("api/org/" + orgId + "/disapprove")
				.then(({data}) => {
					toastr["success"](data.message);
				})
				.catch(error => {
					toastr["error"](error.message);
				});
		},
	}
};
</script>


<style scoped>

</style>
