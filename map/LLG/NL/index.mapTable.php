<?php

// ------------------------------------------------

// SLAVE TABLE
// Need to be bound to a layer
// sqlParams['table'] must match at least one of the data-table of the maplayers
// If no query, then it gets data from parent, else it retrieves its own data!
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$sqlParams['db'] = "llg";
$sqlParams['table'] = "llg_nl_boreholeheader";
$sqlParams['columns'] = "borehole,xco,yco,drilldepth";
$sqlParams['inner_join'] = null;
$sqlParams['where'] = null;
$sqlParams['order_by'] = null;
$sqlParams['direction'] = null;
$sqlParams['limit'] = null;
$sqlParams['offset'] = null;
$tableParams = [];
$tableParams['caption'] = "";
$tableParams['slave'] = true;
$tableParams['master'] = "Maps[0]";
$tableParams['columnNames'] = "borehole,xco,yco,drilldepth";
$tableParams['columnSortable'] = false;
$tableParams['href'] = false;
$tableParams['events'] = "mouseover,mouseout,mousedown,mouseup,click";
$tableParams['preview'] = false;
$tableParams['expanded'] = true;
$tableParams['totalrecords'] = false;
$tableParams['add'] = false;

$table = '
<div class="table-scrollable" style="overflow-y: auto; max-height: 320px;">
    <table style="display:none;font-size:12px;" class="table table-hover table-ajax hidden-xs" 
        data-ajax="table" 
        data-type="slave"
        data-slave="'.$tableParams['slave'].'" 
        data-master="'.$tableParams['master'].'" 
        data-url="'.$sqlParams['url'].'" 
        data-db="'.$sqlParams['db'].'" 
        data-table="'.$sqlParams['table'].'" 
        data-columns="'.$sqlParams['columns'].'" 
        data-inner_join="'.$sqlParams['inner_join'].'" 
        data-where="'.$sqlParams['where'].'" 
        data-order_by="'.$sqlParams['order_by'].'" 
        data-direction="'.$sqlParams['direction'].'" 
        data-limit="'.$sqlParams['limit'].'" 
        data-offset="'.$sqlParams['offset'].'" 
        data-columnnames="'.$tableParams['columnNames'].'" 
        data-columnsortable="'.$tableParams['columnSortable'].'"
        data-href="'.$tableParams['href'].'"
        data-events="'.$tableParams['events'].'"
        data-preview="'.$tableParams['preview'].'" 
        data-totalrecords="'.$tableParams['totalrecords'].'" 
        data-add="'.$tableParams['add'].'" '.$aria_expanded.'>
    </table>
</div>';

// ------------------------------------------------

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    echo $table;
}
else {
    return $table;
}

// ------------------------------------------------

?>