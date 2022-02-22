'use strict';

import { default as ajaxTemplate } from "/e107_plugins/ajaxModules/Components/Template/ajaxTemplates.js";
import { default as storageHandler } from "/e107_plugins/storageHandler/js/storageHandler.js";

(function () {

	function typeOfReasoning() {
		console.log('typeOfReasoning');

		var reasoningcategory = document.querySelectorAll('[data-variable$="reasoningcategory"]');

		reasoningcategory.forEach(category => {

			// <a tabindex="0" class="btn btn-lg btn-danger" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?">Dismissible popover</a>

			switch (category.textContent) {
				case "0":
					category.textContent = 'Unknown';
					break;
				case "1":
					category.textContent = 'Direct Historical';
					break;
				case "2":
					category.textContent = 'Direct Multiple';
					break;
				case "3":
					category.textContent = 'Direct Single';
					break;
				case "4":
					category.textContent = 'Indirect UpStrm';
					break;
				case "5":
					category.textContent = 'Indirect DnStrm';
					break;
				case "6":
					category.textContent = 'Indirect Avulsion';
					break;
				case "7":
					category.textContent = 'Indirect CrossCut';
					break;
				case "8":
					//category.textContent = 'Reserved';
					break;
				case "9":
					//category.textContent = 'Reserved';
					break;
				case "10":
					category.textContent = 'Best Guess';
					break;
				default:
					break;
			}
		})
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
				var url = " <a href='https://wikiwfs.geo.uu.nl/views/dataset/rmdelta/cb/id.php?id=" + id.match(/\d+/g).map(Number) + "'>" + id.trim() + "</a>";
				return url;
			});

			elem.innerHTML = elem.innerHTML.replace(regexC14, function ($1) {
				var id = $1;
				var tmp = id.trim().substring(1, id.length - 2).split("-");

				if (tmp[1].length < 5) {
					tmp[1] = zeroPad(tmp[1], 5);
				}

				id = tmp.join("-");
				var url = " <a href='https://wikiwfs.geo.uu.nl/views/dataset/rmdelta/c14/labidnr.php?labidnr=" + id.trim() + "'>(" + id.trim() + ")</a>";
				return url;
			});
		});
	}

	function dataStorage(obj) {
		console.log("dataStorage");
		Object.keys(obj).forEach((key) => {
			storageHandler.storage.local.set("dataStorage", obj[key])
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
						id__cross_ref,
						typeOfReasoning
					},
				}
			};

			window["ajaxTemplates"][key] = new ajaxTemplate(template, key, templateOptions);
		})

	});

})();