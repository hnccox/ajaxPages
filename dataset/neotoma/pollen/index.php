<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

//e107::css(url, 'css/index.css');
e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxTables.css');
//e107::js(url, 'js/index.js');
//e107::js(url, 'js/ajaxTables.js');

// ------------------------------------------------
$url = "//api.neotomadb.org/v2.0/data/geopoliticalunits/3180/sites?limit=500&offset=0";
$db = null;
$table = null;
$columns = "siteid,sitename,longitude,latitude";
$where_0_identifier = null;
$where_0_value = null;
$order_by_0_identifier = null;
$order_by_0_direction = null;
$limit = $_GET['limit'] ?? "200";
$offset = $_GET['offset'] ?? 0;
$page = $_GET['page'] ?? 1;
$offset = $_GET['offset'] ?? (($page - 1) * $_GET['limit']);
$query = '{}';
// ------------------------------------------------

if($_GET['format'] === 'json') {

    $_GET['db'] = json_encode($db);
    $_GET['query'] = $query;
    
    header('Content-Type: application/json');
    require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/beta/API.php");
    exit;
}

// ------------------------------------------------

require_once(HEADERF);

// ------------------------------------------------
$script = '
<script src="./index.js" type="module">
</script>
';
// ------------------------------------------------
$tableParams = [];
$tableParams['caption'] = "Dutch Pollen";
$tableParams['columnNames'] = "siteid,sitename,longitude,latitude";
$tableParams['preview'] = 3;
$tableParams['expanded'] = true;
$tableParams['href'] = false;
$tableParams['add'] = false;
if ($tableParams['expanded'] == true) { $tableParams['expanded'] = "aria-expanded"; }
$table = '
<table style="font-size:12px;" class="table table-hover table-ajax hidden-xs" 
	data-ajax="table" 
    data-url=\''.$url.'\'
    data-columns=\''.$columns.'\'
    data-query=\''.$query.'\'
	data-columnnames="'.$tableParams['columnNames'].'" 
	data-columnsortable="'.$tableParams['columnSortable'].'"
	data-preview="'.$tableParams['preview'].'" 
	data-href="'.$tableParams['href'].'" 
	data-totalrecords="'.$tableParams['totalrecords'].'"
    data-limit="200"
	data-add="'.$tableParams['add'].'" '.$tableParams['expanded'].'>
	<caption>'.$tableParams['caption'].'</caption>
</table>
';
// ------------------------------------------------
$caption = '';
$text = '<div class="row justify-content-md-center">
            <div class="col-md-10 col-md-offset-1">
                '.$table.'
            </div>
        </div>';
// ------------------------------------------------
$mode = 'Neotoma';
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text.$script, $mode, $return);

// ------------------------------------------------

require_once(FOOTERF);

?>