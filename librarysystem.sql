-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2025 at 08:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `librarysystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `BookId` varchar(50) NOT NULL,
  `BookTitle` varchar(100) NOT NULL,
  `Author` varchar(255) NOT NULL,
  `Accession` varchar(6) NOT NULL,
  `Quantity` int(100) NOT NULL,
  `Available` int(100) NOT NULL,
  `IsFeatured` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`BookId`, `BookTitle`, `Author`, `Accession`, `Quantity`, `Available`, `IsFeatured`) VALUES
('47229d02509e16f88570', 'Mineral', 'Jairuz Lavilla', '102030', 10, 10, 1),
('ad5af5fc386f79f06d64', 'Wild Rift', 'Jadriene Lavilla', '029492', 20, 20, 1),
('dd22f204106c0513e86a', 'Valorant', 'Jairuz Lavilla', '123152', 23, 22, 1),
('dfbea854e47f93bcce74', 'Jollibee', 'Jadriene', '103045', 20, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `borrowhistory`
--

CREATE TABLE `borrowhistory` (
  `TransactionId` varchar(50) NOT NULL,
  `BorrowerFirstName` varchar(50) NOT NULL,
  `BorrowerLastName` varchar(50) NOT NULL,
  `BookBorrowed` varchar(50) NOT NULL,
  `DateBorrowed` date NOT NULL,
  `DateToReturn` date NOT NULL,
  `DateReturned` date NOT NULL,
  `Status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finemanagement`
--

CREATE TABLE `finemanagement` (
  `TransactionId` varchar(100) NOT NULL,
  `FineCost` int(11) NOT NULL,
  `FinePaid` int(11) NOT NULL,
  `DateOfPayment` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

CREATE TABLE `userprofile` (
  `UserId` varchar(50) NOT NULL,
  `StudentId` varchar(50) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `Grade` varchar(50) NOT NULL,
  `Section` varchar(50) NOT NULL,
  `Adviser` varchar(100) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `ContactNumber` varchar(10) NOT NULL,
  `Password` varchar(999) NOT NULL,
  `Role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`UserId`, `StudentId`, `FirstName`, `LastName`, `Grade`, `Section`, `Adviser`, `Email`, `ContactNumber`, `Password`, `Role`) VALUES
('6ff6696f6cf1c0f01609', '10239945', 'superadmin', 'superadmin', '', '', '', 'superadmin@gmail.com', '', '$2y$10$Rd1JgeMEB.NxYL4Gn8wWV.qGnZsNQ/87VVbcWGLQszuycdQoFZVSS', 'superadmin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`BookId`);

--
-- Indexes for table `borrowhistory`
--
ALTER TABLE `borrowhistory`
  ADD PRIMARY KEY (`TransactionId`);

--
-- Indexes for table `finemanagement`
--
ALTER TABLE `finemanagement`
  ADD PRIMARY KEY (`TransactionId`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
