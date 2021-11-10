'use strict'

import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";

(function () {

    window["ajaxTables"] = [];

    document.addEventListener('DOMContentLoaded', () => {

        const tables = document.querySelectorAll('table[data-ajax]');
		tables.forEach((element, key) => {
            var tableOptions = {
                parseResponse: function (response) {
                    const obj = response.data.dataset;
                    return obj;
                },
                _tableCallback: {
                    functions: {}
                }
            }
			window["ajaxTables"][key] = new ajaxTable(element, key, tableOptions);
		})

    });
    
})();