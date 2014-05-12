-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 11, 2014 at 11:06 PM
-- Server version: 5.6.16
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `imdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cast_info`
--

CREATE TABLE IF NOT EXISTS `cast_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `person_role_id` int(11) DEFAULT NULL,
  `note` text,
  `nr_order` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pid` (`person_id`),
  KEY `idx_mid` (`movie_id`),
  KEY `idx_cid` (`person_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40103075 ;

-- --------------------------------------------------------

--
-- Table structure for table `classi_labels`
--

CREATE TABLE IF NOT EXISTS `classi_labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieid` int(11) NOT NULL,
  `budget` double NOT NULL,
  `genres` int(11) NOT NULL,
  `director` varchar(100) NOT NULL,
  `crewcount` int(11) NOT NULL,
  `label` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=142 ;

-- --------------------------------------------------------

--
-- Table structure for table `comp_cast_type`
--

CREATE TABLE IF NOT EXISTS `comp_cast_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kind` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kind` (`kind`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `info_type`
--

CREATE TABLE IF NOT EXISTS `info_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `info` (`info`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

-- --------------------------------------------------------

--
-- Table structure for table `kind_type`
--

CREATE TABLE IF NOT EXISTS `kind_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kind` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kind` (`kind`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `movie_info`
--

CREATE TABLE IF NOT EXISTS `movie_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_id` int(11) NOT NULL,
  `info_type_id` int(11) NOT NULL,
  `info` text NOT NULL,
  `note` text,
  PRIMARY KEY (`id`),
  KEY `idx_mid` (`movie_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16364539 ;

-- --------------------------------------------------------

--
-- Table structure for table `name`
--

CREATE TABLE IF NOT EXISTS `name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `gender` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`(6))
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4555020 ;

-- --------------------------------------------------------

--
-- Table structure for table `person_info`
--

CREATE TABLE IF NOT EXISTS `person_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `info_type_id` int(11) NOT NULL,
  `info` text NOT NULL,
  `note` text,
  PRIMARY KEY (`id`),
  KEY `idx_pid` (`person_id`),
  KEY `person_info_info_type_id_exists` (`info_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3159076 ;

-- --------------------------------------------------------

--
-- Table structure for table `role_type`
--

CREATE TABLE IF NOT EXISTS `role_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `title`
--

CREATE TABLE IF NOT EXISTS `title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `kind_id` int(11) NOT NULL,
  `production_year` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`(10)),
  KEY `title_kind_id_exists` (`kind_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2804771 ;

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE IF NOT EXISTS `usertable` (
  `username` varchar(100) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemid` int(11) NOT NULL,
  `itemname` varchar(100) NOT NULL,
  `type` int(2) NOT NULL,
  `rate` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=141 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cast_info`
--
ALTER TABLE `cast_info`
  ADD CONSTRAINT `cast_info_person_id_exists` FOREIGN KEY (`person_id`) REFERENCES `name` (`id`);

--
-- Constraints for table `person_info`
--
ALTER TABLE `person_info`
  ADD CONSTRAINT `person_info_info_type_id_exists` FOREIGN KEY (`info_type_id`) REFERENCES `info_type` (`id`),
  ADD CONSTRAINT `person_info_person_id_exists` FOREIGN KEY (`person_id`) REFERENCES `name` (`id`);

--
-- Constraints for table `title`
--
ALTER TABLE `title`
  ADD CONSTRAINT `title_kind_id_exists` FOREIGN KEY (`kind_id`) REFERENCES `kind_type` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
