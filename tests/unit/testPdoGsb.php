<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include './../includes/class.pdogsb.inc.php';

Class testPdoGsb {

    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=testGsb';
    private static $user = 'root';
    private static $mdp = '';
    private static $monPdo;

    /**
     * Fonction qui permet de créer la base de données de test et de s'y connectée
     */
    private function CreateDbTest() {
        testPdoGsb::$monPdo = new PDO(
                testPdoGsb::$serveur . ';',
                testPdoGsb::$user,
                testPdoGsb::$mdp
        );
        testPdoGsb::$monPdo->exec('CREATE DATABASE testGsb DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci');      
        testPdoGsb::$monPdo = new PDO(
                testPdoGsb::$serveur . ';' . testPdoGsb::$bdd,
                testPdoGsb::$user,
                testPdoGsb::$mdp
        );
        
        $this->CreateTableAndInsertTest();
    }

    /**
     * Fonction qui permet de créer les table et d'inserer les lignes dans la base de donnée de test
     * @throws PDOException
     */
    private function CreateTableAndInsertTest() {
        //initialisation de la variable req
        $req = "";
        //on met la variable finRinquete a false
        $finRequete = false;
        //on met le fichier dans une variable
        $tables = file("./../Bdd/SauvegardeBDD/saveGSB_1000-07122020.sql"); //Là ton fichier
        //pour chaque ligne du ficher ...
        foreach ($tables AS $ligne) {
            //si ligne[0] n'est pas égal à - et si ligne[0] n'est pas égale a rien
            if ($ligne[0] != "-" && $ligne[0] != "") {
                //on concate $ligne dans $req
                $req .= $ligne;
                // on divise $ligne en plusieurs sous-chaines de caracteres divisé par ;
                $test = explode(";", $ligne);
                //Si la taille de $test est suppérieure à 1 (donc s'il y a quelque chose dedans) faire
                if (sizeof($test) > 1) {
                    //mettre finRequete à vrai
                    $finRequete = true;
                }
            }
            //Si finRequete est vrai
            if ($finRequete) {
                // on prépare la requete sql dans stmt
                $stmt = testPdoGsb::$monPdo->prepare($req);
                //si l'exécution se passe bien
                if (!$stmt->execute()) {
                    //lancer l'exception suivante
                    throw new PDOException("Impossible d'ins&eacute;rer la ligne:<br>" . $req . "<hr>", 100);
                }
                //on vide req
                $req = "";
                //on remet finRequete à faux
                $finRequete = false;
            }
        }
    }

    /**
     * Fonction qui permet de supprimer la base de données de test
     */
    private function DropDbTest() {        
        testPdoGsb::$monPdo->exec('drop database testGsb');
        //testPdoGsb::$monPdo = null;
    }

    /**
     * Fonction qui permet de tester si l'objet pdo arrive bien à être instancié
     * @return bool
     */
    public function testGetPdo() {               
        return PdoGsb::getPdoGsb() != null;       
    }
    
    

}
