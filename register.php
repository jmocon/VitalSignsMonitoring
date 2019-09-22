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
        <div class="row">
          <div class="col-md-8 offset-md-2">
            <div class="card card-user" style="background-color: #7bbfff;">
              <div class="card-body">
                <div class="row">
                  <div class="col-12" style="overflow-y: auto;">
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
                      <div class="col-12 p-0" id="reg_notification">
                      </div>
                    </div>
                    <div class="row m-0">
                      <div class="col-12 p-0 loading d-none" id="reg_loading">
                      </div>
                    </div>

                    <div class="row m-0">
                      <div class="col-md-12 p-0">
                        <div class="form-group">
                          <label for="exampleFormControlInput1">Full Name</label>
                          <div class="row m-0">
                            <div class="col-4 pl-0 pr-1">
                              <input
                                type="text"
                                class="form-control"
                                id="txt_regFirstName"
                                name="firstname"
                                placeholder="First Name"
                              >
                            </div>
                            <div class="col-4 pl-1 pr-1">
                              <input
                                type="text"
                                class="form-control"
                                id="txt_regMiddleName"
                                name="middlename"
                                placeholder="Middle Name"
                              >
                            </div>
                            <div class="col-4 pl-1 pr-0">
                              <input
                                type="text"
                                class="form-control"
                                id="txt_regLastName"
                                name="lastname"
                                placeholder="Last Name"
                              >
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row m-0">
                      <div class="col-md-6 pr-1 pl-0">
                        <div class="form-group">
                          <label>Age</label>
                          <input
                            type="number"
                            class="form-control"
                            id="txt_regAge"
                            name="age"
                            placeholder="Age"
                          >
                        </div>
                      </div>
                      <div class="col-md-6 pl-1 pr-0">
                        <div class="form-group">
                          <label>Gender</label>
                          <select class="form-control" name="gender" id="sel_regGender">
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
                          <textarea
                            class="form-control"
                            name="address"
                            id="txt_regAddress"
                            placeholder="House No. / Street / District / City / Province"
                            ></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="row m-0">
                      <div class="col-md-4 pr-1 pl-0">
                        <div class="form-group">
                          <label>Username</label>
                          <input
                            type="text"
                            class="form-control"
                            id="txt_regUsername"
                            name="reg_username"
                            placeholder="Username"
                          >
                        </div>
                      </div>
                      <div class="col-md-4 pl-1 pr-0">
                        <div class="form-group">
                          <label>Password</label>
                          <input
                            type="password"
                            class="form-control"
                            id="txt_regPassword"
                            name="reg_password"
                            placeholder="Password"
                          >
                        </div>
                      </div>
                      <div class="col-md-4 pl-1 pr-0">
                        <div class="form-group">
                          <label>Confirm Password</label>
                          <input
                            type="password"
                            class="form-control"
                            id="txt_regPasswordConfirm"
                            name="reg_passwordConfirm"
                            placeholder="PasswordConfirm"
                          >
                        </div>
                      </div>
                    </div>

                    <div class="row m-0">
                      <div class="col-12 text-center">
                        <button class="btn btn-primary btn-fill" onclick="register();">Register</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-12 text-center">
                    Already have an account? <a href="login.php" class="text-dark">Click here to login</a>
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
