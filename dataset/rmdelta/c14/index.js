'use strict';

import { default as ajaxTable } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTables.js";

(function () {

	function InUseFor(element) {
        // var table = document.getElementsByTagName("table")[0];
        // table.innerHTML = table.innerHTML.replace(/<td>t/g, '<td>&#10004;').replace(/<td>f/g, '<td>');
        
        var table = element;
        var marinecurve2bused, inuseforchannelage, inuseforgwtinterpol, inuseforldem, inuseformslrise, inuseforvegetationhistory, inuseforlandsubsidence, inuseforcompactquant;
        marinecurve2bused = 4;
        inuseforchannelage = 5;
        inuseforgwtinterpol = 6;
        inuseforldem = 7;
        inuseformslrise = 8;
        inuseforvegetationhistory = 9;
        inuseforlandsubsidence = 10;
        inuseforcompactquant = 11;

        var lookuptable = {
            "true": "&#10004;",
            "false": ""
        }
		
        for (var i = 1; i < table.rows.length - 2; i++) {
			for (var j = 4; j < table.rows[i].cells.length; j++) {
			    table.rows[i].cells[j].innerHTML = lookuptable[table.rows[i].cells[j].innerText];
			}
        }
    }

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
					functions: {
						InUseFor
					}
				}
			}
			window["ajaxTables"][key] = new ajaxTable(element, key, tableOptions);
		})
		
	});

})();