-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 04, 2025 at 06:41 AM
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
-- Table structure for table `cancelation`
--

DROP TABLE IF EXISTS `cancelation`;
CREATE TABLE IF NOT EXISTS `cancelation` (
  `cancelation_id` int NOT NULL,
  `Order_id` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  PRIMARY KEY (`cancelation_id`),
  KEY `fk_cancel_order` (`Order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(1, 'Arabica Beans', 16.00, 1, '2025-03-04 05:45:13'),
(2, 'Espresso Blend', 13.00, 2, '2025-03-04 05:47:47');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `Order_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`Order_id`),
  KEY `fk_product` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Order_id`, `product_id`, `price`, `quantity`) VALUES
(1, 1, 16, 0),
(2, 1, 16, 0),
(3, 2, 13, 0),
(4, 2, 13, 0),
(5, 3, 15, 0),
(6, 2, 13, 0),
(7, 1, 16, 0),
(8, 2, 13, 0),
(9, 2, 13, 0),
(10, 3, 15, 0),
(11, 2, 13, 0),
(12, 1, 16, 0),
(13, 2, 13, 0),
(14, 2, 13, 0),
(15, 3, 15, 0),
(16, 2, 13, 0),
(17, 1, 16, 0),
(18, 2, 13, 0),
(19, 2, 13, 0),
(20, 3, 15, 0),
(21, 2, 13, 0),
(22, 1, 16, 0),
(23, 2, 13, 0),
(24, 2, 13, 0),
(25, 3, 15, 0),
(26, 2, 13, 0),
(27, 1, 16, 0),
(28, 2, 13, 0),
(29, 2, 13, 0),
(30, 3, 15, 0),
(31, 2, 13, 0),
(32, 1, 16, 0),
(33, 2, 13, 0),
(34, 2, 13, 0),
(35, 3, 15, 0),
(36, 2, 13, 0),
(37, 1, 16, 0),
(38, 2, 13, 0),
(39, 2, 13, 0),
(40, 3, 15, 0),
(41, 2, 13, 0),
(42, 1, 16, 0),
(43, 2, 13, 0),
(44, 2, 13, 0),
(45, 3, 15, 0),
(46, 2, 13, 0),
(47, 1, 16, 0),
(48, 2, 13, 0),
(49, 2, 13, 0),
(50, 3, 15, 0),
(51, 2, 13, 0),
(52, 1, 16, 0),
(53, 2, 13, 0),
(54, 2, 13, 0),
(55, 3, 15, 0),
(56, 2, 13, 0),
(57, 1, 16, 0),
(58, 2, 13, 0),
(59, 2, 13, 0),
(60, 3, 15, 0),
(61, 2, 13, 0),
(62, 1, 16, 0),
(63, 2, 13, 0),
(64, 2, 13, 0),
(65, 3, 15, 0),
(66, 2, 13, 0),
(67, 1, 16, 0),
(68, 2, 13, 0),
(69, 2, 13, 0),
(70, 3, 15, 0),
(71, 2, 13, 0),
(72, 1, 16, 0),
(73, 2, 13, 0),
(74, 2, 13, 0),
(75, 3, 15, 0),
(76, 2, 13, 0),
(77, 1, 16, 0),
(78, 2, 13, 0),
(79, 2, 13, 0),
(80, 3, 15, 0),
(81, 2, 13, 0),
(82, 1, 16, 0),
(83, 2, 13, 0),
(84, 2, 13, 0),
(85, 3, 15, 0),
(86, 2, 13, 0),
(87, 1, 16, 0),
(88, 2, 13, 0),
(89, 2, 13, 0),
(90, 3, 15, 0),
(91, 2, 13, 0),
(92, 1, 16, 0),
(93, 2, 13, 0),
(94, 2, 13, 0),
(95, 3, 15, 0),
(96, 2, 13, 0),
(97, 1, 16, 0),
(98, 2, 13, 0),
(99, 2, 13, 0),
(100, 3, 15, 0),
(101, 2, 13, 0),
(102, 1, 16, 0),
(103, 2, 13, 0),
(104, 2, 13, 0),
(105, 3, 15, 0),
(106, 2, 13, 0),
(107, 1, 16, 0),
(108, 2, 13, 0),
(109, 2, 13, 0),
(110, 3, 15, 0),
(111, 2, 13, 0),
(112, 1, 16, 0),
(113, 2, 13, 0),
(114, 2, 13, 0),
(115, 3, 15, 0),
(116, 2, 13, 0),
(117, 1, 16, 0),
(118, 2, 13, 0),
(119, 2, 13, 0),
(120, 3, 15, 0),
(121, 2, 13, 0),
(122, 1, 16, 0),
(123, 2, 13, 0),
(124, 2, 13, 0),
(125, 3, 15, 0),
(126, 2, 13, 0),
(127, 1, 16, 0),
(128, 2, 13, 0),
(129, 2, 13, 0),
(130, 3, 15, 0),
(131, 2, 13, 0),
(132, 1, 16, 0),
(133, 2, 13, 0),
(134, 2, 13, 0),
(135, 3, 15, 0),
(136, 2, 13, 0),
(137, 1, 16, 0),
(138, 2, 13, 0),
(139, 2, 13, 0),
(140, 3, 15, 0),
(141, 2, 13, 0),
(142, 1, 16, 0),
(143, 2, 13, 0),
(144, 2, 13, 0),
(145, 3, 15, 0),
(146, 2, 13, 0),
(147, 1, 16, 0),
(148, 2, 13, 0),
(149, 2, 13, 0),
(150, 3, 15, 0),
(151, 2, 13, 0),
(152, 1, 16, 0),
(153, 2, 13, 0),
(154, 2, 13, 0),
(155, 3, 15, 0),
(156, 2, 13, 0),
(157, 1, 16, 0),
(158, 2, 13, 0),
(159, 2, 13, 0),
(160, 3, 15, 0),
(161, 2, 13, 0),
(162, 1, 16, 0),
(163, 2, 13, 0),
(164, 2, 13, 0),
(165, 3, 15, 0),
(166, 2, 13, 0),
(167, 1, 16, 0),
(168, 2, 13, 0),
(169, 2, 13, 0),
(170, 3, 15, 0),
(171, 2, 13, 0),
(172, 1, 16, 0),
(173, 2, 13, 0),
(174, 2, 13, 0),
(175, 3, 15, 0),
(176, 2, 13, 0),
(177, 1, 16, 0),
(178, 2, 13, 0),
(179, 2, 13, 0),
(180, 3, 15, 0),
(181, 2, 13, 0),
(182, 1, 16, 0),
(183, 2, 13, 0),
(184, 2, 13, 0),
(185, 3, 15, 0),
(186, 2, 13, 0),
(187, 1, 16, 0),
(188, 2, 13, 0),
(189, 2, 13, 0),
(190, 3, 15, 0),
(191, 2, 13, 0),
(192, 1, 16, 0),
(193, 2, 13, 0),
(194, 2, 13, 0),
(195, 3, 15, 0),
(196, 2, 13, 0),
(197, 1, 16, 0),
(198, 2, 13, 0),
(199, 2, 13, 0),
(200, 3, 15, 0),
(201, 2, 13, 0),
(202, 1, 16, 0),
(203, 2, 13, 0),
(204, 2, 13, 0),
(205, 3, 15, 0),
(206, 2, 13, 0),
(207, 1, 16, NULL),
(208, 2, 13, NULL),
(209, 2, 13, NULL),
(210, 3, 15, NULL),
(211, 2, 13, NULL),
(212, 1, 16, NULL),
(213, 2, 13, NULL),
(214, 2, 13, NULL),
(215, 3, 15, NULL),
(216, 2, 13, NULL),
(217, 1, 16, NULL),
(218, 2, 13, NULL),
(219, 2, 13, NULL),
(220, 3, 15, NULL),
(221, 2, 13, NULL),
(222, 1, 16, NULL),
(223, 2, 13, NULL),
(224, 2, 13, NULL),
(225, 3, 15, NULL),
(226, 2, 13, NULL),
(227, 1, 16, NULL),
(228, 2, 13, NULL),
(229, 2, 13, NULL),
(230, 3, 15, NULL),
(231, 2, 13, NULL),
(232, 1, 16, NULL),
(233, 2, 13, NULL),
(234, 2, 13, NULL),
(235, 3, 15, NULL),
(236, 2, 13, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `order_id`, `transaction_id`, `payment_method`, `price`, `payment_status`, `created_at`) VALUES
(1, '', 'WC_67c69fc54d2ad', 'Wallet/Cash Card', 0.00, 'completed', '2025-03-04 06:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `price` int DEFAULT NULL,
  `image` varchar(25) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `price`, `image`) VALUES
(1, 'Arabica Beans', 16, 'product-1.jpg'),
(2, 'Espresso Blend', 13, 'product-2.jpg'),
(3, 'Colombian Roast', 15, 'product-3.jpg'),
(4, 'French Roast', 14, 'product-4.jpg'),
(5, 'Decaf Coffee', 11, 'product-5.jpg'),
(6, 'Mocha Blend', 17, 'product-6.jpg'),
(7, 'Caramel Latte', 14, 'product-7.jpg'),
(8, 'Hazelnut Coffee', 14, 'product-8.jpg');

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `username`, `email`, `password`, `phone`) VALUES
(1, 'prem', '', 'prem', '1222'),
(2, 'abc', '', '$2y$10$TWrQnfPGTZQDIyk2prvscO9t2yyCBpVqBn6Fz1ObFzw.', '1122'),
(3, 'hnbca', '', '$2y$10$Mf1hVHOCrWMsvOKCh.7Z3ezQujeF93HU1JwjdLdadhE...', '11223'),
(4, 'hemant', '', '1234', '7447889909'),
(5, 'om', '', 'om12', '6576890907');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`User_id`, `user_name`, `email`, `password`, `phone_no`) VALUES
(1, 'hncc', 'hncc@gmail.com', '$2y$10$3bbGVPSlyYsbM89OZn/mt.WJ11daCC7GesOD0ilBtphC8SL5Uk1Yq', '12345'),
(2, 'hnbca', 'hnbca@gmail.com', '$2y$10$Mf1hVHOCrWMsvOKCh.7Z3ezQujeF93HU1JwjdLdadhEuWaEFqLLUu', '11223'),
(3, 'jogi', 'jogi@gmail.com', '$2y$10$w8YL92w7dKPhfoBruhNz4.xJ8T8nt9cge4gyazIRfpkWucWizbjRi', '1233'),
(4, 'abc', 'abc@gmail.com', '$2y$10$TWrQnfPGTZQDIyk2prvscO9t2yyCBpVqBn6Fz1ObFzwQIRDJuUuOG', '1122'),
(5, 'prem', 'prem@gmail.com', '$2y$10$zfjkjmpK015ToFcUIW.3FO0.AogudvE8yF15xW94X94Eidfhzuany', '1222'),
(6, 'hemant', 'hemant@gmail.com', '$2y$10$hfj.7cpS5fXoMqLZPm5H6uC00jDPgfnPKKErbpSs607Hp/tlA7DxO', '7447889909'),
(7, 'om', 'om@gmail.com', '$2y$10$JpQIzjEuV5hdyNYp.7azVuKzfq61KqKQ98h1UUCz0e/mwWXSmuTP2', '6576890907');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
