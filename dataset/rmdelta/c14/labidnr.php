<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

//e107::css(url, 'css/index.css');
e107::css(url, '/e107_plugins/ajaxTemplates/css/ajaxTables.css');
e107::css(url, '/e107_plugins/ajaxTemplates/css/ajaxTemplates.css');
e107::css(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
//e107::js(url, 'js/index.js');
//e107::js(url, 'js/ajaxPages.js');
e107::js(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js');

// ------------------------------------------------

require_once(HEADERF);

// --- [ SQL ] ------------------------------------
// ------------------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "rmdelta";
($_GET['releasecandidate'] == "true") ? $table = "c14_cat_rc" : $table = "c14_cat";
$columns = "*";
$where_0_identifier = "labidnr";
$where_0_value = $_GET[$where_0_identifier];
$limit = 1;
$offset = 0;
$query = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "value": "'.$where_0_value.'" } } }, "2": { "limit": "'.$limit.'" }, "3": { "offset": "'.$offset.'" } }';

// --- [ JSON ] -----------------------------------
// ------------------------------------------------
if($_GET['format'] === 'json') {

    $_GET['db'] = json_encode($db);
    $_GET['query'] = $query;
    
    header('Content-Type: application/json');
    require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/beta/API.php");
    exit;
}

if(!$_GET[$where_0_identifier]) {

    require_once(HEADERF);

    $caption = "Something went wrong";
    $text = "Click <a href='index.php'>here</a> to return to the index";

    $mode = "C14labidnr";
    $return = false;
    $ns = e107::getRender();
    $ns->tablerender($caption, $text, $mode, $return);

    require_once(FOOTERF);
    exit;
}

// --- [ JAVASCRIPT ] -----------------------------
// ------------------------------------------------
$script = '
<script src="./labidnr.js" type="module">
</script>
';

// ------------------------------------------------
// TEMPLATE
// ------------------------------------------------
$template = require_once('labidnr.template.php');

// ------------------------------------------------
if($_GET['action'] === 'edit') {
    // ToDo: Check if there is a release candidate...
    $edit = false;
    if (USER) {
        $userData = e107::user(USERID); // Example - currently logged in user.
        $userclassList = explode(",", $userData["user_class"]);
        $userclassID = 4;  // id from 'Wiki Editors' userclass
        if(!in_array($userclassID, $userclassList)) {
            require_once(HEADERF);
            $caption = "Error!";
            $text = "You must be part of the 'Wiki Editor' userclass to edit this page";
            $ns->tablerender($caption, $text);
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
                            element.parentElement.style.border = "1px solid red";
                            element.parentElement.style.margin = "-1px";
                            element.parentElement.style.minWidth = "1em";
                            element.parentElement.style.minHeight = "1em";
                        });
                    });
                })()
            </script>
            ';
        }
    } else {
        require_once(HEADERF);
        $caption = "Error!";
        $text = "You must login to edit this page";
        $ns->tablerender($caption, $text);
        require_once(FOOTERF);
        exit;
    }
}

// --- [ RENDER ] ---------------------------------
// ------------------------------------------------
$caption = '';
$text = $script.$template;
$mode = 'c14labidnr';
$return = false;
$ns = e107::getRender();
$ns->tablerender('', $text, $mode, $return);
// ------------------------------------------------
require_once(FOOTERF);
// ------------------------------------------------

?>