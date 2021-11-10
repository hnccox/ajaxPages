<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

require_once(HEADERF);

// $template = [];
// $template['start'] = "<div>Hello World</div>";

$modal = include($_SERVER['DOCUMENT_ROOT'].'/beta/map/demo/_templates/neotoma.php');
$text = $modal("testing");


// ------------------------------------------------
$caption = "";
//$text = "";

$ns = e107::getRender();
$ns->tablerender($caption, $text, true);
// ------------------------------------------------

require_once(FOOTERF);

?>