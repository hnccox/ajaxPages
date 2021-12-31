<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

e107::css(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
e107::js(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js');

// --- [ API ] ------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$db = "rmdelta";
($_GET['releasecandidate'] == "true") ? $table = "cb_cat_rc" : $table = "cb_cat";
$columns = "*";
$where_0_identifier = "id";
$where_0_value = $_GET[$where_0_identifier];
$limit = 1;
$offset = 0;
$query = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "value": "'.$where_0_value.'" } } }, "2": { "limit": "'.$limit.'" }, "3": { "offset": "'.$offset.'" } }';

// --- [ JSON ] -----------------------------------
if($_GET['format'] === 'json') {

    header('Content-Type: application/json');
    $_GET['db'] = json_encode($db);
    $_GET['query'] = $query;
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/server/API.php");
    exit;
    
}

// --- [ HEADER ] ---------------------------------
if(!$_SERVER['HTTP_REFERER']) {
    require_once(HEADERF);
} else {
    e107::css(url, 'https://wikiwfs.geo.uu.nl/e107_plugins/ajaxModules/Components/Table/ajaxTables.css');
    e107::css(url, 'https://wikiwfs.geo.uu.nl/e107_plugins/ajaxModules/Components/Template/ajaxTemplates.css');
    e107::css(url, 'https://cdn.jsdelivr.net/fontawesome/4.7.0/css/font-awesome.min.css');
}

if(!$_GET[$where_0_identifier]) {

    $caption = "Something went wrong";
    $text = "Click <a href='index.php'>here</a> to return to the index";

    $mode = "CBid";
    $return = false;
    $ns = e107::getRender();
    $ns->tablerender($caption, $text, $mode, $return);

    require_once(FOOTERF);
    exit;
}

// ------------------------------------------------

if($_GET['action'] === 'update') {
    // TODO: Check if there is a release candidate...
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
            $script .= '
            <script type="text/javascript" defer>
                (function() {
                    window.addEventListener("load", function(){
                        const Template = document.querySelectorAll("[data-page]");
                        const elementList = document.querySelectorAll("[contenteditable=\'false\']");
                        elementList.forEach((element) => {
                            element.contentEditable = "true";
                            element.style.border = "1px solid red";
                            element.style.margin = "-1px";
                            element.style.minWidth = "1em";
                            element.style.minHeight = "1em";
                        });
                    });
                })()
            </script>
            ';
        }
    } else {
        $ns->tablerender("Error!", "You must login to edit this page");
        require_once(FOOTERF);
        exit;
    }
}

// --- [ JAVASCRIPT ] -----------------------------
$script = '
<script src="./id.js" type="module">
</script>
';
// --- [ TEMPLATE ] -------------------------------
$template = include('id.Template.php');

// --- [ RENDER ] ---------------------------------
$caption = '';
$text = '<div id="id">'.$script.$template.'<div>';
$mode = "CBid";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------
if(!$_SERVER['HTTP_REFERER']) {
    require_once(FOOTERF);
}
exit;
// ------------------------------------------------

?>