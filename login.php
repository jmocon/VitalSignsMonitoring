<?php
require_once "App_Code/GoogleSheet.php";
require_once "App_Code/User.php";
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
  if ($_GET['d'] == "register") {
    $missing = "";

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
    .wrapper {
      /* background: url('assets/img/full-screen-image-3.jpg') no-repeat !important; */
      /* background-size: cover; */
      background-color: #4aff7d;
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
    .loading {
      background-image: url('JumEE/img/loading.gif');
      background-repeat: no-repeat;
      background-position: center;
      background-size: contain;
      height: 50px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="content">
      <div class="container-fluid centered">
        <h3 class="text-center">Vital Signs Monitoring</h3>
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <div class="card card-user" style="background-color: #7bbfff;">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <h4 class="text-center">Log-in</h4>
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
                    <div class="row">
                      <div class="col-12" id="notification">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-3">
                        <h6 class="mb-2 mt-2">Username:</h6>
                      </div>
                      <div class="col-md-9">
                        <input type="text" id="txtUsername" name="Username" placeholder="Username" class="form-control mb-2 mb-2 border border-secondary" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-3">
                        <h6 class="mb-2 mt-2">Password:</h6>
                      </div>
                      <div class="col-md-9">
                        <input type="password" id="txtPassword" name="Password" placeholder="Password" class="form-control mb-2 mb-2 border border-secondary" />
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-md-12">
                        <button onclick="login()" class="btn form-control col-md-8 offset-md-2 btn-primary btn-fill">
                          Login
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-12 text-center">
                    New Account? <a href="register.php" class="text-dark"> Click Here! </a>
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

<script src="JumEE/js/login.js"></script>
<script src="JumEE/js/utility.js"></script>

</html>
