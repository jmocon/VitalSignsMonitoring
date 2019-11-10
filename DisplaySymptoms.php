<?php
session_start();
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setApplicationName("Google Sheets and PHP Test");
$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType("offline");
$client->setAuthConfig(__DIR__."/database-f587d7d76e58.json");
$service=new Google_Service_Sheets($client);
$spreadsheetId="1CViNms2zmRaZpO0eHePIHtKvbEFuwPPkuTFT0D0lwhI";

$rangeVital="usersymptoms";

$responseVital=$service->spreadsheets_values->get($spreadsheetId,$rangeVital);
$valuesVital=$responseVital->getValues();
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
  <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.css" />
  <!-- CSS Files -->
  <link href="assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/css/demo.css" rel="stylesheet" />
  <!-- Datatable -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/dataTables.min.css" rel="stylesheet" />
  <style>
    pre {
      margin: 0px !important;
    }
    .table>tbody>tr>td {
      padding:6px 8px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include "sidebar.php"; ?>
    <div class="main-panel">
      <!-- Navbar -->
      <?php include "nav.php"; ?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-plain table-plain-bg">
                <div class="card-header ">
                  <h4 class="card-title">
                    Vital Data Table
                  </h4>
                  <p class="card-category">Here is a list of symptoms</p>

                </div>
                <div class="card-body table-responsive">
                  <div class="row m-0">
                    <div class="col-12 p-0" id="notification">
                    </div>
                  </div>
                  <?php
                  $username = "";
                  $count = 0;
                  if (isset($_GET['u'])) {
                    $username = $_GET['u'];
                  } else {
                    $username = $_SESSION['username'];
                  }
                  $values = new stdClass();
                  foreach ($valuesVital as $row)
                  {
                    if ($row[0] == $username) {
                      $count++;
                      $values->chestPain            = $row[1];
                      $values->cough                = $row[2];
                      $values->diarrhea             = $row[3];
                      $values->swallowing           = $row[4];
                      $values->dizziness            = $row[5];
                      $values->headaches            = $row[6];
                      $values->palpitations         = $row[7];
                      $values->nasal_congestion     = $row[8];
                      $values->nausea               = $row[9];
                      $values->shortness_of_breath  = $row[10];
                      $values->wheezing             = $row[11];
                    }
                  }
                  ?>

                  <div class="row">
                    <div class="col">
                      Username: <?php echo $username; ?>
                    </div>
                  </div>
                  <?php
                  if ($count < 1) {
                    ?>
                    <div class="row">
                      <div class="col-12">
                        No Data Available
                      </div>
                    </div>

                    <?php
                  }else{
                    ?>
                    <table class="table table-striped table-hover">
                      <tr>
                        <th>Category</th>
                        <th>Symptoms</th>
                      </tr>
                      <tr>
                        <td>Chest Pain</td>
                        <td><pre><?php echo $values->chestPain; ?></pre></td>
                      </tr>
                      <tr>
                        <td>Cough</td>
                        <td><pre><?php echo $values->cough; ?></pre></td>
                      </tr>
                      <tr>
                        <td>Diarrhea</td>
                        <td><pre><?php echo $values->diarrhea; ?></pre></td>
                      </tr>
                      <tr>
                        <td>Swallowing</td>
                        <td><pre><?php echo $values->swallowing; ?></pre></td>
                      </tr>
                      <tr>
                        <td>Dizziness</td>
                        <td><pre><?php echo $values->dizziness; ?></pre></td>
                      </tr>
                      <tr>
                        <td>Headaches</td>
                        <td><pre><?php echo $values->headaches; ?></pre></td>
                      </tr>
                      <tr>
                        <td>Palpitations</td>
                        <td><pre><?php echo $values->palpitations; ?></pre></td>
                      </tr>
                      <tr>
                        <td>Nasal Congestion</td>
                        <td><pre><?php echo $values->nasal_congestion; ?></pre></td>
                      </tr>
                      <tr>
                        <td>Nausea</td>
                        <td><pre><?php echo $values->nausea; ?></pre></td>
                      </tr>
                      <tr>
                        <td>Shortness of Breath</td>
                        <td><pre><?php echo $values->shortness_of_breath; ?></pre></td>
                      </tr>
                      <tr>
                        <td>Wheezing</td>
                        <td><pre><?php echo $values->wheezing; ?></pre></td>
                      </tr>
                    </table>

                  <?php
                  }
                  ?>
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
<!--  Google Maps Plugin    -->
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
<!--  Chartist Plugin  -->
<script src="assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>
<script src="JumEE/js/DisplayVital.js"></script>
<!-- Datatable -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>

</html>
