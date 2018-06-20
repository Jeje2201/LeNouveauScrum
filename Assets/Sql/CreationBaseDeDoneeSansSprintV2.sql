
CREATE DATABASE scrum;
USE scrum;

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 20 juin 2018 à 12:29
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `scrum`
--

-- --------------------------------------------------------

--
-- Structure de la table `attribution`
--

DROP TABLE IF EXISTS `attribution`;
CREATE TABLE IF NOT EXISTS `attribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heure` smallint(6) DEFAULT NULL,
  `id_Sprint` int(11) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL,
  `id_Projet` int(11) DEFAULT NULL,
  `id_Caracteristiques` int(11) DEFAULT NULL,
  `id_TypeTache` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Attribution_id_Sprint` (`id_Sprint`),
  KEY `FK_Attribution_id_Employe` (`id_Employe`),
  KEY `FK_Attribution_id_Projet` (`id_Projet`),
  KEY `FK_Attribution_id_Caracteristiques` (`id_Caracteristiques`),
  KEY `FK_Attribution_id_TypeTache` (`id_TypeTache`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `caracteristiques`
--

DROP TABLE IF EXISTS `caracteristiques`;
CREATE TABLE IF NOT EXISTS `caracteristiques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `caracteristiques`
--

INSERT INTO `caracteristiques` (`id`, `nom`) VALUES
(1, 'Spike'),
(2, 'Test'),
(3, 'Developpement'),
(4, 'Redaction'),
(5, 'Preuve de concept'),
(6, 'Reunion');

-- --------------------------------------------------------

--
-- Structure de la table `demo`
--

DROP TABLE IF EXISTS `demo`;
CREATE TABLE IF NOT EXISTS `demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(25) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL,
  `id_StatutDemo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Demo_id_Employe` (`id_Employe`),
  KEY `FK_Demo_id_StatutDemo` (`id_StatutDemo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `disponible`
--

