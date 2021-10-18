<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

e107::css(url, '/e107_plugins/ajaxTemplates/css/ajaxMaps.css');
e107::css(url, '/e107_plugins/ajaxTemplates/css/ajaxTables.css');
e107::css(url, '/e107_plugins/ajaxTemplates/css/ajaxTemplates.css');

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
$script = '
<script src="./index.js" type="module" defer>
</script>

<script src="/e107_plugins/proj4js-2.7.2/dist/proj4.js">
</script>
<!--
<script type="text/javascript">
function boreholeURL(event) {
    if(event.target.textContent !== "borehole") {
        window.open("/LLG/IT/borehole.php?borehole="+event.target.textContent, "_blank");
    }
}
</script>
-->
';
// ------------------------------------------------
$page = '
<br>
<div class="row">
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
                data-columns="c14_geom.labidnr,c14_geom.longitude,c14_geom.latitude,c14_geom.xy,c14_geom.geom,samplename,c14age,xco,yco,bottomsamplemv,bottomsamplenap"
                data-inner_join="c14_cat ON c14_geom.labidnr = c14_cat.labidnr"
                data-where="c14_geom.longitude BETWEEN :xmin AND :xmax AND c14_geom.latitude BETWEEN :ymin AND :ymax"
                data-order_by="c14_geom.geom <-> \'SRID=4326;POINT(:lng :lat)\'::geometry, c14_geom.labidnr"
                data-direction=""
                data-page=""
                data-overlaymaps=\'{"Samples": "samples"}\'
                data-limit="500"
                data-zoomlevel="10">
            </div>
        </div>
';

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
                    <div class="col-xs-12">
                        <button class="btn btn-primary" style="pointer-events: none">
                            <span class="badge badge-light" data-variable="labidnr">LABIDNR</span> <span data-variable="samplename">SAMPLENAME</span>
                        </button>
                        <button type="submit" class="btn btn-primary" form="C14labidnr"><span class="glyphicon glyphicon-new-window"></span></button>
                    </div>
                </div>
                <!-- End of header -->
                <br>
                <!-- Content -->
                <div class="row">
                    <div class="col-md-12">
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
                                </div>
                                <br>
                                <!--
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <p><b>Sitetype:</b></p>
                                        <img id="sitetype-icon" src="img/sitetype_unknown.png" style="width:60%;">
                                        <br>
                                        <span data-variable="sitetype" contenteditable="false">sitetype</span>
                                    </div>
                                </div>
                                -->
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
                </div>
                <!-- End of content -->
            </div>
            <script>
                (function () {
                    document.addEventListener(\'DOMContentLoaded\', () => {
                            document.querySelectorAll("button[form=\'C14labidnr\']")[0].onclick = () => {
                                if(document.querySelectorAll("span[data-variable=\'labidnr\']")[0].innerText != "LABIDNR") {
                                    window.open("/RijnMaasDelta/C14catalog/labidnr.php?labidnr="+document.querySelectorAll("span[data-variable=\'labidnr\']")[0].innerText, "_blank");
                                }
                            };
                    })
                })();
            </script>
            <!-- End of Template -->';
$page .= $template;
$page .='
	</div>
	<div class="col-md-8">';

// ------------------------------------------------
// SLAVE TABLE
// Need to be bound to a layer
// sqlParams['table'] must match at least one of the data-table of the maplayers
$sqlParams = [];
$sqlParams['url'] = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/ajaxDBQuery.php";
$sqlParams['db'] = "rmdelta";
$sqlParams['table'] = "c14_cat";
$sqlParams['columns'] = "labidnr,samplename,c14age,xco,yco,bottomsamplemv,bottomsamplenap";
$sqlParams['inner_join'] = null;
$sqlParams['where'] = null;
$sqlParams['order_by'] = null;
$sqlParams['direction'] = null;
$sqlParams['offset'] = null;
$sqlParams['limit'] = null;
$tableParams = [];
$tableParams['caption'] = "C14 Catalog";
$tableParams['slave'] = true;
$tableParams['master'] = "Maps[0]";
$tableParams['columnNames'] = "labidnr,samplename,c14age,xco,yco,bottomsamplemv,bottomsamplenap";
$tableParams['columnSortable'] = false;
$tableParams['href'] = false;
$tableParams['events'] = "mouseover,mouseout,mousedown,mouseup,click";
$tableParams['preview'] = false;
$tableParams['expanded'] = true;
$tableParams['totalrecords'] = false;
$tableParams['add'] = false;

$table = '      <div class="table-scrollable" style="overflow-y: auto; max-height: 620px; margin-top: 0;">
                    <div class="mapinfo" style="height:200px;text-align:center;">
                        <br>
                        <p><strong>Zoom to area of interest to show 14c sample locations</strong></p>
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
                        <caption style="margin: 0;">'.$tableParams['caption'].'</caption>  
                    </table>
                </div>';
$page .= $table;
$page .= '</div>';
// ------------------------------------------------        
$text = $script.$page;
// ------------------------------------------------
$mode = "Map";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------

require_once(FOOTERF);

?>