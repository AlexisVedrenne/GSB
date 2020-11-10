<?php
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
case 'selectionnerMois':
    $lesMois = $pdo->getLesFicheValider();
    // Afin de sélectionner par défaut le dernier mois dans la zone de liste
    // on demande toutes les clés, et on prend la première,
    // les mois étant triés décroissants
    $lesCles = array_keys($lesMois);
    $moisASelectionner = $lesCles[0];
    //include 'vues/v_suivreFicheDeFrais.php';
    include 'vues/v_listeMoisValider.php';
    break;
case 'selcetionnerVisiteur':
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois = $pdo->getLesFicheValider();
    $moisASelectionner = $leMois;
    include 'vues/v_listeMoisValider.php';
    $lesVisiteurs = $pdo->getVisiteurFromMoisValider($leMois);
    //$lesCles = array_keys($lesMois);
    $VisiteurASelectionner = $lesVisiteurs[0];
    include 'vues/v_listeVisiteur.php';
}