DROP TABLE IF EXISTS `disponible`;
CREATE TABLE IF NOT EXISTS `disponible` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DateValable` date DEFAULT NULL,
  `heure` tinyint(4) DEFAULT NULL,
  `id_Sprint` int(11) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Disponible_id_Sprint` (`id_Sprint`),
  KEY `FK_Disponible_id_Employe` (`id_Employe`)
) ENGINE=InnoDB AUTO_INCREMENT=302 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Initial` varchar(5) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `Couleur` varchar(7) DEFAULT NULL,
  `actif` tinyint(1) DEFAULT NULL,
  `id_TypeEmploye` int(11) DEFAULT NULL,
  `id_Poste` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Employe_id_TypeEmploye` (`id_TypeEmploye`),
  KEY `FK_Employe_id_Poste` (`id_Poste`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id`, `Initial`, `prenom`, `nom`, `Couleur`, `actif`, `id_TypeEmploye`, `id_Poste`) VALUES
(1, 'AD', 'Abel', 'Delannoy', NULL, 0, NULL, NULL),
(2, 'AS', 'Almudena', 'SanRoman', NULL, 0, NULL, NULL),
(3, 'AS', 'Amandine', 'Sahl', NULL, 0, NULL, NULL),
(4, 'AM', 'Antoine', 'Micelli', NULL, 0, NULL, NULL),
(5, 'CR', 'Cecile', 'Robin', NULL, 0, NULL, NULL),
(6, 'CS', 'Cedric', 'Seguin', NULL, 0, NULL, NULL),
(7, 'CV', 'Celine', 'Vidal', NULL, 0, NULL, NULL),
(8, 'CK', 'Christelle', 'Khozian', NULL, 0, NULL, NULL),
(9, 'CG', 'Cyril', 'Gautreau', NULL, 0, NULL, NULL),
(10, 'DL', 'David', 'Lassagne', NULL, 0, NULL, NULL),
(11, 'EP', 'Eric', 'Pringels', NULL, 0, NULL, NULL),
(12, 'FB', 'Fabien', 'Buisson', NULL, 0, NULL, NULL),
(13, 'FF', 'Florian', 'Fauchier', NULL, 0, NULL, NULL),
(14, 'FB', 'Frederic', 'Berton', NULL, 1, NULL, NULL),
(15, 'GT', 'Gerald', 'Tibi', NULL, 0, NULL, NULL),
(16, 'GF', 'Ghislain', 'Fortin', NULL, 0, NULL, NULL),
(17, 'GB', 'Gilles', 'Bassiere', NULL, 0, NULL, NULL),
(18, 'JT', 'Jerome', 'TenShong', NULL, 0, NULL, NULL),
(19, 'JL', 'Jean Francois', 'Leger', NULL, 0, NULL, NULL),
(20, 'JA', 'Jean-Vitus', 'Albertini', '#68f06b', 1, NULL, NULL),
(21, 'JD', 'Jeanne', 'Dauvergne', NULL, 0, NULL, NULL),
(22, 'JL', 'Jeremy', 'Leriche', NULL, 1, NULL, NULL),
(23, 'JC', 'Julie', 'Chabalier', NULL, 0, NULL, NULL),
(24, 'JB', 'Julien', 'Bono', NULL, 0, NULL, NULL),
(25, 'KS', 'Kamel', 'Sabri', NULL, 0, NULL, NULL),
(26, 'KT', 'Khaled', 'Talbi', NULL, 0, NULL, NULL),
(27, 'LC', 'Lea', 'Charbonnier', NULL, 0, NULL, NULL),
(28, 'LP', 'Laura', 'Perez', NULL, 0, NULL, NULL),
(29, 'MM', 'Marion', 'Marcoux', NULL, 0, NULL, NULL),
(30, 'MJ', 'Matheo', 'Jaouen', NULL, 0, NULL, NULL),
(31, 'MT', 'Mathieu', 'Thomazo', NULL, 0, NULL, NULL),
(32, 'OR', 'Olivier', 'Rovellotti', '#000000', 0, NULL, NULL),
(33, 'PD', 'Pierre', 'Delaunay', NULL, 0, NULL, NULL),
(34, 'RF', 'Romain', 'Fabbro', NULL, 0, NULL, NULL),
(35, 'SM', 'Sabine', 'Meneut', NULL, 0, NULL, NULL),
(36, 'SB', 'Sandra', 'Bonnot', NULL, 0, NULL, NULL),
(37, 'SR', 'Stephanie', 'Ritz', NULL, 0, NULL, NULL),
(38, 'TA', 'Tamou', 'Amadha', NULL, 0, NULL, NULL),
(39, 'TR', 'Thibault', 'Rhudel', NULL, 0, NULL, NULL),
(40, 'TP', 'Thomas', 'Peel', '#000000', 0, NULL, NULL),
(41, 'TL', 'Tom', 'Lopez', NULL, 1, NULL, NULL),
(42, 'VB', 'Vincent', 'Bourgeois', NULL, 0, NULL, NULL),
(43, 'VG', 'Vivien', 'Grivaud', NULL, 0, NULL, NULL),
(44, 'YT', 'Yacine', 'Thomazo', NULL, 0, NULL, NULL),
(45, 'GG', 'Groupe', 'Groupe', NULL, 1, NULL, NULL),
(46, 'AR', 'Angelique', 'Ries', '#ff00fa', 1, NULL, NULL),
(47, 'NH', 'Nabil', 'Hamadou', '#dd2024', 1, NULL, NULL),
(48, 'RK', 'Romain', 'Knezevitch', '#ff00fa', 0, NULL, NULL),
(49, 'CL', 'Christophe', 'Lavagna', '#99e3e3', 1, NULL, NULL),
(50, 'HA', 'HervÃ©', 'Aymes', '#86f997', 0, NULL, NULL),
(51, 'SP', 'SÃ©bastien', 'Paris', '#ff00fa', 0, NULL, NULL),
(52, 'NF', 'Naomi', 'Fischer', '#a4f898', 1, NULL, NULL),
(53, 'JD', 'Julien', 'Dejasmin', '#ff00fa', 1, NULL, NULL),
(54, 'EV', 'El-Makki', 'Voundy', '#fe787b', 1, NULL, NULL),
(55, 'RG', 'RÃ©mi', 'Guijarro Espinosa', '#4da4b3', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `employe_projet`
--

DROP TABLE IF EXISTS `employe_projet`;
CREATE TABLE IF NOT EXISTS `employe_projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Projet` int(11) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Employe_Projet_id_Projet` (`id_Projet`),
  KEY `FK_Employe_Projet_id_Employe` (`id_Employe`)
) ENGINE=InnoDB AUTO_INCREMENT=220 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `employe_projet`
--

