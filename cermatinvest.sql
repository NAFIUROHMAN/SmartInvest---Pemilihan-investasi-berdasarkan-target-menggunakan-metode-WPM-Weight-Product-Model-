-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Jun 2025 pada 11.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cermatinvest`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `perbandingan`
--

CREATE TABLE `perbandingan` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_investasi_1` varchar(255) NOT NULL,
  `nama_investasi_2` varchar(255) NOT NULL,
  `winner` varchar(255) NOT NULL,
  `persentase_1` decimal(5,2) NOT NULL,
  `persentase_2` decimal(5,2) NOT NULL,
  `tujuan_investasi` varchar(50) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perbandingan`
--

INSERT INTO `perbandingan` (`id`, `id_user`, `nama_investasi_1`, `nama_investasi_2`, `winner`, `persentase_1`, `persentase_2`, `tujuan_investasi`, `tanggal`) VALUES
(12, 7, 'emas digital', 'properti', 'emas digital', 67.14, 32.86, 'future', '2025-06-17 18:51:19'),
(13, 7, 'emas digital', 'properti', 'properti', 40.37, 59.63, 'cold_money', '2025-06-18 09:44:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perbandingan_detail`
--

CREATE TABLE `perbandingan_detail` (
  `id` int(11) NOT NULL,
  `id_perbandingan` int(11) NOT NULL,
  `kriteria` varchar(50) NOT NULL,
  `bobot` decimal(5,4) NOT NULL,
  `nilai_investasi1` decimal(10,2) NOT NULL,
  `nilai_investasi2` decimal(10,2) NOT NULL,
  `tipe_kriteria` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perbandingan_detail`
--

INSERT INTO `perbandingan_detail` (`id`, `id_perbandingan`, `kriteria`, `bobot`, `nilai_investasi1`, `nilai_investasi2`, `tipe_kriteria`) VALUES
(34, 12, 'return', 0.4000, 30.00, 20.00, 'benefit'),
(35, 12, 'risk', 0.3500, 10.00, 18.00, 'cost'),
(36, 12, 'liquidity', 0.2500, 4.00, 1.00, 'benefit'),
(37, 13, 'return', 0.4000, 30.00, 20.00, 'benefit'),
(38, 13, 'risk', 0.3500, 10.00, 18.00, 'benefit'),
(39, 13, 'liquidity', 0.2500, 4.00, 1.00, 'cost');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `password`, `created_at`) VALUES
(7, 'nafiurohman', 'napik@gmail.com', '$2y$10$KwLktlBFoI9nyfNrUR.b2.RfC3cJj8nMiXRo/Kbaa3Vbv.ILjOhuq', '2025-06-17 11:01:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `perbandingan`
--
ALTER TABLE `perbandingan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `perbandingan_detail`
--
ALTER TABLE `perbandingan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_perbandingan` (`id_perbandingan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `perbandingan`
--
ALTER TABLE `perbandingan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `perbandingan_detail`
--
ALTER TABLE `perbandingan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `perbandingan`
--
ALTER TABLE `perbandingan`
  ADD CONSTRAINT `perbandingan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `perbandingan_detail`
--
ALTER TABLE `perbandingan_detail`
  ADD CONSTRAINT `perbandingan_detail_ibfk_1` FOREIGN KEY (`id_perbandingan`) REFERENCES `perbandingan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
