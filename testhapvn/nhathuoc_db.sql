-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2026 at 12:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nhathuoc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `slug`, `description`, `parent_id`, `created_at`) VALUES
(1, 'Thuốc kê đơn', 'thuoc-ke-don', NULL, NULL, '2026-01-11 03:20:36'),
(2, 'Thực phẩm chức năng', 'thuc-pham-chuc-nang', NULL, NULL, '2026-01-11 03:20:36');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `is_prescription` tinyint(1) DEFAULT 0,
  `unit` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `slug`, `meta_title`, `meta_description`, `price`, `stock_quantity`, `is_prescription`, `unit`, `description`, `image_url`, `created_at`) VALUES
(1, 1, 'Augmentin 625mg', '', '', '', 185000.00, 20, 0, 'Hộp', '', NULL, '2026-01-11 03:20:36'),
(2, 2, 'Omega-3 Fish Oil', 'dau-ca-omega-3-uc', 'Viên uống Dầu cá Omega-3 Úc 1000mg', 'Dầu cá tự nhiên hỗ trợ sức khỏe tim mạch và trí não. Hàng nhập khẩu chính ngạch.', 320000.00, 0, 0, 'Lọ', NULL, NULL, '2026-01-11 03:20:36'),
(4, 1, 'Berberin Mộc Hương', 'berberin-moc-huong-tieu-hoa', 'Viên uống Berberin Mộc Hương trị đau bụng, tiêu chảy', 'Sản phẩm kinh điển trị lỵ, tiêu chảy, đau bụng. Chiết xuất thảo dược an toàn.', 15000.00, 300, 0, 'Lọ', 'Người lớn uống 10-15 viên/lần, ngày 2 lần.', 'berberin.jpg', '2026-01-11 04:04:09'),
(5, 1, 'Klamentin 875/125', 'khang-sinh-klamentin-875-125', 'Thuốc kháng sinh Klamentin 1g (Hộp 14 viên)', 'Kháng sinh phối hợp Amoxicillin và Acid Clavulanic điều trị nhiễm khuẩn đường hô hấp, tiết niệu.', 145000.00, 50, 1, 'Hộp', 'Thuốc kê đơn. Uống theo chỉ định của bác sĩ, thường là 1 viên mỗi 12 giờ.', 'klamentin-1g.jpg', '2026-01-11 04:04:09'),
(6, 1, 'Ventolin Inhaler 100mcg', 'xit-hen-ventolin-inhaler', 'Thuốc xịt định liều Ventolin Inhaler cắt cơn hen', 'Thuốc giãn phế quản tác dụng nhanh, dùng để cắt cơn hen suyễn cấp tính.', 110000.00, 40, 1, 'Chai', 'Xịt khi có cơn khó thở. Tuân thủ hướng dẫn kỹ thuật xịt của dược sĩ.', 'ventolin.jpg', '2026-01-11 04:04:09'),
(7, 2, 'Ginkgo Biloba 120mg Trunature', 'vien-uong-bo-nao-ginkgo-biloba-my', 'Viên uống bổ não Ginkgo Biloba 120mg của Mỹ', 'Giúp tăng cường tuần hoàn máu não, cải thiện trí nhớ, giảm đau đầu chóng mặt.', 480000.00, 60, 0, 'Lọ 340 viên', 'Uống 1 viên x 2 lần/ngày sau ăn.', 'ginkgo-biloba.jpg', '2026-01-11 04:04:09'),
(8, 2, 'Glucosamine Orihiro 1500mg', 'glucosamine-orihiro-nhat-ban', 'Viên uống bổ xương khớp Glucosamine Orihiro Nhật Bản', 'Hỗ trợ tái tạo sụn khớp, giảm đau xương khớp, tăng tiết dịch khớp.', 650000.00, 45, 0, 'Lọ 900 viên', 'Ngày uống 10 viên, chia làm 2 lần sau ăn.', 'glucosamine-orihiro.jpg', '2026-01-11 04:04:09'),
(9, 2, 'Vitamin E Enat 400', 'vitamin-e-enat-400-thai-lan', 'Vitamin E Enat 400 - Dưỡng ẩm, chống lão hóa', 'Vitamin E thiên nhiên giúp da mịn màng, hạn chế lão hóa. Sản phẩm nhập khẩu Thái Lan.', 120000.00, 150, 0, 'Hộp 30 viên', 'Uống 1 viên mỗi ngày sau bữa ăn.', 'enat-400.jpg', '2026-01-11 04:04:09'),
(10, 2, 'Boganic Traphaco', 'boganic-traphaco-bo-gan', 'Thuốc bổ gan Boganic Traphaco - Giải độc gan', 'Sản phẩm bổ gan số 1 Việt Nam. Giúp mát gan, giải độc, trị mụn nhọt, dị ứng.', 95000.00, 200, 0, 'Hộp 5 vỉ', 'Ngày uống 3 lần, mỗi lần 1-2 viên.', 'boganic.jpg', '2026-01-11 04:04:09'),
(13, 1, 'adsadsdád', 'adsadsd-d-1768206647', 'ádasâdsdsdsads', 'adsđâsdsấd', 2334434.00, 100, 0, 'Hộp', 'đâsadsáđá', '1768206647_zalo.jpg', '2026-01-12 08:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `full_name`, `email`, `phone_number`, `address`, `role`, `created_at`) VALUES
(1, 'admin', 'admin', 'Quản trị viên', NULL, NULL, NULL, 'admin', '2026-01-11 03:20:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_cart_user` (`user_id`),
  ADD KEY `fk_cart_prod` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_ord_user` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_det_ord` (`order_id`),
  ADD KEY `fk_det_prod` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_prod_cat` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_prod` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_ord_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_det_ord` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_det_prod` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_prod_cat` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
