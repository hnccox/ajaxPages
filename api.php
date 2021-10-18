<?php

switch($_SERVER['REQUEST_METHOD']) {
	case "GET":
		require_once($_SERVER['DOCUMENT_ROOT'].'/e107_plugins/ajaxDBQuery/beta/GET.php');
		break;
	case "POST":
		require_once($_SERVER['DOCUMENT_ROOT'].'/e107_plugins/ajaxDBQuery/beta/POST.php');
		break;
	case "PUT":
		require_once($_SERVER['DOCUMENT_ROOT'].'/e107_plugins/ajaxDBQuery/beta/PUT.php');
		break;         
	case "DELETE":
		require_once($_SERVER['DOCUMENT_ROOT'].'/e107_plugins/ajaxDBQuery/beta/DELETE.php');
		break;       
	default:
		exit;
}

?>