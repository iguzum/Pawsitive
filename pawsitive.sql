-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2026 at 11:55 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pawsitive`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` int UNSIGNED NOT NULL,
  `account_role` enum('admin','staff','customer') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'customer',
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `age` tinyint UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `account_role`, `email`, `password`, `created_at`, `updated_at`, `age`, `first_name`, `last_name`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$SZ2a8WF0s5fBeiUcfOgLZOS5ZdFGUqLct/DePyAw/xl/Cs1djPm1W', '2026-11-14 16:54:28', '2026-11-17 15:18:02', NULL, NULL, NULL),
(2, 'customer', 'customer@gmail.com', '$2y$10$SZ2a8WF0s5fBeiUcfOgLZOS5ZdFGUqLct/DePyAw/xl/Cs1djPm1W', '2026-11-15 01:28:00', '2026-11-18 15:35:25', 21, 'mark', 'capinding'),
(4, 'staff', 'staff@gmail.com', '$2y$10$SZ2a8WF0s5fBeiUcfOgLZOS5ZdFGUqLct/DePyAw/xl/Cs1djPm1W', '2026-11-17 15:21:55', '2026-11-18 00:46:31', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `adoption_application`
--

CREATE TABLE `adoption_application` (
  `application_id` int UNSIGNED NOT NULL,
  `applicant_id` int UNSIGNED NOT NULL,
  `pet_id` int UNSIGNED NOT NULL,
  `status` enum('Pending','Approved','Rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Pending',
  `application_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adoption_application_details`
--

CREATE TABLE `adoption_application_details` (
  `detail_id` int UNSIGNED NOT NULL,
  `application_id` int UNSIGNED NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `monthly_income` decimal(10,2) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `household_members` tinyint UNSIGNED DEFAULT NULL,
  `reason_for_adoption` text,
  `is_committed` enum('Y','N') NOT NULL DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adoption_pet`
--

CREATE TABLE `adoption_pet` (
  `adoption_pet_id` int UNSIGNED NOT NULL,
  `adoption_pet_name` varchar(100) NOT NULL,
  `species` enum('dog','cat') NOT NULL,
  `breed` varchar(50) NOT NULL,
  `sex` enum('male','female') NOT NULL,
  `age` tinyint UNSIGNED NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `adoption_pet`
--

INSERT INTO `adoption_pet` (`adoption_pet_id`, `adoption_pet_name`, `species`, `breed`, `sex`, `age`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Mochi', 'cat', 'Persian', 'female', 2, 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=800&q=80', '2026-11-18 04:22:09', '2026-11-18 04:22:09'),
(2, 'Whiskers', 'cat', 'British Shorthair', 'male', 1, 'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?w=800&q=80', '2026-11-18 04:22:09', '2026-11-18 04:22:09'),
(3, 'Luna', 'cat', 'Siamese', 'female', 3, 'https://images.unsplash.com/photo-1519052537078-e6302a4968d4?w=800&q=80', '2026-11-18 04:22:09', '2026-11-18 04:22:09'),
(4, 'Brownie', 'dog', 'Golden Retriever', 'male', 2, 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=800&q=80', '2026-11-18 04:22:09', '2026-11-18 04:22:09'),
(5, 'Max', 'dog', 'Beagle', 'male', 1, 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=800&q=80', '2026-11-18 04:22:09', '2026-11-18 04:22:09'),
(6, 'Bella', 'dog', 'Poodle', 'female', 4, 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=800&q=80', '2026-11-18 04:22:09', '2026-11-18 04:22:09');

-- --------------------------------------------------------

--
-- Table structure for table `adoption_pet_information`
--

CREATE TABLE `adoption_pet_information` (
  `adoption_pet_id_info` int UNSIGNED NOT NULL,
  `adoption_pet_id` int UNSIGNED NOT NULL,
  `description` text,
  `health_condition` varchar(255) DEFAULT NULL,
  `behavior_details` text,
  `rescue_history` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `adoption_pet_information`
--

INSERT INTO `adoption_pet_information` (`adoption_pet_id_info`, `adoption_pet_id`, `description`, `health_condition`, `behavior_details`, `rescue_history`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Healthy, Vaccinated', 'Calm and cuddly, loves to sleep', 'Rescued from street in Manila', '2026-11-18 04:22:09', '2026-11-18 04:22:09'),
(2, 2, NULL, 'Healthy, Vaccinated', 'Playful and curious, loves toys', 'Surrendered by previous owner', '2026-11-18 04:22:09', '2026-11-18 04:22:09'),
(3, 3, NULL, 'Healthy, Needs check-up', 'Gentle and quiet, good with kids', 'Found abandoned in a park', '2026-11-18 04:22:09', '2026-11-18 04:22:09'),
(4, 4, NULL, 'Healthy, Vaccinated', 'Energetic and loyal, loves fetch', 'Rescued from flood area', '2026-11-18 04:22:09', '2026-11-18 04:22:09'),
(5, 5, NULL, 'Healthy, Vaccinated', 'Friendly and smart, good with other dogs', 'Found wandering in barangay', '2026-11-18 04:22:09', '2026-11-18 04:22:09'),
(6, 6, NULL, 'Healthy, Vaccinated', 'Sweet and obedient, loves walks', 'Surrendered due to owner moving abroad', '2026-11-18 04:22:09', '2026-11-18 04:22:09');

-- --------------------------------------------------------

--
-- Table structure for table `care_service`
--

CREATE TABLE `care_service` (
  `service_id` int UNSIGNED NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `care_service`
--

INSERT INTO `care_service` (`service_id`, `service_name`, `service_price`) VALUES
(1, 'General Care', '499.00'),
(2, 'Preventive Care', '999.00'),
(3, 'Hygiene Care', '899.00'),
(4, 'Diagnostic Care', '799.00');

-- --------------------------------------------------------

--
-- Table structure for table `care_service_record`
--

CREATE TABLE `care_service_record` (
  `record_id` int UNSIGNED NOT NULL,
  `request_id` int UNSIGNED NOT NULL,
  `notes` text,
  `record_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diagnostic_care_record`
--

-- :: START OPTIONAL DIAGNOSTIC CARE DETAILS
CREATE TABLE `diagnostic_care_record` (
  `id` int UNSIGNED NOT NULL,
  `record_id` int UNSIGNED NOT NULL,
  `test_type` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `test_result` text,
  `diagnosis` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- :: END OPTIONAL DIAGNOSTIC CARE DETAILS

-- --------------------------------------------------------

--
-- Table structure for table `general_care_record`
--

-- :: START OPTIONAL GENERAL CARE DETAILS
CREATE TABLE `general_care_record` (
  `id` int UNSIGNED NOT NULL,
  `record_id` int UNSIGNED NOT NULL,
  `checkup_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- :: END OPTIONAL GENERAL CARE DETAILS

-- --------------------------------------------------------

--
-- Table structure for table `hygiene_care_record`
--

-- :: START OPTIONAL HYGIENE CARE DETAILS
CREATE TABLE `hygiene_care_record` (
  `id` int UNSIGNED NOT NULL,
  `record_id` int UNSIGNED NOT NULL,
  `cleaning_type` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- :: END OPTIONAL HYGIENE CARE DETAILS

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `pet_id` int UNSIGNED NOT NULL,
  `account_id` int UNSIGNED NOT NULL,
  `pet_name` varchar(100) NOT NULL,
  `species` enum('Dog','Cat') NOT NULL,
  `breed` varchar(50) DEFAULT NULL,
  `age` tinyint NOT NULL,
  `sex` enum('Male','Female') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preventive_care_record`
--

-- :: START OPTIONAL PREVENTIVE CARE DETAILS
CREATE TABLE `preventive_care_record` (
  `id` int UNSIGNED NOT NULL,
  `record_id` int UNSIGNED NOT NULL,
  `care_type` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `drug_type` varchar(100) DEFAULT NULL,
  `dose_number` tinyint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- :: END OPTIONAL PREVENTIVE CARE DETAILS

-- --------------------------------------------------------

--
-- Table structure for table `service_request`
--

CREATE TABLE `service_request` (
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `request_id` int UNSIGNED NOT NULL,
  `pet_id` int UNSIGNED NOT NULL,
  `service_id` int UNSIGNED NOT NULL,
  `request_date` date NOT NULL,
  `schedule_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `email_3` (`email`),
  ADD UNIQUE KEY `email_4` (`email`);

--
-- Indexes for table `adoption_application`
--
ALTER TABLE `adoption_application`
  ADD PRIMARY KEY (`application_id`),
  ADD UNIQUE KEY `uq_application_applicant_pet` (`applicant_id`,`pet_id`),
  ADD KEY `fk_application_pet` (`pet_id`);

--
-- Indexes for table `adoption_application_details`
--
ALTER TABLE `adoption_application_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD UNIQUE KEY `uq_details_application` (`application_id`);

--
-- Indexes for table `adoption_pet`
--
ALTER TABLE `adoption_pet`
  ADD PRIMARY KEY (`adoption_pet_id`);

--
-- Indexes for table `adoption_pet_information`
--
ALTER TABLE `adoption_pet_information`
  ADD PRIMARY KEY (`adoption_pet_id_info`),
  ADD KEY `fk_info_pet` (`adoption_pet_id`);

--
-- Indexes for table `care_service`
--
ALTER TABLE `care_service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `care_service_record`
--
ALTER TABLE `care_service_record`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `fk_record_request` (`request_id`);

--
-- Indexes for table `diagnostic_care_record`
--
ALTER TABLE `diagnostic_care_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_diagnostic_record` (`record_id`);

--
-- Indexes for table `general_care_record`
--
ALTER TABLE `general_care_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_general_record` (`record_id`);

--
-- Indexes for table `hygiene_care_record`
--
ALTER TABLE `hygiene_care_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hygiene_record` (`record_id`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `fk_pet_owner` (`account_id`);

--
-- Indexes for table `preventive_care_record`
--
ALTER TABLE `preventive_care_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_preventive_record` (`record_id`);

--
-- Indexes for table `service_request`
--
ALTER TABLE `service_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `fk_request_pet` (`pet_id`),
  ADD KEY `fk_request_service` (`service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `adoption_application`
--
ALTER TABLE `adoption_application`
  MODIFY `application_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adoption_application_details`
--
ALTER TABLE `adoption_application_details`
  MODIFY `detail_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adoption_pet`
--
ALTER TABLE `adoption_pet`
  MODIFY `adoption_pet_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `adoption_pet_information`
--
ALTER TABLE `adoption_pet_information`
  MODIFY `adoption_pet_id_info` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `care_service`
--
ALTER TABLE `care_service`
  MODIFY `service_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `care_service_record`
--
ALTER TABLE `care_service_record`
  MODIFY `record_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diagnostic_care_record`
--
ALTER TABLE `diagnostic_care_record`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_care_record`
--
ALTER TABLE `general_care_record`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hygiene_care_record`
--
ALTER TABLE `hygiene_care_record`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `pet_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `preventive_care_record`
--
ALTER TABLE `preventive_care_record`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_request`
--
ALTER TABLE `service_request`
  MODIFY `request_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption_application`
--
ALTER TABLE `adoption_application`
  ADD CONSTRAINT `fk_application_applicant` FOREIGN KEY (`applicant_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_application_pet` FOREIGN KEY (`pet_id`) REFERENCES `adoption_pet` (`adoption_pet_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `adoption_application_details`
--
ALTER TABLE `adoption_application_details`
  ADD CONSTRAINT `fk_details_application` FOREIGN KEY (`application_id`) REFERENCES `adoption_application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `adoption_pet_information`
--
ALTER TABLE `adoption_pet_information`
  ADD CONSTRAINT `fk_info_pet` FOREIGN KEY (`adoption_pet_id`) REFERENCES `adoption_pet` (`adoption_pet_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `care_service_record`
--
ALTER TABLE `care_service_record`
  ADD CONSTRAINT `fk_record_request` FOREIGN KEY (`request_id`) REFERENCES `service_request` (`request_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diagnostic_care_record`
--
ALTER TABLE `diagnostic_care_record`
  ADD CONSTRAINT `fk_diagnostic_record` FOREIGN KEY (`record_id`) REFERENCES `care_service_record` (`record_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `general_care_record`
--
ALTER TABLE `general_care_record`
  ADD CONSTRAINT `fk_general_record` FOREIGN KEY (`record_id`) REFERENCES `care_service_record` (`record_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hygiene_care_record`
--
ALTER TABLE `hygiene_care_record`
  ADD CONSTRAINT `fk_hygiene_record` FOREIGN KEY (`record_id`) REFERENCES `care_service_record` (`record_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `fk_pet_owner` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `preventive_care_record`
--
ALTER TABLE `preventive_care_record`
  ADD CONSTRAINT `fk_preventive_record` FOREIGN KEY (`record_id`) REFERENCES `care_service_record` (`record_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_request`
--
ALTER TABLE `service_request`
  ADD CONSTRAINT `fk_request_pet` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_request_service` FOREIGN KEY (`service_id`) REFERENCES `care_service` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
