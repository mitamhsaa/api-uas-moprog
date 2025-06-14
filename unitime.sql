-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 13 Jun 2025 pada 15.46
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unitime`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_kuliah`
--

CREATE TABLE `jadwal_kuliah` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kode_matkul` varchar(10) NOT NULL,
  `nama_matkul` varchar(100) NOT NULL,
  `kelompok` varchar(10) DEFAULT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_kuliah`
--

INSERT INTO `jadwal_kuliah` (`id`, `user_id`, `kode_matkul`, `nama_matkul`, `kelompok`, `hari`, `jam_mulai`, `jam_selesai`, `ruangan`, `created_at`) VALUES
(1, 1, 'PG119', 'Mobile Programming', 'AE', 'Rabu', '10:40:00', '13:10:00', 'Lab 11', '2025-06-13 11:39:15'),
(2, 1, 'PG184', 'Pemrograman Web', 'AA', 'Selasa', '08:00:00', '10:30:00', 'Lab 2', '2025-06-13 11:39:15'),
(3, 1, 'PG175', 'Jaringan Komputer', 'AC', 'Kamis', '13:25:00', '16:00:00', 'Ruang 832', '2025-06-13 11:39:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kode_matkul` varchar(10) DEFAULT NULL,
  `kelompok` varchar(10) DEFAULT NULL,
  `nama_tugas` varchar(150) NOT NULL,
  `matkul` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `deadline` date NOT NULL,
  `status` enum('belum','proses','selesai') DEFAULT 'belum',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id`, `user_id`, `kode_matkul`, `kelompok`, `nama_tugas`, `matkul`, `deskripsi`, `deadline`, `status`, `created_at`) VALUES
(4, 1, 'PG119', 'AE', 'Tugas UAS - Project Kelompok', 'Mobile Programming', 'Membuat apl menggunakan flutter', '2025-06-18', 'proses', '2025-06-13 11:44:48'),
(5, 1, 'PG184', 'AA', 'Tugas 3 - CRUD', 'Pemrograman Web', 'Buat aplikasi CRUD + DB relasional', '2025-06-22', 'belum', '2025-06-13 11:44:48'),
(6, 1, 'KP041', 'AC', 'Tugas 6 - subnet', 'Jaringan Komputer', 'Konversi subnet mask ke prefix', '2025-06-25', 'selesai', '2025-06-13 11:44:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `universitas` varchar(150) DEFAULT NULL,
  `jurusan` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `universitas`, `jurusan`, `created_at`) VALUES
(1, 'mita', 'mita@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'Universitas Budi Luhur', 'Teknik Informatika', '2025-06-13 11:33:07');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  ADD CONSTRAINT `jadwal_kuliah_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
