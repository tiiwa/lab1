<template>
	<div class="discover-map-container"/>
</template>

<script>
import Vue from "vue";
import Component from "vue-class-component";
import googleMapsInit from "../gmaps";
import africanCountries from "./africanCountries";
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import * as am4maps from "@amcharts/amcharts4/maps";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import am4geodata_worldHigh from "@amcharts/amcharts4-geodata/worldHigh";


@Component({})
export default class DiscoverMap extends Vue {
	components = {};
	chart = null;

	data() {
		return { };
	}
	
	async mounted() {
		am4core.useTheme(am4themes_animated);
		this.chart = am4core.create(this.$el, am4maps.MapChart);

		try {
			this.chart.geodata = am4geodata_worldHigh;
		}
		catch (e) {
			this.chart.raiseCriticalError(new Error("Map geodata could not be loaded. Please download the latest <a href=\"https://www.amcharts.com/download/download-v4/\">amcharts geodata</a> and extract its contents into the same directory as your amCharts files."));
		}

		this.chart.projection = new am4maps.projections.Mercator();

		// zoomout on background click
		// this.chart.chartContainer.background.events.on("hit", function () { zoomOut() });

		let colorSet = new am4core.ColorSet();
		let morphedPolygon;

		// map polygon series (countries)
		let polygonSeries = this.chart.series.push(new am4maps.MapPolygonSeries());
		polygonSeries.useGeodata = true;
		// specify which countries to include
		polygonSeries.include = africanCountries.map(country => country.id);

		// country area look and behavior
		let polygonTemplate = polygonSeries.mapPolygons.template;
		console.log(polygonTemplate);
		polygonTemplate.strokeOpacity = 1;
		polygonTemplate.stroke = am4core.color("#9fcaf8");
		polygonTemplate.fillOpacity = 1;
		polygonTemplate.fill = am4core.color("#f6f6f6");
		polygonTemplate.draggable = false;
		polygonTemplate.tooltipText = "{name}";

		// // desaturate filter for countries
		// let desaturateFilter = new am4core.DesaturateFilter();
		// desaturateFilter.saturation = 0.25;
		// polygonTemplate.filters.push(desaturateFilter);

		// set fillOpacity to 1 when hovered
		// let hoverState = polygonTemplate.states.create("hover");
		// hoverState.properties.fillOpacity = 1;

		// // what to do when country is clicked
		// polygonTemplate.events.on("hit", function (event) {
		// 	event.target.zIndex = 1000000;
		// 	selectPolygon(event.target);
		// })


		// // select polygon
		// function selectPolygon(polygon) {
		// 	if (morphedPolygon != polygon) {
		// 		let animation = pieSeries.hide();
		// 		if (animation) {
		// 			animation.events.on("animationended", function () {
		// 				morphToCircle(polygon);
		// 			})
		// 		}
		// 		else {
		// 			morphToCircle(polygon);
		// 		}
		// 	}
		// }

		// // fade out all countries except selected
		// function fadeOut(exceptPolygon) {
		// 	for (var i = 0; i < polygonSeries.mapPolygons.length; i++) {
		// 		let polygon = polygonSeries.mapPolygons.getIndex(i);
		// 		if (polygon != exceptPolygon) {
		// 			polygon.defaultState.properties.fillOpacity = 0.5;
		// 			polygon.animate([{ property: "fillOpacity", to: 0.5 }, { property: "strokeOpacity", to: 1 }], polygon.polygon.morpher.morphDuration);
		// 		}
		// 	}
		// }

		// function zoomOut() {
		// 	if (morphedPolygon) {
		// 		pieSeries.hide();
		// 		morphBack();
		// 		fadeOut();
		// 		countryLabel.hide();
		// 		morphedPolygon = undefined;
		// 	}
		// }

		// function morphBack() {
		// 	if (morphedPolygon) {
		// 		morphedPolygon.polygon.morpher.morphBack();
		// 		let dsf = morphedPolygon.filters.getIndex(0);
		// 		dsf.animate({ property: "saturation", to: 0.25 }, morphedPolygon.polygon.morpher.morphDuration);
		// 	}
		// }

		// function morphToCircle(polygon) {


		// 	let animationDuration = polygon.polygon.morpher.morphDuration;
		// 	// if there is a country already morphed to circle, morph it back
		// 	morphBack();
		// 	// morph polygon to circle
		// 	polygon.toFront();
		// 	polygon.polygon.morpher.morphToSingle = true;
		// 	let morphAnimation = polygon.polygon.morpher.morphToCircle();

		// 	polygon.strokeOpacity = 0; // hide stroke for lines not to cross countries

		// 	polygon.defaultState.properties.fillOpacity = 1;
		// 	polygon.animate({ property: "fillOpacity", to: 1 }, animationDuration);

		// 	// animate desaturate filter
		// 	let filter = polygon.filters.getIndex(0);
		// 	filter.animate({ property: "saturation", to: 1 }, animationDuration);

		// 	// save currently morphed polygon
		// 	morphedPolygon = polygon;

		// 	// fade out all other
		// 	fadeOut(polygon);

		// 	// hide country label
		// 	countryLabel.hide();

		// 	if (morphAnimation) {
		// 		morphAnimation.events.on("animationended", function () {
		// 			zoomToCountry(polygon);
		// 		})
		// 	}
		// 	else {
		// 		zoomToCountry(polygon);
		// 	}
		// }

		// function zoomToCountry(polygon) {
		// 	let zoomAnimation = this.chart.zoomToMapObject(polygon, 2.2, true);
		// 	if (zoomAnimation) {
		// 		zoomAnimation.events.on("animationended", function () {
		// 			showPieChart(polygon);
		// 		})
		// 	}
		// 	else {
		// 		showPieChart(polygon);
		// 	}
		// }


		// function showPieChart(polygon) {
		// 	polygon.polygon.measure();
		// 	let radius = polygon.polygon.measuredWidth / 2 * polygon.globalScale / this.chart.seriesContainer.scale;
		// 	pieChart.width = radius * 2;
		// 	pieChart.height = radius * 2;
		// 	pieChart.radius = radius;

		// 	let centerPoint = am4core.utils.spritePointToSvg(polygon.polygon.centerPoint, polygon.polygon);
		// 	centerPoint = am4core.utils.svgPointToSprite(centerPoint, this.chart.seriesContainer);

		// 	pieChart.x = centerPoint.x - radius;
		// 	pieChart.y = centerPoint.y - radius;

		// 	let fill = polygon.fill;
		// 	let desaturated = fill.saturate(0.3);

		// 	for (var i = 0; i < pieSeries.dataItems.length; i++) {
		// 		let dataItem = pieSeries.dataItems.getIndex(i);
		// 		dataItem.value = Math.round(Math.random() * 100);
		// 		dataItem.slice.fill = am4core.color(am4core.colors.interpolate(
		// 			fill.rgb,
		// 			am4core.color("#ffffff").rgb,
		// 			0.2 * i
		// 		));

		// 		dataItem.label.background.fill = desaturated;
		// 		dataItem.tick.stroke = fill;
		// 	}

		// 	pieSeries.show();
		// 	pieChart.show();

		// 	countryLabel.text = "{name}";
		// 	countryLabel.dataItem = polygon.dataItem;
		// 	countryLabel.fill = desaturated;
		// 	countryLabel.show();
		// }
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
