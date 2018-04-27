-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2018 at 03:06 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prod_report`
--

-- --------------------------------------------------------

--
-- Table structure for table `action`
--

CREATE TABLE `action` (
  `id` int(11) NOT NULL,
  `controller_id` varchar(50) NOT NULL,
  `action_id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `action`
--

INSERT INTO `action` (`id`, `controller_id`, `action_id`, `name`) VALUES
(12, 'site', 'index', 'Index'),
(13, 'site', 'profile', 'Profile'),
(14, 'site', 'login', 'Login'),
(15, 'site', 'logout', 'Logout'),
(16, 'site', 'contact', 'Contact'),
(17, 'site', 'about', 'About'),
(18, 'menu', 'index', 'Index'),
(19, 'menu', 'view', 'View'),
(20, 'menu', 'create', 'Create'),
(21, 'menu', 'update', 'Update'),
(22, 'menu', 'delete', 'Delete'),
(23, 'role', 'index', 'Index'),
(24, 'role', 'view', 'View'),
(25, 'role', 'create', 'Create'),
(26, 'role', 'update', 'Update'),
(27, 'role', 'delete', 'Delete'),
(28, 'role', 'detail', 'Detail'),
(29, 'user', 'index', 'Index'),
(30, 'user', 'view', 'View'),
(31, 'user', 'create', 'Create'),
(32, 'user', 'update', 'Update'),
(33, 'user', 'delete', 'Delete'),
(34, 'site', 'register', 'Register'),
(35, 'job-order', 'index', 'Index'),
(36, 'job-order', 'view', 'View'),
(37, 'job-order', 'create', 'Create'),
(38, 'job-order', 'update', 'Update'),
(39, 'job-order', 'delete', 'Delete'),
(40, 'job-order', 'index2', 'Index2'),
(41, 'job-order', 'index-report', 'Index Report'),
(42, 'job-order-report', 'index', 'Index'),
(43, 'job-order-report', 'view', 'View'),
(44, 'job-order-report', 'create', 'Create'),
(45, 'job-order-report', 'update', 'Update'),
(46, 'job-order-report', 'delete', 'Delete'),
(47, 'shipping', 'index', 'Index'),
(48, 'shipping', 'index-copy', 'Index Copy');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL DEFAULT 'index',
  `icon` varchar(50) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `controller`, `action`, `icon`, `order`, `parent_id`) VALUES
(1, 'Home', 'site', 'index', 'home', 1, NULL),
(2, 'Master', '', 'index', 'database', 2, NULL),
(3, 'Menu', 'menu', 'index', 'circle-o', 3, 2),
(4, 'Role', 'role', 'index', 'circle-o', 4, 2),
(5, 'User', 'user', 'index', 'circle-o', 5, 2),
(6, 'Report', '', 'index', 'bar-chart', 6, NULL),
(8, 'SMT Report', 'job-order-report', 'index', 'circle-o', 7, 6),
(9, 'SMT Data Table', 'job-order', 'index', 'circle-o', 8, 2),
(10, 'Shipping Report', 'shipping', 'index', 'circle-o', 9, 6);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Super Administrator'),
(2, 'Administrator'),
(3, 'Regular User'),
(4, 'SMT');

-- --------------------------------------------------------

--
-- Table structure for table `role_action`
--

