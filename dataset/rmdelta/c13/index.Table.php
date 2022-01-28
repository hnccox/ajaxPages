<?php

// ------------------------------------------------

require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxModules/Components/Table/ajaxTable.php");

// ------------------------------------------------

$sqlParams = [];
$sqlParams['url'] = 'https://wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php';
$sqlParams['db'] = 'rmdelta';
$sqlParams['table'] = 'c14_cat';
$sqlParams['columns'] = 'labidnr,samplename,c14age,c14err,marinecurve2bused,inuseforchannelage,inuseforgwtinterpol,inuseforldem,inuseformslrise,inuseforvegetationhistory,inuseforlandsubsidence,inuseforcompactquant';
$sqlParams['limit'] = 100;
$sqlParams['offset'] = 0;
$sqlParams['query'] = '{ "0": { "select": { "columns": { "0": "'.$sqlParams['columns'].'" }, "from": { "table": "'.$sqlParams['table'].'" } } }, "1": { "order_by": { "0": { "identifier": "labidnr", "direction": "ASC" } } }, "2": { "limit": "'.$sqlParams['limit'].'" }, "3": { "offset": "'.$sqlParams['offset'].'" } }';

// ------------------------------------------------

$tableParams = [];
//$tableParams['caption'] = '';
//$tableParams['columnNames'] = '';
//$tableParams['preview'] = 3;
//$tableParams['expanded'] = false;
//$tableParams['href'] = true;
//$tableParams['add'] = false;

// ------------------------------------------------

return ajaxTable($sqlParams, $tableParams);

// ------------------------------------------------

?>