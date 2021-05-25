-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 25 mai 2021 à 14:36
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gsb_frais`
--

-- --------------------------------------------------------

--
-- Structure de la table `comptable`
--

DROP TABLE IF EXISTS `comptable`;
CREATE TABLE IF NOT EXISTS `comptable` (
  `id` char(4) NOT NULL,
  `nom` char(30) DEFAULT NULL,
  `prenom` char(30) DEFAULT NULL,
  `login` char(20) DEFAULT NULL,
  `mdp` varchar(500) DEFAULT NULL,
  `adresse` char(30) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(30) DEFAULT NULL,
  `dateembauche` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `comptable`
--

INSERT INTO `comptable` (`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateembauche`) VALUES
('ahj7', 'Vedrenne', 'Alexis', 'Alved', 'bd2b1aaf7ef4f09be9f52ce2d8d599674d81aa9d6a4421696dc4d93dd0619d682ce56b4d64a9ef097761ced99e0f67265b5f76085e5b0ee7ca4696b2ad6fe2b2', '45 rue de la liberté', '83390', 'Cuers', '2007-05-08'),
('cop7', 'Delage', 'Gabriel', 'Gdlage', 'a3ad37dee4bfb6e3176f519e3fd7778e29724ce79f65c144930945b81f64b139', '1 bis rue Jean Bonnet', '83200', 'Lalbenque', '1998-11-23');

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `id` char(2) NOT NULL,
  `libelle` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('MP', 'Mise en paiement'),
('RB', 'Remboursée'),
('VA', 'Validée');

-- --------------------------------------------------------

--
-- Structure de la table `fichefrais`
--

DROP TABLE IF EXISTS `fichefrais`;
CREATE TABLE IF NOT EXISTS `fichefrais` (
  `idvisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `nbjustificatifs` int(11) DEFAULT NULL,
  `montantvalide` decimal(10,2) DEFAULT NULL,
  `datemodif` date DEFAULT NULL,
  `idetat` char(2) DEFAULT 'CR',
  PRIMARY KEY (`idvisiteur`,`mois`),
  KEY `idetat` (`idetat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fichefrais`
--

INSERT INTO `fichefrais` (`idvisiteur`, `mois`, `nbjustificatifs`, `montantvalide`, `datemodif`, `idetat`) VALUES
('a131', '202011', 0, '0.00', '2020-11-23', 'CR'),
('a17', '202011', 0, '0.00', '2020-11-24', 'VA'),
('a17', '202012', 0, '0.00', '2020-12-01', 'CR'),
('e52', '202011', 0, '0.00', '2020-11-24', 'VA'),
('f39', '202011', 0, '0.00', '2020-11-10', 'CR');

-- --------------------------------------------------------

--
-- Structure de la table `fraisforfait`
--

DROP TABLE IF EXISTS `fraisforfait`;
CREATE TABLE IF NOT EXISTS `fraisforfait` (
  `id` char(3) NOT NULL,
  `libelle` char(20) DEFAULT NULL,
  `montant` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fraisforfait`
--

INSERT INTO `fraisforfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', '110.00'),
('KM', 'Frais Kilométrique', '0.62'),
('NUI', 'Nuitée Hôtel', '80.00'),
('REP', 'Repas Restaurant', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `fraiskm`
--

DROP TABLE IF EXISTS `fraiskm`;
CREATE TABLE IF NOT EXISTS `fraiskm` (
  `id` int(11) NOT NULL,
  `libelle` varchar(45) NOT NULL,
  `prix` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fraiskm`
--

INSERT INTO `fraiskm` (`id`, `libelle`, `prix`) VALUES
(0, '4CV Diesel', '0.52'),
(1, '5/6CV Diesel', '0.58'),
(2, '4CV Essence', '0.62'),
(3, '5/6CV Essence', '0.67');

-- --------------------------------------------------------

--
-- Structure de la table `lignefraisforfait`
--

DROP TABLE IF EXISTS `lignefraisforfait`;
CREATE TABLE IF NOT EXISTS `lignefraisforfait` (
  `idvisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `idfraisforfait` char(3) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  PRIMARY KEY (`idvisiteur`,`mois`,`idfraisforfait`),
  KEY `idfraisforfait` (`idfraisforfait`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lignefraisforfait`
--

INSERT INTO `lignefraisforfait` (`idvisiteur`, `mois`, `idfraisforfait`, `quantite`) VALUES
('a131', '202011', 'ETP', 8),
('a131', '202011', 'KM', 9),
('a131', '202011', 'NUI', 4),
('a131', '202011', 'REP', 3),
('a17', '202011', 'ETP', 10),
('a17', '202011', 'KM', 10),
('a17', '202011', 'NUI', 3),
('a17', '202011', 'REP', 1),
('a17', '202012', 'ETP', 0),
('a17', '202012', 'KM', 0),
('a17', '202012', 'NUI', 0),
('a17', '202012', 'REP', 0),
('e52', '202011', 'ETP', 20),
('e52', '202011', 'KM', 600),
('e52', '202011', 'NUI', 15),
('e52', '202011', 'REP', 20),
('f39', '202011', 'ETP', 23),
('f39', '202011', 'KM', 90),
('f39', '202011', 'NUI', 10),
('f39', '202011', 'REP', 20);

-- --------------------------------------------------------

--
-- Structure de la table `lignefraishorsforfait`
--

DROP TABLE IF EXISTS `lignefraishorsforfait`;
CREATE TABLE IF NOT EXISTS `lignefraishorsforfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idvisiteur` char(4) CHARACTER SET latin1 NOT NULL,
  `mois` char(6) CHARACTER SET latin1 NOT NULL,
  `libelle` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `date` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idvisiteur` (`idvisiteur`,`mois`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `lignefraishorsforfait`
--

INSERT INTO `lignefraishorsforfait` (`id`, `idvisiteur`, `mois`, `libelle`, `date`, `montant`) VALUES
(4, 'a131', '202011', 'Salon de l\'agriculture', '2020-11-23', '250.00'),
(6, 'a17', '202011', 'essence', '2020-11-09', '89.00'),
(9, 'a17', '202011', 'Salon de l&#39;agriculture', '2020-11-05', '150.00');

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) DEFAULT NULL,
  `prixKM` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`id`, `libelle`, `prixKM`) VALUES
(1, 'Diesel4CV', '0.52'),
(2, 'Diesel5/6CV', '0.58'),
(3, 'Essence4CV', '0.62'),
(4, 'Essence5/6CV', '0.67');

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

DROP TABLE IF EXISTS `visiteur`;
CREATE TABLE IF NOT EXISTS `visiteur` (
  `id` char(4) NOT NULL,
  `nom` char(30) DEFAULT NULL,
  `prenom` char(30) DEFAULT NULL,
  `login` char(20) DEFAULT NULL,
  `mdp` varchar(500) DEFAULT NULL,
  `adresse` char(30) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(30) DEFAULT NULL,
  `dateembauche` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `visiteur`
--

INSERT INTO `visiteur` (`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateembauche`) VALUES
('a131', 'Villechalane', 'Louis', 'lvillachane', 'ca3983640f22d6a38a0708731ac697146026828b88594f9522ae5517960bd56d', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21'),
('a17', 'Andre', 'David', 'dandre', '165a63d5371a0ccb21b23e8881d59116bfd8377d9cad418de1215da4af09e39d', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23'),
('a55', 'Bedos', 'Christian', 'cbedos', '7461ef03c6debab576933c6e42e71bfdd9f070da3abbb5d8758fa1fc3fe65fc0', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12'),
('a93', 'Tusseau', 'Louis', 'ltusseau', '227daca101749f45a829988faf79144d87d1d2e7a90ce07896ec56e697b7a449', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01'),
('b13', 'Bentot', 'Pascal', 'pbentot', 'e0020387b3eaa7414296fdfa7af5cfe48f6cf514f4350df2ff23b138e5e80e9e', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09'),
('b16', 'Bioret', 'Luc', 'lbioret', '4dcb2c67707621b6bfa81c71db8ea33f6bfe217275bad06241d1f0cdd9171fd3', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11'),
('b19', 'Bunisset', 'Francis', 'fbunisset', '57b592489c1851ed5db43ab164cb2e3fbf88a3eeeba963518f41798260d0fdaa', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21'),
('b25', 'Bunisset', 'Denise', 'dbunisset', '4de535fc4bb81bf16f8396701c72b84dbcfaa1232823cbc62fbf9d8295840921', '23 rue Manin', '75019', 'paris', '2010-12-05'),
('b28', 'Cacheux', 'Bernard', 'bcacheux', '9be0be929c729fe93b16b974b6a7f79ce77ecb399135f23ba8c47318bc3f0885', '114 rue Blanche', '75017', 'Paris', '2009-11-12'),
('b34', 'Cadic', 'Eric', 'ecadic', 'ed5c1022a39ba567bf81c922e7bebcefe1ae1bb29f1ee4d68cb571096ab699cd', '123 avenue de la République', '75011', 'Paris', '2008-09-23'),
('b4', 'Charoze', 'Catherine', 'ccharoze', '659d7ec12a1ed4710ca30bacba2049029cba5f6f8946f55d5150301b2c2bb620', '100 rue Petit', '75019', 'Paris', '2005-11-12'),
('b50', 'Clepkens', 'Christophe', 'cclepkens', '7e9353475b3d90a2ffbedd346b8fd143ff42d8808b43aa8b804465d98827925c', '12 allée des Anges', '93230', 'Romainville', '2003-08-11'),
('b59', 'Cottin', 'Vincenne', 'vcottin', '264fa0634d763fefc9de03d9412af78b553304a1e59bc7c1faf8fd5b4fd26e48', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18'),
('c14', 'Daburon', 'François', 'fdaburon', '2558ad19d564eeafadc7395065d14f6fc244e21c9510079838d5d5c2aa660385', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11'),
('c3', 'De', 'Philippe', 'pde', '80a51081489841526217f5958fe37b1231a8385aa6195c4d5f13cda07ef112b1', '13 rue Barthes', '94000', 'Créteil', '2010-12-14'),
('c54', 'Debelle', 'Michel', 'mdebelle', 'e87f267d00031b3853d13ea6c4abd3aa8ba9a7362f151b23b1d8ab7a36237661', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23'),
('d13', 'Debelle', 'Jeanne', 'jdebelle', '8447a77dcc8a1ab290625d2de92107ad506fe226f21ccc7b94db5576957371e9', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11'),
('d51', 'Debroise', 'Michel', 'mdebroise', 'd908f177158faee7d45535e52ca19d1182a4cfc2ac2c44cc6d56540a36b43e08', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17'),
('e22', 'Desmarquest', 'Nathalie', 'ndesmarquest', '045758ae4faff6e3a69776daea65b425c06df1806fb9fee23001b51ce8ad92f7', '14 Place d Arc', '45000', 'Orléans', '2005-11-12'),
('e24', 'Desnost', 'Pierre', 'pdesnost', '9afdf4579e4688162115b09e0a72a810a3a0db98c3142d2a524d2fbb7a1d83a9', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05'),
('e39', 'Dudouit', 'Frédéric', 'fdudouit', '82189fa33089b33bda4fe93c84cc0ef3e9b5746222735ea948f85aa4faa92b8c', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01'),
('e49', 'Duncombe', 'Claude', 'cduncombe', '1a96aed84026e53d447df5b3501f468b6b1a104d496183b80010aec0ed6e57e3', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10'),
('e5', 'Enault-Pascreau', 'Céline', 'cenault', '5044827970b11b704c3f4bd8025c38a334df3a194247e6b03c3a330eab07316c', '25 place de la gare', '23200', 'Gueret', '1995-09-01'),
('e52', 'Eynde', 'Valérie', 'veynde', '9d3744e22dcada1717408fdf079bff21f3f8cb514e3402b19d990df01f33325e', '3 Grand Place', '13015', 'Marseille', '1999-11-01'),
('f21', 'Finck', 'Jacques', 'jfinck', '577d67f320202216ee7f2fe26b363daada983b0d06521a7c89aeb049eafc97f5', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10'),
('f39', 'Frémont', 'Fernande', 'ffremont', 'b409a4db2e8a88fb10f427ef3ff3452dd3489b75648a7593f6ad74d4572ae06b', '4 route de la mer', '13012', 'Allauh', '1998-10-01'),
('f4', 'Gest', 'Alain', 'agest', 'a8a5b00ccbc425791ae7e9bdca16fc7e108c9d58e6d70b0c66f327b82b083ec9', '30 avenue de la mer', '13025', 'Berre', '1985-11-01');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `fichefrais`
--
ALTER TABLE `fichefrais`
  ADD CONSTRAINT `fichefrais_ibfk_1` FOREIGN KEY (`idetat`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `fichefrais_ibfk_2` FOREIGN KEY (`idvisiteur`) REFERENCES `visiteur` (`id`);

--
-- Contraintes pour la table `lignefraisforfait`
--
ALTER TABLE `lignefraisforfait`
  ADD CONSTRAINT `lignefraisforfait_ibfk_1` FOREIGN KEY (`idvisiteur`,`mois`) REFERENCES `fichefrais` (`idvisiteur`, `mois`),
  ADD CONSTRAINT `lignefraisforfait_ibfk_2` FOREIGN KEY (`idfraisforfait`) REFERENCES `fraisforfait` (`id`);

--
-- Contraintes pour la table `lignefraishorsforfait`
--
ALTER TABLE `lignefraishorsforfait`
  ADD CONSTRAINT `lignefraishorsforfait_ibfk_1` FOREIGN KEY (`idvisiteur`,`mois`) REFERENCES `fichefrais` (`idvisiteur`, `mois`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
