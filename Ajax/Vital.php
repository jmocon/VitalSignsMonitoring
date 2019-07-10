<?php
require_once ("../App_Code/GoogleSheet.php");
require_once ("../App_Code/Fn.php");
require_once ("../App_Code/Vital.php");

$call = $_GET['c'];

switch ($call) {
	case 'delete':
	{
		delete();
		break;
	}
}

function delete(){
	$error = "";
	$output = "";
	$found = false;
	$clsVital = new Vital();
	$mdlVital = new VitalModel();
	$clsFn = new Fn();
	$username = "";

	$error .= $clsFn->setVar('Username',$username);

	if ($error == "") {
		$clsVital->DeleteByUsername($username);
		$output = '{
			"success" : true,
			"title"		:	"Deleted Successfully.",
			"message"	:	"You have successfully deleted data."
		}';
	} else {
		$output = '{
			"success" : false,
			"title"		:	"Please Complete All Required Fields.",
			"message"	:	"'.$error.'"
		}';
	}
	echo $output;
}
