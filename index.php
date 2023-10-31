<?php
session_start();
require_once("controller/dbcontroller.php");
$db_handle = new DBController();

if (!isset($_SESSION['username'])) {
  header('location: login.php');
}
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}

if (isset($_POST['findsensor'])) {


  // $username = $_POST['patientname'];
  // $results = $db_handle->runQuery("SELECT * FROM users WHERE username='$username' ");
  // $_SESSION['patient_username'] = $username;
  // $_SESSION['patient_name'] = $results[0]["name"];
  // $_SESSION['sensor'] = $results[0]["sensor"];

  $sensor = $_POST['sensor'];
  $results = $db_handle->runQuery("SELECT * FROM sensordata WHERE sensor='$sensor' ");
  $_SESSION['sensor'] = $results[0]["sensor"];


}
if (($_SESSION["accesslevel"] == 1)) {
  header('location: index2.php');
}

// if (isset($_POST['sensor'])) {

// $patient = $_SESSION['patient_username'];

// $sensor = $db_handle->escstring($_POST['sensorname']);

// if ($sensor) {
//   $checkexists = $db_handle->runQuery("SELECT * FROM users WHERE sensor='$sensor'  ");
//   if (!empty($checkexists)) {
//     array_push($errors, "Sensor name already used by other patient");
//   }
//   if (count($errors) == 0) {
//     $result = $db_handle->uploadFOrder("UPDATE users SET sensor='$sensor' WHERE username='$patient' ");
//     array_push($errors, "Sensor name changed");
//     $_SESSION['sensor'] = $sensor;
//   }
// }


// }

?>
<!DOCTYPE html>

<html lang="en">

<head>
  <base href="./">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
  <meta name="author" content="Łukasz Holeczek">
  <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
  <title>BME680 Server</title>

  <link rel="icon" type="image/png"  href="assets/favicon/parameter-removebg-preview.png">

  <meta name="theme-color" content="#ffffff">
  <!-- Vendors styles-->
  <link rel="stylesheet" href="vendors/simplebar/css/simplebar.css">
  <link rel="stylesheet" href="css/vendors/simplebar.css">
  <!-- Main styles for this application-->
  <link href="css/style.css" rel="stylesheet">
  <!-- We use those styles to show code examples, you should remove them in your application.-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
  <link href="css/examples.css" rel="stylesheet">

  <link href="vendors/@coreui/chartjs/css/coreui-chartjs.css" rel="stylesheet">
</head>

