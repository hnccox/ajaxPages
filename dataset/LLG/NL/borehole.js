'use strict'

import { default as ajaxTable } from "/e107_plugins/ajaxModules/components/Table/ajaxTables.js";
import { default as ajaxTemplate } from "/e107_plugins/ajaxModules/components/Template/ajaxTemplates.js";

(function () {

    window["ajaxTables"] = [];
    window["ajaxTemplates"] = [];

    document.addEventListener('DOMContentLoaded', () => {

        const templates = document.querySelectorAll('div[data-ajax="template"]');
		templates.forEach((element, key) => {
            var templateOptions = {
                parseResponse: function (response) {
					const type = response.type;
					const data = response.data;
					const dataset = response.data.dataset[0];
					const records = data.records;
					const totalrecords = data.totalrecords;
					return { type, data, dataset, records, totalrecords };
				},
                _templateCallback: {
                    functions: {}
                }
            }
			window["ajaxTemplates"][key] = new ajaxTemplate(element, key, templateOptions);
		})

        const tables = document.querySelectorAll('table[data-ajax]');
		tables.forEach((element, key) => {
            var tableOptions = {
                parseResponse: function (response) {
					const type = response.type;
					const data = response.data;
					const dataset = response.data.dataset;
					const records = data.records;
					const totalrecords = data.totalrecords;
					return { type, data, dataset, records, totalrecords };
				},
                _tableCallback: {
                    functions: {}
                }
            }
			window["ajaxTables"][key] = new ajaxTable(element, key, tableOptions);
		})
        
    });
    
})();