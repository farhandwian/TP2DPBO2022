/*
 Navicat Premium Data Transfer

 Source Server         : MyConnection
 Source Server Type    : MySQL
 Source Server Version : 100422
 Source Host           : localhost:3306
 Source Schema         : db_ormawa

 Target Server Type    : MySQL
 Target Server Version : 100422
 File Encoding         : 65001

 Date: 20/04/2022 15:26:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bidang_divisi
-- ----------------------------
DROP TABLE IF EXISTS `bidang_divisi`;
CREATE TABLE `bidang_divisi`  (
  `id_bidang` int NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_divisi` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_bidang`) USING BTREE,
  INDEX `id_divisi`(`id_divisi`) USING BTREE,
  CONSTRAINT `bidang_divisi_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bidang_divisi
-- ----------------------------
INSERT INTO `bidang_divisi` VALUES (16, 'Ketua', 11);
INSERT INTO `bidang_divisi` VALUES (18, 'Wakil Ketua', 11);
INSERT INTO `bidang_divisi` VALUES (19, 'Staff', 11);
INSERT INTO `bidang_divisi` VALUES (20, 'Ketua', 13);
INSERT INTO `bidang_divisi` VALUES (21, 'Staff', 13);
INSERT INTO `bidang_divisi` VALUES (23, 'Wakil Ketua', 13);
INSERT INTO `bidang_divisi` VALUES (24, 'Ketua', 15);
INSERT INTO `bidang_divisi` VALUES (25, 'Staff', 15);

-- ----------------------------
-- Table structure for divisi
-- ----------------------------
DROP TABLE IF EXISTS `divisi`;
CREATE TABLE `divisi`  (
  `id_divisi` int NOT NULL AUTO_INCREMENT,
  `nama_divisi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_divisi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of divisi
-- ----------------------------
INSERT INTO `divisi` VALUES (11, 'Keamanan');
INSERT INTO `divisi` VALUES (13, 'Olahraga');
INSERT INTO `divisi` VALUES (15, 'Rohani');

-- ----------------------------
-- Table structure for pengurus
-- ----------------------------
DROP TABLE IF EXISTS `pengurus`;
CREATE TABLE `pengurus`  (
  `nim` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `semester` int NULL DEFAULT NULL,
  `foto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_bidang` int NULL DEFAULT NULL,
  PRIMARY KEY (`nim`) USING BTREE,
  INDEX `id_bidang`(`id_bidang`) USING BTREE,
  CONSTRAINT `pengurus_ibfk_1` FOREIGN KEY (`id_bidang`) REFERENCES `bidang_divisi` (`id_bidang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengurus
-- ----------------------------
INSERT INTO `pengurus` VALUES ('011', 'NN', 5, '1.webp', 16);
INSERT INTO `pengurus` VALUES ('012', 'NN', 4, '2.jpg', 18);
INSERT INTO `pengurus` VALUES ('013', 'NN', 5, '3.jpg', 20);
INSERT INTO `pengurus` VALUES ('014', 'NN', 3, '4.webp', 23);
INSERT INTO `pengurus` VALUES ('015', 'NN', 2, '5.webp', 19);
INSERT INTO `pengurus` VALUES ('016', 'NN', 6, '6.jpeg', 24);
INSERT INTO `pengurus` VALUES ('017', 'NN', 4, '7.jpg', 19);
INSERT INTO `pengurus` VALUES ('018', 'NN', 1, '8.webp', 25);

SET FOREIGN_KEY_CHECKS = 1;
