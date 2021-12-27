<?php

// ------------------------------------------------

$templateParams = [];
$templateParams['parent'] = "";

// ------------------------------------------------

$template = '
<iframe src="https://data-dev.neotomadb.org/'.$_GET["siteid"].'" width="100%" height="100%" title="siteid"></iframe>
';

// ------------------------------------------------

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    echo $template;
}
else {
    return $template;
}

// ------------------------------------------------

?>