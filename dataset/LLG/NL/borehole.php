<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");

//e107::css(url, 'css/index.css');
e107::css(url, '/e107_plugins/ajaxTemplates/css/ajaxTables.css');
e107::css(url, '/e107_plugins/ajaxTemplates/css/ajaxTemplates.css');
e107::css(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
//e107::js(url, 'js/index.js');
//e107::js(url, 'js/ajaxPages.js');
e107::js(url, 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js');

// ------------------------------------------------

if($_GET['format'] === 'json') {

    $_GET['db'] = json_encode($db);
    $_GET['query'] = $templatequery;
    
    header('Content-Type: application/json');
    require_once($_SERVER['DOCUMENT_ROOT']."/e107_plugins/ajaxDBQuery/beta/API.php");
    exit;
}

require_once(HEADERF);

// ------------------------------------------------
// JAVASCRIPT
// ------------------------------------------------
$script = '
<script src="./borehole.js" type="module">
</script>
';

// ------------------------------------------------
// TEMPLATE
// ------------------------------------------------
$template = require_once('borehole.template.php');

// ------------------------------------------------
// TABLE
// ------------------------------------------------
$table = require_once('borehole.table.php');

// ------------------------------------------------

if(!$_GET['borehole']) {

    $caption = "Something went wrong";
    $text = "Click <a href='index.php'>here</a> to return to the index";

    $mode = "LLGboreholedata";
    $return = false;
    $ns = e107::getRender();
    $ns->tablerender($caption, $text, $mode, $return);

    require_once(FOOTERF);
    exit;
}

// ------------------------------------------------

if($_GET['action'] === 'edit') {
    // ToDo: Check if there is a release candidate...
    $edit = false;
    if (USER) {
        $userData = e107::user(USERID); // Example - currently logged in user.
        $userclassList = explode(",", $userData["user_class"]);
        $userclassID = 4;  // id from 'Wiki Editors' userclass
        if(!in_array($userclassID, $userclassList)) {
            $ns->tablerender("Error!", "You must be part of the 'Wiki Editor' userclass to edit this page");
            require_once(FOOTERF);
            exit;
        } else {
            $edit = true;
        }
    } else {
        $ns->tablerender("Error!", "You must login to edit this page");
        require_once(FOOTERF);
        exit;
    }
}

// ------------------------------------------------

$caption = "<h1>LLG Boreholedata</h1>";
$text = $script.$template.$table;
$mode = "LLGboreholedate";
$return = false;
$ns = e107::getRender();
$ns->tablerender('', $text, $mode, $return);

// ------------------------------------------------

require_once(FOOTERF);

?>