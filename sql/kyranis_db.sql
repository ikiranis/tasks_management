-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Mar 25, 2024 at 07:23 PM
-- Server version: 10.4.32-MariaDB-1:10.4.32+maria~ubu2004-log
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kyranis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Εργασία'),
(2, 'Προσωπικά'),
(3, 'Εκπαίδευση'),
(4, 'Χόμπι'),
(5, 'Κοινωνικά');

-- --------------------------------------------------------

--
-- Table structure for table `list_users`
--

CREATE TABLE `list_users` (
  `id` int(11) NOT NULL,
  `tasksListId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `list_users`
--

INSERT INTO `list_users` (`id`, `tasksListId`, `userId`) VALUES
(34, 60, 42),
(35, 61, 42),
(36, 62, 42),
(37, 63, 42),
(38, 61, 44),
(39, 61, 43),
(40, 61, 48),
(41, 60, 45),
(42, 60, 47),
(43, 63, 46),
(44, 63, 44),
(45, 64, 43),
(46, 65, 44),
(47, 66, 45),
(48, 67, 46),
(49, 68, 47),
(50, 69, 48);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'Νέα'),
(2, 'Σε εξέλιξη'),
(3, 'Ολοκληρωμένη');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `tasksListId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `tasksListId`, `userId`) VALUES
(117, 'Ανάλυση Δεδομένων', 63, 42),
(118, 'Σύνταξη Εκθέσεων', 63, 42),
(119, 'Αξιολόγηση Εκπαιδευτικών Προγραμμάτων', 63, 42),
(120, 'Αναφορές', 62, 42),
(121, 'Απάντηση σε σημαντικά emails', 62, 42),
(122, 'Διαχείριση Χρόνου', 62, 42),
(123, 'Ανάπτυξη νέων χαρακτηριστικών εφαρμογής', 61, 42),
(124, 'Unit testing', 61, 42),
(125, 'Code review', 61, 42),
(126, 'Documentation', 61, 42),
(127, 'Αναβάθμιση Βιβλιοθηκών', 60, 42),
(128, 'Διόρθωση Σφαλμάτων', 60, 42),
(129, 'Βελτιστοποίηση Κώδικα', 60, 42),
(130, 'Ασφάλεια', 60, 42),
(131, 'Τεκμηρίωση', 60, 42),
(132, 'Ανάλυση απαιτήσεων', 64, 43),
(133, 'Οργάνωση των δεδομένων σε πίνακες', 64, 43),
(134, 'Κανονικοποίηση', 64, 43),
(135, 'Καταγραφή διαδρομών', 65, 44),
(136, 'Ψάξιμο τοπικών μονοπατιών', 65, 44),
(137, 'Εξερεύνηση νέων περιοχών', 65, 44),
(138, 'Ανάλυση Αποτελεσμάτων Εκπαιδευτικών Προγραμμάτων', 63, 44),
(139, 'Συμμετοχή σε Καθαρισμούς Περιβάλλοντος', 66, 45),
(140, 'Διοργάνωση Εκδηλώσεων Κοινότητας', 66, 45),
(141, 'Οργάνωση Προσωπικών Αντικειμένων', 67, 46),
(142, 'Φροντίδα Κατοικιδίων', 67, 46),
(143, 'Συντήρηση Κουζίνας', 67, 46),
(144, 'Ορισμός Στόχων Ποιότητας', 68, 47),
(145, 'Ανάλυση Δεδομένων Ποιότητας', 68, 47),
(146, 'Σχεδιασμός και Εφαρμογή Βελτιώσεων', 68, 47),
(147, 'Παρακολούθηση και Αξιολόγηση', 68, 47),
(148, 'Εκπαίδευση Προσωπικών Δεξιοτήτων', 69, 48),
(149, 'Στόχοι και Σχέδια', 69, 48);

-- --------------------------------------------------------

--
-- Table structure for table `tasks_list`
--

CREATE TABLE `tasks_list` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `statusId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks_list`
--

