-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Jan 2026 pada 06.51
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noctics`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(100) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `stok` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `judul`, `stok`) VALUES
(1, 'Guavita', 31),
(2, 'Coconut', 25),
(3, 'Ultramilk', 100),
(4, 'Beng Beng', 30),
(5, 'Indomie Goreng', 120),
(6, 'Indomie Soto', 100),
(7, 'Mie Sedaap Goreng', 90),
(8, 'Mie Sedaap Soto', 85),
(9, 'Aqua Botol 600ml', 200),
(10, 'Le Minerale 600ml', 180),
(11, 'Teh Botol Sosro', 150),
(12, 'Pocari Sweat 500ml', 130),
(13, 'Ultra Milk Coklat 250ml', 110),
(14, 'Ultra Milk Strawberry 250ml', 105),
(15, 'Roma Marie Gold', 95),
(16, 'Biskuit Good Time', 88),
(17, 'Chitato Sapi Panggang', 75),
(18, 'Qtela Original', 70),
(19, 'SilverQueen 55gr', 60),
(20, 'Delfi Dairy Milk', 65),
(21, 'Kecap Bango 135ml', 55),
(22, 'Sambal ABC 135ml', 50),
(23, 'Gula Gulaku 1kg', 40),
(24, 'Minyak Goreng Bimoli 1L', 45);

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(100) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `username_karyawan` varchar(100) NOT NULL,
  `password_karyawan` varchar(100) NOT NULL,
  `notelp_karyawan` int(100) NOT NULL,
  `alamat_karyawan` varchar(255) NOT NULL,
  `created_at` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama_karyawan`, `username_karyawan`, `password_karyawan`, `notelp_karyawan`, `alamat_karyawan`, `created_at`) VALUES
(1, 'ruth', 'ruth', 'ruth', 1234, 'solo', '2024-10-16'),
(2, 'dekta', 'dekta', '', 4566, 'jakarta', '2024-10-16'),
(4, 'Andi Pratama', 'andi01', 'password01', 2147483647, 'Jakarta', '2026-01-30'),
(5, 'Budi Santoso', 'budi02', 'password02', 2147483647, 'Bandung', '2026-01-30'),
(6, 'Citra Lestari', 'citra03', 'password03', 2147483647, 'Surabaya', '2026-01-30'),
(7, 'Dewi Anggraini', 'dewi04', 'password04', 2147483647, 'Yogyakarta', '2026-01-30'),
(8, 'Eko Saputra', 'eko05', 'password05', 2147483647, 'Semarang', '2026-01-30'),
(9, 'Fajar Hidayat', 'fajar06', 'password06', 2147483647, 'Malang', '2026-01-30'),
(10, 'Gina Putri', 'gina07', 'password07', 2147483647, 'Denpasar', '2026-01-30'),
(11, 'Hadi Wijaya', 'hadi08', 'password08', 2147483647, 'Makassar', '2026-01-30'),
(12, 'Intan Permata', 'intan09', 'password09', 2147483647, 'Medan', '2026-01-30'),
(13, 'Joko Susilo', 'joko10', 'password10', 2147483647, 'Solo', '2026-01-30'),
(14, 'Kiki Amelia', 'kiki11', 'password11', 2147483647, 'Bogor', '2026-01-30'),
(15, 'Lukman Hakim', 'lukman12', 'password12', 2147483647, 'Depok', '2026-01-30'),
(16, 'Maya Sari', 'maya13', 'password13', 2147483647, 'Bekasi', '2026-01-30'),
(17, 'Nanda Prakoso', 'nanda14', 'password14', 2147483647, 'Tangerang', '2026-01-30'),
(18, 'Oki Ramadhan', 'oki15', 'password15', 2147483647, 'Cilegon', '2026-01-30'),
(19, 'Putri Anjani', 'putri16', 'password16', 2147483647, 'Purwokerto', '2026-01-30'),
(20, 'Rizki Kurniawan', 'rizki17', 'password17', 2147483647, 'Cirebon', '2026-01-30'),
(21, 'Sinta Maharani', 'sinta18', 'password18', 2147483647, 'Kediri', '2026-01-30'),
(22, 'Taufik Akbar', 'taufik19', 'password19', 2147483647, 'Palembang', '2026-01-30'),
(23, 'Yuni Kartika', 'yuni20', 'password20', 2147483647, 'Pontianak', '2026-01-30');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
