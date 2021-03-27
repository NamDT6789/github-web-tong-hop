-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 23, 2020 lúc 03:18 PM
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

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `first_model`
--
ALTER TABLE `first_model`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `first_model`
--
ALTER TABLE `first_model`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
