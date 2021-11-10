<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

//e107::css(url, 'css/index.css');
e107::css(url, '/e107_plugins/ajaxTemplates/css/ajaxTables.css');
//e107::js(url, 'js/index.js');
//e107::js(url, 'js/ajaxTables.js');

require_once(HEADERF);

// ------------------------------------------------
$script = '
<script src="./yeargroup.js" type="module">
</script>
';
// ------------------------------------------------
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/ajaxDBQuery.php";
$sqlParams['db'] = "llg";
$sqlParams['table'] = "llg_it_boreholeheader";
$sqlParams['columns'] = "borehole,name,drilldate,xco,yco";
$sqlParams['inner_join'] = "";
$sqlParams['where'] = "yeargroup=".$_GET['yeargroup'];
$sqlParams['order_by'] = "borehole";
$sqlParams['direction'] = "ASC";
$sqlParams['limit'] = null;
$sqlParams['offset'] = 0;
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
		data-url="'.$sqlParams['url'].'" 
		data-db="'.$sqlParams['db'].'" 
		data-table="'.$sqlParams['table'].'" 
		data-columns="'.$sqlParams['columns'].'"
		data-inner_join="'.$sqlParams['inner_join'].'" 
		data-where="'.$sqlParams['where'].'" 
		data-order_by="'.$sqlParams['order_by'].'" 
		data-direction="'.$sqlParams['direction'].'" 
		data-limit="'.$sqlParams['limit'].'" 
		data-offset="'.$sqlParams['offset'].'" 
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