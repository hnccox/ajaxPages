<?php

// ------------------------------------------------

$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php";
$sqlParams['db'] = "llg";
$sqlParams['table'] = "llg_nl_boreholeheader";
$sqlParams['columns'] = "borehole,name,drilldate,xco,yco,coordzone,elevation,drilldepth,geom,geol,soil,veget,groundwaterstep,extraremarks";
$sqlParams['inner_join'] = "";
$sqlParams['where'] = "borehole=':uid'";
$sqlParams['order_by'] = "";
$sqlParams['direction'] = "";
$sqlParams['limit'] = null;
$sqlParams['offset'] = null;

// ------------------------------------------------

$templateParams = [];
$templateParams['parent'] = "";

// ------------------------------------------------

$template = '
<div data-ajax="template"
	data-slave="1"
	data-master="Maps[0]"
	data-url="'.$sqlParams['url'].'" 
	data-db="'.$sqlParams['db'].'" 
	data-table="'.$sqlParams['table'].'" 
	data-columns="'.$sqlParams['columns'].'" 
    data-inner_join="'.$sqlParams['inner_join'].'" 
	data-where="'.$sqlParams['where'].'" 
	data-order_by="'.$sqlParams['order_by'].'" 
	data-direction="'.$sqlParams['direction'].'" 
	data-limit="'.$sqlParams['limit'].'"
    data-offset="'.$sqlParams['offset'].'">
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
            <!--
            <div class="row">
                <div class="col-md-4 table-responsive" style="padding-top:14px">
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td style="border:none">Name</td>
                                <td style="border:none;font-weight: bold"><span data-variable="name" contenteditable="false">name</span></td>
                                <td style="border:none">Date</td>
                                <td style="border:none;font-weight: bold"><input type="date" data-variable="drilldate" value="" disabled></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            -->
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
    <!--
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
        </div>
    </div>
    -->
    
    <!--
    <span data-variable="xco" contenteditable="false">xco</span>
    <span data-variable="yco" contenteditable="false">yco</span>
    <span data-variable="coordzone" contenteditable="false">coordzone</span>
    <span data-variable="elevation" contenteditable="false">elevation</span>
    <span data-variable="drilldepth" contenteditable="false">drilldepth</span>
    <span data-variable="geom" contenteditable="false">geom</span>
    <span data-variable="geol" contenteditable="false">geol</span>
    <span data-variable="soil" contenteditable="false">soil</span>
    <span data-variable="veget" contenteditable="false">veget</span>
    <span data-variable="groundwaterstep" contenteditable="false">groundwaterstep</span>
    <span data-variable="extraremarks" contenteditable="false">extraremarks</span>
    -->
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