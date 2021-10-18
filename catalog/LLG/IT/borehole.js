'use strict'

import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";
import { default as ajaxTemplate } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTemplates.js";

(function () {

    window["Tables"] = [];
    window["Templates"] = [];

    document.addEventListener('DOMContentLoaded', () => {

        const templates = document.querySelectorAll('div[data-ajax="template"]');
		templates.forEach((element, key) => {
            var object = {
                _templateCallback: {
                    functions: {}
                }
            }
			window["Templates"][key] = new ajaxTemplate(element, key, object);
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
        
    });
    
})();