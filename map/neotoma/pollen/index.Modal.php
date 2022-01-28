<?php

// ------------------------------------------------

$modal = '
<!-- Button trigger modal -->
<!--
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#welcomeModal">
  Launch demo modal
</button>
-->

<!-- Vertically centered scrollable modal -->

<div class="modal fade show" id="welcomeModalCenteredScrollable" tabindex="-1" aria-labelledby="welcomeModalCenteredScrollableTitle" style="display: block;" aria-modal="true" role="dialog">
  	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="welcomeModalCenteredScrollableTitle">Dutch Pollen Explorer</h5>
				<button type="button" class="btn-close" data-bs-dismiss="welcomeModalCenteredScrollable" aria-label="Close"></button>
			</div>

			<div class="modal-body">
				<nav>
					<div class="nav nav-tabs" id="nav-welcome-tab" role="tablist">
						<button class="nav-link active" id="nav-welcome-dutch-tab" data-bs-toggle="tab" data-bs-target="#nav-welcome-dutch" type="button" role="tab" aria-controls="nav-welcome-dutch" aria-selected="true">Nederlands</button>
						<button class="nav-link" id="nav-welcome-english-tab" data-bs-toggle="tab" data-bs-target="#nav-welcome-english" type="button" role="tab" aria-controls="nav-welcome-english" aria-selected="false">English</button>
					</div>
				</nav>

				<div class="tab-content" id="nav-welcome-tabContent">
					<div class="tab-pane fade show active" id="nav-welcome-dutch" role="tabpanel" aria-labelledby="nav-welcome-dutch-tab">
						<br>
						<b>Welkom bij de Nederlandse pollen explorer.</b>
						<p>
							Hier kunt u de beschikbare pollen en macrofossielen data in Nederland bekijken. 
							Klik op <i class="fa fa-info"></i> voor meer informatie en uitleg over de viewer en op <img height="15" src="https://wikiwfs.geo.uu.nl/e107_web/lib/leaflet/plugins/leaflet.wmslegend/images/legend.png"> voor de legenda\'s van de kaartlagen. Information in English is given below.
						</p>
		
						<b>Over de viewer</b>
						<p>
							Deze applicatie weergeeft de locaties van beschikbaar gestelde palaeo-ecologische pollen data in combinatie met andere nationale datasets en kaarten. 
							Voor overige zoekopdrachten inclusief zoekopdrachten die gebruik maken van dateringen kunt u gebruik maken van de <a href="https://neotomadb.org/">Neotoma Explorer</a>. 
						</p>
					</div>
					<div class="tab-pane fade" id="nav-welcome-english" role="tabpanel" aria-labelledby="nav-welcome-english-tab">
						<br>
						<b>Welcome at the Dutch pollen explorer.</b>
						<p>
							Here, you can view all available pollen data across the Netherlands. 
							Click on the <i class="fa fa-info"></i> for more information on the pollen viewer and on <img height="15" src="https://wikiwfs.geo.uu.nl/e107_web/lib/leaflet/plugins/leaflet.wmslegend/images/legend.png"> to show the legends of the layers.
						</p>
						
						<b>About the viewer</b>
						<p>
							This tool displays the location of palaeoecological data in relation to national map resources and other national datasets. 
							For other types of searches including age restrictions please query the data using the <a href="https://neotomadb.org/">Neotoma Explorer</a>.
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="welcomeModalCenteredScrollable">Dismiss</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="infoModalCenteredScrollable" tabindex="-1" aria-labelledby="infoModalCenteredScrollableTitle" style="display: none;" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="infoModalCenteredScrollableTitle">Dutch Pollen Explorer</h5>
				<button type="button" class="btn-close" data-bs-dismiss="infoModalCenteredScrollable" aria-label="Close"></button>
			</div>

			<div class="modal-body">
				<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<button class="nav-link active" id="nav-dutch-tab" data-bs-toggle="tab" data-bs-target="#nav-dutch" type="button" role="tab" aria-controls="nav-dutch" aria-selected="true">Nederlands</button>
						<button class="nav-link" id="nav-english-tab" data-bs-toggle="tab" data-bs-target="#nav-english" type="button" role="tab" aria-controls="nav-english" aria-selected="false">English</button>
					</div>
				</nav>

				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-dutch" role="tabpanel" aria-labelledby="nav-dutch-tab">
						<br>
						<div id="accordion-dutch">
							<div class="card">
								<div class="card-header" id="headingOne-dutch">
									<h5 class="mb-0">
										<button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseOne-dutch" aria-expanded="false" aria-controls="collapseOne-dutch">
											Functionaliteit
										</button>
									</h5>
								</div>
								<div id="collapseOne-dutch" class="collapse" aria-labelledby="headingOne-dutch" data-parent="#accordion-dutch">
									<div class="card-body">
										<p>
											Aan de rechterzijde van de kaart van Nederland, kunt u aangeven welke lagen u wilt zien.
											U kunt kiezen uit de volgende kaartlagen: pollen, macrofossielen, C14-dateringen, AHN, geomorfologische kaart en bodemkaart. 
										</p>
										<p>
											Door op de naam van de laag te klikken, wordt deze toegevoegd aan de kaart en wordt, indien van toepassing, 
											een tabel met meer informatie over de beschikbare datasets geopend. 
											De tabel kan gesloten worden door te klikken op het kruisje rechts naast de naam van de tabel en opnieuw geopend door de kaartlaag opnieuw te selecteren. 
										</p>
										<!--<p>
											Alle datasets tegelijkertijd kunnen worden gedownload door te klikken op … (fill in symbol of the download function). 
											Losse datasets kunnen worden gedownload door een individuele locatie aan te klikken in de kaart. 
										</p>-->
										<p>
											Legenda\'s van de verschillende kaartlagen worden weergeven onder <img height="15" src="https://wikiwfs.geo.uu.nl/e107_web/lib/leaflet/plugins/leaflet.wmslegend/images/legend.png" /> wanneer een kaartlaag actief is. 
										</p>
										<!--<p>
											Specifieke datasets of sites kunnen worden gezocht door de naam van de locatie in te voeren in de zoekbalk recht onderin het scherm. 
										</p>-->
										<p>
											Data rondom uw locatie kan worden gevonden door gebruik te maken van de geolocatie-functie. 
											Deze functie wordt geactiveerd door te klikken op <i class="fa fa-location-arrow"></i> rechts boven in het kaartbeeld.
											Uw locatie wordt dan weergeven op de kaart en er wordt een vierkant rondom weergeven. 
											Dit vierkant kan worden verwijderd door te klikken op <i class="fa fa-trash"></i> aan de linkerzijde van het scherm. 
											<i>Let op! Deze functie werkt mogelijk niet in Firefox, maak dan gebruik van een andere internet browser.</i>
										</p>
									</div>
								</div>
							</div>
							<br>
							<div class="card">
								<div class="card-header" id="headingTwo-dutch">
									<h5 class="mb-0">
										<button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseTwo-dutch" aria-expanded="false" aria-control="collapseTwo-dutch">
											Over de kaartlagen
										</button>
									</h5>
								</div>
								<div id="collapseTwo-dutch" class="collapse" aria-labbeledby="headingTwo-dutch" data-parent="#accordion-dutch">
									<div class="card-body">
										<p>
											De <b>pollen datasets</b> en <b>macrofossiel datasets</b> bestaan ieder uit een unieke dataset code ("Handle"), 
											locatienaam ("Site name"), hoogte in meters ("Site Altitude") en data/site type ("Collection Type"). 
											Door op de locatie in de kaart te selecteren, wordt de locatie opgelicht in de tabel. 
											Door op een van de regels in de tabel te klikken, wordt u doorgeleid naar de dataset op de Neotoma database. 
										</p>
										<p>
											Het <b>Algemene Hoogtebestand Nederland (AHN)</b> bevat gedetailleerde hoogtegegevens voor heel Nederland. 
											Dit bestand bevat de hoogtegegevens op elke vierkante kilometer van het land. 
											Op deze applicatie wordt het AHN-3 weergeven, deze data is verkregen in de periode 2014-2019. 
											Meer informatie over deze nationale dataset is te vinden op <a href="https://www.ahn.nl/">https://www.ahn.nl/</a>. 
										</p>
										<p>
											De <b>Geomorfologische kaart</b> is een unieke kaart alleen beschikbaar voor Nederland. 
											De kaart bevat informatie over de zogeheten landvormen; een combinatie van verschillende geologische factoren. 
											Meer informatie over deze dataset is te vinden op <a href="https://www.pdok.nl/-/geomorfologische-kaart-nederland-beschikbaar-bij-pdok">PDOK</a>. 
										</p>
										<p>
											De <b>Bodemkaart van Nederland</b> is gebaseerd op boorprofielen die genomen zijn door heel Nederland tot een diepte van ca. 1,50 m. 
											De dataset bevat gegevens over de verschillende bodemtypen die voorkomen in Nederland. 
											Meer informatie kan gevonden worden op <a href="https://www.pdok.nl/-/de-bodemkaart-van-nederland-beschikbaar-bij-pdok">PDOK</a>.
										</p>
									</div>
								</div>
							</div>
							<br>
							<div class="card">
								<div class="card-header" id="headingThree-dutch">
									<h5 class="mb-0">
										<button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseThree-dutch" aria-expanded="false" aria-control="collapseThree-dutch">
											Legenda
										</button>
									</h5>
								</div>
								<div id="collapseThree-dutch" class="collapse" aria-labbeledby="headingThree-dutch" data-parent="#accordion-dutch">
									<div class="card-body">
										<p>
											Van de volgende kaartlagen is een legenda beschikbaar: AHN, geomorfologische kaart en bodemkaart.
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="nav-english" role="tabpanel" aria-labelledby="nav-english-tab">
						<br>
						<div id="accordion-english">
							<div class="card">
								<div class="card-header" id="headingOne-english">
									<h5 class="mb-0">
										<button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseOne-english" aria-expanded="false" aria-controls="collapseOne-english">
											Functionality
										</button>
									</h5>
								</div>
								<div id="collapseOne-english" class="collapse" aria-labelledby="headingOne-english" data-parent="#accordion-english">
									<div class="card-body">
										<p>
											On the right side of the map of the Netherlands, you can decide which layer to display. 
											The following map layers are available: pollen, macrofossils, C14-dates, AHN, geomorphological map, soil map.
										</p>
										<p>
											By clicking on the name of the layer, the layer will be added to the map and, when possible, 
											a table with more information will be opened on the bottom of the screen.
											The table can be closed by clicking on the X on the tab and can be reopened by reselecting the layer.
										</p>
										<!--<p>
											All dataset can be downloaded simultaneously by clicking on … (fill in symbol of the download function). 
											Individual datasets can be downloaded by selecting an individual site in the map.
										</p>-->
										<p>
											Legends of the individual layers are shown under <img height="15" src="https://wikiwfs.geo.uu.nl/e107_web/lib/leaflet/plugins/leaflet.wmslegend/images/legend.png" /> when a layer is active. 
										</p>
										<!--<p>
											Specific datasets or sites can be searched by typing in the name of the location in the search bar at the bottom right of the map.
										</p>-->
										<p>
											Data around your location can be found by activating the geolocation function. 
											This function can be activated by clicking on <i class="fa fa-location-arrow"></i> top-right in the map.
											Your location will be displayed on the map with a square around your location. 
											This square can then be deleted by clicking on the <i class="fa fa-trash"></i> on the left side of the map. 
											<i>This function might not work in Firefox, use a different browser if problems occur!</i>
										</p>
									</div>
								</div>
							</div>
							<br>
							<div class="card">
								<div class="card-header" id="headingTwo-english">
									<h5 class="mb-0">
										<button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseTwo-english" aria-expanded="false" aria-control="collapseTwo-english">
											About the layers
										</button>
									</h5>
								</div>
								<div id="collapseTwo-english" class="collapse" aria-labbeledby="headingTwo-english" data-parent="#accordion-english">
									<div class="card-body">
										<p>
											All <b>pollen datasets</b> and <b>macrofossil datasets</b> contain a dataset identifier ("Handle"), 
											location name ("SiteName"), coordinates (Longitude and latitude), elevation and data/site type, which are shown in the table. 
											By selecting a location on the map, the information on this site will be highlighted in the table and by clicking on one of the rows in the table, 
											you will be send to the dataset on the Neotoma database.
										</p>
										<p>
											The <b>Algemene Hoogtebestand Nederland (AHN)</b> contains detailed data on elevation across the whole of the Netherlands. 
											This dataset consists of elevation data for each square meter of the country. 
											The AHN-3 is shown in this tool, that version of the AHN is obtained between 2014 and 2019. 
											More information on this dataset can be found on <a href="https://www.ahn.nl/">https://www.ahn.nl/</a>.
										</p>
										<p>
											The <b>Geomorphological map</b> is a unique map only available for the Netherlands. 
											This layer consists of information on so-called landforms; a combination of different geological factors. 
											More information on this dataset can be found on op <a href="https://www.pdok.nl/-/geomorfologische-kaart-nederland-beschikbaar-bij-pdok">PDOK</a>.
										</p>
										<p>
											The <b>Soil map of the Netherlands</b> is based on core profiles collected across the Netherlands at a depth of 0 - 1.50 m. 
											The dataset contains information on the various soil types occurring in the Netherlands. 
											More information can be found on <a href="https://www.pdok.nl/-/de-bodemkaart-van-nederland-beschikbaar-bij-pdok">PDOK</a>.
										</p>
									</div>
								</div>
							</div>
							<br>
							<div class="card">
								<div class="card-header" id="headingThree-english">
									<h5 class="mb-0">
										<button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseThree-english" aria-expanded="false" aria-control="collapseThree-english">
											Legend
										</button>
									</h5>
								</div>
								<div id="collapseThree-english" class="collapse" aria-labbeledby="headingThree-english" data-parent="#accordion-english">
									<div class="card-body">
										<p>
											For each of the following layers, a legend is available: AHN, geomorphological map and soil map. 
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="infoModalCenteredScrollable">Dismiss</button>
			</div>
		</div>
	</div>
</div>

<script>
	const welcomeModal = document.getElementById("welcomeModalCenteredScrollable");
	const infoModal = document.getElementById("infoModalCenteredScrollable");

	var welcomeModalClose = document.querySelectorAll(\'[data-bs-dismiss="welcomeModalCenteredScrollable"]\');
		welcomeModalClose.forEach(button => {
		button.addEventListener("click", function () {
			welcomeModal.classList.remove("show");
			welcomeModal.style.display = "none";
		});
	})

	var infoModalClose = document.querySelectorAll(\'[data-bs-dismiss="infoModalCenteredScrollable"]\');
		infoModalClose.forEach(button => {
		button.addEventListener("click", function () {
			infoModal.classList.remove("show");
			infoModal.style.display = "none";
		});
})

</script>
';

// ------------------------------------------------

return $modal;

// ------------------------------------------------

?>