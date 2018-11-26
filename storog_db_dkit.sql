-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2018 at 05:02 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `storog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poster_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `steam_id` int(11) DEFAULT NULL,
  `on_gog` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `title`, `steam_id`, `on_gog`) VALUES
(64069, 'System Shock', NULL, 1),
(64070, 'System Shock: Enhanced Edition', 410710, 1),
(64071, 'System Shock 2', 238210, 1),
(64072, 'System Shock: Adventure Alpha', 482400, 0),
(64073, 'System Shock: Classic', 410700, 0),
(64074, 'Call of Duty: United Offensive', 2640, 0),
(64075, 'Call of Duty 4: Modern Warfare', 7940, 0),
(64076, 'Call of Duty: Modern Warfare 2', 10180, 0),
(64077, 'Call of Duty: Modern Warfare 3', 42680, 0),
(64078, 'Call of Duty: World at War', 10090, 0),
(64079, 'Undertale', 391540, 1),
(64080, 'VVVVVV', 70300, 1),
(64081, 'The Elder Scrolls III: Morrowind', 22320, 0),
(64082, 'The Elder Scrolls V: Skyrim Special Edition', 489830, 0),
(64083, 'The Elder Scrolls IV: Oblivion ', 22330, 0),
(64084, 'Terraria', 105600, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `username`) VALUES
(1, '', '', '$2y$10$VUH27A4s2kvt9T5lnibXTuoQKez1JFnbaC7j4shnwTwpm4zyYxMmC', '', 'asdf');

-- --------------------------------------------------------

--
-- Table structure for table `user_games`
--

CREATE TABLE `user_games` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_votes`
--

CREATE TABLE `user_votes` (
  `liker_id` int(11) NOT NULL,
  `liked_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`poster_id`),
  ADD KEY `user_id_2` (`poster_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_games`
--
ALTER TABLE `user_games`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `game_id` (`game_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `game_id_2` (`game_id`);

--
-- Indexes for table `user_votes`
--
ALTER TABLE `user_votes`
  ADD PRIMARY KEY (`liker_id`,`liked_id`),
  ADD KEY `liked_id` (`liked_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64085;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_games`
--
ALTER TABLE `user_games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`poster_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_games`
--
ALTER TABLE `user_games`
  ADD CONSTRAINT `user_games_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_games_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);

--
-- Constraints for table `user_votes`
--
ALTER TABLE `user_votes`
  ADD CONSTRAINT `user_votes_ibfk_1` FOREIGN KEY (`liker_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_votes_ibfk_2` FOREIGN KEY (`liked_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
