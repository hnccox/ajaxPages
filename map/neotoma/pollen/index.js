'use strict'

import { default as ajaxMap } from "../../../../e107_plugins/ajaxTemplates/beta/js/ajaxMaps.js";
import { default as ajaxTable } from "../../../../e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";
import { default as ajaxTemplate } from "../../../../e107_plugins/ajaxTemplates/beta/js/ajaxTemplates.js";

(function () {

	/**
	 * Utility function to add CSS in multiple passes.
	 * @param {string} styleString
	 */
	function addStyle(styleString) {
		const style = document.createElement('style');
		style.textContent = styleString;
		document.head.append(style);
	}

	if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
		var layer = "dark";
	} else {
		var layer = "light";
	}

	addStyle(`.marker-cluster.marker-cluster-c14 { background-color: rgba(54, 69, 79, 0.6); }`);
	addStyle(`.marker-cluster.marker-cluster-llg_nl { background-color: rgba(196, 164, 132, 0.6); }`);
	addStyle(`.marker-cluster.marker-cluster-llg_it { background-color: rgba(196, 164, 132, 0.6); }`);

	function layerOpacity(layer) {
		console.log("layerOpacity");
		if (map.getZoom() >= 10) {
			layer.setOpacity(1.0)
		}
	}

	window["ajaxMaps"] = [];
	window["ajaxTables"] = [];
	window["ajaxTemplates"] = [];

	document.addEventListener('DOMContentLoaded', () => {

		const maps = document.querySelectorAll('div[data-ajax="map"]');
		maps.forEach((element, key) => {
			var mapOptions = {
				_defaults: {
					lat: parseFloat(element.dataset.lat, 10),
					lng: parseFloat(element.dataset.lng, 10),
					zoom: parseInt(element.dataset.zoom, 10),
					// minZoom: parseInt(element.dataset.minZoom, 10),
					// maxZoom: parseInt(element.dataset.maxZoom, 10)
				},
				_baseMaps: {
					layers: layer
				},
				_overlayMaps: {
					AHN3: {
						layerType: "tileLayer.WMS",
						layerOptions: {
							layers: "ahn3_5m_dsm",
							format: "image/png",
							version: "1.3.0",
							request: "GetMap",
							transparent: true,
							opacity: 0.6,
							crs: L.CRS.EPSG4326,
							attribution: "LiDAR data &copy; <a href=\"https://www.pdok.nl/\">CC BY Kadaster</a>"
						},
						layerParams: {
							addToMap: true,
							url: "https://geodata.nationaalgeoregister.nl/ahn3/wms",
							minZoom: 7,
							maxZoom: null
						}
					},				
					Neotoma: {
						layerType: "markerClusterGroup",
						layerOptions: {
							attribution: "Pollen data &copy; <a href=\"https://api.neotomadb.org/\">CC BY Neotoma DB</a>"
						},
						layerParams: {
							url: "//api.neotomadb.org/v2.0/data/geopoliticalunits/3180/sites?limit=500&offset=0",
							columns: "siteid,sitename,longitude,latitude",
							addToMap: false,
							cacheReturn: true,
							limit: 1000,
							disableClusteringAtZoom: 8,
							maxClusterRadius: 40
						},
						parseResponse: function (response) {
							const type = response.type;
							const data = response.data[0];
							const dataset = response.data[0].sites;
							let uid = 0;
							let coords = {};
							Object.keys(dataset).forEach((key) => {
								uid = this.getUID(dataset[key]);
								coords = this.getLatLng(dataset[key]);
								dataset[key].uid = uid;
								dataset[key].longitude = coords.lng;
								dataset[key].latitude = coords.lat;
							})
							const records = response.data[0].sites.length;
							const totalrecords = response.data[0].sites.length;
							return { type, data, dataset, records, totalrecords };
						},
						getUID: function (value) {
							return Object.entries(value)[0][1];
						},
						getLatLng: function (value) {
							let latitude, longitude;
							switch(JSON.parse(value.geography).type) {
								case "Point":
									latitude = JSON.parse(value.geography).coordinates[1];
									longitude = JSON.parse(value.geography).coordinates[0];
									break;
								case "Polygon":
									let coords = JSON.parse(value.geography).coordinates[0];
									let bounds = L.latLngBounds();
									coords.forEach((item) => {
										bounds.extend(item);
									})
									latitude = bounds.getCenter().lng;
									longitude = bounds.getCenter().lat;
									break;
							}

							if (isNaN(latitude)) { latitude = 0 }
							if (isNaN(longitude)) { longitude = 0 }

							return { lat: latitude, lng: longitude };
						},
						// icons: {
						// 	icon: {
						// 		iconUrl: "../icons/p1_30.png",
						// 		iconSize: [15, 15]
						// 	},
						// 	highlightIcon: {
						// 		iconUrl: "../icons/p1_30.png",
						// 		iconSize: [25, 25]
						// 	},
						// 	selectedIcon: {
						// 		iconUrl: "../icons/p1y_0.png",
						// 		iconSize: [25, 25]
						// 	}
						// }
						icons: {
							icon: {
								iconUrl: "../icons/m1_30.png",
								iconSize: [10, 10]
							},
							highlightIcon: {
								iconUrl: "../icons/m1_30.png",
								iconSize: [15, 15]
							},
							selectedIcon: {
								iconUrl: "../icons/m1y_0.png",
								iconSize: [15, 15]
							}
						}
					},			
				},
				_mapCallback: {
					functions: {
						layerOpacity
					}
				}
			}
			window["ajaxMaps"][key] = new ajaxMap(element, key, mapOptions);
		})

		const tables = document.querySelectorAll('table[data-ajax="table"]');
		tables.forEach((element, key) => {
			var tableOptions = {
				parseResponse: function (response) {
					const data = response.data;
					const dataset = response.data.dataset;
					const records = data.records;
					const totalrecords = data.totalrecords;
					return { data, dataset, records, totalrecords };
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
				parseResponse: function (response) {
					const data = response.data;
					const obj = response.data.dataset;
					const records = data["records"];
					const totalrecords = data["totalrecords"];
					delete data.records;
					delete data.totalrecords;
					return obj;
				},
				_templateCallback: {
					functions: {}
				}
			}
			window["ajaxTemplates"][key] = new ajaxTemplate(element, key, templateOptions);
		})

	});

})();