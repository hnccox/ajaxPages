'use strict'

import { default as ajaxMap } from "/e107_plugins/ajaxTemplates/beta/js/ajaxMaps.js";
import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";
import { default as ajaxTemplate } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTemplates.js";

(function() {

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
							attribution: "Map data &copy; <a href=\"https://www.pdok.nl/\">CC BY Kadaster</a>"
						},
						layerParams: {
							addToMap: true,
							url: "https://geodata.nationaalgeoregister.nl/ahn3/wms"
						}
					},				
					C14: {
						layerType: "markerClusterGroup",
						layerOptions: {
							attribution: "C14 data &copy; <a href=\"https://www.uu.nl/\">CC BY Geowetenschappen</a>"
						},
						layerParams: {
							addToMap: true,
							url: "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php",
							db: "rmdelta",
							table: "c14_geom",
							columns: "c14_geom.borehole,c14_geom.longitude,c14_geom.latitude,c14_geom.xy,c14_geom.geom,xco,yco",
							offset: 0,
							limit: 500,
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
									"limit": 500
								},
								5: {
									"offset": 0
								}
							},
							zoomlevel: 13
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
							if(isNaN(latitude)) { latitude = 0 }
							if(isNaN(longitude)) { longitude = 0 }
							return { lat: latitude, lng: longitude }
						},
						icons: {
							icon: {
								iconUrl: "img/markers/m1_30.png",
								iconSize: [10, 10]
							},
							highlightIcon: {
								iconUrl: "img/markers/m1_30.png",
								iconSize: [15, 15]
							},
							selectedIcon: {
								iconUrl: "img/markers/m1y_0.png",
								iconSize: [15, 15]
							}
						}
					}
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