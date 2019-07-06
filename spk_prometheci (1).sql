-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 06 Jul 2019 pada 18.03
-- Versi Server: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `nidn` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `prodi` enum('SI','TI') NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`nidn`, `nama`, `prodi`, `jenis_kelamin`) VALUES
('0601123123', 'Zaenur Rochman', 'SI', 'Laki - Laki'),
('0601123124', 'anggep bae nama dosen 2', 'TI', 'Laki - Laki'),
('0601123125', 'anggep bae nama dosen 3', 'SI', 'Laki - Laki');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen_subkriteria`
--

CREATE TABLE `dosen_subkriteria` (
  `id` int(11) NOT NULL,
  `nidn` varchar(20) NOT NULL,
  `id_subkriteria` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `periode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dosen_subkriteria`
--

INSERT INTO `dosen_subkriteria` (`id`, `nidn`, `id_subkriteria`, `value`, `periode`) VALUES
(15, '0601123123', 15, 320, 0),
(16, '0601123123', 16, 1, 0),
(17, '0601123123', 17, 1, 0),
(18, '0601123123', 18, 1, 0),
(19, '0601123123', 19, 3, 0),
(20, '0601123123', 20, 0, 0),
(21, '0601123123', 21, 0, 0),
(22, '0601123123', 22, 2, 0),
(23, '0601123123', 23, 0, 0),
(24, '0601123123', 24, 2, 0),
(25, '0601123124', 15, 300, 0),
(26, '0601123124', 16, 1, 0),
(27, '0601123124', 17, 1, 0),
(28, '0601123124', 18, 1, 0),
(29, '0601123124', 19, 4, 0),
(30, '0601123124', 20, 1, 0),
(31, '0601123124', 21, 1, 0),
(32, '0601123124', 22, 2, 0),
(33, '0601123124', 23, 0, 0),
(34, '0601123124', 24, 3, 0),
(35, '0601123125', 15, 310, 0),
(36, '0601123125', 16, 1, 0),
(37, '0601123125', 17, 1, 0),
(38, '0601123125', 18, 0, 0),
(39, '0601123125', 19, 2, 0),
(40, '0601123125', 20, 2, 0),
(41, '0601123125', 21, 1, 0),
(42, '0601123125', 22, 1, 0),
(43, '0601123125', 23, 1, 0),
(44, '0601123125', 24, 2, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_seleksi`
--

CREATE TABLE `hasil_seleksi` (
  `id` int(11) NOT NULL,
  `nilai` float NOT NULL,
  `nidn` varchar(20) NOT NULL,
  `periode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `hasil_seleksi`
--

INSERT INTO `hasil_seleksi` (`id`, `nilai`, `nidn`, `periode`) VALUES
(5, 0.00909091, '0601123124', 2),
(16, 0.06, '0601123123', 1),
(17, -2.77556e-17, '0601123124', 1),
(18, -0.06, '0601123125', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `input_parameter`
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
-- Dumping data untuk tabel `input_parameter`
--

INSERT INTO `input_parameter` (`id`, `id_kriteria`, `tipe`, `q`, `p`, `periode`) VALUES
(1, 21, 2, 3, 21, 1),
(2, 22, 3, 32, 2, 1),
(3, 23, 4, 4, 5, 1),
(4, 24, 4, 6, 7, 1),
(5, 25, 5, 8, 9, 1),
(6, 26, 3, 4, 5, 1),
(7, 27, 2, 6, 7, 1),
(8, 28, 1, 2, 1, 1),
(9, 29, 1, 2, 3, 1),
(10, 30, 2, 4, 6, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `bobot` float NOT NULL,
  `jenis` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id`, `nama`, `bobot`, `jenis`) VALUES
(21, 'Nilai Rata-Rata Kuesioner mahasiswa', 0.1, 'MAX'),
(22, 'Kesesuaian SAP', 0.1, 'MAX'),
(23, 'Kedisiplinan jumlah kehadiran', 0.1, 'MAX'),
(24, 'Kedisiplinan pengumpulan berkas soal dan nilai', 0.1, 'MAX'),
(25, 'Penelitian', 0.1, 'MAX'),
(26, 'Pengabdian', 0.1, 'MAX'),
(27, 'Penulisan artike ilmiah', 0.1, 'MAX'),
(28, 'Penyusunan modul', 0.1, 'MAX'),
(29, 'Penyusunan buku', 0.1, 'MAX'),
(30, 'Pembicara seminar', 0.1, 'MAX');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
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
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `username`, `password`, `level`, `prodi`) VALUES
(1, 'Zaenurr', 'zaenur.rochman98@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'superadmin', 'TI'),
(4, 'Zaenur Rochman', 'zaenur.rochman98@gmail.com', 'admin TI', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'TI'),
(5, 'Zaenur Rochman', 'zaenur.rochman98@gmail.com', 'admin SI', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'SI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode`
--

CREATE TABLE `periode` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `periode`
--

INSERT INTO `periode` (`id`, `nama`, `keterangan`) VALUES
(1, '2018/2019', 'aman yakan'),
(2, '2019/2020', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subkriteria`
--

CREATE TABLE `subkriteria` (
  `id` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `bobot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `subkriteria`
--

INSERT INTO `subkriteria` (`id`, `id_kriteria`, `nama`, `bobot`) VALUES
(15, 21, 'input', 0),
(16, 22, 'input', 0),
(17, 23, 'input', 0),
(18, 24, 'input', 0),
(19, 25, 'input', 0),
(20, 26, 'input', 0),
(21, 27, 'input', 0),
(22, 28, 'input', 0),
(23, 29, 'input', 0),
(24, 30, 'input', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `hasil_seleksi`
--
ALTER TABLE `hasil_seleksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `input_parameter`
--
ALTER TABLE `input_parameter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dosen_subkriteria`
--
ALTER TABLE `dosen_subkriteria`
  ADD CONSTRAINT `fk_calon_subkriteria` FOREIGN KEY (`nidn`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `fk_subkriteria_calon` FOREIGN KEY (`id_subkriteria`) REFERENCES `subkriteria` (`id`);

--
-- Ketidakleluasaan untuk tabel `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD CONSTRAINT `fk_subkriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
