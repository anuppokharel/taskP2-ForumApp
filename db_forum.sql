-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2022 at 04:37 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admins`
--

CREATE TABLE `tbl_admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admins`
--

INSERT INTO `tbl_admins` (`id`, `name`, `email`, `password`, `status`) VALUES
(1, 'Anup Pokharel', 'anup.pokharel30@gmail.com', 'e6e6249a9d25e5917fb924679cf53369', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `title`, `code`, `rank`, `status`) VALUES
(8, 'Education', 'Edu', 1, 1),
(10, 'Entertainment', 'Ent', 1, 1),
(11, 'Sports', 'Sports', 1, 1),
(12, 'Others', 'Other', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` varchar(150) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`name`, `email`, `message`, `password`) VALUES
('Harry Maguire', 'harry@gmail.com', 'dsfhaskdjasgkihasdfkadsjf', 'd0d2b883ffe11676af7e678cf45a36fa');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forums`
--

CREATE TABLE `tbl_forums` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `posted_date` date DEFAULT current_timestamp(),
  `category_id` int(11) DEFAULT NULL,
  `posted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_forums`
--

INSERT INTO `tbl_forums` (`id`, `title`, `description`, `image`, `status`, `posted_date`, `category_id`, `posted_by`) VALUES
(42, 'Hattrick for Cr', '1 tap-in, 1 header, 1 freekick', '625b0245cb993_E_AqA3xX0AEPbJX.jpg', 1, '2022-04-16', 11, 9),
(43, 'UCL', 'Uefa Champions League is one of the biggest competition in the world new', '625b14173d260_16392542_303.jpg', 1, '2022-04-17', 11, 5),
(44, 'I love you', 'I love you momo <3', '625b7f434323d_30.jpg', 1, '2022-04-17', 12, 10),
(45, 'LM10 and CR7', 'Great rivals!', '625b83042a797_55760065_2322495501144283_9084167130269614080_n.jpg', 1, '2022-04-17', 11, 12),
(46, 'Ahhh shittt', 'Hey there bad bois', '625f7a8b584b1_61856367_859703057715908_28637132532744192_n.jpg', 1, '2022-04-20', 10, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forum_likes`
--

CREATE TABLE `tbl_forum_likes` (
  `action` varchar(50) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_forum_likes`
--

INSERT INTO `tbl_forum_likes` (`action`, `forum_id`, `user_id`) VALUES
('like', 42, 10),
('like', 42, 12),
('like', 46, 12);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forum_replies`
--

CREATE TABLE `tbl_forum_replies` (
  `id` int(11) NOT NULL,
  `reply` varchar(100) DEFAULT NULL,
  `no_comment` bigint(20) DEFAULT 0,
  `no_like` bigint(20) DEFAULT 0,
  `reply_date` date DEFAULT current_timestamp(),
  `forum_id` int(11) DEFAULT NULL,
  `reply_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_forum_replies`
--

INSERT INTO `tbl_forum_replies` (`id`, `reply`, `no_comment`, `no_like`, `reply_date`, `forum_id`, `reply_by`) VALUES
(9, 'Good goal!', 0, 0, '2022-04-18', 42, 12),
(10, 'Ya ya good goal!', 0, 0, '2022-04-18', 42, 5),
(11, 'Hmm, freekick was good though. ^_^', 0, 0, '2022-04-18', 42, 10),
(12, 'Thats a BURGER!!!', 0, 0, '2022-04-18', 44, 10),
(13, 'Good Era', 0, 0, '2022-04-18', 45, 10),
(14, 'Hi gyan', 0, 0, '2022-04-18', 42, 5),
(15, 'Lookin gud', 0, 0, '2022-04-20', 46, 5),
(16, 'Test', 0, 0, '2022-04-20', 42, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `phone`, `email`, `password`, `address`, `status`) VALUES
(5, 'Durga KC', 9841526341, 'durga@gmail.com', '2904a936068a124774e77463ac472ffc', 'Hattidada', 1),
(7, 'Devaka KC', 9860693557, 'devaka@gmail.com', 'bc317f8c6c399d594df1b85bf3d98e34', 'Hattidada', 1),
(9, 'Saksham KC', 9841852149, 'saksham@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Koteshwor', 1),
(10, 'Amit Pokharel', 9841854246, 'amit@gmail.com', 'd2b3f63948406cb893544cee035531d3', 'Butwal', 1),
(12, 'Allan KC', 9841854142, 'allan@gmail.com', '82102231495bd64c4718929f02522f6a', 'Koteshwor', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `tbl_forums`
--
ALTER TABLE `tbl_forums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `posted_by` (`posted_by`);

--
-- Indexes for table `tbl_forum_likes`
--
ALTER TABLE `tbl_forum_likes`
  ADD UNIQUE KEY `forum_id` (`forum_id`,`user_id`);

--
-- Indexes for table `tbl_forum_replies`
--
ALTER TABLE `tbl_forum_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum_id` (`forum_id`),
  ADD KEY `reply_by` (`reply_by`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_forums`
--
ALTER TABLE `tbl_forums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_forum_replies`
--
ALTER TABLE `tbl_forum_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_forums`
--
ALTER TABLE `tbl_forums`
  ADD CONSTRAINT `tbl_forums_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`),
  ADD CONSTRAINT `tbl_forums_ibfk_2` FOREIGN KEY (`posted_by`) REFERENCES `tbl_users` (`id`);

--
-- Constraints for table `tbl_forum_replies`
--
ALTER TABLE `tbl_forum_replies`
  ADD CONSTRAINT `tbl_forum_replies_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `tbl_forums` (`id`),
  ADD CONSTRAINT `tbl_forum_replies_ibfk_2` FOREIGN KEY (`reply_by`) REFERENCES `tbl_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
