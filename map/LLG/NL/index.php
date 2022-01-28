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

// --- [ API ] ------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$db = "llg";
$table = "llg_nl_geom";
$columns = "llg_nl_geom.borehole,llg_nl_geom.longitude,llg_nl_geom.latitude,llg_nl_geom.xy,llg_nl_geom.geom,xco,yco,drilldepth";
$inner_join_0_identifier = "llg_nl_boreholeheader ON llg_nl_geom.borehole = llg_nl_boreholeheader.borehole";
$where_0_identifier = "llg_nl_geom.longitude BETWEEN :xmin AND :xmax AND llg_nl_geom.latitude BETWEEN :ymin AND :ymax";
$where_0_value = $_GET[$where_0_identifier];
$order_by_0_identifier = "llg_nl_geom.geom <-> SRID=4326;POINT(:lng :lat)::geometry, llg_nl_geom.borehole";
$order_by_0_direction = "DESC";
// $limit = $_GET['limit'] ?? 20;
// $offset = $_GET['offset'] ?? 0;
// $page = $_GET['page'] ?? 1;
// $offset = $_GET['offset'] ?? (($page - 1) * $_GET['limit']);
$mapquery = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "inner_join": { "identifier" } }, "1": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "value": "'.$where_0_value.'" } } }, "2": { "order_by": { "0": { "identifier": "'.$order_by_0_identifier.'", "direction": "'.$order_by_0_direction.'" } } } } }';

// --- [ JSON ] -----------------------------------
if($_GET['format'] === 'json') {
	
	$included = true;

	header('Content-Type: application/json');
	
	$_GET['db'] = json_encode($db);
	$_GET['query'] = $mapquery;
	require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/server/API.php");
	$jsonArray[] = $query->response;

	echo json_encode($jsonArray, true);
	exit;
}

// --- [ HEADER ] ---------------------------------
require_once(HEADERF);

// --- [ JAVASCRIPT ] -----------------------------
$script = '
<script src="./index.js" type="module">
</script>
';

// --- [ MAP ] ------------------------------------
$map = include('index.Map.php');
// --- [ TEMPLATE ] -------------------------------
$template = include('index.Template.php');
// --- [ TEMPLATETABLE ] --------------------------
$table = include('index.templateTable.php');
// --- [ RENDER ] ---------------------------------
$page = '
<div class="container-fluid" style="position: relative;">
	<div class="row">
		<div class="col-md-4">
			<div class="square" style="height: calc(100vh - 56px);">
				'.$map.'
				<nav style="display:none;"><ul class="nav nav-tabs" id="nav-tab"></ul></nav>
				<div class="tab-content bg-white" id="nav-tabContent"></div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="container-ajaxTemplate" style="height: calc(100vh - 56px);">
				'.$template.$table.'
			</div>
		</div>
	</div>
</div>';
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