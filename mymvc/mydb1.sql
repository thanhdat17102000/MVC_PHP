-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 19, 2022 lúc 06:28 AM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mydb1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` bigint(20) NOT NULL,
  `m_id_parent` bigint(20) NOT NULL DEFAULT 0,
  `m_title` varchar(255) NOT NULL,
  `m_index` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `m_id_parent`, `m_title`, `m_index`) VALUES
(22, 0, 'Vivo', 1),
(21, 0, 'Xiaomi', 1),
(11, 9, 'Điện thoại', 1),
(12, 10, 'Máy tính 111111', 2),
(20, 0, 'LG', 1),
(19, 0, 'Samsung', 1),
(18, 0, 'Apple', 1),
(17, 16, 'Máy Lạnh 1', 1),
(23, 0, 'Oppo', 1),
(24, 0, 'Huawei', 1),
(26, 0, 'Realme', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` bigint(20) NOT NULL,
  `m_id_category` bigint(20) DEFAULT NULL,
  `m_title` varchar(500) NOT NULL,
  `m_short_description` varchar(500) DEFAULT NULL,
  `m_description` mediumtext DEFAULT NULL,
  `m_price` int(11) DEFAULT 0,
  `m_original_price` int(11) DEFAULT 0,
  `m_time_create` bigint(20) DEFAULT NULL,
  `m_time_update` bigint(20) DEFAULT NULL,
  `m_view` int(11) DEFAULT 0,
  `m_like` int(11) DEFAULT 0,
  `m_quanti` int(11) DEFAULT 0,
  `m_buy` int(11) DEFAULT 0,
  `m_status` tinyint(4) DEFAULT 1,
  `m_file_type` varchar(30) NOT NULL DEFAULT 'gif'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `m_id_category`, `m_title`, `m_short_description`, `m_description`, `m_price`, `m_original_price`, `m_time_create`, `m_time_update`, `m_view`, `m_like`, `m_quanti`, `m_buy`, `m_status`, `m_file_type`) VALUES
(12, 18, 'iPhone 13 mini 256GB I Chính hãng VN/A', 'Iphone 13', '<p>Iphone 13</p>', 20000000, 24000000, 1645175101, 1645175848, 36, 3, 999, 79, 2, 'jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `torder`
--

CREATE TABLE `torder` (
  `id` int(11) NOT NULL,
  `m_name` varchar(255) NOT NULL,
  `m_phone` varchar(20) NOT NULL,
  `m_address` varchar(255) DEFAULT NULL,
  `m_note` varchar(500) DEFAULT NULL,
  `m_total_price` int(11) NOT NULL DEFAULT 0,
  `m_create` bigint(20) DEFAULT NULL,
  `m_update` bigint(20) DEFAULT NULL,
  `m_status_ship` tinyint(4) NOT NULL DEFAULT 1,
  `m_status_purchar` tinyint(4) NOT NULL DEFAULT 1,
  `m_status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `torder`
--

INSERT INTO `torder` (`id`, `m_name`, `m_phone`, `m_address`, `m_note`, `m_total_price`, `m_create`, `m_update`, `m_status_ship`, `m_status_purchar`, `m_status`) VALUES
(1, 'Nguyễn Đình Nam', '0967258243', 'Số nhà 123, đường 456, khu phố 7, phường 8, quận 9, thành phố 10', 'Gọi điện trước 30 phút khi giao hàng.', 600000, 1633952122, 1633952122, 2, 2, 2),
(2, 'Nguyễn Lê Thành Đạt', '0926335577', '876/35 ', 'hello', 500000, 1642351296, 1642351296, 1, 1, 1),
(8, 'thanhdat', '0999999999', '99', '99', 20000000, 1645242737, 1645242737, 1, 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `torder_detail`
--

CREATE TABLE `torder_detail` (
  `id` int(11) NOT NULL,
  `m_id_order` int(11) NOT NULL,
  `m_id_product` int(11) NOT NULL,
  `m_price` int(11) NOT NULL,
  `m_quanti` int(11) NOT NULL,
  `m_product_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `torder_detail`
--

INSERT INTO `torder_detail` (`id`, `m_id_order`, `m_id_product`, `m_price`, `m_quanti`, `m_product_name`) VALUES
(1, 1, 9, 500000, 1, 'Sản phẩm demo 4'),
(2, 1, 6, 50000, 2, 'Sản phẩm demo 1'),
(3, 2, 9, 500000, 1, 'Sản phẩm demo 4'),
(4, 3, 7, 10000, 1, 'Sản phẩm demo 2'),
(5, 4, 7, 10000, 1, 'Sản phẩm demo 2'),
(6, 8, 12, 20000000, 1, 'iPhone 13 mini 256GB I Chính hãng VN/A');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `m_username` varchar(255) NOT NULL,
  `m_password` varchar(255) NOT NULL,
  `m_gender` tinyint(4) DEFAULT NULL,
  `m_phone` varchar(50) DEFAULT NULL,
  `m_email` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `m_username`, `m_password`, `m_gender`, `m_phone`, `m_email`) VALUES
(4, 'thanhdat17', 'f0cc5efc1136c659a5028385c6c4778e', 1, '0926335577', 'datnltps13413@fpt.edu.vn');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `torder`
--
ALTER TABLE `torder`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `torder_detail`
--
ALTER TABLE `torder_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `torder`
--
ALTER TABLE `torder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `torder_detail`
--
ALTER TABLE `torder_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
