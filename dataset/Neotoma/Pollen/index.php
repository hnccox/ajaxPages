<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

require_once(HEADERF);

// ------------------------------------------------
// TO DO: This template should come from the database!
require_once('index.template.php');
// ------------------------------------------------

require_once(FOOTERF);

?>
