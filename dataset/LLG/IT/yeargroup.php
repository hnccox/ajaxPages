<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

// --- [ API ] ------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$db = "llg";
$table = "llg_it_boreholeheader";
$columns = "borehole,name,drilldate,xco,yco";
$where_0_identifier = "yeargroup";
$where_0_value = $_GET[$where_0_identifier];
$order_by_0_identifier = "borehole";
$order_by_0_direction = "ASC";
$limit = 100;
$offset = 0;
$query = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "value": "'.$where_0_value.'" }, "1": { "identifier": "active", "value": "true" } } }, "2": { "order_by": { "0": { "identifier": "'.$order_by_0_identifier.'", "direction": "'.$order_by_0_direction.'" } } }, "3": { "limit": "'.$limit.'" }, "4": { "offset": "'.$offset.'" } }';

// --- [ JSON ] -----------------------------------
if($_GET['format'] === 'json') {

    $_GET['db'] = json_encode($db);
    $_GET['query'] = $query;
    
    header('Content-Type: application/json');
    require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/server/API.php");
    exit;
}

// ------------------------------------------------

require_once(HEADERF);

// ------------------------------------------------
$script = '
<script src="./yeargroup.js" type="module">
</script>
';
// ------------------------------------------------
$table = include('yeargroup.Table.php');
// ------------------------------------------------
$caption = "";
$text = '<div class="row justify-content-md-center">
            <!-- <p>Click <a href="index.php">here</a> to return to index</p> -->
            <div class="col-md-10 col-md-offset-1">
                '.$table.'
            </div>
        </div>';
// ------------------------------------------------
$mode = "LLG";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text.$script, $mode, $return);

// ------------------------------------------------

require_once(FOOTERF);

?>