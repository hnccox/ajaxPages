<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

// --- [ API ] ------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
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
if($_GET['format'] === 'json') {

    header('Content-Type: application/json');

    $_GET['db'] = json_encode($db);
    $_GET['query'] = $query;
    require($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/server/API.php");
    $jsonArray[] = $query->response;

    echo json_encode($jsonArray, true);
    exit;
}

// --- [ HEADER ] ---------------------------------
require_once(HEADERF);

// --- [ JAVASCRIPT ] -----------------------------
$script = '
<script src="./index.js" type="module">
</script>
';
// --- [ TABLE ] ----------------------------------
$table = include('index.Table.php');

// --- [ RENDER ] ---------------------------------
$caption = '<h1>C14 Catalog</h1>';
$text = $script.'<div class="row justify-content-md-center">
			<div class="col-md-10 col-md-offset-1">
				'.$table.'
			</div>
		</div>';
$mode = 'C14catalog';
$return = false;
$ns = e107::getRender();
$ns->tablerender('', $text, $mode, $return);
// ------------------------------------------------
require_once(FOOTERF);
exit;
// ------------------------------------------------

?>
