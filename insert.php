<?php

session_start();
require_once("controller/dbcontroller.php");
$db_handle = new DBController();

$api_key_value = "oxy1";

$api_key = $bpm = $o2 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {

        $bpm = test_input($_POST["bpm"]);
        $o2 = test_input($_POST["o2"]);
        
        $db_handle->uploadFOrder("INSERT INTO sensordata (sensor,bpm,o2) VALUES ('oxy1','$bpm','$o2') ");

    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}