INSERT INTO `employe_projet` (`id`, `id_Projet`, `id_Employe`) VALUES
(1, 1, 43),
(2, 1, 33),
(3, 2, 33),
(4, 3, 39),
(5, 3, 33),
(6, 3, 35),
(7, 7, 14),
(8, 7, 10),
(9, 7, 15),
(10, 10, 14),
(11, 10, 30),
(12, 10, 15),
(13, 10, 34),
(14, 10, 35),
(15, 16, 10),
(16, 19, 10),
(17, 20, 14),
(18, 20, 10),
(19, 20, 41),
(20, 20, 15),
(21, 24, 10),
(22, 24, 15),
(23, 30, 43),
(24, 30, 33),
(25, 7, 41),
(26, 7, 34),
(27, 7, 33),
(28, 9, 7),
(29, 9, 42),
(30, 10, 26),
(31, 10, 20),
(32, 16, 14),
(33, 16, 34),
(34, 20, 43),
(35, 20, 33),
(36, 23, 14),
(37, 23, 41),
(38, 23, 34),
(39, 23, 26),
(40, 23, 35),
(41, 24, 14),
(42, 24, 26),
(43, 26, 7),
(44, 26, 42),
(45, 30, 7),
(46, 30, 42),
(47, 1, 11),
(48, 7, 30),
(49, 7, 26),
(50, 16, 11),
(51, 23, 11),
(52, 23, 7),
(53, 23, 33),
(54, 28, 11),
(64, 69, 7),
(65, 69, 14),
(66, 69, 26),
(67, 69, 30),
(68, 69, 32),
(69, 69, 34),
(70, 69, 43),
(71, 70, 7),
(72, 70, 14),
(73, 70, 26),
(74, 70, 32),
(75, 70, 43),
(76, 67, 7),
(77, 67, 10),
(78, 67, 33),
(79, 67, 14),
(80, 67, 26),
(81, 67, 41),
(82, 67, 43),
(83, 66, 7),
(84, 66, 14),
(85, 66, 26),
(86, 66, 32),
(87, 68, 7),
(88, 68, 14),
(89, 68, 26),
(90, 68, 30),
(91, 68, 32),
(92, 68, 34),
(93, 68, 41),
(94, 71, 1),
(95, 71, 2),
(96, 71, 3),
(97, 71, 4),
(98, 71, 5),
(99, 71, 6),
(100, 71, 7),
(101, 71, 8),
(102, 71, 9),
(103, 71, 10),
(104, 71, 11),
(105, 71, 12),
(106, 71, 13),
(107, 71, 14),
(108, 71, 15),
(109, 71, 16),
(110, 71, 17),
(111, 71, 18),
(112, 71, 19),
(113, 71, 20),
(114, 71, 21),
(115, 71, 22),
(116, 71, 23),
(117, 71, 24),
(118, 71, 25),
(119, 71, 26),
(120, 71, 27),
(121, 71, 28),
(122, 71, 29),
(123, 71, 30),
(124, 71, 31),
(125, 71, 32),
(126, 71, 33),
(127, 71, 34),
(128, 71, 35),
(129, 71, 36),
(130, 71, 37),
(131, 71, 38),
(132, 71, 39),
(133, 71, 40),
(134, 71, 41),
(135, 71, 42),
(136, 71, 43),
(137, 71, 44),
(138, 71, 45),
(157, 72, 1),
(158, 72, 2),
(159, 72, 3),
(160, 72, 4),
(161, 72, 5),
(162, 72, 6),
(163, 72, 7),
(164, 72, 8),
(165, 72, 9),
(166, 72, 10),
(167, 72, 11),
(168, 72, 12),
(169, 72, 13),
(170, 72, 14),
(171, 72, 15),
(172, 72, 16),
(173, 72, 17),
(174, 72, 18),
(175, 72, 19),
(176, 72, 20),
(177, 72, 21),
(178, 72, 22),
(179, 72, 23),
(180, 72, 24),
(181, 72, 25),
(182, 72, 26),
(183, 72, 27),
(184, 72, 28),
(185, 72, 29),
(186, 72, 30),
(187, 72, 31),
(188, 72, 32),
(189, 72, 33),
(190, 72, 34),
(191, 72, 35),
(192, 72, 36),
(193, 72, 37),
(194, 72, 38),
(195, 72, 39),
(196, 72, 40),
(197, 72, 41),
(198, 72, 42),
(199, 72, 43),
(200, 72, 44),
(201, 72, 45);

