<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

//e107::css(url, 'css/index.css');
e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxMenu.css');
e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxTables.css');
//e107::js(url, 'js/index.js');
//e107::js(url, 'js/ajaxTables.js');

require_once(HEADERF);

// ------------------------------------------------
$script = '
<script src="./index.js" type="module">
</script>
';
// ------------------------------------------------
$ajax = true;
$href = true;
$add = false;
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "rmdelta";
$table = "cb_cat";
$columns = "id,name,abegin14cbp,aend14cbp,abegincalbp,aendcalbp,existence,riversystemgrp";
$columnNames = "Id,Name,14C age begin,14C age end,Cal age begin,Cal age end,Existence,Riversystem group";
$inner_join = null;
$where = "systemgrp BETWEEN 10 AND 19";
$order_by = "id";
$direction = "ASC";
$limit = 20;
$offset = 0;
$preview = 3;

// ------------------------------------------------
// TO DO: This template should come from the database!
$caption = '<h1>CB Catalog</h1>';
$text = '<div class="row">
            <div class="col-md-3 col-md-offset-1">
                <br>
                <br>
                <br>
                <div data-ajax="menu" 
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
                </div>
            </div>
            <div class="col-md-7">
                <table class="table table-hover table-ajax"
                    data-ajax="table" 
                    data-href="'.$href.'" 
                    data-add="'.$add.'"
                    data-url="'.$url.'" 
                    data-db="'.$db.'"
                    data-table="'.$table.'"
                    data-columns="'.$columns.'" 
                    data-query=\'{ "0": { "select": { "columns": { "0": "id,name,abegin14cbp,aend14cbp,abegincalbp,aendcalbp,existence,riversystemgrp" }, "from": { "table": "cb_cat" } } }, "1": { "where": { "0": { "identifier": "systemgrp", "between": { "0": 10, "1": 19 } } } }, "2": { "order_by": { "0" : { "identifier": "id", "direction": "ASC" } } }, "3": { "limit": 20 }, "4": { "offset": 0 } }\'
                    data-columnnames="'.$columnNames.'" 
                    data-inner_join="'.$inner_join.'"
                    data-where="'.$where.'" 
                    data-order_by="'.$order_by.'" 
                    data-direction="'.$direction.'" 
                    data-limit="'.$limit.'" 
                    data-offset="'.$offset.'" 
                    data-preview="'.$preview.'" 
                    aria-expanded="false">
                    <caption>Rhine-Meuse delta</caption>
                </table>
            </div>
        </div>';
// ------------------------------------------------

$mode = "CBcatalog";
$return = false;
$ns = e107::getRender();
$ns->tablerender('', $text.$script, $mode, $return);

require_once(FOOTERF);

?>
