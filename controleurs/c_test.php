<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../tests/unit/testPdoGsb.php';
$test = new testPdoGsb();
$reussite = 0;
$test->Open();
$res="";
$libelleTest="";
$numTest=1;
if ($test->testGetPdo() == true) {
    
    $libelleTest="Connexion à la BD";
    $res="Réussi";
    $reussite = $reussite + 1;
} else {
    $res="Echoué";
}
require '../vues/v_test.php';
$numTest=2;
if ($test->testGetInfoVisiteur() == true) {
    $libelleTest="Connexion Visiteur";
    $res="Réussi";
    $reussite = $reussite + 1;
} else {
    $res="Echoué";
}
require '../vues/v_test.php';
$numTest=3;
if ($test->testGetInfoComptable() == true) {
   $libelleTest="Connexion Comptable";
    $res="Réussi";
    $reussite = $reussite + 1;
} else {
    $res="Echoué";
}
require '../vues/v_test.php';
$numTest=4;
if ($test->testGetLesFraisHorsForfait() == true) {
   $libelleTest="Récupération des fiches de frais hors fordait";
    $res="Réussi";
    $reussite = $reussite + 1;
} else {
    $res="Echoué";
}
require '../vues/v_test.php';
$numTest=5;
if ($test->testGetNbJustificatif() == true) {
    $libelleTest="Récupération des nb justificatifs";
    $res="Réussi";
    $reussite = $reussite + 1;
} else {
    $res="Echoué";
}
require '../vues/v_test.php';
$numTest=6;
if ($test->testGetLesFraisForfait() == true) {
    $libelleTest="Récupération des frais forfaits";
    $res="Réussi";
    $reussite = $reussite + 1;
} else {
    $res="Echoué";
}
echo"<h2>Nombre de testes réussis : " . $reussite . "</h2>";
$test->Close();
