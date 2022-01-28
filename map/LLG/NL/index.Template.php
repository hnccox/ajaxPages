<?php

// ------------------------------------------------

$template_parent = "ajaxMaps[0]";
$template_url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$template_db = "llg";
$template_table = "llg_nl_boreholeheader";
$template_columns = "borehole,name,drilldate,xco,yco,coordzone,elevation,drilldepth,geom,geol,soil,veget,groundwaterstep,extraremarks";
$template_where_0_identifier = "borehole";
$template_where_0_value = ":uid";
$template_order_by_0_identifier = "borehole";
$template_order_by_0_direction = "DESC";
$template_query = '{ "0": { "select": { "columns": { "0": "'.$template_columns.'" }, "from": { "table": "'.$template_table.'" } } }, "1": { "where": { "0": { "identifier": "'.$template_where_0_identifier.'", "value": "'.$template_where_0_value.'" } } }, "2": { "order_by": { "0": { "identifier": "'.$template_order_by_0_identifier.'", "direction": "'.$template_order_by_0_direction.'" } } } }';
$template_limit = 1;
$template_offset = 0;

// ------------------------------------------------

$sqlParams = [];
$sqlParams['parent'] = $template_parent;
$sqlParams['url'] = $template_url;
$sqlParams['db'] = $template_db;
$sqlParams['table'] = $template_table;
$sqlParams['columns'] = $template_columns;
$sqlParams['query'] = $template_query;
$sqlParams['limit'] = $template_limit;
$sqlParams['offset'] = $template_offset;

// ------------------------------------------------

$templateParams = [];

// ------------------------------------------------

$template = '
<div class="'.$templateProps['class'].'" style="'.$templateProps['style'].'"
    data-ajax="template" 
    data-parent=\''.$sqlParams['parent'].'\'
    data-key=\'UU LLG_NL\'
    data-url=\''.$sqlParams['url'].'\' 
    data-db=\''.$sqlParams['db'].'\' 
    data-table=\''.$sqlParams['table'].'\'
    data-columns=\''.$sqlParams['columns'].'\'
    data-query=\''.$sqlParams['query'].'\'
    data-limit=\''.$sqlParams['limit'].'\'
    data-page=\''.$sqlParams['offset'].'\'
    data-caption=\''.$templateParams['caption'].'\'
    data-columnnames=\''.$templateParams['columnNames'].'\'
    data-columnsortable=\''.$templateParams['columnSortable'].'\'
    data-preview=\''.$templateParams['preview'].'\'
    data-href=\''.$templateParams['href'].'\'
    data-totalrecords=\''.$templateParams['totalrecords'].'\'
    data-add=\''.$templateParams['add'].'\'
    '.$templateParams['expanded'].'>
    <div class="panel panel-default">
        <div class="panel-heading" style="color:rgb(0,0,0);background-color:rgb(255,205,0);">
                <strong>
                    <span>Borehole: </span>
                    <span data-variable="borehole" contenteditable="false" style="cursor: pointer;" onclick="boreholeURL(event)">borehole</span>
                </strong>
            <span class="pull-right">
                <span>
                    <strong>Logged by: </strong>
                </span>
                <span data-variable="name" contenteditable="false">name</span>
                <span>
                    <strong> on </strong>
                </span>
                <span data-variable="drilldate" contenteditable="false">drilldate</span>
            </span>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <strong>Coordinates</strong>
                    <div class="table-responsive">
                        <table class="table table-condensed mb-0">
                            <tbody>
                                <tr>
                                    <td style="border:none">UTM Zone</td>
                                    <td style="border:none;font-weight: bold">
                                        <input list="coordzones" name="coordzone" data-variable="coordzone" value="coordzone" disabled>
                                        <datalist id="coordzones">
                                            <option value="Internet Explorer">
                                            <option value="Firefox">
                                            <option value="Chrome">
                                            <option value="Opera">
                                            <option value="Safari">
                                        </datalist>
                                    </td>                                                
                                </tr>
                                <tr>
                                    <td style="border:none">X</td>
                                    <td style="border:none;font-weight: bold"><input type="text" data-variable="xco" value="xco" disabled></td>
                                    <td style="border:none">Y</td>
                                    <td style="border:none;font-weight: bold"><input type="text" data-variable="yco" value="yco" disabled></td>
                                </tr>
                                <tr>
                                    <td style="border:none">Elevation (m)</td>
                                   <td style="border:none;font-weight: bold"><input type="text" data-variable="elevation" value="elevation" disabled></td>
                                    <td style="border:none">Depth (cm)</td>
                                    <td style="border:none;font-weight: bold"><input type="text" data-variable="drilldepth" value="drilldepth" disabled></td>
                                </tr>                                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <strong>Classification</strong>
                    <div class="table-responsive">
                        <table class="table table-condensed mb-0">
                            <tbody>
                                <tr>
                                    <td style="border:none">Geom</td>
                                    <td style="border:none;font-weight: bold"><input type="text" data-variable="geom" value="geom" disabled></td>
                                    <td style="border:none">Geol</td>
                                    <td style="border:none;font-weight: bold"><input type="text" data-variable="geol" value="geol" disabled></td>
                                </tr>
                                <tr>
                                    <td style="border:none">Soil</td>
                                    <td style="border:none;font-weight: bold"><input type="text" data-variable="soil" value="soil" disabled></td>
                                    <td style="border:none">Veget</td>
                                    <td style="border:none;font-weight: bold"><input type="text" data-variable="veget" value="veget" disabled></td>
                                </tr>
                                <tr>
                                    <td style="border:none">GWT</td>
                                    <td style="border:none;font-weight: bold"><input type="text" data-variable="groundwaterstep" value="groundwaterstep" disabled></td>                                               
                                </tr>                                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <textarea style="width:100%" data-variable="extraremarks" disabled>extraremarks</textarea>
        </div>
    </div>
</div>';

// ------------------------------------------------

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    echo $template;
}
else {
    return $template;
}

// ------------------------------------------------

?>