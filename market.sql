/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : market

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-05-02 14:37:05
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_apps
-- ----------------------------
INSERT INTO `ym_apps` VALUES ('18', 'کشکول', '43', '4', 'enable', '1000', 'sh88h1460630479.apk', 'ksmvp1460630489.png', '<p><strong>با کشکول، مطالب مورد علاقه تون رو دنبال کنید</strong></p>\r\n\r\n<p> </p>\r\n\r\n<p>‎بیشتر پیگیر چه مطالبی هستی ؟؟ <br />\r\n‎دوست داری اخبار جدید رو در مورد یه موضوع مشخص پیگیری کنی؟؟  دوست داری بدونی دوستات یا افراد مهم چه مطالبی میخونن و چه موضوعاتی رو پیگیری می کنن؟؟ دوست داری سایتهایی که برات مهم اند رو پیگیری کنی و هیچ کدوم از مطالب و اخبارشو از دست ندی؟<br />\r\n‎ کشکول یه سرویس جدیده که در اون میتونی به مطالبی که علاقه داری خیلی راحت دسترسی پیدا کنی و اون ها رو پیگیری کنی.</p>\r\n\r\n<p> </p>\r\n\r\n<p>‎اگر شما از اون دسته آدمهایی هستید که توی اینترنت دنبال مطالب و اخبار مورد علاقه ی خودشون میگردند، باید بهتون یه مژده بدم چون با کشکول دیگه لازم نیست دنبال اخبار و مطالب مورد علاقه تون بگردید. کشکول تمام آن چیزی که بهش علاقمندید رو در اختیارتون قرار میده.شما فقط کافیه به ما بگید به چه چیزی علاقه دارید. اینطوری خیلی توی وقتتون و ترافیک مصرفی اینترنتتون صرفه جویی میشه. <br />\r\n‎چون لازم نیست به سایتهای مختلف سر بزنید و همه ی مطالبشونرو بصورت یکجا توی کشکول ملاحظه خواهید کرد. </p>\r\n\r\n<p> </p>\r\n\r\n<p>‎شما حتی میتونید مطالبی که علاقه دارید را توی پروفایل شخصی خودتون بازنشر کنید تا بتونید این مطالب و سایتها رو به اونها هم معرفی کنید. برای معرفی صفحه شخصی به دوستاتون، فقط لازمه در قسمت تنظیمات، یک شناسه کاربری برای خودتون تعیین کنید. <br />\r\n‎ازین پس شما دارای لینک شخصی در کشکول میشید. </p>\r\n\r\n<p> </p>\r\n\r\n<p>‎اگر سایت مورد علاقه تون توی کشکول ثبت نشده بود، خودتون میتونید وارد سایت کشکول بشید و اون رو در قسمت \"افزودن سایت\"  ثبت کنید.</p>\r\n\r\n<p> </p>\r\n\r\n<p>‎نکته خیلی مهم: <br />\r\n‎تمامی امکانات فوق، در سایت کشکول به آدرس https://kashkol.ir قابل دسترسی هست<br />\r\n‎اپلیکیشن کشکول هنوز در مرحله ی تکمیل قرار داره و به شما قول میدیم در کوتاهترین زمان، تمامی این امکانات رو در اپلیکیشن هم قرار بدیم. </p>\r\n\r\n<p> </p>\r\n\r\n<p>‎درخواست:<br />\r\n‎پس از نصب و استفاده از کشکول، یک نکته یا نظر برای بهبود کشکول به ما بگید. ممنونم. </p>\r\n\r\n<p> </p>\r\n\r\n<p> </p>\r\n\r\n<p> </p>\r\n\r\n<p>‎برای استفاده از تمامی امکانات به آدرس https://kashkol.ir مراجعه کنید.</p>\r\n', '<p>- اضافه شدن صفحه تنظیمات</p>\r\n\r\n<p>- بهبود ثبت نام</p>\r\n\r\n<p>- رفع باگ</p>\r\n', '[\" \\u062e\\u0648\\u0627\\u0646\\u062f\\u0646 \\u062a\\u0646\\u0638\\u06cc\\u0645\\u0627\\u062a \",\" \\u06a9\\u0646\\u062a\\u0631\\u0644 \\u0644\\u0631\\u0632\\u0634 \",\" \\u0645\\u0645\\u0627\\u0646\\u0639\\u062a \\u0627\\u0632 \\u0628\\u0647 \\u062e\\u0648\\u0627\\u0628 \\u0631\\u0641\\u062a\\u0646 \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647 \",\" \\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a \\u0634\\u0628\\u06a9\\u0647 \",\" \\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u06a9\\u0627\\u0645\\u0644 \\u0628\\u0647 \\u0627\\u06cc\\u0646\\u062a\\u0631\\u0646\\u062a \"]', '2127', ' 0.4 ', 'pending', '1', 'کشکول', '53', '0', '4', '0');
INSERT INTO `ym_apps` VALUES ('19', ' آواز (شانس خوانندگی)', '43', '5', 'enable', '0', 'GCeJf1460630634.apk', 'F22F91460630643.png', '<p><strong>آواز شانس شما برای شنیده شدن</strong></p>\r\n\r\n<p> </p>\r\n\r\n<h4><strong>بیش از 50 ترانه ی محبوب در سبک های مختلف پاپ، سنتی، رپ و برخی ترانه های پر طرفدار لاتین را در آکادمی آواز ارائه کردیم که بیشتر آن ها بدون پرداخت هیچ هزینه ای در اختیار شما هستند.</strong></h4>\r\n\r\n<p> </p>\r\n\r\n<p>امکان استفاده از این اپلیکیشن را برای نسخه های قدیمی و جدید اندروید فراهم ساختیم.</p>\r\n\r\n<p> </p>\r\n\r\n<p>با کمک گرافیست های مجرب محیطی جذاب جهت جلب نطر کاربران عزیز این برنامه طراحی کردیم.</p>\r\n\r\n<p> </p>\r\n\r\n<p>قابلیت جدید و منحصر به فردی را با عنوان <strong>avas beats</strong> طراحی کردیم که از طریق تب بیتس در داخل اپلیکیشن قابل دسترسی است و با استفاده از آن می توانید در سبک پاپ یا رپ روی سمپل های آماده هر چه می خواهید بخوانید و اثری منحصر به خودتان بسازید.</p>\r\n\r\n<p> </p>\r\n\r\n<p>امکان برگزاری مسابقه خوانندگی را نیز مهیا کردیم که به طور مداوم برگزار خواهد شد و میتوانید علاوه بر سرگرمی استعداد خوانندگی خود را به چالش کشیده و جایزه ببرید.</p>\r\n\r\n<p> </p>\r\n\r\n<p>در قدم های بعدی نیز علاوه بر بهبود کیفی بخش های مختلف برنامه، بهترین ها رو برای شما در نظر گرفتیم که در حال حاضر در حال بررسی و اجرا می باشند.</p>\r\n\r\n<p> </p>\r\n\r\n<p>قرن هاست که آواز ابزاری تأثیرگذار برای بیان احساسات انسان به شمار می رود و همواره از محبوبیت خاصی در عموم فرهنگ های دنیا برخوردار بوده. با توجه به اینکه همه ی ما بنا به طبع و سلیقه ی خود با سبکی از هنر موسیقی ارتباط برقرار میکنیم، تیم آکادمی آواز با بهره گیری از اساتید متخصص در حوزه های برنامه نویسی و موسیقی مفتخر است این محصول را با امکانات جدید و منحصر به فرد که برخی از آن ها برای اولین بار به واسطه ی این اپلیکیشن ارائه میشود، به تمام علاقه مندان به خوانندگی در سبک ها و سطوح متفاوت تقدیم کند.</p>\r\n\r\n<p> </p>\r\n\r\n<p>طی چند ماه تلاش پی در پی و با استفاده از تجربیات اساتید موسیقی در رشته ی آهنگسازی و آواز، همچنین متخصصین برنامه نویس که جزئی از تیم آکادمی آواز هستند مقدمات یک اتفاق بزرگ را فراهم کردیم.</p>\r\n\r\n<p> </p>\r\n\r\n<p>آواز به معنی جمع آواهای شماست پس با پشتیبانی و حمایت شما کاربران گرامی هر روز با ترانه ها و قابلیت های جدید در جهت نزدیک کردن این برنامه به خواسته های شما قدم برمی داریم.</p>\r\n\r\n<p> </p>\r\n\r\n<p>هدف اصلی ما جلب رضایت شماست</p>\r\n\r\n<p> </p>\r\n\r\n<p>بخوانید، لذت ببرید و ستاره شوید...</p>\r\n\r\n<p> </p>\r\n\r\n<p><strong>توجه:</strong></p>\r\n\r\n<p> </p>\r\n\r\n<p><strong>هنگام ضبط حتماً از هدفون با کیفیت استفاده کنید و نیز بهتر است درمقدار فاصله میکروفون با دهان خود دقت فرمایید.</strong></p>\r\n\r\n<p> </p>\r\n\r\n<p><strong>هر هفته بدون نیاز به آپدیت از ترانه های جدید و به روز تهیه شده توسط تیم آکادمی آواز بهره مند شوید.</strong></p>\r\n', '', '[\"\\u062e\\u0648\\u0627\\u0646\\u062f\\u0646 \\u062a\\u0646\\u0638\\u06cc\\u0645\\u0627\\u062a\",\"\\u06a9\\u0646\\u062a\\u0631\\u0644 \\u0644\\u0631\\u0632\\u0634\",\"\\u0645\\u0645\\u0627\\u0646\\u0639\\u062a \\u0627\\u0632 \\u0628\\u0647 \\u062e\\u0648\\u0627\\u0628 \\u0631\\u0641\\u062a\\u0646 \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a \\u0634\\u0628\\u06a9\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u06a9\\u0627\\u0645\\u0644 \\u0628\\u0647 \\u0627\\u06cc\\u0646\\u062a\\u0631\\u0646\\u062a\",\" \\u062a\\u063a\\u06cc\\u06cc\\u0631 \\u06cc\\u0627 \\u062d\\u0630\\u0641 \\u0645\\u062d\\u062a\\u0648\\u06cc\\u0627\\u062a \\u06a9\\u0627\\u0631\\u062a \\u062d\\u0627\\u0641\\u0638\\u0647 \"]', '2127', '1.0', 'accepted', '1', 'mass music box', '21', '0', '3', '0');
INSERT INTO `ym_apps` VALUES ('20', ' برنامه لیدکامب - لکنت کودکان', '43', '8', 'enable', '8000', '3vTXT1460814161.apk', 'ktQO11460814173.png', '<p>برنامه ی لیدکامب یک درمان رفتاری است که لکنت کودکان را مد نظر قرار می ­دهد. در طول برنامه ی لیدکامب، به هیچ عنوان از کودکان تحت درمان خواسته نمی ­شود الگوی صحبت کردن عادی خود را تغییر دهند. والدین تحت هیچ شرایطی نه عادات گفتاری معمولی خود را تغییر می دهند، نه سبک زندگی خود را. والدین، یا گاهی اوقات پرستاران، برنامه ی درمانی لیدکامب را با آموزش و نظارت یک درمانگر متخصص اجرا می کنند.</p>\r\n\r\n<p> </p>\r\n\r\n<p>«مراجعه ی هفتگی والدین به کلینیک» - «اهداف درمانی» - «اندازه گیری لکنت» - «هدف SR» - «اهداف درمانی مشخص شده توسط SR» - «بازخورد کلامی والدین» از آیتم های برنامه لیدکامب می باشد.</p>\r\n\r\n<p> </p>\r\n\r\n<p>......</p>\r\n\r\n<p> </p>\r\n\r\n<p>این برنامه با همکاری گروه نرم افزاری هورماه و کلینیک گفتاردرمانی آیران ارايه و آماده سازی شده است.</p>\r\n\r\n<p> </p>\r\n\r\n<p>مشاوران درمانی :</p>\r\n\r\n<p> </p>\r\n\r\n<p>عاطفه موذنی - کارشناس ارشد گفتاردرمانی</p>\r\n\r\n<p> </p>\r\n\r\n<p>میثم شفیعی - کارشناس ارشد گفتاردرمانی</p>\r\n\r\n<p> </p>\r\n\r\n<p>توسعه دهنده اپلیکیشن :</p>\r\n\r\n<p> </p>\r\n\r\n<p>سید محمد حسین سجادی منش</p>\r\n\r\n<p> </p>\r\n\r\n<p>وبسایت:</p>\r\n\r\n<p> </p>\r\n\r\n<p><a href=\"http://www.stutteringapk.ir\">stutteringapk.ir</a></p>\r\n', '', '[\"\\u062e\\u0648\\u0627\\u0646\\u062f\\u0646 \\u06a9\\u0627\\u0631\\u062a \\u062d\\u0627\\u0641\\u0638\\u0647\",\"\\u06cc\\u0627\\u0641\\u062a\\u0646 \\u062d\\u0633\\u0627\\u0628\\u200c\\u0647\\u0627 \\u062f\\u0631 \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"\\u062f\\u0631\\u06cc\\u0627\\u0641\\u062a \\u0627\\u0637\\u0644\\u0627\\u0639\\u0627\\u062a \\u0627\\u0632 \\u0627\\u06cc\\u0646\\u062a\\u0631\\u0646\\u062a\",\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a \\u0634\\u0628\\u06a9\\u0647\"]', '2127', '1.3', 'accepted', '2', null, '2', '0', '0', '0');

