<template>
	<div :class="['discover-map', isDisabled ? 'hidden' : '']"/>
</template>

<script>
import Vue from "vue";
import { createNamespacedHelpers } from "vuex";
import Component from "vue-class-component";
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import * as am4maps from "@amcharts/amcharts4/maps";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import am4geodata_worldHigh from "@amcharts/amcharts4-geodata/worldHigh";

import { iso2CodeToCountryMapping } from "../services/africanCountries";

const { mapActions, mapGetters, mapState } = createNamespacedHelpers("search");


export default {
	name: "DiscoverMap",

	props: {
		isDisabled: {
			type: Boolean,
			default: false,
		},
	},

	data() {
		return {
			chart: null,
			chartSeries: null,
			chartSeriesDataMapping: new Map(),
			amChartHitEvent: null,
			focusPolygon: null,
		};
	},

	computed: {
		...mapGetters([
			"resultCountByCountry",
		]),

		...mapState({
			countryInFocus: state => state.countryInFocus,
		}),
	},

	watch: {
		resultCountByCountry: function(newResult, oldResult) {
			this.updateMapDisplay(newResult, oldResult);
		},

		countryInFocus: function(newFocus, oldFocus) {
			this.updateMapFocus(newFocus, oldFocus);
		},
	},

	mounted() {
		am4core.useTheme(am4themes_animated);
		this.chart = am4core.create(this.$el, am4maps.MapChart);

		try {
			this.chart.geodata = am4geodata_worldHigh;
		}
		catch (e) {
			this.chart.raiseCriticalError(new Error("Map geodata could not be loaded. Please download the latest " +
				"<a href=\"https://www.amcharts.com/download/download-v4/\">amcharts geodata</a> and extract its contents " +
				"into the same directory as your amCharts files."));
		}

		this.chart.projection = new am4maps.projections.Mercator();
		this.disableScrolling();
		this.defineMapSeries();
	},

	beforeDestroy() {
		if (this.chart) {
			this.chart.dispose();
			this.amChartHitEvent.dispose();
		}
	},

	methods: {
		...mapActions([
			"searchByMapCountry",
			"searchByText",
			"searchByFiltering",
		]),

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

			this.focusPolygon = new am4maps.MapPolygonSeries();
			this.focusPolygon.useGeodata = true;
			this.focusPolygon.include = [];
			this.focusPolygon.exclude = [];
			this.chart.series.push(this.focusPolygon);

			const focusPolygonTemplate = this.focusPolygon.mapPolygons.template;
			focusPolygonTemplate.stroke = am4core.color("#df4e55");
			focusPolygonTemplate.strokeOpacity = 1;
			focusPolygonTemplate.strokeWidth = 2;
			focusPolygonTemplate.fillOpacity = 0;
			focusPolygonTemplate.tooltipText = "{name}";
			focusPolygonTemplate.fill = am4core.color("#f6f6f6");

			this.amChartHitEvent = this.chartSeries.mapPolygons.template.events.on("hit", this.countrySelected);
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

		updateMapFocus(newFocus, oldFocus) {
			if (newFocus === oldFocus) return;

			this.focusPolygon.include = [newFocus];
			this.focusPolygon.exclude = [oldFocus];
			this.focusPolygon.data = [{ id: newFocus }];

			this.focusPolygon.invalidateData();

			// console.log(this.focusPolygon, this.focusPolygon.data);
		},

		countrySelected(event) {
			const countryContext = event.target.dataItem.dataContext;
			
			this.searchByMapCountry(countryContext);
		},
	},
};
</script>

<style lang="scss" scoped>
.discover-map {
	position: absolute;
	right: 0;
	float: right;
	width: 60%;
	min-width: 600px;
	height: 800px;

	&.hidden {
		display: none;
	}
}
</style>
