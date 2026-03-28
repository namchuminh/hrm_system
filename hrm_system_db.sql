-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2026 at 11:26 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrm_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `status` enum('P','V','M') DEFAULT 'P',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `employee_id`, `shift_id`, `date`, `check_in`, `check_out`, `ip_address`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2026-03-27', '2026-03-27 08:00:00', '2026-03-27 12:03:21', '127.0.0.1', 'P', '2026-03-27 04:35:58', '2026-03-27 05:03:21'),
(2, 1, NULL, '2026-03-28', '2026-03-28 13:20:16', '2026-03-28 13:20:24', NULL, 'P', '2026-03-28 06:20:16', '2026-03-28 06:20:24'),
(3, 2, NULL, '2026-03-28', '2026-03-28 13:23:05', '2026-03-28 13:23:07', NULL, 'P', '2026-03-28 06:23:05', '2026-03-28 06:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `status` enum('Phỏng vấn','Đạt','Loại') DEFAULT 'Phỏng vấn',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `job_id`, `full_name`, `email`, `cv_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Trần Thị Ứng Viên', 'candidate1@gmail.com', NULL, 'Đạt', '2026-03-27 04:35:58', '2026-03-27 23:15:36'),
(2, 1, 'Nguyễn Văn An', 'nguyenvana@gmail.com', NULL, 'Đạt', '2026-03-28 10:01:31', '2026-03-28 10:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `contract_number` varchar(100) NOT NULL,
  `type` enum('Thời hạn','Vô thời hạn') NOT NULL,
  `salary_amount` decimal(15,2) DEFAULT NULL,
  `probation_salary` decimal(15,2) DEFAULT NULL,
  `working_time` varchar(255) NOT NULL DEFAULT '08:00 - 17:00',
  `allowances_text` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `employee_id`, `contract_number`, `type`, `salary_amount`, `probation_salary`, `working_time`, `allowances_text`, `start_date`, `end_date`, `file_path`, `created_at`, `updated_at`) VALUES
