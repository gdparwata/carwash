-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 01 Des 2025 pada 06.49
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carwash`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aboutus`
--

CREATE TABLE `aboutus` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `aboutus`
--

INSERT INTO `aboutus` (`id`, `judul`, `isi`, `foto`, `created_at`, `updated_at`) VALUES
(5, 'Tentang Cucicar', 'Cucicar adalah jasa Cuci Mobil di Rumah berlangganan yang menawarkan berbagai layanan cuci mobil Bali dengan paket lengkap berkualitas standar car wash profesional.\r\n\r\nCucicar hadir sebagai automotive car wash yang berfokus pada layanan membersihkan mobil, detailing mobil, fogging mobil hingga cuci interior mobil. Kini, Anda tak perlu repot lagi mencari salon mobil terbaik di Jakarta atau poles mobil terdekat.\r\n\r\nCucicar memberikan pelayanan cuci mobil berlangganan terbaik agar Anda merasa memiliki car wash profesional pribadi di rumah.', 'aboutus/D0WiYthP5sraA6iuIur9sM1BKggQ6h14zSfTNcUu.png', '2025-11-30 19:45:46', '2025-11-30 19:45:46'),
(6, 'Sejarah Cucicar', 'CuciCar mulai beroperasi sejak September 2018, berawal dari kebutuhan pribadi sang pendiri yang ingin mobilnya selalu bersih tanpa harus repot mengantre di tempat cuci mobil konvensional.\r\n\r\nNama CuciCar berasal dari gabungan dua kata:\r\nCuci: mencerminkan layanan utama berupa pembersihan kendaraan secara menyeluruh.\r\nCar: berarti mobil, fokus utama dari layanan ini.\r\n\r\nCuciCar hadir sebagai jasa cuci mobil panggilan dan berlangganan yang fleksibel, praktis, dan berkualitas tinggi. Tidak hanya sekadar mencuci, CuciCar juga menawarkan layanan salon mobil profesional langsung di rumah pelanggan—mulai dari cuci, detailing, hingga poles—semua dilakukan dengan standar kebersihan dan ketelitian maksimal.\r\n\r\nDengan komitmen pada kualitas, kenyamanan, dan kepercayaan pelanggan, CuciCar siap menjadi solusi perawatan mobil terbaik untuk masyarakat modern.', 'aboutus/4Lmz2GpGsua9X20bJ1sX96BgZQhuIuQSze4kzhtf.png', '2025-11-30 19:46:43', '2025-11-30 19:46:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `addons`
--

CREATE TABLE `addons` (
  `id_addons` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `addons`
--

INSERT INTO `addons` (`id_addons`, `nama`, `harga`, `created_at`, `updated_at`) VALUES
(1, 'Interior Fragarance', 40000.00, NULL, NULL),
(3, 'jyguhkol', 50000.00, '2025-11-30 03:30:07', '2025-11-30 03:30:07'),
(4, 'kjnl', 60000.00, '2025-11-30 16:35:46', '2025-11-30 16:35:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `blogs`
--

CREATE TABLE `blogs` (
  `id_blog` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_singkat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `tanggal_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id_Booking` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_polisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inprogress',
  `tanggal` datetime NOT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `diskon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_Paket` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_Pegawai` bigint UNSIGNED DEFAULT NULL,
  `id_jenis_kendaraan` bigint UNSIGNED NOT NULL,
  `id_Addons` bigint UNSIGNED DEFAULT NULL,
  `id_Diskon` bigint UNSIGNED DEFAULT NULL,
  `jumlah_uang` decimal(10,2) DEFAULT NULL,
  `kembalian` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id_Booking`, `nama`, `nomor_telepon`, `email`, `alamat`, `nomor_polisi`, `status`, `tanggal`, `catatan`, `harga`, `diskon`, `metode`, `created_at`, `updated_at`, `id_Paket`, `id_user`, `id_Pegawai`, `id_jenis_kendaraan`, `id_Addons`, `id_Diskon`, `jumlah_uang`, `kembalian`) VALUES
(27, 'atmaja', '083119468882', 'geday@gmail.com', 'dzxcfvbnh,m,.', 'DK 1234 ABC', 'Done', '2025-10-23 06:45:00', 'vc', 136000.00, '20.00', 'Tunai', '2025-10-20 14:45:55', '2025-10-20 14:46:04', 1, 2, 3, 1, 1, 3, 150000.00, 14000.00),
(28, 'atmaja', '083119468889', 'anjay1@gmail.com', 'dzxcfvbnh,m,.', 'DK 1234 ABC', 'Done', '2025-10-22 10:37:00', 'cggjhj,./', 170000.00, '0', 'Tunai', '2025-10-20 18:38:07', '2025-10-20 18:38:16', 1, 2, 3, 1, 1, NULL, 200000.00, 30000.00),
(29, 'atmaja', '083119468882', 'gparwata20@gmail.com', 'dzxcfvbnh,m,.', 'DK 1238 ABC', 'Done', '2025-10-20 12:28:00', 'cijok\'l;', 170000.00, '0', 'Tunai', '2025-10-20 20:28:26', '2025-10-21 19:24:28', 1, 2, 3, 1, 1, NULL, 180000.00, 10000.00),
(30, 'Deta', '083119468889', 'anjay@gmail.com', 'dzxcfvbnh,m,.', 'DK 1238 ABC', 'Done', '2025-10-24 10:53:00', 'v bnnjkml;', 136000.00, '20.00', 'Tunai', '2025-10-22 18:54:03', '2025-10-22 18:54:12', 1, 2, 3, 1, 1, 3, 150000.00, 14000.00),
(31, 'atmaja', '08089188621', 'owner@carwash.com', 'dzxcfvbnh,m,.', 'DK 1234 ABC', 'Done', '2025-11-29 21:28:00', 'sadsdfgfghjhknl;,\'', 130000.00, '0', 'Tunai', '2025-11-28 05:28:45', '2025-11-28 05:33:07', 1, 2, 3, 1, 1, NULL, 200000.00, 30000.00),
(32, 'Estevan Buckridge', '083119468882', 'anjay@gmail.com', 'a;lma\';\';', 'DK 1238 ABC', 'Done', '2025-11-28 21:39:00', '2wsedfvg', 170000.00, '0', 'Tunai', '2025-11-28 05:39:44', '2025-11-28 05:39:54', 1, 2, 3, 1, 1, NULL, 200000.00, 30000.00),
(33, 'Estevan Buckridge', '083119468887', 'gparwata20@gmail.com', 'dzxcfvbnh,m,.', 'Eertyuhijokpl[;]', 'Done', '2025-11-29 21:46:00', 'bghbjiokp', 170000.00, '0', 'Tunai', '2025-11-28 05:47:10', '2025-11-28 05:47:19', 1, 2, 3, 1, 1, NULL, 200000.00, 30000.00),
(34, 'Estevan Buckridge', '08089188621', 'anjay@gmail.com', 'dsdxfcgvhbjnkl;\'', 'DK 1234 ABC', 'Done', '2025-11-29 21:54:00', 'dfxfcgvuhijokpl[;\'\\', 170000.00, '0', 'Tunai', '2025-11-28 05:54:42', '2025-11-28 05:54:50', 1, 2, 3, 1, 1, NULL, 180000.00, 10000.00),
(35, 'Estevan Buckridge', '083119468882', 'anjay@gmail.com', 'dfxfcgvhbjnkml,', 'DK 1238 ABC', 'Done', '2025-11-29 22:29:00', 'egsrhdtjgfyguhji\'', 170000.00, '0', 'Tunai', '2025-11-28 06:30:37', '2025-11-29 16:56:56', 1, 2, 3, 1, 1, NULL, 200000.00, 30000.00),
(36, 'Estevan Buckridge', '083119468887', 'anjay@gmail.com', 'dzxcfvbnh,m,.', 'DK 1234 ABC', 'Done', '2025-11-30 08:57:00', 'fgvhbjnmkl;,\'', 170000.00, '0', 'Non Tunai', '2025-11-29 16:57:56', '2025-11-29 16:58:07', 1, 2, 3, 1, 1, NULL, NULL, 0.00),
(37, 'Deta', '083119468882', 'anjay@gmail.com', 'dfxfcgvhbjnkml,', 'DK 1238 ABC', 'Done', '2025-12-02 16:32:00', 'asdcvfgvb n', 170000.00, '0', 'Tunai', '2025-11-30 00:32:50', '2025-11-30 00:33:29', 1, 2, 3, 1, NULL, NULL, 200000.00, 30000.00),
(38, 'anjay', '083119468887', 'owner@carwash.com', 'sfdfgj,khljkl;\'', 'DK 1234 ABC', 'Menunggu Konfirmasi', '2025-12-04 09:12:00', 'sdrftg,yhjulik;', 170000.00, NULL, NULL, '2025-11-30 17:15:54', '2025-11-30 17:15:54', 1, 13, NULL, 1, NULL, NULL, NULL, NULL),
(39, 'anjay', '08089188621', 'owner@carwash.com', 'adszfl;,', 'DK 1238 ABC', 'Done', '2025-12-10 09:16:00', 'szdfngrflj/;kl', 170000.00, NULL, 'Tunai', '2025-11-30 17:16:35', '2025-11-30 17:18:46', 1, 13, 3, 1, NULL, NULL, 200000.00, 30000.00),
(40, 'anjay', '08089188621', 'owner@carwash.com', 'adszfl;,', 'DK 1238 ABC', 'Menunggu Konfirmasi', '2025-12-10 09:16:00', 'szdfngrflj/;kl', 170000.00, NULL, NULL, '2025-11-30 17:20:18', '2025-11-30 17:20:18', 1, 13, NULL, 1, NULL, NULL, NULL, NULL),
(41, 'anjay', '08089188621', 'owner@carwash.com', 'fgvnbmn,m', 'DK 1234 ABC', 'Menunggu Konfirmasi', '2025-12-10 09:25:00', 'dsdnfmhg,jhkjlk', 170000.00, NULL, NULL, '2025-11-30 17:25:20', '2025-11-30 17:25:20', 1, 13, NULL, 1, NULL, NULL, NULL, NULL),
(42, 'anjay', '083119468887', 'owner@carwash.com', 'xdfhghjnk', 'Eertyuhijokpl[;]', 'Menunggu Konfirmasi', '2025-12-04 09:25:00', 'zsl;\'cgfjuhjiokl\'', 170000.00, NULL, NULL, '2025-11-30 17:26:14', '2025-11-30 17:26:14', 1, 13, NULL, 1, NULL, NULL, NULL, NULL),
(43, 'atmaja', '083119468889', 'anjay@gmail.com', 'dfxfcgvhbjnkml,', 'DK 1238 ABC', 'Done', '2025-12-10 10:57:00', 'wzghtrmy,jhkunl', 136000.00, '20.00', 'Tunai', '2025-11-30 18:57:27', '2025-11-30 18:57:45', 1, 2, 3, 1, 1, 3, 140000.00, 4000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `diskons`
--

CREATE TABLE `diskons` (
  `id_Diskon` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `persen` decimal(5,2) NOT NULL,
  `Berlaku_dari` datetime NOT NULL,
  `Berlaku_sampai` datetime NOT NULL,
  `dibuat_oleh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `diskons`
--

INSERT INTO `diskons` (`id_Diskon`, `nama`, `persen`, `Berlaku_dari`, `Berlaku_sampai`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
(3, 'Kepala', 20.00, '2025-10-20 15:53:00', '2025-12-24 15:53:00', 'A', '2025-10-19 23:54:17', '2025-11-30 18:56:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoices`
--

CREATE TABLE `invoices` (
  `id_invoices` bigint UNSIGNED NOT NULL,
  `id_booking` bigint UNSIGNED NOT NULL,
  `tanggal` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `invoices`
--

INSERT INTO `invoices` (`id_invoices`, `id_booking`, `tanggal`, `created_at`, `updated_at`) VALUES
(4, 27, '2025-10-20 22:46:04', '2025-10-20 14:45:55', '2025-10-20 14:46:04'),
(5, 28, '2025-10-21 02:38:16', '2025-10-20 18:38:07', '2025-10-20 18:38:16'),
(6, 29, '2025-10-22 03:24:28', '2025-10-20 20:28:26', '2025-10-21 19:24:28'),
(7, 30, '2025-10-23 02:54:12', '2025-10-22 18:54:03', '2025-10-22 18:54:12'),
(8, 31, '2025-11-28 13:33:07', '2025-11-28 05:28:45', '2025-11-28 05:33:07'),
(9, 32, '2025-11-28 13:39:54', '2025-11-28 05:39:44', '2025-11-28 05:39:54'),
(10, 33, '2025-11-28 13:47:19', '2025-11-28 05:47:10', '2025-11-28 05:47:19'),
(11, 34, '2025-11-28 13:54:50', '2025-11-28 05:54:42', '2025-11-28 05:54:50'),
(12, 35, '2025-11-30 00:56:56', '2025-11-28 06:30:37', '2025-11-29 16:56:56'),
(13, 36, '2025-11-30 00:58:07', '2025-11-29 16:57:56', '2025-11-29 16:58:07'),
(14, 37, '2025-11-30 08:33:29', '2025-11-30 00:32:50', '2025-11-30 00:33:29'),
(15, 39, '2025-12-01 01:18:46', NULL, '2025-11-30 17:18:46'),
(16, 43, '2025-12-01 02:57:45', '2025-11-30 18:57:27', '2025-11-30 18:57:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_kendaraans`
--

CREATE TABLE `jenis_kendaraans` (
  `id_jenis_kendaraan` bigint UNSIGNED NOT NULL,
  `jenis_kendaraan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jenis_kendaraans`
--

INSERT INTO `jenis_kendaraans` (`id_jenis_kendaraan`, `jenis_kendaraan`, `harga`) VALUES
(1, 'Mobil Kecil (City Car)', 40000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `liburs`
--

CREATE TABLE `liburs` (
  `id_libur` bigint UNSIGNED NOT NULL,
  `id_pegawai` bigint UNSIGNED DEFAULT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `liburs`
--

INSERT INTO `liburs` (`id_libur`, `id_pegawai`, `id_user`, `hari`) VALUES
(7, 3, NULL, 'Senin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '2025_08_29_044154_create_cache_table', 1),
(4, '2025_08_29_044211_create_sessions_table', 1),
(5, '2025_08_29_044309_create_jobs_table', 1),
(12, '2025_08_28_235639_create_users_table', 2),
(13, '2025_08_29_054048_create_sessions_table', 2),
(14, '2025_09_08_001926_create_pegawais_table', 2),
(15, '2025_09_08_001927_create_tingkatans_table', 2),
(16, '2025_09_08_002154_create_addons_table', 2),
(17, '2025_09_08_002159_create_diskons_table', 2),
(18, '2025_09_08_002534_create_pakets_table', 2),
(19, '2025_09_08_002639_create_jenis_kendaraans_table', 2),
(20, '2025_09_08_002737_create_bookings_table', 2),
(21, '2025_09_08_002924_create_blogs_table', 2),
(22, '2025_09_08_002939_create_liburs_table', 2),
(23, '2025_09_08_002954_create_invoices_table', 2),
(24, '2025_09_13_181059_add_status_to_blogs_table', 3),
(25, '2025_09_13_182615_update_tanggal_upload_default_on_blogs_table', 4),
(26, '2025_09_17_072755_alter_status_enum_in_bookings_table', 5),
(27, '2025_09_22_220525_change_status_enum_in_bookings_table', 6),
(30, '2025_10_09_041754_remove_unique_constraints_from_bookings_table', 7),
(31, '2025_10_09_080641_add_timestamps_to_pakets_and_tingkatans_tables', 8),
(32, '2025_10_10_035718_add_timestamps_to_invoices_table', 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pakets`
--

CREATE TABLE `pakets` (
  `id_Paket` bigint UNSIGNED NOT NULL,
  `kategori_paket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pakets`
--

INSERT INTO `pakets` (`id_Paket`, `kategori_paket`, `created_at`, `updated_at`) VALUES
(1, 'Paket Cuci', NULL, NULL),
(8, 'Paket Banjirr', '2025-11-29 22:17:04', '2025-11-29 22:18:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket_addons`
--

CREATE TABLE `paket_addons` (
  `id` bigint UNSIGNED NOT NULL,
  `id_paket` bigint UNSIGNED NOT NULL,
  `id_addons` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `paket_addons`
--

INSERT INTO `paket_addons` (`id`, `id_paket`, `id_addons`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(3, 8, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawais`
--

CREATE TABLE `pegawais` (
  `id_Pegawai` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pegawais`
--

INSERT INTO `pegawais` (`id_Pegawai`, `nama`, `email`, `nomor_telepon`) VALUES
(3, 'anjay', 'anjay1@gmail.com', '083119468882');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4TM8TTF4GrvEtzTX1q1HpFTewhlYhFWuJ0rwpDRu', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTVRlY0tCZTlUREYyNjAzT0Jkbm1qRzVaYmRHdVlKWG1WdFEzaDhEciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9ibG9ncyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1764570879);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tingkatans`
--

CREATE TABLE `tingkatans` (
  `id_Tingkatan` bigint UNSIGNED NOT NULL,
  `id_paket` bigint UNSIGNED DEFAULT NULL,
  `Tingkatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tingkatans`
--

INSERT INTO `tingkatans` (`id_Tingkatan`, `id_paket`, `Tingkatan`, `deskripsi`, `harga`, `created_at`, `updated_at`) VALUES
(4, 1, 'Basic', 'dfghm,.', 90000.00, '2025-11-29 22:10:17', '2025-11-29 22:10:17'),
(5, 8, 'Legend', 'xasdvbxfncgbnm', 900000.00, '2025-11-29 22:18:44', '2025-11-29 22:18:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_User` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_belakang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `foto_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user','owner') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_User`, `name`, `nama_belakang`, `email`, `no_telepon`, `alamat`, `foto_profile`, `password`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'anjay', NULL, 'owner@gmail.com', NULL, NULL, 'profile-photos/ucFDqG2d4BxbqXzA59SIRoPwjtVWbdYFiVqSxQUP.jpg', '$2y$12$88o1KgXN/G6LdGXAUoFlNu/mVN7h60Jwc25rVKR6IX.DWI8EMg7n6', 'owner', '2025-09-07 18:33:03', '2025-11-30 19:54:15', NULL),
(13, 'anjay', NULL, 'owner@carwash.com', NULL, NULL, 'profile-photos/uiDiV3AdZgEHKgDsvDHUeiKXR9Drfhg1X5gPnkWn.jpg', '$2y$12$4V1/hnImIGgrcaoqwIifSujOK00krprWzmGKOA03peuhOjy.MjZq6', 'user', '2025-10-20 18:19:32', '2025-11-30 18:58:47', NULL),
(14, 'wik', NULL, 'geday@gmail.com', NULL, NULL, NULL, '$2y$12$avw8QkXD87IMTlxYczT5puke44.90TG0Os1Hnn5WWMK475cOMZ39y', 'admin', '2025-10-21 19:23:35', '2025-10-21 19:23:35', NULL),
(15, 'Asih', 'Atmaja', 'asih@gmail.com', '083119468889', 'wgrsehdt', NULL, '$2y$12$wUnTVZHbEPizyZKyAuUhIuxnu6A7/JKMQvKud/xqX3zsKabmIok6G', 'user', '2025-11-30 07:48:46', '2025-11-30 07:48:46', NULL),
(16, 'agus', 'aja', 'user@gmail.com', '234567890-', 'sdfghjkl', NULL, '$2y$12$OBXQiLxsYPeGUFIb/cHhSOPLHe/hrDdzexq2Z4BMlmHxAgqCmhyI.', 'user', '2025-11-30 19:53:02', '2025-11-30 19:53:02', NULL),
(17, 'agus lagi', NULL, 'admin@gmail.com', NULL, NULL, NULL, '$2y$12$1w..8lQ.dn.2otpzQSgxAOveWZWkY8XbJZtIO9Sc8XSJ39.5jVW/u', 'admin', '2025-11-30 19:53:39', '2025-11-30 19:53:39', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aboutus`
--
ALTER TABLE `aboutus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id_addons`);

--
-- Indeks untuk tabel `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id_blog`),
  ADD KEY `blogs_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id_Booking`),
  ADD KEY `bookings_id_paket_foreign` (`id_Paket`),
  ADD KEY `bookings_id_user_foreign` (`id_user`),
  ADD KEY `bookings_id_pegawai_foreign` (`id_Pegawai`),
  ADD KEY `bookings_id_jenis_kendaraan_foreign` (`id_jenis_kendaraan`),
  ADD KEY `bookings_id_addons_foreign` (`id_Addons`),
  ADD KEY `bookings_id_diskon_foreign` (`id_Diskon`);

--
-- Indeks untuk tabel `diskons`
--
ALTER TABLE `diskons`
  ADD PRIMARY KEY (`id_Diskon`);

--
-- Indeks untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id_invoices`),
  ADD KEY `invoices_id_booking_foreign` (`id_booking`);

--
-- Indeks untuk tabel `jenis_kendaraans`
--
ALTER TABLE `jenis_kendaraans`
  ADD PRIMARY KEY (`id_jenis_kendaraan`);

--
-- Indeks untuk tabel `liburs`
--
ALTER TABLE `liburs`
  ADD PRIMARY KEY (`id_libur`),
  ADD KEY `liburs_id_pegawai_foreign` (`id_pegawai`),
  ADD KEY `liburs_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pakets`
--
ALTER TABLE `pakets`
  ADD PRIMARY KEY (`id_Paket`);

--
-- Indeks untuk tabel `paket_addons`
--
ALTER TABLE `paket_addons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `paket_addons_unique` (`id_paket`,`id_addons`),
  ADD KEY `paket_addons_id_paket_foreign` (`id_paket`),
  ADD KEY `paket_addons_id_addons_foreign` (`id_addons`);

--
-- Indeks untuk tabel `pegawais`
--
ALTER TABLE `pegawais`
  ADD PRIMARY KEY (`id_Pegawai`),
  ADD UNIQUE KEY `pegawais_email_unique` (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tingkatans`
--
ALTER TABLE `tingkatans`
  ADD PRIMARY KEY (`id_Tingkatan`),
  ADD KEY `tingkatans_id_paket_foreign` (`id_paket`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_User`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aboutus`
--
ALTER TABLE `aboutus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `addons`
--
ALTER TABLE `addons`
  MODIFY `id_addons` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id_blog` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id_Booking` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `diskons`
--
ALTER TABLE `diskons`
  MODIFY `id_Diskon` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id_invoices` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `jenis_kendaraans`
--
ALTER TABLE `jenis_kendaraans`
  MODIFY `id_jenis_kendaraan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `liburs`
--
ALTER TABLE `liburs`
  MODIFY `id_libur` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `pakets`
--
ALTER TABLE `pakets`
  MODIFY `id_Paket` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `paket_addons`
--
ALTER TABLE `paket_addons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pegawais`
--
ALTER TABLE `pegawais`
  MODIFY `id_Pegawai` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tingkatans`
--
ALTER TABLE `tingkatans`
  MODIFY `id_Tingkatan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_User` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_User`);

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_id_addons_foreign` FOREIGN KEY (`id_Addons`) REFERENCES `addons` (`id_addons`),
  ADD CONSTRAINT `bookings_id_diskon_foreign` FOREIGN KEY (`id_Diskon`) REFERENCES `diskons` (`id_Diskon`),
  ADD CONSTRAINT `bookings_id_jenis_kendaraan_foreign` FOREIGN KEY (`id_jenis_kendaraan`) REFERENCES `jenis_kendaraans` (`id_jenis_kendaraan`),
  ADD CONSTRAINT `bookings_id_paket_foreign` FOREIGN KEY (`id_Paket`) REFERENCES `pakets` (`id_Paket`),
  ADD CONSTRAINT `bookings_id_pegawai_foreign` FOREIGN KEY (`id_Pegawai`) REFERENCES `pegawais` (`id_Pegawai`),
  ADD CONSTRAINT `bookings_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_User`);

--
-- Ketidakleluasaan untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_id_booking_foreign` FOREIGN KEY (`id_booking`) REFERENCES `bookings` (`id_Booking`);

--
-- Ketidakleluasaan untuk tabel `liburs`
--
ALTER TABLE `liburs`
  ADD CONSTRAINT `liburs_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawais` (`id_Pegawai`),
  ADD CONSTRAINT `liburs_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_User`);

--
-- Ketidakleluasaan untuk tabel `paket_addons`
--
ALTER TABLE `paket_addons`
  ADD CONSTRAINT `paket_addons_id_addons_foreign` FOREIGN KEY (`id_addons`) REFERENCES `addons` (`id_addons`) ON DELETE CASCADE,
  ADD CONSTRAINT `paket_addons_id_paket_foreign` FOREIGN KEY (`id_paket`) REFERENCES `pakets` (`id_Paket`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tingkatans`
--
ALTER TABLE `tingkatans`
  ADD CONSTRAINT `tingkatans_id_paket_foreign` FOREIGN KEY (`id_paket`) REFERENCES `pakets` (`id_Paket`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
