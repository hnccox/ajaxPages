'use strict';

import { default as ajaxMap } from "/e107_plugins/ajaxModules/Components/Map/ajaxMaps.js";
import { default as ajaxTable } from "/e107_plugins/ajaxModules/Components/Table/ajaxTables.js";
import { default as ajaxTemplate } from "/e107_plugins/ajaxModules/Components/Template/ajaxTemplates.js";

import { exportDataAsXML } from "../js/LLG.js";


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
					"UU LLG_NL": {
						layerType: "markerClusterGroup",
						layerOptions: {
							attribution: "Borehole data &copy; <a href=\"https://wikiwfs.geo.uu.nl/\">CC BY Geowetenschappen</a>"
						},
						layerParams: {
							addToMap: true,
							url: "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php",
							db: "llg",
							table: "llg_nl_geom",
							columns: "borehole,xco,yco,drilldepth",
							offset: 0,
							limit: 1000,
							query: {
								0: {
									"select": {
										"columns": {
											0: "llg_nl_geom.borehole,llg_nl_geom.longitude,llg_nl_geom.latitude,llg_nl_geom.xy,llg_nl_geom.geom,llg_nl_boreholeheader.name,llg_nl_boreholeheader.drilldate,llg_nl_boreholeheader.xco,llg_nl_boreholeheader.yco,llg_nl_boreholeheader.coordzone,llg_nl_boreholeheader.elevation,llg_nl_boreholeheader.drilldepth,llg_nl_boreholeheader.geom,llg_nl_boreholeheader.geol,llg_nl_boreholeheader.soil,llg_nl_boreholeheader.veget,llg_nl_boreholeheader.groundwaterstep,llg_nl_boreholeheader.extraremarks,llg_nl_boreholeheader.active"
										},
										"from": {
											"table": "llg_nl_geom"
										}
									}
								},
								1: {
									"inner_join": {
										"table": "llg_nl_boreholeheader",
										// "as": "h",
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
											// "identifier": "llg_nl_geom.borehole",
											"direction": "ASC"
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
						tableParams: {
							addToTable: "true",
						},
						templateParams: {
							addToTemplate: "false",
							url: "https://wikiwfs.geo.uu.nl/views/dataset/LLG/NL/borehole.php?borehole=:uid"
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
								iconUrl: "../../_icons/markers/m1_30.png",
								iconSize: [10, 10]
							},
							highlightIcon: {
								iconUrl: "../../_icons/markers/m1_30.png",
								iconSize: [15, 15]
							},
							selectedIcon: {
								iconUrl: "../../_icons/markers/m1y_0.png",
								iconSize: [15, 15]
							}
						}
					},
				},
				constructor() { },
				destructor() { },
				methods: {
					exportData: {

					}
				},
				_controls: {
					exportData: (map) => {
						return L.control.exportdata({
							position: 'topright',
							maxWidth: 50,
							formats: [
								{
									type: "XML",
									icon: "bi bi-code-slash",
									text: "",
									layer: "",
									method: (data) => { return exportDataAsXML(data) }
								}],
						}).addTo(map)
					},
				},
				_mapCallback: {
					functions: {}
				}
			}
			window["ajaxMaps"][key] = new ajaxMap(element, key, mapOptions);
		})

		const tables = document.querySelectorAll('table[data-ajax]:not([id])');
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

		const templates = document.querySelectorAll('div[data-ajax="template"]:not([id])');
		templates.forEach((element, key) => {
			var templateOptions = {
				parseResponse: function (response) {
					const type = response.type;
					const data = response.data;
					const dataset = response.data.dataset[0];
					const records = data.records;
					const totalrecords = data.totalrecords;
					return { type, data, dataset, records, totalrecords };
				},
				_templateCallback: {
					functions: {}
				}
			}
			window["ajaxTemplates"][key] = new ajaxTemplate(element, key, templateOptions);
		})

	});

})();