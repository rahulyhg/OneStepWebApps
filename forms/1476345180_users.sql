-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2016 at 01:29 PM
-- Server version: 5.1.53
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `onestep`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `last_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `gender` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `phonenumber` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `address` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `postalcode` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `birth_date` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `country` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `state` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `city` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `staus` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `gender`, `phonenumber`, `address`, `postalcode`, `birth_date`, `country`, `state`, `city`, `staus`) VALUES
(1, 'siddharth', 'divetiya', 'siddivetiya@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'male', '7778855759', 'surat', '395010', '25/7/1994', 'india', 'gujarat', 'surat', 1),
(2, 'nehal', 'jariwala', 'nehaljariwala324@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'male', '9727334166', 'Kharvarnagar', '395002', '13/12/1993', 'india', 'gujarat', 'surat', 0),
(4, 'nehal', 'jariwala', 'nehaljariwala32@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'male', '9727334168', 'Kharvarnagar', '395002', '13/12/1993', 'india', 'gujarat', 'surat', 0);
