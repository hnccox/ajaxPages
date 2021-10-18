'use strict'

import { default as ajaxMap } from "/e107_plugins/ajaxTemplates/js/ajaxMaps.js";
import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/js/ajaxTables.js";
import { default as ajaxTemplate } from "/e107_plugins/ajaxTemplates/js/ajaxTemplates.js";

(function() {

	window["ajaxMaps"] = [];
	window["ajaxTables"] = [];
	window["ajaxTemplates"] = [];

	document.addEventListener('DOMContentLoaded', () => {
		
		const maps = document.querySelectorAll('.map[data-ajax="map"]');
        maps.forEach((element, key) => {
			var object = {
				_mapCallback: {
					functions: {}
				}
			}
            window["ajaxMaps"][key] = new ajaxMap(element, key, object);
        })

		const tables = document.querySelectorAll('table[data-ajax]');
		tables.forEach((element, key) => {
			var object = {
				_tableCallback: {
					functions: {}
				}
			}
			window["Tables"][key] = new ajaxTable(element, key, object);
		})

		const templates = document.querySelectorAll('div[data-ajax="template"]');
		templates.forEach((element, key) => {
			var object = {
				_templateCallback: {
					functions: {}
				}
			}
			window["Templates"][key] = new ajaxTemplate(element, key, object);
		})
		
	});
	
})();