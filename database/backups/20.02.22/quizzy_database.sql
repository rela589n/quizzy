-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2020 at 07:55 AM
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
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `answer_option_id` bigint(20) UNSIGNED NOT NULL,
  `is_chosen` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `answer_options`
--

CREATE TABLE `answer_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `is_right` tinyint(4) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answer_options`
--

INSERT INTO `answer_options` (`id`, `text`, `question_id`, `is_right`, `deleted_at`) VALUES
(79, 'варіант 1', 28, 0, NULL),
(80, 'варіант 2', 28, 1, NULL),
(81, 'варіант 3', 28, 1, NULL),
(283, 'asdf', 29, 1, NULL),
(284, 'jgjkh', 29, 0, NULL),
(285, 'kl', 30, 0, NULL),
(286, 'sx', 30, 1, NULL),
(287, 'sxad', 30, 0, NULL),
(288, 'їф', 31, 1, NULL),
(289, 'ааі', 31, 0, NULL),
(298, 'test', 35, 1, NULL),
(299, 'question', 35, 0, NULL),
(300, 'афів', 36, 1, NULL),
(301, 'аів', 36, 0, NULL),
(302, 'second answer', 26, 1, NULL),
(303, 'check third', 26, 0, NULL),
(304, 'first answer', 27, 0, NULL),
(305, 'second answer', 27, 1, NULL),
(306, 'third one', 27, 0, NULL),
(412, 'qa', 34, 0, '2020-02-18 10:38:33'),
(423, 'kkkkk', 38, 1, NULL),
(424, 'asdf', 34, 0, NULL),
(425, '123', 34, 1, NULL),
(428, 'fdsf', 40, 0, '2020-02-18 12:10:31'),
(429, 'fsdfg', 40, 1, '2020-02-18 12:10:31'),
(431, 'cccc', 41, 1, NULL),
(433, 'sfgdfg', 38, 0, NULL),
(437, 'cc', 41, 0, NULL),
(438, 'lksjdf', 43, 0, NULL),
(439, 'lsdkfj', 43, 1, NULL),
(441, 'прор', 41, 1, NULL),
(442, 'фів', 41, 1, '2020-02-20 11:00:58'),
(443, 'fghjk', 41, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asked_questions`
--

CREATE TABLE `asked_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_result_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_02_20_180302_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `test_id`, `deleted_at`) VALUES
(26, 'first question', 8, NULL),
(27, 'second question', 8, NULL),
(28, 'Питання перше', 9, NULL),
(29, 'qwe', 10, NULL),
(30, 'ASD', 10, NULL),
(31, 'іїч', 10, NULL),
(34, 'repudiandae', 11, NULL),
(35, 'some', 16, NULL),
(36, 'фіва', 8, NULL),
(38, 'new question', 11, NULL),
(40, 'sdfs', 11, '2020-02-18 12:10:31'),
(41, 'cccc', 11, NULL),
(43, 'laskdfj', 11, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri_alias` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` smallint(5) UNSIGNED NOT NULL,
  `test_subject_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `name`, `uri_alias`, `time`, `test_subject_id`, `deleted_at`) VALUES
(1, 'mock', 'mock-updated', 100, 2, NULL),
(2, 'second mock', 'second-mock', 30, 2, NULL),
(3, 'include tests example', 'include-tests-example', 123, 2, NULL),
(4, 'include tests example', 'include-tests-example2', 123, 2, NULL),
(5, 'asdf', 'asdf', 234, 2, NULL),
(6, 'check redirect', 'check-redirect', 12, 2, NULL),
(7, 'check redirect 2', 'check-redirect-2', 12, 2, NULL),
(8, 'new hello test', 'new-hello-test-2', 11, 1, NULL),
(9, 'second hello test', 'second-hello-test', 25, 1, NULL),
(10, 'hello world', 'hello-world', 2334, 4, NULL),
(11, 'Інкапсуляція', 'encapsulation-2', 1, 7, NULL),
(12, 'Екзамен', 'exam', 30, 7, NULL),
(13, 'hello world', 'hello-world-2', 123, 7, NULL),
(14, 'hello world', 'hello-world-3', 123, 7, NULL),
(15, 'hello world', 'hello-world-4', 123, 7, NULL),
(16, 'hello world', 'hello-world-5', 123, 7, NULL),
(17, 'helllo world', 'helllo-world', 222, 7, NULL),
(18, 'sdfghjkl', 'sdfghjkl', 123, 8, NULL);

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
(10, 17, 11, 999),
(11, 17, 17, 999),
(14, 11, 11, 999),
(16, 18, 18, 999),
(17, 8, 8, 30),
(18, 8, 9, 20),
(19, 9, 9, 1),
(22, 16, 16, 999);

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `patronymic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `patronymic`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Eugene', '', '', 'zsidelnik@gmail.com', NULL, '$2y$10$xDdWUrkpwUTHFXS3laVIAOF.DFpd4wAHynCTPznVZHaKZeti7K7ku', NULL, '2020-02-21 02:09:37', '2020-02-21 02:09:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answer_option_id` (`answer_option_id`);

--
-- Indexes for table `answer_options`
--
ALTER TABLE `answer_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_question` (`question_id`);

--
-- Indexes for table `asked_questions`
--
ALTER TABLE `asked_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_result_id` (`test_result_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_test` (`test_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `answer_options`
--
ALTER TABLE `answer_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=444;

--
-- AUTO_INCREMENT for table `asked_questions`
--
ALTER TABLE `asked_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `test_composite`
--
ALTER TABLE `test_composite`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_subjects`
--
ALTER TABLE `test_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer_options`
--
ALTER TABLE `answer_options`
  ADD CONSTRAINT `answer_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

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
