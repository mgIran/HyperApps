/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : market

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-03-05 13:06:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ym_admins
-- ----------------------------
DROP TABLE IF EXISTS `ym_admins`;
CREATE TABLE `ym_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(11) unsigned NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admins
-- ----------------------------
INSERT INTO `ym_admins` VALUES ('24', 'admin', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'admin@gmial.com', '1');
INSERT INTO `ym_admins` VALUES ('27', 'ad', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'sa@sda.sad', '2');

-- ----------------------------
-- Table structure for ym_admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_admin_roles`;
CREATE TABLE `ym_admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'عنوان نقش',
  `role` varchar(255) NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admin_roles
-- ----------------------------
INSERT INTO `ym_admin_roles` VALUES ('1', 'مدیر', 'admin');
INSERT INTO `ym_admin_roles` VALUES ('2', 'ناظر', 'validator');

-- ----------------------------
-- Table structure for ym_apps
-- ----------------------------
DROP TABLE IF EXISTS `ym_apps`;
CREATE TABLE `ym_apps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `developer_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `status` enum('disable','enable') CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT 'enable',
  `price` double DEFAULT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `description` longtext,
  `change_log` longtext,
  `permissions` longtext,
  `size` float DEFAULT NULL,
  `version` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `confirm` enum('pending','refused','accepted') DEFAULT 'pending',
  `platform_id` int(10) unsigned DEFAULT NULL,
  `developer_team` varchar(50) DEFAULT NULL,
  `seen` tinyint(1) unsigned DEFAULT '0' COMMENT 'دیده شده',
  `download` int(12) unsigned DEFAULT '0' COMMENT 'تعداد دریافت',
  `install` int(12) unsigned DEFAULT '0' COMMENT 'تعداد نصب فعال',
  `deleted` tinyint(1) unsigned DEFAULT '0' COMMENT 'حذف شده',
  PRIMARY KEY (`id`),
  KEY `developer_id` (`developer_id`),
  KEY `category_id` (`category_id`),
  KEY `platform_id` (`platform_id`),
  CONSTRAINT `ym_apps_ibfk_1` FOREIGN KEY (`developer_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_apps_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ym_app_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_apps_ibfk_3` FOREIGN KEY (`platform_id`) REFERENCES `ym_app_platforms` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_apps
-- ----------------------------
INSERT INTO `ym_apps` VALUES ('13', 'بازی ماشین', null, '1', 'enable', '0', 'zB5iA1457094285.xap', 'yaago1457094287.jpg', '<p>asd</p>\r\n', '<p>asd</p>\r\n', '[\"asda\"]', '406084', '1', 'pending', '3', 'سشی');
INSERT INTO `ym_apps` VALUES ('14', 'بازی ماشین', null, '1', 'enable', '0', 'zB5iA1457094285.xap', 'yaago1457094287.jpg', '<p>asd</p>\r\n', '<p>asd</p>\r\n', '[\"asda\"]', '406084', '1', 'pending', '3', 'سشی');
INSERT INTO `ym_apps` VALUES ('15', 'بازی ماشین', '8', '1', 'enable', '0', 'K7V3Y1457111635.apk', 'VYwm61457111636.jpg', '<p>سلام  متن اینجاست</p>\r\n', '<p>خفه شو سبحانی</p>\r\n', '[\"\\u06af\\u0648\\u062a\\u0648\\u0634\"]', '406084', '1', 'pending', '1', null);
INSERT INTO `ym_apps` VALUES ('16', 'بازی ماشین', '8', '1', 'enable', '0', 'h79az1457111994.xap', 'WXiz31457111996.jpg', '<p>asd</p>\r\n', '<p>asd</p>\r\n', null, '406084', '1', 'pending', '3', null);

-- ----------------------------
-- Table structure for ym_app_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_app_categories`;
CREATE TABLE `ym_app_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `path` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `ym_app_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `ym_app_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_app_categories
-- ----------------------------
INSERT INTO `ym_app_categories` VALUES ('1', 'ارتباطات', null, null);
INSERT INTO `ym_app_categories` VALUES ('2', 'آموزش', null, null);
INSERT INTO `ym_app_categories` VALUES ('3', 'سرگرمی', null, null);
INSERT INTO `ym_app_categories` VALUES ('4', 'آب و هوا', null, null);

-- ----------------------------
-- Table structure for ym_app_images
-- ----------------------------
DROP TABLE IF EXISTS `ym_app_images`;
CREATE TABLE `ym_app_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(10) unsigned DEFAULT NULL,
  `image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`app_id`),
  CONSTRAINT `ym_app_images_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `ym_apps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_app_images
-- ----------------------------
INSERT INTO `ym_app_images` VALUES ('10', '14', 'VVZWy1457094442VVZWy1457094442.jpg');

-- ----------------------------
-- Table structure for ym_app_platforms
-- ----------------------------
DROP TABLE IF EXISTS `ym_app_platforms`;
CREATE TABLE `ym_app_platforms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `file_types` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_app_platforms
-- ----------------------------
INSERT INTO `ym_app_platforms` VALUES ('1', 'android', 'اندروید', 'apk');
INSERT INTO `ym_app_platforms` VALUES ('2', 'ios', 'آی او اس', 'ipa');
INSERT INTO `ym_app_platforms` VALUES ('3', 'windowsPhone', 'ویندوزفون', 'xap');

