/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50539
Source Host           : localhost:3306
Source Database       : autoupdate

Target Server Type    : MYSQL
Target Server Version : 50539
File Encoding         : 65001

Date: 2015-01-02 19:41:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for atu_config
-- ----------------------------
DROP TABLE IF EXISTS `atu_config`;
CREATE TABLE `atu_config` (
  `name` varchar(255) NOT NULL,
  `datas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of atu_config
-- ----------------------------
INSERT INTO `atu_config` VALUES ('6ccc3e8973d031a8d6dd07d9ddaf45261825cc14', '?.TXd1aGhITi1GQkJaRjI3LXJ6MW1tUE0tRXlodFFpYi1rdTBVUWwx');
INSERT INTO `atu_config` VALUES ('8e23c6c43f2c87cd4363c848634e0b5c7e85a4f1', '?.Sk9KMTIzS0ZOb2k5MjNMS0pBV0U');
INSERT INTO `atu_config` VALUES ('789ed23e1592aa985bfc0590bbbd2231459d0d74', '?.T09KSkFTRElKT0lKT0lKT0lRV0VPSk1YTEtNSk9JUUpXT0pFT0lK');
INSERT INTO `atu_config` VALUES ('932ff337bab2b098e1326b3b7ee255dc5f0e76b9', '?.dW5kZWZpbmVk');
INSERT INTO `atu_config` VALUES ('ef254cb06d233e7538164e17d85ad7f78a2b2270', '?.MTQwMDgzMjQxMQ');
INSERT INTO `atu_config` VALUES ('03156c5c9661e82c3f1f3460f9d2b34345e733d9', '?.bG9jYWxob3N0');
INSERT INTO `atu_config` VALUES ('2690c54cc96b6fdbbb1d511792c416ce9c2a4789', '?.cm9vdA');
INSERT INTO `atu_config` VALUES ('97f1e0b31b07d66ad0beee0043eb152eb7882799', '?.cm9vdA');
INSERT INTO `atu_config` VALUES ('4a3c081112906811097e08eff2bf334b634274ba', '?.bWluZWNyYWZ0');
INSERT INTO `atu_config` VALUES ('745fd5f3ff037573d4f1ac944f2c3c9a86ec1bb0', '?.YXV0aG1l');
INSERT INTO `atu_config` VALUES ('9f6f6d7b426c569fd9d2d77310d9fd4cc3196f8b', '?.dXNlcm5hbWU');
INSERT INTO `atu_config` VALUES ('b5f8c58f6fa3f959cc768e26577629685fba7671', '?.cGFzc3dvcmQ');

-- ----------------------------
-- Table structure for atu_group
-- ----------------------------
DROP TABLE IF EXISTS `atu_group`;
CREATE TABLE `atu_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `update_list` int(1) DEFAULT NULL,
  `update_add` int(1) DEFAULT NULL,
  `user_list` int(1) DEFAULT NULL,
  `user_add` int(1) DEFAULT NULL,
  `group_list` int(1) DEFAULT NULL,
  `group_add` int(1) DEFAULT NULL,
  `news_list` int(1) DEFAULT NULL,
  `news_add` int(1) DEFAULT NULL,
  `setting_view` int(1) DEFAULT NULL,
  `setting_change` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of atu_group
-- ----------------------------
INSERT INTO `atu_group` VALUES ('1', 'Onwers', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `atu_group` VALUES ('3', 'Demo', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for atu_news
-- ----------------------------
DROP TABLE IF EXISTS `atu_news`;
CREATE TABLE `atu_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `dated` datetime DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `stats` enum('true','false') DEFAULT 'true',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of atu_news
-- ----------------------------

-- ----------------------------
-- Table structure for atu_plugin_login_log
-- ----------------------------
DROP TABLE IF EXISTS `atu_plugin_login_log`;
CREATE TABLE `atu_plugin_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log` text,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of atu_plugin_login_log
-- ----------------------------
INSERT INTO `atu_plugin_login_log` VALUES ('1', '[23:32:33 07-11-2014] <span class=\'text-red\'>ผู้เล่นที่อ้างชื่อว่า <b>phoomin2012</b> ได้เข้าสู่ระบบผ่าน Launcher ไม่สำเร็จ</span>');
INSERT INTO `atu_plugin_login_log` VALUES ('2', '[23:32:54 07-11-2014] <span class=\'text-red\'>ผู้เล่นที่อ้างชื่อว่า <b>phoomin2012</b> ได้เข้าสู่ระบบผ่าน Launcher ไม่สำเร็จ</span>');
INSERT INTO `atu_plugin_login_log` VALUES ('3', '[23:33:34 07-11-2014] <span class=\'text-red\'>ผู้เล่นที่อ้างชื่อว่า <b>phoomin2012</b> ได้เข้าสู่ระบบผ่าน Launcher ไม่สำเร็จ</span>');
INSERT INTO `atu_plugin_login_log` VALUES ('4', '[23:34:06 07-11-2014] <span class=\'text-red\'>ผู้เล่นที่อ้างชื่อว่า <b>phoomin2012</b> ได้เข้าสู่ระบบผ่าน Launcher ไม่สำเร็จ</span>');
INSERT INTO `atu_plugin_login_log` VALUES ('5', '[23:34:22 07-11-2014] <span class=\'text-red\'>ผู้เล่นที่อ้างชื่อว่า <b>phoomin2012</b> ได้เข้าสู่ระบบผ่าน Launcher ไม่สำเร็จ</span>');
INSERT INTO `atu_plugin_login_log` VALUES ('6', '[23:36:14 07-11-2014] <span class=\'text-red\'>ผู้เล่นที่อ้างชื่อว่า <b>phoomin2012</b> ได้เข้าสู่ระบบผ่าน Launcher ไม่สำเร็จ</span>');
INSERT INTO `atu_plugin_login_log` VALUES ('7', '[23:39:17 07-11-2014] <span class=\'text-red\'>ผู้เล่นที่อ้างชื่อว่า <b>phoomin2012</b> ได้เข้าสู่ระบบผ่าน Launcher ไม่สำเร็จ</span>');
INSERT INTO `atu_plugin_login_log` VALUES ('8', '[23:40:40 07-11-2014] <span class=\'text-red\'>ผู้เล่นที่อ้างชื่อว่า <b>phoomin2012</b> ได้เข้าสู่ระบบผ่าน Launcher ไม่สำเร็จ</span>');

-- ----------------------------
-- Table structure for atu_user
-- ----------------------------
DROP TABLE IF EXISTS `atu_user`;
CREATE TABLE `atu_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of atu_user
-- ----------------------------
INSERT INTO `atu_user` VALUES ('1', 'phoomin009@gmail.com', '7a9fc11d', 'ภูมินทร์', 'Onwers');
INSERT INTO `atu_user` VALUES ('2', 'demo@demo.demo', 'f9950adc', 'Demo', 'Onwers');

-- ----------------------------
-- Table structure for atu_version
-- ----------------------------
DROP TABLE IF EXISTS `atu_version`;
CREATE TABLE `atu_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `enabled` enum('true','false') DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of atu_version
-- ----------------------------
INSERT INTO `atu_version` VALUES ('28', '2.0.0.0', '2015-01-02 12:33:02', 'true');
INSERT INTO `atu_version` VALUES ('24', '1.0.0.0', '2014-11-07 20:16:05', 'true');
