<template>
	<div :class="['discover-map', isDisabled ? 'hidden' : '']"/>
</template>

<script>
import Vue from "vue";
import Component from "vue-class-component";
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import * as am4maps from "@amcharts/amcharts4/maps";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import am4geodata_worldHigh from "@amcharts/amcharts4-geodata/worldHigh";

import { iso2CodeToCountryMapping, nameToCountryMapping } from "../services/africanCountries";


export default {
	name: "DiscoverMap",

	props: {
		isDisabled: {
			type: Boolean,
			default: false,

		},

		resultCountByCountry: {
			type: Array,
			default: null,
		},
	},

	data() {
		return {
			chart: null,
			chartSeries: null,
			chartSeriesDataMapping: new Map(),
		};
	},

	watch: {
		resultCountByCountry: function(newResult, oldResult) {
			this.updateMapDisplay(newResult, oldResult);
		},
	},

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
		this.disableScrolling();
		this.defineMapSeries();
	},

	beforeDestroy() {
		if (this.chart) {
			this.chart.dispose();
		}
	},

	methods: {
		disableScrolling: function() {
			this.chart.maxZoomLevel = 1;
			this.chart.seriesContainer.draggable = false;
			this.chart.seriesContainer.resizable = false;
			this.chart.chartContainer.wheelable = false;
		},

		defineMapSeries: function() {
			// map polygon series (countries)
			this.chartSeries = new am4maps.MapPolygonSeries();
			this.chartSeries.useGeodata = true;
			this.chart.series.push(this.chartSeries);

			// specify which countries to include
			const countries = Array.from(iso2CodeToCountryMapping.keys()).sort();

			this.chartSeries.include = countries;

			this.chartSeries.data = countries.map(country => ({ id: country, value: null }));

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
				min: am4core.color("#d0e1f3"),
				max: am4core.color("#367cc9"),
				minValue: 0,
			});
		},

		memoizeCountryMapping() {
			this.chartSeries.data.forEach((datum, index) => {
				this.chartSeriesDataMapping.set(datum.id, index);
			});
		},

		updateMapDisplay(newResult, oldResult) {
			if (this.chartSeriesDataMapping.size === 0) {
				this.memoizeCountryMapping();
			}

			oldResult.forEach(datum => {
				const countryIndex = this.chartSeriesDataMapping.get(datum.id);
				this.chartSeries.data[countryIndex].value = null;
			});

			newResult.forEach(datum => {
				const countryIndex = this.chartSeriesDataMapping.get(datum.id);
				this.chartSeries.data[countryIndex].value = datum.value;
			});

			this.chartSeries.invalidateData();
		},
	},
};
</script>

<style lang="scss" scoped>
.discover-map {
	position: absolute;
	right: 0;
	width: 60%;
	min-width: 600px;
	height: 800px;

	&.hidden {
		display: none;
	}
}
</style>
