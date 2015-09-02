-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2015 at 07:37 AM
-- Server version: 5.6.24-log
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sample_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `font_type`
--

CREATE TABLE IF NOT EXISTS `font_type` (
  `id` int(2) NOT NULL,
  `font_name` varchar(45) DEFAULT NULL,
  `font_class` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `font_type`
--

INSERT INTO `font_type` (`id`, `font_name`, `font_class`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'semantic ui', 'icon ', '2015-09-01 00:00:00', NULL, NULL),
(2, 'font awesome', 'fa fa-', '2015-09-01 00:00:00', NULL, NULL),
(3, 'flaticon', 'flaticon-', '2015-09-01 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE IF NOT EXISTS `kategori_produk` (
  `id_kategori` int(11) NOT NULL,
  `kategori_nama` varchar(45) DEFAULT NULL,
  `kategori_desc` text,
  `font_type` int(11) DEFAULT NULL,
  `kategori_icon` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`id_kategori`, `kategori_nama`, `kategori_desc`, `font_type`, `kategori_icon`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Fashion & Aksesoris', NULL, 3, 'tas', NULL, NULL, NULL),
(2, 'Pakaian', NULL, 3, 'fashion', NULL, NULL, NULL),
(3, 'Dapur', NULL, 3, 'kitchen_tools', NULL, NULL, NULL),
(4, 'Kecantikan', NULL, 3, 'beauty', NULL, NULL, NULL),
(5, 'Kesehatan', NULL, 2, 'ambulance', NULL, NULL, NULL),
(6, 'Rumah Tangga', NULL, 3, 'household', NULL, NULL, NULL),
(7, 'Perawatan Bayi', NULL, 3, 'baby_care', NULL, NULL, NULL),
(8, 'Handphone & Tablet', NULL, 3, 'tablet', NULL, NULL, NULL),
(9, 'Laptop & Aksesoris', NULL, 3, 'laptop', NULL, NULL, NULL),
(10, 'Komputer & Aksesoris', NULL, 2, 'desktop', NULL, NULL, NULL),
(11, 'Elektronik', NULL, 3, 'vacum', NULL, NULL, NULL),
(12, 'Kamera, Foto & Video', NULL, 3, 'camera1', NULL, NULL, NULL),
(13, 'Otomotif', NULL, 3, 'wheel', NULL, NULL, NULL),
(14, 'Olahraga', NULL, 3, 'football', NULL, NULL, NULL),
(15, 'Office', NULL, 3, 'alat_tulis', NULL, NULL, NULL),
(16, 'Souvenir', NULL, 3, 'kado', NULL, NULL, NULL),
(17, 'Mainan', NULL, 2, 'car', NULL, NULL, NULL),
(18, 'Makanan & Minuman', NULL, 3, 'cake', NULL, NULL, NULL),
(19, 'Buku', NULL, 2, 'book', NULL, NULL, NULL),
(20, 'Software', NULL, 3, 'software', NULL, NULL, NULL),
(21, 'Film', NULL, 3, 'roll_film', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE IF NOT EXISTS `produk` (
  `id` int(11) NOT NULL,
  `kode_produk` varchar(45) DEFAULT NULL,
  `produk_kategori` int(11) DEFAULT NULL,
  `produk_name` varchar(100) DEFAULT NULL,
  `produk_desc` text,
  `produk_price` float DEFAULT NULL,
  `produk_diskon` float DEFAULT NULL,
  `produk_url` text,
  `date_available` date DEFAULT NULL,
  `change_date` date DEFAULT NULL,
  `brand_name` varchar(45) DEFAULT NULL,
  `id_toko` int(11) DEFAULT NULL,
  `produk_rating` int(5) DEFAULT '0',
  `produk_terjual` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `kode_produk`, `produk_kategori`, `produk_name`, `produk_desc`, `produk_price`, `produk_diskon`, `produk_url`, `date_available`, `change_date`, `brand_name`, `id_toko`, `produk_rating`, `produk_terjual`) VALUES
(1, 'J001', 1, 'Jam tangan pria', 'NULL', 1602000, 93, 'http://srv-live.lazada.co.id/cms/produkpage/S__6807585.jpg', '2015-08-21', '0000-00-00', 'bluelans', 1, NULL, 0),
(2, 'E001', 11, 'Sharp EC-8304-A', 'NULL', 900000, 23, 'http://srv-live.lazada.co.id/cms/produkpage/vc6_a.jpg', '2015-08-21', '0000-00-00', 'sharp', 1, NULL, 0),
(3, 'E002', 11, 'Kipas angin', 'NULL', 110000, NULL, 'http://srv-live-01.lazada.co.id/floor/ID.2015-08-11.FL.0.5.77aa09fdf586ae761e2da4350b839894.jpg', '2015-08-21', '0000-00-00', 'LG', 1, NULL, 0),
(4, 'B001', 4, 'Dior Skin', 'NULL', 125000, 13, 'http://srv-live-02.lazada.co.id/p/dior-skin-forever-control-matte-powder-makeup-spf-20-pa-beige-clair-020light-beige-2-5g-4196-840028-1-catalog.jpg', '2015-08-21', '0000-00-00', 'DIOR', 1, NULL, 12),
(5, 'B002', 4, 'Maybelline Clear', 'NULL', 42300, 13, 'http://srv-live-01.lazada.co.id/p/maybelline-clear-smooth-all-in-one-two-way-cake-light-6955-73815-1-catalog.jpg', '2015-08-21', '0000-00-00', 'Maybelline', 1, NULL, 10),
(6, 'H001', 6, 'Bantal Leher', 'NULL', 15000, 0, 'https://ecs7.tokopedia.net/img/cache/308/hot_product/2015/8/18/12/3/41/318724/bantal-leher.jpg', '2015-01-01', '0000-00-00', 'NULL', 1, NULL, 0),
(7, 'F001', 2, 'Singlet Rider 224B', 'NULL', 35000, 0, 'https://ecs12.tokopedia.net/newimg/cache/200-square/product-1/2014/12/12/5868400/5868400_59b6c32c-81fc-11e4-b25f-9baf4908a8c2.jpg', '2015-01-01', '0000-00-00', 'rider', 1, NULL, 0),
(8, 'F002', 2, 'Rompi Hitam', 'NULL', 155222, 0, 'https://ecs12.tokopedia.net/newimg/cache/200-square/product-1/2014/8/20/168761/168761_24449a04-2845-11e4-86be-f1e54908a8c2.jpg', '2015-03-02', '0000-00-00', 'maxim', 1, NULL, 0),
(9, 'F003', 1, 'Wedges Midi Flare', 'NULL', 80000, 0, 'https://ecs7.tokopedia.net/img/cache/200-square/product-1/2015/8/21/253326/253326_ec06ad26-47c9-11e5-8638-25a849bc7260.jpg', '2015-07-12', '0000-00-00', 'flare', 1, NULL, 1),
(10, 'K001', 12, 'GoPro Battery', 'NULL', 534000, 10, 'https://ecs7.tokopedia.net/img/cache/200-square/product-1/2015/8/17/549955/549955_4060e507-dd63-4d21-8f61-b85ac4672713.jpg', '2015-08-01', '0000-00-00', 'Go Pro', 1, NULL, 2),
(11, 'K002', 12, 'Lensa Cannon 50mm', 'NULL', 2850000, 10, 'https://ecs7.tokopedia.net/img/cache/200-square/product-1/2015/8/21/316578/316578_5a784c4e-605a-4455-909c-7b659f8c58fb.jpg', '2015-08-17', '0000-00-00', 'Cannon', 1, NULL, 0),
(12, 'K003', 12, 'Tas Slempang', 'NULL', 140000, 0, 'https://ecs7.tokopedia.net/img/cache/200-square/product-1/2015/4/14/9552664/9552664_4bb40c32-e280-11e4-979c-055087772fba.jpg', '2015-08-18', '0000-00-00', 'National', 1, NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `font_type`
--
ALTER TABLE `font_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id_kategori`), ADD KEY `font_type_idx` (`font_type`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`), ADD KEY `id_toko_idx` (`id_toko`), ADD KEY `produk_kategori_idx` (`produk_kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `font_type`
--
ALTER TABLE `font_type`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
