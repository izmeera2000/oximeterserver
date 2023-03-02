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
        $this->Image('assets/favicon/android-icon-144x144.png', 10, 6, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(30);
        // Title
        $this->Cell(10, 20, 'Oximeter Server Beats Per Second(BPM)');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    function LineGraph($w, $h, $data, $options = '', $colors = null, $maxVal = 0, $nbDiv = 4)
    {
        /*******************************************
        Explain the variables:
        $w = the width of the diagram
        $h = the height of the diagram
        $data = the data for the diagram in the form of a multidimensional array
        $options = the possible formatting options which include:
        'V' = Print Vertical Divider lines
        'H' = Print Horizontal Divider Lines
        'kB' = Print bounding box around the Key (legend)
        'vB' = Print bounding box around the values under the graph
        'gB' = Print bounding box around the graph
        'dB' = Print bounding box around the entire diagram
        $colors = A multidimensional array containing RGB values
        $maxVal = The Maximum Value for the graph vertically
        $nbDiv = The number of vertical Divisions
        *******************************************/
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.2);
        $keys = array_keys($data);
        $ordinateWidth = 10;
        $w -= $ordinateWidth;
        $valX = $this->getX() + $ordinateWidth;
        $valY = $this->getY();
        $margin = 1;
        $titleH = 8;
        $titleW = $w;
        $lineh = 5;
        $keyH = count($data) * $lineh;
        $keyW = $w / 5;
        $graphValH = 5;
        $graphValW = $w - $keyW - 3 * $margin;
        $graphH = $h - (3 * $margin) - $graphValH;
        $graphW = $w - (2 * $margin) - ($keyW + $margin);
        $graphX = $valX + $margin;
        $graphY = $valY + $margin;
        $graphValX = $valX + $margin;
        $graphValY = $valY + 2 * $margin + $graphH;
        $keyX = $valX + (2 * $margin) + $graphW;
        $keyY = $valY + $margin + .5 * ($h - (2 * $margin)) - .5 * ($keyH);
        //draw graph frame border
        if (strstr($options, 'gB')) {
            $this->Rect($valX, $valY, $w, $h);
        }
        //draw graph diagram border
        if (strstr($options, 'dB')) {
            $this->Rect($valX + $margin, $valY + $margin, $graphW, $graphH);
        }
        //draw key legend border
        if (strstr($options, 'kB')) {
            $this->Rect($keyX, $keyY, $keyW, $keyH);
        }
        //draw graph value box
        if (strstr($options, 'vB')) {
            $this->Rect($graphValX, $graphValY, $graphValW, $graphValH);
        }
        //define colors
        if ($colors === null) {
            $safeColors = array(0, 51, 102, 153, 204, 225);
            for ($i = 0; $i < count($data); $i++) {
                $colors[$keys[$i]] = array($safeColors[array_rand($safeColors)], $safeColors[array_rand($safeColors)], $safeColors[array_rand($safeColors)]);
            }
        }
        //form an array with all data values from the multi-demensional $data array
        $ValArray = array();
        foreach ($data as $key => $value) {
            foreach ($data[$key] as $val) {
                $ValArray[] = $val;
            }
        }
        //define max value
        if ($maxVal < ceil(max($ValArray))) {
            $maxVal = ceil(max($ValArray));
        }
        //draw horizontal lines
        $vertDivH = $graphH / $nbDiv;
        if (strstr($options, 'H')) {
            for ($i = 0; $i <= $nbDiv; $i++) {
                if ($i < $nbDiv) {
                    $this->Line($graphX, $graphY + $i * $vertDivH, $graphX + $graphW, $graphY + $i * $vertDivH);
                } else {
                    $this->Line($graphX, $graphY + $graphH, $graphX + $graphW, $graphY + $graphH);
                }
            }
        }
        //draw vertical lines
        $horiDivW = floor($graphW / (count($data[$keys[0]]) - 1));
        if (strstr($options, 'V')) {
            for ($i = 0; $i <= (count($data[$keys[0]]) - 1); $i++) {
                if ($i < (count($data[$keys[0]]) - 1)) {
                    $this->Line($graphX + $i * $horiDivW, $graphY, $graphX + $i * $horiDivW, $graphY + $graphH);
                } else {
                    $this->Line($graphX + $graphW, $graphY, $graphX + $graphW, $graphY + $graphH);
                }
            }
        }
        //draw graph lines
        foreach ($data as $key => $value) {
            $this->setDrawColor($colors[$key][0], $colors[$key][1], $colors[$key][2]);
            $this->SetLineWidth(0.8);
            $valueKeys = array_keys($value);
            for ($i = 0; $i < count($value); $i++) {
                if ($i == count($value) - 2) {
                    $this->Line(
                        $graphX + ($i * $horiDivW),
                        $graphY + $graphH - ($value[$valueKeys[$i]] / $maxVal * $graphH),
                        $graphX + $graphW,
                        $graphY + $graphH - ($value[$valueKeys[$i + 1]] / $maxVal * $graphH)
                    );
                } else if ($i < (count($value) - 1)) {
                    $this->Line(
                        $graphX + ($i * $horiDivW),
                        $graphY + $graphH - ($value[$valueKeys[$i]] / $maxVal * $graphH),
                        $graphX + ($i + 1) * $horiDivW,
                        $graphY + $graphH - ($value[$valueKeys[$i + 1]] / $maxVal * $graphH)
                    );
                }
            }
            //Set the Key (legend)
            $this->SetFont('Courier', '', 10);
            if (!isset($n))
                $n = 0;
            $this->Line($keyX + 1, $keyY + $lineh / 2 + $n * $lineh, $keyX + 8, $keyY + $lineh / 2 + $n * $lineh);
            $this->SetXY($keyX + 8, $keyY + $n * $lineh);
            $this->Cell($keyW, $lineh, $key, 0, 1, 'L');
            $n++;
        }
        //print the abscissa values
        foreach ($valueKeys as $key => $value) {
            if ($key == 0) {
                $this->SetXY($graphValX, $graphValY);
                $this->Cell(30, $lineh, $value, 0, 0, 'L');
            } else if ($key == count($valueKeys) - 1) {
                $this->SetXY($graphValX + $graphValW - 30, $graphValY);
                $this->Cell(30, $lineh, $value, 0, 0, 'R');
            } else {
                $this->SetXY($graphValX + $key * $horiDivW - 15, $graphValY);
                $this->Cell(30, $lineh, $value, 0, 0, 'C');
            }
        }
        //print the ordinate values
        for ($i = 0; $i <= $nbDiv; $i++) {
            $this->SetXY($graphValX - 10, $graphY + ($nbDiv - $i) * $vertDivH - 3);
            $this->Cell(8, 6, sprintf('%.1f', $maxVal / $nbDiv * $i), 0, 0, 'R');
        }
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.2);
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetY(40);
// for($i=1;$i<=4z0;$i++)
//     $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$newmin = $_SESSION["minrangebpm"];
$newmax = $_SESSION["maxrangebpm"];
$results = $db_handle->runQuery("SELECT sensor,bpm,DATE_FORMAT(reading_time,  '%H:%i:%s %d-%m-%Y') FROM sensordata WHERE sensor='$sensor ' AND reading_time BETWEEN '$newmin' AND '$newmax' ORDER BY id ASC");
$pdf->SetFont('Arial', 'B', 24);
$data = array();

$pdf->Cell(0, 10, "Sensor Data From " . $results[0]["sensor"], 0, 1);

$pdf->SetFont('Arial', '', 12);
$bpm = array_column($results, 'bpm');
$minbpm = min($bpm);
$maxbpm = max($bpm);
$pdf->Cell(0, 20, "Lowest Value: " . $minbpm . " Highest Value: " . $maxbpm, 0, 1);

$pdf->SetY(70);
$arraydata = array();

foreach ($results as $row2) {
    $datetime = $row2["DATE_FORMAT(reading_time,  '%H:%i:%s %d-%m-%Y')"];
    $bpm = $row2["bpm"];
$arraydata[$datetime] = $bpm;


}
echo print_r($arraydata);
?>