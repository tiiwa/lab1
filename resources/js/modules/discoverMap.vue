<template>
	<div class="discover-map-container"/>
</template>

<script>
import Vue from "vue";
import { createNamespacedHelpers } from 'vuex';
import Component from "vue-class-component";
import googleMapsInit from "../gmaps";
import africanCountries from "./africanCountries";
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import * as am4maps from "@amcharts/amcharts4/maps";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import am4geodata_worldHigh from "@amcharts/amcharts4-geodata/worldHigh";

const { mapActions } = createNamespacedHelpers('search');


@Component({})
export default class DiscoverMap extends Vue {
	components = {};
	chart = null;
	chartSeries = null;
	chartSeriesDataMapping = new Map();
	
	mounted() {
		am4core.useTheme(am4themes_animated);
		this.chart = am4core.create(this.$el, am4maps.MapChart);

		try {
			this.chart.geodata = am4geodata_worldHigh;
		}
		catch (e) {
			this.chart.raiseCriticalError(new Error("Map geodata could not be loaded. Please download the latest <a href=\"https://www.amcharts.com/download/download-v4/\">amcharts geodata</a> and extract its contents into the same directory as your amCharts files."));
		}

		this.chart.projection = new am4maps.projections.Mercator();
		this._disableScrolling();
		this._defineMapSeries();
		
		this.chartSeries.data = this._defineInitialSeriesData();

		console.log(this.chartSeries.data);
	}

	_disableScrolling() {
		this.chart.maxZoomLevel = 1;
		this.chart.seriesContainer.draggable = false;
		this.chart.seriesContainer.resizable = false;
		this.chart.chartContainer.wheelable = false;
	}

	_defineMapSeries() {
		// map polygon series (countries)
		this.chartSeries = new am4maps.MapPolygonSeries();
		this.chartSeries.useGeodata = true;
		this.chart.series.push(this.chartSeries);

		// specify which countries to include
		const countries = Array.from(africanCountries.keys());

		countries.forEach((country, index) => {
			this.chartSeriesDataMapping.set(country, index);
		});
		
		this.chartSeries.include = countries;

		// country area look and behavior
		const polygonTemplate = this.chartSeries.mapPolygons.template;
		polygonTemplate.strokeOpacity = 1;
		polygonTemplate.stroke = am4core.color("#9fcaf8");
		polygonTemplate.fillOpacity = 1;
		polygonTemplate.fill = am4core.color("#f6f6f6");
		polygonTemplate.tooltipText = "{name}";

		// Set min/max fill color for each area
		this.chartSeries.heatRules.push({
			property: "fill",
			target: polygonTemplate,
			min: am4core.color("#f6f6f6"),
			minValue: 0,
			max: am4core.color("#df4e55"), 
			// Not quite sure how this will play out in our use case.
			maxValue: 10,
		});
	}

	_defineInitialSeriesData() {
		const data = [];

		for (let i of this.chartSeriesDataMapping.keys()) {
			data.push({ id: i, value: 0});
		}

		return data;
	}

	beforeDestroy() {
		if (this.chart) {
			this.chart.dispose();
		}
	}
}
</script>

<style lang="scss" scoped>
.discover-map-container {
	width: 100%;
	height: 1000px;
	margin-top: 16px;
}
</style>
