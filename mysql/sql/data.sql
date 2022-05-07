SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `final` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `final`;

CREATE TABLE `donnghiphep` (
  `madon` int(10) NOT NULL,
  `manhanvien` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hoten` varchar(50) NOT NULL,
  `songaymuonnghi` int(2) NOT NULL,
  `noidung` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ngaylap` varchar(10) NOT NULL,
  `taptin` varchar(200) DEFAULT NULL,
  `trangthai` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lichsu` (
  `manhiemvu` varchar(10) NOT NULL,
  `manhanvien` varchar(10) NOT NULL,
  `thutu` int(11) NOT NULL,
  `mota` varchar(200) NOT NULL,
  `taptin` varchar(200) NOT NULL,
  `ngaygui` varchar(10) NOT NULL,
  `hanchot` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `nguoidung` (
  `manhanvien` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hoten` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `taikhoan` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `matkhau` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phongban` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `chucvu` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `anhdaidien` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `songaynghi` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `nguoidung` (`manhanvien`, `hoten`, `taikhoan`, `matkhau`, `phongban`, `chucvu`, `anhdaidien`, `songaynghi`) VALUES
('admin', 'Nguyễn Mạnh Hải', 'admin', '$2y$10$BlsWUF5B4yrZv1jq62w80enlDyI5EB.XMeRQeu6D5jGTeXEGp/J0S', '', 'Giám đốc', NULL, 0),
('nv_kt_001', 'Đặng Hoàng Nam', 'kt_danghoangnam', '$2y$10$AE1oK28g3HRfB50Eesyi8upb2HU1t/eGFgUAYus8XnDiwC9rG1iSO', 'Kỹ thuật', 'Trưởng phòng', NULL, 10),
('nv_kt_002', 'Lê Tuấn Anh', 'kt_letuananh', '$2y$10$/f/hZnM68pT3yQl2X1OugujTbuGYHiOSJtpScBn7syEEX2jM9Q5Ay', 'Kỹ thuật', 'Nhân viên', NULL, 12);

CREATE TABLE `nhiemvu` (
  `manhiemvu` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `matruongphong` varchar(10) NOT NULL,
  `manhanvien` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tieude` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mota` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hanchot` varchar(10) NOT NULL,
  `taptin` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `trangthai` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `danhgia` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `phongban` (
  `maphongban` int(11) NOT NULL,
  `tenphongban` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mota` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sophong` int(11) NOT NULL,
  `truongphong` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `phongban` (`maphongban`, `tenphongban`, `mota`, `sophong`, `truongphong`) VALUES
(1, 'Kỹ thuật', 'Quản lý kỹ thuật', 1, 'Đặng Hoàng Nam'),
(2, 'Nhân sự', 'Quản lý nhân sự', 2, NULL);


ALTER TABLE `donnghiphep`
  ADD PRIMARY KEY (`madon`);

ALTER TABLE `lichsu`
  ADD PRIMARY KEY (`manhiemvu`,`thutu`);

ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`manhanvien`);

ALTER TABLE `nhiemvu`
  ADD PRIMARY KEY (`manhiemvu`);

ALTER TABLE `phongban`
  ADD PRIMARY KEY (`maphongban`);


ALTER TABLE `donnghiphep`
  MODIFY `madon` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `phongban`
  MODIFY `maphongban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
