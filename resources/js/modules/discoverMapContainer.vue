<template>
	<div class="discover-map-container">
		<div class="map-control-container"></div>
		<discover-map />
	</div>
</template>

<script>
import discoverMap from "./discoverMap";


export default {
	name: "DiscoverMapContainer",

	components: {
		discoverMap,
	},

	computed: {

	},

	methods: {

	}
};
</script>

<style lang="scss" scoped>
@media (max-width: $max-width-for-map) {
	.discover-map-container {
		visibility: hidden;
	}
}
</style>
