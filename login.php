<?php
session_start();
$success = false;
$notif = "";

$regsuccess = false;
$regnotif = "";
$uname = "";
$pword = "";
$fname = "";
$mname = "";
$lname = "";
$age = "";
$gender = "";
$address = "";
if (isset($_GET['d']) && isset($_GET['d'])) {
  if ($_GET['d'] == "login") {
    require_once 'vendor/autoload.php';
    $client = new Google_Client();
    $client->setApplicationName("Google Sheets and PHP Test");
    $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
    $client->setAccessType("offline");
    $client->setAuthConfig(__DIR__."/database-f587d7d76e58.json");
    $service=new Google_Service_Sheets($client);
    $spreadsheetId="1CViNms2zmRaZpO0eHePIHtKvbEFuwPPkuTFT0D0lwhI";

    $rangeUser="userdata";

    $responseUser=$service->spreadsheets_values->get($spreadsheetId,$rangeUser);
    $valuesUser=$responseUser->getValues();

    if(empty($valuesUser))
    {
        echo("No data found.");
        die();
    }
    else
    {
      $found = false;
      $mask='%s - %s - %s\r\n';
      if ('username' != $_POST['username'] && 'password' != $_POST['password']) {
        foreach ($valuesUser as $row) {
          if ($row[0] == $_POST['username'] && $row[1] == $_POST['password']) {
            $found = true;
            $success = true;
            $_SESSION['username'] = $row[0];
            $_SESSION['usertype'] = (isset($row[8]))?$row[8]:'';
            echo $_SESSION['username'];
            echo "-";
            echo $_SESSION['usertype'];
            header('Location: index.php');
            break;
          }
        }
      }
      if (!$found) {
        $success = false;
        $notif = "Authentication Failed.";
      }
    }
  } else if ($_GET['d'] == "register") {
    $missing = "";
    require_once 'vendor/autoload.php';
    $client = new Google_Client();
    $client->setApplicationName("Google Sheets and PHP Test");
    $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
    $client->setAccessType("offline");
    $client->setAuthConfig(__DIR__."/database-f587d7d76e58.json");
    $service=new Google_Service_Sheets($client);
    $spreadsheetId="1CViNms2zmRaZpO0eHePIHtKvbEFuwPPkuTFT0D0lwhI";


    if (!empty($_POST['username'])) {
      $uname = $_POST['username'];
    } else {
      $missing .= "<p>Username Missing. </p>";
    }
    if (!empty($_POST['password'])) {
      $pword = $_POST['password'];
    } else {
      $missing .= "<p>Password Missing. </p>";
    }
    if (!empty($_POST['firstname'])) {
      $fname = $_POST['firstname'];
    } else {
      $missing .= "<p>First Name Missing. </p>";
    }
    if (!empty($_POST['middlename'])) {
      $mname = $_POST['middlename'];
    } else {
      $missing .= "<p>Middle Name Missing. </p>";
    }
    if (!empty($_POST['lastname'])) {
      $lname = $_POST['lastname'];
    } else {
      $missing .= "<p>Last Name Missing. </p>";
    }
    if (!empty($_POST['age'])) {
      $age = $_POST['age'];
    } else {
      $missing .= "<p>Age Missing. </p>";
    }
    if (!empty($_POST['gender'])) {
      $gender = $_POST['gender'];
    } else {
      $missing .= "<p>Gender Missing. </p>";
    }
    if (!empty($_POST['address'])) {
      $address = $_POST['address'];
    } else {
      $missing .= "<p>Address Missing. </p>";
    }

    if ($missing == "") {
      $exist = false;
      $rangeUser="userdata";
      $responseUser=$service->spreadsheets_values->get($spreadsheetId,$rangeUser);
      $valuesUser=$responseUser->getValues();
      foreach ($valuesUser as $row) {
        if ($row[0] == $uname) {
          $exist = true;
        }
      }

      if ($exist) {
        $regnotif = "Username already exist.";
        $regsuccess = false;
      } else {

        $regnotif = "User successfully added.";
        $regsuccess = true;
        $range = "userdata";
        $values = [[$uname, $pword,$fname,$mname,$lname,$age,$gender,$address,"client"]];
        $body = new Google_Service_Sheets_ValueRange([
          'values' => $values
        ]);
        $params = ['valueInputOption' => 'RAW'];
        $insert = ['insertDataOption' => 'INSERT_ROWS'];
        $result = $service->spreadsheets_values->append($spreadsheetId,$range,$body,$params,$insert);
      }
    } else {
      $regnotif = "<h5 style='margin: 0px;'>Please complete all details.</h5>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Vital Signs Monitoring</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="assets/fonts/Montserrat.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css" />
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/css/demo.css" rel="stylesheet" />
  <style>
    body {
      background: url('assets/img/full-screen-image-3.jpg')no-repeat;background-size: cover;
    }
    .centered {
      position: fixed;
      top: 50%;
      left: 50%;
      /* bring your own prefixes */
      transform: translate(-50%, -50%);
    }
    label {
      color: #000 !important;
    }
    input, select, textarea {
      border: 1px solid #6c757d !important;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="content">
      <div class="container-fluid centered">
        <div class="row">
          <div class="col-md-8 offset-md-2">
            <div class="card card-user" style="background-color: rgba(255, 255, 255, 0.6);">
              <div class="card-body">
                <div class="row">
                  <div class="col-6">
                    <h3 class="text-center">Vital Signs Monitoring</h3>
                    <hr>
                    <h4 class="text-center">Log-in</h4>
                    <hr>
                    <?php
                    if ($notif != "") {
                      ?>
                      <div class="alert alert-<?php echo ($success)?'success':'danger';?>">
                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                          <i class="nc-icon nc-simple-remove"></i>
                        </button>
                        <span>
                          <?php echo $notif; ?>
                        </span>
                      </div>
                      <?php
                    }
                    ?>

                    <form method="post" action="login.php?d=login">
                      <div class="row">
                        <div class="col-md-10 offset-md-1">
                          <h6 class="mb-2 mt-2">Username</h6>
                          <input class="form-control mb-2 mb-2 border border-secondary" type="text" name="username" placeholder="Username" />
                          <h6 class="mb-2 mt-2">Password</h6>
                          <input class="form-control mb-2 mb-2 border border-secondary" type="password" name="password" placeholder="Password" />
                          <input class="btn form-control col-md-8 offset-md-2 mb-2 btn-primary btn-fill  border border-secondary" type="submit" value="Login" />
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-6" style="overflow-y: auto;">
                    <form method="post" action="login.php?d=register">
                      <div class="row m-0">
                        <div class="col-sm-12 pr-1 pl-0">
                          <h4 class="text-center">Register</h4>
                          <hr>
                        </div>
                      </div>
                      <?php
                      if ($regnotif != "") {
                        ?>
                        <div class="row m-0">
                          <div class="col-12">
                            <div class="alert alert-<?php echo ($regsuccess)?'success':'danger';?>">
                              <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                                <i class="nc-icon nc-simple-remove"></i>
                              </button>
                              <span>
                                <?php echo $regnotif; ?>
                              </span>
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                      ?>
                      <div class="row m-0">
                        <div class="col-md-6 pr-1 pl-0">
                          <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Username">
                          </div>
                        </div>
                        <div class="col-md-6 pl-1 pr-0">
                          <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" name="password" placeholder="Password">
                          </div>
                        </div>
                      </div>
                      <div class="row m-0">
                        <div class="col-md-12 p-0">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Full Name</label>
                            <div class="row m-0">
                              <div class="col-4 pl-0 pr-1">
                                <input type="text" class="form-control" name="firstname" placeholder="First Name">
                              </div>
                              <div class="col-4 pl-1 pr-1">
                                <input type="text" class="form-control" name="middlename" placeholder="Middle Name">
                              </div>
                              <div class="col-4 pl-1 pr-0">
                                <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row m-0">
                        <div class="col-md-6 pr-1 pl-0">
                          <div class="form-group">
                            <label>Age</label>
                            <input type="number" class="form-control" name="age" placeholder="Age">
                          </div>
                        </div>
                        <div class="col-md-6 pl-1 pr-0">
                          <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control" name="gender">
                              <option value="M" selected>Male</option>
                              <option value="F">Female</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row m-0">
                        <div class="col-md-12 p-0">
                          <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address" placeholder="House No. / Street / District / City / Province"></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="row m-0">
                        <div class="col-12 text-center">
                          <input type="submit" class="btn btn-primary btn-fill" value="Register" />
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<!--   Core JS Files   -->
<script src="assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="assets/js/plugins/bootstrap-switch.js"></script>
<!--  Chartist Plugin  -->
<script src="assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>

</html>
