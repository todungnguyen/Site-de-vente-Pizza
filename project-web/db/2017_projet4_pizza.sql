-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 01, 2017 at 10:00 PM
-- Server version: 5.7.11
-- PHP Version: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2017_projet4_pizza`
--
/*CREATE DATABASE IF NOT EXISTS `2017_projet4_pizza` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `2017_projet4_pizza`;*/

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE `commandes` (
  `cid` int(11) NOT NULL,
  `ref` varchar(10) NOT NULL,
  `uid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `statut` enum('preparation','livraison','terminee','') NOT NULL DEFAULT 'preparation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`cid`, `ref`, `uid`, `rid`, `date`, `statut`) VALUES
(1, 'AZ17YT', 2, 1, '2017-05-01 11:48:00', 'terminee'),
(2, 'I7GTL4', 2, 4, '2017-04-25 18:15:00', 'livraison'),
(3, 'YT65RQ', 4, 2, '2017-05-02 13:00:00', 'preparation'),
(4, 'YHGT5', 3, 3, '2017-05-16 14:28:00', 'livraison'),
(5, 'QW34BN', 5, 1, '2017-05-09 12:00:00', 'preparation');

-- --------------------------------------------------------

--
-- Table structure for table `extras`
--

DROP TABLE IF EXISTS `extras`;
CREATE TABLE `extras` (
  `cid` int(11) NOT NULL,
  `sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `extras`
--

INSERT INTO `extras` (`cid`, `sid`) VALUES
(2, 3),
(5, 3),
(3, 4),
(5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `recettes`
--

DROP TABLE IF EXISTS `recettes`;
CREATE TABLE `recettes` (
  `rid` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prix` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recettes`
--

INSERT INTO `recettes` (`rid`, `nom`, `prix`) VALUES
(1, ' Margherita', 8.5),
(2, 'Regina', 10.5),
(3, 'Napoletana', 11.5),
(4, '4 stagioni', 11.5);

-- --------------------------------------------------------

--
-- Table structure for table `supplements`
--

DROP TABLE IF EXISTS `supplements`;
CREATE TABLE `supplements` (
  `sid` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prix` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplements`
--

INSERT INTO `supplements` (`sid`, `nom`, `prix`) VALUES
(1, 'Fromage', 0.5),
(2, 'Anchois', 0.75),
(3, 'Jambon', 1),
(4, 'Boisson', 2),
(5, 'Frites', 2.5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `login` varchar(30) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `nom`, `prenom`, `login`, `mdp`, `role`) VALUES
(1, 'Admin', 'User', 'admin', '$2y$10$WUXmfWOTO3gf.QIwxuHH0ecG51cmEsgW5YmHbQaAHcYL6wV11GgOm', 'admin'),
(2, 'Test', 'User', 'test', '$2y$10$rwE2jgPjPrw1i8DBi5xgY.aZuqV..6w9ZEFQmiYAy1G3slnJpKFVy', 'user'),
(3, 'Dupont', 'Jean', 'jean', '$2y$10$uCA3FR6xf6b1SvEXedZ3ju5/qae4wQvIaRN6LnrbVwml1bta.6Gbm', 'user'),
(4, 'Monin', 'Michel', 'michel', '$2y$10$BwrkqA3/Snps08LSYwttyOPUGp/8eaGDslq9Zv3aoDUEFqjtM7QmW', 'user'),
(5, NULL, NULL, 'anne', '$2y$10$Y7YSA5gcMB/It.Azzz.SBumneYSwOInCSUI9.JPdneltcNH3UC2JC', 'user'),
(6, 'admin1', 'admin1', 'admin1', 'e00cf25ad42683b3df678c61f42c6bda', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`cid`,`sid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `recettes`
--
ALTER TABLE `recettes`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `supplements`
--
ALTER TABLE `supplements`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `recettes`
--
ALTER TABLE `recettes`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `supplements`
--
ALTER TABLE `supplements`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `recettes` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `extras`
--
ALTER TABLE `extras`
  ADD CONSTRAINT `extras_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `supplements` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `extras_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `commandes` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
