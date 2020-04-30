-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2020 at 11:09 PM
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
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_changed` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `name`, `surname`, `patronymic`, `email`, `email_verified_at`, `password`, `password_changed`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '', 'system', '', 'system', NULL, '$2y$10$wCVL.Bjyxu/dibacq5phHOgoPDWKZlNjCkFNZ.uGsV.yY4yGgJzu6', 0, NULL, '2020-04-30 18:09:31', '2020-04-30 18:09:31'),
(2, 'Євген', 'Григоровський', 'Сергійович', 'admin', NULL, '$2y$10$2qPFWZymjwR7N/MVXug2v.eRAaP40xhI.hbBDQN0X6YU6X0halZjq', 0, NULL, '2020-04-30 18:09:31', '2020-04-30 18:09:31');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `answer_option_id` bigint(20) UNSIGNED NOT NULL,
  `asked_question_id` bigint(20) UNSIGNED NOT NULL,
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
(4, '2020_02_20_180302_create_permission_tables', 1),
(5, '2020_02_22_070025_create_test_subjects_table', 1),
(6, '2020_02_22_070742_create_tests_table', 1),
(7, '2020_02_22_071634_create_questions_table', 1),
(8, '2020_02_22_072544_create_test_composite_table', 1),
(9, '2020_02_22_073712_create_answer_options_table', 1),
(10, '2020_02_22_074607_create_test_results_table', 1),
(11, '2020_02_22_080043_create_full_name_to_users_table', 1),
(12, '2020_02_22_081409_create_asked_questions_table', 1),
(13, '2020_02_22_082021_create_answers_table', 1),
(14, '2020_02_25_151616_create_administrators_table', 1),
(15, '2020_02_27_095528_append_password_changed_flag_on_users_table', 1),
(16, '2020_02_29_084825_create_student_groups_table', 1),
(17, '2020_02_29_085312_append_group_id_on_users_table', 1),
(18, '2020_03_15_213116_add_public_name_on_permissions_table', 1),
(19, '2020_03_15_214421_add_public_name_on_roles_table', 1),
(20, '2020_04_01_144350_add_created_by_to_student_groups_table', 1),
(21, '2020_04_14_053210_change_email_size_on_administrators_table', 1),
(22, '2020_04_14_054739_change_email_size_on_users_table', 1),
(23, '2020_04_24_182336_add_created_by_field_on_tests_table', 1),
(24, '2020_04_30_162442_reduce_model_type_size_on_permissions_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(96) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(96) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Administrator', 1),
(1, 'App\\Models\\Administrator', 2);

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
  `public_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `public_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'access-administrators', 'Доступ до управління адміністраторами (пункт меню)', 'admin', '2020-04-30 18:09:29', '2020-04-30 18:09:29'),
(2, 'create-administrators', 'Реєстрація адміністраторів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(3, 'view-administrators', 'Перегляд адміністраторів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(4, 'update-administrators', 'Редагування адміністраторів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(5, 'delete-administrators', 'Видалення адміністраторів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(6, 'access-groups', 'Доступ до груп (пункт меню)', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(7, 'create-groups', 'Створення груп', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(8, 'view-groups', 'Перегляд груп', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(9, 'update-groups', 'Налаштування груп', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(10, 'delete-groups', 'Видалення груп', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(11, 'create-students', 'Реєстрація студентів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(12, 'view-students', 'Перегляд студентів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(13, 'update-students', 'Редагування студентів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(14, 'delete-students', 'Видалення студенів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(15, 'access-subjects', 'Доступ до тестів (пункт меню)', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(16, 'create-subjects', 'Створення предметів тестування', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(17, 'view-subjects', 'Перегляд предметів тестування', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(18, 'update-subjects', 'Налаштування предметів тестування', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(19, 'delete-subjects', 'Видалення предметів тестування', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(20, 'create-tests', 'Створення тестів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(21, 'view-tests', 'Перегляд тестів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(22, 'update-tests', 'Налаштування тестів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(23, 'delete-tests', 'Видалення тестів', 'admin', '2020-04-30 18:09:30', '2020-04-30 18:09:30'),
(24, 'view-results', 'Перегляд результатів', 'admin', '2020-04-30 18:09:31', '2020-04-30 18:09:31'),
(25, 'generate-group-statement', 'Створення відомості по групі', 'admin', '2020-04-30 18:09:31', '2020-04-30 18:09:31'),
(26, 'generate-student-statement', 'Створення відомості по студенту', 'admin', '2020-04-30 18:09:31', '2020-04-30 18:09:31');

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

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `public_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super-admin', 'Адміністратор', 'admin', '2020-04-30 18:09:31', '2020-04-30 18:09:31'),
(2, 'teacher', 'Викладач', 'admin', '2020-04-30 18:09:31', '2020-04-30 18:09:31'),
(3, 'class-monitor', 'Староста', 'admin', '2020-04-30 18:09:31', '2020-04-30 18:09:31');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(6, 2),
(6, 3),
(7, 2),
(7, 3),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(11, 3),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(20, 2),
(21, 2),
(24, 2),
(25, 2),
(26, 2);

