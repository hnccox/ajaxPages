<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

e107::css(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
e107::js(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js');

// --- [ API ] ------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$db = "llg";
$table = "llg_nl_boreholeheader";
$columns = "borehole,name,drilldate,xco,yco,coordzone,elevation,drilldepth,geom,geol,soil,veget,groundwaterstep,extraremarks";
$where_0_identifier = "borehole";
$where_0_value = $_GET[$where_0_identifier];
$order_by_0_identifier = "borehole";
$order_by_0_direction = "DESC";
// $limit = $_GET['limit'] ?? 20;
// $offset = $_GET['offset'] ?? 0;
// $page = $_GET['page'] ?? 1;
// $offset = $_GET['offset'] ?? (($page - 1) * $_GET['limit']);
$templatequery = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "value": "'.$where_0_value.'" } } }, "2": { "order_by": { "0": { "identifier": "'.$order_by_0_identifier.'", "direction": "'.$order_by_0_direction.'" } } } }';
// ------------------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
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
$tablequery = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "value": "'.$where_0_value.'" } } }, "2": { "order_by": { "0": { "identifier": "'.$order_by_0_identifier.'", "direction": "'.$order_by_0_direction.'" } } } }';

// --- [ JSON ] -----------------------------------
if($_GET['format'] === 'json') {
    
    $included = true;

    header('Content-Type: application/json');
    
    $_GET['db'] = json_encode($db);
    $_GET['query'] = $templatequery;
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/server/API.php");
    $jsonArray[] = $query->response;
    
    $_GET['db'] = json_encode($db);
    $_GET['query'] = $tablequery;
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/server/API.php");
    $jsonArray[] = $query->response;

    echo json_encode($jsonArray, true);
    exit;
}

// --- [ HEADER ] ---------------------------------
require_once(HEADERF);

// ------------------------------------------------

if(!$_GET['borehole']) {

    $caption = "Something went wrong";
    $text = "Click <a href='index.php'>here</a> to return to the index";

    $mode = "LLGboreholedata";
    $return = false;
    $ns = e107::getRender();
    $ns->tablerender($caption, $text, $mode, $return);

    require_once(FOOTERF);
    exit;
}

// ------------------------------------------------
if($_GET['action'] === 'edit') {
    // ToDo: Check if there is a release candidate...
    $edit = false;
    if (USER) {
        $userData = e107::user(USERID); // Example - currently logged in user.
        $userclassList = explode(",", $userData["user_class"]);
        $userclassID = 4;  // id from 'Wiki Editors' userclass
        if(!in_array($userclassID, $userclassList)) {
            $ns->tablerender("Error!", "You must be part of the 'Wiki Editor' userclass to edit this page");
            require_once(FOOTERF);
            exit;
        } else {
            $edit = true;
        }
    } else {
        $ns->tablerender("Error!", "You must login to edit this page");
        require_once(FOOTERF);
        exit;
    }
}

// --- [ JAVASCRIPT ] -----------------------------
$script = '
<script src="./borehole.js" type="module">
</script>
';
// --- [ TEMPLATE ] -------------------------------
$template = include('borehole.Template.php');
// --- [ TABLE ] ----------------------------------
$table = include('borehole.Table.php');

// --- [ RENDER ] ---------------------------------
$caption = '<h1>LLG Boreholedata</h1>';
$text = '<div id="borehole">'.$script.$template.$table.'</div>';
$mode = 'LLGboreholedate';
$return = false;
$ns = e107::getRender();
$ns->tablerender('', $text, $mode, $return);
// ------------------------------------------------
require_once(FOOTERF);
exit;
// ------------------------------------------------

?>