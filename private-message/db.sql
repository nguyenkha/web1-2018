-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2017 at 10:12 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `btcn08`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `userId1` int(11) NOT NULL,
  `userId2` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`userId1`, `userId2`, `createdAt`) VALUES
(1, 2, '2017-10-30 06:13:51'),
(1, 4, '2017-11-06 10:03:29'),
(2, 1, '2017-10-30 06:14:11'),
(3, 1, '2017-10-23 10:01:17'),
(4, 1, '2017-11-06 10:04:04');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `userId1` int(11) NOT NULL,
  `userId2` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `content`, `userId1`, `userId2`, `type`, `createdAt`) VALUES
(1, 'Hi', 1, 2, 0, '2017-11-06 08:58:48'),
(2, 'Hi', 2, 1, 1, '2017-11-06 08:58:48'),
(3, 'Hello', 2, 1, 0, '2017-11-06 08:59:51'),
(4, 'Hello', 1, 2, 1, '2017-11-06 08:59:51'),
(5, 'Chào bạn', 1, 3, 1, '2017-11-06 09:25:38'),
(6, 'Chào bạn', 3, 1, 0, '2017-11-06 09:25:38'),
(7, 'Haha', 1, 2, 0, '2017-11-06 09:50:47'),
(8, 'Haha', 2, 1, 1, '2017-11-06 09:50:47'),
(9, 'Huhu', 2, 1, 0, '2017-11-06 09:51:12'),
(10, 'Huhu', 1, 2, 1, '2017-11-06 09:51:12'),
(11, 'Là lá la', 1, 2, 0, '2017-11-06 09:52:06'),
(12, 'Là lá la', 2, 1, 1, '2017-11-06 09:52:06'),
(13, 'Abc', 1, 2, 0, '2017-11-06 10:02:59'),
(14, 'Abc', 2, 1, 1, '2017-11-06 10:02:59'),
(15, 'Chào chị A', 1, 4, 0, '2017-11-06 10:04:20'),
(16, 'Chào chị A', 4, 1, 1, '2017-11-06 10:04:20'),
(17, 'Chào em Kha', 4, 1, 0, '2017-11-06 10:04:36'),
(18, 'Chào em Kha', 1, 4, 1, '2017-11-06 10:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `content` varchar(1024) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userId`, `content`, `createdAt`) VALUES
(1, 1, 'Em gái mưa@@', '2017-10-16 09:51:24'),
(2, 1, 'Trời lại sắp mưa...', '2017-10-16 10:01:56'),
(3, 2, 'Trời đang mưa', '2017-10-16 10:07:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `hasAvatar` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `phone`, `email`, `password`, `hasAvatar`) VALUES
(1, 'Kha N. Do', '0123456789', 'dnkha@fit.hcmus.edu.vn', '$2y$10$Q3NNG0ZGxmaayuZKNVC9tOvXUNi2/O6S.jmffkP1jKNoXXR9qWtl2', 1),
(2, 'Thái Gia Huy', '0123435455', 'thaigiahuy@gmail.com', '$2y$10$6jG6yEQPxf6ZgbRJWqmVwu/e4kxpAK08q./kirZPy2BByfh6mnwC6', 1),
(3, 'Nguyễn Công Hiệp', '', 'nchiep@gmail.com', '$2y$10$cdtNk2bG61a2qjUQ3q5rF.6G4iCbCLMty7sFjPNdlzD.OQW8G958y', 0),
(4, 'Trần Thị A', '', 'tranthia@yahoo.com', '$2y$10$Ka0n5K9Arji2xRi0XeCMvOeTp5hgY4EBMPuLKqJNqjAxCzHvX2FVe', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`userId1`,`userId2`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;