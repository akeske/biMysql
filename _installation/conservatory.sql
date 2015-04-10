SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `conservatory` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `conservatory`;

DROP TABLE IF EXISTS `audit`;
CREATE TABLE IF NOT EXISTS `audit` (
`id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `table_name` enum('instrument','musician','student','teaching','register','login','logout') NOT NULL,
  `query` mediumblob NOT NULL,
  `trans_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `instrument`;
CREATE TABLE IF NOT EXISTS `instrument` (
`instrument_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_start` timestamp NULL DEFAULT NULL,
  `trans_end` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `musician`;
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `student`;
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `teaching`;
CREATE TABLE IF NOT EXISTS `teaching` (
`id` int(10) NOT NULL,
  `teaching_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `musician_id` int(10) NOT NULL,
  `instrument_id` int(10) NOT NULL,
  `valid_start` timestamp NULL DEFAULT NULL,
  `valid_end` timestamp NULL DEFAULT NULL,
  `read_level` set('student','admin','secretary','') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` set('admin','secretary','student','musician') COLLATE utf8_unicode_ci NOT NULL,
  `is_enable` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`id`, `name`, `password`, `type`, `is_enable`) VALUES
(0, 'admin', '$2y$10$M4Zhdz.hkQCInV.TmSOJQurh0en983EpN4BnR0p0YJa4Pi3gNaqYq', 'admin', 'true');


ALTER TABLE `audit`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `instrument`
 ADD PRIMARY KEY (`instrument_id`);

ALTER TABLE `musician`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `student`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `teaching`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);


ALTER TABLE `audit`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `instrument`
MODIFY `instrument_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `musician`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `student`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `teaching`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
