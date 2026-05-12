-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 18, 2026 alle 10:45
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accessi`
--
DROP DATABASE IF EXISTS `accessi`;
CREATE DATABASE IF NOT EXISTS `accessi` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `accessi`;

-- --------------------------------------------------------

--
-- Struttura della tabella `accessi`
--

CREATE TABLE `accessi` (
  `idA` int(11) NOT NULL,
  `DataInizio` date NOT NULL,
  `OraInizio` time NOT NULL,
  `DataFine` date DEFAULT NULL,
  `OraFine` time DEFAULT NULL,
  `idU` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tipiutenti`
--

CREATE TABLE `tipiutenti` (
  `idT` int(11) NOT NULL,
  `ruolo` varchar(15) NOT NULL,
  `descrizione` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tipiutenti`
--

INSERT INTO `tipiutenti` (`idT`, `ruolo`, `descrizione`) VALUES
(1, 'user', 'Normal user'),
(2, 'admin', 'Administrator');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `idU` int(11) NOT NULL,
  `nome` varchar(25) NOT NULL,
  `cognome` varchar(25) NOT NULL,
  `dataNascita` date NOT NULL,
  `sesso` char(1) NOT NULL CHECK (`sesso` = 'M' or `sesso` = 'F'),
  `email` varchar(40) NOT NULL,
  `password` varchar(32) NOT NULL CHECK (char_length(`password`) >= 8),
  `telefono` varchar(15) NOT NULL,
  `residenza` varchar(50) NOT NULL,
  `tipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`idU`, `nome`, `cognome`, `dataNascita`, `sesso`, `email`, `password`, `telefono`, `residenza`, `tipo`) VALUES
(1, 'Mario', 'Rossi', '1990-05-10', 'M', 'mario.rossi@example.com', 'pwdMario90', '3331111111', 'Brescia', 1),
(2, 'Lucia', 'Bianchi', '1992-08-21', 'F', 'lucia.bianchi@example.com', 'pwdLucia92', '3332222222', 'Milano', 1),
(3, 'Gianni', 'Verdi', '1988-01-15', 'M', 'gianni.verdi@example.com', 'pwdGianni88', '3333333333', 'Roma', 1),
(4, 'Sara', 'Neri', '1995-12-03', 'F', 'sara.neri@example.com', 'pwdSara95', '3334444444', 'Torino', 1),
(6, 'pietro', 'marchesi', '2007-12-11', 'M', 'marchesipietro@marchesipietro.xyz', 'natehikkers', '', '', 2);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `accessi`
--
ALTER TABLE `accessi`
  ADD PRIMARY KEY (`idA`),
  ADD KEY `idU` (`idU`);

--
-- Indici per le tabelle `tipiutenti`
--
ALTER TABLE `tipiutenti`
  ADD PRIMARY KEY (`idT`),
  ADD UNIQUE KEY `ruolo` (`ruolo`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`idU`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telefono` (`telefono`),
  ADD KEY `tipologia` (`tipo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `accessi`
--
ALTER TABLE `accessi`
  MODIFY `idA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `tipiutenti`
--
ALTER TABLE `tipiutenti`
  MODIFY `idT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `idU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `accessi`
--
ALTER TABLE `accessi`
  ADD CONSTRAINT `accessi_ibfk_1` FOREIGN KEY (`idU`) REFERENCES `utenti` (`idU`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `tipologia` FOREIGN KEY (`tipo`) REFERENCES `tipiutenti` (`idT`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
