'use strict';

import { default as ajaxMenu } from "/e107_plugins/ajaxTemplates/beta/js/ajaxMenus.js";
import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";

(function () {

    window["ajaxMenus"] = [];
    window["ajaxTables"] = [];

    document.addEventListener('DOMContentLoaded', () => {

        const menus = document.querySelectorAll('div[data-ajax="menu"]');
        menus.forEach((element, key) => {
            var object = {
                _menuCallback: {
                    functions: {}
                }
            }
            window["ajaxMenus"][key] = new ajaxMenu(element, key, object);
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