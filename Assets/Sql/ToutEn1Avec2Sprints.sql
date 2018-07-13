-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 13 juil. 2018 à 12:43
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

Create Database scrum;
Use scrum;

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
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `attribution`
--

INSERT INTO `attribution` (`id`, `heure`, `id_Sprint`, `id_Employe`, `id_Projet`, `id_Caracteristiques`, `id_TypeTache`) VALUES
(1, 31, 1, 43, 1, NULL, NULL),
(2, 19, 1, 33, 1, NULL, NULL),
(3, 4, 1, 33, 2, NULL, NULL),
(4, 61, 1, 39, 3, NULL, NULL),
(5, 5, 1, 33, 3, NULL, NULL),
(6, 38, 1, 35, 3, NULL, NULL),
(7, 25, 1, 14, 7, NULL, NULL),
(8, 20, 1, 10, 7, NULL, NULL),
(9, 13, 1, 15, 7, NULL, NULL),
(10, 7, 1, 14, 10, NULL, NULL),
(11, 29, 1, 30, 10, NULL, NULL),
(12, 11, 1, 15, 10, NULL, NULL),
(13, 47, 1, 34, 10, NULL, NULL),
(14, 2, 1, 35, 10, NULL, NULL),
(15, 21, 1, 10, 16, NULL, NULL),
(16, 4, 1, 10, 19, NULL, NULL),
(17, 18, 1, 14, 20, NULL, NULL),
(18, 2, 1, 10, 20, NULL, NULL),
(19, 49, 1, 41, 20, NULL, NULL),
(20, 10, 1, 15, 20, NULL, NULL),
(21, 2, 1, 10, 24, NULL, NULL),
(22, 5, 1, 15, 24, NULL, NULL),
(23, 13, 1, 43, 30, NULL, NULL),
(24, 1, 1, 33, 30, NULL, NULL),
(25, 7, 2, 33, 2, NULL, NULL),
(26, 57, 2, 39, 3, NULL, NULL),
(27, 15, 2, 33, 3, NULL, NULL),
(28, 5, 2, 14, 7, NULL, NULL),
(29, 34, 2, 10, 7, NULL, NULL),
(30, 7, 2, 41, 7, NULL, NULL),
(31, 15, 2, 34, 7, NULL, NULL),
(32, 7, 2, 33, 7, NULL, NULL),
(33, 3, 2, 7, 9, NULL, NULL),
(34, 2, 2, 42, 9, NULL, NULL),
(35, 27, 2, 30, 10, NULL, NULL),
(36, 7, 2, 34, 10, NULL, NULL),
(37, 34, 2, 26, 10, NULL, NULL),
(38, 56, 2, 20, 10, NULL, NULL),
(39, 4, 2, 14, 16, NULL, NULL),
(40, 15, 2, 10, 16, NULL, NULL),
(41, 0, 2, 34, 16, NULL, NULL),
(42, 19, 2, 14, 20, NULL, NULL),
(43, 1, 2, 10, 20, NULL, NULL),
(44, 35, 2, 41, 20, NULL, NULL),
(45, 21, 2, 43, 20, NULL, NULL),
(46, 10, 2, 33, 20, NULL, NULL),
(47, 3, 2, 14, 23, NULL, NULL),
(48, 4, 2, 41, 23, NULL, NULL),
(49, 4, 2, 34, 23, NULL, NULL),
(50, 7, 2, 26, 23, NULL, NULL),
(51, 20, 2, 35, 23, NULL, NULL),
(52, 1, 2, 14, 24, NULL, NULL),
(53, 1, 2, 10, 24, NULL, NULL),
(54, 1, 2, 26, 24, NULL, NULL),
(55, 20, 2, 7, 26, NULL, NULL),
(56, 33, 2, 42, 26, NULL, NULL),
(57, 17, 2, 43, 30, NULL, NULL),
(58, 12, 2, 7, 30, NULL, NULL),
(59, 10, 2, 42, 30, NULL, NULL),
(60, 10, 2, 33, 30, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `disponible`
--

INSERT INTO `disponible` (`id`, `DateValable`, `heure`, `id_Sprint`, `id_Employe`) VALUES
(1, '2016-07-25', 4, 1, 14),
(2, '2016-07-25', 4, 1, 10),
(3, '2016-07-25', 4, 1, 41),
(4, '2016-07-25', 4, 1, 30),
(5, '2016-07-25', 4, 1, 34),
(6, '2016-07-25', 4, 1, 39),
(7, '2016-07-25', 4, 1, 43),
(8, '2016-07-25', 4, 1, 33),
(9, '2016-07-26', 7, 1, 10),
(10, '2016-07-26', 2, 1, 15),
(11, '2016-07-26', 7, 1, 39),
(12, '2016-07-26', 7, 1, 43),
(13, '2016-07-26', 7, 1, 33),
(14, '2016-07-27', 7, 1, 14),
(15, '2016-07-27', 4, 1, 10),
(16, '2016-07-27', 4, 1, 41),
(17, '2016-07-27', 4, 1, 15),
(18, '2016-07-27', 4, 1, 34),
(19, '2016-07-27', 7, 1, 39),
(20, '2016-07-27', 6, 1, 43),
(21, '2016-07-27', 7, 1, 33),
(22, '2016-07-27', 7, 1, 35),
(23, '2016-07-28', 4, 1, 14),
(24, '2016-07-28', 7, 1, 41),
(25, '2016-07-28', 6, 1, 30),
(26, '2016-07-28', 7, 1, 15),
(27, '2016-07-28', 7, 1, 34),
(28, '2016-07-28', 7, 1, 39),
(29, '2016-07-28', 4, 1, 33),
(30, '2016-07-28', 4, 1, 35),
(31, '2016-07-29', 7, 1, 14),
(32, '2016-07-29', 6, 1, 10),
(33, '2016-07-29', 6, 1, 41),
(34, '2016-07-29', 5, 1, 30),
(35, '2016-07-29', 5, 1, 15),
(36, '2016-07-29', 4, 1, 34),
(37, '2016-07-29', 7, 1, 39),
(38, '2016-07-29', 7, 1, 33),
(39, '2016-07-29', 7, 1, 35),
(40, '2016-08-01', 5, 1, 14),
(41, '2016-08-01', 5, 1, 10),
(42, '2016-08-01', 5, 1, 41),
(43, '2016-08-01', 5, 1, 30),
(44, '2016-08-01', 5, 1, 15),
(45, '2016-08-01', 5, 1, 34),
(46, '2016-08-01', 6, 1, 39),
(47, '2016-08-01', 5, 1, 43),
(48, '2016-08-01', 6, 1, 35),
(49, '2016-08-02', 7, 1, 14),
(50, '2016-08-02', 7, 1, 10),
(51, '2016-08-02', 7, 1, 41),
(52, '2016-08-02', 7, 1, 30),
(53, '2016-08-02', 7, 1, 15),
(54, '2016-08-02', 7, 1, 34),
(55, '2016-08-02', 7, 1, 39),
(56, '2016-08-02', 7, 1, 43),
(57, '2016-08-02', 7, 1, 35),
(58, '2016-08-03', 7, 1, 14),
(59, '2016-08-03', 7, 1, 10),
(60, '2016-08-03', 7, 1, 41),
(61, '2016-08-03', 7, 1, 34),
(62, '2016-08-03', 7, 1, 39),
(63, '2016-08-03', 6, 1, 43),
(64, '2016-08-04', 7, 1, 14),
(65, '2016-08-04', 7, 1, 10),
(66, '2016-08-04', 7, 1, 41),
(67, '2016-08-04', 7, 1, 15),
(68, '2016-08-04', 7, 1, 34),
(69, '2016-08-04', 7, 1, 39),
(70, '2016-08-04', 7, 1, 43),
(71, '2016-08-04', 7, 1, 35),
(72, '2016-08-05', 2, 1, 14),
(73, '2016-08-05', 2, 1, 10),
(74, '2016-08-05', 2, 1, 41),
(75, '2016-08-05', 2, 1, 30),
(76, '2016-08-05', 2, 1, 15),
(77, '2016-08-05', 2, 1, 34),
(78, '2016-08-05', 2, 1, 39),
(79, '2016-08-05', 2, 1, 43),
(80, '2016-08-05', 2, 1, 35),
(81, '2016-08-23', 5, 2, 14),
(82, '2016-08-23', 5, 2, 10),
(83, '2016-08-23', 7, 2, 41),
(84, '2016-08-23', 5, 2, 34),
(85, '2016-08-23', 7, 2, 39),
(86, '2016-08-23', 5, 2, 26),
(87, '2016-08-23', 7, 2, 7),
(88, '2016-08-23', 7, 2, 20),
(89, '2016-08-23', 5, 2, 33),
(90, '2016-08-24', 7, 2, 14),
(91, '2016-08-24', 7, 2, 10),
(92, '2016-08-24', 7, 2, 41),
(93, '2016-08-24', 3, 2, 30),
(94, '2016-08-24', 7, 2, 39),
(95, '2016-08-24', 7, 2, 26),
(96, '2016-08-24', 3, 2, 43),
(97, '2016-08-24', 7, 2, 7),
(98, '2016-08-24', 7, 2, 20),
(99, '2016-08-24', 7, 2, 42),
(100, '2016-08-24', 7, 2, 33),
(101, '2016-08-25', 6, 2, 14),
(102, '2016-08-25', 6, 2, 10),
(103, '2016-08-25', 6, 2, 41),
(104, '2016-08-25', 4, 2, 34),
(105, '2016-08-25', 7, 2, 39),
(106, '2016-08-25', 7, 2, 43),
(107, '2016-08-25', 7, 2, 7),
(108, '2016-08-25', 6, 2, 20),
(109, '2016-08-25', 7, 2, 42),
(110, '2016-08-25', 7, 2, 33),
(111, '2016-08-26', 7, 2, 14),
(112, '2016-08-26', 7, 2, 10),
(113, '2016-08-26', 7, 2, 39),
(114, '2016-08-26', 5, 2, 26),
(115, '2016-08-26', 7, 2, 43),
(116, '2016-08-26', 7, 2, 7),
(117, '2016-08-26', 7, 2, 20),
(118, '2016-08-26', 7, 2, 42),
(119, '2016-08-26', 7, 2, 33),
(120, '2016-08-26', 5, 2, 35),
(121, '2016-08-29', 5, 2, 10),
(122, '2016-08-29', 5, 2, 41),
(123, '2016-08-29', 5, 2, 34),
(124, '2016-08-29', 6, 2, 39),
(125, '2016-08-29', 6, 2, 26),
(126, '2016-08-29', 5, 2, 43),
(127, '2016-08-29', 5, 2, 7),
(128, '2016-08-29', 6, 2, 20),
(129, '2016-08-29', 5, 2, 42),
(130, '2016-08-29', 6, 2, 33),
(131, '2016-08-29', 6, 2, 35),
(132, '2016-08-30', 5, 2, 10),
(133, '2016-08-30', 5, 2, 41),
(134, '2016-08-30', 7, 2, 30),
(135, '2016-08-30', 5, 2, 34),
(136, '2016-08-30', 7, 2, 39),
(137, '2016-08-30', 7, 2, 26),
(138, '2016-08-30', 3, 2, 43),
(139, '2016-08-30', 7, 2, 20),
(140, '2016-08-30', 3, 2, 42),
(141, '2016-08-30', 3, 2, 33),
(142, '2016-08-31', 7, 2, 10),
(143, '2016-08-31', 7, 2, 41),
(144, '2016-08-31', 7, 2, 30),
(145, '2016-08-31', 7, 2, 39),
(146, '2016-08-31', 3, 2, 26),
(147, '2016-08-31', 4, 2, 43),
(148, '2016-08-31', 7, 2, 20),
(149, '2016-08-31', 7, 2, 42),
(150, '2016-08-31', 5, 2, 33),
(151, '2016-09-01', 5, 2, 14),
(152, '2016-09-01', 7, 2, 10),
(153, '2016-09-01', 7, 2, 41),
(154, '2016-09-01', 7, 2, 30),
(155, '2016-09-01', 5, 2, 34),
(156, '2016-09-01', 7, 2, 39),
(157, '2016-09-01', 7, 2, 26),
(158, '2016-09-01', 7, 2, 43),
(159, '2016-09-01', 7, 2, 20),
(160, '2016-09-01', 7, 2, 42),
(161, '2016-09-01', 7, 2, 33),
(162, '2016-09-01', 7, 2, 35),
(163, '2016-09-02', 2, 2, 14),
(164, '2016-09-02', 2, 2, 10),
(165, '2016-09-02', 2, 2, 41),
(166, '2016-09-02', 3, 2, 30),
(167, '2016-09-02', 2, 2, 34),
(168, '2016-09-02', 2, 2, 39),
(169, '2016-09-02', 2, 2, 26),
(170, '2016-09-02', 2, 2, 43),
(171, '2016-09-02', 2, 2, 7),
(172, '2016-09-02', 2, 2, 20),
(173, '2016-09-02', 2, 2, 42),
(174, '2016-09-02', 2, 2, 33),
(175, '2016-09-02', 2, 2, 35);

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
(1, 'AD', 'Abel', 'Delannoy', '#e0d0f1', 0, NULL, NULL),
(2, 'AS', 'Almudena', 'SanRoman', '#ae4ff3', 0, NULL, NULL),
(3, 'AS', 'Amandine', 'Sahl', '#316a1c', 0, NULL, NULL),
(4, 'AM', 'Antoine', 'Micelli', '#2dfb0e', 0, NULL, NULL),
(5, 'CR', 'Cecile', 'Robin', '#10367c', 0, NULL, NULL),
(6, 'CS', 'Cedric', 'Seguin', '#502377', 0, NULL, NULL),
(7, 'CV', 'Celine', 'Vidal', '#85263d', 1, 6, NULL),
(8, 'CK', 'Christelle', 'Khozian', '#2b1e6b', 1, 4, NULL),
(9, 'CG', 'Cyril', 'Gautreau', '#05413f', 0, NULL, NULL),
(10, 'DL', 'David', 'Lassagne', '#8999b2', 1, 3, NULL),
(11, 'EP', 'Eric', 'Pringels', '#2ee96e', 0, NULL, NULL),
(12, 'FB', 'Fabien', 'Buisson', '#daf1ba', 0, NULL, NULL),
(13, 'FF', 'Florian', 'Fauchier', '#270eaf', 0, NULL, NULL),
(14, 'FB', 'Frederic', 'Berton', '#b1a49b', 1, 6, NULL),
(15, 'GT', 'Gerald', 'Tibi', '#1e97da', 0, NULL, NULL),
(16, 'GF', 'Ghislain', 'Fortin', '#a68c67', 0, NULL, NULL),
(17, 'GB', 'Gilles', 'Bassiere', '#627fc5', 0, NULL, NULL),
(18, 'JT', 'Jerome', 'TenShong', '#31b935', 0, NULL, NULL),
(19, 'JL', 'Jean Francois', 'Leger', '#c6e62c', 0, NULL, NULL),
(20, 'JA', 'Jean-Vitus', 'Albertini', '#40e210', 1, 3, NULL),
(21, 'JD', 'Jeanne', 'Dauvergne', '#b98392', 0, NULL, NULL),
(22, 'JL', 'Jeremy', 'Leriche', '#ea0166', 1, 3, NULL),
(23, 'JC', 'Julie', 'Chabalier', '#6741f7', 0, NULL, NULL),
(24, 'JB', 'Julien', 'Bono', '#a2435c', 0, NULL, NULL),
(25, 'KS', 'Kamel', 'Sabri', '#f2d9e0', 0, NULL, NULL),
(26, 'KT', 'Khaled', 'Talbi', '#ff0f02', 1, 6, NULL),
(27, 'LC', 'Lea', 'Charbonnier', '#3c1d47', 0, NULL, NULL),
(28, 'LP', 'Laura', 'Perez', '#c698ea', 0, NULL, NULL),
(29, 'MM', 'Marion', 'Marcoux', '#72fda7', 0, NULL, NULL),
(30, 'MJ', 'Matheo', 'Jaouen', '#2504d2', 0, NULL, NULL),
(31, 'MT', 'Mathieu', 'Thomazo', '#ec25b3', 0, NULL, NULL),
(32, 'OR', 'Olivier', 'Rovellotti', '#a16a0b', 1, 6, NULL),
(33, 'PD', 'Pierre', 'Delaunay', '#6cdf49', 0, 2, NULL),
(34, 'RF', 'Romain', 'Fabbro', '#3dbaed', 0, NULL, NULL),
(35, 'SM', 'Sabine', 'Meneut', '#d45df9', 0, NULL, NULL),
(36, 'SB', 'Sandra', 'Bonnot', '#340b29', 0, NULL, NULL),
(37, 'SR', 'Stephanie', 'Ritz', '#b033b7', 0, NULL, NULL),
(38, 'TA', 'Tamou', 'Amadha', '#a10e64', 0, NULL, NULL),
(39, 'TR', 'Thibault', 'Rhudel', '#20ba44', 0, NULL, NULL),
(40, 'TP', 'Thomas', 'Peel', '#10353b', 0, NULL, NULL),
(41, 'TL', 'Tom', 'Lopez', '#eb34cb', 1, 3, NULL),
(42, 'VB', 'Vincent', 'Bourgeois', '#a0a0f6', 1, 3, NULL),
(43, 'VG', 'Vivien', 'Grivaud', '#20604f', 0, NULL, NULL),
(44, 'YT', 'Yacine', 'Thomazo', '#bbea15', 0, NULL, NULL),
(45, 'GG', 'Groupe', 'Groupe', '#833e1a', 1, 4, NULL),
(46, 'AR', 'Angelique', 'Ries', '#7291fc', 1, 2, NULL),
(47, 'NH', 'Nabil', 'Hamadou', '#b4644f', 1, 2, NULL),
(48, 'RK', 'Romain', 'Knezevitch', '#e6da01', 0, NULL, NULL),
(49, 'CL', 'Christophe', 'Lavagna', '#bf289e', 1, 3, NULL),
(50, 'HA', 'Herve', 'Aymes', '#6e60e1', 1, 3, NULL),
(51, 'SP', 'Sebastien', 'Paris', '#5aa2d8', 1, 6, NULL),
(52, 'NF', 'Naomi', 'Fischer', '#cfc61c', 1, 2, NULL),
(53, 'JD', 'Julien', 'Dejasmin', '#031f43', 1, 3, NULL),
(54, 'MV', 'El-Makki', 'Voundy', '#4c2100', 1, 3, NULL),
(55, 'RG', 'Remi', 'Guijarro Espinosa', '#1f899d', 1, 3, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `heuresdescendues`
--

INSERT INTO `heuresdescendues` (`id`, `heure`, `DateDescendu`, `id_Sprint`, `id_Employe`, `id_Projet`, `id_Attribution`) VALUES
(196, 18, '2016-07-25', 1, 14, 20, 17),
(197, 21, '2016-07-25', 1, 10, 16, 15),
(198, 19, '2016-07-26', 1, 33, 1, 2),
(199, 11, '2016-07-26', 1, 15, 10, 12),
(200, 4, '2016-07-26', 1, 33, 2, 3),
(201, 1, '2016-07-27', 1, 33, 30, 24),
(202, 31, '2016-07-27', 1, 43, 1, 1),
(203, 61, '2016-07-27', 1, 39, 3, 4),
(204, 38, '2016-07-29', 1, 35, 3, 6),
(205, 29, '2016-07-30', 1, 30, 10, 11),
(206, 49, '2016-07-30', 1, 41, 20, 19),
(207, 13, '2016-08-02', 1, 15, 7, 9),
(208, 13, '2016-08-02', 1, 43, 30, 23),
(209, 25, '2016-08-03', 1, 14, 7, 7),
(210, 20, '2016-08-03', 1, 10, 7, 8),
(211, 2, '2016-08-05', 1, 35, 10, 14),
(212, 2, '2016-08-05', 1, 10, 24, 21),
(213, 5, '2016-08-05', 1, 15, 24, 22),
(214, 33, '2016-08-22', 2, 42, 26, 56),
(215, 1, '2016-08-22', 2, 14, 24, 52),
(216, 15, '2016-08-22', 2, 33, 3, 27),
(217, 7, '2016-08-23', 2, 33, 7, 32),
(218, 3, '2016-08-23', 2, 14, 23, 47),
(219, 4, '2016-08-23', 2, 41, 23, 48),
(220, 35, '2016-08-24', 2, 41, 20, 44),
(221, 0, '2016-08-24', 2, 34, 16, 41),
(222, 10, '2016-08-24', 2, 33, 20, 46),
(223, 7, '2016-08-25', 2, 34, 10, 36),
(224, 27, '2016-08-25', 2, 30, 10, 35),
(226, 4, '2016-08-26', 2, 34, 23, 49),
(227, 4, '2016-08-26', 2, 14, 16, 39),
(228, 34, '2016-08-26', 2, 26, 10, 37),
(229, 20, '2016-08-27', 2, 35, 23, 51),
(230, 2, '2016-08-27', 2, 42, 9, 34),
(231, 21, '2016-08-28', 2, 43, 20, 45),
(232, 1, '2016-08-28', 2, 26, 24, 54),
(233, 1, '2016-08-29', 2, 10, 24, 53),
(234, 10, '2016-08-29', 2, 42, 30, 59),
(235, 20, '2016-08-30', 2, 7, 26, 55),
(236, 5, '2016-08-30', 2, 14, 7, 28),
(237, 56, '2016-08-30', 2, 20, 10, 38),
(238, 15, '2016-09-01', 2, 10, 16, 40),
(239, 7, '2016-09-01', 2, 26, 23, 50),
(240, 10, '2016-09-02', 2, 33, 30, 60),
(241, 12, '2016-09-02', 2, 7, 30, 58),
(242, 19, '2016-09-02', 2, 14, 20, 42);

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `interference`
--

INSERT INTO `interference` (`id`, `heure`, `id_TypeInterference`, `id_Sprint`, `id_Projet`, `id_Employe`) VALUES
(1, 8, 1, 1, 7, 15),
(2, 5, 1, 1, 10, 34),
(3, 25, 1, 1, 20, 41),
(4, 3, 1, 1, 23, 15),
(5, 1, 1, 2, 7, 10),
(6, 19, 1, 2, 10, 30),
(7, 5, 1, 2, 10, 34),
(8, 8, 1, 2, 16, 10),
(9, 1, 1, 2, 16, 34),
(10, 1, 1, 2, 20, 14),
(11, 14, 1, 2, 20, 41);

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `objectif`
--

INSERT INTO `objectif` (`id`, `id_Sprint`, `id_Projet`, `objectif`, `id_StatutObjectif`) VALUES
(10, 2, 51, 'CrÃ©er une vue de template', 5),
(11, 2, 61, 'Compter jusqu\'Ã  10', 4),
(12, 2, 61, 'Faire un origami en forme de chat', 5),
(13, 2, 37, 'Remplacer Elon Musk', 3),
(14, 2, 37, 'DÃ©placer des donnÃ©es', 1),
(15, 2, 74, 'TÃ©lÃ©charger l\'intÃ©grale d\'amour gloire et beautÃ©', 2),
(16, 2, 74, 'Dessiner un chat', 2),
(17, 2, 85, 'Trouver le nord sur une carte', 2),
(18, 2, 85, 'Hacker la nasa', 1),
(19, 1, 86, 'htrhtrh', 4),
(20, 1, 86, 'trhtrh', 2),
(21, 1, 86, 'rthrth', 2),
(22, 1, 86, 'trhtrh', 2),
(23, 1, 86, 'rth', 3),
(24, 1, 86, 'rthtrh', 5),
(25, 1, 30, 'rthr', 1);

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
  `Logo` varchar(150) NOT NULL,
  `id_TypeProjet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Projet_id_TypeProjet` (`id_TypeProjet`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`id`, `nom`, `couleur`, `abreviation`, `Logo`, `id_TypeProjet`) VALUES
(1, 'AO', NULL, NULL, 'Inconnue.png', 5),
(2, 'PIM-Atlas', NULL, NULL, 'Inconnue.png', 5),
(3, 'ecoBalade', NULL, NULL, 'Ecobalade.png', 5),
(4, 'eCollection', NULL, NULL, 'Ecollection.png', 5),
(5, 'iFeedBird', NULL, NULL, 'Inconnue.png', 5),
(6, 'Multiprojets', NULL, NULL, 'Inconnue.png', 5),
(7, 'Data Centralization', NULL, NULL, 'Inconnue.png', 5),
(8, 'Tuyaux (Bonna)', NULL, NULL, 'Inconnue.png', 5),
(9, 'Noe', NULL, NULL, 'Inconnue.png', 5),
(10, 'ecoReleve Data', NULL, NULL, 'Inconnue.png', 5),
(11, 'eReleve', NULL, NULL, 'Inconnue.png', 5),
(12, 'Kitizen', NULL, NULL, 'Kitizen.png', 5),
(13, 'INPN', NULL, NULL, 'INPN.png', 5),
(14, 'Collier Loups', NULL, NULL, 'Inconnue.png', 5),
(15, 'BioLit', NULL, NULL, 'Inconnue.png', 5),
(16, 'FormBuilder', NULL, NULL, 'Formbuilder.png', 5),
(17, 'Sauvages de ma rue PACA', NULL, NULL, 'Inconnue.png', 5),
(18, 'Mycoflore', NULL, NULL, 'Inconnue.png', 5),
(19, 'Site Web NS', NULL, NULL, 'Inconnue.png', 5),
(20, 'TRACK', NULL, NULL, 'Inconnue.png', 5),
(21, 'Photomapping', NULL, NULL, 'Inconnue.png', 5),
(22, 'ButterflyId', NULL, NULL, 'Inconnue.png', 5),
(23, 'NS Interne', NULL, NULL, 'NS_interne.png', 5),
(24, 'Renecore Apps', NULL, NULL, 'Renecore.png', 5),
(25, 'Mon jardin', NULL, NULL, 'Mon_jardin_en_villle.png', 5),
(26, 'Green citizen', NULL, NULL, 'Inconnue.png', 5),
(27, 'Alerting App', NULL, NULL, 'Inconnue.png', 5),
(28, 'Futback', NULL, NULL, 'Futbak.png', 5),
(29, 'Sweet', NULL, NULL, 'Inconnue.png', 5),
(30, 'Aveyron nature', NULL, NULL, 'Inconnue.png', 5),
(31, 'Tout a pied', NULL, NULL, 'Inconnue.png', 5),
(32, 'ecoReleve Explorer', NULL, NULL, 'Inconnue.png', 5),
(33, 'Footback', NULL, NULL, 'Inconnue.png', 5),
(34, 'ecoReleve Core', NULL, NULL, 'Inconnue.png', 5),
(35, 'M-EOL', NULL, NULL, 'Inconnue.png', 5),
(36, 'Nature en Ville', NULL, NULL, 'Inconnue.png', 5),
(37, 'CAU13', NULL, NULL, 'Inconnue.png', 5),
(38, 'ecoReleve Glossaire', NULL, NULL, 'Inconnue.png', 5),
(39, 'ecoOnto', NULL, NULL, 'Inconnue.png', 5),
(40, 'geodiva', NULL, NULL, 'Inconnue.png', 5),
(41, 'GR2013 2.0', NULL, NULL, 'Inconnue.png', 5),
(42, 'Pocket', NULL, NULL, 'Inconnue.png', 5),
(43, 'Site Web Labs', NULL, NULL, 'Inconnue.png', 5),
(44, 'Armadillo', NULL, NULL, 'Inconnue.png', 5),
(45, 'PIM', NULL, NULL, 'Inconnue.png', 5),
(46, 'SIB', NULL, NULL, 'Inconnue.png', 5),
(47, 'ecoOnto-med', NULL, NULL, 'Inconnue.png', 5),
(48, 'ecoReleve Mobile', NULL, NULL, 'Inconnue.png', 5),
(49, 'Mica environnement', NULL, NULL, 'Inconnue.png', 5),
(50, 'Valo - LIF', NULL, NULL, 'Inconnue.png', 5),
(51, 'AAP FP7 environnement', NULL, NULL, 'Inconnue.png', 5),
(52, 'Carnet de plongee', NULL, NULL, 'Inconnue.png', 5),
(53, 'Curieux2Sciences', NULL, NULL, 'Inconnue.png', 5),
(54, 'EcoBalade Bidules', NULL, NULL, 'Inconnue.png', 5),
(55, 'ecoReleve', NULL, NULL, 'Ecoreleve.png', 5),
(56, 'ecoReleve Core/GIS', NULL, NULL, 'Inconnue.png', 5),
(57, 'eReleve-Release', NULL, NULL, 'Inconnue.png', 5),
(58, 'Faro', NULL, NULL, 'Inconnue.png', 5),
(59, 'MICA', NULL, NULL, 'Inconnue.png', 5),
(60, 'Open Data', NULL, NULL, 'Inconnue.png', 5),
(61, 'ANDD', NULL, NULL, 'Inconnue.png', 5),
(62, 'Sentiers sous-marins', NULL, NULL, 'Inconnue.png', 5),
(63, 'TeamBuildingEcoBalade_Bioblitz', NULL, NULL, 'Inconnue.png', 5),
(64, 'Marche des collines', NULL, NULL, 'Inconnue.png', 5),
(65, 'OCK', NULL, NULL, 'Inconnue.png', 5),
(66, 'Scrum', NULL, NULL, 'Scrum.png', 5),
(67, 'Position', NULL, NULL, 'Position.png', 5),
(68, 'Biotope', NULL, NULL, 'Inconnue.png', 5),
(69, 'Airele', NULL, NULL, 'Inconnue.png', 5),
(70, 'SECAFI', NULL, NULL, 'Inconnue.png', 5),
(71, 'Support', NULL, NULL, 'Inconnue.png', 5),
(72, 'Inconnu', NULL, NULL, 'Inconnue.png', 5),
(73, 'FEMS', NULL, NULL, 'Inconnue.png', 5),
(74, 'Creamontblanc', NULL, NULL, 'Inconnue.png', 5),
(75, 'Ouigreens', NULL, NULL, 'Inconnue.png', 5),
(76, 'Cistude', NULL, NULL, 'Inconnue.png', 5),
(77, 'Espaces verts', NULL, NULL, 'Inconnue.png', 5),
(78, 'Reneco devis', NULL, NULL, 'Inconnue.png', 5),
(79, 'Panda', NULL, NULL, 'Inconnue.png', 5),
(80, 'ONB', NULL, NULL, 'Inconnue.png', 5),
(81, 'PeekMotion', NULL, NULL, 'Inconnue.png', 5),
(82, 'Balance RFID', NULL, NULL, 'Inconnue.png', 5),
(83, 'Vanoise', NULL, NULL, 'Vanoise.png', 5),
(84, 'Geonature interopérabilité', NULL, NULL, 'Inconnue.png', 5),
(85, 'Capel', NULL, NULL, 'Capel.png', 5),
(86, 'Alfred', NULL, NULL, 'Inconnue.png', 5),
(87, 'CITES', NULL, NULL, 'Inconnue.png', 5),
(88, 'SINP-Espaces verts', NULL, NULL, 'Inconnue.png', 5);

-- --------------------------------------------------------

--
-- Structure de la table `retrospective`
--

DROP TABLE IF EXISTS `retrospective`;
CREATE TABLE IF NOT EXISTS `retrospective` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Label` varchar(250) NOT NULL,
  `DateCreation` date NOT NULL,
  `Etat` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `retrospective`
--

INSERT INTO `retrospective` (`id`, `Label`, `DateCreation`, `Etat`) VALUES
(1, 'zefz', '2018-07-11', 1),
(2, 'Avoir une imprimante fonctionelle', '2018-07-13', 0),
(3, 'Arroser les plantes', '2018-07-13', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sprint`
--

INSERT INTO `sprint` (`id`, `numero`, `dateDebut`, `dateFin`) VALUES
(1, 96, '2016-07-25', '2016-08-05'),
(2, 97, '2016-08-22', '2016-09-02');

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
  ADD CONSTRAINT `FK_Attribution_id_Caracteristiques` FOREIGN KEY (`id_Caracteristiques`) REFERENCES `caracteristiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Attribution_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Attribution_id_Projet` FOREIGN KEY (`id_Projet`) REFERENCES `projet` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Attribution_id_Sprint` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Attribution_id_TypeTache` FOREIGN KEY (`id_TypeTache`) REFERENCES `typetache` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `demo`
--
ALTER TABLE `demo`
  ADD CONSTRAINT `FK_Demo_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Demo_id_StatutDemo` FOREIGN KEY (`id_StatutDemo`) REFERENCES `statutdemo` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `disponible`
--
ALTER TABLE `disponible`
  ADD CONSTRAINT `FK_Disponible_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Disponible_id_Sprint` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `FK_Employe_id_Poste` FOREIGN KEY (`id_Poste`) REFERENCES `poste` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Employe_id_TypeEmploye` FOREIGN KEY (`id_TypeEmploye`) REFERENCES `typeemploye` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employe_projet`
--
ALTER TABLE `employe_projet`
  ADD CONSTRAINT `FK_Employe_Projet_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Employe_Projet_id_Projet` FOREIGN KEY (`id_Projet`) REFERENCES `projet` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `heuresdescendues`
--
ALTER TABLE `heuresdescendues`
  ADD CONSTRAINT `FK_HeuresDescendues_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_HeuresDescendues_id_Projet` FOREIGN KEY (`id_Projet`) REFERENCES `projet` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_HeuresDescendues_id_Sprint` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `heuresdescendues_ibfk_1` FOREIGN KEY (`id_Attribution`) REFERENCES `attribution` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `interference`
--
ALTER TABLE `interference`
  ADD CONSTRAINT `FK_Interference_id_Employe` FOREIGN KEY (`id_Employe`) REFERENCES `employe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Interference_id_Projet` FOREIGN KEY (`id_Projet`) REFERENCES `projet` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Interference_id_Sprint` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Interference_id_TypeInterference` FOREIGN KEY (`id_TypeInterference`) REFERENCES `typeinterference` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `objectif`
--
ALTER TABLE `objectif`
  ADD CONSTRAINT `FK_Objectif_id_StatutObjectif` FOREIGN KEY (`id_StatutObjectif`) REFERENCES `statutobjectif` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `objectif_ibfk_1` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `objectif_ibfk_2` FOREIGN KEY (`id_Projet`) REFERENCES `projet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `FK_Projet_id_TypeProjet` FOREIGN KEY (`id_TypeProjet`) REFERENCES `typeprojet` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
