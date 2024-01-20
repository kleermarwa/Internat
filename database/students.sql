-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2024 at 06:15 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estc`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `room_number` int DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `filliere` varchar(50) DEFAULT NULL,
  `annee_scolaire` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `image`, `room_number`, `email`, `date_naissance`, `ville`, `tel`, `filliere`, `annee_scolaire`) VALUES
(1, 'Adam Ait Oufkir', 'images/lklb.jpeg', 6, 'adamaitoufkir05@gmail.com', '2005-03-01', 'Casablanca', '0606060606', 'Génie informatique', '2'),
(2, 'Othman Hamida', 'images/hamida.jpeg', 6, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Hamza El Kaoui', 'images/lorem.jpeg', 6, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Yassine Rmidi', 'images/yassuine.jpeg', 6, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Adnane Elkihel', 'images/adnoune.jpeg', 5, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Aymane Laaroui', 'images/laaroui.jpeg', 5, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Yassine EL MESBAHY ', 'images/7alla9.jpeg', 4, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Amine Aghoudid AKA Ms3oud', 'images/ms3oud.jpeg', 5, 'amine.aghoudide@gmail.com', NULL, NULL, NULL, NULL, NULL),
(9, 'Houssam Abdellah Louazna ', 'images/louazna.jpeg', 3, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Nabila Chatira ', 'images/nabila.jpeg', 3, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
