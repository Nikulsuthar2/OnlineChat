-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2022 at 02:46 PM
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
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msgid` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL,
  `time` varchar(20) NOT NULL,
  `msg_status` varchar(10) NOT NULL DEFAULT 'unseen'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msgid`, `sender_id`, `receiver_id`, `message`, `date`, `time`, `msg_status`) VALUES
(9, 9, 10, 'hi', '2022-09-04', '11:34 AM', 'seen'),
(10, 9, 10, 'hello', '2022-09-04', '11:35 AM', 'seen'),
(11, 9, 7, 'hi', '2022-09-04', '11:36 AM', 'unseen'),
(12, 9, 7, 'xyz', '2022-09-04', '11:36 AM', 'unseen'),
(13, 10, 9, 'hi', '2022-09-04', '12:09 PM', 'seen'),
(14, 10, 9, 'fhfdfhjdhnbtynebjbd  rtyt y   yu u u u yt yt uyuyyuyruyubyubyubybybhgjv', '2022-09-04', '12:10 PM', 'seen'),
(15, 9, 10, 'what', '2022-09-04', '12:10 PM', 'seen'),
(16, 10, 6, 'hi', '2022-09-04', '12:39 PM', 'seen'),
(17, 9, 6, 'hi', '2022-09-04', '12:40 PM', 'seen'),
(18, 8, 9, 'hi', '2022-09-04', '12:43 PM', 'seen'),
(19, 9, 8, 'hi', '2022-09-04', '12:46 PM', 'unseen'),
(20, 9, 6, 'hi', '2022-09-23', '02:11 PM', 'seen'),
(21, 9, 6, 'hello', '2022-09-23', '02:12 PM', 'seen'),
(22, 6, 9, 'hi', '2022-09-23', '02:12 PM', 'seen'),
(23, 6, 9, 'hii', '2022-09-23', '02:14 PM', 'seen'),
(24, 9, 6, 'hello', '2022-09-23', '02:14 PM', 'seen'),
(25, 6, 9, 'hii', '2022-09-23', '02:14 PM', 'seen'),
(26, 9, 6, 'hello how are you', '2022-09-23', '02:17 PM', 'seen'),
(27, 9, 6, 'hello hi', '2022-09-23', '02:19 PM', 'seen'),
(28, 6, 9, 'hi whatsup', '2022-09-23', '02:19 PM', 'seen'),
(29, 9, 6, 'hi how are you', '2022-09-23', '02:23 PM', 'seen'),
(30, 6, 9, 'fine.', '2022-09-23', '02:23 PM', 'seen'),
(31, 9, 6, 'hello', '2022-09-23', '02:35 PM', 'seen'),
(32, 9, 6, 'hi', '2022-09-23', '02:35 PM', 'seen'),
(33, 6, 9, 'hi', '2022-09-23', '02:36 PM', 'seen');

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
(9, 'Nikul', 'nik@user.com', 'nikusers', 'image/profileimg/166228380412577.jpg', 'online'),
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
(2, 6, 9, 'null');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

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
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `userstatus`
--
ALTER TABLE `userstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
