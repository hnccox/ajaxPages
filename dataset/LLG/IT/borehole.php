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

// --- [ SQL ] ------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "llg";
$table = "llg_it_boreholeheader";
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
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "llg";
$table = "llg_it_boreholedata";
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
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/beta/API.php");
    $jsonArray[] = $query->response;
    
    $_GET['db'] = json_encode($db);
    $_GET['query'] = $tablequery;
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/beta/API.php");
    $jsonArray[] = $query->response;

    echo json_encode($jsonArray, true);
    exit;
}

// ------------------------------------------------

require_once(HEADERF);

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

// ------------------------------------------------
$script = '
<script src="./borehole.js" type="module">
</script>
';
// ------------------------------------------------
$template = '
            <form id="LLGborehole" action="borehole.php" method="GET" target="_self">
                <input type="hidden" name="borehole" value="'.$_GET["borehole"].'" />
                <input type="hidden" name="action" value="edit" />
            </form>
            <div data-ajax="template"
                data-url=\''.$url.'\'
                data-db=\''.$db.'\'
                data-table=\''.$table.'\'
                data-columns=\''.$columns.'\'
                data-query=\''.$templatequery.'\'>
                <div class="panel panel-default">
                    <div class="panel-heading" style="color:rgb(0,0,0);background-color:rgb(255,205,0);">
                        <strong><span>Borehole: </span><span data-variable="borehole" contenteditable="false">borehole</span></strong>
                        <button type="submit" class="btn btn-sm btn-primary pull-right" form="LLGborehole">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <span class="pull-right">
                            <span>
                                <strong>Logged by: </strong>
                            </span>
                            <span data-variable="name" contenteditable="false">name</span>
                            <span>
                                <strong> on </strong>
                            </span>
                            <span data-variable="drilldate" contenteditable="false">drilldate</span>
                        </span>
                    </div>
                    <div class="panel-body">
                        <!--
                        <div class="row">
                            <div class="col-md-4 table-responsive" style="padding-top:14px">
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <td style="border:none">Name</td>
                                            <td style="border:none;font-weight: bold"><span data-variable="name" contenteditable="false">name</span></td>
                                            <td style="border:none">Date</td>
                                            <td style="border:none;font-weight: bold"><input type="date" data-variable="drilldate" value="" disabled></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        -->
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Coordinates</strong>
                                <div class="table-responsive">
                                    <table class="table table-condensed mb-0">
                                        <tbody>
                                            <tr>
                                                <td style="border:none">UTM Zone</td>
                                                <td style="border:none;font-weight: bold">
                                                    <input list="coordzones" name="coordzone" data-variable="coordzone" value="coordzone" disabled>
                                                    <datalist id="coordzones">
                                                        <option value="Internet Explorer">
                                                        <option value="Firefox">
                                                        <option value="Chrome">
                                                        <option value="Opera">
                                                        <option value="Safari">
                                                    </datalist>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td style="border:none">X</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="xco" value="xco" disabled></td>
                                                <td style="border:none">Y</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="yco" value="yco" disabled></td>
                                            </tr>
                                            <tr>
                                                <td style="border:none">Elevation (m)</td>
                                               <td style="border:none;font-weight: bold"><input type="text" data-variable="elevation" value="elevation" disabled></td>
                                                <td style="border:none">Depth (cm)</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="drilldepth" value="drilldepth" disabled></td>
                                            </tr>                                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <strong>Classification</strong>
                                <div class="table-responsive">
                                    <table class="table table-condensed mb-0">
                                        <tbody>
                                            <tr>
                                                <td style="border:none">Geom</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="geom" value="geom" disabled></td>
                                                <td style="border:none">Geol</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="geol" value="geol" disabled></td>
                                            </tr>
                                            <tr>
                                                <td style="border:none">Soil</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="soil" value="soil" disabled></td>
                                                <td style="border:none">Veget</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="veget" value="veget" disabled></td>
                                            </tr>
                                            <tr>
                                                <td style="border:none">GWT</td>
                                                <td style="border:none;font-weight: bold"><input type="text" data-variable="groundwaterstep" value="groundwaterstep" disabled></td>                                               
                                            </tr>                                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <textarea style="width:100%" data-variable="extraremarks" disabled>extraremarks</textarea>
                    </div>
                </div>
                <!--
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text"></p>
                    </div>
                </div>
                -->
                
                <!--
                <span data-variable="xco" contenteditable="false">xco</span>
                <span data-variable="yco" contenteditable="false">yco</span>
                <span data-variable="coordzone" contenteditable="false">coordzone</span>
                <span data-variable="elevation" contenteditable="false">elevation</span>
                <span data-variable="drilldepth" contenteditable="false">drilldepth</span>
                <span data-variable="geom" contenteditable="false">geom</span>
                <span data-variable="geol" contenteditable="false">geol</span>
                <span data-variable="soil" contenteditable="false">soil</span>
                <span data-variable="veget" contenteditable="false">veget</span>
                <span data-variable="groundwaterstep" contenteditable="false">groundwaterstep</span>
                <span data-variable="extraremarks" contenteditable="false">extraremarks</span>
                -->
            </div>
';
// ------------------------------------------------
$tableParams = [];
$tableParams['slave'] = true;
$tableParams['master'] = "Templates[0]";
$tableParams['columnNames'] = "Top,Depth,Texture,Org,Plr,Color,RedOx,Gravel,M50,Ca,Fe,GW,Sample,Paleosoil,Strat,Remarks";
$tableParams['columnSortable'] = false;
$tableParams['preview'] = false;
$tableParams['expanded'] = true;
$tableParams['href'] = false;
$tableParams['add'] = false;

$table = '
        <div class="table-scrollable" style="overflow-y: auto; overflow-x: hidden; height: 470px;">
            <table style="font-size:12px;" class="table table-hover table-ajax" 
                data-ajax="table"
                data-url=\''.$url.'\'
                data-db=\''.$db.'\'
                data-table=\''.$table.'\'
                data-columns=\''.$columns.'\'
                data-query=\''.$tablequery.'\'
                data-type="relational" 
                data-page="'.$sqlParams['offset'].'" 
                data-limit="'.$sqlParams['limit'].'" 
                data-columnnames="'.$tableParams['columnNames'].'" 
                data-columnsortable="'.$tableParams['columnSortable'].'"
                data-preview="'.$tableParams['preview'].'" 
                data-href="'.$tableParams['href'].'" 
                data-add="'.$tableParams['add'].'" '.$aria_expanded.'>
            </table>
        </div>';

// ------------------------------------------------
$caption = "<h1>LLG Boreholedata</h1>";
$text = $script.$template.$table;
$mode = "LLGboreholedate";
$return = false;
$ns = e107::getRender();
$ns->tablerender('', $text, $mode, $return);

// ------------------------------------------------

require_once(FOOTERF);

?>