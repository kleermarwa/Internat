-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2024 at 09:50 PM
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
  `filliere` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Génie informatique',
  `annee_scolaire` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `image`, `room_number`, `email`, `date_naissance`, `ville`, `tel`, `filliere`, `annee_scolaire`) VALUES
(1, 'Adam Ait Oufkir', 'images/lklb.jpeg', 5, 'adamaitoufkir05@gmail.com', '2005-03-01', 'Casablanca', '0606060606', 'Genie Informatique', '2'),
(2, 'Othman Hamida', 'images/hamida.jpeg', 6, NULL, NULL, 'Casablanca', NULL, 'Genie Informatique', '2'),
(3, 'Hamza El Kaoui', 'images/lorem.jpeg', 6, 'hamzaelkaouii04@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2'),
(4, 'Yassine Rmidi', 'images/yassuine.jpeg', 6, 'yrmidi7@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2'),
(5, 'Adnane Elkihel', 'images/adnoune.jpeg', 5, 'adnaneelkihel63@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2'),
(6, 'Aymane Laaroui', 'images/laaroui.jpeg', 5, 'laarouiaymane@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2'),
(7, 'Yassine EL MESBAHY ', 'images/7alla9.jpeg', 4, 'yassineelmesbahy226@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2'),
(8, 'Amine Aghoudid AKA Ms3oud', 'images/ms3oud.jpeg', 5, 'amine.aghoudide@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2'),
(9, 'Houssam Abdellah Louazna ', 'images/louazna.jpeg', 3, NULL, NULL, 'Casablanca', NULL, 'Genie Informatique', '2'),
(11, 'Oussama Arhannaj', 'images/oussama.jpeg', 3, 'Oussamaarhannaj66@gmail.com', NULL, NULL, NULL, 'Génie informatique', '2'),
(12, 'Mohammed Boukhatem', 'images/boukhatem.jpeg', 3, 'mohammedboukhatem069@gmail.com', NULL, NULL, NULL, 'Génie informatique', '2'),
(13, 'Noaman Makhlouf', 'images/noaman.jpeg', 4, 'makhloufnoaman58@gmail.com', NULL, NULL, NULL, 'Génie informatique', '2'),
(14, 'Yassine ElFal', 'images/sbata.jpeg', 3, 'yassineelfal8@gmail.com', NULL, NULL, NULL, 'Génie informatique', '2');

--
-- Triggers `students`
--
DELIMITER $$
CREATE TRIGGER `before_insert_students` BEFORE INSERT ON `students` FOR EACH ROW BEGIN
    DECLARE num_students INT;

    IF NEW.room_number IS NOT NULL THEN
        SELECT COUNT(*) INTO num_students
        FROM students
        WHERE room_number = NEW.room_number;

        IF num_students >= 4 THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Room is full. Maximum 4 students allowed.';
        END IF;
    END IF;
END
$$
DELIMITER ;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
