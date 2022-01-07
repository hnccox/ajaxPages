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
e107::css(url, 'https://wikiwfs.geo.uu.nl/e107_plugins/ajaxModules/Components/Table/ajaxTables.css');
e107::css(url, 'https://wikiwfs.geo.uu.nl/e107_plugins/ajaxModules/Components/Template/ajaxTemplates.css');

// --- [ HEADER ] ---------------------------------
require_once(HEADERF);

// --- [ JAVASCRIPT ] -----------------------------
$script = '
<script src="./index.js" type="module" defer>
</script>
';

// --- [ MAP ] ------------------------------------
$map = include('index.Map.php');
// --- [ TEMPLATE ] -------------------------------
$template = include('index.Template.php');
// --- [ TABLE ] ----------------------------------
$table = include('index.Table.php');

$page = '
<br>
<div class="row">
	<div class="col-md-4">
        <div class="square">
            '.$map.'
        </div>
        <div class="row" style="font-size:11px; background:rgba(255, 255, 255, 0.7);">
        </div>
';

// ------------------------------------------------
// SLAVE TABLE
// Need to be bound to a layer
// sqlParams['table'] must match at least one of the data-table of the maplayers
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$sqlParams['db'] = "llg";
$sqlParams['table'] = "llg_nl_boreholeheader";
$sqlParams['columns'] = "borehole,xco,yco,drilldepth";
$sqlParams['inner_join'] = null;
$sqlParams['where'] = null;
$sqlParams['order_by'] = null;
$sqlParams['direction'] = null;
$sqlParams['offset'] = null;
$sqlParams['limit'] = null;
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
                <div class="table-scrollable" style="overflow-y: auto; max-height: 400px;">
                    <table style="font-size:12px;" class="table table-hover table-ajax hidden-xs" 
                        data-ajax="table" 
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
                        data-page="'.$sqlParams['offset'].'" 
                        data-limit="'.$sqlParams['limit'].'" 
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
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$sqlParams['db'] = "llg";
$sqlParams['table'] = "llg_nl_boreholeheader";
$sqlParams['columns'] = "borehole,name,drilldate,xco,yco,coordzone,elevation,drilldepth,geom,geol,soil,veget,groundwaterstep,extraremarks";
$sqlParams['where'] = "borehole=''";
$sqlParams['order_by'] = "";
$sqlParams['direction'] = "";
$sqlParams['offset'] = null;
$sqlParams['limit'] = null;

// ------------------------------------------------
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/ajaxDBQuery.php";
$sqlParams['db'] = "llg";
$sqlParams['table'] = "llg_it_boreholedata";
$sqlParams['columns'] = "startdepth,depth,texture,organicmatter,plantremains,color,oxired,gravelcontent,median,calcium,ferro,groundwater,sample,soillayer,stratigraphy,remarks";
$sqlParams['where'] = "borehole=''";
$sqlParams['order_by'] = "startdepth";
$sqlParams['direction'] = "ASC";
$sqlParams['offset'] = null;
$sqlParams['limit'] = null;

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
        <div class="table-scrollable" style="overflow-y: auto; overflow-x: hidden; height: 470px;">
            <table style="font-size:12px;" class="table table-hover table-ajax" 
                data-ajax="table" 
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
                data-page="'.$sqlParams['offset'].'" 
                data-limit="'.$sqlParams['limit'].'" 
                data-columnnames="'.$tableParams['columnNames'].'" 
                data-columnsortable="'.$tableParams['columnSortable'].'"
                data-preview="'.$tableParams['preview'].'" 
                data-href="'.$tableParams['href'].'" 
                data-events="'.$tableParams['events'].'"
                data-add="'.$tableParams['add'].'" '.$aria_expanded.'>
            </table>
        </div>';

// ------------------------------------------------
$page .= '<div id="templateContainer">'.$template.'</div>'.$table;
$page .= '
	</div>
</div>
';

// --- [ RENDER ] ---------------------------------
$caption = '';
$text = $script.$page;
$mode = '';
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------

require_once(FOOTERF);
exit;

?>