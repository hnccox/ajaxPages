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
					Neotoma: {
						layerType: "markerClusterGroup",
						layerOptions: {
							attribution: "Pollen data &copy; <a href=\"https://api.neotomadb.org/\">CC BY Neotoma DB</a>"
						},
						layerParams: {
							//url: "//api.neotomadb.org/v2.0/data/geopoliticalunits/3180/sites",
							url: "//api.neotomadb.org/v2.0/data/geopoliticalunits/3180/sites?limit=500&offset=0",
							addToMap: false,
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
								iconUrl: "../icons/p1_30.png",
								iconSize: [15, 15]
							},
							highlightIcon: {
								iconUrl: "../icons/p1_30.png",
								iconSize: [25, 25]
							},
							selectedIcon: {
								iconUrl: "../icons/p1y_0.png",
								iconSize: [25, 25]
							}
						}
					},
					LLG_NL: {
						layerType: "markerClusterGroup",
						layerOptions: {
							attribution: "Borehole data &copy; <a href=\"https://www.uu.nl/\">CC BY Geowetenschappen</a>"
						},
						layerParams: {
							addToMap: false,
							url: "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php",
							db: "llg",
							table: "llg_nl_geom",
							columns: "llg_nl_geom.borehole,llg_nl_geom.longitude,llg_nl_geom.latitude,llg_nl_geom.xy,llg_nl_geom.geom,xco,yco,drilldepth",
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
							const data = response.data;
							const obj = response.data.dataset;
							const records = data["records"];
							const totalrecords = data["totalrecords"];
							delete data.records;
							delete data.totalrecords;
							return obj;
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
					LLG_IT: {
						layerType: "markerClusterGroup",
						layerOptions: {
							attribution: "Borehole data &copy; <a href=\"https://www.uu.nl/\">CC BY Geowetenschappen</a>"
						},
						layerParams: {
							addToMap: false,
							url: "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php",
							db: "llg",
							table: "llg_it_geom",
							columns: "llg_it_geom.borehole,llg_it_geom.longitude,llg_it_geom.latitude,llg_it_geom.xy,llg_it_geom.geom,xco,yco,drilldepth",
							offset: 0,
							limit: 1000,
							query: {
								0: {
									"select": {
										"columns": {
											0: "llg_it_geom.borehole,llg_it_geom.longitude,llg_it_geom.latitude,llg_it_geom.xy,llg_it_geom.geom,xco,yco,drilldepth"
										},
										"from": {
											"table": "llg_it_geom"
										}
									}
								},
								1: {
									"inner_join": {
										"table": "llg_it_boreholeheader",
										//"as": "",
										"on": {
											"identifier": "llg_it_geom.borehole",
											"value": "llg_it_boreholeheader.borehole"
										}
									}
								},
								2: {
									"where": {
										0: {
											"identifier": "llg_it_geom.longitude",
											"between": {
												0: ":xmin",
												1: ":xmax"
											}
										},
										1: {
											"identifier": "llg_it_geom.latitude",
											"between": {
												0: ":ymin",
												1: ":ymax"
											}
										}
									}
								},
								3: {
									"order_by": {
										0: {
											"identifier": "llg_it_geom.geom <-> 'SRID=4326;POINT(:lng :lat)'::geometry, llg_it_geom.borehole",
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
							disableClusteringAtZoom: 13
						},
						parseResponse: function (response) {
							const data = response.data;
							const obj = response.data.dataset;
							const records = data["records"];
							const totalrecords = data["totalrecords"];
							delete data.records;
							delete data.totalrecords;
							return obj;
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
					C14: {
						layerType: "markerClusterGroup",
						layerOptions: {
							attribution: "C14 data &copy; <a href=\"https://www.uu.nl/\">CC BY Geowetenschappen</a>"
						},
						layerParams: {
							addToMap: false,
							url: "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php",
							db: "rmdelta",
							table: "c14_geom",
							columns: "c14_geom.borehole,c14_geom.longitude,c14_geom.latitude,c14_geom.xy,c14_geom.geom,xco,yco",
							offset: 0,
							limit: 1000,
							query: {
								0: {
									"select": {
										"columns": {
											0: "c14_geom.labidnr,c14_geom.longitude,c14_geom.latitude,c14_geom.xy,c14_geom.geom,xco,yco"
										},
										"from": {
											"table": "c14_geom"
										}
									}
								},
								1: {
									"inner_join": {
										"table": "c14_cat",
										//"as": "",
										"on": {
											"identifier": "c14_geom.labidnr",
											"value": "c14_cat.labidnr"
										}
									}
								},
								2: {
									"where": {
										0: {
											"identifier": "c14_geom.longitude",
											"between": {
												0: ":xmin",
												1: ":xmax"
											}
										},
										1: {
											"identifier": "c14_geom.latitude",
											"between": {
												0: ":ymin",
												1: ":ymax"
											}
										}
									}
								},
								3: {
									"order_by": {
										0: {
											"identifier": "c14_geom.geom <-> 'SRID=4326;POINT(:lng :lat)'::geometry, c14_geom.labidnr",
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
							disableClusteringAtZoom: 10
						},
						parseResponse: function (response) {
							const data = response.data;
							const obj = response.data.dataset;
							const records = data["records"];
							const totalrecords = data["totalrecords"];
							delete data.records;
							delete data.totalrecords;
							return obj;
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
								iconUrl: "../icons/c14_0.png",
								iconSize: [10, 10]
							},
							highlightIcon: {
								iconUrl: "../icons/c14_0.png",
								iconSize: [15, 15]
							},
							selectedIcon: {
								iconUrl: "../icons/c14y_0.png",
								iconSize: [15, 15]
							}
						}
					}
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