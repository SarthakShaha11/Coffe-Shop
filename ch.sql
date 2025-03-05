-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 17, 2025 at 07:36 AM
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
  `order_id` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  PRIMARY KEY (`cancelation_id`),
  KEY `fk_cancel_order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `transaction_id` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `fk_payment_order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `price` int DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `final_price` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`) VALUES
(1, 'prem', '', 'prem', '1222'),
(2, 'abc', '', '$2y$10$TWrQnfPGTZQDIyk2prvscO9t2yyCBpVqBn6Fz1ObFzw.', '1122'),
(3, 'hnbca', '', '$2y$10$Mf1hVHOCrWMsvOKCh.7Z3ezQujeF93HU1JwjdLdadhE...', '11223');

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

DROP TABLE IF EXISTS `usertable`;
CREATE TABLE IF NOT EXISTS `usertable` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`id`, `user_name`, `email`, `password`, `phone_no`) VALUES
(1, 'hncc', 'hncc@gmail.com', '$2y$10$3bbGVPSlyYsbM89OZn/mt.WJ11daCC7GesOD0ilBtphC8SL5Uk1Yq', '12345'),
(2, 'hnbca', 'hnbca@gmail.com', '$2y$10$Mf1hVHOCrWMsvOKCh.7Z3ezQujeF93HU1JwjdLdadhEuWaEFqLLUu', '11223'),
(3, 'jogi', 'jogi@gmail.com', '$2y$10$w8YL92w7dKPhfoBruhNz4.xJ8T8nt9cge4gyazIRfpkWucWizbjRi', '1233'),
(4, 'abc', 'abc@gmail.com', '$2y$10$TWrQnfPGTZQDIyk2prvscO9t2yyCBpVqBn6Fz1ObFzwQIRDJuUuOG', '1122'),
(5, 'prem', 'prem@gmail.com', '$2y$10$zfjkjmpK015ToFcUIW.3FO0.AogudvE8yF15xW94X94Eidfhzuany', '1222');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cancelation`
--
ALTER TABLE `cancelation`
  ADD CONSTRAINT `fk_cancel_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
