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
$table = "llg_nl_grouplist";
$columns = "yeargroup,year,names,n_boreholes,minxco,maxxco,minyco,maxyco";
// $where_0_identifier = "";
// $where_0_value = $_GET[$where_0_identifier];
$order_by_0_identifier = "year";
$order_by_0_direction = "DESC";
$limit = $_GET['limit'] ?? 20;
$offset = $_GET['offset'] ?? 0;
$page = $_GET['page'] ?? 1;
$offset = $_GET['offset'] ?? (($page - 1) * $_GET['limit']);
$query = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "order_by": { "0": { "identifier": "'.$order_by_0_identifier.'", "direction": "'.$order_by_0_direction.'" } } }, "2": { "limit": "'.$limit.'" }, "3": { "offset": "'.$offset.'" } }';
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
// $sqlParams = [];
// $sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/ajaxDBQuery.php";
// $sqlParams['db'] = "llg";
// $sqlParams['table'] = "llg_nl_grouplist";
// $sqlParams['columns'] = "yeargroup,year,names,n_boreholes,minxco,maxxco,minyco,maxyco";
// $sqlParams['inner_join'] = "";
// $sqlParams['where'] = "";
// $sqlParams['order_by'] = "year";
// $sqlParams['direction'] = "DESC";
// $sqlParams['limit'] = 20;
// $sqlParams['offset'] = 0;
$tableParams = [];
$tableParams['caption'] = "LLG NL";
$tableParams['columnNames'] = "yeargroup,year,names,n_boreholes,minXco,maxXco,minYco,maxYco";
$tableParams['preview'] = 3;
$tableParams['expanded'] = true;
$tableParams['href'] = true;
$tableParams['add'] = false;
if ($tableParams['expanded'] == true) { $tableParams['expanded'] = "aria-expanded"; }
//$table = createAjaxTable($sqlParams, $tableParams);
// $table = '
// 	<table style="font-size:12px;" class="table table-hover table-ajax hidden-xs" 
// 		data-ajax="table" 
// 		data-url="'.$sqlParams['url'].'" 
// 		data-db="'.$sqlParams['db'].'" 
// 		data-table="'.$sqlParams['table'].'" 
// 		data-columns="'.$sqlParams['columns'].'"
// 		data-inner_join="'.$sqlParams['inner_join'].'" 
// 		data-where="'.$sqlParams['where'].'" 
// 		data-order_by="'.$sqlParams['order_by'].'" 
// 		data-direction="'.$sqlParams['direction'].'" 
// 		data-limit="'.$sqlParams['limit'].'" 
// 		data-offset="'.$sqlParams['offset'].'" 
// 		data-columnnames="'.$tableParams['columnNames'].'" 
// 		data-columnsortable="'.$tableParams['columnSortable'].'"
// 		data-preview="'.$tableParams['preview'].'" 
// 		data-href="'.$tableParams['href'].'" 
// 		data-totalrecords="'.$tableParams['totalrecords'].'" 
// 		data-add="'.$tableParams['add'].'" '.$tableParams['expanded'].'>
// 		<caption>'.$tableParams['caption'].'</caption>
// 	</table>
// ';
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
$text = '<div class="row">
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