-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2022 at 11:35 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinechat`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@admin.com', 'admin'),
(2, 'nikul', 'nik@admin.com', 'nikadmin'),
(3, 'abc', 'abc@admin.com', 'abcadmin');

-- --------------------------------------------------------

--
-- Table structure for table `blockeduser`
--

CREATE TABLE `blockeduser` (
  `id` int(11) NOT NULL,
  `blockedby` int(11) NOT NULL,
  `blocked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msgid` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL,
  `time` varchar(20) NOT NULL,
  `msg_status` varchar(10) NOT NULL DEFAULT 'unseen',
  `senderclear` int(11) NOT NULL DEFAULT 0,
  `receiverclear` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msgid`, `sender_id`, `receiver_id`, `message`, `date`, `time`, `msg_status`, `senderclear`, `receiverclear`) VALUES
(52, 9, 6, 'hi', '2022-09-27', '09:06 AM', 'seen', 0, 1),
(56, 6, 9, 'hi', '2022-09-27', '11:28 AM', 'unseen', 1, 0),
(57, 6, 9, 'hi', '2022-09-27', '11:30 AM', 'unseen', 1, 0),
(58, 6, 9, 'hi', '2022-09-27', '11:31 AM', 'unseen', 1, 0),
(59, 6, 9, 'hi', '2022-09-27', '03:03 PM', 'unseen', 1, 0),
(60, 6, 9, 'hi', '2022-09-27', '03:03 PM', 'unseen', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'image/profileimg/profiledef.png',
  `status` varchar(15) NOT NULL DEFAULT 'offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `name`, `email`, `password`, `image`, `status`) VALUES
(6, 'abc', 'abc@user.com', 'abcusers', 'image/profileimg/profiledef.png', 'online'),
(7, 'xyz', 'xyz@user.com', 'xyzusers', 'image/profileimg/profiledef.png', 'offline'),
(8, 'pqr', 'pqr@user.com', 'pqrusers', 'image/profileimg/profiledef.png', 'offline'),
(9, 'Nikul', 'nik@user.com', 'nikusers', 'image/profileimg/166228380412577.jpg', 'offline'),
(10, 'Mno', 'mno@user.com', 'mnousers', 'image/profileimg/166227848135453_2d74ca950a3ad2a190efdc53d3d93097.jpg', 'offline');

-- --------------------------------------------------------

--
-- Table structure for table `userstatus`
--

CREATE TABLE `userstatus` (
  `id` int(11) NOT NULL,
  `mainuser` int(11) NOT NULL,
  `otheruser` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userstatus`
--

INSERT INTO `userstatus` (`id`, `mainuser`, `otheruser`, `status`) VALUES
(1, 9, 6, 'null'),
(2, 6, 9, 'null'),
(3, 10, 6, 'null'),
(4, 6, 10, 'null');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `blockeduser`
--
ALTER TABLE `blockeduser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msgid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `userstatus`
--
ALTER TABLE `userstatus`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blockeduser`
--
ALTER TABLE `blockeduser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `userstatus`
--
ALTER TABLE `userstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
