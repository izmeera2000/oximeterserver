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


?>
<!DOCTYPE html>

<!-- Breadcrumb-->
<html lang="en">

<head>
  <base href="./">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
  <meta name="author" content="Łukasz Holeczek">
  <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
  <title>Oximeter</title>
  <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="assets/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <!-- Vendors styles-->
  <link rel="stylesheet" href="vendors/simplebar/css/simplebar.css">
  <link rel="stylesheet" href="css/vendors/simplebar.css">
  <!-- Main styles for this application-->
  <link href="css/style.css" rel="stylesheet">
  <!-- We use those styles to show code examples, you should remove them in your application.-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
  <link href="css/examples.css" rel="stylesheet">
  <!-- Global site tag (gtag.js) - Google Analytics-->
  <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    // Shared ID
    gtag('config', 'UA-118965717-3');
    // Bootstrap ID
    gtag('config', 'UA-118965717-5');
  </script>
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
      <li class="nav-item"><a class="nav-link" href="bpm.php">
          <svg class="nav-icon">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-graph"></use>
          </svg> Beats Per Minute</a></li>
      <li class="nav-item"><a class="nav-link" href="o2.php">
          <svg class="nav-icon">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chart"></use>
          </svg> Oxygen</a></li>


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
          <img style="height:48px" src="assets/favicon/android-icon-144x144.png" class="img" alt="Oximeter Logo"></a>
        <ul class="header-nav d-none d-md-flex">
          <li class="nav-item">
            <a class="nav-link" href="index.php"><img style="height:48px" src="assets/favicon/android-icon-144x144.png"
                class="img" alt="Oximeter Logo">Oximeter
            </a>
          </li>
          <!-- <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Settings</a></li> -->
        </ul>
        <ul class="header-nav ms-auto">
          <!-- <li class="nav-item"><a class="nav-link" href="#">
              <svg class="icon icon-lg">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
              </svg></a></li>
          <li class="nav-item"><a class="nav-link" href="#">
              <svg class="icon icon-lg">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-list-rich"></use>
              </svg></a></li>
          <li class="nav-item"><a class="nav-link" href="#">
              <svg class="icon icon-lg">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
              </svg></a></li> -->
        </ul>
        <ul class="header-nav ms-3">
          <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button"
              aria-haspopup="true" aria-expanded="false">
              <!-- <div class="avatar avatar-md"><img class="avatar-img" src="assets/img/avatars/8.jpg" alt="user@email.com">
              </div> -->
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
              <!-- <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                </svg> Profile</a> -->
              <!-- <a class="dropdown-item" href="#">
                <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                </svg> Updates<span class="badge badge-sm bg-info ms-2">42</span></a>
                
                <a class="dropdown-item" href="#">
                <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                </svg> Messages<span class="badge badge-sm bg-success ms-2">42</span></a><a class="dropdown-item"
                href="#">
                <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-task"></use>
                </svg> Tasks<span class="badge badge-sm bg-danger ms-2">42</span></a><a class="dropdown-item" href="#">
                <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-comment-square"></use>
                </svg> Comments<span class="badge badge-sm bg-warning ms-2">42</span></a> -->
              <!-- <div class="dropdown-header bg-light py-2">
                <div class="fw-semibold">Settings</div>
              </div> -->


              <!-- <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                </svg> Settings</a> -->
              <!-- <a class="dropdown-item" href="#">
                <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-credit-card"></use>
                </svg> Payments<span class="badge badge-sm bg-secondary ms-2">42</span></a> -->
              <!-- <a class="dropdown-item"
                href="#">
                <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-file"></use>
                </svg> Projects<span class="badge badge-sm bg-primary ms-2">42</span></a>
              <div class="dropdown-divider"></div> -->
              <!-- <a class="dropdown-item" href="#">
                <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                </svg> Lock Account</a> -->
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
            <div class="card mb-4">
              <div class="card-body">

                <div class="d-flex justify-content-between">
                  <div id="test">
                    <h4 class="card-title mb-0">Beats Per Minute (BPM) </h4>
                  </div>
                  <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">

                    <div class="dropdown">
                      <button class="btn btn-transparent " type="button" data-coreui-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                        </svg>
                      </button>

                    </div>

                  </div>
                </div>
                <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                  <canvas class="chart" id="main-chart1" height="300"></canvas>
                </div>
              </div>

            </div>

          </div>

          <div class="col-sm-12 col-lg-12">
            <div class="card mb-4 text-white bg-dark">

              <div class="card-body">
                <form action="bpm.php" method="post">

                  <div class="d-flex justify-content-between">
                    <div>
                      <h4 class="card-title mb-0">Patient
                        <?php

                        if (isset($_SESSION['patient_username'])) {

                          $patientname = ($_SESSION['patient_username']);
                          echo "($patientname)";
                        }

                        ?>
                      </h4>
                    </div>



                    <div class="btn-toolbar d-block d-md-block" role="toolbar" aria-label="Toolbar with buttons">


                      <button class="btn btn-light" type="submit" name="bpmrange">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-find-in-page"></use>
                        </svg>
                      </button>

                    </div>
                  </div>

                  <div class="c-chart-wrapper">
                    <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-83">
                      <div class="row g-3">

                        <div class="input-group">
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
                    </div>

                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php
          if (isset($_POST['bpmrange'])) { ?>
            <div class="col-sm-12 col-lg-12">
              <div class="card mb-4">
                <div class="card-body">

                  <div class="d-flex justify-content-between mb-4">
                    <div>

                    </div>



                    <div class="btn-toolbar d-block d-md-block" role="toolbar" aria-label="Toolbar with buttons">

                      <a class="btn btn-light" href="bpmpdf.php" target="_blank">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-print"></use>
                        </svg>
                      </a>


                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table border mb-0">
                      <thead class="table-light fw-semibold">
                        <tr class="align-middle">

                          <th>Patient Username</th>
                          <th>Beats Per Minute (BPM)</th>
                          <th>Date And Time</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (isset($_POST['bpmrange'])) {
                          $sensor = $_SESSION['sensor'];
                          $max = $_POST['daterange2'];
                          $min = $_POST['daterange1'];
                          $maxtime = $_POST['timerange2'];
                          $mintime = $_POST['timerange1'];




                          $newmax = date("Y-m-d H:i:s", strtotime($maxtime, strtotime($max)));
                          // echo $newmax;
                          $newmin = date("Y-m-d H:i:s", strtotime($mintime, strtotime($min)));
                                                    // echo $newmin;

                          $_SESSION["minrangebpm"] = $newmin;
                          $_SESSION["maxrangebpm"] = $newmax;
                          $results = $db_handle->runQuery("SELECT sensor,bpm,DATE_FORMAT(reading_time,  '%H:%i:%s %d-%m-%Y') FROM sensordata WHERE sensor='$sensor ' AND reading_time BETWEEN '$newmin' AND '$newmax'");

                          if ($results) {
                            $bpm = array_column($results, 'bpm');
                            $minbpm = min($bpm);
                            $maxbpm = max($bpm);
                            $answer = 55 / 160 * 100;
                            // echo $answer;
                      
                            foreach ($results as $element) {
                              echo '<tr class="align-middle">';
                              echo '    <td> <div>' . $element["sensor"] . '</div></td>';
                              $barwidth = $element["bpm"] / $maxbpm * 100;

                              if ($element["bpm"] >= 90 && $element["bpm"] <= 100) {
                                echo '<td><div class="clearfix"><div class="float-start"><div class="fw-semibold">' . $element["bpm"] . '</div></div></div><div class="progress progress-thin"><div class="progress-bar bg-success" style="width: ' . $barwidth . '%"></div></div></td>';

                              } else if (($element["bpm"] >= 70 && $element["bpm"] < 90) || ($element["bpm"] > 100 && $element["bpm"] <= 120)) {
                                echo '<td><div class="clearfix"><div class="float-start"><div class="fw-semibold">' . $element["bpm"] . '</div></div></div><div class="progress progress-thin"><div class="progress-bar bg-warning" style="width: ' . $barwidth . '%"></div></div></td>';

                              } else {

                                echo '<td><div class="clearfix"><div class="float-start"><div class="fw-semibold">' . $element["bpm"] . '</div></div></div><div class="progress progress-thin"><div class="progress-bar bg-danger" style="width: ' . $barwidth . '%"></div></div></td>';

                              }
                              // echo '<td><div class="clearfix"><div class="float-start"><div class="fw-semibold">' . $element["bpm"] . '</div></div></div><div class="progress progress-thin"><div class="progress-bar bg-success" style="width: '. $barwidth. '%"></div></div></td>';
                      
                              echo '<td><div class="fw-semibold">' . $element["DATE_FORMAT(reading_time,  '%H:%i:%s %d-%m-%Y')"] . '</div></td>';
                              echo '</tr>';
                            }

                          } else {
                            echo '<script type="text/javascript">coretoast("Sensor data with the time range cannot be found")</script>';

                          }
                        }


                        ?>


                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          <?php } ?>


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
  <script>


    function table() {
      const xhttp = new XMLHttpRequest();
      xhttp.open("GET", "db.php", true);

      xhttp.onload = function () {

        var data = JSON.parse(this.responseText);
        if (data.length !== 0) {
          const labelsc = [];
          const bpm = [];
          for (var i = 0; i < data.length; i++) {

            labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
            bpm.push(data[i]["bpm"]);


          }


          mainChart1.data.labels = labelsc;
          mainChart1.data.datasets[0].data = bpm;
          mainChart1.update();

        }
      }
      xhttp.send();
    }
    setInterval(function () {
      table();
    }, 1000);

    function coretoast($content) {
      const toastLiveExample = document.getElementById("liveToast");
      const toastcontent = document.getElementById("content");
      toastcontent.innerHTML = $content;
      const toast = new coreui.Toast(toastLiveExample);
      toast.show();

    }

  </script>
  <?php
  if (!isset($_SESSION['sensor'])) {
    echo '<script type="text/javascript">coretoast("Sensor not found")</script>';

  }

  ?>

  <?php if (isset($_POST['sensor'])) {

    $patient = $_SESSION['patient_username'];

    $sensor = $db_handle->escstring($_POST['sensorname']);

    if ($sensor) {
      $checkexists = $db_handle->runQuery("SELECT * FROM users WHERE sensor='$sensor'  ");
      if (!empty($checkexists)) {
        array_push($errors, "Sensor name already used by other patient");

        echo '<script type="text/javascript">coretoast("Sensor name already used by other patient");</script>';

      }

      if (count($errors) == 0) {



        $result = $db_handle->uploadFOrder("UPDATE users SET sensor='$sensor'   WHERE username='$patient' ");
        // if (!$result) {
        //   echo "Error updating record: " . $conn->error;
        // }
  
        // $_SESSION['sensor'] = $sensor;
  
      }
    }


  } ?>


</body>

</html>