<template>
	<div class="discover-map-container"></div>
</template>

<script>
import Vue from "vue";
import Component from "vue-class-component";
import googleMapsInit from "../gmaps";

@Component({})
export default class DiscoverMap extends Vue {
	components = {};
	
	data() {
		return { };
	}
	    
    async mounted() {
        try {
			const google = await googleMapsInit();
            const map = new google.maps.Map(this.$el);

			map.setCenter({lat: 4.5332659, lng: 16.9183376});
			map.setZoom(4);
        } catch (error) {
        	console.error(error);
        }
    }
};
</script>

<style lang="scss" scoped>
.discover-map-container {
	width: 100%;
	height: 1000px;
	max-height: 1000px;
}
</style>
