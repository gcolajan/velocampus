-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 05 Novembre 2012 à 16:57
-- Version du serveur: 5.1.63
-- Version de PHP: 5.3.3-7+squeeze14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `velocampus`
--

-- --------------------------------------------------------

--
-- Structure de la table `velo_campus`
--

CREATE TABLE IF NOT EXISTS `velo_campus` (
  `campus_id` int(11) NOT NULL AUTO_INCREMENT,
  `campus_nom` varchar(32) NOT NULL,
  PRIMARY KEY (`campus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `velo_dept_universitaire`
--

CREATE TABLE IF NOT EXISTS `velo_dept_universitaire` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_nom` varchar(64) NOT NULL,
  `dept_campus_id` int(11) NOT NULL,
  PRIMARY KEY (`dept_id`),
  KEY `dept_campus_id` (`dept_campus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `velo_local`
--

CREATE TABLE IF NOT EXISTS `velo_local` (
  `local_id` int(11) NOT NULL AUTO_INCREMENT,
  `local_nom` varchar(32) NOT NULL,
  `local_adresse` varchar(255) NOT NULL,
  `local_campus_id` int(11) NOT NULL,
  `local_ville_id` int(11) NOT NULL,
  PRIMARY KEY (`local_id`),
  KEY `local_ville_id` (`local_ville_id`),
  KEY `local_campus_id` (`local_campus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `velo_locataire`
--

CREATE TABLE IF NOT EXISTS `velo_locataire` (
  `loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_nom` varchar(32) NOT NULL,
  `loc_prenom` varchar(32) NOT NULL,
  `loc_telephone` int(11),
  `loc_email` varchar(255),
  `loc_adresse` varchar(255),
  `loc_dept_id` int(11),
  `loc_statut_id` int(11) NOT NULL,
  `loc_ville_id` int(11),
  PRIMARY KEY (`loc_id`),
  KEY `loc_dept_id` (`loc_dept_id`),
  KEY `loc_statut_id` (`loc_statut_id`),
  KEY `loc_ville_id` (`loc_ville_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `velo_loue`
--

CREATE TABLE IF NOT EXISTS `velo_loue` (
  `loue_loc_id` int(11),
  `loue_velo_id` int(11) NOT NULL,
  `loue_date_location` date NOT NULL,
  `loue_cadenas1` int(11) NOT NULL,
  `loue_cadenas2` int(11) NOT NULL,
  `loue_cadenas3` int(11) NOT NULL,
  `loue_duree_theorique` int(11) NOT NULL,
  `loue_date_rendu_effective` date DEFAULT NULL,
  PRIMARY KEY (`loue_loc_id`,`loue_velo_id`,`loue_date_location`),
  KEY `loue_velo_id` (`loue_velo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `velo_modele`
--

CREATE TABLE IF NOT EXISTS `velo_modele` (
  `modele_id` int(11) NOT NULL AUTO_INCREMENT,
  `modele_nom` varchar(32) NOT NULL,
  PRIMARY KEY (`modele_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `velo_statut`
--

CREATE TABLE IF NOT EXISTS `velo_statut` (
  `statut_id` int(11) NOT NULL AUTO_INCREMENT,
  `statut_nom` varchar(32) NOT NULL,
  PRIMARY KEY (`statut_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `velo_velo`
--

CREATE TABLE IF NOT EXISTS `velo_velo` (
  `velo_id` int(11) NOT NULL AUTO_INCREMENT,
  `velo_date_achat` date NOT NULL,
  `velo_suivi` text NOT NULL,
  `velo_observations` text NOT NULL,
  `velo_modele_id` int(11) NOT NULL,
  `velo_local_id` int(11) NOT NULL,
  PRIMARY KEY (`velo_id`),
  KEY `velo_modele_id` (`velo_modele_id`),
  KEY `velo_local_id` (`velo_local_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `velo_ville`
--

CREATE TABLE IF NOT EXISTS `velo_ville` (
  `ville_id` int(11) NOT NULL AUTO_INCREMENT,
  `ville_nom` varchar(255) NOT NULL,
  `ville_cp` mediumint(5) NOT NULL,
  PRIMARY KEY (`ville_id`),
  KEY `code_postal` (`ville_cp`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38106 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `velo_dept_universitaire`
--
ALTER TABLE `velo_dept_universitaire`
  ADD CONSTRAINT `velo_dept_universitaire_ibfk_1` FOREIGN KEY (`dept_campus_id`) REFERENCES `velo_campus` (`campus_id`);

--
-- Contraintes pour la table `velo_local`
--
ALTER TABLE `velo_local`
  ADD CONSTRAINT `velo_local_ibfk_2` FOREIGN KEY (`local_ville_id`) REFERENCES `velo_ville` (`ville_id`),
  ADD CONSTRAINT `velo_local_ibfk_1` FOREIGN KEY (`local_campus_id`) REFERENCES `velo_campus` (`campus_id`);

--
-- Contraintes pour la table `velo_locataire`
--
ALTER TABLE `velo_locataire`
  ADD CONSTRAINT `velo_locataire_ibfk_3` FOREIGN KEY (`loc_ville_id`) REFERENCES `velo_ville` (`ville_id`),
  ADD CONSTRAINT `velo_locataire_ibfk_1` FOREIGN KEY (`loc_dept_id`) REFERENCES `velo_dept_universitaire` (`dept_id`),
  ADD CONSTRAINT `velo_locataire_ibfk_2` FOREIGN KEY (`loc_statut_id`) REFERENCES `velo_statut` (`statut_id`);

--
-- Contraintes pour la table `velo_loue`
--
ALTER TABLE `velo_loue`
  ADD CONSTRAINT `velo_loue_ibfk_1` FOREIGN KEY (`loue_loc_id`) REFERENCES `velo_locataire` (`loc_id`),
  ADD CONSTRAINT `velo_loue_ibfk_2` FOREIGN KEY (`loue_velo_id`) REFERENCES `velo_velo` (`velo_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `velo_velo`
--
ALTER TABLE `velo_velo`
  ADD CONSTRAINT `velo_velo_ibfk_2` FOREIGN KEY (`velo_local_id`) REFERENCES `velo_local` (`local_id`),
  ADD CONSTRAINT `velo_velo_ibfk_1` FOREIGN KEY (`velo_modele_id`) REFERENCES `velo_modele` (`modele_id`);