(1, 1, 'HĐ-2026-001', 'Vô thời hạn', NULL, NULL, '08:00 - 17:00', NULL, '2025-03-27', NULL, NULL, '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(2, 2, 'HĐ-2026-002', 'Thời hạn', NULL, NULL, '08:00 - 17:00', NULL, '2025-09-27', '2027-03-27', NULL, '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(3, 3, 'HĐ-2026-003', 'Vô thời hạn', NULL, NULL, '08:00 - 17:00', NULL, '2025-09-27', NULL, NULL, '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(4, 4, 'HĐ-2026-004', 'Thời hạn', NULL, NULL, '08:00 - 17:00', NULL, '2025-09-27', '2027-03-27', NULL, '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(5, 5, 'HĐ-2028-NVA', 'Thời hạn', 0.00, NULL, '08 giờ/ngày (48 giờ/tuần)', NULL, '2026-03-28', '2028-03-28', NULL, '2026-03-28 10:02:49', '2026-03-28 10:02:49');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `manager_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Phòng Nhân sự', 'HR', 1, 'Quản lý nhân sự và tuyển dụng', '2026-03-27 04:33:29', '2026-03-27 05:55:08'),
(2, 'Phòng Kỹ thuật', 'TECH', NULL, 'Phát triển phần mềm và hạ tầng', '2026-03-27 04:33:29', '2026-03-27 04:33:29'),
(3, 'Phòng Kinh doanh', 'SALES', NULL, 'Kinh doanh và tiếp thị', '2026-03-27 04:33:29', '2026-03-27 04:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `education_histories`
--

CREATE TABLE `education_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `school` varchar(255) DEFAULT NULL,
  `major` varchar(255) DEFAULT NULL,
  `degree` varchar(100) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `transcript_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `education_histories`
--

INSERT INTO `education_histories` (`id`, `employee_id`, `school`, `major`, `degree`, `year`, `transcript_image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Đại học Bách Khoa', 'Công nghệ thông tin', 'Kỹ sư', 2020, NULL, '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(2, 2, 'Đại học Bách Khoa', 'Công nghệ thông tin', 'Kỹ sư', 2019, NULL, '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(3, 3, 'Đại học Bách Khoa', 'Công nghệ thông tin', 'Kỹ sư', 2018, NULL, '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(5, 4, 'Đại học Xây dựng HN', 'Công nghệ thông tin', 'Kỹ sư', 2026, NULL, '2026-03-28 09:39:04', '2026-03-28 09:39:04');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dept_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pos_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_code` varchar(20) NOT NULL,
  `identity_number` varchar(255) DEFAULT NULL,
  `identity_date` date DEFAULT NULL,
  `identity_place` varchar(255) DEFAULT NULL,
  `social_insurance_number` varchar(255) DEFAULT NULL,
  `tax_code` varchar(255) DEFAULT NULL,
  `bank_account` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) NOT NULL DEFAULT 'Việt Nam',
  `education` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `gender` enum('Nam','Nữ','Khác') DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pob` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `status` enum('Đang làm','Nghỉ việc','Thử việc') DEFAULT 'Thử việc',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `dept_id`, `pos_id`, `employee_code`, `identity_number`, `identity_date`, `identity_place`, `social_insurance_number`, `tax_code`, `bank_account`, `bank_name`, `nationality`, `education`, `full_name`, `avatar`, `gender`, `marital_status`, `dob`, `pob`, `phone`, `address`, `join_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 'NV_ADM985', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Việt Nam', NULL, 'Quản trị viên', NULL, 'Nam', NULL, NULL, NULL, NULL, NULL, '2025-03-27', 'Đang làm', '2026-03-27 04:35:58', '2026-03-27 05:30:38'),
(2, 2, NULL, NULL, 'NV_HRM423', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Việt Nam', NULL, 'Nhân sự', NULL, 'Nam', NULL, NULL, NULL, NULL, NULL, NULL, 'Đang làm', '2026-03-27 05:30:20', '2026-03-27 05:30:38'),
(3, 3, 1, 1, 'NV_ACC707', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Việt Nam', NULL, 'Kế toán', NULL, 'Nam', NULL, NULL, NULL, NULL, NULL, '2026-03-27', 'Đang làm', '2026-03-27 05:30:38', '2026-03-27 06:31:47'),
(4, 4, 1, 2, 'NV_EMP558', '001100005656', '2019-03-28', 'Hà Nội', NULL, NULL, NULL, NULL, 'Việt Nam', 'Đại học', 'Nhân viên mẫu', 'avatars/cn8vsqtquKCH1snocAfU7k8idOydRR1JrtyKA5wB.jpg', 'Nam', NULL, '2000-03-28', 'Hà Nội', '0399888666', 'Hà Nội', '2026-03-28', 'Đang làm', '2026-03-27 05:30:38', '2026-03-28 09:12:55'),
(5, 5, 2, 2, 'NV0005', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Việt Nam', NULL, 'Nguyễn Văn An', 'avatars/y10iIIxtI7K3jBU74C0fPojSHBd83w8pd1zTGgta.jpg', 'Nữ', NULL, '2001-03-28', 'Hà Nội', NULL, NULL, '2026-03-28', 'Đang làm', '2026-03-28 10:01:42', '2026-03-28 10:05:30');

-- --------------------------------------------------------

--
-- Table structure for table `employee_allowances`
--

CREATE TABLE `employee_allowances` (
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `allowance_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_trainings`
--

CREATE TABLE `employee_trainings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `result` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employee_trainings`
--

INSERT INTO `employee_trainings` (`id`, `employee_id`, `course_id`, `result`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Xuất sắc', '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(2, 2, 1, 'Xuất sắc', '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(3, 3, 1, 'Xuất sắc', '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(4, 1, 2, 'Xuất sắc', '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(5, 2, 2, 'Xuất sắc', '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(6, 3, 2, 'Xuất sắc', '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(7, 1, 3, 'Xuất sắc', '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(8, 2, 3, 'Xuất sắc', '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(9, 3, 3, 'Xuất sắc', '2026-03-27 05:35:40', '2026-03-27 05:35:40');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `deadline` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `title`, `description`, `quantity`, `deadline`, `created_at`, `updated_at`) VALUES
(1, 'Lập trình viên Laravel Senior', 'Phát triển các hệ thống quản trị nội bộ.', 2, '2026-04-27', '2026-03-27 04:35:58', '2026-03-27 04:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('Chờ duyệt','Đồng ý','Từ chối') DEFAULT 'Chờ duyệt',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employee_id`, `leave_type_id`, `start_date`, `end_date`, `reason`, `status`, `approved_by`, `created_at`, `updated_at`) VALUES
(3, 4, 2, '2026-03-28', '2026-03-28', 'Nghỉ ốm', 'Từ chối', NULL, '2026-03-28 06:40:51', '2026-03-28 06:59:03'),
(4, 4, 1, '2026-03-28', '2026-03-29', 'Nghỉ có việc riêng', 'Đồng ý', NULL, '2026-03-28 06:58:38', '2026-03-28 06:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `days_allowed` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `days_allowed`, `created_at`, `updated_at`) VALUES
(1, 'Nghỉ phép năm', 12, '2026-03-27 04:35:59', '2026-03-27 04:35:59'),
(2, 'Nghỉ ốm', 5, '2026-03-27 04:35:59', '2026-03-27 04:35:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_03_27_110844_create_role_user_table', 1),
(2, '2026_03_27_134913_create_notifications_table', 2),
(3, '2024_03_28_000000_add_avatar_to_employees_table', 3),
(4, '2024_03_28_000001_expand_employee_and_contract_fields', 4),
(5, '2024_03_28_000002_add_legal_fields_to_employees_table', 5),
(6, '2026_03_28_162025_create_system_settings_table', 6),
(7, '2026_03_28_163225_add_transcript_image_to_education_histories', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('20de7637-7d30-4dfb-97a1-ab6891fcee27', 'App\\Notifications\\LeaveRequestCreated', 'App\\Models\\User', 2, '{\"type\":\"leave_request\",\"id\":3,\"title\":\"Y\\u00eau c\\u1ea7u ngh\\u1ec9 ph\\u00e9p m\\u1edbi\",\"message\":\"Nh\\u00e2n vi\\u00ean Nh\\u00e2n vi\\u00ean m\\u1eabu \\u0111\\u00e3 t\\u1ea1o y\\u00eau c\\u1ea7u ngh\\u1ec9 ph\\u00e9p t\\u1eeb ng\\u00e0y 28\\/03\\/2026 \\u0111\\u1ebfn ng\\u00e0y 28\\/03\\/2026.\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/leave-requests?status=Ch%E1%BB%9D%20duy%E1%BB%87t\"}', NULL, '2026-03-28 06:40:51', '2026-03-28 06:40:51'),
('4f4aeeed-93aa-4c0f-82d4-30a62a7ab38f', 'App\\Notifications\\LeaveStatusUpdated', 'App\\Models\\User', 4, '{\"type\":\"leave_status\",\"id\":4,\"title\":\"\\u0110\\u01a1n ngh\\u1ec9 ph\\u00e9p c\\u1ee7a b\\u1ea1n \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c \\u0110\\u1ed3ng \\u00fd\",\"message\":\"Y\\u00eau c\\u1ea7u ngh\\u1ec9 ph\\u00e9p t\\u1eeb ng\\u00e0y 28\\/03\\/2026 \\u0111\\u1ebfn ng\\u00e0y 29\\/03\\/2026 \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c c\\u1eadp nh\\u1eadt th\\u00e0nh: \\u0110\\u1ed3ng \\u00fd.\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/leave-requests\"}', NULL, '2026-03-28 06:59:00', '2026-03-28 06:59:00'),
('80c0ffba-ac0f-4d75-b084-e9e56550e95f', 'App\\Notifications\\LeaveRequestCreated', 'App\\Models\\User', 1, '{\"type\":\"leave_request\",\"id\":3,\"title\":\"Y\\u00eau c\\u1ea7u ngh\\u1ec9 ph\\u00e9p m\\u1edbi\",\"message\":\"Nh\\u00e2n vi\\u00ean Nh\\u00e2n vi\\u00ean m\\u1eabu \\u0111\\u00e3 t\\u1ea1o y\\u00eau c\\u1ea7u ngh\\u1ec9 ph\\u00e9p t\\u1eeb ng\\u00e0y 28\\/03\\/2026 \\u0111\\u1ebfn ng\\u00e0y 28\\/03\\/2026.\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/leave-requests?status=Ch%E1%BB%9D%20duy%E1%BB%87t\"}', '2026-03-28 06:41:18', '2026-03-28 06:40:51', '2026-03-28 06:41:18'),
('9c464174-5ee3-4c8e-8f1d-8fe49560b591', 'App\\Notifications\\LeaveStatusUpdated', 'App\\Models\\User', 4, '{\"type\":\"leave_status\",\"id\":3,\"title\":\"\\u0110\\u01a1n ngh\\u1ec9 ph\\u00e9p c\\u1ee7a b\\u1ea1n \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c T\\u1eeb ch\\u1ed1i\",\"message\":\"Y\\u00eau c\\u1ea7u ngh\\u1ec9 ph\\u00e9p t\\u1eeb ng\\u00e0y 28\\/03\\/2026 \\u0111\\u1ebfn ng\\u00e0y 28\\/03\\/2026 \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c c\\u1eadp nh\\u1eadt th\\u00e0nh: T\\u1eeb ch\\u1ed1i.\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/leave-requests\"}', NULL, '2026-03-28 06:59:03', '2026-03-28 06:59:03'),
('ac28c4a8-88bc-429e-beb5-49ea69342b6a', 'App\\Notifications\\CandidateStatusUpdated', 'App\\Models\\User', 1, '{\"title\":\"C\\u1eadp nh\\u1eadt tr\\u1ea1ng th\\u00e1i \\u1ee9ng vi\\u00ean\",\"message\":\"\\u1ee8ng vi\\u00ean Tr\\u1ea7n Th\\u1ecb \\u1ee8ng Vi\\u00ean \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c chuy\\u1ec3n sang tr\\u1ea1ng th\\u00e1i: \\u0110\\u1ea1t\"}', '2026-03-27 23:15:49', '2026-03-27 23:15:36', '2026-03-27 23:15:49'),
('b189b067-7536-49e4-a604-ae5991137957', 'App\\Notifications\\CandidateStatusUpdated', 'App\\Models\\User', 1, '{\"title\":\"C\\u1eadp nh\\u1eadt tr\\u1ea1ng th\\u00e1i \\u1ee9ng vi\\u00ean\",\"message\":\"\\u1ee8ng vi\\u00ean Tr\\u1ea7n Th\\u1ecb \\u1ee8ng Vi\\u00ean \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c chuy\\u1ec3n sang tr\\u1ea1ng th\\u00e1i: Ph\\u1ecfng v\\u1ea5n\"}', '2026-03-27 23:15:47', '2026-03-27 07:21:34', '2026-03-27 23:15:47'),
('eae1b3dc-6014-49b9-80f2-3178dc58aa97', 'App\\Notifications\\LeaveRequestCreated', 'App\\Models\\User', 2, '{\"type\":\"leave_request\",\"id\":4,\"title\":\"Y\\u00eau c\\u1ea7u ngh\\u1ec9 ph\\u00e9p m\\u1edbi\",\"message\":\"Nh\\u00e2n vi\\u00ean Nh\\u00e2n vi\\u00ean m\\u1eabu \\u0111\\u00e3 t\\u1ea1o y\\u00eau c\\u1ea7u ngh\\u1ec9 ph\\u00e9p t\\u1eeb ng\\u00e0y 28\\/03\\/2026 \\u0111\\u1ebfn ng\\u00e0y 29\\/03\\/2026.\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/leave-requests?status=Ch%E1%BB%9D%20duy%E1%BB%87t\"}', NULL, '2026-03-28 06:58:38', '2026-03-28 06:58:38'),
('ecd890b4-ed8c-468e-ba1f-376035b0704c', 'App\\Notifications\\LeaveRequestCreated', 'App\\Models\\User', 1, '{\"type\":\"leave_request\",\"id\":4,\"title\":\"Y\\u00eau c\\u1ea7u ngh\\u1ec9 ph\\u00e9p m\\u1edbi\",\"message\":\"Nh\\u00e2n vi\\u00ean Nh\\u00e2n vi\\u00ean m\\u1eabu \\u0111\\u00e3 t\\u1ea1o y\\u00eau c\\u1ea7u ngh\\u1ec9 ph\\u00e9p t\\u1eeb ng\\u00e0y 28\\/03\\/2026 \\u0111\\u1ebfn ng\\u00e0y 29\\/03\\/2026.\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/leave-requests?status=Ch%E1%BB%9D%20duy%E1%BB%87t\"}', '2026-03-28 10:20:19', '2026-03-28 06:58:38', '2026-03-28 10:20:19');

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month` tinyint(4) NOT NULL,
  `year` int(11) NOT NULL,
  `total_working_days` int(11) DEFAULT 0,
  `total_salary` decimal(15,2) DEFAULT 0.00,
  `net_salary` decimal(15,2) DEFAULT 0.00,
  `status` enum('Đã thanh toán','Chưa thanh toán') DEFAULT 'Chưa thanh toán',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payrolls`
--

INSERT INTO `payrolls` (`id`, `employee_id`, `month`, `year`, `total_working_days`, `total_salary`, `net_salary`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 2026, 0, 0.00, 11000000.00, 'Chưa thanh toán', '2026-03-27 06:07:04', '2026-03-27 06:07:04');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'manage_employees', '2026-03-27 04:33:29', '2026-03-27 04:33:29'),
(2, 'manage_departments', '2026-03-27 04:33:29', '2026-03-27 04:33:29'),
(3, 'view_payroll', '2026-03-27 04:33:29', '2026-03-27 04:33:29'),
(4, 'manage_recruitment', '2026-03-27 04:33:29', '2026-03-27 04:33:29'),
(5, 'view_dashboard', '2026-03-27 05:28:42', '2026-03-27 05:28:42'),
(6, 'manage_positions', '2026-03-27 05:28:42', '2026-03-27 05:28:42'),
(7, 'manage_attendance', '2026-03-27 05:28:42', '2026-03-27 05:28:42'),
(8, 'view_own_attendance', '2026-03-27 05:28:42', '2026-03-27 05:28:42'),
(9, 'manage_leave', '2026-03-27 05:28:42', '2026-03-27 05:28:42'),
(10, 'view_own_leave', '2026-03-27 05:28:42', '2026-03-27 05:28:42'),
(11, 'approve_leave', '2026-03-27 05:28:42', '2026-03-27 05:28:42'),
(12, 'manage_payroll', '2026-03-27 05:28:42', '2026-03-27 05:28:42'),
(13, 'view_own_payroll', '2026-03-27 05:28:42', '2026-03-27 05:28:42');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `basic_salary` decimal(15,2) DEFAULT 0.00,
  `allowance` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `basic_salary`, `allowance`, `created_at`, `updated_at`) VALUES
(1, 'Trưởng phòng Nhân sự', 25000000.00, 5000000.00, '2026-03-27 04:33:29', '2026-03-27 04:33:29'),
(2, 'Nhân viên Kỹ thuật', 15000000.00, 2000000.00, '2026-03-27 04:33:29', '2026-03-27 04:33:29'),
(3, 'Chuyên viên Tuyển dụng', 12000000.00, 1000000.00, '2026-03-27 04:33:29', '2026-03-27 04:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2026-03-27 04:33:29', '2026-03-27 04:33:29'),
(2, 'Manager', '2026-03-27 04:33:29', '2026-03-27 04:33:29'),
(3, 'Employee', '2026-03-27 04:33:29', '2026-03-27 04:33:29'),
(4, 'HR', '2026-03-27 05:28:42', '2026-03-27 05:28:42'),
(5, 'Kế toán', '2026-03-27 05:28:42', '2026-03-27 05:28:42');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(2, 1),
(2, 5),
(2, 7),
(2, 11),
(3, 5),
(3, 8),
(3, 10),
(3, 13),
(4, 1),
(4, 2),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(5, 5),
(5, 7),
(5, 12);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 4),
(3, 5),
(4, 3),
(5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `salary_structures`
--

CREATE TABLE `salary_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `base_salary` decimal(15,2) NOT NULL,
  `insurance_rate` float DEFAULT 10.5,
  `tax_rate` float DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `late_threshold` int(11) DEFAULT 15,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'company_name', 'CÔNG TY TNHH PHÁT TRIỂN CÔNG NGHỆ HRM PRO', '2026-03-28 09:21:37', '2026-03-28 09:21:37'),
(2, 'director_name', 'VŨ ĐỨC LONG', '2026-03-28 09:21:37', '2026-03-28 09:21:37'),
(3, 'company_address', 'Khu đô thị mới Cầu Giấy, Quận Cầu Giấy, TP. Hà Nội1', '2026-03-28 09:21:37', '2026-03-28 09:39:47'),
(4, 'company_phone', '024.399.8888', '2026-03-28 09:21:37', '2026-03-28 09:21:37'),
(5, 'company_email', 'contact@hrmpro.com', '2026-03-28 09:21:37', '2026-03-28 09:21:37'),
(6, 'default_working_time', '08 giờ/ngày (48 giờ/tuần)', '2026-03-28 09:21:37', '2026-03-28 09:21:37');

-- --------------------------------------------------------

--
-- Table structure for table `training_courses`
--

CREATE TABLE `training_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `training_courses`
--

INSERT INTO `training_courses` (`id`, `name`, `description`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'Kỹ năng làm việc nhóm chuyên nghiệp', 'Khóa huấn luyện kỹ năng mềm cho toàn hệ thống.', NULL, NULL, '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(2, 'An toàn thông tin doanh nghiệp', 'Hướng dẫn bảo mật dữ liệu nhân sự.', NULL, NULL, '2026-03-27 05:35:40', '2026-03-27 05:35:40'),
(3, 'Quản trị nhân sự 4.0', 'Cập nhật xu hướng quản trị hiện đại.', NULL, NULL, '2026-03-27 05:35:40', '2026-03-27 05:35:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Quản trị viên', 'admin@hrm.com', '$2a$10$59pHzs7IK595V9NQ3z3psOjdJC8EWe71hJUsuurIoLKpKQf6zlYlW', NULL, NULL, '2026-03-27 04:33:29', '2026-03-28 06:12:59'),
(2, 'Nhân sự', 'hr@hrm.com', '$2a$10$59pHzs7IK595V9NQ3z3psOjdJC8EWe71hJUsuurIoLKpKQf6zlYlW', NULL, NULL, '2026-03-27 05:30:20', '2026-03-28 06:22:48'),
(3, 'Kế toán', 'accountant@hrm.com', '$2a$10$59pHzs7IK595V9NQ3z3psOjdJC8EWe71hJUsuurIoLKpKQf6zlYlW', NULL, NULL, '2026-03-27 05:30:20', '2026-03-28 06:22:51'),
(4, 'Nhân viên mẫu', 'employee@hrm.com', '$2a$10$59pHzs7IK595V9NQ3z3psOjdJC8EWe71hJUsuurIoLKpKQf6zlYlW', NULL, NULL, '2026-03-27 05:30:38', '2026-03-28 06:22:52'),
(5, 'Nguyễn Văn An', 'nguyenvana@gmail.com', '$2y$10$ZPT0ksApdCRL6gYEpVYe9.Bvvn4jYJXJWr3DVFvySiJD8gzUiecQu', NULL, NULL, '2026-03-28 10:01:42', '2026-03-28 10:01:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `shift_id` (`shift_id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contract_number` (`contract_number`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `fk_dept_manager` (`manager_id`);

--
-- Indexes for table `education_histories`
--
ALTER TABLE `education_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_code` (`employee_code`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `pos_id` (`pos_id`);

--
-- Indexes for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  ADD PRIMARY KEY (`employee_id`,`allowance_id`),
  ADD KEY `allowance_id` (`allowance_id`);

--
-- Indexes for table `employee_trainings`
--
ALTER TABLE `employee_trainings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `leave_type_id` (`leave_type_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `salary_structures`
--
ALTER TABLE `salary_structures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `system_settings_key_unique` (`key`);

--
-- Indexes for table `training_courses`
--
ALTER TABLE `training_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `education_histories`
--
ALTER TABLE `education_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee_trainings`
--
ALTER TABLE `employee_trainings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `salary_structures`
--
ALTER TABLE `salary_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `training_courses`
--
ALTER TABLE `training_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_ibfk_2` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job_postings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `fk_dept_manager` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `education_histories`
--
ALTER TABLE `education_histories`
  ADD CONSTRAINT `education_histories_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employees_ibfk_3` FOREIGN KEY (`pos_id`) REFERENCES `positions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  ADD CONSTRAINT `employee_allowances_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_allowances_ibfk_2` FOREIGN KEY (`allowance_id`) REFERENCES `allowances` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_trainings`
--
ALTER TABLE `employee_trainings`
  ADD CONSTRAINT `employee_trainings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_trainings_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `training_courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leave_requests_ibfk_2` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`),
  ADD CONSTRAINT `leave_requests_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payrolls_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_structures`
--
ALTER TABLE `salary_structures`
  ADD CONSTRAINT `salary_structures_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
