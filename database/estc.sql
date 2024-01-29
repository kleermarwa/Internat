-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2024 at 11:06 PM
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
-- Table structure for table `decharge`
--

CREATE TABLE `decharge` (
  `id_demande` int NOT NULL,
  `student_id` int NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Pending',
  `read_departement` int NOT NULL DEFAULT '0',
  `read_internat` int NOT NULL DEFAULT '0',
  `read_economique` int NOT NULL DEFAULT '0',
  `read_administartion` int NOT NULL DEFAULT '0',
  `notification_status` enum('unread','read') NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `valide_departement` int NOT NULL DEFAULT '0',
  `valide_internat` int NOT NULL DEFAULT '0',
  `valide_economique` int NOT NULL DEFAULT '0',
  `valide_administration` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `decharge`
--

INSERT INTO `decharge` (`id_demande`, `student_id`, `status`, `read_departement`, `read_internat`, `read_economique`, `read_administartion`, `notification_status`, `created_at`, `updated_at`, `valide_departement`, `valide_internat`, `valide_economique`, `valide_administration`) VALUES
(4, 2, 'Validé', 1, 1, 1, 1, 'unread', '2024-01-25 19:40:44', '2024-01-27 23:19:05', 1, 1, 1, 1),
(12, 1, 'Validé', 1, 1, 0, 0, 'unread', '2024-01-27 23:17:48', '2024-01-27 23:19:04', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `internat`
--

CREATE TABLE `internat` (
  `id_demande` int NOT NULL,
  `student_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `room_number` int NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `valide` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internat`
--

INSERT INTO `internat` (`id_demande`, `student_id`, `name`, `ville`, `created_at`, `updated_at`, `room_number`, `status`, `genre`, `valide`) VALUES
(11, 1, 'Adam Ait Oufkir', 'Casablanca', '2024-01-27 23:16:54', '2024-01-27 23:16:54', 5, 'accepted', 'boy', 1),
(12, 6, 'Aymane Laaroui', 'Casablanca', '2024-01-28 00:07:14', '2024-01-28 00:07:14', 1, 'accepted', 'boy', 1),
(23, 5, 'Adnane Elkihel', 'Casablanca', '2024-01-28 09:38:58', '2024-01-28 09:38:58', 5, 'accepted', 'boy', 1),
(24, 15, 'Chatira', 'null', '2024-01-28 16:29:55', '2024-01-28 16:29:55', 1, 'accepted', 'girl', 1);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('interne','externe','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'externe',
  `role` enum('student','departement','internat','economique','administration','super_admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'student',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'images/default_user.png',
  `room_number` int DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tel` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `filliere` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'Génie informatique',
  `annee_scolaire` varchar(10) COLLATE utf8mb4_general_ci DEFAULT '2',
  `genre` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `status`, `role`, `password`, `email`, `image`, `room_number`, `date_naissance`, `ville`, `tel`, `filliere`, `annee_scolaire`, `genre`) VALUES
(1, 'Adam Ait Oufkir', 'interne', 'student', 'a', 'adamoufkir05@gmail.com', '../images/lklb.jpeg', 6, '2005-03-01', 'Casablanca', '+212673155179', 'Genie Informatique', '2', 'boy'),
(2, 'Ayoub Moutik', 'interne', 'student', 'z', 'whoami9630@gmail.com', '../images/moulchi.jpeg', 6, '2004-08-31', 'Casablanca', '0660002406', 'Génie informatique', '2', 'boy'),
(3, 'Hitler The Cat', 'admin', 'super_admin', 'a', 'hitler_anti_jews@gmail.com', '../images/hitler.jpg', NULL, NULL, 'Ra7ma', '6969696969', 'Génie informatique', '2', 'boy'),
(4, 'Yassine Rmidi', 'interne', 'student', 'a', 'yrmidi7@gmail.com', '../images/yassuine.jpeg', 6, NULL, 'Casablanca', '06060606', 'Genie Informatique', '2', 'boy'),
(5, 'Adnane Elkihel', 'externe', 'student', 'a', 'adnaneelkihel63@gmail.com', '../images/adnoune.jpeg', NULL, NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(6, 'Aymane Laaroui', 'externe', 'student', 'a', 'laarouiaymane@gmail.com', '../images/laaroui.jpeg', NULL, NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(7, 'Yassine EL MESBAHY ', 'interne', 'student', NULL, 'yassineelmesbahy226@gmail.com', '../images/7alla9.jpeg', 8, NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(8, 'Amine Aghoudid AKA Ms3oud', 'externe', 'student', 'a', 'amine.aghoudide@gmail.com', '../images/ms3oud.jpeg', NULL, NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(9, 'Houssam Abdellah Louazna ', 'externe', 'student', NULL, NULL, '../images/louazna.jpeg', NULL, NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(11, 'Oussama Arhannaj', 'interne', 'student', NULL, 'Oussamaarhannaj66@gmail.com', '../images/oussama.jpeg', 6, NULL, NULL, NULL, 'Génie informatique', '2', 'boy'),
(12, 'Mohammed Boukhatem', 'interne', 'student', NULL, 'mohammedboukhatem069@gmail.com', '../images/boukhatem.jpeg', 8, NULL, NULL, NULL, 'Génie informatique', '2', 'boy'),
(13, 'Noaman Makhlouf', 'interne', 'student', NULL, 'makhloufnoaman58@gmail.com', '../images/noaman.jpeg', 5, NULL, NULL, NULL, 'Génie informatique', '2', 'boy'),
(14, 'Yassine ElFal', 'externe', 'student', NULL, 'yassineelfal8@gmail.com', '../images/sbata.jpeg', NULL, NULL, NULL, NULL, 'Génie informatique', '2', 'boy'),
(15, 'Chatira', 'interne', 'student', 'a', 'chatira@gmail.com', '../images/default_user.png', 8, NULL, NULL, NULL, 'Génie informatique', '2', 'girl'),
(16, 'Othman Hamida', 'externe', 'student', NULL, NULL, '../images/hamida.jpeg', NULL, NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(17, 'Hamza El Kaoui', 'interne', 'student', NULL, 'hamzaelkaouii04@gmail.com', '../images/lorem.jpeg', 8, NULL, 'Casablanca', NULL, 'Genie Informatique', '2', 'boy'),
(32, 'Test 1', 'interne', 'student', NULL, 'test1@example.com', '../images/default_user.png', 1, '2000-01-01', 'Casablanca', '1234567891', 'Génie informatique', '2', 'girl'),
(33, 'Test 2', 'interne', 'student', NULL, 'test2@example.com', '../images/default_user.png', 7, '2000-02-02', 'Casablanca', '1234567892', 'Génie informatique', '2', 'girl'),
(34, 'Test 3', 'interne', 'student', NULL, 'test3@example.com', '../images/default_user.png', 1, '2000-03-03', 'Casablanca', '1234567893', 'Génie informatique', '2', 'girl'),
(35, 'Test 4', 'interne', 'student', NULL, 'test4@example.com', '../images/default_user.png', 4, '2000-04-04', 'Casablanca', '1234567894', 'Génie informatique', '2', 'girl'),
(36, 'Test 5', 'interne', 'student', NULL, 'test5@example.com', '../images/default_user.png', 8, '2000-05-05', 'Casablanca', '1234567895', 'Génie informatique', '2', 'girl'),
(37, 'Test 6', 'interne', 'student', NULL, 'test6@example.com', '../images/default_user.png', 8, '2000-06-06', 'Casablanca', '1234567896', 'Génie informatique', '2', 'girl'),
(38, 'Test 7', 'interne', 'student', NULL, 'test7@example.com', '../images/default_user.png', 7, '2000-07-07', 'Casablanca', '1234567897', 'Génie informatique', '2', 'girl'),
(39, 'Test 8', 'interne', 'student', NULL, 'test8@example.com', '../images/default_user.png', 8, '2000-08-08', 'Casablanca', '1234567898', 'Génie informatique', '2', 'girl'),
(45, 'Khalid Bouragba', 'admin', 'departement', 'a', 'bouragba2008@gmail.com', '../images/bouragba.jpg', NULL, '1980-01-01', 'Casablanca', '061234567', 'Génie informatique', '', 'boy'),
(46, 'Admin Internat', 'admin', 'internat', 'a', 'internat@gmail.com', '../images/default_user.png', NULL, NULL, 'Casablanca\n', NULL, '[value-9]', NULL, 'boy'),
(47, 'Admin Economique', 'admin', 'economique', 'a', 'eco@gmail.com', '../images/default_user.png', NULL, NULL, 'Casablanca\n', NULL, '[value-9]', NULL, 'boy'),
(48, 'Administrateur', 'admin', 'administration', 'a', 'admin@gmail.com', '../images/default_user.png', NULL, NULL, 'Casablanca\n', NULL, '[value-9]', NULL, 'boy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `decharge`
--
ALTER TABLE `decharge`
  ADD PRIMARY KEY (`id_demande`);

--
-- Indexes for table `internat`
--
ALTER TABLE `internat`
  ADD PRIMARY KEY (`id_demande`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `decharge`
--
ALTER TABLE `decharge`
  MODIFY `id_demande` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `internat`
--
ALTER TABLE `internat`
  MODIFY `id_demande` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
