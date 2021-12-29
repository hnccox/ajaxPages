'use strict'

import { default as ajaxMap } from "/e107_plugins/ajaxModules/Components/Map/ajaxMaps.js";
import { default as ajaxTable } from "/e107_plugins/ajaxModules/Components/Table/ajaxTables.js";
import { default as ajaxTemplate } from "/e107_plugins/ajaxModules/Components/Template/ajaxTemplates.js";

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
	addStyle(`.marker-cluster-llg_nl { background-color: #C4A484; }`);
	addStyle(`.marker-cluster-llg_it { background-color: #C4A484; }`);

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
							addToMap: false,
							url: "https://geodata.nationaalgeoregister.nl/ahn3/wms",
							minZoom: 7,
							maxZoom: null
						}
					},
					"BRO Bodemkaart": {
						layerType: "tileLayer.WMS",
						layerOptions: {
							layers: "view_soil_area",
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
							url: "https://geodata.nationaalgeoregister.nl/bzk/bro-bodemkaart/wms/v1_0"
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
							columns: "borehole,longitude,latitude,xco,yco,drilldepth",
							offset: 0,
							limit: 500,
							query: {
								0: {
									"select": {
										"columns": {
											0: "llg_nl_geom.borehole,llg_nl_geom.longitude,llg_nl_geom.latitude,llg_nl_geom.xy,llg_nl_geom.geom,xco,yco,drilldepth,active"
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
											/*"identifier": "llg_nl_geom.geom <-> 'SRID=4326;POINT(:lng :lat)'::geometry, llg_nl_geom.borehole",*/
											"identifier": "llg_nl_geom.borehole",
											"direction": "ASC"
										}
									}
								},
								4: {
									"limit": 500
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