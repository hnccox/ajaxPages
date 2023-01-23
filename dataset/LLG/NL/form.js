'use strict';

import { default as ajaxForm } from "/e107_plugins/ajaxModules/Components/Form/ajaxForms.js";
import { default as storageHandler } from "/e107_plugins/storageHandler/js/storageHandler.js";

(function () {

	function dataStorage() {
		console.log("dataStorage");
		const elementList = document.querySelectorAll("span[data-variable]");
		elementList.forEach((element) => {
			storageHandler.storage.local.set(element.dataset.variable, element.innerText)
		});
	}

	window["ajaxForms"] = [];

	document.addEventListener('DOMContentLoaded', () => {

		const forms = document.querySelectorAll('form[data-ajax="form"]');
		forms.forEach((element, key) => {
			var formOptions = {
				parseResponse: function (response) {
					const type = response.type;
					const data = response.data;
					const dataset = response.data.dataset[0];
					const records = data.records;
					const totalrecords = data.totalrecords;
					return { type, data, dataset, records, totalrecords };
				},
				_formCallback: {
					functions: {
						dataStorage
					}
				}
			}
			// Check if we already have specific id in our localStorage...
			// And if data in our localStorage is still valid...
			// Else

			// var object = {
			// 	_formCallback: {
			// 		functions: {
			// 			dataStorage
			// 		}
			// 	}
			window["ajaxForms"][key] = new ajaxForm(element, key, formOptions);
			// ...and store data in our LocalStorage
		})

	});

})();