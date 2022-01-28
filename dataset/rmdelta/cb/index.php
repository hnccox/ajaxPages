<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

// --- [ API ] ------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$db = "rmdelta";
$table = "cb_cat";
$columns = "id,name,abegin14cbp,aend14cbp,abegincalbp,aendcalbp,existence,riversystemgrp";
$where_0_identifier = "systemgrp";
//$where_0_value = "BETWEEN 10 AND 19";
//$where = "systemgrp BETWEEN 10 AND 19";
$order_by_0_identifier = "id";
$order_by_0_direction = "ASC";
$limit = 20;
$offset = 0;
$query = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "between": { "0": 10, "1": 19 } } } }, "2": { "order_by": { "0" : { "identifier": "'.$order_by_0_identifier.'", "direction": "'.$order_by_0_direction.'" } } }, "3": { "limit": "'.$limit.'" }, "4": { "offset": "'.$offset.'" } }';

// --- [ JSON ] -----------------------------------

// --- [ HEADER ] ---------------------------------
require_once(HEADERF);

// --- [ JAVASCRIPT ] -----------------------------
$script = '
<script src="./index.js" type="module">
</script>
';
// --- [ MENU ] -----------------------------------
$menu = include('index.Menu.php');
// --- [ TABLE ] ----------------------------------
$table = include('index.Table.php');

// --- [ RENDER ] ---------------------------------
$caption = '<h1>CB Catalog</h1>';
$text = '
<div class="container-fluid">
    <div class="row justify-content-md-center"">
        <div class="col-md-3 offset-md-1">
            <br>
            <br>
            <br>
            '.$menu.'
        </div>
        <div class="col-md-7">
            '.$table.'
        </div>
    </div>
</div>';
$mode = 'CBcatalog';
$return = false;
$ns = e107::getRender();
$ns->tablerender('', $text.$script, $mode, $return);
// ------------------------------------------------
require_once(FOOTERF);
exit;
// ------------------------------------------------

?>
