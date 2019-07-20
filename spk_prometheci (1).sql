-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2019 at 02:35 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_prometheci`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `nidn` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `prodi` enum('SI','TI') NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`nidn`, `nama`, `prodi`, `jenis_kelamin`) VALUES
('061234510', 'ELY PURNAWATI', 'TI', 'Perempuan'),
('061234513', 'Zaenur', 'TI', 'Laki - Laki'),
('061234515', 'Ahmad Reza', 'SI', 'Laki - Laki'),
('061234516', 'Rochman', 'SI', 'Laki - Laki'),
('06123456', 'ARGIYAN DWI PRITAMA', 'TI', 'Laki - Laki'),
('06123457', 'BAGUS ADHI KUSUMA', 'TI', 'Laki - Laki'),
('06123458', 'CHENDRI IRAWAN SATRIO NUGROHO', 'TI', 'Laki - Laki'),
('06123459', 'DHANAR INTAN SURYA S', 'TI', 'Laki - Laki');

-- --------------------------------------------------------

--
-- Table structure for table `dosen_subkriteria`
--

CREATE TABLE `dosen_subkriteria` (
  `id` int(11) NOT NULL,
  `nidn` varchar(20) NOT NULL,
  `id_subkriteria` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `periode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen_subkriteria`
--

INSERT INTO `dosen_subkriteria` (`id`, `nidn`, `id_subkriteria`, `value`, `periode`) VALUES
(55, '06123456', 34, 0, 1),
(56, '06123456', 16, 0, 1),
(57, '06123456', 28, 0, 1),
(58, '06123456', 31, 0, 1),
(59, '06123456', 19, 0, 1),
(60, '06123456', 20, 2, 1),
(61, '06123456', 42, 0, 1),
(62, '06123456', 22, 3, 1),
(63, '06123456', 45, 0, 1),
(64, '06123456', 39, 0, 1),
(65, '06123457', 34, 0, 1),
(66, '06123457', 16, 0, 1),
(67, '06123457', 27, 0, 1),
(68, '06123457', 31, 0, 1),
(69, '06123457', 40, 0, 1),
(70, '06123457', 20, 3, 1),
(71, '06123457', 43, 0, 1),
(72, '06123457', 22, 3, 1),
(73, '06123457', 23, 0, 1),
(74, '06123457', 39, 0, 1),
(75, '06123458', 15, 0, 1),
(76, '06123458', 16, 0, 1),
(77, '06123458', 29, 0, 1),
(78, '06123458', 32, 0, 1),
(79, '06123458', 41, 0, 1),
(80, '06123458', 20, 4, 1),
(81, '06123458', 42, 0, 1),
(82, '06123458', 22, 2, 1),
(83, '06123458', 45, 0, 1),
(84, '06123458', 38, 0, 1),
(85, '06123459', 34, 0, 1),
(86, '06123459', 16, 0, 1),
(87, '06123459', 29, 0, 1),
(88, '06123459', 32, 0, 1),
(89, '06123459', 19, 0, 1),
(90, '06123459', 20, 4, 1),
(91, '06123459', 21, 0, 1),
(92, '06123459', 22, 2, 1),
(93, '06123459', 44, 0, 1),
(94, '06123459', 38, 0, 1),
(95, '061234510', 35, 0, 1),
(96, '061234510', 33, 0, 1),
(97, '061234510', 29, 0, 1),
(98, '061234510', 31, 0, 1),
(99, '061234510', 40, 0, 1),
(100, '061234510', 20, 2, 1),
(101, '061234510', 21, 0, 1),
(102, '061234510', 22, 2, 1),
(103, '061234510', 44, 0, 1),
(104, '061234510', 38, 0, 1),
(125, '061234515', 34, 0, 2),
(126, '061234515', 33, 0, 2),
(127, '061234515', 27, 0, 2),
(128, '061234515', 31, 0, 2),
(129, '061234515', 19, 0, 2),
(130, '061234515', 20, 3, 2),
(131, '061234515', 21, 0, 2),
(132, '061234515', 22, 1, 2),
(133, '061234515', 23, 0, 2),
(134, '061234515', 24, 0, 2),
(145, '06123457', 34, 0, 2),
(146, '06123457', 16, 0, 2),
(147, '06123457', 26, 0, 2),
(148, '06123457', 32, 0, 2),
(149, '06123457', 41, 0, 2),
(150, '06123457', 20, 3, 2),
(151, '06123457', 42, 0, 2),
(152, '06123457', 22, 2, 2),
(153, '06123457', 45, 0, 2),
(154, '06123457', 39, 0, 2),
(155, '06123459', 34, 0, 2),
(156, '06123459', 16, 0, 2),
(157, '06123459', 26, 0, 2),
(158, '06123459', 31, 0, 2),
(159, '06123459', 40, 0, 2),
(160, '06123459', 20, 1, 2),
(161, '06123459', 43, 0, 2),
(162, '06123459', 22, 3, 2),
(163, '06123459', 45, 0, 2),
(164, '06123459', 39, 0, 2),
(165, '06123458', 15, 0, 2),
(166, '06123458', 16, 0, 2),
(167, '06123458', 28, 0, 2),
(168, '06123458', 31, 0, 2),
(169, '06123458', 40, 0, 2),
(170, '06123458', 20, 2, 2),
(171, '06123458', 43, 0, 2),
(172, '06123458', 22, 3, 2),
(173, '06123458', 45, 0, 2),
(174, '06123458', 38, 0, 2),
(424, '061234513', 34, 0, 1),
(425, '061234513', 16, 0, 1),
(426, '061234513', 29, 0, 1),
(427, '061234513', 32, 0, 1),
(428, '061234513', 19, 0, 1),
(429, '061234513', 20, 4, 1),
(430, '061234513', 21, 0, 1),
(431, '061234513', 22, 2, 1),
(432, '061234513', 44, 0, 1),
(433, '061234513', 38, 0, 1),
(434, '061234516', 35, 0, 1),
(435, '061234516', 33, 0, 1),
(436, '061234516', 29, 0, 1),
(437, '061234516', 31, 0, 1),
(438, '061234516', 40, 0, 1),
(439, '061234516', 20, 2, 1),
(440, '061234516', 21, 0, 1),
(441, '061234516', 22, 2, 1),
(442, '061234516', 44, 0, 1),
(443, '061234516', 38, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hasil_seleksi`
--

