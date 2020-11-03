<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


  $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
  $idVisiteur = $_SESSION['idVisiteur'];
  switch ($action) {
  case 'selectionnerFicheFrais':
  $lesFiches = $pdo->getFicheAValiderEtMiseEnPaiement();
  $lesCles = array_keys($lesFiches);
  $fichesASelectionner = $lesCles[0];
  include 'vues/v_ficheValideeMiseEnPaiement.php';
  break;
  case 'voirSuiviFicheFrais':
  $laFiche = filter_input(INPUT_POST, '1stFiche', FILTER_SANITIZE_STRING);
  $lesMois = $pdo->getEtatFicheFrais($idFicheDePaie);
  $fichesASelectionner = $laFiche;
  include 'vues/v_ficheValideeMiseEnPaiement.php';
  $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur);
  $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur);
  break;
  }
 