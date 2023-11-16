-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2022 at 01:18 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kbc_inventory`
--
CREATE DATABASE IF NOT EXISTS `kbc_inventory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `kbc_inventory`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `prcStockReport`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `prcStockReport` (IN `productId` VARCHAR(50))  BEGIN
	SET productId = IFNULL(productId, NULL);
	SELECT products.id,
	`products`.`name`, 
	SUM(`stock`.`debit_quantity`) AS debit_quantity, 
	SUM(`stock`.`credit_quantity`) AS credit_quantity, 
	SUM(`stock`.`debit_quantity`)-SUM(`stock`.`credit_quantity`) AS balance
	FROM `stock` 
	LEFT JOIN `products` on `products`.`id` = `stock`.`product_id`
	WHERE ((stock.product_id = productId AND productId IS NOT NULL) OR productId IS NULL)
	GROUP BY `stock`.`product_id`;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_no` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_no` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mailing_address` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_type` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_code`, `name`, `email`, `phone_no`, `mobile_no`, `whatsapp_no`, `mailing_address`, `shipping_address`, `city`, `account_type`, `created_at`, `updated_at`) VALUES
(1, 'P-1', 'Liaqat Khan', 'khalil@test.com', '3434', '343434', '3434', 'dsfas', 'fdasdfasf', 'asdfa', 'P', '2021-11-25 05:58:25', '2021-11-25 05:58:25'),
(2, 'P-2', 'Quita Khan', 'khalil@test.com', '343', '43434', '343', 'asdf', 'asdfasdfad', 'fsdf', 'P', '2021-11-25 05:58:44', '2021-11-25 05:58:44'),
(4, 'S-1', 'Rehmat and sons', 'rehmat@gmail.com', '2323232', '333333', '23232323', 'sdf', 'sdfadsf', 'Karachi', 'S', '2021-11-26 01:30:21', '2021-11-26 01:30:21'),
(5, 'CH-00001', 'Cash in Hand', NULL, NULL, '', NULL, '', '', NULL, 'CH', NULL, NULL),
(6, 'S-5', 'adsfsadf', NULL, '3434', '3434', '3434', 'fasdfsa', 'dfsadfsadfsad', 'fsad', 'S', '2021-12-02 08:39:21', '2021-12-02 08:39:21'),
(7, 'S-7', 'sadfsdfasdf', NULL, NULL, '3434', '3434', 'asdfsadf', 'sadfsafdsadf', 'fasdf', 'S', '2021-12-02 08:42:49', '2021-12-02 08:42:49'),
(8, 'E-1', 'Salary Expense', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'E', '2021-12-02 08:45:20', '2021-12-02 08:51:51'),
(9, 'E-2', 'misc expenses', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-02 08:56:07', '2021-12-02 09:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `account_ledgers`
--

DROP TABLE IF EXISTS `account_ledgers`;
CREATE TABLE `account_ledgers` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `account_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `cheque_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` double NOT NULL,
  `credit` double NOT NULL,
  `voucher_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_ledgers`
--

