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
if (!isset($_SESSION['sensor'])) {
  $username = $_SESSION['username'];
  $results = $db_handle->runQuery("SELECT * FROM users WHERE username='$username' ");

  // echo '<pre>'; print_r($results[0]["sensor"]); echo '</pre>';
  $_SESSION['sensor'] = $results[0]["sensor"];



}


?>
<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v4.2.2
* @link https://coreui.io
* Copyright (c) 2022 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
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
  <div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
      <div class="container-fluid">
        <!-- <button class="header-toggler px-md-0 me-md-3" type="button"
          onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
          <svg class="icon icon-lg">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
          </svg>
        </button> -->
        <a class="header-brand d-md-none" href="#">
          <svg width="118" height="46" alt="Logo">
            <use xlink:href="assets/brand/coreui.svg#full"></use>
          </svg></a>
        <ul class="header-nav d-none d-md-flex">
          <li class="nav-item"><a class="nav-link" href="#">Logo</a></li>
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
              <div class="avatar bg-primary text-white">   <?php echo substr(ucfirst($_SESSION['username']), 0, 1);  ?></div>

           
            </a>
            <div class="dropdown-menu dropdown-menu-end pt-0">
              <div class="dropdown-header bg-light py-2">
                <div class="fw-semibold">   <?php echo ucfirst($_SESSION['username'])?>'s Account</div>

            </div>
            <a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                  </svg> Profile</a>
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
              <div class="dropdown-header bg-light py-2"> 
                <div class="fw-semibold">Settings</div>
              </div>

              <button type="button" class="dropdown-item" data-coreui-toggle="modal" data-coreui-target="#Sensor">
                <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-heart"></use>
                </svg> Sensor
              </button>
              <a class="dropdown-item" href="#">
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
          <div class="col-sm-6 col-lg-6">
            <div class="card mb-4 text-white bg-primary">
              <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>

                  <div class="fs-4 fw-semibold">
                    <asd id="latestbpm">26K</asd>
                    <svg class="icon">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-heart"></use>
                    </svg>
                  </div>

                  <div>BPM</div>
                </div>

              </div>
              <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                <canvas class="chart" id="card-chart1" height="70"></canvas>
              </div>
            </div>
          </div>
          <!-- /.col-->
          <div class="col-sm-6 col-lg-6">
            <div class="card mb-4 text-white bg-info">
              <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>

                  <div class="fs-4 fw-semibold">
                    <asd id="latesto2">26K</asd>
                    %
                  </div>

                  <div>Oxygen</div>
                </div>

              </div>
              <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                <canvas class="chart" id="card-chart1" height="70"></canvas>
              </div>
            </div>
          </div>
          <!-- /.col-->

        </div>
        <!-- /.row-->

        <div class="row">

          <div class="col-sm-12 col-lg-6">
            <div class="card mb-4">
              <div class="card-body">

                <div class="d-flex justify-content-between">
                  <div id="test">
                    <h4 class="card-title mb-0">Beats Per Minute (BPM)</h4>

                  </div>
                  <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">

                    <!-- <div class="btn-group btn-group-toggle mx-3" data-coreui-toggle="buttons">
                  <input class="btn-check" id="option1" type="radio" name="options" autocomplete="off">
                  <label class="btn btn-outline-secondary"> Day</label>
                  <input class="btn-check" id="option2" type="radio" name="options" autocomplete="off" checked="">
                  <label class="btn btn-outline-secondary active"> Month</label>
                  <input class="btn-check" id="option3" type="radio" name="options" autocomplete="off">
                  <label class="btn btn-outline-secondary"> Year</label>
                </div> -->
                    <!-- <button class="btn btn-primary" type="button">
                  <svg class="icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cloud-download"></use>
                  </svg>
                </button> -->

                    <div class="dropdown">
                      <button class="btn btn-transparent " type="button" data-coreui-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                        </svg>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">See all data</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                  <canvas class="chart" id="main-chart1" height="300"></canvas>
                </div>
              </div>

            </div>

          </div>

          <div class="col-sm-12 col-lg-6">
            <div class="card mb-4">
              <div class="card-body">

                <div class="d-flex justify-content-between">
                  <div>
                    <h4 class="card-title mb-0">Oxygen (%)</h4>

                  </div>
                  <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <!-- <div class="btn-group btn-group-toggle mx-3" data-coreui-toggle="buttons">
                  <input class="btn-check" id="option1" type="radio" name="options" autocomplete="off">
                  <label class="btn btn-outline-secondary"> Day</label>
                  <input class="btn-check" id="option2" type="radio" name="options" autocomplete="off" checked="">
                  <label class="btn btn-outline-secondary active"> Month</label>
                  <input class="btn-check" id="option3" type="radio" name="options" autocomplete="off">
                  <label class="btn btn-outline-secondary"> Year</label>
                </div> -->
                    <!-- <button class="btn btn-primary" type="button">
                  <svg class="icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cloud-download"></use>
                  </svg>
                </button> -->
                  </div>
                </div>
                <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                  <canvas class="chart" id="main-chart2" height="300"></canvas>
                </div>
              </div>

            </div>

          </div>
          <form action="index.php" method="post">

            <div class="modal fade" id="Sensor" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
              aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Sensor</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <label for="buatmodal" class="form-label">Sensor Name</label>

                    <div class="input-group mb-3" id="buatmodal">

                      <span class="input-group-text">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-heart"></use>
                        </svg></span>
                      <input name="sensorname" class="form-control" type="text"
                        placeholder="<?php echo $_SESSION['sensor'] ?>">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-primary px-4" type="submit" name="sensor">Apply</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="toast-header">
                <img src="..." class="rounded me-2" alt="...">
                <strong class="me-auto">Oximeter</strong>
                <button type="button" class="btn-close" data-coreui-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body">
                Sensor name already exist </div>
            </div>
          </div>
          <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast2" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="toast-header">
                <img src="..." class="rounded me-2" alt="...">
                <strong class="me-auto">Oximeter</strong>
                <button type="button" class="btn-close" data-coreui-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body">
                No data</div>
            </div>
          </div>
        </div>
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
  <script>


    function table() {
      const xhttp = new XMLHttpRequest();
      xhttp.open("GET", "db.php", true);

      xhttp.onload = function () {

        var data = JSON.parse(this.responseText);
        if (data.length !== 0) {
          const labelsc = [];
          const bpm = [];
          const o2 = [];
          for (var i = 0; i < data.length; i++) {

            labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
            bpm.push(data[i]["bpm"]);
            o2.push(data[i]["o2"]);

          }

          document.getElementById("latestbpm").innerHTML = bpm[0];
          document.getElementById("latesto2").innerHTML = o2[0];

          mainChart1.data.labels = labelsc;
          mainChart1.data.datasets[0].data = bpm;
          mainChart1.update();
          mainChart2.data.labels = labelsc;
          mainChart2.data.datasets[0].data = o2;
          mainChart2.update();
          // var lineGraph = new CoreUI.LineGraph('main-chart', data);

        }
        else {

          // coretoast2();
        }


      }

      xhttp.send();

    }

    setInterval(function () {
      table();
    }, 1000);

    function coretoast() {
      const toastLiveExample = document.getElementById("liveToast");
      const toast = new coreui.Toast(toastLiveExample);
      toast.show();

    }
    function coretoast2() {
      const toastLiveExample2 = document.getElementById("liveToast2");
      const toast2 = new coreui.Toast(toastLiveExample2);
      toast2.show();

    }
  </script>


  <?php if (isset($_POST['sensor'])) {

    $username = $_SESSION['username'];

    $sensor = $db_handle->escstring($_POST['sensorname']);

    if ($sensor) {
      $checkexists = $db_handle->runQuery("SELECT * FROM users WHERE sensor='$sensor'  ");
      if (!empty($checkexists)) {
        array_push($errors, "Sensor name already exists");

        // echo '<script type="text/javascript"> $("#liveToast").toast(show); </script>';
  

        echo '<script type="text/javascript">coretoast();</script>';

      }

      if (count($errors) == 0) {



        $result = $db_handle->uploadFOrder("UPDATE users SET sensor='$sensor' WHERE username='$username' ");
        if (!$result) {
          echo "Error updating record: " . $conn->error;
        }

        $_SESSION['sensor'] = $sensor;

      }
    }


  } ?>
</body>

</html>