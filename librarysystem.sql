-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 10:14 PM
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
('8faffd0d-da97-11ef-bed1-10ffe0425a46', 'The Silent Echoes', 'Jane Doe', 'ACC123', 10, 5, 'Fiction', 1, 'A gripping tale of love and loss that echoes through time.'),
('8fb00841-da97-11ef-bed1-10ffe0425a46', 'The Mindful Path', 'John Smith', 'ACC124', 8, 4, 'Non-Fiction', 0, 'Discover the power of mindfulness and meditation to transform your life.'),
('8fb00899-da97-11ef-bed1-10ffe0425a46', 'Quantum Dreams', 'Alice Walker', 'ACC125', 12, 6, 'Science', 1, 'Explore the boundaries of reality and imagination in this mind-bending scientific journey.'),
('8fb008b4-da97-11ef-bed1-10ffe0425a46', 'Shadows of the Past', 'Mark Bennett', 'ACC126', 6, 3, 'History', 0, 'A compelling historical fiction set against the backdrop of a lost civilization.'),
('8fb008c5-da97-11ef-bed1-10ffe0425a46', 'Whispers of the Soul', 'Emily Hart', 'ACC127', 15, 8, 'Biography', 1, 'The untold story of a woman who inspired generations with her strength and resilience.'),
('8fb008d7-da97-11ef-bed1-10ffe0425a46', 'The Coded Key', 'David Lee', 'ACC128', 9, 7, 'Mystery', 0, 'A detective unravels a cryptic puzzle that could change the fate of the world.'),
('8fb008ea-da97-11ef-bed1-10ffe0425a46', 'Beneath the Stars', 'Sarah Lewis', 'ACC129', 11, 6, 'Fantasy', 1, 'A young mage embarks on an epic journey to save a kingdom lost in time.'),
('8fb008fb-da97-11ef-bed1-10ffe0425a46', 'Echoes of the Night', 'Daniel Rivers', 'ACC130', 14, 7, 'Horror', 0, 'A chilling tale where the past refuses to stay buried and haunts the living.'),
('8fb0090e-da97-11ef-bed1-10ffe0425a46', 'The Last Stand', 'Carla Hughes', 'ACC131', 10, 5, 'Drama', 1, 'A fierce battle for survival and dignity in the face of overwhelming odds.'),
('8fb0091d-da97-11ef-bed1-10ffe0425a46', 'The Uncharted Waters', 'Matthew Brown', 'ACC132', 13, 6, 'Adventure', 0, 'Set sail on an extraordinary voyage through unexplored realms and forgotten legends.'),
('8fb0092e-da97-11ef-bed1-10ffe0425a46', 'Love’s Unwritten Rules', 'Patricia Clark', 'ACC133', 5, 3, 'Romance', 1, 'A love story that defies the rules and finds its way through unexpected paths.'),
('8fb0093f-da97-11ef-bed1-10ffe0425a46', 'Awaken Your Potential', 'Thomas White', 'ACC134', 8, 4, 'Self-Help', 0, 'Unlock the secrets to achieving your highest potential and living your best life.'),
('8fb0094f-da97-11ef-bed1-10ffe0425a46', 'The Culinary Chronicles', 'Lisa Adams', 'ACC135', 7, 4, 'Cookbook', 1, 'A delicious collection of recipes and stories that celebrate food as an art form.'),
('8fb0095f-da97-11ef-bed1-10ffe0425a46', 'The Philosopher’s Stone', 'James Carter', 'ACC136', 16, 9, 'Philosophy', 0, 'A thought-provoking exploration of the ancient wisdom that still shapes our world today.'),
('8fb00971-da97-11ef-bed1-10ffe0425a46', 'The Road to Wellness', 'Nicole Turner', 'ACC137', 10, 6, 'Health', 1, 'A holistic guide to achieving physical and mental health through balanced living.'),
('8fb00981-da97-11ef-bed1-10ffe0425a46', 'Chronicles of Tomorrow', 'Benjamin Scott', 'ACC138', 11, 7, 'Science Fiction', 0, 'A visionary tale set in a future where technology and humanity collide in dramatic ways.'),
('8fb00992-da97-11ef-bed1-10ffe0425a46', 'Brushstrokes of Life', 'Hannah Wright', 'ACC139', 9, 5, 'Art', 1, 'An artistic journey through the lives of the world’s most influential painters and their masterpieces.'),
('8fb009a6-da97-11ef-bed1-10ffe0425a46', 'The Soul’s Compass', 'Victoria Green', 'ACC140', 13, 8, 'Psychology', 0, 'A deep dive into the human mind and the forces that shape our emotions and behavior.'),
('8fb009b6-da97-11ef-bed1-10ffe0425a46', 'The Champion’s Mindset', 'Chris Ford', 'ACC141', 6, 4, 'Sports', 1, 'A motivational guide to building mental toughness and resilience for success in sports and life.'),
('8fb009c7-da97-11ef-bed1-10ffe0425a46', 'The Sound of Music', 'Anna Mitchell', 'ACC142', 12, 6, 'Music', 0, 'Discover the stories behind iconic music compositions that changed the world.'),
('8fb009da-da97-11ef-bed1-10ffe0425a46', 'Tech Titans', 'Ethan Carter', 'ACC143', 10, 5, 'Technology', 1, 'A fascinating look at the innovators and companies shaping the future of technology.'),
('8fb009e9-da97-11ef-bed1-10ffe0425a46', 'Wanderlust: A Journey', 'Rachel Evans', 'ACC144', 8, 4, 'Travel', 0, 'Pack your bags for an adventure through some of the world’s most exotic destinations.'),
('8fb009fb-da97-11ef-bed1-10ffe0425a46', 'The Educator’s Guide', 'Samantha Harris', 'ACC145', 9, 5, 'Education', 1, 'A comprehensive guide for teachers to inspire and engage students in the modern classroom.'),
('8fb00a0a-da97-11ef-bed1-10ffe0425a46', 'The Art of Business', 'Michael King', 'ACC146', 11, 6, 'Business', 0, 'Strategies for success and innovation in the ever-evolving business world.'),
('8fb00a1a-da97-11ef-bed1-10ffe0425a46', 'Wealth and Wisdom', 'Jessica Moore', 'ACC147', 14, 8, 'Economics', 1, 'A deep dive into the principles that govern wealth creation and financial success.'),
('8fb00a29-da97-11ef-bed1-10ffe0425a46', 'Voices of Change', 'Paul Robinson', 'ACC148', 13, 7, 'Political Science', 0, 'A look at the global leaders and movements that are shaping the future of politics.'),
('8fb00a39-da97-11ef-bed1-10ffe0425a46', 'The Spirit of Faith', 'Laura Evans', 'ACC149', 15, 9, 'Religion', 1, 'A collection of inspiring stories from diverse religious traditions around the world.'),
('8fb00a49-da97-11ef-bed1-10ffe0425a46', 'The Quantum Leap', 'George Daniels', 'ACC150', 10, 6, 'Science', 0, 'An exploration into the world of quantum mechanics and the mysteries of the universe.'),
('8fb00a5a-da97-11ef-bed1-10ffe0425a46', 'The Legal Code', 'Sophia Martin', 'ACC151', 6, 4, 'Law', 1, 'A comprehensive guide to understanding the key legal principles that shape our society.'),
('8fb00a69-da97-11ef-bed1-10ffe0425a46', 'The Literary Legacy', 'David Green', 'ACC152', 8, 5, 'Literature', 0, 'An anthology of literary classics that have shaped the course of history and culture.'),
('8fb00a79-da97-11ef-bed1-10ffe0425a46', 'The Hidden Garden', 'Olivia Brooks', 'ACC153', 11, 7, 'Romance', 1, 'A heartwarming story of love found in the most unexpected of places.'),
('8fb00a88-da97-11ef-bed1-10ffe0425a46', 'Digital Transformation', 'Richard Young', 'ACC154', 14, 8, 'Technology', 0, 'How businesses and individuals are adapting to the digital revolution.'),
('8fb00a97-da97-11ef-bed1-10ffe0425a46', 'The Alchemist’s Secret', 'Gina Clarke', 'ACC155', 10, 5, 'Fantasy', 1, 'A young alchemist uncovers ancient secrets that could change the world forever.'),
('8fb00aa6-da97-11ef-bed1-10ffe0425a46', 'The Darkest Hour', 'Victor Adams', 'ACC156', 9, 6, 'Thriller', 0, 'A race against time to prevent a catastrophe that could destroy everything.'),
('8fb00ab5-da97-11ef-bed1-10ffe0425a46', 'Echoes of Eternity', 'Sophia Turner', 'ACC157', 15, 9, 'Science Fiction', 1, 'A journey across galaxies to uncover the lost truths of an ancient civilization.'),
('8fb00ac4-da97-11ef-bed1-10ffe0425a46', 'The Final Countdown', 'Tom Harris', 'ACC158', 12, 7, 'Adventure', 0, 'A daring expedition to a hidden land where time seems to stand still.'),
('8fb00ad3-da97-11ef-bed1-10ffe0425a46', 'The Weight of Silence', 'Liam Thomas', 'ACC159', 10, 6, 'Drama', 1, 'A moving tale of finding peace in the chaos of life and learning to forgive.'),
('8fb00ae2-da97-11ef-bed1-10ffe0425a46', 'The Eternal City', 'Eva Walker', 'ACC160', 8, 5, 'Historical Fiction', 0, 'A captivating story of love and betrayal set in ancient Rome.'),
('8fb00af1-da97-11ef-bed1-10ffe0425a46', 'Redemption’s Edge', 'James Davis', 'ACC161', 9, 6, 'Thriller', 1, 'A man on the run from his past must confront his deepest fears to survive.'),
('8fb00b01-da97-11ef-bed1-10ffe0425a46', 'The Tides of Change', 'Natalie Young', 'ACC162', 11, 7, 'Drama', 0, 'A coming-of-age story about identity, change, and the power of choice.'),
('8fb00b10-da97-11ef-bed1-10ffe0425a46', 'Whispers in the Dark', 'Megan Clark', 'ACC163', 7, 5, 'Horror', 1, 'A chilling ghost story where the past and present collide in a haunting mystery.'),
('8fb00b1f-da97-11ef-bed1-10ffe0425a46', 'Beyond the Horizon', 'Richard James', 'ACC164', 14, 9, 'Adventure', 0, 'An epic quest to find a new world in a time when all hope is lost.'),
('8fb00b34-da97-11ef-bed1-10ffe0425a46', 'The Edge of Tomorrow', 'Nicole White', 'ACC165', 12, 6, 'Science Fiction', 1, 'In a future dominated by AI, a group of rebels fight for humanity’s survival.'),
('8fb00b67-da97-11ef-bed1-10ffe0425a46', 'Fate’s Design', 'Jenna Martin', 'ACC166', 9, 5, 'Romance', 0, 'A story of destiny, love, and fate intertwined in an impossible romance.'),
('8fb00bbb-da97-11ef-bed1-10ffe0425a46', 'The New World', 'David Carter', 'ACC167', 11, 7, 'Dystopian', 1, 'In a fractured world, a group of survivors fight to rebuild society.'),
('8fb00bcb-da97-11ef-bed1-10ffe0425a46', 'The Time Traveler’s Journal', 'Lily Collins', 'ACC168', 8, 4, 'Science Fiction', 0, 'A young woman discovers a journal from the future and is thrust into a web of time travel and paradoxes.'),
('8fb00bdf-da97-11ef-bed1-10ffe0425a46', 'The Golden Key', 'Isaac King', 'ACC169', 12, 8, 'Fantasy', 1, 'A key to another world is found, unlocking adventures and challenges beyond imagination.'),
('8fb00bef-da97-11ef-bed1-10ffe0425a46', 'The Great Escape', 'Nina Roberts', 'ACC170', 6, 3, 'Thriller', 0, 'A thrilling escape story that will keep you on the edge of your seat until the last page.');

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