<body>
  <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">

    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
      <li class="nav-item"><a class="nav-link" href="index.php">
          <svg class="nav-icon">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-speedometer"></use>
          </svg> Dashboard</a></li>
      <li class="nav-title">Page</li>
      <li class="nav-item"><a class="nav-link" href="list.php">
          <svg class="nav-icon">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-list"></use>
          </svg>Suhu</a></li>
      <li class="nav-item"><a class="nav-link" href="exportdata.php">
          <svg class="nav-icon">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-graph"></use>
          </svg>Kelembapan</a></li>
      <li class="nav-item"><a class="nav-link" href="o2.php">
          <svg class="nav-icon">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chart"></use>
          </svg>Gas</a></li>


    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
  </div>
  <div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
      <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button"
          onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
          <svg class="icon icon-lg">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
          </svg>
        </button>

        <a class="header-brand d-md-none" href="#">
          <!-- logo -->
          <img style="height:48px" src="assets/favicon/parameter-removebg-preview.png" class="img" alt="Oximeter Logo">
          <!-- logo -->
        </a>
        <ul class="header-nav d-none d-md-flex">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <!-- logo -->
              <img style="height:48px" src="assets/favicon/parameter-removebg-preview.png" class="img" alt="Logo">
              <!-- logo -->
              BME680 Server
            </a>
          </li>

        </ul>
        <ul class="header-nav ms-auto">

        </ul>
        <ul class="header-nav ms-3">
          <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button"
              aria-haspopup="true" aria-expanded="false">

              <div class="avatar bg-primary text-white">
                <?php echo substr(ucfirst($_SESSION['username']), 0, 1); ?>
              </div>


            </a>
            <div class="dropdown-menu dropdown-menu-end pt-0">
              <div class="dropdown-header bg-light py-2">
                <div class="fw-semibold">
                  <?php echo ucfirst($_SESSION['username']) ?>'s Account
                </div>

              </div>

              <a class="dropdown-item" href="?logout='1'">
                <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                </svg> Logout</a>
            </div>
          </li>
        </ul>
      </div>
      <div class="header-divider"></div>
      <div class="container-fluid">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
              <!-- if breadcrumb is single--><span>Home</span>
            </li>
            <li class="breadcrumb-item active"><span>Dashboard</span></li>
          </ol>
        </nav>
      </div>
    </header>
    <div class="body flex-grow-1 px-3">
      <div class="container-lg">
        <div class="row">
          <div class="col-sm-12 col-lg-12">
            <div class="card mb-4 text-white bg-dark">

              <div class="card-body">
                <form action="index.php" method="post">

                  <div class="d-flex justify-content-between">
                    <div>
                      <h4 class="card-title mb-0">Sensor</h4>
                      <?php
                      if (isset($_SESSION['sensor'])) {
                        echo '<div class="fs-4 ">Name : ';
                        echo $_SESSION['sensor'];
                        echo '</div>';

                      } ?>
                    </div>

                    <div class="btn-toolbar d-block d-md-block" role="toolbar" aria-label="Toolbar with buttons">


                      <button class="btn btn-light" type="submit" name="findsensor">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-find-in-page"></use>
                        </svg>
                      </button>


                      <!-- daa -->

                    </div>
                  </div>
                  <?php
                  if (!isset($_SESSION['patient_username'])) {

                    echo '<div class="c-chart-wrapper">';
                    echo '<div class="tab-pane p-3 active preview" id="preview-839">';
                    echo '<select class="form-select" name="sensor">';

                    $resultpatient = $db_handle->runQuery("SELECT * FROM `sensordata` GROUP BY sensor;
                    ");

                    if (!isset($_SESSION['sensor'])) {
                      echo '<option selected="" disabled>Please Select Sensor</option>';
                    } else {

                    }

                    foreach ($resultpatient as $row => $value) {
                      echo "<option value=" . $value['sensor'] . ">" . $value['sensor'] . "</option>";
                    }
                    echo '</select>';

                    ?>
                </div>
              </div>
            <?php } ?>

            </form>

          </div>


        </div>
      </div>


    </div>
    <!-- /.row-->


    <?php
    if (isset($_SESSION['sensor'])) { ?>
      <div class="row">
        <div class="col-4">
          <div class="card mb-4">
            <div class="card-header">
              <h3 class="card-title mb-0">Suhu</h3>
            </div>

            <div class="card-body">

              <div class="d-flex justify-content-between">


                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">

                </div>
              </div>
              <canvas id="suhu"></canvas>

            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card mb-4">
            <div class="card-header">
              <h3 class="card-title mb-0">Kelembapan</h3>
            </div>

            <div class="card-body">

              <div class="d-flex justify-content-between">


                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">

                </div>
              </div>
              <canvas id="kelembapan"></canvas>

            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card mb-4">
            <div class="card-header">
              <h3 class="card-title mb-0">Gas</h3>
            </div>

            <div class="card-body">

              <div class="d-flex justify-content-between">


                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">

                </div>
              </div>
              <canvas id="gas"></canvas>

            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    <!-- /.row-->
    <!-- /.card.mb-4-->

  </div>
  </div>
  <footer class="footer">
    <div>Impeccable Vision Sdn Bhd © 2022</div>
    <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/docs/">CoreUI UI Components</a></div>
  </footer>
  </div>
  <!-- CoreUI and necessary plugins-->
  <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
  <script src="vendors/simplebar/js/simplebar.min.js"></script>
  <!-- Plugins and scripts required by this view-->
  <script src="vendors/chart.js/js/chart.min.js"></script>
  <script src="vendors/@coreui/chartjs/js/coreui-chartjs.js"></script>
  <script src="vendors/@coreui/utils/js/coreui-utils.js"></script>
  <script src="js/main.js"></script>


  <?php
  if (isset($_SESSION['sensor'])) {
    echo "<script>indexchart();</script>";

  }
  if (!count($errors) == 0) {

    foreach ($errors as $error) {

      echo '<script>coretoast("' . $error . '");</script>';
    }
  } ?>


</body>

</html>