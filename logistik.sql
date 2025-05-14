/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80030
 Source Host           : localhost:3306
 Source Schema         : logistik

 Target Server Type    : MySQL
 Target Server Version : 80030
 File Encoding         : 65001

 Date: 12/02/2025 16:08:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for db_menu
-- ----------------------------
DROP TABLE IF EXISTS `db_menu`;
CREATE TABLE `db_menu`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `sub_id` int(0) NOT NULL,
  `nama_menu` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `link_page` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `modul` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `faicon` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `urutan` int(0) NOT NULL,
  `status` int(0) NOT NULL,
  `hapus` int(0) NOT NULL,
  `tgl_insert` datetime(0) NOT NULL,
  `tgl_update` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP(0),
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 170 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Tabel Data Menu' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of db_menu
-- ----------------------------
INSERT INTO `db_menu` VALUES (1, 0, 'Dashboard', 'home', 'home', 'fa-home', 1, 1, 0, '0000-00-00 00:00:00', '2018-08-04 19:29:56', '');
INSERT INTO `db_menu` VALUES (2, 0, 'User', '', '', 'fa-user', 2, 1, 0, '0000-00-00 00:00:00', '2025-02-12 15:42:59', '');
INSERT INTO `db_menu` VALUES (3, 2, 'Data User', 'data-user', 'user_data', '', 1, 1, 0, '0000-00-00 00:00:00', '2025-02-12 15:42:29', '');
INSERT INTO `db_menu` VALUES (4, 2, 'User Level', 'user-level', 'user_level', '', 2, 1, 0, '0000-00-00 00:00:00', '2025-02-12 15:43:01', '');
INSERT INTO `db_menu` VALUES (5, 0, 'Gudang Logistik', '', '', 'fa-database', 3, 1, 0, '0000-00-00 00:00:00', '2025-02-12 16:06:10', '');
INSERT INTO `db_menu` VALUES (6, 5, 'Jenis Barang', 'gl-jenis-barang', 'gl_jenis_barang', 'fa-list-alt', 2, 1, 0, '0000-00-00 00:00:00', '2025-02-12 15:47:55', '');
INSERT INTO `db_menu` VALUES (7, 5, 'Data Barang', 'gl-data-barang', 'gl_data_barang', 'fa-archive', 1, 1, 0, '0000-00-00 00:00:00', '2025-02-12 15:47:54', '');
INSERT INTO `db_menu` VALUES (8, 5, 'Satuan Barang', 'gl-satuan-barang', 'gl_satuan_barang', 'fa-balance-scale', 3, 1, 0, '0000-00-00 00:00:00', '2025-02-12 15:47:56', '');
INSERT INTO `db_menu` VALUES (9, 5, 'Order', 'gl-order', 'gl_order', 'fa-shopping-cart', 4, 1, 0, '0000-00-00 00:00:00', '2025-02-12 15:47:56', '');

