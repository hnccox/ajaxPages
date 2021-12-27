<?php

// ------------------------------------------------

$tableParams = [];
$tableParams['caption'] = "Yeargroup: {$_GET['yeargroup']}";
$tableParams['columnNames'] = "borehole,name,drilldate,xco,yco";
$tableParams['preview'] = null;
$tableParams['expanded'] = true;
$tableParams['href'] = true;
$tableParams['add'] = false;
if ($tableParams['expanded'] == true) { $tableParams['expanded'] = "aria-expanded"; }

// ------------------------------------------------

$table = '
	<table style="font-size:12px;" class="table table-hover table-ajax hidden-xs" 
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
		data-add="'.$tableParams['add'].'" '.$tableParams['expanded'].'>
		<caption>'.$tableParams['caption'].'</caption>
	</table>
';

// ------------------------------------------------

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    echo $table;
} else {
    return $table;
}

// ------------------------------------------------

?>