-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2024 at 11:49 AM
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
-- Database: `if0_35608359_bnb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `user`, `mail`, `password`) VALUES
(1, 'admin', 'admin@home.co', 'Admin*123');

-- --------------------------------------------------------

--
-- Table structure for table `bnb`
--

CREATE TABLE `bnb` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` varchar(255) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL,
  `login_token` varchar(255) DEFAULT NULL,
  `login_token_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ItemId` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Pic` varchar(255) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `Quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemId`, `ProductName`, `Description`, `Price`, `Pic`, `Category`, `Quantity`) VALUES
(1, 'ASUS TUF Gaming GeForce RTX 4090 OG OC Edition', 'ASUS TUF Gaming GeForce RTX 4090 OG OC Edition Gaming Graphics Card (PCIe 4.0, 24GB GDDR6X, DLSS 3, HDMI 2.1, DisplayPort 1.4a)', 'EGP160,700', '/products/Hardware/hardware0.jpg', 'Hardware-Hot', 97),
(2, 'Apple iPhone 14 Pro Max', '6.7-inch Super Retina XDR display featuring Always-On and ProMotion Dynamic Island, a magical new way to interact with iPhone\r\n48MP Main camera for up to 4x greater resolution Cinematic mode now in 4K Dolby Vision up to 30 fps', 'EGP32,900', '/products/Mobile_Phones/phone0.jpg', 'Phones', 99),
(3, 'Samsung Galaxy A54 ', 'Samsung Galaxy A54 - Dual SIM Mobile Phone Android, 8GB RAM, 256GB, Awesome Graphite - 1 year Warranty', 'EGP13,299', '/products/Mobile_Phones/phone1.jpg', 'Phones-New', 3),
(4, ' Nokia G21', 'Nokia G21 4gb ram, 128gb memory, finger print sensor - blue', 'EGP3,999', '/products/Mobile_Phones/phone5.jpg', 'Phones', 99),
(5, 'Samsung Galaxy A04e Dual SIM Smartphone', 'Samsung Galaxy A04e Dual SIM Smartphone - 3GB RAM, 64GB Storage, LTE, Black - 1 year Warranty', 'EGP4,750', '/products/Mobile_Phones/phone7.jpg', 'Phones', 99),
(6, 'realme C53 Dual SIM', 'realme C53 Dual SIM 6GB RAM 128GB Mighty Black 4G LTE', 'EGP6,390', '/products/Mobile_Phones/phone8.jpg', 'Phones', 99),
(7, 'Samsung Galaxy M34', 'Samsung Galaxy M34, Dual SIM, 8GB RAM, 128GB Storage, 5G, Blue - 1 year Warranty', 'EGP9,999', '/products/Mobile_Phones/phone9.jpg', 'Phones', 99),
(8, 'Redmi 12 Hybrid Dual SIM', 'Redmi 12 Hybrid Dual SIM, 8GB RAM, 256GB ROM - Midnight Black', 'EGP8,042', '/products/Mobile_Phones/phone10.jpg', 'Phones', 99),
(9, 'Samsung Galaxy A24 4G', 'Samsung Galaxy A24 4G Android Smartphone, Dual SIM, 6GB RAM, 128GB Storage, Black', 'EGP7,899', '/products/Mobile_Phones/phone11.jpg', 'Phones', 99),
(10, ' NZXT H510', 'NZXT H510 - Compact ATX Mid-Tower PC Gaming Case - Front I/O USB Type-C Port - Tempered Glass Side Panel - Cable Management System - Water-Cooling Ready - Steel Construction - White/Black', 'EGP2,341', '/products/Hardware/hardware1.jpg', 'Hardware', 99),
(11, 'Crucial P3 1TB', 'Crucial P3 1TB M.2 PCIe Gen3 NVMe Internal SSD - Up to 3500MB/s Sequential Read & 3000 MB/s Sequential Write - CT1000P3SSD8', 'EGP3,000', '/products/Hardware/hardware2.jpg', 'Hardware-Hot', 96),
(12, 'AMD Ryzen 9 7900X', 'AMD Ryzen 9 7900X 12-Core, 24-Thread Unlocked Desktop Processor', 'EGP24,155', '/products/Hardware/1baed8cf5b735209aa50fbce33072498.jpg', 'Hardware-New', 0),
(13, 'Zotac Gaming GeForce RTX 3060', 'Zotac Gaming GeForce RTX 3060 Twin Edge OC 12GB GDDR6 192-bit 15 Gbps PCIE 4.0 Gaming Graphics Card, IceStorm 2.0 Cooling, Active Fan Control, Freeze Fan Stop ZT-A30600H-10M', 'EGP22,097', '/products/Hardware/hardware4.jpg', 'Hardware', 99),
(14, 'Corsair Vengeance RGB PRO 16GB', 'Corsair Vengeance RGB PRO 16GB (2x8GB) DDR4 3200MHz C16 LED Desktop Memory - Black', 'EGP3,800', '/products/Hardware/hardware5.jpg', 'Hardware', 99),
(15, 'SAMSUNG 870 QVO SATA III SSD', 'SAMSUNG 870 QVO SATA III SSD 1TB 2.5\" Internal Solid State Hard Drive, Upgrade Desktop PC or Laptop Memory and Storage for IT Pros, Creators, Everyday Users, MZ-77Q1T0B', 'EGP3,257', '/products/Hardware/hardware7.jpg', 'Hardware', 99),
(16, 'Crucial RAM 16GB', 'Crucial RAM 16GB DDR4 3200 MHz CL22 DESKTOP Memory CT16G4DFRA32A', 'EGP1,868', '/products/Hardware/hardware8.jpg', 'Hardware', 99),
(17, 'Lenovo IdeaPad Gaming 3 Laptop', 'Lenovo IdeaPad Gaming 3 Laptop - Intel Core i7-12650H 10-Cores, NVIDIA GeForce RTX 3050 4GB GDDR6 Graphics, 16GB RAM, 512GB SSD, 15.6\" FHD 1920x1080 IPS 120Hz, 4Z RGB Backlit, Win 11 +Gaming RGB Mouse', 'EGP39,999', '/products/Laptops/laptop1.jpg', 'Laptops-New', 91),
(18, 'HP Victus 15-fa0032dx Gaming Laptop', 'HP Victus 15-fa0032dx Gaming Laptop - 12th Intel Core i7-12650H 10-Cores, 16GB RAM, 512GB SSD, NVIDIA RTX3050Ti 4GB GDDR6 Graphics, 15.6\" FHD (1920x1080) IPS 144Hz, Backlit KB, Windows 11- Mica Silver', 'EGP69,999', '/products/Laptops/laptop2.jpg', 'Laptops-Hot', 99),
(19, 'HP Laptop 15S-EQ1001NE (155N7EA)', 'HP Laptop 15S-EQ1001NE (155N7EA), AMD Ryzen 3 3250U, 4GB DDR4-2400 MHz RAM (1 x 4GB), 256 GB PCIe NVMe M.2 SSD - Black', 'EGP11,499', '/products/Laptops/laptop3.jpg', 'Laptops', 99),
(20, '14-inch MacBook Pro: Apple M2 Pro', '14-inch MacBook Pro: Apple M2 Pro chip with 10‑core CPU and 16‑core GPU,16GB, 512GB SSD - Space Grey', 'EGP105,099', '/products/Laptops/laptop4.jpg', 'Laptops', 99),
(21, 'Dell Vostro 3520 Laptop', 'Dell Vostro 3520 Laptop - 12th Intel Core i5-1235U 10-Cores, 16GB RAM, 512GB SSD, NVIDIA GeForce MX550 with 2GB GDDR6 Graphics, 15.6\" FHD (1920 x 1080) 120Hz 250 nits Anti-Glare, Ubuntu -Carbon Black', 'EGP21,999', '/products/Laptops/laptop5.jpg', 'Laptops', 99),
(22, 'HP Victus 16-d1002ne Gaming Laptop', 'HP Victus 16-d1002ne Gaming Laptop - 12th Intel Core i7-12700H 14-Cores, 16GB RAM DDR5 4800 MHz, 1TB PCIe NVMe SSD, NVIDIA RTX3050 4GB GDDR6 Graphics, 16,1\" FHD 144Hz, Backlit KB, Dos - Mica silver', 'EGP42,205', '/products/Laptops/laptop6.jpg', 'Laptops', 99),
(23, 'HP Laptop 15S-FQ5048NE (6L8K8EA)', ' HP Laptop 15S-FQ5048NE (6L8K8EA), Intel Core i3 - 1215U, 12th Generation, 4GB DDR4, 256GB SSD, Windows 11 Home Single Language - Black', 'EGP16,000', '/products/Laptops/laptop7.jpg', 'Laptops', 99),
(24, 'Lenovo Legion 5 Pro 16ITH6', 'Lenovo Legion 5 Pro 16ITH6 Intel Core i7-11800H, 16GB, 1TB SSD, NVIDIA GeForce RTX 3060 6GB - Whit-DOSe', 'EGP36,999', '/products/Laptops/laptop8.jpg', 'Laptops', 99),
(25, 'Samsung 27 inch odyssey g5 gaming monitor', 'Samsung 27 inch odyssey g5 gaming monitor with 1000r curved screen, 144hz, 1ms, freesync premium, qhd (lc27g55tqwmxzn), black', 'EGP6,777', '/products/Monitors/monitor2.jpg', 'Monitors', 99),
(26, 'BenQ 27Inch IPS FHD Monitor', 'BenQ 27Inch IPS FHD 1080p Eye Care LED Monitor,Black,1920x1080 Display,GW2780', 'EGP4,440', '/products/Monitors/monitor3.jpg', 'Monitors', 99),
(27, 'LG 24GQ50F', 'LG 24GQ50F UltraGear Full HD Gaming Monitor - Black', 'EGP5,199', '/products/Monitors/monitor4.jpg', 'Monitors', 99),
(28, 'Samsung 22-Inch LED Monitor', 'Samsung 22-Inch LED Monitor with IPS Panel and Borderless Design', 'EGP2,665', '/products/Monitors/monitor6.jpg', 'Monitors', 99),
(29, 'Lenovo Gaming 31.5\" QHD', 'Lenovo Gaming 31.5\" QHD VA 1ms MPRT 144Hz HDMI DP FreeSync LT, CURVED', 'EGP17,595', '/products/Monitors/monitor8.jpg', 'Monitors', 99),
(30, 'SAMSUNG 32 Inch Odyssey G5 Monitor', 'SAMSUNG 32 Inch Odyssey G5 Gaming Monitor with 1000R Curved Screen, 144Hz, 1ms, FreeSync Premium, QHD (LC32G55TQWMXZN), Black', 'EGP8,599', '/products/Monitors/monitor10.jpg', 'Monitors-Hot', 99),
(31, 'LG 27GQ50F', 'LG 27GQ50F UltraGear Full HD Gaming Monitor - Black', 'EGP5,980', '/products/Monitors/monitor11.jpg', 'Monitors', 99),
(32, 'SAMSUNG ODYSSEY G5 LC27G55TQBMXEG', 'SAMSUNG ODYSSEY G5 LC27G55TQBMXEG 27 INCH, CURVED GAMING Monitor - Black', 'EGP6,799', '/products/Monitors/monitor12.jpg', 'Monitors', 99),
(33, 'Rest Gel Ergonomic Wrist Rest Kit', 'Yizhet Keyboard Wrist Rest and Mouse Wrist Rest Gel Ergonomic Wrist Rest Kit for Mouse Keyboard Non-Slip Computer Accessories (43 x 8.5 x 2 cm)', 'EGP150', '/products/Accessories/accessories2.jpg', 'Accessories', 99),
(34, '2 Pack Artist', '2 Pack Artist Glove Anti-fouling Two Fingers Graphics Drawing Tablets for Light Box/Graphic Tablet/Pen Display/iPad Pro Pencil', 'EGP140', '/products/Accessories/accessories3.jpg', 'Accessories', 99),
(35, 'TITANWOLF Bundle', 'TITANWOLF - RGB Gaming Mouse Pad XXL - Gaming Mouse Pad - 800x300mm - 11 LED Colours and Light Effects - Precision and Speed - Rubberized Bottom Side - Washable - World Map', 'EGP299', '/products/Accessories/accessories4.jpg', 'Accessories', 99),
(36, '3Dconnexion Accessory', '3Dconnexion 3DX-700059 Input Device Accessory', 'EGP15,600', '/products/Accessories/accessories5.jpg', 'Accessories', 99),
(37, 'Titanwolf RGB Gaming Mouse Mat', 'Titanwolf RGB Gaming Mouse Mat - LED Desk Mat - 800 x 300 mm - XXL Mouse Mat - LED Multi Colour - 11 Lighting Modes - 7 LED Colours Plus 4 Effect Modes - Washable - World Map', 'EGP275', '/products/Accessories/accessories6.jpg', 'Accessories', 99),
(38, 'Wireless USB Charger Computer Mouse', 'Wireless USB Charger Computer Mouse for MacBook Air Mac Pro Laptop Ipad Pad PC The Laser Optical Rechargeable Mini Slim Silent Mice is Replacement Wired Widely Used Desktop Hp iMac (Rose Gold)', 'EGP256', '/products/Accessories/accessories7.jpg', 'Accessories', 99),
(39, 'DELUXE Bundle', 'DELUX Ergonomic Mouse, Wired Large RGB Vertical Mouse with 6 Buttons, Removable Wrist Rest, 4000DPI and On-Board Software Reduce Hand Strain, for Carpal Tunnel(M618Plus RGB-Black)', 'EGP1,050', '/products/Accessories/accessories9.jpg', 'Accessories', 99),
(40, '7-in-1 Cleaner Set', '7-in-1 Cleaner Set, Laptop Screen Keyboard Earbud Cleaner Kit for Airpods MacBook iPad iPhone iPod, Multi-Function Cleaning Pen Brush Tool Key Remover for PC Monitor, Computer, Headphone (Blue)', 'EGP118', '/products/Accessories/accessories1.jpg', 'Accessories', 99),
(41, 'Sony PlayStation 5', 'Sony PlayStation 5 Console with Wireless Controller, Middle East Version - White and Black', 'EGP26,199', '/products/Consoles/consoles2.jpg', 'Consoles', 99),
(42, 'Xbox Series S', 'Xbox Series S with 1 Controllers, 512GB SSD', 'EGP14,999', '/products/Consoles/consoles6.jpg', 'Consoles', 99),
(43, 'ps2 console', 'ps2 console with 30 games and 2 controllers', 'EGP1,999', '/products/Consoles/consoles8.jpg', 'Consoles', 99),
(44, 'Xbox Wireless Controller', 'Xbox Wireless Controller - Mineral Camo Special Edition', 'EGP4,373', '/products/Consoles/consoles12.jpg', 'Consoles', 99),
(45, 'Sony PlayStation / PS Vita', 'Sony PlayStation / PS Vita PCH-2006ZA23 Wi-Fi Console (Aqua Blue)', 'EGP1,999', '/products/Consoles/consoles11.jpg', 'Consoles', 99),
(46, 'Playstation Design Game Console', 'Playstation Design Game Console with 100GB Hard Drive with 50+ Games and 2 Controllers', 'EGP26,170', '/products/Consoles/consoles10.jpg', 'Consoles', 99),
(47, 'Xbox Series X', 'Xbox Series X with 2 Controllers, 1TB SSD', 'EGP25,488', '/products/Consoles/consoles13.jpg', 'Consoles', 99),
(48, 'Logitech G Cloud Console', 'Logitech G Cloud Handheld Portable Gaming Console with Long-Battery Life, 1080P 7-Inch Touchscreen, Lightweight Design, Xbox Cloud Gaming, NVIDIA GeForce NOW, Google Play', 'EGP9,999', '/products/Consoles/consoles14.jpg', 'Consoles', 99),
(49, 'Bluetooth Wireless Mouse', 'Bluetooth Wireless Mouse, Dual Mode Slim Rechargeable Wireless Mouse Silent Cordless Mouse with Bluetooth 4.0 and 2.4G Wireless, Compatible with Laptop, PC, Windows Mac Android OS Tablet (Black)', 'EGP249', '/products/Video_Games/video_game1.jpg', 'Games', 99),
(50, 'Aula S20 Mouse', 'Aula S20 3200 Dpi LED Macro Gaming Mouse', 'EGP169', '/products/Video_Games/video_game2.jpg', 'Games', 99),
(51, 'Gaming Headphone K1B Pro', 'Gaming Headphone K1B Pro with LED and Microphone Wired Over Ear Headphone for PC, PS5, Xbox, Mobiles, Tablets, Laptops. (Blue)', 'EGP325', '/products/Video_Games/video_game4.jpg', 'Games', 99),
(52, 'RUNMUS K2 PRO Headset', 'RUNMUS K2 PRO Wired Gaming Headset, Green LED Lights with Mic, 7.1 Surround Sound Stereo Bass and Noise Cancellation, Over-Ear, 3.5mm, Padded Ear Cushion, for PS4/PS5/PC/Xbox One', 'EGP325', '/products/Video_Games/video_game5.jpg', 'Games', 99),
(53, 'Kids Wireless Headphones', 'Kids Wireless Headphones, Arvin Childrens Bluetooth Headphones with Microphone and LED Light, Using TF Card, 85/94dB Volume Limited, Wired Foldable Over-Ear Headset for Girls/Travel/Music/PC/PS5-Black', 'EGP175', '/products/Video_Games/video_game6.jpg', 'Games', 99),
(54, 'Onikuma k20 stereo headset', 'Onikuma k20 stereo rgb gaming headset with led light noise-cancelling mic for mobile/pc/ps4/xbox one/mac, black, Wired', 'EGP325', '/products/Video_Games/video_game11.jpg', 'Games-New', 86),
(55, 'Vicloon Large Gaming Pad', 'Vicloon Large Gaming Mouse Pad Mouse Mat 900 * 400 * 3mm, Extended Mousepad Keyboard Desk Pad with Non-slip Rubber Base and Stitched Edges Mousepad or Laptop, Computer and PC - Black World Map', 'EGP279', '/products/Video_Games/video_game8.jpg', 'Games', 99),
(56, 'Hp RGB Gaming mouse', 'Hp wired rgb gaming mouse high performance mouse with optical sensor, 3 buttons, 7 color led for computer notebook laptop office pc home', 'EGP160', '/products/Video_Games/video_game12.jpg', 'Games', 99);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','going','delivered','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bnb`
--
ALTER TABLE `bnb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ItemId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bnb`
--
ALTER TABLE `bnb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `bnb` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `items` (`ItemId`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `bnb` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
