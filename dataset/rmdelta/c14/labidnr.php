<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

//e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxMenu.css');
e107::css(url, '/e107_plugins/ajaxTemplates/beta/css/ajaxTemplates.css');
e107::css(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
e107::js(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js');

// --- [ SQL ] ------------------------------------
// ------------------------------------------------
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "rmdelta";
($_GET['releasecandidate'] == "true") ? $table = "c14_cat_rc" : $table = "c14_cat";
$columns = "*";
$where_0_identifier = "labidnr";
$where_0_value = $_GET[$where_0_identifier];
$limit = 1;
$offset = 0;
$query = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "where": { "0": { "identifier": "'.$where_0_identifier.'", "value": "'.$where_0_value.'" } } }, "2": { "limit": "'.$limit.'" }, "3": { "offset": "'.$offset.'" } }';

// --- [ JSON ] -----------------------------------
// ------------------------------------------------
if($_GET['format'] === 'json') {

    $_GET['db'] = json_encode($db);
    $_GET['query'] = $query;
    
    header('Content-Type: application/json');
    require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/beta/API.php");
    exit;
}

if(!$_GET[$where_0_identifier]) {

    require_once(HEADERF);

    $caption = "Something went wrong";
    $text = "Click <a href='index.php'>here</a> to return to the index";

    $mode = "C14labidnr";
    $return = false;
    $ns = e107::getRender();
    $ns->tablerender($caption, $text, $mode, $return);

    require_once(FOOTERF);
    exit;
}

require_once(HEADERF);
// --- [ JAVASCRIPT ] -----------------------------
// ------------------------------------------------
$script .= '
<script src="./labidnr.js" type="module">
</script>
';

