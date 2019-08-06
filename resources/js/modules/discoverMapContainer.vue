<template>
	<div class="discover-map-container">
		<div :aria-label="altText" 
			class="map-control-container card-shadow" 
			role="text" 
			@click="onMapControlClicked">
			<i v-if="isDisabled" 
				class="far fa-eye"/>
			<i v-else 
				class="far fa-eye-slash"/>
		</div>

		<discover-map
			:is-disabled="isDisabled"/>
	</div>
</template>

<script>
import discoverMap from "./discoverMap";


const SHOW_MAP_TEXT = "Show Map";
const HIDE_MAP_TEXT = "Hide Map";

export default {
	name: "DiscoverMapContainer",

	components: {
		discoverMap,
	},

	props: {
		isDisabled : {
			type: Boolean,
			default: false,
		},

		onMapModeChangeRequested: {
			type: Function,
			default: () => {},
		},
	},

	computed: {
		altText: function() {
			return this.isDisabled ? SHOW_MAP_TEXT : HIDE_MAP_TEXT;
		}
	},

	methods: {
		onMapControlClicked: function() {
			this.onMapModeChangeRequested();
		}
	}
};
</script>

<style lang="scss" scoped>
.discover-map-container {
	position: relative;
}

.map-control-container {
	position: absolute;
	right: 0;
	z-index: 2;
	width: 40px;
	height: 40px;
	font-size: 24px;
	line-height: 1.7;
	text-align: center;
	cursor: pointer;
	background-color: white;
	border-radius: 2px;
}

@media (max-width: $max-width-for-map) {
	.discover-map-container {
		visibility: hidden;
	}
}
</style>
