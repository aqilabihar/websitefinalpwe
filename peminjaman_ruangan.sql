-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 08, 2024 at 03:55 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman_ruangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_advanced`
--

CREATE TABLE `peminjaman_advanced` (
  `id_peminjaman` int NOT NULL,
  `tanggal_usulan` date NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_peminjam` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `surat_peminjaman` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman_advanced`
--

INSERT INTO `peminjaman_advanced` (`id_peminjaman`, `tanggal_usulan`, `nama_kegiatan`, `nama_peminjam`, `surat_peminjaman`, `waktu_mulai`, `waktu_selesai`) VALUES
(12, '2024-10-15', 'tidur', 'anonim', '_0_Agenda Akademik_Tahun 2024-2025.pdf', '12:12:00', '13:33:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `peminjaman_advanced`
--
ALTER TABLE `peminjaman_advanced`
  ADD PRIMARY KEY (`id_peminjaman`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `peminjaman_advanced`
--
ALTER TABLE `peminjaman_advanced`
  MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
