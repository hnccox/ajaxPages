<?php

// ------------------------------------------------

$tableParams = [];
$tableParams['parent'] = "Templates[0]";
$tableParams['columnNames'] = "Top,Depth,Texture,Org,Plr,Color,RedOx,Gravel,M50,Ca,Fe,GW,Sample,Paleosoil,Strat,Remarks";
$tableParams['columnSortable'] = false;
$tableParams['preview'] = false;
$tableParams['expanded'] = true;
$tableParams['href'] = false;
$tableParams['add'] = false;

// ------------------------------------------------

$table = '
<div class="table-scrollable" style="overflow-y: auto; overflow-x: hidden; height: 470px;">
    <table style="font-size:12px;" class="table table-hover table-ajax" 
        data-ajax="table"
        data-type="relational" 
        data-url=\''.$url.'\'
        data-db=\''.$db.'\'
        data-table=\''.$table.'\'
        data-columns=\''.$columns.'\'
        data-query=\''.$tablequery.'\'
        data-page="'.$sqlParams['offset'].'" 
        data-limit="'.$sqlParams['limit'].'" 
        data-columnnames="'.$tableParams['columnNames'].'" 
        data-columnsortable="'.$tableParams['columnSortable'].'"
        data-preview="'.$tableParams['preview'].'" 
        data-href="'.$tableParams['href'].'" 
        data-add="'.$tableParams['add'].'" '.$aria_expanded.'>
    </table>
</div>';

// ------------------------------------------------

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    echo $table;
} else {
    return $table;
}

// ------------------------------------------------

?>