<?php

session_start();
require_once("controller/dbcontroller.php");
$db_handle = new DBController();

$api_key_value = "tPmAT5Ab3j7F9";

$api_key = $bpm = $o2 = $sensorname = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {

        $sensorname = test_input($_POST["sensor"]);
        $gas = test_input($_POST["gas"]);
        $kelembapan = test_input($_POST["kelembapan"]);
        $suhu = test_input($_POST["suhu"]);
        
        
        $db_handle->uploadFOrder("INSERT INTO sensordata (sensor,gas,kelembapan,suhu) VALUES ('$sensorname','$gas','$kelembapan','$suhu') ");
        echo "data sent";

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