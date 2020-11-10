<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if ($action == 'selectionnerMois') {
    unset($_SESSION['date']);
    unset($_SESSION['idVisi']);
}
$lesMois = $pdo->getMoisFicheDeFrais();
$clee = array_keys($lesMois);
$moisASelectionne = $clee[0];
require 'vues/v_mois_comptable.php';
if ($action == 'selectionnerVisiteur' || $action == 'AffichageFicheFraisAndVisiteur') {
    $datePost = str_replace('/', '', filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING));
    if ((empty($_SESSION['date']) || $datePost != $_SESSION['date']) && $datePost != '') {
        $date = $datePost;
        $_SESSION['date'] = trim($date);
    }
    $lesVisiteur = $pdo->getVisiteurFromMois($_SESSION['date']);
    require 'vues/v_visiteur_comptable.php';
}

if ($action == 'AffichageFicheFraisAndVisiteur' || $action == 'corrigerLefrais') {
    require './vues/v_validerLaFiche.php';
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
    if ((empty($_SESSION['idSelect']) || $idVisiteur != $_SESSION['idSelect']) && $idVisiteur != "") {
        $_SESSION['idSelect'] = $idVisiteur;
    }
    $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($_SESSION['idSelect'], $_SESSION['date']);
    $infoFraisForfait = $pdo->getLesFraisForfait($_SESSION['idSelect'], $_SESSION['date']);
    $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['idSelect'], $_SESSION['date']);
    require 'vues/v_afficherFicheDeFraisComptable.php';
    require 'vues/v_horsForfaitComtable.php';
}

if($action=='corrigerLefrais'){
    $date=filter_input(INPUT_GET,'date',FILTER_SANITIZE_STRING);
    $libelleHors=filter_input(INPUT_GET,'libelle',FILTER_SANITIZE_STRING);
    $montant=filter_input(INPUT_GET,'montant');
    $pdo->majFraisHorsForfait($libelle,$date,$montant,$_SESSION['idSelect']);
}
    