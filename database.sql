-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2025 at 04:30 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `app_bac`
--
CREATE DATABASE IF NOT EXISTS `app_bac` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `app_bac`;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_role` (`nom_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nom_utilisateur` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL,
  `statut` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nom_utilisateur` (`nom_utilisateur`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accreditations`
--

CREATE TABLE `accreditations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_permission` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_permission` (`nom_permission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles_accreditations`
--

CREATE TABLE `roles_accreditations` (
  `id_role` int(11) NOT NULL,
  `id_accreditation` int(11) NOT NULL,
  PRIMARY KEY (`id_role`,`id_accreditation`),
  KEY `id_accreditation` (`id_accreditation`),
  CONSTRAINT `roles_accreditations_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `roles_accreditations_ibfk_2` FOREIGN KEY (`id_accreditation`) REFERENCES `accreditations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parametres`
--

CREATE TABLE `parametres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cle` varchar(255) NOT NULL,
  `valeur` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cle` (`cle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lycees`
--

CREATE TABLE `lycees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `directeur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_serie` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_serie` (`nom_serie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matieres`
--

CREATE TABLE `matieres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_matiere` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_matiere` (`nom_matiere`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matieres_series`
--

CREATE TABLE `matieres_series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_matiere` int(11) NOT NULL,
  `id_serie` int(11) NOT NULL,
  `coefficient` float NOT NULL,
  `type` enum('obligatoire','facultatif') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_matiere_id_serie` (`id_matiere`,`id_serie`),
  KEY `id_serie` (`id_serie`),
  CONSTRAINT `matieres_series_ibfk_1` FOREIGN KEY (`id_matiere`) REFERENCES `matieres` (`id`) ON DELETE CASCADE,
  CONSTRAINT `matieres_series_ibfk_2` FOREIGN KEY (`id_serie`) REFERENCES `series` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `centres`
--

CREATE TABLE `centres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_centre` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `capacite` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidats`
--

CREATE TABLE `candidats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_matricule` varchar(255) NOT NULL,
  `numero_dossier` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `sexe` enum('M','F') DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(255) DEFAULT NULL,
  `nationalite` varchar(255) DEFAULT NULL,
  `id_serie` int(11) NOT NULL,
  `id_lycee_origine` int(11) NOT NULL,
  `date_enrolement` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_matricule` (`numero_matricule`),
  UNIQUE KEY `numero_dossier` (`numero_dossier`),
  KEY `id_serie` (`id_serie`),
  KEY `id_lycee_origine` (`id_lycee_origine`),
  CONSTRAINT `candidats_ibfk_1` FOREIGN KEY (`id_serie`) REFERENCES `series` (`id`),
  CONSTRAINT `candidats_ibfk_2` FOREIGN KEY (`id_lycee_origine`) REFERENCES `lycees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biometrie`
--

CREATE TABLE `biometrie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_candidat` int(11) NOT NULL,
  `photo` longblob DEFAULT NULL,
  `empreinte_digitale` longblob DEFAULT NULL,
  `signature_numerique` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_candidat` (`id_candidat`),
  CONSTRAINT `biometrie_ibfk_1` FOREIGN KEY (`id_candidat`) REFERENCES `candidats` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paiements`
--

CREATE TABLE `paiements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_candidat` int(11) NOT NULL,
  `type_paiement` enum('enrolement','retrait_diplome','authentification_diplome') NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date_paiement` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_candidat` (`id_candidat`),
  KEY `id_utilisateur` (`id_utilisateur`),
  CONSTRAINT `paiements_ibfk_1` FOREIGN KEY (`id_candidat`) REFERENCES `candidats` (`id`),
  CONSTRAINT `paiements_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribution_centres`
--

CREATE TABLE `attribution_centres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_candidat` int(11) NOT NULL,
  `id_centre` int(11) NOT NULL,
  `numero_salle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_candidat` (`id_candidat`),
  KEY `id_centre` (`id_centre`),
  CONSTRAINT `attribution_centres_ibfk_1` FOREIGN KEY (`id_candidat`) REFERENCES `candidats` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attribution_centres_ibfk_2` FOREIGN KEY (`id_centre`) REFERENCES `centres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_candidat` int(11) NOT NULL,
  `id_matiere_serie` int(11) NOT NULL,
  `note` float DEFAULT NULL,
  `id_utilisateur_saisie` int(11) NOT NULL,
  `date_saisie` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_candidat_id_matiere_serie` (`id_candidat`,`id_matiere_serie`),
  KEY `id_matiere_serie` (`id_matiere_serie`),
  KEY `id_utilisateur_saisie` (`id_utilisateur_saisie`),
  CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`id_candidat`) REFERENCES `candidats` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`id_matiere_serie`) REFERENCES `matieres_series` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notes_ibfk_3` FOREIGN KEY (`id_utilisateur_saisie`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resultats`
--

CREATE TABLE `resultats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_candidat` int(11) NOT NULL,
  `moyenne` float DEFAULT NULL,
  `decision` enum('admis','ajourne','admissible_2nd_tour') DEFAULT NULL,
  `date_calcul` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_candidat` (`id_candidat`),
  CONSTRAINT `resultats_ibfk_1` FOREIGN KEY (`id_candidat`) REFERENCES `candidats` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `adresse_ip` varchar(45) DEFAULT NULL,
  `date_action` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_utilisateur` (`id_utilisateur`),
  CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
