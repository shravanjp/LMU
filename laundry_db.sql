-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2022 at 05:21 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(30) NOT NULL,
  `supply_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `available` int(20) NOT NULL,
  `stock_type` tinyint(1) NOT NULL COMMENT '1= in , 2 = used',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `supply_id`, `qty`, `available`, `stock_type`, `date_created`) VALUES
(34, 9, 80, 80, 1, '2022-01-16 09:57:36'),
(35, 10, 5, 5, 1, '2022-01-17 22:18:05'),
(39, 3, 30, 30, 1, '2022-03-23 08:20:30');

-- --------------------------------------------------------

--
-- Table structure for table `laundry_categories`
--

CREATE TABLE `laundry_categories` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laundry_categories`
--

INSERT INTO `laundry_categories` (`id`, `name`, `price`) VALUES
(1, 'DryClean', 30),
(3, 'wash', 50),
(7, 'Ironing', 25);

-- --------------------------------------------------------

--
-- Table structure for table `laundry_items`
--

CREATE TABLE `laundry_items` (
  `id` int(30) NOT NULL,
  `laundry_category_id` int(30) NOT NULL,
  `weight` double NOT NULL,
  `laundry_id` int(30) NOT NULL,
  `unit_price` double NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laundry_items`
--

INSERT INTO `laundry_items` (`id`, `laundry_category_id`, `weight`, `laundry_id`, `unit_price`, `amount`) VALUES
(99, 3, 4, 63, 50, 200),
(100, 1, 3, 63, 30, 90),
(101, 1, 9, 64, 30, 270),
(102, 3, 7, 65, 50, 350),
(103, 7, 6, 65, 25, 150),
(104, 3, 5, 66, 50, 250);

-- --------------------------------------------------------

--
-- Table structure for table `laundry_list`
--

CREATE TABLE `laundry_list` (
  `id` int(30) NOT NULL,
  `customer_name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1 = ongoing,2= ready,3= claimed',
  `queue` int(30) NOT NULL,
  `total_amount` double NOT NULL,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laundry_list`
--

INSERT INTO `laundry_list` (`id`, `customer_name`, `status`, `queue`, `total_amount`, `remarks`, `date_created`) VALUES
(63, 'Ganesh', 0, 1, 290, 'Expected Date: 30/03/2022', '2022-03-23 11:38:00'),
(64, 'Yashodar', 0, 2, 270, 'Expected date:01/04/2022', '2022-03-23 11:38:31'),
(65, 'Suresh', 0, 3, 500, '', '2022-03-23 11:39:27'),
(66, 'yash', 0, 4, 250, '', '2022-03-23 21:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `supply_list`
--

CREATE TABLE `supply_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supply_list`
--

INSERT INTO `supply_list` (`id`, `name`) VALUES
(3, 'Baking  Soda'),
(9, 'Fabric Conditioner'),
(10, 'Vanish');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=admin , 2 = staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'Administrator', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 1),
(7, 'SJP', 'shravanjp@gmail.com', '778a7600c2c3bf7a43fb762d2181271e', 1),
(55, 'staff2', 'staff2@gmail.com', '8bc01711b8163ec3f2aa0688d12cdf3b', 2),
(90, 'Administrator2', 'admin2@gmail.com', '885ee4b6ee92fc9aba945f2641fa3eca', 1),
(129, 'Buvan', 'buvan@gmail.com', 'c3af5c91fca33f4b546ae86f36d77340', 2),
(134, 'happy', 'happy@gmail.com', 'fbaae9f62be52af338e3c928ea198afc', 2),
(136, 'staff3', 'staff3@gmail.com', '8f03660f569ce4023dddaea0bf560d74', 2),
(137, 'LAB', 'lab@gmail.com', 'b1573c5480370a346507915f15ee346c', 1),
(141, 'test2', 'test2@gmail.com', '4ff9018a647ae315a7e6601a818b4940', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supply_id` (`supply_id`);

--
-- Indexes for table `laundry_categories`
--
ALTER TABLE `laundry_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laundry_items`
--
ALTER TABLE `laundry_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laundry_category_id` (`laundry_category_id`),
  ADD KEY `laundry_id` (`laundry_id`);

--
-- Indexes for table `laundry_list`
--
ALTER TABLE `laundry_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supply_list`
--
ALTER TABLE `supply_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `laundry_categories`
--
ALTER TABLE `laundry_categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `laundry_items`
--
ALTER TABLE `laundry_items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `laundry_list`
--
ALTER TABLE `laundry_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `supply_list`
--
ALTER TABLE `supply_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`supply_id`) REFERENCES `supply_list` (`id`);

--
-- Constraints for table `laundry_items`
--
ALTER TABLE `laundry_items`
  ADD CONSTRAINT `laundry_items_ibfk_1` FOREIGN KEY (`laundry_category_id`) REFERENCES `laundry_categories` (`id`),
  ADD CONSTRAINT `laundry_items_ibfk_2` FOREIGN KEY (`laundry_id`) REFERENCES `laundry_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
