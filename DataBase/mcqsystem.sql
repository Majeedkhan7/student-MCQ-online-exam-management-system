-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2022 at 07:13 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcqsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `option_id` int(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `exam_id` int(10) NOT NULL,
  `question_result` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `dateandtime` datetime NOT NULL,
  `duration` varchar(40) NOT NULL,
  `teacherid` int(10) NOT NULL,
  `status` varchar(45) NOT NULL,
  `updatedate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `name`, `dateandtime`, `duration`, `teacherid`, `status`, `updatedate`) VALUES
(1, 'php', '2022-07-11 09:00:00', '45', 2, 'published', '2022-07-02 05:54:06'),
(2, 'JavaScript', '2022-07-04 08:29:00', '2', 2, 'published', '2022-07-04 02:59:58'),
(3, 'CSS', '2022-07-08 01:00:00', '45', 2, 'draft', '2022-07-02 06:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `optionvalue` varchar(200) NOT NULL,
  `questionId` int(11) NOT NULL,
  `iscoorect` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `optionvalue`, `questionId`, `iscoorect`) VALUES
(1, 'Hypertext Preprocessor', 1, '1'),
(2, 'Pretext Hypertext Preprocessor', 1, '0'),
(3, 'Personal Home Processor', 1, '0'),
(4, 'None of the above', 1, '0'),
(5, 'Drek Kolkevi', 2, '0'),
(6, 'List Barely', 2, '0'),
(7, 'Rasmus Lerdrof', 2, '1'),
(8, 'None of the above', 2, '0'),
(9, '! (Exclamation)', 3, '0'),
(10, '$ (Dollar)', 3, '1'),
(11, '& (Ampersand)', 3, '0'),
(12, '# (Hash)', 3, '0'),
(13, 'Object-Oriented', 4, '0'),
(14, 'Object-Based', 4, '1'),
(15, 'Assembly-language', 4, '0'),
(16, 'High-level', 4, '0'),
(17, 'Alternative to if-else', 5, '0'),
(18, 'Switch statement', 5, '0'),
(19, 'If-then-else statement', 5, '0'),
(20, 'immediate if', 5, '1'),
(21, 'Conditional block', 6, '0'),
(22, 'block that combines a number of statements into a single compound statement', 6, '1'),
(23, 'both conditional block and a single statement', 6, '0'),
(24, 'block that contains a single statement', 6, '0'),
(25, 'Shows a warning', 7, '0'),
(26, 'Prompts to complete the statement', 7, '0'),
(27, 'Throws an error', 7, '0'),
(28, 'Ignores the statements', 7, '1'),
(29, 'Cascade style sheets', 8, '0'),
(30, 'Color and style sheets', 8, '0'),
(31, 'Cascading style sheets', 8, '1'),
(32, 'None of the above', 8, '0'),
(33, 'bgcolor', 9, '0'),
(34, 'color', 9, '0'),
(35, 'background-color', 9, '1'),
(36, 'All of the above', 9, '0');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `questionNo` varchar(10) NOT NULL,
  `Question` varchar(200) NOT NULL,
  `examid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `questionNo`, `Question`, `examid`) VALUES
(1, '1', 'PHP stands for -', 1),
(2, '2', 'Who is known as the father of PHP?', 1),
(3, '3', 'Variable name in PHP starts with -', 1),
(4, '1', 'Which type of JavaScript language is ___', 2),
(5, '2', 'Which one of the following also known as Conditional Expression:', 2),
(6, '3', 'In JavaScript, what is a block of statement?', 2),
(7, '4', 'When interpreter encounters an empty statements, what it will do:', 2),
(8, '1', 'CSS stands for -', 3),
(9, '2', 'The property in CSS used to change the background color of an element is -', 3);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phoneno` varchar(15) NOT NULL,
  `user_login_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `address`, `phoneno`, `user_login_id`) VALUES
(2, 'Davoli', 'trinco', '0753462584', 1),
(4, 'student2', 'Colombo', '0261548115', 3),
(5, 'student3', 'Kandy', '0753462949', 4);

-- --------------------------------------------------------

--
-- Table structure for table `student_has_exam`
--

CREATE TABLE `student_has_exam` (
  `id` int(11) NOT NULL,
  `student_id` int(10) NOT NULL,
  `Exam_id` int(10) NOT NULL,
  `Examstatus` varchar(45) NOT NULL,
  `result` int(45) NOT NULL DEFAULT 0,
  `GRADE` varchar(10) NOT NULL,
  `ExamResult` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phoneno` varchar(15) NOT NULL,
  `user_login_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `address`, `phoneno`, `user_login_id`) VALUES
(1, 'Fuller', 'Colombo', '07156235', 2),
(2, 'Teacher2', 'Trincomalee', '0753462548', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users_login`
--

CREATE TABLE `users_login` (
  `id` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `usertype` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_login`
--

INSERT INTO `users_login` (`id`, `email`, `password`, `usertype`) VALUES
(1, 'student@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'Student'),
(2, 'Teacher@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'Teacher'),
(3, 'student2@gmail.com', '213ee683360d88249109c2f92789dbc3', 'Student'),
(4, 'student3@gmail.com', '8e4947690532bc44a8e41e9fb365b76a', 'Student'),
(5, 'teacher2@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'Teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_has_exam`
--
ALTER TABLE `student_has_exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_login`
--
ALTER TABLE `users_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_has_exam`
--
ALTER TABLE `student_has_exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_login`
--
ALTER TABLE `users_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
