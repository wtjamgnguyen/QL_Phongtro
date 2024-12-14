-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 02:35 PM
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
-- Database: `gtpt`
--

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `ID` int(10) NOT NULL,
  `Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `motel`
--

CREATE TABLE `motel` (
  `ID` int(10) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `count_view` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latlng` varchar(255) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `utilities` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `phone` varchar(255) DEFAULT NULL,
  `approve` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motel`
--

INSERT INTO `motel` (`ID`, `title`, `description`, `price`, `area`, `count_view`, `address`, `latlng`, `images`, `user_id`, `category_id`, `district_id`, `utilities`, `created_at`, `phone`, `approve`) VALUES
(1, 'Phòng trọ cao cấp 1', 'Phòng sạch sẽ, thoáng mát, gần trường học', 3000000, 25, 10, '123 Nguyễn Trãi, Hà Nội', '21.028511, 105.804817', NULL, 1, 1, 1, 'Wifi, Máy lạnh', '2024-12-13 17:10:26', '0901234567', 1),
(2, 'Phòng trọ giá rẻ 2', 'Phòng trọ đầy đủ tiện nghi, gần trung tâm', 1500000, 15, 20, '456 Trần Hưng Đạo, Hà Nội', '21.028456, 105.805789', NULL, 2, 2, 2, 'Wifi, Máy nước nóng', '2024-12-13 17:10:26', '0902345678', 1),
(3, 'Phòng trọ tiện lợi 3', 'Phòng có chỗ để xe rộng rãi, an ninh tốt', 2500000, 20, 30, '789 Lê Lợi, Hà Nội', '21.029123, 105.806543', NULL, 3, 1, 1, 'Chỗ để xe, Wifi', '2024-12-13 17:10:26', '0903456789', 1),
(4, 'Phòng trọ giá tốt 4', 'Phòng trọ yên tĩnh, gần chợ và siêu thị', 1800000, 18, 40, '123 Phố Huế, Hà Nội', '21.030987, 105.807654', NULL, 4, 3, 3, 'Gần siêu thị, Wifi', '2024-12-13 17:10:26', '0904567890', 1),
(5, 'Phòng trọ bình dân 5', 'Phòng rộng rãi, khu vực an ninh', 2000000, 22, 50, '456 Hàng Bạc, Hà Nội', '21.031456, 105.808765', NULL, 5, 2, 2, 'Wifi, Máy giặt', '2024-12-13 17:10:26', '0905678901', 1),
(6, 'Phòng trọ VIP 6', 'Phòng đầy đủ nội thất, gần công viên', 3500000, 30, 60, '789 Bạch Mai, Hà Nội', '21.032123, 105.809876', NULL, 6, 1, 1, 'Máy lạnh, Giường ngủ', '2024-12-13 17:10:26', '0906789012', 1),
(7, 'Phòng trọ sinh viên 7', 'Phòng giá rẻ, gần trường đại học', 1200000, 12, 70, '123 Cầu Giấy, Hà Nội', '21.033789, 105.810987', NULL, 7, 3, 3, 'Wifi, Gần trường học', '2024-12-13 17:10:26', '0907890123', 1),
(8, 'Phòng trọ gia đình 8', 'Phòng rộng, tiện nghi, gần siêu thị', 4000000, 40, 80, '456 Nguyễn Lương Bằng, Hà Nội', '21.034456, 105.811098', NULL, 8, 2, 2, 'Chỗ để xe, Máy lạnh', '2024-12-13 17:10:26', '0908901234', 1),
(9, 'Phòng trọ mini 9', 'Phòng nhỏ gọn, tiện lợi cho người đi làm', 1300000, 14, 90, '789 Hồ Tùng Mậu, Hà Nội', '21.035123, 105.812345', NULL, 9, 1, 1, 'Wifi, Gần trung tâm', '2024-12-13 17:10:26', '0909012345', 1),
(10, 'Phòng trọ cao cấp 10', 'Phòng đầy đủ tiện nghi, có máy lạnh và giường ngủ', 3200000, 28, 100, '123 Kim Mã, Hà Nội', '21.036789, 105.813456', NULL, 10, 2, 2, 'Máy lạnh, Máy nước nóng', '2024-12-13 17:10:26', '0910123456', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(10) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Role` int(11) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `Name`, `Username`, `Email`, `Password`, `Role`, `Phone`, `Avatar`) VALUES
(19, 'Trần Đức Lương', 'admin', 'admin@gmail.com', 'admin', 1, '0773366256', NULL),
(20, 'Trần Đức Lương', 'admin2', 'admin2@gmail.com', '$2y$10$NxC0exxxZB2U7I5ghUeTq.UBY.Bmwh/kGeGC3LhlqwGbc3lLghrK.', 1, '0773366256', NULL),
(21, 'Trần Ngọc Nguyên', 'nguyen', 'nguyen@gmail.com', '$2y$10$FcK7U5cDLZv7jb9rDyNkRObI5Lv0Ao7aPceg2pl93c.zNbQqTk4Di', 1, '123123123', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `motel`
--
ALTER TABLE `motel`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `motel`
--
ALTER TABLE `motel`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
