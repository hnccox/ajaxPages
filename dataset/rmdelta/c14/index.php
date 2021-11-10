<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

//e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxMenu.css');
e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxTables.css');

// --- [ SQL ] ------------------------------------
// ------------------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "rmdelta";
$table = "c14_cat";
$columns = "labidnr,samplename,c14age,c14err,marinecurve2bused,inuseforchannelage,inuseforgwtinterpol,inuseforldem,inuseformslrise,inuseforvegetationhistory,inuseforlandsubsidence,inuseforcompactquant";
$where_0_identifier = "labidnr";
$where_0_value = $_GET[$where_0_identifier];
$order_by_0_identifier = $where_0_identifier;
$order_by_0_direction = "ASC";
$limit = $_GET['limit'] ?? 100;
$offset = $_GET['offset'] ?? 0;
$page = $_GET['page'] ?? 1;
$offset = $_GET['offset'] ?? (($page - 1) * $_GET['limit']);
$query = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "order_by": { "0": { "identifier": "'.$order_by_0_identifier.'", "direction": "'.$order_by_0_direction.'" } } }, "2": { "limit": "'.$limit.'" }, "3": { "offset": "'.$offset.'" } }';

// --- [ JSON ] -----------------------------------
// ------------------------------------------------
if($_GET['format'] === 'json') {

    $_GET['db'] = json_encode($db);
    $_GET['query'] = $query;

    header('Content-Type: application/json');
    require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/beta/API.php");
    exit;
}

require_once(HEADERF);

// --- [ JAVASCRIPT ] -----------------------------
// ------------------------------------------------
$script = '
<script src="./index.js" type="module">
</script>
';

// --- [ TABLE ] ----------------------------------
// ------------------------------------------------
$tableParams = [];
$tableParams['caption'] = "C14 Catalog";
$tableParams['columnNames'] = "labIDnr,Name,14C age,14C err,Marine curve,ChanAge,GWL,LDEM,MSL,VegHis,Landsub,Compaction";
$tableParams['preview'] = 20;
$tableParams['expanded'] = false;
$tableParams['href'] = true;
$tableParams['add'] = false;
if ($tableParams['expanded'] == true) { $tableParams['expanded'] = "aria-expanded"; }
$table = '
<table class="table table-hover table-ajax"
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
    data-limit="'.$limit.'" 
    data-offset="'.$offset.'" 
    data-add="'.$add.'"
	'.$tableParams['expanded'].'>
    <caption>'.$tableParams['caption'].'</caption>
</table>';

// --- [ RENDER ] ---------------------------------
// ------------------------------------------------
$caption = '<h1>C14 Catalog</h1>';
$description = '<p>The table below shows all 14C dates currently in our database (back to RMD:Introduction).</p>
<p>The contents of this page is database-queried. Custom queries are found under RijnMaasDelta:UserQueries.</p>';
$text = '<div class="row justify-content-md-center">
			<div class="col-md-10 col-md-offset-1">
				'.$table.'
			</div>
		</div>';
$mode = 'C14catalog';
$return = false;
$ns = e107::getRender();
$ns->tablerender('', $text.$script, $mode, $return);
// ------------------------------------------------
require_once(FOOTERF);
exit;
// ------------------------------------------------

?>
