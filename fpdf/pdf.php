<?php

require('../fpdf/fpdf.php');

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
        
        // tableau de chaîne de caractère comportant des mois
        $tableauMois = ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
        
        // Connexion à la BDD
        $bddname = 'gsb_frais';
        $hostname = 'localhost';
        $username = 'userGsb';
        $password = 'secret';
        $db = mysqli_connect($hostname, $username, $password, $bddname);

        // Requête pour récupérer l'id du visiteur
        $reqIdVisiteur = "SELECT id FROM visiteur";
        $repIdVisiteur = mysqli_query($db, $reqIdVisiteur);
        $rowIdVisiteur = mysqli_fetch_array($repIdVisiteur);

        
        // Requête pour avoir le prenom
        $reqPrenom = "SELECT prenom, nom FROM visiteur";
        $repPrenom = mysqli_query($db, $reqPrenom);
        $rowPrenom = mysqli_fetch_array($repPrenom);
        
        // Requête pour avoir le mois
        $reqMois = "SELECT mois FROM lignefraishorsforfait";
        $repMois = mysqli_query($db, $reqMois);
        $rowMois = mysqli_fetch_array($repMois);
        
        $idMois = $rowMois['mois'];
        $idMoisLettre = strval($idMois[4]) + strval($idMois[5]);
        $idMoisLettre = $tableauMois[$idMoisLettre-1];
        $idMoisAnnee  = strval($idMois[0]) + strval($idMois[1]) + strval($idMois[2]) + strval($idMois[3]);
        
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

        $this->Text(30, 70, 'Visiteur : ' . $rowIdVisiteur['id']);
        
        $this->Text(30, 80, 'Mois : ' . $idMoisLettre . $idMoisAnnee);
        $this->Text(70, 70, $rowPrenom['prenom'] . ' ' . strtoupper($rowPrenom['nom']));
        // Met la position Y du projet attribut à 60
        $this->SetY(75);
        // Met la position X du projet attribut à 40S
        $this->SetX(30);
        // Objet Mois
        //$this->Text(30, 80, 'Mois : ' . $rowIdVisiteur['mois']);
        // Met la position Y du projet attribut à 60
        $this->SetY(90);
        // Met la position X du projet attribut à 40
        $this->SetX(10);

        // Place l'en-tête du premier tableau
        $this->Cell(190, 10, 'Frais Forfaitaires         Quantite           Montant unitaire           Total', 1, 0);
        $this->Text(15, 107, $rowFraisForfait['libelle']);
        $this->Text(80, 107, $rowQte['quantite']);
        $this->Text(125, 107, $rowMontant['montant']);
        $this->Text(175, 107, $rowQte['quantite'] * $rowMontant['montant']);
    }

}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->body();
$pdf->Output();
