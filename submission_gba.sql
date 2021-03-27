-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 23, 2020 lúc 03:20 PM
-- Phiên bản máy phục vụ: 10.1.32-MariaDB
-- Phiên bản PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `submission_gba`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `first_model`
--

CREATE TABLE `first_model` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_code` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_code` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_file_cts` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_list` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asignment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `ratio_assignment` int(11) DEFAULT '0',
  `ratio_check_file` int(11) DEFAULT '0',
  `ratio_check_list` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `first_model`
--

INSERT INTO `first_model` (`id`, `submission_id`, `device_code`, `model_name`, `sale_code`, `check_file_cts`, `check_list`, `asignment`, `status`, `type`, `ratio_assignment`, `ratio_check_file`, `ratio_check_list`, `created_at`, `updated_at`) VALUES
(15, 'Test Type 1.2', '111', '111', '111', '2', '3', NULL, 4, 0, 0, 60, 40, '2020-02-16 07:27:50', '2020-02-23 05:41:12'),
(16, 'Test Type 2.3', '222', '222', '2222', NULL, NULL, '5', 4, 2, 20, 0, 0, '2020-02-16 07:28:17', '2020-02-16 07:29:28'),
(17, 'Test Type 3.1', '333', '333', '333', '2', '1', NULL, 2, 0, 0, 60, 40, '2020-02-16 07:28:50', '2020-02-16 07:29:09'),
(18, '00001', '1100', '0010101', '1111', '2', '5', NULL, 1, 1, 0, 50, 50, '2020-02-22 06:23:10', '2020-02-23 01:38:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(0, '2019_11_20_133651_add_column_week_on_table_submission', 2),
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_10_27_024612_create_table_submission', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `submission`
--

CREATE TABLE `submission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_code` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ap_version` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modem_version` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `csc_version` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_csc` int(11) DEFAULT NULL,
  `approval_type` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reviewer` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pl_email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_model` tinyint(1) NOT NULL DEFAULT '0',
  `svmc_project` tinyint(1) NOT NULL DEFAULT '0',
  `submit_date_time` datetime DEFAULT NULL,
  `svmc_review_date` datetime DEFAULT NULL,
  `urgent_mark` tinyint(1) NOT NULL DEFAULT '0',
  `week` int(11) NOT NULL DEFAULT '0',
  `svmc_review_status` int(11) DEFAULT NULL,
  `svmc_comment` text COLLATE utf8mb4_unicode_ci,
  `progress` int(11) DEFAULT NULL,
  `google_review_status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `submission`
--

INSERT INTO `submission` (`id`, `submission_id`, `device_code`, `ap_version`, `modem_version`, `csc_version`, `total_csc`, `approval_type`, `reviewer`, `pl_email`, `first_model`, `svmc_project`, `submit_date_time`, `svmc_review_date`, `urgent_mark`, `week`, `svmc_review_status`, `svmc_comment`, `progress`, `google_review_status`, `created_at`, `updated_at`) VALUES
(27, 'Test 1', 'Test 1', 'Test 1', 'Test 1', 'Test 1', 10, 'Regular', '1', 'fsdf@gmail.com', 1, 1, '2020-02-01 02:01:00', '2020-02-02 00:00:00', 1, 5, 1, NULL, 1, 1, '2020-02-22 22:20:18', '2020-02-22 22:20:18'),
(28, 'Test 2', 'Test 2', 'Test 2', 'Test 2', 'Test 2', 11, 'Regular', '1', 'fsdf@gmail.com', 1, 1, '2020-02-08 11:11:00', '2020-02-15 00:00:00', 1, 6, 1, NULL, 1, 1, '2020-02-22 22:23:13', '2020-02-22 22:23:13'),
(29, 'Test 3', 'Test 3', 'Test 3', 'Test 3', 'Test 3', 13, 'Regular', '1', 'fsdf@gmail.com', 1, 1, '2020-02-08 09:09:00', '2020-02-15 00:00:00', 1, 6, 1, 'sasasassa', 1, 1, '2020-02-22 22:23:56', '2020-02-22 22:23:56'),
(30, 'Test 4', 'Test 4', 'Test 4', 'Test 4', 'Test 4', 14, 'Normal', '1', 'fsdf@gmail.com', 1, 1, '2020-02-21 09:09:00', '2020-02-23 00:00:00', 1, 8, 2, NULL, 1, 1, '2020-02-22 22:24:46', '2020-02-22 22:24:46'),
(31, 'Test 5', 'Test 5', 'Test 5', 'Test 5', 'Test 5', 14, 'Normal', '1', 'fsdf@gmail.com', 1, 1, '2020-02-23 05:25:25', '2020-02-14 00:00:00', 1, 8, 1, NULL, 1, 1, '2020-02-22 22:25:25', '2020-02-22 22:25:25'),
(33, 'Test 7', 'Test 7', 'Test 7', 'Test 7', 'Test 7', 11, 'Regular', '1', 'fsdf@gmail.com', 0, 1, '2020-02-08 09:09:00', '2020-02-21 00:00:00', 1, 6, 1, NULL, 1, 1, '2020-02-22 22:26:59', '2020-02-22 22:26:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ng.thanhtuan', 'ng.thanhtuan@gmail.com', NULL, '$2y$10$x5IB64Tt0pB8UEpBMooCJuPNZgzY9VBYL5f6eVrPdrJlqDDLfgTwS', NULL, NULL, '2019-12-22 04:40:43'),
(2, 'hoangluan0207', 'hoangluan0207@gmail.com', NULL, '$2y$10$2UTHFSlEsnYYSa2CQ.X9RedXqWj3fDlhcLBaLJeI0fQBj7VYFZEUC', NULL, NULL, '2019-11-21 04:45:20'),
(3, 'admin_demo131', 'admin1_demo123@gmail.com', NULL, '$2y$10$gFS4lz3mKltuuswuL/SFi.q.FHGRSSuOgn5WCcfVhLVtIfqaWM6dq', NULL, NULL, NULL),
(4, 'HoangLuan', 'HoangLuan12@gmail.com', NULL, '$2y$10$IJm0xkB4CVtOhsPzioKYIOmJawwqmtyCvDIjk88NGI1nZR5mCi2Ze', NULL, '2019-12-19 07:10:30', '2019-12-19 07:10:30'),
(5, 'HoangLuan1', 'HoangLuan123@gmail.com', NULL, '$2y$10$P5yGfou0n2Aou7B1ykuRyOlbKb5fGfkslvLwrSqtG20KBvqwGK4AO', NULL, '2019-12-22 01:41:42', '2019-12-22 01:41:42'),
(6, 'thang.dv', 'thang.dv@gmail.com', NULL, '$2y$10$VdfzEzW/rJk4fGLvTN7WLevIiNkkxCY95b7/4jyPyKniprK5.7lYa', NULL, '2019-12-22 04:35:53', '2019-12-22 04:35:53');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `first_model`
--
ALTER TABLE `first_model`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Chỉ mục cho bảng `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `first_model`
--
ALTER TABLE `first_model`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `submission`
--
ALTER TABLE `submission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
