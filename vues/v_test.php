<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../tests/unit/testPdoGsb.php';
$test=new testPdoGsb();
if($test->testGetPdo()==true){
    echo "<h1>Test 1 [Connexion à la BD]: Réussi";
}else{
    echo "<h1>Test 1 [Connexion à la BD]: Echoué";
}

