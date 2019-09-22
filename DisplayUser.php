<?php
session_start();

require_once 'vendor/autoload.php';
require_once 'App_Code/Vital.php';
$notif = "";
$success = false;
$client = new Google_Client();
$client->setApplicationName("Google Sheets and PHP Test");
$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType("offline");
$client->setAuthConfig(__DIR__."/database-f587d7d76e58.json");
$service=new Google_Service_Sheets($client);
$spreadsheetId="1CViNms2zmRaZpO0eHePIHtKvbEFuwPPkuTFT0D0lwhI";
// DELETE START
if (!empty($_GET['delete'])) {
  $success = true;
  $notif = "User successfully deleted.";
}
if (!empty($_POST['row_delete_id'])) {
  $id = $_POST['row_delete_id'];
  $username = $_POST['row_delete_username'];
  $id_prev = $id-1;

  $deleteOperation = array(
                    'range' => array(
                        'sheetId'   => 0, // <======= This mean the very first sheet on worksheet
                        'dimension' => 'ROWS',
                        'startIndex'=> $id_prev, //Identify the starting point,
                        'endIndex'  => $id //Identify where to stop when deleting
                    )
                );
  $deletable_row[] = new Google_Service_Sheets_Request(
                        array('deleteDimension' =>  $deleteOperation)
                      );

  $delete_body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(
                        array('requests' => $deletable_row)
                      );
  $result = $service->spreadsheets->batchUpdate($spreadsheetId,$delete_body);
  $clsVital = new Vital();
  $clsVital->DeleteByUsername($username);
  header('Location: DisplayUser.php?delete=done');
}
// DELETE END
// UPDATE START
if (isset($_POST['row_id'])) {
  $id = $_POST['row_id'];
  $uname = $_POST['username'];
  $pword = $_POST['password'];
  $fname = $_POST['firstname'];
  $mname = $_POST['middlename'];
  $lname = $_POST['lastname'];
  $age = $_POST['age'];
  $gender = $_POST['gender'];
  $address = $_POST['address'];

  $exist = false;
  $rangeUser="userdata";
  $responseUser=$service->spreadsheets_values->get($spreadsheetId,$rangeUser);
  $valuesUser=$responseUser->getValues();
  $count = 0;
  foreach ($valuesUser as $row) {
    $count++;
    if ($row[0] == $uname && $count != $id) {
      $exist = true;
    }
  }

  if ($exist) {
    $notif = "Username already exist.";
    $success = false;
  } else {

    $notif = "User successfully updated.";
    $success = true;
    $range = "userdata!A".$id.":I".$id;
    $values = [[$uname, $pword,$fname,$mname,$lname,$age,$gender,$address,"client"]];
    $body = new Google_Service_Sheets_ValueRange([
      'values' => $values
    ]);
    $params = ['valueInputOption' => 'RAW'];

    $result = $service->spreadsheets_values->update($spreadsheetId,$range,$body,$params);
  }
}
//UPDATE END
$rangeUser="userdata";

