<?php

// ------------------------------------------------

$map = '
    <div class="map content"
        data-ajax="map"
        data-master="true"
        data-lat="45.67"
        data-lng="12.83" 
        data-url="//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/server/API.php"
        data-db="llg"
        data-table="llg_it_geom"
        data-columns="llg_it_geom.borehole,llg_it_geom.longitude,llg_it_geom.latitude,llg_it_geom.xy,llg_it_geom.geom,xco,yco,drilldepth"
        data-inner_join="llg_it_geom ON llg_it_boreholeheader.borehole = llg_it_geom.borehole"
        data-where=""
        data-order_by=""
        data-direction=""
        data-page=""
        data-overlaymaps=\'{"Boreholes": "boreholes"}\'
        data-limit="200">
    </div>
    <div class="d-none d-md-block"></div>
';

// ------------------------------------------------

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    echo $map;
} else {
    return $map;
}

// ------------------------------------------------

?>