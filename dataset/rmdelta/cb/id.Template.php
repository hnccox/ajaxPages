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
<div 
    data-ajax="template"
    data-url=\''.$template_url.'\'
    data-db=\''.$template_db.'\'
    data-table=\''.$template_table.'\'
    data-columns=\''.$template_columns.'\'
    data-query=\''.$template_query.'\'>

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
    <div class="col-md-6">
        <div class="row">
            <div class="btn-group" role="group" aria-label="">
                <a href="index.php" type="button" class="btn btn-primary" id="CBindex">☰</a>
                <a class="btn btn-primary" href="id.php?id='.$template_where_0_value.'&amp;format=json">
                    <span class="badge badge-light" data-variable="id">ID</span> <span data-variable="name">NAME</span>
                </a>
                <button type="submit" class="btn btn-primary" form="CBid"><span class="fa fa-edit"></span></button>
                <button type="submit" class="btn btn-primary" form="formCBid"><span class="fa fa-list-alt"></span></button>
                <form id="CBid" action="id.php" method="GET" target="_self">
                    <input type="hidden" name="id" value="'.$template_where_0_value.'" />
                    <input type="hidden" name="action" value="update" />
                </form>
                <form id="formCBid" action="form.php" method="GET" target="_self">
                    <input type="hidden" name="id" value="'.$template_where_0_value.'" />
                    <input type="hidden" name="action" value="update" />
                </form>
            </div>
        </div>
        <div class="row" style="margin-top:0.5em">
            <div class="btn-group">
                <a href="#" class="btn btn-primary" onclick="pagePrev(this);return false;">Prev</a>
                <a href="#" class="btn btn-primary" onclick="pageNext(this);return false;">Next</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <form>
            <div class="form-group">
                <label for="existence">Period of sedimentary activity</label>
                <br>
                <span data-variable="abegin14cbp" contenteditable="false">abegin14cbp</span> - <span data-variable="aend14cbp" contenteditable="false">aend14cbp</span> <strong>14C yr</strong> (<span data-variable="existence">existence</span>)
            </div>
        </form>
    </div>
    <div class="col-md-3">
        <form>
            <div class="form-group">
                <label for="riversystemgrp">Group</label>
                <br>
                <span data-variable="riversystemgrp" contenteditable="false">riversystemgrp</span>
            </div>
        </form>
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
                <a role="tab" class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#description" aria-controls="description" aria-selected="true">Description</a>
            </li>
            <li role="presentation" class="nav-item">
                <a role="tab" class="nav-link" id="geometry-tab" data-bs-toggle="tab" href="#geometry" aria-controls="geometry" aria-selected="false">Geometry</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade show active" id="description" aria-labelledby="description-tab">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group row">
                            <div class="col-sm-2"><b>Dating methods</b></div>
                            <div class="col-sm-10"><span data-variable="datingmethods" contenteditable="false">datingmethods</span></div>
                        </div>
                        <br>
                        <h5><b>Beginning of sedimentation</b></h5>
                        <div class="row small">
                            <div class="col-md-12">
                                <div class="col-sm-2 bg-primary text-right"><b>Type of reasoning</b></div>
                                <div class="col-sm-2 bg-primary"><span data-variable="abeginreasoningcategory" contenteditable="false">abeginreasoningcategory</span></div>
                                <div class="col-sm-2 bg-primary text-right"><b>Begin same as</b></div>
                                <div class="col-sm-2 bg-primary"><span data-variable="upstrconnect" contenteditable="false">upstrconnect</span></div>
                                <div class="col-sm-2 bg-primary text-right"><b>Precursor</b></div>
                                <div class="col-sm-2 bg-primary"><span data-variable="abeginreasoningprecursor" contenteditable="false">abeginreasoningprecursor</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-area id--cross-ref" disabled style="background-color: transparent" data-function="id--cross-ref">
                                <span data-variable="abeginreasoning" contenteditable="false">abeginreasoning</span>
                            </div>
                        </div>
                        <br>
                        <h5><b>End of sedimentation</b></h5>
                        <div class="row small">
                            <div class="col-md-12">
                                <div class="col-sm-2 bg-primary text-right"><b>Type of reasoning</b></div>
                                <div class="col-sm-2 bg-primary"><span data-variable="aendreasoningcategory" contenteditable="false">aendreasoningcategory</span></div>
                                <div class="col-sm-2 bg-primary text-right"><b>End same as</b></div>
                                <div class="col-sm-2 bg-primary"><span data-variable="dnstrconnect" contenteditable="false">dnstrconnect</span></div>
                                <div class="col-sm-2 bg-primary text-right"><b>Successor</b></div>
                                <div class="col-sm-2 bg-primary"><span data-variable="aendreasoningsuccessor" contenteditable="false">aendreasoningsuccessor</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-area id--cross-ref" disabled style="background-color: transparent" data-function="id--cross-ref">
                                <span data-variable="aendreasoning" contenteditable="false">aendreasoning</span>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col-sm-12 text-area id--cross-ref" disabled style="background-color: transparent" data-function="id--cross-ref">
                                <label for="archeologyfindperiods" class="col-sm-2">Archeology</label>
                                <span class="col-sm-10" data-variable="archeologyfindperiods" contenteditable="false">archeologyfindperiods</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 text-area id--cross-ref" disabled style="background-color: transparent">
                                <label for="biblioreferences" class="col-sm-2">References</label>
                                <span class="col-sm-10" data-variable="biblioreferences" contenteditable="false">biblioreferences</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 text-area id--cross-ref" disabled style="background-color: transparent" data-function="id--cross-ref">
                                <label for="remarkvarious" class="col-sm-2">Remarks</label>
                                <span class="col-sm-10" data-variable="remarkvarious" contenteditable="false">remarkvarious</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- tab -->
            <div role="tabpanel" class="tab-pane fade" id="geometry" aria-labelledby="geometry-tab">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h5><b>Upstream:</b></h5>
                                <h5><b>X,Y</b></h5>
                                <span data-variable="upstrxco" contenteditable="false">upstrxco</span> , <span data-variable="upstryco" contenteditable="false">upstryco</span>
                                <h5><b>Long,Lat</b></h5>
                                <span data-variable="upstrlong" contenteditable="false">upstrlong</span> , <span data-variable="upstrlat" contenteditable="false">upstrlat</span>
                                <h5><b>Top of Sand</b></h5>
                                <span data-variable="upstrtopsand" contenteditable="false">upstrtopsand</span> (m NAP)
                            </div>
                            <div class="col-md-4">
                                <h5><b>Downstream:</b></h5>
                                <h5><b>X,Y</b></h5>
                                <span data-variable="dnstrxco" contenteditable="false">dnstrxco</span> , <span data-variable="dnstryco" contenteditable="false">dnstryco</span>
                                <h5><b>Long,Lat</b></h5>
                                <span data-variable="dnstrlong" contenteditable="false">dnstrlong</span> , <span data-variable="dnstrlat" contenteditable="false">dnstrlat</span>
                                <h5><b>Top of Sand</b></h5>
                                <span data-variable="dnstrtopsand" contenteditable="false">dnstrtopsand</span> (m NAP)
                            </div>
                            <div class="col-md-4">
                                <div id="map" style="width: auto; height: 350px; background-color: #eeeeee; overflow: hidden;"></div>
                                <script src="/e107_plugins/leaflet/js/leaflet-bing-layer.js"></script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5><b>Avg slope</b></h5>
                                <span data-variable="avgslope" contenteditable="false">avgslope</span> <span>cm/km</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5><b>Remarks:</b></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span data-variable="remarkupdnstr" contenteditable="false">remarkupdnstr</span>
                                <br>
                                <span data-variable="remarktopsand" contenteditable="false">remarktopsand</span>
                                <br>
                                <span data-variable="remarkavgslope" contenteditable="false">remarkavgslope</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5><b>Connections</b></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6><b>Upstream:</b></h6>
                                <span data-variable="upstrconnect" contenteditable="false">upstrconnect</span>
                                <br>
                                <span data-variable="remarkupstrconnect" contenteditable="false">remarkupstrconnect</span>
                            </div>
                            <div class="col-md-6">
                                <h6><b>Downstream:</b></h6>
                                <span data-variable="dnstrconnect" contenteditable="false">dnstrconnect</span>
                                <br>
                                <span data-variable="remarkdnstrconnect" contenteditable="false">remarkdnstrconnect</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row text-center">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="row">
                                    <div class="col-md-6 text-left">W</div>
                                    <div class="col-md-6 text-right">E</div>
                                </div>
                                <div class="row">
                                    <canvas id="myCanvas" width="400" height="200" style="border:1px solid #000000;"></canvas>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row text-left">
                                            <h6><b>Downstream Top of Sand</b></h6>
                                            <span data-variable="dnstrtopsand" contenteditable="false">dnstrtopsand</span> (m NAP)
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row text-center">
                                            <h6><b>Avg slope (cm/km) and remark</b></h6>
                                            <span data-variable="avgslope" contenteditable="false">avgslope</span>
                                            <br>
                                            <span data-variable="remarkavgslope" contenteditable="false">remarkavgslope</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row text-right">
                                            <h6><b>Upstream Top of Sand</b></h6>
                                            <span data-variable="upstrtopsand" contenteditable="false">upstrtopsand</span> (m NAP)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row text-center">
                            <div class="col-md-4 text-left">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6><b>Downstream connections:</b></h6>
                                        <span data-variable="dnstrconnect" contenteditable="false">dnstrconnect</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6><b>Remark</b></h6>
                                        <span data-variable="remarkdnstrconnect" contenteditable="false">remarkdnstrconnect</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4 text-right">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6><b>Upstream connections:</b></h6>
                                        <span data-variable="upstrconnect" contenteditable="false">upstrconnect</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6><b>Remark</b></h6>
                                        <span data-variable="remarkupstrconnect" contenteditable="false">remarkupstrconnect<span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of content -->
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