
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données :  `club`
--
-- --------------------------------------------------------
--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `idMessage` int(11) NOT NULL AUTO_INCREMENT ,
  `emailContact` char(40) NOT NULL,
  `messageContact` char(200) NOT NULL,
  PRIMARY KEY (`idMessage`)
 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `message` (`emailContact`, `messageContact`) VALUES
('cathy.delmas@laposte.net', 'test1'),
('cathy.delmas@laposte.net', 'test2');


-- --------------------------------------------------------
--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `idAdmin` int(11) NOT NULL AUTO_INCREMENT ,
  `nomAdmin` char(32) NOT NULL,
  `prenomAdmin` char(32) NOT NULL,
  `loginAdmin` char(20) NOT NULL,
  `pwdAdmin` char(20) NOT NULL,
  PRIMARY KEY (`idAdmin`)
 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `administrateur` (`idAdmin`, `nomAdmin`, `prenomAdmin`, `loginAdmin`, `pwdAdmin`) VALUES
(1, 'LeFirst', 'Vincent', 'admin','admin'),
(2, 'LeSecond', 'Pierre', 'admin2','admin2');

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

DROP TABLE IF EXISTS `adherent`;
CREATE TABLE IF NOT EXISTS `adherent` (
  `idAdherent` int(11) NOT NULL AUTO_INCREMENT ,
  `nomAdherent` char(32) NOT NULL,
  `prenomAdherent` char(32) NOT NULL,
  `ageAdherent` int(11) NOT NULL,
  `sexeAdherent` char(1) NOT NULL,
  `loginAdherent` char(20) NOT NULL,
  `pwdAdherent` char(20) NOT NULL,
  `idEquipe` int(11) NOT NULL,
  PRIMARY KEY (`idAdherent`) ,
  KEY `fk_adherent_equipe` (`idEquipe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `adherent` (`idAdherent`, `nomAdherent`, `prenomAdherent`, `ageAdherent`, `sexeAdherent`, `loginAdherent`, `pwdAdherent`, `idEquipe`) VALUES
(1, 'Dupont', 'Pierre', 8, 'F', 'pDupont','pDupont',1),
(2, 'Dubois', 'Vincent', 10, 'M','vDubois','vDubois', 1),
(3, 'Durant', 'Jacques', 6, 'M','jDurant','jDurant', 2),
(4, 'Fleur', 'Sophie', 7, 'F','sFleur','sFleur', 2);

-- --------------------------------------------------------

--
-- Structure de la table `entraineur`
--

DROP TABLE IF EXISTS `entraineur`;
CREATE TABLE IF NOT EXISTS `entraineur` (
  `idEntraineur` int(11) NOT NULL AUTO_INCREMENT,
  `nomEntraineur` char(32) NOT NULL,
  `loginEntraineur` char(20) NOT NULL,
  `pwdEntraineur` char(20) NOT NULL,
  PRIMARY KEY (`idEntraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `entraineur` (`idEntraineur`, `nomEntraineur`, `loginEntraineur`, `pwdEntraineur`) VALUES
(1, 'Delbert', 'Delbert', 'Delbert'),
(2, 'Dubois', 'Dubois', 'Dubois'),
(3, 'Bousquet', 'Bousquet', 'Bousquet');

-- --------------------------------------------------------
--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `idEquipe` int(11) NOT NULL AUTO_INCREMENT,
  `nomEquipe` char(32) NOT NULL,
  `nbrPlaceEquipe` int(11) NOT NULL,
  `ageMinEquipe` int(11) NOT NULL,
  `ageMaxEquipe` int(11) NOT NULL,
  `sexeEquipe` char(1) NOT NULL,
  `idEntraineur` int(11) NOT NULL,
  PRIMARY KEY (`idEquipe`),
  KEY `fk_equipe_entraineur` (`idEntraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `equipe` (`idEquipe`, `nomEquipe`, `nbrPlaceEquipe`, `ageMinEquipe`, `ageMaxEquipe`, `sexeEquipe`, `idEntraineur`) VALUES
(1, 'natation', 10, 5, 8, 'F', 3),
(2, 'foot', 20, 10, 12, 'F', 2),
(3, 'judo', 10, 5, 8, 'F', 1),
(4, 'equitation', 10, 5, 8, 'F', 1),
(5, 'volley', 10, 5, 8, 'F', 1),
(6, 'athletisme', 10, 5, 8, 'F', 1),
(7, 'moto cross', 10, 5, 8, 'F', 1);


-- --------------------------------------------------------
--
-- Structure de la table `titulaire`
--

DROP TABLE IF EXISTS `titulaire`;
CREATE TABLE IF NOT EXISTS `titulaire` (
  `idEntraineur` int(11) NOT NULL,
  `dateEmbauche` date NOT NULL,
  PRIMARY KEY (`idEntraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `titulaire` (`idEntraineur`, `dateEmbauche`) VALUES
(1, '2019-10-10'),
(3, '2019-10-12');

-- --------------------------------------------------------
--
-- Structure de la table `vacataire`
--

DROP TABLE IF EXISTS `vacataire`;
CREATE TABLE IF NOT EXISTS `vacataire` (
  `idEntraineur` int(11) NOT NULL,
  `telephoneVacataire` char(14) NOT NULL,
  PRIMARY KEY (`idEntraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `vacataire` (`idEntraineur`, `telephoneVacataire`) VALUES
(2, '06.25.45.12.15');

-- --------------------------------------------------------
--
-- Structure de la table `typeNouvelle`
--

DROP TABLE IF EXISTS `typeNouvelle`;
CREATE TABLE IF NOT EXISTS `typeNouvelle` (
  `idTypeNouvelle` int(11) NOT NULL,
  `libelleTypeNouvelle` char(32) NOT NULL,
  PRIMARY KEY (`idTypeNouvelle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `typeNouvelle` (`idTypeNouvelle`, `libelleTypeNouvelle`) VALUES 
(1, 'sport'),
(2, 'culture'),
(3, 'famille'),
(4, 'pratique');
-- --------------------------------------------------------
--
-- Structure de la table `nouvelle`
--

DROP TABLE IF EXISTS `nouvelle`;
CREATE TABLE IF NOT EXISTS `nouvelle` (
  `idNouvelle` int(11) NOT NULL,
  `dateParutionNouvelle` DATE NOT NULL,
  `descriptionNouvelle` char(150) NOT NULL,
  `idTypeNouvelle` int(11) NOT NULL,
  PRIMARY KEY (`idNouvelle`),
   KEY `fk_nouvelle_typeNouvelle` (`idTypeNouvelle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `nouvelle` (`idNouvelle`, `dateParutionNouvelle`, `descriptionNouvelle`,`idTypeNouvelle`) VALUES 
(1, '2021-07-07', 'Une nouvelle équipe est née : la natation.\r\n',1),
(2, '2021-07-18', 'L équipe de judo est qualifié pour le tournoi régional poid lourd.\r\n',1),
(3, '2021-07-24', 'La vidéothèque sera ouverte dès le 20 Juillet.\r\n',2),
(4, '2021-07-25', 'Réduction de 10% sur l abonnement pass cinéma de la commune.\r\n',2),
(5, '2021-07-12', 'Nous venons de recevoir les nouveaux jeux du parc PERRAULT.\r\n',3),
(6, '2021-07-10', 'Le tarif des entrées familles à la piscine ont baissé de 15% cette année.\r\n',3),
(7, '2021-07-11', 'Organisation d un loto par le club du 3ème age. Tout le monde est le bienvenu.\r\n',4),
(8, '2021-07-12', 'Le club couture organise une vente dans le hall de la Mairie le 20 juillet.\r\n',4);

--
-- Contraintes pour les tables
--

ALTER TABLE `adherent`
  ADD CONSTRAINT `fk_adherent_equipe` FOREIGN KEY (`idEquipe`) REFERENCES `equipe` (`idEquipe`);


ALTER TABLE `equipe`
  ADD CONSTRAINT `fk_equipe_entraineur` FOREIGN KEY (`idEntraineur`) REFERENCES `entraineur` (`idEntraineur`);


ALTER TABLE `titulaire`
  ADD CONSTRAINT `fk_titulaire_entraineur` FOREIGN KEY (`idEntraineur`) REFERENCES `entraineur` (`idEntraineur`);


ALTER TABLE `vacataire`
  ADD CONSTRAINT `fk_vacataire_entraineur` FOREIGN KEY (`idEntraineur`) REFERENCES `entraineur` (`idEntraineur`);
COMMIT;

