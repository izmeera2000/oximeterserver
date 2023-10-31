<?php
session_start();
require_once("controller/dbcontroller.php");
$db_handle = new DBController();




if (isset($_POST['lgn'])) {
  $username = $db_handle->escstring($_POST['username']);
  $password = $db_handle->escstring($_POST['password']);
  if (count($errors) == 0) {
    $password = md5($password);

    $results = $db_handle->uploadFOrder("SELECT * FROM users WHERE username='$username' AND password='$password'  ");

    if (mysqli_num_rows($results) == 1 && $password != md5("oximeter")) {
      $_SESSION['username'] = $username;

      while ($row = $results->fetch_array()) {
        if ($row["accesslevel"] == 0) {
          $_SESSION['accesslevel'] = $row["accesslevel"];
          header('location: index.php');
        } else {
          $_SESSION['accesslevel'] = $row["accesslevel"];
          header('location: index2.php');
        }
      }
    } else if (mysqli_num_rows($results) == 1 && $password == md5("oximeter")) {
      $_SESSION['usernamenew'] = $username;
      array_push($errors, "New patient, please insert new password");
    } else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}


if (isset($_POST['newuser'])) {

  $username = $_SESSION['usernamenew'];
  // $name = $db_handle->escstring($_POST['name']);
  // $email = $db_handle->escstring($_POST['email']);
  $password_1 = $db_handle->escstring($_POST['password_1']);
  $password_2 = $db_handle->escstring($_POST['password_2']);

  if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
  }
  if (count($errors) == 0) {
    $passwordnew = md5($password_1); //encrypt the password before saving in the database
    $db_handle->uploadFOrder("UPDATE users SET password='$passwordnew' WHERE  username='$username' ");
    unset($_SESSION['usernamenew']);
    $_SESSION['username'] = $username;
    $results2 = $db_handle->uploadFOrder("SELECT * FROM users WHERE username='$username' LIMIT 1  ");
    while ($row2 = $results2->fetch_array()) {
      $_SESSION['accesslevel'] = $row2["accesslevel"];
      header('location: index2.php');
    }
  }
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
</head>

<body>
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">

        <div class="col-12">
        <h1 class="text-center">Tajuk</h1>

        </div>
        <div class="col-lg-8">
          <div class="card-group d-block d-md-flex row">
            <div class="card col-md-7 p-4 mb-0">
              <form action="login.php" method="post">

                <div class="card-body">
                  <h1>Login</h1>
                  <p class="text-medium-emphasis">Sign In to your account</p>
                  <?php include('errors.php'); ?>
                  <?php
                  if (!isset($_SESSION['usernamenew'])) { ?>
                    <div class="input-group mb-3"><span class="input-group-text">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                        </svg></span>
                      <input name="username" class="form-control" type="text" placeholder="Username">
                    </div>
                    <div class="input-group mb-4"><span class="input-group-text">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                        </svg></span>
                      <input name="password" class="form-control" type="password" placeholder="Password">
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <button class="btn btn-primary px-4" type="submit" name="lgn">Login</button>
                      </div>
                    </div>

                  <?php } else { ?>

                    <div class="input-group mb-4"><span class="input-group-text">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                        </svg></span>
                      <input name="password_1" class="form-control" type="password" placeholder="Password">
                    </div>
                    <div class="input-group mb-4"><span class="input-group-text">
                        <svg class="icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                        </svg></span>
                      <input name="password_2" class="form-control" type="password" placeholder="Confirm Password">
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <button class="btn btn-primary px-4" type="submit" name="newuser">Login
                        </button>
                      </div>

                    </div>

                  <?php } ?>

                </div>
              </form>
            </div>
            <div class="card col-md-5 text-white bg-primary py-5">
              <div class="card-body text-center">
                <div>
                  <h2>Register</h2>
                  <p>Register as admininstrator to manage patients and get sensor data from patients. </p>
                  <button class="btn btn-lg btn-outline-light mt-3" type="button"
                    onclick="location.href='register.php'">Register Now!</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- CoreUI and necessary plugins-->
  <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
  <script src="vendors/simplebar/js/simplebar.min.js"></script>
  <script>
  </script>

</body>

</html>