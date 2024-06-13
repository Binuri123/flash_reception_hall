-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 12, 2024 at 03:23 PM
-- Server version: 5.7.18-log
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flash_reception_hall`
--
CREATE DATABASE IF NOT EXISTS `flash_reception_hall` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `flash_reception_hall`;

-- --------------------------------------------------------

--
-- Table structure for table `additional_allowed_item`
--

DROP TABLE IF EXISTS `additional_allowed_item`;
CREATE TABLE IF NOT EXISTS `additional_allowed_item` (
  `additional_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `additional_ratio` decimal(5,2) NOT NULL,
  `addon_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`additional_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `additional_allowed_item`
--

INSERT INTO `additional_allowed_item` (`additional_id`, `item_id`, `additional_ratio`, `addon_price`) VALUES
(1, 1, '5.00', '138.60'),
(2, 2, '5.00', '138.60'),
(3, 3, '5.00', '150.15'),
(4, 7, '5.00', '138.60'),
(5, 10, '5.00', '69.30'),
(6, 11, '5.00', '103.95'),
(7, 13, '5.00', '127.05'),
(8, 14, '5.00', '138.60'),
(9, 15, '5.00', '115.50'),
(10, 16, '5.00', '57.75'),
(11, 17, '10.00', '121.00'),
(12, 18, '10.00', '169.40'),
(13, 19, '10.00', '242.00'),
(14, 20, '5.00', '138.60'),
(15, 21, '5.00', '173.25'),
(16, 22, '10.00', '193.60'),
(17, 23, '10.00', '181.50'),
(18, 24, '5.00', '115.50'),
(19, 25, '10.00', '72.60'),
(20, 26, '5.00', '115.50'),
(21, 27, '5.00', '173.25'),
(22, 28, '5.00', '80.85'),
(23, 29, '5.00', '115.50'),
(24, 30, '5.00', '115.50'),
(25, 31, '15.00', '316.25'),
(26, 32, '5.00', '173.25'),
(27, 33, '5.00', '115.50'),
(28, 34, '5.00', '173.25'),
(29, 35, '5.00', '138.60'),
(30, 36, '10.00', '157.30'),
(31, 37, '10.00', '121.00'),
(32, 38, '20.00', '132.00'),
(33, 39, '20.00', '158.40'),
(34, 40, '20.00', '198.00'),
(35, 41, '20.00', '171.60'),
(36, 42, '20.00', '158.40'),
(37, 43, '20.00', '158.40'),
(38, 44, '20.00', '198.00'),
(39, 45, '20.00', '198.00'),
(40, 46, '20.00', '198.00'),
(41, 47, '20.00', '198.00'),
(42, 48, '10.00', '181.50'),
(43, 49, '10.00', '181.50'),
(44, 50, '10.00', '181.50'),
(45, 51, '10.00', '181.50'),
(46, 52, '10.00', '181.50'),
(47, 53, '10.00', '242.00'),
(48, 54, '10.00', '242.00'),
(49, 55, '10.00', '242.00'),
(50, 56, '10.00', '242.00'),
(51, 57, '10.00', '242.00'),
(52, 58, '10.00', '266.20'),
(53, 59, '10.00', '266.20'),
(54, 60, '15.00', '253.00'),
(55, 61, '15.00', '253.00'),
(56, 62, '20.00', '264.00'),
(57, 63, '20.00', '264.00');

-- --------------------------------------------------------

--
-- Table structure for table `agreement_status`
--

