-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 11:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `addressID` int(10) NOT NULL,
  `userInfoID` int(10) NOT NULL,
  `cityID` int(10) NOT NULL,
  `provinceID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `cityID` int(10) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `closefriends`
--

CREATE TABLE `closefriends` (
  `closeFriendID` int(10) NOT NULL,
  `ownerID` int(10) NOT NULL,
  `userID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(10) NOT NULL,
  `dateTime` varchar(20) NOT NULL,
  `content` varchar(50) NOT NULL,
  `userID` int(10) NOT NULL,
  `postID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friendID` int(10) NOT NULL,
  `requesterID` int(10) NOT NULL,
  `requesteeID` int(10) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gcmembers`
--

CREATE TABLE `gcmembers` (
  `gcMemberID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `groupChatID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groupchats`
--

CREATE TABLE `groupchats` (
  `groupChatID` int(10) NOT NULL,
  `adminID` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `picture` varchar(30) NOT NULL,
  `theme` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message` varchar(100) NOT NULL,
  `senderID` int(10) NOT NULL,
  `receiverID` int(10) NOT NULL,
  `dateTime` varchar(20) NOT NULL,
  `isRead` varchar(5) NOT NULL,
  `status` varchar(10) NOT NULL,
  `attachment` varchar(100) NOT NULL,
  `groupChatID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `content` varchar(50) NOT NULL,
  `dateTime` varchar(20) NOT NULL,
  `privacy` varchar(20) NOT NULL,
  `isDeleted` varchar(10) NOT NULL,
  `attachment` varchar(50) NOT NULL,
  `cityID` int(10) NOT NULL,
  `provinceID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `userID`, `content`, `dateTime`, `privacy`, `isDeleted`, `attachment`, `cityID`, `provinceID`) VALUES
(1, 1, 'do u like meshi', '2024-10-28 13:30:45', 'public', '0', 'images/img1.jpg', 1, 1),
(2, 2, 'skyyy :)', '2024-10-28 14:11:15', 'public', '0', 'images/img2.jpg', 1, 1),
(3, 3, '.p spicy by aespa', '2024-10-28 14:42:23', 'public', '0', 'images/img3.jpg', 2, 1),
(4, 4, 'wassupp', '2024-10-28 15:12:31', 'public', '0', 'images/img4.jpg', 1, 1),
(5, 5, 'outer whattt?', '2024-10-28 15:31:10', 'public', '0', 'images/img5.jpg', 3, 1),
(6, 6, 'he sleepy ', '2024-10-28 15:42:45', 'public', '0', 'images/img6.jpg', 1, 1),
(7, 7, 'who is this DIVA', '2024-10-28 16:12:33', 'public', '0', 'images/img7.jpg', 2, 1),
(8, 8, 'my mood rn', '2024-10-28 16:51:03', 'public', '0', 'images/img8.jpg', 3, 1),
(9, 9, 'dose of the day', '2024-10-28 16:51:03', 'public', '0', 'images/img9.jpg', 2, 1),
(10, 10, 'slayyy', '2024-10-28 17:11:28', 'public', '0', 'images/img10.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `provinceID` int(10) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `reactionID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `postID` int(10) NOT NULL,
  `kind` varchar(20) NOT NULL,
  `commentID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `userInfoID` int(10) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `birthDay` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(9) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `userInfoID` int(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phoneNumber` varchar(12) NOT NULL,
  `willRemember` varchar(5) NOT NULL,
  `isOnline` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userInfoID`, `password`, `email`, `phoneNumber`, `willRemember`, `isOnline`) VALUES
(1, 'strawberryjamm', 1, 'strawberryjamm', 'strawberryjamm43@gmail.com', '09123456789', '1', '0'),
(2, 'nayeonnnzzzz', 2, 'nayeonnnzzzz', 'nayeonnnzzzz@gmail.com', '09223456789', '1', '0'),
(3, 'yoodonote', 3, 'yoodonote', 'yoodonote0_0@gmail.com', '09323456789', '1', '0'),
(4, 'mamamomoo', 4, 'mamamomoo', 'mamamomoo@gmail.com', '09423456789', '1', '0'),
(5, 'markyyerr', 5, 'markyyerr', 'markyyerr123@gmail.com', '09523456789', '1', '0'),
(6, 'jaehyundontgo', 6, 'jaehyundontgo', 'jaehyundontgo34@gmail.com', '09623456789', '1', '0'),
(7, 'ajuniceeex0x0', 7, 'ajuniceeex0x0', 'ajuniceeex0x0@gmail.com', '09723456789', '1', '0'),
(8, 'migzzzzDK', 8, 'migzzzzDK', 'migzzzzDK@gmail.com', '09823456789', '1', '0'),
(9, 'riiiality', 9, 'riiiality', 'riiiality123@gmail.com', '09923456789', '1', '1'),
(10, 'billTHEgates', 10, 'billTHEgates', 'billTHEgates@gmail.com', '09023456789', '1', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