CREATE TABLE `hasil_seleksi` (
  `id` int(11) NOT NULL,
  `nilai` float NOT NULL,
  `nidn` varchar(20) NOT NULL,
  `periode` int(11) NOT NULL,
  `prodi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil_seleksi`
--

INSERT INTO `hasil_seleksi` (`id`, `nilai`, `nidn`, `periode`, `prodi`) VALUES
(92, 0.075, '061234515', 2, 'TI'),
(93, -0.05, '06123457', 2, 'TI'),
(97, 0.1, '06123456', 1, 'TI'),
(98, -0.15, '06123457', 1, 'TI'),
(99, -0.15, '06123458', 1, 'TI'),
(100, -0.025, '06123459', 1, 'TI'),
(101, 0.225, '061234510', 1, 'TI'),
(103, -0.05, '06123458', 2, 'TI'),
(104, 0.025, '06123459', 2, 'TI');

-- --------------------------------------------------------

--
-- Table structure for table `input_parameter`
--

CREATE TABLE `input_parameter` (
  `id` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `tipe` int(11) NOT NULL,
  `q` float NOT NULL,
  `p` float NOT NULL,
  `periode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `input_parameter`
--

INSERT INTO `input_parameter` (`id`, `id_kriteria`, `tipe`, `q`, `p`, `periode`) VALUES
(181, 21, 1, 0, 0, 2),
(182, 22, 1, 0, 0, 2),
(183, 23, 1, 0, 0, 2),
(184, 24, 0, 1, 0.5, 2),
(185, 25, 2, 0, 1, 2),
(186, 26, 1, 0, 0, 2),
(187, 27, 1, 0, 0, 2),
(188, 28, 1, 0, 0, 2),
(189, 29, 0, 3, 1, 2),
(190, 30, 1, 0, 0, 2),
(201, 21, 1, 0, 0, 1),
(202, 22, 1, 0, 0, 1),
(203, 23, 1, 0, 0, 1),
(204, 24, 2, 1, 0, 1),
(205, 25, 2, 1, 0, 1),
(206, 26, 4, 0.5, 1, 1),
(207, 27, 1, 0, 0, 1),
(208, 28, 1, 0, 0, 1),
(209, 29, 2, 1, 0, 1),
(210, 30, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `bobot` float NOT NULL,
  `jenis` varchar(10) NOT NULL,
  `simbol` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `nama`, `bobot`, `jenis`, `simbol`) VALUES
(21, 'Nilai Rata-Rata Kuesioner mahasiswa', 0.05, 'MAX', 'X1'),
(22, 'Kesesuaian RPP', 0, 'MAX', 'X2'),
(23, 'Kedisiplinan jumlah kehadiran', 0.1, 'MAX', 'X3'),
(24, 'Kedisiplinan pengumpulan berkas soal dan nilai', 0.125, 'MAX', 'X4'),
(25, 'Penelitian', 0.1, 'MAX', 'X5'),
(26, 'Pengabdian', 0.125, 'MAX', 'X6'),
(27, 'Penulisan artikel ilmiah', 0.1, 'MAX', 'X7'),
(28, 'Penyusunan modul', 0.125, 'MAX', 'X8'),
(29, 'Penyusunan buku', 0.1, 'MAX', 'X9'),
(30, 'Pembicara seminar', 0.125, 'MAX', 'X10');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(15) NOT NULL,
  `prodi` enum('SI','TI') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `username`, `password`, `level`, `prodi`) VALUES
(1, 'Zaenurr', 'zaenur.rochman98@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'superadmin', 'TI'),
(4, 'Zaenur Rochman', 'zaenur.rochman98@gmail.com', 'admin TI', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'TI'),
(5, 'Zaenur Rochman', 'zaenur.rochman98@gmail.com', 'admin SI', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'SI');

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE `periode` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`id`, `nama`, `keterangan`) VALUES
(1, '2018/2019', 'aman yakan'),
(2, '2019/2020', '');

-- --------------------------------------------------------

--
-- Table structure for table `subkriteria`
--

CREATE TABLE `subkriteria` (
  `id` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `bobot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subkriteria`
--

INSERT INTO `subkriteria` (`id`, `id_kriteria`, `nama`, `bobot`) VALUES
(15, 21, 'Rata-rata 80-100', 4),
(16, 22, 'Sesuai', 4),
(19, 25, 'Penelitian Internasional', 4),
(20, 26, 'input', 0),
(21, 27, 'Jurnal Internasional', 4),
(22, 28, 'input', 0),
(23, 29, 'Buku Penerbit Internasional', 4),
(24, 30, 'Pembicara Seminar Internasional', 4),
(26, 23, 'Rata-rata 80-100', 4),
(27, 23, 'Rata-rata 70-79', 3),
(28, 23, 'Rata-rata 60-69', 2),
(29, 23, 'Rata-rata 50-59', 1),
(30, 23, 'Rata-rata < 50', 0),
(31, 24, 'Disiplin', 4),
(32, 24, 'Tidak Disiplin', 1),
(33, 22, 'Tidak Sesuai', 1),
(34, 21, 'Rata-rata 70-79', 3),
(35, 21, 'Rata-rata 60-69', 2),
(36, 21, 'Rata-rata 50-59', 1),
(37, 21, 'Rata-rata < 50', 0),
(38, 30, 'Pembicara Seminar Nasional', 3),
(39, 30, 'Tidak Ada', 1),
(40, 25, 'Penelitian Nasional', 3),
(41, 25, 'Tidak ada penelitian', 1),
(42, 27, 'Jurnal Nasional', 3),
(43, 27, 'Tidak ada karya ilmiah', 1),
(44, 29, 'Buku Penerbit Nasional', 3),
(45, 29, 'Tidak ada penyusunan', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nidn`);

--
-- Indexes for table `dosen_subkriteria`
--
ALTER TABLE `dosen_subkriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_calon_subkriteria` (`nidn`),
  ADD KEY `fk_subkriteria_calon` (`id_subkriteria`);

--
-- Indexes for table `hasil_seleksi`
--
ALTER TABLE `hasil_seleksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `input_parameter`
--
ALTER TABLE `input_parameter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subkriteria` (`id_kriteria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dosen_subkriteria`
--
ALTER TABLE `dosen_subkriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=444;
--
-- AUTO_INCREMENT for table `hasil_seleksi`
--
ALTER TABLE `hasil_seleksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT for table `input_parameter`
--
ALTER TABLE `input_parameter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;
--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `subkriteria`
--
ALTER TABLE `subkriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen_subkriteria`
--
ALTER TABLE `dosen_subkriteria`
  ADD CONSTRAINT `fk_calon_subkriteria` FOREIGN KEY (`nidn`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `fk_subkriteria_calon` FOREIGN KEY (`id_subkriteria`) REFERENCES `subkriteria` (`id`);

--
-- Constraints for table `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD CONSTRAINT `fk_subkriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
