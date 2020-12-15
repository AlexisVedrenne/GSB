<?php

/**
 * Fonctions utilisées pour la génération d'un jeu d'essai
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

/**
 * Fonction qui retourne la liste des visiteurs
 *
 * @param PDO $pdo instance de la classe PDO utilisée pour se connecter
 *
 * @return Array de visiteurs
 */
function getLesVisiteurs($pdo)
{
    $req = 'select * from visiteur';
    $res = $pdo->query($req);
    $lesLignes = $res->fetchAll();
    return $lesLignes;
}

/**
 * Fonction générique qui retourne le nombre d'enregistrements d'une table
 *
 * @param PDO    $pdo   Instance de la classe PDO utilisée pour se connecter
 * @param String $table Nom de la table que l'on veut utiliser
 *
 * @return Integer avec le nombre d'enregistrements
 */
function getNbTable($pdo, $table)
{
    $req = 'select count(*) from ' . $table;
    $res = $pdo->query($req);
    $nbLignes = $res->fetch();
    return $nbLignes[0];
}

/**
 * Fonction qui retourne la liste des fiches de frais
 *
 * @param PDO $pdo instance de la classe PDO utilisée pour se connecter
 *
 * @return Array de fiches de frais
 */
function getLesFichesFrais($pdo)
{
    $req = 'select * from fichefrais';
    $res = $pdo->query($req);
    $lesLignes = $res->fetchAll();
    return $lesLignes;
}

/**
 * Fonction qui retourne les id des fiches de frais
 *
 * @param PDO $pdo instance de la classe PDO utilisée pour se connecter
 *
 * @return Array de id de fiches de frais
 */
function getLesIdFraisForfait($pdo)
{
    $req = 'select fraisforfait.id as id '
        . 'from fraisforfait '
        . 'order by fraisforfait.id';
    $res = $pdo->query($req);
    $lesLignes = $res->fetchAll();
    return $lesLignes;
}

/**
 * Fonction qui retourne le mois suivant un mois passé en paramètre
 *
 * @param String $mois Contient le mois à utiliser
 *
 * @return String le mois d'après
 */
function getMoisSuivant($mois)
{
    $numAnnee = substr($mois, 0, 4);
    $numMois = substr($mois, 4, 2);
    if ($numMois == '12') {
        $numMois = '01';
        $numAnnee++;
    } else {
        $numMois++;
    }
    if (strlen($numMois) == 1) {
        $numMois = '0' . $numMois;
    }
    return $numAnnee . $numMois;
}

/**
 * Fonction qui retourne le mois précédent un mois passé en paramètre
 *
 * @param String $mois Contient le mois à utiliser
 *
 * @return String le mois d'avant
 */
function getMoisPrecedent($mois)
{
    $numAnnee = substr($mois, 0, 4);
    $numMois = substr($mois, 4, 2);
    if ($numMois == '01') {
        $numMois = '12';
        $numAnnee--;
    } else {
        $numMois--;
    }
    if (strlen($numMois) == 1) {
        $numMois = '0' . $numMois;
    }
    return $numAnnee . $numMois;
}

/**
 * Fonction qui crée les fiches de frais (via des INSERT SQL)
 *
 * @param PDO $pdo instance de la classe PDO utilisée pour se connecter
 *
 * @return null
 */
function creationFichesFrais($pdo)
{
    global $moisDebut; // valeur dans majGSB.php
    $lesVisiteurs = getLesVisiteurs($pdo);
    $moisActuel = getMois(date('d/m/Y'));
    $moisFin = getMoisPrecedent($moisActuel);
    foreach ($lesVisiteurs as $unVisiteur) {
        $moisCourant = $moisFin;
        $idVisiteur = $unVisiteur['id'];
        $n = 1;
        while ($moisCourant >= $moisDebut) {
            if ($n == 1) {
                $etat = 'CR';
                $moisModif = $moisCourant;
            } else {
                if ($n == 2) {
                    $etat = 'VA';
                    $moisModif = getMoisSuivant($moisCourant);
                } else {
                    $etat = 'RB';
                    $moisModif = getMoisSuivant(getMoisSuivant($moisCourant));
                }
            }
            $numAnnee = substr($moisModif, 0, 4);
            $numMois = substr($moisModif, 4, 2);
            $dateModif = $numAnnee . '-' . $numMois . '-' . rand(1, 8);
            $nbJustificatifs = rand(0, 12);
            $req = 'insert into fichefrais(idvisiteur,mois,nbjustificatifs,'
                . 'montantvalide,datemodif,idetat) '
                . "values ('$idVisiteur','$moisCourant',$nbJustificatifs,"
                . "0,'$dateModif','$etat');";
            $pdo->exec($req);
            $moisCourant = getMoisPrecedent($moisCourant);
            $n++;
        }
    }
}

