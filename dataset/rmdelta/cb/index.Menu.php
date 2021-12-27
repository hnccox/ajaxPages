<?php

// ------------------------------------------------

$menu = '
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
</div>';

// ------------------------------------------------

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    echo $menu;
} else {
    return $menu;
}

// ------------------------------------------------

?>