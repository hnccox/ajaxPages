<?php

// ------------------------------------------------

$tableParams = [];
$tableParams['caption'] = "Dutch Pollen";
$tableParams['columnNames'] = "siteid,sitename,longitude,latitude";
$tableParams['preview'] = 3;
$tableParams['expanded'] = true;
$tableParams['href'] = true;
$tableParams['add'] = false;
if ($tableParams['expanded'] == true) { $tableParams['expanded'] = "aria-expanded"; }

// ------------------------------------------------

$table = '
<table style="font-size:12px;" class="table table-hover table-ajax hidden-xs" 
	data-ajax="table" 
    data-url=\''.$url.'\'
    data-columns=\''.$columns.'\'
    data-query=\''.$query.'\'
	data-columnnames="'.$tableParams['columnNames'].'" 
	data-columnsortable="'.$tableParams['columnSortable'].'"
	data-preview="'.$tableParams['preview'].'" 
	data-href="'.$tableParams['href'].'" 
	data-totalrecords="'.$tableParams['totalrecords'].'"
    data-limit="200"
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