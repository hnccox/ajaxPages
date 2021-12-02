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
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "llg";
$table = "llg_nl_boreholeheader";
$columns = "borehole,name,drilldate,xco,yco";
$where_0_identifier = "yeargroup";
$where_0_value = $_GET[$where_0_identifier];
$order_by_0_identifier = "borehole";
$order_by_0_direction = "ASC";
$limit = 100;
$offset = 0;
$query = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "value": "'.$where_0_value.'" }, "1": { "identifier": "active", "value": "true" } } }, "2": { "order_by": { "0": { "identifier": "'.$order_by_0_identifier.'", "direction": "'.$order_by_0_direction.'" } } }, "3": { "limit": "'.$limit.'" }, "4": { "offset": "'.$offset.'" } }';
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
<script src="./yeargroup.js" type="module">
</script>
';
// ------------------------------------------------
// $sqlParams = [];
// $sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/ajaxDBQuery.php";
// $sqlParams['db'] = "llg";
// $sqlParams['table'] = "llg_nl_boreholeheader";
// $sqlParams['columns'] = "borehole,name,drilldate,xco,yco";
// $sqlParams['where'] = "yeargroup=".$_GET['yeargroup'];
// $sqlParams['order_by'] = "borehole";
// $sqlParams['direction'] = "ASC";
// $sqlParams['limit'] = null;
// $sqlParams['offset'] = 0;
$tableParams = [];
$tableParams['caption'] = "Yeargroup: {$_GET['yeargroup']}";
$tableParams['columnNames'] = "borehole,name,drilldate,xco,yco";
$tableParams['preview'] = null;
$tableParams['expanded'] = true;
$tableParams['href'] = true;
$tableParams['add'] = false;
if ($tableParams['expanded'] == true) { $tableParams['expanded'] = "aria-expanded"; }
//$table = createAjaxTable($sqlParams, $tableParams);
$table = '
	<table style="font-size:12px;" class="table table-hover table-ajax hidden-xs" 
		data-ajax="table" 
        data-url=\''.$url.'\'
        data-db=\''.$db.'\'
        data-table=\''.$table.'\'
        data-columns=\''.$columns.'\'
        data-query=\''.$query.'\'
		data-columnnames="'.$tableParams['columnNames'].'" 
		data-columnsortable="'.$tableParams['columnSortable'].'"
		data-preview="'.$tableParams['preview'].'" 
		data-href="'.$tableParams['href'].'" 
		data-totalrecords="'.$tableParams['totalrecords'].'" 
		data-add="'.$tableParams['add'].'" '.$tableParams['expanded'].'>
		<caption>'.$tableParams['caption'].'</caption>
	</table>
';
// ------------------------------------------------
$caption = "";
$text = '<div class="row justify-content-md-center">
            <!-- <p>Click <a href="index.php">here</a> to return to index</p> -->
            <div class="col-md-10 col-md-offset-1">
                '.$table.'
            </div>
        </div>';
// ------------------------------------------------
$mode = "LLG";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text.$script, $mode, $return);

// ------------------------------------------------

require_once(FOOTERF);

?>