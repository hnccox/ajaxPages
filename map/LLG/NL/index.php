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

e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.2/proj4.js');

// --- [ SQL ] ------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
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
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/beta/API.php");
    $jsonArray[] = $query->response;

    echo json_encode($jsonArray, true);
    exit;
}
// --- [ JS ] -------------------------------------
$script = '
<script src="./index.js" type="module" defer>
</script>

<script src="/e107_plugins/proj4js-2.7.2/dist/proj4.js">
</script>
';
// ------------------------------------------------

require_once(HEADERF);

// ------------------------------------------------

$page = '
<br>
<div class="row">
	<div class="col-md-4">
        <div class="square">
            <div class="leaflet map content"
                data-type="parent"
                data-ajax="map"
                data-url=\''.$url.'\'
                data-db=\''.$db.'\'
                data-table=\''.$table.'\'
                data-columns=\''.$columns.'\'
                data-query=\''.$mapquery.'\'
                data-options=\'{ "lat": 52.05, "lng": 5.45, "zoom": 7 }\'
                data-lat="52.05"
                data-lng="5.45"
                data-zoom="7"
                data-overlaymaps=\'{ "Boreholes": "boreholes" }\'
                data-limit="1000"
                data-offset=""
                data-zoomlevel="12">
            </div>
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

// ------------------------------------------------        
$page .= $table;

$page .='
	</div>
	<div class="col-md-8">';
// ------------------------------------------------
// DETAILS TEMPLATE
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$sqlParams['db'] = "llg";
$sqlParams['table'] = "llg_nl_boreholeheader";
$sqlParams['columns'] = "borehole,name,drilldate,xco,yco,coordzone,elevation,drilldepth,geom,geol,soil,veget,groundwaterstep,extraremarks";
$sqlParams['inner_join'] = "";
$sqlParams['where'] = "borehole=':uid'";
$sqlParams['order_by'] = "";
$sqlParams['direction'] = "";
$sqlParams['limit'] = null;
$sqlParams['offset'] = null;

// ------------------------------------------------
$template = '<div data-ajax="template"
				data-slave="1"
				data-master="Maps[0]"
				data-url="'.$sqlParams['url'].'" 
				data-db="'.$sqlParams['db'].'" 
				data-table="'.$sqlParams['table'].'" 
				data-columns="'.$sqlParams['columns'].'" 
                data-inner_join="'.$sqlParams['inner_join'].'" 
				data-where="'.$sqlParams['where'].'" 
				data-order_by="'.$sqlParams['order_by'].'" 
				data-direction="'.$sqlParams['direction'].'" 
				data-limit="'.$sqlParams['limit'].'"
                data-offset="'.$sqlParams['offset'].'">
                <div class="panel panel-default">
                    <div class="panel-heading" style="color:rgb(0,0,0);background-color:rgb(255,205,0);">
                            <strong>
                                <span>Borehole: </span>
                                <span data-variable="borehole" contenteditable="false" style="cursor: pointer;" onclick="boreholeURL(event)">borehole</span>
                            </strong>
                        <span class="pull-right">
                            <span>
                                <strong>Logged by: </strong>
                            </span>
                            <span data-variable="name" contenteditable="false">name</span>
                            <span>
                                <strong> on </strong>
                            </span>
                            <span data-variable="drilldate" contenteditable="false">drilldate</span>
                        </span>
                    </div>
                    <div class="panel-body">
                        <!--
                        <div class="row">
                            <div class="col-md-4 table-responsive" style="padding-top:14px">
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <td style="border:none">Name</td>
                                            <td style="border:none;font-weight: bold"><span data-variable="name" contenteditable="false">name</span></td>
                                            <td style="border:none">Date</td>
                                            <td style="border:none;font-weight: bold"><input type="date" data-variable="drilldate" value="" disabled></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        -->
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Coordinates</strong>
                                <div class="table-responsive">
                                    <table class="table table-condensed mb-0">
                                        <tbody>
                                            <tr>
                                                <td style="border:none">UTM Zone</td>
                                                <td style="border:none;font-weight: bold">
                                                    <input list="coordzones" name="coordzone" data-variable="coordzone" value="coordzone" disabled>
                                                    <datalist id="coordzones">
                                                        <option value="Internet Explorer">
                                                        <option value="Firefox">
                                                        <option value="Chrome">
                                                        <option value="Opera">
                                                        <option value="Safari">
                                                    </datalist>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td style="border:none">X</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="xco" value="xco" disabled></td>
                                                <td style="border:none">Y</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="yco" value="yco" disabled></td>
                                            </tr>
                                            <tr>
                                                <td style="border:none">Elevation (m)</td>
                                               <td style="border:none;font-weight: bold"><input type="text" data-variable="elevation" value="elevation" disabled></td>
                                                <td style="border:none">Depth (cm)</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="drilldepth" value="drilldepth" disabled></td>
                                            </tr>                                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <strong>Classification</strong>
                                <div class="table-responsive">
                                    <table class="table table-condensed mb-0">
                                        <tbody>
                                            <tr>
                                                <td style="border:none">Geom</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="geom" value="geom" disabled></td>
                                                <td style="border:none">Geol</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="geol" value="geol" disabled></td>
                                            </tr>
                                            <tr>
                                                <td style="border:none">Soil</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="soil" value="soil" disabled></td>
                                                <td style="border:none">Veget</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="veget" value="veget" disabled></td>
                                            </tr>
                                            <tr>
                                                <td style="border:none">GWT</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="groundwaterstep" value="groundwaterstep" disabled></td>                                               
                                            </tr>                                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <textarea style="width:100%" data-variable="extraremarks" disabled>extraremarks</textarea>
                    </div>
                </div>
                <!--
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text"></p>
                    </div>
                </div>
                -->
                
                <!--
                <span data-variable="xco" contenteditable="false">xco</span>
                <span data-variable="yco" contenteditable="false">yco</span>
                <span data-variable="coordzone" contenteditable="false">coordzone</span>
                <span data-variable="elevation" contenteditable="false">elevation</span>
                <span data-variable="drilldepth" contenteditable="false">drilldepth</span>
                <span data-variable="geom" contenteditable="false">geom</span>
                <span data-variable="geol" contenteditable="false">geol</span>
                <span data-variable="soil" contenteditable="false">soil</span>
                <span data-variable="veget" contenteditable="false">veget</span>
                <span data-variable="groundwaterstep" contenteditable="false">groundwaterstep</span>
                <span data-variable="extraremarks" contenteditable="false">extraremarks</span>
                -->
            </div>';

// ------------------------------------------------
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/ajaxDBQuery.php";
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
$page .= $template.$table;
$page .= '
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