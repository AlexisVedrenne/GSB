<?php

require('../fpdf/fpdf.php');
//require_once 'includes/fct.inc.php';

class PDF extends FPDF {

    /**
     * Fonction Header qui s'occupera de l'en-tête de toutes les pages
     */
    function header() {
        // Placer une image en en-tête
        $this->Image('../images/logo.jpg', 85, 10);
        // Saute des lignes
        $this->Ln(40);
    }

    /**
     * Fonction Footer qui s'occupera du pied de page de toutes les pages
     */
    function footer() {
        $this->Image('../images/signatureComptable.png', 135, 250);
    }

    function body() {

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $mois = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING);

        // Connexion à la BDD
        $bddname = 'gsb_frais';
        $hostname = 'localhost';
        $username = 'userGsb';
        $password = 'secret';
        $db = mysqli_connect($hostname, $username, $password, $bddname);



        // Requête pour avoir le prenom
        $reqPrenom = "SELECT prenom, nom FROM visiteur WHERE id ='$id' ";
        $repPrenom = mysqli_query($db, $reqPrenom);
        $rowPrenom = mysqli_fetch_array($repPrenom);

        // Requête pour avoir le libellé du frais forfaitaire
        $reqFraisForfait = "SELECT libelle FROM lignefraishorsforfait";
        $repFraisForfait = mysqli_query($db, $reqFraisForfait);
        $rowFraisForfait = mysqli_fetch_array($repFraisForfait);

        // Requête pour avoir la quantité
        $reqQte = "SELECT quantite FROM lignefraisforfait";
        $repQte = mysqli_query($db, $reqQte);
        $rowQte = mysqli_fetch_array($repQte);

        // Requête pour avoir le montant
        $repMontant = "SELECT montant FROM lignefraishorsforfait";
        $reqMontant = mysqli_query($db, $repMontant);
        $rowMontant = mysqli_fetch_array($reqMontant);

        $this->SetX(17);
        // En-tête du tableau
        $this->Cell(175, 10, 'REMBOURSEMENT DE FRAIS ENGAGES', 1, 0, 'C');

        $this->Text(30, 70, 'Visiteur : ' . $id );

        $this->Text(30, 80, 'Mois : ' . $mois);
        $this->Text(70, 70, $rowPrenom['prenom'] . ' ' . strtoupper($rowPrenom['nom']));
        // Met la position Y du projet attribut à 60
        $this->SetY(75);
        // Met la position X du projet attribut à 40S
        $this->SetX(30);
        // Met la position Y du projet attribut à 60
        $this->SetY(90);
        // Met la position X du projet attribut à 40
        $this->SetX(10);

        // Place l'en-tête du premier tableau
        $this->Cell(190, 10, 'Frais Forfaitaires         Quantite           Montant unitaire           Total', 1, 0, 'C');
        $this->Text(15, 107, $rowFraisForfait['libelle']);
        $this->Text(80, 107, $rowQte['quantite']);
        $this->Text(125, 107, $rowMontant['montant']);
        $this->Text(175, 107, $rowQte['quantite'] * $rowMontant['montant']);
        
        $this->Text(80, 130, 'Autres Frais');
        /**
         * 
         */
        $this->SetY(150);
        $this->SetX(10);
        $this->Cell(190, 10, 'Date                       Libelle                     Montant', 1, 0, 'C');
    }

}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->body();
$pdf->Output();
