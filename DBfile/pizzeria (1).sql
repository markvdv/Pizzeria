-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 28 mei 2014 om 17:05
-- Serverversie: 5.6.16
-- PHP-versie: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `pizzeria`
--
CREATE DATABASE IF NOT EXISTS `pizzeria` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `pizzeria`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `accountid` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `voornaam` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `telefoon` varchar(15) COLLATE utf8_bin NOT NULL,
  `leverplaatsid` int(11) NOT NULL,
  `email` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pw` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`accountid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `account`
--

INSERT INTO `account` (`accountid`, `naam`, `voornaam`, `telefoon`, `leverplaatsid`, `email`, `pw`, `salt`) VALUES
(1, 'me', 'me', '0474192822', 4, 'me@me.me', '7765a7f3fadfd3cb7f92ab65d0d5e56dee48fd8b08927540fd4659629692dacc', '1dd378becc07aeb173254301e5026bc722dd1ea64f76137ec954027e77689c75c7053accf86fa7402b445bd0ee3279d2');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `adminid` int(11) NOT NULL,
  `naam` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pw` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden uitgevoerd voor tabel `admin`
--

INSERT INTO `admin` (`adminid`, `naam`, `pw`, `salt`) VALUES
(0, 'admin', 'be788643d7fea595826f2a9c4a003fae449a2cd69a19935a1482f538c50baf38', '5083765d4431982c0af0585808a3de4619b1a2384586efc46f10229ded9cc5ed72a971e432137eba2eaf9e4f4f20adf7');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bericht`
--

CREATE TABLE IF NOT EXISTS `bericht` (
  `berichtid` int(11) NOT NULL AUTO_INCREMENT,
  `auteur` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tijdstip` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`berichtid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `bericht`
--

INSERT INTO `bericht` (`berichtid`, `auteur`, `tijdstip`, `text`) VALUES
(1, 'ikke', '2014-03-25 09:54:20', 'Bangelijke pizza''s hier! Echt een aanrader!!'),
(2, 'een tevreden klant', '2014-03-25 10:41:46', 'Snelle levering, lekkere pizza''s!!');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling`
--

CREATE TABLE IF NOT EXISTS `bestelling` (
  `bestellingid` int(11) NOT NULL AUTO_INCREMENT,
  `tijdstip` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `naam` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `voornaam` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `telefoon` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `leverplaatsid` int(11) NOT NULL,
  `opmerking` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `accountid` int(11) DEFAULT NULL,
  PRIMARY KEY (`bestellingid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelregel`
--

CREATE TABLE IF NOT EXISTS `bestelregel` (
  `bestelregelid` int(11) NOT NULL AUTO_INCREMENT,
  `bestellingid` int(11) NOT NULL,
  `productnaam` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`bestelregelid`),
  KEY `bestellingid` (`bestellingid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=189 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leverplaats`
--

CREATE TABLE IF NOT EXISTS `leverplaats` (
  `leverplaatsid` int(11) NOT NULL AUTO_INCREMENT,
  `straat` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `huisnummer` int(3) NOT NULL,
  `postcodeid` int(11) NOT NULL,
  PRIMARY KEY (`leverplaatsid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `leverplaats`
--

INSERT INTO `leverplaats` (`leverplaatsid`, `straat`, `huisnummer`, `postcodeid`) VALUES
(4, 'vredebaan', 21, 1),
(5, 'm', 26, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `postcode`
--

CREATE TABLE IF NOT EXISTS `postcode` (
  `postcodeid` int(11) NOT NULL AUTO_INCREMENT,
  `postcode` int(4) NOT NULL,
  `woonplaats` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`postcodeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `postcode`
--

INSERT INTO `postcode` (`postcodeid`, `postcode`, `woonplaats`) VALUES
(1, 2640, 'Mortsel'),
(2, 2530, 'Boechout'),
(3, 2000, 'Antwerpen'),
(4, 2600, 'Berchem');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `productnaam` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `productomschrijving` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `productprijs` int(4) NOT NULL,
  `productaantal` int(11) DEFAULT '10',
  PRIMARY KEY (`productnaam`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden uitgevoerd voor tabel `product`
--

INSERT INTO `product` (`productnaam`, `productomschrijving`, `productprijs`, `productaantal`) VALUES
('Pizza Capricciosa', 'tomatensaus, mozzarella, ham, ansjovis, artisjok, champignons, olijven', 1500, NULL),
('Pizza Margherita', 'tomatensaus, mozzarella', 999, NULL),
('Pizza Napoletana', 'tomatensaus, mozzarella, ansjovis, kappertjes', 1100, NULL),
('Pizza Quattro Formaggi', 'tomatensaus, mozzarella, parmezaan, gorgonzola, emmentaler, ', 1300, NULL),
('Pizza Salami', 'tomatensaus, mozzarella, salami, ajuin', 1200, NULL);

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `bestelregel`
--
ALTER TABLE `bestelregel`
  ADD CONSTRAINT `bestelregel_ibfk_1` FOREIGN KEY (`bestellingid`) REFERENCES `bestelling` (`bestellingid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
