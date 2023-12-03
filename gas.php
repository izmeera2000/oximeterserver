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




if (isset($_POST['findpatient'])) {
  $username = $_POST['patientname'];
  $results = $db_handle->runQuery("SELECT * FROM users WHERE username='$username' ");
  $_SESSION['patient_username'] = $username;
  $_SESSION['sensor'] = $results[0]["sensor"];


}
if (isset($_POST['bpmrangereset'])) {
  unset($_SESSION["minrangebpm"]);
  unset($_SESSION["maxrangebpm"]);

}

?>
<!DOCTYPE html>

<!-- Breadcrumb-->
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
    $pagetitle = "Suhu";

    include("topbar.php");
    ?>

    <div class="body flex-grow-1 px-3">
      <div class="container-lg">

        <div class="row">

          <div class="col-sm-12 col-lg-12">
            <div class="card mb-4">
              <div class="card-body">

                <div class="d-flex justify-content-between">
                  <div id="test">
                    <h4 class="card-title mb-0">Gas</h4>
                  </div>
                  <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <?php
                    if (isset($_SESSION['sensor'])) {
                      ?>
                      <button type="button" class="btn btn-light" data-coreui-toggle="modal" data-coreui-target="#Sensor">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                        </svg>
                      </button>
                    <?php } ?>

                  </div>
                </div>
                <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                  <canvas class="chart" id="main-chart1" height="300"></canvas>
                </div>
              </div>

            </div>

          </div>





          <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="toast-header">
                <img src="assets/favicon/android-icon-48x48.png" class="img" alt="Oximeter Logo">

                <strong class="me-auto">Oximeter</strong>
                <button type="button" class="btn-close" data-coreui-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body" id="content">
              </div>
            </div>
          </div>

        </div>
        <!-- /.row-->
        <!-- /.card.mb-4-->

      </div>


    </div>
    <!-- /.row-->

    <form action="suhu.php" method="post">
      <div class="modal fade" id="Sensor" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Settings</h5>
              <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <label for="buatmodal" class="form-label">Date And Time Range</label>
              <div class="input-group mb-3" id="buatmodal">
                <?php
                if (isset($_SESSION['sensor'])) {
                  $sensor = $_SESSION['sensor'];
                  $results = $db_handle->runQuery("SELECT DATE_FORMAT(reading_time, '%Y-%m-%d') FROM sensordata WHERE sensor='$sensor'ORDER BY id ASC ");
                  $min = $results[0]["DATE_FORMAT(reading_time, '%Y-%m-%d')"];
                  $max = end($results)["DATE_FORMAT(reading_time, '%Y-%m-%d')"];
                  echo '<input type="date" class="form-control text-center" name="daterange1" max=' . $max . ' min=' . $min . '>';
                  echo '<span class="input-group-text">-</span>';
                  echo '<input type="date" class="form-control text-center" name="daterange2" max=' . $max . ' min=' . $min . '>';
                }
                ?>
              </div>
              <div class="input-group">
                <?php
                echo '<input type="time" class="form-control text-center" name="timerange1" >';
                echo '<span class="input-group-text">-</span>';
                echo '<input type="time" class="form-control text-center" name="timerange2" >';
                ?>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary px-4" type="submit" name="rangereset">Reset Range</button>
              <button class="btn btn-primary px-4" type="submit" name="range">Apply</button>
            </div>
          </div>
        </div>
      </div>
    </form>

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
  if (!isset($_SESSION['sensor'])) {
    array_push($errors, "Sensor not found");

  } else {
    if (isset($_POST['range'])) {
      $sensor = $_SESSION['sensor'];
      $max = $_POST['daterange2'];
      $min = $_POST['daterange1'];
      $maxtime = $_POST['timerange2'];
      $mintime = $_POST['timerange1'];
      $_SESSION["max"] = $max;
      $_SESSION["min"] = $min;
      $_SESSION["maxtime"] = $maxtime;
      $_SESSION["mintime"] = $mintime;
      $newmax = date("Y-m-d H:i:s", strtotime('+59 seconds', strtotime($maxtime, strtotime($max))));
      // echo $newmax;
      $newmin = date("Y-m-d H:i:s", strtotime($mintime, strtotime($min)));
      // echo $newmin;
  
      $_SESSION["minrangeo2"] = $newmin;
      $_SESSION["maxrangeo2"] = $newmax;

      echo "<script>gaschart1('" . $_SESSION["minrangeo2"] . "','" . $_SESSION["maxrangeo2"] . "');</script>";

    } else {
      echo "<script>gaschart1();</script>";

    }


  }
  ?>

  <?php if (isset($_POST['sensor'])) {

    $patient = $_SESSION['patient_username'];

    $sensor = $db_handle->escstring($_POST['sensorname']);

    if ($sensor) {
      $checkexists = $db_handle->runQuery("SELECT * FROM users WHERE sensor='$sensor'  ");
      if (!empty($checkexists)) {
        array_push($errors, "Sensor name already used by other patient");


      }

      if (count($errors) == 0) {



        $result = $db_handle->uploadFOrder("UPDATE users SET sensor='$sensor'   WHERE username='$patient' ");

      }
    }


  }

  if (!count($errors) == 0) {

    foreach ($errors as $error) {

      echo '<script type="text/javascript">coretoast("' . $error . '")</script>';
    }
  }
  ?>


</body>

</html>