'use strict';

import { default as ajaxTemplate } from "/e107_plugins/ajaxTemplates/beta/js/ajaxTemplates.js";
import { default as storageHandler } from "/e107_plugins/storageHandler/js/storageHandler.js";

(function () {

	function marineCurve2Bused() {
		if (document.querySelectorAll('[data-variable="marinecurve2bused"]')[0]?.innerText == "true") {
			document.querySelectorAll('[data-variable="marinecurve2bused"]')[0].innerText = "~";
			document.querySelectorAll('[data-variable="marinecurve2bused"]')[0].classList.remove("hidden");
		}
	}

	function siteType() {
		switch (document.querySelectorAll('[data-variable="sitetype"]')[0].innerText) {
			case "coring":
				document.getElementById("sitetype-icon").src = "./img/sitetype_coring.png";
				break;
			case "excavation":
				document.getElementById("sitetype-icon").src = "./img/sitetype_excavation.png";
				break;
			default:
				document.getElementById("sitetype-icon").src = "./img/sitetype_unknown.png";
		}
	}

	function boreholeURI() {
		const elementList = document.querySelectorAll("[data-variable=\"boreholedb\"]");
		elementList.forEach((element) => {
			if(element.innerHTML == "UU") {
				element.parentElement.style.pointerEvents = "auto";
				var boreholeId = element.parentElement.firstElementChild.innerText;
				element.parentElement.addEventListener('click', () => {
					window.open('https://wikiwfs.geo.uu.nl/LLG/NL/borehole.php?borehole='+boreholeId.replace(/\D/g,''), '_blank').focus();
				})
			}
		})
	}

	function dataStorage() {
		const elementList = document.querySelectorAll("[contenteditable='false']");
		elementList.forEach((element) => {
			storageHandler.storage.local.set(element.dataset.variable, element.innerText)
		});
	}

	window["ajaxTemplates"] = [];

	document.addEventListener('DOMContentLoaded', () => {

		const templates = document.querySelectorAll('div[data-ajax="template"]');
		templates.forEach((element, key) => {
			// Check if we already have specific id in our localStorage...
			// And if data in our localStorage is still valid...
			// Else

			var templateOptions = {
				parseResponse: function (response) {
					const data = response.data;
					const dataset = response.data.dataset[0];
					const records = data["records"];
					const totalrecords = data["totalrecords"];
					delete data.dataset;
					delete data.records;
					delete data.totalrecords;
					return { data, dataset, records, totalrecords };
				},
				_templateCallback: {
					functions: {
						marineCurve2Bused,
						siteType,
						boreholeURI,
						dataStorage
					}
				}
			}

			window["ajaxTemplates"][key] = new ajaxTemplate(element, key, templateOptions);
			// ...and store data in our LocalStorage

		})

	});

})();