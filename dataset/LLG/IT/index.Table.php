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
$tableParams['caption'] = "LLG IT";
$tableParams['columnNames'] = "yeargroup,year,names,n_boreholes,minXco,maxXco,minYco,maxYco";
$tableParams['preview'] = 20;
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