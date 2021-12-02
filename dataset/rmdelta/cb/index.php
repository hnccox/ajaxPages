<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxMenu.css');
e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxTables.css');

// ------------------------------------------------

require_once(HEADERF);

// ------------------------------------------------
$script = '
<script src="./index.js" type="module">
</script>
';
// ------------------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "rmdelta";
$table = "cb_cat";
$columns = "id,name,abegin14cbp,aend14cbp,abegincalbp,aendcalbp,existence,riversystemgrp";
$where_0_identifier = "systemgrp";
//$where_0_value = "BETWEEN 10 AND 19";
//$where = "systemgrp BETWEEN 10 AND 19";
$order_by_0_identifier = "id";
$order_by_0_direction = "ASC";
$limit = 20;
$offset = 0;
$query = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "between": { "0": 10, "1": 19 } } } }, "2": { "order_by": { "0" : { "identifier": "'.$order_by_0_identifier.'", "direction": "'.$order_by_0_direction.'" } } }, "3": { "limit": "'.$limit.'" }, "4": { "offset": "'.$offset.'" } }';
// ------------------------------------------------

// TO DO: This template should come from the database!
$menu = '<div data-ajax="menu" 
            data-url="'.$url.'" 
            data-db="'.$db.'" 
            data-table="cb_cat_systemgrps" 
            data-columns="id,name,displayname" 
            data-query=\'{ "0": { "select": { "columns": { "0": "id,name,displayname" }, "from": { "table": "cb_cat_systemgrps" } } }, "1": { "order_by": { "0": { "identifier": "id", "direction": "ASC" } } } }\'
            data-inner_join=""
            data-where="" 
            data-order_by="id" 
            data-direction="ASC"
            data-limit="100"
            data-offset="0">
        </div>';
// ------------------------------------------------
$tableParams = [];
$tableParams['caption'] = "CB Catalog";
$tableParams['columnNames'] = "Id,Name,14C age begin,14C age end,Cal age begin,Cal age end,Existence,Riversystem group";
$tableParams['preview'] = 20;
$tableParams['expanded'] = true;
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
    data-caption=\''.$tableParams['caption'].'\'
    data-columnnames="'.$tableParams['columnNames'].'" 
    data-columnsortable="'.$tableParams['columnSortable'].'"
    data-preview="'.$tableParams['preview'].'" 
    data-href="'.$tableParams['href'].'" 
    data-totalrecords="'.$tableParams['totalrecords'].'" 
    data-limit="'.$limit.'" 
    data-offset="'.$offset.'" 
    data-add="'.$add.'"
    '.$tableParams['expanded'].'>
</table>';
// ------------------------------------------------
$caption = '<h1>CB Catalog</h1>';
$text = '<div class="row justify-content-md-center"">
            <div class="col-md-3 offset-md-1">
                <br>
                <br>
                <br>
                '.$menu.'
            </div>
            <div class="col-md-7">
                '.$table.'
            </div>
        </div>';
// ------------------------------------------------
$mode = 'CBcatalog';
$return = false;
$ns = e107::getRender();
$ns->tablerender('', $text.$script, $mode, $return);

// ------------------------------------------------

require_once(FOOTERF);

?>
