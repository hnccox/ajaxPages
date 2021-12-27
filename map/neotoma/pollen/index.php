<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css');
e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js');

e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js');
e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css');

e107::css(url, 'https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.css');
e107::js(url, 'https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js');

e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/leaflet.markercluster.js');
e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/MarkerCluster.css');
e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/MarkerCluster.Default.css');

e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.heat/0.2.0/leaflet-heat.js');

e107::js(url, 'https://wikiwfs.geo.uu.nl/e107_web/lib/leaflet/plugins/leaflet.wmslegend/js/leaflet.wmslegend.js');
e107::css(url, 'https://wikiwfs.geo.uu.nl/e107_web/lib/leaflet/plugins/leaflet.wmslegend/css/leaflet.wmslegend.css');
e107::js(url, 'https://wikiwfs.geo.uu.nl/e107_web/lib/leaflet/plugins/leaflet.addlayer/js/leaflet.addlayer.js');

e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.2/proj4.js');

require_once(HEADERF);

// --- [ JS ] -------------------------------------
$script = '
<script src="./index.js" type="module" defer>
</script>
';
// --- [ MODAL ] ----------------------------------
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
        <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="exampleModalCenteredScrollable" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <p>Welcome at the … (fill in name of the application).</p>

        <p>Here, you can view all available pollen data across the Netherlands. Click on the … (fill in symbol of the help-page) for more information on the … ( fill in name of the application).</p>
        
        <b>About …</b>
        
        <p>This tool displays the location of palaeoecological data in relation to national map resources and other national datasets. For other types of searches including age restrictions please query the data using the Neotoma Explorer (https://neotomadb.org/).</p>
        
        <b>Functions</b>
        
        <p>On the right side of the map of the Netherlands, you can decide which layer to display. The following map layers are available: pollen, AHN, …, … . By clicking on the name of the layer, the layer will be added to the map and, when possible, a table with more information will be opened on the bottom of the screen.</p>
        
        <p>All pollen datasets contain a dataset identifier (handle), SiteID, SiteName, coordinates (Longitude and latitude), elevation and data/site type, which are shown in the table. By selecting a location on the map, the information on this site will be highlighted in the table and by clicking on one of the rows in the table, you will be send to the dataset on the Neotoma database.</p>
        
        <p>The Algemene Hoogtebestand Nederland (AHN) contains detailed data on elevation across the whole of the Netherlands. This dataset consists of elevation data for each square meter of the country1. The AHN-3 is shown in this tool, that version of the AHN is obtained between 2014 and 2019. More information on this dataset can be found on https://www.ahn.nl/.</p>
        
        <p>… (add information on other layers)</p>
        
        <p>…</p>
        
        <p>…</p>
        
        <b>Legends</b>
        
        <p>For each of the following layers, a legend is available: AHN, …, … .</p>

        <ul>
            <li>Enter legend of maps here (in English)</li>
        </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="exampleModalCenteredScrollable">I understand</button>
      </div>
    </div>
  </div>
</div>
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

// --- [ MAP ] ------------------------------------
$map = '
<div class="fullscreen">
    <div class="leaflet map content"
        data-type="parent"
        data-ajax="map"
        data-lat="52.0907"
        data-lng="5.1214"
        data-zoom="7"
        data-min-zoom="7"
        data-max-zoom="12"
        data-zoomlevel="13"
        data-limit="500">
    </div>
    <div class="d-none d-md-block"></div>
</div>
';

// --- [ RENDER ] ---------------------------------
$caption = '';
$text = $script.$modal.$map;
$mode = "ajaxMap";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------
require_once(FOOTERF);
exit;
// ------------------------------------------------

?>