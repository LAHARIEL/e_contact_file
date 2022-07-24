-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 19 juil. 2022 à 00:17
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `repertoire`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type_contact` enum('ami','famille','professionel','autre') NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id_contact`, `nom`, `prenom`, `telephone`, `email`, `type_contact`, `photo`) VALUES
(1, 'Chat', 'Piteau', '0000000006', 'miaou@ronron.com', 'famille', 'photo/1658176294_chat.jpg'),
(2, 'Bêêêle', 'Patrofor', '0000000001', 'laineu@baaaa.fr', 'professionel', 'photo/1658173715_mouton.jpg'),
(8, 'Patoche', 'Woufi', '0000000009', 'waf@grrr.com', 'ami', 'photo/1658173726_chien.jpg'),
(10, 'Roi', 'Lionceau', '0000000005', 'graou@graou.com', 'famille', 'photo/1658174062_lion.jpg'),
(11, 'Birdy', 'Singer', '0000000005', 'tuitui@song.com', 'autre', 'photo/1658173745_oiseau.jpg'),
(17, 'Bambi', 'Baby', '0000000000', 'forest@green.fr', 'autre', 'photo/1658180394_cerf.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
