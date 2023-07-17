-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2023 at 03:58 AM
-- Server version: 8.0.33-0ubuntu0.22.04.2
-- PHP Version: 8.1.2-1ubuntu2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instagram`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint NOT NULL,
  `user` bigint NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` text,
  `photo` varchar(500) DEFAULT NULL,
  `location` varchar(250) DEFAULT NULL,
  `tags` varchar(500) DEFAULT NULL,
  `total_likes` bigint DEFAULT NULL,
  `total_comments` bigint DEFAULT NULL,
  `total_shares` bigint DEFAULT NULL,
  `published` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user`, `title`, `description`, `photo`, `location`, `tags`, `total_likes`, `total_comments`, `total_shares`, `published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 1, 'Demo Title', 'Demo Description', 'Post Photo', 'Demo Location', NULL, NULL, 0, NULL, 1, '2023-07-16 02:52:05', NULL, NULL),
(5, 1, 'Demo Title', 'Demo Description', 'Post Photo', 'Demo Location', NULL, NULL, 0, NULL, 1, '2023-07-16 02:52:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` bigint NOT NULL,
  `user` bigint NOT NULL,
  `post` bigint NOT NULL,
  `comment` text NOT NULL,
  `published` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `user`, `post`, `comment`, `published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 1, 4, 'Demo Comment', 1, '2023-07-16 03:22:36', NULL, NULL),
(4, 1, 4, 'Demo Comment', 1, '2023-07-16 03:23:24', NULL, NULL),
(5, 1, 4, 'Demo Comment', 1, '2023-07-16 03:23:51', NULL, NULL),
(6, 1, 4, 'Demo Comment', 1, '2023-07-16 03:24:35', NULL, NULL),
(7, 1, 4, 'Demo Comment', 1, '2023-07-16 03:24:38', NULL, NULL),
(8, 1, 4, 'Demo Comment', 1, '2023-07-16 03:25:47', NULL, NULL),
(9, 1, 4, 'Demo Comment', 1, '2023-07-16 03:26:59', NULL, NULL),
(10, 1, 4, 'Demo Comment', 1, '2023-07-16 03:27:26', NULL, NULL),
(11, 1, 4, 'Demo Comment', 1, '2023-07-16 03:28:02', NULL, NULL),
(12, 1, 4, 'Demo Comment', 1, '2023-07-16 03:28:52', NULL, NULL),
(13, 1, 4, 'Demo Comment', 1, '2023-07-16 03:28:59', NULL, NULL),
(14, 1, 4, 'Demo Comment', 1, '2023-07-16 03:29:20', NULL, NULL),
(15, 1, 4, 'Demo Comment', 1, '2023-07-16 03:29:37', NULL, NULL),
(16, 1, 4, 'Demo Comment', 1, '2023-07-16 03:50:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `id` bigint NOT NULL,
  `user` bigint NOT NULL,
  `post` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `photo` varchar(500) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `photo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Mehedi Jaman', 'mail4mjaman@gmail.com', '123', NULL, NULL, 1, '2023-07-16 02:51:55', '2023-07-16 02:51:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_followers`
--

CREATE TABLE `user_followers` (
  `id` bigint NOT NULL,
  `user` bigint NOT NULL,
  `follower` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `post` (`post`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `post` (`post`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_followers`
--
ALTER TABLE `user_followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `follower` (`follower`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_followers`
--
ALTER TABLE `user_followers`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `post_comments_ibfk_2` FOREIGN KEY (`post`) REFERENCES `posts` (`id`);

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`post`) REFERENCES `posts` (`id`);

--
-- Constraints for table `user_followers`
--
ALTER TABLE `user_followers`
  ADD CONSTRAINT `user_followers_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_followers_ibfk_2` FOREIGN KEY (`follower`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
