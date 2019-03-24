<template>
	<nav id="header"
		class="navbar navbar-expand-lg">
		<router-link :to="links.home">
			<img id="navbar-logo"
				:src="links.logo"
				class="d-inline-block align-top navbar-brand"
				alt="BV">
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
						href="/">Home <span class="sr-only">(current)</span></a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<router-link :to="'login'"
						class="red-button">
						Login
					</router-link>
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
				logo: "/images/logo.svg",
				home: "/",
			},
		};
	}
};
</script>
