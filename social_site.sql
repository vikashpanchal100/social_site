-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 28, 2021 at 08:25 PM
-- Server version: 5.7.28-0ubuntu0.19.04.2
-- PHP Version: 7.2.24-0ubuntu0.19.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `scl_follow_user`
--

CREATE TABLE `scl_follow_user` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `following_to_id` int(11) NOT NULL,
  `currently_following` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `last_viewed_status_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scl_follow_user`
--

INSERT INTO `scl_follow_user` (`id`, `follower_id`, `following_to_id`, `currently_following`, `last_viewed_status_id`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 'YES', 15, '2021-10-27 09:56:24', '2021-10-28 08:43:22'),
(3, 1, 2, 'YES', NULL, '2021-10-27 13:39:56', '2021-10-27 13:39:56'),
(4, 2, 3, 'YES', 16, '2021-10-28 13:35:24', '2021-10-28 08:43:25');

-- --------------------------------------------------------

--
-- Table structure for table `scl_user`
--

CREATE TABLE `scl_user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `current_status_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scl_user`
--

INSERT INTO `scl_user` (`id`, `name`, `email`, `mobile`, `password`, `current_status_id`, `created_at`, `updated_at`) VALUES
(1, 'vikash', 'vikashpanchal100@gmail.com', '8285252539', '123456', 15, '2021-10-27 06:42:14', '2021-10-28 07:59:04'),
(2, 'vikash panchal', 'vikashpanchal217@gmail.com', '9855444545', '12345678', 11, '2021-10-27 07:24:12', '2021-10-27 09:44:38'),
(3, 'kuldeep', 'vikashpanchal101@gmail.com', '9845658589', '12345678', 16, '2021-10-27 15:12:57', '2021-10-28 08:06:16'),
(4, 'amba', 'vikashpanchal102@gmail.com', '9854625878', '123456', 17, '2021-10-28 13:56:02', '2021-10-28 08:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `scl_user_status`
--

CREATE TABLE `scl_user_status` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_status_content` text,
  `post_status_image` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scl_user_status`
--

INSERT INTO `scl_user_status` (`id`, `user_id`, `post_status_content`, `post_status_image`, `created_at`, `updated_at`) VALUES
(1, 2, 'efefewf', '2Screenshot from 2019-08-29 11-20-01.png', '2021-10-27 13:22:42', '2021-10-27 13:22:42'),
(2, 2, 'sdfgdgdfg', '2Screenshot from 2019-08-29 11-19-56.png', '2021-10-27 13:25:10', '2021-10-27 13:25:10'),
(3, 2, 'gdgsdgsdg', '2Screenshot from 2019-10-23 17-51-21.png', '2021-10-27 13:25:56', '2021-10-27 13:25:56'),
(4, 2, 'hfsfhsdgsdg', '2Screenshot from 2019-09-18 15-15-26.png', '2021-10-27 13:37:11', '2021-10-27 13:37:11'),
(5, 1, 'safwef', '1Screenshot from 2019-08-29 11-19-56.png', '2021-10-27 14:04:40', '2021-10-27 14:04:40'),
(6, 1, 'dff', '1Screenshot from 2019-08-29 11-20-01.png', '2021-10-27 14:05:40', '2021-10-27 14:05:40'),
(7, 1, 'dff', '1Screenshot from 2019-08-29 11-20-01.png', '2021-10-27 14:06:04', '2021-10-27 14:06:04'),
(8, 1, 'fff', '1Screenshot from 2019-09-18 15-15-26.png', '2021-10-27 14:06:58', '2021-10-27 14:06:58'),
(9, 1, 'fff', '1Screenshot from 2019-09-18 15-15-26.png', '2021-10-27 14:07:47', '2021-10-27 14:07:47'),
(10, 1, 'fff', '1Screenshot from 2019-09-18 15-15-26.png', '2021-10-27 14:08:05', '2021-10-27 14:08:05'),
(11, 2, 'dfgdfgdfgdfg', '2Screenshot from 2019-10-23 17-51-21.png', '2021-10-27 15:14:38', '2021-10-27 15:14:38'),
(12, 1, 'fyiuweyfyefiuyewuifyewfwef', '1Screenshot from 2019-10-25 16-30-51.png', '2021-10-28 13:21:51', '2021-10-28 13:21:51'),
(13, 1, 'gegwgwg', '1Screenshot from 2019-10-23 17-51-21.png', '2021-10-28 13:24:10', '2021-10-28 13:24:10'),
(14, 1, 'ggg', '1Screenshot from 2019-09-18 15-16-07.png', '2021-10-28 13:25:13', '2021-10-28 13:25:13'),
(15, 1, 'dsfsdff', '1Screenshot from 2019-10-23 17-51-21.png', '2021-10-28 13:29:04', '2021-10-28 13:29:04'),
(16, 3, 'hgjgfjgjkfgaf', '3Screenshot from 2019-10-23 17-51-21.png', '2021-10-28 13:36:16', '2021-10-28 13:36:16'),
(17, 4, 'fyfghfhgfghfghf', '4Screenshot from 2019-10-23 17-51-21.png', '2021-10-28 13:56:28', '2021-10-28 13:56:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `scl_follow_user`
--
ALTER TABLE `scl_follow_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scl_user`
--
ALTER TABLE `scl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scl_user_status`
--
ALTER TABLE `scl_user_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `scl_follow_user`
--
ALTER TABLE `scl_follow_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `scl_user`
--
ALTER TABLE `scl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `scl_user_status`
--
ALTER TABLE `scl_user_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