-- ----------------------------
-- Table structure for db_setting
-- ----------------------------
DROP TABLE IF EXISTS `db_setting`;
CREATE TABLE `db_setting`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `fvar` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fket` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fjenis` int(0) NOT NULL COMMENT '1:instalasi, 2:bpjs, 3:pcare, 4:antrian',
  `tgl_insert` datetime(0) NOT NULL,
  `tgl_update` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP(0),
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 29 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Tabel Data Seting' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of db_setting
-- ----------------------------
INSERT INTO `db_setting` VALUES (1, 'vnama', 'RSU Universitas Muhammadiyah Malang', 1, '0000-00-00 00:00:00', '2019-10-20 20:46:28', '');
INSERT INTO `db_setting` VALUES (2, 'vnamasub', 'Universitas Muhammadiyah Malang', 1, '0000-00-00 00:00:00', '2019-10-20 20:46:28', '');
INSERT INTO `db_setting` VALUES (3, 'valamat', 'Jl. Raya Tlogomas No. 45 Malang', 1, '0000-00-00 00:00:00', '2019-10-20 20:46:28', '');
INSERT INTO `db_setting` VALUES (4, 'vemail', 'hospital@umm.ac.id', 1, '0000-00-00 00:00:00', '2019-10-20 20:46:28', '');
INSERT INTO `db_setting` VALUES (5, 'vpemail', '1212121', 1, '0000-00-00 00:00:00', '2019-10-20 20:46:29', '');
INSERT INTO `db_setting` VALUES (6, 'vtelp', '09871937', 1, '0000-00-00 00:00:00', '2019-10-20 20:46:29', '');
INSERT INTO `db_setting` VALUES (7, 'vlogo1', '', 1, '0000-00-00 00:00:00', '2019-10-20 20:20:26', '');
INSERT INTO `db_setting` VALUES (8, 'vlogo2', '', 1, '0000-00-00 00:00:00', '2019-10-20 20:20:29', '');
INSERT INTO `db_setting` VALUES (9, 'vket_reservasi', '', 4, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (10, 'vbpjs_kode', '', 2, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (11, 'vbpjs_vclaim_id', '', 2, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (12, 'vbpjs_vclaim_key', '', 2, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (13, 'vbpjs_pcare_user', '', 3, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (14, 'vbpjs_pcare_pwd', '', 3, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (15, 'vbpjs_pcare_kins', '', 3, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (16, 'vbpjs_pcare_kapp', '', 3, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (17, 'vbpjs_pcare_id', '', 3, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (18, 'vbpjs_pcare_key', '', 3, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (19, 'vket_antrian_res', '', 4, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (20, 'vket_antrian_mesin', '', 4, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (21, 'vket_antrian_poli', '', 4, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (22, 'vh_reservasi', '', 4, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (23, 'vexp_bpjs', '', 4, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (24, 'vopen_res', '', 4, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (25, 'vket_antrian_res_font', '', 4, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (26, 'vket_antrian_mesin_font', '', 4, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (27, 'vket_antrian_poli_font', '', 4, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');
INSERT INTO `db_setting` VALUES (28, 'vh_reservasi_akhir', '', 4, '0000-00-00 00:00:00', '2025-02-12 16:00:57', '');

-- ----------------------------
-- Table structure for db_user
-- ----------------------------
DROP TABLE IF EXISTS `db_user`;
CREATE TABLE `db_user`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_telp` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keyuser` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_pegawai` int(0) NOT NULL,
  `level_user` int(0) NOT NULL,
  `status` int(0) NOT NULL DEFAULT 1 COMMENT '1:aktif, 2:tidak_aktif',
  `hapus` int(0) NOT NULL DEFAULT 0 COMMENT '0:ada, 1:hapus',
  `tgl_insert` datetime(0) NOT NULL,
  `tgl_update` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 960 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Tabel Data User' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of db_user
-- ----------------------------
INSERT INTO `db_user` VALUES (1, 'admin', '', '*46599E8E892CCE09DDA47A126E3E403EDD09920D', '$2y$12$8pEKE1NGp7oqaJzQAoQ6iOa81glp0R6jUFje7ACmrEw8O0yG0SK6K', 'Administrator', 0, 1, 1, 0, '0000-00-00 00:00:00', '2025-01-15 11:17:57', '');
INSERT INTO `db_user` VALUES (2, 'kemal', '', '*38FF22B44390F5BA9D9A8E2DF2DD7A04C5303A4C', '$2y$12$1kzNkHaJEoZO28V7R1D5P.PjA3c/QRFAdL5.cCruWASKJrRkDQbI2', 'Kemal', 0, 1, 1, 0, '2018-08-17 11:00:11', '2025-02-12 15:44:00', '1,1');

-- ----------------------------
-- Table structure for db_user_akses
-- ----------------------------
DROP TABLE IF EXISTS `db_user_akses`;
CREATE TABLE `db_user_akses`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `id_level` int(0) NOT NULL,
  `id_menu` int(0) NOT NULL,
  `hk_add` int(0) NOT NULL,
  `hk_edit` int(0) NOT NULL,
  `hk_delete` int(0) NOT NULL,
  `status` int(0) NOT NULL,
  `hapus` int(0) NOT NULL,
  `tgl_insert` datetime(0) NOT NULL,
  `tgl_update` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1554 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Tabel Hak Akses User' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of db_user_akses
-- ----------------------------
INSERT INTO `db_user_akses` VALUES (1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-17 00:43:29', '');
INSERT INTO `db_user_akses` VALUES (2, 1, 2, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 13:27:25', '');
INSERT INTO `db_user_akses` VALUES (3, 1, 3, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 13:27:25', '');
INSERT INTO `db_user_akses` VALUES (4, 1, 4, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 13:27:25', '');
INSERT INTO `db_user_akses` VALUES (5, 1, 5, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 13:27:25', '');
INSERT INTO `db_user_akses` VALUES (6, 1, 6, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 13:27:25', '');
INSERT INTO `db_user_akses` VALUES (7, 1, 7, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 13:27:25', '');
INSERT INTO `db_user_akses` VALUES (8, 1, 8, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', '2018-08-01 13:27:25', '');

-- ----------------------------
-- Table structure for db_user_level
-- ----------------------------
DROP TABLE IF EXISTS `db_user_level`;
CREATE TABLE `db_user_level`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `nama_level` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int(0) NOT NULL DEFAULT 1 COMMENT '1:aktif, tidak aktif',
  `hapus` int(0) NOT NULL DEFAULT 0 COMMENT '0:ada, 1:hapus',
  `tgl_insert` datetime(0) NOT NULL,
  `tgl_update` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 47 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Tabel Level User' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of db_user_level
-- ----------------------------
INSERT INTO `db_user_level` VALUES (1, 'Superadmin', 1, 0, '0000-00-00 00:00:00', '2018-04-09 23:17:01', '');
INSERT INTO `db_user_level` VALUES (2, 'Administrator', 1, 0, '0000-00-00 00:00:00', '2021-08-29 22:12:01', '415,415,1,1,635,1,1,1,');

-- ----------------------------
-- Table structure for gl_data_barang
-- ----------------------------
DROP TABLE IF EXISTS `gl_data_barang`;
CREATE TABLE `gl_data_barang`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_gl_jenis_barang` int(0) NOT NULL,
  `id_gl_satuan_barang` int(0) NOT NULL,
  `status` int(0) NOT NULL DEFAULT 1 COMMENT '1: aktif, 2:tidak aktif',
  `hapus` int(0) NOT NULL DEFAULT 0 COMMENT '0: tidak di hapus, 1: dihapus',
  `tgl_insert` datetime(0) NOT NULL,
  `tgl_update` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP(0),
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7323 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Tabel Data Barang Logistik' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gl_data_barang
-- ----------------------------

-- ----------------------------
-- Table structure for gl_jenis_barang
-- ----------------------------
DROP TABLE IF EXISTS `gl_jenis_barang`;
CREATE TABLE `gl_jenis_barang`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int(0) NOT NULL,
  `hapus` int(0) NOT NULL,
  `tgl_insert` datetime(0) NOT NULL,
  `tgl_update` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP(0),
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Tabel Master Satuan Jenis Logistik' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gl_jenis_barang
-- ----------------------------

-- ----------------------------
-- Table structure for gl_satuan_barang
-- ----------------------------
DROP TABLE IF EXISTS `gl_satuan_barang`;
CREATE TABLE `gl_satuan_barang`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int(0) NOT NULL,
  `hapus` int(0) NOT NULL,
  `tgl_insert` datetime(0) NOT NULL,
  `tgl_update` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP(0),
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 66 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Tabel Master Satuan Barang Logistik' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gl_satuan_barang
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
