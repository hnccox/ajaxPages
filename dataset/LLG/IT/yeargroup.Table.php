<?php

// ------------------------------------------------

require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxModules/Components/Table/ajaxTable.php");

// ------------------------------------------------

$sqlParams = [];
$sqlParams['url'] = $table_url;
$sqlParams['db'] = $table_db;
$sqlParams['table'] = $table_table;
$sqlParams['columns'] = $table_columns;
$sqlParams['query'] = $table_query;
$sqlParams['limit'] = $table_limit;
$sqlParams['offset'] = $table_offset;

// ------------------------------------------------

$tableParams = [];
$tableParams['columnNames'] = "borehole,name,drilldate,xco,yco";
$tableParams['columnSortable'] = true;
$tableParams['preview'] = false;
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