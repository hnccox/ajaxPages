function C14Catalogue() {
	console.log("C14Catalogue");

	function InUseFor() {
		// var table = document.getElementsByTagName("table")[0];
		// table.innerHTML = table.innerHTML.replace(/<td>t/g, '<td>&#10004;').replace(/<td>f/g, '<td>');
		
		var table = document.getElementsByTagName("table")[0];
		var marinecurve2bused, inuseforchannelage, inuseforgwtinterpol, inuseforldem, inuseformslrise, inuseforvegetationhistory, inuseforlandsubsidence, inuseforcompactquant;
		marinecurve2bused = 4;
		inuseforchannelage = 5;
		inuseforgwtinterpol = 6;
		inuseforldem = 7;
		inuseformslrise = 8;
		inuseforvegetationhistory = 9;
		inuseforlandsubsidence = 10;
		inuseforcompactquant = 11;

		for (i = 1; i < table.rows.length; i++) {

			if (table.rows[i].cells[marinecurve2bused].innerText == "1") {
				table.rows[i].cells[marinecurve2bused].innerHTML = "&excl;";
			} else {
				table.rows[i].cells[marinecurve2bused].innerText = "";
			}

			if (table.rows[i].cells[inuseforchannelage].innerText == "1") {
				table.rows[i].cells[inuseforchannelage].innerHTML = "&#10004;";
			} else {
				table.rows[i].cells[inuseforchannelage].innerText = "";
			}

			if (table.rows[i].cells[inuseforgwtinterpol].innerText == "1") {
				table.rows[i].cells[inuseforgwtinterpol].innerHTML = "&#10004;";
			} else {
				table.rows[i].cells[inuseforgwtinterpol].innerText = "";
			}

			if (table.rows[i].cells[inuseformslrise].innerText == "1") {
				table.rows[i].cells[inuseformslrise].innerHTML = "&#10004;";
			} else {
				table.rows[i].cells[inuseformslrise].innerText = "";
			}

			if (table.rows[i].cells[inuseforvegetationhistory].innerText == "1") {
				table.rows[i].cells[inuseforvegetationhistory].innerHTML = "&#10004;";
			} else {
				table.rows[i].cells[inuseforvegetationhistory].innerText = "";
			}

			if (table.rows[i].cells[inuseforlandsubsidence].innerText == "1") {
				table.rows[i].cells[inuseforlandsubsidence].innerHTML = "&#10004;";
			} else {
				table.rows[i].cells[inuseforlandsubsidence].innerText = "";
			}

			if (table.rows[i].cells[inuseforcompactquant].innerText == "1") {
				table.rows[i].cells[inuseforcompactquant].innerHTML = "&#10004;";
			} else {
				table.rows[i].cells[inuseforcompactquant].innerText = "";
			}

		}
	}

	InUseFor(); /* Fuck Google Chrome */

}

// Wait for the page to be parsed
$(document).ready(function () {
	setTimeout(function () {
		C14Catalogue();
	}, 1000);
});
