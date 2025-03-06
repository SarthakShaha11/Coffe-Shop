-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 06, 2025 at 05:40 PM
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
(3, 'jogi', 'jogi@gmail.com', '$2y$10$w8YL92w7dKPhfoBruhNz4.xJ8T8nt9cge4gyazIRfpkWucWizbjRi', '1233'),
(4, 'abc', 'abc@gmail.com', '$2y$10$TWrQnfPGTZQDIyk2prvscO9t2yyCBpVqBn6Fz1ObFzwQIRDJuUuOG', '1122'),
(5, 'prem', 'prem@gmail.com', '$2y$10$zfjkjmpK015ToFcUIW.3FO0.AogudvE8yF15xW94X94Eidfhzuany', '1222'),
(6, 'hemant', 'hemant@gmail.com', '$2y$10$hfj.7cpS5fXoMqLZPm5H6uC00jDPgfnPKKErbpSs607Hp/tlA7DxO', '7447889909'),
(7, 'om', 'om@gmail.com', '$2y$10$JpQIzjEuV5hdyNYp.7azVuKzfq61KqKQ98h1UUCz0e/mwWXSmuTP2', '6576890907'),
(8, 'Vaidehi Chanmal', 'vaidehi@gmail.com', '3010', '8898764567');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
