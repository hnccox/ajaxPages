<?php

// ------------------------------------------------
// TABLE
// ------------------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "llg";
$table = "llg_nl_boreholedata";
$columns = "startdepth,depth,texture,organicmatter,plantremains,color,oxired,gravelcontent,median,calcium,ferro,groundwater,sample,soillayer,stratigraphy,remarks";
$where_0_identifier = "borehole";
$where_0_value = $_GET[$where_0_identifier];
$order_by_0_identifier = "startdepth";
$order_by_0_direction = "ASC";
// $limit = $_GET['limit'] ?? null;
// $offset = $_GET['offset'] ?? null;
// $page = $_GET['page'] ?? 1;
// $offset = $_GET['offset'] ?? (($page - 1) * $_GET['limit']);
$tablequery = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "llg_nl_boreholedata" } } }, "1": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "value": "'.$where_0_value.'" } } }, "2": { "order_by": { "0": { "identifier": "'.$order_by_0_identifier.'", "direction": "'.$order_by_0_direction.'" } } } }';

// ------------------------------------------------
$tableParams = [];
$tableParams['slave'] = true;
$tableParams['master'] = "ajaxTemplates[0]";
$tableParams['columnNames'] = "Top,Depth,Texture,Org,Plr,Color,RedOx,Gravel,M50,Ca,Fe,GW,Sample,Paleosoil,Strat,Remarks";
$tableParams['columnSortable'] = false;
$tableParams['preview'] = false;
$tableParams['expanded'] = true;
$tableParams['href'] = false;
$tableParams['add'] = false;

$table = '
        <div class="table-scrollable" style="overflow-y: auto; overflow-x: hidden; height: 470px;">
            <table style="font-size:12px;" class="table table-hover table-ajax"
                data-ajax="table"
                data-type="relational"
                data-url=\''.$url.'\'
                data-db=\''.$db.'\'
                data-table=\''.$table.'\'
                data-columns=\''.$columns.'\'
                data-query=\''.$tablequery.'\'
                data-columnnames="'.$tableParams['columnNames'].'" 
                data-columnsortable="'.$tableParams['columnSortable'].'"
                data-preview="'.$tableParams['preview'].'" 
                data-href="'.$tableParams['href'].'" 
                data-add="'.$tableParams['add'].'" '.$aria_expanded.'>
            </table>
        </div>';

return $table;

?>