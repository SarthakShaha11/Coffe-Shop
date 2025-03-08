-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 08, 2025 at 07:21 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ch`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `InsertUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertUser` (IN `p_username` VARCHAR(255), IN `p_email` VARCHAR(255), IN `p_password` VARCHAR(255), IN `p_phone_no` VARCHAR(15))   BEGIN
    INSERT INTO users (username, email, password, phone_no)
    VALUES (p_username, p_email, p_password, p_phone_no);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `phone`, `password`) VALUES
(1, 'sarthak', '7447880508', '$2y$10$drkyGR1jA8o3FdfrD4Y1zuM2aKo6zj5sU7ORF9YF4dGu6Qw53DKvW');

-- --------------------------------------------------------

--
-- Table structure for table `cancelation`
--

DROP TABLE IF EXISTS `cancelation`;
CREATE TABLE IF NOT EXISTS `cancelation` (
  `cancelation_id` int NOT NULL AUTO_INCREMENT,
  `Order_id` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  PRIMARY KEY (`cancelation_id`),
  KEY `fk_cancel_order` (`Order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cancelation`
--

INSERT INTO `cancelation` (`cancelation_id`, `Order_id`, `price`) VALUES
(1, 0, 664),
(2, 0, 664),
(3, 0, 664),
(4, 0, 664);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `product_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`product_id`, `product_name`, `product_price`, `quantity`, `created_at`) VALUES
(1, 'Arabica Beans', 200.00, 1, '2025-03-08 07:14:35'),
(2, 'Espresso Blend', 500.00, 3, '2025-03-08 06:51:49');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`) VALUES
(4, 'Sarthak Shah', 'sarthakshaha@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending',
  `quantity` int NOT NULL DEFAULT '1',
  `Order_id` varchar(255) NOT NULL,
  `product_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total`, `status`, `quantity`, `Order_id`, `product_id`, `price`) VALUES
(1, NULL, NULL, 'Pending', 2, 'ORD_1741408992_3163', 3, 250.00),
(2, NULL, NULL, 'Pending', 2, 'ORD_1741408992_3163', 7, 400.00),
(3, NULL, NULL, 'Pending', 4, 'ORD_1741408992_3163', 1, 200.00),
(18, NULL, NULL, 'Pending', 2, 'ORD_1741413015_6691', 1, 200.00),
(17, NULL, NULL, 'Pending', 1, 'ORD_1741413015_6691', 7, 400.00),
(16, NULL, NULL, 'Pending', 1, 'ORD_1741413015_6691', 3, 250.00),
(19, NULL, NULL, 'Pending', 1, 'ORD_1741414029_6595', 3, 250.00),
(20, NULL, NULL, 'Pending', 2, 'ORD_1741414029_6595', 1, 200.00),
(21, NULL, NULL, 'Pending', 2, 'ORD_1741414605_1378', 1, 200.00),
(22, NULL, NULL, 'Pending', 1, 'ORD_1741414853_2903', 5, 300.00),
(23, NULL, NULL, 'Pending', 2, 'ORD_1741414853_2903', 1, 200.00),
(24, NULL, NULL, 'Pending', 1, 'ORD_1741415832_2159', 5, 300.00),
(25, NULL, NULL, 'Pending', 2, 'ORD_1741415832_2159', 1, 200.00),
(26, NULL, NULL, 'Pending', 1, 'ORD_1741416347_1443', 5, 300.00),
(27, NULL, NULL, 'Pending', 1, 'ORD_1741416569_3221', 5, 300.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 0, 5, 1, 300.00),
(2, 0, 2, 1, 500.00),
(3, 0, 2, 1, 500.00),
(4, 0, 1, 1, 200.00),
(5, 0, 2, 3, 500.00),
(6, 0, 1, 1, 200.00),
(7, 0, 2, 3, 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) NOT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `payment_status` varchar(20) DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `order_id`, `transaction_id`, `payment_method`, `price`, `payment_status`, `created_at`) VALUES
(1, '', 'WC_67c69fc54d2ad', 'Wallet/Cash Card', 0.00, 'completed', '2025-03-04 06:38:30'),
(2, '', 'WC_67c69fc54d2ad', 'Wallet/Cash Card', 0.00, 'completed', '2025-03-04 06:43:02'),
(3, '', 'WC_67c69fc54d2ad', 'Wallet/Cash Card', 0.00, 'completed', '2025-03-04 06:45:10'),
(4, '', 'WC_67c69fc54d2ad', 'Wallet/Cash Card', 0.00, 'completed', '2025-03-04 06:49:08'),
(5, '', 'CC_67c6a54a1575c', 'Credit Card', 0.00, 'completed', '2025-03-04 07:02:01'),
(6, '', 'CC_67c6a54a1575c', 'Credit Card', 0.00, 'completed', '2025-03-04 07:04:22'),
(7, 'ORD_1741071868_3440', 'CC_67c6a5fc670c0', 'Credit Card', 42.00, 'completed', '2025-03-04 07:05:10'),
(8, 'ORD_1741071868_3440', 'CC_67c6a5fc670c0', 'Credit Card', 42.00, 'completed', '2025-03-04 07:08:37'),
(9, 'ORD_1741072126_3997', 'CC_67c6a6fe1c66c', 'Credit Card', 42.00, 'completed', '2025-03-04 07:11:30'),
(10, 'ORD_1741155562_7975', NULL, 'Cash on Delivery', 42.00, 'completed', '2025-03-05 06:41:20'),
(11, 'ORD_1741155562_7975', NULL, 'Cash on Delivery', 42.00, 'completed', '2025-03-05 07:04:54'),
(12, 'ORD_1741158303_6263', NULL, 'Cash on Delivery', 42.00, 'completed', '2025-03-05 07:05:06'),
(13, 'ORD_1741158303_6263', NULL, 'Cash on Delivery', 42.00, 'completed', '2025-03-05 07:07:15'),
(14, 'ORD_1741158444_5698', NULL, 'Cash on Delivery', 42.00, 'completed', '2025-03-05 07:07:27'),
(15, 'ORD_1741158444_5698', NULL, 'Cash on Delivery', 42.00, 'completed', '2025-03-05 07:07:31'),
(16, 'ORD_1741158484_2587', NULL, 'Cash on Delivery', 55.00, 'completed', '2025-03-05 07:08:07'),
(17, 'ORD_1741158484_2587', NULL, 'Cash on Delivery', 55.00, 'completed', '2025-03-05 07:08:11'),
(18, 'ORD_1741158484_2587', NULL, 'Cash on Delivery', 55.00, 'completed', '2025-03-05 07:10:27'),
(19, 'ORD_1741159372_9823', NULL, 'Cash on Delivery', 69.00, 'completed', '2025-03-05 07:23:04'),
(20, 'ORD_1741160857_3532', NULL, 'Cash on Delivery', 15.00, 'completed', '2025-03-05 07:48:01'),
(21, 'ORD_1741160857_3532', NULL, 'Cash on Delivery', 15.00, 'completed', '2025-03-05 07:49:26'),
(22, 'ORD_1741160857_3532', NULL, 'COD', 15.00, 'completed', '2025-03-05 07:54:51'),
(23, 'ORD_1741160857_3532', NULL, 'COD', 15.00, 'completed', '2025-03-05 07:55:02'),
(24, 'ORD_1741160857_3532', NULL, 'COD', 15.00, 'completed', '2025-03-05 07:55:05'),
(25, 'ORD_1741160857_3532', NULL, 'COD', 15.00, 'completed', '2025-03-05 07:55:10'),
(26, 'ORD_1741160857_3532', NULL, 'COD', 15.00, 'completed', '2025-03-05 08:01:01'),
(27, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:01:33'),
(28, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:11:50'),
(29, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:14:32'),
(30, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:14:35'),
(31, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:15:54'),
(32, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:15:58'),
(33, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:16:57'),
(34, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:17:39'),
(35, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:18:18'),
(36, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:19:19'),
(37, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:21:21'),
(38, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:21:44'),
(39, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:25:12'),
(40, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:32:57'),
(41, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:33:54'),
(42, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:34:17'),
(43, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:34:30'),
(44, 'ORD_1741161670_1696', NULL, 'Cash on Delivery', 29.00, 'completed', '2025-03-05 08:36:20'),
(45, 'ORD_1741190869_9367', NULL, 'Cash on Delivery', 414.00, 'completed', '2025-03-05 16:19:30'),
(46, 'ORD_1741190869_9367', NULL, 'Cash on Delivery', 414.00, 'completed', '2025-03-05 16:20:08'),
(47, 'ORD_1741190869_9367', NULL, 'Cash on Delivery', 414.00, 'completed', '2025-03-05 16:20:33'),
(48, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 16:21:44'),
(49, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 16:21:46'),
(50, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 16:21:47'),
(51, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 16:21:55'),
(52, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 16:23:50'),
(53, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 16:24:03'),
(54, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 16:28:07'),
(55, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 16:28:23'),
(56, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 16:44:56'),
(57, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 16:46:35'),
(58, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 17:02:07'),
(59, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 17:05:49'),
(60, 'ORD_1741190869_9367', NULL, 'COD', 414.00, 'completed', '2025-03-05 17:12:39'),
(61, 'ORD_1741413015_6691', NULL, 'Cash on Delivery', 664.00, 'completed', '2025-03-08 05:54:36'),
(62, 'ORD_1741413015_6691', NULL, 'Cash on Delivery', 664.00, 'completed', '2025-03-08 05:58:36'),
(63, 'ORD_1741413015_6691', NULL, 'Cash on Delivery', 664.00, 'completed', '2025-03-08 05:59:12'),
(64, 'ORD_1741414029_6595', NULL, 'Cash on Delivery', 650.00, 'completed', '2025-03-08 06:07:22'),
(65, 'ORD_1741414029_6595', NULL, 'Cash on Delivery', 650.00, 'completed', '2025-03-08 06:07:47'),
(66, 'ORD_1741414029_6595', NULL, 'Cash on Delivery', 650.00, 'completed', '2025-03-08 06:08:03'),
(67, 'ORD_1741414029_6595', NULL, 'Cash on Delivery', 650.00, 'completed', '2025-03-08 06:08:40'),
(68, 'ORD_1741414029_6595', NULL, 'Cash on Delivery', 650.00, 'completed', '2025-03-08 06:11:34'),
(69, 'ORD_1741414029_6595', NULL, 'Cash on Delivery', 650.00, 'completed', '2025-03-08 06:12:52'),
(70, 'ORD_1741414029_6595', NULL, 'Cash on Delivery', 650.00, 'completed', '2025-03-08 06:14:15'),
(71, 'ORD_1741414029_6595', NULL, 'Cash on Delivery', 650.00, 'completed', '2025-03-08 06:16:28'),
(72, 'ORD_1741414605_1378', NULL, 'Cash on Delivery', 400.00, 'completed', '2025-03-08 06:16:58'),
(73, 'ORD_1741414605_1378', NULL, 'Cash on Delivery', 400.00, 'completed', '2025-03-08 06:17:04'),
(74, 'ORD_1741414853_2903', NULL, 'Cash on Delivery', 700.00, 'completed', '2025-03-08 06:21:12'),
(75, 'ORD_1741414853_2903', NULL, 'Cash on Delivery', 700.00, 'completed', '2025-03-08 06:24:24'),
(76, 'ORD_1741414853_2903', NULL, 'Cash on Delivery', 700.00, 'completed', '2025-03-08 06:28:23'),
(77, 'ORD_1741414853_2903', NULL, 'Cash on Delivery', 700.00, 'completed', '2025-03-08 06:29:46'),
(78, 'ORD_1741414853_2903', NULL, 'Cash on Delivery', 700.00, 'completed', '2025-03-08 06:30:20'),
(79, 'ORD_1741414853_2903', NULL, 'Cash on Delivery', 700.00, 'completed', '2025-03-08 06:31:04'),
(80, 'ORD_1741414853_2903', NULL, 'Cash on Delivery', 700.00, 'completed', '2025-03-08 06:35:13'),
(81, 'ORD_1741414853_2903', NULL, 'Cash on Delivery', 700.00, 'completed', '2025-03-08 06:35:19'),
(82, 'ORD_1741414853_2903', NULL, 'Cash on Delivery', 700.00, 'completed', '2025-03-08 06:37:01'),
(83, 'ORD_1741415832_2159', 'IB_67cbe5a371b2c', 'Internet Banking', 700.00, 'completed', '2025-03-08 06:37:35'),
(84, 'ORD_1741415832_2159', 'IB_67cbe5a371b2c', 'Internet Banking', 700.00, 'completed', '2025-03-08 06:45:35'),
(85, 'ORD_1741416347_1443', 'IB_67cbe7a515688', 'Internet Banking', 300.00, 'completed', '2025-03-08 06:46:17'),
(86, 'ORD_1741416347_1443', 'IB_67cbe7a515688', 'Internet Banking', 300.00, 'completed', '2025-03-08 06:46:22'),
(87, 'ORD_1741416569_3221', NULL, 'Cash on Delivery', 300.00, 'completed', '2025-03-08 06:49:57'),
(88, 'ORD_1741416569_3221', NULL, 'Cash on Delivery', 300.00, 'completed', '2025-03-08 06:51:29'),
(89, 'ORD_1741416712_1954', NULL, 'Cash on Delivery', 800.00, 'completed', '2025-03-08 06:52:10'),
(90, 'ORD_1741416712_1954', NULL, 'Cash on Delivery', 800.00, 'completed', '2025-03-08 06:52:35'),
(91, 'ORD_1741416712_1954', NULL, 'Cash on Delivery', 800.00, 'completed', '2025-03-08 06:55:59'),
(92, 'ORD_1741416712_1954', NULL, 'Cash on Delivery', 800.00, 'completed', '2025-03-08 06:57:33'),
(93, 'ORD_1741416712_1954', NULL, 'Cash on Delivery', 800.00, 'completed', '2025-03-08 07:00:14'),
(94, 'ORD_1741416712_1954', NULL, 'Cash on Delivery', 800.00, 'completed', '2025-03-08 07:01:13'),
(95, 'ORD_1741417286_1889', NULL, 'Cash on Delivery', 500.00, 'completed', '2025-03-08 07:01:39'),
(96, 'ORD_1741417286_1889', NULL, 'Cash on Delivery', 500.00, 'completed', '2025-03-08 07:03:19'),
(97, 'ORD_1741417286_1889', NULL, 'Cash on Delivery', 500.00, 'completed', '2025-03-08 07:03:35'),
(98, 'ORD_1741417286_1889', NULL, 'Cash on Delivery', 500.00, 'completed', '2025-03-08 07:04:00'),
(99, 'ORD_1741418098_9121', NULL, 'Cash on Delivery', 1700.00, 'completed', '2025-03-08 07:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(225) DEFAULT NULL,
  `price` int DEFAULT NULL,
  `image` varchar(25) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `price`, `image`) VALUES
(1, 'Arabica Beans', 200, 'product-1.jpg'),
(2, 'Espresso Blend', 500, 'product-2.jpg'),
(3, 'Colombian Roast', 250, 'product-3.jpg'),
(4, 'French Roast', 100, 'product-4.jpg'),
(5, 'Decaf Coffee', 300, 'product-5.jpg'),
(6, 'Mocha Blend', 550, 'product-6.jpg'),
(7, 'Caramel Latte', 400, 'product-7.jpg'),
(8, 'Hazelnut Coffee', 150, 'product-8.jpg'),
(9, 'Hot coffee', 425, 'uploads/product-10.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category`) VALUES
(1, 'abcs', 32.00, 'product-13.jpg', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `User_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`User_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `username`, `email`, `password`, `phone`) VALUES
(1, 'prem', '', 'prem', '1222'),
(2, 'abc', '', '$2y$10$TWrQnfPGTZQDIyk2prvscO9t2yyCBpVqBn6Fz1ObFzw.', '1122'),
(3, 'hnbca', '', '$2y$10$Mf1hVHOCrWMsvOKCh.7Z3ezQujeF93HU1JwjdLdadhE...', '11223'),
(4, 'hemant', '', '1234', '7447889909'),
(5, 'om', '', 'om12', '6576890907'),
(6, 'Abhi', 'Abhi@gmail.com', '$2y$10$hdGk0k7Hx8lpsKzTSftk/.Rtye634eMMwI6dmwYMfc0I6TIP1RrkS', '7822908754');

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

