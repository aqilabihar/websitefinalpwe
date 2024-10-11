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
  `waktu_mulai` DATE NOT NULL,
  `waktu_selesai` DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman_advanced`
--

INSERT INTO `peminjaman_advanced` (`id_peminjaman`, `tanggal_usulan`, `nama_kegiatan`, `nama_peminjam`, `surat_peminjaman`, `waktu_mulai`, `waktu_selesai`)
VALUES
(1, '2024-10-01', 'Seminar Teknologi', 'Andi Wijaya', 'surat_seminar_001.pdf', '2024-10-10', '2024-10-12'),
(2, '2024-09-20', 'Pelatihan Soft Skill', 'Budi Santoso', 'surat_pelatihan_002.pdf', '2024-10-15', '2024-10-16'),
(3, '2024-09-25', 'Workshop Digital Marketing', 'Citra Dewi', 'surat_workshop_003.pdf', '2024-11-01', '2024-11-02'),
(4, '2024-08-30', 'Rapat Koordinasi', 'Dewi Kurniawan', NULL, '2024-09-05', '2024-09-05'),
(5, '2024-07-15', 'Pameran Seni', 'Eko Pratama', 'surat_pameran_004.pdf', '2024-10-20', '2024-10-22');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