/**
 * Fonction qui crée des lignes de frais au forfait (via des INSERT SQL)
 *
 * @param PDO $pdo instance de la classe PDO utilisée pour se connecter
 *
 * @return null
 */
function creationFraisForfait($pdo)
{
    $lesFichesFrais = getLesFichesFrais($pdo);
    $lesIdFraisForfait = getLesIdFraisForfait($pdo);
    foreach ($lesFichesFrais as $uneFicheFrais) {
        $idVisiteur = $uneFicheFrais['idvisiteur'];
        $mois = $uneFicheFrais['mois'];
        foreach ($lesIdFraisForfait as $unIdFraisForfait) {
            $idFraisForfait = $unIdFraisForfait['id'];
            if (substr($idFraisForfait, 0, 1) == 'K') {
                $quantite = rand(300, 1000);
            } else {
                $quantite = rand(2, 20);
            }
            $req = 'insert into lignefraisforfait(idvisiteur,mois,'
                . 'idfraisforfait,quantite) '
                . "values('$idVisiteur','$mois','$idFraisForfait',$quantite);";
            $pdo->exec($req);
        }
    }
}

/**
 * Fonction qui retourne des exmples de frais hors forfait pour de la génération
 * aléatoire
 *
 * @return Array d'exemples de frais hors forfait
 */
function getDesFraisHorsForfait()
{
    $tab = array(
        1 => array(
            'lib' => 'Repas avec praticien',
            'min' => 30,
            'max' => 50),
        2 => array(
            'lib' => 'Achat de matériel de papèterie',
            'min' => 10,
            'max' => 50),
        3 => array(
            'lib' => 'Taxi',
            'min' => 20,
            'max' => 80),
        4 => array(
            'lib' => "Achat d'espace publicitaire",
            'min' => 20,
            'max' => 150),
        5 => array(
            'lib' => 'Location salle conférence',
            'min' => 120,
            'max' => 650),
        6 => array(
            'lib' => 'Voyage SNCF',
            'min' => 30,
            'max' => 150),
        7 => array(
            'lib' => 'Traiteur, alimentation, boisson',
            'min' => 25,
            'max' => 450),
        8 => array(
            'lib' => 'Rémunération intervenant/spécialiste',
            'min' => 250,
            'max' => 1200),
        9 => array(
            'lib' => 'Location équipement vidéo/sonore',
            'min' => 100,
            'max' => 850),
        10 => array(
            'lib' => 'Location véhicule',
            'min' => 25,
            'max' => 450),
        11 => array(
            'lib' => 'Frais vestimentaire/représentation',
            'min' => 25,
            'max' => 450)
    );
    return $tab;
}

/**
 * Fonction qui met à jour les mots de passe des visisteurs avec des mots de
 * pass aléatoire
 *
 * @param PDO $pdo instance de la classe PDO utilisée pour se connecter
 *
 * @return null
 */
function updateMdpVisiteur($pdo)
{
    $req = 'select * from visiteur';
    $res = $pdo->query($req);
    $lesLignes = $res->fetchAll();
    $lettres = 'azertyuiopqsdfghjkmwxcvbn123456789';
    foreach ($lesLignes as $unVisiteur) {
        $mdp = '';
        $id = $unVisiteur['id'];
        for ($i = 1; $i <= 5; $i++) {
            $uneLettrehasard = substr($lettres, rand(33, 1), 1);
            $mdp = $mdp . $uneLettrehasard;
        }
        $req = "update visiteur set mdp ='$mdp' where visiteur.id ='$id' ";
        $pdo->exec($req);
    }
}

