<?php

require('../fpdf/fpdf.php');

class PDF extends FPDF {

    function Header() {
        // Placer une image en en-tête
        $this->Image('../images/logo.jpg', 100, 0, 30);
        // Saute des lignes
        $this->Ln(50);
    }

    function Footer() {
        $this->SetFont('Arial', 'B', 16);
        
    }

}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Hello World !');
$pdf->Output();
