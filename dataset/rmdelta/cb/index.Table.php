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
$tableParams['caption'] = "Rhine-Meuse delta";
$tableParams['columnNames'] = "Id,Name,14C age begin,14C age end,Cal age begin,Cal age end,Existence,Riversystem group";
$tableParams['preview'] = 20;
$tableParams['expanded'] = true;
$tableParams['href'] = true;
$tableParams['add'] = false;
$tableParams['expanded'] = true;

// ------------------------------------------------

$tableProps['type'] = 'table-scrollable';
$tableProps['height'] = '500px';

// ------------------------------------------------

return ajaxTable($sqlParams, $tableParams);

// ------------------------------------------------

?>