$responseUser=$service->spreadsheets_values->get($spreadsheetId,$rangeUser);
$valuesUser=$responseUser->getValues();
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
                  <h4 class="card-title">Users Table</h4>
                  <p class="card-category">Here is a list of all the registered users</p>
                  <?php
                  if ($notif != "") {
                    ?>
                    <div class="alert alert-<?php echo ($success)?'success':'danger'; ?>">
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
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover" id="example">
                    <thead>
                      <th>Username</th>
                      <th>Password</th>
                      <th>First Name</th>
                      <th>Middle Name</th>
                      <th>Last Name</th>
                      <th>Age</th>
                      <th>Gender</th>
                      <th>Address</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                      <?php
                      $count = 0;
                      foreach ($valuesUser as $row)
                      {
                        if (empty($row[8])) {
                          $row[8] = "client";
                        }
                        $count++;
                        if ($row[0] != 'username' && $row[8] != "admin") {
                          echo "<tr>";
                          echo "<td>" . $row[0] . "</td>";
                          echo "<td>" . $row[1] . "</td>";
                          echo "<td>" . $row[2] . "</td>";
                          echo "<td>" . $row[3] . "</td>";
                          echo "<td>" . $row[4] . "</td>";
                          echo "<td>" . $row[5] . "</td>";
                          echo "<td>" . $row[6] . "</td>";
                          echo "<td>" . ((empty($row[7]))?'':$row[7]) . "</td>";
                          ?>
                          <td class="td-actions">
                            <a href="DisplayVital.php?u=<?php echo $row[0]; ?>" rel="tooltip" title="View" class="btn btn-secondary btn-simple btn-link">
                              <i class="fa fa-eye"></i>
                            </a>
                            <button type="button" rel="tooltip" title="Edit" class="btn btn-info btn-simple btn-link" data-toggle="modal" data-target="#modal_edit_<?php echo $count; ?>">
                              <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" rel="tooltip" title="Delete" class="btn btn-danger btn-simple btn-link" data-toggle="modal" data-target="#modal_delete_<?php echo $count; ?>" >
                              <i class="fa fa-times"></i>
                            </button>
                            <!-- Edit Modal -->
                            <div class="modal fade modal-primary" id="modal_edit_<?php echo $count; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <form method="post">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      Edit User
                                    </div>
                                    <div class="modal-body">
                                      <input type="hidden" name="row_id" value="<?php echo $count; ?>">
                                      <div class="row m-0">
                                        <div class="col-md-6 pr-1 pl-0">
                                          <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $row[0]; ?>">
                                          </div>
                                        </div>
                                        <div class="col-md-6 pl-1 pr-0">
                                          <div class="form-group">
                                            <label>Password</label>
                                            <input type="text" class="form-control" name="password" placeholder="Password" value="<?php echo $row[1]; ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row m-0">
                                        <div class="col-md-12 p-0">
                                          <div class="form-group">
                                            <label for="exampleFormControlInput1">Full Name</label>
                                            <div class="row m-0">
                                              <div class="col-4 pl-0 pr-1">
                                                <input type="text" class="form-control" name="firstname" placeholder="First Name" value="<?php echo $row[2]; ?>">
                                              </div>
                                              <div class="col-4 pl-1 pr-1">
                                                <input type="text" class="form-control" name="middlename" placeholder="Middle Name" value="<?php echo $row[3]; ?>">
                                              </div>
                                              <div class="col-4 pl-1 pr-0">
                                                <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="<?php echo $row[4]; ?>">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row m-0">
                                        <div class="col-md-6 pr-1 pl-0">
                                          <div class="form-group">
                                            <label>Age</label>
                                            <input type="number" class="form-control" name="age" placeholder="Age" value="<?php echo $row[5]; ?>">
                                          </div>
                                        </div>
                                        <div class="col-md-6 pl-1 pr-0">
                                          <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control" name="gender">
                                              <?php
                                              if ($row[6] == "M") {
                                                echo '<option value="M" selected>Male</option>
                                                      <option value="F">Female</option>';
                                              } else {
                                                echo '<option value="M">Male</option>
                                                      <option value="F" selected>Female</option>';
                                              }
                                              ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row m-0">
                                        <div class="col-md-12 p-0">
                                          <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" name="address" placeholder="House No. / Street / District / City / Province"><?php echo ((empty($row[7]))?'':$row[7]); ?></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer text-right">
                                      <div class="col-12">
                                        <input type="submit" class="btn btn-primary" value="Update" />
                                        <button type="button" class="btn btn-simple" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                            <!--  End Modal -->
                            <!-- Delete Modal -->
                            <div class="modal fade modal-primary" id="modal_delete_<?php echo $count; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form method="post">
                                    <div class="modal-header">
                                      Delete User
                                    </div>
                                    <div class="modal-body">
                                          <p>Are you sure you want to delete <?php echo $row[0]; ?>?</p>
                                    </div>
                                    <div class="modal-footer text-right">
                                      <div class="col-12">
                                        <input type="hidden" name="row_delete_id" value="<?php echo $count; ?>">
                                        <input type="hidden" name="row_delete_username" value="<?php echo $row[0]; ?>">
                                        <input type="submit" class="btn btn-danger" value="Delete" />
                                        <button type="button" class="btn btn-simple" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!--  End Modal -->
                          </td>
                          </tr>
                          <?php
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
  <!-- View Modal -->
  <div class="modal fade modal-primary" id="modal_view" tabindex="-1" role="dialog" aria-labelledby="modal_view" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post">
          <div class="modal-header">
            User Vital Signs
          </div>
          <div class="modal-body">

          </div>
          <div class="modal-footer text-right">
            <div class="col-12">
              <button type="submit" class="btn btn-danger">Clear Data</button>
              <button type="button" class="btn btn-simple" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--  End Modal -->
</body>
<!--   Core JS Files   -->
<script src="assets/js/core/jquery.3.3.1.js" type="text/javascript"></script>
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
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>
<script>
jQuery( document ).ready(function( $ ) {
  // $('[data-toggle="tooltip"]').tooltip();
});
</script>

</html>
