<?php

require('../fpdf/fpdf.php');

class PDF extends FPDF {

    function Header() {
        // Placer une image en en-tête
        $this->Image('../images/logo.jpg', 85, 10);
        // Saute des lignes
        $this->Ln(40);
    }

    function Footer() {
        $this->Image('../images/signatureComptable.png', 135, 250);
    }

    function Body() {
        // Connexion à la BDD
        $bddname = 'gsb_frais';
        $hostname = 'localhost';
        $username = 'userGsb';
        $password = 'secret';
        $db = mysqli_connect($hostname, $username, $password, $bddname);
        
        //
        $reqIdVisiteurMois = "SELECT idvisiteur, mois FROM fichefrais";
        $repIdVisiteurMois = mysqli_query($db, $reqIdVisiteurMois);
        $rowIdVisiteurMois = mysqli_fetch_array($repIdVisiteurMois);
        
        //
        $reqNomPrenom = "SELECT nom, prenom FROM visiteur WHERE id= a17";
        $repNomPrenom = mysqli_query($db, $reqNomPrenom);
        $rowNomPrenom = mysqli_fetch_array($repNomPrenom);
        //
        
        $this->SetX(17);
// En-tête du tableau
        $this->Cell(175, 10, 'REMBOURSEMENT DE FRAIS ENGAGES', 1, 0, 'C');

        $this->Text(30, 70, 'Visiteur : ' . $rowIdVisiteurMois['idvisiteur']);
// Met la position Y du projet attribut à 60
        $this->SetY(75);
// Met la position X du projet attribut à 40
        $this->SetX(30);
// Objet Mois
        $this->Text(30, 80, 'Mois : ' . $rowIdVisiteurMois['mois']);
        $this->Text(40, 90, $rowNomPrenom['prenom'] . strtoupper($rowNomPrenom['nom']));
    }

}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Body();
$pdf->Output();
