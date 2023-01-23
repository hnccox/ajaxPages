<?php

// ------------------------------------------------

$templateParams = [];
$templateParams['parent'] = "";

// ------------------------------------------------

$template = '
<iframe src="https://data-dev.neotomadb.org/'.filter_var($_GET["siteid"], FILTER_SANITIZE_NUMBER_INT).'" width="100%" height="100%" title="siteid"></iframe>
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