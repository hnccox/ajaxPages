'use strict'

import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";

(function () {

    window["Tables"] = [];

    document.addEventListener('DOMContentLoaded', () => {

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