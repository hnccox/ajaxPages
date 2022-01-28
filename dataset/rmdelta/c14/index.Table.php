<?php

// ------------------------------------------------

require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxModules/Components/Table/ajaxTable.php");

// ------------------------------------------------

$sqlParams = [];
$sqlParams['url'] = $url;
$sqlParams['db'] = $db;
$sqlParams['table'] = $table;
$sqlParams['columns'] = $columns;
$sqlParams['query'] = $query;
$sqlParams['limit'] = $limit;
$sqlParams['offset'] = $offset;

// ------------------------------------------------

$tableParams = [];
$tableParams['caption'] = "C14 Catalog";
$tableParams['columnNames'] = "labIDnr,Name,14C age,14C err,Marine curve,ChanAge,GWL,LDEM,MSL,VegHis,Landsub,Compaction";
$tableParams['preview'] = 20;
$tableParams['expanded'] = false;
$tableParams['href'] = true;
$tableParams['add'] = false;

// ------------------------------------------------

return ajaxTable($sqlParams, $tableParams);

// ------------------------------------------------

?>