'use strict'

import { default as ajaxMap } from "/e107_plugins/ajaxTemplates/beta/js/ajaxMaps.js";
import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";
import { default as ajaxTemplate } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTemplates.js";

(function() {

	window["Maps"] = [];
	window["Tables"] = [];
	window["Templates"] = [];

	document.addEventListener('DOMContentLoaded', () => {
		
		const maps = document.querySelectorAll('.map[data-ajax="map"]');
        maps.forEach((element, key) => {
            Maps[key] = new ajaxMap(element, key);
        })

		const tables = document.querySelectorAll('table[data-ajax]');
		tables.forEach((element, key) => {
			Tables[key] = new ajaxTable(element, key);
		})

		const templates = document.querySelectorAll('div[data-ajax="template"]');
		templates.forEach((element, key) => {
			Templates[key] = new ajaxTemplate(element, key);
		})
		
	});
	
})();