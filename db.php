<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oximeter_server";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the data from the database
$sql = "SELECT id , DATE_FORMAT(reading_time, '%h:%i %p'), bpm , o2 FROM sensordata ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);

// Store the data in an array
$data = array();
while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the connection
$conn->close();

// Encode the data as JSON and return it to the JavaScript code
echo json_encode($data);
?>
