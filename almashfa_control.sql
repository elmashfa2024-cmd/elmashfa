-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 19 مايو 2026 الساعة 18:37
-- إصدار الخادم: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `almashfa_control`
--

-- --------------------------------------------------------

--
-- بنية الجدول `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `expected_exit_date` date DEFAULT NULL,
  `exit_date` date DEFAULT NULL,
  `monthly_amount` decimal(10,2) DEFAULT '0.00',
  `monthly_type` varchar(20) DEFAULT 'fixed',
  `total_paid` decimal(10,2) DEFAULT '0.00',
  `total_debt` decimal(10,2) DEFAULT '0.00',
  `overdue_months` int(11) DEFAULT '0',
  `overdue_days` int(11) DEFAULT '0',
  `referrer_name` varchar(100) DEFAULT NULL,
  `credit_balance` decimal(10,2) DEFAULT '0.00',
  `risk_level` varchar(20) DEFAULT 'medium',
  `referrer_id` int(11) DEFAULT NULL,
  `room_number` varchar(20) DEFAULT NULL,
  `diagnosis` varchar(100) DEFAULT NULL,
  `doctor_name` varchar(100) DEFAULT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `guardian_phone` varchar(20) DEFAULT NULL,
  `patient_phone` varchar(20) DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `notes` text,
  `next_visit_date` date DEFAULT NULL,
  `status` enum('active','archived') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cigarette_balance` int(11) DEFAULT '0',
  `external_balance` decimal(10,2) DEFAULT '0.00',
  `external_debt` decimal(10,2) DEFAULT '0.00',
  `cigarette_daily` int(11) DEFAULT '0' COMMENT 'عدد السجاير اليومية',
  `cigarette_price` decimal(10,2) DEFAULT '50.00' COMMENT 'سعر العلبة',
  `cigarette_debt` decimal(10,2) DEFAULT '0.00' COMMENT 'مديونية السجاير بالجنيه',
  `cigarette_debt_packs` int(11) DEFAULT '0' COMMENT 'مديونية السجاير بالعلب',
  `cigarette_total_packs` int(11) DEFAULT '0' COMMENT 'إجمالي العلب المصروفة من تاريخ الدخول',
  `cigarette_last_update` date DEFAULT NULL COMMENT 'آخر تحديث للرصيد الشهري'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `patients`
--

INSERT INTO `patients` (`id`, `name`, `entry_date`, `expected_exit_date`, `exit_date`, `monthly_amount`, `monthly_type`, `total_paid`, `total_debt`, `overdue_months`, `overdue_days`, `referrer_name`, `credit_balance`, `risk_level`, `referrer_id`, `room_number`, `diagnosis`, `doctor_name`, `guardian_name`, `guardian_phone`, `patient_phone`, `national_id`, `notes`, `next_visit_date`, `status`, `created_at`, `cigarette_balance`, `external_balance`, `external_debt`, `cigarette_daily`, `cigarette_price`, `cigarette_debt`, `cigarette_debt_packs`, `cigarette_total_packs`, `cigarette_last_update`) VALUES
(13, 'حسن حامد', '2025-10-22', NULL, NULL, '9000.00', 'fixed', '2000.00', '60100.00', 6, 20, 'المكان', '0.00', 'high', NULL, NULL, 'إدمان', 'د.ايه', 'حامد', 'لا يوجد', 'لا يوجد', NULL, '', NULL, 'active', '2026-05-17 10:23:10', 0, '0.00', '1905.00', 0, '50.00', '0.00', 0, 0, '2026-05-17'),
(14, 'عماد محمد سليمان', '2025-11-17', NULL, NULL, '10000.00', 'fixed', '46000.00', '14333.33', 1, 13, 'احمد فتحي', '0.00', 'low', NULL, NULL, '', 'علي الجندي', 'محمد سليمان', '01004061170', 'لا يوجد', NULL, '', NULL, 'active', '2026-05-17 10:25:16', 660, '0.00', '825.00', 10, '50.00', '0.00', 0, 15, '2026-05-17'),
(15, 'مصطفي فتحي', '2025-11-20', NULL, NULL, '10000.00', 'fixed', '40000.00', '19333.33', 1, 28, 'بسام', '0.00', 'low', NULL, NULL, 'إدمان', 'علي الجندي', 'فتحي', 'لا يوجد', 'لا يوجد', NULL, '', NULL, 'active', '2026-05-17 11:18:01', 0, '0.00', '2625.00', 0, '50.00', '0.00', 0, 0, '2026-05-17'),
(16, 'احمد زغلول الريفي', '2025-11-22', NULL, NULL, '6000.00', 'fixed', '32000.00', '3200.00', 0, 16, 'المكان', '0.00', 'low', NULL, NULL, 'إدمان', 'علي الجندي', 'زغلول', 'لا يوجد', 'لا يوجد', NULL, '', NULL, 'active', '2026-05-17 11:20:01', 0, '0.00', '0.00', 0, '50.00', '0.00', 0, 0, '2026-05-17'),
(17, 'شريف جمال', '2026-03-29', NULL, NULL, '6000.00', 'fixed', '6000.00', '3800.00', 0, 19, 'المكان', '0.00', 'low', NULL, NULL, 'نفسي', 'علي الجندي', 'جمال', 'لا يوجد', 'لا يوجد', NULL, '', NULL, 'active', '2026-05-17 11:20:58', 400, '0.00', '0.00', 10, '50.00', '0.00', 0, 15, '2026-05-17');

