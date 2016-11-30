/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : market

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-11-30 16:36:32
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admins
-- ----------------------------
INSERT INTO `ym_admins` VALUES ('24', 'admin', '$2a$12$4zT7cVJzpPy/B0WQ3nx.pOJ4pF6..jQ.yGA/5PVBN1Xty/8hacrYG', 'admin@gmial.com', '1');
INSERT INTO `ym_admins` VALUES ('28', 'masoud', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'gharagozlu.masoud@gmail.com', '1');

-- ----------------------------
-- Table structure for ym_admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_admin_roles`;
CREATE TABLE `ym_admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'عنوان نقش',
  `role` varchar(255) NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admin_roles
-- ----------------------------
INSERT INTO `ym_admin_roles` VALUES ('1', 'مدیر', 'admin');
INSERT INTO `ym_admin_roles` VALUES ('2', 'ناظر', 'validator');
INSERT INTO `ym_admin_roles` VALUES ('3', 'پشتیبان', 'supporter');

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
  `icon` varchar(50) DEFAULT NULL,
  `description` longtext,
  `change_log` longtext,
  `permissions` longtext,
  `size` float DEFAULT NULL,
  `confirm` enum('incomplete','pending','refused','accepted','change_required') DEFAULT 'incomplete',
  `platform_id` int(10) unsigned DEFAULT NULL,
  `developer_team` varchar(50) DEFAULT NULL,
  `seen` tinyint(1) unsigned DEFAULT '0' COMMENT 'دیده شده',
  `download` int(12) unsigned DEFAULT '0' COMMENT 'تعداد دریافت',
  `install` int(12) unsigned DEFAULT '0' COMMENT 'تعداد نصب فعال',
  `deleted` tinyint(1) unsigned DEFAULT '0' COMMENT 'حذف شده',
  `support_phone` varchar(11) DEFAULT NULL COMMENT 'تلفن',
  `support_email` varchar(255) DEFAULT NULL COMMENT 'ایمیل',
  `support_fa_web` varchar(255) DEFAULT NULL COMMENT 'وب سایت فارسی',
  `support_en_web` varchar(255) DEFAULT NULL COMMENT 'وب سایت انگلیسی',
  PRIMARY KEY (`id`),
  KEY `developer_id` (`developer_id`),
  KEY `category_id` (`category_id`),
  KEY `platform_id` (`platform_id`),
  CONSTRAINT `ym_apps_ibfk_1` FOREIGN KEY (`developer_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_apps_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ym_app_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_apps_ibfk_3` FOREIGN KEY (`platform_id`) REFERENCES `ym_app_platforms` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_apps
-- ----------------------------
INSERT INTO `ym_apps` VALUES ('47', 'مرورگر اپرا مینی', null, '7', 'enable', '0', 'MHDeb1466454442.png', '<p>شما میتوانید با نصبمرورگرهای محبوبی مثل <strong>Opera</strong> در موبایل خودتان، صفحات اینترنت را سریع تر و راحت تر مشاهده کنید و از امکانات مختلف این مرورگرها استفاده نمایید.</p>\n\n<p> </p>\n\n<p><strong>مرورگر Opera</strong> پرطرفدارترین و پرکاربرد ترین مرورگر حال حاضر در بیشتر گوشی ها است. این مرورگر با قابلیت های خوب خود نیازهای هر کاربری را برطرف میکند.</p>\n', '', null, null, 'accepted', '3', 'opera', '17', '0', '8', '1', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('48', 'دعای روزانه ماه رمضان+صوت', '46', '12', 'enable', '1000', 'HWerv1466462964.png', '<p style=\"text-align:right;\">دعاهای روزانه ماه رمضان</p>\r\n\r\n<p style=\"text-align:right;\">به همراه صوت</p>\r\n', '', '[\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0648\\u0636\\u0639\\u06cc\\u062a \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0634\\u0628\\u06a9\\u0647 Wi-Fi\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u0637\\u0644\\u0627\\u0639\\u0627\\u062a \\u0634\\u0628\\u06a9\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u06cc\\u0646\\u062a\\u0631\\u0646\\u062a\",\"\\u0645\\u062f\\u06cc\\u0631\\u06cc\\u062a \\u062d\\u0627\\u0641\\u0638\\u0647 \\u062e\\u0627\\u0631\\u062c\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u062d\\u0627\\u0641\\u0638\\u0647 \\u0647\\u0627\\u06cc \\u062e\\u0627\\u0631\\u062c\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u062a\\u0645\\u0627\\u0633 \\u062a\\u0644\\u0641\\u0646\\u06cc\",\"RECEIVE_BOOT_COMPLETED\",\"\\u0645\\u0645\\u0627\\u0646\\u0639\\u062a \\u0627\\u0632 \\u0628\\u0647 \\u062e\\u0648\\u0627\\u0628 \\u0631\\u0641\\u062a\\u0646 \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"\\u0627\\u0631\\u0633\\u0627\\u0644 \\u067e\\u06cc\\u0627\\u0645\\u06a9\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 NFC\",\"ACCESS_SUPERUSER\",\"\\u062f\\u0631\\u06cc\\u0627\\u0641\\u062a \\u0644\\u06cc\\u0633\\u062a \\u062d\\u0633\\u0627\\u0628 \\u0647\\u0627\\u06cc \\u06a9\\u0627\\u0631\\u0628\\u0631\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0645\\u062e\\u0627\\u0637\\u0628\\u06cc\\u0646\"]', null, 'accepted', '1', null, '214', '0', '54', '0', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('49', 'دعای روزهای ماه رمضان', '46', '12', 'enable', '0', 'AXQD81466465420.png', '<p>دعای روزهای ماه رمضان+ترجمه</p>\r\n\r\n<p> </p>\r\n\r\n<p>بدون صوت</p>\r\n', '', '[\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0648\\u0636\\u0639\\u06cc\\u062a \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0634\\u0628\\u06a9\\u0647 Wi-Fi\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u0637\\u0644\\u0627\\u0639\\u0627\\u062a \\u0634\\u0628\\u06a9\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u06cc\\u0646\\u062a\\u0631\\u0646\\u062a\",\"\\u0645\\u062f\\u06cc\\u0631\\u06cc\\u062a \\u062d\\u0627\\u0641\\u0638\\u0647 \\u062e\\u0627\\u0631\\u062c\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u062d\\u0627\\u0641\\u0638\\u0647 \\u0647\\u0627\\u06cc \\u062e\\u0627\\u0631\\u062c\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u062a\\u0645\\u0627\\u0633 \\u062a\\u0644\\u0641\\u0646\\u06cc\",\"RECEIVE_BOOT_COMPLETED\",\"\\u0645\\u0645\\u0627\\u0646\\u0639\\u062a \\u0627\\u0632 \\u0628\\u0647 \\u062e\\u0648\\u0627\\u0628 \\u0631\\u0641\\u062a\\u0646 \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"\\u0627\\u0631\\u0633\\u0627\\u0644 \\u067e\\u06cc\\u0627\\u0645\\u06a9\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 NFC\",\"ACCESS_SUPERUSER\",\"\\u062f\\u0631\\u06cc\\u0627\\u0641\\u062a \\u0644\\u06cc\\u0633\\u062a \\u062d\\u0633\\u0627\\u0628 \\u0647\\u0627\\u06cc \\u06a9\\u0627\\u0631\\u0628\\u0631\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0645\\u062e\\u0627\\u0637\\u0628\\u06cc\\u0646\"]', null, 'accepted', '1', null, '150', '0', '29', '0', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('53', 'اپرا', '46', '28', 'enable', '0', 'uXWbP1467036994.png', '<p>ندارد</p>\n', '', null, null, 'accepted', '3', null, '4', '0', '1', '1', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('55', 'اپرا', null, '7', 'enable', '0', 'NpopE1467046261.png', '<p><strong>مرورگر Opera</strong> پرطرفدارترین و پرکاربرد ترین مرورگر حال حاضر در بیشتر گوشی ها است. این مرورگر با قابلیت های خوب خود نیازهای هر کاربری را برطرف میکند.</p>\n', '', null, null, 'accepted', '3', 'opera', '44', '0', '20', '0', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('57', 'MoliPlayer Pro', null, '14', 'enable', '0', '0WeaT1467121740.png', '<p>نرم افزار <strong>MoliPlayer Pro</strong> یکی از بهترین پلیرها برای ویندور فون میباشد. با نصب این پلیر همه محدودیت ها در پخش فایل های تصویری برطرف خواهد شد.</p>\n\n<p>این نرم افزار قابلیت پخش انواع فرمت های تصویری را دارد و میتواند اکثر فایل های صوتی را نیز پخش کند.</p>\n\n<p> </p>\n\n<p>نرم افزار <strong>MoliPlayer Pro</strong> از زیرنویس های فارسی نیز پشتیبانی میکند.</p>\n', '', null, null, 'accepted', '3', 'MoliPlayer', '22', '0', '11', '1', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('58', 'نرم افزار PhotoGrid برای ویرایش عکس', null, '27', 'enable', '0', 'gv6Ue1467126131.png', '<p>این نرم افزار به شما این امکان را می دهد تا عکس های خود را ویرایش کنید و در شبکه های اجتماعی قرار دهید.</p>\n', '', null, null, 'accepted', '3', 'PhotoGrid', '39', '0', '28', '0', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('59', 'عید سعید فطر+صوت', '45', '12', 'enable', '500', 'FRooM1467569693.png', '<p style=\"text-align:right;\">نماز عید فطر با قابلیت پخش صوت دلنشین و خاطره انگیز</p>\n', '', '[\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u0637\\u0644\\u0627\\u0639\\u0627\\u062a \\u0634\\u0628\\u06a9\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u06cc\\u0646\\u062a\\u0631\\u0646\\u062a\",\"RECEIVE\",\"\\u0645\\u0645\\u0627\\u0646\\u0639\\u062a \\u0627\\u0632 \\u0628\\u0647 \\u062e\\u0648\\u0627\\u0628 \\u0631\\u0641\\u062a\\u0646 \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"RECEIVE_BOOT_COMPLETED\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0648\\u0636\\u0639\\u06cc\\u062a \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"PAY_THROUGH_BAZAAR\"]', null, 'accepted', '1', null, '59', '0', '0', '1', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('60', '3C Toolbox Pro 1.7.9', null, '28', 'enable', '0', 'kYSYP1470461904.png', '<p> این برنامه با دارا بودن مجموعه‌ای کامل از ابزارهای مختلف در واقع وظایف و عملکرد چند اپلیکیشن را در قالب یک اپلیکیشن گردآوری نموده و شما را در مدیریت هر چه بهتر گوشی یا تبلت خود یاری خواهد کرد؛ البته باید خاطرنشان کنیم که برای استفاده از تمام قابلیتهای این برنامه دستگاه اندرویدی شما باید روت شده باشد.</p>\n\n<p><strong>برخی از ویژگیهای برنامه 3C Toolbox Pro:</strong><br />\nوجود پروفایلهایی برای کنترل پردازنده<br />\nامکان تنظیم نحوه مصرف باتری<br />\nبخش Device Manager برای مدیریت کامل دستگاه اندرویدی<br />\nدارا بودن بخش مدیریت فایل <br />\nامکان مدیریت اپلیکیشنهای نصب شده<br />\nامکان بکاپ گیری از اپلیکیشنها و فایلهای apk<br />\nامکان Freeze/unfreeze کردن اپلیکیشنها<br />\nامکان مدیریت نوتیفیکیشن اپلیکیشنهای نصب شده<br />\nامکان مدیریت شبکه<br />\nامکان تنظیم فایروال اندروید<br />\nدارا بودن Task manager برای مدیریت اپلیکیشنهای در حال اجرا<br />\nمانیتورینگ پروسسها، باتری، وضعیت پردازنده، شبکه و حافظه<br />\nدارا بودن ویجتهای قابل شخصی سازی<br />\nو ...</p>\n', '', null, null, 'accepted', '1', '3c', '33', '0', '5', '0', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('61', ' تمرین عضلات شکم', null, '23', 'enable', '0', 'iFESP1470462396.png', '<p><strong>Abs workout PRO v8.12</strong>  برنامه ی شامل برنامه تمرین برای انجام در 42 روز – فقط 6 هفته، بدون میانبر – است که به عنوان Aerobic Weider Six شناخته می شود. تمرین عضله شکم روزانه شامل 6 تمرین برای انجام در هر روز است تا به 6 تکه شدن شکم برسید. شنا رفتن(push ups)، درازنشست(push ups)، بارفیکس و … را فراموش کنید. نیازی به رفتن به سالن ورزش نیست. شما می توانید این تمرین 6 تکه کردن شکم را در خانه انجام دهد.</p>\n\n<p> </p>\n\n<p><strong>ویژگی های نسخه PRO :</strong><br />\n– محاسبه لحظه ای تایمر تمرین<br />\n– گزینه ای برای تغییر ترتیب تمرین تمرینات<br />\n– تم تاریک برنامه<br />\n– بدون تبلیغات (مصرف کمتر RAM و باتری، اندازه کوچک تر برنامه)<br /><br /><br />\n </p>\n', '', null, null, 'accepted', '1', 'Caynax', '32', '0', '15', '0', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('62', 'App Lock & Photo Vault 2.3.1.002', null, '14', 'enable', '0', 'rD39X1470463226.png', '<p> با نصب این برنامه قادر خواهید بود از حریم خصوصی خود مثل پیام ها، ایمیل ها، لیست مخاطبین و فعالیتهای فیسبوکی خود بخوبی محافظت کنید، علاوه بر اینها امکان محافظت از عکسها و تصاویر خصوصی نیز وجود دارد که میتواند بسیار کاربردی و مفید باشد. <br /><br /><strong>ویژگیهای برنامه App Lock &amp; Photo Vault:</strong><br />\nامکان محافظت از برنامه ها و تصاویر شخصی<br />\nرابط کاربری زیبا و مدرن<br />\nدارا بودن تمهای مختلف<br />\nامکان ایجاد لاک اسکرین های جعلی<br />\nدارا بودن ویجت<br />\n </p>\n', '', null, null, 'accepted', '1', ' CY Security', '2', '0', '0', '0', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('65', 'Call Recorder Elite', null, '14', 'enable', '0', '0ceGz1471616432.png', '<p>یک نرم افزار ظبط مکالمات حرفه ای و کاربردی است که قصد دارند مکالمات و تماس های خود را به صورت دو طرفه ضبط کنند. این برنامه استفاده راحت و واسط حسی داشته و منوی پیچیده و گیج کننده ندارد. </p>\n\n<p><strong>برخی از ویژگی های برنامه Call Recorder Elite اندروید :</strong><br />\n فعال سازی یا غیرفعال سازی خودکار ضبط صدا<br />\n قابلیت ضبط به طور دستی ( با فشار دادن یک دکمه در حال صحبت)<br />\n قابلیت اضافه کردن یادداشت به موارد ضبط شده<br />\n فرستادن موارد ضبط شده توسط ایمیل<br />\n حذف موارد ضبط شده قبلی به صورت خودکار<br />\n عکس مخاطبین<br />\n گذاشتن رمز برای ورود به برنامه ها<br />\n جستجو برای تلفن های ضبط شده<br />\n پنهان کردن فایل های صوتی<br />\nانتخاب یکی از سه نوع برای فایل های خروجی<br />\n جداسازی تماس ها(لیست سیاه و سفید)<br />\n انتخاب محل ذخیره سازی ضبط شده ها<br />\n تغییر زمان<br />\n انتخاب منبع ضبط کننده ( میکروفون صدای تماس گیرنده صدای مخاطب...)<br />\n پخش کننده صدای مجتمع</p>\n', '', null, null, 'accepted', '1', 'palladium.dev.corp', '19', '0', '10', '0', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('66', 'Call Recorder Pro', null, '14', 'enable', '0', 'xvTE81471685013.png', '<p> می توانید همه مکالمات و تماس های خود را ضبط کرده و درنهایت تصمیم بگیرید که کدام را بر روی گوشی خود ذخیره کرده و نگه دارید. هم چنین این برنامه این امکان را داشته تا از پیش مشخص کنید که کدام تماس ها ضبط شود و کدام یک ضبط نشود. پس از ضبط تماس ها می توانید به آن ها گوش داده و نکات و یادداشت هایی را به آن ها اضافه نمایید. . مکالمات ذخیره شده در داخل قسمت صندوق ورودی برنامه قرار می گیرند، می توانید محل ذخیره سازی مکالمه ها را عوض کرده و مثلا بر روی sd کارت خود قرار دهید. از دیگر ویژگی های مفید برنامه قابلیت قرار دادن رمز عبور برای جلوگیری از دسترسی دیگران می باشد.</p>\n', '', null, null, 'accepted', '1', 'Clever Mobile', '20', '0', '7', '0', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('67', 'ترفند و راز رمز های تلگرام،واتس آپ ،وایبر و ...', '45', '13', 'enable', '2000', '8aGf51471688205.png', '<p style=\"text-align:right;\"><strong>این برنامه ترفند و آموزش کامل  و نکات مخفی  تلگرام،واتس آپ،وایبر،لاین،اینستاگرام،جیمیل،مایکروسافت،یاهو را  به صورت تصویری و  گام به گام آموزش داده است.</strong></p>\r\n\r\n<p style=\"text-align:right;\"><strong>همه در یک برنامه</strong></p>\r\n\r\n<p style=\"text-align:right;\">آموزش کامل و نکات مخفی تلگرام</p>\r\n\r\n<p style=\"text-align:right;\">آموزش کامل و نکات مخفی اینستاگرام</p>\r\n\r\n<p style=\"text-align:right;\">آموزش کامل و نکات مخفی واتس آپ</p>\r\n\r\n<p style=\"text-align:right;\">آموزش کامل و نکات مخفی وایبر</p>\r\n\r\n<p style=\"text-align:right;\">آموزش کامل و نکات مخفی لاین</p>\r\n\r\n<p style=\"text-align:right;\">آموزش کاملو نکات مخفی جیمیل</p>\r\n\r\n<p style=\"text-align:right;\">آموزش کامل و نکات مخفی و ساخت اکانت مایکروسافت برای ویندوز 10</p>\r\n\r\n<p style=\"text-align:right;\">آموزش کامل و نکات مخفی یاهو و مسنجر یاهو</p>\r\n', '', '[\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u0637\\u0644\\u0627\\u0639\\u0627\\u062a \\u0634\\u0628\\u06a9\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u06cc\\u0646\\u062a\\u0631\\u0646\\u062a\",\"\\u0645\\u062f\\u06cc\\u0631\\u06cc\\u062a \\u062d\\u0627\\u0641\\u0638\\u0647 \\u062e\\u0627\\u0631\\u062c\\u06cc\",\"\\u0645\\u0645\\u0627\\u0646\\u0639\\u062a \\u0627\\u0632 \\u0628\\u0647 \\u062e\\u0648\\u0627\\u0628 \\u0631\\u0641\\u062a\\u0646 \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"RECEIVE\",\"RECEIVE_BOOT_COMPLETED\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0648\\u0636\\u0639\\u06cc\\u062a \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\"]', null, 'accepted', '1', null, '19', '0', '0', '0', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('68', 'APUS Flashlight', null, '14', 'enable', '0', 'nv2zl1472701034.png', '<p>این برنامه از فلش دوربین گوشی شما به عنوان چراغ قوه نیز استفاده می کند . دو ابزار عالی Talking و SOS نیز در این برنامه گنجانده شده که با مورد اولی می توانید با حرف زدن چراغ قوه را فعال کنید و از مورد دوم برای درخواست کمک در شرایط بحرانی بهره ببرید! حالت SOS را انتخاب نموده و در مصرف باطری هنگام استفاده از چراغ قوه صرفه جویی نمایید . از این پس دیگر نیاز نیست نگران تاریکی باشید ، هروقت برق رفت کافی است این برنامه را فعال نموده و سپس محیط را روشن نمایید</p>\r\n', '', '[\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0648\\u0636\\u0639\\u06cc\\u062a \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0634\\u0628\\u06a9\\u0647 Wi-Fi\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u0637\\u0644\\u0627\\u0639\\u0627\\u062a \\u0634\\u0628\\u06a9\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u06cc\\u0646\\u062a\\u0631\\u0646\\u062a\",\"\\u0645\\u062f\\u06cc\\u0631\\u06cc\\u062a \\u062d\\u0627\\u0641\\u0638\\u0647 \\u062e\\u0627\\u0631\\u062c\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u062d\\u0627\\u0641\\u0638\\u0647 \\u0647\\u0627\\u06cc \\u062e\\u0627\\u0631\\u062c\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u062a\\u0645\\u0627\\u0633 \\u062a\\u0644\\u0641\\u0646\\u06cc\",\"RECEIVE_BOOT_COMPLETED\",\"\\u0645\\u0645\\u0627\\u0646\\u0639\\u062a \\u0627\\u0632 \\u0628\\u0647 \\u062e\\u0648\\u0627\\u0628 \\u0631\\u0641\\u062a\\u0646 \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"\\u0627\\u0631\\u0633\\u0627\\u0644 \\u067e\\u06cc\\u0627\\u0645\\u06a9\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 NFC\",\"ACCESS_SUPERUSER\",\"\\u062f\\u0631\\u06cc\\u0627\\u0641\\u062a \\u0644\\u06cc\\u0633\\u062a \\u062d\\u0633\\u0627\\u0628 \\u0647\\u0627\\u06cc \\u06a9\\u0627\\u0631\\u0628\\u0631\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0645\\u062e\\u0627\\u0637\\u0628\\u06cc\\u0646\"]', null, 'accepted', '1', 'APUS Group', '3', '0', '0', '0', null, null, null, null);
INSERT INTO `ym_apps` VALUES ('75', 'برنامه بدون اطلاعات', '46', '13', 'enable', '0', 'GQJyy1477039236.png', '<p>test</p>\r\n', '', '[\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u0637\\u0644\\u0627\\u0639\\u0627\\u062a \\u0634\\u0628\\u06a9\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0634\\u0628\\u06a9\\u0647 Wi-Fi\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u06cc\\u0646\\u062a\\u0631\\u0646\\u062a\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0648\\u0636\\u0639\\u06cc\\u062a \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"RECEIVE_BOOT_COMPLETED\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0648\\u06cc\\u0628\\u0631\\u0647\",\"\\u0645\\u0645\\u0627\\u0646\\u0639\\u062a \\u0627\\u0632 \\u0628\\u0647 \\u062e\\u0648\\u0627\\u0628 \\u0631\\u0641\\u062a\\u0646 \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"\\u0645\\u062f\\u06cc\\u0631\\u06cc\\u062a \\u062d\\u0627\\u0641\\u0638\\u0647 \\u062e\\u0627\\u0631\\u062c\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 NFC\",\"\\u062f\\u0631\\u06cc\\u0627\\u0641\\u062a \\u0644\\u06cc\\u0633\\u062a \\u062d\\u0633\\u0627\\u0628 \\u0647\\u0627\\u06cc \\u06a9\\u0627\\u0631\\u0628\\u0631\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u062a\\u0645\\u0627\\u0633 \\u062a\\u0644\\u0641\\u0646\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0645\\u06a9\\u0627\\u0646 \\u062a\\u0642\\u0631\\u06cc\\u0628\\u06cc\",\"PAY_THROUGH_BAZAAR\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u062a\\u0627\\u0631\\u06cc\\u062e\\u0686\\u0647 \\u0641\\u0627\\u06cc\\u0644 \\u0647\\u0627\",\"ACCESS_SUPERUSER\",\"\\u0646\\u0635\\u0628 \\u0645\\u06cc\\u0627\\u0646\\u0628\\u0631 \\u062f\\u0631 Launcher\",\"RECEIVE\",\"C2D_MESSAGE\",\"READ\",\"WRITE\",\"READ_SETTINGS\",\"UPDATE_SHORTCUT\",\"BROADCAST_BADGE\",\"UPDATE_COUNT\",\"UPDATE_BADGE\"]', null, 'pending', '1', null, '7', '0', '0', '0', '12345', 'm@m.com', 'fa web', 'en web');
INSERT INTO `ym_apps` VALUES ('76', null, '46', null, 'enable', null, null, '', '', null, null, 'incomplete', '1', null, '0', '0', '0', '0', null, null, null, null);

-- ----------------------------
-- Table structure for ym_app_advertises
-- ----------------------------
DROP TABLE IF EXISTS `ym_app_advertises`;
CREATE TABLE `ym_app_advertises` (
  `app_id` int(10) unsigned NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `create_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `cover` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تصویر',
  PRIMARY KEY (`app_id`),
  CONSTRAINT `ym_app_advertises_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `ym_apps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_app_advertises
-- ----------------------------
INSERT INTO `ym_app_advertises` VALUES ('55', '1', '1480363511', 'Y7Fkb1480363509.jpg');
INSERT INTO `ym_app_advertises` VALUES ('58', '1', '1480361464', 'TCnrl1480363365.jpg');
INSERT INTO `ym_app_advertises` VALUES ('61', '1', '1480357103', 'Xwnjh1480363376.jpg');
INSERT INTO `ym_app_advertises` VALUES ('66', '1', '1480335566', 'h9LXV1480363434.jpg');
INSERT INTO `ym_app_advertises` VALUES ('67', '1', '1480356526', 'BivV61480363403.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_app_buys
-- ----------------------------
INSERT INTO `ym_app_buys` VALUES ('1', '48', '48', '1466641625');
INSERT INTO `ym_app_buys` VALUES ('2', '48', '45', '1480408146');
INSERT INTO `ym_app_buys` VALUES ('10', '49', '46', '1480408146');
INSERT INTO `ym_app_buys` VALUES ('11', '48', '46', '1480408146');

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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_app_categories
-- ----------------------------
INSERT INTO `ym_app_categories` VALUES ('1', 'برنامه ها', null, null);
INSERT INTO `ym_app_categories` VALUES ('2', 'بازی ها', null, null);
INSERT INTO `ym_app_categories` VALUES ('3', 'آموزش ها', null, null);
INSERT INTO `ym_app_categories` VALUES ('4', 'آب و هوا', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('6', 'اخبار و مجلات', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('7', 'ارتباطات', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('11', 'تفننی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('12', 'مذهبی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('13', 'برنامه آموزشی', '3', '3-');
INSERT INTO `ym_app_categories` VALUES ('14', 'ابزار‌ها', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('15', 'اجتماعی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('16', 'اخبار و مجلات', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('17', 'پزشکی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('18', 'پس‌زمینهٔ زنده', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('19', 'حمل و نقل', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('20', 'خرید', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('21', 'سبک زندگی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('22', 'سرگرمی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('23', 'سلامت و تناسب اندام', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('24', 'سیر و سفر', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('25', 'شخصی‌سازی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('26', 'صوت و موسیقی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('27', 'عکاسی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('28', 'کاربردی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('29', 'کتابخانه و دمو', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('30', 'کتاب‌ها و مراجع', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('31', 'کسب و کار', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('32', 'کمیک', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('33', 'مالی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('34', 'ورزشی', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('35', 'ویجت‌ها', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('36', 'ویدیو و رسانه', '1', '1-');
INSERT INTO `ym_app_categories` VALUES ('37', 'بازی آموزشی', '3', '3-');
INSERT INTO `ym_app_categories` VALUES ('38', 'استراتژی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('39', 'تخته‌ای', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('40', 'خانوادگی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('41', 'دانستنی‌ها', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('42', 'رقابتی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('43', 'شبیه‌سازی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('44', 'کلمات', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('45', 'ماجراجویی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('46', 'مسابقه و سرعت', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('47', 'معمایی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('48', 'موسیقایی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('49', 'نقش‌آفرینی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('50', 'ورزشی', '2', '2-');
INSERT INTO `ym_app_categories` VALUES ('51', 'هیجان‌‌انگیز', '2', '2-');

-- ----------------------------
-- Table structure for ym_app_discounts
-- ----------------------------
DROP TABLE IF EXISTS `ym_app_discounts`;
CREATE TABLE `ym_app_discounts` (
  `app_id` int(11) unsigned NOT NULL,
  `start_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ شروع',
  `end_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ پایان',
  `percent` int(3) unsigned DEFAULT NULL COMMENT 'درصد',
  PRIMARY KEY (`app_id`),
  CONSTRAINT `ym_app_discounts_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `ym_apps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_app_discounts
-- ----------------------------
INSERT INTO `ym_app_discounts` VALUES ('48', '1480404602', '1480408200', '10');

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_app_images
-- ----------------------------
INSERT INTO `ym_app_images` VALUES ('18', '47', '9YRaL1466454597.jpg');
INSERT INTO `ym_app_images` VALUES ('19', '48', 'X8cK51466463141.jpg');
INSERT INTO `ym_app_images` VALUES ('20', '48', 'OIFxO1466463153.jpg');
INSERT INTO `ym_app_images` VALUES ('21', '49', '97InE1466465557.jpg');
INSERT INTO `ym_app_images` VALUES ('22', '49', 'eE1cO1466465581.jpg');
INSERT INTO `ym_app_images` VALUES ('23', '53', 'Tgywn1467037026.jpg');
INSERT INTO `ym_app_images` VALUES ('26', '57', 'VaJvN1467122483.jpg');
INSERT INTO `ym_app_images` VALUES ('27', '57', 'LTRnY1467122487.jpg');
INSERT INTO `ym_app_images` VALUES ('28', '57', 'VBLjT1467122494.jpg');
INSERT INTO `ym_app_images` VALUES ('29', '59', 'IorXj1467569717.jpg');
INSERT INTO `ym_app_images` VALUES ('30', '59', 'TMl9h1467569725.jpg');
INSERT INTO `ym_app_images` VALUES ('31', '58', 'ECaxk1467623437.jpg');
INSERT INTO `ym_app_images` VALUES ('32', '55', 'ub89s1467623456.jpg');
INSERT INTO `ym_app_images` VALUES ('33', '60', '65Vm01470462143.png');
INSERT INTO `ym_app_images` VALUES ('34', '60', 'dIKMV1470462151.png');
INSERT INTO `ym_app_images` VALUES ('35', '60', 'nY1nk1470462158.png');
INSERT INTO `ym_app_images` VALUES ('40', '61', 'aNkwZ1470462951.jpg');
INSERT INTO `ym_app_images` VALUES ('41', '61', 'qlUU91470462957.jpg');
INSERT INTO `ym_app_images` VALUES ('42', '61', 'tZsps1470462962.jpg');
INSERT INTO `ym_app_images` VALUES ('43', '61', 'Xdb9p1470462967.jpg');
INSERT INTO `ym_app_images` VALUES ('46', '65', 'YGnel1471684638.jpg');
INSERT INTO `ym_app_images` VALUES ('47', '65', 'R9s8A1471684645.jpg');
INSERT INTO `ym_app_images` VALUES ('48', '66', 'jvY741471685253.jpg');
INSERT INTO `ym_app_images` VALUES ('49', '66', 'BuuY11471685260.jpg');
INSERT INTO `ym_app_images` VALUES ('50', '67', 'jXj9X1471688386.jpg');
INSERT INTO `ym_app_images` VALUES ('51', '67', 'fFCIe1471688393.jpg');
INSERT INTO `ym_app_images` VALUES ('52', '67', 'yv2DV1471688434.jpg');
INSERT INTO `ym_app_images` VALUES ('53', '75', 'DlIcM1477039252.jpg');
INSERT INTO `ym_app_images` VALUES ('54', '75', '8vW0w1477039253.jpg');

-- ----------------------------
-- Table structure for ym_app_packages
-- ----------------------------
DROP TABLE IF EXISTS `ym_app_packages`;
CREATE TABLE `ym_app_packages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `app_id` int(10) unsigned DEFAULT NULL COMMENT 'برنامه',
  `version` varchar(20) DEFAULT NULL COMMENT 'نسخه',
  `package_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'نام بسته',
  `file_name` varchar(255) DEFAULT NULL COMMENT 'فایل',
  `create_date` varchar(20) DEFAULT NULL COMMENT 'تاریخ بارگذاری',
  `publish_date` varchar(20) DEFAULT NULL COMMENT 'تاریخ انتشار',
  `status` enum('pending','accepted','refused','change_required') DEFAULT 'pending' COMMENT 'وضعیت',
  `reason` text CHARACTER SET utf8 COLLATE utf8_persian_ci COMMENT 'دلیل',
  `for` enum('new_app','old_app') CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`app_id`),
  CONSTRAINT `ym_app_packages_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `ym_apps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_app_packages
-- ----------------------------
INSERT INTO `ym_app_packages` VALUES ('41', '47', '1.1', 'com.h.opera', '1.1-com.h.opera.xap', '1466455059', '1466455059', 'accepted', null, null);
INSERT INTO `ym_app_packages` VALUES ('42', '47', '2.1', 'com.hyperapps.opera', '2.1-com.hyperapps.opera.xap', '1466456160', '1466456160', 'accepted', null, null);
INSERT INTO `ym_app_packages` VALUES ('43', '48', 'v2.2', 'ir.hyperads.doahayeramezan', 'v2.2-ir.hyperads.doahayeramezan.apk', '1466462389', '1471688555', 'accepted', null, 'new_app');
INSERT INTO `ym_app_packages` VALUES ('44', '49', 'v1.0', 'ir.hyperads.doayeroozane', 'v1.0-ir.hyperads.doayeroozane.apk', '1466464915', '1466466022', 'accepted', null, 'new_app');
INSERT INTO `ym_app_packages` VALUES ('45', '47', '1.0.12', 'teset.pack.ca', '1.0.12-teset.pack.ca.xap', '1466493405', '1466493405', 'accepted', null, null);
INSERT INTO `ym_app_packages` VALUES ('46', '53', '1.0', 'ir.h.opera', '1.0-ir.h.opera.xap', '1467036867', '1467037057', 'accepted', null, 'new_app');
INSERT INTO `ym_app_packages` VALUES ('49', '55', '2.1', 'com.o.opera', '2.1-com.o.opera.xap', '1467046450', '1467046450', 'accepted', null, null);
INSERT INTO `ym_app_packages` VALUES ('51', '57', '1', 'test', '1-test.xap', '1467125011', '1467125011', 'accepted', null, null);
INSERT INTO `ym_app_packages` VALUES ('52', '58', '1.0', 'com. Photo. PhotoGrid', '1.0-com. Photo. PhotoGrid.xap', '1467126184', '1467126184', 'accepted', null, null);
INSERT INTO `ym_app_packages` VALUES ('53', '59', 'v1.0', 'ir.hyperads.eed', 'v1.0-ir.hyperads.eed.apk', '1467569469', '1467569759', 'accepted', null, 'new_app');
INSERT INTO `ym_app_packages` VALUES ('54', '61', '8.12 PRO', 'com.caynax.a6w.pro', '8.12 PRO-com.caynax.a6w.pro.apk', '1470462725', '1470462725', 'accepted', null, null);
INSERT INTO `ym_app_packages` VALUES ('57', '65', '1.57', 'com.habra.example.call_recorder', '1.57-com.habra.example.call_recorder.apk', '1471684726', '1471684726', 'accepted', null, null);
INSERT INTO `ym_app_packages` VALUES ('58', '66', '4.9', 'polis.app.callrecorder.pro', '4.9-polis.app.callrecorder.pro.apk', '1471685147', '1471685147', 'accepted', null, null);
INSERT INTO `ym_app_packages` VALUES ('60', '67', '2', 'ir.hyperads.shabake', '2-ir.hyperads.shabake.apk', '1471686698', '1471688672', 'accepted', null, 'new_app');
INSERT INTO `ym_app_packages` VALUES ('63', '75', '2.1.4', 'ir.tgbs.android.iranapp2', '2.1.4-ir.tgbs.android.iranapp.apk', '1476970234', '1477039466', 'accepted', null, 'new_app');
INSERT INTO `ym_app_packages` VALUES ('64', '75', '7.1.3', 'com.farsitel.bazaar', '7.1.3-com.farsitel.bazaar.apk', '1477041711', '1477043018', 'accepted', null, 'old_app');
INSERT INTO `ym_app_packages` VALUES ('65', '48', '2.1.4', 'ir.tgbs.android.iranapp2', '2.1.4-ir.tgbs.android.iranapp.apk', '1478082719', '1480150519', 'accepted', null, 'old_app');
INSERT INTO `ym_app_packages` VALUES ('66', '49', '2.1.4', 'ir.tgbs.android.iranapp', '2.1.4-ir.tgbs.android.iranapp.apk', '1480144992', null, 'pending', null, 'old_app');

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
INSERT INTO `ym_app_platforms` VALUES ('3', 'windowsphone', 'ویندوزفون', 'xap,appx');

-- ----------------------------
-- Table structure for ym_app_ratings
-- ----------------------------
DROP TABLE IF EXISTS `ym_app_ratings`;
CREATE TABLE `ym_app_ratings` (
  `user_id` int(11) unsigned NOT NULL,
  `app_id` int(11) unsigned NOT NULL,
  `rate` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`,`app_id`),
  KEY `app_id` (`app_id`),
  CONSTRAINT `ym_app_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_app_ratings_ibfk_2` FOREIGN KEY (`app_id`) REFERENCES `ym_apps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_app_ratings
-- ----------------------------
INSERT INTO `ym_app_ratings` VALUES ('44', '47', '4');
INSERT INTO `ym_app_ratings` VALUES ('44', '49', '5');
INSERT INTO `ym_app_ratings` VALUES ('44', '65', '5');
INSERT INTO `ym_app_ratings` VALUES ('44', '66', '5');
INSERT INTO `ym_app_ratings` VALUES ('44', '67', '5');
INSERT INTO `ym_app_ratings` VALUES ('46', '47', '1');
INSERT INTO `ym_app_ratings` VALUES ('46', '49', '2');
INSERT INTO `ym_app_ratings` VALUES ('47', '47', '3');
INSERT INTO `ym_app_ratings` VALUES ('47', '49', '4');

-- ----------------------------
-- Table structure for ym_app_special_advertises
-- ----------------------------
DROP TABLE IF EXISTS `ym_app_special_advertises`;
CREATE TABLE `ym_app_special_advertises` (
  `app_id` int(10) unsigned NOT NULL COMMENT 'برنامه',
  `cover` varchar(200) COLLATE utf8_persian_ci NOT NULL COMMENT 'تصویر کاور',
  `fade_color` varchar(7) COLLATE utf8_persian_ci DEFAULT '000' COMMENT 'رنگ زمینه',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT 'وضعیت',
  `create_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`app_id`),
  CONSTRAINT `ym_app_special_advertises_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `ym_apps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_app_special_advertises
-- ----------------------------
INSERT INTO `ym_app_special_advertises` VALUES ('48', 'GRxQW1480343849.png', '#ff0000', '1', '1480343925');
INSERT INTO `ym_app_special_advertises` VALUES ('55', 'aTIID1480348176.png', '#25af64', '1', '1480348183');

-- ----------------------------
-- Table structure for ym_comments
-- ----------------------------
DROP TABLE IF EXISTS `ym_comments`;
CREATE TABLE `ym_comments` (
  `owner_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `owner_id` int(12) NOT NULL,
  `comment_id` int(12) NOT NULL AUTO_INCREMENT,
  `parent_comment_id` int(12) DEFAULT NULL,
  `creator_id` int(12) DEFAULT NULL,
  `user_name` varchar(128) COLLATE utf8_persian_ci DEFAULT NULL,
  `user_email` varchar(128) COLLATE utf8_persian_ci DEFAULT NULL,
  `comment_text` text COLLATE utf8_persian_ci,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `is_private` tinyint(4) DEFAULT '0' COMMENT 'خصوصی',
  PRIMARY KEY (`comment_id`),
  KEY `owner_name` (`owner_name`,`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_comments
-- ----------------------------
INSERT INTO `ym_comments` VALUES ('Apps', '60', '74', null, '44', null, null, 'سلام', '1471171859', null, '0', '0');
INSERT INTO `ym_comments` VALUES ('Apps', '60', '75', null, '44', null, null, 'عالی', '1471245819', null, '0', '0');
INSERT INTO `ym_comments` VALUES ('Apps', '67', '76', null, '44', 'Admin', null, 'تست', '1471762043', '1472538715', '2', '0');
INSERT INTO `ym_comments` VALUES ('Apps', '65', '77', null, '44', 'Admin', null, 'خیلی نرم افزار خوبیه\r\n', '1472069470', '1472542802', '2', '0');
INSERT INTO `ym_comments` VALUES ('Apps', '48', '78', null, '44', null, null, 'سلام', '1473069470', null, '0', '0');
INSERT INTO `ym_comments` VALUES ('Apps', '48', '79', '78', '46', null, null, 'علیک سلام', '1480504842', null, '0', '1');

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
INSERT INTO `ym_counter_save` VALUES ('counter', '1356');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2457723');
INSERT INTO `ym_counter_save` VALUES ('max_count', '27');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1470123000');
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
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1480510799');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_pages
-- ----------------------------
INSERT INTO `ym_pages` VALUES ('1', 'درباره ما', '<p dir=\"RTL\">ویژگی اصلی گوشی&zwnj;های هوشمند ایجاد امکان استفاده از برنامه&zwnj;های کاربردی است و گوشی هوشمند بدون استفاده از این برنامه&zwnj;ها تفاوت چندانی با گوشی معمولی ندارد. هایپر اپس،&nbsp;محلی برای دانلود برنامه&zwnj;های اندرویدی و ویندوزفونی و ios است که به&zwnj;طور ویژه به کاربران فارسی&zwnj;زبان سرویس&zwnj;دهی می&zwnj;کند و ده&zwnj;ها هزار برنامه که توسط هزاران توسعه&zwnj;دهنده تهیه شده&zwnj;اند، از طریق آن قابل دسترسی هستند.</p>\r\n\r\n<p dir=\"RTL\">هایپر اپس فرصت مناسبی&zwnj; است برای توسعه&zwnj;دهندگان تا به بازار رو به رشد تلفن&zwnj;های هوشمند قدم بگذارند و کسب درآمد کنند. هم&zwnj;اکنون توسعه&zwnj;دهندگان &nbsp;می&zwnj;توانند با استفاده از پنل مخصوص توسعه&zwnj;دهندگان هایپر اپس، به&zwnj;آسانی برنامه&zwnj;های خود را منتشر، به&zwnj;روزرسانی و مدیریت کنند.</p>\r\n', '1');
INSERT INTO `ym_pages` VALUES ('2', 'تماس با ما', '<p>تهران - تهران - تهران-تقاطع یادگار امام و دامپزشکی-کوچه آبگینه-بن بست انبار-پلاک 4-واحد 6 - کدپستی: 1349793141</p>\r\n\r\n<p>تلفن : 02165572767</p>\r\n\r\n<p>ایمیل:&nbsp;hyperapps.ir@gmail.com</p>\r\n', '1');
INSERT INTO `ym_pages` VALUES ('3', 'راهنما', '<h3 dir=\"RTL\"><strong>روش ساخت حساب کاربری</strong></h3>\r\n\r\n<p dir=\"RTL\">برای دریافت برنامه&zwnj;های فروشی، اعلام نظر و ارائه امتیاز به برنامه&zwnj;ها، استفاده از کارت هدیه و سایر امتیازات ویژه، ایجاد حساب کاربری ضروری است. ثبت&zwnj;نام و ایجاد حساب کاربری در هایپر اپس&nbsp;ساده است:</p>\r\n\r\n<p>۱- پس از باز کردن سایت هایپر اپس&nbsp;در قسمت سمت چپ&nbsp;بالای صفحه، ثبت نام را انتخاب کنید.<br />\r\n۲- صفحه&zwnj;ای با پیام &laquo;ایمیل و رمز ورود&raquo; به شما نشان داده می&zwnj;شود. آدرس ایمیل خود را در قسمت مربوط وارد و گزینهٔ ثبت نام را انتخاب کنید.<br />\r\n۳- کد تایید به ایمیل وارد شده ارسال خواهد شد.<br />\r\n۴- به ایمیل خود مراجعه کرده و بر روی آن کلیک کنید تا حساب کاربری شما فعال شود.</p>\r\n\r\n<p dir=\"RTL\">بخشی از برنامه&zwnj;های هایپر اپس رایگان نیستند و بخشی نیز به پرداخت درون&zwnj;برنامه&zwnj;ای نیاز دارند. آسان&zwnj;ترین روش خرید یا پرداخت، افزایش اعتبار هایپر اپس و استفاده از این اعتبار است. با کلیک روی گزینه حساب کاربری در قسمت بالای سمت راست صفحه وارد حساب کاربری خود شوید. اعتبار فعلی شما در این صفحه نمایش داده می&zwnj;شود. در همین صفحه می&zwnj;توانید با دو شیوه اعتبار خود را افزایش دهید:&nbsp;<br />\r\n* &nbsp;گزینه افزایش اعتبارهایپر اپس را انتخاب کنید و با تعیین مبلغ افزایش اعتبار، در صفحات بعدی از طریق کارت حساب بانکی خود خرید اینترنتی کنید. برای خرید اینترنتی جهت استفاده از کارت شتاب لازم است موارد زیر را وارد کنید:</p>\r\n\r\n<ul>\r\n	<li dir=\"RTL\">شماره کارت ( شماره ۱۶ تا ۱۹ رقمی روی کارت بانکی)</li>\r\n	<li dir=\"RTL\">رمز دوم PIN2 پنج رقمی&nbsp;کارت</li>\r\n	<li dir=\"RTL\">کد اعتبار سنجی دوم (CVV2)</li>\r\n	<li dir=\"RTL\">تاریخ انقضای کارت</li>\r\n</ul>\r\n\r\n<h3 dir=\"RTL\"><strong>دسترسی به برنامه&zwnj;ها</strong></h3>\r\n\r\n<p dir=\"RTL\">دسترسی به برنامه&zwnj;ها درهایپر اپس از سه طریق ممکن است:<br />\r\n<strong>یک: استفاده از دسته&zwnj;ها</strong></p>\r\n\r\n<p dir=\"RTL\">با انتخاب گزینه دسته&zwnj;&zwnj;ها از نواربالای صفحه، ۲۷ دسته برنامه از قبیل اجتماعی، خرید، آموزش، سلامت، مذهبی و غیره و ۱۶ دسته بازی از قبیل معمایی، ماجراجویی، شبیه&zwnj;سازی، ورزشی و غیره مشاهده می&zwnj;کنید. پس از انتخاب دسته موردنظر ترکیب متنوعی از برنامه&zwnj;های آن دسته نمایش داده می&zwnj;شود.</p>\r\n\r\n<p dir=\"RTL\"><strong>دو: استفاده از لیست&zwnj;های معرفی برنامه&nbsp;</strong>&zwnj;</p>\r\n\r\n<p dir=\"RTL\">هایپر اپس لیست&zwnj;های متعددی از برترین و تازه&zwnj;ترین برنامه&zwnj;ها را در صفحه اول در اختیار شما قرار می&zwnj;دهد و شما می&zwnj;توانید با انتخاب در قسمت هر معیار فهرستی از برنامه&zwnj;ها را مشاهده کنید.&nbsp;در کنار این لیست&zwnj;ها، مجموعه&zwnj;هایی از برنامه&zwnj;ها و بازی&zwnj;ها که موضوع یکسانی دارند در صفحه اول نشان داده می&zwnj;شوند.<br />\r\n<strong>سه: جستجو</strong></p>\r\n\r\n<p dir=\"RTL\">برای جستجوی نام برنامه موردنظر آیکون جستجو را از نوار بالای صفحه هایپر اپس انتخاب و کلیدواژه خود را وارد کنید.</p>\r\n\r\n<h3 dir=\"RTL\"><strong>اطلاعات برنامه</strong></h3>\r\n\r\n<p dir=\"RTL\">پس از کلیک کردن روی نام هر برنامه صفحه&zwnj;ای باز می&zwnj;شود که حاوی جزئیات آن، نظرات سایر کاربران و برنامه&zwnj;های مرتبط است. شما می&zwnj;توانید با استفاده از این اطلاعات در مورد دریافت برنامه تصمیم بگیرید. در قسمت بالای برگه جزئیات می&zwnj;توانید برنامه را به اشتراک بگذارید یا نشان کنید تا به لیست نشان&zwnj;های حساب کاربری شما اضافه شود. برای دسترسی به لیست نشان&zwnj;ها از نوار بالای&nbsp;سایت هایپر اپس روی آن کلیک و نشان&zwnj;شده&zwnj;ها را انتخاب کنید.</p>\r\n\r\n<h3 dir=\"RTL\"><strong>نصب برنامه رایگان</strong></h3>\r\n\r\n<p dir=\"RTL\">برای نصب یک برنامه رایگان دو راه وجود دارد:</p>\r\n\r\n<p dir=\"RTL\"><strong>یک. سایت هایپر اپس حالت ریسپانسیو(در گوشی)</strong></p>\r\n\r\n<p dir=\"RTL\">روی برنامه موردنظر کلیک کنید. گزینه نصب را انتخاب کنید. دریافت برنامه آغاز می&zwnj;شود و پس از دریافت، می&zwnj;توانید آن را نصب کنید.</p>\r\n\r\n<p dir=\"RTL\"><strong>دو. سایت هایپر اپس</strong></p>\r\n\r\n<p dir=\"RTL\">وب&zwnj;&zwnj;سایت هایپر اپس برای مرور راحت&zwnj;تر فهرست برنامه&zwnj;ها و بررسی توضیحات آنها راه&zwnj;اندازی شده است. در صورتی که مایلید ابتدا برنامه مورد نیاز خود را از طریق وب&zwnj;سایت هایپر اپس جستجو کنید و سپس آن را بر دستگاه اندرویدی خود نصب کنید، مطابق این مراحل اقدام کنید.</p>\r\n\r\n<p>۱- به وب سایت&nbsp;هایپر اپس&nbsp;بروید و صفحه برنامه مورد نظر را باز کنید.<br />\r\n۲- روی گزینه رایگان کلیک کنید. &nbsp;QR Code برنامه موردنظر شما نمایش داده می&zwnj;شود.<br />\r\n۳- برای نصب برنامه در دستگاه اندرویدی خود لازم است قبلا یکی از برنامه&zwnj;های رایج QR code reader را نصب کرده باشید &nbsp;برنامه لازم را باز کنید و دوربین دستگاه اندرویدی خود را مقابل QR code نمایش داده شده در سایت هایپر اپس قرار دهید. روی لینک ایجاد شده توسط برنامه کلیک کنید.<br />\r\n۴- حال می&zwnj;توانید به راحتی برنامه مورد نظرتان را از طریق دستگاه اندرویدی نصب کنید.</p>\r\n\r\n<p dir=\"RTL\">پس از خرید به هر روش، برنامه مورد نظر شما دریافت می&zwnj;شود و می&zwnj;توانید آن را نصب کنید.</p>\r\n\r\n<h3 dir=\"RTL\"><strong>نصب برنامه&nbsp;</strong><strong>فروشی</strong></h3>\r\n\r\n<p dir=\"RTL\">برای خرید و نصب یک برنامه فروشی این اقدامات را انجام دهید:</p>\r\n\r\n<p dir=\"RTL\"><strong>&nbsp;سایت هایپر اپس</strong></p>\r\n\r\n<p dir=\"RTL\">صفحه آن را باز و روی گزینه قیمت آن کلیک کنید. در صورتی که اعتبار حساب کاربری شما برای خرید آن کافی باشد، هایپر اپس از شما می&zwnj;خواهد که خرید با کسر اعتبار حساب را تایید کنید. در غیراینصورت ابتدا باید یکی از دو روش پرداخت را انتخاب کنید:<br />\r\nروش اول، افزایش اعتبار و خرید</p>\r\n\r\n<p dir=\"RTL\">اگر مایلید ابتدا اعتبار حساب خود را افزایش دهید و آنگاه برنامه موردنظر را خریداری کنید، این گزینه را انتخاب و مبلغ موردنظر خود را در صفحه بعد معین کنید. در نهایت گزینه خرید را انتخاب کنید و با انتخاب یکی از درگاه&zwnj;های پرداخت نسبت به افزایش اعتبار اقدام کنید. مزیت این روش این است که با یک بار افزایش اعتبار لازم نیست در هر بار خرید مشخصات کارت بانکی خود را وارد کنید.</p>\r\n\r\n<p dir=\"RTL\">روش دوم، پرداخت اینترنتی در برنامه</p>\r\n\r\n<p dir=\"RTL\">اگر مایلید برنامه را به&zwnj;طور مستقیم از طریق کارت حساب بانکی خود خریداری کنید، پس از انتخاب گزینه پرداخت اینترنتی عملیات بانکی مربوطه را انجام دهید. هایپر اپس هیچ وقت بدون امکان نصب برنامه از شما وجهی کسر نمی&lrm;کند و امکان دو بار خریدن یک برنامه را ندارد. اگر درگاه بانکی به مشکل خورد و به هر صورت موفق به نصب برنامه نشدید یا بانک دو بار وجهی را از حساب شما کسر کرد، حداکثر تا سه روز کاری صبر کنید تا وجه توسط بانک به حساب شما برگردانده شود.</p>\r\n\r\n<p dir=\"RTL\">برخی از برنامه&zwnj;های رایگان هایپر اپس در ازای خرید درون&zwnj;برنامه&zwnj;ای خدمات ویژه خود را ارائه می&zwnj;دهند. برای خرید درون&zwnj;برنامه&zwnj;ای، از درون برنامه یا بازی به صفحه پرداخت بازار هدایت می&zwnj;شوید و پس از انجام عملیات خرید، دوباره به محیط برنامه یا بازی بازمی&zwnj;گردید. برای نمایش لیست خریده&zwnj;شده&zwnj;ها وارد حساب کاربری خود شوید. و روی خریده&zwnj;شده&zwnj;ها کلیک کنید. در این صفحه می&zwnj;توانید برنامه&zwnj;هایی را که خریداری کرده&zwnj;اید، مشاهده کنید.</p>\r\n\r\n<h3 dir=\"RTL\"><strong>ارزیابی برنامه</strong></h3>\r\n\r\n<p dir=\"RTL\">در صورتی که برنامه را نصب کرده&zwnj;باشید، می&zwnj;توانید در صفحه آن وارد برگه نظرها شوید. &nbsp;و نظر خود در مورد آن را بنویسید.</p>\r\n\r\n<h3 dir=\"RTL\"><strong>پشتیبانی</strong></h3>\r\n\r\n<p dir=\"RTL\">در صورتی که در پرداخت و یا سایر فعالیت&zwnj;های عمومی هایپر اپس با مشکلی مواجه شدید، با انتخاب منوی&nbsp;هایپر اپس و گزینه پشتیبانی می&zwnj;توانید برای حل مشکل خود اقدام کنید و یا مشکل خود را مستقیماً به ما ایمیل&nbsp;بفرستید.&nbsp;<br />\r\nهمچنین در صورتی که در مورد برنامه خاصی نیاز به پشتیبانی دارید، صفحه برنامه را باز کنید و از قسمت انتهایی آن اطلاعات تماس توسعه&zwnj;دهنده آن را بیابید و از این طریق مشکل ایجادشده را به وی اطلاع دهید. در همین قسمت می&zwnj;توانید با انتخاب گزینه شکایت از برنامه و تعیین یکی از دلایل، توضیحات خود را در شکایت از برنامه&zwnj;ها برای هایپر اپس ارسال کنید.</p>\r\n', '1');
INSERT INTO `ym_pages` VALUES ('4', 'شرایط استفاده از خدمات', '<p><strong>شرایط استفاده از هایپر اپس</strong></p>\r\n\r\n<p>هایپر اپس هیچ گونه مسئولیتی در قبال مشکلات احتمالی تلفن همراه شما یا حذف شدن اطلاعات تلفن همراه شما پس از استفاده از هایپر اپس و برنامه های موجود در آن ندارد و مسئولیت آن با خود کاربر است.</p>\r\n\r\n<p><strong>حساب کاربری:</strong></p>\r\n\r\n<p>شما برای استفاده از بعضی از خدمات و امکانات هایپر اپس مانند: خرید برنامه و خرید درون برنامه ای و نشانه گذاری و... نیاز به حساب کاربری دارید.&nbsp;</p>\r\n\r\n<p>حساب کاربری شما امنیت بالایی دارد ،برای حفظ امنیت بیشتر حساب کاربری خود از گذرواژه های طولانی استفاده کنید.&nbsp;</p>\r\n\r\n<p><strong>نظرات:&nbsp;</strong></p>\r\n\r\n<p>شما می توانید به برنامه های مختلف نظر دهید نظرات شما باید متناسب با قوانین جمهوری اسلامی ایران باشد و چنانچه در نظرات تبلیغ،الفاظ رکیک،لینک سایت،نقض قوانین جمهوری اسلامی، غیر مرتبط به برنامه و نوشتن اطلاعات شخصی مثل شماره تلفن دیده شود آن نظر حذف خواهد شد و در صورت تکرار شدن نظرات غیر مجاز توسط &nbsp;یک حساب کاربری، آن حساب معلق خواهد شد.&nbsp;</p>\r\n', '1');
INSERT INTO `ym_pages` VALUES ('5', 'حریم شخصی', '<p>حریم شخصی کاربران برای ما بسیار اهمیت دارد.&nbsp;</p>\r\n\r\n<p>اطلاعات شخصی که شما به هنگام ثبت نام به ما میدهید ایمیل خودتان است ، ایمیل شما به صورت محرمانه پیش ما می ماند و از آن فقط جهت خبرنامه هایپر اپس&nbsp;استفاده می شود.</p>\r\n\r\n<p>ما حق داریم اطلاعات اختصاصی دستگاه شما مانند نسخه سیستم عامل، مدل و برند دستگاه &nbsp;شما را جمع آوری کنیم.&nbsp;</p>\r\n\r\n<p>این اطلاعات تنها جهت آمارگیری استفاده میشود وقتی شما یک حساب کاربری در هایپر اپس دارید این اطلاعات برای ما ارسال میشود و ما به کمک این اطلاعات می توانیم خدمات بهتر و بهینه ای در اختیار شما قرار دهیم.</p>\r\n', '1');
INSERT INTO `ym_pages` VALUES ('6', 'متن راهنمای تسویه حساب', '<ul>\r\n	<li>در صورتی که می&zwnj;خواهید هر ماه تصفیه&zwnj;حساب شما به یک شبای ثابت انجام شود، کافی است گزینه تصفیه&zwnj;حساب خودکار را انتخاب و شبای خود را وارد نمائید.</li>\r\n	<li>شبای اعلامی تا پایان روز ۲۰ اُم هر ماه قابل تغییر است و پرداخت&zwnj;های هر ماه به آخرین شبای وارد شده در سیستم تا پایان این روز واریز می&zwnj;شود.</li>\r\n	<li>پرداخت بر اساس مبلغ قابل تصفیه شما در پایان روز ۲۰ اُم و به فاصله حداکثر&nbsp;<strong>۵ روز کاری</strong>&nbsp;صورت می&zwnj;گیرد.</li>\r\n	<li>حداقل میزان قابل پرداخت به ناشر 300,000 ریال است</li>\r\n	<li>عواید حاصل از فروش، پس از کسر کسورات قانونی به نسبت 85 درصد سهم ناشر و 15 درصد سهم هایپر اپس&nbsp;تقسیم می&zwnj;شود.&nbsp;</li>\r\n</ul>\r\n', '1');
INSERT INTO `ym_pages` VALUES ('7', 'قرارداد توسعه دهندگان', '<p>قرارداد حاضر براساس مادهٔ ۱۰ قانون مدنی، و با تابعیت از کلیهٔ قوانین و مقررات جمهوری اسلامی ایران، به شماره و تاریخ فوق، میان طرفین مندرج در مادهٔ ۱ منعقد می&zwnj;شود و مفاد آن از تاریخ امضاء برای طرفین لازم&zwnj;الاجرا خواهد بود:</p>\r\n\r\n<p>مادهٔ ۱- طرفین قرارداد:</p>\r\n\r\n<p>۱-۱- مارکت هایپر اپس&nbsp;</p>\r\n\r\n<p>۱-۲- آقا/خانم/شرکت ..................................... که از این پس &laquo;توسعه&zwnj;دهنده&raquo; نامیده می&zwnj;شود.</p>\r\n\r\n<p>ماده ۲- تعاریف:</p>\r\n\r\n<p>۱-۲- هایپر اپس&nbsp;: بستر کاربر محور ارائه&zwnj;دهندهٔ خدمات میزبانی، جهت عرضهٔ برنامه&zwnj;ها و یا محتواهای ابزارهای هوشمند است. نشانی اینترنتی سایت</p>\r\n\r\n<p>هایپر اپس&nbsp;، hyperapps.ir است.</p>\r\n\r\n<p>۲-۲- توسعه&zwnj;دهنده: شخص حقیقی یا حقوقی است که برنامهٔ اندرویدی , ویندوزفونی و ios&nbsp;خود را در هایپر اپس&nbsp; عرضه می&zwnj;کند.</p>\r\n\r\n<p>۳-۲- برنامه: منظور نرم&lrm;افزارهای ساخته شده بر بستر اندروید،ویندوزفون&nbsp;و ios بازی&zwnj;ها و سایر محصولات دیجیتالی است که توسعه&zwnj;دهنده برای توزیع و فروش از طریق هایپر اپس&nbsp;ارائه می&zwnj;نماید.</p>\r\n\r\n<p>۴-۲- محتوا: منظور تمام و انواع متعلقات برنامه به هر جنس، شکل و نوعی شامل پایگاه داده&zwnj;، متن و عکس، صدا و فیلم، ظاهر، خدمات، تبلیغات، سایر متعلقات دیجیتالی داخل برنامه، توضیحات قابل دسترسی از طریق برنامه، اطلاعات محصول و دیگر موارد ممکن است.</p>\r\n\r\n<p>۵-۲- پنل توسعه&zwnj;دهنده: فضایی که هایپر اپس به صورت برخط جهت بارگذاری برنامه/محتوا، مدارک شناسایی و سایر متعلقات در اختیار توسعه&zwnj;دهنده قرار می&zwnj;&zwnj;دهد و برخی اطلاعات مربوط به توسعه&zwnj;دهنده در آن نمایش داده می&zwnj;شود و راه ارتباط اصلی و رسمی هایپر اپس و توسعه&zwnj;دهنده است.</p>\r\n\r\n<p>۶-۲- حساب کاربری توسعه&zwnj;دهنده: حسابی است که با اختصاص نام و رمز عبور به توسعه&zwnj;دهنده تعلق گرفته است و توسعه&zwnj;دهنده توسط آن به پنل دسترسی خواهد داشت.</p>\r\n\r\n<p>۷-۲- کاربر: فردی است که از طریق هایپر اپس اقدام به نصب برنامه می&zwnj;کند.</p>\r\n\r\n<p>ماده ۳- موضوع قرارداد:<br />\r\nموضوع قرارداد حاضر، عرضهٔ برنامه یا محتوا توسط توسعه&zwnj;دهنده در هایپر اپس است. بدین منظور هایپر اپس به عنوان ارائه دهندهٔ خدمات میزبانی، فضایی را در اختیار توسعه دهندگان می&zwnj;گذارد تا مطابق با مقررات به نشر و عرضه نرم افزارهای خود در این فضا بپردازند.</p>\r\n\r\n<p>ماده ۴- مدت قرارداد:</p>\r\n\r\n<p>قرارداد حاضر، به مدت یک سال از تاریخ امضای طرفین لازم&zwnj;الاجرا خواهد بود و در صورت عدم فسخ، به طور خودکار و به صورت سالانه تمدید خواهد شد.</p>\r\n\r\n<p>ماده ۵- مبلغ قرارداد:</p>\r\n\r\n<p>برای ثبت نام به عنوان توسعه دهنده کافیست تا به میزان 5000 ریال اعتبار در حساب هایپر اپس کاربر موجودی وجود داشته باشد.</p>\r\n\r\n<p>۵ -۱- چنانچه هایپر اپس بنا بر شرایط تشخیص دهد که باید میزان یا نحوهٔ دریافت مبلغ قرارداد را تغییر دهد، تغییر میزان و نحوهٔ دریافت مبلغ قرارداد از طریق پنل و ایمیل به اطلاع توسعه&zwnj;دهنده خواهد رسید. توسعه&zwnj;دهنده موظف به پرداخت هزینهٔ اعلام شده است و با پرداخت آن به طور ضمنی این شرایط جدید را می&zwnj;پذیرد و در صورت عدم پرداخت آن در مهلت مقرر، هایپر اپس می&zwnj;تواند دسترسی وی به پنل توسعه&zwnj;دهندگان را به حالت تعلیق در بیاورد.</p>\r\n\r\n<p>ماده ۶- حقوق و تعهدات توسعه&zwnj;دهنده:</p>\r\n\r\n<p>۱-۶- به موجب قرارداد حاضر، کلیه حقوق معنوی مربوط به محتوا متعلق به توسعه&zwnj;دهنده خواهد بود.</p>\r\n\r\n<p>۲-۶- به موجب قرارداد حاضر، توسعه&zwnj;دهنده مسئول تطابق محتوای برنامه با کلیهٔ قوانین و مقررات جمهوری اسلامی ایران و کسب مجوزهای مربوطه شناخته می&zwnj;شود.</p>\r\n\r\n<p>۳-۶- به موجب این قرارداد، توسعه&zwnj;دهنده متعهد می&zwnj;شود که سند &laquo;راهنمای انتشار برنامه&zwnj;ها&raquo; را که در بخش مستندات سایت قرار دارد و به عنوان پیوست این قرارداد محسوب و بخش لاینفکی از آن تلقی می&zwnj;شود، به دقت مطالعه و به آن عمل نموده و تعهدات و شرایط آن را می&zwnj;پذیرد.</p>\r\n\r\n<p>۴-۶- به موجب قرارداد حاضر، توسعه&zwnj;دهنده تضمین می&zwnj;کند که از اهلیت قانونی لازم برای انعقاد معاملات برخوردار است و چنانچه به نمایندگی از یک شخص حقوقی به عنوان توسعه&zwnj;دهنده این قرارداد را منعقد می&zwnj;نماید، دارای اختیار قانونی لازم برای این کار است و مدارک نمایندگی خود را به هایپر اپس ارائه می&zwnj;دهد.</p>\r\n\r\n<p>۵-۶- توسعه&zwnj;دهنده مسئول است پیش از ارائهٔ هرگونه محتوا به هایپر اپس، اختیارات قانونی لازم به منظور اعمال حقوق ناشی از این قرارداد را کسب نموده، و فارغ از هرگونه ادعا از سوی اشخاص ثالث اختیار عرضه آن را دارا باشد.</p>\r\n\r\n<p>۶-۶- توسعه&zwnj;دهنده اقرار می&zwnj;نماید که از کلیهٔ مقررات قانونی از جمله مفاد قانون حمایت از حقوق پدیدآورندگان نرم&zwnj;افزارهای رایانه&lrm;ای مصوب ۱۳۷۹، قانون تجارت الکترونیک، قانون حمایت از حقوق مؤلفان، مصنفان و هنرمندان و سایر قوانین مربوط اطلاع کامل دارد و پای&zwnj;بند به رعایت آن&zwnj;ها است. در صورت ادعا یا مطالبه حق از ناحیهٔ اشخاص ثالث، مسئول پاسخ&zwnj;گویی و جبران خسارات احتمالی خواهد بود وهایپر اپس هیچ&zwnj;گونه مسئولیتی در این خصوص نخواهد داشت.</p>\r\n\r\n<p>۷-۶- به موجب قرارداد حاضر، توسعه&zwnj;دهنده در خصوص هرگونه ادعای کاربران یا سایر اشخاص نسبت به برنامه یا محتوای ارائه شده از هر حیث پاسخ&zwnj;گو خواهد بود و هایپر اپس مسئولیتی نسبت به این دعاوی نخواهد داشت.</p>\r\n\r\n<p>۸-۶- به موجب قرارداد حاضر، توسعه&zwnj;دهنده متعهد به تحویل صحیح و کامل برنامه&zwnj; و یا محتوا از قبیل اشتراک و محصولات درون&zwnj;برنامه&zwnj;ای (در طول بازهٔ زمانی مربوط به آن) و یا سایر موارد ارائه&zwnj; شده به کاربر است. در غیر این&zwnj; صورت مسئولیت تأمین خسارات وارده به هایپر اپس،کاربر یا هر شخص ثالث دیگر بر عهدهٔ توسعه&zwnj;دهنده خواهد بود.</p>\r\n\r\n<p>۹-۶- به موجب قرارداد حاضر، توسعه&zwnj;دهنده مجاز به درخواست هیچ نوع دسترسی به اطلاعات کاربر در برنامهٔ خود، به جز آن&lrm;چه مورد نیاز کارآیی برنامه است، نبوده و در غیر این صورت مسئولیت ناشی از آن را بر عهده خواهد داشت. هایپر اپس حق بررسی دسترسی&zwnj;های هر برنامه و نسخه&zwnj;های به روزرسانی آن را داراست. چنانچه توسعه&zwnj;دهنده در نتیجهٔ استفادهٔ کاربران از محتوای تولید شده، به هرگونه اطلاعات شخصی کاربران از جمله نام، رمز عبور، یا سایر اطلاعات و داده&zwnj;های شخصی آنان دسترسی پیدا کند، متعهد است:</p>\r\n\r\n<p>الف- کلیه قوانین و مقررات جمهوری اسلامی ایران در رابطه با حریم خصوصی را رعایت نماید و در صورت نقض، عواقب آن را بپذیرد.</p>\r\n\r\n<p>ب- تنها برای مقاصدی که کاربر مجاز دانسته است از این اطلاعات استفاده نماید.</p>\r\n\r\n<p>ج- هرگونه گردآوری، استفاده، تغییر و ذخیرهٔ اطلاعات کاربران را تنها با اجازهٔ کاربر و به صورت آشکارا انجام دهد.</p>\r\n\r\n<p>۱۰-۶- به موجب قرارداد حاضر، توسعه&zwnj;دهنده مسئول حفاظت از نام کاربری و رمز عبور پنلی که به او اختصاص یافته است، شناخته می&zwnj;شود و مسئولیت تمامی فعالیت&zwnj;هایی را که با نام کاربری او انجام می&zwnj;گیرند، بر عهده خواهد داشت.</p>\r\n\r\n<p>۱۱-۶- درصورتی که به تشخیص هایپر اپس، توسعه&zwnj;&zwnj;دهنده هر یک ازمواد قرارداد حاضر را نقض نموده یا مرتکب تخلف شود، هایپر اپس مجاز به متوقف نمودن همکاری شامل حذف برنامه، حذف محصولات درون&zwnj;برنامه&zwnj;ای، تعلیق حساب کاربری، توقف تصفیه&zwnj;حساب، غیرفعال نمودن حساب کاربری هایپر اپس و ... خواهد بود. قطع همکاری می&zwnj;تواند به صورت یک&zwnj;جانبه و بدون نیاز به اطلاع&zwnj;رسانی قبلی انجام گیرد و هایپر اپس می&zwnj;تواند اقدام به تعیین خسارت مربوطه بنماید.</p>\r\n\r\n<p>موارد تخلف شامل و نه محدود به موارد زیر است:</p>\r\n\r\n<p>الف- عرضه برنامه&zwnj;های خارجی یا ایرانی توسعه&zwnj;دهندگان دیگر به نام خود.</p>\r\n\r\n<p>ب- هرگونه نقض حقوق مالکیت فکری اشخاص ثالث اعم از مادی ومعنوی و عرضهٔ هرگونه نسخهٔ ترجمه یا دستکاری شدهٔ برنامه&zwnj;های دیگران بدون رضایت صاحب اصلی برنامه.</p>\r\n\r\n<p>ج- انجام هرگونه فعالیت متقلبانه که به طور غیرعادی و غیرواقعی منجر به رشد و یا نزول برنامه و یا محتوای ارائه&zwnj;شده از سوی خود و یا دیگر توسعه&zwnj;دهندگان گردد. برای مثال، نصب انبوه برنامه&zwnj;های خود با هدف معرفی برنامه به کاربران به عنوان یک برنامهٔ پرنصب یا ارائهٔ نظرات و رتبه&zwnj;دهی مثبت یا منفی به تعداد زیاد توسط توسعه&zwnj;دهنده به برنامه خود یا دیگر توسعه&zwnj;دهندگان.</p>\r\n\r\n<p>د- هرگونه تلاش در راستای فریب دادن کاربران، در برنامه&zwnj;های خود و دیگر توسعه&lrm;دهندگان شامل دستکاری در سیستم هایپر اپس و یا ارائهٔ هر نوع پیشنهاد به کاربر در جهت ترغیب وی به ارسال نظر از طریق سایر مشوق&zwnj;ها، مانند اهدای جوایز درون و خارج از برنامه منتشر شده درهایپر اپس.</p>\r\n\r\n<p>ه- عدم پشتیبانی و پاسخ&zwnj;گویی به مشکلات و پرسش&zwnj;&zwnj;های کاربران و هایپر اپس در خصوص بخش&zwnj;های مختلف برنامه،کارکرد و تغییر در هریک از بخش&zwnj;های داخلی و یا توضیحات برنامه درهایپر اپس پس از انتشار که منجر به نارضایتی کاربران شود.</p>\r\n\r\n<p>و- عدم رعایت موازین و شئونات اخلاقی و عرفی نسبت به هایپر اپس و کاربران در کلیه مکاتبات و تماس&zwnj;ها.</p>\r\n\r\n<p>ز- در دسترس قرار ندادن راه&zwnj;های ارتباطی پاسخ&zwnj;گو مانند ایمیل و شماره تماس در داخل برنامه و صفحه برنامه در هایپر اپس جهت تماس کاربران.</p>\r\n\r\n<p>۱۲-۶- همراه با تحویل هر برنامه باید اطلاعات لازم، قالب و نحوهٔ ارسال برنامه&zwnj;&zwnj;ها یا نسخه&zwnj;های به&zwnj;روزرسانی نیز به شرح فرآیند معمول هایپر اپس جهت انتشار ارائه گردد. توسعه&zwnj;دهنده موظف به ارائهٔ اطلاعات صحیح در این خصوص است.</p>\r\n\r\n<p>۱۳-۶- به موجب قرارداد حاضر، توسعه&zwnj;دهنده موظف به ارسال مدارک و ارائه اطلاعات ذیل در پنل توسعه&zwnj;دهندگان خواهد بود:</p>\r\n\r\n<p>الف) اشخاص حقیقی:</p>\r\n\r\n<p>تصویر کارت شناسایی ملی، کدپستی محل سکونت، شمارهٔ تلفن و نشانی دقیق محل سکونت.</p>\r\n\r\n<p>ب) اشخاص حقوقی:</p>\r\n\r\n<p>تصویر روزنامهٔ رسمی تأسیس و روزنامهٔ رسمی آخرین تغییرات شرکت و معرفی صاحبان امضای مجاز، شمارهٔ تلفن، کد اقتصادی، شناسهٔ ملی، شمارهٔ ثبت، نشانی دقیق شرکت و کدپستی.</p>\r\n\r\n<p>۱۴-۶- به موجب قرارداد حاضر، توسعه&zwnj;دهنده موافقت می&zwnj;نماید که علامت و نام تجاری &laquo;هایپر اپس&raquo;&nbsp;یا هر علامت دیگر متعلق به آن را، مگر به موجب رضایت پیشین هایپر اپس و یا در مواردی که فرآیند مربوط به آن در بخش رسانه&zwnj;های سایت هایپر اپس آمده است، به هیچ وجه مورد استفاده قرار ندهد.</p>\r\n\r\n<p>۱۵-۶- به موجب قرارداد حاضر توسعه&zwnj;دهنده متعهد است در صورت تغییر اطلاعات تماس خود آن را فوراً به اطلاع بازار برساند.</p>\r\n\r\n<p>۱۶-۶- به موجب قرارداد حاضر، توسعه&zwnj;دهنده مجاز به اجبار کاربران برای ایجاد ارتباط&zwnj;های خارج از هایپر اپس اعم از تماس تلفنی، پیامکی، ایمیلی، اینترنتی، ثبت &zwnj;نام در وب&zwnj;سایت&zwnj;های دیگر و یا مراجعه حضوری، به هر دلیلی جهت فعا&zwnj;&zwnj;ل&zwnj;سازی برنامه، استفاده از برنامه&zwnj;، امکانات برنامه، رفع مشکل، اطلاع&zwnj;رسانی، به&zwnj;روزرسانی و دیگر موارد، بدون اطلاع و رضایت کامل کاربر نخواهد بود.</p>\r\n\r\n<p>۱۷-۶- به موجب قرارداد حاضر، توسعه&zwnj;دهنده متعهد است برنامه و یا محتوا را به ازای یک بار دریافت کاربر با حساب هایپر اپس در تعداد دستگاه&zwnj;&zwnj;های نامحدود در اختیار وی قرار دهد.</p>\r\n\r\n<p>۱۸-۶- توسعه&zwnj;دهنده می&zwnj;تواند تقاضای انتقال قرارداد به دیگری را به هایپر اپس ارائه نماید. هایپر اپس ظرف مدت هفت روز به این تقاضا رسیدگی خواهد کرد.</p>\r\n\r\n<p>ماده۷- حقوق و تعهداتهایپر اپس:</p>\r\n\r\n<p>۱-۷- به موجب قرارداد حاضر، هایپر اپس می&zwnj;تواند:</p>\r\n\r\n<p>الف- محتوای ارائه شده توسط توسعه&zwnj;دهنده و محتوای پیوند داده شده با آن را به منظور ارزیابی و آزمایش، مورد استفاده قرار داده و آن را روی یک یا چند دستگاه نگهداری نماید.</p>\r\n\r\n<p>ب- بعد از خاتمه قرارداد، نسخهٔ برنامه و اطلاعات مربوط به آن را نگهداری نموده و حافظهٔ اطلاعاتی مربوط به سوابق حضور برنامه در هایپر اپس را نیز حفظ نماید.</p>\r\n\r\n<p>ج- نسبت به انتشار، عدم انتشار و حذف نظرات کاربران در هر کجا و در هر موردی اقدام کند و در مواردی که نظرات یک برنامه به هر دلیلی براساس تشخیص هایپر اپس قابل کنترل نباشد، ارسال نظرات برای یک برنامه&zwnj; را غیرفعال کند.</p>\r\n\r\n<p>۲-۷- هایپر اپس می&zwnj;تواند در هر زمان به تشخیص خود نسبت به تغییر، به&zwnj;روزرسانی، بهبود یا اصلاح در پنل توسعه&zwnj;دهندگان، برنامه و سایت هایپر اپس اقدام نماید.</p>\r\n\r\n<p>۳-۷- به موجب این قرارداد، هایپر اپس هیچ&zwnj;گونه مسئولیتی در رابطه با خسارات وارد شده به توسعه&zwnj;دهنده، از جمله از دست رفتن داده یا محتوا، سود، یا شهرت تجاری وی ندارد.</p>\r\n\r\n<p>۴-۷- به موجب این قرارداد، سایت، محتوا، خدمات یا سایر اطلاعاتی که توسط هایپر اپسر و اشخاص وابسته به آن، مسئولان، مدیران، کارکنان، نمایندگان، شرکاء و دارندگان امتیاز (که مجموعاً تحت عنوان هایپر اپس از آن&zwnj;ها نام برده می&zwnj;شود) به توسعه&zwnj;دهنده ارائه می&zwnj;گردد، بر اساس داشته&zwnj;های فعلی است. هایپر اپس تلاش خواهد نمود تا این اطلاعات دقیق، قابل اتکاء، به موقع، بدون اشکال یا قطعی باشند. با این حال به دلیل بروز مشکلات احتمالی، هایپر اپس نمی&zwnj;تواند این موارد را تضمین نماید.</p>\r\n\r\n<p>۵-۷- به موجب این قرارداد، هایپر اپس نمی&zwnj;تواند عدم سوء استفاده از محتوای توسعه&zwnj;دهنده را تضمین نماید و هیچ&zwnj;گونه مسئولیتی در قبال نواقص امنیت فناوری نخواهد داشت.</p>\r\n\r\n<p>۶-۷- به موجب این قرارداد، در صورت مشاهدهٔ هرگونه تلاش جهت رخنه و نفوذ به بخش&lrm;های مختلف و یا ایجاد تغییر در هر محتوای ارائه شده توسط هایپر اپس، حق پیگیری از طریق مراجع قانونی و قضایی برای هایپر اپس محفوظ است.</p>\r\n\r\n<p>۷-۷- هایپر اپس می&zwnj;تواند در مواقع لزوم نسبت به حمایت از حقوق مادی و معنوی در ارتباط با برنامه و محتوای ارائه&zwnj;شده از سوی توسعه&zwnj;دهنده از طرق مختلف قانونی اقدام نماید، با وجود این مسئولیتی در قبال هرگونه سوء استفاده اشخاص ثالث و یا نقض احتمالی حقوق توسعه&zwnj;دهنده توسط اشخاص ثالث نخواهد داشت.</p>\r\n\r\n<p>۸-۷- هایپر اپس مجاز است شرایط و بندهای قرارداد را در هر زمان تغییرداده و یا اصلاح نماید. تغییرات به محض به&zwnj;روزرسانی و یا در زمانی که هایپر اپس معین می&zwnj;کند، لازم&zwnj;الاجرا خواهند بود. توسعه&zwnj;دهنده مسئولیت بررسی به&zwnj;روزرسانی احتمالی قرارداد را بر عهده دارد. این تغییر از طریق پنل کاربری به اطلاع توسعه&zwnj;دهنده رسیده و استمرار همکاری با هایپر اپس پس از لازم الاجرا شدن این تغییرات به منزلهٔ قبول این تغییرات است.</p>\r\n\r\n<p>۹-۷- در صورتی که در خصوص هر یک از شروط عدم مسئولیت یا تحدید مسئولیت یا نقض هر یک از مقررات کشور در رابطه با توزیع برنامه و محتوای توسعه&zwnj;دهنده، مسئولیتی بر هایپر اپس تحمیل گردد، توسعه&zwnj;دهنده موظف است که کلیهٔ خسارات مادی و معنوی وارده بر هایپر اپس را جبران نماید.</p>\r\n\r\n<p>۱۰-۷-هایپر اپس در صورت لزوم، اطلاعات مربوط به توسعه&zwnj;دهندگان را با دستور رسمی نهادهای قضایی و انتظامی، در اختیار ایشان قرار خواهد داد.</p>\r\n\r\n<p>ماده ۸- محرمانگی:<br />\r\nبه موجب قرارداد حاضر، طرفین به طور متقابل متعهد به حفظ اطلاعات فنی و غیرفنی محرمانه&zwnj;ای هستند که به موجب همکاری&zwnj;&zwnj;های موضوع این قرارداد با یکدیگر به اشتراک گذاشته&zwnj;اند. اطلاعات محرمانه اطلاعاتی هستند که عرفاً محرمانه تلقی می&zwnj;شوند یا محرمانگی آن&zwnj;ها تصریح شده است.</p>\r\n\r\n<p>ماده ۹- خاتمه و فسخ قرارداد:</p>\r\n\r\n<p>۱-۹- هایپر اپس می&zwnj;تواند در مدت اعتبار این قرارداد بنا به تشخیص خود، قرارداد را خاتمه داده و با اخطار قبلی یا بدون آن دسترسی توسعه&zwnj;دهنده به حساب کاربری را مسدود نموده، برنامه&lrm;ها را حذف کرده و یا حساب کاربری توسعه&zwnj;دهنده را معلق نماید. در این صورت تمامی حقوق و امتیازات اعطا شده از جانب هایپر اپس به توسعه&zwnj;دهنده متوقف خواهد شد و حق هایپر اپس برای رد درخواست مجدد همکاری با توسعه&zwnj;دهنده محفوظ است.</p>\r\n\r\n<p>۲-۹- توسعه&zwnj;دهنده در مدت اعتبار این قرارداد می&zwnj;تواند با اخطار کتبی و قبلی ده روزه قرارداد حاضر را فسخ نماید. در این صورت هایپر اپس عرضهٔ برنامه&zwnj;های توسعه&zwnj;دهنده را متوقف خواهد نمود. اما هایپر اپس هیچ&zwnj;&zwnj;گونه تعهدی نسبت به بازگرداندن کپی محتوا، هزینهٔ سالانه قرارداد یا سایر موارد ارائه شده توسط توسعه&zwnj;&zwnj;دهنده نخواهد داشت. در صورت خاتمه این قرارداد طرفین همچنان نسبت به مادهٔ ۸ قرارداد حاضر متعهد خواهند بود.</p>\r\n\r\n<p>ماده ۱۰- تفسير قرارداد</p>\r\n\r\n<p>۱-۱۰- بنا بر توافق طرفين، در تفسیر و اجرای این قرارداد، هر امری كه در نتيجه در نظر نگرفتن &laquo;حسن نیت&raquo; حاصل شود فاقد اعتبار و برخلاف قصد و رضای طرفين عقد است. همچنين در تفسير قرارداد موجود کلیهٔ شرایط، اعم از مذاکرات طرفین، اوضاع و احوال حاکم بر انعقاد قرارداد، هدف از انعقاد آن، روح کلی حاکم بر قرارداد و نيز عرف حاکم بر این نوع معاملات و منطق مد نظر قرار خواهد گرفت.</p>\r\n\r\n<p>۲-۱۰- در صورتی که به موجب حکم دادگاه یا قوانین جاری کشور، هر یک از مقررات این قرارداد نامعتبر شناخته شود، اولاً خدشه&zwnj;ای به سایر مفاد قرارداد وارد نشده و ثانیاً پیشنهاد هایپر اپس در خصوص اجرای سایر مفاد قرارداد به نحوی که بیشترین تطابق را با ارادهٔ اولیه طرفین داشته باشد، پذیرفته خواهد شد.</p>\r\n\r\n<p>ماده ۱۱- حل و فصل اختلافات&nbsp;</p>\r\n\r\n<p>کلیهٔ اختلافات و دعاوی ناشی از این قرارداد و یا راجع به آن از جمله انعقاد، اعتبار، فسخ، نقض، تفسیر یا اجرای آن در ابتدا از طریق صلح و سازش فصل خواهد شد؛ چنانچه اختلافات مزبور ظرف مدت یک ماه از تاریخ ابلاغ اعلامیهٔ حدوث اختلاف از این طریق حل و فصل نگردد این امر به مرکز داوری اتاق ایران ارجاع می&zwnj;گردد که مطابق با قانون اساسنامه و آئین داوری آن مرکز با رأی یک یا سه نفر داور بصورت قطعی و لازم الاجراء حل و فصل گردد. داور(ان) علاوه بر مقررات حاکم، عرف تجاری ذی&zwnj;ربط را نیز مراعات خواهد (خواهند) نمود. شرط داوری حاضر، موافقتنامه&zwnj;ای مستقل از قرارداد اصلی تلقی می&zwnj;شود و در هر حال لازم الاجراء است.</p>\r\n\r\n<p>ماده ۱۲- سایر مقررات</p>\r\n\r\n<p>۱-۱۲- این قرارداد تابع قوانین جمهوری&zwnj; اسلامی ایران است.</p>\r\n\r\n<p>۲-۱۲- عدم اعمال هریک از حقوق هایپر اپس (مصرح در این قرارداد) به منزلهٔ انصراف از حق اعمال و اجرای آن در آینده نخواهد بود.</p>\r\n\r\n<p>۳-۱۲- قرارداد حاضر متضمن کلیهٔ توافقات طرفین بوده و توافقات و اظهارات پیشین، اعم از شفاهی و کتبی، در ارتباط با موضوع این قرارداد از تاریخ انعقاد فاقد هرگونه اثر خواهد بود.</p>\r\n\r\n<p>۴-۱۲ - کلیه اخطارها، پیام&zwnj;ها و مکاتبات هایپر اپس از طریق آدرس ایمیل&zwnj;های تحت دامنه hyperapps.ir، به&zwnj;روزرسانی مستندات، پنل و یا وبلاگ رسمی توسعه&zwnj;دهندگان صورت می&zwnj;گیرد. هایپر اپس مسئولیتی در خصوص عدم توجه و یا عدم مشاهده پیام&zwnj;ها توسط توسعه&zwnj;دهنده نخواهد داشت.</p>\r\n\r\n<p>۵-۱۲- در خصوص حقوق مادی برنامه&zwnj;ها و یا محتواهایی که عرضه آن ها معوض (غیررایگان) است،&zwnj; متمم قرارداد حاضر در ۳ ماده مجری خواهد بود.</p>\r\n\r\n<p>۶-۱۲- قرارداد حاضر که شامل ۱۲ ماده و یک متمم است، در ۲ نسخه که تماماً حکم واحد را داشته توسط طرفین تنظیم، امضاء و مبادله گردیده و طرفین متعهد به اجرای کلیه تعهدات مربوط به خود شده&zwnj;اند.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>متمم قرارداد&zwnj; عرضهٔ برنامه&zwnj; و محتوای دیجیتال</strong></p>\r\n\r\n<p>عطف به بند ۵-۱۲ قرارداد توسعه&zwnj;دهندگان،&zwnj; قرارداد حاضر در خصوص حقوق مادی برنامه&zwnj;ها و یا محتواهایی که عرضه آن&zwnj;ها معوض (غیررایگان) است،&zwnj; مجری خواهد بود.</p>\r\n\r\n<p>ماده ۱- فروش و پرداخت:<br />\r\n۱-۱- قیمت فروش هر برنامه و یا محتوا به هایپر اپس توسط توسعه&zwnj;دهنده در پنل اختصاصی وی تعیین می&zwnj;گردد. هایپر اپس این برنامه یا محتوا را به قیمت صد هفتادم قیمت خرید آن از توسعه&zwnj;دهنده به علاوه مالیات بر ارزش افزوده متعلق، به کاربران خود می&zwnj;فروشد.</p>\r\n\r\n<p>۲-۱- پس از تکمیل فرآیند خرید برنامه و یا محتوا (محصولات درون&zwnj;برنامه&zwnj;ای، اشتراک و &hellip;) از سوی کاربر، هایپر اپس یک فاکتور الکترونیک برای کاربر صادر می&zwnj;کند. مبلغ مالیات دریافتی از کاربر بابت این فروش تماماً به اداره مالیات بر ارزش افزوده پرداخت می&zwnj;شود و همزمان یک فروش از توسعه&zwnj;دهنده بههایپر اپس با قیمت تعیین&zwnj;شده طبق بند ۱-۱ ثبت می&zwnj;شود.</p>\r\n\r\n<p>۳-۱- توسعه دهنده به هایپر اپس اجازه می دهد که در صورت مواجهه با شکایت کاربران، به تشخیص خود اقدام به بازگرداندن مبلغ پرداختی کاربران نماید و فروش برنامه و یا محتوا از طرف خود به آنان را برگشت بزند. بدین ترتیب به ازای هر برگشت از فروش به کاربر، یک برگشت از فروش از سوی توسعه&zwnj;دهنده به هایپر اپس نیز ثبت می&zwnj;شود.</p>\r\n\r\n<p>۴-۱- تمامی نسخه&zwnj;های به&zwnj;روزرسانی برنامه، به ازای یک بار دریافت، همواره به طور رایگان قابل دریافت خواهد بود.</p>\r\n\r\n<p>۵-۱- هایپر اپس با توجه به میزان فروش و برگشت از فروش&zwnj;های برنامه و یا محتوا در بازه&zwnj;های زمانی مشخص، یک فاکتور فروش از سوی توسعه&zwnj;دهنده به هایپر اپس، به طور خودکار صادر می&zwnj;کند و فایل الکترونیکی آن را در اختیار توسعه&zwnj;دهنده قرار می&zwnj;دهد. این فاکتور به عنوان ضمیمهٔ این قرارداد، سند مثبتهٔ خرید نسخه&zwnj;های نرم&zwnj;افزار توسط هایپر اپس از توسعه&zwnj;دهنده است. توسعه&zwnj;دهنده با امضای این قرارداد می&zwnj;پذیرد که صورت&zwnj;حساب مذکور مورد تأیید وی جهت ارائه به مراجع مالیاتی است و در صورت نیاز طبق روالی که هایپر اپس مشخص می&zwnj;کند، نسبت به تأیید و امضای آن اقدام خواهد کرد.</p>\r\n\r\n<p>۶-۱- هایپر اپس هر ماه یک بار نسبت به تصفیه&zwnj;حساب مبالغ مربوط به خرید برنامه و یا محتوا از توسعه&zwnj;دهنده، اقدام می&zwnj;کند.</p>\r\n\r\n<p>۷-۱- به منظور تصفیه&zwnj;حساب هایپر اپس با توسعه&zwnj;دهنده، باید از زمان ثبت برنامه در هایپر اپس حداقل دو هفته سپری شده باشد و حساب توسعه&zwnj;دهنده نزد هایپر اپس باید در روز پرداخت حداقل به مبلغ &nbsp;پانصد هزار&nbsp;ریال باشد. مبالغ کمتر از مبلغ ذکر شده در پایان سال و به درخواست توسعه&zwnj;دهنده تصفیه خواهند شد.</p>\r\n\r\n<p>۸-۱- پرداخت مبالغ فوق از طریق واریز به شبایی انجام خواهد گرفت که توسعه&zwnj;دهنده در پنل توسعه&zwnj;دهندگانهایپر اپس ثبت نموده است. توسعه&zwnj;دهنده به موجب این قرارداد، انتساب شبای مذکور به خود را تصدیق می&zwnj;&zwnj;کند. در غیر این صورت، هایپر اپس مسئولیتی در این خصوص نخواهد پذیرفت. اسناد واریزی به شبای وارد شده در پنل، به منزله تصفیه&zwnj;حساب هایپر اپس با توسعه&zwnj;دهنده خواهند بود.</p>\r\n\r\n<p>ماده ۲- مالیات و عوارض:</p>\r\n\r\n<p>۱-۲- در خصوص مسائل مالیاتی هر یک از طرفین مسئول تمام فعالیت&zwnj;های خود، اظهار و پرداخت مالیات&zwnj;های مربوطه هستند. هایپر اپس در خصوص ثبت اسناد و ارائه گزارشات به طور کامل از قوانین دارائی و مالیاتی کشور پیروی می&zwnj;کند و هیچ مسئولیتی در قبال نحوه ارائه گزارش&zwnj;های مالیاتی توسعه&zwnj;دهندگان برعهده ندارد.</p>\r\n\r\n<p>۲-۲- هرگونه کسورات قانونی مطابق دستورالعمل&zwnj;ها و تعرفه&zwnj;های رسمی کشور اعم از این&zwnj;که در زمان یا بعد از انعقاد قرارداد وضع شود، در محاسبات و صورت&zwnj;حساب&zwnj;ها لحاظ شده و به مراجع ذی&zwnj;ربط پرداخت خواهد شد.</p>\r\n\r\n<p>ماده ۳- مواد و نسخ قرارداد:</p>\r\n\r\n<p>متمم حاضر در ۳ ماده به عنوان جزء اختیاری قرارداد توسعه&zwnj;دهندگان در خصوص عرضه معوض برنامه و محتوا امضاء و مبادله گردیده و طرفین متعهد به اجرای کلیه بندهای آن هستند</p>\r\n', '1');
INSERT INTO `ym_pages` VALUES ('11', 'راهنمای پنل توسعه دهندگان', '<p style=\"text-align:justify\">مدیریت برنامه&zwnj;ها، حساب توسعه&zwnj;دهنده، امور مالی و فروش، ارتباط با بخش پشتیبانی بازار و دسترسی به مستندات فنی همگی از طریق پنل توسعه&zwnj;دهندگان قابل انجام هستند و شرح این موارد در ادامه آمده است.</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">ضمناً ما در &laquo;راهنمای انتشار برنامه&zwnj;ها&raquo; سعی کردیم معیار و شرایط بازار را تا حد ممکن شرح دهیم. لطفاً&nbsp;این شرایط را در&nbsp;<a href=\"https://cafebazaar.ir/developers/docs/app-publish/guideline/\">اینجا</a>&nbsp;مطالعه بفرمایید.</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<h3 dir=\"rtl\" style=\"text-align:justify\">مشاهدهٔ وضعیت و فروش برنامه&zwnj;ها</h3>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">در سربرگ اول به نام &laquo;برنامه&zwnj;ها&raquo;، وضعیت انتشار برنامه&zwnj;ها، قیمت آن&zwnj;ها، تعداد صورت&zwnj;حساب&lrm;ها برای برنامه&zwnj;های غیررایگان، تعداد نصب و امتیاز هر برنامه قابل مشاهده است. تعداد نصب&zwnj;ها برای هر برنامه، تخمینی و تعداد صورت&zwnj;حساب&lrm;ها برای برنامه&zwnj;های فروشی دقیق می&zwnj;باشد. در این سربرگ با کلیک روی هر برنامه می&zwnj;توانید هر کدام را مدیریت کنید.</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<h3 dir=\"rtl\" style=\"text-align:justify\">انتشار برنامهٔ جدید</h3>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">در سربرگ اول به نام &laquo;برنامه&zwnj;ها&raquo;، با کلیک روی دکمهٔ &laquo;برنامهٔ جدید&raquo; می&zwnj;توانید برنامه&zwnj;ای جدید بارگذاری کنید. قالب فایل ارسالی باید apk باشد و قالب&zwnj;هایی مثل zip و rar مورد قبول نیستند. پس از ارسال برنامه از این سربرگ، باید مشخصات برنامه را تکمیل نمایید و با استفاده از دکمهٔ &laquo;درخواست انتشار برنامه&raquo; در نوار بالای صفحه، برنامه را در وضعیت &laquo;در صف انتظار&raquo; قرار دهید تا توسط بازار بررسی شود.</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">اگر برنامه نیاز به تغییر داشته باشد یا مطابق شرایط بازار نباشد یا به هر دلیل دیگری، تغییری در وضعیت برنامهٔ شما توسط بازار ایجاد شود، ایمیلی حاوی توضیحات مربوطه به شما ارسال خواهد شد. لطفاً قبل از ارسال مجدد برنامه برای انتشار یا هر اقدام دیگری، ایمیل ارسال شده را ملاحظه بفرمایید. اگر ایمیل به دست شما نرسیده بود، پوشهٔ اسپم&zwnj; ایمیل&zwnj;تان را نیز بررسی کنید.</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">توجه فرمایید که پیام&zwnj;ها به ایمیلی ارسال می&zwnj;شود که با آن در بازار عضو شده و به عنوان توسعه&zwnj;دهنده ثبت&zwnj;نام کرده&zwnj;اید و نه ایمیلی که در بخش اطلاعات پشتیبانی کاربر در پنل وارد کرده&zwnj;اید.&nbsp;</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<h3 dir=\"rtl\" style=\"text-align:justify\">تکمیل یا ویرایش مشخصات برنامه</h3>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">پس از بارگذاری هر برنامه می&zwnj;توانید&nbsp;برای تکمیل اطلاعات یا برای ویرایش اطلاعات برنامه&zwnj;های قبلی اقدام کنید.</p>\r\n\r\n<h4 dir=\"rtl\" style=\"text-align:justify\">&nbsp;</h4>\r\n\r\n<h4 dir=\"rtl\" style=\"text-align:justify\">اطلاعات پایه</h4>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">با انتخاب هر برنامه به سر&rlm;برگ&zwnj; &laquo;اطلاعات&raquo; و سپس بخش &laquo;اطلاعات پایه&raquo; مراجعه کنید. در این قسمت می&zwnj;توانید مشخصات پایه&zwnj;ای برنامهٔ خود (نام، توضیحات و دسته&zwnj;بندی) را تغییر دهید. دقت کنید که پر کردن فیلد&zwnj;های این قسمت ضروری است.&nbsp;توجه داشته باشید برای برنامهٔ خود نام&zwnj;هایی را به کار برید که قبلاً در بازار استفاده&zwnj; نشده است زیرا برنامه&zwnj;های با نام مشابه در بازارمنتشر نخواهند شد. همچنین پس از انتشار برنامه در بازار، امکان تغییر دسته&zwnj;بندی آن وجود ندارد. لذا در انتخاب دسته&zwnj;بندی برنامه دقت لازم را به عمل آورید.&nbsp;</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<h4 dir=\"rtl\" style=\"text-align:justify\">قیمت&zwnj;گذاری</h4>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">در قسمت &laquo;قیمت&zwnj;&raquo;، شما می&zwnj;توانید قیمتی برای برنامهٔ خود تعیین کنید و یا قیمت قبلی آن را تغییر دهید. فقط کافی است قیمت مورد نظر خود را وارد کرده و روی دکمهٔ &laquo;تغییر قیمت&raquo; کلیک کنید. دقت کنید که امکان تغییر قیمت برای برنامه&zwnj;های رایگانی که حداقل یک بار منتشرشده&zwnj;اند، وجود ندارد.</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">تغییر قیمت&zwnj;ها، به صورت خودکار انجام می&zwnj;شود.</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<h4 dir=\"rtl\" style=\"text-align:justify\">اطلاعات پشتیبانی</h4>\r\n\r\n<p style=\"text-align:justify\">در سربرگ &laquo;اطلاعات&raquo; قسمت &laquo;اطلاعات پشتیبانی کاربر&raquo; می&zwnj;توانید اطلاعاتی را که برای ارتباط با کابران برنامه استفاده می&zwnj;شود (شماره تماس، پست الکترونیکی و آدرس سایت) را وارد کنید. وارد کردن ایمیل در این قسمت ضروری است.</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">این مشخصات جهت ارتباط کاربران با شما در صفحهٔ برنامه&zwnj;تان نمایش داده خواهند شد.</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<h4 dir=\"rtl\" style=\"text-align:justify\">تصاویر</h4>\r\n\r\n<p style=\"text-align:justify\">با انتخاب برنامه و مراجعه به سر&rlm;برگ&zwnj; &laquo;تصاویر&raquo;، می&zwnj;توانید اطلاعات تصویری برنامهٔ خود (شامل آیکون، اسکرین&zwnj;شات&zwnj;ها و ویدیو) را تغییر دهید. دقت کنید که بارگذاری آیکون و حداقل ۵ اسکرین&zwnj;شات برای هر برنامه ضروری است.</p>\r\n\r\n<p style=\"text-align:justify\">ویدیوی برنامه&zwnj;ها به صورت لینکی از <a href=\"http://www.aparat.com/\">آپارات</a> دریافت می&zwnj;شود.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<h4 style=\"text-align:justify\">درخواست انتشار</h4>\r\n\r\n<p style=\"text-align:justify\">پس از تکمیل فرآیند تکمیل مشخصات برنامه و بارگذاری بسته&zwnj;های مورد نظر خود، درخواست انتشار برنامهٔ خود را برای ما ارسال کنید. برای این کار کافی است در نوار بالای صفحه روی دکمهٔ &laquo;درخواست انتشار برنامه&raquo; کلیک کنید.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<h5 dir=\"rtl\" style=\"text-align:justify\">وضعیت برنامه&zwnj;</h5>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">هر برنامه&zwnj; می&zwnj;تواند وضعیت&zwnj;های مختلفی داشته باشد:</p>\r\n\r\n<ul>\r\n	<li dir=\"rtl\"><strong>بارگذاری شده:</strong>&nbsp;برنامه&zwnj;ای که به تازگی بارگذاری شده و هنوز درخواست انتشار برای آن ارسال نشده است. همچنین برنامه&zwnj;ای که انتشار آن توسط توسعه&zwnj;دهنده لغو شده است نیز در این وضعیت قرار می&zwnj;گیرد.</li>\r\n	<li dir=\"rtl\">\r\n	<p dir=\"rtl\"><strong>در صف انتظار:</strong>&nbsp;برنامه&zwnj;ای که در انتظار انتشار است.&nbsp;انتشار برنامه&zwnj;ها طی حداکثر ۵ روز&nbsp;<strong>کاری</strong>&nbsp;انجام می&zwnj;شوند&nbsp;(پنج&zwnj;شنبه&zwnj;ها و جمعه&zwnj;ها روز کاری محسوب نمی&zwnj;شوند).</p>\r\n	</li>\r\n	<li dir=\"rtl\">\r\n	<p dir=\"rtl\"><strong>نیاز به تغییرات:</strong>&nbsp;برنامه&zwnj;ای که برای انتشار نیاز به تغییراتی دارد. تغییرات مورد نیاز قبل از قرارگیری برنامه در این وضعیت، از طریق ایمیل به اطلاع شما خواهد رسید.</p>\r\n	</li>\r\n	<li dir=\"rtl\">\r\n	<p dir=\"rtl\"><strong>رد شده:</strong>&nbsp;برنامه&zwnj;ای که با شرایط بازار سازگار نیست و انتشار آن منتفی است. دلایل رد برنامه از طریق ایمیل به اطلاع شما می&zwnj;رسد.</p>\r\n	</li>\r\n	<li dir=\"rtl\"><strong>حذف شده:</strong>&nbsp;برنامه&zwnj;ای که قبلاً منتشرشده ولی در حال حاضر انتشار آن توسط بازار متوقف شده است.</li>\r\n	<li dir=\"rtl\">\r\n	<p dir=\"rtl\"><strong>آمادهٔ انتشار:</strong>&nbsp;برنامه&zwnj;ای که برای انتشار آماده است.</p>\r\n	</li>\r\n	<li dir=\"rtl\">\r\n	<p dir=\"rtl\"><strong>منتشر شده:</strong>&nbsp;برنامه&zwnj;ای که منتشر شده و در دسترس کاربران است.</p>\r\n	</li>\r\n</ul>\r\n\r\n<h4 style=\"text-align:justify\">انتشار خودکار یا دستی</h4>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">برنامهٔ شما پس از طی فرآیند انتشار، به صورت خودکار در کافه&zwnj;بازار منتشر خواهد شد. اگر می&zwnj;خواهید برنامه توسط شما منتشر شود؛ در زمان ارسال درخواست بررسی، انتشار خودکار را غیرفعال کنید و یا پس از ارسال درخواست انتشار، در نوار بالای صفحهٔ برنامه روی دکمهٔ &laquo;لغو انتشار خودکار&raquo; در نوار بالای صفحه کلیک کنید. در این صورت مشخص کردن زمان&zwnj; انتشار برای برنامه در اختیار شماست.</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">&nbsp;برای انتشار دستی برنامهٔ خود، در نوار بالای صفحهٔ برنامه روی دکمهٔ &laquo;انتشار برنامه&raquo; کلیک کنید. دقت داشته باشید که به دلیل همگام&zwnj;سازی سرورهای بازار، ممکن است انتشار برنامه حداکثر یک ساعت به طول انجامد.</p>\r\n\r\n<p dir=\"rtl\" style=\"text-align:justify\">در صورتی که از تصمیم خود مبنی بر انتشار دستی منصرف شده&zwnj;اید؛ می&zwnj;توانید با کلیک روی دکمهٔ &laquo;فعال&zwnj;سازی انتشار خودکار&raquo; در نوار بالای صفحه&zwnj;ٔ برنامه به حالت اولیه (انتشار خودکار بلافاصله بعد از تأیید برنامه) بازگردید.</p>\r\n', '2');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_page_categories
-- ----------------------------
INSERT INTO `ym_page_categories` VALUES ('1', 'صفحات استاتیک', 'base', '1');
INSERT INTO `ym_page_categories` VALUES ('2', 'مستندات', 'document', '1');

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
INSERT INTO `ym_site_setting` VALUES ('1', 'site_title', 'عنوان سایت', 'مرجع برنامه های موبایل');
INSERT INTO `ym_site_setting` VALUES ('2', 'default_title', 'عنوان پیش فرض صفحات', 'هایپر اپس');
INSERT INTO `ym_site_setting` VALUES ('3', 'keywords', 'کلمات کلیدی سایت', 'برنامه موبایل,android,ios,windowsphone,اندروید,ویندوز فون،هایپر اپس،مارکت هایپر اپس-مارکت اندروید');
INSERT INTO `ym_site_setting` VALUES ('4', 'site_description', 'شرح وبسایت', 'ارائه دهنده اپلیکیشن موبایل در سه پلتفرم اندروید ، iOS و ویندوز فون');
INSERT INTO `ym_site_setting` VALUES ('7', 'tax', 'میزان مالیات (درصد)', '9');
INSERT INTO `ym_site_setting` VALUES ('8', 'commission', 'حق کمیسیون (درصد)', '15');
INSERT INTO `ym_site_setting` VALUES ('5', 'buy_credit_options', 'گزینه های خرید اعتبار', '[\"5000\",\"10000\",\"20000\",\"500\"]');
INSERT INTO `ym_site_setting` VALUES ('6', 'min_credit', 'حداقل اعتبار جهت تبدیل عضویت', '500');

-- ----------------------------
-- Table structure for ym_tickets
-- ----------------------------
DROP TABLE IF EXISTS `ym_tickets`;
CREATE TABLE `ym_tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه تیکت',
  `user_id` int(10) unsigned DEFAULT NULL,
  `status` enum('waiting','pending','open','close') COLLATE utf8_persian_ci DEFAULT 'waiting' COMMENT 'وضعیت تیکت',
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ',
  `subject` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'موضوع',
  `department_id` int(10) unsigned DEFAULT NULL COMMENT 'بخش',
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ym_tickets_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `ym_ticket_departments` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_tickets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_tickets
-- ----------------------------
INSERT INTO `ym_tickets` VALUES ('11', '10000', '44', 'close', '1471761824', 'مشکل در اراسال فایل apk', '1');

-- ----------------------------
-- Table structure for ym_ticket_departments
-- ----------------------------
DROP TABLE IF EXISTS `ym_ticket_departments`;
CREATE TABLE `ym_ticket_departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_ticket_departments
-- ----------------------------
INSERT INTO `ym_ticket_departments` VALUES ('1', 'مدیریت');

-- ----------------------------
-- Table structure for ym_ticket_messages
-- ----------------------------
DROP TABLE IF EXISTS `ym_ticket_messages`;
CREATE TABLE `ym_ticket_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(10) unsigned DEFAULT NULL COMMENT 'تیکت',
  `sender` enum('admin','supporter','user') COLLATE utf8_persian_ci DEFAULT NULL,
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ',
  `text` text COLLATE utf8_persian_ci COMMENT 'متن',
  `attachment` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'فایل ضمیمه',
  `visit` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`),
  CONSTRAINT `ym_ticket_messages_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ym_tickets` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_ticket_messages
-- ----------------------------
INSERT INTO `ym_ticket_messages` VALUES ('31', '11', 'user', '1471761824', 'تست', 's8kEb1464260978.png', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('44', '', '$2a$12$m/P8t.qlboQFFmWWocuCne.jHKNADmRM2WhaXr3r3Xai2vMw3pe9O', 'yusef.mobasheri@gmail.com', '2', '1465981367', 'active', '31d605466e289ae77f9d01dc7da28b5c', '0');
INSERT INTO `ym_users` VALUES ('45', '', '$2a$12$b57H8NhKosG9nk30YjxBGO46YBPz8q9aEctRmccXac.jafMVuYbU.', 'hyperads.panel@gmail.com', '2', '1466122239', 'active', null, '0');
INSERT INTO `ym_users` VALUES ('46', '', '$2a$12$UQ1SQGTCVIKciT6rDMKKL.xoBOew7MK/DuaYKSMii.Pa1nU4.wxN.', 'gharagozlu.masoud@gmail.com', '2', '1466406436', 'active', 'b0492e5ee5582af151b9f41bdb3531c0', '0');
INSERT INTO `ym_users` VALUES ('47', '', '$2a$12$Q5rOF1L9t8KdcXaEs4sz8.1Xp6dY5Jsfkb5u.nmRvQ.bS1eolNN46', 'hyperads8l@gmail.com', '1', '1466638902', 'active', 'bea833d9545281de58e3c04baff50246', '0');
INSERT INTO `ym_users` VALUES ('48', '', '$2a$12$eUQP0wKu21P8c74YDLfsyOTF7dv9zy5Sg0axWfk/rBTG5NrrRD6gS', 'hyperapps8@gmail.com', '1', '1466639001', 'active', '1b28d1f0a05ecfb60bff58abb40ef023', '0');
INSERT INTO `ym_users` VALUES ('49', '', '$2a$12$eIvTLA541cW6pLsaaNhsoO19wIM3FGQjty1v/ycOvtkpjQCYudMbq', 'ghanbarpour2012@gmail.com', '1', '1467532081', 'active', 'c45aab53430564a2b3df455d04f43def', '0');
INSERT INTO `ym_users` VALUES ('50', '', '$2a$12$chQjMeX2wAXDPhoj251qU.JZOWbJmYhKNs/qTq9vpGvIaTLu4saf6', 'k.rahebi@gmail.com', '2', '1469554150', 'active', null, '0');
INSERT INTO `ym_users` VALUES ('51', '', '$2a$12$tv1/st9yHD0GntCEmJTCR.S8Xo/7UtxgxWOM38lOhSVqswmqeYCYK', 'SibcheApp@yahoo.com', '1', '1470818975', 'pending', 'ba37dcaf4eca702152bdcedadd408863', '0');
INSERT INTO `ym_users` VALUES ('52', '', '$2a$12$24xJS.JfTCoPxhhgno8zzeq89gOWUh4WAzh4rz9pGHmEqKp5nCEu.', 'medesighnerm1@gmail.com', '1', '1471526560', 'pending', '8aef1a0df6fbb84d5653365dcb27409e', '0');
INSERT INTO `ym_users` VALUES ('53', '', '$2a$12$qNq78ERrzz7aG67z2h9CzONldJ0wSOd9swyDjD8qLT.Lv4Kg4HnUK', 'my1170@gmail.com', '1', '1471685175', 'pending', '142b72f806b06784b7574b8b629597d0', '0');

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
INSERT INTO `ym_user_app_bookmark` VALUES ('44', '60');

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
  `nickname` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام نمایشی',
  `type` enum('real','legal') CHARACTER SET utf8 DEFAULT 'real' COMMENT 'نوع حساب',
  `post` enum('ceo','board') CHARACTER SET utf8 DEFAULT NULL COMMENT 'سمت',
  `company_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام شرکت',
  `registration_number` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شماره ثبت',
  `registration_certificate_image` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تصویر گواهی ثبت شرکت',
  `score` int(10) unsigned DEFAULT '0' COMMENT 'امتیاز',
  `dev_score` int(10) unsigned DEFAULT '0' COMMENT 'امتیاز توسعه دهنده',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_details
-- ----------------------------
INSERT INTO `ym_user_details` VALUES ('44', 'یوسف مبشری', 'Yusef Mobasheri', 'tarsiminc.ir', 'tarsiminc.com', '0370544651', 'NpLls1465983239.jpg', '09358389265', '3718146164', 'قم - خیابان امام خمینی', '5000000', 'yusef', 'accepted', '0', null, 'Yusef', 'real', null, null, null, null, null, '0');
INSERT INTO `ym_user_details` VALUES ('45', 'گروه برنامه نویسی هایپر ادز', 'Programming Group hyperads', '', 'http://hyperads.ir', '0830083731', 'gmdIt1466126488.jpg', '09332514128', '0831166567', 'تهران', '684', 'hyperads', 'accepted', '0', null, 'هایپر ادز', 'real', 'ceo', 'هایپر ادز', '123456', 'gmdIt1466126488.jpg', null, '0');
INSERT INTO `ym_user_details` VALUES ('46', 'مسعود قراگوزلو', 'masoud gharagozlu', '', '', '0370518926', 'jfJ9J1466406615.png', '38888888', '3718958691', 'قم...', '199100', 'Masoud', 'accepted', '1', '123456789123456789123456', null, 'real', null, null, null, null, '1', '23');
INSERT INTO `ym_user_details` VALUES ('47', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, '0');
INSERT INTO `ym_user_details` VALUES ('48', null, null, null, null, null, null, null, null, null, '600', null, 'pending', '0', null, null, 'real', null, null, null, null, null, '0');
INSERT INTO `ym_user_details` VALUES ('49', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, '10', '0');
INSERT INTO `ym_user_details` VALUES ('50', 'پویا', 'Pouya', '', '', '2020202020', 'CisDP1469566398.jpg', '09368365525', '1234567890', 'jkhjf,k.hlj;kljhgfd', '500', null, 'accepted', '0', null, 'Pouya', 'real', null, null, null, null, null, '0');
INSERT INTO `ym_user_details` VALUES ('51', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, '0');
INSERT INTO `ym_user_details` VALUES ('52', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, '0');
INSERT INTO `ym_user_details` VALUES ('53', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, '0');

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
-- Table structure for ym_user_notifications
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_notifications`;
CREATE TABLE `ym_user_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `message` varchar(500) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'متن پیام',
  `seen` tinyint(4) NOT NULL COMMENT 'مشاهده شده',
  `date` varchar(30) NOT NULL COMMENT 'زمان',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_notifications
-- ----------------------------
INSERT INTO `ym_user_notifications` VALUES ('15', '46', 'اطلاعات شما توسط مدیر سیستم تایید شد.', '1', '1465984503');
INSERT INTO `ym_user_notifications` VALUES ('16', '46', 'شناسه شما توسط مدیر سیستم تایید شد.', '1', '1465984546');
INSERT INTO `ym_user_notifications` VALUES ('17', '46', 'اطلاعات شما توسط مدیر سیستم تایید شد.', '1', '1466126840');
INSERT INTO `ym_user_notifications` VALUES ('18', '46', 'شناسه شما توسط مدیر سیستم تایید شد.', '1', '1466126915');
INSERT INTO `ym_user_notifications` VALUES ('19', '46', 'اطلاعات شما توسط مدیر سیستم تایید شد.', '1', '1466406657');
INSERT INTO `ym_user_notifications` VALUES ('20', '46', 'شناسه شما توسط مدیر سیستم تایید شد.', '1', '1466407916');
INSERT INTO `ym_user_notifications` VALUES ('21', '46', 'اطلاعات شما توسط مدیر سیستم تایید شد.', '1', '1466429041');
INSERT INTO `ym_user_notifications` VALUES ('22', '46', 'اطلاعات شما توسط مدیر سیستم رد شد.', '1', '1466429077');
INSERT INTO `ym_user_notifications` VALUES ('23', null, 'بسته opera توسط مدیر سیستم حذف شد.', '0', '1466454953');
INSERT INTO `ym_user_notifications` VALUES ('24', null, 'بسته ir.hyperapps.opera توسط مدیر سیستم حذف شد.', '0', '1466454956');
INSERT INTO `ym_user_notifications` VALUES ('25', '46', 'برنامه دعای روزانه ماه رمضان+صوت تایید شده است.', '1', '1466463243');
INSERT INTO `ym_user_notifications` VALUES ('26', '46', 'برنامه دعای روزانه ماه رمضان+صوت تایید شده است.', '1', '1466463451');
INSERT INTO `ym_user_notifications` VALUES ('27', '46', 'برنامه دعای روزهای ماه رمضان تایید شده است.', '1', '1466466022');
INSERT INTO `ym_user_notifications` VALUES ('28', '46', 'برنامه  توسط مدیر سیستم حذف شد.', '1', '1466490552');
INSERT INTO `ym_user_notifications` VALUES ('29', '46', 'برنامه دعای روزانه ماه رمضان+صوت تایید شده است.', '1', '1466640898');
INSERT INTO `ym_user_notifications` VALUES ('30', null, 'برنامه تلگرام توسط مدیر سیستم حذف شد.', '0', '1466939183');
INSERT INTO `ym_user_notifications` VALUES ('31', '46', 'برنامه اپرا تایید شده است.', '1', '1467037057');
INSERT INTO `ym_user_notifications` VALUES ('32', '46', 'برنامه اپرا توسط مدیر سیستم حذف شد.', '1', '1467037431');
INSERT INTO `ym_user_notifications` VALUES ('33', null, 'برنامه مرورگر اپرا مینی توسط مدیر سیستم حذف شد.', '0', '1467037433');
INSERT INTO `ym_user_notifications` VALUES ('34', null, 'بسته com.mobo.MoliPlayer  توسط مدیر سیستم حذف شد.', '0', '1467122241');
INSERT INTO `ym_user_notifications` VALUES ('35', null, 'برنامه برنامه آزمایشی توسط مدیر سیستم حذف شد.', '0', '1467126038');
INSERT INTO `ym_user_notifications` VALUES ('36', '46', 'برنامه عید سعید فطر+صوت تایید شده است.', '1', '1467569759');
INSERT INTO `ym_user_notifications` VALUES ('37', '46', 'اطلاعات شما توسط مدیر سیستم تایید شد.', '1', '1469597046');
INSERT INTO `ym_user_notifications` VALUES ('38', null, 'برنامه MoliPlayer Pro توسط مدیر سیستم حذف شد.', '0', '1469631021');
INSERT INTO `ym_user_notifications` VALUES ('39', '46', 'برنامه عید سعید فطر+صوت توسط مدیر سیستم حذف شد.', '1', '1470462274');
INSERT INTO `ym_user_notifications` VALUES ('40', null, 'بسته com.habra.example.call_recorder توسط مدیر سیستم حذف شد.', '0', '1471684597');
INSERT INTO `ym_user_notifications` VALUES ('41', null, 'بسته ir.tgbs.android.iranapp توسط مدیر سیستم حذف شد.', '0', '1471686987');
INSERT INTO `ym_user_notifications` VALUES ('42', '46', 'برنامه دعای روزانه ماه رمضان+صوت تایید شده است.', '1', '1471688555');
INSERT INTO `ym_user_notifications` VALUES ('43', '46', 'بسته ir.hyperads.shabake توسط مدیر سیستم تایید شد.', '1', '1471688567');
INSERT INTO `ym_user_notifications` VALUES ('44', '46', 'برنامه ترفند و راز رمز های تلگرام،واتس آپ ،وایبر و ... تایید شده است.', '1', '1471688672');
INSERT INTO `ym_user_notifications` VALUES ('45', null, 'بسته com.apusapps.tools.flashtorch توسط مدیر سیستم حذف شد.', '0', '1472913143');
INSERT INTO `ym_user_notifications` VALUES ('46', null, 'بسته ir.tgbs.android.iranapp توسط مدیر سیستم حذف شد.', '0', '1472913146');
INSERT INTO `ym_user_notifications` VALUES ('47', null, 'بسته com.apusapps.tools.flashtorch توسط مدیر سیستم حذف شد.', '0', '1472915999');
INSERT INTO `ym_user_notifications` VALUES ('48', null, 'بسته com.asadworld.asadworld.flashlightpro توسط مدیر سیستم حذف شد.', '0', '1472916002');
INSERT INTO `ym_user_notifications` VALUES ('49', null, 'بسته ir.tgbs.android.iranapp توسط مدیر سیستم حذف شد.', '0', '1472979885');
INSERT INTO `ym_user_notifications` VALUES ('50', null, 'برنامه نرم افزار PhotoGrid برای ویرایش عکس توسط مدیر سیستم حذف شد.', '0', '1474624721');
INSERT INTO `ym_user_notifications` VALUES ('51', null, 'برنامه اپرا توسط مدیر سیستم حذف شد.', '0', '1474624724');
INSERT INTO `ym_user_notifications` VALUES ('52', '46', 'برنامه مزاج یاب تایید شده است.', '1', '1474664875');
INSERT INTO `ym_user_notifications` VALUES ('53', '46', 'بسته ir.hyperads.love توسط مدیر سیستم تایید شد.', '1', '1474664892');
INSERT INTO `ym_user_notifications` VALUES ('54', '46', 'بسته ir.hyperads.root توسط مدیر سیستم تایید شد.', '1', '1474664897');
INSERT INTO `ym_user_notifications` VALUES ('55', '46', 'برنامه کارت پستال های عاشقانه تایید شده است.', '1', '1474664922');
INSERT INTO `ym_user_notifications` VALUES ('56', '46', 'برنامه روت همه گوشیهای آندروید(صد در صد تضمینی) تایید شده است.', '1', '1474664934');
INSERT INTO `ym_user_notifications` VALUES ('57', '46', 'برنامه مرجع کامل تست هوش تایید شده است.', '1', '1474665413');
INSERT INTO `ym_user_notifications` VALUES ('58', '46', 'برنامه دعای روزهای ماه رمضان نیاز به تغییرات دارد. جهت مشاهده پیام کارشناسان به صفحه ویرایش برنامه مراجعه فرمایید.', '1', '1474831382');
INSERT INTO `ym_user_notifications` VALUES ('59', '46', 'اطلاعات شما توسط مدیر سیستم تایید شد.', '1', '1475303917');
INSERT INTO `ym_user_notifications` VALUES ('60', '46', 'اطلاعات شما توسط مدیر سیستم تایید شد.', '1', '1475364806');
INSERT INTO `ym_user_notifications` VALUES ('61', '46', 'اطلاعات شما توسط مدیر سیستم تایید شد.', '1', '1475364889');
INSERT INTO `ym_user_notifications` VALUES ('62', '46', 'بسته ir.tgbs.android.iranapp توسط مدیر سیستم تایید شد.', '1', '1477039452');
INSERT INTO `ym_user_notifications` VALUES ('63', '46', 'برنامه برنامه بدون اطلاعات تایید شده است.', '1', '1477039466');
INSERT INTO `ym_user_notifications` VALUES ('64', '46', 'بسته com.farsitel.bazaar توسط مدیر سیستم تایید شد.', '1', '1477043018');
INSERT INTO `ym_user_notifications` VALUES ('65', '46', 'برنامه برنامه بدون اطلاعات رد شده است. جهت اطلاع از دلیل تایید نشدن بسته جدید به صفحه ویرایش برنامه مراجعه فرمایید.', '0', '1477382718');
INSERT INTO `ym_user_notifications` VALUES ('66', null, 'برنامه APUS Flashlight نیاز به تغییرات دارد. جهت مشاهده پیام کارشناسان به صفحه ویرایش برنامه مراجعه فرمایید.', '0', '1477382759');
INSERT INTO `ym_user_notifications` VALUES ('67', '46', 'بسته ir.tgbs.android.iranapp2 توسط مدیر سیستم تایید شد.', '0', '1480150519');
INSERT INTO `ym_user_notifications` VALUES ('68', '44', 'توسعه دهنده برنامه \"دعای روزانه ماه رمضان+صوت\" برای نظر شما پاسخ ارسال کرده است.', '0', '1480504842');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_settlement
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_transactions
-- ----------------------------
INSERT INTO `ym_user_transactions` VALUES ('4', '45', '100', '1466126098', 'paid', '5089738158', 'خرید اعتبار از طریق درگاه زرین پال');
INSERT INTO `ym_user_transactions` VALUES ('5', '48', '100', '1466639210', 'paid', '3892320583', 'خرید اعتبار از طریق درگاه زرین پال');
INSERT INTO `ym_user_transactions` VALUES ('6', '48', '100', '1467124844', 'paid', '4794704778', 'خرید اعتبار از طریق درگاه زرین پال');
INSERT INTO `ym_user_transactions` VALUES ('7', '48', '500', '1467569943', 'paid', '4496956003', 'خرید اعتبار از طریق درگاه زرین پال');
INSERT INTO `ym_user_transactions` VALUES ('8', '50', '500', '1469566182', 'paid', '41106820966', 'خرید اعتبار از طریق درگاه زرین پال');
