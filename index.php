<?php
session_start();
if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
  if ($_SESSION['usertype'] == "admin") {
    header('Location: DisplayUser.php');
  } else {
    header('Location: DisplayVital.php');
  }
} else {
  header('Location: login.php');
}
?>