// --- [ TEMPLATE ] -------------------------------
// ------------------------------------------------
$template = '
    <div class="container" 
        data-ajax="template" 
        data-url=\''.$url.'\'
        data-db=\''.$db.'\'
        data-table=\''.$table.'\'
        data-columns=\''.$columns.'\'
        data-query=\''.$query.'\'>

        <!-- Release candidate alerts -->
        <div class="row">
            <div id="releasecandidateAlertWarning" class="alert alert-warning alert-dismissible visually-hidden" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Attention!</strong> There is a Release Candidate for this entry. Please click <a href="#releasecandidate" class="alert-link" onclick="return false;">here</a> to view!
            </div>
            <div id="releasecandidateAlertDanger" class="alert alert-danger alert-dismissible visually-hidden" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Warning!</strong> This is the Release Candidate for this entry. Please click <a href="#releasecandidate" class="alert-link" onclick="return false;">here</a> to return to the released version!
            </div>
        </div>
        <!-- End of Release candidate alerts -->
        <br>
        <!-- Header -->
        <div class="row">
            <div class="col-xs-12 col-sm-9">
                <div class="btn-group">
                    <a href="index.php" type="button" class="btn btn-primary" id="C14index">☰</a>
                    <a class="btn btn-primary" href="?labidnr='.$_GET["labidnr"].'&format=json">
                        <span class="badge badge-light" data-variable="labidnr">LABIDNR</span> <span data-variable="samplename">SAMPLENAME</span>
                    </a>
                    <button type="submit" class="btn btn-primary" form="C14labidnr"><span class="fa fa-edit"></span></button>
                    <button type="submit" class="btn btn-primary" form="formC14labidnr"><span class="fa fa-list-alt"></span></button>
                    <form id="C14labidnr" action="labidnr.php" method="GET" target="_self">
                        <input type="hidden" name="labidnr" value="'.$_GET["labidnr"].'" />
                        <input type="hidden" name="action" value="edit" />
                    </form>
                    <form id="formC14labidnr" action="form.php" method="GET" target="_self">
                        <input type="hidden" name="labidnr" value="'.$_GET["labidnr"].'" />
                        <input type="hidden" name="action" value="update" />
                    </form>
                </div>
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
                            <td style="border:none;padding:1px;"> 14C <sup><span class="invisible" style="font-weight: bold; font-size:2em" data-variable="marinecurve2bused" contenteditable="false">marinecurve2bused</span></sup></td>
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
            <div class="col-12">
                <!-- Nav tabs -->
                <ul role="tablist" class="nav nav-tabs">
                    <li role="presentation" class="nav-item">
                        <a role="tab" class="nav-link active" id="sampledetails-tab" data-bs-toggle="tab" href="#sampledetails" aria-controls="sampledtails" aria-selected="true">Details</a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a role="tab" class="nav-link" id="sampleusage-tab" data-bs-toggle="tab" href="#sampleusage" aria-controls="sampleusage" aria-selected="false">In Use For</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade show active" id="sampledetails" aria-labelledby="sampledetails-tab">
                        <div class="row">
                            <div class="col-xs-12 col-md-8">
                                <div class="col-xs-3 text-right" style="margin-top:200px;">
                                    <b>X</b>
                                    <br>
                                    <div style="float:right;"><span data-variable="xco" contenteditable="false">xco</span></div>
                                    <br>
                                    <b>Long</b>
                                    <br>
                                    <div style="float:right;"><span id="long" data-variable="long" contenteditable="false">long</span></div>
                                </div>
                                <div class="col-xs-6 text-center">
                                    <b>Z-mv NAP <br>(Surface elevation)</b>
                                    <div><span data-variable="zco" contenteditable="false">zco</span></div>
                                    <img src="img/c14samplexyz.png" style="width:100%;">
                                </div>
                                <div class="col-xs-3 text-left" style="margin-top:200px;">
                                    <b>Y</b>
                                    <br>
                                    <div style="float:left;"><span data-variable="yco" contenteditable="false">yco</span></div>
                                    <br>
                                    <b>Lat</b>
                                    <br>
                                    <div style="float:left;"><span id="lat" data-variable="lat" contenteditable="false">lat</span></div>
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
                    <div role="tabpanel" class="tab-pane fade" id="sampleusage" aria-labelledby="sampleusage-tab">
                        <div class="accordion" id="accordion">

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#InUseForChannelAge" aria-expanded="true" aria-controls="InUseForChannelAge">
                                        <div class="circle pull-left"></div>
                                        Channel Age
                                    </button>
                                </h2>
                                <div id="InUseForChannelAge" class="accordion-collapse collapse show" aria-labbeledby="InUseForChannelAge" data-bs-parent="#accordion">
                                    <div class="invisible"><span data-variable="inuseforchannelage" contenteditable="false">inuseforchannelage</span></div>
                                    <div class="accordion-body">
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
                                                    <td><span data-variable="endscbnrs" contenteditable="false">endscbnrs</span></td>
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

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#InUseForGWTinterpol" aria-expanded="true" aria-controls="InUseForGWTinterpol">
                                        <div class="circle pull-left"></div>
                                        Groundwater Table Rise (Z-gw)
                                    </button>
                                </h2>
                                <div id="InUseForGWTinterpol" class="accordion-collapse collapse show" aria-labbeledby="InUseForGWTinterpol" data-bs-parent="#accordion">
                                    <div class="invisible"><span data-variable="inuseforgwtinterpol" contenteditable="false">inuseforgwtinterpol</span></div>
                                    <div class="accordion-body">
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
                                            <div id="InUseForLDEM" class="invisible"></div>
                                            <div class="invisible">
                                                <div class="col-md-1"><span data-variable="inuseforldem" contenteditable="false">inuseforldem</span></div>
                                                <div class="col-md-11 text-area" disabled>In use for LDEM</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#InUseForMSLrise" aria-expanded="true" aria-controls="InUseForMSLrise">
                                        <div class="circle pull-left"></div>
                                        Mean Sea Level Rise (Z-msl) 
                                    </button>
                                </h2>
                                <div id="InUseForMSLrise" class="accordion-collapse collapse show" aria-labbeledby="InUseForMSLrise" data-bs-parent="#accordion">
                                    <div class="invisible"><span data-variable="inuseformslrise" contenteditable="false">inuseformslrise</span></div>
                                    <div class="accordion-body">
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

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#InUseForVegetationHistory" aria-expanded="true" aria-controls="InUseForVegetationHistory">
                                        <div class="circle pull-left"></div>
                                        Vegetation History
                                    </button>
                                </h2>
                                <div id="InUseForVegetationHistory" class="panel-collapse collapse">
                                    <div class="invisible"><span data-variable="inuseforvegetationhistory" contenteditable="false">inuseforvegetationhistory</span></div>
                                    <div class="panel-body">
                                        <div class="col-md-12 text-area" disabled style="background-color: transparent"><span data-variable="vegetationhistorysourcereference" contenteditable="false">vegetationhistorysourcereference</span></div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#InUseForLandSubsidence" aria-expanded="true" aria-controls="InUseForLandSubsidence">
                                        <div class="circle pull-left"></div>
                                        Land Subsidence
                                    </button>
                                </h2>
                                <div id="InUseForLandSubsidence" class="accordion-collapse collapse show" aria-labbeledby="InUseForLandSubsidence" data-bs-parent="#accordion">
                                    <div class="invisible"><span data-variable="inuseforlandsubsidence" contenteditable="false">inuseforlandsubsidence</span></div>
                                    <div class="accordion-body">
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#InUseForCompactQuant" aria-expanded="true" aria-controls="InUseForCompactQuant">
                                        <div class="circle pull-left"></div>
                                        Compaction Quantification
                                    </button>
                                </h2>
                                <div id="InUseForCompactQuant" class="accordion-collapse collapse show" aria-labbeledby="InUseForCompactQuant" data-bs-parent="#accordion">
                                    <div class="invisible"><span data-variable="inuseforcompactquant" contenteditable="false">inuseforcompactquant</span></div>
                                    <div class="accordion-body">
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
            <div class="col-md-4">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="map" style="width: auto; height: 350px; background-color: #eeeeee; overflow: hidden;"></div>
                        <script src="/e107_plugins/leaflet/js/leaflet-bing-layer.js"></script>
                        <script src="/e107_plugins/leaflet/js/leaflet.js"></script>
                    </div>
                </div>

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
                                    <td><span data-variable="datedstratumislithostrat" contenteditable="false">datedstratumislithostrat</span></td>
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

            <div class="text-center">
                <button id="submitForm" type="submit" class="btn btn-primary btn-large" value="Submit form"><span class="glyphicon glyphicon-upload"></span> Submit</button>
            </div>
        </div>
        <!-- End of content -->
        <!-- Release candidate -->
        <div class="row">
            <div id="mws-properties" class="invisible">
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
if($_GET['action'] === 'edit') {
    // ToDo: Check if there is a release candidate...
    $edit = false;
    if (USER) {
        $userData = e107::user(USERID); // Example - currently logged in user.
        $userclassList = explode(",", $userData["user_class"]);
        $userclassID = 4;  // id from 'Wiki Editors' userclass
        if(!in_array($userclassID, $userclassList)) {
            require_once(HEADERF);
            $caption = "Error!";
            $text = "You must be part of the 'Wiki Editor' userclass to edit this page";
            $ns->tablerender($caption, $text);
            require_once(FOOTERF);
            exit;
        } else {
            $edit = true;
            $script .= '
            <script type="text/javascript" defer>
                (function() {
                    window.addEventListener("load", function(){
                        const Template = document.querySelectorAll("[data-page]");
                        const elementList = document.querySelectorAll("[contenteditable=\'false\']");
                        elementList.forEach((element) => {
                            element.contentEditable = "true";
                            element.parentElement.style.border = "1px solid red";
                            element.parentElement.style.margin = "-1px";
                            element.parentElement.style.minWidth = "1em";
                            element.parentElement.style.minHeight = "1em";
                        });
                    });
                })()
            </script>
            ';
        }
    } else {
        require_once(HEADERF);
        $caption = "Error!";
        $text = "You must login to edit this page";
        $ns->tablerender($caption, $text);
        require_once(FOOTERF);
        exit;
    }
}

// --- [ RENDER ] ---------------------------------
// ------------------------------------------------
$caption = '';
$text = $script.$template;
$mode = 'C14labidnr';
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);
// ------------------------------------------------
require_once(FOOTERF);
exit;
// ------------------------------------------------

?>