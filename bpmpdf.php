<?php
session_start();
require('vendors/fpdf/fpdf.php');

require_once("controller/dbcontroller.php");
$db_handle = new DBController();

$sensor = $_SESSION['sensor'];

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('assets/favicon/android-icon-144x144.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(30);
    // Title
    $this->Cell(10,20,'Oximeter Server Beats Per Second(BPM)');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetY(40);
// for($i=1;$i<=4z0;$i++)
//     $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$newmin = $_SESSION["minrangebpm"] ;
$newmax=$_SESSION["maxrangebpm"];
$results = $db_handle->runQuery("SELECT sensor,bpm,DATE_FORMAT(reading_time,  '%H:%i:%s %d-%m-%Y') FROM sensordata WHERE sensor='$sensor ' AND reading_time BETWEEN '$newmin' AND '$newmax' ORDER BY id ASC");
$pdf->SetFont('Arial','B',24);
$data = array();

    $pdf->Cell(0,10, "Sensor Data From " .$results[0]["sensor"] ,0,1);

    $pdf->SetFont('Arial','',12);
    $bpm = array_column($results, 'bpm');
    $minbpm = min($bpm);
    $maxbpm = max($bpm);
    $pdf->Cell(0,20, "Lowest Value: " .$minbpm . " Highest Value: " .$maxbpm ,0,1);

    $pdf->SetY(70);

foreach ($results as $row) {
    $pdf->Cell(0,15, " BPM: " . $row["bpm"] ." at ".$row["DATE_FORMAT(reading_time,  '%H:%i:%s %d-%m-%Y')"],0,1);

}
$filename = "BPM_".$results[0]["sensor"]."_".$newmin."-".$newmax;
$pdf->Output('I',$filename);
?>