/**
 * Fonction qui crée des lignes de frais hors forfait (via des INSERT SQL)
 *
 * @param PDO $pdo instance de la classe PDO utilisée pour se connecter
 *
 * @return null
 */
function creationFraisHorsForfait($pdo)
{
    $desFrais = getDesFraisHorsForfait();
    $lesFichesFrais = getLesFichesFrais($pdo);

    foreach ($lesFichesFrais as $uneFicheFrais) {
        $idVisiteur = $uneFicheFrais['idvisiteur'];
        $mois = $uneFicheFrais['mois'];
        $nbFrais = rand(0, 5);
        for ($i = 0; $i <= $nbFrais; $i++) {
            $hasardNumfrais = rand(1, count($desFrais));
            $frais = $desFrais[$hasardNumfrais];
            $lib = $frais['lib'];
            $min = $frais['min'];
            $max = $frais['max'];
            $hasardMontant = rand($min, $max);
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $hasardJour = rand(1, 28);
            if (strlen($hasardJour) == 1) {
                $hasardJour = '0' . $hasardJour;
            }
            $hasardMois = $numAnnee . '-' . $numMois . '-' . $hasardJour;
            $req = 'insert into lignefraishorsforfait(idvisiteur,mois,libelle,'
                    . 'date,montant) '
                    . "values('$idVisiteur','$mois','$lib','$hasardMois',"
                    . "$hasardMontant);";
            $pdo->exec($req);
        }
    }
}

/**
 * Fonction qui retourne le mois (au format ID GSB : aaaamm) à partir d'une
 * date passée en paramètre
 *
 * @param String $date Date à utiliser pour extraire le mois
 *
 * @return String avec le mois au format aaaamm
 */
function getMois($date)
{
    @list($jour, $mois, $annee) = explode('/', $date);
    unset($jour);
    if (strlen($mois) == 1) {
        $mois = '0' . $mois;
    }
    return $annee . $mois;
}

/**
 * Fonction qui met à jour les montants des fiches de frais (via des UPDATE SQL)
 *
 * @param PDO $pdo instance de la classe PDO utilisée pour se connecter
 *
 * @return null
 */
function majFicheFrais($pdo)
{
    $lesFichesFrais = getLesFichesFrais($pdo);
    foreach ($lesFichesFrais as $uneFicheFrais) {
        $idVisiteur = $uneFicheFrais['idvisiteur'];
        $mois = $uneFicheFrais['mois'];
        $req = 'select sum(montant) as cumul from lignefraishorsforfait '
            . "where lignefraishorsforfait.idvisiteur = '$idVisiteur' "
            . "and lignefraishorsforfait.mois = '$mois' ";
        $res = $pdo->query($req);
        $ligne = $res->fetch();
        $cumulMontantHF = $ligne['cumul'];
        $req = 'select sum(lignefraisforfait.quantite * fraisforfait.montant) '
                . 'as cumul '
                . 'from lignefraisforfait, fraisforfait '
                . 'where lignefraisforfait.idfraisforfait = fraisforfait.id '
                . "and lignefraisforfait.idvisiteur = '$idVisiteur' "
                . "and lignefraisforfait.mois = '$mois' ";
        $res = $pdo->query($req);
        $ligne = $res->fetch();
        $cumulMontantForfait = $ligne['cumul'];
        $montantEngage = $cumulMontantHF + $cumulMontantForfait;
        $etat = $uneFicheFrais['idetat'];
        if ($etat == 'CR') {
            $montantValide = 0;
        } else {
            $montantValide = $montantEngage * rand(80, 100) / 100;
        }
        $req = "update fichefrais set montantvalide = $montantValide "
            . "where idvisiteur = '$idVisiteur' and mois = '$mois'";
        $pdo->exec($req);
    }
}
