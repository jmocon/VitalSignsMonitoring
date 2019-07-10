<?php
require_once ("../App_Code/GoogleSheet.php");
require_once ("../App_Code/Fn.php");
require_once ("../App_Code/User.php");

$call = $_GET['c'];

switch ($call) {
	case 'add':
	{
		add();
		break;
	}
	case 'update':
	{
		update();
		break;
	}
	case 'get':
	{
		get();
		break;
	}
	case 'delete':
	{
		delete($_GET['Id']);
		break;
	}
	case 'login':
	{
		login();
		break;
	}
}

function add(){
	$error = "";
	$output = "";
	$found = false;
	$clsUser = new User();
	$mdlUser = new UserModel();
	$clsFn = new Fn();

	$error .= $clsFn->setForm('Username',$mdlUser,true);
	$error .= $clsFn->setForm('Password',$mdlUser,true);
	$error .= $clsFn->setForm('FirstName',$mdlUser,true);
	$error .= $clsFn->setForm('MiddleName',$mdlUser,true);
	$error .= $clsFn->setForm('LastName',$mdlUser,true);
	$error .= $clsFn->setForm('Age',$mdlUser,true);
	$error .= $clsFn->setForm('Gender',$mdlUser,true);
	$error .= $clsFn->setForm('Address',$mdlUser,true);
	$mdlUser->setUserType('client');

	if ($error == "") {
		if ($clsUser->IsUsernameExist($mdlUser->getUsername())) {
			$output = '{
				"success" : false,
				"title"		:	"Username already taken.",
				"message"	:	"A user is already using the username, please choose a different username."
			}';
		} else {
			$clsUser->Add($mdlUser);

			$output = '{
				"success" : true,
				"title"		:	"Registered Successfully.",
				"message"	:	"You have successfully registered. Log-in to continue."
			}';
		}
	} else {
		$output = '{
			"success" : false,
			"title"		:	"Please Complete All Required Fields.",
			"message"	:	"'.$error.'"
		}';
	}
	echo $output;
}

function edit() {
	$success = false;
	$err = "";
	$msg = "";
	$cls = new User();
	$mdl = new UserModel();
	$clsFn = new Fn();

	$err .= $clsFn->setForm('Id',$mdl,true);
	$err .= $clsFn->setForm('Name',$mdl,true);
	$err .= $clsFn->setForm('Position',$mdl,true);
	$err .= $clsFn->setForm('Email',$mdl,true);
	$err .= $clsFn->setForm('Password',$mdl);

	if($err == ""){
		$duplicate = $cls->IsExist($mdl);
		if($duplicate['val']){
			$msg = '{
				"success" : false,
				"type"		:	"duplicate",
				"title"		:	"Duplicate of Information Detected.",
				"email"		:	true,
				"message"	:	"'.$duplicate['msg'].'"
			}';
		}else{
			if (empty($mdl->getPassword())) {
				$id = $cls->UpdateNotPassword($mdl);
			} else {
				$hash = password_hash($mdl->getPassword(), PASSWORD_BCRYPT, ["cost" => 10]);
				$mdl->setPassword($hash);
				$id = $cls->Update($mdl);
			}
			$msg = '{
				"success" : "true",
				"title"		:	"Successfully Edited User",
				"id"			:	"'.$mdl->getId().'",
				"name"		:	"'.$mdl->getName().'",
				"email"		:	"'.$mdl->getEmail().'"
			}';
		}
	}else{
		$msg = '{
			"success" : "false",
			"type"		:	"incomplete",
			"title"		:	"Please Complete All Required Fields.",
			"message"	:	"'.$err.'"
		}';

	}

	echo $msg;
}

function display($id) {

	$cls = new User();
	$mdl = new UserModel();
	$mdl = $cls->GetById($id);
	?>
  <!-- Modal Header -->
  <div class="modal-header">
    <h5 class="modal-title">User Detail</h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>

  <!-- Modal body -->
  <div class="modal-body">
    <div class="row">
      <div class="col-md-4">
        Name:
      </div>
      <div class="col-md-8">
        <?php echo $mdl->getName(); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        Position:
      </div>
      <div class="col-md-8">
        <?php echo $mdl->getPosition(); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        Email:
      </div>
      <div class="col-md-8">
        <?php echo $mdl->getEmail(); ?>
      </div>
    </div>
  </div>

  <!-- Modal footer -->
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  </div>
	<?php
}

function deleteItem($id)
{
	$cls = new User();
	$cls->Delete($id);
	?>


  <!-- Modal Header -->
  <div class="modal-header">
    <h4 class="modal-title">User Deleted</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>

  <!-- Modal body -->
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
				<div class="alert alert-success" role="alert">
	        User Deleted Successfully
				</div>
      </div>
    </div>
  </div>

  <!-- Modal footer -->
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  </div>
	<?php
}

function login() {
	$found = false;
	$error = "";
	$output = "";
	$clsUser = new User();
	$mdlUser = new UserModel();
	$clsFn = new Fn();
	$username = "";
	$password = "";

	$error .= $clsFn->setVar('Username',$username);
	$error .= $clsFn->setVar('Password',$password);

	if($error == ""){
		$lstUser = $clsUser->Get();
    foreach ($lstUser as $mdlUser) {
      if ($username == $mdlUser->getUsername() && $password == $mdlUser->getPassword()) {
        $found = true;
				$_SESSION['username'] = $mdlUser->getUsername();
        $_SESSION['usertype'] = $mdlUser->getUserType();
        break;
      }
    }
		if($found){
			$output = '{
				"success" : true,
				"title"		:	"Successfully Loggeed In",
				"message"	:	"You will be redirected, please wait."
			}';
		}else{
			$output = '{
				"success" : false,
				"title"		:	"Authentication Failed.",
				"message"	:	"Please check your Username and Password."
			}';
		}
	}else{
		$output = '{
			"success" : false,
			"title"		:	"Please Complete All Required Fields.",
			"message"	:	"'.$error.'"
		}';
	}

	echo $output;
}

?>
