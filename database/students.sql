-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2024 at 02:23 AM
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
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'images/default_user.png',
  `room_number` int DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `filliere` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Génie informatique',
  `annee_scolaire` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '2',
  `genre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `image`, `room_number`, `email`, `date_naissance`, `ville`, `tel`, `filliere`, `annee_scolaire`, `genre`) VALUES
(1, 'Adam Ait Oufkir', 'images/lklb.jpeg', 5, 'adamaitoufkir05@gmail.com', '2005-03-01', 'Casablanca', '0606060606', 'Genie Informatique', '2', 'boy'),
(2, 'Othman Hamida', 'images/hamida.jpeg', 6, NULL, NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(3, 'Hamza El Kaoui', 'images/lorem.jpeg', 6, 'hamzaelkaouii04@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(4, 'Yassine Rmidi', 'images/yassuine.jpeg', 6, 'yrmidi7@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(5, 'Adnane Elkihel', 'images/adnoune.jpeg', 5, 'adnaneelkihel63@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(6, 'Aymane Laaroui', 'images/laaroui.jpeg', 5, 'laarouiaymane@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(7, 'Yassine EL MESBAHY ', 'images/7alla9.jpeg', 4, 'yassineelmesbahy226@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(8, 'Amine Aghoudid AKA Ms3oud', 'images/ms3oud.jpeg', 5, 'amine.aghoudide@gmail.com', NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(9, 'Houssam Abdellah Louazna ', 'images/louazna.jpeg', 3, NULL, NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(11, 'Oussama Arhannaj', 'images/oussama.jpeg', 3, 'Oussamaarhannaj66@gmail.com', NULL, NULL, NULL, 'Génie informatique', '2', 'boy'),
(12, 'Mohammed Boukhatem', 'images/boukhatem.jpeg', 3, 'mohammedboukhatem069@gmail.com', NULL, NULL, NULL, 'Génie informatique', '2', 'boy'),
(13, 'Noaman Makhlouf', 'images/noaman.jpeg', 4, 'makhloufnoaman58@gmail.com', NULL, NULL, NULL, 'Génie informatique', '2', 'boy'),
(14, 'Yassine ElFal', 'images/sbata.jpeg', 3, 'yassineelfal8@gmail.com', NULL, NULL, NULL, 'Génie informatique', '2', 'boy'),
(15, 'Chatira', 'images/default_user.png', 8, NULL, NULL, NULL, NULL, 'Génie informatique', '2', 'girl'),
(32, 'Test 1', 'images/default_user.png', 1, 'test1@example.com', '2000-01-01', 'Casablanca', '1234567891', 'Génie informatique', '2', 'girl'),
(33, 'Test 2', 'images/default_user.png', 7, 'test2@example.com', '2000-02-02', 'Casablanca', '1234567892', 'Génie informatique', '2', 'girl'),
(34, 'Test 3', 'images/default_user.png', 1, 'test3@example.com', '2000-03-03', 'Casablanca', '1234567893', 'Génie informatique', '2', 'girl'),
(35, 'Test 4', 'images/default_user.png', 4, 'test4@example.com', '2000-04-04', 'Casablanca', '1234567894', 'Génie informatique', '2', 'girl'),
(36, 'Test 5', 'images/default_user.png', 8, 'test5@example.com', '2000-05-05', 'Casablanca', '1234567895', 'Génie informatique', '2', 'girl'),
(37, 'Test 6', 'images/default_user.png', 8, 'test6@example.com', '2000-06-06', 'Casablanca', '1234567896', 'Génie informatique', '2', 'girl'),
(38, 'Test 7', 'images/default_user.png', 7, 'test7@example.com', '2000-07-07', 'Casablanca', '1234567897', 'Génie informatique', '2', 'girl'),
(39, 'Test 8', 'images/default_user.png', 8, 'test8@example.com', '2000-08-08', 'Casablanca', '1234567898', 'Génie informatique', '2', 'girl');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
