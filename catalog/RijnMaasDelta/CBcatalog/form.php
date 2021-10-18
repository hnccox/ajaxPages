<?php

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");
require_once(HEADERF);

if (USER) {
    $userData = e107::user(USERID); // Example - currently logged in user.
    $userclassList = explode(",", $userData["user_class"]);
    $userclassID = 4;  // id from 'Wiki Editors' userclass
    if(!in_array($userclassID, $userclassList)) {
        $ns->tablerender("Error!", "You must be part of the 'Wiki Editor' userclass to view this page");
        require_once(FOOTERF);
        exit;
    }
} else {
    $ns->tablerender("Error!", "You must login to view this page");
    require_once(FOOTERF);
    exit; 
}

function validateFormSubmit() {
    
}

function validateUserAction() {
    if(!USER) {
        $ns->tablerender("Error!", "You must login to view this page");
        require_once(FOOTERF);
        exit; 
    }

    $userData = e107::user(USERID); // Example - currently logged in user.
    $userclassList = explode(",", $userData["user_class"]);

    switch($_POST['_method']) {
        case "POST":
            // Check if we have CREATE permissions!
            $userclassID = 4;  // id from 'Wiki Admin' userclass
            if(!in_array($userclassID, $userclassList)) {
                $ns->tablerender("Error!", "You must be part of the 'Wiki Admin' userclass to view this page");
                require_once(FOOTERF);
                exit;
            }
            break;
        case "GET":            
            // Check if we have READ permissions!
            $userclassID = 4;  // id from 'Wiki Editor' userclass
            if(!in_array($userclassID, $userclassList)) {
                $ns->tablerender("Error!", "You must be part of the 'Wiki Editor' userclass to view this page");
                require_once(FOOTERF);
                exit;
            }
            break;
        case "PUT":
            // Check if we have UPDATE permissions!
            $userclassID = 4;  // id from 'Wiki Editor' userclass
            if(!in_array($userclassID, $userclassList)) {
                $ns->tablerender("Error!", "You must be part of the 'Wiki Editor' userclass to view this page");
                require_once(FOOTERF);
                exit;
            }
            break;
        case "DELETE":
            // Check if we have DELETE permissions!
            $userclassID = 4;  // id from 'Wiki Admin' userclass
            if(!in_array($userclassID, $userclassList)) {
                $ns->tablerender("Error!", "You must be part of the 'Wiki Admin' userclass to view this page");
                require_once(FOOTERF);
                exit;
            }
            break;
        default:
            exit;
    }

    validateFormSubmit();

}
// ------------------------------------------------
if($_GET['action'] == "submit") {
    validateUserAction();
}

if(!array_keys($_GET)) {
    $method = "CREATE";
    $formaction = "?action=submit";
} else {
    $formaction = "?id={$_GET['id']}&action=submit";
}
// ------------------------------------------------
$script .= '
<script src="./form.js" type="module">
</script>
';
// ------------------------------------------------
$method = "GET";
$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "rmdelta";
$table = "cb_cat";
$columns = "*";
$inner_join = "";
$where = "id='{$_GET['id']}'";
$limit = 1;
$offset = 0;
$query = '{ "0": { "select": { "columns": { "0": "*" }, "from": { "table": "cb_cat" } } }, "1": { "where": { "0": { "identifier": "id", "value": "'.$_GET['id'].'" } } } }';
$form = '
<br> 
<form action="'.$formaction.'" method="post" class="container" 
    data-ajax="form" 
    data-url="'.$url.'" 
    data-db="'.$db.'" 
    data-table="'.$table.'" 
    data-columns="'.$columns.'" 
    data-query=\'{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "where": { "0": { "identifier": "'.array_keys($_GET)[0].'", "value": "'.$_GET['id'].'" } } } }\'
>
    <input type="hidden" name="_method" value="'.$method.'">
    <input type="submit" value="submit">
</form>
';

// ------------------------------------------------

$text = $script.$form.$footerscript;
$mode = "CBid";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);

require_once(FOOTERF);

?>