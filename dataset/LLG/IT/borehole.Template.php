<?php

// ------------------------------------------------

$templateParams = [];
$templateParams['parent'] = "";

$iframe = function() {
    if(strpos(parse_url($_SERVER['HTTP_REFERER'])['path'], '/beta/map/') === 0) {
        return true;
    }
};

// ------------------------------------------------

$template = '
<div class="container"
    data-ajax="template"
    data-url=\''.$template_url.'\'
    data-db=\''.$template_db.'\'
    data-table=\''.$template_table.'\'
    data-columns=\''.$template_columns.'\'
    data-query=\''.$template_query.'\'>

    <div class="card">
        <div class="card-header" style="color:rgb(0,0,0);background-color:rgb(255,205,0);">
            <div class="container-fluid p-0">
                <div class="pull-left">
                    <strong><span>Borehole: </span><span data-variable="borehole" contenteditable="false">borehole</span></strong>
                    <br>
                    <span>
                        <strong>Logged by: </strong>
                    </span>
                    <span data-variable="name" contenteditable="false">name</span>
                    <span>
                        <strong> on </strong>
                    </span>
                    <span data-variable="drilldate" v-dateformat="yyyy-mm-dd" contenteditable="false">drilldate</span>
                </div>';

if(!$iframe()) {
$template .= '
                <div class="btn-group btn-group-sm position-absolute top-0 end-0" role="group" aria-label="">
                    <a href="index.php" type="button" class="btn btn-primary" id="returnIndex">☰</a>
                    <a class="btn btn-primary" href="borehole.php?borehole='.$template_where_0_value.'&amp;format=json">
                        <span>{...}</span>
                    </a>
                    <form id="LLGborehole" action="borehole.php" method="GET" target="_self">
                        <input type="hidden" name="borehole" value="'.$template_where_0_value.'" />
                        <input type="hidden" name="action" value="edit" />
                    </form>
                    <button type="submit" class="btn btn-primary" form="LLGborehole"><span class="fa fa-edit"></span></button>
                    <form id="formLLGborehole" action="form.php" method="GET" target="_self">
                        <input type="hidden" name="borehole" value="'.$template_where_0_value.'" />
                        <input type="hidden" name="action" value="edit" />
                    </form>
                    <button type="submit" class="btn btn-primary" form="formLLGborehole"><span class="fa fa-list-alt"></span></button>
                </div>';
}

$template .= '
                <br>
                <div class="pull-right me-5">
                    <label for="coordzone"><b>UTM Zone:</b></label>
                    <input list="coordzones" name="coordzone" data-variable="coordzone" value="coordzone" contenteditable="false" disabled>
                    <datalist id="coordzones">
                        <option value="RD">
                        <option value="option2">
                        <option value="option3">
                    </datalist>
                </div>   
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title pull-left">Coordinates</h5>
                    <div class="clearfix"></div>

                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>X</td>
                                    <td style="font-weight: bold"><input type="text" data-variable="xco" value="xco" disabled></td>
                                    <td>Y</td>
                                    <td style="font-weight: bold"><input type="text" data-variable="yco" value="yco" disabled></td>
                                </tr>
                                <tr>
                                    <td>Elevation (m)</td>
                                    <td style="font-weight: bold"><input type="text" data-variable="elevation" value="elevation" disabled></td>
                                    <td>Depth (cm)</td>
                                    <td style="font-weight: bold"><input type="text" data-variable="drilldepth" value="drilldepth" disabled></td>
                                </tr>                                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Classification</h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>Geom</td>
                                    <td style="font-weight: bold"><input type="text" data-variable="geom" value="geom" disabled></td>
                                    <td>Geol</td>
                                    <td style="font-weight: bold"><input type="text" data-variable="geol" value="geol" disabled></td>
                                </tr>
                                <tr>
                                    <td>Soil</td>
                                    <td style="font-weight: bold"><input type="text" data-variable="soil" value="soil" disabled></td>
                                    <td>Veget</td>
                                    <td style="font-weight: bold"><input type="text" data-variable="veget" value="veget" disabled></td>
                                </tr>
                                <tr>
                                    <td>GWT</td>
                                    <td style="font-weight: bold"><input type="text" data-variable="groundwaterstep" value="groundwaterstep" disabled></td>                                               
                                </tr>                                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <textarea style="width:100%" data-variable="extraremarks" contenteditable="false" disabled>extraremarks</textarea>
        </div>
    </div>
    
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