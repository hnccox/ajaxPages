<?php

// ------------------------------------------------

require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxModules/Components/Template/ajaxTemplate.php");

// ------------------------------------------------

$sqlParams = [];
$sqlParams['url'] = 'https://wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php';
$sqlParams['db'] = 'rmdelta';
$sqlParams['table'] = 'c14_cat';
$sqlParams['columns'] = '*';
$sqlParams['limit'] = 1;
$sqlParams['offset'] = 0;
$sqlParams['query'] = '{ "0": { "select": { "columns": { "0": "'.$sqlParams['columns'].'" }, "from": { "table": "'.$sqlParams['table'].'" } } }, "1": { "where": { "0": { "identifier": "labidnr", "value": "'.$_GET['labidnr'].'" } } }, "2": { "limit": "'.$sqlParams['limit'].'" }, "3": { "offset": "'.$sqlParams['offset'].'" } }';

// ------------------------------------------------

$templateParams = [];
//$templateParams['parent'] = '';
//$templateParams['template'] = '/labidnr.Template.html';

// ------------------------------------------------

$templateProps = [];

// ------------------------------------------------

return ajaxTemplate($sqlParams, $templateParams, $templateProps);

?>