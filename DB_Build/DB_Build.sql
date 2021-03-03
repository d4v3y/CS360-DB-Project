-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 21, 2021 at 08:09 PM
-- Server version: 10.5.8-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db2`
--

-- --------------------------------------------------------

--
-- Table structure for table `Drugs`
--

CREATE TABLE IF NOT EXISTS `Drugs` (
  `Drug ID` int(10) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Type` varchar(100) NOT NULL,
  PRIMARY KEY (`Drug ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Insurance`
--

CREATE TABLE IF NOT EXISTS `Insurance` (
  `Patient ID` int(10) NOT NULL,
  `Insurance ID` int(10) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Annual Premium` int(6) NOT NULL,
  `Annual Deductible` int(4) NOT NULL,
  `Coverage` varchar(3) NOT NULL,
  `Lifetime Coverage` int(9) NOT NULL,
  PRIMARY KEY (`Patient ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Interactions`
--

CREATE TABLE IF NOT EXISTS `Interactions` (
  `Interaction ID` int(10) NOT NULL,
  `Drug ID` int(10) NOT NULL,
  `Patient ID` int(10) NOT NULL,
  `Symptoms` varchar(40) NOT NULL,
  PRIMARY KEY (`Interaction ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Lab`
--

CREATE TABLE IF NOT EXISTS `Lab` (
  `Lab ID` int(10) NOT NULL,
  `Insurance ID` int(10) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `cost` int(6) NOT NULL,
  `copay` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Medication`
--

CREATE TABLE IF NOT EXISTS `Medication` (
  `Drug ID` int(10) NOT NULL,
  `Insurance ID` int(10) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Cost` int(6) NOT NULL,
  `Co-pay` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Patients`
--

CREATE TABLE IF NOT EXISTS `Patients` (
  `Patient ID` int(10) NOT NULL,
  `Name` char(25) NOT NULL,
  `Age` int(3) NOT NULL,
  `Annual Income` int(7) NOT NULL,
  `SSN` int(9) NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` varchar(20) NOT NULL,
  `ZIP` int(5) NOT NULL,
  `Insurance ID` int(10) NOT NULL,
  `Pharmacy ID` int(10) NOT NULL,
  PRIMARY KEY (`Patient ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Pharmacy`
--

CREATE TABLE IF NOT EXISTS `Pharmacy` (
  `Pharmacy ID` int(10) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `City` varchar(40) NOT NULL,
  `State` varchar(40) NOT NULL,
  'Zip'   varchar(40) NOT NULL,
  PRIMARY KEY (`Pharmacy ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Provider`
--

CREATE TABLE IF NOT EXISTS `Provider` (
  `Provider ID` int(10) NOT NULL,
  `Insurance ID` int(10) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Cost` int(6) NOT NULL,
  `Co-Pay` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Purchases`
--

CREATE TABLE IF NOT EXISTS `Purchases` (
  `Purchase ID` int(10) NOT NULL,
  'Pharmacy ID' int(10) NOT NULL,
  `Patient ID` int(10) NOT NULL,
  `Drug ID` int(10) NOT NULL,
  `Quantity` int(3) NOT NULL,
  `Cost` varchar(6) NOT NULL,
  `Insurance ID` int(10) NOT NULL,
  `Referral ID` int(10) NOT NULL,
  `Interaction ID` int(10) NOT NULL,
  PRIMARY KEY (`Purchase ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
