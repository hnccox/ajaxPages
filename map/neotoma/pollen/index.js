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

	addStyle(`.marker-cluster-c14 { background-color: #36454F; }`);
	addStyle(`.marker-cluster-boreholes { background-color: #C4A484; }`);

	function layerOpacity(layer) {
		console.log("layerOpacity");
		if (map.getZoom() >= 10) {
			layer.setOpacity(1.0)
		}
	}

	function tabulateModal(data) {
		console.log(data.collectionunits[0].datasets);
		var url = "#";
		Object.keys(data.collectionunits[0].datasets).forEach((key) => {
			if(data.collectionunits[0].datasets[key].datasettype == "pollen") {
				url = "https://data-dev.neotomadb.org/" + data.collectionunits[0].datasets[key].datasetid
			}
		})
		window["ajaxTemplates"][0].element.querySelectorAll('[data-variable="url"')[0].href = url;
		// window["ajaxTemplates"][0].element.querySelectorAll(".modal-body")[0].innerHTML = JSON.stringify(data);
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
					layers: "dark"
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
							url: "https://geodata.nationaalgeoregister.nl/ahn3/wms"
						}
					},
					"BRO Geomorfologische Kaart": {
						layerType: "tileLayer.WMS",
						layerOptions: {
							layers: "view_geomorphological_area",
							format: "image/png",
							version: "1.3.0",
							request: "GetMap",
							transparent: true,
							opacity: 0.6,
							crs: L.CRS.EPSG4326,
							attribution: "BRO data &copy; <a href=\"https://www.pdok.nl/\">CC BY Kadaster</a>"
						},
						layerParams: {
							addToMap: false,
							url: "https://service.pdok.nl/bzk/bro-geomorfologischekaart/wms/v1_0"
						}
					},
					Neotoma: {
						layerType: "markerClusterGroup",
						layerOptions: {
							attribution: "Pollen data &copy; <a href=\"https://api.neotomadb.org/\">CC BY Neotoma DB</a>"
						},
						layerParams: {
							//url: "//api.neotomadb.org/v2.0/data/geopoliticalunits/3180/sites",
							url: "//api.neotomadb.org/v2.0/data/geopoliticalunits/3180/sites?limit=500&offset=0",
							addToMap: true,
							cacheReturn: true,
							limit: 1000,
							disableClusteringAtZoom: 8,
							maxClusterRadius: 40
						},
						parseResponse: function (response) {
							const obj = response.data[0].sites;
							return obj;
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
						icons: {
							icon: {
								iconUrl: "../../icons/p1_30.png",
								iconSize: [15, 15]
							},
							highlightIcon: {
								iconUrl: "../../icons/p1_30.png",
								iconSize: [25, 25]
							},
							selectedIcon: {
								iconUrl: "../../icons/p1y_0.png",
								iconSize: [25, 25]
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

		const tables = document.querySelectorAll('table[data-ajax]');
		tables.forEach((element, key) => {
			var tableOptions = {
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
					const obj = response.data[0];
					return obj;
				},
				_templateCallback: {
					functions: {
						tabulateModal
					}
				},
			}
			window["ajaxTemplates"][key] = new ajaxTemplate(element, key, templateOptions);
		})

	});

})();