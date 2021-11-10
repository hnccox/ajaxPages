'use strict';

export function marineCurve2Bused() {
	if (document.querySelectorAll('[data-variable="marinecurve2bused"]')[0].innerText == "true") {
		document.querySelectorAll('[data-variable="marinecurve2bused"]')[0].innerText = "~";
		document.querySelectorAll('[data-variable="marinecurve2bused"]')[0].classList.remove("hidden");
	}
}

export function siteType() {
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

export function boreholeURI() {
	const elementList = document.querySelectorAll("[data-variable=\"boreholedb\"]");
	elementList.forEach((element) => {
		if (element.innerHTML == "UU") {
			element.parentElement.style.pointerEvents = "auto";
			var boreholeId = element.parentElement.firstElementChild.innerText;
			element.parentElement.addEventListener('click', () => {
				window.open('https://wikiwfs.geo.uu.nl/LLG/NL/borehole.php?borehole=' + boreholeId.replace(/\D/g, ''), '_blank').focus();
			})
		}
	})
}

export function dataStorage() {
	const elementList = document.querySelectorAll("[contenteditable='false']");
	elementList.forEach((element) => {
		storageHandler.storage.local.set(element.dataset.variable, element.innerText)
	});
}
