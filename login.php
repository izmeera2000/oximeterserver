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
<?php

include("header.php");
?>

<body>
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 d-flex align-items-center justify-content-center">
          <img style="height:150px" src="assets/favicon/parameter-removebg-preview.png" class="img text-center"
            alt="Logo">

        </div>

        <div class="col-12">
          <h5 class="text-center">

            Sistem Pemantauan Suhu, Kelembapan Dan Gas</h5>

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