-- --------------------------------------------------------

--
-- Table structure for table `student_groups`
--

CREATE TABLE `student_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri_alias` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri_alias` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` smallint(5) UNSIGNED NOT NULL,
  `test_subject_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `patronymic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `student_group_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_changed` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `administrators_email_unique` (`email`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_answer_option_id_foreign` (`answer_option_id`),
  ADD KEY `answers_asked_question_id_foreign` (`asked_question_id`);

--
-- Indexes for table `answer_options`
--
ALTER TABLE `answer_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answer_options_question_id_foreign` (`question_id`);

--
-- Indexes for table `asked_questions`
--
ALTER TABLE `asked_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asked_questions_test_result_id_foreign` (`test_result_id`),
  ADD KEY `asked_questions_question_id_foreign` (`question_id`);

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
  ADD KEY `questions_test_id_foreign` (`test_id`);

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
-- Indexes for table `student_groups`
--
ALTER TABLE `student_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_groups_uri_alias_unique` (`uri_alias`),
  ADD KEY `student_groups_year_index` (`year`),
  ADD KEY `student_groups_created_by_foreign` (`created_by`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tests_uri_alias_unique` (`uri_alias`),
  ADD KEY `tests_test_subject_id_foreign` (`test_subject_id`),
  ADD KEY `tests_created_by_foreign` (`created_by`);

--
-- Indexes for table `test_composite`
--
ALTER TABLE `test_composite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_composite_id_test_foreign` (`id_test`),
  ADD KEY `test_composite_id_include_test_foreign` (`id_include_test`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_results_test_id_foreign` (`test_id`),
  ADD KEY `test_results_user_id_foreign` (`user_id`);

--
-- Indexes for table `test_subjects`
--
ALTER TABLE `test_subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_subjects_uri_alias_unique` (`uri_alias`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_student_group_id_foreign` (`student_group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `answer_options`
--
ALTER TABLE `answer_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_groups`
--
ALTER TABLE `student_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_composite`
--
ALTER TABLE `test_composite`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_subjects`
--
ALTER TABLE `test_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_answer_option_id_foreign` FOREIGN KEY (`answer_option_id`) REFERENCES `answer_options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answers_asked_question_id_foreign` FOREIGN KEY (`asked_question_id`) REFERENCES `asked_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `answer_options`
--
ALTER TABLE `answer_options`
  ADD CONSTRAINT `answer_options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asked_questions`
--
ALTER TABLE `asked_questions`
  ADD CONSTRAINT `asked_questions_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asked_questions_test_result_id_foreign` FOREIGN KEY (`test_result_id`) REFERENCES `test_results` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `questions_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_groups`
--
ALTER TABLE `student_groups`
  ADD CONSTRAINT `student_groups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `administrators` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `administrators` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tests_test_subject_id_foreign` FOREIGN KEY (`test_subject_id`) REFERENCES `test_subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test_composite`
--
ALTER TABLE `test_composite`
  ADD CONSTRAINT `test_composite_id_include_test_foreign` FOREIGN KEY (`id_include_test`) REFERENCES `tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `test_composite_id_test_foreign` FOREIGN KEY (`id_test`) REFERENCES `tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test_results`
--
ALTER TABLE `test_results`
  ADD CONSTRAINT `test_results_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `test_results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_student_group_id_foreign` FOREIGN KEY (`student_group_id`) REFERENCES `student_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
