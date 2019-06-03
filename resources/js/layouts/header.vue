<template>
	<nav id="header"
		class="navbar navbar-expand-lg">

		<router-link :to="links.home">
			<img id="navbar-logo"
				:src="links.logo"
				class="d-inline-block align-top navbar-brand"
				alt="Tiiwa">
		</router-link>

		<button class="navbar-toggler"
			type="button"
			data-toggle="collapse"
			data-target="#main-nav"
			aria-controls="main-nav"
			aria-expanded="false"
			aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"/>
		</button>

		<div id="main-nav"
			class="collapse navbar-collapse">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link"
						href="#">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link"
						href="#">Users</a>
				</li>
				<li class="nav-item">
					<a class="nav-link"
						href="#">Companies</a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a id="add-company"
						href="#"
						class="red-button"
						@click.prevent="logout">+ Add company</a>
				</li>
				<li>
					<router-link :to="links.profile">
						<template slot="button-content">
							{{ getAuthUserFullName() }}
						</template>
					</router-link>
				</li>
				<li>
					<a href="#"
						class="red-button"
						@click.prevent="logout">Logout</a>
				</li>
			</ul>
		</div>
	</nav>
</template>

<script>
import helper from "../services/helper";

export default {
	data() {
		return {
			links: {
				logo: "/images/logo.png",
				home: "/",
				profile: "/profile",
				logout: "/logout"
			},
		};
	},
	methods: {
		logout() {
			helper.logout().then(() => {
				this.$store.dispatch("resetAuthUserDetail");
				localStorage.clear();
				sessionStorage.clear();
				this.$router.replace("/login");
			}).catch(() => {
				this.$store.dispatch("resetAuthUserDetail");
				localStorage.clear();
				sessionStorage.clear();
				this.$router.replace("/login");
			});
		},
		routeToAddCompany() {
			this.$router.replace("/org/create");
		},
		getAuthUserFullName() {
			return this.$store.getters.getAuthUserFullName;
		},
		getAuthUser(key) {
			return this.$store.getters.getAuthUser(key);
		}
	}
};
</script>

<style lang="scss" scoped>
</style>
