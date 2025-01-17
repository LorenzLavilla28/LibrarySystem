-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2025 at 02:21 AM
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
('ad5af5fc386f79f06d64', 'Wild Rift', 'Jadriene Lavilla', '029492', 20, 0, 1),
('d4f5cf9974e6e0ff60a0', 'HoK', 'Jairuz Lavilla', '102312', 32, 32, 0),
('dd22f204106c0513e86a', 'Valorant', 'Jairuz Lavilla', '123152', 23, 23, 1);

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
  `Email` varchar(50) NOT NULL,
  `ContactNumber` varchar(10) NOT NULL,
  `Password` varchar(999) NOT NULL,
  `Role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`UserId`, `StudentId`, `FirstName`, `LastName`, `Email`, `ContactNumber`, `Password`, `Role`) VALUES
('16a6d1c1cbe97a5d15b5', '23232323', 'Lorenz', 'Lavilla', 'jairuzlavilla@gmail.com', '9304922930', '$2y$10$/1H5/g2az7aCGSjgpdiWgu1q8n1astfYIs8r0BB2lLkpqrHTlP2Uq', 'Student'),
('6ff6696f6cf1c0f01609', '10239945', 'superadmin', 'superadmin', 'superadmin@gmail.com', '', '$2y$10$Rd1JgeMEB.NxYL4Gn8wWV.qGnZsNQ/87VVbcWGLQszuycdQoFZVSS', 'superadmin'),
('7684b90eb12b12e9064d', '', 'Lorenz', 'Lavilla', 'lorenzlavilla28@gmail.com', '', '$2y$10$ckgb.LI9v2gZ/2ikQ.c8Xu54GWgaMNu4Eg93BoLCGcSEgPvHMnwkK', 'Admin'),
('8952b410583227b368c0', '', 'Lorenz Joseph', 'Lavilla', 'testest@gmail.comm', '', '$2y$10$1vi8R6DbapK/.2Tgy8pDaeieOQOVMq14OMjAeGZmN3nK7h6jByAdK', 'Admin');

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
