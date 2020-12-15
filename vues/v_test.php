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
if ($test->testGetPdo() == true) {
    echo "<h1>Test 1 [Connexion à la BD]: Réussi";
    $reussite = $reussite + 1;
} else {
    echo "<h1>Test 1 [Connexion à la BD]: Echoué";
}

if ($test->testGetInfoVisiteur() == true) {
    echo "<h1>Test 2 [Connexion Visiteur]: Réussi";
    $reussite = $reussite + 1;
} else {
    echo "<h1>Test 2 [Connexion Visiteur]: Echoué";
}

if ($test->testGetInfoComptable() == true) {
    echo "<h1>Test 3 [Connexion Comptable]: Réussi";
    $reussite = $reussite + 1;
} else {
    echo "<h1>Test 3 [Connexion Comptable]: Echoué";
}
if ($test->testGetLesFraisHorsForfait() == true) {
    echo "<h1>Test 4 [Récuperer les fiches de frais hors forfait]: Réussi";
    $reussite = $reussite + 1;
} else {
    echo "<h1>Test 4 [Récuperer les fiches de frais hors forfait]: Echoué";
}

if ($test->testGetNbJustificatif() == true) {
    echo "<h1>Test 5 [Récuperation des nb justificatifs]: Réussi";
    $reussite = $reussite + 1;
} else {
    echo "<h1>Test 5 [Récuperation des nb justificatifs]: Echoué";
}
echo"<h2>Nombre de testes réussis : " . $reussite . "</h2>";
$test->Close();