-- --------------------------------------------------------

--
-- بنية الجدول `patient_balance`
--

CREATE TABLE `patient_balance` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `type` enum('cigarettes','external_cash') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) DEFAULT '0.00',
  `quantity` int(11) DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `patient_transactions`
--

CREATE TABLE `patient_transactions` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `type` enum('cigarettes','external_expense','deposit','charge') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) DEFAULT '0',
  `amount` decimal(10,2) DEFAULT '0.00',
  `unit_price` decimal(10,2) DEFAULT '0.00',
  `total` decimal(10,2) DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `patient_transactions`
--

INSERT INTO `patient_transactions` (`id`, `patient_id`, `type`, `quantity`, `amount`, `unit_price`, `total`, `notes`, `created_by`, `created_at`) VALUES
(37, 14, 'cigarettes', 660, '0.00', '0.00', '0.00', 'دخول من احمد فتحي', NULL, '2026-05-17 10:25:58'),
(38, 13, 'charge', 0, '1905.00', '0.00', '0.00', 'مصاريف خارجيه', NULL, '2026-05-17 10:26:28'),
(39, 14, 'charge', 0, '825.00', '0.00', '0.00', 'مصاريف خارجيه', NULL, '2026-05-17 10:26:53'),
(40, 15, 'charge', 0, '2625.00', '0.00', '0.00', '', NULL, '2026-05-17 11:18:46'),
(41, 17, 'cigarettes', 400, '0.00', '0.00', '0.00', '', NULL, '2026-05-17 11:21:20');

-- --------------------------------------------------------

--
-- بنية الجدول `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(30) DEFAULT 'كاش',
  `received_from` varchar(100) DEFAULT NULL,
  `receipt_number` varchar(50) DEFAULT NULL,
  `notes` text,
  `payment_date` date NOT NULL,
  `recorded_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `referrers`
--

CREATE TABLE `referrers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('admin','referrer','specialist') DEFAULT 'referrer',
  `phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `role`, `phone`, `is_active`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'مدير النظام', 'admin', NULL, 1, '2026-05-16 11:32:24'),
(3, 'entsar', 'e10adc3949ba59abbe56e057f20f883e', 'ا / انتصار', 'specialist', NULL, 1, '2026-05-16 12:31:20');

-- --------------------------------------------------------

--
-- بنية الجدول `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `specialist_id` int(11) NOT NULL,
  `visit_date` date NOT NULL,
  `visit_time` time DEFAULT NULL,
  `notes` text,
  `follow_up` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_balance`
--
ALTER TABLE `patient_balance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `patient_transactions`
--
ALTER TABLE `patient_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `recorded_by` (`recorded_by`);

--
-- Indexes for table `referrers`
--
ALTER TABLE `referrers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `specialist_id` (`specialist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `patient_balance`
--
ALTER TABLE `patient_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_transactions`
--
ALTER TABLE `patient_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `referrers`
--
ALTER TABLE `referrers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- قيود الجداول المحفوظة
--

--
-- القيود للجدول `patient_balance`
--
ALTER TABLE `patient_balance`
  ADD CONSTRAINT `patient_balance_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- القيود للجدول `patient_transactions`
--
ALTER TABLE `patient_transactions`
  ADD CONSTRAINT `patient_transactions_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `patient_transactions_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- القيود للجدول `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`);

--
-- القيود للجدول `referrers`
--
ALTER TABLE `referrers`
  ADD CONSTRAINT `referrers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- القيود للجدول `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `visits_ibfk_2` FOREIGN KEY (`specialist_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
