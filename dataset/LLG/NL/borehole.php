<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

e107::css(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
e107::js(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js');

// --- [ API ] ------------------------------------
$template_url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$template_db = "llg";
$template_table = "llg_nl_boreholeheader";
$template_columns = "borehole,name,drilldate,xco,yco,coordzone,elevation,drilldepth,geom,geol,soil,veget,groundwaterstep,extraremarks";
$template_where_0_identifier = "borehole";
$template_where_0_value = $_GET[$template_where_0_identifier];
$template_order_by_0_identifier = "borehole";
$template_order_by_0_direction = "DESC";
// $template_limit = $_GET['limit'] ?? 20;
// $template_offset = $_GET['offset'] ?? 0;
// $template_page = $_GET['page'] ?? 1;
// $template_offset = $_GET['offset'] ?? (($page - 1) * $_GET['limit']);
$template_query = '{ "0": { "select": { "columns": { "0": "'.$template_columns.'" }, "from": { "table": "'.$template_table.'" } } }, "1": { "where": { "0": { "identifier": "'.$template_where_0_identifier.'", "value": "'.$template_where_0_value.'" } } }, "2": { "order_by": { "0": { "identifier": "'.$template_order_by_0_identifier.'", "direction": "'.$template_order_by_0_direction.'" } } } }';
// ------------------------------------------------
$table_url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$table_db = "llg";
$table_table = "llg_nl_boreholedata";
$table_columns = "startdepth,depth,texture,organicmatter,plantremains,color,oxired,gravelcontent,median,calcium,ferro,groundwater,sample,soillayer,stratigraphy,remarks";
$table_where_0_identifier = "borehole";
$table_where_0_value = $_GET[$table_where_0_identifier];
$table_order_by_0_identifier = "startdepth";
$table_order_by_0_direction = "ASC";
// $limit = $_GET['limit'] ?? null;
// $offset = $_GET['offset'] ?? null;
// $page = $_GET['page'] ?? 1;
// $offset = $_GET['offset'] ?? (($page - 1) * $_GET['limit']);
$table_query = '{ "0": { "select": { "columns": { "0": "'.$table_columns.'" }, "from": { "table": "'.$table_table.'" } } }, "1": { "where": { "0": { "identifier": "'.$table_where_0_identifier.'", "value": "'.$table_where_0_value.'" } } }, "2": { "order_by": { "0": { "identifier": "'.$table_order_by_0_identifier.'", "direction": "'.$table_order_by_0_direction.'" } } } }';

// --- [ JSON ] -----------------------------------
if($_GET['format'] === 'json') {
    
    $included = true;

    header('Content-Type: application/json');
    
    $_GET['db'] = json_encode($template_db);
    $_GET['query'] = $template_query;
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/server/API.php");
    $jsonArray[] = $query->response;
    
    $_GET['db'] = json_encode($table_db);
    $_GET['query'] = $table_query;
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/server/API.php");
    $jsonArray[] = $query->response;

    echo json_encode($jsonArray, true);
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
    e107::css(url, 'https://wikiwfs.geo.uu.nl/e107_plugins/ajaxModules/Components/Table/ajaxTables.css');
    e107::css(url, 'https://wikiwfs.geo.uu.nl/e107_plugins/ajaxModules/Components/Template/ajaxTemplates.css');
    e107::css(url, 'https://cdn.jsdelivr.net/fontawesome/4.7.0/css/font-awesome.min.css');  
}

// ------------------------------------------------

if(!$_GET['borehole']) {

    $caption = "Something went wrong";
    $text = "Click <a href='index.php'>here</a> to return to the index";

    $mode = "LLGborehole";
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
            $footerscript .= '
            <script type="text/javascript">
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
                        if (element.hasAttribute("disabled")) {
                            element.removeAttribute("disabled");
                        }
                        
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
<script src="./borehole.js" type="module">
</script>
';
// --- [ TEMPLATE ] -------------------------------
$template = include('borehole.Template.php');
// --- [ TABLE ] ----------------------------------
$table = include('borehole.Table.php');

// --- [ RENDER ] ---------------------------------
$caption = '';
$text = '<div class="row justify-content-md-center p-0 m-0" id="borehole">'.$script.$template.$table.$footerscript.'</div>';
$mode = 'LLGboreholedate';
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