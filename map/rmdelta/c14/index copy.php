<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../../class2.php");

e107::css(url, '/e107_plugins/ajaxDBQuery/css/ajaxMaps.css');
e107::css(url, '/e107_plugins/ajaxDBQuery/css/ajaxTables.css');
e107::css(url, '/e107_plugins/ajaxDBQuery/css/ajaxTemplates.css');

e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css');
e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/MarkerCluster.css');
//e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/MarkerCluster.Default.css');
e107::css(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css');

e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js');
e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/leaflet.markercluster.js');
e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.heat/0.2.0/leaflet-heat.js');
e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js');

e107::js(url, 'https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.2/proj4.js');

require_once(HEADERF);

// ------------------------------------------------

require_once(e_PLUGIN."/ajaxDBQuery/ajaxMap.php");
require_once(e_PLUGIN."/ajaxDBQuery/ajaxTable.php");
require_once(e_PLUGIN."/ajaxDBQuery/ajaxTemplate.php");

// ------------------------------------------------
$script = '
<script src="./index.js" type="module" defer>
</script>

<script src="/e107_plugins/proj4js-2.7.2/dist/proj4.js">
</script>

<script type="text/javascript">
function boreholeURL(event) {
    if(event.target.textContent !== "borehole") {
        window.open("/LLG/IT/borehole.php?borehole="+event.target.textContent, "_blank");
    }
}
</script>
';
// ------------------------------------------------
$page = '
<br>
<div class="row row-no-gutters">
	<div class="col-md-4">
        <div class="square">
            <div class="leaflet map content"
                data-ajax="map"
                data-master="true"
                data-lat="52.05"
                data-lng="5.45"
                data-zoom="7"
                data-url="//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/ajaxDBQuery.php"
                data-db="rmdelta"
                data-table="c14_geom"
                data-columns="c14_geom.labidnr,c14_geom.longitude,c14_geom.latitude,c14_geom.xy,c14_geom.geom,xco,yco,c14age"
                data-inner_join="c14_cat ON c14_geom.labidnr = c14_cat.labidnr"
                data-where="c14_geom.longitude BETWEEN :xmin AND :xmax AND c14_geom.latitude BETWEEN :ymin AND :ymax"
                data-order_by="c14_geom.geom <-> \'SRID=4326;POINT(:lng :lat)\'::geometry, c14_geom.labidnr"
                data-direction=""
                data-page=""
                data-overlaymaps=\'{"Samples": "samples"}\'
                data-limit="1000"
                data-zoomlevel="13">
            </div>

        </div>
';

// ------------------------------------------------
// SLAVE TABLE
// Need to be bound to a layer
// sqlParams['table'] must match at least one of the data-table of the maplayers
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/ajaxDBQuery.php";
$sqlParams['db'] = "rmdelta";
$sqlParams['table'] = "c14_cat";
$sqlParams['columns'] = "labidnr,xco,yco,c14age";
$sqlParams['inner_join'] = null;
$sqlParams['where'] = null;
$sqlParams['order_by'] = null;
$sqlParams['direction'] = null;
$sqlParams['offset'] = null;
$sqlParams['limit'] = null;
$tableParams = [];
$tableParams['caption'] = "";
$tableParams['slave'] = true;
$tableParams['master'] = "Maps[0]";
$tableParams['columnNames'] = "labidnr,xco,yco,c14age";
$tableParams['columnSortable'] = false;
$tableParams['href'] = false;
$tableParams['events'] = "mouseover,mouseout,mousedown,mouseup,click";
$tableParams['preview'] = false;
$tableParams['expanded'] = true;
$tableParams['totalrecords'] = false;
$tableParams['add'] = false;

$table = '
        <div class="row">
            <div class="col-xs-12">
                <div class="table-scrollable" style="overflow-y: auto; max-height: 320px;">
                    <div class="mapinfo" style="height:200px;text-align:center;">
                        <br>
                        <p><strong>Zoom to area of interest to show boreholes</strong></p>
                    </div>
                    <table style="font-size:12px;" class="table table-hover hidden-xs" 
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
                        data-page="'.$sqlParams['offset'].'" 
                        data-limit="'.$sqlParams['limit'].'" 
                        data-columnnames="'.$tableParams['columnNames'].'" 
                        data-columnsortable="'.$tableParams['columnSortable'].'"
                        data-href="'.$tableParams['href'].'"
                        data-events="'.$tableParams['events'].'"
                        data-preview="'.$tableParams['preview'].'" 
                        data-totalrecords="'.$tableParams['totalrecords'].'" 
                        data-add="'.$tableParams['add'].'" '.$aria_expanded.'>
                    </table>
                </div>
            </div>
        </div>';

// ------------------------------------------------        
$page .= $table;

$page .='
	</div>
	<div class="col-md-8">';
// ------------------------------------------------
// DETAILS TEMPLATE
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/ajaxDBQuery.php";
$sqlParams['db'] = "rmdelta";
$sqlParams['table'] = "c14_cat";
$sqlParams['columns'] = "*";
$sqlParams['where'] = "labidnr=':uid'";
$sqlParams['order_by'] = "";
$sqlParams['direction'] = "";
$sqlParams['offset'] = null;
$sqlParams['limit'] = null;

// ------------------------------------------------
$template = '<div data-ajax="template"
				data-slave="0"
				data-master="Maps[0]"
				data-url="'.$sqlParams['url'].'" 
				data-db="'.$sqlParams['db'].'" 
				data-table="'.$sqlParams['table'].'" 
				data-columns="'.$sqlParams['columns'].'" 
				data-where="'.$sqlParams['where'].'" 
				data-order_by="'.$sqlParams['order_by'].'" 
				data-direction="'.$sqlParams['direction'].'" 
				data-page="'.$sqlParams['offset'].'" 
				data-limit="'.$sqlParams['limit'].'">
                <!-- Release candidate alerts -->
                <div class="row">
                    <div id="releasecandidateAlertWarning" class="alert alert-warning alert-dismissible hidden" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Attention!</strong> There is a Release Candidate for this entry. Please click <a href="#releasecandidate" class="alert-link" onclick="return false;">here</a> to view!
                    </div>
                    <div id="releasecandidateAlertDanger" class="alert alert-danger alert-dismissible hidden" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Warning!</strong> This is the Release Candidate for this entry. Please click <a href="#releasecandidate" class="alert-link" onclick="return false;">here</a> to return to the released version!
                    </div>
                </div>
                <!-- End of Release candidate alerts -->
                <br>
                <!-- Header -->
                <div class="row">
                    <div class="col-xs-12 col-sm-9">
                        <a href="index.php" type="button" class="btn btn-primary" id="C14index">☰</a>
                        <a class="btn btn-primary" href="?labidnr='.$_GET["labidnr"].'&format=json">
                            <span class="badge badge-light" data-variable="labidnr">LABIDNR</span> <span data-variable="samplename">SAMPLENAME</span>
                        </a>
                        <button type="submit" class="btn btn-primary" form="C14labidnr"><span class="glyphicon glyphicon-edit"></span></button>
                        <form id="C14labidnr" action="labidnr.php" method="GET" target="_self">
                            <input type="hidden" name="labidnr" value="'.$_GET["labidnr"].'" />
                            <input type="hidden" name="action" value="edit" />
                        </form>
                    </div>
                    <div class="col-xs-12 col-sm-3 text-right">
                        <button type="button" class="btn btn-secondary btn-md" style="pointer-events: none"><span data-variable="boreholenr" contenteditable="false">boreholenr</span><span class="badge badge-light" style="margin-left: 0.5em" data-variable="boreholedb" contenteditable="false">boreholedb</span>
                        </button>
                    </div>    
                </div>
                <br>
                <div class="row" style="min-height:135px">
                    <div class="col-md-2">
                        <div class="table-responsive" style="background-color:#f0f8ff;height:100%;">
                            <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th colspan="2" style="border-bottom: 0px;"><h4 class="text-center" style="font-weight: bold">Age</h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-right" style="border:none;padding:1px;"><span data-variable="c14age" contenteditable="false">c14age</span></td>
                                    <td style="border:none;padding:1px;"> 14C <sup><span class="hidden" style="font-weight: bold; font-size:2em" data-variable="marinecurve2bused" contenteditable="false">marinecurve2bused</span></sup></td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="border:none;padding:1px;">± <span data-variable="c14err" contenteditable="false">c14err</span>
                                    </td>
                                    <td style="border:none;padding:1px;"> 1σ</td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="border:none;padding:1px;">
                                        <span data-variable="delta13c" contenteditable="false">delta13c</span>
                                    </td>
                                    <td style="border:none;padding:1px;"> δ13C</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6" style="border-left-style: solid;border-left-width: thin;border-right-style: solid;border-right-width: thin;height: 100%;">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td style="border:none">Material</td>
                                        <td style="border:none;font-weight: bold"><span data-variable="sampledmaterial" contenteditable="false">sampledmaterial</span></td>
                                    </tr>
                                    <tr>
                                        <td style="border:none">Significance</td>
                                        <td style="border:none;font-weight: bold"><span data-variable="significance" contenteditable="false">significance</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding-left:0">
                            <div class="pull-right">Added: <strong><span data-variable="yearadded" contenteditable="false">yearadded</span></strong></div>
                            <br>
                            <div class="pull-right"><strong><span data-variable="biblioreferences" contenteditable="false">biblioreferences</span></strong></div>
                    </div>
                </div>
                <!-- End of header -->
                <br>
                <br>
                <!-- Content -->
                <div class="row">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#sampledetails" class="tab-toggle" data-toggle="tab">Details</a>
                        </li>
                        <li>
                            <a href="#sampleusage" class="tab-toggle" data-toggle="tab">In Use For</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="sampledetails" role="tabpanel" aria-labelledby="details-tab">
                                <div class="row">
                                    <div class="col-xs-12 col-md-8">
                                        <div class="col-xs-3 text-right" style="margin-top:200px;">
                                            <b>X</b>
                                            <div><span data-variable="xco" contenteditable="false">xco</span></div>
                                            <b>Long</b>
                                            <div><span id="long" data-variable="long" contenteditable="false">long</span></div>
                                        </div>
                                        <div class="col-xs-6 text-center">
                                            <b>Z-mv NAP <br>(Surface elevation)</b>
                                            <div><span data-variable="zco" contenteditable="false">zco</span></div>
                                            <img src="img/c14samplexyz.png" style="width:100%;">
                                        </div>
                                        <div class="col-xs-3 text-left" style="margin-top:200px;">
                                            <b>Y</b>
                                            <div><span data-variable="yco" contenteditable="false">yco</span></div>
                                            <b>Lat</b>
                                            <div id="lat" data-variable="lat" contenteditable="false">lat</span></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <p><b>Sitetype:</b></p>
                                                <img id="sitetype-icon" src="img/sitetype_unknown.png" style="width:60%;">
                                                <br>
                                                <span data-variable="sitetype" contenteditable="false">sitetype</span>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="row">
                                            <div id="sampleMV" class="col-sm-6 col-md-12">
                                                <p><b>Z (sample depth surface):</b></p>
                                                <div class="col-xs-4">
                                                    <img src="img/c14samplemv.png" style="width:100%;">
                                                </div>
                                                <div class="col-xs-8">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">Top:</div>
                                                        <div class="col-xs-8 text-right"><span data-variable="topsamplemv" contenteditable="false">topsamplemv</span></div>
                                                        <div class="col-xs-4">Bottom:</div>
                                                        <div class="col-xs-8 text-right"><span data-variable="bottomsamplemv" contenteditable="false">bottomsamplemv</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="sampleNAP" class="col-sm-6 col-md-12">
                                                <p><b>Z (sample depth NAP):</b></p>
                                                <div class="col-xs-4">
                                                    <img src="img/c14samplenap.png" style="width:100%;"></div>
                                                <div class="col-xs-8">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">Top:</div>
                                                        <div class="col-xs-8 text-right"><span data-variable="topsamplenap" contenteditable="false">topsamplenap</span></div>
                                                        <div class="col-xs-4">Bottom:</div>
                                                        <div class="col-xs-8 text-right"><span data-variable="bottomsamplenap" contenteditable="false">bottomsamplenap</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- tab -->
                            <div class="tab-pane fade" id="sampleusage" role="tabpanel" aria-labelledby="usage-tab">
                                <div class="panel-group" id="accordion">

                                    <div class="panel panel-default">
                                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#InUseForChannelAge">
                                            <h3 class="panel-title">
                                                <div class="circle pull-left"></div>
                                                Channel Age
                                            </h3>
                                        </div>
                                        <div id="InUseForChannelAge" class="panel-collapse collapse in">
                                            <div class="hidden"><span data-variable="inuseforchannelage" contenteditable="false">inuseforchannelage</span></div>
                                            <div class="panel-body">
                                                <table class="table table-condensed">
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>Relates to Channel Belt IDs</strong></td>
                                                            <td><span data-variable="relatestocbs" contenteditable="false">relatestocbs</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Location typology</strong></td>
                                                            <td><span data-variable="cb_datingtype" contenteditable="false">cb_datingtype</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Abandonment age meaning?</strong></td>
                                                            <td><span data-variable="isendage" contenteditable="false">isendage</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>For Channel Belt ID(s)</strong></td>
                                                            <td><span data-variable="endscbnrs contenteditable="false">endscbnrs</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Beginning age meaning?</strong></td>
                                                            <td><span data-variable="isbeginage" contenteditable="false">isbeginage</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>For Channel Belt ID(s)</strong></td>
                                                            <td><span data-variable="begincbnrs" contenteditable="false">begincbnrs</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Channel-belt activity meaning?</strong></td>
                                                            <td><span data-variable="isactivitydate" contenteditable="false">isactivitydate</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>For Channel Belt ID(s)</strong></td>
                                                            <td><span data-variable="activecbnr" contenteditable="false">activecbnr</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-md-12 text-area" disabled style="background-color: transparent"><span data-variable="channelagesourcereference" contenteditable="false">channelagesourcereference</span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#InUseForGWTinterpol">
                                            <h4 class="panel-title">
                                                <div class="circle pull-left"></div>
                                                Groundwater Table Rise (Z-gw)
                                            </h4>
                                        </div>
                                        <div id="InUseForGWTinterpol" class="panel-collapse collapse">
                                            <div class="hidden"><span data-variable="inuseforgwtinterpol" contenteditable="false">inuseforgwtinterpol</span></div>
                                            <div class="panel-body">
                                                <div class="col-md-12">
                                                    <table class="table table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th>Upper limit (m NAP)</th>
                                                                <th>Lower limit (m NAP)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><span data-variable="gw_z_upper" contenteditable="false">gw_z_upper</span></td>
                                                                <td><span data-variable="gw_z_lower" contenteditable="false">gw_z_lower</span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12 text-area" disabled style="background-color: transparent"><span data-variable="gwsourcereference" contenteditable="false">gwsourcereference</span></div>
                                                <br>
                                                <div class="row">
                                                    <div id="InUseForLDEM" class="hidden"></div>
                                                    <div class="hidden">
                                                        <div class="col-md-1" style="color:green;font-size: 3rem"><span data-variable="inuseforldem" contenteditable="false">inuseforldem</span></div>
                                                        <div class="col-md-11 text-area" disabled style="background-color: transparent;margin-left:-5em;margin-top:1.5rem">In use for LDEM</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#InUseForMSLrise">
                                            <h4 class="panel-title">
                                                <div class="circle pull-left"></div>
                                                Mean Sea Level Rise (Z-msl)
                                            </h4>
                                        </div>
                                        <div id="InUseForMSLrise" class="panel-collapse collapse">
                                            <div class="hidden"><span data-variable="inuseformslrise" contenteditable="false">inuseformslrise</span></div>
                                            <div class="panel-body">
                                                <div class="col-md-12">
                                                    <table class="table table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th>Upper limit (m NAP)</th>
                                                                <th>Lower limit (m NAP)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><span data-variable="msl_z_upper" contenteditable="false">msl_z_upper</span></td>
                                                                <td><span data-variable="msl_z_lower" contenteditable="false">msl_z_lower</span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12 text-area" disabled style="background-color: transparent"><span data-variable="mslsourcereference" contenteditable="false">mslsourcereference</span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#InUseForVegetationHistory">
                                            <h4 class="panel-title">
                                                <div class="circle pull-left"></div>
                                                Vegetation History
                                            </h4>
                                        </div>
                                        <div id="InUseForVegetationHistory" class="panel-collapse collapse">
                                            <div class="hidden"><span data-variable="inuseforvegetationhistory" contenteditable="false">inuseforvegetationhistory</span></div>
                                            <div class="panel-body">
                                                <div class="col-md-12 text-area" disabled style="background-color: transparent"><span data-variable="vegetationhistorysourcereference" contenteditable="false">vegetationhistorysourcereference</span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#InUseForLandSubsidence">
                                            <h4 class="panel-title">
                                                <div class="circle pull-left"></div>
                                                Land Subsidence
                                            </h4>
                                        </div>
                                        <div id="InUseForLandSubsidence" class="panel-collapse collapse">
                                            <div class="hidden"><span data-variable="inuseforlandsubsidence" contenteditable="false">inuseforlandsubsidence</span></div>
                                            <div class="panel-body">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#InUseForCompactQuant">
                                            <h4 class="panel-title">
                                                <div class="circle pull-left"></div>
                                                Compaction Quantification
                                            </h4>
                                        </div>
                                        <div id="InUseForCompactQuant" class="panel-collapse collapse">
                                            <div class="hidden"><span data-variable="inuseforcompactquant" contenteditable="false">inuseforcompactquant</span></div>
                                            <div class="panel-body">
                                                <div class="col-md-12">
                                                    <table class="table table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th>Compaction displacement μ (m)</th>
                                                                <th>Compaction displacement σ (m)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><span data-variable="compactiondisplacement" contenteditable="false">compactiondisplacement</span></td>
                                                                <td><span data-variable="compactiondisplacementerr" contenteditable="false">compactiondisplacementerr</span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    </div>
                                                <div class="col-md-12 text-area" disabled style="background-color: transparent"><span data-variable="compactionstudysourcereference" contenteditable="false">compactionstudysourcereference</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-4">

                        <!--
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div id="map" style="width: auto; height: 350px; background-color: #eeeeee; overflow: hidden;"></div>
                                <script src="/e107_plugins/leaflet/js/leaflet-bing-layer.js"></script>
                                <script src="/e107_plugins/leaflet/js/leaflet.js"></script>
                            </div>
                        </div>
                        -->

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 class="panel-title">Dated material</h1>
                            </div>
                            <div class="panel-body">
                                <span data-variable="sampledmaterial" contenteditable="false">sampledmaterial</span>
                                <span data-variable="sampledmaterialdetail" contenteditable="false">sampledmaterialdetail</span>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 class="panel-title">Dated stratum details</h1>
                            </div>
                            <div class="panel-body">
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <td>Underlies (lithostrat)</td>
                                            <td><span data-variable="datedstratumunderlieslithostrat" contenteditable="false">datedstratumunderlieslithostrat</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Lithology</strong></td>
                                            <td><span data-variable="datedstratumlithology" contenteditable="false">datedstratumlithology</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Lithostrat</strong></td>
                                            <td><span data-variale="datedstratumislithostrat" contenteditable="false">datedstratumislithostrat</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>top/mid/base</strong></td>
                                            <td><span data-variable="instratumtopmidbase" contenteditable="false">instratumtopmidbase</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Waterdepth tendency</strong></td>
                                            <td><span data-variable="stratumwaterdepthtrend" contenteditable="false">stratumwaterdepthtrend</span></td>
                                        </tr>
                                        <tr>
                                            <td>Overlies (lithostrat)</td>
                                            <td><span data-variable="datedstratumoverlieslithostrat" contenteditable="false">datedstratumoverlieslithostrat</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-area" disabled style="background-color: transparent"><span data-variable="stratarelationremark" contenteditable="false">stratarelationremark</span></div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 class="panel-title">Further facies codes (legacy contents, partially obsolete)</h1>
                            </div>
                            <div class="panel-body">
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <td>Lithofacies</td>
                                            <td><span data-variable="facies" contenteditable="false">facies</span></td>
                                        </tr>
                                        <tr>
                                            <td>Facies code</td>
                                            <td><span data-variable="faciescode" contenteditable="false">faciescode</span></td>
                                        </tr>
                                        <tr>
                                            <td>Seq position</td>
                                            <td><span data-variable="seqposition" contenteditable="false">seqposition</span></td>
                                        </tr>
                                        <tr>
                                            <td>Peat on Sand (Y/N)</td>
                                            <td><span data-variable="ispeatonsand" contenteditable="false">ispeatonsand</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>                
                    </div>
                </div>
                <!-- End of content -->
                <!-- Release candidate -->
                <div class="row">
                    <div id="mws-properties" class="hidden">
                        <div id="rc-releasecandidate">true</div>
                        <div id="rc-labidnr">AA-37253</div>
                        <div id="rc-samplename"></div>
                        <div id="rc-yearadded">2010</div>
                        <div id="rc-marinecurve2bused"></div>
                        <div id="rc-c14age"></div>
                        <div id="rc-c14err"></div>
                        <div id="rc-delta13c"></div>
                        <div id="rc-significance"></div>
                        <div id="rc-xco"></div>
                        <div id="rc-yco"></div>
                        <div id="rc-zco"></div>
                        <div id="rc-lat"></div>
                        <div id="rc-long"></div>
                        <div id="rc-topsamplemv"></div>
                        <div id="rc-bottomsamplemv"></div>
                        <div id="rc-topsamplenap"></div>
                        <div id="rc-bottomsamplenap"></div>
                        <div id="rc-sitetype"></div>
                        <div id="rc-biblioreferences"></div>
                        <div id="rc-boreholedb"></div>
                        <div id="rc-boreholenr"></div>
                        <div id="rc-sampledmaterial"></div>
                        <div id="rc-sampledmaterialdetail"></div>
                        <div id="rc-datedstratumlithology"></div>
                        <div id="rc-instratumtopmidbase"></div>
                        <div id="rc-stratumwaterdepthtrend"></div>
                        <div id="rc-datedstratumoverlieslithostrat"></div>
                        <div id="rc-datedstratumislithostrat"></div>
                        <div id="rc-datedstratumunderlieslithostrat"></div>
                        <div id="rc-stratarelationremark"></div>
                        <div id="rc-facies"></div>
                        <div id="rc-faciescode"></div>
                        <div id="rc-seqposition"></div>
                        <div id="rc-ispeatonsand"></div>
                        <div id="rc-inuseforchannelage"></div>
                        <div id="rc-channelagesourcereference"></div>
                        <div id="rc-relatestocbs"></div>
                        <div id="rc-cb_datingtype"></div>
                        <div id="rc-isendage"></div>
                        <div id="rc-endscbnrs"></div>
                        <div id="rc-isbeginage"></div>
                        <div id="rc-beginscbnrs"></div>
                        <div id="rc-isactivitydate"></div>
                        <div id="rc-activecbnr"></div>
                        <div id="rc-inuseforgwtinterpol"></div>
                        <div id="rc-gw_z_upper"></div>
                        <div id="rc-gw_z_lower"></div>
                        <div id="rc-gwsourcereference"></div>
                        <div id="rc-inuseforldem"></div>
                        <div id="rc-inuseformslrise"></div>
                        <div id="rc-msl_z_upper"></div>
                        <div id="rc-msl_z_lower"></div>
                        <div id="rc-mslsourcereference"></div>
                        <div id="rc-inuseforvegetationhistory"></div>
                        <div id="rc-vegetationhistorysourcereference"></div>
                        <div id="rc-inuseforcompactquant"></div>
                        <div id="rc-compactiondisplacement"></div>
                        <div id="rc-compactiondisplacementerr"></div>
                        <div id="rc-compactionstudysourcereference"></div>
                        <div id="rc-inuseforlandsubsidence"></div>
                    </div>
                </div>
                <!-- End of release candidate -->
            </div>';

// ------------------------------------------------
/*
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/ajaxDBQuery.php";
$sqlParams['db'] = "llg";
$sqlParams['table'] = "llg_it_boreholedata";
$sqlParams['columns'] = "startdepth,depth,texture,organicmatter,plantremains,color,oxired,gravelcontent,median,calcium,ferro,groundwater,sample,soillayer,stratigraphy,remarks";
$sqlParams['where'] = "borehole=''";
$sqlParams['order_by'] = "startdepth";
$sqlParams['direction'] = "ASC";
$sqlParams['offset'] = null;
$sqlParams['limit'] = null;
$tableParams = [];
$tableParams['slave'] = true;
$tableParams['master'] = "Templates[0]";
$tableParams['columnNames'] = "Top,Depth,Texture,Org,Plr,Color,RedOx,Gravel,M50,Ca,Fe,GW,Sample,Paleosoil,Strat,Remarks";
$tableParams['columnSortable'] = false;
$tableParams['preview'] = false;
$tableParams['expanded'] = true;
$tableParams['href'] = false;
$tableParams['events'] = ["mouseover", "mouseout", "mousedown", "mouseup", "click"];
$rowParams = [];
$rowParams['href'] = false;
$rowParams['mouseover'] = true;
$rowParams['mouseout'] = true;
$rowParams['click'] = true;
$rowParams['add'] = false;
$cellParams = [];

$table = '
        <div class="table-scrollable" style="overflow-y: auto; overflow-x: hidden; height: 408px;">
            <table style="font-size:12px;" class="table table-hover" 
                data-ajax="table"
                data-type="relational"
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
                data-page="'.$sqlParams['offset'].'" 
                data-limit="'.$sqlParams['limit'].'" 
                data-columnnames="'.$tableParams['columnNames'].'" 
                data-columnsortable="'.$tableParams['columnSortable'].'"
                data-preview="'.$tableParams['preview'].'" 
                data-href="'.$tableParams['href'].'" 
                data-events="'.$tableParams['events'].'"
                data-add="'.$tableParams['add'].'" '.$aria_expanded.'>
            </table>
        </div>';

// ------------------------------------------------
$page .= $template.$table;
$page .= '
	</div>
</div>
';
*/
$page .= $template;
$text = $script.$page;
// ------------------------------------------------
$mode = "Map";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------

require_once(FOOTERF);

?>