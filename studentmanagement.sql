-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2020 at 12:44 PM
-- Server version: 8.0.22
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
--
-- Database: `studentmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--



CREATE TABLE `admin` (
  `id` int NOT NULL,
  `userName` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `userName`, `Password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'password', '2020-12-31 06:59:04', '2020-12-31 06:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int NOT NULL,
  `className` varchar(80) DEFAULT NULL,
  `section` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `className`, `section`, `created_at`, `updated_at`) VALUES
(1, 'Computer Science', 'A', '2020-12-31 07:12:00', '2020-12-31 07:12:00'),
(2, 'Computer Science', 'B', '2020-12-31 07:12:00', '2020-12-31 07:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `classes_has_subjects`
--

CREATE TABLE `classes_has_subjects` (
  `id` int NOT NULL,
  `class_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classes_has_subjects`
--

INSERT INTO `classes_has_subjects` (`id`, `class_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2020-12-31 08:12:00', '2020-12-31 08:12:00'),
(2, 1, 2, '2020-12-31 09:12:00', '2020-12-31 09:12:00'),
(3, 2, 1, '2020-12-31 10:12:00', '2020-12-31 10:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `class_id` int NOT NULL,
  `marks` varchar(45) DEFAULT NULL,
  `posted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_id`, `subject_id`, `class_id`, `marks`, `posted_at`, `updated_at`) VALUES
(1, 1, 2, 1, '100', '2020-12-31 10:12:00', '2020-12-31 10:12:00'),
(2, 1, 1, 1, '60', '2020-12-31 10:12:00', '2020-12-31 10:12:00'),
(3, 2, 1, 2, '70', '2020-12-31 10:12:00', '2020-12-31 10:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentId` int NOT NULL,
  `studentName` varchar(100) DEFAULT NULL,
  `rollId` varchar(100) DEFAULT NULL,
  `studentEmail` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `DOB` varchar(100) DEFAULT NULL,
  `class_id` int NOT NULL,
  `registered_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentId`, `studentName`, `rollId`, `studentEmail`, `gender`, `DOB`, `class_id`, `registered_at`, `updated_at`) VALUES
(1, 'dano', '123456', 'dano@gmail.com', 'male', '2020-12-07', 1, '2020-12-31 07:12:00', '2020-12-31 07:12:00'),
(2, 'thyda', '123457', 'thyda@gmail.com', 'male', '2020-12-09', 2, '2020-12-31 08:12:00', '2020-12-31 08:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subjectId` int NOT NULL,
  `subjectName` varchar(100) DEFAULT NULL,
  `subjectCode` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subjectId`, `subjectName`, `subjectCode`, `created_at`, `updated_at`) VALUES
(1, 'Math', 'M', '2020-12-31 08:12:00', '2020-12-31 08:12:00'),
(2, 'Coding', 'C', '2020-12-31 09:12:00', '2020-12-31 09:12:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes_has_subjects`
--
ALTER TABLE `classes_has_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studentId`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subjectId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `classes_has_subjects`
--
ALTER TABLE `classes_has_subjects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `studentId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subjectId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes_has_subjects`
--
ALTER TABLE `classes_has_subjects`
  ADD CONSTRAINT `classes_has_subjects_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_has_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subjectId`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`studentId`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subjectId`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
