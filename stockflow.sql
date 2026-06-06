-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2026 at 06:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`) VALUES
('ADM10', 'Sami', 'fghj@gmail.com'),
('ADM9', 'Tanvir', 'ghj@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
('CAT10', 'Electronics', ''),
('CAT11', 'Grocery', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT '',
  `phone_opt` varchar(20) DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `address` text DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `phone`, `phone_opt`, `email`, `address`) VALUES
('C7', 'Walk-in Customer', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `id_sequence`
--

CREATE TABLE `id_sequence` (
  `prefix` varchar(10) NOT NULL,
  `nextval` int(11) NOT NULL DEFAULT 1001
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `id_sequence`
--

INSERT INTO `id_sequence` (`prefix`, `nextval`) VALUES
('ADM', 10),
('C', 7),
('CAT', 11),
('INV', 1),
('P', 18),
('PUR', 12),
('SALE', 10),
('SUP', 14);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `quantity_in` int(11) NOT NULL DEFAULT 0,
  `quantity_out` int(11) NOT NULL DEFAULT 0,
  `last_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `quantity_in`, `quantity_out`, `last_updated`) VALUES
(18, 'P17', 10, 0, '2026-06-06'),
(19, 'P17', 0, 2, '2026-06-06'),
(20, 'P18', 20, 0, '2026-06-06');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` varchar(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT '',
  `category_id` varchar(20) NOT NULL,
  `unit` varchar(20) DEFAULT 'pcs',
  `purchase_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `selling_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `stock_quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `category_id`, `unit`, `purchase_price`, `selling_price`, `stock_quantity`) VALUES
('P17', 'Mouse', '', 'CAT10', '0', 10.00, 15.00, 8),
('P18', 'Oil', 'Good quality oil', 'CAT11', 'pcs', 12.00, 14.00, 20);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` varchar(20) NOT NULL,
  `supplier_id` varchar(20) NOT NULL,
  `admin_id` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_type` enum('fixed','percent') NOT NULL DEFAULT 'fixed',
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping_charge` decimal(12,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(5,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `supplier_id`, `admin_id`, `date`, `subtotal`, `discount_type`, `discount_amount`, `shipping_charge`, `vat`, `total`) VALUES
('PUR11', 'SUP13', 'ADM10', '2026-06-06', 100.00, 'fixed', 0.00, 0.00, 0.00, 100.00),
('PUR12', 'SUP14', 'ADM10', '2026-06-06', 240.00, 'fixed', 0.00, 0.00, 0.00, 240.00);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item`
--

CREATE TABLE `purchase_item` (
  `id` int(11) NOT NULL,
  `purchase_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(20) DEFAULT 'pcs',
  `price` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_item`
--

INSERT INTO `purchase_item` (`id`, `purchase_id`, `product_id`, `quantity`, `unit`, `price`, `total`) VALUES
(10, 'PUR11', 'P17', 10, 'pcs', 10.00, 100.00),
(11, 'PUR12', 'P18', 20, 'pcs', 12.00, 240.00);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `id` varchar(20) NOT NULL,
  `customer_id` varchar(20) NOT NULL,
  `admin_id` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_type` enum('fixed','percent') NOT NULL DEFAULT 'fixed',
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(5,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `customer_id`, `admin_id`, `date`, `subtotal`, `discount_type`, `discount_amount`, `vat`, `total`) VALUES
('SALE10', 'C7', 'ADM10', '2026-06-06', 30.00, 'fixed', 0.00, 0.00, 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `sale_item`
--

CREATE TABLE `sale_item` (
  `id` int(11) NOT NULL,
  `sale_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_item`
--

INSERT INTO `sale_item` (`id`, `sale_id`, `product_id`, `quantity`, `price`, `total`) VALUES
(9, 'SALE10', 'P17', 2, 15.00, 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `phone_opt` varchar(20) DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `address` text DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `phone`, `phone_opt`, `email`, `address`) VALUES
('SUP13', 'Modern Electronics', '45678', '', 'fghjk@gmail.com', 'Sylhet'),
('SUP14', 'Tanim Grocery', '746532', '', 'iuyf@gmail.com', 'Sylhet');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_product`
--

CREATE TABLE `supplier_product` (
  `supplier_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `cost_price` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_product`
--

INSERT INTO `supplier_product` (`supplier_id`, `product_id`, `cost_price`) VALUES
('SUP13', 'P17', 10.00),
('SUP14', 'P18', 10.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `id_sequence`
--
ALTER TABLE `id_sequence`
  ADD PRIMARY KEY (`prefix`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_ibfk_1` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ibfk_1` (`category_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_ibfk_2` (`admin_id`),
  ADD KEY `purchase_ibfk_1` (`supplier_id`);

--
-- Indexes for table `purchase_item`
--
ALTER TABLE `purchase_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `purchase_item_ibfk_2` (`product_id`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_ibfk_2` (`admin_id`),
  ADD KEY `sale_ibfk_1` (`customer_id`);

--
-- Indexes for table `sale_item`
--
ALTER TABLE `sale_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `sale_item_ibfk_2` (`product_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_product`
--
ALTER TABLE `supplier_product`
  ADD PRIMARY KEY (`supplier_id`,`product_id`),
  ADD KEY `supplier_product_ibfk_2` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `purchase_item`
--
ALTER TABLE `purchase_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sale_item`
--
ALTER TABLE `sale_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_item`
--
ALTER TABLE `purchase_item`
  ADD CONSTRAINT `purchase_item_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `sale_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_item`
--
ALTER TABLE `sale_item`
  ADD CONSTRAINT `sale_item_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier_product`
--
ALTER TABLE `supplier_product`
  ADD CONSTRAINT `supplier_product_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
