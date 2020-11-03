<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if ($action == 'selectionnerMois') {
    unset($_SESSION['date']);
}
$lesMois = $pdo->getMoisFicheDeFrais();
$clee = array_keys($lesMois);
$moisASelectionne = $clee[0];
require 'vues/v_mois_comptable.php';

if ($action == 'selectionnerVisiteur' || $action == 'AffichageFicheFraisAndVisiteur') {
    $datePost=str_replace('/', '', filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING));
    if ((empty($_SESSION['date'])||$datePost!=$_SESSION['date'])&&$datePost!='') {
        $date = $datePost;
        trim($date);
        $_SESSION['date'] = $date;
    }
    $lesVisiteur = $pdo->getVisiteurFromMois($_SESSION['date']);
    require 'vues/v_visiteur_comptable.php';
}

if ($action == 'AffichageFicheFraisAndVisiteur') {
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
    $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $_SESSION['date']);
    $infoFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $_SESSION['date']);
    $infoFraisHorsForfait=$pdo->getLesFraisHorsForfait($idVisiteur, $_SESSION['date']);
    require 'vues/v_afficherFicheDeFraisComptable.php';
    require 'vues/v_horsForfaitComtable.php';
}



    