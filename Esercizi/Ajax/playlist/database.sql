-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2026 at 06:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `playlist`
--
DROP DATABASE IF EXISTS `playlist`;
CREATE DATABASE IF NOT EXISTS `playlist` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `playlist`;

-- --------------------------------------------------------

--
-- Table structure for table `brani`
--

CREATE TABLE `brani` (
  `idB` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `durata` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brani`
--

INSERT INTO `brani` (`idB`, `nome`, `categoria`, `durata`) VALUES
(1, 'Bohemian Rhapsody', 'Rock', 0),
(2, 'Stairway to Heaven', 'Rock', 0),
(3, 'Imagine', 'Pop', 0),
(4, 'Blinding Lights', 'Pop', 0),
(5, 'Lose Yourself', 'Hip Hop', 0),
(6, 'Eye of the Tiger', 'Rock', 0),
(7, 'Perfect', 'Pop', 0),
(8, 'Shallow', 'Pop', 0),
(9, 'Thunderstruck', 'Rock', 0),
(10, 'Meditation Sounds', 'Relax', 0);

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `idP` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`idP`, `nome`, `username`) VALUES
(1, 'Rock Classico', 'mrossi'),
(2, 'Relax Evening', 'lbianchi'),
(3, 'Workout Mix', 'gverdi'),
(4, 'Pop Italia', 'nneri'),
(5, 'EFN', 'pietro');

-- --------------------------------------------------------

--
-- Table structure for table `playlist_brani`
--

CREATE TABLE `playlist_brani` (
  `id_playlist` int(11) NOT NULL,
  `id_brano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlist_brani`
--

INSERT INTO `playlist_brani` (`id_playlist`, `id_brano`) VALUES
(1, 1),
(1, 2),
(1, 9),
(2, 3),
(2, 8),
(2, 10),
(3, 5),
(3, 6),
(3, 9),
(4, 3),
(4, 4),
(4, 7),
(5, 1),
(5, 2),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`username`, `password`, `nome`, `cognome`) VALUES
('gverdi', 'pass789', 'Giulia', 'Verdi'),
('lbianchi', 'abc123', 'Laura', 'Bianchi'),
('mrossi', '12345', 'Marco', 'Rossi'),
('nneri', 'qwerty', 'Nicolo', 'Neri'),
('pietro', 'time', 'pietro', 'marchesi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brani`
--
ALTER TABLE `brani`
  ADD PRIMARY KEY (`idB`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`idP`),
  ADD UNIQUE KEY `user` (`username`);

--
-- Indexes for table `playlist_brani`
--
ALTER TABLE `playlist_brani`
  ADD PRIMARY KEY (`id_playlist`,`id_brano`),
  ADD KEY `id_brano` (`id_brano`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brani`
--
ALTER TABLE `brani`
  MODIFY `idB` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `idP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utenti` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `playlist_brani`
--
ALTER TABLE `playlist_brani`
  ADD CONSTRAINT `playlist_brani_ibfk_1` FOREIGN KEY (`id_playlist`) REFERENCES `playlist` (`idP`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `playlist_brani_ibfk_2` FOREIGN KEY (`id_brano`) REFERENCES `brani` (`idB`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
