'use strict'

import { default as ajaxMap } from "/e107_plugins/ajaxTemplates/js/ajaxMaps.js";
import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/js/ajaxTables.js";
import { default as ajaxTemplate } from "/e107_plugins/ajaxTemplates/js/ajaxTemplates.js";

(function() {

	window.Maps = [];
	window.Tables = [];
	window.Templates = [];

	document.addEventListener('DOMContentLoaded', () => {
		
		const maps = document.querySelectorAll('.map[data-ajax="map"]');
        maps.forEach((element, key) => {
            Maps[key] = new ajaxMap(element, key);
        })

		const tables = document.querySelectorAll('table[data-ajax]');
		tables.forEach((element, key) => {
			var object = {
				_tableCallback: {
					functions: {}
				}
			}
			Tables[key] = new ajaxTable(element, key, object);
		})

		const templates = document.querySelectorAll('div[data-ajax="template"]');
		templates.forEach((element, key) => {
			var object = {
				_templateCallback: {
					functions: {}
				}
			}
			Templates[key] = new ajaxTemplate(element, key, object);
		})
		
	});
	
})();