DROP TABLE IF EXISTS `agreement_status`;
CREATE TABLE IF NOT EXISTS `agreement_status` (
  `agreement_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `agreement_status` varchar(100) NOT NULL,
  PRIMARY KEY (`agreement_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agreement_status`
--

INSERT INTO `agreement_status` (`agreement_status_id`, `agreement_status`) VALUES
(1, 'Active'),
(2, 'Expired'),
(3, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `arrangement_plan`
--

DROP TABLE IF EXISTS `arrangement_plan`;
CREATE TABLE IF NOT EXISTS `arrangement_plan` (
  `arrangement_plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_no` char(25) NOT NULL,
  `reservation_no` char(25) NOT NULL,
  `arrangement_status_id` int(11) NOT NULL,
  `requested_date` date NOT NULL,
  `completed_date` date DEFAULT NULL,
  PRIMARY KEY (`arrangement_plan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `arrangement_plan`
--

INSERT INTO `arrangement_plan` (`arrangement_plan_id`, `customer_no`, `reservation_no`, `arrangement_status_id`, `requested_date`, `completed_date`) VALUES
(1, 'CUS2023080417', 'R2023080485', 2, '2023-08-04', NULL),
(3, 'CUS2023080525', 'R20230805106', 2, '2023-08-05', NULL),
(4, 'CUS2024052827', 'R20240528115', 1, '2024-05-28', NULL),
(5, 'CUS2024052827', 'R20240528119', 2, '2024-05-28', NULL),
(6, 'CUS2024052827', 'R20240528121', 1, '2024-06-12', NULL),
(7, 'CUS2024052827', 'R20240612129', 1, '2024-06-12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `arrangement_plan_samples`
--

DROP TABLE IF EXISTS `arrangement_plan_samples`;
CREATE TABLE IF NOT EXISTS `arrangement_plan_samples` (
  `arrangement_samples_id` int(11) NOT NULL AUTO_INCREMENT,
  `arrangement_plan_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_sample_id` int(11) NOT NULL,
  PRIMARY KEY (`arrangement_samples_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `arrangement_plan_samples`
--

INSERT INTO `arrangement_plan_samples` (`arrangement_samples_id`, `arrangement_plan_id`, `service_id`, `service_sample_id`) VALUES
(1, 1, 5, 11),
(2, 1, 8, 12),
(3, 1, 9, 1),
(4, 1, 14, 4),
(5, 1, 23, 15),
(6, 1, 32, 21),
(7, 2, 5, 34),
(8, 2, 8, 13),
(9, 2, 9, 1),
(10, 2, 14, 4),
(11, 2, 23, 16),
(12, 2, 32, 22),
(13, 3, 5, 34),
(14, 3, 9, 1),
(15, 3, 14, 4),
(16, 4, 9, 2),
(17, 4, 14, 4),
(18, 4, 23, 15),
(19, 5, 5, 34),
(20, 6, 5, 34),
(21, 7, 9, 3),
(22, 7, 14, 4);

-- --------------------------------------------------------

--
-- Table structure for table `arrangement_plan_status`
--

DROP TABLE IF EXISTS `arrangement_plan_status`;
CREATE TABLE IF NOT EXISTS `arrangement_plan_status` (
  `arr_plan_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `arr_plan_status` varchar(100) NOT NULL,
  PRIMARY KEY (`arr_plan_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `arrangement_plan_status`
--

INSERT INTO `arrangement_plan_status` (`arr_plan_status_id`, `arr_plan_status`) VALUES
(1, 'Requested'),
(2, 'In Progress'),
(3, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `arr_assign_supplier`
--

DROP TABLE IF EXISTS `arr_assign_supplier`;
CREATE TABLE IF NOT EXISTS `arr_assign_supplier` (
  `arr_assign_supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `arr_plan_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `assign_status_id` int(11) NOT NULL,
  `assign_date` date NOT NULL,
  `respond_date` date DEFAULT NULL,
  PRIMARY KEY (`arr_assign_supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `arr_assign_supplier`
--

INSERT INTO `arr_assign_supplier` (`arr_assign_supplier_id`, `arr_plan_id`, `service_id`, `supplier_id`, `assign_status_id`, `assign_date`, `respond_date`) VALUES
(44, 1, 2, 5, 2, '2023-08-04', '2023-08-05'),
(45, 1, 5, 15, 2, '2023-08-04', '2023-08-05'),
(46, 1, 8, 15, 2, '2023-08-04', '2023-08-05'),
(47, 1, 9, 15, 2, '2023-08-04', '2023-08-04'),
(48, 1, 10, 9, 2, '2023-08-04', '2023-08-04'),
(49, 1, 12, 9, 2, '2023-08-04', '2023-08-04'),
(50, 1, 13, 15, 2, '2023-08-04', '2023-08-04'),
(51, 1, 14, 11, 2, '2023-08-04', '2023-08-04'),
(52, 1, 18, 12, 2, '2023-08-04', '2023-08-04'),
(53, 1, 23, 6, 2, '2023-08-04', '2023-08-04'),
(54, 1, 32, 15, 2, '2023-08-04', '2023-08-04'),
(55, 1, 5, 10, 2, '2023-08-04', '2023-08-04'),
(56, 1, 10, 17, 2, '2023-08-04', '2023-08-04'),
(61, 2, 2, 4, 2, '2023-08-05', NULL),
(62, 2, 5, 10, 2, '2023-08-05', NULL),
(63, 2, 8, 15, 2, '2023-08-05', NULL),
(64, 2, 9, 12, 2, '2023-08-05', NULL),
(65, 2, 10, 9, 2, '2023-08-05', NULL),
(66, 2, 11, 9, 2, '2023-08-05', NULL),
(67, 2, 12, 9, 3, '2023-08-05', NULL),
(68, 2, 13, 13, 3, '2023-08-05', NULL),
(69, 2, 14, 11, 2, '2023-08-05', NULL),
(70, 2, 18, 12, 2, '2023-08-05', NULL),
(71, 2, 23, 6, 2, '2023-08-05', NULL),
(72, 2, 25, 13, 2, '2023-08-05', NULL),
(73, 2, 33, 15, 2, '2023-08-05', NULL),
(74, 2, 32, 15, 2, '2023-08-05', NULL),
(75, 3, 2, 5, 3, '2023-08-05', '2023-08-05'),
(76, 3, 5, 10, 2, '2023-08-05', '2023-08-05'),
(77, 3, 9, 15, 2, '2023-08-05', NULL),
(78, 3, 10, 9, 2, '2023-08-05', '2023-08-05'),
(79, 3, 11, 17, 3, '2023-08-05', '2023-08-05'),
(80, 3, 12, 9, 2, '2023-08-05', '2023-08-05'),
(81, 3, 13, 15, 2, '2023-08-05', NULL),
(82, 3, 14, 11, 2, '2023-08-05', '2023-08-05'),
(83, 3, 15, 7, 2, '2023-08-05', '2023-08-05'),
(84, 3, 18, 12, 2, '2023-08-05', '2023-08-05'),
(85, 3, 5, 15, 2, '2023-08-05', '2023-08-05'),
(86, 5, 5, 10, 1, '2024-05-29', NULL),
(87, 5, 18, 12, 1, '2024-05-29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
  `bank_id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bank_id`, `bank_name`) VALUES
(1, 'Amana Bank PLC'),
(2, 'Bank of Ceylon'),
(3, 'Bank of China Ltd'),
(4, 'Cargills Bank Ltd'),
(5, 'Citybank, N.A.'),
(6, 'Commercial Bank of Ceylon PLC'),
(7, 'Deutsche Bank AG, Colombo Branch'),
(8, 'DFCC Bank PLC'),
(9, 'Habib Bank Ltd'),
(10, 'Hatton National Bank PLC'),
(11, 'Indian Bank'),
(12, 'Indian Overseas Bank'),
(13, 'MCB Bank Ltd'),
(14, 'National Development Bank PLC'),
(15, 'Nations Trust Bank PLC'),
(16, 'Pan Asia Banking Corporation PLC'),
(17, 'People\'s Bank'),
(18, 'Public Bank Berhad'),
(19, 'Sampath Bank PLC'),
(20, 'Seylan Bank PLC'),
(21, 'Standard Chartered Bank'),
(22, 'State Bank of India'),
(23, 'HSBC'),
(24, 'Union Bank of Colombo PLC');

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

DROP TABLE IF EXISTS `bank_details`;
CREATE TABLE IF NOT EXISTS `bank_details` (
  `bank_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(200) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  PRIMARY KEY (`bank_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bank_details`
--

INSERT INTO `bank_details` (`bank_detail_id`, `bank_name`, `account_number`) VALUES
(1, 'People\'s Bank', '071200190002155'),
(2, 'Bank of Ceylon', '8876459'),
(3, 'National Savings Bank', '987654321');

-- --------------------------------------------------------

--
-- Table structure for table `bank_refund`
--

DROP TABLE IF EXISTS `bank_refund`;
CREATE TABLE IF NOT EXISTS `bank_refund` (
  `bank_refund_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_request_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `account_holder_name` varchar(255) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  PRIMARY KEY (`bank_refund_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bank_refund`
--

INSERT INTO `bank_refund` (`bank_refund_id`, `refund_request_id`, `bank_id`, `branch_name`, `account_holder_name`, `account_number`) VALUES
(4, 2, 17, 'Dematagoda', 'P. B. D. Kumaranathunge', '07120090002155'),
(5, 0, 17, 'Dematagoda', 'P. B. D. Kumaranathunge', '07120090002155'),
(7, 9, 17, 'Dematagoda', 'P. B. D. Kumaranathunge', '07120080002155'),
(8, 10, 17, 'Dematagoda', 'P. B. D. Kumaranathunge', '07120090002155'),
(9, 11, 17, 'Dematagoda', 'P. B. D. Kumaranathunge', '07120090002155');

-- --------------------------------------------------------

--
-- Table structure for table `cancelation_reasons`
--

DROP TABLE IF EXISTS `cancelation_reasons`;
CREATE TABLE IF NOT EXISTS `cancelation_reasons` (
  `reason_id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` varchar(255) NOT NULL,
  PRIMARY KEY (`reason_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cancelation_reasons`
--

INSERT INTO `cancelation_reasons` (`reason_id`, `reason`) VALUES
(1, 'Personal Reasons'),
(2, 'Financial Problem'),
(3, 'Event Details Changes (Ex: Date, Time Changes)'),
(4, 'Cancelation of the Event'),
(5, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `canceled_reservations`
--

DROP TABLE IF EXISTS `canceled_reservations`;
CREATE TABLE IF NOT EXISTS `canceled_reservations` (
  `canceled_reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_no` char(25) NOT NULL,
  `cancel_reason` varchar(255) NOT NULL,
  `canceled_date` date NOT NULL,
  `cancel_time` varchar(6) NOT NULL,
  `other_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`canceled_reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `canceled_reservations`
--

INSERT INTO `canceled_reservations` (`canceled_reservation_id`, `reservation_no`, `cancel_reason`, `canceled_date`, `cancel_time`, `other_reason`) VALUES
(8, 'R20240528116', 'Cancelation of the Event', '2024-05-28', '15:14', NULL),
(9, 'R20240528117', 'Financial Problem', '2024-05-28', '16:52', NULL),
(10, 'R20240528118', 'Cancelation of the Event', '2024-05-28', '17:04', NULL),
(11, 'R20240612128', 'Other', '2024-06-12', '13:35', '');

-- --------------------------------------------------------

--
-- Table structure for table `cash_refund`
--

DROP TABLE IF EXISTS `cash_refund`;
CREATE TABLE IF NOT EXISTS `cash_refund` (
  `cash_refund_id` int(11) NOT NULL AUTO_INCREMENT,
  `cash_collector` varchar(100) NOT NULL,
  `refund_request_id` int(11) NOT NULL,
  `cash_collector_name` varchar(255) NOT NULL,
  `cash_collector_nic` char(12) NOT NULL,
  PRIMARY KEY (`cash_refund_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cash_refund`
--

INSERT INTO `cash_refund` (`cash_refund_id`, `cash_collector`, `refund_request_id`, `cash_collector_name`, `cash_collector_nic`) VALUES
(1, 'customer', 1, 'Binuri Kumaranathunge', '977552761V'),
(3, 'other', 8, 'Gayan Indika Pushpakumara', '942522564V');

-- --------------------------------------------------------

--
-- Table structure for table `check_availability`
--

DROP TABLE IF EXISTS `check_availability`;
CREATE TABLE IF NOT EXISTS `check_availability` (
  `check_availability_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `function_mode_id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `guest_count` int(11) NOT NULL,
  `hall_id` int(11) NOT NULL,
  PRIMARY KEY (`check_availability_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `check_availability`
--

INSERT INTO `check_availability` (`check_availability_id`, `event_id`, `function_mode_id`, `event_date`, `guest_count`, `hall_id`) VALUES
(5, 1, 1, '2023-07-24', 200, 2),
(6, 1, 1, '2023-07-24', 300, 2),
(7, 1, 1, '2023-07-24', 300, 2),
(8, 1, 1, '2023-07-24', 300, 2),
(15, 1, 3, '2023-07-28', 200, 2),
(17, 4, 12, '2023-08-17', 100, 1),
(20, 1, 1, '2023-08-18', 100, 1),
(21, 1, 1, '2023-08-18', 100, 1),
(27, 4, 14, '2023-08-19', 100, 2),
(28, 4, 14, '2023-08-25', 100, 2),
(29, 4, 14, '2023-08-24', 100, 2),
(34, 1, 1, '2023-08-23', 100, 2),
(35, 6, 19, '2024-06-08', 150, 1);

-- --------------------------------------------------------

--
-- Table structure for table `condition_category`
--

DROP TABLE IF EXISTS `condition_category`;
CREATE TABLE IF NOT EXISTS `condition_category` (
  `condition_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `condition_category` varchar(100) NOT NULL,
  PRIMARY KEY (`condition_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `condition_category`
--

INSERT INTO `condition_category` (`condition_category_id`, `condition_category`) VALUES
(1, 'Bookings and Payments'),
(2, 'Cancellation and Refund'),
(3, 'Damage'),
(4, 'Reservation Updates'),
(5, 'Compliance with the Laws');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_no` char(25) DEFAULT NULL,
  `title_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `house_no` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `district_id` int(11) NOT NULL,
  `contact_number` char(10) NOT NULL,
  `alternate_number` char(10) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `nic` char(12) NOT NULL,
  `acceptance` varchar(25) NOT NULL,
  `user_id` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_no`, `title_id`, `first_name`, `middle_name`, `last_name`, `house_no`, `street`, `city`, `district_id`, `contact_number`, `alternate_number`, `email`, `nic`, `acceptance`, `user_id`, `add_date`, `update_date`) VALUES
(16, 'CUS2023073116', 3, 'Gayan', 'Indika', 'Pushpakumara', '219/7', '12', 'Hewagama', 5, '0773591279', '', 'gayanbinu9874@gmail.com', '840821579V', 'Accepted', 25, '2023-07-31', '2023-07-31'),
(17, 'CUS2023080417', 3, 'Manuda', 'Vonal', 'Pushpakumara', '219/7', 'Vihara Lane', 'Hewagama', 5, '0773591278', '', 'manuda@gmail.com', '199723456712', 'Accepted', 26, '2023-08-04', NULL),
(18, 'CUS2023080418', 4, 'Theshala', 'Induwari', 'Kumaranathunge', 'C11', 'Railway Flats', 'Dematagoda', 5, '0752223333', '', 'theshala@gmail.com', '200367812345', 'Accepted', 27, '2023-08-04', NULL),
(19, 'CUS2023080419', 3, 'Seyan', '', 'Perera', '102', 'Baseline Road', 'Borella', 5, '0716645464', '', 'seyanperera@gmail.com', '930523214V', 'Accepted', 28, '2023-08-04', NULL),
(20, 'CUS2023080420', 4, 'Upeksha', '', 'Hansani', '253', 'Gonawala Road', 'Kelaniya', 7, '0778562511', '', 'upekshahansani@gmail.com', '935252655V', 'Accepted', 29, '2023-08-04', NULL),
(21, 'CUS2023080421', 3, 'Dulan', '', 'Indeewara', '411', 'Pethiyagoda Road', 'Kelaniya', 7, '0754331233', '', 'dulanindeewara@gmail.com', '199523314555', 'Accepted', 30, '2023-08-04', NULL),
(22, 'CUS2023080422', 3, 'Rusiru', 'Ujith', 'Vidushka', '235/10', 'Pelengasthuduwa Road', 'Borella', 5, '0745465656', '', 'rusiruvidushka@gmail.com', '199623587812', 'Accepted', 31, '2023-08-04', NULL),
(23, 'CUS2023080423', 4, 'Aruni', '', 'Gayani', '255', 'Kota Road', 'Borella', 5, '0715436352', '', 'arunigayani@gmail.com', '957852525V', 'Accepted', 32, '2023-08-04', NULL),
(24, 'CUS2023080424', 2, 'Isuru', 'Anjula', 'Perera', '289', 'Ganemulla Road', 'Kadawatha', 7, '0714464643', '', 'isuruanjula@gmail.com', '941256256V', 'Accepted', 33, '2023-08-04', NULL),
(26, 'CUS2024052326', 3, 'Amal', '', 'Fernando', '233', 'Temple Road', 'Nugegoda', 5, '0772345617', '', 'amal@gmail.com', '123456789V', 'Accepted', 35, '2024-05-23', NULL),
(27, 'CUS2024052827', 3, 'Niroshan', '', 'Mendis', '256', 'Maradana Road', 'Punchi Borella', 5, '0752266333', '', 'binuriwork@gmail.com', '930651234V', 'Accepted', 36, '2024-05-28', '2024-05-28');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payments`
--

DROP TABLE IF EXISTS `customer_payments`;
CREATE TABLE IF NOT EXISTS `customer_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_no` char(25) DEFAULT NULL,
  `reservation_no` char(25) NOT NULL,
  `customer_no` char(25) NOT NULL,
  `reservation_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_category_id` int(5) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `paid_date` date NOT NULL,
  `payment_method_id` int(5) NOT NULL,
  `bank_id` int(11) NOT NULL DEFAULT '0',
  `pay_slip` varchar(255) DEFAULT NULL,
  `balance_amount` decimal(10,2) NOT NULL,
  `payment_status` int(5) NOT NULL,
  `verified_date` date DEFAULT NULL,
  `verified_user` int(11) DEFAULT NULL,
  `rejected_date` date DEFAULT NULL,
  `rejected_user` int(11) DEFAULT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_payments`
--

INSERT INTO `customer_payments` (`payment_id`, `receipt_no`, `reservation_no`, `customer_no`, `reservation_price`, `total_price`, `payment_category_id`, `paid_amount`, `paid_date`, `payment_method_id`, `bank_id`, `pay_slip`, `balance_amount`, `payment_status`, `verified_date`, `verified_user`, `rejected_date`, `rejected_user`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(42, '2023080242', 'R2023080283', 'CUS2023073116', '237475.00', '277475.00', 1, '40000.00', '2023-08-02', 2, 1, '20230802R202308028364ca53a3b12e7.jpg', '237475.00', 2, '2023-08-02', 23, NULL, NULL, 25, '2023-08-02', NULL, NULL),
(43, '2023080243', 'R2023080284', 'CUS2023073116', '415840.00', '455840.00', 1, '40000.00', '2023-08-02', 3, 1, '20230802R202308028464ca540023991.jpg', '415840.00', 6, '2023-08-02', 23, '2023-08-02', 23, 25, '2023-08-02', NULL, NULL),
(44, '2023080444', 'R2023080485', 'CUS2023080417', '388062.90', '428062.90', 1, '40000.00', '2023-08-04', 2, 1, '20230804R202308048564cc8321bf0b9.jpg', '388062.90', 2, '2023-08-04', 23, NULL, NULL, 26, '2023-08-04', NULL, NULL),
(45, '2023080445', 'R2023080486', 'CUS2023080417', '279191.25', '319191.25', 1, '40000.00', '2023-08-04', 2, 1, '20230804R202308048664cc84b706677.jpg', '279191.25', 6, NULL, NULL, '2023-08-04', 23, 26, '2023-08-04', NULL, NULL),
(46, '2023080446', 'R2023080487', 'CUS2023080417', '572527.50', '612527.50', 1, '40000.00', '2023-08-04', 3, 1, '20230804R202308048764cc8c6aaed71.jpg', '572527.50', 2, '2023-08-04', 23, NULL, NULL, 26, '2023-08-04', NULL, NULL),
(47, '2023080447', 'R2023080488', 'CUS2023080419', '422751.50', '462751.50', 1, '40000.00', '2023-08-04', 2, 1, '20230804R202308048864ccd605c4b3b.jpg', '422751.50', 2, '2023-08-04', 23, NULL, NULL, 28, '2023-08-04', NULL, NULL),
(48, '2023080448', 'R2023080489', 'CUS2023080419', '241937.00', '281937.00', 1, '40000.00', '2023-08-04', 3, 2, '20230804R202308048964ccd8395b57f.jpg', '241937.00', 2, '2023-08-04', 23, NULL, NULL, 28, '2023-08-04', NULL, NULL),
(49, '2023080449', 'R2023080490', 'CUS2023080420', '408319.00', '448319.00', 1, '40000.00', '2023-08-04', 2, 1, '20230804R202308049064cce02a90af3.jpg', '408319.00', 2, '2023-08-04', 23, NULL, NULL, 29, '2023-08-04', NULL, NULL),
(50, '2023080450', 'R2023080491', 'CUS2023080420', '296539.00', '336539.00', 1, '40000.00', '2023-08-04', 3, 1, '20230804R202308049164cce0ead0825.jpg', '296539.00', 2, '2023-08-04', 23, NULL, NULL, 29, '2023-08-04', NULL, NULL),
(51, '2023080451', 'R2023080492', 'CUS2023080421', '305670.00', '345670.00', 1, '40000.00', '2023-08-04', 2, 3, '20230804R202308049264cce1723b3aa.jpg', '305670.00', 2, '2023-08-04', 23, NULL, NULL, 30, '2023-08-04', NULL, NULL),
(52, '2023080452', 'R2023080493', 'CUS2023080421', '271400.00', '311400.00', 1, '40000.00', '2023-08-04', 3, 3, '20230804R202308049364cce2199bf2d.jpg', '271400.00', 2, '2023-08-04', 23, NULL, NULL, 30, '2023-08-04', NULL, NULL),
(53, '2023080453', 'R2023080494', 'CUS2023080422', '303197.50', '343197.50', 1, '40000.00', '2023-08-04', 3, 1, '20230804R202308049464cce2a03a26d.jpg', '303197.50', 2, '2023-08-04', 23, NULL, NULL, 31, '2023-08-04', NULL, NULL),
(54, '2023080454', 'R2023080495', 'CUS2023080422', '224825.00', '264825.00', 1, '40000.00', '2023-08-04', 2, 1, '20230804R202308049564cce2ef94164.jpg', '224825.00', 2, '2023-08-04', 23, NULL, NULL, 31, '2023-08-04', NULL, NULL),
(55, '2023080455', 'R2023080496', 'CUS2023080423', '344137.50', '384137.50', 1, '40000.00', '2023-08-04', 2, 1, '20230804R202308049664cce35a32382.jpg', '344137.50', 2, '2023-08-04', 23, NULL, NULL, 32, '2023-08-04', NULL, NULL),
(56, '2023080456', 'R2023080497', 'CUS2023080423', '280600.00', '320600.00', 1, '40000.00', '2023-08-04', 2, 1, '20230804R202308049764cce3d3642e3.jpg', '280600.00', 2, '2023-08-04', 23, NULL, NULL, 32, '2023-08-04', NULL, NULL),
(57, '2023080457', 'R2023080498', 'CUS2023080424', '208380.00', '248380.00', 1, '40000.00', '2023-08-04', 2, 1, '20230804R202308049864cce42c27533.jpg', '208380.00', 1, NULL, NULL, NULL, NULL, 33, '2023-08-04', NULL, NULL),
(58, '2023080458', 'R2023080499', 'CUS2023080424', '501515.00', '541515.00', 1, '40000.00', '2023-08-04', 2, 2, '20230804R202308049964cce48f90cb7.jpg', '501515.00', 1, NULL, NULL, NULL, NULL, 33, '2023-08-04', NULL, NULL),
(63, '2023080563', 'R20230805106', 'CUS2023080525', '399567.50', '439567.50', 1, '40000.00', '2023-08-05', 2, 1, '20230805R2023080510664cdf41f786c7.jpg', '399567.50', 4, '2023-08-05', 23, NULL, NULL, 34, '2023-08-05', NULL, NULL),
(64, '2023080564', 'R20230805106', 'CUS2023080525', '399567.50', '439567.50', 2, '79913.50', '2023-08-05', 3, 3, '20230805R2023080510664cdf86404c20.jpg', '319654.00', 1, NULL, NULL, NULL, NULL, 34, '2023-08-05', NULL, NULL),
(65, '2024052465', 'R20240524113', 'CUS2024052326', '1460406.25', '1500406.25', 1, '40000.00', '2024-05-24', 2, 1, 'bank_transfer_pay_slip.jpg', '1460406.25', 1, NULL, NULL, NULL, NULL, 35, '2024-05-24', NULL, NULL),
(66, '2024052866', 'R20240528115', 'CUS2024052827', '452286.00', '492286.00', 1, '40000.00', '2024-05-28', 3, 2, '20240528R2024052811566557a6e428e0.jpg', '452286.00', 4, '2024-05-28', 23, NULL, NULL, 36, '2024-05-28', 36, '2024-05-28'),
(67, '2024052867', 'R20240528115', 'CUS2024052827', '452286.00', '492286.00', 2, '90457.20', '2024-05-28', 2, 3, '20240528R2024052811566557e5cf1c13.jpg', '361828.80', 4, '2024-05-28', 23, NULL, NULL, 36, '2024-05-28', NULL, NULL),
(68, '2024052868', 'R20240528115', 'CUS2024052827', '452286.00', '492286.00', 3, '361828.80', '2024-05-28', 3, 1, '20240528R2024052811566559dfcf1627.jpg', '0.00', 2, '2024-05-28', 23, NULL, NULL, 36, '2024-05-28', 36, '2024-05-28'),
(69, '2024052869', 'R20240528117', 'CUS2024052827', '239140.00', '279140.00', 1, '40000.00', '2024-05-28', 2, 1, '20240528R202405281176655b2922a783.jpg', '239140.00', 2, '2024-05-28', 23, NULL, NULL, 36, '2024-05-28', NULL, NULL),
(70, '2024052870', 'R20240528118', 'CUS2024052827', '364980.00', '404980.00', 1, '40000.00', '2024-05-28', 3, 3, '20240528R202405281186655bf6098ecf.jpg', '364980.00', 4, '2024-05-28', 23, NULL, NULL, 36, '2024-05-28', NULL, NULL),
(71, '2024052871', 'R20240528118', 'CUS2024052827', '364980.00', '404980.00', 2, '72996.00', '2024-05-28', 2, 2, '20240528R202405281186655c127bc7f3.jpg', '291984.00', 2, '2024-05-28', 23, NULL, NULL, 36, '2024-05-28', NULL, NULL),
(72, '2024052872', 'R20240528119', 'CUS2024052827', '163300.00', '203300.00', 1, '40000.00', '2024-05-28', 2, 3, '20240528R202405281196655cfb2b2e2f.jpg', '163300.00', 4, '2024-05-28', 23, NULL, NULL, 36, '2024-05-28', NULL, NULL),
(73, '2024052873', 'R20240528119', 'CUS2024052827', '163300.00', '203300.00', 2, '32660.00', '2024-05-28', 3, 1, '20240528R202405281196655d0fbcb0a6.jpg', '130640.00', 4, '2024-05-28', 23, NULL, NULL, 36, '2024-05-28', NULL, NULL),
(74, '2024052874', 'R20240528119', 'CUS2024052827', '163300.00', '203300.00', 3, '130640.00', '2024-05-28', 2, 2, '20240528R202405281196655d15730582.jpg', '0.00', 2, '2024-05-28', 23, NULL, NULL, 36, '2024-05-28', NULL, NULL),
(75, '2024052875', 'R20240528121', 'CUS2024052827', '164500.00', '204500.00', 1, '40000.00', '2024-05-28', 2, 1, '20240528R202405281216655faf175122.jpg', '164500.00', 2, '2024-05-28', 1, NULL, NULL, 36, '2024-05-28', NULL, NULL),
(76, '2024052876', 'R20240528120', 'CUS2024052827', '231360.00', '271360.00', 1, '40000.00', '2024-05-28', 3, 1, '20240528R202405281206655fb377744e.jpg', '231360.00', 6, NULL, NULL, '2024-05-28', 1, 36, '2024-05-28', NULL, NULL),
(77, '2024061277', 'R20240612128', 'CUS2024052827', '294954.00', '334954.00', 1, '40000.00', '2024-06-12', 2, 1, '20240612R2024061212866695675b7274.jpg', '294954.00', 2, '2024-06-12', 1, NULL, NULL, 36, '2024-06-12', NULL, NULL),
(78, '2024061278', 'R20240612129', 'CUS2024052827', '318120.00', '358120.00', 1, '40000.00', '2024-06-12', 2, 1, '20240612R202406121296669575b03d1d.jpg', '318120.00', 2, '2024-06-12', 1, NULL, NULL, 36, '2024-06-12', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_bank`
--

DROP TABLE IF EXISTS `customer_payment_bank`;
CREATE TABLE IF NOT EXISTS `customer_payment_bank` (
  `cus_pay_bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `bank_branch` varchar(100) NOT NULL,
  PRIMARY KEY (`cus_pay_bank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_payment_bank`
--

INSERT INTO `customer_payment_bank` (`cus_pay_bank_id`, `payment_id`, `bank_branch`) VALUES
(5, 21, 'Dematagoda'),
(6, 24, 'Dematagoda'),
(8, 25, 'Dematagoda'),
(9, 26, 'Dematagoda'),
(12, 32, 'Dematagoda'),
(13, 34, 'Dematagoda'),
(14, 35, 'Borella'),
(15, 36, 'Borella'),
(16, 39, 'Dematagoda'),
(17, 40, 'Dematagoda'),
(18, 41, 'Dematagoda'),
(19, 42, 'Dematagoda'),
(20, 44, 'Dematagoda'),
(21, 45, 'Dematagoda'),
(22, 47, 'Dematagoda'),
(23, 49, 'Dematagoda'),
(24, 51, 'Borella'),
(25, 54, 'Dematagoda'),
(26, 55, 'Dematagoda'),
(27, 56, 'Dematagoda'),
(28, 57, 'Dematagoda'),
(29, 58, 'Dematagoda'),
(30, 59, 'Dematagoda'),
(31, 60, 'Dematagoda'),
(32, 62, 'Dematagoda'),
(33, 63, 'Dematagoda'),
(34, 65, 'Dematagoda'),
(36, 67, 'Borella'),
(37, 69, 'Dematagoda'),
(38, 71, 'Dematagoda'),
(39, 72, 'Borella'),
(40, 74, 'Dematagoda'),
(41, 75, 'Dematagoda'),
(42, 77, 'Dematagoda'),
(43, 78, 'Dematagoda');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_online`
--

DROP TABLE IF EXISTS `customer_payment_online`;
CREATE TABLE IF NOT EXISTS `customer_payment_online` (
  `cus_pay_online_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `reference_no` varchar(200) NOT NULL,
  PRIMARY KEY (`cus_pay_online_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_payment_online`
--

INSERT INTO `customer_payment_online` (`cus_pay_online_id`, `payment_id`, `reference_no`) VALUES
(6, 22, '2307128463495183'),
(7, 23, '2307138463495183'),
(8, 27, '2307238463495183'),
(10, 28, '2307208463495183'),
(12, 37, '2307248463495183'),
(13, 38, '2307248463495183'),
(14, 43, '2308028463495183'),
(15, 46, '2307248463495183'),
(16, 48, '2307248463495183'),
(17, 50, '2307248463495183'),
(18, 52, '2307248463495183'),
(19, 53, '2307248463495183'),
(20, 61, '2307248463495183'),
(21, 64, '230345463495183'),
(22, 66, '2307248463495183'),
(24, 68, '2307248463495144'),
(25, 70, '2307248463495200'),
(26, 73, '2307248463491120'),
(27, 76, '2307248463495230');

-- --------------------------------------------------------

--
-- Table structure for table `customer_review`
--

DROP TABLE IF EXISTS `customer_review`;
CREATE TABLE IF NOT EXISTS `customer_review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `approval_status` varchar(25) NOT NULL,
  `add_date` date NOT NULL,
  `approved_date` date DEFAULT NULL,
  `approved_user` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `reply` text,
  `reply_status` varchar(25) DEFAULT 'Not Replied',
  `replied_date` date DEFAULT NULL,
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_review`
--

INSERT INTO `customer_review` (`review_id`, `first_name`, `last_name`, `email`, `review`, `approval_status`, `add_date`, `approved_date`, `approved_user`, `image`, `reply`, `reply_status`, `replied_date`) VALUES
(1, 'Binuri', 'Kumaranathunge', 'binuridilara11@gmail.com', 'Best place in the area for weddings and other events. Good quality food and service for a reasonable price. Highly recommended.', 'Approved', '2023-08-02', '2023-08-03', 1, 'noImage.png', 'We appreciate sharing your feedback with us.', 'Replied', '2023-08-03'),
(2, 'Gayan', 'Pushpakumara', 'gayanbinu9874@gmail.com', 'Nice place. I visited for the first time and my experience was very good. Convenient location to have a function', 'Approved', '2023-08-02', '2023-08-03', 1, 'noImage.png', NULL, 'Not Replied', '0000-00-00'),
(3, 'Bhagya', 'Dilshani', 'bhagyadilshani.17@gmail.com', 'Excellent service with food. Its totally budget friendly for all occasions. Highly recommended.', 'Approved', '2023-08-03', '2023-08-03', 1, '.png', NULL, 'Not Replied', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_titles`
--

DROP TABLE IF EXISTS `customer_titles`;
CREATE TABLE IF NOT EXISTS `customer_titles` (
  `title_id` int(11) NOT NULL AUTO_INCREMENT,
  `title_name` varchar(255) NOT NULL,
  PRIMARY KEY (`title_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_titles`
--

INSERT INTO `customer_titles` (`title_id`, `title_name`) VALUES
(1, 'Ven'),
(2, 'Dr'),
(3, 'Mr'),
(4, 'Miss'),
(5, 'Mrs');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `name`) VALUES
(1, 'HR'),
(2, 'Operations'),
(3, 'Accounts'),
(4, 'Events Planning'),
(5, 'Maintenance'),
(6, 'Sales and Marketing');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

DROP TABLE IF EXISTS `designation`;
CREATE TABLE IF NOT EXISTS `designation` (
  `designation_id` int(11) NOT NULL AUTO_INCREMENT,
  `designation_name` varchar(255) NOT NULL,
  PRIMARY KEY (`designation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`designation_id`, `designation_name`) VALUES
(1, 'Owner'),
(2, 'Booking Manager'),
(3, 'Hall Manager'),
(4, 'Accountant'),
(5, 'Receptionist');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
CREATE TABLE IF NOT EXISTS `discount` (
  `discount_id` int(3) NOT NULL AUTO_INCREMENT,
  `reason` varchar(200) NOT NULL,
  `discount_period_start` date DEFAULT NULL,
  `discount_period_end` date DEFAULT NULL,
  `discount_ratio` decimal(5,2) NOT NULL,
  `availability` varchar(20) NOT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`discount_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`discount_id`, `reason`, `discount_period_start`, `discount_period_end`, `discount_ratio`, `availability`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(1, 'none', NULL, NULL, '0.00', 'Available', 1, '2023-05-06', NULL, NULL),
(2, 'New Year ', '2023-03-01', '2023-04-30', '0.05', 'Not Available', 2, '2023-06-16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
CREATE TABLE IF NOT EXISTS `district` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `district_name` varchar(255) NOT NULL,
  PRIMARY KEY (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`district_id`, `district_name`) VALUES
(1, 'Ampara'),
(2, 'Anuradhapura'),
(3, 'Badulla'),
(4, 'Batticaloa'),
(5, 'Colombo'),
(6, 'Galle'),
(7, 'Gampaha'),
(8, 'Hambantota'),
(9, 'Jaffna'),
(10, 'Kalutara'),
(11, 'Kandy'),
(12, 'Kegalle'),
(13, 'Kilinochchi'),
(14, 'Kurunegala'),
(15, 'Mannar'),
(16, 'Matale'),
(17, 'Matara'),
(18, 'Moneragala'),
(19, 'Mullaitivu'),
(20, 'Nuwara Eliya'),
(21, 'Polonnaruwa'),
(22, 'Puttalam'),
(23, 'Ratnapura'),
(24, 'Trincomalee'),
(25, 'Vavuniya');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_no` char(25) DEFAULT NULL,
  `emp_image` varchar(255) NOT NULL,
  `title` varchar(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `calling_name` varchar(255) NOT NULL,
  `house_no` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `district_id` int(11) NOT NULL,
  `contact_number` char(10) NOT NULL,
  `alternate_number` char(10) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `nic` char(12) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `recruitment_date` date NOT NULL,
  `employement_status_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `employee_no`, `emp_image`, `title`, `first_name`, `middle_name`, `last_name`, `calling_name`, `house_no`, `street`, `city`, `district_id`, `contact_number`, `alternate_number`, `email`, `dob`, `nic`, `gender`, `designation_id`, `recruitment_date`, `employement_status_id`, `user_id`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(10, 'EMP2024060810', '940081009V.png', 'Mr', 'Niroshan', 'Padmakumara', 'Mendis', 'Niroshan', 'Araliya Uyana', 'First Lane', 'Kelaniya', 7, '0766123045', '', 'bnpm00@gmail.com', '1994-01-08', '940081009V', 'Male', 1, '2024-01-01', 1, 41, 1, '2024-06-08', 41, '2024-06-09'),
(11, 'EMP2024060911', '977552761V.png', 'Miss', 'Binuri', 'Dilara', 'Kumaranathunge', 'Binuri', 'C11', 'Railway Flats', 'Dematagoda', 5, '0702825863', '', 'binuridilara11@gmail.com', '1997-09-11', '977552761V', 'Female', 2, '2024-05-28', 1, 42, 41, '2024-06-09', NULL, NULL),
(12, 'EMP2024060912', '955520700V.png', 'Mrs', 'Shashakya', 'Amadahara', 'Kuruppu', 'Amadahara', 'No. 234', 'Kolonnawa Road', 'Kolonnawa', 5, '0752526543', '', 'binuriwork@gmail.com', '1995-02-21', '955520700V', 'Female', 3, '2024-05-31', 1, 43, 41, '2024-06-09', NULL, NULL),
(13, 'EMP2024060913', '708111341V.png', 'Mrs', 'Dilini', 'Hemanthi', 'Ratnayake', 'Dilini', 'No. 39', 'Railway Quarters', 'Mountmary', 5, '0713543364', '', 'diliniratnayake1970@gmail.com', '1970-11-06', '708111341V', 'Female', 4, '2024-06-01', 1, 44, 41, '2024-06-09', NULL, NULL),
(14, 'EMP2024060914', '200374000446.png', 'Miss', 'Theshala', 'Induwari', 'Kumaranathunge', 'Induwari', '572/B/22/Y', 'Narangoda Road', 'Angoda', 5, '0702703226', '', 'induwari.0308@gmail.com', '2003-08-27', '200374000446', 'Female', 5, '2024-06-02', 1, 45, 41, '2024-06-09', NULL, NULL),
(15, 'EMP2024061015', '840821579V.png', 'Mr', 'Gayan', 'Indika', 'Pushpakumara', 'Gayan', '219/7', 'Vihara Lane', 'Hewagama', 5, '0773591279', '', 'gayanbinu9874@gmail.com', '1984-03-22', '840821579V', 'Male', 3, '2024-05-15', 2, 46, 41, '2024-06-10', NULL, NULL),
(16, 'EMP2024061016', '199400801009.png', 'Mr', 'Manuda', 'Vonal', 'Pushpakumara', 'Manuda', 'Samagi Mawatha', 'Maradana Road', 'Borella', 5, '0701251230', '', 'niroshan.lessons1@gmail.com', '1994-01-08', '199400801009', 'Male', 3, '2024-05-25', 2, 47, 41, '2024-06-10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_status`
--

DROP TABLE IF EXISTS `employee_status`;
CREATE TABLE IF NOT EXISTS `employee_status` (
  `employee_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(20) NOT NULL,
  PRIMARY KEY (`employee_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_status`
--

INSERT INTO `employee_status` (`employee_status_id`, `status_name`) VALUES
(1, 'Employed'),
(2, 'Resigned'),
(3, 'Retired');

-- --------------------------------------------------------

--
-- Table structure for table `employment_status`
--

DROP TABLE IF EXISTS `employment_status`;
CREATE TABLE IF NOT EXISTS `employment_status` (
  `employement_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `employement_status_name` varchar(100) NOT NULL,
  PRIMARY KEY (`employement_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employment_status`
--

INSERT INTO `employment_status` (`employement_status_id`, `employement_status_name`) VALUES
(1, 'Full - time'),
(2, 'Part - time'),
(3, 'Contract'),
(4, 'Intern');

-- --------------------------------------------------------

--
-- Table structure for table `emp_title`
--

DROP TABLE IF EXISTS `emp_title`;
CREATE TABLE IF NOT EXISTS `emp_title` (
  `title_id` int(11) NOT NULL AUTO_INCREMENT,
  `title_name` varchar(255) NOT NULL,
  PRIMARY KEY (`title_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emp_title`
--

INSERT INTO `emp_title` (`title_id`, `title_name`) VALUES
(1, 'Mr.'),
(2, 'Mrs.'),
(3, 'Miss.');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(100) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_name`) VALUES
(1, 'Wedding'),
(2, 'Homecoming'),
(3, 'Engagement'),
(4, 'Birthday Party'),
(5, 'Get-Together'),
(6, 'Business Party'),
(7, 'Conference Meeting'),
(8, 'Seminar'),
(9, 'Training Program'),
(10, 'Workshop'),
(11, 'Launch'),
(12, 'Private Party');

-- --------------------------------------------------------

--
-- Table structure for table `event_function_mode`
--

DROP TABLE IF EXISTS `event_function_mode`;
CREATE TABLE IF NOT EXISTS `event_function_mode` (
  `event_function_mode_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `function_mode_id` int(11) NOT NULL,
  `start_time` varchar(5) NOT NULL,
  `end_time` varchar(5) NOT NULL,
  PRIMARY KEY (`event_function_mode_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_function_mode`
--

INSERT INTO `event_function_mode` (`event_function_mode_id`, `event_id`, `function_mode_id`, `start_time`, `end_time`) VALUES
(1, 1, 1, '08:00', '15:00'),
(2, 1, 2, '18:00', '23:00'),
(3, 1, 2, '19:00', '24:00'),
(4, 2, 1, '08:00', '16:00'),
(5, 2, 1, '09:00', '15:00'),
(6, 2, 1, '10:00', '16:00'),
(7, 2, 2, '18:00', '23:00'),
(8, 2, 2, '19:00', '24:00'),
(9, 3, 1, '08:00', '16:00'),
(10, 3, 2, '18:00', '23:00'),
(11, 3, 2, '19:00', '24:00'),
(12, 4, 3, '08:00', '12:00'),
(13, 4, 4, '14:00', '18:00'),
(14, 4, 5, '20:00', '24:00'),
(15, 5, 1, '08:00', '16:00'),
(16, 5, 2, '18:00', '23:00'),
(17, 5, 2, '19:00', '24:00'),
(18, 6, 2, '18:00', '23:00'),
(19, 6, 2, '19:00', '24:00'),
(20, 7, 1, '08:00', '16:00'),
(21, 8, 1, '08:00', '18:00'),
(22, 9, 1, '08:00', '16:00'),
(23, 10, 1, '08:00', '12:00'),
(24, 11, 1, '08:00', '14:00'),
(25, 11, 1, '09:00', '15:00'),
(26, 11, 2, '16:00', '22:00'),
(27, 11, 2, '17:00', '23:00'),
(28, 11, 2, '18:00', '24:00'),
(29, 12, 2, '19:00', '24:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_menu_type`
--

DROP TABLE IF EXISTS `event_menu_type`;
CREATE TABLE IF NOT EXISTS `event_menu_type` (
  `event_menu_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_menu_type` varchar(50) NOT NULL,
  PRIMARY KEY (`event_menu_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_menu_type`
--

INSERT INTO `event_menu_type` (`event_menu_type_id`, `event_menu_type`) VALUES
(1, 'Wedding'),
(2, 'Birthday'),
(3, 'All');

-- --------------------------------------------------------

--
-- Table structure for table `event_service`
--

DROP TABLE IF EXISTS `event_service`;
CREATE TABLE IF NOT EXISTS `event_service` (
  `event_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`event_service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=408 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_service`
--

INSERT INTO `event_service` (`event_service_id`, `service_id`, `event_id`) VALUES
(171, 26, 1),
(172, 26, 2),
(173, 26, 3),
(174, 26, 5),
(175, 26, 6),
(176, 1, 1),
(177, 1, 2),
(178, 1, 3),
(179, 1, 4),
(180, 1, 5),
(181, 1, 6),
(182, 1, 7),
(183, 1, 8),
(184, 1, 9),
(185, 1, 10),
(186, 1, 11),
(187, 1, 12),
(188, 2, 1),
(189, 2, 2),
(190, 2, 3),
(191, 2, 4),
(192, 2, 5),
(193, 2, 6),
(194, 2, 12),
(195, 3, 1),
(196, 3, 2),
(197, 3, 3),
(198, 4, 1),
(199, 4, 2),
(200, 4, 3),
(201, 4, 9),
(202, 4, 10),
(203, 4, 11),
(204, 5, 1),
(205, 5, 2),
(206, 5, 3),
(207, 6, 1),
(208, 6, 2),
(209, 6, 3),
(210, 6, 4),
(211, 6, 5),
(212, 6, 6),
(213, 6, 12),
(224, 9, 1),
(225, 10, 1),
(226, 11, 1),
(227, 12, 1),
(228, 13, 1),
(234, 15, 1),
(235, 15, 2),
(236, 15, 3),
(237, 15, 4),
(238, 15, 5),
(239, 15, 12),
(240, 16, 1),
(241, 16, 2),
(242, 16, 3),
(243, 16, 4),
(244, 16, 5),
(245, 16, 6),
(246, 16, 7),
(247, 16, 8),
(248, 16, 9),
(249, 16, 10),
(250, 16, 11),
(251, 16, 12),
(252, 17, 1),
(253, 17, 2),
(254, 17, 3),
(255, 17, 8),
(256, 17, 9),
(257, 17, 10),
(258, 17, 11),
(259, 17, 12),
(260, 18, 1),
(261, 18, 2),
(262, 18, 3),
(263, 18, 12),
(264, 19, 1),
(265, 19, 2),
(266, 19, 3),
(267, 19, 4),
(268, 19, 5),
(269, 19, 6),
(270, 19, 7),
(271, 19, 8),
(272, 19, 9),
(273, 19, 10),
(274, 19, 11),
(275, 19, 12),
(276, 20, 1),
(277, 20, 2),
(278, 20, 3),
(279, 20, 4),
(280, 20, 5),
(281, 20, 6),
(282, 20, 7),
(283, 20, 8),
(284, 20, 9),
(285, 20, 10),
(286, 20, 11),
(287, 20, 12),
(288, 21, 1),
(289, 21, 2),
(290, 21, 3),
(291, 21, 4),
(292, 21, 5),
(293, 21, 6),
(294, 21, 7),
(295, 21, 8),
(296, 21, 9),
(297, 21, 10),
(298, 21, 11),
(299, 21, 12),
(300, 22, 1),
(301, 22, 2),
(302, 22, 3),
(303, 22, 4),
(304, 22, 5),
(305, 22, 6),
(306, 22, 12),
(319, 24, 1),
(320, 24, 2),
(321, 24, 3),
(322, 24, 4),
(323, 24, 5),
(324, 24, 6),
(325, 24, 7),
(326, 24, 11),
(327, 24, 12),
(328, 25, 1),
(329, 25, 2),
(330, 25, 5),
(331, 25, 6),
(335, 27, 1),
(336, 27, 2),
(337, 27, 3),
(338, 27, 11),
(339, 14, 1),
(340, 28, 4),
(352, 30, 4),
(354, 32, 1),
(355, 32, 2),
(356, 32, 3),
(357, 32, 4),
(358, 32, 5),
(359, 32, 6),
(360, 32, 11),
(361, 32, 12),
(362, 33, 1),
(363, 33, 2),
(364, 33, 3),
(365, 33, 12),
(366, 8, 1),
(367, 8, 2),
(368, 8, 3),
(369, 34, 3),
(388, 31, 2),
(389, 23, 1),
(390, 29, 2),
(391, 29, 5),
(392, 29, 6),
(393, 29, 7),
(394, 29, 8),
(395, 29, 9),
(396, 29, 10),
(397, 29, 11),
(398, 29, 12),
(399, 7, 1),
(400, 7, 2),
(401, 7, 3),
(402, 7, 4),
(403, 7, 5),
(404, 7, 6),
(405, 7, 7),
(406, 7, 11),
(407, 7, 12);

-- --------------------------------------------------------

--
-- Table structure for table `extras`
--

DROP TABLE IF EXISTS `extras`;
CREATE TABLE IF NOT EXISTS `extras` (
  `extra_id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_no` char(25) NOT NULL,
  `item_id` int(11) NOT NULL,
  `portion_qty` int(4) DEFAULT NULL,
  `portion_price` decimal(8,2) DEFAULT NULL,
  `total_portion_price` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`extra_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `extras`
--

INSERT INTO `extras` (`extra_id`, `reservation_no`, `item_id`, `portion_qty`, `portion_price`, `total_portion_price`) VALUES
(36, 'R2023051262', 2, 3, '110.00', '330.00'),
(37, 'R2023051262', 9, 5, '300.00', '1500.00'),
(38, 'R2023051262', 6, 5, '999.99', '4999.95'),
(39, 'R2023052664', 2, 20, '110.00', '2200.00'),
(40, 'R2023052664', 9, 15, '300.00', '4500.00');

-- --------------------------------------------------------

--
-- Table structure for table `function_mode`
--

DROP TABLE IF EXISTS `function_mode`;
CREATE TABLE IF NOT EXISTS `function_mode` (
  `function_mode_id` int(11) NOT NULL AUTO_INCREMENT,
  `function_mode` varchar(100) NOT NULL,
  PRIMARY KEY (`function_mode_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `function_mode`
--

INSERT INTO `function_mode` (`function_mode_id`, `function_mode`) VALUES
(1, 'Day'),
(2, 'Night'),
(3, 'Morning'),
(4, 'Afternoon'),
(5, 'Evening'),
(6, 'All Day'),
(7, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

DROP TABLE IF EXISTS `gender`;
CREATE TABLE IF NOT EXISTS `gender` (
  `gender_id` int(11) NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(10) NOT NULL,
  PRIMARY KEY (`gender_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`gender_id`, `gender_name`) VALUES
(1, 'male'),
(2, 'female');

-- --------------------------------------------------------

--
-- Table structure for table `hall`
--

DROP TABLE IF EXISTS `hall`;
CREATE TABLE IF NOT EXISTS `hall` (
  `hall_id` int(11) NOT NULL AUTO_INCREMENT,
  `hall_no` varchar(20) DEFAULT NULL,
  `hall_name` varchar(255) NOT NULL,
  `min_capacity` int(5) NOT NULL,
  `max_capacity` int(5) NOT NULL,
  `facilities` text NOT NULL,
  `hall_image` varchar(255) NOT NULL,
  `availability` varchar(25) NOT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`hall_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hall`
--

INSERT INTO `hall` (`hall_id`, `hall_no`, `hall_name`, `min_capacity`, `max_capacity`, `facilities`, `hall_image`, `availability`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(1, 'H - 001', 'Sapphire Ballroom', 100, 700, 'Cordless microphone with the podium, Dancing floor, Table for Gifts/Registration/Cake Structure, Changing room (only for the duration of the function)', 'Sapphire Ballroom.jpg', 'Available', 33, '2023-06-22', 1, '2023-07-09'),
(2, 'H - 002', 'Emerald Ballroom', 100, 700, 'Cordless microphone with the podium, Dancing floor, Table for Gifts/Registration/Cake Structure, Changing room (only for the duration of the function)', 'Emerald Ballroom.jpeg', 'Available', 33, '2023-06-22', 1, '2023-07-09');

-- --------------------------------------------------------

--
-- Table structure for table `hall_event`
--

DROP TABLE IF EXISTS `hall_event`;
CREATE TABLE IF NOT EXISTS `hall_event` (
  `hall_event_id` int(11) NOT NULL AUTO_INCREMENT,
  `hall_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`hall_event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hall_event`
--

INSERT INTO `hall_event` (`hall_event_id`, `hall_id`, `event_id`) VALUES
(289, 1, 1),
(290, 1, 2),
(291, 1, 3),
(292, 1, 4),
(293, 1, 5),
(294, 1, 6),
(295, 1, 7),
(296, 1, 8),
(297, 1, 9),
(298, 1, 10),
(299, 1, 11),
(300, 1, 12),
(301, 2, 1),
(302, 2, 2),
(303, 2, 3),
(304, 2, 4),
(305, 2, 5),
(306, 2, 6),
(307, 2, 7),
(308, 2, 8),
(309, 2, 9),
(310, 2, 10),
(311, 2, 11),
(312, 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `hall_status`
--

DROP TABLE IF EXISTS `hall_status`;
CREATE TABLE IF NOT EXISTS `hall_status` (
  `hall_status_id` int(4) NOT NULL AUTO_INCREMENT,
  `hall_status_name` varchar(25) NOT NULL,
  PRIMARY KEY (`hall_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hall_status`
--

INSERT INTO `hall_status` (`hall_status_id`, `hall_status_name`) VALUES
(1, 'Reserved'),
(2, 'Occupied'),
(3, 'Cleaning'),
(4, 'Maintenance'),
(5, 'Available'),
(6, 'Unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_details`
--

DROP TABLE IF EXISTS `hotel_details`;
CREATE TABLE IF NOT EXISTS `hotel_details` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `open_time` varchar(5) NOT NULL,
  `close_time` varchar(5) NOT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hotel_details`
--

INSERT INTO `hotel_details` (`detail_id`, `open_time`, `close_time`) VALUES
(1, '08:00', '24:00');

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

DROP TABLE IF EXISTS `item_category`;
CREATE TABLE IF NOT EXISTS `item_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `availability` varchar(15) NOT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`category_id`, `category_name`, `availability`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(1, 'Welcome Drink', 'Available', 2, '2023-06-30', NULL, NULL),
(2, 'Main Dish', 'Available', 2, '2023-06-30', NULL, NULL),
(3, 'Side Dish', 'Available', 2, '2023-06-30', NULL, NULL),
(4, 'Salad', 'Available', 2, '2023-06-30', NULL, NULL),
(5, 'Dessert', 'Available', 2, '2023-06-30', NULL, NULL),
(6, 'Chicken Varieties', 'Available', 2, '2023-06-30', NULL, NULL),
(7, 'Beef Varieties', 'Available', 2, '2023-06-30', NULL, NULL),
(8, 'Seafood Varieties', 'Available', 2, '2023-06-30', 2, '2023-07-01'),
(9, 'Gravy Chicken Varieties', 'Available', 2, '2023-06-30', 2, '2023-06-30'),
(10, 'Beverages', 'Available', 3, '2023-07-05', 3, '2023-07-05'),
(11, 'Bites', 'Available', 3, '2023-07-05', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_arrange_type`
--

DROP TABLE IF EXISTS `menu_arrange_type`;
CREATE TABLE IF NOT EXISTS `menu_arrange_type` (
  `arrange_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `arrange_type` varchar(30) NOT NULL,
  PRIMARY KEY (`arrange_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_arrange_type`
--

INSERT INTO `menu_arrange_type` (`arrange_type_id`, `arrange_type`) VALUES
(1, 'Buffet'),
(2, 'Plated'),
(3, 'Stations'),
(4, 'Family Style');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

DROP TABLE IF EXISTS `menu_item`;
CREATE TABLE IF NOT EXISTS `menu_item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `availability` varchar(15) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `profit_ratio` decimal(5,2) NOT NULL,
  `portion_price` decimal(10,2) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `addon_status` varchar(5) NOT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`item_id`, `category_id`, `item_name`, `availability`, `item_price`, `profit_ratio`, `portion_price`, `item_image`, `addon_status`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(1, 1, 'Strawberry and Guava', 'Available', '120.00', '10.00', '132.00', 'Strawberry and Guava649f3feb48524.jpeg', 'Yes', 2, '2023-06-30', 2, '2023-06-30'),
(2, 1, 'Mango', 'Available', '120.00', '10.00', '132.00', 'Mango649f373512ee7.jpeg', 'Yes', 2, '2023-06-30', NULL, NULL),
(3, 1, 'Orange Juice', 'Available', '130.00', '10.00', '143.00', 'Orange Juice64a0357cc3cd4.jpeg', 'Yes', 2, '2023-07-01', 2, '2023-07-01'),
(4, 1, 'Apple Juice', 'Available', '130.00', '10.00', '143.00', 'Apple Juice64a034f516a5a.jpeg', 'No', 2, '2023-07-01', NULL, NULL),
(5, 1, 'Lemon and Mint', 'Available', '100.00', '10.00', '110.00', 'Lemon and Mint64a035b9867c2.jpeg', 'No', 2, '2023-07-01', NULL, NULL),
(6, 1, 'Black Current', 'Available', '140.00', '10.00', '154.00', 'Black Current64a035e70b6ef.jpeg', 'No', 2, '2023-07-01', NULL, NULL),
(7, 1, 'Mix Fruit Juice', 'Available', '120.00', '10.00', '132.00', 'Mix Fruit Juice64a0361ab8086.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(8, 2, 'Fried Rice', 'Available', '100.00', '10.00', '110.00', 'Fried Rice64a03774370b2.jpeg', 'No', 2, '2023-07-01', 2, '2023-07-01'),
(9, 2, 'Keeri Samba Chicken Biriyani', 'Available', '120.00', '10.00', '132.00', 'Keeri Samba Chicken Biriyani64a037617e32c.jpeg', 'No', 2, '2023-07-01', NULL, NULL),
(10, 2, 'White Rice', 'Available', '60.00', '10.00', '66.00', 'White Rice64a037a53e315.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(11, 2, 'Garlic Rice', 'Available', '90.00', '10.00', '99.00', 'Garlic Rice64a037f987f19.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(12, 2, 'Saffron Rice', 'Available', '100.00', '10.00', '110.00', 'Saffron Rice64a0382112d2e.jpeg', 'No', 2, '2023-07-01', NULL, NULL),
(13, 2, 'Chicken Biriyani', 'Available', '110.00', '10.00', '121.00', 'Chicken Biriyani64a0386f62199.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(14, 2, 'Chicken String Hopper Biriyani', 'Available', '120.00', '10.00', '132.00', 'Chicken String Hopper Biriyani64a0394fa3b9f.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(15, 2, 'Fried Noodles', 'Available', '100.00', '10.00', '110.00', 'Fried Noodles64a039a561a4c.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(16, 2, 'String Hopper Pilo', 'Available', '50.00', '10.00', '55.00', 'String Hopper Pilo64a039d89457d.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(17, 3, 'Potato Tempered', 'Available', '100.00', '10.00', '110.00', 'Potato Tempered64a03f961d3d4.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(18, 3, 'Brinjal Moju', 'Available', '140.00', '10.00', '154.00', 'Brinjal Moju64a03fc6aac79.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(19, 3, 'Green Peas and Cashew Mix Curry', 'Available', '200.00', '10.00', '220.00', 'Green Peas and Cashew Mix Curry64a0402b1f182.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(20, 3, 'Devilled Mushroom', 'Available', '120.00', '10.00', '132.00', 'Devilled Mushroom64a0407d0e192.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(21, 3, 'Maldive Fish Sambol', 'Available', '150.00', '10.00', '165.00', 'Maldive Fish Sambol64a040edcda97.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(22, 3, 'Sinhala Achcharu', 'Available', '160.00', '10.00', '176.00', 'Sinhala Achcharu64a041363cc64.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(23, 3, 'Malay Achcharu', 'Available', '150.00', '10.00', '165.00', 'Malay Achcharu64a043aa8d256.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(24, 3, 'Papadam', 'Available', '100.00', '10.00', '110.00', 'Papadam64a043e6569cc.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(25, 3, 'Cutlet', 'Available', '60.00', '10.00', '66.00', 'Cutlet64a0444bc69e3.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(26, 3, 'Moru Chilly', 'Available', '100.00', '10.00', '110.00', 'Moru Chilly64a04479ad747.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(27, 3, 'Vegetable Chopsuey', 'Available', '150.00', '10.00', '165.00', 'Vegetable Chopsuey64a044d1506f3.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(28, 3, 'Chilli Paste', 'Available', '70.00', '10.00', '77.00', 'Chilli Paste64a044ef7766d.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(29, 4, 'Green Salad', 'Available', '100.00', '10.00', '110.00', 'Green Salad64a0452fae62a.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(30, 4, 'Cucumber Salad', 'Available', '100.00', '10.00', '110.00', 'Cucumber Salad64a045647ff2f.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(31, 4, 'Seafood Salad', 'Available', '250.00', '10.00', '275.00', 'Seafood Salad64a045920d9a4.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(32, 4, 'Tuna and Bean Salad', 'Available', '150.00', '10.00', '165.00', 'Tuna and Bean Salad64a045bd783d7.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(33, 4, 'Mixed Vegetable Salad', 'Available', '100.00', '10.00', '110.00', 'Mixed Vegetable Salad64a045e3b8c3c.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(34, 4, 'Assorted Appetizer on Mirror', 'Available', '150.00', '10.00', '165.00', 'Assorted Appetizer on Mirror64a0461a69abf.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(35, 4, 'Chicken Ham and Pineapple Salad', 'Available', '120.00', '10.00', '132.00', 'Chicken Ham and Pineapple Salad64a0465512d3e.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(36, 4, 'Pineapple and Sausage Mixed Salad', 'Available', '130.00', '10.00', '143.00', 'Pineapple and Sausage Mixed Salad64a046a883eb4.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(37, 4, 'Carrot and Sultana Salad', 'Available', '100.00', '10.00', '110.00', 'Carrot and Sultana Salad64a046d155379.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(38, 5, 'Icecream', 'Available', '100.00', '10.00', '110.00', 'Icecream64a047cbd2d55.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(39, 5, 'Fruit Salad', 'Available', '120.00', '10.00', '132.00', 'Fruit Salad64a0481816451.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(40, 5, 'Watalappan', 'Available', '150.00', '10.00', '165.00', 'Watalappan64a048454521c.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(41, 5, 'Double Caramel Pudding', 'Available', '130.00', '10.00', '143.00', 'Double Caramel Pudding64a0489366aaa.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(42, 5, 'Jelly Pudding', 'Available', '120.00', '10.00', '132.00', 'Jelly Pudding64a048ced87fb.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(43, 5, 'Fruit Triffle', 'Available', '120.00', '10.00', '132.00', 'Fruit Triffle64a0490dc2e52.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(44, 5, 'Jelly Caramel', 'Available', '150.00', '10.00', '165.00', 'Jelly Caramel64a0493f60d0e.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(45, 5, 'Blake Alaska', 'Available', '150.00', '10.00', '165.00', 'Blake Alaska64a049711bd59.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(46, 5, 'Passion Mousse', 'Available', '150.00', '10.00', '165.00', 'Passion Mousse64a049a05c081.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(47, 5, 'Chocolate Triffle', 'Available', '150.00', '10.00', '165.00', 'Chocolate Triffle64a049c8444be.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(48, 6, 'Devilled Chicken', 'Available', '150.00', '10.00', '165.00', 'Devilled Chicken64a04a177243f.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(49, 6, 'Chilli Chicken', 'Available', '150.00', '10.00', '165.00', 'Chilli Chicken64a04a3eccdfb.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(50, 6, 'Chicken', 'Available', '150.00', '10.00', '165.00', 'Chicken64a04aba181b9.jpeg', 'Yes', 2, '2023-07-01', 2, '2023-07-01'),
(51, 6, 'Thandoori Chicken', 'Available', '150.00', '10.00', '165.00', 'Thandoori Chicken64a04aef8d2bb.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(52, 6, 'Chicken Korma', 'Available', '150.00', '10.00', '165.00', 'Chicken Korma64a04b2189617.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(53, 6, 'Fried Chicken Korma', 'Available', '200.00', '10.00', '220.00', 'Fried Chicken Korma64a04b4eb8c88.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(54, 9, 'Hydrabhath Chicken Korma', 'Available', '200.00', '10.00', '220.00', 'Hydrabhath Chicken Korma64a04ba10f763.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(55, 9, 'Butter Chicken', 'Available', '200.00', '10.00', '220.00', 'Butter Chicken64a04bc2889ea.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(56, 9, 'Chicken Pepper Korma', 'Available', '200.00', '10.00', '220.00', 'Chicken Pepper Korma64a04bef42889.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(57, 9, 'Chicken Tikka Masala', 'Available', '200.00', '10.00', '220.00', 'Chicken Tikka Masala64a04c13accb6.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(58, 7, 'Devilled Beef', 'Available', '220.00', '10.00', '242.00', 'Devilled Beef64a04c46e7d12.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(59, 7, 'Beef Curry', 'Available', '220.00', '10.00', '242.00', 'Beef Curry64a04c68e7e87.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(60, 8, 'Devilled Fish', 'Available', '200.00', '10.00', '220.00', 'Devilled Fish64a04cba06c5c.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(61, 8, 'Fish Ambul Thiyal', 'Available', '200.00', '10.00', '220.00', 'Fish Ambul Thiyal64a04ce7727eb.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(62, 8, 'Devilled Prawns', 'Available', '200.00', '10.00', '220.00', 'Devilled Prawns64a04d1664c21.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL),
(63, 8, 'Devilled Cuttle Fish', 'Available', '200.00', '10.00', '220.00', 'Devilled Cuttle Fish64a04d4b7a4aa.jpeg', 'Yes', 2, '2023-07-01', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_package`
--

DROP TABLE IF EXISTS `menu_package`;
CREATE TABLE IF NOT EXISTS `menu_package` (
  `menu_package_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_package_name` varchar(255) NOT NULL,
  `menu_type_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `profit_ratio` decimal(5,2) NOT NULL,
  `final_price` decimal(10,2) NOT NULL,
  `availability` varchar(15) NOT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`menu_package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_package`
--

INSERT INTO `menu_package` (`menu_package_id`, `menu_package_name`, `menu_type_id`, `total_price`, `profit_ratio`, `final_price`, `availability`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(1, 'Budget', 1, '913.00', '20.00', '1095.60', 'Available', 2, '2023-07-01', 2, '2023-07-02'),
(2, 'Bronce', 1, '1463.00', '10.00', '1609.30', 'Available', 2, '2023-07-02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_package_item`
--

DROP TABLE IF EXISTS `menu_package_item`;
CREATE TABLE IF NOT EXISTS `menu_package_item` (
  `menu_package_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_package_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_package_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_package_item`
--

INSERT INTO `menu_package_item` (`menu_package_item_id`, `menu_package_id`, `category_id`, `item_id`) VALUES
(19, 2, 1, 3),
(20, 2, 2, 9),
(21, 2, 2, 10),
(22, 2, 3, 19),
(23, 2, 3, 21),
(24, 2, 3, 22),
(25, 2, 3, 23),
(26, 2, 3, 24),
(27, 2, 3, 25),
(28, 2, 4, 30),
(29, 2, 5, 38),
(65, 1, 1, 1),
(66, 1, 2, 8),
(67, 1, 3, 18),
(68, 1, 3, 27),
(69, 1, 3, 28),
(70, 1, 5, 38),
(71, 1, 6, 48);

-- --------------------------------------------------------

--
-- Table structure for table `menu_type`
--

DROP TABLE IF EXISTS `menu_type`;
CREATE TABLE IF NOT EXISTS `menu_type` (
  `menu_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_type_name` varchar(20) NOT NULL,
  PRIMARY KEY (`menu_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_type`
--

INSERT INTO `menu_type` (`menu_type_id`, `menu_type_name`) VALUES
(1, 'Fixed'),
(2, 'Customized');

-- --------------------------------------------------------

--
-- Table structure for table `outsource_service_package`
--

DROP TABLE IF EXISTS `outsource_service_package`;
CREATE TABLE IF NOT EXISTS `outsource_service_package` (
  `service_package_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `sample_image` varchar(255) NOT NULL,
  PRIMARY KEY (`service_package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

DROP TABLE IF EXISTS `package`;
CREATE TABLE IF NOT EXISTS `package` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(100) NOT NULL,
  `event_id` int(11) NOT NULL,
  `menu_package_id` int(11) NOT NULL,
  `pax_count` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `service_charge` decimal(5,2) NOT NULL,
  `final_price` decimal(10,2) NOT NULL,
  `display_price` decimal(10,2) NOT NULL,
  `per_person_price` decimal(10,2) NOT NULL,
  `availability` varchar(15) NOT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_id`, `package_name`, `event_id`, `menu_package_id`, `pax_count`, `total_price`, `service_charge`, `final_price`, `display_price`, `per_person_price`, `availability`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(7, 'Package 1', 1, 1, 100, '167640.00', '15.00', '192786.00', '192800.00', '1928.00', 'Available', 1, '2023-08-04', NULL, NULL),
(8, 'Package 2', 1, 2, 100, '222060.00', '15.00', '255369.00', '255400.00', '2554.00', 'Available', 1, '2023-08-04', NULL, NULL),
(9, 'Package 3', 2, 1, 100, '143040.00', '15.00', '164496.00', '164500.00', '1645.00', 'Available', 1, '2023-08-04', NULL, NULL),
(10, 'Package 4', 2, 2, 100, '199010.00', '15.00', '228861.50', '228900.00', '2289.00', 'Available', 1, '2023-08-04', NULL, NULL),
(11, 'Package 5', 3, 1, 100, '141940.00', '15.00', '163231.00', '163300.00', '1633.00', 'Available', 1, '2023-08-04', NULL, NULL),
(12, 'Package 6', 3, 2, 100, '198810.00', '15.00', '228631.50', '228700.00', '2287.00', 'Available', 1, '2023-08-04', NULL, NULL),
(13, 'Package 7', 4, 1, 100, '140940.00', '15.00', '162081.00', '162100.00', '1621.00', 'Available', 1, '2023-08-04', NULL, NULL),
(14, 'Package 8', 4, 2, 100, '192310.00', '15.00', '221156.50', '221200.00', '2212.00', 'Available', 1, '2023-08-04', NULL, NULL),
(15, 'Package 9', 5, 1, 100, '197630.00', '10.00', '217393.00', '217400.00', '2174.00', 'Available', 1, '2023-08-04', NULL, NULL),
(16, 'Package 10', 5, 2, 100, '249000.00', '15.00', '286350.00', '286400.00', '2864.00', 'Available', 1, '2023-08-04', NULL, NULL),
(17, 'Package 11', 6, 1, 100, '197630.00', '10.00', '217393.00', '217400.00', '2174.00', 'Available', 1, '2023-08-04', NULL, NULL),
(18, 'Package 12', 6, 2, 100, '249000.00', '15.00', '286350.00', '286400.00', '2864.00', 'Available', 1, '2023-08-04', NULL, NULL),
(19, 'Package 13', 7, 1, 100, '177680.00', '10.00', '195448.00', '195500.00', '1955.00', 'Available', 1, '2023-08-04', NULL, NULL),
(20, 'Package 14', 7, 2, 100, '229050.00', '15.00', '263407.50', '263500.00', '2635.00', 'Available', 1, '2023-08-04', NULL, NULL),
(21, 'Package 15', 8, 1, 100, '153780.00', '10.00', '169158.00', '169200.00', '1692.00', 'Available', 1, '2023-08-04', NULL, NULL),
(22, 'Package 16', 8, 2, 100, '205150.00', '15.00', '235922.50', '236000.00', '2360.00', 'Available', 1, '2023-08-04', NULL, NULL),
(23, 'Package 17', 9, 1, 100, '153780.00', '10.00', '169158.00', '169200.00', '1692.00', 'Available', 1, '2023-08-04', NULL, NULL),
(24, 'Package 18', 9, 2, 100, '205150.00', '15.00', '235922.50', '236000.00', '2360.00', 'Available', 1, '2023-08-04', NULL, NULL),
(25, 'Package 19', 10, 1, 100, '153780.00', '10.00', '169158.00', '169200.00', '1692.00', 'Available', 1, '2023-08-04', NULL, NULL),
(26, 'Package 20', 10, 2, 100, '205150.00', '15.00', '235922.50', '236000.00', '2360.00', 'Available', 1, '2023-08-04', NULL, NULL),
(27, 'Package 21', 11, 1, 100, '183180.00', '10.00', '201498.00', '201500.00', '2015.00', 'Available', 1, '2023-08-04', NULL, NULL),
(28, 'Package 22', 11, 2, 100, '234550.00', '15.00', '269732.50', '269800.00', '2698.00', 'Available', 1, '2023-08-04', NULL, NULL),
(29, 'Package 23', 12, 1, 100, '206740.00', '10.00', '227414.00', '227500.00', '2275.00', 'Available', 1, '2023-08-04', NULL, NULL),
(30, 'Package 24', 12, 2, 100, '258110.00', '15.00', '296826.50', '296900.00', '2969.00', 'Available', 1, '2023-08-04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `package_services`
--

DROP TABLE IF EXISTS `package_services`;
CREATE TABLE IF NOT EXISTS `package_services` (
  `package_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`package_service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=347 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `package_services`
--

INSERT INTO `package_services` (`package_service_id`, `package_id`, `category_id`, `service_id`, `service_price`) VALUES
(29, 0, 1, 1, '25000.00'),
(30, 0, 3, 14, '12500.00'),
(31, 0, 4, 6, '6250.00'),
(32, 0, 4, 7, '12500.00'),
(33, 0, 1, 1, '25000.00'),
(34, 0, 3, 14, '12500.00'),
(35, 0, 4, 6, '6250.00'),
(36, 0, 4, 7, '12500.00'),
(128, 2, 1, 1, '25000.00'),
(129, 2, 2, 16, '25000.00'),
(130, 2, 3, 14, '12500.00'),
(131, 2, 4, 6, '6250.00'),
(132, 2, 4, 7, '12500.00'),
(133, 2, 8, 22, '550.00'),
(134, 2, 2, 9, '2500.00'),
(135, 2, 2, 11, '10000.00'),
(136, 2, 2, 12, '3750.00'),
(137, 2, 3, 13, '3750.00'),
(138, 2, 4, 5, '3750.00'),
(139, 2, 8, 3, '34800.00'),
(157, 6, 1, 1, '25000.00'),
(158, 6, 4, 5, '3750.00'),
(159, 6, 4, 6, '6250.00'),
(160, 6, 4, 7, '12500.00'),
(161, 6, 4, 19, '2200.00'),
(162, 6, 4, 20, '2200.00'),
(163, 6, 8, 4, '12000.00'),
(164, 6, 2, 10, '7500.00'),
(165, 6, 2, 12, '3750.00'),
(166, 6, 8, 2, '15000.00'),
(167, 6, 10, 17, '1100.00'),
(168, 6, 10, 18, '1650.00'),
(169, 6, 3, 13, '3750.00'),
(170, 6, 5, 21, '1320.00'),
(171, 6, 8, 22, '550.00'),
(172, 6, 2, 16, '25000.00'),
(173, 3, 1, 1, '25000.00'),
(174, 3, 2, 16, '25000.00'),
(176, 3, 4, 6, '6250.00'),
(177, 3, 4, 7, '12500.00'),
(178, 3, 8, 22, '550.00'),
(179, 3, 3, 28, '6900.00'),
(180, 4, 1, 1, '25000.00'),
(182, 4, 4, 6, '6250.00'),
(183, 4, 4, 7, '12500.00'),
(184, 4, 3, 28, '6900.00'),
(185, 5, 1, 1, '25000.00'),
(186, 5, 4, 6, '6250.00'),
(187, 5, 4, 7, '12500.00'),
(188, 5, 3, 28, '6900.00'),
(189, 1, 1, 1, '25000.00'),
(190, 1, 2, 9, '2500.00'),
(191, 1, 2, 10, '7500.00'),
(192, 1, 2, 12, '3750.00'),
(193, 1, 3, 14, '12500.00'),
(194, 1, 4, 7, '12500.00'),
(195, 1, 3, 24, '110.00'),
(196, 7, 1, 1, '25000.00'),
(197, 7, 2, 9, '2500.00'),
(198, 7, 2, 10, '7500.00'),
(199, 7, 2, 12, '3750.00'),
(200, 7, 3, 13, '3750.00'),
(201, 7, 3, 14, '12500.00'),
(202, 7, 3, 24, '110.00'),
(203, 7, 5, 21, '1320.00'),
(204, 7, 10, 18, '1650.00'),
(205, 8, 1, 1, '25000.00'),
(206, 8, 2, 9, '2500.00'),
(207, 8, 2, 10, '7500.00'),
(208, 8, 2, 12, '3750.00'),
(209, 8, 3, 13, '3750.00'),
(210, 8, 3, 24, '110.00'),
(211, 8, 5, 21, '1320.00'),
(212, 8, 8, 2, '15000.00'),
(213, 8, 8, 22, '550.00'),
(214, 8, 10, 18, '1650.00'),
(215, 9, 1, 1, '25000.00'),
(216, 9, 3, 24, '110.00'),
(217, 9, 4, 5, '3750.00'),
(218, 9, 5, 21, '1320.00'),
(219, 9, 8, 22, '550.00'),
(220, 9, 10, 17, '1100.00'),
(221, 9, 10, 18, '1650.00'),
(222, 10, 1, 1, '25000.00'),
(223, 10, 3, 15, '6250.00'),
(224, 10, 3, 24, '110.00'),
(225, 10, 4, 5, '3750.00'),
(226, 10, 5, 21, '1320.00'),
(227, 10, 8, 22, '550.00'),
(228, 10, 10, 17, '1100.00'),
(229, 11, 1, 1, '25000.00'),
(230, 11, 3, 24, '110.00'),
(231, 11, 4, 5, '3750.00'),
(232, 11, 5, 21, '1320.00'),
(233, 11, 8, 22, '550.00'),
(234, 11, 10, 18, '1650.00'),
(235, 12, 1, 1, '25000.00'),
(236, 12, 3, 24, '110.00'),
(237, 12, 4, 5, '3750.00'),
(238, 12, 4, 32, '4400.00'),
(239, 12, 5, 21, '1320.00'),
(240, 12, 8, 22, '550.00'),
(241, 12, 10, 17, '1100.00'),
(242, 12, 10, 18, '1650.00'),
(243, 13, 1, 1, '25000.00'),
(244, 13, 3, 24, '110.00'),
(245, 13, 4, 32, '4400.00'),
(246, 13, 5, 21, '1320.00'),
(247, 13, 8, 22, '550.00'),
(248, 14, 1, 1, '25000.00'),
(249, 14, 3, 24, '110.00'),
(250, 14, 4, 32, '4400.00'),
(251, 14, 5, 21, '1320.00'),
(252, 14, 8, 22, '550.00'),
(253, 15, 1, 1, '25000.00'),
(254, 15, 8, 2, '15000.00'),
(255, 15, 8, 22, '550.00'),
(256, 15, 4, 7, '25000.00'),
(257, 15, 4, 32, '4400.00'),
(258, 15, 5, 21, '1320.00'),
(259, 15, 12, 29, '16800.00'),
(260, 16, 1, 1, '25000.00'),
(261, 16, 8, 2, '15000.00'),
(262, 16, 8, 22, '550.00'),
(263, 16, 4, 7, '25000.00'),
(264, 16, 4, 32, '4400.00'),
(265, 16, 5, 21, '1320.00'),
(266, 16, 12, 29, '16800.00'),
(267, 17, 1, 1, '25000.00'),
(268, 17, 8, 2, '15000.00'),
(269, 17, 8, 22, '550.00'),
(270, 17, 4, 7, '25000.00'),
(271, 17, 4, 32, '4400.00'),
(272, 17, 5, 21, '1320.00'),
(273, 17, 12, 29, '16800.00'),
(274, 18, 1, 1, '25000.00'),
(275, 18, 8, 2, '15000.00'),
(276, 18, 8, 22, '550.00'),
(277, 18, 4, 7, '25000.00'),
(278, 18, 4, 32, '4400.00'),
(279, 18, 5, 21, '1320.00'),
(280, 18, 12, 29, '16800.00'),
(281, 19, 1, 1, '25000.00'),
(282, 19, 4, 7, '25000.00'),
(283, 19, 5, 21, '1320.00'),
(284, 19, 12, 29, '16800.00'),
(285, 20, 1, 1, '25000.00'),
(286, 20, 4, 7, '25000.00'),
(287, 20, 5, 21, '1320.00'),
(288, 20, 12, 29, '16800.00'),
(289, 21, 1, 1, '25000.00'),
(290, 21, 10, 17, '1100.00'),
(291, 21, 5, 21, '1320.00'),
(292, 21, 12, 29, '16800.00'),
(293, 22, 1, 1, '25000.00'),
(294, 22, 10, 17, '1100.00'),
(295, 22, 5, 21, '1320.00'),
(296, 22, 12, 29, '16800.00'),
(297, 23, 1, 1, '25000.00'),
(298, 23, 10, 17, '1100.00'),
(299, 23, 5, 21, '1320.00'),
(300, 23, 12, 29, '16800.00'),
(301, 24, 1, 1, '25000.00'),
(302, 24, 10, 17, '1100.00'),
(303, 24, 5, 21, '1320.00'),
(304, 24, 12, 29, '16800.00'),
(305, 25, 1, 1, '25000.00'),
(306, 25, 10, 17, '1100.00'),
(307, 25, 5, 21, '1320.00'),
(308, 25, 12, 29, '16800.00'),
(309, 26, 1, 1, '25000.00'),
(310, 26, 10, 17, '1100.00'),
(311, 26, 5, 21, '1320.00'),
(312, 26, 12, 29, '16800.00'),
(313, 27, 1, 1, '25000.00'),
(314, 27, 4, 7, '25000.00'),
(315, 27, 4, 32, '4400.00'),
(316, 27, 10, 17, '1100.00'),
(317, 27, 5, 21, '1320.00'),
(318, 27, 12, 29, '16800.00'),
(319, 28, 1, 1, '25000.00'),
(320, 28, 4, 7, '25000.00'),
(321, 28, 4, 32, '4400.00'),
(322, 28, 10, 17, '1100.00'),
(323, 28, 5, 21, '1320.00'),
(324, 28, 12, 29, '16800.00'),
(325, 29, 1, 1, '25000.00'),
(326, 29, 8, 2, '15000.00'),
(327, 29, 8, 22, '550.00'),
(328, 29, 4, 7, '25000.00'),
(329, 29, 4, 32, '4400.00'),
(330, 29, 3, 24, '110.00'),
(331, 29, 3, 15, '6250.00'),
(332, 29, 10, 17, '1100.00'),
(333, 29, 10, 18, '1650.00'),
(334, 29, 5, 21, '1320.00'),
(335, 29, 12, 29, '16800.00'),
(336, 30, 1, 1, '25000.00'),
(337, 30, 8, 2, '15000.00'),
(338, 30, 8, 22, '550.00'),
(339, 30, 4, 7, '25000.00'),
(340, 30, 4, 32, '4400.00'),
(341, 30, 3, 15, '6250.00'),
(342, 30, 3, 24, '110.00'),
(343, 30, 10, 17, '1100.00'),
(344, 30, 10, 18, '1650.00'),
(345, 30, 5, 21, '1320.00'),
(346, 30, 12, 29, '16800.00');

-- --------------------------------------------------------

--
-- Table structure for table `payable_service`
--

DROP TABLE IF EXISTS `payable_service`;
CREATE TABLE IF NOT EXISTS `payable_service` (
  `payable_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_price` decimal(10,2) NOT NULL,
  `profit_ratio` decimal(5,2) NOT NULL,
  `final_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`payable_service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_category`
--

DROP TABLE IF EXISTS `payment_category`;
CREATE TABLE IF NOT EXISTS `payment_category` (
  `payment_category_id` int(5) NOT NULL AUTO_INCREMENT,
  `payment_category_name` varchar(100) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `ratio` decimal(5,2) DEFAULT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`payment_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_category`
--

INSERT INTO `payment_category` (`payment_category_id`, `payment_category_name`, `amount`, `ratio`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(1, 'Security Payment', '40000.00', '0.00', 1, '2023-05-27', NULL, NULL),
(2, 'Advance Payment', '0.00', '0.20', 1, '2023-05-27', NULL, NULL),
(3, 'Balance Payment', '0.00', '0.80', 1, '2023-05-27', NULL, NULL),
(4, 'Full Payment', '0.00', '1.00', 1, '2023-05-27', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE IF NOT EXISTS `payment_method` (
  `method_id` int(5) NOT NULL AUTO_INCREMENT,
  `method_name` varchar(100) NOT NULL,
  `availability` varchar(100) NOT NULL,
  PRIMARY KEY (`method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`method_id`, `method_name`, `availability`) VALUES
(1, 'Cash', 'Available'),
(2, 'Bank Deposit', 'Available'),
(3, 'Online Transfer', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `payment_status`
--

DROP TABLE IF EXISTS `payment_status`;
CREATE TABLE IF NOT EXISTS `payment_status` (
  `payment_status_id` int(5) NOT NULL AUTO_INCREMENT,
  `status_name` char(25) NOT NULL,
  PRIMARY KEY (`payment_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_status`
--

INSERT INTO `payment_status` (`payment_status_id`, `status_name`) VALUES
(1, 'Paid'),
(2, 'Verified'),
(3, 'Unsuccessful'),
(4, 'Successful'),
(5, 'Canceled'),
(6, 'Rejected'),
(7, 'Not Yet Paid');

-- --------------------------------------------------------

--
-- Table structure for table `policy`
--

DROP TABLE IF EXISTS `policy`;
CREATE TABLE IF NOT EXISTS `policy` (
  `policy_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `policy` text NOT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`policy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `policy`
--

INSERT INTO `policy` (`policy_id`, `category_id`, `policy`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(1, 1, 'Customer should pay a refundable deposit of Rs. 40000 securing the date and time for the event.', 1, '2023-07-11', NULL, NULL),
(2, 1, 'The balance should be paid 15 days prior to the event date.', 1, '2023-07-11', NULL, NULL),
(3, 1, 'There may be increases due to unforeseen changes in market conditions at the time of your event, which will be communicated in advance and will require customer confirmation to pay these additional cost on or before the event date.', 1, '2023-07-11', NULL, NULL),
(4, 1, 'Usage of the venue may be extended depending on the circumstances. Rs. 10000 will be charged for an additional hour. If the venue is already booked on the requested hours, extension may not be allowed.', 1, '2023-07-11', NULL, NULL),
(5, 2, 'Customer can cancel the reservation due to fortuitous reason.', 1, '2023-07-11', NULL, NULL),
(6, 2, 'If the cancellation made within 4 hours from the reservation placement time 100% of the payment will be refunded.', 1, '2023-07-11', NULL, NULL),
(7, 2, 'If the cancellation done after 4 hours from the reservation placement, security payment will not be refunded.', 1, '2023-07-11', NULL, NULL),
(8, 2, 'Once customer cancel the reservation he has to send a refund request to get the refund. refund will be proceed within 7 days from the date received the refund request.', 1, '2023-07-11', NULL, NULL),
(9, 3, 'The customer is responsible for any damages that is made on the reserved event at the venue.', 1, '2023-07-11', NULL, NULL),
(10, 3, 'For any and all damages to the hall that arise from or is related to the booked event the cost of damage shall be billed to the customer.', 1, '2023-07-11', NULL, NULL),
(11, 4, 'After placing a reservation customer cannot change the event details of the reservation except for the guest count.', 1, '2023-07-11', NULL, NULL),
(12, 4, 'Customer can only make changes to the reservation until 14 days prior to the event date.', 1, '2023-07-11', NULL, NULL),
(13, 4, 'Customer can only make a request for a change of the event details except for the guest count. If It did not get approved by the authorized person from the reception hall he would have to cancel the reservation and proceed to the refund process.', 1, '2023-07-11', NULL, NULL),
(14, 4, 'If a event details change request get approved by the reception hall customer can request for a transfer of a payments to the new reservation.', 1, '2023-07-11', NULL, NULL),
(15, 5, 'The Customer Shall comply with all applicable laws and regulations.', 1, '2023-08-03', NULL, NULL),
(16, 5, 'Customer shall not use or occupy the hall for any unlawful purpose.', 1, '2023-08-03', NULL, NULL),
(17, 5, 'All statutory permission will sole responsibility of customer, copy of such permission will have to presented in the management office before 3 days of the event.', 1, '2023-08-03', NULL, NULL),
(18, 1, 'The reservation confirmation will be depend on the security payment priority of the customers.', 1, '2023-08-03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `refund_pending_reason`
--

DROP TABLE IF EXISTS `refund_pending_reason`;
CREATE TABLE IF NOT EXISTS `refund_pending_reason` (
  `refund_pending_reason_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_request_id` int(11) NOT NULL,
  `pending_reason` varchar(255) NOT NULL,
  PRIMARY KEY (`refund_pending_reason_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `refund_pending_reason`
--

INSERT INTO `refund_pending_reason` (`refund_pending_reason_id`, `refund_request_id`, `pending_reason`) VALUES
(1, 2, 'Insufficient Fund');

-- --------------------------------------------------------

--
-- Table structure for table `refund_request`
--

DROP TABLE IF EXISTS `refund_request`;
CREATE TABLE IF NOT EXISTS `refund_request` (
  `refund_request_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_no` char(25) DEFAULT NULL,
  `reservation_no` char(25) NOT NULL,
  `customer_no` char(25) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `refundable_amount` decimal(10,2) NOT NULL,
  `refund_method_id` int(5) NOT NULL,
  `refund_status_id` int(11) NOT NULL,
  `requested_date` date NOT NULL,
  `requested_user` int(11) NOT NULL,
  `approved_date` date DEFAULT NULL,
  `approved_user` int(11) DEFAULT NULL,
  `issued_date` date DEFAULT NULL,
  `issued_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  `update_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`refund_request_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `refund_request`
--

INSERT INTO `refund_request` (`refund_request_id`, `refund_no`, `reservation_no`, `customer_no`, `paid_amount`, `refundable_amount`, `refund_method_id`, `refund_status_id`, `requested_date`, `requested_user`, `approved_date`, `approved_user`, `issued_date`, `issued_user`, `update_date`, `update_user`) VALUES
(1, '202308031', 'R2023072480', 'CUS2023070915', '247920.00', '247920.00', 1, 5, '2023-08-01', 18, '2023-08-01', 1, '2023-08-03', 1, NULL, NULL),
(2, NULL, 'R2023072481', 'CUS2023070915', '432610.00', '432610.00', 2, 4, '2023-08-02', 18, '2023-08-05', 21, NULL, NULL, '2023-08-02', 1),
(8, NULL, 'R2023072582', 'CUS2023070915', '539008.00', '499008.00', 1, 2, '2023-08-02', 18, NULL, NULL, NULL, NULL, '2023-08-02', 18),
(9, NULL, 'R2023080284', 'CUS2023073116', '40000.00', '40000.00', 2, 4, '2023-08-02', 25, '2024-05-27', 1, NULL, NULL, '2023-08-02', 25),
(10, NULL, 'R20230805103', 'CUS2023070915', '40000.00', '40000.00', 2, 4, '2023-08-05', 18, '2023-08-05', 21, NULL, NULL, NULL, NULL),
(11, '2024052811', 'R20240528117', 'CUS2024052827', '40000.00', '40000.00', 2, 5, '2024-05-28', 36, '2024-05-28', 21, '2024-05-28', 23, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `refund_status`
--

DROP TABLE IF EXISTS `refund_status`;
CREATE TABLE IF NOT EXISTS `refund_status` (
  `refund_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_status_name` varchar(25) NOT NULL,
  PRIMARY KEY (`refund_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `refund_status`
--

INSERT INTO `refund_status` (`refund_status_id`, `refund_status_name`) VALUES
(1, 'No Refund'),
(2, 'Requested'),
(3, 'Pending'),
(4, 'Approved'),
(5, 'Refunded');

-- --------------------------------------------------------

--
-- Table structure for table `reporttype`
--

DROP TABLE IF EXISTS `reporttype`;
CREATE TABLE IF NOT EXISTS `reporttype` (
  `ReportTypeId` int(11) NOT NULL,
  `ReportTypeName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reporttype`
--

INSERT INTO `reporttype` (`ReportTypeId`, `ReportTypeName`) VALUES
(1, 'Daily'),
(2, 'Weekly'),
(3, 'Monthly'),
(4, 'Annual');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_no` char(25) DEFAULT NULL,
  `customer_no` char(25) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `function_mode` varchar(25) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `guest_count` int(5) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `per_person_price` decimal(10,2) NOT NULL,
  `total_package_price` decimal(10,2) NOT NULL,
  `addon_item_price` decimal(10,2) NOT NULL,
  `addon_service_price` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL,
  `taxed_price` decimal(10,2) NOT NULL,
  `discount_rate` decimal(5,2) NOT NULL,
  `discounted_price` decimal(10,2) NOT NULL,
  `reservation_payment_status_id` int(5) NOT NULL,
  `remarks` text,
  `reservation_status_id` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `add_time` varchar(6) NOT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `reservation_no`, `customer_no`, `event_id`, `event_date`, `function_mode`, `start_time`, `end_time`, `guest_count`, `hall_id`, `package_id`, `per_person_price`, `total_package_price`, `addon_item_price`, `addon_service_price`, `total_amount`, `tax_rate`, `taxed_price`, `discount_rate`, `discounted_price`, `reservation_payment_status_id`, `remarks`, `reservation_status_id`, `add_date`, `add_time`, `update_date`) VALUES
(83, 'R2023080283', 'CUS2023073116', 1, '2023-08-16', 'Day', '08:00:00', '16:00:00', 100, 1, 1, '2065.00', '206500.00', '0.00', '0.00', '206500.00', '15.00', '237475.00', '0.00', '237475.00', 6, '', 2, '2023-08-02', '18:30', NULL),
(84, 'R2023080284', 'CUS2023073116', 1, '2023-08-16', 'Day', '08:00:00', '16:00:00', 100, 1, 2, '3616.00', '361600.00', '0.00', '0.00', '361600.00', '15.00', '415840.00', '0.00', '415840.00', 7, '', 4, '2023-08-02', '18:32', NULL),
(85, 'R2023080485', 'CUS2023080417', 1, '2023-08-18', 'Day', '08:00:00', '16:00:00', 100, 1, 7, '1928.00', '192800.00', '15246.00', '129400.00', '337446.00', '15.00', '388062.90', '0.00', '388062.90', 6, '', 2, '2023-08-04', '10:17', NULL),
(86, 'R2023080486', 'CUS2023080417', 2, '2023-08-18', 'Day', '08:00:00', '16:00:00', 100, 1, 9, '1645.00', '164500.00', '9075.00', '69200.00', '242775.00', '15.00', '279191.25', '0.00', '279191.25', 7, '', 4, '2023-08-04', '10:23', NULL),
(87, 'R2023080487', 'CUS2023080417', 1, '2023-08-18', 'Night', '18:00:00', '23:00:00', 100, 1, 8, '2554.00', '255400.00', '0.00', '242450.00', '497850.00', '15.00', '572527.50', '0.00', '572527.50', 6, '', 2, '2023-08-04', '10:57', NULL),
(88, 'R2023080488', 'CUS2023080419', 1, '2023-10-14', 'Day', '08:00:00', '16:00:00', 100, 1, 7, '1928.00', '192800.00', '13860.00', '160950.00', '367610.00', '15.00', '422751.50', '0.00', '422751.50', 6, '', 2, '2023-08-04', '16:10', NULL),
(89, 'R2023080489', 'CUS2023080419', 4, '2023-08-20', 'Evening', '20:00:00', '24:00:00', 100, 2, 13, '1621.00', '162100.00', '6930.00', '41350.00', '210380.00', '15.00', '241937.00', '0.00', '241937.00', 6, '', 2, '2023-08-04', '16:20', NULL),
(90, 'R2023080490', 'CUS2023080420', 1, '2023-09-22', 'Day', '08:00:00', '16:00:00', 100, 1, 7, '1928.00', '192800.00', '13860.00', '148400.00', '355060.00', '15.00', '408319.00', '0.00', '408319.00', 6, '', 2, '2023-08-04', '16:52', NULL),
(91, 'R2023080491', 'CUS2023080420', 12, '2023-09-23', 'None', '08:00:00', '24:00:00', 100, 1, 29, '2275.00', '227500.00', '13860.00', '16500.00', '257860.00', '15.00', '296539.00', '0.00', '296539.00', 6, '', 2, '2023-08-04', '16:58', NULL),
(92, 'R2023080492', 'CUS2023080421', 10, '2023-10-02', 'Day', '08:00:00', '12:00:00', 150, 1, 25, '1692.00', '253800.00', '0.00', '12000.00', '265800.00', '15.00', '305670.00', '0.00', '305670.00', 6, '', 2, '2023-08-04', '17:00', NULL),
(93, 'R2023080493', 'CUS2023080421', 8, '2023-10-28', 'Day', '08:00:00', '18:00:00', 100, 1, 22, '2360.00', '236000.00', '0.00', '0.00', '236000.00', '15.00', '271400.00', '0.00', '271400.00', 6, '', 2, '2023-08-04', '17:02', NULL),
(94, 'R2023080494', 'CUS2023080422', 3, '2023-10-12', 'Day', '08:00:00', '16:00:00', 100, 1, 11, '1633.00', '163300.00', '0.00', '100350.00', '263650.00', '15.00', '303197.50', '0.00', '303197.50', 6, '', 2, '2023-08-04', '17:05', NULL),
(95, 'R2023080495', 'CUS2023080422', 7, '2023-09-16', 'Day', '08:00:00', '16:00:00', 100, 2, 19, '1955.00', '195500.00', '0.00', '0.00', '195500.00', '15.00', '224825.00', '0.00', '224825.00', 6, '', 2, '2023-08-04', '17:06', NULL),
(96, 'R2023080496', 'CUS2023080423', 5, '2023-08-26', 'Night', '18:00:00', '23:00:00', 100, 2, 16, '2864.00', '286400.00', '0.00', '12850.00', '299250.00', '15.00', '344137.50', '0.00', '344137.50', 6, '', 2, '2023-08-04', '17:08', NULL),
(97, 'R2023080497', 'CUS2023080423', 12, '2023-12-14', 'None', '08:00:00', '24:00:00', 100, 2, 29, '2275.00', '227500.00', '0.00', '16500.00', '244000.00', '15.00', '280600.00', '0.00', '280600.00', 6, '', 2, '2023-08-04', '17:10', NULL),
(98, 'R2023080498', 'CUS2023080424', 10, '2023-08-27', 'Day', '08:00:00', '12:00:00', 100, 1, 25, '1692.00', '169200.00', '0.00', '12000.00', '181200.00', '15.00', '208380.00', '0.00', '208380.00', 1, '', 1, '2023-08-04', '17:12', NULL),
(99, 'R2023080499', 'CUS2023080424', 1, '2023-08-26', 'Night', '18:00:00', '23:00:00', 100, 2, 8, '2554.00', '255400.00', '0.00', '180700.00', '436100.00', '15.00', '501515.00', '0.00', '501515.00', 1, '', 1, '2023-08-04', '17:13', NULL),
(106, 'R20230805106', 'CUS2023080525', 1, '2023-08-24', 'Day', '08:00:00', '16:00:00', 120, 1, 8, '2554.00', '306480.00', '8470.00', '32500.00', '347450.00', '15.00', '399567.50', '0.00', '399567.50', 6, '', 2, '2023-08-05', '12:27', NULL),
(107, 'R20230805107', 'CUS2023080525', 1, '2023-08-19', 'Day', '08:00:00', '16:00:00', 100, 1, 7, '1928.00', '192800.00', '0.00', '0.00', '192800.00', '20.00', '231360.00', '0.00', '231360.00', 1, '', 1, '2023-08-05', '13:48', NULL),
(108, 'R20230805108', 'CUS2023080525', 2, '2023-08-26', 'Day', '09:00:00', '15:00:00', 100, 2, 9, '1645.00', '164500.00', '0.00', '186200.00', '350700.00', '25.00', '438375.00', '0.00', '438375.00', 1, '', 1, '2023-08-05', '13:52', NULL),
(109, 'R20230805109', 'CUS2023080525', 1, '2023-08-23', 'Day', '08:00:00', '16:00:00', 120, 1, 8, '2554.00', '306480.00', '0.00', '0.00', '306480.00', '20.00', '367776.00', '0.00', '367776.00', 1, '', 1, '2023-08-05', '13:54', NULL),
(110, 'R20230805110', 'CUS2023080525', 1, '2023-08-31', 'Day', '08:00:00', '16:00:00', 200, 1, 7, '1928.00', '385600.00', '0.00', '25850.00', '411450.00', '25.00', '514312.50', '0.00', '514312.50', 1, '', 1, '2023-08-05', '13:55', NULL),
(111, 'R20230805111', 'CUS2023080525', 1, '2023-08-29', 'Day', '08:00:00', '16:00:00', 120, 1, 7, '1928.00', '231360.00', '0.00', '23350.00', '254710.00', '20.00', '305652.00', '0.00', '305652.00', 1, '', 1, '2023-08-05', '13:57', NULL),
(112, 'R20240523112', 'CUS2024052326', 1, '2024-06-12', 'Night', '18:00:00', '23:00:00', 300, 1, 8, '2554.00', '766200.00', '277.20', '0.00', '766477.20', '25.00', '958096.50', '0.00', '958096.50', 1, '', 1, '2024-05-23', '17:41', NULL),
(113, 'R20240524113', 'CUS2024052326', 5, '2024-06-30', 'Night', '19:00:00', '24:00:00', 500, 2, 15, '2174.00', '1087000.00', '75075.00', '6250.00', '1168325.00', '25.00', '1460406.25', '0.00', '1460406.25', 1, '', 1, '2024-05-24', '10:57', NULL),
(114, 'R20240525114', 'CUS2024052326', 9, '2024-06-25', 'Day', '08:00:00', '16:00:00', 100, 1, 24, '2360.00', '236000.00', '57750.00', '0.00', '293750.00', '10.00', '323125.00', '0.00', '323125.00', 1, '', 1, '2024-05-25', '20:33', NULL),
(115, 'R20240528115', 'CUS2024052827', 1, '2024-06-18', 'Night', '18:00:00', '23:00:00', 150, 1, 7, '1928.00', '289200.00', '12705.00', '75000.00', '376905.00', '20.00', '452286.00', '0.00', '452286.00', 3, '', 2, '2024-05-28', '11:51', NULL),
(116, 'R20240528116', 'CUS2024052827', 2, '2024-07-04', 'Day', '10:00:00', '16:00:00', 100, 2, 10, '2289.00', '228900.00', '0.00', '0.00', '228900.00', '0.00', '228900.00', '0.00', '228900.00', 1, '', 3, '2024-05-28', '15:14', '2024-05-28'),
(117, 'R20240528117', 'CUS2024052827', 5, '2024-07-31', 'Night', '18:00:00', '23:00:00', 110, 1, 15, '2174.00', '239140.00', '0.00', '0.00', '239140.00', '0.00', '239140.00', '0.00', '239140.00', 4, '', 3, '2024-05-28', '16:01', '2024-05-28'),
(118, 'R20240528118', 'CUS2024052827', 4, '2024-07-14', 'Afternoon', '14:00:00', '18:00:00', 150, 1, 14, '2212.00', '331800.00', '0.00', '0.00', '331800.00', '10.00', '364980.00', '0.00', '364980.00', 2, '', 3, '2024-05-28', '16:55', '2024-05-28'),
(119, 'R20240528119', 'CUS2024052827', 3, '2024-06-28', 'Night', '19:00:00', '24:00:00', 100, 2, 11, '1633.00', '163300.00', '0.00', '0.00', '163300.00', '0.00', '163300.00', '0.00', '163300.00', 3, '', 2, '2024-05-28', '18:05', NULL),
(120, 'R20240528120', 'CUS2024052827', 1, '2024-06-25', 'Day', '08:00:00', '16:00:00', 120, 1, 7, '1928.00', '231360.00', '0.00', '0.00', '231360.00', '0.00', '231360.00', '0.00', '231360.00', 7, '', 4, '2024-05-28', '21:08', NULL),
(121, 'R20240528121', 'CUS2024052827', 2, '2024-06-25', 'Day', '09:00:00', '15:00:00', 100, 1, 9, '1645.00', '164500.00', '0.00', '0.00', '164500.00', '0.00', '164500.00', '0.00', '164500.00', 6, '', 2, '2024-05-28', '21:09', NULL),
(122, 'R20240529122', 'CUS2024052827', 4, '2024-06-25', 'Evening', '20:00:00', '24:00:00', 160, 2, 13, '1621.00', '259360.00', '0.00', '0.00', '259360.00', '10.00', '285296.00', '0.00', '285296.00', 1, '', 1, '2024-05-29', '16:02', NULL),
(123, 'R20240529123', 'CUS2024052827', 4, '2024-06-25', 'Evening', '20:00:00', '24:00:00', 160, 2, 13, '1621.00', '259360.00', '0.00', '0.00', '259360.00', '10.00', '285296.00', '0.00', '285296.00', 1, '', 1, '2024-05-29', '16:02', NULL),
(124, 'R20240529124', 'CUS2024052827', 4, '2024-06-25', 'Evening', '20:00:00', '24:00:00', 160, 2, 13, '1621.00', '259360.00', '0.00', '0.00', '259360.00', '10.00', '285296.00', '0.00', '285296.00', 1, '', 1, '2024-05-29', '16:03', NULL),
(125, 'R20240529125', 'CUS2024052827', 4, '2024-06-25', 'Evening', '20:00:00', '24:00:00', 160, 2, 13, '1621.00', '259360.00', '0.00', '0.00', '259360.00', '10.00', '285296.00', '0.00', '285296.00', 1, '', 1, '2024-05-29', '16:04', NULL),
(126, 'R20240529126', 'CUS2024052827', 4, '2024-06-25', 'Evening', '20:00:00', '24:00:00', 160, 2, 13, '1621.00', '259360.00', '0.00', '0.00', '259360.00', '10.00', '285296.00', '0.00', '285296.00', 1, '', 1, '2024-05-29', '16:04', NULL),
(127, 'R20240529127', 'CUS2024052827', 4, '2024-06-25', 'Evening', '20:00:00', '24:00:00', 160, 2, 13, '1621.00', '259360.00', '0.00', '0.00', '259360.00', '10.00', '285296.00', '0.00', '285296.00', 1, '', 1, '2024-05-29', '16:04', NULL),
(128, 'R20240612128', 'CUS2024052827', 3, '2024-06-26', 'Day', '08:00:00', '16:00:00', 150, 1, 11, '1633.00', '244950.00', '16940.00', '6250.00', '268140.00', '10.00', '294954.00', '0.00', '294954.00', 6, '', 3, '2024-06-12', '13:32', '2024-06-12'),
(129, 'R20240612129', 'CUS2024052827', 1, '2024-06-27', 'Day', '08:00:00', '15:00:00', 150, 1, 7, '1928.00', '289200.00', '0.00', '0.00', '289200.00', '10.00', '318120.00', '0.00', '318120.00', 6, '', 2, '2024-06-12', '13:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_addon_items`
--

DROP TABLE IF EXISTS `reservation_addon_items`;
CREATE TABLE IF NOT EXISTS `reservation_addon_items` (
  `reservation_addon_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `portion_price` decimal(10,2) NOT NULL,
  `portion_qty` int(11) NOT NULL,
  `total_portion_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`reservation_addon_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation_addon_items`
--

INSERT INTO `reservation_addon_items` (`reservation_addon_item_id`, `reservation_id`, `item_id`, `portion_price`, `portion_qty`, `total_portion_price`) VALUES
(56, 70, 3, '150.15', 100, '15015.00'),
(57, 70, 23, '181.50', 2, '363.00'),
(58, 70, 24, '115.50', 2, '231.00'),
(59, 70, 25, '72.60', 50, '3630.00'),
(60, 70, 40, '198.00', 100, '19800.00'),
(61, 71, 3, '150.15', 100, '15015.00'),
(62, 71, 23, '181.50', 2, '363.00'),
(63, 71, 24, '115.50', 2, '231.00'),
(64, 71, 25, '72.60', 50, '3630.00'),
(65, 71, 40, '198.00', 100, '19800.00'),
(66, 72, 3, '150.15', 100, '15015.00'),
(67, 72, 23, '181.50', 2, '363.00'),
(68, 74, 40, '198.00', 110, '21780.00'),
(69, 75, 40, '198.00', 21, '4158.00'),
(70, 78, 2, '138.60', 20, '2772.00'),
(71, 85, 10, '69.30', 20, '1386.00'),
(72, 85, 20, '138.60', 100, '13860.00'),
(73, 86, 23, '181.50', 10, '1815.00'),
(74, 86, 25, '72.60', 100, '7260.00'),
(75, 88, 1, '138.60', 100, '13860.00'),
(76, 89, 1, '138.60', 50, '6930.00'),
(77, 90, 1, '138.60', 100, '13860.00'),
(78, 91, 1, '138.60', 100, '13860.00'),
(79, 100, 1, '138.60', 20, '2772.00'),
(80, 101, 18, '169.40', 100, '16940.00'),
(81, 102, 22, '193.60', 20, '3872.00'),
(82, 102, 25, '72.60', 100, '7260.00'),
(83, 103, 19, '242.00', 99, '23958.00'),
(84, 103, 2, '138.60', 50, '6930.00'),
(85, 103, 15, '115.50', 40, '4620.00'),
(86, 104, 21, '173.25', 100, '17325.00'),
(87, 105, 1, '138.60', 20, '2772.00'),
(88, 106, 18, '169.40', 50, '8470.00'),
(89, 112, 1, '138.60', 2, '277.20'),
(90, 113, 3, '150.15', 500, '75075.00'),
(91, 115, 13, '127.05', 100, '12705.00'),
(92, 128, 18, '169.40', 100, '16940.00');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_addon_service`
--

DROP TABLE IF EXISTS `reservation_addon_service`;
CREATE TABLE IF NOT EXISTS `reservation_addon_service` (
  `reservation_addon_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`reservation_addon_service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation_addon_service`
--

INSERT INTO `reservation_addon_service` (`reservation_addon_service_id`, `reservation_id`, `service_id`, `service_price`) VALUES
(67, 70, 24, '110.00'),
(68, 70, 26, '9600.00'),
(69, 70, 25, '6600.00'),
(70, 70, 8, '31250.00'),
(71, 70, 18, '1650.00'),
(72, 70, 21, '1320.00'),
(73, 71, 24, '110.00'),
(74, 71, 26, '9600.00'),
(75, 71, 25, '6600.00'),
(76, 71, 8, '31250.00'),
(77, 71, 18, '1650.00'),
(78, 71, 21, '1320.00'),
(79, 72, 26, '9600.00'),
(80, 72, 25, '6600.00'),
(81, 72, 2, '15000.00'),
(82, 73, 2, '15000.00'),
(83, 73, 23, '75000.00'),
(84, 74, 24, '110.00'),
(85, 75, 24, '110.00'),
(86, 75, 2, '15000.00'),
(87, 76, 16, '25000.00'),
(88, 76, 24, '110.00'),
(89, 76, 13, '3750.00'),
(90, 78, 26, '9600.00'),
(91, 85, 8, '31250.00'),
(92, 85, 5, '3750.00'),
(93, 85, 32, '4400.00'),
(94, 85, 23, '75000.00'),
(95, 85, 2, '15000.00'),
(96, 86, 27, '18700.00'),
(97, 86, 32, '4400.00'),
(98, 86, 2, '15000.00'),
(99, 86, 31, '14300.00'),
(100, 86, 29, '16800.00'),
(101, 87, 14, '12500.00'),
(102, 87, 5, '3750.00'),
(103, 87, 25, '6600.00'),
(104, 87, 27, '18700.00'),
(105, 87, 32, '4400.00'),
(106, 87, 33, '16500.00'),
(107, 87, 8, '31250.00'),
(108, 87, 23, '75000.00'),
(109, 87, 3, '34800.00'),
(110, 87, 4, '12000.00'),
(111, 87, 17, '1100.00'),
(112, 87, 26, '9600.00'),
(113, 87, 15, '6250.00'),
(114, 87, 11, '10000.00'),
(115, 88, 11, '10000.00'),
(116, 88, 15, '6250.00'),
(117, 88, 23, '75000.00'),
(118, 88, 5, '3750.00'),
(119, 88, 8, '31250.00'),
(120, 88, 25, '6600.00'),
(121, 88, 2, '15000.00'),
(122, 88, 4, '12000.00'),
(123, 88, 17, '1100.00'),
(124, 89, 15, '6250.00'),
(125, 89, 28, '6900.00'),
(126, 89, 2, '15000.00'),
(127, 89, 30, '13200.00'),
(128, 90, 11, '10000.00'),
(129, 90, 15, '6250.00'),
(130, 90, 27, '18700.00'),
(131, 90, 5, '3750.00'),
(132, 90, 25, '6600.00'),
(133, 90, 2, '15000.00'),
(134, 90, 4, '12000.00'),
(135, 90, 17, '1100.00'),
(136, 90, 23, '75000.00'),
(137, 91, 33, '16500.00'),
(138, 92, 4, '12000.00'),
(139, 94, 15, '6250.00'),
(140, 94, 34, '49500.00'),
(141, 94, 33, '16500.00'),
(142, 94, 2, '15000.00'),
(143, 94, 4, '12000.00'),
(144, 94, 17, '1100.00'),
(145, 96, 15, '6250.00'),
(146, 96, 25, '6600.00'),
(147, 97, 33, '16500.00'),
(148, 98, 4, '12000.00'),
(149, 99, 11, '10000.00'),
(150, 99, 14, '12500.00'),
(151, 99, 15, '6250.00'),
(152, 99, 27, '18700.00'),
(153, 99, 5, '3750.00'),
(154, 99, 25, '6600.00'),
(155, 99, 3, '34800.00'),
(156, 99, 4, '12000.00'),
(157, 99, 17, '1100.00'),
(158, 99, 23, '75000.00'),
(159, 100, 15, '6250.00'),
(160, 100, 28, '6900.00'),
(161, 101, 11, '10000.00'),
(162, 101, 26, '9600.00'),
(163, 101, 15, '6250.00'),
(164, 102, 15, '6250.00'),
(165, 102, 27, '18700.00'),
(166, 102, 32, '4400.00'),
(167, 103, 26, '9600.00'),
(168, 103, 8, '31250.00'),
(169, 103, 5, '3750.00'),
(170, 103, 2, '15000.00'),
(171, 104, 14, '12500.00'),
(172, 104, 11, '10000.00'),
(173, 104, 25, '6600.00'),
(174, 104, 5, '3750.00'),
(175, 104, 32, '4400.00'),
(176, 104, 23, '75000.00'),
(177, 104, 33, '16500.00'),
(178, 104, 8, '31250.00'),
(179, 105, 26, '9600.00'),
(180, 105, 15, '6250.00'),
(181, 106, 11, '10000.00'),
(182, 106, 15, '6250.00'),
(183, 106, 14, '12500.00'),
(184, 106, 5, '3750.00'),
(185, 108, 26, '9600.00'),
(186, 108, 15, '6250.00'),
(187, 108, 29, '16800.00'),
(188, 108, 31, '14300.00'),
(189, 108, 25, '6600.00'),
(190, 108, 33, '16500.00'),
(191, 108, 27, '18700.00'),
(192, 108, 32, '4400.00'),
(193, 108, 8, '31250.00'),
(194, 108, 2, '15000.00'),
(195, 108, 3, '34800.00'),
(196, 108, 4, '12000.00'),
(197, 110, 11, '10000.00'),
(198, 110, 15, '6250.00'),
(199, 110, 26, '9600.00'),
(200, 111, 11, '10000.00'),
(201, 111, 26, '9600.00'),
(202, 111, 5, '3750.00'),
(203, 113, 15, '6250.00'),
(204, 115, 23, '75000.00'),
(205, 128, 15, '6250.00');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_payment_status`
--

DROP TABLE IF EXISTS `reservation_payment_status`;
CREATE TABLE IF NOT EXISTS `reservation_payment_status` (
  `payment_status_id` int(5) NOT NULL AUTO_INCREMENT,
  `payment_status` varchar(100) NOT NULL,
  PRIMARY KEY (`payment_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation_payment_status`
--

INSERT INTO `reservation_payment_status` (`payment_status_id`, `payment_status`) VALUES
(1, 'Pending'),
(2, 'Advanced'),
(3, 'Fully Paid'),
(4, 'Refunded'),
(5, 'Partially Refunded'),
(6, 'Secured'),
(7, 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_status`
--

DROP TABLE IF EXISTS `reservation_status`;
CREATE TABLE IF NOT EXISTS `reservation_status` (
  `reservation_status_id` int(5) NOT NULL AUTO_INCREMENT,
  `reservation_status` varchar(20) NOT NULL,
  PRIMARY KEY (`reservation_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation_status`
--

INSERT INTO `reservation_status` (`reservation_status_id`, `reservation_status`) VALUES
(1, 'Pending'),
(2, 'Confirmed'),
(3, 'Canceled'),
(4, 'Rejected'),
(5, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `sub_service_id` int(11) DEFAULT NULL,
  `service_type` varchar(25) NOT NULL,
  `addon_status` varchar(10) NOT NULL,
  `service_price` decimal(10,2) NOT NULL,
  `profit_ratio` decimal(5,2) NOT NULL,
  `final_price` decimal(10,2) NOT NULL,
  `availability` varchar(15) NOT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `category_id`, `service_name`, `sub_service_id`, `service_type`, `addon_status`, `service_price`, `profit_ratio`, `final_price`, `availability`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(1, 1, 'Hall Reservation', 14, 'inhouse', 'No', '20000.00', '25.00', '25000.00', 'Available', 3, '2023-07-03', 1, '2023-07-11'),
(2, 8, 'DJ Music', 14, 'outsource', 'Yes', '12000.00', '25.00', '15000.00', 'Available', 3, '2023-07-04', 1, '2023-07-11'),
(3, 8, 'Band Group', 14, 'outsource', 'Yes', '30000.00', '16.00', '34800.00', 'Available', 3, '2023-07-04', 1, '2023-07-11'),
(4, 8, 'Traditional Dancing Group', 14, 'outsource', 'Yes', '10000.00', '20.00', '12000.00', 'Available', 3, '2023-07-04', 1, '2023-07-11'),
(5, 4, 'Hall Decoration and Entrance Arch Decoration', 5, 'outsource', 'Yes', '3000.00', '25.00', '3750.00', 'Available', 3, '2023-07-04', 1, '2023-07-11'),
(7, 4, 'Themed Decorations', 6, 'inhouse', 'No', '20000.00', '25.00', '25000.00', 'Available', 3, '2023-07-04', 1, '2023-08-04'),
(8, 4, 'Fresh Flower Decorations', 7, 'outsource', 'Yes', '25000.00', '25.00', '31250.00', 'Available', 3, '2023-07-04', 1, '2023-08-03'),
(9, 2, 'Poruwa', 1, 'outsource', 'Yes', '2000.00', '25.00', '2500.00', 'Available', 3, '2023-07-04', 1, '2023-07-11'),
(10, 2, 'Ashtaka Group of 6', 14, 'outsource', 'Yes', '6000.00', '25.00', '7500.00', 'Available', 3, '2023-07-04', 1, '2023-07-11'),
(11, 2, 'Ashtaka Group of 8', 14, 'outsource', 'Yes', '8000.00', '25.00', '10000.00', 'Available', 3, '2023-07-04', 1, '2023-07-11'),
(12, 2, 'Jayamangala Gatha', 14, 'outsource', 'Yes', '3000.00', '25.00', '3750.00', 'Available', 3, '2023-07-04', 1, '2023-07-11'),
(13, 3, 'Milk Fountain', 14, 'outsource', 'Yes', '3000.00', '25.00', '3750.00', 'Available', 3, '2023-07-04', 1, '2023-07-11'),
(14, 3, 'Wedding Cake Structure', 2, 'outsource', 'Yes', '10000.00', '25.00', '12500.00', 'Available', 3, '2023-07-04', 1, '2023-08-02'),
(15, 3, 'Chocolate Fountain', 14, 'outsource', 'Yes', '5000.00', '25.00', '6250.00', 'Available', 3, '2023-07-04', 1, '2023-07-11'),
(17, 10, 'Oil Lamp', 14, 'outsource', 'Yes', '1000.00', '10.00', '1100.00', 'Available', 3, '2023-07-05', 1, '2023-07-11'),
(18, 10, 'Setteback', 14, 'outsource', 'Yes', '1500.00', '10.00', '1650.00', 'Available', 3, '2023-07-05', 1, '2023-07-11'),
(21, 5, 'Electricity for Photography', 14, 'inhouse', 'Yes', '1200.00', '10.00', '1320.00', 'Available', 3, '2023-07-05', 1, '2023-07-11'),
(22, 8, 'Dancing Floor', 14, 'inhouse', 'No', '500.00', '10.00', '550.00', 'Available', 3, '2023-07-05', 1, '2023-07-11'),
(23, 12, 'Wedding Photographer', 8, 'outsource', 'Yes', '60000.00', '25.00', '75000.00', 'Available', 3, '2023-07-05', 1, '2023-08-04'),
(24, 3, 'Ice Cubes', 14, 'inhouse', 'No', '100.00', '10.00', '110.00', 'Available', 3, '2023-07-05', 1, '2023-07-11'),
(25, 4, 'Ice Carving', 14, 'outsource', 'Yes', '6000.00', '10.00', '6600.00', 'Available', 1, '2023-07-10', 1, '2023-07-11'),
(26, 3, 'Champagne Fountain', 14, 'outsource', 'Yes', '8000.00', '20.00', '9600.00', 'Available', 1, '2023-07-11', NULL, NULL),
(27, 4, 'Artificial Flower Decorations', 7, 'outsource', 'Yes', '17000.00', '10.00', '18700.00', 'Available', 1, '2023-08-02', NULL, NULL),
(28, 3, 'Birthday Cake Structure', 3, 'outsource', 'Yes', '6000.00', '15.00', '6900.00', 'Available', 1, '2023-08-02', NULL, NULL),
(29, 12, 'Event Photographer', 14, 'outsource', 'Yes', '15000.00', '12.00', '16800.00', 'Available', 1, '2023-08-02', 1, '2023-08-04'),
(30, 12, 'Birthday Photographer', 9, 'outsource', 'Yes', '12000.00', '10.00', '13200.00', 'Available', 1, '2023-08-02', NULL, NULL),
(31, 3, 'Homecoming Cake Structure', 4, 'outsource', 'Yes', '13000.00', '10.00', '14300.00', 'Available', 1, '2023-08-03', 1, '2023-08-04'),
(32, 4, 'Baloon Decoration', 11, 'outsource', 'Yes', '4000.00', '10.00', '4400.00', 'Available', 1, '2023-08-03', NULL, NULL),
(33, 4, 'Candle Decorations', 12, 'outsource', 'Yes', '15000.00', '10.00', '16500.00', 'Available', 1, '2023-08-03', NULL, NULL),
(34, 12, 'Engagement Photographer', 10, 'outsource', 'Yes', '45000.00', '10.00', '49500.00', 'Available', 1, '2023-08-03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_category`
--

DROP TABLE IF EXISTS `service_category`;
CREATE TABLE IF NOT EXISTS `service_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `description` text,
  `availability` varchar(15) NOT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_category`
--

INSERT INTO `service_category` (`category_id`, `category_name`, `description`, `availability`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(1, 'Venue Rental', 'Welcome to our reception hall\'s venue rental service. Explore our stunning customizable spaces and seamless event coordination for unforgettable memories. Your perfect event awaits!', 'Available', 3, '2023-07-03', 3, '2023-07-03'),
(2, 'Event Planning', 'Welcome to our Event Planning service category. Let us turn your vision into a stress-free reality, creating unforgettable memories in our beautiful reception hall. Welcome to a seamless and personalized experience!', 'Available', 3, '2023-07-03', 3, '2023-07-05'),
(3, 'Catering', 'Indulge in culinary excellence at our reception hall\'s Catering service. From exquisite dishes to impeccable service, savor a memorable dining experience that elevates your event. Welcome to a world of flavors!', 'Available', 3, '2023-07-03', 3, '2023-07-03'),
(4, 'Decor and Design', 'Unleash creativity with our Decor and Design service. Watch your vision come to life as we transform our reception hall into an enchanting space, tailored uniquely to you. Welcome to a world of elegance and imagination', 'Available', 3, '2023-07-03', 3, '2023-07-03'),
(5, 'Audiovisual and Technology', 'Experience innovation at its finest with our Audiovisual and Technology service. Our cutting-edge equipment and skilled technicians ensure flawless execution, creating unforgettable moments in our reception hall. Welcome to the future of event experiences!', 'Available', 3, '2023-07-03', 3, '2023-07-03'),
(6, 'Parking and Transportation', 'Enjoy convenience and peace of mind with our Parking and Transportation service. Our reception hall offers secure parking and professional transportation, ensuring a stress-free event for you and your guests. Welcome to a seamless experience!', 'Unavailable', 3, '2023-07-03', 3, '2023-07-05'),
(7, 'Staffing and Service', 'Experience seamless hospitality with our Staffing and Service. Our attentive and professional team ensures every detail is taken care of, allowing you to savor every moment of your event. Welcome to an exceptional experience at our reception hall!', 'Unavailable', 3, '2023-07-03', 3, '2023-07-05'),
(8, 'Entertainment and Music', 'Experience enchanting entertainment with our Music service. From live bands to talented DJs, our reception hall sets the stage for an unforgettable event. Welcome to a world of rhythm and joy!', 'Available', 3, '2023-07-03', NULL, NULL),
(9, 'Event Coordination', 'Experience seamless planning with our Event Coordination service. Our dedicated team ensures every detail is meticulously crafted for a stress-free and unforgettable event at our reception hall. Welcome to a world of flawless execution!', 'Unavailable', 3, '2023-07-03', 3, '2023-07-05'),
(10, 'Amenities', 'Indulge in comfort and convenience with our Amenities service. Our reception hall offers thoughtful facilities, ensuring an exceptional event experience. Welcome to a world of convenience and sophistication!', 'Available', 3, '2023-07-05', NULL, NULL),
(11, 'Other', NULL, 'Unavailable', 3, '2023-07-05', 3, '2023-07-05'),
(12, 'Photography', 'Capture timeless memories with our Photography service. Our reception hall\'s professional photographers preserve every moment of your special occasion, ensuring cherished memories for a lifetime. Welcome to a world of unforgettable snapshots!', 'Available', 3, '2023-07-05', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_samples`
--

DROP TABLE IF EXISTS `service_samples`;
CREATE TABLE IF NOT EXISTS `service_samples` (
  `service_sample_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_service_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `sample_name` varchar(100) NOT NULL,
  `sample_image` varchar(255) NOT NULL,
  `availability` varchar(25) NOT NULL,
  PRIMARY KEY (`service_sample_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_samples`
--

INSERT INTO `service_samples` (`service_sample_id`, `sub_service_id`, `service_id`, `sample_name`, `sample_image`, `availability`) VALUES
(1, 1, 9, 'Sample 1', '64cbdca4e59be.jpeg', 'Available'),
(2, 1, 9, 'Sample 2', '64cbdcba00d91.jpeg', 'Available'),
(3, 1, 9, 'Sample 3', '64cbdcce84d7e.jpeg', 'Available'),
(4, 2, 14, 'Sample 1', '64cbdced977df.jpeg', 'Available'),
(5, 2, 14, 'Sample 2', '64cbdd0289cb8.jpeg', 'Available'),
(6, 2, 14, 'Sample 3', '64cbdd142f586.jpeg', 'Available'),
(7, 3, 28, 'Sample 1', '64cbdd2b7b404.jpeg', 'Available'),
(8, 3, 28, 'Sample 2', '64cbdd3de5fe0.jpeg', 'Available'),
(9, 3, 28, 'Sample 3', '64cbdd4e01a42.jpeg', 'Available'),
(10, 4, 31, 'Sample 1', '64cbdd6fc3aa3.jpeg', 'Available'),
(11, 5, 5, 'Sample 1', '64cbdd9708e1e.jpeg', 'Available'),
(12, 7, 8, 'Sample 1', '64cbddd5d28de.jpeg', 'Available'),
(13, 7, 8, 'Sample 2', '64cbe43cd94fa.jpeg', 'Available'),
(14, 7, 8, 'Sample 3', '64cbe4563d879.jpeg', 'Available'),
(15, 8, 23, 'Sample 1', '64cbe47214eb4.png', 'Available'),
(16, 8, 23, 'Sample 2', '64cbe48836830.png', 'Available'),
(17, 8, 23, 'Sample 3', '64cbe4a5d2dc8.png', 'Available'),
(18, 9, 30, 'Sample 1', '64cbe4bc95369.png', 'Available'),
(19, 9, 30, 'Sample 2', '64cbe4d10d4dd.png', 'Available'),
(20, 10, 34, 'Sample 1', '64cbe4e71b944.png', 'Available'),
(21, 11, 32, 'Sample 1', '64cbe4ff91967.jpeg', 'Available'),
(22, 11, 32, 'Sample 2', '64cbe514a1364.jpeg', 'Available'),
(23, 11, 32, 'Sample 3', '64cbe52dd74ad.jpeg', 'Available'),
(24, 6, 7, 'Red and Black', '64cc8655bd681.jpg', 'Available'),
(25, 6, 7, 'Blue and White', '64cc867944ec2.jpg', 'Available'),
(26, 6, 7, 'Yellow and Black', '64cc8693618a7.jpeg', 'Available'),
(27, 6, 7, 'Yellow and White', '64cc86aeea6aa.jpg', 'Available'),
(28, 7, 27, 'Sample 1', '64cc97fe0cb1a.jpeg', 'Available'),
(29, 7, 27, 'Sample 2', '64cc98115c0f8.jpeg', 'Available'),
(30, 7, 27, 'Sample 3', '64cc9827a1b4a.jpeg', 'Available'),
(31, 4, 31, 'Sample 2', '64cd21afa684d.jpg', 'Available'),
(32, 4, 31, 'Sample 3', '64cd220452f16.jpg', 'Available'),
(33, 5, 5, 'Sample 2', '64cd226325585.jpg', 'Available'),
(34, 5, 5, 'Sample 3', '64cd22a26d10c.jpg', 'Available'),
(35, 10, 34, 'Package 2', '64cd251f0a5f4.png', 'Available'),
(36, 10, 34, 'Sample 3', '64cd25564c781.png', 'Available'),
(37, 12, 33, 'Sample 1', '64cd25faafcc7.jpeg', 'Available'),
(38, 12, 33, 'Sample 2', '64cd2661ebf77.jpg', 'Available'),
(39, 12, 33, 'Sample 3', '64cd26ae12cbe.jpg', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `sub_service`
--

DROP TABLE IF EXISTS `sub_service`;
CREATE TABLE IF NOT EXISTS `sub_service` (
  `sub_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_service_name` varchar(255) NOT NULL,
  PRIMARY KEY (`sub_service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_service`
--

INSERT INTO `sub_service` (`sub_service_id`, `sub_service_name`) VALUES
(1, 'Poruwa'),
(2, 'Wedding Cake'),
(3, 'Birthday Cake'),
(4, 'Homecoming Cake'),
(5, 'Hall Decorations with Entrance Arch'),
(6, 'Themed Decorations'),
(7, 'Floral Decorations'),
(8, 'Wedding Photography'),
(9, 'Birthday Photography'),
(10, 'Engagement Photography'),
(11, 'Balloon Decorations'),
(12, 'Candle Decorations'),
(13, 'Light Decorations'),
(14, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_no` char(25) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `no` varchar(100) NOT NULL,
  `street_name` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `district_id` int(11) NOT NULL,
  `contact_number` char(10) NOT NULL,
  `alternate_number` char(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nic` char(12) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_reg_no` varchar(100) NOT NULL,
  `agreement_start_date` date NOT NULL,
  `agreement_end_date` date NOT NULL,
  `agreement_status_id` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `add_user` int(11) NOT NULL,
  `update_date` date DEFAULT NULL,
  `update_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_no`, `title`, `first_name`, `middle_name`, `last_name`, `no`, `street_name`, `city`, `district_id`, `contact_number`, `alternate_number`, `email`, `nic`, `company_name`, `company_reg_no`, `agreement_start_date`, `agreement_end_date`, `agreement_status_id`, `add_date`, `add_user`, `update_date`, `update_user`) VALUES
(4, 'SUP202308024', 'Mr', 'Amal', 'Sanjaya', 'Ratnayake', '12', '2nd Lane', 'Narahenpita', 5, '0773591273', '', 'amal@gmail.com', '843456121V', 'Amal Sounds', 'R181054', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(5, 'SUP202308025', 'Mr', 'Mithun', 'Sanjaya', 'Senevirathna', '12', '1st Lane', 'Kolonnawa', 5, '0773591279', '', 'kamal@gmail.com', '843456321V', 'DJ Mithun', 'R5656421', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(6, 'SUP202308026', 'Mr', 'Dimuthu', 'Harshana', 'Perera', '100/12', 'Kandy Road', 'Peliyagoda', 7, '0715238452', '', 'dimuthuharshana@gmail.com', '952357421V', 'Dimuthu Harshana Photography', 'R8896324', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(7, 'SUP202308027', 'Mr', 'Dilshan', '', 'Perera', '125/18', 'Kandy Road', 'Kelaniya', 7, '0715236981', '', 'asiacatering@gmail.com', '930592374V', 'Asiri Catering', 'R8952141', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(8, 'SUP202308028', 'Mr', 'Sarath', '', 'Perera', '150', 'Dutugemunu Mawatha', 'Peliyagoda', 7, '0718952110', '', 'galaxies@gmail.com', '882502387V', 'Galaxies Band', 'R8956231', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(9, 'SUP202308029', 'Mr', 'Kamal', '', 'Gunarathne', '189', 'Kandy Road', 'Dalugama', 7, '0785123471', '', 'siyanaweabishekamandapaya@gmail.com', '935623147V', 'Siyanawe Abisheka Mandapaya', 'R5625641', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(10, 'SUP2023080210', 'Mrs', 'Champi', '', 'Senevirathna', '185/10', 'Baseline Road', 'Dematagoda', 5, '0718952124', '', 'chamathkaraflora@gmail.com', '887445543V', 'Chamathkara Flora', 'BR1563128', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(11, 'SUP2023080211', 'Mrs', 'Dulmini', '', 'Dilhara', '789', 'Baseline Road', 'Borella', 5, '0741257815', '', 'pearlflowecake@gmail.com', '754523147V', 'Pearl Flower Cake', 'BR798745', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(12, 'SUP2023080212', 'Mr', 'Samith', '', 'Thennakoon', '253', 'Gonawala Road', 'Kelaniya', 7, '0781236498', '', 'rajabishekamandapaya@gmail.com', '745123694V', 'Rajabisheka Mandapaya', 'BR563258', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(13, 'SUP2023080213', 'Mr', 'Aruna', '', 'Udana', '150', 'Baseline Road', 'Dematagoda', 5, '0745123661', '', 'arunadesign@gmail.com', '895124321V', 'Aruna Design', 'BR125321', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(14, 'SUP2023080214', 'Mr', 'Eranda', '', 'Harshana', '285', 'Kandy Road', 'Kadawatha', 7, '0785124111', '', 'silverstar@gmail.com', '948366123V', 'Silver Star Audio Visual &amp; Event Planner', 'BR86565', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(15, 'SUP2023080215', 'Mr', 'Sakmal', '', 'Subsinghe', '56', 'Kandy Road', 'Mahara', 7, '0741335912', '', 'sakmaldeco@gmail.com', '914521325V', 'Sakmal Decorations', 'BR526321', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, '2023-08-04', 1),
(16, 'SUP2023080216', 'Mr', 'Srimal', '', 'Dilanga', '105', 'Baseline Road', 'Borella', 5, '0741253153', '', 'srimafood@gmail.com', '947512538V', 'Srima Food &amp; Catering Service', 'BR265251', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(17, 'SUP2023080217', 'Mr', 'Vishwa', '', 'Perera', '103', 'Baseline Road', 'Borella', 5, '0781313213', '', 'vishviweddings@gmail.com', '965232144V', 'Vishvi Weddings Ashtaka', 'BR11651', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(18, 'SUP2023080218', 'Mr', 'Buddika', '', 'Jayawardhana', '104', 'Kandy Road', 'Dalugama', 7, '0741616546', '', 'shinephoto@gmail.com', '965565151V', 'Shine Wedding Photography', 'BR114523', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL),
(19, 'SUP2023080219', 'Mr', 'Aravin', '', 'Perera', '45', 'Baseline Road', 'Borella', 5, '0744363521', '', 'Dearts@gmail.com', '965466321V', 'De ARTS Events Pvt Ltd', 'BR512151', '2024-01-01', '2024-12-31', 1, '2023-08-02', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_assignment_status`
--

DROP TABLE IF EXISTS `supplier_assignment_status`;
CREATE TABLE IF NOT EXISTS `supplier_assignment_status` (
  `assignment_id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_status` varchar(100) NOT NULL,
  PRIMARY KEY (`assignment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier_assignment_status`
--

INSERT INTO `supplier_assignment_status` (`assignment_id`, `assignment_status`) VALUES
(1, 'Assigned'),
(2, 'Confirmed'),
(3, 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_service`
--

DROP TABLE IF EXISTS `supplier_service`;
CREATE TABLE IF NOT EXISTS `supplier_service` (
  `supplier_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`supplier_service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier_service`
--

INSERT INTO `supplier_service` (`supplier_service_id`, `supplier_id`, `service_id`) VALUES
(1, 4, 2),
(2, 4, 3),
(3, 5, 2),
(4, 6, 23),
(5, 7, 15),
(6, 7, 27),
(7, 8, 3),
(8, 9, 4),
(9, 9, 10),
(10, 9, 11),
(11, 9, 12),
(12, 0, 5),
(13, 0, 6),
(14, 0, 7),
(15, 0, 8),
(16, 0, 5),
(17, 0, 6),
(18, 0, 7),
(19, 0, 8),
(20, 10, 5),
(21, 10, 6),
(22, 10, 7),
(23, 10, 8),
(24, 11, 14),
(25, 12, 9),
(26, 12, 17),
(27, 12, 18),
(28, 13, 13),
(29, 13, 25),
(30, 13, 26),
(31, 14, 2),
(32, 14, 3),
(33, 14, 4),
(34, 14, 16),
(44, 16, 15),
(45, 16, 27),
(46, 17, 4),
(47, 17, 9),
(48, 17, 10),
(49, 17, 11),
(50, 17, 12),
(51, 17, 13),
(52, 17, 17),
(53, 17, 26),
(54, 18, 23),
(55, 19, 16),
(56, 15, 5),
(57, 15, 8),
(58, 15, 9),
(59, 15, 13),
(60, 15, 17),
(61, 15, 18),
(62, 15, 26),
(63, 15, 32),
(64, 15, 33);

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

DROP TABLE IF EXISTS `tax`;
CREATE TABLE IF NOT EXISTS `tax` (
  `tax_id` int(2) NOT NULL AUTO_INCREMENT,
  `tax_rate` decimal(5,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `add_user` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`tax_id`, `tax_rate`, `amount`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(1, '10.00', '250000.00', 1, '2023-05-06', 23, '2023-08-05'),
(2, '20.00', '370000.00', 23, '2023-08-05', 23, '2023-08-05'),
(3, '25.00', '500000.00', 23, '2023-08-05', 23, '2023-08-05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menuitem`
--

DROP TABLE IF EXISTS `tbl_menuitem`;
CREATE TABLE IF NOT EXISTS `tbl_menuitem` (
  `MenuItemId` int(11) NOT NULL,
  `MenuItemCategoryId` int(11) NOT NULL,
  `MenuItemName` varchar(100) NOT NULL,
  `MenuItemCost` decimal(10,0) NOT NULL,
  `ProfitRatio` decimal(10,0) NOT NULL,
  `PortionPrice` decimal(10,2) NOT NULL,
  `MenuItemImage` varchar(255) NOT NULL,
  `MenuItemStatus` varchar(25) NOT NULL,
  `AddUser` int(11) NOT NULL,
  `AddDate` date NOT NULL,
  `UpdateUser` int(11) DEFAULT NULL,
  `UpdateDate` date DEFAULT NULL,
  PRIMARY KEY (`MenuItemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_menuitem`
--

INSERT INTO `tbl_menuitem` (`MenuItemId`, `MenuItemCategoryId`, `MenuItemName`, `MenuItemCost`, `ProfitRatio`, `PortionPrice`, `MenuItemImage`, `MenuItemStatus`, `AddUser`, `AddDate`, `UpdateUser`, `UpdateDate`) VALUES
(1, 2, 'Tempered Dhal', '100', '100', '110.00', '645e13cce04149.77489735.jpg', 'Available', 1, '2023-04-10', 57, '2023-06-29'),
(2, 2, 'Potato White Curry', '100', '20', '120.00', '645e14592d2bf4.17665550.jpg', 'Available', 1, '2023-04-10', 57, '2023-05-12'),
(3, 6, 'Male Pickle', '50', '20', '60.00', '645e15095e4336.80457068.jpg', 'Available', 1, '2023-04-10', 57, '2023-05-12'),
(4, 4, 'Biscuit Pudding', '50', '20', '60.00', '645e177ab7e521.99314526.jpg', 'Available', 1, '2023-04-10', 57, '2023-05-12'),
(5, 4, 'Vatalappan', '100', '20', '120.00', '645e1c6c1b0e71.61070002.jpeg', 'Available', 1, '2023-04-09', 57, '2023-05-12'),
(6, 2, 'Cashew and Green Piece Curry', '100', '20', '120.00', '645e1cc2787bb3.90755554.jpeg', 'Available', 1, '2023-04-10', 57, '2023-05-12'),
(7, 1, 'Chicken Hawai Salad', '50', '20', '60.00', '645e1c139d97e3.44535463.jpeg', 'Available', 1, '2023-04-08', 57, '2023-05-12'),
(8, 4, 'Jelly with Custard Cream', '50', '20', '60.00', '645e1723174d90.56962039.jpg', 'Available', 1, '2023-04-10', 57, '2023-05-12'),
(9, 4, 'Fresh Cut Fruit', '50', '20', '60.00', '645e16dd9673a5.69628989.jpeg', 'Available', 1, '2023-04-09', 57, '2023-05-12'),
(10, 4, 'Chocolate Ice Cream', '50', '10', '55.00', '6432430f16a2a9.37488056.jpg', 'Available', 1, '2023-04-09', NULL, NULL),
(11, 4, 'Vanila Ice Cream', '100', '20', '120.00', '645e1823d3ad87.83001896.jpeg', 'Available', 1, '2023-04-14', 57, '2023-05-12'),
(12, 4, 'Biscuit Pudding', '50', '10', '55.00', '6455bc68d63781.83103290.jpg', 'Available', 57, '2023-05-06', NULL, NULL),
(13, 2, 'Yellow Rice', '100', '10', '110.00', '6456976b531fb2.98315754.jpg', 'Available', 57, '2023-05-06', NULL, NULL),
(14, 1, 'Mixed Salad', '50', '20', '60.00', '645e07cb5f3076.50383032.jpeg', 'Available', 57, '2023-05-12', NULL, NULL),
(15, 1, 'Pine Apple and Green Chili Salad', '50', '20', '60.00', '645e08597f1d11.14999290.jpg', 'Available', 57, '2023-05-12', NULL, NULL),
(16, 1, 'Macaroni Salad with Mayonnaise', '50', '20', '60.00', '645e0bb53efa83.17061893.jpg', 'Available', 57, '2023-05-12', NULL, NULL),
(17, 1, 'Lettuce and Onion Salad', '50', '20', '60.00', '645e0c1a9cea50.05690899.jpg', 'Available', 57, '2023-05-12', NULL, NULL),
(18, 2, 'Nectar Mount Resort Special Rice', '100', '20', '120.00', '645e0c97616a70.73984350.jpg', 'Available', 57, '2023-05-12', NULL, NULL),
(19, 2, 'Steam White Rice', '50', '20', '60.00', '645e106f99bee2.28938891.jpg', 'Available', 57, '2023-05-12', NULL, NULL),
(20, 2, 'Chicken Black Curry', '100', '50', '150.00', '645e10f27f88a2.39503034.jpeg', 'Available', 57, '2023-05-12', NULL, NULL),
(21, 2, 'Devilled Fish', '50', '20', '60.00', '645e114c9b16e0.20190392.jpeg', 'Available', 57, '2023-05-12', NULL, NULL),
(22, 2, 'Fish Red Curry', '50', '20', '60.00', '645e11c08a1a86.71347708.jpg', 'Available', 57, '2023-05-12', NULL, NULL),
(23, 2, 'Brinjal Moju', '50', '20', '60.00', '645e124fedf988.98359022.jpg', 'Available', 57, '2023-05-12', NULL, NULL),
(24, 2, 'Tempered Potato', '50', '20', '60.00', '645e13b7611a16.84655288.jpg', 'Available', 57, '2023-05-12', NULL, NULL),
(25, 6, 'Maldives Fish Sambal', '50', '20', '60.00', '645e1570e42621.62421488.jpg', 'Available', 57, '2023-05-12', NULL, NULL),
(26, 6, 'Mini Prawns Sambal', '50', '20', '60.00', '645e15c77e8a45.90699609.jpg', 'Available', 57, '2023-05-12', NULL, NULL),
(27, 6, 'Papadam', '50', '20', '60.00', '645e1610dc1cc5.48790389.jpeg', 'Available', 57, '2023-05-12', NULL, NULL),
(28, 6, 'Cutlet', '50', '20', '60.00', '645e1662da79b0.52890914.jpeg', 'Available', 57, '2023-05-12', NULL, NULL),
(29, 1, 'Coleslaw Salad', '50', '10', '55.00', '649d72272d6a43.03589297.jpg', 'Available', 57, '2023-06-29', NULL, NULL),
(30, 1, 'Pasta Sea Food Salad', '50', '10', '55.00', '649d7281ac1d79.11114769.jpg', 'Available', 57, '2023-06-29', NULL, NULL),
(31, 1, 'Beet Root with Egg Salad', '50', '10', '55.00', '649d72f1c369e2.40638871.jpg', 'Available', 57, '2023-06-29', NULL, NULL),
(32, 1, 'Tomato, Pine Apple and Cucumber Rings', '50', '10', '55.00', '649d73addb0834.81824983.jpg', 'Available', 57, '2023-06-29', NULL, NULL),
(33, 2, 'Nectar Mount Resort Special Mongolian Rice', '100', '20', '120.00', '649d743e08e935.59512888.jpg', 'Available', 57, '2023-06-29', NULL, NULL),
(34, 2, 'Chili Chicken with Cashew Nuts', '100', '20', '120.00', '649d75395ca365.71859579.jpg', 'Available', 57, '2023-06-29', NULL, NULL),
(35, 2, 'Aloogobi', '100', '20', '120.00', '649d7597a83375.25561747.jpg', 'Available', 57, '2023-06-29', NULL, NULL),
(36, 2, 'Seasonal Fresh Boiled Vegetable', '100', '20', '120.00', '649d76499953e6.59462516.jpg', 'Available', 57, '2023-06-29', NULL, NULL),
(37, 1, 'Pasta Salad', '50', '10', '55.00', '649d777fe24f49.08241983.jpeg', 'Available', 57, '2023-06-29', NULL, NULL),
(38, 1, 'Tomato, Onion and Cucumber Rings', '50', '10', '55.00', '649d7844da6275.63644482.jpeg', 'Available', 57, '2023-06-29', NULL, NULL),
(39, 1, 'Lettuce and Croutons Salad', '50', '20', '60.00', '649d78bb53ce79.48437999.jpg', 'Available', 57, '2023-06-29', NULL, NULL),
(40, 2, 'Vegetable Noodles', '50', '20', '60.00', '649d7c6156e107.58947932.jpeg', 'Available', 57, '2023-06-29', NULL, NULL),
(41, 2, 'Chicken Drumsticks with BBQ Sauce', '200', '20', '240.00', '649d7d42deacf4.23140295.jpg', 'Available', 57, '2023-06-29', NULL, NULL),
(42, 2, 'Vegetable Lasonya', '100', '50', '150.00', '649d7dbc189a39.41612212.jpeg', 'Available', 57, '2023-06-29', NULL, NULL),
(43, 2, 'Chili Gobi', '100', '50', '150.00', '649d7e48329c91.14338922.jpg', 'Available', 57, '2023-06-29', NULL, NULL),
(44, 6, 'Dry Chili', '100', '20', '120.00', '649d80c094c9b4.06995051.jpeg', 'Available', 57, '2023-06-29', 57, '2023-06-29'),
(45, 4, 'Chocolate Moose', '100', '50', '150.00', '649d7ef102c2a1.57015498.jpg', 'Available', 57, '2023-06-29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_year`
--

DROP TABLE IF EXISTS `tbl_year`;
CREATE TABLE IF NOT EXISTS `tbl_year` (
  `YearId` int(11) NOT NULL,
  `Year` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_year`
--

INSERT INTO `tbl_year` (`YearId`, `Year`) VALUES
(1, '2022'),
(2, '2023');

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

DROP TABLE IF EXISTS `theme`;
CREATE TABLE IF NOT EXISTS `theme` (
  `theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(100) NOT NULL,
  `sample_image` varchar(255) NOT NULL,
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`theme_id`, `theme_name`, `sample_image`) VALUES
(1, 'Red/Black', 'redandblack.jpg'),
(2, 'Blue/White', 'blueandwhite.jpg'),
(3, 'Yellow/Black', 'yellowandblack.jpeg'),
(4, 'Yellow/White', 'yellowandwhite.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `user_status` varchar(15) NOT NULL,
  `add_user` int(11) NOT NULL DEFAULT '0',
  `add_date` date NOT NULL,
  `update_user` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `user_role_id`, `user_status`, `add_user`, `add_date`, `update_user`, `update_date`) VALUES
(1, 'admin', '23d42f5f3f66498b2c8ff4c20b8c5ac826e47146', 1, 'Active', 1, '2023-01-01', NULL, NULL),
(25, 'gayan', '221dce273998f3f73c494256271f836e6415db3d', 7, 'Active', 25, '2023-07-31', NULL, NULL),
(26, 'manuda', 'f65243699cad6e4013ee90a7c31f01ffdad0b4ef', 7, 'Active', 26, '2023-08-04', NULL, NULL),
(27, 'theshala', '44805f765f839a5abe46d73402c6f0564fbc1dfb', 7, 'Active', 27, '2023-08-04', NULL, NULL),
(28, 'Seyan', '7fe9b8e722f1f2cf609a90c0193fbc4d403e3258', 7, 'Active', 28, '2023-08-04', NULL, NULL),
(29, 'Upeksha', 'b8fbd8ad428f7aedca63e718779ced82b515baaf', 7, 'Active', 29, '2023-08-04', NULL, NULL),
(30, 'Dulan', 'd4931bf4abd5f06a57651e17a0130a29346a7a95', 7, 'Active', 30, '2023-08-04', NULL, NULL),
(31, 'Rusiru', '9ce61f2dca27f0d0019991527e139589653ce962', 7, 'Active', 31, '2023-08-04', NULL, NULL),
(32, 'Aruni', '51a938e78f9779cd8b90c05aecbc39bb51e18fb4', 7, 'Active', 32, '2023-08-04', NULL, NULL),
(33, 'Isuru', '1e916b890c28d2b368a7bf10ec5b409c891db53f', 7, 'Active', 33, '2023-08-04', NULL, NULL),
(34, 'ucsc', '6f57c7897e5ddd524b723b0523ffa6dee7e98b28', 7, 'Active', 34, '2023-08-05', NULL, NULL),
(35, 'amal', 'cd9fe3342152b2f2a8f0f386bcacb4a877a55774', 7, 'Active', 35, '2024-05-23', NULL, NULL),
(36, 'Niroshan', 'ddac418a1be76098d01107464026f65d2a3192bf', 7, 'Active', 36, '2024-05-28', NULL, NULL),
(41, 'bnpm00@gmail.com', '8fd39b2f00e7e2b6750c79a0c9a7fc948d1ed48a', 6, 'Active', 1, '2024-06-08', NULL, NULL),
(42, 'binuridilara11@gmail.com', '54f332004393c9afa67e76bf2e37123adf7ef906', 2, 'Active', 41, '2024-06-09', NULL, NULL),
(43, 'binuriwork@gmail.com', '316dfce0b1cc13f397323358a087725aba800237', 3, 'Active', 41, '2024-06-09', NULL, NULL),
(44, 'diliniratnayake1970@gmail.com', '2567cd3371c0efc91ae5e881d93ea54c87a37199', 4, 'Active', 41, '2024-06-09', NULL, NULL),
(45, 'induwari.0308@gmail.com', 'c4fcf88b41f0aa43cb1dc5c9e20f2b8f56050f78', 5, 'Active', 41, '2024-06-09', NULL, NULL),
(46, 'gayanbinu9874@gmail.com', '3408669caf878f77da78df9faa215cf5eb353302', 9, 'Active', 41, '2024-06-10', NULL, NULL),
(47, 'niroshan.lessons1@gmail.com', '2df360e217f53aa34f87aada7bd509fb86078bb0', 9, 'Active', 41, '2024-06-10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Booking Manager'),
(3, 'Hall Manager'),
(4, 'Accountant'),
(5, 'Receptionist'),
(6, 'Owner'),
(7, 'Customer'),
(8, 'None'),
(9, 'Supervisor');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
