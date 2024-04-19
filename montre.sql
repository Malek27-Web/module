-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 19 avr. 2024 à 23:01
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `montre`
--

-- --------------------------------------------------------

--
-- Structure de la table `bus`
--

CREATE TABLE `bus` (
  `id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `vitesse` int(11) NOT NULL,
  `nb_passagers` int(11) NOT NULL,
  `heure_depart` varchar(40) NOT NULL,
  `heure_arrivee` varchar(40) NOT NULL,
  `etat` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `camera`
--

CREATE TABLE `camera` (
  `id` int(11) NOT NULL,
  `nom_photo` varchar(50) NOT NULL,
  `date_photo` date NOT NULL,
  `photo` text NOT NULL,
  `etat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `camera`
--

INSERT INTO `camera` (`id`, `nom_photo`, `date_photo`, `photo`, `etat`) VALUES
(15, 'camera', '2024-04-19', 'img/pngimg.com - photo_camera_PNG101601.png', 'en panne'),
(16, 'thermostat', '2024-04-19', 'img/17407503-thermometre-thermostat-intelligent-dessin-anime-vecteur-illustration-vectoriel.jpg', 'en marche');

-- --------------------------------------------------------

--
-- Structure de la table `montre`
--

CREATE TABLE `montre` (
  `id` bigint(200) NOT NULL,
  `nb_pas` decimal(11,0) NOT NULL,
  `distance` int(11) NOT NULL,
  `calories` int(11) NOT NULL,
  `duree` varchar(120) NOT NULL,
  `etat` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `montre`
--

INSERT INTO `montre` (`id`, `nb_pas`, `distance`, `calories`, `duree`, `etat`) VALUES
(1, 200, 12, 132, '2', ''),
(2, 490, 1, 12, '01:30', ''),
(7, 900, 2, 170, '2:25', ''),
(8, 490, 1, 131, '1', ''),
(10, 1200, 12, 134, '01:30', ''),
(12, 200, 12, 12, '02:23', ''),
(13, 200, 1, 120, '01:30', ''),
(62, 200, 24, 547, '2:25', ''),
(63, 1200, 1, 12, '02:23', ''),
(64, 1200, 12, 134, '1:30', ''),
(65, 1200, 12, 134, '02:23', ''),
(69, 1200, 11, 11, '1:30', ''),
(70, 1200, 1, 139, '2', ''),
(71, 200, 12, 134, '1:30', ''),
(72, 200, 11, 134, '01:30', ''),
(73, 200, 1, 11, '01:30', ''),
(74, 2300, 4, 230, '03:34', ''),
(75, 200, 9, 234, '23', ''),
(79, 200, 0, 134, '01:30', 'en panne');

-- --------------------------------------------------------

--
-- Structure de la table `thermostat`
--

CREATE TABLE `thermostat` (
  `id` int(11) NOT NULL,
  `temp_actuelle` int(11) NOT NULL,
  `temp_choisie` int(11) NOT NULL,
  `humidite` int(11) NOT NULL,
  `duree_fonctionnement` varchar(30) NOT NULL,
  `etat` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `thermostat`
--

INSERT INTO `thermostat` (`id`, `temp_actuelle`, `temp_choisie`, `humidite`, `duree_fonctionnement`, `etat`) VALUES
(3, 22, 45, 12, '02:34', 'en marche'),
(5, -3, 20, 8, '02:34', 'en panne');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `camera`
--
ALTER TABLE `camera`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `montre`
--
ALTER TABLE `montre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `thermostat`
--
ALTER TABLE `thermostat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bus`
--
ALTER TABLE `bus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `camera`
--
ALTER TABLE `camera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `montre`
--
ALTER TABLE `montre`
  MODIFY `id` bigint(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT pour la table `thermostat`
--
ALTER TABLE `thermostat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
