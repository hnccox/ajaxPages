<?php

// ------------------------------------------------

require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxModules/Components/Table/ajaxTable.php");

// ------------------------------------------------

$sqlParams = [];
$sqlParams['url'] = $url;
$sqlParams['db'] = $db;
$sqlParams['table'] = $table;
$sqlParams['columns'] = $columns;
$sqlParams['limit'] = $limit;
$sqlParams['offset'] = $offset;
$sqlParams['query'] = $query;

// ------------------------------------------------

$tableParams = [];
$tableParams['caption'] = "Yeargroup: ".filter_var($_GET['yeargroup'], FILTER_SANITIZE_NUMBER_INT);
$tableParams['columnNames'] = "borehole,name,drilldate,xco,yco";
$tableParams['preview'] = null;
$tableParams['expanded'] = true;
$tableParams['href'] = true;
$tableParams['add'] = false;

// ------------------------------------------------

$tableProps = [];
$tableProps['class'] = "table table-hover";
$tableProps['style'] = "font-size: 12px";

// ------------------------------------------------

return ajaxTable($sqlParams, $tableParams, $tableProps);

// ------------------------------------------------

?>