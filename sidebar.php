<?php
$page = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
?>
<div class="sidebar" data-image="assets/img/sidebar-5.jpg">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

    Tip 2: you can also add an image using data-image tag
-->
  <div class="sidebar-wrapper">
    <div class="logo">
      <a href="" class="simple-text">
        VSM
      </a>
    </div>
    <ul class="nav">
      <!-- <li>
        <a class="nav-link" href="dashboard.html">
          <i class="nc-icon nc-chart-pie-35"></i>
          <p>Dashboard</p>
        </a>
      </li> -->
      <?php
      if ($_SESSION['usertype'] == "admin") {
        ?>
        <li class="nav-item <?php echo ($page == 'DisplayUser.php')?'active':''; ?>">
          <a class="nav-link" href="./DisplayUser.php">
            <i class="nc-icon nc-circle-09"></i>
            <p>User Profile</p>
          </a>
        </li>
        <?php
      }
      ?>
      <li class="nav-item <?php echo ($page == 'DisplayVital.php')?'active':''; ?>">
        <a class="nav-link" href="./DisplayVital.php">
          <i class="nc-icon nc-notes"></i>
          <p>Vital Data</p>
        </a>
      </li>
      <li>
        <a class="nav-link" href="./logout.php">
          <i class="nc-icon nc-button-power"></i>
          <p>Logout</p>
        </a>
      </li>
    </ul>
  </div>
</div>
