-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: localhost
-- Χρόνος δημιουργίας: 17 Νοε 2014 στις 00:41:57
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
-- Δομή πίνακα για τον πίνακα `instrument`
--

CREATE TABLE IF NOT EXISTS `instrument` (
`id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_start` timestamp NULL DEFAULT NULL,
  `trans_end` timestamp NULL DEFAULT NULL
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
  `trans_end` timestamp NULL DEFAULT NULL,
  `read_level` set('admin','secretary','student','') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=66 ;

--
-- Άδειασμα δεδομένων του πίνακα `musician`
--

INSERT INTO `musician` (`id`, `musician_id`, `name`, `telephone`, `valid_start`, `valid_end`, `trans_start`, `trans_end`, `read_level`) VALUES
(61, 1, 'thanos', '0000', '2012-10-31 22:00:00', NULL, '2014-11-16 23:35:59', '2014-11-16 22:36:11', 'admin'),
(62, 1, 'thanos', '0000', '2012-10-31 22:00:00', '2014-09-30 21:00:00', '2014-11-16 22:36:11', NULL, 'admin'),
(63, 1, 'thanos', '1111', '2013-10-31 22:00:00', NULL, '2014-11-16 23:36:11', '2014-11-16 22:37:14', 'admin'),
(64, 1, 'thanos', '1111', '2013-10-31 22:00:00', '2014-07-31 21:00:00', '2014-11-16 22:37:14', NULL, 'admin'),
(65, 1, 'thanos', '2222', '2014-07-31 21:00:00', NULL, '2014-11-16 23:37:14', NULL, 'admin,secretary,student');

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
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('admin','student','secretary') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Άδειασμα δεδομένων του πίνακα `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `type`) VALUES
(6, 'admin', '$2y$10$AY9M2OlmkVrdL/ZBX7gYzeolScaQWSxIyREYXm1EFVe.XWfRGNbMa', 'admin'),
(7, 'student', '$2y$10$0nZC/iB7LSRMW6a4k5GqC.awyg..y98pwS6xY9HVaOYbZAUMBTXX2', 'student'),
(11, 'secretary', '$2y$10$aqzatK6.Vc4VyiKt.2B/N.EsjrPsLzrLX5HQJ3Gm88U.qKsaZEAgG', 'secretary');

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
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
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
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
