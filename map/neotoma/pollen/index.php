<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxMaps.css');
e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxTables.css');
e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxTemplates.css');

e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css');
e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/MarkerCluster.css');
//e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/MarkerCluster.Default.css');
e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css');
e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js');
e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/leaflet.markercluster.js');
e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.heat/0.2.0/leaflet-heat.js');
e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js');
//e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.2/proj4.js');

require_once(HEADERF);

// ------------------------------------------------
$script = '
<script src="./index.js" type="module" defer>
</script>

<script src="/e107_plugins/proj4js-2.7.2/dist/proj4.js">
</script>
';
// ------------------------------------------------
$map = '
<div class="fullscreen">
    <div class="leaflet map content"
        data-ajax="map"
        data-master="true"
        data-lat="45.58398"
        data-lng="12.829406"
        data-zoom="8"
        data-url="//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/ajaxDBQuery.php"
        data-db="llg"
        data-table="llg_it_geom"
        data-columns="llg_it_geom.borehole,llg_it_geom.longitude,llg_it_geom.latitude,llg_it_geom.xy,llg_it_geom.geom,xco,yco,drilldepth"
        data-inner_join="llg_it_boreholeheader ON llg_it_geom.borehole = llg_it_boreholeheader.borehole"
        data-where="llg_it_geom.longitude BETWEEN :xmin AND :xmax AND llg_it_geom.latitude BETWEEN :ymin AND :ymax"
        data-order_by="llg_it_geom.geom <-> \'SRID=4326;POINT(:lng :lat)\'::geometry, llg_it_geom.borehole"
        data-direction=""
        data-overlaymaps=\'{"Boreholes": "boreholes"}\'
        data-limit="1000"
        data-offset=""
        data-zoomlevel="12">
    </div>
</div>
';

// ------------------------------------------------
$page = '<br>'.$map;
$text = $script.$page;
// ------------------------------------------------
$mode = "Map";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------

//require_once(FOOTERF);

?>