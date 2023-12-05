<?php
session_start();

require_once("controller/dbcontroller.php");
$db_handle = new DBController();

$sensor = $_SESSION['sensor'];

require('vendors/fpdf/fpdf.php');

require('vendors/fpdf/exfpdf.php');
require('vendors/fpdf/easyTable.php');


$time1 = $_SESSION["minrange"];
$time2 = $_SESSION["maxrange"];
$type = $_GET["type"];
$result = $db_handle->runQuery2("SELECT id , sensor , DATE_FORMAT(reading_time, '%H:%i:%s'),DATE_FORMAT(reading_time, '%d-%m-%Y'), gas, suhu,kelembapan FROM sensordata WHERE sensor ='$sensor'  AND reading_time BETWEEN '$time1' AND '$time2' ORDER BY reading_time DESC  ");


// Instanciation of inherited class
$pdf = new exFPDF('P', 'mm', 'A4');

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
// for($i=1;$i<=40;$i++)











if ($type == "suhu") {


    $tableb = new easyTable($pdf, '%{100}', 'border:0;font-size:8;');
    $tableb->easyCell('', 'img:assets/favicon/parameter-removebg-preview.png,w40;valign:M;  align:C');
    $tableb->printRow();
    $tableb->easyCell("Suhu", 'valign:M;  align:C');
    $tableb->printRow();
    $tableb->easyCell($time1." - ".$time2, 'valign:M;  align:C');
    $tableb->printRow();
    $tableb->endTable(5);

    $tablelist = new easyTable($pdf, 2, 'border:1;font-size:8;');


    while ($row = $result->fetch_assoc()) {

        $tablelist->easyCell($row["DATE_FORMAT(reading_time, '%H:%i:%s')"] . " " . $row["DATE_FORMAT(reading_time, '%d-%m-%Y')"], 'valign:M;  align:C');
        $tablelist->easyCell($row["suhu"] . mb_convert_encoding("°C", 'ISO-8859-1'), 'valign:M;  align:C');
        $tablelist->printRow();


    }

    $tablelist->endTable(5);
}
if ($type == "kelembapan") {

    $tableb = new easyTable($pdf, '%{100}', 'border:0;font-size:8;');
    $tableb->easyCell('', 'img:assets/favicon/parameter-removebg-preview.png,w40;valign:M;  align:C');
    $tableb->printRow();
    $tableb->easyCell("Kelembapan", 'valign:M;  align:C');
    $tableb->printRow();
    $tableb->easyCell($time1." - ".$time2, 'valign:M;  align:C');
    $tableb->printRow();
    $tableb->endTable(5);

    $tablelist = new easyTable($pdf, 2, 'border:1;font-size:8;');


    while ($row = $result->fetch_assoc()) {

        $tablelist->easyCell($row["DATE_FORMAT(reading_time, '%H:%i:%s')"] . " " . $row["DATE_FORMAT(reading_time, '%d-%m-%Y')"], 'valign:M;  align:C');
        $tablelist->easyCell($row["kelembapan"] . " %", 'valign:M;  align:C');
        $tablelist->printRow();


    }

    $tablelist->endTable(5);
}

if ($type == "gas") {

    $tableb = new easyTable($pdf, '%{100}', 'border:0;font-size:8;');
    $tableb->easyCell('', 'img:assets/favicon/parameter-removebg-preview.png,w40;valign:M;  align:C');
    $tableb->printRow();
    $tableb->easyCell("Gas", 'valign:M;  align:C');
    $tableb->printRow();
    $tableb->easyCell($time1." - ".$time2, 'valign:M;  align:C');
    $tableb->printRow();
    $tableb->endTable(5);

    $tablelist = new easyTable($pdf, 2, 'border:1;font-size:8;');


    while ($row = $result->fetch_assoc()) {

        $tablelist->easyCell($row["DATE_FORMAT(reading_time, '%H:%i:%s')"] . " " . $row["DATE_FORMAT(reading_time, '%d-%m-%Y')"], 'valign:M;  align:C');
        $tablelist->easyCell($row["gas"] ." pbb", 'valign:M;  align:C');
        $tablelist->printRow();


    }

    $tablelist->endTable(5);
}
$pdf->Output();

?>