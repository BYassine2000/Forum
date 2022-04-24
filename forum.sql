-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 24 avr. 2022 à 15:31
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  `titre_cat` varchar(50) DEFAULT NULL,
  `lien_cat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_cat`, `titre_cat`, `lien_cat`) VALUES
(1, 'Jeux-vidéos', 'jeux-videos'),
(2, 'Informatiques', 'informatiques');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id_p` int(11) NOT NULL AUTO_INCREMENT,
  `contenu` text,
  `date_p` date DEFAULT NULL,
  `heure_p` time DEFAULT NULL,
  `id_u` int(11) DEFAULT NULL,
  `id_t` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_p`),
  KEY `id_u` (`id_u`),
  KEY `id_t` (`id_t`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id_p`, `contenu`, `date_p`, `heure_p`, `id_u`, `id_t`) VALUES
(1, 'Le developpement durable', '2020-10-10', '10:10:00', 1, 1),
(2, 'Emploi et jeunesse', '2020-08-07', '15:30:00', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id_t` int(11) NOT NULL AUTO_INCREMENT,
  `id_cat` int(11) NOT NULL,
  `titre_top` varchar(50) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id_t`),
  KEY `id_cat` (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `topics`
--

INSERT INTO `topics` (`id_t`, `id_cat`, `titre_top`, `description`) VALUES
(1, 1, 'Topic-1', 'Vie scolaire'),
(2, 2, 'Topic-2', 'Cours municipaux adultes');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_u` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `lvl` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_u`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_u`, `pseudo`, `email`, `mdp`, `lvl`) VALUES
(1, 'yassineadmin', 'admin@gmail.com', '107d348bff437c999a9ff192adcb78cb03b8ddc6', 3),
(2, 'yassinemodo', 'modo@gmail.com', '107d348bff437c999a9ff192adcb78cb03b8ddc6', 2),
(3, 'yassineuser', 'user@gmail.com', '107d348bff437c999a9ff192adcb78cb03b8ddc6', 1);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `viewposts`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `viewposts`;
CREATE TABLE IF NOT EXISTS `viewposts` (
`titre_cat` varchar(50)
,`description` text
,`contenu` text
,`date_p` date
,`heure_p` time
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `viewtopics`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `viewtopics`;
CREATE TABLE IF NOT EXISTS `viewtopics` (
`id_t` int(11)
,`id_cat` varchar(50)
,`titre_top` varchar(50)
,`description` text
);

-- --------------------------------------------------------

--
-- Structure de la vue `viewposts`
--
DROP TABLE IF EXISTS `viewposts`;

DROP VIEW IF EXISTS `viewposts`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewposts`  AS   (select `c`.`titre_cat` AS `titre_cat`,`t`.`description` AS `description`,`p`.`contenu` AS `contenu`,`p`.`date_p` AS `date_p`,`p`.`heure_p` AS `heure_p` from (((`users` `u` join `topics` `t`) join `posts` `p`) join `category` `c`) where ((`u`.`id_u` = `p`.`id_p`) and (`c`.`id_cat` = `p`.`id_p`) and (`t`.`id_t` = `p`.`id_p`)))  ;

-- --------------------------------------------------------

--
-- Structure de la vue `viewtopics`
--
DROP TABLE IF EXISTS `viewtopics`;

DROP VIEW IF EXISTS `viewtopics`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtopics`  AS SELECT `t`.`id_t` AS `id_t`, `c`.`titre_cat` AS `id_cat`, `t`.`titre_top` AS `titre_top`, `t`.`description` AS `description` FROM (`topics` `t` join `category` `c`) WHERE (`c`.`id_cat` = `t`.`id_t`) ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `users` (`id_u`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`id_t`) REFERENCES `topics` (`id_t`);

--
-- Contraintes pour la table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`id_cat`) REFERENCES `category` (`id_cat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
