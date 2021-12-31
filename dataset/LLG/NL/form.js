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

	window.Forms = [];

	document.addEventListener('DOMContentLoaded', () => {

		const forms = document.querySelectorAll('form[data-ajax="form"]');
		forms.forEach((element, key) => {
			// Check if we already have specific id in our localStorage...
			// And if data in our localStorage is still valid...
			// Else

			var object = {
				_formCallback: {
					functions: {
						dataStorage
					}
				}
			}

			window["Forms"][key] = new ajaxForm(element, key, object);
			// ...and store data in our LocalStorage
		})

	});

})();