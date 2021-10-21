'use strict'

import { default as ajaxMap } from "/e107_plugins/ajaxDBQuery/beta/js/ajaxMaps.js";
import { default as ajaxTable } from "/e107_plugins/ajaxDBQuery/beta/js/ajaxTables.js";
import { default as ajaxTemplate } from "/e107_plugins/ajaxDBQuery/beta/js/ajaxTemplates.js";

(function() {

	window["ajaxMaps"] = [];
	window["ajaxTables"] = [];
	window["ajaxTemplates"] = [];

	document.addEventListener('DOMContentLoaded', () => {
		
		const maps = document.querySelectorAll('div[data-ajax="map"]');
        maps.forEach((element, key) => {
            window["ajaxMaps"][key] = new ajaxMap(element, key);
        })

		const tables = document.querySelectorAll('table[data-ajax]');
		tables.forEach((element, key) => {
			window["ajaxTables"][key] = new ajaxTable(element, key);
		})

		const templates = document.querySelectorAll('div[data-ajax="template"]');
		templates.forEach((element, key) => {
			window["ajaxTemplates"][key] = new ajaxTemplate(element, key);
		})
		
	});
	
})();