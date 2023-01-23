<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

require_once(HEADERF);

// ------------------------------------------------
if(!$_GET['borehole'] && $_GET['action'] !== 'create') {

    $caption = "Something went wrong";
    $text = "Click <a href='index.php'>here</a> to return to the index";

    $mode = "CBid";
    $return = false;
    $ns = e107::getRender();
    $ns->tablerender($caption, $text, $mode, $return);

    require_once(FOOTERF);
    exit;
}

if($_GET['action'] === 'update' && !$_GET['borehole']) {

    $caption = "Something went wrong";
    $text = "Click <a href='index.php'>here</a> to return to the index";

    $mode = "CBid";
    $return = false;
    $ns = e107::getRender();
    $ns->tablerender($caption, $text, $mode, $return);

    require_once(FOOTERF);
    exit;
}

if($_GET['action'] === 'update') {
    if (USER) {
        $method = "PUT";
        $userData = e107::user(USERID); // Example - currently logged in user.
        $userclassList = explode(",", $userData["user_class"]);
        $userclassID = 4;  // id from 'Wiki Editors' userclass
        if(!in_array($userclassID, $userclassList)) {
            $ns->tablerender("Error!", "You must be part of the 'Wiki Editor' userclass to view this page");
            require_once(FOOTERF);
            exit;
        }
    }
}

if($_GET['action'] === 'create') {
    if (USER) {
        $method = "POST";
        $userData = e107::user(USERID); // Example - currently logged in user.
        $userclassList = explode(",", $userData["user_class"]);
        $userclassID = 4;  // id from 'Wiki Creators' userclass
        if(!in_array($userclassID, $userclassList)) {
            $ns->tablerender("Error!", "You must be part of the 'Wiki Creators' userclass to view this page");
            require_once(FOOTERF);
            exit;
        }
    }
}

// --- [ API ] ------------------------------------
$form_url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$form_db = "llg";
$form_table = "llg_nl_boreholedata";
$form_columns = "*";
$form_where_0_identifier = "borehole";
$form_where_0_value = filter_var($_GET[$form_where_0_identifier], FILTER_SANITIZE_STRING);
$form_order_by_0_identifier = "borehole";
$form_order_by_0_direction = "DESC";
$form_query = '{ "0": { "select": { "columns": { "0": "'.$form_columns.'" }, "from": { "table": "'.$form_table.'" } } }, "1": { "where": { "0": { "identifier": "'.$form_where_0_identifier.'", "value": "'.$form_where_0_value.'" } } }, "2": { "order_by": { "0": { "identifier": "'.$form_order_by_0_identifier.'", "direction": "'.$form_order_by_0_direction.'" } } } }';

// --- [ JAVASCRIPT ] -----------------------------
$script .= '
<script src="./form.js" type="module">
</script>
';

// --- [ TEMPLATE ] -------------------------------
$form = '
<form method="'.$method.'" class="container p-5"
    data-ajax="form"
    data-url=\''.$form_url.'\'
    data-db=\''.$form_db.'\'
    data-table=\''.$form_table.'\'
    data-columns=\''.$form_columns.'\'
    data-query=\''.$form_query.'\'>
</form>
';

// <form method="'.$method.'" class="container" data-ajax="form" data-url="'.$url.'" data-db="'.$db.'" data-table="'.$table.'" data-columns="'.$columns.'" data-inner_join="'.$inner_join.'" data-where="'.$where.'" data-order_by="'.$order_by.'" data-direction="'.$direction.'" data-paging="'.$paging.'" data-limit="'.$limit.'" data-offset="'.$offset.'">
// </form>
// ------------------------------------------------

$text = $script.$form.$footerscript;
$mode = "CBid";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);

require_once(FOOTERF);

?>