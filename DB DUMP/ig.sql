-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 24, 2013 at 12:07 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ig`
--

-- --------------------------------------------------------

--
-- Table structure for table `columnblocks`
--

CREATE TABLE IF NOT EXISTS `columnblocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(55) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `columnblocks`
--

INSERT INTO `columnblocks` (`id`, `Name`, `order`) VALUES
(1, 'News', 0),
(3, 'Comics', 0),
(4, 'Local', 0);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moduleType` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `moduleType`, `parent`, `order`) VALUES
(1, 1, 1, 1),
(2, 1, 4, 0),
(3, 2, 4, 0),
(5, 1, 1, 0),
(6, 1, 3, 0),
(7, 1, 3, 0),
(8, 1, 3, 0),
(9, 1, 1, 0),
(10, 1, 1, 0),
(11, 1, 1, 0),
(12, 1, 1, 0),
(13, 1, 1, 0),
(14, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `newsfeed`
--

CREATE TABLE IF NOT EXISTS `newsfeed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedName` varchar(45) NOT NULL,
  `feedUrl` varchar(150) NOT NULL,
  `numArticles` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `newsfeed`
--

INSERT INTO `newsfeed` (`id`, `feedName`, `feedUrl`, `numArticles`) VALUES
(1, 'GizModo', 'http://www.gizmodo.com/index.xml', 10),
(5, 'Life Hacker', 'http://lifehacker.com/index.xml', 10),
(6, 'Cyanide and Happiness', 'http://feeds.feedburner.com/Explosm', 5),
(7, 'Dilbert', 'http://feed.dilbert.com/dilbert/daily_strip', 5),
(8, 'XKCD', 'http://xkcd.com/rss.xml', 5),
(9, 'Engadget', 'http://www.engadget.com/rss.xml', 10),
(10, 'Techdirt', 'http://feeds.feedburner.com/techdirt/feed', 10),
(11, 'Slashdot', 'http://rss.slashdot.org/Slashdot/slashdot', 10),
(12, 'Inventorspot', 'http://feeds.feedburner.com/inventorspot/articles', 5),
(13, 'College Humor', 'http://www.collegehumor.com/originals/rss', 5),
(14, 'Onion News', 'http://www.theonion.com/feeds/onn/', 5);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`id`, `note`) VALUES
(1, 'Put Notes Here!');

-- --------------------------------------------------------

--
-- Table structure for table `weather`
--

CREATE TABLE IF NOT EXISTS `weather` (
  `moduleId` int(11) NOT NULL AUTO_INCREMENT,
  `GeoCode` varchar(20) NOT NULL,
  PRIMARY KEY (`moduleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `weather`
--

INSERT INTO `weather` (`moduleId`, `GeoCode`) VALUES
(3, 'CAXX0181');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
