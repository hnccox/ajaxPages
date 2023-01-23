<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

e107::css(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
e107::js(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js');

// --- [ API ] ------------------------------------
$template_url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$template_db = "rmdelta";
($_GET['releasecandidate'] == "true") ? $template_table = "c14_cat_rc" : $template_table = "c14_cat";
$template_columns = "*";
$template_where_0_identifier = "labidnr";
$template_where_0_value = filter_var($_GET[$template_where_0_identifier], FILTER_SANITIZE_STRING);
$template_limit = 1;
$template_offset = 0;
$template_query = '{ "0": { "select": { "columns": { "0": "'.$template_columns.'" }, "from": { "table": "'.$template_table.'" } } }, "1": { "where": { "0": { "identifier": "'.$template_where_0_identifier.'", "value": "'.$template_where_0_value.'" } } }, "2": { "limit": "'.$template_limit.'" }, "3": { "offset": "'.$template_offset.'" } }';

// --- [ JSON ] -----------------------------------
if($_GET['format'] === 'json') {

    header('Content-Type: application/json');
    $_GET['db'] = json_encode($template_db);
    $_GET['query'] = $template_query;
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/server/API.php");
    $jsonArray[] = $query->response;
    echo $jsonArray;    
    exit;

}

// --- [ HEADER ] ---------------------------------
$iframe = function() {
    if(strpos(parse_url($_SERVER['HTTP_REFERER'])['path'], '/beta/map/') === 0) {
        return true;
    }
};

if(!$iframe()) {
    require_once(HEADERF);  
} else {
    e107::css(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
    e107::js(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js');
    e107::css(url, 'https://wikiwfs.geo.uu.nl/e107_plugins/ajaxModules/Components/Table/ajaxTables.css');
    e107::css(url, 'https://wikiwfs.geo.uu.nl/e107_plugins/ajaxModules/Components/Template/ajaxTemplates.css');
    e107::css(url, 'https://cdn.jsdelivr.net/fontawesome/4.7.0/css/font-awesome.min.css');  
}

if(!$_GET[$template_where_0_identifier]) {

    $caption = "Something went wrong";
    $text = "Click <a href='index.php'>here</a> to return to the index";

    $mode = "C14labidnr";
    $return = false;
    $ns = e107::getRender();
    $ns->tablerender($caption, $text, $mode, $return);

    require_once(FOOTERF);
    exit;
}

// ------------------------------------------------

if($_GET['action'] === 'edit') {
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
        $ns->tablerender("Error!", "You must login to edit this page");
        require_once(FOOTERF);
        exit;
    }
}

// --- [ JAVASCRIPT ] -----------------------------
$script = '
<script src="./labidnr.js" type="module">
</script>
';
// --- [ TEMPLATE ] -------------------------------
$template = require_once('labidnr.Template.php');

// --- [ RENDER ] ---------------------------------
$caption = '';
$text = '<div class="row justify-content-md-center" id="labidnr">'.$script.$template.'</div>';
$mode = 'c14labidnr';
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------
if(!$iframe()) {
    require_once(FOOTERF);
}
exit;
// ------------------------------------------------

?>