<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

// --- [ API ] ------------------------------------
$url = "//pollen.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";

// --- [ JSON ] -----------------------------------
if($_GET['format'] === 'json') {

    $_GET['db'] = json_encode($db);
    $_GET['query'] = $query;
    
    header('Content-Type: application/json');
    require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/server/API.php");
    exit;
}

// --- [ HEADER ] ---------------------------------
require_once(HEADERF);

if(!$_GET['siteid']) {

    $caption = "Something went wrong";
    $text = "Click <a href='index.php'>here</a> to return to the index";

    $mode = 'siteid';
    $return = false;
    $ns = e107::getRender();
    $ns->tablerender($caption, $text, $mode, $return);

    require_once(FOOTERF);
    exit;
}

// --- [ JAVASCRIPT ] -----------------------------
$script .= '
<script src="./siteid.js" type="module">
</script>
';
// --- [ TEMPLATE ] -------------------------------
$template = include('siteid.Template.php');

// --- [ RENDER ] ---------------------------------
$caption = '<h1>Dutch Pollendata</h1>';
$text = '<div id="siteid">'.$script.$template.'</div>';
$mode = 'siteid';
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------
require_once(FOOTERF);
exit;
// ------------------------------------------------

?>