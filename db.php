<?php
session_start();
require_once("controller/dbcontroller.php");
$db_handle = new DBController();

$sensor = $_SESSION['sensor'];


// Retrieve the data from the database
// $result = $conn->query($sql);
$result = $db_handle->runQuery2("SELECT id , sensor , DATE_FORMAT(reading_time, '%H:%i:%s'),DATE_FORMAT(reading_time, '%d-%m-%Y'), value1, value2,value3 FROM sensordata WHERE sensor ='$sensor' ORDER BY id DESC LIMIT 10 ");
// Store the data in an array

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the connection

// Encode the data as JSON and return it to the JavaScript code
echo json_encode($data);
?>