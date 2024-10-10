-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2024 at 10:23 AM
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
-- Database: `tabel_peminjmana`
--

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_advanced`
--

CREATE TABLE `peminjaman_advanced` (
  `id_peminjaman` int(11) NOT NULL,
  `tanggal_usulan` date NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `nama_peminjam` varchar(255) NOT NULL,
  `surat_peminjaman` varchar(255) DEFAULT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman_advanced`
--

INSERT INTO `peminjaman_advanced` (`id_peminjaman`, `tanggal_usulan`, `nama_kegiatan`, `nama_peminjam`, `surat_peminjaman`, `waktu_mulai`, `waktu_selesai`) VALUES
(1, '2024-10-15', 'Seminar Teknologi', 'Andi Setiawan', 'surat_peminjaman_001.pdf', '09:00:00', '11:00:00'),
(2, '2024-10-16', 'Workshop Desain Grafis', 'Budi Santoso', NULL, '13:00:00', '15:00:00'),
(3, '2024-10-17', 'Pelatihan Kepemimpinan', 'Citra Dewi', 'surat_peminjaman_002.pdf', '10:00:00', '12:00:00'),
(4, '2024-10-18', 'Acara Musik Kampus', 'Dewi Sari', NULL, '14:00:00', '17:00:00'),
(5, '2024-10-19', 'Diskusi Publik', 'Eka Putra', 'surat_peminjaman_003.pdf', '08:00:00', '10:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
