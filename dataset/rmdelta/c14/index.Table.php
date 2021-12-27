<?php

// ------------------------------------------------

$tableParams = [];
$tableParams['caption'] = "C14 Catalog";
$tableParams['columnNames'] = "labIDnr,Name,14C age,14C err,Marine curve,ChanAge,GWL,LDEM,MSL,VegHis,Landsub,Compaction";
$tableParams['preview'] = 20;
$tableParams['expanded'] = false;
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
    data-columnnames="'.$tableParams['columnNames'].'" 
    data-columnsortable="'.$tableParams['columnSortable'].'"
    data-preview="'.$tableParams['preview'].'" 
    data-href="'.$tableParams['href'].'" 
    data-totalrecords="'.$tableParams['totalrecords'].'" 
    data-limit="'.$limit.'" 
    data-offset="'.$offset.'" 
    data-add="'.$add.'"
	'.$tableParams['expanded'].'>
    <caption>'.$tableParams['caption'].'</caption>
</table>';

// ------------------------------------------------

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    echo $table;
} else {
    return $table;
}

// ------------------------------------------------

?>