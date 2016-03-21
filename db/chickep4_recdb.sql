-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 24, 2015 at 04:51 PM
-- Server version: 5.5.42-37.1-log
-- PHP Version: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chickep4_recdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

DROP TABLE IF EXISTS `albums`;
CREATE TABLE IF NOT EXISTS `albums` (
  `albumId` smallint(9) NOT NULL AUTO_INCREMENT,
  `nameTxt` varchar(100) NOT NULL,
  `artistId` smallint(9) NOT NULL,
  PRIMARY KEY (`albumId`),
  UNIQUE KEY `nameTxt` (`nameTxt`),
  KEY `artistId` (`artistId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`albumId`, `nameTxt`, `artistId`) VALUES
(1, 'The Beatles (White Album)', 1),
(2, 'Revolver', 1),
(3, 'Magpie and the Dandelion', 2),
(4, 'Atlas:  Year One', 3);

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

DROP TABLE IF EXISTS `artists`;
CREATE TABLE IF NOT EXISTS `artists` (
  `artistId` smallint(9) NOT NULL AUTO_INCREMENT,
  `nameTxt` varchar(100) NOT NULL,
  PRIMARY KEY (`artistId`),
  UNIQUE KEY `nameTxt` (`nameTxt`),
  UNIQUE KEY `nameTxt_2` (`nameTxt`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artistId`, `nameTxt`) VALUES
(1, 'The Beatles'),
(2, 'The Avett Brothers'),
(3, 'Sleeping At Last');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

DROP TABLE IF EXISTS `songs`;
CREATE TABLE IF NOT EXISTS `songs` (
  `songId` smallint(9) NOT NULL AUTO_INCREMENT,
  `nameTxt` varchar(100) NOT NULL,
  `albumId` smallint(9) NOT NULL,
  PRIMARY KEY (`songId`),
  UNIQUE KEY `nameTxt` (`nameTxt`),
  KEY `albumId` (`albumId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`songId`, `nameTxt`, `albumId`) VALUES
(1, 'Dear Prudence', 1),
(2, 'Martha My Dear', 1),
(3, 'I''m So Tired', 1),
(4, 'I Will', 1),
(5, 'Mother Nature''s Son', 1),
(6, 'I''m Only Sleeping', 2),
(7, 'Here, There and Everywhere', 2),
(8, 'For No One', 2),
(9, 'Another Is Waiting', 3),
(10, 'I''ll Keep You Safe', 4);

-- --------------------------------------------------------

--
-- Table structure for table `userFavAlbums`
--

DROP TABLE IF EXISTS `userFavAlbums`;
CREATE TABLE IF NOT EXISTS `userFavAlbums` (
  `userFavAlbumId` smallint(9) NOT NULL AUTO_INCREMENT,
  `userId` smallint(9) NOT NULL,
  `albumId` smallint(9) NOT NULL,
  PRIMARY KEY (`userFavAlbumId`),
  KEY `userId` (`userId`,`albumId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `userFavAlbums`
--

INSERT INTO `userFavAlbums` (`userFavAlbumId`, `userId`, `albumId`) VALUES
(1, 1, 2),
(2, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `userFavArtists`
--

DROP TABLE IF EXISTS `userFavArtists`;
CREATE TABLE IF NOT EXISTS `userFavArtists` (
  `userFavArtistId` smallint(9) NOT NULL AUTO_INCREMENT,
  `userId` smallint(9) NOT NULL,
  `artistId` smallint(9) NOT NULL,
  PRIMARY KEY (`userFavArtistId`),
  KEY `userId` (`userId`,`artistId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `userFavArtists`
--

INSERT INTO `userFavArtists` (`userFavArtistId`, `userId`, `artistId`) VALUES
(1, 1, 1),
(2, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `userFavSongs`
--

DROP TABLE IF EXISTS `userFavSongs`;
CREATE TABLE IF NOT EXISTS `userFavSongs` (
  `userFavSongId` smallint(9) NOT NULL AUTO_INCREMENT,
  `userId` smallint(9) NOT NULL,
  `songId` smallint(9) NOT NULL,
  PRIMARY KEY (`userFavSongId`),
  KEY `userId` (`userId`,`songId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `userFavSongs`
--

INSERT INTO `userFavSongs` (`userFavSongId`, `userId`, `songId`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 5),
(4, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` smallint(9) NOT NULL AUTO_INCREMENT,
  `emailTxt` varchar(255) NOT NULL,
  `passwordTxt` varchar(32) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `email` (`emailTxt`),
  UNIQUE KEY `email_2` (`emailTxt`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Used to store userids and passwords' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `emailTxt`, `passwordTxt`) VALUES
(1, 'mckneisler@hotmail.com', 'd966844d797a229a3775c9f4f8535aae');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
