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
							columns: "labidnr,samplename,c14age,c14err,xco,yco,latitude,longitude",
							offset: 0,
							limit: 1000,
							query: {
								0: {
									"select": {
										"columns": {
											0: "c14_geom.labidnr,c14_geom.longitude,c14_geom.latitude,c14_geom.xy,c14_geom.geom,xco,yco,c14_cat.samplename,c14_cat.c14age,c14_cat.c14err"
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
								iconUrl: "../../_icons/markers/c14_0.png",
								iconSize: [10, 10]
							},
							highlightIcon: {
								iconUrl: "../../_icons/markers/c14_0.png",
								iconSize: [15, 15]
							},
							selectedIcon: {
								iconUrl: "../../_icons/markers/c14y_0.png",
								iconSize: [15, 15]
							}
						}
					},
					"Bodemkaart": {
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
						},
						legendOptions: {
							service: "WMS",
							layers: "view_soil_area",
							format: "image/png",
							version: "1.3.0",
							request: "GetLegendGraphic",
							sld_version: "1.1.0",
							style: "bro-bodemkaart:bodemlegenda"
						},
						legendParams: {
							addToLegend: false,
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
						},
						legendOptions: {
							service: "WMS",
							layers: "view_geomorphological_area",
							format: "image/png",
							version: "1.3.0",
							request: "GetLegendGraphic",
							sld_version: "1.1.0",
							style: "view_geomorphological_area"
						},
						legendParams: {
							addToLegend: false,
							url: "https://service.pdok.nl/bzk/bro-geomorfologischekaart/wms/v1_0"
						}
					},
					"Pollen": {
						layerReference: { id: "pollen", name: "Pollen", description: "Dutch pollen data" },
						layerType: "markerClusterGroup",
						layerOptions: {
							attribution: "Pollen data &copy; <a href=\"https://api.neotomadb.org/\">CC BY Neotoma DB</a>"
						},
						layerParams: {
							addToMap: false,
							//url: "//api.neotomadb.org/v2.0/data/geopoliticalunits/3180/sites?limit=5&offset=0",
							url: "//api.neotomadb.org/v2.0/data/geopoliticalunits/3180/datasets?limit=500&offset=0",
							columns: "sitename,altitude,collectionunithandles,collectionunittypes,longitude,latitude",
							columnnames: "sitename,altitude,collectionunithandles,collectionunittypes,longitude,latitude",
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
							let collectionunithandleArray = [];
							let collectionunittypeArray = [];
							Object.keys(dataset).forEach((key) => {
								uid = this.getUID(dataset[key]);
								coords = this.getLatLng(dataset[key]);
								dataset[key].collectionunits.forEach((collectionunit) => {
									collectionunithandleArray = [];
									collectionunittypeArray = [];
									if (collectionunit?.handle) {
										if (!collectionunithandleArray.includes(collectionunit.handle)) {
											collectionunithandleArray.push(collectionunit.handle)
										}
									}
									if (collectionunit?.collectionunittype) {
										if (!collectionunittypeArray.includes(collectionunit.collectionunittype)) {
											collectionunittypeArray.push(collectionunit.collectionunittype)
										}
									}
								})
								dataset[key].uid = uid;
								dataset[key].longitude = coords.lng;
								dataset[key].latitude = coords.lat;
								dataset[key].collectionunithandles = collectionunithandleArray.toString();
								dataset[key].collectionunittypes = collectionunittypeArray.toString();
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
							switch (JSON.parse(value.geography).type) {
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
								iconUrl: "../../_icons/markers/m1_30.png",
								iconSize: [15, 15]
							},
							highlightIcon: {
								iconUrl: "../../_icons/markers/m1_30.png",
								iconSize: [25, 25]
							},
							selectedIcon: {
								iconUrl: "../../_icons/markers/m1y_0.png",
								iconSize: [25, 25]
							}
						}
					},
					"Macrofossils": {
						layerReference: { id: "macrofossils", name: "Macrofossils", description: "Dutch macrofossil data" },
						layerType: "markerClusterGroup",
						layerOptions: {
							attribution: "Pollen data &copy; <a href=\"https://api.neotomadb.org/\">CC BY Neotoma DB</a>"
						},
						layerParams: {
							addToMap: false,
							url: "//api.neotomadb.org/v2.0/data/geopoliticalunits/3180/sites?limit=500&offset=0",
							//url: "//api.neotomadb.org/v2.0/data/geopoliticalunits/3180/datasets?limit=500&offset=0",
							columns: "sitename,altitude,longitude,latitude",
							columnnames: "sitename,altitude,longitude,latitude",
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
							let collectionunithandleArray = [];
							let collectionunittypeArray = [];
							Object.keys(dataset).forEach((key) => {
								uid = this.getUID(dataset[key]);
								coords = this.getLatLng(dataset[key]);
								// dataset[key].collectionunits.forEach((collectionunit) => {
								// 	collectionunithandleArray = [];
								// 	collectionunittypeArray = [];
								// 	if (collectionunit?.handle) {
								// 		if (!collectionunithandleArray.includes(collectionunit.handle)) {
								// 			collectionunithandleArray.push(collectionunit.handle)
								// 		}
								// 	}
								// 	if (collectionunit?.collectionunittype) {
								// 		if (!collectionunittypeArray.includes(collectionunit.collectionunittype)) {
								// 			collectionunittypeArray.push(collectionunit.collectionunittype)
								// 		}
								// 	}
								// })
								dataset[key].uid = uid;
								dataset[key].longitude = coords.lng;
								dataset[key].latitude = coords.lat;
								// dataset[key].collectionunithandles = collectionunithandleArray.toString();
								// dataset[key].collectionunittypes = collectionunittypeArray.toString();
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
							switch (JSON.parse(value.geography).type) {
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
								iconUrl: "../../_icons/markers/m1_30.png",
								iconSize: [15, 15]
							},
							highlightIcon: {
								iconUrl: "../../_icons/markers/m1_30.png",
								iconSize: [25, 25]
							},
							selectedIcon: {
								iconUrl: "../../_icons/markers/m1y_0.png",
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