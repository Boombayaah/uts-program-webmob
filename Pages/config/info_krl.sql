-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Mar 2026 pada 13.14
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
-- Database: `info_krl`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `found_items`
--

CREATE TABLE `found_items` (
  `found_item_id` int(11) NOT NULL,
  `reported_by` int(11) NOT NULL,
  `item_name` varchar(150) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(200) NOT NULL,
  `found_date` date NOT NULL,
  `status` enum('Diproses','Menunggu Verifikasi Atasan','Telah Diverifikasi','Dibatalkan','Diserahkan') DEFAULT 'Diproses',
  `file` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` varchar(30) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  `updated_by` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `found_items`
--

INSERT INTO `found_items` (`found_item_id`, `reported_by`, `item_name`, `category`, `description`, `location`, `found_date`, `status`, `file`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 2, 'Dompet Coklat', 'Dompet/Tas', 'Dompet coklat ditemukan di kursi kereta', 'Stasiun Sudirman', '2025-03-02', 'Menunggu Verifikasi Atasan', NULL, '2026-03-11 21:10:06', NULL, '2026-03-11 21:10:06', NULL),
(2, 3, 'HP Samsung A50', 'Elektronik', 'HP Samsung warna hitam', 'Stasiun Bekasi', '2025-03-03', 'Diproses', NULL, '2026-03-11 21:10:06', NULL, '2026-03-11 21:10:06', NULL),
(3, 2, 'Kunci Mobil Toyota', 'Kunci', 'Kunci mobil dengan remote', 'Stasiun Depok', '2025-03-04', 'Diproses', NULL, '2026-03-11 21:10:06', NULL, '2026-03-11 21:10:06', NULL),
(4, 4, 'Tas Laptop Hitam', 'Dompet/Tas', 'Tas laptop berisi charger', 'Stasiun Bogor', '2025-03-05', 'Diproses', NULL, '2026-03-11 21:10:06', NULL, '2026-03-11 21:10:06', NULL),
(5, 3, 'Kartu Member Gym', 'Dokumen', 'Kartu membership fitness', 'Stasiun Palmerah', '2025-03-06', 'Diproses', NULL, '2026-03-11 21:10:06', NULL, '2026-03-11 21:10:06', NULL),
(6, 2, 'Laptop Asus', 'Elektronik', 'Laptop Asus dengan charger', 'Stasiun Bogor', '2025-03-07', 'Diproses', NULL, '2026-03-11 21:11:19', NULL, '2026-03-11 21:11:19', NULL),
(7, 4, 'Kunci Sepeda', 'Kunci', 'Kunci sepeda dengan rantai kecil', 'Stasiun Bekasi', '2025-03-08', 'Diproses', NULL, '2026-03-11 21:11:19', NULL, '2026-03-11 21:11:19', NULL),
(8, 2, 'Ransel Biru', 'Dompet/Tas', 'Tas ransel berisi buku sekolah', 'Stasiun Jatinegara', '2025-03-09', 'Diproses', NULL, '2026-03-11 21:11:19', NULL, '2026-03-11 21:11:19', NULL),
(9, 2, 'SIM A', 'Dokumen', 'SIM A ditemukan di lantai peron', 'Stasiun Klender', '2025-03-10', 'Diproses', NULL, '2026-03-11 21:11:19', NULL, '2026-03-11 21:11:19', NULL),
(10, 3, 'Jam Tangan Digital', 'Aksesoris', 'Jam tangan hitam digital', 'Stasiun Buaran', '2025-03-11', 'Diproses', NULL, '2026-03-11 21:11:19', NULL, '2026-03-11 21:11:19', NULL),
(11, 2, 'Laporan Program Web', 'Dokumen', 'Buku laporan ubm', 'Stasiun Manggarai', '2026-02-22', 'Diproses', '1773846230_Desain tanpa judul (7).png', '2026-03-18 20:41:37', NULL, '2026-03-18 20:41:37', NULL),
(12, 2, 'Laporan Program Web', 'Dokumen', '', 'Stasiun Sudirman', '2006-02-22', 'Diserahkan', 'Desain tanpa judul (7).png', '2026-03-18 22:05:23', NULL, '2026-03-18 22:05:23', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_category`
--

CREATE TABLE `item_category` (
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `item_category`
--

INSERT INTO `item_category` (`category`) VALUES
('Aksesoris'),
('Dokumen'),
('Dompet/Tas'),
('Elektronik'),
('Kunci'),
('Lainnya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lost_reports`
--

CREATE TABLE `lost_reports` (
  `lost_report_id` int(11) NOT NULL,
  `reported_by` int(11) NOT NULL,
  `item_name` varchar(150) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `lost_date` date NOT NULL,
  `status` enum('Sedang Diproses','Telah Ditemukan','Menunggu Pengambilan','Selesai','Dibatalkan') DEFAULT 'Sedang Diproses',
  `file` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` varchar(30) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  `updated_by` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lost_reports`
--

INSERT INTO `lost_reports` (`lost_report_id`, `reported_by`, `item_name`, `category`, `description`, `location`, `lost_date`, `status`, `file`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 5, 'Dompet Kulit Coklat', 'Dompet/Tas', 'Dompet kulit berisi KTP dan ATM', 'Stasiun Sudirman', '2025-03-01', 'Sedang Diproses', NULL, '2026-03-11 21:10:06', NULL, '2026-03-11 21:10:06', NULL),
(4, 5, 'HP iPhone 11', 'Elektronik', 'iPhone warna putih dengan casing biru', 'Stasiun Manggarai', '2025-03-02', 'Sedang Diproses', NULL, '2026-03-11 21:10:06', NULL, '2026-03-11 21:10:06', NULL),
(5, 5, 'Kunci Motor Yamaha', 'Kunci', 'Kunci motor dengan gantungan Doraemon', 'Stasiun Tebet', '2025-03-03', 'Sedang Diproses', NULL, '2026-03-11 21:10:06', NULL, '2026-03-11 21:10:06', NULL),
(6, 5, 'Tas Ransel Abu-abu', 'Dompet/Tas', 'Tas berisi buku kuliah', 'Stasiun Tanah Abang', '2025-03-04', 'Sedang Diproses', NULL, '2026-03-11 21:10:06', NULL, '2026-03-11 21:10:06', NULL),
(7, 5, 'Kartu ATM BCA', 'Dokumen', 'Kartu ATM dengan nama Andi', 'Stasiun Cawang', '2025-03-05', 'Selesai', NULL, '2026-03-11 21:10:06', NULL, '2026-03-11 21:10:06', NULL),
(8, 5, 'Earphone AirPods', 'Elektronik', 'AirPods putih tanpa casing', 'Stasiun Cikini', '2025-03-07', 'Sedang Diproses', NULL, '2026-03-11 21:11:19', NULL, '2026-03-11 21:11:19', NULL),
(9, 5, 'Kunci Rumah', 'Kunci', 'Kunci rumah dengan gantungan karet biru', 'Stasiun Duren Kalibata', '2025-03-08', 'Sedang Diproses', NULL, '2026-03-11 21:11:19', NULL, '2026-03-11 21:11:19', NULL),
(10, 5, 'Tas Selempang Coklat', 'Dompet/Tas', 'Tas kecil berisi uang dan kartu', 'Stasiun Pasar Minggu', '2025-03-09', 'Sedang Diproses', NULL, '2026-03-11 21:11:19', NULL, '2026-03-11 21:11:19', NULL),
(11, 5, 'KTP Atas Nama Budi', 'Dokumen', 'KTP dengan alamat Jakarta Selatan', 'Stasiun Lenteng Agung', '2025-03-10', 'Sedang Diproses', NULL, '2026-03-11 21:11:19', NULL, '2026-03-11 21:11:19', NULL),
(12, 5, 'Gelang Perak', 'Aksesoris', 'Gelang perak kecil', 'Stasiun Universitas Indonesia', '2025-03-11', 'Sedang Diproses', NULL, '2026-03-11 21:11:19', NULL, '2026-03-11 21:11:19', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `matchings`
--

CREATE TABLE `matchings` (
  `matching_id` int(11) NOT NULL,
  `found_item_id` int(11) NOT NULL,
  `lost_report_id` int(11) NOT NULL,
  `matched_by` int(11) NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `approval_status` enum('Pending','Diajukan ke Atasan','Disetujui','Ditolak') DEFAULT 'Pending',
  `supervisor_notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` varchar(30) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  `updated_by` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `matchings`
--

INSERT INTO `matchings` (`matching_id`, `found_item_id`, `lost_report_id`, `matched_by`, `supervisor_id`, `approval_status`, `supervisor_notes`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 1, 3, 4, NULL, 'Diajukan ke Atasan', NULL, '2026-03-15 18:51:02', NULL, '2026-03-15 18:51:02', NULL),
(3, 12, 7, 2, NULL, 'Disetujui', NULL, '2026-03-18 22:07:12', NULL, '2026-03-18 22:07:12', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pickup_schedules`
--

CREATE TABLE `pickup_schedules` (
  `schedule_id` int(11) NOT NULL,
  `matching_id` int(11) NOT NULL,
  `pickup_date` datetime DEFAULT NULL,
  `status` enum('Dijadwalkan','Barang Dikembalikan','Diterima Pelapor') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` varchar(30) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  `updated_by` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pickup_schedules`
--

INSERT INTO `pickup_schedules` (`schedule_id`, `matching_id`, `pickup_date`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 3, '2026-03-19 13:49:48', 'Diterima Pelapor', '2026-03-19 13:50:05', NULL, '2026-03-19 14:34:19', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(30) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Admin Leader', '2026-03-12 13:43:03', 'Fernando', '2026-03-12 13:43:03', 'Fernando'),
(2, 'Admin Staff', '2026-03-12 13:43:03', 'Fernando', '2026-03-12 13:43:03', 'Fernando'),
(3, 'User', '2026-03-12 13:43:03', 'Fernando', '2026-03-12 13:43:03', 'Fernando');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `profile_image` varchar(150) DEFAULT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(16) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` varchar(30) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  `updated_by` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `nik`, `profile_image`, `full_name`, `email`, `phone`, `password_hash`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, '316246151275721', '94132137-7d4fc100-fe7c-11ea-8512-69f90cb65e48.gif', 'Fernando', 's32240137@student.ubm.ac.id', '6216316274121', '$2y$10$Nkh7upIjDdoCtlbHGIt.6OBY7v38gX7PgutM3EZgEGNezIPW1QOnK', '2026-03-12 13:52:30', 'Fernando', '2026-03-12 13:52:30', 'Fernando'),
(2, 2, '312174571857175', 'code.gif', 'Kevin Kan', 's32240135@student.ubm.ac.id', '62162351461757', '$2y$10$4cIRcfoyzWvinqkpcP/om.89HxeLZKvG3JPwbcZRg2ikJ89o50VmC', '2026-03-12 14:03:59', 'Fernando', '2026-03-12 14:03:59', 'Fernando'),
(3, 2, '1283174752182581', '9082df56a85f501054db9067508bb6a9.gif', 'Davin Leaw', 's32240143@student.ubm.ac.id', '6217264165', '$2y$10$XWp0heNGqXdfzkcV5z6mQ.uxoAIEtWckxycdFr7K.SZy.fcw28ImO', '2026-03-12 14:05:29', 'Fernando', '2026-03-12 14:05:29', 'Fernando'),
(4, 2, '1237164671857165', 'nyan-cat.gif', 'Jap Cong Ho', 's32240142@student.ubm.ac.id', '62182717581', '$2y$10$d.Uh6RQqB.jwTdEb1PxAZegbhFgwFOwbauA1TVBI.b6oaTfdcwAuu', '2026-03-12 14:05:29', 'Fernando', '2026-03-12 14:05:29', 'Fernando'),
(5, 3, '1234567891234567', 'snow (1).png', 'Budianto Suryano', 'budiantosuryano@krl.id', '621722364272', '$2y$10$Os3It/IAkMwhqh2meOiFaOVMkCVfz4XmLQFDRCe5k7NAS.oBKHjuu', '2026-03-12 13:46:09', 'Fernando', '2026-03-12 13:46:09', 'Fernando'),
(8, 2, '1234567891011123', 'otter-otters.gif', 'Dummy1', 'dummy1@gmail.com', '62717263162615', '$2y$10$APPPJaNHE74KFMXwucExq.ZC83vAJ3ifCUR9I1HUGZOkl5AqZmcJC', '2026-03-16 19:23:21', NULL, '2026-03-16 19:23:21', NULL),
(9, 2, '1234567891011121', 'funnygifsbox.com-2019-09-15-07-44-38-22.gif', 'Dummy2', 'dummy2@gmail.com', '6212387416256', '$2y$10$4dWaKK8jMHuaezuj3.X2xOp7XY6uIcnF1iZMWLaXe5ApY3fH6DN6m', '2026-03-16 21:03:16', NULL, '2026-03-16 21:03:16', NULL),
(10, 3, '2312417657151651', NULL, 'Suyanto', NULL, '6217231623173132', '$2y$10$6xhOyQ2uvxuh2ejD.afju.Q1p98s378CoZF.iWxPXZYXNVyK.TGfa', '2026-03-18 19:14:50', NULL, '2026-03-18 19:14:50', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `found_items`
--
ALTER TABLE `found_items`
  ADD PRIMARY KEY (`found_item_id`),
  ADD KEY `reported_by` (`reported_by`),
  ADD KEY `found_items_ibfk_2` (`category`);

--
-- Indeks untuk tabel `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`category`);

--
-- Indeks untuk tabel `lost_reports`
--
ALTER TABLE `lost_reports`
  ADD PRIMARY KEY (`lost_report_id`),
  ADD KEY `reported_by` (`reported_by`),
  ADD KEY `lost_reports_ibfk_2` (`category`);

--
-- Indeks untuk tabel `matchings`
--
ALTER TABLE `matchings`
  ADD PRIMARY KEY (`matching_id`),
  ADD KEY `found_item_id` (`found_item_id`),
  ADD KEY `lost_report_id` (`lost_report_id`),
  ADD KEY `matched_by` (`matched_by`),
  ADD KEY `supervisor_id` (`supervisor_id`);

--
-- Indeks untuk tabel `pickup_schedules`
--
ALTER TABLE `pickup_schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `matching_id` (`matching_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `found_items`
--
ALTER TABLE `found_items`
  MODIFY `found_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `lost_reports`
--
ALTER TABLE `lost_reports`
  MODIFY `lost_report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `matchings`
--
ALTER TABLE `matchings`
  MODIFY `matching_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pickup_schedules`
--
ALTER TABLE `pickup_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `found_items`
--
ALTER TABLE `found_items`
  ADD CONSTRAINT `found_items_ibfk_1` FOREIGN KEY (`reported_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `found_items_ibfk_2` FOREIGN KEY (`category`) REFERENCES `item_category` (`category`);

--
-- Ketidakleluasaan untuk tabel `lost_reports`
--
ALTER TABLE `lost_reports`
  ADD CONSTRAINT `lost_reports_ibfk_1` FOREIGN KEY (`reported_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `lost_reports_ibfk_2` FOREIGN KEY (`category`) REFERENCES `item_category` (`category`);

--
-- Ketidakleluasaan untuk tabel `matchings`
--
ALTER TABLE `matchings`
  ADD CONSTRAINT `matchings_ibfk_1` FOREIGN KEY (`found_item_id`) REFERENCES `found_items` (`found_item_id`),
  ADD CONSTRAINT `matchings_ibfk_2` FOREIGN KEY (`lost_report_id`) REFERENCES `lost_reports` (`lost_report_id`),
  ADD CONSTRAINT `matchings_ibfk_3` FOREIGN KEY (`matched_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `matchings_ibfk_4` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `pickup_schedules`
--
ALTER TABLE `pickup_schedules`
  ADD CONSTRAINT `pickup_schedules_ibfk_1` FOREIGN KEY (`matching_id`) REFERENCES `matchings` (`matching_id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
