<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- [ SQL ] ------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "llg";
$table = "llg_nl_geom";
$columns = "llg_nl_geom.borehole,llg_it_geom.longitude,llg_it_geom.latitude,llg_it_geom.xy,llg_it_geom.geom,xco,yco,drilldepth";
$inner_join_0_identifier = "llg_nl_boreholeheader ON llg_nl_geom.borehole = llg_nl_boreholeheader.borehole";
$where_0_identifier = "llg_nl_geom.longitude BETWEEN :xmin AND :xmax AND llg_nl_geom.latitude BETWEEN :ymin AND :ymax";
$where_0_value = $_GET[$where_0_identifier];
$order_by_0_identifier = "llg_nl_geom.geom <-> SRID=4326;POINT(:lng :lat)::geometry, llg_nl_geom.borehole";
$order_by_0_direction = "DESC";
// $limit = $_GET['limit'] ?? 20;
// $offset = $_GET['offset'] ?? 0;
// $page = $_GET['page'] ?? 1;
// $offset = $_GET['offset'] ?? (($page - 1) * $_GET['limit']);
$mapquery = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "inner_join": { "table": "llg_nl_boreholeheader", "as": "", "on": "" } }, "2": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "value": "'.$where_0_value.'" } } }, "3": { "order_by": { "0": { "identifier": "'.$order_by_0_identifier.'", "direction": "'.$order_by_0_direction.'" } } } }';

// --- [ JSON ] -----------------------------------
if($_GET['format'] === 'json') {
    
    $included = true;

    header('Content-Type: application/json');
    
    $_GET['db'] = json_encode($db);
    $_GET['query'] = $mapquery;
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/beta/API.php");
    $jsonArray[] = $query->response;

    echo json_encode($jsonArray, true);
    exit;
}

// ------------------------------------------------

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

// --- [ JS ] -------------------------------------
$script = '
<script src="./index.js" type="module" defer>
</script>

<script src="/e107_plugins/proj4js-2.7.2/dist/proj4.js">
</script>
';
// ------------------------------------------------
$page = '

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
        </div>

'; 
// ------------------------------------------------
$text = $script.$page;
// ------------------------------------------------
$mode = "ajaxMap";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------

require_once(FOOTERF);

?>