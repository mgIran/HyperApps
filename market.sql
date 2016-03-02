/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : market

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2016-03-01 15:47:06
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
  PRIMARY KEY (`id`),
  KEY `developer_id` (`developer_id`),
  KEY `category_id` (`category_id`),
  KEY `platform_id` (`platform_id`),
  CONSTRAINT `ym_apps_ibfk_1` FOREIGN KEY (`developer_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_apps_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ym_app_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_apps_ibfk_3` FOREIGN KEY (`platform_id`) REFERENCES `ym_apps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_apps
-- ----------------------------
INSERT INTO `ym_apps` VALUES ('6', 'هواشناسی هوشمند و پیشرفته', '8', '4', 'enable', '3000', 'ym_app_categories2.apk', 'masoud.6.png', 'هواشناسی پیشرفته و جدید کافه بازار\r\nجدیدترین اپلیکیشین هواشناسی با طراحی فوق العاده و متریال پیش روی شماست !\r\nبا این برنامه میتونید آب و هوای تمام شهرهای ایران و دنیارو در کمترین زمان با طراحی فوق العاده زیبا مشاهده کنید و برای روزهای بعدی برنامه ریزی داشته باشید !', 'بهبود عملکرد', '[\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a Wi-Fi\",\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a \\u0634\\u0628\\u06a9\\u0647\",\"\\u062e\\u0648\\u0627\\u0646\\u062f\\u0646 \\u06a9\\u0627\\u0631\\u062a \\u062d\\u0627\\u0641\\u0638\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u06a9\\u0627\\u0645\\u0644 \\u0628\\u0647 \\u0627\\u06cc\\u0646\\u062a\\u0631\\u0646\\u062a\"]', '2498', '1.0.3', 'accepted', null, null);
INSERT INTO `ym_apps` VALUES ('7', 'همسا | اشتراک ایده ها', '8', '1', 'enable', '0', 'ym_app_categories.apk', 'com.hamsa.png', 'اگر از زمانی که در برنامه‌های اجتماعی حضور دارید احساس بطالت می‌کنید، هم‌سا انتخاب مناسبی برای شماست!\r\n\r\nهم‌سا یک شبکه‌ی اجتماعی متفاوت است برای روشن کردن موتور فکر شما ...\r\n \r\nبا چرخیدن در محیط هم‌سا فکرها و ایده‌های زیادی به ذهن شما خواهد رسید. این ایده‌های خام باید پخته و بارور شوند. اینجا هم‌سایه‌های شما کنارتان هستند. هم ایده‌‌ی شما را ارزیابی می‌کنند هم کمک می‌کنند تا چکش بخورد و شکل بگیرد!\r\n \r\nمسئله‌هایی که بیرون از هم‌سا شما را کلافه می‌کند و ناخودآگاه فراموش‌شان می‌کنید، در هم‌سا حالتان را خوب می‌کند و منشاء تحول می‌شود! در هم‌سا می‌توانید کسانی که مسئله‌های مشترک با شما دارند را بشناسید و از تجربه‌های آن‌ها استفاده کنید. اگر هم جایی نمی‌خواهید شناخته شوید، می‌توانید به صورت ناشناس مسئله‌تان را مطرح کنید!', '- رفع خطای ثبت‌نام در حالات خاص\r\n- تکمیل گزارش تخلف', '[\"\\u062e\\u0648\\u0627\\u0646\\u062f\\u0646 \\u0645\\u062e\\u0627\\u0637\\u0628\\u06cc\\u0646 \\u0634\\u0645\\u0627\",\"\\u06a9\\u0646\\u062a\\u0631\\u0644 \\u0644\\u0631\\u0632\\u0634\"]', '2498', '3.0.61 b', 'pending', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_app_images
-- ----------------------------
INSERT INTO `ym_app_images` VALUES ('1', '6', '0n4XpPvL6pUXkYf7MTZm0n4XpPvL6pUXkYf7MTZm.jpg');
INSERT INTO `ym_app_images` VALUES ('2', '6', 'FY6fKz3UcyOULeRmEs9QFY6fKz3UcyOULeRmEs9Q.jpg');
INSERT INTO `ym_app_images` VALUES ('3', '6', 'ABasNtRNYqIWmiGwFsfAABasNtRNYqIWmiGwFsfA.jpg');
INSERT INTO `ym_app_images` VALUES ('4', '6', '6JnLpsw8MuGhXaik8kmP6JnLpsw8MuGhXaik8kmP.jpg');

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
INSERT INTO `ym_counter_save` VALUES ('counter', '8');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2457449');
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
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1456833046');

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
-- Table structure for ym_places
-- ----------------------------
DROP TABLE IF EXISTS `ym_places`;
CREATE TABLE `ym_places` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `name` varchar(200) NOT NULL COMMENT 'عنوان',
  `town_id` int(10) unsigned NOT NULL COMMENT 'والد',
  PRIMARY KEY (`id`),
  KEY `town_id` (`town_id`),
  CONSTRAINT `ym_places_ibfk_1` FOREIGN KEY (`town_id`) REFERENCES `ym_towns` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=444 DEFAULT CHARSET=utf8 COMMENT='شهر ها';

-- ----------------------------
-- Records of ym_places
-- ----------------------------
INSERT INTO `ym_places` VALUES ('1', 'تبریز', '1');
INSERT INTO `ym_places` VALUES ('2', 'كندوان', '1');
INSERT INTO `ym_places` VALUES ('3', 'بندر شرفخانه', '1');
INSERT INTO `ym_places` VALUES ('4', 'مراغه', '1');
INSERT INTO `ym_places` VALUES ('5', ' ', '1');
INSERT INTO `ym_places` VALUES ('6', 'شبستر', '1');
INSERT INTO `ym_places` VALUES ('7', 'مرند', '1');
INSERT INTO `ym_places` VALUES ('8', 'جلفا', '1');
INSERT INTO `ym_places` VALUES ('9', 'سراب', '1');
INSERT INTO `ym_places` VALUES ('10', 'هادیشهر', '1');
INSERT INTO `ym_places` VALUES ('11', 'بناب', '1');
INSERT INTO `ym_places` VALUES ('12', 'كلیبر', '1');
INSERT INTO `ym_places` VALUES ('13', 'تسوج', '1');
INSERT INTO `ym_places` VALUES ('14', 'اهر', '1');
INSERT INTO `ym_places` VALUES ('15', 'هریس', '1');
INSERT INTO `ym_places` VALUES ('16', 'عجبشیر', '1');
INSERT INTO `ym_places` VALUES ('17', 'هشترود', '1');
INSERT INTO `ym_places` VALUES ('18', 'ملكان', '1');
INSERT INTO `ym_places` VALUES ('19', 'بستان آباد', '1');
INSERT INTO `ym_places` VALUES ('20', 'ورزقان', '1');
INSERT INTO `ym_places` VALUES ('21', 'اسكو', '1');
INSERT INTO `ym_places` VALUES ('22', 'آذر شهر', '1');
INSERT INTO `ym_places` VALUES ('23', 'قره آغاج', '1');
INSERT INTO `ym_places` VALUES ('24', 'ممقان', '1');
INSERT INTO `ym_places` VALUES ('25', 'صوفیان', '1');
INSERT INTO `ym_places` VALUES ('26', 'ایلخچی', '1');
INSERT INTO `ym_places` VALUES ('27', 'خسروشهر', '1');
INSERT INTO `ym_places` VALUES ('28', 'باسمنج', '1');
INSERT INTO `ym_places` VALUES ('29', 'سهند', '1');
INSERT INTO `ym_places` VALUES ('30', 'ارومیه', '2');
INSERT INTO `ym_places` VALUES ('31', 'نقده', '2');
INSERT INTO `ym_places` VALUES ('32', 'ماكو', '2');
INSERT INTO `ym_places` VALUES ('33', 'تكاب', '2');
INSERT INTO `ym_places` VALUES ('34', 'خوی', '2');
INSERT INTO `ym_places` VALUES ('35', 'مهاباد', '2');
INSERT INTO `ym_places` VALUES ('36', 'سر دشت', '2');
INSERT INTO `ym_places` VALUES ('37', 'چالدران', '2');
INSERT INTO `ym_places` VALUES ('38', 'بوكان', '2');
INSERT INTO `ym_places` VALUES ('39', 'میاندوآب', '2');
INSERT INTO `ym_places` VALUES ('40', 'سلماس', '2');
INSERT INTO `ym_places` VALUES ('41', 'شاهین دژ', '2');
INSERT INTO `ym_places` VALUES ('42', 'پیرانشهر', '2');
INSERT INTO `ym_places` VALUES ('43', 'سیه چشمه', '2');
INSERT INTO `ym_places` VALUES ('44', 'اشنویه', '2');
INSERT INTO `ym_places` VALUES ('45', 'چایپاره', '2');
INSERT INTO `ym_places` VALUES ('46', 'پلدشت', '2');
INSERT INTO `ym_places` VALUES ('47', 'شوط', '2');
INSERT INTO `ym_places` VALUES ('48', 'اردبیل', '3');
INSERT INTO `ym_places` VALUES ('49', 'سرعین', '3');
INSERT INTO `ym_places` VALUES ('50', 'بیله سوار', '3');
INSERT INTO `ym_places` VALUES ('51', 'پارس آباد', '3');
INSERT INTO `ym_places` VALUES ('52', 'خلخال', '3');
INSERT INTO `ym_places` VALUES ('53', 'مشگین شهر', '3');
INSERT INTO `ym_places` VALUES ('54', 'مغان', '3');
INSERT INTO `ym_places` VALUES ('55', 'نمین', '3');
INSERT INTO `ym_places` VALUES ('56', 'نیر', '3');
INSERT INTO `ym_places` VALUES ('57', 'كوثر', '3');
INSERT INTO `ym_places` VALUES ('58', 'کیوی', '3');
INSERT INTO `ym_places` VALUES ('59', 'گرمی', '3');
INSERT INTO `ym_places` VALUES ('60', 'اصفهان', '4');
INSERT INTO `ym_places` VALUES ('61', 'فریدن', '4');
INSERT INTO `ym_places` VALUES ('62', 'فریدون شهر', '4');
INSERT INTO `ym_places` VALUES ('63', 'فلاورجان', '4');
INSERT INTO `ym_places` VALUES ('64', 'گلپایگان', '4');
INSERT INTO `ym_places` VALUES ('65', 'دهاقان', '4');
INSERT INTO `ym_places` VALUES ('66', 'نطنز', '4');
INSERT INTO `ym_places` VALUES ('67', 'نایین', '4');
INSERT INTO `ym_places` VALUES ('68', 'تیران', '4');
INSERT INTO `ym_places` VALUES ('69', 'كاشان', '4');
INSERT INTO `ym_places` VALUES ('70', 'فولاد شهر', '4');
INSERT INTO `ym_places` VALUES ('71', 'اردستان', '4');
INSERT INTO `ym_places` VALUES ('72', 'سمیرم', '4');
INSERT INTO `ym_places` VALUES ('73', 'درچه', '4');
INSERT INTO `ym_places` VALUES ('74', 'کوهپایه', '4');
INSERT INTO `ym_places` VALUES ('75', 'مباركه', '4');
INSERT INTO `ym_places` VALUES ('76', 'شهرضا', '4');
INSERT INTO `ym_places` VALUES ('77', 'خمینی شهر', '4');
INSERT INTO `ym_places` VALUES ('78', 'شاهین شهر', '4');
INSERT INTO `ym_places` VALUES ('79', 'نجف آباد', '4');
INSERT INTO `ym_places` VALUES ('80', 'دولت آباد', '4');
INSERT INTO `ym_places` VALUES ('81', 'زرین شهر', '4');
INSERT INTO `ym_places` VALUES ('82', 'آران و بیدگل', '4');
INSERT INTO `ym_places` VALUES ('83', 'باغ بهادران', '4');
INSERT INTO `ym_places` VALUES ('84', 'خوانسار', '4');
INSERT INTO `ym_places` VALUES ('85', 'مهردشت', '4');
INSERT INTO `ym_places` VALUES ('86', 'علویجه', '4');
INSERT INTO `ym_places` VALUES ('87', 'عسگران', '4');
INSERT INTO `ym_places` VALUES ('88', 'نهضت آباد', '4');
INSERT INTO `ym_places` VALUES ('89', 'حاجی آباد', '4');
INSERT INTO `ym_places` VALUES ('90', 'تودشک', '4');
INSERT INTO `ym_places` VALUES ('91', 'ورزنه', '4');
INSERT INTO `ym_places` VALUES ('92', 'ایلام', '6');
INSERT INTO `ym_places` VALUES ('93', 'مهران', '6');
INSERT INTO `ym_places` VALUES ('94', 'دهلران', '6');
INSERT INTO `ym_places` VALUES ('95', 'آبدانان', '6');
INSERT INTO `ym_places` VALUES ('96', 'شیروان چرداول', '6');
INSERT INTO `ym_places` VALUES ('97', 'دره شهر', '6');
INSERT INTO `ym_places` VALUES ('98', 'ایوان', '6');
INSERT INTO `ym_places` VALUES ('99', 'سرابله', '6');
INSERT INTO `ym_places` VALUES ('100', 'بوشهر', '7');
INSERT INTO `ym_places` VALUES ('101', 'تنگستان', '7');
INSERT INTO `ym_places` VALUES ('102', 'دشتستان', '7');
INSERT INTO `ym_places` VALUES ('103', 'دیر', '7');
INSERT INTO `ym_places` VALUES ('104', 'دیلم', '7');
INSERT INTO `ym_places` VALUES ('105', 'كنگان', '7');
INSERT INTO `ym_places` VALUES ('106', 'گناوه', '7');
INSERT INTO `ym_places` VALUES ('107', 'ریشهر', '7');
INSERT INTO `ym_places` VALUES ('108', 'دشتی', '7');
INSERT INTO `ym_places` VALUES ('109', 'خورموج', '7');
INSERT INTO `ym_places` VALUES ('110', 'اهرم', '7');
INSERT INTO `ym_places` VALUES ('111', 'برازجان', '7');
INSERT INTO `ym_places` VALUES ('112', 'خارك', '7');
INSERT INTO `ym_places` VALUES ('113', 'جم', '7');
INSERT INTO `ym_places` VALUES ('114', 'کاکی', '7');
INSERT INTO `ym_places` VALUES ('115', 'عسلویه', '7');
INSERT INTO `ym_places` VALUES ('116', 'بردخون', '7');
INSERT INTO `ym_places` VALUES ('117', 'تهران', '8');
INSERT INTO `ym_places` VALUES ('118', 'ورامین', '8');
INSERT INTO `ym_places` VALUES ('119', 'فیروزكوه', '8');
INSERT INTO `ym_places` VALUES ('120', 'ری', '8');
INSERT INTO `ym_places` VALUES ('121', 'دماوند', '8');
INSERT INTO `ym_places` VALUES ('122', 'اسلامشهر', '8');
INSERT INTO `ym_places` VALUES ('123', 'رودهن', '8');
INSERT INTO `ym_places` VALUES ('124', 'لواسان', '8');
INSERT INTO `ym_places` VALUES ('125', 'بومهن', '8');
INSERT INTO `ym_places` VALUES ('126', 'تجریش', '8');
INSERT INTO `ym_places` VALUES ('127', 'فشم', '8');
INSERT INTO `ym_places` VALUES ('128', 'كهریزك', '8');
INSERT INTO `ym_places` VALUES ('129', 'پاكدشت', '8');
INSERT INTO `ym_places` VALUES ('130', 'چهاردانگه', '8');
INSERT INTO `ym_places` VALUES ('131', 'شریف آباد', '8');
INSERT INTO `ym_places` VALUES ('132', 'قرچك', '8');
INSERT INTO `ym_places` VALUES ('133', 'باقرشهر', '8');
INSERT INTO `ym_places` VALUES ('134', 'شهریار', '8');
INSERT INTO `ym_places` VALUES ('135', 'رباط كریم', '8');
INSERT INTO `ym_places` VALUES ('136', 'قدس', '8');
INSERT INTO `ym_places` VALUES ('137', 'ملارد', '8');
INSERT INTO `ym_places` VALUES ('138', 'شهركرد', '9');
INSERT INTO `ym_places` VALUES ('139', 'فارسان', '9');
INSERT INTO `ym_places` VALUES ('140', 'بروجن', '9');
INSERT INTO `ym_places` VALUES ('141', 'چلگرد', '9');
INSERT INTO `ym_places` VALUES ('142', 'اردل', '9');
INSERT INTO `ym_places` VALUES ('143', 'لردگان', '9');
INSERT INTO `ym_places` VALUES ('144', 'سامان', '9');
INSERT INTO `ym_places` VALUES ('145', 'قائن', '10');
INSERT INTO `ym_places` VALUES ('146', 'فردوس', '10');
INSERT INTO `ym_places` VALUES ('147', 'بیرجند', '10');
INSERT INTO `ym_places` VALUES ('148', 'نهبندان', '10');
INSERT INTO `ym_places` VALUES ('149', 'سربیشه', '10');
INSERT INTO `ym_places` VALUES ('150', 'طبس مسینا', '10');
INSERT INTO `ym_places` VALUES ('151', 'قهستان', '10');
INSERT INTO `ym_places` VALUES ('152', 'درمیان', '10');
INSERT INTO `ym_places` VALUES ('153', 'مشهد', '11');
INSERT INTO `ym_places` VALUES ('154', 'نیشابور', '11');
INSERT INTO `ym_places` VALUES ('155', 'سبزوار', '11');
INSERT INTO `ym_places` VALUES ('156', 'كاشمر', '11');
INSERT INTO `ym_places` VALUES ('157', 'گناباد', '11');
INSERT INTO `ym_places` VALUES ('158', 'طبس', '11');
INSERT INTO `ym_places` VALUES ('159', 'تربت حیدریه', '11');
INSERT INTO `ym_places` VALUES ('160', 'خواف', '11');
INSERT INTO `ym_places` VALUES ('161', 'تربت جام', '11');
INSERT INTO `ym_places` VALUES ('162', 'تایباد', '11');
INSERT INTO `ym_places` VALUES ('163', 'قوچان', '11');
INSERT INTO `ym_places` VALUES ('164', 'سرخس', '11');
INSERT INTO `ym_places` VALUES ('165', 'بردسكن', '11');
INSERT INTO `ym_places` VALUES ('166', 'فریمان', '11');
INSERT INTO `ym_places` VALUES ('167', 'چناران', '11');
INSERT INTO `ym_places` VALUES ('168', 'درگز', '11');
INSERT INTO `ym_places` VALUES ('169', 'كلات', '11');
INSERT INTO `ym_places` VALUES ('170', 'طرقبه', '11');
INSERT INTO `ym_places` VALUES ('171', 'سر ولایت', '11');
INSERT INTO `ym_places` VALUES ('172', 'بجنورد', '12');
INSERT INTO `ym_places` VALUES ('173', 'اسفراین', '12');
INSERT INTO `ym_places` VALUES ('174', 'جاجرم', '12');
INSERT INTO `ym_places` VALUES ('175', 'شیروان', '12');
INSERT INTO `ym_places` VALUES ('176', 'آشخانه', '12');
INSERT INTO `ym_places` VALUES ('177', 'گرمه', '12');
INSERT INTO `ym_places` VALUES ('178', 'ساروج', '12');
INSERT INTO `ym_places` VALUES ('179', 'اهواز', '13');
INSERT INTO `ym_places` VALUES ('181', 'شوش', '13');
INSERT INTO `ym_places` VALUES ('182', 'آبادان', '13');
INSERT INTO `ym_places` VALUES ('183', 'خرمشهر', '13');
INSERT INTO `ym_places` VALUES ('184', 'مسجد سلیمان', '13');
INSERT INTO `ym_places` VALUES ('185', 'ایذه', '13');
INSERT INTO `ym_places` VALUES ('186', 'شوشتر', '13');
INSERT INTO `ym_places` VALUES ('187', 'اندیمشك', '13');
INSERT INTO `ym_places` VALUES ('188', 'سوسنگرد', '13');
INSERT INTO `ym_places` VALUES ('189', 'هویزه', '13');
INSERT INTO `ym_places` VALUES ('190', 'دزفول', '13');
INSERT INTO `ym_places` VALUES ('191', 'شادگان', '13');
INSERT INTO `ym_places` VALUES ('192', 'بندر ماهشهر', '13');
INSERT INTO `ym_places` VALUES ('193', 'بندر امام خمینی', '13');
INSERT INTO `ym_places` VALUES ('194', 'امیدیه', '13');
INSERT INTO `ym_places` VALUES ('195', 'بهبهان', '13');
INSERT INTO `ym_places` VALUES ('196', 'رامهرمز', '13');
INSERT INTO `ym_places` VALUES ('197', 'باغ ملك', '13');
INSERT INTO `ym_places` VALUES ('198', 'هندیجان', '13');
INSERT INTO `ym_places` VALUES ('199', 'لالی', '13');
INSERT INTO `ym_places` VALUES ('200', 'رامشیر', '13');
INSERT INTO `ym_places` VALUES ('201', 'حمیدیه', '13');
INSERT INTO `ym_places` VALUES ('202', 'دغاغله', '13');
INSERT INTO `ym_places` VALUES ('203', 'ملاثانی', '13');
INSERT INTO `ym_places` VALUES ('204', 'شادگان', '13');
INSERT INTO `ym_places` VALUES ('205', 'ویسی', '13');
INSERT INTO `ym_places` VALUES ('206', 'زنجان', '14');
INSERT INTO `ym_places` VALUES ('207', 'ابهر', '14');
INSERT INTO `ym_places` VALUES ('208', 'خدابنده', '14');
INSERT INTO `ym_places` VALUES ('209', 'كارم', '14');
INSERT INTO `ym_places` VALUES ('210', 'ماهنشان', '14');
INSERT INTO `ym_places` VALUES ('211', 'خرمدره', '14');
INSERT INTO `ym_places` VALUES ('212', 'ایجرود', '14');
INSERT INTO `ym_places` VALUES ('213', 'زرین آباد', '14');
INSERT INTO `ym_places` VALUES ('214', 'آب بر', '14');
INSERT INTO `ym_places` VALUES ('215', 'قیدار', '14');
INSERT INTO `ym_places` VALUES ('216', 'سمنان', '15');
INSERT INTO `ym_places` VALUES ('217', 'شاهرود', '15');
INSERT INTO `ym_places` VALUES ('218', 'گرمسار', '15');
INSERT INTO `ym_places` VALUES ('219', 'ایوانكی', '15');
INSERT INTO `ym_places` VALUES ('220', 'دامغان', '15');
INSERT INTO `ym_places` VALUES ('221', 'بسطام', '15');
INSERT INTO `ym_places` VALUES ('222', 'زاهدان', '16');
INSERT INTO `ym_places` VALUES ('223', 'چابهار', '16');
INSERT INTO `ym_places` VALUES ('224', 'خاش', '16');
INSERT INTO `ym_places` VALUES ('225', 'سراوان', '16');
INSERT INTO `ym_places` VALUES ('226', 'زابل', '16');
INSERT INTO `ym_places` VALUES ('227', 'سرباز', '16');
INSERT INTO `ym_places` VALUES ('228', 'نیكشهر', '16');
INSERT INTO `ym_places` VALUES ('229', 'ایرانشهر', '16');
INSERT INTO `ym_places` VALUES ('230', 'راسك', '16');
INSERT INTO `ym_places` VALUES ('231', 'میرجاوه', '16');
INSERT INTO `ym_places` VALUES ('232', 'شیراز', '17');
INSERT INTO `ym_places` VALUES ('233', 'اقلید', '17');
INSERT INTO `ym_places` VALUES ('234', 'داراب', '17');
INSERT INTO `ym_places` VALUES ('235', 'فسا', '17');
INSERT INTO `ym_places` VALUES ('236', 'مرودشت', '17');
INSERT INTO `ym_places` VALUES ('237', 'خرم بید', '17');
INSERT INTO `ym_places` VALUES ('238', 'آباده', '17');
INSERT INTO `ym_places` VALUES ('239', 'كازرون', '17');
INSERT INTO `ym_places` VALUES ('240', 'ممسنی', '17');
INSERT INTO `ym_places` VALUES ('241', 'سپیدان', '17');
INSERT INTO `ym_places` VALUES ('242', 'لار', '17');
INSERT INTO `ym_places` VALUES ('243', 'فیروز آباد', '17');
INSERT INTO `ym_places` VALUES ('244', 'جهرم', '17');
INSERT INTO `ym_places` VALUES ('245', 'نی ریز', '17');
INSERT INTO `ym_places` VALUES ('246', 'استهبان', '17');
INSERT INTO `ym_places` VALUES ('247', 'لامرد', '17');
INSERT INTO `ym_places` VALUES ('248', 'مهر', '17');
INSERT INTO `ym_places` VALUES ('249', 'حاجی آباد', '17');
INSERT INTO `ym_places` VALUES ('250', 'نورآباد', '17');
INSERT INTO `ym_places` VALUES ('251', 'اردكان', '17');
INSERT INTO `ym_places` VALUES ('252', 'صفاشهر', '17');
INSERT INTO `ym_places` VALUES ('253', 'ارسنجان', '17');
INSERT INTO `ym_places` VALUES ('254', 'قیروكارزین', '17');
INSERT INTO `ym_places` VALUES ('255', 'سوریان', '17');
INSERT INTO `ym_places` VALUES ('256', 'فراشبند', '17');
INSERT INTO `ym_places` VALUES ('257', 'سروستان', '17');
INSERT INTO `ym_places` VALUES ('258', 'ارژن', '17');
INSERT INTO `ym_places` VALUES ('259', 'گویم', '17');
INSERT INTO `ym_places` VALUES ('260', 'داریون', '17');
INSERT INTO `ym_places` VALUES ('261', 'زرقان', '17');
INSERT INTO `ym_places` VALUES ('262', 'خان زنیان', '17');
INSERT INTO `ym_places` VALUES ('263', 'کوار', '17');
INSERT INTO `ym_places` VALUES ('264', 'ده بید', '17');
INSERT INTO `ym_places` VALUES ('265', 'باب انار/خفر', '17');
INSERT INTO `ym_places` VALUES ('266', 'بوانات', '17');
INSERT INTO `ym_places` VALUES ('267', 'خرامه', '17');
INSERT INTO `ym_places` VALUES ('268', 'خنج', '17');
INSERT INTO `ym_places` VALUES ('269', 'سیاخ دارنگون', '17');
INSERT INTO `ym_places` VALUES ('270', 'قزوین', '18');
INSERT INTO `ym_places` VALUES ('271', 'تاكستان', '18');
INSERT INTO `ym_places` VALUES ('272', 'آبیك', '18');
INSERT INTO `ym_places` VALUES ('273', 'بوئین زهرا', '18');
INSERT INTO `ym_places` VALUES ('274', 'قم', '19');
INSERT INTO `ym_places` VALUES ('275', 'طالقان', '5');
INSERT INTO `ym_places` VALUES ('276', 'نظرآباد', '5');
INSERT INTO `ym_places` VALUES ('277', 'اشتهارد', '5');
INSERT INTO `ym_places` VALUES ('278', 'هشتگرد', '5');
INSERT INTO `ym_places` VALUES ('279', 'كن', '5');
INSERT INTO `ym_places` VALUES ('280', 'آسارا', '5');
INSERT INTO `ym_places` VALUES ('281', 'شهرک گلستان', '5');
INSERT INTO `ym_places` VALUES ('282', 'اندیشه', '5');
INSERT INTO `ym_places` VALUES ('283', 'كرج', '5');
INSERT INTO `ym_places` VALUES ('284', 'نظر آباد', '5');
INSERT INTO `ym_places` VALUES ('285', 'گوهردشت', '5');
INSERT INTO `ym_places` VALUES ('286', 'ماهدشت', '5');
INSERT INTO `ym_places` VALUES ('287', 'مشکین دشت', '5');
INSERT INTO `ym_places` VALUES ('288', 'سنندج', '20');
INSERT INTO `ym_places` VALUES ('289', 'دیواندره', '20');
INSERT INTO `ym_places` VALUES ('290', 'بانه', '20');
INSERT INTO `ym_places` VALUES ('291', 'بیجار', '20');
INSERT INTO `ym_places` VALUES ('292', 'سقز', '20');
INSERT INTO `ym_places` VALUES ('293', 'كامیاران', '20');
INSERT INTO `ym_places` VALUES ('294', 'قروه', '20');
INSERT INTO `ym_places` VALUES ('295', 'مریوان', '20');
INSERT INTO `ym_places` VALUES ('296', 'صلوات آباد', '20');
INSERT INTO `ym_places` VALUES ('297', 'حسن آباد', '20');
INSERT INTO `ym_places` VALUES ('298', 'كرمان', '21');
INSERT INTO `ym_places` VALUES ('299', 'راور', '21');
INSERT INTO `ym_places` VALUES ('300', 'بابك', '21');
INSERT INTO `ym_places` VALUES ('301', 'انار', '21');
INSERT INTO `ym_places` VALUES ('302', 'کوهبنان', '21');
INSERT INTO `ym_places` VALUES ('303', 'رفسنجان', '21');
INSERT INTO `ym_places` VALUES ('304', 'بافت', '21');
INSERT INTO `ym_places` VALUES ('305', 'سیرجان', '21');
INSERT INTO `ym_places` VALUES ('306', 'كهنوج', '21');
INSERT INTO `ym_places` VALUES ('307', 'زرند', '21');
INSERT INTO `ym_places` VALUES ('308', 'بم', '21');
INSERT INTO `ym_places` VALUES ('309', 'جیرفت', '21');
INSERT INTO `ym_places` VALUES ('310', 'بردسیر', '21');
INSERT INTO `ym_places` VALUES ('311', 'كرمانشاه', '22');
INSERT INTO `ym_places` VALUES ('312', 'اسلام آباد غرب', '22');
INSERT INTO `ym_places` VALUES ('313', 'سر پل ذهاب', '22');
INSERT INTO `ym_places` VALUES ('314', 'كنگاور', '22');
INSERT INTO `ym_places` VALUES ('315', 'سنقر', '22');
INSERT INTO `ym_places` VALUES ('316', 'قصر شیرین', '22');
INSERT INTO `ym_places` VALUES ('317', 'گیلان غرب', '22');
INSERT INTO `ym_places` VALUES ('318', 'هرسین', '22');
INSERT INTO `ym_places` VALUES ('319', 'صحنه', '22');
INSERT INTO `ym_places` VALUES ('320', 'پاوه', '22');
INSERT INTO `ym_places` VALUES ('321', 'جوانرود', '22');
INSERT INTO `ym_places` VALUES ('322', 'شاهو', '22');
INSERT INTO `ym_places` VALUES ('323', 'یاسوج', '23');
INSERT INTO `ym_places` VALUES ('324', 'گچساران', '23');
INSERT INTO `ym_places` VALUES ('325', 'دنا', '23');
INSERT INTO `ym_places` VALUES ('326', 'دوگنبدان', '23');
INSERT INTO `ym_places` VALUES ('327', 'سی سخت', '23');
INSERT INTO `ym_places` VALUES ('328', 'دهدشت', '23');
INSERT INTO `ym_places` VALUES ('329', 'لیكك', '23');
INSERT INTO `ym_places` VALUES ('330', 'گرگان', '24');
INSERT INTO `ym_places` VALUES ('331', 'آق قلا', '24');
INSERT INTO `ym_places` VALUES ('332', 'گنبد كاووس', '24');
INSERT INTO `ym_places` VALUES ('333', 'علی آباد كتول', '24');
INSERT INTO `ym_places` VALUES ('334', 'مینو دشت', '24');
INSERT INTO `ym_places` VALUES ('335', 'تركمن', '24');
INSERT INTO `ym_places` VALUES ('336', 'كردكوی', '24');
INSERT INTO `ym_places` VALUES ('337', 'بندر گز', '24');
INSERT INTO `ym_places` VALUES ('338', 'كلاله', '24');
INSERT INTO `ym_places` VALUES ('339', 'آزاد شهر', '24');
INSERT INTO `ym_places` VALUES ('340', 'رامیان', '24');
INSERT INTO `ym_places` VALUES ('341', 'رشت', '25');
INSERT INTO `ym_places` VALUES ('342', 'منجیل', '25');
INSERT INTO `ym_places` VALUES ('343', 'لنگرود', '25');
INSERT INTO `ym_places` VALUES ('344', 'رود سر', '25');
INSERT INTO `ym_places` VALUES ('345', 'تالش', '25');
INSERT INTO `ym_places` VALUES ('346', 'آستارا', '25');
INSERT INTO `ym_places` VALUES ('347', 'ماسوله', '25');
INSERT INTO `ym_places` VALUES ('348', 'آستانه اشرفیه', '25');
INSERT INTO `ym_places` VALUES ('349', 'رودبار', '25');
INSERT INTO `ym_places` VALUES ('350', 'فومن', '25');
INSERT INTO `ym_places` VALUES ('351', 'صومعه سرا', '25');
INSERT INTO `ym_places` VALUES ('352', 'بندرانزلی', '25');
INSERT INTO `ym_places` VALUES ('353', 'كلاچای', '25');
INSERT INTO `ym_places` VALUES ('354', 'هشتپر', '25');
INSERT INTO `ym_places` VALUES ('355', 'رضوان شهر', '25');
INSERT INTO `ym_places` VALUES ('356', 'ماسال', '25');
INSERT INTO `ym_places` VALUES ('357', 'شفت', '25');
INSERT INTO `ym_places` VALUES ('358', 'سیاهكل', '25');
INSERT INTO `ym_places` VALUES ('359', 'املش', '25');
INSERT INTO `ym_places` VALUES ('360', 'لاهیجان', '25');
INSERT INTO `ym_places` VALUES ('361', 'خشک بیجار', '25');
INSERT INTO `ym_places` VALUES ('362', 'خمام', '25');
INSERT INTO `ym_places` VALUES ('363', 'لشت نشا', '25');
INSERT INTO `ym_places` VALUES ('364', 'بندر کیاشهر', '25');
INSERT INTO `ym_places` VALUES ('365', 'خرم آباد', '26');
INSERT INTO `ym_places` VALUES ('366', 'ماهشهر', '26');
INSERT INTO `ym_places` VALUES ('367', 'دزفول', '26');
INSERT INTO `ym_places` VALUES ('368', 'بروجرد', '26');
INSERT INTO `ym_places` VALUES ('369', 'دورود', '26');
INSERT INTO `ym_places` VALUES ('370', 'الیگودرز', '26');
INSERT INTO `ym_places` VALUES ('371', 'ازنا', '26');
INSERT INTO `ym_places` VALUES ('372', 'نور آباد', '26');
INSERT INTO `ym_places` VALUES ('373', 'كوهدشت', '26');
INSERT INTO `ym_places` VALUES ('374', 'الشتر', '26');
INSERT INTO `ym_places` VALUES ('375', 'پلدختر', '26');
INSERT INTO `ym_places` VALUES ('376', 'ساری', '27');
INSERT INTO `ym_places` VALUES ('377', 'آمل', '27');
INSERT INTO `ym_places` VALUES ('378', 'بابل', '27');
INSERT INTO `ym_places` VALUES ('379', 'بابلسر', '27');
INSERT INTO `ym_places` VALUES ('380', 'بهشهر', '27');
INSERT INTO `ym_places` VALUES ('381', 'تنكابن', '27');
INSERT INTO `ym_places` VALUES ('382', 'جویبار', '27');
INSERT INTO `ym_places` VALUES ('383', 'چالوس', '27');
INSERT INTO `ym_places` VALUES ('384', 'رامسر', '27');
INSERT INTO `ym_places` VALUES ('385', 'سواد كوه', '27');
INSERT INTO `ym_places` VALUES ('386', 'قائم شهر', '27');
INSERT INTO `ym_places` VALUES ('387', 'نكا', '27');
INSERT INTO `ym_places` VALUES ('388', 'نور', '27');
INSERT INTO `ym_places` VALUES ('389', 'بلده', '27');
INSERT INTO `ym_places` VALUES ('390', 'نوشهر', '27');
INSERT INTO `ym_places` VALUES ('391', 'پل سفید', '27');
INSERT INTO `ym_places` VALUES ('392', 'محمود آباد', '27');
INSERT INTO `ym_places` VALUES ('393', 'فریدون كنار', '27');
INSERT INTO `ym_places` VALUES ('394', 'اراك', '28');
INSERT INTO `ym_places` VALUES ('395', 'آشتیان', '28');
INSERT INTO `ym_places` VALUES ('396', 'تفرش', '28');
INSERT INTO `ym_places` VALUES ('397', 'خمین', '28');
INSERT INTO `ym_places` VALUES ('398', 'دلیجان', '28');
INSERT INTO `ym_places` VALUES ('399', 'ساوه', '28');
INSERT INTO `ym_places` VALUES ('400', 'سربند', '28');
INSERT INTO `ym_places` VALUES ('401', 'محلات', '28');
INSERT INTO `ym_places` VALUES ('402', 'شازند', '28');
INSERT INTO `ym_places` VALUES ('403', 'بندرعباس', '29');
INSERT INTO `ym_places` VALUES ('404', 'قشم', '29');
INSERT INTO `ym_places` VALUES ('405', 'كیش', '29');
INSERT INTO `ym_places` VALUES ('406', 'بندر لنگه', '29');
INSERT INTO `ym_places` VALUES ('407', 'بستك', '29');
INSERT INTO `ym_places` VALUES ('408', 'حاجی آباد', '29');
INSERT INTO `ym_places` VALUES ('409', 'دهبارز', '29');
INSERT INTO `ym_places` VALUES ('410', 'انگهران', '29');
INSERT INTO `ym_places` VALUES ('411', 'میناب', '29');
INSERT INTO `ym_places` VALUES ('412', 'ابوموسی', '29');
INSERT INTO `ym_places` VALUES ('413', 'بندر جاسك', '29');
INSERT INTO `ym_places` VALUES ('414', 'تنب بزرگ', '29');
INSERT INTO `ym_places` VALUES ('415', 'بندر خمیر', '29');
INSERT INTO `ym_places` VALUES ('416', 'پارسیان', '29');
INSERT INTO `ym_places` VALUES ('417', 'قشم', '29');
INSERT INTO `ym_places` VALUES ('418', 'همدان', '30');
INSERT INTO `ym_places` VALUES ('419', 'ملایر', '30');
INSERT INTO `ym_places` VALUES ('420', 'تویسركان', '30');
INSERT INTO `ym_places` VALUES ('421', 'نهاوند', '30');
INSERT INTO `ym_places` VALUES ('422', 'كبودر اهنگ', '30');
INSERT INTO `ym_places` VALUES ('423', 'رزن', '30');
INSERT INTO `ym_places` VALUES ('424', 'اسدآباد', '30');
INSERT INTO `ym_places` VALUES ('425', 'بهار', '30');
INSERT INTO `ym_places` VALUES ('426', 'یزد', '31');
INSERT INTO `ym_places` VALUES ('427', 'تفت', '31');
INSERT INTO `ym_places` VALUES ('428', 'اردكان', '31');
INSERT INTO `ym_places` VALUES ('429', 'ابركوه', '31');
INSERT INTO `ym_places` VALUES ('430', 'میبد', '31');
INSERT INTO `ym_places` VALUES ('431', 'طبس', '31');
INSERT INTO `ym_places` VALUES ('432', 'بافق', '31');
INSERT INTO `ym_places` VALUES ('433', 'مهریز', '31');
INSERT INTO `ym_places` VALUES ('434', 'اشكذر', '31');
INSERT INTO `ym_places` VALUES ('435', 'هرات', '31');
INSERT INTO `ym_places` VALUES ('436', 'خضرآباد', '31');
INSERT INTO `ym_places` VALUES ('437', 'شاهدیه', '31');
INSERT INTO `ym_places` VALUES ('438', 'حمیدیه شهر', '31');
INSERT INTO `ym_places` VALUES ('439', 'سید میرزا', '31');
INSERT INTO `ym_places` VALUES ('440', 'زارچ', '31');
INSERT INTO `ym_places` VALUES ('441', 'دستجرد', '19');
INSERT INTO `ym_places` VALUES ('442', 'کهک', '19');
INSERT INTO `ym_places` VALUES ('443', 'خلجستان', '19');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_site_setting
-- ----------------------------
INSERT INTO `ym_site_setting` VALUES ('1', 'site_title', 'عنوان سایت', 'نیازمندی های آنلاین ');
INSERT INTO `ym_site_setting` VALUES ('2', 'default_title', 'عنوان پیش فرض صفحات', 'تابلو ');
INSERT INTO `ym_site_setting` VALUES ('3', 'keywords', 'کلمات کلیدی سایت', 'خرید، فروش، دست دوم، خودرو، املاک، موبایل، وسایل خانگی، تبلت، پوشاک ، نوزاد و سیسمونی، صوتی و تصویری، دوربین عکاسی فیلمبرداری، کنسول بازی، آرایشی، بهداشتی، زیبایی، جواهر، بدلیجات، ساعت، آنتیک، خدمات، آگهی، نیازمندی، استخدام،');
INSERT INTO `ym_site_setting` VALUES ('4', 'site_description', 'شرح وبسایت', 'تابلو فضای داد و ستد آنلاین و نیازمندی های خرید و فروش اینترنتی رایگان در بخش های املاک، خودرو، وسایل خانگی، موبایل، پوشاک، آنتیک، آرایشی زیبایی بهداشتی، عکاسی و ...');

-- ----------------------------
-- Table structure for ym_towns
-- ----------------------------
DROP TABLE IF EXISTS `ym_towns`;
CREATE TABLE `ym_towns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `name` varchar(100) NOT NULL COMMENT 'عنوان',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='استان ها';

-- ----------------------------
-- Records of ym_towns
-- ----------------------------
INSERT INTO `ym_towns` VALUES ('1', 'آذربايجان شرقی');
INSERT INTO `ym_towns` VALUES ('2', 'آذربايجان غربی');
INSERT INTO `ym_towns` VALUES ('3', 'اردبيل');
INSERT INTO `ym_towns` VALUES ('4', 'اصفهان');
INSERT INTO `ym_towns` VALUES ('5', 'البرز');
INSERT INTO `ym_towns` VALUES ('6', 'ايلام');
INSERT INTO `ym_towns` VALUES ('7', 'بوشهر');
INSERT INTO `ym_towns` VALUES ('8', 'تهران');
INSERT INTO `ym_towns` VALUES ('9', 'چهارمحال بختياری');
INSERT INTO `ym_towns` VALUES ('10', 'خراسان جنوبی');
INSERT INTO `ym_towns` VALUES ('11', 'خراسان رضوی');
INSERT INTO `ym_towns` VALUES ('12', 'خراسان شمالی');
INSERT INTO `ym_towns` VALUES ('13', 'خوزستان');
INSERT INTO `ym_towns` VALUES ('14', 'زنجان');
INSERT INTO `ym_towns` VALUES ('15', 'سمنان');
INSERT INTO `ym_towns` VALUES ('16', 'سيستان و بلوچستان');
INSERT INTO `ym_towns` VALUES ('17', 'فارس');
INSERT INTO `ym_towns` VALUES ('18', 'قزوين');
INSERT INTO `ym_towns` VALUES ('19', 'قم');
INSERT INTO `ym_towns` VALUES ('20', 'كردستان');
INSERT INTO `ym_towns` VALUES ('21', 'كرمان');
INSERT INTO `ym_towns` VALUES ('22', 'كرمانشاه');
INSERT INTO `ym_towns` VALUES ('23', 'كهكيلويه و بويراحمد');
INSERT INTO `ym_towns` VALUES ('24', 'گلستان');
INSERT INTO `ym_towns` VALUES ('25', 'گيلان');
INSERT INTO `ym_towns` VALUES ('26', 'لرستان');
INSERT INTO `ym_towns` VALUES ('27', 'مازندران');
INSERT INTO `ym_towns` VALUES ('28', 'مركزی');
INSERT INTO `ym_towns` VALUES ('29', 'هرمزگان');
INSERT INTO `ym_towns` VALUES ('30', 'همدان');
INSERT INTO `ym_towns` VALUES ('31', 'يزد');

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
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('8', 'masoud', '$2a$12$H9pEmjmlXTABPuGxlaQ.E.29akZUA5X3UxbsHeENB2YqcnHIiqgT.', 'e@s.s', '2');
INSERT INTO `ym_users` VALUES ('9', '', '$2a$12$Bsqz6xUsd3HykzEekwnP7O2tbAe42XytV4dTpV0iEN0gj3TIB/Se.', 'wsd@sd.s', null);
INSERT INTO `ym_users` VALUES ('10', '', '$2a$12$WSwoxdogvRqsDvbAHpc2uO9nuUe5r4pGkXJFhXqpGzMO.0xOnGhNG', 'wsd@sd.s', null);
INSERT INTO `ym_users` VALUES ('11', '', '$2a$12$ag4jsnZyO41SZEZlViKxN.LXiKEJ.xusW1LGaPAtEVAoNzAVNINOi', 'alskmd@akslm.asd', null);
INSERT INTO `ym_users` VALUES ('14', '', '$2a$12$nYpXPB/Kciy8N7Rqt58HZ.Ik/tiZj5ktsbyqEigDFibusySaAJRNq', 'yusef.mobasheri@gmail.com', null);
INSERT INTO `ym_users` VALUES ('15', '', '$2a$12$0T2WyDqGudDBUBcL.OHAsOCQ7cvt/u7A6ATPgsH1FMmDUr8Q57Lpy', 'sa@asd.d', null);
INSERT INTO `ym_users` VALUES ('16', '', '$2a$12$qhZe7dYMfopnusz7UmZiP.qQxLI5cRxQk4WzCJsKWrtmqo.gMIEJO', 'sami@a.s', null);
INSERT INTO `ym_users` VALUES ('17', '', '$2a$12$iHTF9okp6f9jjne60rJDwe7Y5GpcESJkx9BTZ1oSCv0Mha6I446zW', 'asd@asd.asdaaaaa', null);
INSERT INTO `ym_users` VALUES ('18', '', '$2a$12$ElmUqOc0ZPVlQIzDEbjd6eDZVyA4U0KwjANPkVr/pIZtbvbv8RHYa', 'asd@asd.asdaaaaaa', null);
INSERT INTO `ym_users` VALUES ('19', '', '$2a$12$/hxj8aQdI8.qgzkjq78R4un.cxofTHV1a.xG7LOvPQ3gRtxkIwUnq', 'asd@asd.as', null);
INSERT INTO `ym_users` VALUES ('20', '', '$2a$12$BAGEBr9mDIM3zd0Gojeghuo6myrvlrsU//5nY4hWgjYjgziSChWky', 'ae@asd.aa', null);

-- ----------------------------
-- Table structure for ym_user_details
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_details`;
CREATE TABLE `ym_user_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `fa_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام فارسی',
  `en_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام انگلیسی',
  `fa_web_url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس سایت فارسی',
  `en_web_url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس سایت انگلیسی',
  `national_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد ملی',
  `national_card_image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تصویر کارت ملی',
  `phone` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تلفن',
  `zip_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد پستی',
  `address` longtext COLLATE utf8_persian_ci COMMENT 'نشانی دقیق پستی',
  `credit` double DEFAULT NULL COMMENT 'اعتبار',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_details
-- ----------------------------
INSERT INTO `ym_user_details` VALUES ('1', '8', null, null, null, null, null, null, null, null, null, '5000');

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
