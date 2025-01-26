-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2025 at 10:39 AM
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
  `Category` varchar(100) NOT NULL,
  `IsFeatured` tinyint(1) NOT NULL,
  `Description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`BookId`, `BookTitle`, `Author`, `Accession`, `Quantity`, `Available`, `Category`, `IsFeatured`, `Description`) VALUES
('1', 'The Great Adventure', 'John Doe', 'A1001', 10, 10, 'Fiction', 0, 'A thrilling journey through unknown lands.'),
('10', 'The Art of War', 'Sun Tzu', 'A1010', 20, 20, 'Classic', 0, 'The timeless treatise on strategy and warfare.'),
('11', 'Adventures in the Wild', 'Brian Martin', 'A1011', 11, 11, 'Adventure', 0, 'Surviving the harshest conditions in nature.'),
('12', 'In the Shadows', 'Clara Johnson', 'A1012', 3, 3, 'Horror', 0, 'A chilling tale of the unknown lurking nearby.'),
('13', 'The City of Dreams', 'Lucas Harper', 'A1013', 18, 18, 'Fiction', 0, 'The journey of a man to create the perfect city.'),
('14', 'The Garden of Secrets', 'Laura Adams', 'A1014', 10, 10, 'Drama', 0, 'A family drama unfolding over generations.'),
('15', 'Quantum Leap', 'Richard Clarke', 'A1015', 5, 5, 'Science fiction', 0, 'Time travel and the consequences of changing history.'),
('16', 'Ocean\'s Call', 'Diana Miller', 'A1016', 14, 14, 'Romance', 0, 'A story of love set against the backdrop of the sea.'),
('17', 'The Last Defender', 'Thomas Scott', 'A1017', 6, 6, 'Fantasy', 0, 'The final battle for the last free city.'),
('18', 'Journey to the Center of the Earth', 'Jules Verne', 'A1018', 25, 25, 'Classic', 0, 'An expedition into the depths of our planet.'),
('19', 'The Mystery of the Missing Crown', 'Sophie Clarke', 'A1019', 13, 13, 'Mystery', 0, 'A royal crown is missing, and a detective is on the case.'),
('2', 'Mysteries of the Deep', 'Jane Smith', 'A1002', 8, 8, 'Mystery', 0, 'A gripping mystery set in the heart of the sea.'),
('20', 'The Forgotten Tomb', 'Eric Thomas', 'A1020', 7, 7, 'Thriller', 0, 'A tomb is unearthed, revealing deadly secrets.'),
('3', 'A Love Rekindled', 'Emily Watson', 'A1003', 5, 5, 'Romance', 0, 'A heartwarming story of second chances.'),
('4', 'Science Unveiled', 'Michael Brown', 'A1004', 12, 12, 'Non-fiction', 0, 'A deep dive into the wonders of modern science.'),
('5', 'The Last Kingdom', 'Alexander Grey', 'A1005', 6, 6, 'Fantasy', 0, 'The rise of a lost civilization.'),
('6', 'Culinary Wonders', 'Sarah Green', 'A1006', 15, 15, 'Cooking', 0, 'A collection of delicious recipes from around the world.'),
('7', 'Beyond the Stars', 'David White', 'A1007', 9, 9, 'Science fiction', 0, 'A space exploration tale of humanity\'s future.'),
('8', 'Whispers of the Past', 'Olivia Brooks', 'A1008', 7, 7, 'Historical', 0, 'Uncovering secrets buried in history.'),
('9', 'The Silent War', 'William Harris', 'A1009', 4, 4, 'Thriller', 0, 'A secret conflict threatens global peace.');

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
-- Table structure for table `loginaudit`
--

CREATE TABLE `loginaudit` (
  `ActionId` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `LoginDate` varchar(30) DEFAULT NULL,
  `LogoutDate` varchar(30) DEFAULT NULL,
  `IsLoggedOut` tinyint(1) NOT NULL
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
('6ff6696f6cf1c0f01609', '', 'superadmin', 'superadmin', '', '', '', 'superadmin@gmail.com', '', '$2y$10$Rd1JgeMEB.NxYL4Gn8wWV.qGnZsNQ/87VVbcWGLQszuycdQoFZVSS', 'superadmin');

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
-- Indexes for table `loginaudit`
--
ALTER TABLE `loginaudit`
  ADD PRIMARY KEY (`ActionId`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
