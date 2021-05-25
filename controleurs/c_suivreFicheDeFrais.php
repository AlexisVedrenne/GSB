<?php

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
    case 'selectionnerMois':
        $lesMois = $pdo->getLesFicheValider();
        if (!isset($lesMois)) {
            // Afin de sélectionner par défaut le dernier mois dans la zone de liste
            // on demande toutes les clés, et on prend la première,
            // les mois étant triés décroissants
            $lesCles = array_keys($lesMois);
            $moisASelectionner = $lesCles[0];
        }
        include 'vues/v_listeMoisValider.php';
        break;
    case 'selcetionnerVisiteur':
        $leMois = filter_input(INPUT_POST, 'lstMoisValider', FILTER_SANITIZE_STRING);
        $leMoisB = str_replace('/', '', filter_input(INPUT_POST, 'lstMoisValider', FILTER_SANITIZE_STRING));
        $lesMois = $pdo->getLesFicheValider();
        $moisASelectionner = $leMois;
        include 'vues/v_listeMoisValider.php';

        $lesVisiteurs = $pdo->getVisiteurFromMoisValider($leMoisB);
        $lesCles2 = array_keys($lesVisiteurs);
        $visiteurASelectionner = $lesCles2[0];
        include 'vues/v_listeVisiteurV2.php';
        $_SESSION["dateSuvie"] = $leMoisB;
        break;
    case 'suivreFicheDeFrais':
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $leMoisB = str_replace('/', '', filter_input(INPUT_POST, 'lstMoisValider', FILTER_SANITIZE_STRING));
        $lesMois = $pdo->getLesFicheValider();
        $moisASelectionner = $leMois;
        include 'vues/v_listeMoisValider.php';

        $leVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $lesVisiteurs = $pdo->getVisiteurFromMoisValider($_SESSION["dateSuvie"]);
        $visiteurASelectionner = $leVisiteur;
        include 'vues/v_listeVisiteurV2.php';

        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur, $_SESSION["dateSuvie"]);
        $lesFraisForfait = $pdo->getLesFraisForfait($leVisiteur, $_SESSION["dateSuvie"]);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $_SESSION["dateSuvie"]);
        $numAnnee = substr($_SESSION["dateSuvie"], 0, 4);
        $numMois = substr($_SESSION["dateSuvie"], 4, 2);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        include 'vues/v_suivreFicheDeFrais.php';
        $_SESSION["visiteurSuvie"] = $leVisiteur;
        break;

    case 'miseEnPaiement':
        $pdo->majEtatFicheFrais($_SESSION["visiteurSuvie"], $_SESSION["dateSuvie"], 'MP');
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $leMoisB = str_replace('/', '', filter_input(INPUT_POST, 'lstMoisValider', FILTER_SANITIZE_STRING));
        $lesMois = $pdo->getLesFicheValider();
        $moisASelectionner = $leMois;
        include 'vues/v_listeMoisValider.php';

        $lesVisiteurs = $pdo->getVisiteurFromMoisValider($_SESSION["dateSuvie"]);
        $visiteurASelectionner = $_SESSION["visiteurSuvie"];
        include 'vues/v_listeVisiteurV2.php';

        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($_SESSION["visiteurSuvie"], $_SESSION["dateSuvie"]);
        $numAnnee = substr($_SESSION["dateSuvie"], 0, 4);
        $numMois = substr($_SESSION["dateSuvie"], 4, 2);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        include 'vues/v_miseEnPaiement.php';

        break;
}