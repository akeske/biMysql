-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: localhost
-- Χρόνος δημιουργίας: 22 Νοε 2014 στις 22:59:46
-- Έκδοση διακομιστή: 5.6.20
-- Έκδοση PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Βάση δεδομένων: `conservatory`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `audit`
--

CREATE TABLE IF NOT EXISTS `audit` (
`id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `table_name` enum('instrument','musician','student','teaching','register','login','logout') NOT NULL,
  `query` mediumblob NOT NULL,
  `trans_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `instrument`
--

CREATE TABLE IF NOT EXISTS `instrument` (
`instrument_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_start` timestamp NULL DEFAULT NULL,
  `trans_end` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `musician`
--

CREATE TABLE IF NOT EXISTS `musician` (
`id` int(10) NOT NULL,
  `musician_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `valid_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `valid_end` timestamp NULL DEFAULT NULL,
  `trans_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_end` timestamp NULL DEFAULT NULL,
  `read_level` set('admin','secretary','student','') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `student`
--

CREATE TABLE IF NOT EXISTS `student` (
`id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valid_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `valid_end` timestamp NULL DEFAULT NULL,
  `trans_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_end` timestamp NULL DEFAULT NULL,
  `read_level` set('student','admin','secretary','') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `teaching`
--

CREATE TABLE IF NOT EXISTS `teaching` (
`id` int(10) NOT NULL,
  `teaching_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `musician_id` int(10) NOT NULL,
  `instrument_id` int(10) NOT NULL,
  `valid_start` timestamp NULL DEFAULT NULL,
  `valid_end` timestamp NULL DEFAULT NULL,
  `read_level` set('student','admin','secretary','') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` set('admin','secretary','student','musician') COLLATE utf8_unicode_ci NOT NULL,
  `is_enable` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `audit`
--
ALTER TABLE `audit`
 ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `instrument`
--
ALTER TABLE `instrument`
 ADD PRIMARY KEY (`instrument_id`);

--
-- Ευρετήρια για πίνακα `musician`
--
ALTER TABLE `musician`
 ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `student`
--
ALTER TABLE `student`
 ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `teaching`
--
ALTER TABLE `teaching`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

--
-- Ευρετήρια για πίνακα `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);