-- --------------------------------------------------------

--
-- Structure de la table `heuresdescendues`
--

DROP TABLE IF EXISTS `heuresdescendues`;
CREATE TABLE IF NOT EXISTS `heuresdescendues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heure` tinyint(4) DEFAULT NULL,
  `DateDescendu` date DEFAULT NULL,
  `id_Sprint` int(11) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL,
  `id_Projet` int(11) DEFAULT NULL,
  `id_Attribution` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_HeuresDescendues_id_Sprint` (`id_Sprint`),
  KEY `FK_HeuresDescendues_id_Employe` (`id_Employe`),
  KEY `FK_HeuresDescendues_id_Projet` (`id_Projet`),
  KEY `FK_HeuresDescendues_id_Attribution` (`id_Attribution`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `interference`
--

DROP TABLE IF EXISTS `interference`;
CREATE TABLE IF NOT EXISTS `interference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heure` int(11) DEFAULT NULL,
  `id_TypeInterference` int(11) DEFAULT NULL,
  `id_Sprint` int(11) DEFAULT NULL,
  `id_Projet` int(11) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Interference_id_TypeInterference` (`id_TypeInterference`),
  KEY `FK_Interference_id_Sprint` (`id_Sprint`),
  KEY `FK_Interference_id_Projet` (`id_Projet`),
  KEY `FK_Interference_id_Employe` (`id_Employe`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `objectif`
--

DROP TABLE IF EXISTS `objectif`;
CREATE TABLE IF NOT EXISTS `objectif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Sprint` int(11) DEFAULT NULL,
  `id_Projet` int(11) DEFAULT NULL,
  `objectif` varchar(255) DEFAULT NULL,
  `id_StatutObjectif` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Objectif_id_StatutObjectif` (`id_StatutObjectif`),
  KEY `IdDuSprintDepuisObjectif` (`id_Sprint`),
  KEY `IdDuProjetDepuisObjectif` (`id_Projet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `poste`
--

DROP TABLE IF EXISTS `poste`;
CREATE TABLE IF NOT EXISTS `poste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

DROP TABLE IF EXISTS `projet`;
CREATE TABLE IF NOT EXISTS `projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `couleur` varchar(25) DEFAULT NULL,
  `abreviation` varchar(5) DEFAULT NULL,
  `cheminIcone` varchar(50) DEFAULT NULL,
  `id_TypeProjet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Projet_id_TypeProjet` (`id_TypeProjet`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`id`, `nom`, `couleur`, `abreviation`, `cheminIcone`, `id_TypeProjet`) VALUES
(1, 'AO', NULL, NULL, 'inconnue', NULL),
(2, 'PIM-Atlas', NULL, NULL, 'inconnue', NULL),
(3, 'ecoBalade', NULL, NULL, 'inconnue', NULL),
(4, 'eCollection', NULL, NULL, 'inconnue', NULL),
(5, 'iFeedBird', NULL, NULL, 'inconnue', NULL),
(6, 'Multiprojets', NULL, NULL, 'inconnue', NULL),
(7, 'Data Centralization', NULL, NULL, 'inconnue', NULL),
(8, 'Tuyaux (Bonna)', NULL, NULL, 'inconnue', NULL),
(9, 'Noe', NULL, NULL, 'inconnue', NULL),
(10, 'ecoReleve Data', NULL, NULL, 'inconnue', NULL),
(11, 'eReleve', NULL, NULL, 'inconnue', NULL),
(12, 'Kitizen', NULL, NULL, 'inconnue', NULL),
(13, 'INPN', NULL, NULL, 'inconnue', NULL),
(14, 'Collier Loups', NULL, NULL, 'inconnue', NULL),
(15, 'BioLit', NULL, NULL, 'inconnue', NULL),
(16, 'FormBuilder', NULL, NULL, 'inconnue', NULL),
(17, 'Sauvages de ma rue PACA', NULL, NULL, 'inconnue', NULL),
(18, 'Mycoflore', NULL, NULL, 'inconnue', NULL),
(19, 'Site Web NS', NULL, NULL, 'inconnue', NULL),
(20, 'TRACK', NULL, NULL, 'inconnue', NULL),
(21, 'Photomapping', NULL, NULL, 'inconnue', NULL),
(22, 'ButterflyId', NULL, NULL, 'inconnue', NULL),
(23, 'NS Interne', NULL, NULL, 'inconnue', NULL),
(24, 'Renecore Apps', NULL, NULL, 'inconnue', NULL),
(25, 'Mon jardin', NULL, NULL, 'inconnue', NULL),
(26, 'Green citizen', NULL, NULL, 'inconnue', NULL),
(27, 'Alerting App', NULL, NULL, 'inconnue', NULL),
(28, 'Futback', NULL, NULL, 'inconnue', NULL),
(29, 'Sweet', NULL, NULL, 'inconnue', NULL),
(30, 'Aveyron nature', NULL, NULL, 'inconnue', NULL),
(31, 'Tout a pied', NULL, NULL, 'inconnue', NULL),
(32, 'ecoReleve Explorer', NULL, NULL, 'inconnue', NULL),
(33, 'Footback', NULL, NULL, 'inconnue', NULL),
(34, 'ecoReleve Core', NULL, NULL, 'inconnue', NULL),
(35, 'M-EOL', NULL, NULL, 'inconnue', NULL),
(36, 'Nature en Ville', NULL, NULL, 'inconnue', NULL),
(37, 'CAU13', NULL, NULL, 'inconnue', NULL),
(38, 'ecoReleve Glossaire', NULL, NULL, 'inconnue', NULL),
(39, 'ecoOnto', NULL, NULL, 'inconnue', NULL),
(40, 'geodiva', NULL, NULL, 'inconnue', NULL),
(41, 'GR2013 2.0', NULL, NULL, 'inconnue', NULL),
(42, 'Pocket', NULL, NULL, 'inconnue', NULL),
(43, 'Site Web Labs', NULL, NULL, 'inconnue', NULL),
(44, 'Armadillo', NULL, NULL, 'inconnue', NULL),
(45, 'PIM', NULL, NULL, 'inconnue', NULL),
(46, 'SIB', NULL, NULL, 'inconnue', NULL),
(47, 'ecoOnto-med', NULL, NULL, 'inconnue', NULL),
(48, 'ecoReleve Mobile', NULL, NULL, 'inconnue', NULL),
(49, 'Mica environnement', NULL, NULL, 'inconnue', NULL),
(50, 'Valo - LIF', NULL, NULL, 'inconnue', NULL),
(51, 'AAP FP7 environnement', NULL, NULL, 'inconnue', NULL),
(52, 'Carnet de plongee', NULL, NULL, 'inconnue', NULL),
(53, 'Curieux2Sciences', NULL, NULL, 'inconnue', NULL),
(54, 'EcoBalade Bidules', NULL, NULL, 'inconnue', NULL),
(55, 'ecoReleve', NULL, NULL, 'inconnue', NULL),
(56, 'ecoReleve Core/GIS', NULL, NULL, 'inconnue', NULL),
(57, 'eReleve-Release', NULL, NULL, 'inconnue', NULL),
(58, 'Faro', NULL, NULL, 'inconnue', NULL),
(59, 'MICA', NULL, NULL, 'inconnue', NULL),
(60, 'Open Data', NULL, NULL, 'inconnue', NULL),
(61, 'ANDD', NULL, NULL, 'inconnue', NULL),
(62, 'Sentiers sous-marins', NULL, NULL, 'inconnue', NULL),
(63, 'TeamBuildingEcoBalade_Bioblitz', NULL, NULL, 'inconnue', NULL),
(64, 'Marche des collines', NULL, NULL, 'inconnue', NULL),
(65, 'OCK', NULL, NULL, 'inconnue', NULL),
(66, 'Scrum', NULL, NULL, 'inconnue', NULL),
(67, 'Position', NULL, NULL, 'inconnue', NULL),
(68, 'Biotope', NULL, NULL, 'inconnue', NULL),
(69, 'Airele', NULL, NULL, 'inconnue', NULL),
(70, 'SECAFI', NULL, NULL, 'inconnue', NULL),
(71, 'Support', NULL, NULL, 'inconnue', NULL),
(72, 'Inconnu', NULL, NULL, 'inconnue', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sprint`
--

DROP TABLE IF EXISTS `sprint`;
CREATE TABLE IF NOT EXISTS `sprint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(10) DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `statutdemo`
--

DROP TABLE IF EXISTS `statutdemo`;
CREATE TABLE IF NOT EXISTS `statutdemo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  `couleur` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `statutobjectif`
--

DROP TABLE IF EXISTS `statutobjectif`;
CREATE TABLE IF NOT EXISTS `statutobjectif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `couleur` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `statutobjectif`
--

INSERT INTO `statutobjectif` (`id`, `nom`, `couleur`) VALUES
(1, 'Ok', '#95D972'),
(2, 'En cours', '#E88648'),
(3, 'Non', '#E8514E'),
(4, 'Annule', '#E8514E'),
(5, '?', '#222222');

-- --------------------------------------------------------

--
-- Structure de la table `typeemploye`
--

DROP TABLE IF EXISTS `typeemploye`;
CREATE TABLE IF NOT EXISTS `typeemploye` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typeemploye`
--

INSERT INTO `typeemploye` (`id`, `nom`) VALUES
(1, 'Graphiste'),
(2, 'Designer'),
(3, 'Developpeur'),
(4, 'ChefProjet'),
(5, 'Naturaliste'),
(6, 'ScrumMaster');

-- --------------------------------------------------------

--
-- Structure de la table `typeinterference`
--

DROP TABLE IF EXISTS `typeinterference`;
CREATE TABLE IF NOT EXISTS `typeinterference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typeinterference`
--

INSERT INTO `typeinterference` (`id`, `nom`) VALUES
(1, 'Interferences'),
(2, 'Absence'),
(3, 'Help'),
(4, 'Bugs'),
(5, 'Interruption'),
(6, 'RAB');

-- --------------------------------------------------------

--
-- Structure de la table `typeprojet`
--

DROP TABLE IF EXISTS `typeprojet`;
CREATE TABLE IF NOT EXISTS `typeprojet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  `couleur` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typeprojet`
--

INSERT INTO `typeprojet` (`id`, `nom`, `couleur`) VALUES
(1, 'Reneco', NULL),
(2, 'SciencesParticipatives', NULL),
(3, 'Industriel', NULL),
(4, 'ProduitEditeur', NULL),
(5, 'Autres', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `typetache`
--

DROP TABLE IF EXISTS `typetache`;
CREATE TABLE IF NOT EXISTS `typetache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vburndown`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vburndown`;
CREATE TABLE IF NOT EXISTS `vburndown` (
`id_Sprint` int(11)
,`Date` date
,`HeuresTotalDescendues` decimal(25,0)
,`HeureTotalAttribuées` decimal(27,0)
,`HeuresDescenduesParJour` decimal(25,0)
,`burnDownHour` decimal(48,0)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vvheuresdescendues`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vvheuresdescendues`;
CREATE TABLE IF NOT EXISTS `vvheuresdescendues` (
`id_Sprint` int(11)
,`Date` date
,`HeuresTotalDescendues` decimal(25,0)
,`HeureTotalAttribuées` decimal(27,0)
,`HeuresDescenduesParJour` decimal(25,0)
);

-- --------------------------------------------------------

--
-- Structure de la vue `vburndown`
--
DROP TABLE IF EXISTS `vburndown`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vburndown`  AS  select `v`.`id_Sprint` AS `id_Sprint`,`v`.`Date` AS `Date`,`v`.`HeuresTotalDescendues` AS `HeuresTotalDescendues`,`v`.`HeureTotalAttribuées` AS `HeureTotalAttribuées`,`v`.`HeuresDescenduesParJour` AS `HeuresDescenduesParJour`,(select (`v`.`HeureTotalAttribuées` - sum(`v2`.`HeuresDescenduesParJour`)) from `vvheuresdescendues` `v2` where ((`v`.`Date` >= `v2`.`Date`) and (`v`.`id_Sprint` = `v2`.`id_Sprint`)) group by `v`.`id_Sprint`) AS `burnDownHour` from `vvheuresdescendues` `v` order by `v`.`Date` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vvheuresdescendues`
--
DROP TABLE IF EXISTS `vvheuresdescendues`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vvheuresdescendues`  AS  select `hd0`.`id_Sprint` AS `id_Sprint`,`hd0`.`DateDescendu` AS `Date`,(select sum(`hd1`.`heure`) from `heuresdescendues` `hd1` where (`hd1`.`id_Sprint` = `hd0`.`id_Sprint`) group by `hd1`.`id_Sprint`) AS `HeuresTotalDescendues`,(select sum(`a1`.`heure`) from `attribution` `a1` where (`a1`.`id_Sprint` = `hd0`.`id_Sprint`) group by `a1`.`id_Sprint`) AS `HeureTotalAttribuées`,(select sum(`hd3`.`heure`) from `heuresdescendues` `hd3` where ((`hd3`.`id_Sprint` = `hd0`.`id_Sprint`) and (`hd3`.`DateDescendu` = `hd0`.`DateDescendu`)) group by `hd3`.`DateDescendu`) AS `HeuresDescenduesParJour` from `heuresdescendues` `hd0` group by `hd0`.`DateDescendu`,`hd0`.`id_Sprint` ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `attribution`
--
ALTER TABLE `attribution`
  ADD CONSTRAINT `FK_Attribution_id_Caracteristiques` FOREIGN KEY (`id_Caracteristiques`) REFERENCES `caracteristiques` (`id`),
  ADD CONSTRAINT `FK_Attribution_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `FK_Attribution_id_Projet` FOREIGN KEY (`id_Projet`) REFERENCES `projet` (`id`),
  ADD CONSTRAINT `FK_Attribution_id_Sprint` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Attribution_id_TypeTache` FOREIGN KEY (`id_TypeTache`) REFERENCES `typetache` (`id`);

--
-- Contraintes pour la table `demo`
--
ALTER TABLE `demo`
  ADD CONSTRAINT `FK_Demo_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `FK_Demo_id_StatutDemo` FOREIGN KEY (`id_StatutDemo`) REFERENCES `statutdemo` (`id`);

--
-- Contraintes pour la table `disponible`
--
ALTER TABLE `disponible`
  ADD CONSTRAINT `FK_Disponible_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `FK_Disponible_id_Sprint` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `FK_Employe_id_Poste` FOREIGN KEY (`id_Poste`) REFERENCES `poste` (`id`),
  ADD CONSTRAINT `FK_Employe_id_TypeEmploye` FOREIGN KEY (`id_TypeEmploye`) REFERENCES `typeemploye` (`id`);

--
-- Contraintes pour la table `employe_projet`
--
ALTER TABLE `employe_projet`
  ADD CONSTRAINT `FK_Employe_Projet_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `FK_Employe_Projet_id_Projet` FOREIGN KEY (`id_Projet`) REFERENCES `projet` (`id`);

--
-- Contraintes pour la table `heuresdescendues`
--
ALTER TABLE `heuresdescendues`
  ADD CONSTRAINT `FK_HeuresDescendues_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `FK_HeuresDescendues_id_Projet` FOREIGN KEY (`id_Projet`) REFERENCES `projet` (`id`),
  ADD CONSTRAINT `FK_HeuresDescendues_id_Sprint` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `heuresdescendues_ibfk_1` FOREIGN KEY (`id_Attribution`) REFERENCES `attribution` (`id`);

--
-- Contraintes pour la table `interference`
--
ALTER TABLE `interference`
  ADD CONSTRAINT `FK_Interference_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `FK_Interference_id_Projet` FOREIGN KEY (`id_Projet`) REFERENCES `projet` (`id`),
  ADD CONSTRAINT `FK_Interference_id_Sprint` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Interference_id_TypeInterference` FOREIGN KEY (`id_TypeInterference`) REFERENCES `typeinterference` (`id`);

--
-- Contraintes pour la table `objectif`
--
ALTER TABLE `objectif`
  ADD CONSTRAINT `FK_Objectif_id_StatutObjectif` FOREIGN KEY (`id_StatutObjectif`) REFERENCES `statutobjectif` (`id`),
  ADD CONSTRAINT `objectif_ibfk_1` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `objectif_ibfk_2` FOREIGN KEY (`id_Projet`) REFERENCES `projet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `FK_Projet_id_TypeProjet` FOREIGN KEY (`id_TypeProjet`) REFERENCES `typeprojet` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
