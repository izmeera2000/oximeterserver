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

if (isset($_POST['registerpatient'])) {

  $username = $db_handle->escstring($_POST['username']);
  $name = $db_handle->escstring($_POST['name']);
  $email = $db_handle->escstring($_POST['email']);


  $password = md5("oximeter"); //encrypt the password before saving in the database


  $checkexists = $db_handle->runQuery("SELECT * FROM users WHERE username='$username'  ");
  if (!empty($checkexists)) {
    array_push($errors, "Username already exists");

  }

  if (count($errors) == 0) {



    $db_handle->uploadFOrder("INSERT INTO users (username,name,email,password,accesslevel) VALUES ('$username','$name','$email','$password','1') ");


  }
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
          </svg> Patient List</a></li>
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
            <li class="breadcrumb-item active"><span>BPM</span></li>
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

                <div class="d-flex justify-content-between mb-4">
                  <div>
                    <h4 class="card-title mb-0">
                      Patient List
                    </h4>
                  </div>



                  <div class="btn-toolbar d-block d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <button type="button" class="btn btn-light" data-coreui-toggle="modal" data-coreui-target="#Sensor">
                      <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-input"></use>
                      </svg>
                    </button>


                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table border mb-0" id="tablebpm">
                    <thead class="table-light fw-semibold">
                      <tr class="align-middle">

                        <th>Patient Username</th>
                        <th>Sensor</th>
                        <th>Activity</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php




                      $results = $db_handle->runQuery("SELECT username,sensor,name,DATE_FORMAT(inserttime,  '%d %M, %Y') FROM users WHERE accesslevel='1' ");

                      if ($results) {


                        foreach ($results as $element) {
                          echo '<tr class="align-middle">';
                          echo '    <td> <div>' . $element["username"] . '</div><div class="small text-medium-emphasis">Registered: ' . $element["DATE_FORMAT(inserttime,  '%d %M, %Y')"] . '</div>
                            </td>';

                          if ($element["sensor"]) {
                            echo '<td><div class="clearfix"><div class="float-start"><div class="fw-semibold">' . $element["sensor"] . '</div></div></div></td>';

                            $sensorname = $element["sensor"];
                            $results2 = $db_handle->runQuery("SELECT reading_time FROM sensordata WHERE sensor='$sensorname' LIMIT 1");

                            if ($results2) {
                              foreach ($results2 as $element2) {
                                echo '<td><div class="small text-medium-emphasis">Last upload</div>
                            <div class="fw-semibold">' . $element2["reading_time"] . '</div></td>';
                                echo '</tr>';
                              }
                            } else {
                              echo '<td><div class="small text-medium-emphasis">Last upload</div>
                            <div class="fw-semibold">Not found</div></td>';
                              echo '</tr>';
                            }

                          } else {
                            echo '<td><div class="clearfix"><div class="float-start"><div class="fw-semibold">Not found</div></div></div></td>';
                            echo '<td><div class="small text-medium-emphasis">Last upload</div>
                            <div class="fw-semibold">Not found</div></td>';
                            echo '</tr>';

                          }


                        }
                      } else {
                        array_push($errors, "No Data Found From Patient List");

                      }



                      ?>


                    </tbody>
                  </table>
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

    <form action="list.php" method="post">

      <div class="modal fade" id="Sensor" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Settings</h5>
              <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <label for="buatmodal" class="form-label mb-3">Register patient</label>

              <div class="input-group mb-3"><span class="input-group-text">
                  <svg class="icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>

                  </svg></span>
                <input name="username" class="form-control" type="text" placeholder="Username" required>
              </div>
              <div class="input-group mb-3"><span class="input-group-text">
                  <svg class="icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>

                  </svg></span>
                <input name="name" class="form-control" type="text" placeholder="Name" required>
              </div>
              <div class="input-group mb-3"><span class="input-group-text">
                  <svg class="icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                  </svg></span>
                <input name="email" class="form-control" type="text" placeholder="Email" required>
              </div>

            </div>
            <div class="modal-footer">
              <button class="btn btn-primary px-4" type="submit" name="registerpatient">Register</button>
            </div>
          </div>
        </div>
      </div>
    </form>

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