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
$tableParams['parent'] = "";
$tableParams['columnNames'] = "Top,Depth,Texture,Org,Plr,Color,RedOx,Gravel,M50,Ca,Fe,GW,Sample,Paleosoil,Strat,Remarks";
$tableParams['columnSortable'] = false;
$tableParams['preview'] = false;
$tableParams['expanded'] = true;
$tableParams['href'] = false;
$tableParams['add'] = false;

// ------------------------------------------------

$tableProps = [];
$tableProps['type'] = 'table-scrollable';
$tableProps['height'] = '560px';

// ------------------------------------------------

return ajaxTable($sqlParams, $tableParams, $tableProps);

// ------------------------------------------------

?>