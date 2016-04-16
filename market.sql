/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : market

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-04-16 15:20:14
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
  `install` int(12) unsigned DEFAULT '0' COMMENT 'تعداد نصب فعال',
  `deleted` tinyint(1) unsigned DEFAULT '0' COMMENT 'حذف شده',
  PRIMARY KEY (`id`),
  KEY `developer_id` (`developer_id`),
  KEY `category_id` (`category_id`),
  KEY `platform_id` (`platform_id`),
  CONSTRAINT `ym_apps_ibfk_1` FOREIGN KEY (`developer_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_apps_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ym_app_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_apps_ibfk_3` FOREIGN KEY (`platform_id`) REFERENCES `ym_app_platforms` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_apps
-- ----------------------------
INSERT INTO `ym_apps` VALUES ('17', 'هواشناسی هوشمند و پیشرفته', null, '4', 'enable', '4000', 'ZHs0h1457613911.apk', '1FUfb1457613932.png', '<p><strong>هواشناسی پیشرفته و جدید کافه بازار</strong><br />\nجدیدترین اپلیکیشین هواشناسی با طراحی فوق العاده و متریال پیش روی شماست !<br />\nبا این برنامه میتونید آب و هوای تمام شهرهای ایران و دنیارو در کمترین زمان با طراحی فوق العاده زیبا مشاهده کنید و برای روزهای بعدی برنامه ریزی داشته باشید !</p>\n\n<p> </p>\n\n<p><strong>امکانات جدید و بی نظیر این نرم افزار شامل :</strong></p>\n\n<p> </p>\n\n<p>- نمایش آب و هوای تمام نقاط و شهرهای دنیا، بویژه ایران<br />\n- پیش بینی آب و هوای شش روز آینده<br />\n- پشتیبانی از چند شهر برای نمایش آب و هوا<br />\n- پشتیبانی از مکان کاربر برای نمایش آب و هوا<br />\n- دارای ویجت صفحه قفل و نوار اعلان برای دسترسی بهتر<br />\n- نمایش آب و هوای نزدیک ترین محل به نقطه ی مورد نظر درصورت پیدا نکردن نام محل (منحصر به فردترین امکان برنامه بدون مشابه داخلی و خارجی)<br />\n- رابط کاربری فوق العاده زیبا و متریال، تغییر ظاهر برنامه با توجه به شرایط و ساعت شبانه روز<br />\n- دریافت اطلاعات از سرور معتبر و دقیق برای هواشناسی برای پیش بینی دقیق<br />\n-پیش بینی دوره ای و ساعتی وضعیت هوا<br />\n- امکان به اشتراک گذاشتن آب و هوا برای اطلاع رسانی به دوستان<br />\n- و ...</p>\n', '<p>بهبود رابط کاربری در اندروید 4.2</p>\n', '[\" \\u0627\\u062c\\u0631\\u0627 \\u0634\\u062f\\u0646 \\u062f\\u0631 \\u0647\\u0646\\u06af\\u0627\\u0645 \\u0631\\u0627\\u0647\\u200c\\u0627\\u0646\\u062f\\u0627\\u0632\\u06cc \",\"\\u062e\\u0648\\u0627\\u0646\\u062f\\u0646 \\u06a9\\u0627\\u0631\\u062a \\u062d\\u0627\\u0641\\u0638\\u0647\"]', '2127', ' 1.0.5', 'accepted', '1', 'سیبچه', '0', '0');
INSERT INTO `ym_apps` VALUES ('18', 'برنامه آیفون', null, '4', 'enable', '0', 'ZHs0h1457613911.apk', '1FUfb1457613932.png', null, null, null, '2127', null, 'accepted', '2', 'سیبچه', '0', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_app_categories
-- ----------------------------
INSERT INTO `ym_app_categories` VALUES ('1', 'برنامه ها', null, null);
INSERT INTO `ym_app_categories` VALUES ('2', 'بازی ها', null, null);
INSERT INTO `ym_app_categories` VALUES ('3', 'آموزش ها', null, null);
INSERT INTO `ym_app_categories` VALUES ('4', 'کاربردی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('5', 'آب و هوا', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('6', 'موسیقی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('7', 'اکشن', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('8', 'فکری', '2', '2-');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_app_images
-- ----------------------------
INSERT INTO `ym_app_images` VALUES ('15', '31', 'IY4ef1457338577IY4ef1457338577.jpg');
INSERT INTO `ym_app_images` VALUES ('16', '31', 'rwrJK1457338579rwrJK1457338579.jpg');
INSERT INTO `ym_app_images` VALUES ('17', '32', 'aPZHE1457339210aPZHE1457339210.jpg');

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
INSERT INTO `ym_counter_save` VALUES ('counter', '28');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2457495');
INSERT INTO `ym_counter_save` VALUES ('max_count', '1');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1455957000');
INSERT INTO `ym_counter_save` VALUES ('yesterday', '0');

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
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1460790399');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

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
INSERT INTO `ym_pages` VALUES ('17', 'قرارداد توسعه دهندگان', 'متن قرارداد', '4');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_site_setting
-- ----------------------------
INSERT INTO `ym_site_setting` VALUES ('1', 'site_title', 'عنوان سایت', 'نیازمندی های آنلاین ');
INSERT INTO `ym_site_setting` VALUES ('2', 'default_title', 'عنوان پیش فرض صفحات', 'تابلو ');
INSERT INTO `ym_site_setting` VALUES ('3', 'keywords', 'کلمات کلیدی سایت', 'خرید، فروش، دست دوم، خودرو، املاک، موبایل، وسایل خانگی، تبلت، پوشاک ، نوزاد و سیسمونی، صوتی و تصویری، دوربین عکاسی فیلمبرداری، کنسول بازی، آرایشی، بهداشتی، زیبایی، جواهر، بدلیجات، ساعت، آنتیک، خدمات، آگهی، نیازمندی، استخدام،');
INSERT INTO `ym_site_setting` VALUES ('4', 'site_description', 'شرح وبسایت', 'تابلو فضای داد و ستد آنلاین و نیازمندی های خرید و فروش اینترنتی رایگان در بخش های املاک، خودرو، وسایل خانگی، موبایل، پوشاک، آنتیک، آرایشی زیبایی بهداشتی، عکاسی و ...');
INSERT INTO `ym_site_setting` VALUES ('5', 'buy_credit_options', 'گزینه های خرید اعتبار', '[\"5000\",\"10000\",\"20000\"]');
INSERT INTO `ym_site_setting` VALUES ('6', 'min_credit', 'حداقل اعتبار جهت تبدیل عضویت', '1000');

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
  `create_date` varchar(20) DEFAULT NULL,
  `status` enum('pending','active','blocked','deleted') DEFAULT 'pending',
  `verification_token` varchar(100) DEFAULT NULL,
  `change_password_request_count` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('8', '', '$2a$12$Fdjxz7ATPpgbZf50mx40uudLwdWL1tMCgpftg6NdK/8xVXT2jgog.', 'e@s.s', '2', null, 'pending', null, '0');
INSERT INTO `ym_users` VALUES ('9', '', '$2a$12$Fdjxz7ATPpgbZf50mx40uudLwdWL1tMCgpftg6NdK/8xVXT2jgog.', 'masoud@gmail.com', '2', null, 'active', '4a50c13f6b162f3f2d7e8373c512e3b2', '0');
INSERT INTO `ym_users` VALUES ('10', '', '$2a$12$WSwoxdogvRqsDvbAHpc2uO9nuUe5r4pGkXJFhXqpGzMO.0xOnGhNG', 'wsd@sd.s', null, null, 'pending', null, '0');
INSERT INTO `ym_users` VALUES ('11', '', '$2a$12$ag4jsnZyO41SZEZlViKxN.LXiKEJ.xusW1LGaPAtEVAoNzAVNINOi', 'alskmd@akslm.asd', null, null, 'pending', null, '0');
INSERT INTO `ym_users` VALUES ('14', '', '$2a$12$nYpXPB/Kciy8N7Rqt58HZ.Ik/tiZj5ktsbyqEigDFibusySaAJRNq', 'yusef.mobasheri@gmail.com', null, null, 'pending', null, '0');
INSERT INTO `ym_users` VALUES ('15', '', '$2a$12$0T2WyDqGudDBUBcL.OHAsOCQ7cvt/u7A6ATPgsH1FMmDUr8Q57Lpy', 'sa@asd.d', null, null, 'pending', null, '0');
INSERT INTO `ym_users` VALUES ('16', '', '$2a$12$qhZe7dYMfopnusz7UmZiP.qQxLI5cRxQk4WzCJsKWrtmqo.gMIEJO', 'sami@a.s', null, null, 'pending', null, '0');
INSERT INTO `ym_users` VALUES ('17', '', '$2a$12$iHTF9okp6f9jjne60rJDwe7Y5GpcESJkx9BTZ1oSCv0Mha6I446zW', 'asd@asd.asdaaaaa', null, null, 'pending', null, '0');
INSERT INTO `ym_users` VALUES ('18', '', '$2a$12$ElmUqOc0ZPVlQIzDEbjd6eDZVyA4U0KwjANPkVr/pIZtbvbv8RHYa', 'asd@asd.asdaaaaaa', null, null, 'pending', null, '0');
INSERT INTO `ym_users` VALUES ('19', '', '$2a$12$/hxj8aQdI8.qgzkjq78R4un.cxofTHV1a.xG7LOvPQ3gRtxkIwUnq', 'asd@asd.as', null, null, 'pending', null, '0');
INSERT INTO `ym_users` VALUES ('20', '', '$2a$12$BAGEBr9mDIM3zd0Gojeghuo6myrvlrsU//5nY4hWgjYjgziSChWky', 'ae@asd.aa', null, null, 'pending', null, '0');
INSERT INTO `ym_users` VALUES ('23', '', '$2a$12$WdOyD.ae7NxYz0wdwCUHiexTQfZrVw6/3fU3Qvf4htn09a3W..QAK', 'gharagozlu.masoud@gmail.com', '1', '1460361827', 'pending', '202b3c3b071cf7c9ca19f8f68bb85232', '0');
INSERT INTO `ym_users` VALUES ('24', '', '$2a$12$WiZYKzWKevV.9/b3eUulK.Oy0CDh/1WlFzTRM21I9QllUnABh2l1S', 'gharagozlu.amasoud@gmail.com', '1', '1460364861', 'pending', '2b60060523aff84d960fe770ae947740', '0');
INSERT INTO `ym_users` VALUES ('25', '', '$2a$12$ZEPk9MlddmE3J4rGMtw/uuKHl1X0sWSxS6iSgEr5Z.EwI577ybeAm', 'gharadgozlu.masoud@gmail.com', '1', '1460521814', 'pending', '0dba9a0699e816bbce7e43ce2b6233aa', '0');
INSERT INTO `ym_users` VALUES ('26', '', '$2a$12$Hnkw1kkb3kwMv7oR4VnLBuEXy0n4kXNQBY95Eno03D7qtrNzgytjW', 'masou1d@gmail.com', '1', '1460787564', 'pending', '9aa9b5d21567c554ea571550ec4a5d25', '0');

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
  `developer_id` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه توسعه دهنده',
  `details_status` enum('accepted','pending','failed') COLLATE utf8_persian_ci DEFAULT 'accepted' COMMENT 'وضعیت اطلاعات کاربر',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_details
-- ----------------------------
INSERT INTO `ym_user_details` VALUES ('1', '8', 'مسعود قراگوزلو', 'Masoud Gharagozlu', '', '', null, null, null, null, null, '5000', '', null);
INSERT INTO `ym_user_details` VALUES ('2', '9', 'مسعود قراگوزلو', 'Masoud Gharagozlu', '', '', '0370518926', '6Own01460349732.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد خ شوندی ک12 پ5', '1500', null, 'pending');
INSERT INTO `ym_user_details` VALUES ('5', '23', null, null, null, null, null, null, null, null, null, null, null, 'accepted');
INSERT INTO `ym_user_details` VALUES ('6', '24', null, null, null, null, null, null, null, null, null, null, null, 'accepted');
INSERT INTO `ym_user_details` VALUES ('7', '25', null, null, null, null, null, null, null, null, null, null, null, 'accepted');
INSERT INTO `ym_user_details` VALUES ('8', '26', null, null, null, null, null, null, null, null, null, null, null, 'accepted');

-- ----------------------------
-- Table structure for ym_user_dev_id_requests
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_dev_id_requests`;
CREATE TABLE `ym_user_dev_id_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `requested_id` varchar(20) DEFAULT NULL COMMENT 'شناسه درخواستی',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
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