INSERT INTO `tasks_list` (`id`, `title`, `categoryId`, `statusId`, `userId`) VALUES
(60, 'Εργασίες Συντήρησης', 1, 1, 42),
(61, 'Στόχοι Εβδομάδας', 1, 1, 42),
(62, 'Επείγουσες Εργασίες', 1, 1, 42),
(63, 'Αναφορές και Αναλύσεις', 3, 2, 42),
(64, 'Σχεδίαση Βάσης Δεδομένων', 1, 2, 43),
(65, 'Εξερεύνηση νέων διαδρομών για ποδηλασία', 4, 1, 44),
(66, 'Συμμετοχή σε Κοινωνικές Εκδηλώσεις και Πρωτοβουλίες', 5, 2, 45),
(67, 'Καθημερινές Εργασίες', 2, 1, 46),
(68, 'Βελτίωση Διαδικασιών Ποιότητας', 1, 1, 47),
(69, 'Προσωπική Ανάπτυξη', 2, 1, 48);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`) VALUES
(22, 'Ομάδα Ανάπτυξης'),
(23, 'Ομάδα Ποιότητας'),
(24, 'Ομάδα Υποστήριξης');

-- --------------------------------------------------------

--
-- Table structure for table `team_users`
--

CREATE TABLE `team_users` (
  `id` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_users`
--

INSERT INTO `team_users` (`id`, `teamId`, `userId`) VALUES
(42, 22, 42),
(43, 22, 44),
(44, 22, 43),
(45, 23, 45),
(46, 23, 42),
(47, 23, 47),
(48, 22, 48),
(49, 24, 42),
(50, 24, 46),
(51, 24, 44);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `role` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `role`) VALUES
(42, 'admin', '$2y$10$YgY/Xxer6uQ.orEmpM8acu6cBzlzd1bBKYQyBP0.8uSqE4Deih5hq', '', 'admin@mail.com', 0),
(43, 'zenith', '$2y$10$RolNYv2Cxgo4HN3SPZdSCO27qw1Qp4zU6kw/wkX3QjubgUOUGYwZ.', '', 'zenith@mail.com', 1),
(44, 'quasar', '$2y$10$WZzOLZxsAOI98G5PaO1OLuGX/WwsceNx0DP0TBvFqVgeGIq0fF1wC', '', 'quasar@mail.com', 1),
(45, 'lumina', '$2y$10$MySu7faaWmixMkUNs3f.HOUNS60KlWt9vL44DO/ds.2Dgrv5.MO1W', '', 'lumina@mail.com', 1),
(46, 'eclipse', '$2y$10$gLnghAsGs9vuGHYqjRGt3OwnMce4APdzVGuTXzsgbU6Mss1OWl5Wy', '', 'eclipse@mail.com', 1),
(47, 'infinity', '$2y$10$rjKkavXpyuJQ7S4TXjBOGuZmtyk.YUXrg/yuEshVx6k56vnYsrb..', '', 'infinity@mail.com', 1),
(48, 'orion', '$2y$10$CPP2FcUACyqfwCtgVNRyxedzO2e8.Dz2R8Rn/5H9QOiv4bvQ7aPMm', '', 'orion@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `list_users`
--
ALTER TABLE `list_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `tasksListId` (`tasksListId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `tasksListId` (`tasksListId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `tasks_list`
--
ALTER TABLE `tasks_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `categoryId` (`categoryId`),
  ADD KEY `statusId` (`statusId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `team_users`
--
ALTER TABLE `team_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `teamId` (`teamId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `list_users`
--
ALTER TABLE `list_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `tasks_list`
--
ALTER TABLE `tasks_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `team_users`
--
ALTER TABLE `team_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `list_users`
--
ALTER TABLE `list_users`
  ADD CONSTRAINT `list_users_ibfk_1` FOREIGN KEY (`tasksListId`) REFERENCES `tasks_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `list_users_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`tasksListId`) REFERENCES `tasks_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks_list`
--
ALTER TABLE `tasks_list`
  ADD CONSTRAINT `tasks_list_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_list_ibfk_2` FOREIGN KEY (`statusId`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_list_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team_users`
--
ALTER TABLE `team_users`
  ADD CONSTRAINT `team_users_ibfk_1` FOREIGN KEY (`teamId`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `team_users_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
