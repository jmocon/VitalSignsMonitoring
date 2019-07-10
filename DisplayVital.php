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

$rangeVital="vitaldata";

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
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css" />
  <!-- CSS Files -->
  <link href="assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/css/demo.css" rel="stylesheet" />
  <!-- Datatable -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/dataTables.min.css" rel="stylesheet" />
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
                    <?php
                    if ($_SESSION['usertype'] == 'admin' && isset($_GET['u'])) {
                      ?>
                      <button class="btn btn-danger pull-right" onclick="clearByUsername(<?php echo $_GET['u']; ?>);">
                        Clear Entries
                      </button>
                      <?php
                    }
                    ?>
                  </h4>
                  <p class="card-category">Here is a list of all the vital details collected</p>

                </div>
                <div class="card-body table-responsive">
                  <div class="row m-0">
                    <div class="col-12 p-0" id="notification">
                    </div>
                  </div>
                  <table class="table table-hover" id="example">
                    <thead>
                      <?php
                      if ($_SESSION['usertype'] == "admin" && empty($_GET['u'])) {
                        echo '<th>Username</th>';
                      }
                      ?>
                      <th>Date-Time</th>
                      <th>Body Temperature</th>
                      <th>Heart Rate</th>
                      <th>Blood Pressure</th>
                      <th>Diastolic</th>
                      <th>Systolic</th>
                      <th>Respiration Rate</th>
                    </thead>
                    <tbody>
                      <?php
                      $first = true;
                      if ($_SESSION['usertype'] == "admin" && empty($_GET['u'])) {
                        foreach ($valuesVital as $row)
                        {
                          if ($first) {
                            $first = false;
                          } else {
                            echo "<tr>";
                            echo "<td>" . $row[0] . "</td>";
                            echo "<td>" . date_format(date_create($row[1]),"F n, Y H:i:s") . "</td>";
                            echo "<td>" . $row[2] . "</td>";
                            echo "<td>" . $row[3] . "</td>";
                            echo "<td>" . $row[4] . "</td>";
                            echo "<td>" . $row[5] . "</td>";
                            echo "<td>" . $row[6] . "</td>";
                            echo "<td>" . $row[7] . "</td>";
                            echo "</tr>";
                          }
                        }
                      } else {
                        $username = "";
                        if (isset($_GET['u'])) {
                          $username = $_GET['u'];
                        } else {
                          $username = $_SESSION['username'];
                        }
                        foreach ($valuesVital as $row)
                        {
                          if ($row[0] == $username) {
                            echo "<tr>";
                            echo "<td>" . date_format(date_create($row[1]),"F n, Y H:i:s") . "</td>";
                            echo "<td>" . $row[2] . "</td>";
                            echo "<td>" . $row[3] . "</td>";
                            echo "<td>" . $row[4] . "</td>";
                            echo "<td>" . $row[5] . "</td>";
                            echo "<td>" . $row[6] . "</td>";
                            echo "<td>" . $row[7] . "</td>";
                            echo "</tr>";
                          }
                        }
                      }
                      ?>
                    </tbody>
                  </table>
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
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
