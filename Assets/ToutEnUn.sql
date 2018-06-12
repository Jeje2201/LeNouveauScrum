
CREATE DATABASE scrum;
USE scrum;


-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 13 Février 2017 à 10:10
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

CREATE TABLE `attribution` (
  `id` int(11) NOT NULL,
  `heure` smallint(6) DEFAULT NULL,
  `id_Sprint` int(11) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL,
  `id_Projet` int(11) DEFAULT NULL,
  `id_Caracteristiques` int(11) DEFAULT NULL,
  `id_TypeTache` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `attribution`
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
(60, 10, 2, 33, 30, NULL, NULL),
(61, 21, 3, 43, 1, NULL, NULL),
(62, 35, 3, 11, 1, NULL, NULL),
(63, 21, 3, 33, 1, NULL, NULL),
(64, 61, 3, 39, 3, NULL, NULL),
(65, 3, 3, 33, 3, NULL, NULL),
(66, 7, 3, 35, 3, NULL, NULL),
(67, 22, 3, 14, 7, NULL, NULL),
(68, 52, 3, 10, 7, NULL, NULL),
(69, 14, 3, 41, 7, NULL, NULL),
(70, 2, 3, 30, 7, NULL, NULL),
(71, 7, 3, 34, 7, NULL, NULL),
(72, 4, 3, 26, 7, NULL, NULL),
(73, 9, 3, 7, 9, NULL, NULL),
(74, 2, 3, 14, 10, NULL, NULL),
(75, 28, 3, 30, 10, NULL, NULL),
(76, 36, 3, 34, 10, NULL, NULL),
(77, 34, 3, 26, 10, NULL, NULL),
(78, 61, 3, 20, 10, NULL, NULL),
(79, 1, 3, 11, 16, NULL, NULL),
(80, 15, 3, 14, 20, NULL, NULL),
(81, 6, 3, 10, 20, NULL, NULL),
(82, 43, 3, 41, 20, NULL, NULL),
(83, 4, 3, 43, 20, NULL, NULL),
(84, 9, 3, 33, 20, NULL, NULL),
(85, 2, 3, 14, 23, NULL, NULL),
(86, 5, 3, 11, 23, NULL, NULL),
(87, 4, 3, 7, 23, NULL, NULL),
(88, 7, 3, 33, 23, NULL, NULL),
(89, 27, 3, 35, 23, NULL, NULL),
(90, 3, 3, 14, 24, NULL, NULL),
(91, 2, 3, 10, 24, NULL, NULL),
(92, 3, 3, 11, 28, NULL, NULL),
(93, 20, 3, 43, 30, NULL, NULL),
(94, 35, 3, 7, 30, NULL, NULL),
(95, 28, 3, 42, 30, NULL, NULL),
(96, 14, 3, 33, 30, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `caracteristiques`
--

CREATE TABLE `caracteristiques` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `caracteristiques`
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

CREATE TABLE `demo` (
  `id` int(11) NOT NULL,
  `titre` varchar(25) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL,
  `id_StatutDemo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `disponible`
--

CREATE TABLE `disponible` (
  `id` int(11) NOT NULL,
  `DateValable` date DEFAULT NULL,
  `heure` tinyint(4) DEFAULT NULL,
  `id_Sprint` int(11) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `disponible`
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
(175, '2016-09-02', 2, 2, 35),
(176, '2016-09-05', 3, 3, 14),
(177, '2016-09-05', 4, 3, 10),
(178, '2016-09-05', 4, 3, 41),
(179, '2016-09-05', 4, 3, 30),
(180, '2016-09-05', 3, 3, 34),
(181, '2016-09-05', 4, 3, 39),
(182, '2016-09-05', 1, 3, 43),
(183, '2016-09-05', 2, 3, 11),
(184, '2016-09-05', 2, 3, 7),
(185, '2016-09-05', 4, 3, 20),
(186, '2016-09-05', 2, 3, 42),
(187, '2016-09-05', 2, 3, 33),
(188, '2016-09-05', 2, 3, 35),
(189, '2016-09-06', 7, 3, 10),
(190, '2016-09-06', 7, 3, 41),
(191, '2016-09-06', 7, 3, 30),
(192, '2016-09-06', 7, 3, 34),
(193, '2016-09-06', 7, 3, 39),
(194, '2016-09-06', 7, 3, 26),
(195, '2016-09-06', 7, 3, 43),
(196, '2016-09-06', 5, 3, 11),
(197, '2016-09-06', 5, 3, 7),
(198, '2016-09-06', 7, 3, 20),
(199, '2016-09-06', 5, 3, 42),
(200, '2016-09-06', 7, 3, 33),
(201, '2016-09-06', 7, 3, 35),
(202, '2016-09-07', 5, 3, 14),
(203, '2016-09-07', 7, 3, 10),
(204, '2016-09-07', 7, 3, 41),
(205, '2016-09-07', 7, 3, 30),
(206, '2016-09-07', 7, 3, 39),
(207, '2016-09-07', 7, 3, 26),
(208, '2016-09-07', 5, 3, 43),
(209, '2016-09-07', 1, 3, 11),
(210, '2016-09-07', 3, 3, 7),
(211, '2016-09-07', 7, 3, 20),
(212, '2016-09-07', 7, 3, 42),
(213, '2016-09-07', 5, 3, 33),
(214, '2016-09-08', 6, 3, 14),
(215, '2016-09-08', 7, 3, 10),
(216, '2016-09-08', 6, 3, 41),
(217, '2016-09-08', 7, 3, 39),
(218, '2016-09-08', 3, 3, 26),
(219, '2016-09-08', 7, 3, 11),
(220, '2016-09-08', 7, 3, 7),
(221, '2016-09-08', 7, 3, 20),
(222, '2016-09-08', 7, 3, 42),
(223, '2016-09-08', 7, 3, 33),
(224, '2016-09-08', 7, 3, 35),
(225, '2016-09-09', 3, 3, 14),
(226, '2016-09-09', 7, 3, 10),
(227, '2016-09-09', 7, 3, 41),
(228, '2016-09-09', 7, 3, 34),
(229, '2016-09-09', 7, 3, 39),
(230, '2016-09-09', 5, 3, 26),
(231, '2016-09-09', 5, 3, 43),
(232, '2016-09-09', 3, 3, 11),
(233, '2016-09-09', 7, 3, 7),
(234, '2016-09-09', 7, 3, 20),
(235, '2016-09-09', 7, 3, 42),
(236, '2016-09-09', 7, 3, 33),
(237, '2016-09-09', 6, 3, 35),
(238, '2016-09-12', 5, 3, 14),
(239, '2016-09-12', 5, 3, 10),
(240, '2016-09-12', 5, 3, 41),
(241, '2016-09-12', 5, 3, 34),
(242, '2016-09-12', 6, 3, 39),
(243, '2016-09-12', 6, 3, 26),
(244, '2016-09-12', 5, 3, 43),
(245, '2016-09-12', 5, 3, 11),
(246, '2016-09-12', 5, 3, 7),
(247, '2016-09-12', 6, 3, 20),
(248, '2016-09-12', 5, 3, 42),
(249, '2016-09-12', 6, 3, 33),
(250, '2016-09-12', 6, 3, 35),
(251, '2016-09-13', 7, 3, 14),
(252, '2016-09-13', 7, 3, 10),
(253, '2016-09-13', 7, 3, 41),
(254, '2016-09-13', 5, 3, 34),
(255, '2016-09-13', 7, 3, 39),
(256, '2016-09-13', 7, 3, 43),
(257, '2016-09-13', 6, 3, 11),
(258, '2016-09-13', 7, 3, 7),
(259, '2016-09-13', 7, 3, 20),
(260, '2016-09-13', 7, 3, 42),
(261, '2016-09-13', 7, 3, 33),
(262, '2016-09-13', 6, 3, 35),
(263, '2016-09-14', 7, 3, 14),
(264, '2016-09-14', 7, 3, 10),
(265, '2016-09-14', 5, 3, 41),
(266, '2016-09-14', 2, 3, 30),
(267, '2016-09-14', 7, 3, 34),
(268, '2016-09-14', 7, 3, 39),
(269, '2016-09-14', 3, 3, 26),
(270, '2016-09-14', 6, 3, 43),
(271, '2016-09-14', 6, 3, 11),
(272, '2016-09-14', 3, 3, 7),
(273, '2016-09-14', 7, 3, 20),
(274, '2016-09-14', 7, 3, 42),
(275, '2016-09-14', 5, 3, 33),
(276, '2016-09-15', 6, 3, 14),
(277, '2016-09-15', 7, 3, 10),
(278, '2016-09-15', 7, 3, 41),
(279, '2016-09-15', 7, 3, 30),
(280, '2016-09-15', 7, 3, 34),
(281, '2016-09-15', 7, 3, 39),
(282, '2016-09-15', 5, 3, 26),
(283, '2016-09-15', 7, 3, 43),
(284, '2016-09-15', 7, 3, 11),
(285, '2016-09-15', 7, 3, 7),
(286, '2016-09-15', 7, 3, 20),
(287, '2016-09-15', 7, 3, 42),
(288, '2016-09-15', 6, 3, 33),
(289, '2016-09-16', 2, 3, 14),
(290, '2016-09-16', 2, 3, 10),
(291, '2016-09-16', 2, 3, 41),
(292, '2016-09-16', 3, 3, 30),
(293, '2016-09-16', 2, 3, 34),
(294, '2016-09-16', 2, 3, 39),
(295, '2016-09-16', 2, 3, 26),
(296, '2016-09-16', 2, 3, 43),
(297, '2016-09-16', 2, 3, 11),
(298, '2016-09-16', 2, 3, 7),
(299, '2016-09-16', 2, 3, 20),
(300, '2016-09-16', 2, 3, 42),
(301, '2016-09-16', 2, 3, 33);

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `id` int(11) NOT NULL,
  `Initial` varchar(5) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `actif` tinyint(1) DEFAULT NULL,
  `id_TypeEmploye` int(11) DEFAULT NULL,
  `id_Poste` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `employe`
--

INSERT INTO `employe` (`id`, `Initial`, `prenom`, `nom`, `actif`, `id_TypeEmploye`, `id_Poste`) VALUES
(1, 'AD', 'Abel', 'Delannoy', 0, NULL, NULL),
(2, 'AS', 'Almudena', 'SanRoman', 0, NULL, NULL),
(3, 'AS', 'Amandine', 'Sahl', 0, NULL, NULL),
(4, 'AM', 'Antoine', 'Micelli', 0, NULL, NULL),
(5, 'CR', 'Cecile', 'Robin', 0, NULL, NULL),
(6, 'CS', 'Cedric', 'Seguin', 0, NULL, NULL),
(7, 'CV', 'Celine', 'Vidal', 0, NULL, NULL),
(8, 'CK', 'Christelle', 'Khozian', 0, NULL, NULL),
(9, 'CG', 'Cyril', 'Gautreau', 0, NULL, NULL),
(10, 'DL', 'David', 'Lassagne', 0, NULL, NULL),
(11, 'EP', 'Eric', 'Pringels', 0, NULL, NULL),
(12, 'FB', 'Fabien', 'Buisson', 0, NULL, NULL),
(13, 'FF', 'Florian', 'Fauchier', 0, NULL, NULL),
(14, 'FB', 'Frederic', 'Berton', 1, NULL, NULL),
(15, 'GT', 'Gerald', 'Tibi', 0, NULL, NULL),
(16, 'GF', 'Ghislain', 'Fortin', 0, NULL, NULL),
(17, 'GB', 'Gilles', 'Bassiere', 0, NULL, NULL),
(18, 'JT', 'Jerome', 'TenShong', 0, NULL, NULL),
(19, 'JL', 'Jean Francois', 'Leger', 0, NULL, NULL),
(20, 'JA', 'Jean-Vitus', 'Albertini', 1, NULL, NULL),
(21, 'JD', 'Jeanne', 'Dauvergne', 0, NULL, NULL),
(22, 'JL', 'Jeremy', 'Leriche', 1, NULL, NULL),
(23, 'JC', 'Julie', 'Chabalier', 0, NULL, NULL),
(24, 'JB', 'Julien', 'Bono', 0, NULL, NULL),
(25, 'KS', 'Kamel', 'Sabri', 0, NULL, NULL),
(26, 'KT', 'Khaled', 'Talbi', 0, NULL, NULL),
(27, 'LC', 'Lea', 'Charbonnier', 0, NULL, NULL),
(28, 'LP', 'Laura', 'Perez', 0, NULL, NULL),
(29, 'MM', 'Marion', 'Marcoux', 0, NULL, NULL),
(30, 'MJ', 'Matheo', 'Jaouen', 0, NULL, NULL),
(31, 'MT', 'Mathieu', 'Thomazo', 0, NULL, NULL),
(32, 'OR', 'Olivier', 'Robellotti', 0, NULL, NULL),
(33, 'PD', 'Pierre', 'Delaunay', 0, NULL, NULL),
(34, 'RF', 'Romain', 'Fabbro', 0, NULL, NULL),
(35, 'SM', 'Sabine', 'Meneut', 0, NULL, NULL),
(36, 'SB', 'Sandra', 'Bonnot', 0, NULL, NULL),
(37, 'SR', 'Stephanie', 'Ritz', 0, NULL, NULL),
(38, 'TA', 'Tamou', 'Amadha', 0, NULL, NULL),
(39, 'TR', 'Thibault', 'Rhudel', 0, NULL, NULL),
(40, 'TP', 'Thomas', 'Pell', 0, NULL, NULL),
(41, 'TL', 'Tom', 'Lopez', 1, NULL, NULL),
(42, 'VB', 'Vincent', 'Bourgeois', 0, NULL, NULL),
(43, 'VG', 'Vivien', 'Grivaud', 0, NULL, NULL),
(44, 'YT', 'Yacine', 'Thomazo', 0, NULL, NULL),
(45, 'GG', 'Groupe', 'Groupe', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `employe_projet`
--

CREATE TABLE `employe_projet` (
  `id` int(11) NOT NULL,
  `id_Projet` int(11) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `employe_projet`
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

CREATE TABLE `heuresdescendues` (
  `id` int(11) NOT NULL,
  `heure` tinyint(4) DEFAULT NULL,
  `DateDescendu` date DEFAULT NULL,
  `id_Sprint` int(11) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL,
  `id_Projet` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `heuresdescendues`
--

INSERT INTO `heuresdescendues` (`id`, `heure`, `DateDescendu`, `id_Sprint`, `id_Employe`, `id_Projet`) VALUES
(1, 1, '2016-07-26', 1, 45, 1),
(2, 1, '2016-07-28', 1, 45, 1),
(3, 7, '2016-07-29', 1, 45, 1),
(4, 3, '2016-08-02', 1, 45, 1),
(5, 5, '2016-08-03', 1, 45, 1),
(6, 6, '2016-08-04', 1, 45, 1),
(7, 10, '2016-08-05', 1, 45, 1),
(8, 3, '2016-07-26', 1, 45, 3),
(9, 2, '2016-07-28', 1, 45, 3),
(10, 17, '2016-07-29', 1, 45, 3),
(11, 8, '2016-08-02', 1, 45, 3),
(12, 11, '2016-08-03', 1, 45, 3),
(13, 14, '2016-08-04', 1, 45, 3),
(14, 19, '2016-08-05', 1, 45, 3),
(15, 2, '2016-07-26', 1, 45, 7),
(16, 1, '2016-07-28', 1, 45, 7),
(17, 11, '2016-07-29', 1, 45, 7),
(18, 5, '2016-08-02', 1, 45, 7),
(19, 7, '2016-08-03', 1, 45, 7),
(20, 9, '2016-08-04', 1, 45, 7),
(21, 13, '2016-08-05', 1, 45, 7),
(22, 3, '2016-07-26', 1, 45, 10),
(23, 2, '2016-07-28', 1, 45, 10),
(24, 18, '2016-07-29', 1, 45, 10),
(25, 8, '2016-08-02', 1, 45, 10),
(26, 11, '2016-08-03', 1, 45, 10),
(27, 14, '2016-08-04', 1, 45, 10),
(28, 20, '2016-08-05', 1, 45, 10),
(29, 4, '2016-07-29', 1, 45, 16),
(30, 1, '2016-08-02', 1, 45, 16),
(31, 2, '2016-08-03', 1, 45, 16),
(32, 3, '2016-08-04', 1, 45, 16),
(33, 7, '2016-08-05', 1, 45, 16),
(34, 2, '2016-07-26', 1, 45, 20),
(35, 1, '2016-07-28', 1, 45, 20),
(36, 11, '2016-07-29', 1, 45, 20),
(37, 5, '2016-08-02', 1, 45, 20),
(38, 7, '2016-08-03', 1, 45, 20),
(39, 9, '2016-08-04', 1, 45, 20),
(40, 13, '2016-08-05', 1, 45, 20),
(41, 3, '2016-07-29', 1, 45, 23),
(42, 1, '2016-08-02', 1, 45, 23),
(43, 2, '2016-08-03', 1, 45, 23),
(44, 3, '2016-08-04', 1, 45, 23),
(45, 7, '2016-08-05', 1, 45, 23),
(46, 1, '2016-07-29', 1, 45, 24),
(47, 1, '2016-08-03', 1, 45, 24),
(48, 1, '2016-08-04', 1, 45, 24),
(49, 4, '2016-08-05', 1, 45, 24),
(50, 1, '2016-07-26', 1, 45, 30),
(51, 5, '2016-07-29', 1, 45, 30),
(52, 2, '2016-08-02', 1, 45, 30),
(53, 3, '2016-08-03', 1, 45, 30),
(54, 4, '2016-08-04', 1, 45, 30),
(55, 10, '2016-08-05', 1, 45, 30),
(56, 1, '2016-08-29', 2, 45, 2),
(57, 6, '2016-09-02', 2, 45, 2),
(58, 1, '2016-08-22', 2, 45, 3),
(59, 6, '2016-08-23', 2, 45, 3),
(60, 3, '2016-08-24', 2, 45, 3),
(61, 5, '2016-08-25', 2, 45, 3),
(62, 13, '2016-08-29', 2, 45, 3),
(63, 2, '2016-08-30', 2, 45, 3),
(64, 6, '2016-08-31', 2, 45, 3),
(65, 8, '2016-09-01', 2, 45, 3),
(66, 28, '2016-09-02', 2, 45, 3),
(67, 3, '2016-08-23', 2, 45, 7),
(68, 2, '2016-08-24', 2, 45, 7),
(69, 3, '2016-08-25', 2, 45, 7),
(70, 8, '2016-08-29', 2, 45, 7),
(71, 1, '2016-08-30', 2, 45, 7),
(72, 3, '2016-08-31', 2, 45, 7),
(73, 5, '2016-09-01', 2, 45, 7),
(74, 21, '2016-09-02', 2, 45, 7),
(75, 5, '2016-09-02', 2, 45, 9),
(76, 1, '2016-08-22', 2, 45, 10),
(77, 6, '2016-08-23', 2, 45, 10),
(78, 3, '2016-08-24', 2, 45, 10),
(79, 5, '2016-08-25', 2, 45, 10),
(80, 13, '2016-08-29', 2, 45, 10),
(81, 2, '2016-08-30', 2, 45, 10),
(82, 6, '2016-08-31', 2, 45, 10),
(83, 8, '2016-09-01', 2, 45, 10),
(84, 30, '2016-09-02', 2, 45, 10),
(85, 1, '2016-08-23', 2, 45, 16),
(86, 1, '2016-08-24', 2, 45, 16),
(87, 1, '2016-08-25', 2, 45, 16),
(88, 3, '2016-08-29', 2, 45, 16),
(89, 1, '2016-08-31', 2, 45, 16),
(90, 2, '2016-09-01', 2, 45, 16),
(91, 12, '2016-09-02', 2, 45, 16),
(92, 1, '2016-08-22', 2, 45, 20),
(93, 6, '2016-08-23', 2, 45, 20),
(94, 3, '2016-08-24', 2, 45, 20),
(95, 5, '2016-08-25', 2, 45, 20),
(96, 14, '2016-08-29', 2, 45, 20),
(97, 3, '2016-08-30', 2, 45, 20),
(98, 6, '2016-08-31', 2, 45, 20),
(99, 8, '2016-09-01', 2, 45, 20),
(100, 31, '2016-09-02', 2, 45, 20),
(101, 2, '2016-08-23', 2, 45, 23),
(102, 1, '2016-08-24', 2, 45, 23),
(103, 1, '2016-08-25', 2, 45, 23),
(104, 5, '2016-08-29', 2, 45, 23),
(105, 1, '2016-08-30', 2, 45, 23),
(106, 2, '2016-08-31', 2, 45, 23),
(107, 3, '2016-09-01', 2, 45, 23),
(108, 12, '2016-09-02', 2, 45, 23),
(109, 2, '2016-09-02', 2, 45, 24),
(110, 3, '2016-08-23', 2, 45, 26),
(111, 2, '2016-08-24', 2, 45, 26),
(112, 3, '2016-08-25', 2, 45, 26),
(113, 8, '2016-08-29', 2, 45, 26),
(114, 1, '2016-08-30', 2, 45, 26),
(115, 3, '2016-08-31', 2, 45, 26),
(116, 4, '2016-09-01', 2, 45, 26),
(117, 19, '2016-09-02', 2, 45, 26),
(118, 4, '2016-08-23', 2, 45, 30),
(119, 2, '2016-08-24', 2, 45, 30),
(120, 3, '2016-08-25', 2, 45, 30),
(121, 8, '2016-08-29', 2, 45, 30),
(122, 1, '2016-08-30', 2, 45, 30),
(123, 4, '2016-08-31', 2, 45, 30),
(124, 5, '2016-09-01', 2, 45, 30),
(125, 21, '2016-09-02', 2, 45, 30),
(126, 1, '2016-09-05', 3, 45, 1),
(127, 1, '2016-09-06', 3, 45, 1),
(128, 4, '2016-09-07', 3, 45, 1),
(129, 1, '2016-09-08', 3, 45, 1),
(130, 8, '2016-09-12', 3, 45, 1),
(131, 3, '2016-09-13', 3, 45, 1),
(132, 3, '2016-09-14', 3, 45, 1),
(133, 9, '2016-09-15', 3, 45, 1),
(134, 31, '2016-09-16', 3, 45, 1),
(135, 1, '2016-09-06', 3, 45, 3),
(136, 4, '2016-09-07', 3, 45, 3),
(137, 1, '2016-09-08', 3, 45, 3),
(138, 7, '2016-09-12', 3, 45, 3),
(139, 3, '2016-09-13', 3, 45, 3),
(140, 3, '2016-09-14', 3, 45, 3),
(141, 8, '2016-09-15', 3, 45, 3),
(142, 30, '2016-09-16', 3, 45, 3),
(143, 1, '2016-09-05', 3, 45, 7),
(144, 3, '2016-09-06', 3, 45, 7),
(145, 6, '2016-09-07', 3, 45, 7),
(146, 2, '2016-09-08', 3, 45, 7),
(147, 12, '2016-09-12', 3, 45, 7),
(148, 5, '2016-09-13', 3, 45, 7),
(149, 5, '2016-09-14', 3, 45, 7),
(150, 14, '2016-09-15', 3, 45, 7),
(151, 49, '2016-09-16', 3, 45, 7),
(152, 1, '2016-09-12', 3, 45, 9),
(153, 1, '2016-09-15', 3, 45, 9),
(154, 6, '2016-09-16', 3, 45, 9),
(155, 2, '2016-09-05', 3, 45, 10),
(156, 4, '2016-09-06', 3, 45, 10),
(157, 10, '2016-09-07', 3, 45, 10),
(158, 3, '2016-09-08', 3, 45, 10),
(159, 18, '2016-09-12', 3, 45, 10),
(160, 7, '2016-09-13', 3, 45, 10),
(161, 8, '2016-09-14', 3, 45, 10),
(162, 21, '2016-09-15', 3, 45, 10),
(163, 67, '2016-09-16', 3, 45, 10),
(164, 1, '2016-09-16', 3, 45, 16),
(165, 1, '2016-09-05', 3, 45, 20),
(166, 2, '2016-09-06', 3, 45, 20),
(167, 5, '2016-09-07', 3, 45, 20),
(168, 1, '2016-09-08', 3, 45, 20),
(169, 10, '2016-09-12', 3, 45, 20),
(170, 4, '2016-09-13', 3, 45, 20),
(171, 4, '2016-09-14', 3, 45, 20),
(172, 11, '2016-09-15', 3, 45, 20),
(173, 39, '2016-09-16', 3, 45, 20),
(174, 1, '2016-09-12', 3, 45, 23),
(175, 1, '2016-09-15', 3, 45, 23),
(176, 9, '2016-09-16', 3, 45, 23),
(177, 5, '2016-09-16', 3, 45, 24),
(178, 1, '2016-09-05', 3, 45, 30),
(179, 1, '2016-09-06', 3, 45, 30),
(180, 4, '2016-09-07', 3, 45, 30),
(181, 1, '2016-09-08', 3, 45, 30),
(182, 8, '2016-09-12', 3, 45, 30),
(183, 3, '2016-09-13', 3, 45, 30),
(184, 3, '2016-09-14', 3, 45, 30),
(185, 9, '2016-09-15', 3, 45, 30),
(186, 30, '2016-09-16', 3, 45, 30);

-- --------------------------------------------------------

--
-- Structure de la table `interference`
--

CREATE TABLE `interference` (
  `id` int(11) NOT NULL,
  `heure` int(11) DEFAULT NULL,
  `id_TypeInterference` int(11) DEFAULT NULL,
  `id_Sprint` int(11) DEFAULT NULL,
  `id_Projet` int(11) DEFAULT NULL,
  `id_Employe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `interference`
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
(11, 14, 1, 2, 20, 41),
(12, 1, 1, 3, 3, 35),
(13, 12, 1, 3, 7, 10),
(14, 2, 1, 3, 10, 34),
(15, 4, 1, 3, 10, 26),
(16, 3, 1, 3, 10, 11),
(17, 1, 1, 3, 20, 14),
(18, 7, 1, 3, 20, 41),
(19, 15, 1, 3, 23, 43),
(20, 3, 1, 3, 23, 33),
(21, 28, 1, 3, 30, 42),
(22, 2, 4, 3, 3, 33);

-- --------------------------------------------------------

--
-- Structure de la table `objectif`
--

CREATE TABLE `objectif` (
  `id` int(11) NOT NULL,
  `objectif` varchar(255) DEFAULT NULL,
  `id_StatutObjectif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `poste`
--

CREATE TABLE `poste` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `couleur` varchar(25) DEFAULT NULL,
  `abreviation` varchar(5) DEFAULT NULL,
  `cheminIcone` varchar(50) DEFAULT NULL,
  `id_TypeProjet` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`id`, `nom`, `couleur`, `id_TypeProjet`) VALUES
(1, 'AO', NULL, NULL),
(2, 'PIM-Atlas', NULL, NULL),
(3, 'ecoBalade', NULL, NULL),
(4, 'eCollection', NULL, NULL),
(5, 'iFeedBird', NULL, NULL),
(6, 'Multiprojets', NULL, NULL),
(7, 'Data Centralization', NULL, NULL),
(8, 'Tuyaux (Bonna)', NULL, NULL),
(9, 'Noe', NULL, NULL),
(10, 'ecoReleve Data', NULL, NULL),
(11, 'eReleve', NULL, NULL),
(12, 'Kitizen', NULL, NULL),
(13, 'INPN', NULL, NULL),
(14, 'Collier Loups', NULL, NULL),
(15, 'BioLit', NULL, NULL),
(16, 'FormBuilder', NULL, NULL),
(17, 'Sauvages de ma rue PACA', NULL, NULL),
(18, 'Mycoflore', NULL, NULL),
(19, 'Site Web NS', NULL, NULL),
(20, 'TRACK', NULL, NULL),
(21, 'Photomapping', NULL, NULL),
(22, 'ButterflyId', NULL, NULL),
(23, 'NS Interne', NULL, NULL),
(24, 'Renecore Apps', NULL, NULL),
(25, 'Mon jardin', NULL, NULL),
(26, 'Green citizen', NULL, NULL),
(27, 'Alerting App', NULL, NULL),
(28, 'Futback', NULL, NULL),
(29, 'Sweet', NULL, NULL),
(30, 'Aveyron nature', NULL, NULL),
(31, 'Tout a pied', NULL, NULL),
(32, 'ecoReleve Explorer', NULL, NULL),
(33, 'Footback', NULL, NULL),
(34, 'ecoReleve Core', NULL, NULL),
(35, 'M-EOL', NULL, NULL),
(36, 'Nature en Ville', NULL, NULL),
(37, 'CAU13', NULL, NULL),
(38, 'ecoReleve Glossaire', NULL, NULL),
(39, 'ecoOnto', NULL, NULL),
(40, 'geodiva', NULL, NULL),
(41, 'GR2013 2.0', NULL, NULL),
(42, 'Pocket', NULL, NULL),
(43, 'Site Web Labs', NULL, NULL),
(44, 'Armadillo', NULL, NULL),
(45, 'PIM', NULL, NULL),
(46, 'SIB', NULL, NULL),
(47, 'ecoOnto-med', NULL, NULL),
(48, 'ecoReleve Mobile', NULL, NULL),
(49, 'Mica environnement', NULL, NULL),
(50, 'Valo - LIF', NULL, NULL),
(51, 'AAP FP7 environnement', NULL, NULL),
(52, 'Carnet de plongee', NULL, NULL),
(53, 'Curieux2Sciences', NULL, NULL),
(54, 'EcoBalade Bidules', NULL, NULL),
(55, 'ecoReleve', NULL, NULL),
(56, 'ecoReleve Core/GIS', NULL, NULL),
(57, 'eReleve-Release', NULL, NULL),
(58, 'Faro', NULL, NULL),
(59, 'MICA', NULL, NULL),
(60, 'Open Data', NULL, NULL),
(61, 'ANDD', NULL, NULL),
(62, 'Sentiers sous-marins', NULL, NULL),
(63, 'TeamBuildingEcoBalade_Bioblitz', NULL, NULL),
(64, 'Marche des collines', NULL, NULL),
(65, 'OCK', NULL, NULL),
(66, 'Scrum', NULL, NULL),
(67, 'Position', NULL, NULL),
(68, 'Biotope', NULL, NULL),
(69, 'Airele', NULL, NULL),
(70, 'SECAFI', NULL, NULL),
(71, 'Support', NULL, NULL),
(72, 'Inconnu', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sprint`
--

CREATE TABLE `sprint` (
  `id` int(11) NOT NULL,
  `numero` int(10) DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `sprint`
--

INSERT INTO `sprint` (`id`, `numero`, `dateDebut`, `dateFin`) VALUES
(1, '96', '2016-07-25', '2016-08-05'),
(2, '97', '2016-08-22', '2016-09-02'),
(3, '98', '2016-09-05', '2016-09-16');

-- --------------------------------------------------------

--
-- Structure de la table `sprint_projet`
--

CREATE TABLE `sprint_projet` (
  `id` int(11) NOT NULL,
  `id_Objectif` int(11) DEFAULT NULL,
  `id_Sprint` int(11) DEFAULT NULL,
  `id_Projet` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `statutdemo`
--

CREATE TABLE `statutdemo` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) DEFAULT NULL,
  `couleur` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `statutobjectif`
--

CREATE TABLE `statutobjectif` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `statutobjectif`
--

INSERT INTO `statutobjectif` (`id`, `nom`) VALUES
(1, 'Ok'),
(2, 'En cours'),
(3, 'Non'),
(4, 'Annule');

-- --------------------------------------------------------

--
-- Structure de la table `typeemploye`
--

CREATE TABLE `typeemploye` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `typeemploye`
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

CREATE TABLE `typeinterference` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `typeinterference`
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

CREATE TABLE `typeprojet` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) DEFAULT NULL,
  `couleur` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `typeprojet`
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

CREATE TABLE `typetache` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vburndown`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vburndown` (
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
CREATE TABLE `vvheuresdescendues` (
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
-- Index pour les tables exportées
--

--
-- Index pour la table `attribution`
--
ALTER TABLE `attribution`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Attribution_id_Sprint` (`id_Sprint`),
  ADD KEY `FK_Attribution_id_Employe` (`id_Employe`),
  ADD KEY `FK_Attribution_id_Projet` (`id_Projet`),
  ADD KEY `FK_Attribution_id_Caracteristiques` (`id_Caracteristiques`),
  ADD KEY `FK_Attribution_id_TypeTache` (`id_TypeTache`);

--
-- Index pour la table `caracteristiques`
--
ALTER TABLE `caracteristiques`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `demo`
--
ALTER TABLE `demo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Demo_id_Employe` (`id_Employe`),
  ADD KEY `FK_Demo_id_StatutDemo` (`id_StatutDemo`);

--
-- Index pour la table `disponible`
--
ALTER TABLE `disponible`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Disponible_id_Sprint` (`id_Sprint`),
  ADD KEY `FK_Disponible_id_Employe` (`id_Employe`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Employe_id_TypeEmploye` (`id_TypeEmploye`),
  ADD KEY `FK_Employe_id_Poste` (`id_Poste`);

--
-- Index pour la table `employe_projet`
--
ALTER TABLE `employe_projet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Employe_Projet_id_Projet` (`id_Projet`),
  ADD KEY `FK_Employe_Projet_id_Employe` (`id_Employe`);

--
-- Index pour la table `heuresdescendues`
--
ALTER TABLE `heuresdescendues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_HeuresDescendues_id_Sprint` (`id_Sprint`),
  ADD KEY `FK_HeuresDescendues_id_Employe` (`id_Employe`),
  ADD KEY `FK_HeuresDescendues_id_Projet` (`id_Projet`);

--
-- Index pour la table `interference`
--
ALTER TABLE `interference`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Interference_id_TypeInterference` (`id_TypeInterference`),
  ADD KEY `FK_Interference_id_Sprint` (`id_Sprint`),
  ADD KEY `FK_Interference_id_Projet` (`id_Projet`),
  ADD KEY `FK_Interference_id_Employe` (`id_Employe`);

--
-- Index pour la table `objectif`
--
ALTER TABLE `objectif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Objectif_id_StatutObjectif` (`id_StatutObjectif`);

--
-- Index pour la table `poste`
--
ALTER TABLE `poste`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Projet_id_TypeProjet` (`id_TypeProjet`);

--
-- Index pour la table `sprint`
--
ALTER TABLE `sprint`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sprint_projet`
--
ALTER TABLE `sprint_projet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Sprint_Projet_id_Objectif` (`id_Objectif`),
  ADD KEY `FK_Sprint_Projet_id_Sprint` (`id_Sprint`),
  ADD KEY `FK_Sprint_Projet_id_Projet` (`id_Projet`);

--
-- Index pour la table `statutdemo`
--
ALTER TABLE `statutdemo`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statutobjectif`
--
ALTER TABLE `statutobjectif`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `typeemploye`
--
ALTER TABLE `typeemploye`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `typeinterference`
--
ALTER TABLE `typeinterference`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `typeprojet`
--
ALTER TABLE `typeprojet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `typetache`
--
ALTER TABLE `typetache`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `attribution`
--
ALTER TABLE `attribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT pour la table `caracteristiques`
--
ALTER TABLE `caracteristiques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `demo`
--
ALTER TABLE `demo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `disponible`
--
ALTER TABLE `disponible`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;
--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT pour la table `employe_projet`
--
ALTER TABLE `employe_projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;
--
-- AUTO_INCREMENT pour la table `heuresdescendues`
--
ALTER TABLE `heuresdescendues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;
--
-- AUTO_INCREMENT pour la table `interference`
--
ALTER TABLE `interference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `objectif`
--
ALTER TABLE `objectif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `poste`
--
ALTER TABLE `poste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT pour la table `sprint`
--
ALTER TABLE `sprint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `sprint_projet`
--
ALTER TABLE `sprint_projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `statutdemo`
--
ALTER TABLE `statutdemo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `statutobjectif`
--
ALTER TABLE `statutobjectif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `typeemploye`
--
ALTER TABLE `typeemploye`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `typeinterference`
--
ALTER TABLE `typeinterference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `typeprojet`
--
ALTER TABLE `typeprojet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `typetache`
--
ALTER TABLE `typetache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
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
  ADD CONSTRAINT `FK_HeuresDescendues_id_Sprint` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `FK_Objectif_id_StatutObjectif` FOREIGN KEY (`id_StatutObjectif`) REFERENCES `statutobjectif` (`id`);

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `FK_Projet_id_TypeProjet` FOREIGN KEY (`id_TypeProjet`) REFERENCES `typeprojet` (`id`);

--
-- Contraintes pour la table `sprint_projet`
--
ALTER TABLE `sprint_projet`
  ADD CONSTRAINT `FK_Sprint_Projet_id_Objectif` FOREIGN KEY (`id_Objectif`) REFERENCES `objectif` (`id`),
  ADD CONSTRAINT `FK_Sprint_Projet_id_Projet` FOREIGN KEY (`id_Projet`) REFERENCES `projet` (`id`),
  ADD CONSTRAINT `FK_Sprint_Projet_id_Sprint` FOREIGN KEY (`id_Sprint`) REFERENCES `sprint` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
