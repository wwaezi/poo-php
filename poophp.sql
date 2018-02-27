-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 27 Février 2018 à 12:23
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `poophp`
--

-- --------------------------------------------------------

--
-- Structure de la table `personnagestp`
--

CREATE TABLE IF NOT EXISTS `personnagestp` (
  `id` smallint(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8 NOT NULL,
  `degats` tinyint(3) NOT NULL DEFAULT '0',
  `experience` tinyint(3) NOT NULL DEFAULT '0',
  `niveau` tinyint(3) NOT NULL DEFAULT '1',
  `puissance` tinyint(3) NOT NULL DEFAULT '5',
  `nbCoupsPortes` int(11) NOT NULL DEFAULT '0',
  `dateDernierCoupPorte` date DEFAULT NULL,
  `dateDerniereConnexion` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

--
-- Contenu de la table `personnagestp`
--

INSERT INTO `personnagestp` (`id`, `nom`, `degats`, `experience`, `niveau`, `puissance`, `nbCoupsPortes`, `dateDernierCoupPorte`, `dateDerniereConnexion`) VALUES
(96, 'Wali', 5, 0, 2, 6, 3, '2018-02-27', '2018-02-27'),
(97, 'Henry', 6, 40, 1, 5, 1, '2018-02-27', '2018-02-27');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
