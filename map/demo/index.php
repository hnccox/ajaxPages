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

e107::js(url, 'https://wikiwfs.geo.uu.nl/e107_web/lib/leaflet/plugins/leaflet.addlayer/js/leaflet.addlayer.js');
e107::js(url, 'https://wikiwfs.geo.uu.nl/e107_web/lib/leaflet/plugins/leaflet.wmslegend/js/leaflet.wmslegend.js');
e107::css(url, 'https://wikiwfs.geo.uu.nl/e107_web/lib/leaflet/plugins/leaflet.wmslegend/css/leaflet.wmslegend.css');

e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.2/proj4.js');

e107::css(url, 'https://wikiwfs.geo.uu.nl/e107_plugins/ajaxModules/Components/Map/ajaxMaps.css');

// --- [ HEADER ] ---------------------------------
require_once(HEADERF);

// --- [ JAVASCRIPT ] -----------------------------
$script = '
<script src="./index.js" type="module" defer>
</script>
';

// --- [ MAP ] ------------------------------------
$map = include('index.Map.php');

// --- [ RENDER ] ---------------------------------
$caption = '';
$text = $script.'<div class="fullscreen">'.$map.'</div>';
$mode = "ajaxMap";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------
require_once(FOOTERF);
exit;
// ------------------------------------------------

?>