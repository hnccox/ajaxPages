<?php

// ------------------------------------------------

$map = '
<div class="leaflet map content"
    data-type="parent"
    data-ajax="map"
    data-lat="52.0907"
    data-lng="5.1214"
    data-zoom="7"   
    data-min-zoom="7"
    data-max-zoom="12"
    data-zoomlevel="13"
    data-limit="500">
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