INSERT INTO `account_ledgers` (`id`, `date`, `invoice_id`, `account_id`, `cheque_number`, `description`, `transaction_type`, `debit`, `credit`, `voucher_number`, `created_at`, `updated_at`) VALUES
(2, NULL, 61, '1', '', 'Purchased Product', 'Purchase', 0, 45000, NULL, NULL, NULL),
(3, NULL, 62, '3', '', 'Purchased Product', 'Purchase', 0, 34500, NULL, NULL, NULL),
(5, NULL, 64, '3', '', 'Purchased products against invoice no, 64', 'Purchase', 0, 21000, NULL, NULL, NULL),
(6, NULL, 78, '1', '', 'Purchased products against invoice no, 78', 'Purchase', 0, 15000, NULL, NULL, NULL),
(7, NULL, 140, '4', '', 'Purchased products against invoice no, 140', 'Purchase', 0, 60000, NULL, NULL, NULL),
(8, NULL, 166, '1', '', 'Purchased products against invoice no, 166', 'Purchase', 0, 39000, NULL, NULL, NULL),
(9, NULL, 167, '1', '', 'Purchased products against invoice no, 167', 'Purchase', 0, 39000, NULL, NULL, NULL),
(10, NULL, 168, '3', '', 'Purchased products against invoice no, 168', 'Purchase', 0, 45000, NULL, NULL, NULL),
(11, NULL, 171, '1', '', 'Purchased products against invoice no, 171', 'Purchase', 0, 15000, NULL, NULL, NULL),
(17, NULL, 195, '1', '', 'Purchased products against invoice no, 195', 'Purchase', 0, 15000, NULL, NULL, NULL),
(18, NULL, 196, '1', '', 'Purchased products against invoice no, 196', 'Purchase', 0, 15000, NULL, NULL, NULL),
(19, NULL, 1, '2', '', 'Purchased products against invoice no, 1', 'Purchase', 0, 15000, NULL, NULL, NULL),
(21, NULL, 15, '3', '', 'Purchased Return Products against invoice no, 15', 'purchase_return', 0, 10000, NULL, NULL, NULL),
(22, NULL, 16, '3', '', 'Purchased Return Products against invoice no, 16', 'purchase_return', 0, 30000, NULL, NULL, NULL),
(23, NULL, 17, '1', '', 'Purchased Return Products against invoice no, 17', 'purchase_return', 0, 15000, NULL, NULL, NULL),
(24, NULL, 18, '1', '', 'Purchased Return Products against invoice no, 18', 'purchase_return', 32500, 0, NULL, NULL, NULL),
(25, NULL, 19, '4', '', 'Purchased Return Products against invoice no, 19', 'purchase_return', 15000, 0, NULL, NULL, NULL),
(26, NULL, 199, '1', '', 'Purchased products against invoice no, 199', 'purchase', 0, 15000, NULL, NULL, NULL),
(88, '2021-11-04', NULL, '5', '968574', 'sdfasd', 'brv', 35000, 0, '88', '2021-11-07 02:26:13', '2021-11-07 02:26:13'),
(89, '2021-11-04', NULL, '1', '968574', 'sdfasd', 'brv', 0, 35000, '88', '2021-11-07 02:26:13', '2021-11-07 02:26:13'),
(90, '2021-11-03', NULL, '11', '34434', 'dewc', 'brv', 45000, 0, '90', '2021-11-07 02:27:00', '2021-11-07 02:27:00'),
(91, '2021-11-03', NULL, '1', '34434', 'dewc', 'brv', 0, 45000, '90', '2021-11-07 02:27:00', '2021-11-07 02:27:00'),
(92, NULL, 200, '1', '', 'Purchased products against invoice no, 200', 'purchase', 0, 110352, NULL, '2021-11-26 09:56:43', '2021-11-26 09:56:44'),
(102, '2021-12-04', NULL, 'CH-00001', '', 'cash received', 'cpv', 5000, 0, NULL, '2021-12-01 05:23:39', '2021-12-04 08:07:22'),
(103, '2021-12-01', NULL, 'CH-00001', '', 'cash received', 'cpv', 200000, 0, NULL, '2021-12-01 05:23:39', '2021-12-01 05:23:39'),
(104, '2021-12-02', NULL, 'P-1', '', 'cash paid', 'cpv', 50000, 0, NULL, '2021-12-01 05:26:05', '2021-12-01 05:26:05'),
(105, '2021-12-02', NULL, 'CH-00001', '', 'cash paid', 'cpv', 0, 50000, NULL, '2021-12-01 05:26:05', '2021-12-01 05:26:05'),
(106, '2021-12-02', 204, 'P-00000001', '', 'Purchase against invoice no 204', 'purchase', 8300, 0, NULL, NULL, NULL),
(107, '2021-12-02', 205, '2', '', 'Purchase against invoice no 205', 'purchase', 0, 17400, NULL, NULL, NULL),
(108, '2021-12-02', 205, 'P-00000001', '', 'Purchase against invoice no 205', 'purchase', 17400, 0, NULL, NULL, NULL),
(109, '2021-12-02', 206, 'P-1', '', 'Purchase against invoice no 206', 'purchase', 0, 4500, NULL, NULL, NULL),
(110, '2021-12-02', 206, 'P-00000001', '', 'Purchase against invoice no 206', 'purchase', 4500, 0, NULL, NULL, NULL),
(111, '2021-12-01', 207, 'P-1', '', 'Purchase against invoice no 207', 'purchase', 0, 5200, NULL, NULL, NULL),
(112, '2021-12-01', 207, 'P-00000001', '', 'Purchase against invoice no 207', 'purchase', 5200, 0, NULL, NULL, NULL),
(113, '2021-12-02', 208, 'P-1', '', 'Purchase against invoice no 208', 'purchase', 0, 176000, NULL, NULL, NULL),
(114, '2021-12-02', 208, 'P-00000001', '', 'Purchase against invoice no 208', 'purchase', 176000, 0, NULL, NULL, NULL),
(115, '2021-12-03', 20, 'PR-00000001', '', 'Purchased Return Products 20', 'purchase_return', 2433, 0, NULL, NULL, NULL),
(116, '2021-12-03', 21, '1', '', 'Purchased Return Products 21', 'purchase_return', 0, 4600, NULL, NULL, NULL),
(117, '2021-12-03', 21, 'PR-00000001', '', 'Purchased Return Products 21', 'purchase_return', 4600, 0, NULL, NULL, NULL),
(118, '2021-12-03', 22, 'P-1', '', 'Purchased Return Products 22', 'purchase_return', 0, 7500, NULL, NULL, NULL),
(119, '2021-12-03', 22, 'PR-00000001', '', 'Purchased Return Products 22', 'purchase_return', 7500, 0, NULL, NULL, NULL),
(120, '2021-10-16', 23, 'PR-00000001', '', 'Purchased Return Products 23', 'purchase_return', 0, 10500, NULL, NULL, NULL),
(121, '2021-10-16', 23, 'P-1', '', 'Purchased Return Products 23', 'purchase_return', 10500, 0, NULL, NULL, NULL),
(122, '2021-12-02', NULL, 'P-1', '', 'cash paid', 'cpv', 50000, 0, NULL, '2021-12-03 04:45:16', '2021-12-03 04:45:16'),
(123, '2021-12-02', NULL, 'CH-00001', '', 'cash paid', 'cpv', 0, 50000, NULL, '2021-12-03 04:45:16', '2021-12-03 04:45:16'),
(124, '2021-12-01', NULL, 'P-1', '3443433434', 'cash paid by cheque no: 56987785 MCB', 'bpv', 32000, 0, '124', '2021-12-03 04:56:44', '2021-12-03 04:56:44'),
(125, '2021-12-01', NULL, '5', '3443433434', 'cash paid by cheque no: 56987785 MCB', 'bpv', 0, 32000, '124', '2021-12-03 04:56:44', '2021-12-03 04:56:44'),
(126, '2021-12-02', NULL, 'P-1', '9878855', 'Cash received', 'bpv', 10000, 0, '126', '2021-12-03 05:10:53', '2021-12-03 05:10:53'),
(127, '2021-12-02', NULL, '5', '9878855', 'Cash received', 'bpv', 0, 10000, '126', '2021-12-03 05:10:53', '2021-12-03 05:10:53'),
(128, '2021-12-04', 8, '4', '', 'Saled products 8', 'sale', 4800, 0, NULL, NULL, NULL),
(129, '2021-12-04', 8, 'S-00000001', '', 'Saled products 8', 'sale', 0, 4800, NULL, NULL, NULL),
(130, '2021-12-04', 9, '4', '', 'Saled products 9', 'sale', 4800, 0, NULL, NULL, NULL),
(131, '2021-12-04', 9, 'S-00000001', '', 'Saled products 9', 'sale', 0, 4800, NULL, NULL, NULL),
(132, '2021-12-04', 10, 'S-1', '', 'Saled products 10', 'sale', 5400, 0, NULL, NULL, NULL),
(133, '2021-12-04', 10, 'S-00000001', '', 'Saled products 10', 'sale', 0, 5400, NULL, NULL, NULL),
(136, '2021-12-04', NULL, 'CH-00001', '', 'cash received', 'crv', 2000, 0, NULL, '2021-12-04 08:21:56', '2021-12-04 08:21:56'),
(137, '2021-12-04', NULL, 'S-1', '', 'cash received', 'crv', 0, 2000, NULL, '2021-12-04 08:21:56', '2021-12-04 08:21:56'),
(144, '2021-12-04', NULL, 'CH-00001', '', 'sadf', 'crv', 3500, 0, '141', '2021-12-04 08:33:57', '2021-12-04 08:33:57'),
(145, '2021-12-04', NULL, 'P-2', '', 'sadf', 'crv', 0, 3500, '141', '2021-12-04 08:33:57', '2021-12-04 08:33:57'),
(146, '2021-12-04', NULL, 'CH-00001', '', 'sadf', 'crv', 3700, 0, '138', '2021-12-04 08:34:55', '2021-12-04 08:34:55'),
(147, '2021-12-04', NULL, 'P-2', '', 'sadf', 'crv', 0, 3700, '138', '2021-12-04 08:34:55', '2021-12-04 08:34:55'),
(148, '2021-12-04', NULL, 'S-1', '', 'cash paid', 'cpv', 2000, 0, '123', '2021-12-04 09:59:12', '2021-12-04 09:59:12'),
(149, '2021-12-04', NULL, 'CH-00001', '', 'cash paid', 'cpv', 0, 2000, '123', '2021-12-04 09:59:12', '2021-12-04 09:59:12'),
(152, '2021-12-04', NULL, 'S-1', '', 'cash paid', 'cpv', 2700, 0, '149', '2021-12-04 10:10:00', '2021-12-04 10:10:00'),
(153, '2021-12-04', NULL, 'CH-00001', '', 'cash paid', 'cpv', 0, 2700, '149', '2021-12-04 10:10:00', '2021-12-04 10:10:00'),
(154, '2021-10-16', NULL, 'S-1', '6597774', 'payment by cheque', 'bpv', 3500, 0, '154', '2021-12-04 10:17:44', '2021-12-04 10:17:44'),
(155, '2021-10-16', NULL, '5', '6597774', 'payment by cheque', 'bpv', 0, 3500, '154', '2021-12-04 10:17:44', '2021-12-04 10:17:44'),
(156, '2021-10-16', NULL, '11', '658777', 'cash received by cheque', 'brv', 5000, 0, '156', '2021-12-04 10:23:35', '2021-12-04 10:23:35'),
(157, '2021-10-16', NULL, 'S-1', '658777', 'cash received by cheque', 'brv', 0, 5000, '156', '2021-12-04 10:23:35', '2021-12-04 10:23:35'),
(162, '2021-12-04', 15, 'SR-00000001', '', 'Products returned against invoice 15', 'sale_return', 5200, 0, NULL, NULL, NULL),
(163, '2021-12-04', 15, 'S-1', '', 'Products returned against invoice 15', 'sale_return', 0, 5200, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

DROP TABLE IF EXISTS `account_types`;
CREATE TABLE `account_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_types`
--

INSERT INTO `account_types` (`id`, `name`, `alias`, `created_at`, `updated_at`) VALUES
(1, 'Sale', 'S', NULL, NULL),
(2, 'Purchase', 'P', NULL, NULL),
(3, 'Expense', 'E', NULL, NULL),
(4, 'Cash in Hand', 'CH', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE `banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `account_title`, `branch_code`, `branch_name`, `account_number`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(5, 'SCB', 'Khalil ur Rehman', '9999', 'F-11 Markaz', '858774774-988', '051-8997747', 'F-11, Markaz ISB', '2021-10-31 06:21:36', '2021-10-31 06:25:46'),
(11, 'MCB', 'Karachi Branded Collection', '65889', 'G-11 Branch', '34534345-22`', '051-8977485', 'G-11 Markaz', '2021-10-31 06:37:58', '2021-10-31 06:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `bank_payment_vouchers`
--

DROP TABLE IF EXISTS `bank_payment_vouchers`;
CREATE TABLE `bank_payment_vouchers` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `bank_id` int(10) UNSIGNED NOT NULL,
  `f_year_id` int(10) UNSIGNED NOT NULL,
  `bpv_no` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cheque_no` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_to` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `wht` double(10,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(10,2) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_receipt_vouchers`
--

DROP TABLE IF EXISTS `bank_receipt_vouchers`;
CREATE TABLE `bank_receipt_vouchers` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `bank_id` int(10) UNSIGNED NOT NULL,
  `f_year_id` int(10) UNSIGNED NOT NULL,
  `brv_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cheque_no` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_to` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `wht` double(10,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(10,2) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Saphires', NULL, '2021-12-02 09:23:57'),
(2, 'Gul Ahmed', NULL, NULL),
(3, 'J.', NULL, NULL),
(4, 'TJ', '2021-12-02 09:24:19', '2021-12-02 09:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `cash_payment_vouchers`
--

DROP TABLE IF EXISTS `cash_payment_vouchers`;
CREATE TABLE `cash_payment_vouchers` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `cpv_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_year_id` int(10) UNSIGNED NOT NULL,
  `paid_to` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wht` double(10,2) NOT NULL,
  `date` date NOT NULL,
  `amount` double(10,2) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_receipt_vouchers`
--

DROP TABLE IF EXISTS `cash_receipt_vouchers`;
CREATE TABLE `cash_receipt_vouchers` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `crv_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_year_id` int(10) UNSIGNED NOT NULL,
  `received_from` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wht` double(10,2) NOT NULL,
  `date` date NOT NULL,
  `amount` double(10,2) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_no` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp_no` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mailing_address` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone_no`, `mobile_no`, `whatsapp_no`, `mailing_address`, `shipping_address`, `city`, `created_at`, `updated_at`) VALUES
(1, 'Haris', 'haris@test.com', '0456655855', '03006599887', '03004152525', 'Isb', 'Isb', 'Isb', '2021-10-17 12:15:06', NULL),
(2, 'Wajid', 'wajid@gmail.com', '0456655855', '03006599887', '03004152525', 'Isb', 'Isb', 'Isb', '2021-10-17 12:15:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_charges_price`
--

DROP TABLE IF EXISTS `delivery_charges_price`;
CREATE TABLE `delivery_charges_price` (
  `id` int(10) UNSIGNED NOT NULL,
  `shipment_type_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `fuel_percentage` int(11) NOT NULL,
  `gst_percentage` int(11) NOT NULL,
  `additional_kg_charges` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
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
(3, '2021_09_11_095941_create_customers_table', 1),
(4, '2021_09_11_095953_create_brands_table', 1),
(5, '2021_09_11_100009_create_products_table', 1),
(6, '2021_09_11_100037_create_purchase_master_table', 1),
(9, '2021_09_11_100803_create_purchase_detail_table', 1),
(10, '2021_09_11_101058_create_categories_table', 1),
(11, '2021_09_12_070904_create_parties_table', 1),
(12, '2021_09_14_113502_create_purchase_return_table', 1),
(13, '2021_09_14_113547_create_sale_return_table', 1),
(15, '2021_09_14_114244_create_stock_table', 2),
(16, '2021_10_14_065126_account_ledgers', 3),
(17, '2021_10_17_065030_create_purchase_return_master_table', 4),
(18, '2021_10_17_065044_create_purchase_return_detail_table', 4),
(21, '2021_09_11_100051_create_sale_master_table', 5),
(22, '2021_09_11_100713_create_sale_detail_table', 5),
(23, '2021_10_18_123251_create_sale_return_master_table', 6),
(24, '2021_10_18_123300_create_sale_return_detail_table', 6),
(25, '2021_10_19_075047_create_shipment_types_table', 7),
(26, '2021_10_19_075216_create_zones_table', 7),
(27, '2021_10_19_075419_create_delivery_charges_price_table', 7),
(29, '2020_03_10_174518_create_banks_table', 8),
(30, '2020_03_12_184139_create_bank_payment_vouchers_table', 8),
(31, '2020_03_12_184200_create_bank_receipt_vouchers_table', 8),
(32, '2020_03_12_184213_create_cash_receipt_vouchers_table', 8),
(33, '2020_03_12_184226_create_cash_payment_vouchers_table', 8),
(34, '2020_04_10_170607_add_columns_in_banks_table', 8),
(35, '2020_04_10_173240_add_columns_phone_in_banks_table', 8),
(36, '2020_05_03_070917_create_permissions_table', 9),
(37, '2021_11_24_101107_create_accounts_table', 10),
(38, '2021_11_25_072814_create_account_types_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

DROP TABLE IF EXISTS `parties`;
CREATE TABLE `parties` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mailing_address` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `name`, `email`, `phone_no`, `mobile_no`, `whatsapp_no`, `mailing_address`, `shipping_address`, `city`, `created_at`, `updated_at`) VALUES
(1, 'Rehmat and sons', 'rehmat@test.com', '0425887788', '0300857858', '03216588974', 'House#433, street#9, G-11/2 Islamabad', 'House#433, street#9, G-11/2 Islamabad', 'Islamabad', NULL, NULL),
(2, 'Noor and sons', 'noor@test.com', '0425887788', '0300857858', '03216588974', 'House#433, street#9, G-11/2 Islamabad', 'House#433, street#9, G-11/2 Islamabad', 'Islamabad', NULL, NULL),
(3, 'Peshawar Khan', 'peshawar.khan@test.com', '0425887788', '0300857858', '03216588974', 'House#433, street#9, G-11/2 Islamabad', 'House#433, street#9, G-11/2 Islamabad', 'Islamabad', NULL, NULL),
(4, 'Queita Khan', 'quita@test.com', '0425887788', '0300857858', '03216588974', 'House#433, street#9, G-11/2 Islamabad', 'House#433, street#9, G-11/2 Islamabad', 'Islamabad', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `menu_access` tinyint(3) UNSIGNED NOT NULL,
  `select_access` tinyint(3) UNSIGNED NOT NULL,
  `insert_access` tinyint(3) UNSIGNED NOT NULL,
  `edit_access` tinyint(3) UNSIGNED NOT NULL,
  `delete_access` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `brand_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `sale_price` double DEFAULT NULL,
  `size` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand_id`, `name`, `price`, `sale_price`, `size`, `created_at`, `updated_at`) VALUES
(1, 1, 'Stiched Shirt', 1500, 2200, 'Toddler', NULL, NULL),
(2, 2, 'Frock', 1000, 1500, 'Toddler', NULL, NULL),
(4, 1, 'Shalwar Qameez', 1200, 1500, 'Large', NULL, NULL),
(5, 3, 'Kurta', 2000, 2500, 'Medium', NULL, NULL),
(6, 1, 'new product', 100, 200, 'Large', '2021-10-17 07:25:23', '2021-10-17 07:25:23'),
(7, 1, 'Saphaire suite', 33, 33, 'dsafadf', '2021-10-31 04:54:48', '2021-12-02 09:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_detail`
--

DROP TABLE IF EXISTS `purchase_detail`;
CREATE TABLE `purchase_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` double NOT NULL,
  `purchase_master_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_detail`
--

INSERT INTO `purchase_detail` (`id`, `product_id`, `price`, `quantity`, `amount`, `purchase_master_id`, `created_at`, `updated_at`) VALUES
(208, 1, 1500, 3, 4500, 206, '2021-12-02 10:02:35', '2021-12-02 10:02:35'),
(209, 1, 1500, 3, 4500, 207, '2021-12-02 10:09:41', '2021-12-02 10:09:41'),
(210, 6, 100, 7, 700, 207, '2021-12-02 10:09:41', '2021-12-02 10:09:41'),
(211, 1, 1500, 100, 150000, 208, '2021-12-02 10:22:00', '2021-12-02 10:22:00'),
(212, 6, 100, 10, 1000, 208, '2021-12-02 10:22:00', '2021-12-02 10:22:00'),
(213, 4, 1200, 20, 24000, 208, '2021-12-02 10:22:00', '2021-12-02 10:22:00'),
(214, 7, 33, 10, 1000, 208, '2021-12-02 10:22:00', '2021-12-02 10:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_master`
--

DROP TABLE IF EXISTS `purchase_master`;
CREATE TABLE `purchase_master` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `party_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `brand_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `quantity` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_master`
--

INSERT INTO `purchase_master` (`id`, `date`, `party_id`, `brand_id`, `amount`, `quantity`, `created_at`, `updated_at`) VALUES
(206, '2021-12-02', 'P-1', 1, 4500, 3, '2021-12-02 10:02:35', '2021-12-02 10:02:35'),
(207, '2021-12-01', 'P-1', 1, 5200, 10, '2021-12-02 10:09:41', '2021-12-02 10:09:41'),
(208, '2021-12-02', 'P-1', 1, 176000, 140, '2021-12-02 10:22:00', '2021-12-02 10:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return`
--

DROP TABLE IF EXISTS `purchase_return`;
CREATE TABLE `purchase_return` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `bill_number` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_master_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_detail`
--

DROP TABLE IF EXISTS `purchase_return_detail`;
CREATE TABLE `purchase_return_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` double NOT NULL,
  `purchase_return_master_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_return_detail`
--

INSERT INTO `purchase_return_detail` (`id`, `product_id`, `price`, `quantity`, `amount`, `purchase_return_master_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1500, 10, 15000, 1, '2021-10-17 02:16:34', '2021-10-17 02:16:34'),
(2, 3, 2500, 10, 25000, 2, '2021-10-17 02:20:48', '2021-10-17 02:20:48'),
(3, 2, 1000, 5, 5000, 2, '2021-10-17 02:20:48', '2021-10-17 02:20:48'),
(17, 2, 1000, 10, 10000, 15, '2021-10-17 03:22:52', '2021-10-17 03:22:52'),
(18, 1, 1500, 20, 30000, 16, '2021-10-17 03:24:22', '2021-10-17 03:24:22'),
(19, 1, 1500, 10, 15000, 17, '2021-10-17 03:27:23', '2021-10-17 03:27:23'),
(20, 2, 1000, 20, 20000, 18, '2021-10-17 03:28:45', '2021-10-17 03:28:45'),
(21, 3, 2500, 5, 12500, 18, '2021-10-17 03:28:45', '2021-10-17 03:28:45'),
(22, 1, 1500, 10, 15000, 19, '2021-10-17 03:31:39', '2021-10-17 03:31:39'),
(23, 4, 1200, 2, 2400, 20, '2021-12-03 04:16:50', '2021-12-03 04:16:50'),
(24, 7, 33, 1, 33, 20, '2021-12-03 04:16:50', '2021-12-03 04:16:50'),
(25, 1, 1500, 3, 4500, 21, '2021-12-03 04:18:57', '2021-12-03 04:18:57'),
(26, 6, 100, 1, 100, 21, '2021-12-03 04:18:57', '2021-12-03 04:18:57'),
(27, 1, 1500, 5, 7500, 22, '2021-12-03 04:32:26', '2021-12-03 04:32:26'),
(28, 1, 1500, 7, 10500, 23, '2021-12-03 04:41:52', '2021-12-03 04:41:52');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_master`
--

DROP TABLE IF EXISTS `purchase_return_master`;
CREATE TABLE `purchase_return_master` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `party_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `brand_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `quantity` double NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_return_master`
--

INSERT INTO `purchase_return_master` (`id`, `date`, `party_id`, `brand_id`, `amount`, `quantity`, `remarks`, `created_at`, `updated_at`) VALUES
(22, '2021-12-03', 'P-1', 1, 7500, 5, NULL, '2021-12-03 04:32:26', '2021-12-03 04:32:26'),
(23, '2021-10-16', 'P-1', 1, 10500, 7, NULL, '2021-12-03 04:41:52', '2021-12-03 04:41:52');

-- --------------------------------------------------------

--
-- Table structure for table `sale_detail`
--

DROP TABLE IF EXISTS `sale_detail`;
CREATE TABLE `sale_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` double NOT NULL,
  `amount` double NOT NULL,
  `sale_master_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_detail`
--

INSERT INTO `sale_detail` (`id`, `product_id`, `price`, `quantity`, `amount`, `sale_master_id`, `created_at`, `updated_at`) VALUES
(19, 1, 2200, 2, 4400, 10, '2021-12-04 08:03:34', '2021-12-04 08:03:34'),
(20, 6, 200, 5, 1000, 10, '2021-12-04 08:03:34', '2021-12-04 08:03:34');

-- --------------------------------------------------------

--
-- Table structure for table `sale_master`
--

DROP TABLE IF EXISTS `sale_master`;
CREATE TABLE `sale_master` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `customer_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `brand_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `quantity` double NOT NULL,
  `tracking_number` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_master`
--

INSERT INTO `sale_master` (`id`, `date`, `customer_id`, `brand_id`, `amount`, `quantity`, `tracking_number`, `remarks`, `created_at`, `updated_at`) VALUES
(10, '2021-12-04', 'S-1', 1, 5400, 7, '4545455', 'remarks', '2021-12-04 08:03:34', '2021-12-04 08:03:34');

-- --------------------------------------------------------

--
-- Table structure for table `sale_return`
--

DROP TABLE IF EXISTS `sale_return`;
CREATE TABLE `sale_return` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `bill_number` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `tracking_number` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_master_id` int(11) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_detail`
--

DROP TABLE IF EXISTS `sale_return_detail`;
CREATE TABLE `sale_return_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` double NOT NULL,
  `amount` double NOT NULL,
  `sale_return_master_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_return_detail`
--

INSERT INTO `sale_return_detail` (`id`, `product_id`, `price`, `quantity`, `amount`, `sale_return_master_id`, `created_at`, `updated_at`) VALUES
(12, 1, 2200, 1, 2200, 15, '2021-12-04 10:57:10', '2021-12-04 10:57:10'),
(13, 4, 1500, 2, 3000, 15, '2021-12-04 10:57:10', '2021-12-04 10:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_master`
--

DROP TABLE IF EXISTS `sale_return_master`;
CREATE TABLE `sale_return_master` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `customer_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `brand_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `quantity` double NOT NULL,
  `tracking_number` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_return_master`
--

INSERT INTO `sale_return_master` (`id`, `date`, `customer_id`, `brand_id`, `amount`, `quantity`, `tracking_number`, `remarks`, `created_at`, `updated_at`) VALUES
(15, '2021-12-04', 'S-1', 1, 5200, 3, NULL, 'sale returned', '2021-12-04 10:57:10', '2021-12-04 10:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `shipment_types`
--

DROP TABLE IF EXISTS `shipment_types`;
CREATE TABLE `shipment_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipment_types`
--

INSERT INTO `shipment_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Detain', NULL, NULL),
(2, 'Overland', NULL, NULL),
(3, 'Overnight', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL,
  `debit_quantity` double DEFAULT NULL,
  `credit_quantity` double DEFAULT NULL,
  `transaction_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `invoice_id`, `product_id`, `debit_quantity`, `credit_quantity`, `transaction_type`, `created_at`, `updated_at`) VALUES
(1, 0, 2, 10, 0, NULL, '2021-10-13 07:11:02', '2021-10-13 07:11:02'),
(2, 0, 2, 5, 0, NULL, '2021-10-13 07:17:45', '2021-10-13 07:17:45'),
(3, 0, 2, 5, 0, NULL, NULL, NULL),
(4, 0, 3, 10, 0, NULL, NULL, NULL),
(5, 0, 2, 2, 41, NULL, NULL, NULL),
(6, 0, 3, 5, 41, NULL, NULL, NULL),
(10, 40, 2, 5, 0, NULL, NULL, NULL),
(11, 40, 2, 10, 2, NULL, NULL, NULL),
(12, 40, 3, 2, 0, NULL, NULL, NULL),
(15, 56, 1, 10, 0, NULL, NULL, NULL),
(16, 56, 1, 5, 0, NULL, NULL, NULL),
(17, 56, 4, 2, 0, NULL, NULL, NULL),
(26, 61, 1, 10, 0, NULL, NULL, NULL),
(27, 61, 1, 20, 0, NULL, NULL, NULL),
(28, 61, 4, 5, 0, NULL, NULL, NULL),
(29, 62, 4, 10, 5, NULL, NULL, NULL),
(30, 62, 1, 15, 0, NULL, NULL, NULL),
(32, 64, 1, 10, 0, NULL, NULL, NULL),
(33, 64, 4, 5, 0, NULL, NULL, NULL),
(34, 78, 1, 10, 4, NULL, NULL, NULL),
(79, 140, 2, 10, 0, NULL, NULL, NULL),
(80, 140, 3, 20, 0, NULL, NULL, NULL),
(114, 195, 1, 10, 0, NULL, '2021-10-17 02:04:47', '2021-10-17 02:04:47'),
(115, 196, 1, 10, 0, NULL, '2021-10-17 02:06:02', '2021-10-17 02:06:02'),
(116, 1, 1, 10, 0, NULL, '2021-10-17 02:16:34', '2021-10-17 02:16:34'),
(119, 15, 2, NULL, NULL, NULL, '2021-10-17 03:22:52', '2021-10-17 03:22:52'),
(120, 16, 1, NULL, 4, NULL, '2021-10-17 03:24:22', '2021-10-17 03:24:22'),
(121, 17, 1, NULL, 5, NULL, '2021-10-17 03:27:23', '2021-10-17 03:27:23'),
(122, 18, 2, NULL, NULL, NULL, '2021-10-17 03:28:45', '2021-10-17 03:28:45'),
(123, 18, 3, NULL, NULL, NULL, '2021-10-17 03:28:45', '2021-10-17 03:28:45'),
(124, 19, 1, 0, 10, 'purchase_return', '2021-10-17 03:31:39', '2021-10-17 03:31:39'),
(125, 199, 1, 10, 0, 'purchase', '2021-10-17 04:03:20', '2021-10-17 04:03:20'),
(128, 3, 6, 0, 10, 'sale', '2021-10-17 23:13:52', '2021-10-17 23:13:52'),
(132, 5, 1, 0, 2, 'sale', '2021-10-17 23:24:12', '2021-10-17 23:24:12'),
(133, 5, 1, 0, 5, 'sale', '2021-10-17 23:24:12', '2021-10-17 23:24:12'),
(134, 5, 1, 0, 1, 'sale', '2021-10-17 23:24:12', '2021-10-17 23:24:12'),
(135, 5, 4, 0, 1, 'sale', '2021-10-17 23:24:12', '2021-10-17 23:24:12'),
(136, 6, 1, 0, 10, 'sale', '2021-10-17 23:29:45', '2021-10-17 23:29:45'),
(137, 6, 4, 0, 2, 'sale', '2021-10-17 23:29:45', '2021-10-17 23:29:45'),
(143, 11, 1, 1, 0, 'sale_return', '2021-10-18 11:53:17', '2021-10-18 11:53:17'),
(144, 11, 4, 2, 0, 'sale_return', '2021-10-18 11:53:17', '2021-10-18 11:53:17'),
(145, 200, 1, 33, 0, 'purchase', '2021-11-15 08:38:31', '2021-11-15 08:38:31'),
(146, 7, 1, 0, 33, 'sale', '2021-11-26 01:30:52', '2021-11-26 01:30:52'),
(147, 7, 6, 0, 55, 'sale', '2021-11-26 01:30:52', '2021-11-26 01:30:52'),
(154, 204, 1, 5, 0, 'purchase', '2021-12-02 09:55:17', '2021-12-02 09:55:17'),
(155, 204, 6, 8, 0, 'purchase', '2021-12-02 09:55:17', '2021-12-02 09:55:17'),
(156, 205, 1, 10, 0, 'purchase', '2021-12-02 09:57:13', '2021-12-02 09:57:13'),
(157, 205, 4, 2, 0, 'purchase', '2021-12-02 09:57:13', '2021-12-02 09:57:13'),
(158, 206, 1, 3, 0, 'purchase', '2021-12-02 10:02:35', '2021-12-02 10:02:35'),
(159, 207, 1, 3, 0, 'purchase', '2021-12-02 10:09:41', '2021-12-02 10:09:41'),
(160, 207, 6, 7, 0, 'purchase', '2021-12-02 10:09:41', '2021-12-02 10:09:41'),
(161, 208, 1, 100, 0, 'purchase', '2021-12-02 10:22:00', '2021-12-02 10:22:00'),
(162, 208, 6, 10, 0, 'purchase', '2021-12-02 10:22:00', '2021-12-02 10:22:00'),
(163, 208, 4, 20, 0, 'purchase', '2021-12-02 10:22:00', '2021-12-02 10:22:00'),
(164, 208, 7, 10, 0, 'purchase', '2021-12-02 10:22:00', '2021-12-02 10:22:00'),
(165, 20, 4, 0, 2, 'purchase_return', '2021-12-03 04:16:50', '2021-12-03 04:16:50'),
(166, 20, 7, 0, 1, 'purchase_return', '2021-12-03 04:16:50', '2021-12-03 04:16:50'),
(167, 21, 1, 0, 3, 'purchase_return', '2021-12-03 04:18:57', '2021-12-03 04:18:57'),
(168, 21, 6, 0, 1, 'purchase_return', '2021-12-03 04:18:57', '2021-12-03 04:18:57'),
(169, 22, 1, 0, 5, 'purchase_return', '2021-12-03 04:32:26', '2021-12-03 04:32:26'),
(170, 23, 1, 0, 7, 'purchase_return', '2021-12-03 04:41:52', '2021-12-03 04:41:52'),
(171, 8, 1, 0, 2, 'sale', '2021-12-04 07:59:49', '2021-12-04 07:59:49'),
(172, 8, 6, 0, 2, 'sale', '2021-12-04 07:59:49', '2021-12-04 07:59:49'),
(173, 9, 1, 0, 2, 'sale', '2021-12-04 08:02:07', '2021-12-04 08:02:07'),
(174, 9, 6, 0, 2, 'sale', '2021-12-04 08:02:07', '2021-12-04 08:02:07'),
(175, 10, 1, 0, 2, 'sale', '2021-12-04 08:03:34', '2021-12-04 08:03:34'),
(176, 10, 6, 0, 5, 'sale', '2021-12-04 08:03:34', '2021-12-04 08:03:34'),
(181, 15, 1, 1, 0, 'sale_return', '2021-12-04 10:57:10', '2021-12-04 10:57:10'),
(182, 15, 4, 2, 0, 'sale_return', '2021-12-04 10:57:10', '2021-12-04 10:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Khalil ur Rehman', 'khalil@test.com', NULL, '$2y$10$t/6SBToaV42Dth5esqPVrujiH0Qnzgd/hWw8h.L7galdHDQu/1Gl2', 'admin', NULL, NULL, NULL),
(4, 'adsasdfadf', 'khalil12@test.com', NULL, '$2y$10$vDN0xaAVfrOYYa.b8EK3f.nelyUk4tSrJi7IsTD9uAJmqlspxkK4i', 'admin', NULL, '2021-12-06 11:04:58', '2021-12-06 11:04:58'),
(5, 'Waleed', 'waleed@test.com', NULL, '$2y$10$R7pKahCyknh7a.vMiLq7duhjuww.v1DVkD8LIAn8wJovne02VbsKe', 'user', NULL, '2021-12-06 11:06:18', '2021-12-06 11:06:18');

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
CREATE TABLE `zones` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Karachi', NULL, NULL),
(2, 'Zone 1', NULL, NULL),
(3, 'Zone 2', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_ledgers`
--
ALTER TABLE `account_ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_types`
--
ALTER TABLE `account_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_payment_vouchers`
--
ALTER TABLE `bank_payment_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_payment_vouchers_bank_id_foreign` (`bank_id`);

--
-- Indexes for table `bank_receipt_vouchers`
--
ALTER TABLE `bank_receipt_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_receipt_vouchers_bank_id_foreign` (`bank_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_payment_vouchers`
--
ALTER TABLE `cash_payment_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_receipt_vouchers`
--
ALTER TABLE `cash_receipt_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_charges_price`
--
ALTER TABLE `delivery_charges_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_master`
--
ALTER TABLE `purchase_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return`
--
ALTER TABLE `purchase_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_detail`
--
ALTER TABLE `purchase_return_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_master`
--
ALTER TABLE `purchase_return_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_detail`
--
ALTER TABLE `sale_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_master`
--
ALTER TABLE `sale_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_return`
--
ALTER TABLE `sale_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_return_detail`
--
ALTER TABLE `sale_return_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_return_master`
--
ALTER TABLE `sale_return_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipment_types`
--
ALTER TABLE `shipment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `account_ledgers`
--
ALTER TABLE `account_ledgers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `account_types`
--
ALTER TABLE `account_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bank_payment_vouchers`
--
ALTER TABLE `bank_payment_vouchers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_receipt_vouchers`
--
ALTER TABLE `bank_receipt_vouchers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cash_payment_vouchers`
--
ALTER TABLE `cash_payment_vouchers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_receipt_vouchers`
--
ALTER TABLE `cash_receipt_vouchers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_charges_price`
--
ALTER TABLE `delivery_charges_price`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT for table `purchase_master`
--
ALTER TABLE `purchase_master`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `purchase_return`
--
ALTER TABLE `purchase_return`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_detail`
--
ALTER TABLE `purchase_return_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `purchase_return_master`
--
ALTER TABLE `purchase_return_master`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sale_detail`
--
ALTER TABLE `sale_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sale_master`
--
ALTER TABLE `sale_master`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sale_return`
--
ALTER TABLE `sale_return`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_detail`
--
ALTER TABLE `sale_return_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sale_return_master`
--
ALTER TABLE `sale_return_master`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `shipment_types`
--
ALTER TABLE `shipment_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_payment_vouchers`
--
ALTER TABLE `bank_payment_vouchers`
  ADD CONSTRAINT `bank_payment_vouchers_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bank_receipt_vouchers`
--
ALTER TABLE `bank_receipt_vouchers`
  ADD CONSTRAINT `bank_receipt_vouchers_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
