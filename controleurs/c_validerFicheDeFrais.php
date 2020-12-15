<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$lesMois=$pdo->getMoisFicheDeFrais();
$clee=array_keys($lesMois);
$moisASelectionne = $clee[0];
require'vues/v_validerFicheDeFrais.php';
