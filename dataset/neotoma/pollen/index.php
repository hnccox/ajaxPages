<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

// --- [ API ] ------------------------------------
$url = "//api.neotomadb.org/v2.0/data/geopoliticalunits/3180/sites?limit=500&offset=0";
$db = null;
$table = null;
$columns = "siteid,sitename,longitude,latitude";
$where_0_identifier = null;
$where_0_value = null;
$order_by_0_identifier = null;
$order_by_0_direction = null;
$limit = $_GET['limit'] ?? "500";
$offset = $_GET['offset'] ?? 0;
$page = $_GET['page'] ?? 1;
$offset = $_GET['offset'] ?? (($page - 1) * $_GET['limit']);
$query = '{}';

// --- [ JSON ] -----------------------------------
if($_GET['format'] === 'json') {

    header('Content-Type: application/json');

    $_GET['db'] = json_encode($db);
    $_GET['query'] = $query;
    
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/server/API.php");
    exit;
}

// --- [ HEADER ] ---------------------------------
require_once(HEADERF);

// --- [ JAVASCRIPT ] -----------------------------
$script = '
<script src="./index.js" type="module">
</script>
';
// --- [ TABLE ] ----------------------------------
$table = include('index.Table.php');

// --- [ RENDER ] ---------------------------------
$caption = '';
$text = '<div class="row justify-content-md-center">
            <div class="col-md-10 col-md-offset-1">
                '.$table.'
            </div>
        </div>';
$mode = 'Neotoma';
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text.$script, $mode, $return);

// ------------------------------------------------

require_once(FOOTERF);

?>