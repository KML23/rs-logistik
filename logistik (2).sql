-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 15, 2025 at 10:06 AM
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
-- Database: `logistik`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` int NOT NULL,
  `id_order` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_masuk` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_hitam_barang`
--

CREATE TABLE `daftar_hitam_barang` (
  `id` int NOT NULL,
  `id_barang` int NOT NULL,
  `alasan` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_barang`
--

CREATE TABLE `data_barang` (
  `id` int NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int DEFAULT '0',
  `harga` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_barang`
--

INSERT INTO `data_barang` (`id`, `nama_barang`, `stok`, `harga`, `created_at`) VALUES
(1, 'Kursi', 100, 500000.00, '2025-01-20 18:24:18'),
(3, 'Papan Tulis', 10, 750000.00, '2025-01-20 18:33:25'),
(12, 'Meja', 500, 575000.00, '2025-01-20 19:01:52'),
(13, 'Lemari', 10, 1250000.00, '2025-01-24 00:42:13'),
(14, 'PC', 1, 1.00, '2025-01-30 06:24:52'),
(15, 'Pintu', 3, 3.00, '2025-01-29 23:26:28'),
(16, 'Meja', 1, 1.00, '2025-01-30 00:57:00'),
(17, 'Papan', 50, 10000.00, '2025-02-10 20:22:18'),
(18, 'Jendela', 10, 75000.00, '2025-02-10 20:28:40'),
(19, 'Galon', 5, 15.00, '2025-02-10 23:54:59');

-- --------------------------------------------------------

--
-- Table structure for table `db_menu`
--

CREATE TABLE `db_menu` (
  `id` int NOT NULL,
  `sub_id` int NOT NULL,
  `nama_menu` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `link_page` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `modul` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `faicon` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `urutan` int NOT NULL,
  `status` int NOT NULL,
  `hapus` int NOT NULL,
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Data Menu' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_menu`
--

INSERT INTO `db_menu` (`id`, `sub_id`, `nama_menu`, `link_page`, `modul`, `faicon`, `urutan`, `status`, `hapus`, `tgl_insert`, `tgl_update`, `user_update`) VALUES
(1, 0, 'Dashboard', 'home', 'home', 'fa-home', 1, 1, 0, '0000-00-00 00:00:00', '2018-08-04 12:29:56', ''),
(2, 0, 'User', '', '', 'fa-user', 2, 1, 0, '0000-00-00 00:00:00', '2025-02-12 08:42:59', ''),
(3, 2, 'Data User', 'data-user', 'user_data', '', 1, 1, 0, '0000-00-00 00:00:00', '2025-02-12 08:42:29', ''),
(4, 2, 'User Level', 'user-level', 'user_level', '', 2, 1, 0, '0000-00-00 00:00:00', '2025-02-12 08:43:01', ''),
(5, 0, 'Gudang Logistik', '', '', 'fa-database', 3, 1, 0, '0000-00-00 00:00:00', '2025-02-12 09:06:10', ''),
(6, 5, 'Jenis Barang', 'gl-jenis-barang', 'gl_jenis_barang', 'fa-list-alt', 2, 1, 0, '0000-00-00 00:00:00', '2025-02-12 08:47:55', ''),
(7, 5, 'Data Barang', 'gl-data-barang', 'gl_data_barang', 'fa-archive', 1, 1, 0, '0000-00-00 00:00:00', '2025-02-12 08:47:54', ''),
(8, 5, 'Satuan Barang', 'gl-satuan-barang', 'gl_satuan_barang', 'fa-balance-scale', 3, 1, 0, '0000-00-00 00:00:00', '2025-02-12 08:47:56', ''),
(9, 5, 'Order', 'gl-order', 'gl_order', 'fa-shopping-cart', 5, 1, 0, '0000-00-00 00:00:00', '2025-02-17 09:12:34', ''),
(10, 5, 'Data Supplier', 'gl-data-supplier', 'gl_data_supplier', 'fa-truck', 4, 1, 0, '2025-02-15 04:28:27', '2025-02-17 09:12:37', ''),
(11, 5, 'Order Barang', 'gl-1order-barang\n', 'gl_1order_barang', '', 6, 1, 0, '2025-02-20 07:37:50', '2025-02-20 08:00:30', ''),
(12, 5, 'Barang Keluar', 'gl-barang-keluar', 'gl_barang_keluar', 'fas fa-share-square', 7, 1, 0, '2025-05-15 16:26:12', '2025-05-15 09:26:12', '');

-- --------------------------------------------------------

--
-- Table structure for table `db_setting`
--

CREATE TABLE `db_setting` (
  `id` int NOT NULL,
  `fvar` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fket` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fjenis` int NOT NULL COMMENT '1:instalasi, 2:bpjs, 3:pcare, 4:antrian',
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Data Seting' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_setting`
--

INSERT INTO `db_setting` (`id`, `fvar`, `fket`, `fjenis`, `tgl_insert`, `tgl_update`, `user_update`) VALUES
(1, 'vnama', 'RSU Universitas Muhammadiyah Malang', 1, '0000-00-00 00:00:00', '2019-10-20 13:46:28', ''),
(2, 'vnamasub', 'Universitas Muhammadiyah Malang', 1, '0000-00-00 00:00:00', '2019-10-20 13:46:28', ''),
(3, 'valamat', 'Jl. Raya Tlogomas No. 45 Malang', 1, '0000-00-00 00:00:00', '2019-10-20 13:46:28', ''),
(4, 'vemail', 'hospital@umm.ac.id', 1, '0000-00-00 00:00:00', '2019-10-20 13:46:28', ''),
(5, 'vpemail', '1212121', 1, '0000-00-00 00:00:00', '2019-10-20 13:46:29', ''),
(6, 'vtelp', '09871937', 1, '0000-00-00 00:00:00', '2019-10-20 13:46:29', ''),
(7, 'vlogo1', '', 1, '0000-00-00 00:00:00', '2019-10-20 13:20:26', ''),
(8, 'vlogo2', '', 1, '0000-00-00 00:00:00', '2019-10-20 13:20:29', ''),
(9, 'vket_reservasi', '', 4, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(10, 'vbpjs_kode', '', 2, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(11, 'vbpjs_vclaim_id', '', 2, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(12, 'vbpjs_vclaim_key', '', 2, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(13, 'vbpjs_pcare_user', '', 3, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(14, 'vbpjs_pcare_pwd', '', 3, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(15, 'vbpjs_pcare_kins', '', 3, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(16, 'vbpjs_pcare_kapp', '', 3, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(17, 'vbpjs_pcare_id', '', 3, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(18, 'vbpjs_pcare_key', '', 3, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(19, 'vket_antrian_res', '', 4, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(20, 'vket_antrian_mesin', '', 4, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(21, 'vket_antrian_poli', '', 4, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(22, 'vh_reservasi', '', 4, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(23, 'vexp_bpjs', '', 4, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(24, 'vopen_res', '', 4, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(25, 'vket_antrian_res_font', '', 4, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(26, 'vket_antrian_mesin_font', '', 4, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(27, 'vket_antrian_poli_font', '', 4, '0000-00-00 00:00:00', '2025-02-12 09:00:57', ''),
(28, 'vh_reservasi_akhir', '', 4, '0000-00-00 00:00:00', '2025-02-12 09:00:57', '');

-- --------------------------------------------------------

--
-- Table structure for table `db_user`
--

CREATE TABLE `db_user` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_telp` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keyuser` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_pegawai` int NOT NULL,
  `level_user` int NOT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1:aktif, 2:tidak_aktif',
  `hapus` int NOT NULL DEFAULT '0' COMMENT '0:ada, 1:hapus',
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Data User' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_user`
--

INSERT INTO `db_user` (`id`, `username`, `no_telp`, `password`, `keyuser`, `nama_user`, `id_pegawai`, `level_user`, `status`, `hapus`, `tgl_insert`, `tgl_update`, `user_update`) VALUES
(1, 'admin', '', '*46599E8E892CCE09DDA47A126E3E403EDD09920D', '$2y$12$8pEKE1NGp7oqaJzQAoQ6iOa81glp0R6jUFje7ACmrEw8O0yG0SK6K', 'Administrator', 0, 1, 1, 0, '0000-00-00 00:00:00', '2025-01-15 04:17:57', ''),
(2, 'kemal', '', '*38FF22B44390F5BA9D9A8E2DF2DD7A04C5303A4C', '$2y$12$1kzNkHaJEoZO28V7R1D5P.PjA3c/QRFAdL5.cCruWASKJrRkDQbI2', 'Kemal', 0, 1, 1, 0, '2018-08-17 11:00:11', '2025-02-12 08:44:00', '1,1');

-- --------------------------------------------------------

--
-- Table structure for table `db_user_akses`
--

CREATE TABLE `db_user_akses` (
  `id` int NOT NULL,
  `id_level` int NOT NULL,
  `id_menu` int NOT NULL,
  `hk_add` int NOT NULL,
  `hk_edit` int NOT NULL,
  `hk_delete` int NOT NULL,
  `status` int NOT NULL,
  `hapus` int NOT NULL,
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Hak Akses User' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_user_akses`
--

INSERT INTO `db_user_akses` (`id`, `id_level`, `id_menu`, `hk_add`, `hk_edit`, `hk_delete`, `status`, `hapus`, `tgl_insert`, `tgl_update`, `user_update`) VALUES
(1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-16 17:43:29', ''),
(2, 1, 2, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 06:27:25', ''),
(3, 1, 3, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 06:27:25', ''),
(4, 1, 4, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 06:27:25', ''),
(5, 1, 5, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 06:27:25', ''),
(6, 1, 6, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 06:27:25', ''),
(7, 1, 7, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 06:27:25', ''),
(8, 1, 8, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 06:27:25', ''),
(9, 1, 9, 1, 1, 1, 1, 0, '2000-01-01 00:00:00', '2025-02-15 04:00:10', ''),
(10, 1, 10, 1, 1, 1, 1, 0, '2025-02-15 04:31:00', '2025-02-15 04:31:19', ''),
(11, 1, 11, 1, 1, 1, 0, 0, '2025-02-20 07:39:31', '2025-02-20 08:02:02', ''),
(12, 1, 12, 1, 1, 1, 1, 0, '2025-05-15 16:29:51', '2025-05-15 09:30:09', '');

-- --------------------------------------------------------

--
-- Table structure for table `db_user_level`
--

CREATE TABLE `db_user_level` (
  `id` int NOT NULL,
  `nama_level` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1:aktif, tidak aktif',
  `hapus` int NOT NULL DEFAULT '0' COMMENT '0:ada, 1:hapus',
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Level User' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_user_level`
--

INSERT INTO `db_user_level` (`id`, `nama_level`, `status`, `hapus`, `tgl_insert`, `tgl_update`, `user_update`) VALUES
(1, 'Superadmin', 1, 0, '0000-00-00 00:00:00', '2018-04-09 16:17:01', ''),
(2, 'Administrator', 1, 0, '0000-00-00 00:00:00', '2021-08-29 15:12:01', '415,415,1,1,635,1,1,1,');

-- --------------------------------------------------------

--
-- Table structure for table `distribusi_barang`
--

CREATE TABLE `distribusi_barang` (
  `id` int NOT NULL,
  `id_permintaan` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_distribusi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gl_barang_keluar`
--

CREATE TABLE `gl_barang_keluar` (
  `id_barang_keluar` int NOT NULL,
  `no_transaksi` varchar(30) NOT NULL,
  `nama_unit` varchar(100) NOT NULL,
  `nama_pengambil` varchar(100) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `keterangan` text,
  `hapus` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `gl_barang_keluar_detail`
--

CREATE TABLE `gl_barang_keluar_detail` (
  `id_detail_barang_keluar` int NOT NULL,
  `id_barang_keluar` int NOT NULL,
  `id_barang` int NOT NULL,
  `jumlah_keluar` int NOT NULL,
  `hapus` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `gl_data_barang`
--

CREATE TABLE `gl_data_barang` (
  `id` int NOT NULL,
  `nama_barang` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_gl_jenis_barang` int NOT NULL,
  `id_gl_satuan_barang` int NOT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1: aktif, 2:tidak aktif',
  `hapus` int NOT NULL DEFAULT '0' COMMENT '0: tidak di hapus, 1: dihapus',
  `tgl_insert` datetime NOT NULL,
  `tgl_update` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jml_stok_gudang` varchar(20) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Data Barang Logistik' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `gl_data_barang`
--

INSERT INTO `gl_data_barang` (`id`, `nama_barang`, `id_gl_jenis_barang`, `id_gl_satuan_barang`, `status`, `hapus`, `tgl_insert`, `tgl_update`, `user_update`, `jml_stok_gudang`) VALUES
(1, 'Aqua 1,500ml', 1, 1, 1, 0, '2025-02-14 15:18:53', '2025-05-09 17:01:57', 'admin', '9985'),
(2, 'Aqua 600ml', 1, 1, 1, 0, '2025-02-14 15:18:53', '2025-05-09 17:15:57', 'admin', '0'),
(3, 'Aqua Galon Refill', 1, 2, 1, 0, '2025-02-14 15:18:53', '2025-05-09 17:20:58', 'admin', '50'),
(4, 'Aqua Gelas', 1, 1, 1, 0, '2025-02-14 15:18:53', '2025-05-14 17:21:55', 'admin', '505'),
(5, 'Le Minerale Botol 330', 1, 1, 1, 0, '2025-02-14 15:18:53', '2025-02-14 15:19:18', 'admin', '0'),
(6, 'Qmas Botol 330', 2, 1, 1, 0, '2025-02-14 15:18:53', '2025-04-25 13:00:06', 'admin', '450'),
(7, 'Qmas Gelas', 2, 1, 1, 0, '2025-02-14 15:18:53', '2025-03-11 14:12:38', 'admin', '50'),
(8, 'Amplop Besar', 2, 3, 1, 0, '2025-02-14 15:18:53', '2025-02-14 15:19:23', 'admin', '0'),
(9, 'Amplop Kecil', 2, 3, 1, 0, '2025-02-14 15:18:53', '2025-02-14 15:19:24', 'admin', '0'),
(10, 'Bantalan Stampel', 2, 4, 1, 0, '2025-02-14 15:18:53', '2025-02-14 15:19:28', 'admin', '0'),
(11, 'Binder Clip 111', 2, 3, 1, 0, '2025-02-14 15:18:53', '2025-02-14 15:19:29', 'admin', '0'),
(12, 'Binder Clip 111', 2, 3, 1, 0, '2025-02-14 15:18:53', '2025-02-14 15:19:32', 'admin', '0'),
(13, 'Pulpen Pilot Hitam', 2, 3, 1, 0, '2025-02-14 15:20:00', '2025-02-24 19:01:40', 'admin', '0'),
(14, 'Pulpen Pilot Biru', 2, 3, 1, 0, '2025-02-14 15:20:02', '2025-02-24 19:02:12', 'admin', '0'),
(15, 'Pensil 2B', 2, 3, 1, 0, '2025-02-14 15:20:04', '2025-02-24 19:02:10', 'admin', '0'),
(16, 'Penghapus Kecil', 2, 3, 1, 0, '2025-02-14 15:20:06', '2025-02-24 19:02:07', 'admin', '0'),
(17, 'Penghapus Putih', 2, 3, 1, 0, '2025-02-14 15:20:08', '2025-02-24 19:02:05', 'admin', '0'),
(18, 'Penggaris Besi 30cm', 2, 3, 1, 0, '2025-02-14 15:20:10', '2025-02-24 19:02:02', 'admin', '0'),
(19, 'Stapler Joyko Kecil', 2, 3, 1, 0, '2025-02-14 15:20:12', '2025-02-24 19:01:59', 'admin', '0'),
(20, 'Staples Isi No.10', 2, 3, 1, 0, '2025-02-14 15:20:14', '2025-02-24 19:01:56', 'admin', '0'),
(21, 'Kertas HVS A4 70gr', 2, 3, 1, 0, '2025-02-14 15:20:16', '2025-02-24 19:01:54', 'admin', '0'),
(22, 'Kertas HVS A4 80gr', 2, 3, 1, 0, '2025-02-14 15:20:18', '2025-02-24 19:01:51', 'admin', '0'),
(23, 'Kertas Folio 70gr', 2, 3, 1, 0, '2025-02-14 15:20:20', '2025-02-24 19:01:49', 'admin', '0'),
(24, 'Kertas Folio 80gr', 2, 3, 1, 0, '2025-02-14 15:20:22', '2025-02-24 19:01:47', 'admin', '0'),
(25, 'Map Plastik Bening', 2, 4, 1, 0, '2025-02-14 15:30:00', '2025-02-14 15:31:20', 'admin', '0'),
(26, 'Map Folder Kertas', 2, 4, 1, 0, '2025-02-14 15:30:02', '2025-02-14 15:31:20', 'admin', '0'),
(27, 'Bolpoin Standard Hitam', 2, 4, 1, 0, '2025-02-14 15:30:04', '2025-02-14 15:31:20', 'admin', '0'),
(28, 'Bolpoin Standard Biru', 2, 4, 1, 0, '2025-02-14 15:30:06', '2025-02-14 15:31:20', 'admin', '0'),
(29, 'Bolpoin Standard Merah', 2, 4, 1, 0, '2025-02-14 15:30:08', '2025-02-14 15:31:20', 'admin', '0'),
(30, 'Correction Tape Joyko', 2, 4, 1, 0, '2025-02-14 15:30:10', '2025-02-14 15:31:20', 'admin', '0'),
(31, 'Correction Pen Pilot', 2, 4, 1, 0, '2025-02-14 15:30:12', '2025-02-14 15:31:20', 'admin', '0'),
(32, 'Sticky Notes Kuning', 2, 3, 1, 0, '2025-02-14 15:30:14', '2025-02-14 15:31:20', 'admin', '0'),
(33, 'Sticky Notes Warna', 2, 3, 1, 0, '2025-02-14 15:30:16', '2025-02-14 15:31:20', 'admin', '0'),
(34, 'Highlighter Stabilo', 2, 4, 1, 0, '2025-02-14 15:30:18', '2025-02-14 15:31:20', 'admin', '0'),
(35, 'Tipe-X Cair', 2, 4, 1, 0, '2025-02-14 15:30:20', '2025-02-14 15:31:20', 'admin', '0'),
(36, 'Gunting Kertas', 2, 4, 1, 0, '2025-02-14 15:30:22', '2025-02-14 15:31:20', 'admin', '0'),
(37, 'Lem Stick UHU', 2, 4, 1, 0, '2025-02-14 15:30:24', '2025-02-14 15:31:20', 'admin', '0'),
(38, 'Lem Cair Fox', 2, 4, 1, 0, '2025-02-14 15:30:26', '2025-02-14 15:31:20', 'admin', '0'),
(39, 'Klip Kertas Besar', 2, 4, 1, 0, '2025-02-14 15:30:28', '2025-02-14 15:31:20', 'admin', '0'),
(40, 'Klip Kertas Kecil', 2, 4, 1, 0, '2025-02-14 15:30:30', '2025-02-14 15:31:20', 'admin', '0'),
(41, 'Lakban Coklat Besar', 2, 1, 1, 0, '2025-02-14 15:30:32', '2025-02-14 15:31:20', 'admin', '0'),
(42, 'Lakban Bening Besar', 2, 1, 1, 0, '2025-02-14 15:30:34', '2025-02-14 15:31:20', 'admin', '0'),
(43, 'Lakban Coklat Kecil', 2, 1, 1, 0, '2025-02-14 15:30:36', '2025-02-14 15:31:20', 'admin', '0'),
(44, 'Lakban Bening Kecil', 2, 1, 1, 0, '2025-02-14 15:30:38', '2025-02-14 15:31:20', 'admin', '0'),
(45, 'Spidol Whiteboard Hitam', 2, 4, 1, 0, '2025-02-14 15:30:40', '2025-02-14 15:31:20', 'admin', '0'),
(46, 'Spidol Whiteboard Merah', 2, 4, 1, 0, '2025-02-14 15:30:42', '2025-02-14 15:31:20', 'admin', '0'),
(47, 'Spidol Whiteboard Biru', 2, 4, 1, 0, '2025-02-14 15:30:44', '2025-02-14 15:31:20', 'admin', '0'),
(48, 'Spidol Permanent Black', 2, 4, 1, 0, '2025-02-14 15:30:46', '2025-02-14 15:31:20', 'admin', '0'),
(49, 'Spidol Permanent Blue', 2, 4, 1, 0, '2025-02-14 15:30:48', '2025-02-14 15:31:20', 'admin', '0'),
(50, 'Spidol Permanent Red', 2, 4, 1, 0, '2025-02-14 15:30:50', '2025-02-14 15:31:20', 'admin', '0');

-- --------------------------------------------------------

--
-- Table structure for table `gl_data_supplier`
--

CREATE TABLE `gl_data_supplier` (
  `id` int NOT NULL,
  `nama_supplier` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int NOT NULL,
  `hapus` int NOT NULL,
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Master Supplier' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `gl_data_supplier`
--

INSERT INTO `gl_data_supplier` (`id`, `nama_supplier`, `status`, `hapus`, `tgl_insert`, `tgl_update`, `user_update`) VALUES
(1, 'Aqua', 1, 0, '2025-02-17 16:54:01', '2025-02-17 11:57:55', 'admin'),
(2, 'Club', 1, 1, '2025-02-17 19:00:46', '2025-02-17 12:00:51', 'admin'),
(3, 'Qmas', 1, 0, '2025-02-17 19:01:00', '2025-02-20 05:10:47', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `gl_jenis_barang`
--

CREATE TABLE `gl_jenis_barang` (
  `id` int NOT NULL,
  `nama_jenis` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int NOT NULL,
  `hapus` int NOT NULL,
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Master Satuan Jenis Logistik' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `gl_jenis_barang`
--

INSERT INTO `gl_jenis_barang` (`id`, `nama_jenis`, `status`, `hapus`, `tgl_insert`, `tgl_update`, `user_update`) VALUES
(1, 'Air Mineral', 1, 0, '2025-02-14 15:18:41', '0000-00-00 00:00:00', 'admin'),
(2, 'Alat Tulis Kantor', 1, 0, '2025-02-14 15:18:41', '0000-00-00 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `gl_order`
--

CREATE TABLE `gl_order` (
  `id` int NOT NULL,
  `tgl_order` date NOT NULL,
  `id_gl_supplier` int NOT NULL,
  `tgl_datang` date NOT NULL,
  `no_faktur` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int NOT NULL,
  `keterangan` varchar(1000) NOT NULL DEFAULT 'none',
  `simpan` int NOT NULL DEFAULT '0',
  `hapus` int NOT NULL,
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Master Supplier' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `gl_order`
--

INSERT INTO `gl_order` (`id`, `tgl_order`, `id_gl_supplier`, `tgl_datang`, `no_faktur`, `status`, `keterangan`, `simpan`, `hapus`, `tgl_insert`, `tgl_update`, `user_update`) VALUES
(14, '2025-05-09', 1, '2025-05-10', 'INV-15375', 1, '-', 0, 0, '2025-05-09 17:22:54', '2025-05-14 10:21:55', 'admin'),
(12, '2025-05-09', 1, '2025-05-10', 'INV-091273', 1, 'Order dibatalkan', 0, 1, '2025-05-09 17:02:32', '2025-05-09 10:15:57', 'admin'),
(11, '2025-05-09', 1, '2025-05-09', 'INV-123456', 1, 'salah', 0, 1, '2025-05-09 17:01:15', '2025-05-09 10:01:57', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `gl_order_barang`
--

CREATE TABLE `gl_order_barang` (
  `id` int NOT NULL,
  `id_gl_order` int NOT NULL,
  `id_gl_data_barang` int NOT NULL,
  `jml_barang` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga_beli` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_beli` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `hapus` int NOT NULL,
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Data Order' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `gl_order_barang`
--

INSERT INTO `gl_order_barang` (`id`, `id_gl_order`, `id_gl_data_barang`, `jml_barang`, `harga_beli`, `total_beli`, `hapus`, `tgl_insert`, `tgl_update`, `user_update`) VALUES
(22, 14, 4, '10', '5000', '50000', 0, '2025-05-09 20:33:59', '2025-05-09 13:33:59', 'admin'),
(21, 14, 4, '15', '5000', '75000', 1, '2025-05-09 17:23:54', '2025-05-09 13:30:20', 'admin'),
(20, 13, 3, '10', '15000', '150000', 1, '2025-05-09 17:20:25', '2025-05-09 10:20:58', 'admin'),
(19, 12, 2, '30', '15000', '450000', 1, '2025-05-09 17:02:47', '2025-05-09 10:15:57', 'admin'),
(18, 11, 1, '10', '5000', '50000', 1, '2025-05-09 17:01:28', '2025-05-09 10:01:57', 'admin'),
(17, 10, 1, '15', '5000', '75000', 1, '2025-05-08 16:33:52', '2025-05-08 10:00:27', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `gl_satuan_barang`
--

CREATE TABLE `gl_satuan_barang` (
  `id` int NOT NULL,
  `nama_satuan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int NOT NULL,
  `hapus` int NOT NULL,
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Master Satuan Barang Logistik' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `gl_satuan_barang`
--

INSERT INTO `gl_satuan_barang` (`id`, `nama_satuan`, `status`, `hapus`, `tgl_insert`, `tgl_update`, `user_update`) VALUES
(1, 'Karton', 1, 0, '2025-02-14 15:18:03', '2025-02-14 08:37:08', 'admin'),
(2, 'Gallon', 1, 0, '2025-02-14 15:18:03', '2025-02-14 08:37:14', 'admin'),
(3, 'Pack', 1, 0, '2025-02-14 15:18:03', '2025-02-14 08:37:48', 'admin'),
(4, 'Buah', 1, 0, '2025-02-14 15:18:03', '2025-02-14 08:37:59', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_barang`
--

CREATE TABLE `permintaan_barang` (
  `id` int NOT NULL,
  `id_barang` int NOT NULL,
  `jumlah` int NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `tanggal_permintaan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stok_opname_barang`
--

CREATE TABLE `stok_opname_barang` (
  `id` int NOT NULL,
  `id_barang` int NOT NULL,
  `stok_aktual` int NOT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$12$KvcRscfpsauMJuMXKr0NGuVhrEuX5AAso1wNF2jVdEgOlS/UbX.l6', '2025-01-20 04:09:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `daftar_hitam_barang`
--
ALTER TABLE `daftar_hitam_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `data_barang`
--
ALTER TABLE `data_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_menu`
--
ALTER TABLE `db_menu`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `db_setting`
--
ALTER TABLE `db_setting`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `db_user`
--
ALTER TABLE `db_user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `db_user_akses`
--
ALTER TABLE `db_user_akses`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `db_user_level`
--
ALTER TABLE `db_user_level`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `distribusi_barang`
--
ALTER TABLE `distribusi_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_permintaan` (`id_permintaan`);

--
-- Indexes for table `gl_barang_keluar`
--
ALTER TABLE `gl_barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`),
  ADD KEY `no_transaksi` (`no_transaksi`),
  ADD KEY `tanggal_transaksi` (`tanggal_transaksi`);

--
-- Indexes for table `gl_barang_keluar_detail`
--
ALTER TABLE `gl_barang_keluar_detail`
  ADD PRIMARY KEY (`id_detail_barang_keluar`),
  ADD KEY `id_barang_keluar` (`id_barang_keluar`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `gl_data_barang`
--
ALTER TABLE `gl_data_barang`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `gl_data_supplier`
--
ALTER TABLE `gl_data_supplier`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `gl_jenis_barang`
--
ALTER TABLE `gl_jenis_barang`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `gl_order`
--
ALTER TABLE `gl_order`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `gl_order_barang`
--
ALTER TABLE `gl_order_barang`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `gl_satuan_barang`
--
ALTER TABLE `gl_satuan_barang`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `stok_opname_barang`
--
ALTER TABLE `stok_opname_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daftar_hitam_barang`
--
ALTER TABLE `daftar_hitam_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_barang`
--
ALTER TABLE `data_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `db_menu`
--
ALTER TABLE `db_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `db_setting`
--
ALTER TABLE `db_setting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `db_user`
--
ALTER TABLE `db_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=960;

--
-- AUTO_INCREMENT for table `db_user_akses`
--
ALTER TABLE `db_user_akses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1554;

--
-- AUTO_INCREMENT for table `db_user_level`
--
ALTER TABLE `db_user_level`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `distribusi_barang`
--
ALTER TABLE `distribusi_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl_barang_keluar`
--
ALTER TABLE `gl_barang_keluar`
  MODIFY `id_barang_keluar` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl_barang_keluar_detail`
--
ALTER TABLE `gl_barang_keluar_detail`
  MODIFY `id_detail_barang_keluar` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl_data_barang`
--
ALTER TABLE `gl_data_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7335;

--
-- AUTO_INCREMENT for table `gl_data_supplier`
--
ALTER TABLE `gl_data_supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gl_jenis_barang`
--
ALTER TABLE `gl_jenis_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gl_order`
--
ALTER TABLE `gl_order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `gl_order_barang`
--
ALTER TABLE `gl_order_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `gl_satuan_barang`
--
ALTER TABLE `gl_satuan_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_opname_barang`
--
ALTER TABLE `stok_opname_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_hitam_barang`
--
ALTER TABLE `daftar_hitam_barang`
  ADD CONSTRAINT `daftar_hitam_barang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id`);

--
-- Constraints for table `distribusi_barang`
--
ALTER TABLE `distribusi_barang`
  ADD CONSTRAINT `distribusi_barang_ibfk_1` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan_barang` (`id`);

--
-- Constraints for table `gl_barang_keluar_detail`
--
ALTER TABLE `gl_barang_keluar_detail`
  ADD CONSTRAINT `gl_barang_keluar_detail_ibfk_1` FOREIGN KEY (`id_barang_keluar`) REFERENCES `gl_barang_keluar` (`id_barang_keluar`) ON DELETE CASCADE;

--
-- Constraints for table `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  ADD CONSTRAINT `permintaan_barang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id`);

--
-- Constraints for table `stok_opname_barang`
--
ALTER TABLE `stok_opname_barang`
  ADD CONSTRAINT `stok_opname_barang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
