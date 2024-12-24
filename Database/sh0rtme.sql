-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql305.epizy.com
-- Generation Time: May 26, 2023 at 12:51 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_34281813_sh0rtme`
--

-- --------------------------------------------------------

--
-- Table structure for table `urls`
--

CREATE TABLE `urls` (
  `id` int(11) NOT NULL,
  `longurl` varchar(500) NOT NULL,
  `shorturl` varchar(30) NOT NULL,
  `time` date NOT NULL DEFAULT current_timestamp(),
  `is_custom` BOOLEAN DEFAULT FALSE,
  `custom_text` varchar(30) DEFAULT NULL,
  UNIQUE KEY `unique_shorturl` (`shorturl`),
  UNIQUE KEY `unique_custom` (`custom_text`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `urls`
--

INSERT INTO `urls` (`id`, `longurl`, `shorturl`, `time`) VALUES
(29, 'https://google.com', '5eea6', '2023-05-25'),
(30, 'https://jsw.in', '02513', '2023-05-25'),
(31, 'https://www.analyticsvidhya.com/blog/2021/05/in-de', 'e070e', '2023-05-25'),
(32, 'https://docs.google.com/document/d/1qd4ESsA3JyYaz0', '6190a', '2023-05-25'),
(33, 'https://docs.google.com/document/d/1qd4ESsA3JyYaz0', '2a912', '2023-05-25'),
(34, 'https://www.youtube.com/watch?v=lVg8y-rERlk', '12fad', '2023-05-25'),
(35, 'https://docs.google.com/document/d/1qd4ESsA3JyYaz0', 'eb2e1', '2023-05-25'),
(36, 'https://docs.google.com/document/d/1qd4ESsA3JyYaz0', 'df050', '2023-05-25'),
(37, 'https://images.unsplash.com/photo-1531259683007-01', 'a1898', '2023-05-25'),
(38, 'https://images.unsplash.com/photo-1531259683007-01', '4912b', '2023-05-25'),
(39, 'https://images.unsplash.com/photo-1588860939994-ce4f7a537f03?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWF', 'ac6b1', '2023-05-25'),
(40, 'https://images.unsplash.com/photo-1588862081167-d5b98006637e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWF', 'edfb1', '2023-05-25'),
(41, 'https://images.unsplash.com/photo-1588862081167-d5b98006637e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWF', '3d630', '2023-05-25'),
(42, 'https://images.unsplash.com/photo-1590586914586-9df5c6dfc39d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGJhdG1hbnxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60', 'c0d63', '2023-05-25'),
(43, 'https://images.unsplash.com/photo-1588862081167-d5b98006637e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8YmF0bWFufGVufDB8fDB8fHww&w=1000&q=80', '4cfa3', '2023-05-26'),
(44, 'https://docs.google.com/document/d/1qd4ESsA3JyYaz0c8It4yrW6HTn3-NQI4bGdJAJQpp3A/edit?usp=sharing', '1056d', '2023-05-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `urls`
--
ALTER TABLE `urls`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `urls`
--
ALTER TABLE `urls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Table structure for table `url_analytics`
--

CREATE TABLE `url_analytics` (
  `id` int(11) NOT NULL,
  `url_id` int(11) NOT NULL,
  `visitor_ip` varchar(45) NOT NULL,
  `user_agent` text NOT NULL,
  `visited_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `browser` varchar(100) NOT NULL,
  `platform` varchar(100) NOT NULL,
  FOREIGN KEY (`url_id`) REFERENCES `urls`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `file_size` int(11) NOT NULL,
  `upload_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `file_path` varchar(500) NOT NULL,
  `is_public` boolean DEFAULT FALSE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
