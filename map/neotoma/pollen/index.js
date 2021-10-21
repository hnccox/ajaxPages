'use strict'

import { default as ajaxMap } from "../../../../e107_plugins/ajaxTemplates/beta/js/ajaxMaps_neotoma.js";
import { default as ajaxTable } from "../../../../e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";
import { default as ajaxTemplate } from "../../../../e107_plugins/ajaxTemplates/beta/js/ajaxTemplates.js";

(function () {

    window["ajaxMaps"] = [];
    window["ajaxTables"] = [];
    window["ajaxTemplates"] = [];

    document.addEventListener('DOMContentLoaded', () => {

		let AHN3 = L.tileLayer.wms('', {

        });

        const maps = document.querySelectorAll('div[data-ajax="map"]');
        maps.forEach((element, key) => {
            var mapOptions = {
				_overlayMaps: {
					AHN3: { 
						layerType: "WMS", 
						url: 'https://geodata.nationaalgeoregister.nl/ahn3/wms', 
						layerOptions: { 
							layers: 'ahn3_05m_dsm',
							format: 'image/png',
							version: '1.3.0',
							transparent: true,
							opacity: 0.5,
							crs: L.CRS.EPSG4326,
							attribution: 'Map data &copy; <a href="https://www.pdok.nl/">CC BY Kadaster</a>'
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