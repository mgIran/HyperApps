/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : ym_tablo_db

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-02-10 03:41:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ym_ticket_messages
-- ----------------------------
DROP TABLE IF EXISTS `ym_ticket_messages`;
CREATE TABLE `ym_ticket_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_text` varchar(2000) NOT NULL,
  `seen` tinyint(1) unsigned DEFAULT '0',
  `reply` tinyint(1) unsigned DEFAULT '0',
  `ticket_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`),
  CONSTRAINT `ym_ticket_messages_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ym_tickets` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_ticket_messages
-- ----------------------------

-- ----------------------------
-- Table structure for ym_tickets
-- ----------------------------
DROP TABLE IF EXISTS `ym_tickets`;
CREATE TABLE `ym_tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `status` enum('open','close','pending') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_tickets
-- ----------------------------
