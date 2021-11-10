'use strict'

import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";
import { default as ajaxTemplate } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTemplates.js";

(function () {

    window["ajaxTables"] = [];
    window["ajaxTemplates"] = [];

    document.addEventListener('DOMContentLoaded', () => {

        const templates = document.querySelectorAll('div[data-ajax="template"]');
		templates.forEach((element, key) => {
            var object = {
                _templateCallback: {
                    functions: {}
                }
            }
			window["ajaxTemplates"][key] = new ajaxTemplate(element, key, object);
		})

        const tables = document.querySelectorAll('table[data-ajax]');
		tables.forEach((element, key) => {
            var object = {
                _tableCallback: {
                    functions: {}
                }
            }
			window["ajaxTables"][key] = new ajaxTable(element, key, object);
		})
        
    });
    
})();