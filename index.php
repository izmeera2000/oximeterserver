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

<?php

include("header.php");
?>

<body>
  <?php

  include("sidebar.php");
  ?>
  <div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <?php
    $pagetitle = "Dashboard";
    include("topbar.php");
    ?>
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
        <div class="col-lg-4 col-12">
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
        <div class="col-lg-4 col-12">
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
        <div class="col-lg-4 col-12">
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
  <?php

  include("footer.php");
  ?>
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