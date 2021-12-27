<?php

// ------------------------------------------------

$tableParams = [];
$tableParams['caption'] = "CB Catalog";
$tableParams['columnNames'] = "Id,Name,14C age begin,14C age end,Cal age begin,Cal age end,Existence,Riversystem group";
$tableParams['preview'] = 20;
$tableParams['expanded'] = true;
$tableParams['href'] = true;
$tableParams['add'] = false;
if ($tableParams['expanded'] == true) { $tableParams['expanded'] = "aria-expanded"; }

// ------------------------------------------------

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

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    echo $table;
} else {
    return $table;
}

// ------------------------------------------------

?>