<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

// --- [ API ] ------------------------------------

// --- [ JSON ] -----------------------------------

// --- [ HEADER ] ---------------------------------
require_once(HEADERF);

// --- [ JAVASCRIPT ] -----------------------------
$script = '
<script src="./labidnr.js" type="module" defer>
</script>
';

// --- [ MAP ] ------------------------------------
// --- [ TABLE ] ----------------------------------
// --- [ TEMPLATE ] -------------------------------
$template = include('labidnr.Template.php');

// --- [ RENDER ] ---------------------------------
$caption = '';
$text = '<div class="row justify-content-md-center">
			<div class="col-md-12">
                '.$template.'
			</div>
		</div>';
$mode = 'C13catalog';
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $script.$text, $mode, $return);
// ------------------------------------------------
require_once(FOOTERF);
exit;
// ------------------------------------------------

?>