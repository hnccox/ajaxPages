<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../class2.php");

//e107::css(url, 'css/index.css');
e107::css(url, '/e107_plugins/ajaxTemplates/css/ajaxMenu.css');
e107::css(url, '/e107_plugins/ajaxTemplates/css/ajaxTables.css');
//e107::js(url, 'js/index.js');
//e107::js(url, 'js/ajaxTables.js');

require_once(HEADERF);

// ------------------------------------------------
$script = '
<script src="./cbgroup.js" type="module">
</script>
';
// ------------------------------------------------
// TO DO: This template should come from the database!
$caption = '';
$template = '
<br>
<div id="Graaf_(Rhine)" class="hidden">
    Graaf_(Rhine)
</div>
<div id="Benschop_(Rhine)" class="hidden">
    Benschop_(Rhine)
</div>
';
// ------------------------------------------------

$text = $script.$template;
$mode = "CBgroup";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);

require_once(FOOTERF);

?>