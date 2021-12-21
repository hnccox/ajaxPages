'use strict'

import { default as ajaxMap } from "../../../../e107_plugins/ajaxTemplates/beta/js/ajaxMaps.js";
import { default as ajaxTable } from "../../../../e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";
import { default as ajaxTemplate } from "../../../../e107_plugins/ajaxTemplates/beta/js/ajaxTemplates.js";

(function () {

	window["ajaxMaps"] = [];
	window["ajaxTables"] = [];
	window["ajaxTemplates"] = [];

	if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
		var layer = "dark";
	} else {
		var layer = "light";
	}

	document.addEventListener('DOMContentLoaded', () => {

		const maps = document.querySelectorAll('div[data-ajax="map"]');
		maps.forEach((element, key) => {
			var mapOptions = {
				_defaults: {
					lat: parseFloat(element.dataset.lat, 10),
					lng: parseFloat(element.dataset.lng, 10),
					zoom: parseInt(element.dataset.zoom, 10),
					geolocation: true,
					// minZoom: parseInt(element.dataset.minZoom, 10),
					// maxZoom: parseInt(element.dataset.maxZoom, 10)
				},
				_baseMaps: {
					layers: layer
				},
				_overlayMaps: {
					LLG_NL: {
						layerType: "markerClusterGroup",
						layerOptions: {
							attribution: "Borehole data &copy; <a href=\"https://www.uu.nl/\">CC BY Geowetenschappen</a>"
						},
						layerParams: {
							addToMap: true,
							url: "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php",
							db: "llg",
							table: "llg_nl_geom",
							columns: "borehole,xco,yco,drilldepth",
							offset: 0,
							limit: 1000,
							query: {
								0: {
									"select": {
										"columns": {
											0: "llg_nl_geom.borehole,llg_nl_geom.longitude,llg_nl_geom.latitude,llg_nl_geom.xy,llg_nl_geom.geom,xco,yco,drilldepth"
										},
										"from": {
											"table": "llg_nl_geom"
										}
									}
								},
								1: {
									"inner_join": {
										"table": "llg_nl_boreholeheader",
										//"as": "",
										"on": {
											"identifier": "llg_nl_geom.borehole",
											"value": "llg_nl_boreholeheader.borehole"
										}
									}
								},
								2: {
									"where": {
										0: {
											"identifier": "llg_nl_geom.longitude",
											"between": {
												0: ":xmin",
												1: ":xmax"
											}
										},
										1: {
											"identifier": "llg_nl_geom.latitude",
											"between": {
												0: ":ymin",
												1: ":ymax"
											}
										},
										2: {
											"identifier": "llg_nl_boreholeheader.active",
											"value": "t"
										}
									}
								},
								3: {
									"order_by": {
										0: {
											"identifier": "llg_nl_geom.geom <-> 'SRID=4326;POINT(:lng :lat)'::geometry, llg_nl_geom.borehole",
											"direction": "DESC"
										}
									}
								},
								4: {
									"limit": 1000
								},
								5: {
									"offset": 0
								}
							},
							disableClusteringAtZoom: 14
						},
						parseResponse: function (response) {
							const type = response.type;
							const data = response.data;
							const dataset = response.data.dataset;
							const records = data.records;
							const totalrecords = data.totalrecords;
							return { type, data, dataset, records, totalrecords };
						},
						getUID: function (value) {
							return Object.entries(value)[0][1];
						},
						getLatLng: function (value) {
							let latitude = value.latitude;
							let longitude = value.longitude;
							if (isNaN(latitude)) { latitude = 0 }
							if (isNaN(longitude)) { longitude = 0 }
							return { lat: latitude, lng: longitude }
						},
						icons: {
							icon: {
								iconUrl: "/beta/map/markers/m1_30.png",
								iconSize: [10, 10]
							},
							highlightIcon: {
								iconUrl: "/beta/map/markers/m1_30.png",
								iconSize: [15, 15]
							},
							selectedIcon: {
								iconUrl: "/beta/map/markers/m1y_0.png",
								iconSize: [15, 15]
							}
						}
					},
				},
				_mapCallback: {
					functions: {}
				}
			}
			window["ajaxMaps"][key] = new ajaxMap(element, key, mapOptions);
		})

		const tables = document.querySelectorAll('table[data-ajax]');
		tables.forEach((element, key) => {
			var tableOptions = {
				parseResponse: function (response) {
					const type = response.type;
					const data = response.data;
					const dataset = response.data.dataset;
					const records = data.records;
					const totalrecords = data.totalrecords;
					return { type, data, dataset, records, totalrecords };
				},
				_tableCallback: {
					functions: {}
				}
			}
			window["ajaxTables"][key] = new ajaxTable(element, key, tableOptions);
		})

		const templates = document.querySelectorAll('div[data-ajax="template"]');
		templates.forEach((element, key) => {
			var templateOptions = {
				_templateCallback: {
					functions: {}
				}
			}
			window["ajaxTemplates"][key] = new ajaxTemplate(element, key, templateOptions);
		})

	});

})();