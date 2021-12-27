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

// --- [ RENDER ] ---------------------------------
$page = '
<div class="container-fluid">
<div class="row">
	<div class="col-md-4">
        <div class="square">
        '.$map.'
        <div class="tab-content bg-white" id="nav-tabContent"></div>
        </div>
';

// ------------------------------------------------
// SLAVE TABLE
// Need to be bound to a layer
// sqlParams['table'] must match at least one of the data-table of the maplayers
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$sqlParams['db'] = "llg";
$sqlParams['table'] = "llg_nl_boreholeheader";
$sqlParams['columns'] = "borehole,xco,yco,drilldepth";
$sqlParams['inner_join'] = null;
$sqlParams['where'] = null;
$sqlParams['order_by'] = null;
$sqlParams['direction'] = null;
$sqlParams['limit'] = null;
$sqlParams['offset'] = null;
$tableParams = [];
$tableParams['caption'] = "";
$tableParams['slave'] = true;
$tableParams['master'] = "Maps[0]";
$tableParams['columnNames'] = "borehole,xco,yco,drilldepth";
$tableParams['columnSortable'] = false;
$tableParams['href'] = false;
$tableParams['events'] = "mouseover,mouseout,mousedown,mouseup,click";
$tableParams['preview'] = false;
$tableParams['expanded'] = true;
$tableParams['totalrecords'] = false;
$tableParams['add'] = false;

$table = '
        <div class="row">
            <div class="col-xs-12">
                <div class="table-scrollable" style="overflow-y: auto; max-height: 320px;">
                    <div class="mapinfo" style="height:200px;text-align:center;">
                        <br>
                        <p><strong>Zoom to area of interest to show boreholes</strong></p>
                    </div>
                    <table style="display:none;font-size:12px;" class="table table-hover table-ajax hidden-xs" 
                        data-ajax="table" 
                        data-type="slave"
                        data-slave="'.$tableParams['slave'].'" 
                        data-master="'.$tableParams['master'].'" 
                        data-url="'.$sqlParams['url'].'" 
                        data-db="'.$sqlParams['db'].'" 
                        data-table="'.$sqlParams['table'].'" 
                        data-columns="'.$sqlParams['columns'].'" 
                        data-inner_join="'.$sqlParams['inner_join'].'" 
                        data-where="'.$sqlParams['where'].'" 
                        data-order_by="'.$sqlParams['order_by'].'" 
                        data-direction="'.$sqlParams['direction'].'" 
                        data-limit="'.$sqlParams['limit'].'" 
                        data-offset="'.$sqlParams['offset'].'" 
                        data-columnnames="'.$tableParams['columnNames'].'" 
                        data-columnsortable="'.$tableParams['columnSortable'].'"
                        data-href="'.$tableParams['href'].'"
                        data-events="'.$tableParams['events'].'"
                        data-preview="'.$tableParams['preview'].'" 
                        data-totalrecords="'.$tableParams['totalrecords'].'" 
                        data-add="'.$tableParams['add'].'" '.$aria_expanded.'>
                    </table>
                </div>
            </div>
        </div>';

// --- [ TEMPLATE ] -------------------------------
$template = include('index.Template.php');

$page .='
	</div>
	<div class="col-md-8" id="templateContainer">';
// --- [ TEMPLATE ] -------------------------------
$template = include('index.Template.php');

// ------------------------------------------------
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$sqlParams['db'] = "llg";
$sqlParams['table'] = "llg_nl_boreholedata";
$sqlParams['columns'] = "startdepth,depth,texture,organicmatter,plantremains,color,oxired,gravelcontent,median,calcium,ferro,groundwater,sample,soillayer,stratigraphy,remarks";
$sqlParams['where'] = "borehole=''";
$sqlParams['order_by'] = "startdepth";
$sqlParams['direction'] = "ASC";
$sqlParams['limit'] = null;
$sqlParams['offset'] = null;
$tableParams = [];
$tableParams['slave'] = true;
$tableParams['master'] = "Templates[0]";
$tableParams['columnNames'] = "Top,Depth,Texture,Org,Plr,Color,RedOx,Gravel,M50,Ca,Fe,GW,Sample,Paleosoil,Strat,Remarks";
$tableParams['columnSortable'] = false;
$tableParams['preview'] = false;
$tableParams['expanded'] = true;
$tableParams['href'] = false;
$tableParams['events'] = ["mouseover", "mouseout", "mousedown", "mouseup", "click"];
$rowParams = [];
$rowParams['href'] = false;
$rowParams['mouseover'] = true;
$rowParams['mouseout'] = true;
$rowParams['click'] = true;
$rowParams['add'] = false;
$cellParams = [];

$table = '
        <div class="table-scrollable" style="overflow-y: auto; overflow-x: hidden; height: 408px;">
            <table style="font-size:12px;" class="table table-hover table-ajax" 
                data-ajax="table"
                data-type="relational"
                data-slave="'.$tableParams['slave'].'" 
                data-master="'.$tableParams['master'].'" 
                data-url="'.$sqlParams['url'].'" 
                data-db="'.$sqlParams['db'].'" 
                data-table="'.$sqlParams['table'].'" 
                data-columns="'.$sqlParams['columns'].'" 
                data-inner_join="'.$sqlParams['inner_join'].'" 
                data-where="'.$sqlParams['where'].'" 
                data-order_by="'.$sqlParams['order_by'].'" 
                data-direction="'.$sqlParams['direction'].'" 
                data-limit="'.$sqlParams['limit'].'" 
                data-offset="'.$sqlParams['offset'].'" 
                data-columnnames="'.$tableParams['columnNames'].'" 
                data-columnsortable="'.$tableParams['columnSortable'].'"
                data-preview="'.$tableParams['preview'].'" 
                data-href="'.$tableParams['href'].'" 
                data-events="'.$tableParams['events'].'"
                data-add="'.$tableParams['add'].'" '.$aria_expanded.'>
            </table>
        </div>';

// ------------------------------------------------
//$page .= $template.$table;
$page .= '
	</div>
</div>
</div>
';
$text = $script.$page;
// ------------------------------------------------
$mode = "ajaxMap";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------

require_once(FOOTERF);

?>