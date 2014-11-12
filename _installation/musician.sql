-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: localhost
-- Χρόνος δημιουργίας: 12 Νοε 2014 στις 14:49:46
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
-- Δομή πίνακα για τον πίνακα `musician`
--

CREATE TABLE IF NOT EXISTS `musician` (
`id` int(10) NOT NULL,
  `musician_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `salary` float NOT NULL,
  `valid_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `valid_end` timestamp NULL DEFAULT NULL,
  `trans_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_end` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Άδειασμα δεδομένων του πίνακα `musician`
--

INSERT INTO `musician` (`id`, `musician_id`, `name`, `telephone`, `salary`, `valid_start`, `valid_end`, `trans_start`, `trans_end`) VALUES
(1, 2, 'ghc', 'gh', 456, '0000-00-00 00:00:00', NULL, '2014-11-12 08:04:47', NULL),
(2, 2, '', 'gh', 0, '2014-11-12 22:00:00', NULL, '2014-11-12 08:39:46', NULL);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `musician`
--
ALTER TABLE `musician`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `musician`
--
ALTER TABLE `musician`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
