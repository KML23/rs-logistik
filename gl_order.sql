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

 Date: 14/02/2025 14:36:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for gl_order
-- ----------------------------
DROP TABLE IF EXISTS `gl_order`;
CREATE TABLE `gl_order`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `tgl_order` date NOT NULL,
  `id_gl_supplier` int(0) NOT NULL,
  `tgl_datang` date NOT NULL,
  `no_faktur` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int(0) NOT NULL,
  `hapus` int(0) NOT NULL,
  `tgl_insert` datetime(0) NOT NULL,
  `tgl_update` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP(0),
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Tabel Master Supplier' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for gl_order_barang
-- ----------------------------
DROP TABLE IF EXISTS `gl_order_barang`;
CREATE TABLE `gl_order_barang`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `id_gl_order` int(0) NOT NULL,
  `id_gl_data_barang` int(0) NOT NULL,
  `jml_barang` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga_beli` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_beli` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `hapus` int(0) NOT NULL,
  `tgl_insert` datetime(0) NOT NULL,
  `tgl_update` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP(0),
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Tabel Data Order' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for gl_supplier
-- ----------------------------
DROP TABLE IF EXISTS `gl_supplier`;
CREATE TABLE `gl_supplier`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int(0) NOT NULL,
  `hapus` int(0) NOT NULL,
  `tgl_insert` datetime(0) NOT NULL,
  `tgl_update` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP(0),
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Tabel Master Supplier' ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
