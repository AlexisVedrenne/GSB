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

    public function Open() {
        $this->CreateDbTest();
    }

    public function Close() {
        $this->DropDbTest();
    }

    /**
     * Fonction qui permet de tester si l'objet pdo arrive bien à être instancié
     * @return bool
     */
    public function testGetPdo() {
        try {
            return PdoGsb::getPdoGsb() != null;
        } catch (Swoole\Exception $ex) {
            return null;
        }
    }

    /**
     * Fonction qui permet de tester la connexion d'un visiteur à la bd
     * @return bool
     */
    public function testGetInfoVisiteur(): bool {
        try {
            $login = "dandre";
            $mdp = "oppg5";
            $requetePrepare = testPdoGsb::$monPdo->prepare(
                    'SELECT visiteur.id AS id, visiteur.nom AS nom, '
                    . 'visiteur.prenom AS prenom '
                    . 'FROM visiteur '
                    . 'WHERE visiteur.login = :unLogin AND visiteur.mdp = :unMdp'
            );
            $requetePrepare->bindParam(':unLogin', $login, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMdp', $mdp, PDO::PARAM_STR);
            $requetePrepare->execute();
            return !empty($requetePrepare->fetch());
        } catch (Swoole\Exception $ex) {
            return false;
        }
    }

    public function testGetInfoComptable(): bool {
        try {
            $login = "damalia";
            $mdp = "dfgh";
            $requetePrepare = testPdoGsb::$monPdo->prepare(
                    'SELECT comptable.id AS id, comptable.nom AS nom, '
                    . 'comptable.prenom AS prenom '
                    . 'FROM comptable '
                    . 'WHERE comptable.login = :unLogin AND comptable.mdp = :unMdp'
            );
            $requetePrepare->bindParam(':unLogin', $login, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMdp', $mdp, PDO::PARAM_STR);
            $requetePrepare->execute();
            return !empty($requetePrepare->fetch());
        } catch (Swoole\Exception $ex) {
            return false;
        }
    }

    public function testGetLesFraisHorsForfait(): bool {
        try {
            $idVisiteur = "A17";
            $mois = "202011";
            $requetePrepare = testPdoGsb::$monPdo->prepare(
                    'SELECT id as id, idvisiteur as idvisiteur, mois as mois, libelle as libelle, date as date, montant as montant FROM lignefraishorsforfait '
                    . 'WHERE lignefraishorsforfait.idvisiteur = :unIdVisiteur '
                    . 'AND lignefraishorsforfait.mois = :unMois'
            );
            $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
            $requetePrepare->execute();
            return !empty($requetePrepare->fetchAll(PDO::FETCH_ASSOC));
        } catch (Swoole\MySQL\Exception $ex) {
            return false;
        }
    }

    public function testGetNbJustificatif(): bool {
        try {
            $idVisiteur = "A17";
            $mois = "202011";
            $requetePrepare = testPdoGsb::$monPdo->prepare(
                    'SELECT fichefrais.nbjustificatifs as nb FROM fichefrais '
                    . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                    . 'AND fichefrais.mois = :unMois'
            );
            $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
            $requetePrepare->execute();
            $laLigne = $requetePrepare->fetch();
            return !empty($laLigne['nb']) || $laLigne['nb'] == '0';
        } catch (PDOException $ex) {
            return false;
        }
    }

    public function testGetLesFraisForfait(): bool {
        try {
            $idVisiteur = "A17";
            $mois = "202011";
            $requetePrepare = testPdoGSB::$monPdo->prepare(
                    'select fraisforfait.id as idfrais,fraisforfait.libelle as libelle,lignefraisforfait.quantite as quantite,fraisforfait.montant as prix '
                    . 'from lignefraisforfait inner join fraisforfait '
                    . 'on fraisforfait.id=lignefraisforfait.idfraisforfait '
                    . 'where lignefraisforfait.idvisiteur= :unIdVisiteur and '
                    . 'lignefraisforfait.mois= :unMois'
            );
            $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
            $requetePrepare->execute();
            return !empty($requetePrepare->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $ex) {
            return false;
        }
    }

}