DROP TABLE IF EXISTS `usertable`;
CREATE TABLE IF NOT EXISTS `usertable` (
  `User_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  PRIMARY KEY (`User_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`User_id`, `user_name`, `email`, `password`, `phone_no`) VALUES
(1, 'hncc', 'hncc@gmail.com', '$2y$10$3bbGVPSlyYsbM89OZn/mt.WJ11daCC7GesOD0ilBtphC8SL5Uk1Yq', '12345'),
(2, 'hnbca', 'hnbca@gmail.com', '$2y$10$Mf1hVHOCrWMsvOKCh.7Z3ezQujeF93HU1JwjdLdadhEuWaEFqLLUu', '11223'),
(3, 'Jogi', 'jogi@gmail.com', 'jogi123', '8407885478'),
(4, 'abc', 'abc@gmail.com', '$2y$10$TWrQnfPGTZQDIyk2prvscO9t2yyCBpVqBn6Fz1ObFzwQIRDJuUuOG', '1122'),
(5, 'prem', 'prem@gmail.com', '$2y$10$zfjkjmpK015ToFcUIW.3FO0.AogudvE8yF15xW94X94Eidfhzuany', '1222'),
(6, 'hemant', 'hemant@gmail.com', '$2y$10$hfj.7cpS5fXoMqLZPm5H6uC00jDPgfnPKKErbpSs607Hp/tlA7DxO', '7447889909'),
(7, 'om', 'om@gmail.com', '$2y$10$JpQIzjEuV5hdyNYp.7azVuKzfq61KqKQ98h1UUCz0e/mwWXSmuTP2', '6576890907'),
(8, 'Vaidehi Chanmal', 'vaidehi@gmail.com', '3010', '8898764567');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
