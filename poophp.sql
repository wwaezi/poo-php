-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 27 fév. 2018 à 08:36
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `poophp`
--

-- --------------------------------------------------------

--
-- Structure de la table `personnagestp`
--

DROP TABLE IF EXISTS `personnagestp`;
CREATE TABLE IF NOT EXISTS `personnagestp` (
  `id` smallint(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8 NOT NULL,
  `degats` tinyint(3) NOT NULL DEFAULT '0',
  `experience` tinyint(3) NOT NULL DEFAULT '0',
  `niveau` tinyint(3) NOT NULL DEFAULT '1',
  `puissance` tinyint(3) NOT NULL DEFAULT '5',
  `nbCoupsPortes` int(11) NOT NULL DEFAULT '0',
  `dateDernierCoupPorte` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `personnagestp`
--

INSERT INTO `personnagestp` (`id`, `nom`, `degats`, `experience`, `niveau`, `puissance`, `nbCoupsPortes`, `dateDernierCoupPorte`) VALUES
(75, 'henry', 5, 80, 8, 12, 3, '2018-02-26'),
(76, 'wai', 99, 40, 1, 5, 1, '2018-02-26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