CREATE TABLE `role_action` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_action`
--

INSERT INTO `role_action` (`id`, `role_id`, `action_id`) VALUES
(33, 2, 12),
(34, 2, 13),
(35, 2, 14),
(36, 2, 15),
(37, 2, 16),
(38, 2, 17),
(39, 2, 18),
(40, 2, 19),
(41, 2, 20),
(42, 2, 21),
(43, 2, 22),
(44, 2, 23),
(45, 2, 24),
(46, 2, 25),
(47, 2, 26),
(48, 2, 27),
(49, 2, 28),
(50, 2, 29),
(51, 2, 30),
(52, 2, 31),
(53, 2, 32),
(54, 2, 33),
(98, 3, 12),
(99, 3, 13),
(100, 3, 14),
(101, 3, 15),
(102, 3, 16),
(103, 3, 17),
(104, 3, 18),
(105, 3, 19),
(106, 3, 20),
(107, 3, 21),
(108, 3, 22),
(109, 3, 23),
(110, 3, 24),
(111, 3, 25),
(112, 3, 26),
(113, 3, 27),
(114, 3, 28),
(115, 3, 29),
(116, 3, 30),
(117, 3, 31),
(118, 3, 32),
(119, 3, 33),
(142, 4, 35),
(325, 1, 12),
(326, 1, 13),
(327, 1, 14),
(328, 1, 15),
(329, 1, 17),
(330, 1, 18),
(331, 1, 19),
(332, 1, 20),
(333, 1, 21),
(334, 1, 22),
(335, 1, 23),
(336, 1, 24),
(337, 1, 25),
(338, 1, 26),
(339, 1, 27),
(340, 1, 28),
(341, 1, 29),
(342, 1, 30),
(343, 1, 31),
(344, 1, 32),
(345, 1, 33),
(346, 1, 35),
(347, 1, 36),
(348, 1, 37),
(349, 1, 38),
(350, 1, 39),
(351, 1, 42),
(352, 1, 47);

-- --------------------------------------------------------

--
-- Table structure for table `role_menu`
--

CREATE TABLE `role_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_menu`
--

INSERT INTO `role_menu` (`id`, `role_id`, `menu_id`) VALUES
(56, 2, 1),
(57, 2, 2),
(58, 2, 3),
(59, 2, 4),
(60, 2, 5),
(71, 3, 1),
(72, 3, 2),
(73, 3, 3),
(74, 3, 4),
(75, 3, 5),
(82, 4, 6),
(133, 1, 1),
(134, 1, 2),
(135, 1, 3),
(136, 1, 4),
(137, 1, 5),
(138, 1, 9),
(139, 1, 6),
(140, 1, 8),
(141, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tp_part_list`
--

CREATE TABLE `tp_part_list` (
  `tp_part_list_id` int(11) NOT NULL,
  `speaker_model` varchar(50) DEFAULT NULL,
  `part_no` varchar(20) DEFAULT NULL,
  `part_name` varchar(200) DEFAULT NULL,
  `rev_no` int(11) DEFAULT '0',
  `total_product` double DEFAULT '0',
  `total_assy` double DEFAULT '0',
  `total_spare_part` double DEFAULT '0',
  `total_requirement` double DEFAULT '0',
  `pc_remarks` varchar(100) DEFAULT NULL,
  `present_po` varchar(50) DEFAULT NULL,
  `present_due_date` date DEFAULT NULL,
  `present_qty` double DEFAULT '0',
  `dcn_no` varchar(50) DEFAULT NULL,
  `part_type` varchar(20) DEFAULT NULL,
  `part_status` varchar(20) DEFAULT NULL,
  `caf_no` varchar(20) DEFAULT NULL,
  `direct_po_trf` varchar(50) DEFAULT NULL,
  `purch_status` varchar(20) DEFAULT NULL,
  `pc_status` varchar(20) DEFAULT NULL,
  `delivery_conf_etd` varchar(50) DEFAULT NULL,
  `delivery_conf_eta` varchar(50) DEFAULT NULL,
  `act_delivery_etd` varchar(50) DEFAULT NULL,
  `act_delivery_eta` varchar(50) DEFAULT NULL,
  `invoice` varchar(30) DEFAULT NULL,
  `qty` double DEFAULT '0',
  `transport_by` varchar(50) DEFAULT NULL,
  `transportation_cost` double DEFAULT '0',
  `pe_confirm` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `qa_judgement` varchar(20) DEFAULT NULL,
  `qa_remark` varchar(20) DEFAULT NULL,
  `last_modified` date DEFAULT NULL,
  `last_modified_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `role_id`, `photo_url`, `last_login`, `last_logout`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 1, 'ID6jM8Az7Yh_R6LR44Ezh02VECKTQ_Ya.png', '2018-04-26 15:15:44', '2018-03-21 08:06:41'),
(2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'Regular User', 3, 'default.png', NULL, NULL),
(3, 'smt', 'd8cc653b02f7897915cdd2ee65540ac0', 'SMT', 4, 'default.png', '2018-03-14 16:07:55', '2018-03-13 14:38:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_action`
--
ALTER TABLE `role_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `action_id` (`action_id`);

--
-- Indexes for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `tp_part_list`
--
ALTER TABLE `tp_part_list`
  ADD PRIMARY KEY (`tp_part_list_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action`
--
ALTER TABLE `action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_action`
--
ALTER TABLE `role_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=353;

--
-- AUTO_INCREMENT for table `role_menu`
--
ALTER TABLE `role_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `tp_part_list`
--
ALTER TABLE `tp_part_list`
  MODIFY `tp_part_list_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menu` (`id`);

--
-- Constraints for table `role_action`
--
ALTER TABLE `role_action`
  ADD CONSTRAINT `role_action_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `role_action_ibfk_2` FOREIGN KEY (`action_id`) REFERENCES `action` (`id`);

--
-- Constraints for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD CONSTRAINT `role_menu_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `role_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
