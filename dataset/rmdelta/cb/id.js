'use strict';

import { default as ajaxTemplate } from "/e107_plugins/ajaxModules/components/Template/ajaxTemplates.js";
import { default as storageHandler } from "/e107_plugins/storageHandler/js/storageHandler.js";

(function () {

	function dataStorage(obj) {
		console.log("dataStorage");
		Object.keys(obj).forEach((key) => {
			storageHandler.storage.local.set("dataStorage", obj[key])
		});
	}

	function hasReleaseCandidate(obj) {
		console.log("hasReleaseCandidate");
		Object.keys(obj).forEach((key) => {
			if (obj[key]["hasreleasecandidate"]) {
				document.getElementById("releasecandidateAlertWarning").classList.remove("hidden");
			}
		})
	}

	function id__cross_ref() {

		var regexCB = /(\ \(#[0-9]*\))/gm;
		var regexC14 = /(\ \(Beta-[0-9]*\))|(\ \(GrN-[0-9]*\))|(\ \(GrA-[0-9]*\))|(\ \(Poz-[0-9]*\))|(\ \(UtC-[0-9]*\))/gm;

		function zeroPad(input, length) {
			return (Array(length + 1).join('0') + input).slice(-length);
		}

		var myArray = Array.from(document.getElementsByClassName('id--cross-ref'));

		myArray.forEach(function (elem) {
			elem.innerHTML = elem.innerHTML.replace(regexCB, function ($1) {
				var id = $1;
				var url = "<a href='https://wikiwfs.geo.uu.nl/beta/RijnMaasDelta/CBcatalog/id.php?id=" + id.match(/\d+/g).map(Number) + "'>" + id.trim() + "</a>";
				return url;
			});

			elem.innerHTML = elem.innerHTML.replace(regexC14, function ($1) {
				var id = $1;
				var tmp = id.trim().substring(1, id.length - 2).split("-");

				if (tmp[1].length < 5) {
					tmp[1] = zeroPad(tmp[1], 5);
				}

				id = tmp.join("-");
				var url = "<a href='https://wikiwfs.geo.uu.nl/beta/RijnMaasDelta/C14catalog/labidnr.php?labidnr=" + id.trim() + "'>(" + id.trim() + ")</a>";
				return url;
			});
		});
	}

	window["ajaxTemplates"] = [];

	document.addEventListener('DOMContentLoaded', () => {
		const templates = document.querySelectorAll('div[data-ajax="template"]');
		templates.forEach((template, key) => {
			// Check if we already have specific id in our localStorage...
			// And if data in our localStorage is still valid...
			// Else
			// switch(template.table) {
			// 	case "":
			// 		break;
			// }
			
			var templateOptions = {
				parseResponse: function (response) {
					const data = response.data;
					const dataset = response.data.dataset[0];
					const records = data.records;
					const totalrecords = data.totalrecords;
					return { data, dataset, records, totalrecords };
				},
				_templateCallback: {
					functions: {
						dataStorage,
						hasReleaseCandidate,
						id__cross_ref
					},
				}
			};

			window["ajaxTemplates"][key] = new ajaxTemplate(template, key, templateOptions);
		})

	});

})();