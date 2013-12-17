/*
Navicat MySQL Data Transfer

Source Server         : virtual
Source Server Version : 50531
Source Host           : deevdeb:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50531
File Encoding         : 65001

Date: 2013-12-17 07:44:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `annotation` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `date` date DEFAULT NULL,
  `public` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
