-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: localhost
-- Χρόνος δημιουργίας: 13 Νοε 2014 στις 14:52:09
-- Έκδοση διακομιστή: 5.5.40-0ubuntu1
-- Έκδοση PHP: 5.5.12-2ubuntu4.1

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
-- Δομή πίνακα για τον πίνακα `instrument`
--

CREATE TABLE IF NOT EXISTS `instrument` (
`id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valid_start` timestamp NULL DEFAULT NULL,
  `valid_end` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
  `trans_end` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Άδειασμα δεδομένων του πίνακα `musician`
--

INSERT INTO `musician` (`id`, `musician_id`, `name`, `telephone`, `valid_start`, `valid_end`, `trans_start`, `trans_end`) VALUES
(1, 2, 'ghc', 'gh', '0000-00-00 00:00:00', NULL, '2014-11-12 08:04:47', NULL),
(2, 2, '', 'gh', '2014-11-12 22:00:00', NULL, '2014-11-12 08:39:46', NULL);

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
  `trans_end` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `teaching`
--

CREATE TABLE IF NOT EXISTS `teaching` (
`id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `musician_id` int(10) NOT NULL,
  `instrument_id` int(10) NOT NULL,
  `valid_start` timestamp NULL DEFAULT NULL,
  `valid_end` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('admin','student','secretary','') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Άδειασμα δεδομένων του πίνακα `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `type`) VALUES
(1, 'admin', 'admin', 'admin'),
(2, 'student', 'student', 'student'),
(3, 'secretary', 'secretary', 'secretary'),
(4, 'thanos269', '$2y$10$igOyCQKd6mX5b6w9xgnwJeEVY', 'admin');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `instrument`
--
ALTER TABLE `instrument`
 ADD PRIMARY KEY (`id`);

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
 ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `instrument`
--
ALTER TABLE `instrument`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `musician`
--
ALTER TABLE `musician`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT για πίνακα `student`
--
ALTER TABLE `student`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `teaching`
--
ALTER TABLE `teaching`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `user`
--
ALTER TABLE `user`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
