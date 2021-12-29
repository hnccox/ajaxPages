<?php

// ------------------------------------------------

$modal = '
<!-- Button trigger modal -->
<!--
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>
-->

<!-- Vertically centered scrollable modal -->

<div class="modal fade show" id="exampleModalCenteredScrollable" tabindex="-1" aria-labelledby="exampleModalCenteredScrollableTitle" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Dutch Pollen Explorer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="exampleModalCenteredScrollable" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <b>Welcome at the Dutch pollen explorer.</b>
        <p>
            Here, you can view all available pollen data across the Netherlands. 
            Click on the "?" for more information on the pollen viewer and on <img src="../images/legend.png"> to show the legends of the layers.
        </p>
        
        <b>About the viewer</b>
        <p>
            This tool displays the location of palaeoecological data in relation to national map resources and other national datasets. 
            For other types of searches including age restrictions please query the data using the <a href="https://neotomadb.org/">Neotoma Explorer</a>.
        </p>
        
        <b>Functions</b>
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
            Specific datasets or sites can be searched by typing in the name of the location in the search bar at the bottom right of the map.
        </p>
        <p>
            Data around your location can be found by activating the geolocation function. 
            This function can be activated by clicking on … (fill in symbol of geolocation), a square will then be shown on the map around your location. 
            This square can then be deleted by clicking on the … (fill in symbol of bin) on the left side of the map. 
            (This function might not work in Firefox, use a different browser if problems occur!)
        </p>

        <b>Layers</b>
        <p>
            All pollen datasets contain a dataset identifier (handle), SiteID, SiteName, coordinates (Longitude and latitude), 
            elevation and data/site type, which are shown in the table. 
            By selecting a location on the map, the information on this site will be highlighted in the table and by clicking on one of the rows in the table, 
            you will be send to the dataset on the Neotoma database.
        </p>
        <p>
            The Algemene Hoogtebestand Nederland (AHN) contains detailed data on elevation across the whole of the Netherlands. 
            This dataset consists of elevation data for each square meter of the country. 
            The AHN-3 is shown in this tool, that version of the AHN is obtained between 2014 and 2019. 
            More information on this dataset can be found on https://www.ahn.nl/.
        </p>
        <p>
            The Geomorphological map is a unique map only available for the Netherlands. 
            This layer consists of information on so-called landforms; a combination of different geological factors. 
            More information on this dataset can be found on op https://www.pdok.nl/-/geomorfologische-kaart-nederland-beschikbaar-bij-pdok.
        </p>
        <p>
            The Soil map of the Netherlands is based on core profiles collected across the Netherlands at a depth of 0 - 1.50 m. 
            The dataset contains information on the various soil types occurring in the Netherlands. 
            More information can be found on https://www.pdok.nl/-/de-bodemkaart-van-nederland-beschikbaar-bij-pdok.
        </p>
        <p>… (add information on other layers)</p>
                
        <b>Legends</b>
        <p>For each of the following layers, a legend is available:</p>

        <ul>
            <li>AHN</li>
            <li>geomorphological map</li>
            <li>soil map</li>
        </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="exampleModalCenteredScrollable">Dismiss</button>
      </div>
    </div>
  </div>
</div>

<!--
<div class="modal" id="exampleModalCenteredScrollable2" tabindex="-1" aria-labelledby="exampleModalCenteredScrollableTitle2" style="display: block;" aria-modal="true" role="dialog">
</div>
-->

<script>
    const container = document.getElementById("exampleModalCenteredScrollable");

    var modalClose = document.querySelectorAll(\'[data-bs-dismiss="exampleModalCenteredScrollable"]\');
        modalClose.forEach(button => {
        button.addEventListener("click", function () {
            container.classList.remove("show");
            container.style.display = "none";
        });
    })
</script>
';

// ------------------------------------------------

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    echo $modal;
} else {
    return $modal;
}

// ------------------------------------------------

?>