'use strict'

import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";

(function () {

    window["ajaxTables"] = [];

    document.addEventListener('DOMContentLoaded', () => {

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