-- ----------------------------
-- Table structure for ym_app_buys
-- ----------------------------
DROP TABLE IF EXISTS `ym_app_buys`;
CREATE TABLE `ym_app_buys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  PRIMARY KEY (`id`),
  KEY `app_id` (`app_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_app_buys_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `ym_apps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_app_buys_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_app_buys
-- ----------------------------
INSERT INTO `ym_app_buys` VALUES ('2', '18', '43', '1461845059');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_app_categories
-- ----------------------------
INSERT INTO `ym_app_categories` VALUES ('1', 'برنامه ها', null, null);
INSERT INTO `ym_app_categories` VALUES ('2', 'بازی ها', null, null);
INSERT INTO `ym_app_categories` VALUES ('3', 'آموزش ها', null, null);
INSERT INTO `ym_app_categories` VALUES ('4', 'آب و هوا', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('5', 'ماجراجویی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('6', 'اخبار و مجلات', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('7', 'ارتباطات', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('8', 'پزشکی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('9', 'استراتژی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('10', 'خانوادگی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('11', 'تفننی', '2', '2-');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_app_images
-- ----------------------------
INSERT INTO `ym_app_images` VALUES ('7', '18', '7i1hq1460630601.jpg');
INSERT INTO `ym_app_images` VALUES ('8', '18', 'TwYEo1460630602.jpg');
INSERT INTO `ym_app_images` VALUES ('9', '18', 'b5Ueb1460630604.jpg');
INSERT INTO `ym_app_images` VALUES ('10', '19', 'N9QpK1460630672.jpg');
INSERT INTO `ym_app_images` VALUES ('11', '19', 'AFD1r1460630679.jpg');
INSERT INTO `ym_app_images` VALUES ('12', '19', 'daS8E1460630684.jpg');
INSERT INTO `ym_app_images` VALUES ('13', '20', 'lV7Hb1460814214lV7Hb1460814214.jpg');
INSERT INTO `ym_app_images` VALUES ('14', '20', 'AYGcM1460814245AYGcM1460814245.jpg');
INSERT INTO `ym_app_images` VALUES ('15', '20', 'wCnw21460814247wCnw21460814247.jpg');

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
INSERT INTO `ym_counter_save` VALUES ('counter', '71');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2457511');
INSERT INTO `ym_counter_save` VALUES ('max_count', '5');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1457598600');
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
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1462175618');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_pages
-- ----------------------------
INSERT INTO `ym_pages` VALUES ('1', 'درباره ما', 'متن صفحه درباره ما', '1');
INSERT INTO `ym_pages` VALUES ('2', 'تماس با ما', 'متن صفحه تماس با ما', '1');
INSERT INTO `ym_pages` VALUES ('3', 'راهنما', 'متن صفحه راهنما', '1');
INSERT INTO `ym_pages` VALUES ('4', 'شرایط استفاده از خدمات', 'متن صفحه شرایط استفاده از خدمات', '1');
INSERT INTO `ym_pages` VALUES ('5', 'حریم شخصی', 'متن صفحه حریم شخصی', '1');
INSERT INTO `ym_pages` VALUES ('6', 'متن راهنمای تسویه حساب', 'متن راهنما', '1');
INSERT INTO `ym_pages` VALUES ('7', 'قرارداد توسعه دهندگان', 'متن قرارداد', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_page_categories
-- ----------------------------
INSERT INTO `ym_page_categories` VALUES ('1', 'صفحات استاتیک', 'base', '1');

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_site_setting
-- ----------------------------
INSERT INTO `ym_site_setting` VALUES ('1', 'site_title', 'عنوان سایت', 'نیازمندی های آنلاین ');
INSERT INTO `ym_site_setting` VALUES ('2', 'default_title', 'عنوان پیش فرض صفحات', 'تابلو ');
INSERT INTO `ym_site_setting` VALUES ('3', 'keywords', 'کلمات کلیدی سایت', 'خرید، فروش، دست دوم، خودرو، املاک، موبایل، وسایل خانگی، تبلت، پوشاک ، نوزاد و سیسمونی، صوتی و تصویری، دوربین عکاسی فیلمبرداری، کنسول بازی، آرایشی، بهداشتی، زیبایی، جواهر، بدلیجات، ساعت، آنتیک، خدمات، آگهی، نیازمندی، استخدام،');
INSERT INTO `ym_site_setting` VALUES ('4', 'site_description', 'شرح وبسایت', 'تابلو فضای داد و ستد آنلاین و نیازمندی های خرید و فروش اینترنتی رایگان در بخش های املاک، خودرو، وسایل خانگی، موبایل، پوشاک، آنتیک، آرایشی زیبایی بهداشتی، عکاسی و ...');
INSERT INTO `ym_site_setting` VALUES ('5', 'buy_credit_options', 'گزینه های خرید اعتبار', '[\"5000\",\"10000\",\"20000\"]');
INSERT INTO `ym_site_setting` VALUES ('6', 'min_credit', 'حداقل اعتبار جهت تبدیل عضویت', '1000');
INSERT INTO `ym_site_setting` VALUES ('7', 'tax', 'میزان مالیات (درصد)', '9');
INSERT INTO `ym_site_setting` VALUES ('8', 'commission', 'حق کمیسیون (درصد)', '15');

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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('39', '', '$2a$12$aZ3RdEA7oLAVEcYrs.TT/uO6yC6lUADCi8AoOntHdvdui9WwR6nJ2', 'm@gmail.com', '2', '1460625263', 'pending', '23aa8793179b679912142a701e3a9632', '0');
INSERT INTO `ym_users` VALUES ('43', '', '$2a$12$s8yAVo/JZ3Z86w5iFQV/7OIOGEwhyBCWj1Jw5DrlIqHERUF2otno2', 'gharagozlu.masoud@gmail.com', '2', '1460634664', 'active', 'ec0bfa4e54eed8afb0d7fb0305d52759', '1');

-- ----------------------------
-- Table structure for ym_user_app_bookmark
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_app_bookmark`;
CREATE TABLE `ym_user_app_bookmark` (
  `user_id` int(10) unsigned DEFAULT NULL,
  `app_id` int(10) unsigned DEFAULT NULL,
  KEY `user_id` (`user_id`),
  KEY `app_id` (`app_id`),
  CONSTRAINT `ym_user_app_bookmark_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_user_app_bookmark_ibfk_2` FOREIGN KEY (`app_id`) REFERENCES `ym_apps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_app_bookmark
-- ----------------------------
INSERT INTO `ym_user_app_bookmark` VALUES ('43', '18');
INSERT INTO `ym_user_app_bookmark` VALUES ('43', '19');
INSERT INTO `ym_user_app_bookmark` VALUES ('43', '20');

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
  `monthly_settlement` tinyint(4) DEFAULT '0' COMMENT 'تسویه حساب ماهانه',
  `iban` varchar(24) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شماره شبا',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_details
-- ----------------------------
INSERT INTO `ym_user_details` VALUES ('39', 'یوسف مبشری', 'yusef', null, null, '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', '1000', 'Yusef', 'accepted', '1', '23423');
INSERT INTO `ym_user_details` VALUES ('43', 'مسعود قراگوزلو', 'masoud', '', '', '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', '1000', 'Masoud', 'accepted', '1', '234242342');

-- ----------------------------
-- Table structure for ym_user_dev_id_requests
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_dev_id_requests`;
CREATE TABLE `ym_user_dev_id_requests` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `requested_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه درخواستی',
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

-- ----------------------------
-- Table structure for ym_user_settlement
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_settlement`;
CREATE TABLE `ym_user_settlement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `amount` varchar(15) DEFAULT NULL COMMENT 'مبلغ',
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  `iban` varchar(24) DEFAULT NULL COMMENT 'شماره شبا',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ym_user_settlement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_settlement
-- ----------------------------
INSERT INTO `ym_user_settlement` VALUES ('28', '43', '19000', '1462175546', '234242342');
INSERT INTO `ym_user_settlement` VALUES ('29', '39', '299000', '1462175552', '23423');

-- ----------------------------
-- Table structure for ym_user_transactions
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_transactions`;
CREATE TABLE `ym_user_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `amount` varchar(10) DEFAULT NULL COMMENT 'مقدار',
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  `status` enum('unpaid','paid') DEFAULT 'unpaid' COMMENT 'وضعیت',
  `token` varchar(50) DEFAULT NULL COMMENT 'کد رهگیری',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ym_user_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_transactions
-- ----------------------------
INSERT INTO `ym_user_transactions` VALUES ('1', '43', '5000', '1461646925', 'paid', 'j2343jk4h2k4h24h', 'خرید اعتبار از طریق درگاه زرین پال');
INSERT INTO `ym_user_transactions` VALUES ('2', '39', '1000', '1461646925', 'paid', 'asdf8sa97df9s7f', 'خرید اعتبار از طریق درگاه زرین پال');
INSERT INTO `ym_user_transactions` VALUES ('3', '39', '2000', '1461646925', 'unpaid', null, null);
