<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

//e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxMenu.css');
e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxTemplates.css');

// --- [ SQL ] ------------------------------------
// ------------------------------------------------

// --- [ JSON ] -----------------------------------
// ------------------------------------------------
if($_GET['format'] === 'json') {

    $_GET['db'] = json_encode($db);
    $_GET['query'] = $query;
    
    header('Content-Type: application/json');
    require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/beta/API.php");
    exit;
}

// --- [ JAVASCRIPT ] -----------------------------
// ------------------------------------------------
$script .= '
<script src="./labidnr.js" type="module">
</script>
';

// --- [ TEMPLATE ] -------------------------------
// ------------------------------------------------
require_once(HEADERF);


// --- [ RENDER ] ---------------------------------
// ------------------------------------------------
$caption = '';
$text = $script.$template;
$mode = 'C14labidnr';
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------
require_once(FOOTERF);
exit;
// ------------------------------------------------

?>