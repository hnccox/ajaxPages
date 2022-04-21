
<?php

// ------------------------------------------------

require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxModules/Components/Table/ajaxTable.php");

// ------------------------------------------------

$table_url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$table_db = "llg";
$table_table = "llg_it_boreholedata";
$table_columns = "startdepth,depth,texture,organicmatter,plantremains,color,oxired,gravelcontent,median,calcium,ferro,groundwater,sample,soillayer,stratigraphy,remarks";
$table_where_0_identifier = "borehole";
$table_where_0_value = ":uid";
$table_order_by_0_identifier = "startdepth";
$table_order_by_0_direction = "ASC";
$limit = $_GET['limit'] ?? null;
$offset = $_GET['offset'] ?? null;
$page = $_GET['page'] ?? 1;
$offset = $_GET['offset'] ?? (($page - 1) * $_GET['limit']);
$table_query = '{ "0": { "select": { "columns": { "0": "'.$table_columns.'" }, "from": { "table": "'.$table_table.'" } } }, "1": { "where": { "0": { "identifier": "'.$table_where_0_identifier.'", "value": "'.$table_where_0_value.'" } } }, "2": { "order_by": { "0": { "identifier": "'.$table_order_by_0_identifier.'", "direction": "'.$table_order_by_0_direction.'" } } } }';

// $sqlParams = [];
// $sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
// $sqlParams['db'] = "llg";
// $sqlParams['table'] = "llg_it_boreholedata";
// $sqlParams['columns'] = "startdepth,depth,texture,organicmatter,plantremains,color,oxired,gravelcontent,median,calcium,ferro,groundwater,sample,soillayer,stratigraphy,remarks";
// $sqlParams['query'] = 
// $sqlParams['where'] = "borehole=''";
// $sqlParams['order_by'] = "startdepth";
// $sqlParams['direction'] = "ASC";
// $sqlParams['limit'] = null;
// $sqlParams['offset'] = null;

$sqlParams = [];
$sqlParams['url'] = $table_url;
$sqlParams['db'] = $table_db;
$sqlParams['table'] = $table_table;
$sqlParams['columns'] = $table_columns;
$sqlParams['query'] = $table_query;
$sqlParams['limit'] = $limit;
$sqlParams['offset'] = $offset;

// ------------------------------------------------

$tableParams = [];
$tableParams['parent'] = "ajaxTemplates[0]";
$tableParams['key'] = "UU LLG_IT";
$tableParams['columnNames'] = "Top,Depth,Texture,Org,Plr,Color,RedOx,Gravel,M50,Ca,Fe,GW,Sample,Paleosoil,Strat,Remarks";
$tableParams['columnSortable'] = false;
$tableParams['preview'] = false;
$tableParams['expanded'] = true;
$tableParams['href'] = false;
$tableParams['events'] = ["mouseover", "mouseout", "mousedown", "mouseup", "click"];

// $tableParams = [];
// $tableParams['caption'] = "C14 Catalog";
// $tableParams['columnNames'] = "labIDnr,Name,14C age,14C err,Marine curve,ChanAge,GWL,LDEM,MSL,VegHis,Landsub,Compaction";
// $tableParams['preview'] = 20;
// $tableParams['expanded'] = false;
// $tableParams['href'] = true;
// $tableParams['add'] = false;
// if ($tableParams['expanded'] == true) { $tableParams['expanded'] = "aria-expanded"; }

// ------------------------------------------------

$tableProps['type'] = 'table-scrollable';

return ajaxTable($sqlParams, $tableParams, $tableProps);

// ------------------------------------------------

?>

<!-- <?php

// ------------------------------------------------





// $table = '
// <div class="table-scrollable" style="overflow-y: auto; overflow-x: hidden; height: 408px;">
//     <table style="font-size:12px;" class="table table-hover table-ajax" 
//         data-ajax="table"
//         data-type="relational"
//         data-slave="'.$tableParams['slave'].'" 
//         data-master="'.$tableParams['master'].'" 
//         data-url="'.$sqlParams['url'].'" 
//         data-db="'.$sqlParams['db'].'" 
//         data-table="'.$sqlParams['table'].'" 
//         data-columns="'.$sqlParams['columns'].'" 
//         data-inner_join="'.$sqlParams['inner_join'].'" 
//         data-where="'.$sqlParams['where'].'" 
//         data-order_by="'.$sqlParams['order_by'].'" 
//         data-direction="'.$sqlParams['direction'].'" 
//         data-limit="'.$sqlParams['limit'].'" 
//         data-offset="'.$sqlParams['offset'].'" 
//         data-columnnames="'.$tableParams['columnNames'].'" 
//         data-columnsortable="'.$tableParams['columnSortable'].'"
//         data-preview="'.$tableParams['preview'].'" 
//         data-href="'.$tableParams['href'].'" 
//         data-events="'.$tableParams['events'].'"
//         data-add="'.$tableParams['add'].'" '.$aria_expanded.'>
//     </table>
// </div>';
        
// ------------------------------------------------

// if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
//     echo $table;
// }
// else {
//     return $table;
// }

// ------------------------------------------------

?> -->