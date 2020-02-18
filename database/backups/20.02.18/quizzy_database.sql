-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2020 at 01:25 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizzy_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer_options`
--

CREATE TABLE `answer_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `is_right` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answer_options`
--

INSERT INTO `answer_options` (`id`, `text`, `question_id`, `is_right`) VALUES
(79, 'варіант 1', 28, 0),
(80, 'варіант 2', 28, 1),
(81, 'варіант 3', 28, 1),
(283, 'asdf', 29, 1),
(284, 'jgjkh', 29, 0),
(285, 'kl', 30, 0),
(286, 'sx', 30, 1),
(287, 'sxad', 30, 0),
(288, 'їф', 31, 1),
(289, 'ааі', 31, 0),
(298, 'test', 35, 1),
(299, 'question', 35, 0),
(300, 'афів', 36, 1),
(301, 'аів', 36, 0),
(302, 'second answer', 26, 1),
(303, 'check third', 26, 0),
(304, 'first answer', 27, 0),
(305, 'second answer', 27, 1),
(306, 'third one', 27, 0),
(412, 'qa', 34, 0),
(423, 'kkkkk', 38, 1),
(424, 'asdf', 34, 0),
(425, '123', 34, 1),
(428, 'fdsf', 40, 0),
(429, 'fsdfg', 40, 1),
(431, 'cccc', 41, 1),
(433, 'sfgdfg', 38, 0),
(437, 'cc', 41, 0),
(438, 'lksjdf', 43, 0),
(439, 'lsdkfj', 43, 1),
(440, 'lkasdjf', 43, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `test_id`) VALUES
(26, 'first question', 8),
(27, 'second question', 8),
(28, 'Питання перше', 9),
(29, 'qwe', 10),
(30, 'ASD', 10),
(31, 'іїч', 10),
(34, 'repudiandae', 11),
(35, 'some', 16),
(36, 'фіва', 8),
(38, 'new question', 11),
(40, 'sdfs', 11),
(41, 'cccc', 11),
(43, 'laskdfj', 11);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri_alias` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` smallint(5) UNSIGNED NOT NULL,
  `test_subject_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `name`, `uri_alias`, `time`, `test_subject_id`) VALUES
(1, 'mock', 'mock-updated', 100, 2),
(2, 'second mock', 'second-mock', 30, 2),
(3, 'include tests example', 'include-tests-example', 123, 2),
(4, 'include tests example', 'include-tests-example2', 123, 2),
(5, 'asdf', 'asdf', 234, 2),
(6, 'check redirect', 'check-redirect', 12, 2),
(7, 'check redirect 2', 'check-redirect-2', 12, 2),
(8, 'new hello test', 'new-hello-test-2', 11, 1),
(9, 'second hello test', 'second-hello-test', 25, 1),
(10, 'hello world', 'hello-world', 2334, 4),
(11, 'Інкапсуляція', 'encapsulation-2', 123, 7),
(12, 'Екзамен', 'exam', 30, 7),
(13, 'hello world', 'hello-world-2', 123, 7),
(14, 'hello world', 'hello-world-3', 123, 7),
(15, 'hello world', 'hello-world-4', 123, 7),
(16, 'hello world', 'hello-world-5', 123, 7),
(17, 'helllo world', 'helllo-world', 222, 7),
(18, 'sdfghjkl', 'sdfghjkl', 123, 8);

-- --------------------------------------------------------

--
-- Table structure for table `test_composite`
--

CREATE TABLE `test_composite` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_test` bigint(20) UNSIGNED NOT NULL,
  `id_include_test` bigint(20) UNSIGNED NOT NULL,
  `questions_quantity` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_composite`
--

INSERT INTO `test_composite` (`id`, `id_test`, `id_include_test`, `questions_quantity`) VALUES
(1, 1, 2, 20),
(2, 1, 1, 0),
(3, 2, 2, 0),
(4, 3, 1, 123),
(6, 12, 11, 2),
(7, 13, 11, 1),
(8, 16, 11, 2),
(9, 16, 16, 999),
(10, 17, 11, 999),
(11, 17, 17, 999),
(14, 11, 11, 1),
(15, 11, 16, 999),
(16, 18, 18, 999),
(17, 8, 8, 30),
(18, 8, 9, 20),
(19, 9, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `test_subjects`
--

CREATE TABLE `test_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri_alias` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_subjects`
--

INSERT INTO `test_subjects` (`id`, `name`, `uri_alias`, `course`) VALUES
(1, 'hello world', 'hello-world2', '4'),
(2, 'Алгоритми', 'algorithms', '3'),
(3, 'алгоритми та структури даних', 'alhorytmy-ta-struktury-danykh', '1'),
(4, 'check', 'check', '1'),
(5, 'asdsf', 'asdf', '1'),
(6, 'hello2', 'world2', '3'),
(7, 'ООП', 'ooop', '3'),
(8, 'dfghjkl', 'dfghjkl', '3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer_options`
--
ALTER TABLE `answer_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_question` (`question_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_test` (`test_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uri_alias` (`uri_alias`),
  ADD KEY `id_subject` (`test_subject_id`);

--
-- Indexes for table `test_composite`
--
ALTER TABLE `test_composite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_test` (`id_test`),
  ADD KEY `id_include_test` (`id_include_test`);

--
-- Indexes for table `test_subjects`
--
ALTER TABLE `test_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uri_alias` (`uri_alias`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer_options`
--
ALTER TABLE `answer_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=441;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `test_composite`
--
ALTER TABLE `test_composite`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `test_subjects`
--
ALTER TABLE `test_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer_options`
--
ALTER TABLE `answer_options`
  ADD CONSTRAINT `answer_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`test_subject_id`) REFERENCES `test_subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test_composite`
--
ALTER TABLE `test_composite`
  ADD CONSTRAINT `test_composite_ibfk_1` FOREIGN KEY (`id_test`) REFERENCES `tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `test_composite_ibfk_2` FOREIGN KEY (`id_include_test`) REFERENCES `tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