-- ----------------------------
-- Table structure for ym_counter_save
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_save`;
CREATE TABLE `ym_counter_save` (
  `save_name` varchar(10) NOT NULL,
  `save_value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`save_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_counter_save
-- ----------------------------
INSERT INTO `ym_counter_save` VALUES ('counter', '12');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2457453');
INSERT INTO `ym_counter_save` VALUES ('max_count', '1');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1455957000');
INSERT INTO `ym_counter_save` VALUES ('yesterday', '1');

-- ----------------------------
-- Table structure for ym_counter_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_users`;
CREATE TABLE `ym_counter_users` (
  `user_ip` varchar(255) NOT NULL,
  `user_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_counter_users
-- ----------------------------
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1457170474');

-- ----------------------------
-- Table structure for ym_pages
-- ----------------------------
DROP TABLE IF EXISTS `ym_pages`;
CREATE TABLE `ym_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `summary` text COMMENT 'متن',
  `category_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `ym_pages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_page_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_pages
-- ----------------------------
INSERT INTO `ym_pages` VALUES ('2', 'درباره ما', '<p>امروزه در جوامع پیشرفته</p>\r\n\r\n<p>سسیبدسئینئسی</p>\r\n\r\n<p>&nbsp;س</p>\r\n\r\n<p>یبش</p>\r\n\r\n<p>ی</p>\r\n\r\n<p>شس</p>\r\n\r\n<p>ی</p>\r\n\r\n<p>شسی</p>\r\n', '4');
INSERT INTO `ym_pages` VALUES ('3', 'تماس با ما', '', '4');
INSERT INTO `ym_pages` VALUES ('5', 'قوانین و مقررات', '<p>\r\n	&nbsp;</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	&nbsp;</p>', '1');
INSERT INTO `ym_pages` VALUES ('12', 'پشتیبانی', '<p>شماره های تماس :</p>\r\n\r\n<p>021 - 23655822</p>\r\n\r\n<p>021 - 323352525</p>\r\n', '4');
INSERT INTO `ym_pages` VALUES ('13', 'سلام', '<p>سشیکمئبمسشئبئکم سشنمبئکشسمنئی سشنئب کنمشسئ</p>\r\n', '2');
INSERT INTO `ym_pages` VALUES ('14', 'راهنما', '<p>ستیدبمشسکدئیب</p>\r\n', '2');
INSERT INTO `ym_pages` VALUES ('15', 'ljdvn', '<p>ksdmnkafm</p>\r\n', '2');
INSERT INTO `ym_pages` VALUES ('16', 'sdfjnsfl;km', '<p>&nbsp;</p>\r\n\r\n<p>dfasfsf</p>\r\n\r\n<p>&nbsp;</p>\r\n', '2');

-- ----------------------------
-- Table structure for ym_page_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_page_categories`;
CREATE TABLE `ym_page_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `slug` varchar(255) DEFAULT NULL COMMENT 'آدرس',
  `multiple` tinyint(1) unsigned DEFAULT '1' COMMENT 'چند صحفه ای',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_page_categories
-- ----------------------------
INSERT INTO `ym_page_categories` VALUES ('1', 'قوانین', 'rules', '1');
INSERT INTO `ym_page_categories` VALUES ('2', 'راهنما', 'guide', '1');
INSERT INTO `ym_page_categories` VALUES ('3', 'آزاد', 'free', '1');
INSERT INTO `ym_page_categories` VALUES ('4', 'صفحات اصلی', 'base', '1');

-- ----------------------------
-- Table structure for ym_site_setting
-- ----------------------------
DROP TABLE IF EXISTS `ym_site_setting`;
CREATE TABLE `ym_site_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_site_setting
-- ----------------------------
INSERT INTO `ym_site_setting` VALUES ('1', 'site_title', 'عنوان سایت', 'نیازمندی های آنلاین ');
INSERT INTO `ym_site_setting` VALUES ('2', 'default_title', 'عنوان پیش فرض صفحات', 'تابلو ');
INSERT INTO `ym_site_setting` VALUES ('3', 'keywords', 'کلمات کلیدی سایت', 'خرید، فروش، دست دوم، خودرو، املاک، موبایل، وسایل خانگی، تبلت، پوشاک ، نوزاد و سیسمونی، صوتی و تصویری، دوربین عکاسی فیلمبرداری، کنسول بازی، آرایشی، بهداشتی، زیبایی، جواهر، بدلیجات، ساعت، آنتیک، خدمات، آگهی، نیازمندی، استخدام،');
INSERT INTO `ym_site_setting` VALUES ('4', 'site_description', 'شرح وبسایت', 'تابلو فضای داد و ستد آنلاین و نیازمندی های خرید و فروش اینترنتی رایگان در بخش های املاک، خودرو، وسایل خانگی، موبایل، پوشاک، آنتیک، آرایشی زیبایی بهداشتی، عکاسی و ...');

-- ----------------------------
-- Table structure for ym_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_users`;
CREATE TABLE `ym_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(10) unsigned DEFAULT NULL,
  `status` enum('deleted','blocked','pending','accepted') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('8', '', '$2a$12$H9pEmjmlXTABPuGxlaQ.E.29akZUA5X3UxbsHeENB2YqcnHIiqgT.', 'e@s.s', '2', 'accepted');

-- ----------------------------
-- Table structure for ym_user_details
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_details`;
CREATE TABLE `ym_user_details` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `fa_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام فارسی',
  `en_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام انگلیسی',
  `fa_web_url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس سایت فارسی',
  `en_web_url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس سایت انگلیسی',
  `national_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد ملی',
  `national_card_image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تصویر کارت ملی',
  `phone` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تلفن',
  `zip_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد پستی',
  `address` varchar(1000) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نشانی دقیق پستی',
  `credit` double DEFAULT NULL COMMENT 'اعتبار',
  `developer_id` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه توسعه دهنده',
  `details_status` enum('refused','pending','accepted') CHARACTER SET utf8 DEFAULT 'pending' COMMENT 'وضعیت اطلاعات کاربر',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_details
-- ----------------------------
INSERT INTO `ym_user_details` VALUES ('8', 'مسعود قراگوزلو', 'Masoud Gharagozlu', '', '', '0370518926', 'QXzNM1457170405.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد خ شوندی', '5000', 'Masoud', 'pending');

-- ----------------------------
-- Table structure for ym_user_dev_id_requests
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_dev_id_requests`;
CREATE TABLE `ym_user_dev_id_requests` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `requested_id` varchar(20) DEFAULT NULL COMMENT 'شناسه درخواستی',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `ym_user_dev_id_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_dev_id_requests
-- ----------------------------

-- ----------------------------
-- Table structure for ym_user_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_roles`;
CREATE TABLE `ym_user_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_roles
-- ----------------------------
INSERT INTO `ym_user_roles` VALUES ('1', 'کاربر معمولی', 'user');
INSERT INTO `ym_user_roles` VALUES ('2', 'توسعه دهنده', 'developer');
