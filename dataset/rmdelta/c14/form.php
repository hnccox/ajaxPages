<?php

require_once($_SERVER['DOCUMENT_ROOT']."/class2.php");
require_once(HEADERF);

if(!USER) {
    $ns->tablerender("Error!", "You must login to view this page");
    require_once(FOOTERF);
    exit; 
}

function validateFormSubmit() {
    // $require_path = realpath($_SERVER['DOCUMENT_ROOT']."/../../db");
    // require_once("{$require_path}/{$db}.php");

    // try {
    //     $this->pdo = new PDO("pgsql:host=$servername;dbname=$dbname", $username, $password);
    //     $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // } catch(PDOException $e) {
    //     echo "Error: " . $e->getMessage();
    // }
}

function validateUserAction() {

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

$url = "//wikiwfs.geo.uu.nl/e107_plugins/ajaxDBQuery/beta/API.php";
$db = "rmdelta";
$table = "c14_cat";
$columns = "*";
$inner_join = "";
$where = "labidnr='{$_GET['labidnr']}'";
$limit = 1;
$offset = 0;

if(!array_keys($_GET)) {
    $method = "CREATE";
    $formaction = "?action=submit";
    $query = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } } }';
} else {
    $method = "UPDATE";
    $formaction = "?labidnr={$_GET['labidnr']}&action=submit";
    $query = '{ "0": { "select": { "columns": { "0": "'.$columns.'" }, "from": { "table": "'.$table.'" } } }, "1": { "where": { "0": { "identifier": "'.array_keys($_GET)[0].'", "value": "'.$_GET['labidnr'].'" } } } }';

}
// ------------------------------------------------
$script .= '
<script src="./form.js" type="module">
</script>
';
// ------------------------------------------------
$method = "GET";

$query = '{ "0": { "select": { "columns": { "0": "*" }, "from": { "table": "c14_cat" } } }, "1": { "where": { "0": { "identifier": "labidnr", "value": "'.$_GET['labidnr'].'" } } } }';
$form = '
<br> 
<form action="'.$formaction.'" method="post" class="container" 
    data-ajax="form" 
    data-url="'.$url.'" 
    data-db="'.$db.'" 
    data-table="'.$table.'" 
    data-columns="'.$columns.'" 
    data-query=\''.$query.'\'
>
    <input type="hidden" name="_method" value="'.$method.'">
    <input type="submit" value="submit">
</form>
';

// ------------------------------------------------

$text = $script.$form.$footerscript;
$mode = "C14labidnr";
$return = false;
$ns = e107::getRender();
$ns->tablerender($caption, $text, $mode, $return);

require_once(FOOTERF);

?>