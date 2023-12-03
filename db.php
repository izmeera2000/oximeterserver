<?php
session_start();
require_once("controller/dbcontroller.php");
$db_handle = new DBController();

$sensor = $_SESSION['sensor'];

if (isset($_GET["time1"] )&& isset($_GET["time2"])) {
    $time1 = $_GET["time1"];
    $time2 = $_GET["time2"];
    $result = $db_handle->runQuery2("SELECT id , sensor , DATE_FORMAT(reading_time, '%H:%i:%s'),DATE_FORMAT(reading_time, '%d-%m-%Y'), gas, suhu,kelembapan FROM sensordata WHERE sensor ='$sensor'  AND reading_time BETWEEN '$time1' AND '$time2' ORDER BY reading_time DESC  ");

}
else{

// Retrieve the data from the database
// $result = $conn->query($sql);
$result = $db_handle->runQuery2("SELECT id , sensor , DATE_FORMAT(reading_time, '%H:%i:%s'),DATE_FORMAT(reading_time, '%d-%m-%Y'), gas, suhu,kelembapan FROM sensordata WHERE sensor ='$sensor' ORDER BY reading_time DESC LIMIT  10");
// Store the data in an array
}
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the connection

// Encode the data as JSON and return it to the JavaScript code
echo json_encode($data);
?>