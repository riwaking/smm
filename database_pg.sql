-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 15, 2025 at 06:57 AM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

START TRANSACTION;

;
;
;
;

--
-- Database: "u650314999_project"
--

-- --------------------------------------------------------

--
-- Table structure for table "admins"
--

CREATE TABLE "admins" (
  "admin_id" INTEGER NOT NULL,
  "admin_type" VARCHAR(50) NOT NULL DEFAULT '2',
  "admin_name" varchar(255) DEFAULT NULL,
  "admin_email" text DEFAULT NULL,
  "username" varchar(225) DEFAULT NULL,
  "password" text NOT NULL,
  "telephone" varchar(50) DEFAULT NULL,
  "register_date" TIMESTAMP NOT NULL,
  "login_date" TIMESTAMP DEFAULT NULL,
  "login_ip" varchar(225) DEFAULT NULL,
  "client_type" VARCHAR(50) NOT NULL DEFAULT '2',
  "access" varchar(999) NOT NULL,
  "mode" varchar(225) NOT NULL,
  "two_factor" VARCHAR(50) NOT NULL DEFAULT '0',
  "two_factor_secret_key" varchar(100) DEFAULT NULL
);

--
-- Dumping data for table "admins"
--

INSERT INTO "admins" ("admin_id", "admin_type", "admin_name", "admin_email", "username", "password", "telephone", "register_date", "login_date", "login_ip", "client_type", "access", "mode", "two_factor", "two_factor_secret_key") VALUES
(1, '3', 'Admin', 'admin@admin.com', 'admin', '1234567890', '', '2021-09-08 10:19:05', '2023-09-24 23:03:38', '27.58.7.36', '2', '{\"admin_access\":1,\"users\":1,\"services\":1,\"update-prices\":1,\"bulk\":1,\"synced-logs\":1,\"orders\":1,\"subscriptions\":1,\"dripfeed\":1,\"tasks\":1,\"payments\":1,\"tickets\":1,\"additionals\":1,\"referral\":1,\"broadcast\":1,\"logs\":1,\"reports\":1,\"videop\":1,\"coupon\":1,\"child-panels\":1,\"updates\":1,\"appearance\":1,\"themes\":1,\"new_year\":1,\"pages\":1,\"news\":1,\"meta\":1,\"blog\":1,\"menu\":1,\"inte\":1,\"language\":1,\"files\":1,\"settings\":1,\"general_settings\":1,\"providers\":1,\"payments_settings\":1,\"bank_accounts\":1,\"modules\":1,\"subject\":1,\"payments_bonus\":1,\"currency-manager\":1,\"alert_settings\":1,\"site_count\":1,\"manager\":1,\"super_admin\":1}', 'sun', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table "admin_constants"
--

CREATE TABLE "admin_constants" (
  "id" INTEGER NOT NULL,
  "brand_logo" varchar(255) DEFAULT NULL,
  "paidRent" SMALLINT DEFAULT 0
);

--
-- Dumping data for table "admin_constants"
--

INSERT INTO "admin_constants" ("id", "brand_logo", "paidRent") VALUES
(1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table "article"
--

CREATE TABLE "article" (
  "id" INTEGER NOT NULL,
  "title" varchar(128) NOT NULL,
  "content" text NOT NULL,
  "published_at" TIMESTAMP DEFAULT NULL,
  "image_file" varchar(200) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "bank_accounts"
--

CREATE TABLE "bank_accounts" (
  "id" INTEGER NOT NULL,
  "bank_name" varchar(225) NOT NULL,
  "bank_sube" varchar(225) NOT NULL,
  "bank_hesap" varchar(225) NOT NULL,
  "bank_iban" text NOT NULL,
  "bank_alici" varchar(225) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "blogs"
--

CREATE TABLE "blogs" (
  "id" INTEGER NOT NULL,
  "title" varchar(128) NOT NULL,
  "content" text NOT NULL,
  "published_at" TIMESTAMP NOT NULL,
  "image_file" varchar(200) DEFAULT NULL,
  "status" VARCHAR(50) NOT NULL DEFAULT '1',
  "blog_get" varchar(225) NOT NULL,
  "updated_at" TIMESTAMP NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "bulkedit"
--

CREATE TABLE "bulkedit" (
  "id" INTEGER NOT NULL,
  "service_id" INTEGER NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "categories"
--

CREATE TABLE "categories" (
  "category_id" INTEGER NOT NULL,
  "category_name" text NOT NULL,
  "category_name_lang" TEXT DEFAULT NULL,
  "category_line" DOUBLE PRECISION NOT NULL,
  "category_type" VARCHAR(50) NOT NULL DEFAULT '2',
  "category_secret" VARCHAR(50) NOT NULL DEFAULT '2',
  "category_icon" text NOT NULL,
  "is_refill" VARCHAR(50) NOT NULL DEFAULT '1',
  "category_deleted" VARCHAR(50) NOT NULL DEFAULT '0'
);

-- --------------------------------------------------------

--
-- Table structure for table "childpanels"
--

CREATE TABLE "childpanels" (
  "id" INTEGER NOT NULL,
  "client_id" INTEGER NOT NULL,
  "domain" varchar(191) NOT NULL,
  "child_panel_currency" varchar(191) NOT NULL,
  "child_panel_username" varchar(191) NOT NULL,
  "child_panel_password" varchar(191) NOT NULL,
  "charged_amount" REAL NOT NULL,
  "child_panel_status" VARCHAR(50) NOT NULL DEFAULT 'Pending',
  "renewal_date" date NOT NULL,
  "created_on" TIMESTAMP NOT NULL,
  "child_panel_uqid" varchar(225) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "clients"
--

CREATE TABLE "clients" (
  "client_id" INTEGER NOT NULL,
  "name" varchar(225) DEFAULT NULL,
  "email" varchar(225) NOT NULL,
  "username" varchar(225) DEFAULT NULL,
  "admin_type" VARCHAR(50) NOT NULL DEFAULT '2',
  "password" text NOT NULL,
  "telephone" varchar(225) DEFAULT NULL,
  "balance" decimal(21,4) NOT NULL DEFAULT 0.0000,
  "spent" decimal(21,4) NOT NULL DEFAULT 0.0000,
  "balance_type" VARCHAR(50) NOT NULL DEFAULT '2',
  "debit_limit" DOUBLE PRECISION DEFAULT NULL,
  "register_date" TIMESTAMP NOT NULL,
  "login_date" TIMESTAMP DEFAULT NULL,
  "login_ip" varchar(225) DEFAULT NULL,
  "apikey" text NOT NULL,
  "tel_type" VARCHAR(50) NOT NULL DEFAULT '1',
  "email_type" VARCHAR(50) NOT NULL DEFAULT '1',
  "client_type" VARCHAR(50) NOT NULL DEFAULT '2',
  "access" text DEFAULT NULL,
  "lang" varchar(255) NOT NULL DEFAULT 'tr',
  "timezone" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "currency_type" varchar(10) DEFAULT NULL,
  "ref_code" text NOT NULL,
  "ref_by" text DEFAULT NULL,
  "change_email" VARCHAR(50) NOT NULL DEFAULT '2',
  "resend_max" INTEGER NOT NULL DEFAULT 3,
  "currency" varchar(225) NOT NULL DEFAULT '1',
  "passwordreset_token" varchar(225) NOT NULL,
  "discount_percentage" INTEGER NOT NULL,
  "broadcast_id" varchar(255) NOT NULL DEFAULT '0'
);

-- --------------------------------------------------------

--
-- Table structure for table "clients_category"
--

CREATE TABLE "clients_category" (
  "id" INTEGER NOT NULL,
  "client_id" INTEGER NOT NULL,
  "category_id" INTEGER NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "clients_price"
--

CREATE TABLE "clients_price" (
  "id" INTEGER NOT NULL,
  "client_id" INTEGER NOT NULL,
  "service_id" INTEGER NOT NULL,
  "service_price" DOUBLE PRECISION NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "clients_service"
--

CREATE TABLE "clients_service" (
  "id" INTEGER NOT NULL,
  "client_id" INTEGER NOT NULL,
  "service_id" INTEGER NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "client_report"
--

CREATE TABLE "client_report" (
  "id" INTEGER NOT NULL,
  "client_id" INTEGER NOT NULL,
  "action" text NOT NULL,
  "report_ip" varchar(225) NOT NULL,
  "report_date" TIMESTAMP NOT NULL
);

--
-- Dumping data for table "client_report"
--

INSERT INTO "client_report" ("id", "client_id", "action", "report_ip", "report_date") VALUES
(1, 1, '\r\n    User registered.', '122.177.216.106', '2023-09-01 18:40:21'),
(2, 1, 'Member logged in.', '122.177.216.106', '2023-09-01 18:41:43'),
(3, 1, 'Member logged in.', '122.177.216.106', '2023-09-01 21:15:50'),
(4, 1, 'Member logged in.', '122.177.216.106', '2023-09-02 11:23:42'),
(5, 1, 'Member logged in.', '122.177.216.106', '2023-09-02 12:02:38'),
(6, 1, 'Member logged in.', '122.177.216.106', '2023-09-02 13:30:20'),
(7, 1, '2.5285 New Order #1.', '122.177.216.106', '2023-09-02 15:13:50'),
(8, 1, '0.8645 New Order #2.', '122.177.216.106', '2023-09-02 16:13:29'),
(9, 1, '#2 Order number of has been completed.', '127.0.0.1', '2023-09-02 16:39:02'),
(10, 1, '0.3458 New Order #3.', '122.177.216.106', '2023-09-02 17:14:59'),
(11, 1, '#3 Order number of has been completed.', '127.0.0.1', '2023-09-02 17:39:07'),
(12, 1, '#1 Order number of has been completed.', '127.0.0.1', '2023-09-03 01:01:02'),
(13, 1, 'Member logged in.', '122.161.61.242', '2023-09-04 21:26:42'),
(14, 1, 'Member logged in.', '122.161.61.242', '2023-09-05 19:39:38');

-- --------------------------------------------------------

--
-- Table structure for table "currencies"
--

CREATE TABLE "currencies" (
  "id" INTEGER NOT NULL,
  "currency_name" varchar(50) NOT NULL,
  "currency_code" varchar(10) NOT NULL,
  "currency_symbol" varchar(10) DEFAULT NULL,
  "symbol_position" varchar(10) DEFAULT 'left',
  "currency_rate" DOUBLE PRECISION NOT NULL,
  "currency_inverse_rate" DOUBLE PRECISION NOT NULL,
  "is_enable" SMALLINT NOT NULL DEFAULT 0,
  "currency_hash" text NOT NULL
);

--
-- Dumping data for table "currencies"
--

INSERT INTO "currencies" ("id", "currency_name", "currency_code", "currency_symbol", "symbol_position", "currency_rate", "currency_inverse_rate", "is_enable", "currency_hash") VALUES
(1, 'Indian Rupee', 'INR', '₹', 'left', 1, 1, 1, 'a4956249500ba31bc01c4b302cfa8e1a22b8a801'),
(2, 'U.S. Dollar', 'USD', '$', 'left', 0.012031188633176, 83.117307066609, 1, '8909c4c6bc52fe2357bd35e6b3fc209a2476399a'),
(3, 'Euro', 'EUR', '€', 'left', 0.011283789309634, 88.622711091052, 1, '185d31d64c6feb611b6a2ab50b634ba00e43e586'),
(4, 'Turkish Lira', 'TRY', '₺', 'left', 0.32464957828123, 3.0802442599625, 1, '349f7b9ebdeb631986de1a85faa303032f206147'),
(5, 'Russian Rouble', 'RUB', '₽', 'left', 1.1622701365896, 0.86038517941643, 1, '5fe6bfdce0b90e9caf56a80fd25f33d0f20159f1'),
(6, 'Brazilian Real', 'BRL', 'R$', 'left', 0.058598591142312, 17.065256698261, 1, 'e50baf88aed2020b6073f40a8ca26d7d1b0fb765'),
(7, 'South Korean Won', 'KRW', '₩', 'left', 15.971135887832, 0.062612954208339, 1, 'e676515c1847b4376de8a04c370e0bf201fc34ca'),
(8, 'Saudi Riyal', 'SAR', '﷼', 'left', 0.045127965560183, 22.159208543678, 1, 'd7f247a574a692b15fc7e9dadf1fa4883c9a6e2d'),
(9, 'Chinese Yuan', 'CNY', '¥', 'left', 0.087514931016616, 11.426621587694, 1, '06c7a274a673ed9037f1d4ad04f3a737b3024d75'),
(10, 'Vietnamese Dong', 'VND', '₫', 'left', 291.3860438861, 0.0034318733548917, 1, '4f2780b924554c2e51c34013c102c1119d9fbfb9'),
(11, 'Kuwaiti Dinar', 'KWD', 'د.ك', 'left', 0.0037181157337651, 268.95343545086, 1, 'dcf8a0dd3ddfaca27e99475560a40ff4a780f070'),
(12, 'Egyptian Pound', 'EGP', '£', 'left', 0.37196575116044, 2.6884195571239, 1, 'a0d874f915b1733bf25be06df757cb843ad07fbe'),
(13, 'Pakistani Rupee', 'PKR', '₨', 'left', 3.6480720199915, 0.27411739530359, 1, '4829c93dadf334b7298def05bbfdd8642142f378'),
(14, 'Nigerian Naira', 'NGN', '₦', 'left', 9.2427922307965, 0.10819241361588, 1, '36577516307566a0725f97fdc8797b27ea1ef78d');

-- --------------------------------------------------------

--
-- Table structure for table "custom_settings"
--

CREATE TABLE "custom_settings" (
  "id" INTEGER NOT NULL,
  "snow_data" text NOT NULL,
  "snow_data_array" text NOT NULL,
  "snow_status" VARCHAR(50) NOT NULL DEFAULT '1',
  "start_count_parser" text NOT NULL,
  "orders_count_increase" varchar(225) NOT NULL
);

--
-- Dumping data for table "custom_settings"
--

INSERT INTO "custom_settings" ("id", "snow_data", "snow_data_array", "snow_status", "start_count_parser", "orders_count_increase") VALUES
(1, '\"snow\":{\"init\":false,\"options\":{\"particles\":{\"move\":{\"speed\":,\"bounce\":false,\"enable\":true,\"random\":false,\"attract\":{\"enable\":false,\"rotateX\":600,\"rotateY\":1200},\"out_mode\":\"out\",\"straight\":false,\"direction\":\"bottom\"},\"size\":{\"anim\":{\"sync\":false,\"speed\":40,\"enable\":false,\"size_min\":0.1},\"value\":10,\"random\":true},\"color\":{\"value\":\"#fff\"},\"number\":{\"value\":,\"density\":{\"enable\":true,\"value_area\":650}},\"opacity\":{\"anim\":{\"sync\":false,\"speed\":1,\"enable\":true,\"opacity_min\":0.9},\"value\":0.9,\"random\":true},\"line_linked\":{\"color\":\"#ffffff\",\"width\":1,\"enable\":false,\"opacity\":0.8,\"distance\":500}},\"interactivity\":{\"modes\":{\"bubble\":{\"size\":4,\"speed\":3,\"opacity\":1,\"distance\":400,\"duration\":0.3},\"repulse\":{\"speed\":3,\"distance\":200,\"duration\":0.4}},\"events\":{\"resize\":true,\"onclick\":{\"mode\":\"repulse\",\"enable\":true},\"onhover\":{\"mode\":\"bubble\",\"enable\":false}},\"detect_on\":\"window\"},\"retina_detect\":true}},\"toys\":{\"init\":false,\"options\":{\"count\":100,\"speed\":1,\"images\":[],\"maxSize\":30,\"launches\":\"1\"}},\"garland\":{\"init\":false,\"options\":{\"type\":\"\",\"style\":\"\"}},\"fireworks\":{\"init\":false,\"options\":{\"delay\":{\"max\":30,\"min\":30},\"friction\":,\"launches\":1,}}', '{\"snow_fall\":\"true\",\"snowflakes\":\"20\",\"snow_speed\":\"3\",\"garlands\":\"true\",\"gar_shape\":\"apple\",\"gar_style\":\"style1\",\"fire_works\":\"true\",\"fire_size\":\"0.95\",\"fire_speed\":\"slow\",\"toy_size\":\"80\",\"toy_quantity\":\"100\",\"toy_speed\":\"6\",\"toy_launch\":\"infinite\"}', '1', '{\"none\":\"Catch from supplier\",\"instagram_follower\":\"Instagram followers\",\"instagram_photo\":\"Instagram likes\",\"instagram_comments\":\"Instagram comments\",\"youtube_views\":\"Youtube views\",\"youtube_likes\":\"Youtube likes\",\"youtube_comments\":\"Youtube comments\",\"youtube_subscribers\":\"Youtube subscribers\"}', '0:0');

-- --------------------------------------------------------

--
-- Table structure for table "decoration"
--

CREATE TABLE "decoration" (
  "id" INTEGER NOT NULL,
  "snow_effect" INTEGER NOT NULL,
  "snow_colour" text NOT NULL,
  "diwali_lights" INTEGER NOT NULL,
  "video_link" text NOT NULL,
  "christmas_deco" varchar(5000) NOT NULL,
  "action_link" text NOT NULL,
  "pop_noti" INTEGER NOT NULL,
  "pop_title" text NOT NULL,
  "pop_desc" text NOT NULL,
  "action_text" varchar(10) NOT NULL,
  "action_button" INTEGER NOT NULL,
  "snow_fall" varchar(500) DEFAULT NULL,
  "garlands" text DEFAULT NULL,
  "fire_works" text DEFAULT NULL,
  "toys" text DEFAULT NULL,
  "snowflakes" INTEGER NOT NULL,
  "snow_speed" INTEGER NOT NULL,
  "gar_shape" text NOT NULL,
  "gar_style" text NOT NULL,
  "fire_size" varchar(100) NOT NULL,
  "fire_speed" text NOT NULL,
  "toy_size" INTEGER NOT NULL,
  "toy_quantity" INTEGER NOT NULL,
  "toy_speed" INTEGER NOT NULL,
  "toy_launch" varchar(100) NOT NULL,
  "toy_a" varchar(50) NOT NULL,
  "toy_b" varchar(50) NOT NULL,
  "toy_c" varchar(50) NOT NULL,
  "toy_d" varchar(50) NOT NULL,
  "toy_e" varchar(50) NOT NULL,
  "toy_f" varchar(50) NOT NULL,
  "toy_g" varchar(50) NOT NULL,
  "toy_h" varchar(50) NOT NULL,
  "toy_i" varchar(50) NOT NULL,
  "toy_j" varchar(50) NOT NULL,
  "toy_k" varchar(50) NOT NULL,
  "psw_license" text NOT NULL,
  "toy_l" varchar(50) NOT NULL
);

--
-- Dumping data for table "decoration"
--

INSERT INTO "decoration" ("id", "snow_effect", "snow_colour", "diwali_lights", "video_link", "christmas_deco", "action_link", "pop_noti", "pop_title", "pop_desc", "action_text", "action_button", "snow_fall", "garlands", "fire_works", "toys", "snowflakes", "snow_speed", "gar_shape", "gar_style", "fire_size", "fire_speed", "toy_size", "toy_quantity", "toy_speed", "toy_launch", "toy_a", "toy_b", "toy_c", "toy_d", "toy_e", "toy_f", "toy_g", "toy_h", "toy_i", "toy_j", "toy_k", "psw_license", "toy_l") VALUES
(1, 0, '#004a00', 0, '', '\n<style>.particle-snow{position:fixed;top:0;left:0;width:100%;height:100%;z-index:1;pointer-events:none}.particle-snow canvas{position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none}.christmas-garland{text-align:center;white-space:nowrap;overflow:hidden;position:absolute;z-index:1;padding:0;pointer-events:none;width:100%;height:85px}.christmas-garland .christmas-garland__item{position:relative;width:28px;height:28px;border-radius:50%;display:inline-block;margin-left:20px}.christmas-garland .christmas-garland__item .shape{-webkit-animation-fill-mode:both;animation-fill-mode:both;-webkit-animation-iteration-count:infinite;animation-iteration-count:infinite;-webkit-animation-name:flash-1;animation-name:flash-1;-webkit-animation-duration:2s;animation-duration:2s}.christmas-garland .christmas-garland__item .apple{width:22px;height:22px;border-radius:50%;margin-left:auto;margin-right:auto;margin-top:8px}.christmas-garland .christmas-garland__item .pear{width:12px;height:28px;border-radius:50%;margin-left:auto;margin-right:auto;margin-top:6px}.christmas-garland .christmas-garland__item:nth-child(2n+1) .shape{-webkit-animation-name:flash-2;animation-name:flash-2;-webkit-animation-duration:.4s;animation-duration:.4s}.christmas-garland .christmas-garland__item:nth-child(4n+2) .shape{-webkit-animation-name:flash-3;animation-name:flash-3;-webkit-animation-duration:1.1s;animation-duration:1.1s}.christmas-garland .christmas-garland__item:nth-child(odd) .shape{-webkit-animation-duration:1.8s;animation-duration:1.8s}.christmas-garland .christmas-garland__item:nth-child(3n+1) .shape{-webkit-animation-duration:1.4s;animation-duration:1.4s}.christmas-garland .christmas-garland__item:before{content:\"\";position:absolute;background:#222;width:10px;height:10px;border-radius:3px;top:-1px;left:9px}.christmas-garland .christmas-garland__item:after{content:\"\";top:-9px;left:14px;position:absolute;width:52px;height:18px;border-bottom:solid #222 2px;border-radius:50%}.christmas-garland .christmas-garland__item:last-child:after{content:none}.christmas-garland .christmas-garland__item:first-child{margin-left:-40px}</style>\n<!-- developed by Raj Patel-->\n      \n<!-- developed by Raj Patel-->  \n    <script type=\"text/javascript\" src=\"https://cdn.mypanel.link/libs/jquery/1.12.4/jquery.min.js\">\n          </script>\n    \n<!-- developed by Raj Patel-->\n        \n    <script type=\"text/javascript\" src=\"https://cdn.mypanel.link/global/flpbonhmkq9tsp29.js\">\n          </script>\n    \n        \n<!-- developed by Raj Patel-->\n    <script type=\"text/javascript\" src=\"https://cdn.mypanel.link/global/a4kdpfesx15uh7ae.js\">\n          </script>\n    \n<!-- developed by Raj Patel-->\n        \n    <script type=\"text/javascript\" src=\"https://cdn.mypanel.link/global/596z6ya3isgxcipy.js\">\n          </script>\n    \n        \n    <script type=\"text/javascript\" src=\"https://cdn.mypanel.link/global/39j8e9yrxs283d1x.js\">\n          </script>\n    \n        \n    <script type=\"text/javascript\" src=\"https://cdn.mypanel.link/global/33srijdbqcgk6lsz.js\">\n          </script>\n    \n<!-- developed by Raj Patel-->\n<!-- developed by Raj Patel-->\n        \n    <script type=\"text/javascript\" src=\"https://cdn.mypanel.link/52pp7z/wxbh27w4jdzpslxn.js\">\n          </script>\n    \n<!-- developed by Raj Patel-->\n<!-- developed by Raj Patel-->\n        \n    <script type=\"text/javascript\" src=\"https://cdn.mypanel.link/52pp7z/angedasgma230hxr.js\">\n          </script>\n    \n        \n<!-- developed by Raj Patel-->\n<!-- developed by Raj Patel-->\n    <script type=\"text/javascript\" >\n       window.modules.layouts = {\"theme_id\":1,\"auth\":0,\"live\":true};     </script>\n    \n        \n    <script type=\"text/javascript\" >\n       window.modules.signin = [];     </script>\n    \n<!-- developed by Raj Patel-->\n<!-- developed by Raj Patel-->\n<!-- developed by Raj Patel-->\n        \n    <script type=\"text/javascript\" >\n       document.addEventListener(\'DOMContentLoaded\', function() { \nvar newYearEvent = new window.NewYearEvent({\"snow\":{\"init\":true,\"options\":{\"particles\":{\"move\":{\"speed\":3,\"bounce\":false,\"enable\":true,\"random\":false,\"attract\":{\"enable\":false,\"rotateX\":600,\"rotateY\":1200},\"out_mode\":\"out\",\"straight\":false,\"direction\":\"bottom\"},\"size\":{\"anim\":{\"sync\":false,\"speed\":40,\"enable\":false,\"size_min\":0.1},\"value\":5,\"random\":true},\"color\":{\"value\":\"#fff\"},\"number\":{\"value\":100,\"density\":{\"enable\":true,\"value_area\":650}},\"opacity\":{\"anim\":{\"sync\":false,\"speed\":1,\"enable\":true,\"opacity_min\":0.9},\"value\":0.9,\"random\":true},\"line_linked\":{\"color\":\"#ffffff\",\"width\":1,\"enable\":false,\"opacity\":0.8,\"distance\":500}},\"interactivity\":{\"modes\":{\"bubble\":{\"size\":4,\"speed\":3,\"opacity\":1,\"distance\":400,\"duration\":0.3},\"repulse\":{\"speed\":3,\"distance\":200,\"duration\":0.4}},\"events\":{\"resize\":true,\"onclick\":{\"mode\":\"repulse\",\"enable\":true},\"onhover\":{\"mode\":\"bubble\",\"enable\":false}},\"detect_on\":\"window\"},\"retina_detect\":true}},\"toys\"', '', 0, '', '', '', 0, 'true', NULL, NULL, NULL, 50, 10, 'apple', 'style2', '0.95', 'slow', 80, 100, 6, 'infinite', '', '', '', '', '', '1', '', '', '', '1', '1', 'dukesmm.com', '1');

-- --------------------------------------------------------

--
-- Table structure for table "earn"
--

CREATE TABLE "earn" (
  "earn_id" INTEGER NOT NULL,
  "client_id" INTEGER NOT NULL,
  "link" text NOT NULL,
  "earn_note" text NOT NULL,
  "status" VARCHAR(50) NOT NULL DEFAULT 'Pending'
);

-- --------------------------------------------------------

--
-- Table structure for table "files"
--

CREATE TABLE "files" (
  "id" INTEGER NOT NULL,
  "name" varchar(100) DEFAULT NULL,
  "link" text DEFAULT NULL,
  "date" TIMESTAMP NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "General_options"
--

CREATE TABLE "General_options" (
  "id" INTEGER NOT NULL,
  "coupon_status" VARCHAR(50) NOT NULL DEFAULT '1',
  "updates_show" VARCHAR(50) NOT NULL DEFAULT '1',
  "panel_status" VARCHAR(50) NOT NULL,
  "panel_orders" INTEGER NOT NULL,
  "panel_thismonthorders" INTEGER NOT NULL,
  "massorder" VARCHAR(50) NOT NULL DEFAULT '2',
  "balance_format" VARCHAR(50) NOT NULL DEFAULT '0.0',
  "currency_format" VARCHAR(50) NOT NULL DEFAULT '3',
  "ticket_system" VARCHAR(50) NOT NULL DEFAULT '1'
);

--
-- Dumping data for table "General_options"
--

INSERT INTO "General_options" ("id", "coupon_status", "updates_show", "panel_status", "panel_orders", "panel_thismonthorders", "massorder", "balance_format", "currency_format", "ticket_system") VALUES
(1, '', '2', 'Active', 1024, 20, '2', '', '', '2');

-- --------------------------------------------------------

--
-- Table structure for table "integrations"
--

CREATE TABLE "integrations" (
  "id" INTEGER NOT NULL,
  "name" varchar(225) NOT NULL,
  "description" varchar(225) NOT NULL,
  "icon_url" varchar(225) NOT NULL,
  "code" text NOT NULL,
  "visibility" INTEGER NOT NULL,
  "status" INTEGER NOT NULL DEFAULT 1
);

--
-- Dumping data for table "integrations"
--

INSERT INTO "integrations" ("id", "name", "description", "icon_url", "code", "visibility", "status") VALUES
(1, 'Beamer', 'Announce updates and get feedback with in-app notification center, widgets and changelog', '/img/integrations/Beamer.svg', '', 1, 1),
(2, 'Getsitecontrol', 'It helps you prevent website visitors from leaving your website without taking any action.', '/img/integrations/Getsitecontrol.svg', '<html>\r\n<body style=\'background-color:black\'>\r\n<canvas id=\'myCanvas\' width=\'800\' height=\'800\'></canvas>\r\n<script>\r\nconst max_fireworks = 5,\r\n  max_sparks = 50;\r\nlet canvas = document.getElementById(\'myCanvas\');\r\nlet context = canvas.getContext(\'2d\');\r\nlet fireworks = [];\r\n \r\nfor (let i = 0; i < max_fireworks; i++) {\r\n  let firework = {\r\n    sparks: []\r\n  };\r\n  for (let n = 0; n < max_sparks; n++) {\r\n    let spark = {\r\n      vx: Math.random() * 5 + .5,\r\n      vy: Math.random() * 5 + .5,\r\n      weight: Math.random() * .3 + .03,\r\n      red: Math.floor(Math.random() * 2),\r\n      green: Math.floor(Math.random() * 2),\r\n      blue: Math.floor(Math.random() * 2)\r\n    };\r\n    if (Math.random() > .5) spark.vx = -spark.vx;\r\n    if (Math.random() > .5) spark.vy = -spark.vy;\r\n    firework.sparks.push(spark);\r\n  }\r\n  fireworks.push(firework);\r\n  resetFirework(firework);\r\n}\r\nwindow.requestAnimationFrame(explode);\r\n \r\nfunction resetFirework(firework) {\r\n  firework.x = Math.floor(Math.random() * canvas.width);\r\n  firework.y = canvas.height;\r\n  firework.age = 0;\r\n  firework.phase = \'fly\';\r\n}\r\n \r\nfunction explode() {\r\n  context.clearRect(0, 0, canvas.width, canvas.height);\r\n  fireworks.forEach((firework,index) => {\r\n    if (firework.phase == \'explode\') {\r\n        firework.sparks.forEach((spark) => {\r\n        for (let i = 0; i < 10; i++) {\r\n          let trailAge = firework.age + i;\r\n          let x = firework.x + spark.vx * trailAge;\r\n          let y = firework.y + spark.vy * trailAge + spark.weight * trailAge * spark.weight * trailAge;\r\n          let fade = i * 20 - firework.age * 2;\r\n          let r = Math.floor(spark.red * fade);\r\n          let g = Math.floor(spark.green * fade);\r\n          let b = Math.floor(spark.blue * fade);\r\n          context.beginPath();\r\n          context.fillStyle = \'rgba(\' + r + \',\' + g + \',\' + b + \',1)\';\r\n          context.rect(x, y, 4, 4);\r\n          context.fill();\r\n        }\r\n      });\r\n      firework.age++;\r\n      if (firework.age > 100 && Math.random() < .05) {\r\n        resetFirework(firework);\r\n      }\r\n    } else {\r\n      firework.y = firework.y - 10;\r\n      for (let spark = 0; spark < 15; spark++) {\r\n        context.beginPath();\r\n        context.fillStyle = \'rgba(\' + index * 50 + \',\' + spark * 17 + \',0,1)\';\r\n        context.rect(firework.x + Math.random() * spark - spark / 2, firework.y + spark * 4, 4, 4);\r\n        context.fill();\r\n      }\r\n      if (Math.random() < .001 || firework.y < 200) firework.phase = \'explode\';\r\n    }\r\n  });\r\n  window.requestAnimationFrame(explode);\r\n}\r\n</script>\r\n</body>\r\n</html>', 1, 1),
(3, 'Google Analytics', 'Statistics and basic analytical tools for search engine optimization (SEO) and marketing purposes', '/img/integrations/Google%20Analytics.svg', '', 1, 1),
(4, 'Google Tag manager', 'Manage all your website tags without editing the code using simple tag management solutions', '/img/integrations/Google%20Tag%20manager.svg', '', 1, 1),
(5, 'JivoChat', 'All-in-one business messenger to talk to customers: live chat, phone, email and social', '/img/integrations/JivoChat.svg', '', 1, 1),
(6, 'Onesignal', 'Leader in customer engagement, empowers mobile push, web push, email, in-app messages', '/img/integrations/Onesignal.svg', '', 1, 1),
(7, 'Push alert', 'Increase reach, revenue, retarget users with Push Notifications on desktop and mobile', '/img/integrations/Push%20alert.svg', '', 1, 1),
(8, 'Smartsupp', 'Live chat, email inbox and Facebook Messenger in one customer messaging platform', '/img/integrations/Smartsupp.svg', '', 1, 1),
(9, 'Tawk.to', 'Track and chat with visitors on your website, mobile app or a free customizable page', '/img/integrations/Tawk.to.svg', '', 1, 1),
(10, 'Tidio', 'Communicator for businesses that keep live chat, chatbots, Messenger and email in one place', '/img/integrations/Tidio.svg', '', 1, 1),
(11, 'Zendesk Chat', 'Helps respond quickly to customer questions, reduce wait times and increase sales', '/img/integrations/Zendesk%20Chat.svg', '', 1, 1),
(12, 'Getbutton.io', 'Chat with website visitors through popular messaging apps. Whatsapp, messenger etc. contact button.', '/img/integrations/Getbutton.svg', '', 1, 1),
(13, 'Google reCAPTCHA v2', 'It uses an advanced risk analysis engine and adaptive challenges to prevent malware from engaging in abusive activities on your website.', '/img/integrations/reCAPTCHA.svg', '', 1, 1),
(14, 'Whatsapp', 'Whatsapp is for Personal Support of your Users', '/img/integrations/whatsapp.svg', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table "kuponlar"
--

CREATE TABLE "kuponlar" (
  "id" INTEGER NOT NULL,
  "kuponadi" varchar(255) NOT NULL,
  "adet" INTEGER NOT NULL,
  "tutar" DOUBLE PRECISION NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "kupon_kullananlar"
--

CREATE TABLE "kupon_kullananlar" (
  "id" INTEGER NOT NULL,
  "uye_id" INTEGER NOT NULL,
  "kuponadi" varchar(255) NOT NULL,
  "tutar" DOUBLE PRECISION NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "languages"
--

CREATE TABLE "languages" (
  "id" INTEGER NOT NULL,
  "language_name" varchar(225) NOT NULL,
  "language_code" varchar(225) NOT NULL,
  "language_type" VARCHAR(50) NOT NULL DEFAULT '2',
  "default_language" VARCHAR(50) NOT NULL DEFAULT '0'
);

--
-- Dumping data for table "languages"
--

INSERT INTO "languages" ("id", "language_name", "language_code", "language_type", "default_language") VALUES
(1, 'English', 'en', '2', '1'),
(2, 'Arabic', 'ar', '2', '0');

-- --------------------------------------------------------

--
-- Table structure for table "Mailforms"
--

CREATE TABLE "Mailforms" (
  "id" INTEGER NOT NULL,
  "subject" varchar(225) NOT NULL,
  "message" varchar(225) NOT NULL,
  "status" VARCHAR(50) NOT NULL DEFAULT '1',
  "header" varchar(225) NOT NULL,
  "footer" varchar(225) NOT NULL,
  "type" VARCHAR(50) NOT NULL DEFAULT 'Users'
);

-- --------------------------------------------------------

--
-- Table structure for table "menus"
--

CREATE TABLE "menus" (
  "id" INTEGER NOT NULL,
  "name" text NOT NULL,
  "menu_name_lang" TEXT DEFAULT NULL,
  "menu_line" DOUBLE PRECISION NOT NULL,
  "type" VARCHAR(50) NOT NULL DEFAULT '2',
  "slug" varchar(225) NOT NULL DEFAULT '2',
  "icon" varchar(225) DEFAULT NULL,
  "menu_status" VARCHAR(50) NOT NULL DEFAULT '1',
  "visible" VARCHAR(50) NOT NULL DEFAULT 'Internal',
  "active" varchar(225) NOT NULL,
  "tiptext" varchar(225) NOT NULL
);

--
-- Dumping data for table "menus"
--

INSERT INTO "menus" ("id", "name", "menu_name_lang", "menu_line", "type", "slug", "icon", "menu_status", "visible", "active", "tiptext") VALUES
(1, 'New Order', '{\"en\": \"New Order\"}', 1, '2', '/', 'fa fa-shopping-bag', '1', 'Internal', 'neworder', ''),
(2, 'Mass Order', '{\"en\": \"Mass Order\"}', 2, '2', '/massorder', 'fas fa-cart-plus', '1', 'Internal', 'massorder', 'Shown only if Mass Order system enabled for use'),
(3, 'Orders ', '{\"en\": \"Orders \"}', 3, '2', '/orders', 'fas fa-server', '1', 'Internal', 'orders', ''),
(6, 'Services', '{\"en\": \"Services\"}', 5, '2', '/services', 'fas fa-file-alt', '1', 'Internal', 'services', ''),
(7, 'Add Funds', '{\"en\": \"Add Funds\"}', 6, '2', '/addfunds', 'fab fa-cc-amazon-pay', '1', 'Internal', 'addfunds', ''),
(8, 'Api', '{\"en\": \"Api\"}', 9, '2', '/api', 'fal fa-plug', '1', 'Internal', 'api', ''),
(9, 'Tickets ', '{\"en\": \"Tickets \"}', 8, '2', '/tickets', 'fas fa-headset', '1', 'Internal', 'tickets', ''),
(10, 'Child Panels', '{\"en\": \"Child Panels\"}', 10, '2', '/child-panels', 'fas fa-child', '1', 'Internal', 'child-panels', 'Shown only if child panels selling enabled'),
(11, 'Refer & Earn', '{\"en\": \"Refer & Earn\"}', 11, '2', '/refer', 'fas fa-bezier-curve', '1', 'Internal', 'refer', 'Shown only if affiliate system enabled for use'),
(13, 'Terms', '{\"en\": \"Terms\"}', 12, '2', '/terms', 'fas fa-exclamation-triangle', '1', 'Internal', 'terms', ''),
(14, 'Signup ', '{\"en\": \"Signup\"}', 2, '2', '/signup', 'fas fa-arrow-right', '1', 'External', 'signup', 'Shown only if Signup system enabled for use'),
(15, 'Api', '{\"en\": \"Api\"}', 4, '2', '/api', 'fal fa-plug', '1', 'External', 'api', ''),
(17, 'Daily Updates', '{\"en\": \"Daily Updates\"}', 13, '2', '/updates', 'fas fa-bell', '1', 'Internal', '', 'Shown only if Updates System enabled'),
(18, 'Terms', '{\"en\": \"Terms\"}', 3, '2', '/terms', 'fas fa-exclamation-triangle', '1', 'External', 'terms', ''),
(32, 'blogs', '{\"en\": \"blogs\"}', 16, '2', '/blog', 'fab fa-500px', '1', 'Internal', 'blog', ''),
(24, 'Services', '{\"en\": \"Services\"}', 14, '2', '/services', 'fas fa-file-alt', '1', 'External', 'services', ''),
(28, 'Transfer Funds ', '{\"en\": \"Transfer Funds \"}', 14, '2', '/transferfunds', 'fas fa-grip-vertical', '1', 'Internal', 'Transfer Funds ', ''),
(31, 'blogs', '{\"en\": \"blogs\"}', 15, '2', '/blog', '', '1', 'External', 'blog', '');

-- --------------------------------------------------------

--
-- Table structure for table "news"
--

CREATE TABLE "news" (
  "id" INTEGER NOT NULL,
  "news_icon" varchar(225) NOT NULL,
  "news_title" varchar(225) NOT NULL,
  "news_title_lang" TEXT DEFAULT NULL,
  "news_content" varchar(225) NOT NULL,
  "news_content_lang" TEXT DEFAULT NULL,
  "news_date" TIMESTAMP NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "notifications_popup"
--

CREATE TABLE "notifications_popup" (
  "id" INTEGER NOT NULL,
  "title" text NOT NULL,
  "type" text DEFAULT NULL,
  "action_link" text DEFAULT NULL,
  "isAllUser" VARCHAR(50) NOT NULL DEFAULT '0',
  "expiry_date" date NOT NULL,
  "status" VARCHAR(50) NOT NULL DEFAULT '1',
  "description" text DEFAULT NULL,
  "action_text" text DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "orders"
--

CREATE TABLE "orders" (
  "order_id" INTEGER NOT NULL,
  "client_id" INTEGER NOT NULL,
  "service_id" INTEGER NOT NULL,
  "api_orderid" INTEGER NOT NULL DEFAULT 0,
  "order_error" text NOT NULL,
  "order_detail" text DEFAULT NULL,
  "order_api" INTEGER NOT NULL DEFAULT 0,
  "api_serviceid" INTEGER NOT NULL DEFAULT 0,
  "api_charge" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "api_currencycharge" DOUBLE PRECISION DEFAULT 1,
  "order_profit" DOUBLE PRECISION NOT NULL,
  "order_quantity" DOUBLE PRECISION NOT NULL,
  "order_extras" text NOT NULL,
  "order_charge" DOUBLE PRECISION NOT NULL,
  "dripfeed" VARCHAR(50) DEFAULT '1',
  "dripfeed_id" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "subscriptions_id" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "subscriptions_type" VARCHAR(50) NOT NULL DEFAULT '1',
  "dripfeed_totalcharges" DOUBLE PRECISION DEFAULT NULL,
  "dripfeed_runs" DOUBLE PRECISION DEFAULT NULL,
  "dripfeed_delivery" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "dripfeed_interval" DOUBLE PRECISION DEFAULT NULL,
  "dripfeed_totalquantity" DOUBLE PRECISION DEFAULT NULL,
  "dripfeed_status" VARCHAR(50) NOT NULL DEFAULT 'active',
  "order_url" text NOT NULL,
  "order_start" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "order_finish" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "order_remains" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "order_create" TIMESTAMP NOT NULL,
  "order_status" VARCHAR(50) NOT NULL DEFAULT 'pending',
  "subscriptions_status" VARCHAR(50) NOT NULL DEFAULT 'active',
  "subscriptions_username" text DEFAULT NULL,
  "subscriptions_posts" DOUBLE PRECISION DEFAULT NULL,
  "subscriptions_delivery" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "subscriptions_delay" DOUBLE PRECISION DEFAULT NULL,
  "subscriptions_min" DOUBLE PRECISION DEFAULT NULL,
  "subscriptions_max" DOUBLE PRECISION DEFAULT NULL,
  "subscriptions_expiry" date DEFAULT NULL,
  "last_check" TIMESTAMP NOT NULL,
  "order_where" VARCHAR(50) NOT NULL DEFAULT 'site',
  "refill_status" VARCHAR(50) NOT NULL DEFAULT 'Pending',
  "is_refill" VARCHAR(50) NOT NULL DEFAULT '1',
  "refill" varchar(225) NOT NULL DEFAULT '1',
  "cancelbutton" VARCHAR(50) NOT NULL DEFAULT '1',
  "show_refill" VARCHAR(50) NOT NULL DEFAULT 'true',
  "api_refillid" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "avg_done" VARCHAR(50) NOT NULL DEFAULT '1',
  "order_increase" INTEGER NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "pages"
--

CREATE TABLE "pages" (
  "page_id" INTEGER NOT NULL,
  "page_name" varchar(225) NOT NULL,
  "page_get" varchar(225) NOT NULL,
  "page_content" text NOT NULL,
  "page_status" VARCHAR(50) NOT NULL DEFAULT '1',
  "active" VARCHAR(50) NOT NULL DEFAULT '1',
  "seo_title" varchar(225) NOT NULL,
  "seo_keywords" varchar(225) NOT NULL,
  "seo_description" varchar(225) NOT NULL,
  "last_modified" TIMESTAMP NOT NULL,
  "del" varchar(255) NOT NULL DEFAULT '1',
  "page_content2" text NOT NULL
);

--
-- Dumping data for table "pages"
--

INSERT INTO "pages" ("page_id", "page_name", "page_get", "page_content", "page_status", "active", "seo_title", "seo_keywords", "seo_description", "last_modified", "del", "page_content2") VALUES
(2, 'Add funds', 'addfunds', '', '1', '1', '', '', '', '2023-07-27 09:55:56', '2', ''),
(787, 'Login', 'auth', '', '1', '1', '', '', '', '2023-08-12 09:18:17', '2', ''),
(9, 'New Order', 'neworder', '', '1', '1', '', '', '', '2023-09-02 05:24:53', '2', ''),
(14, 'Terms', 'terms', '', '1', '1', '', '', '', '2022-02-07 08:41:16', '2', ''),
(789, 'Mass Order', 'massorder', '', '1', '1', '', '', '', '2022-02-07 08:43:06', '2', ''),
(790, 'Orders', 'orders', '', '1', '1', '', '', '', '2022-02-07 08:53:20', '2', ''),
(791, 'Services', 'services', '', '1', '1', '', '', '', '2022-01-26 07:22:09', '2', ''),
(792, 'Tickets', 'tickets', '', '1', '1', '', '', '', '2022-01-26 07:22:09', '2', ''),
(793, 'API', 'api', '', '1', '1', '', '', '', '2022-01-24 07:21:07', '2', ''),
(794, 'Signup', 'signup', '', '1', '1', '', '', '', '2022-01-24 07:21:07', '2', ''),
(795, 'Blog', 'blog', '', '1', '1', '', '', '', '2022-01-24 07:21:07', '2', ''),
(909, 'success', 'success', '', '1', '1', '', '', '', NULL, '1', '');

-- --------------------------------------------------------

--
-- Table structure for table "panel_categories"
--

CREATE TABLE "panel_categories" (
  "id" INTEGER NOT NULL,
  "name" text DEFAULT NULL,
  "status" VARCHAR(50) NOT NULL DEFAULT '1'
);

-- --------------------------------------------------------

--
-- Table structure for table "panel_info"
--

CREATE TABLE "panel_info" (
  "panel_id" INTEGER NOT NULL,
  "panel_domain" text NOT NULL,
  "panel_plan" text NOT NULL,
  "panel_status" VARCHAR(50) NOT NULL,
  "panel_orders" INTEGER NOT NULL,
  "panel_thismonthorders" INTEGER NOT NULL,
  "date_created" TIMESTAMP NOT NULL,
  "api_key" varchar(225) NOT NULL,
  "renewal_date" TIMESTAMP NOT NULL,
  "panel_type" VARCHAR(50) NOT NULL DEFAULT 'Main'
);

--
-- Dumping data for table "panel_info"
--

INSERT INTO "panel_info" ("panel_id", "panel_domain", "panel_plan", "panel_status", "panel_orders", "panel_thismonthorders", "date_created", "api_key", "renewal_date", "panel_type") VALUES
(1, 'yourpanel.com', 'A', 'Active', 1453, 1453, '2022-01-24 10:58:08', 'b1fbedd6f1266a8990bf648919068680', '2025-02-23 10:58:08', 'Main');

-- --------------------------------------------------------

--
-- Table structure for table "paymentmethods"
--

CREATE TABLE "paymentmethods" (
  "methodId" INTEGER NOT NULL,
  "methodName" varchar(300) DEFAULT NULL,
  "methodLogo" varchar(200) DEFAULT NULL,
  "methodVisibleName" varchar(300) DEFAULT NULL,
  "methodCallback" varchar(100) DEFAULT NULL,
  "methodMin" INTEGER NOT NULL DEFAULT 1,
  "methodMax" INTEGER NOT NULL DEFAULT 1,
  "methodFee" REAL NOT NULL DEFAULT 0,
  "methodBonusPercentage" REAL NOT NULL DEFAULT 0,
  "methodBonusStartAmount" INTEGER NOT NULL DEFAULT 0,
  "methodCurrency" varchar(3) DEFAULT NULL,
  "methodStatus" VARCHAR(50) NOT NULL DEFAULT '0',
  "methodExtras" TEXT DEFAULT NULL,
  "methodPosition" INTEGER DEFAULT NULL,
  "methodInstructions" TEXT DEFAULT NULL
);

--
-- Dumping data for table "paymentmethods"
--

INSERT INTO "paymentmethods" ("methodId", "methodName", "methodLogo", "methodVisibleName", "methodCallback", "methodMin", "methodMax", "methodFee", "methodBonusPercentage", "methodBonusStartAmount", "methodCurrency", "methodStatus", "methodExtras", "methodPosition", "methodInstructions") VALUES
(1, 'PayTM Checkout', 'https://i.ibb.co/0VNTSLb/pngegg-2.png', 'PayTM Checkout', 'payTMCheckout', 1, 100000, 0, 0, 0, 'INR', '0', '{\"merchantId\":\"\",\"merchantKey\":\"\"}', 2, ''),
(2, 'PayTM Merchant', 'https://i.ibb.co/G0PxyPm/paytmpaymentgateway-3257-logo-1597644450-ayat1.png', 'PayTM Merchant', 'payTMMerchant', 1, 10000, 0, 0, 0, 'INR', '1', '{\"merchantId\":\"\"}', 1, '&lt;p&gt;&lt;strong class=&quot;ql-size-large&quot; style=&quot;background-color: rgb(230, 0, 0); color: rgb(255, 255, 0);&quot;&gt;&lt;em&gt;Paytm and Phone Pe only&lt;/em&gt;&lt;/strong&gt;&lt;/p&gt;'),
(3, 'Perfect Money', 'https://excelcdn.in/smm/admin/images/payment-methods/perfect-money.png', 'Perfect Money', 'perfectMoney', 10, 1000, 3, 0, 0, 'USD', '1', '{\"accountNumber\":\"\",\"alternatePassPhrase\":\"\"}', 3, ''),
(4, 'Coinbase Commerce', 'https://excelcdn.in/smm/admin/images/payment-methods/coinbase-commerce.png', 'Coinbase Commerce', 'coinbaseCommerce', 1, 1000, 0, 0, 0, 'USD', '0', '{\"APIKey\":\"\"}', 4, NULL),
(5, 'Kashier', 'https://excelcdn.in/smm/admin/images/payment-methods/kashier.png', 'Kashier', 'kashier', 1, 1000, 0, 0, 0, 'USD', '0', '{\"MID\":\"\",\"APIKey\":\"\",\"mode\":\"live\"}', 5, NULL),
(6, 'Razorpay', 'https://excelcdn.in/smm/admin/images/payment-methods/razorpay.png', 'Razorpay', 'razorPay', 1, 10000, 0, 0, 0, 'INR', '0', '{\"APIPublicKey\":\"\",\"APISecretKey\":\"\",\"gatewayThemeColour\":\"\"}', 6, NULL),
(7, 'PhonePe (Automatic)', 'https://excelcdn.in/smm/admin/images/payment-methods/phonepe.png', 'PhonePe (Automatic)', 'phonepe', 1, 10000, 0, 0, 0, 'INR', '1', '{\"email\":\"\",\"password\":\"\"}', 7, ''),
(8, 'Easypaisa (Automatic)', 'https://excelcdn.in/smm/admin/images/payment-methods/easypaisa.png', 'Easypaisa (Automatic)', 'easypaisa', 1, 50000, 0, 0, 0, 'PKR', '0', '{\"email\":\"\",\"password\":\"\",\"senderEmail\":\"\",\"emailSubject\":\"easypaisa\"}', 8, NULL),
(9, 'Jazzcash (Automatic)', 'https://excelcdn.in/smm/admin/images/payment-methods/jazzcash.png', 'Jazzcash (Automatic)', 'jazzcash', 1, 50000, 0, 0, 0, 'PKR', '0', '{\"email\":\"\",\"password\":\"\",\"senderEmail\":\"\",\"emailSubject\":\"jazzcash\"}', 9, NULL),
(10, 'Instamojo', 'https://excelcdn.in/smm/admin/images/payment-methods/instamojo.jpg', 'Instamojo', 'instamojo', 1, 1000, 0, 0, 0, 'INR', '0', '{\"APIKey\":\"\",\"authToken\":\"\"}', 10, NULL),
(11, 'Cashmaal', 'https://excelcdn.in/smm/admin/images/payment-methods/cashmaal.png', 'Cashmaal', 'cashmaal', 1, 50000, 0, 0, 0, 'PKR', '0', '{\"webId\":\"\"}', 11, NULL),
(12, 'Alipay', 'https://excelcdn.in/smm/admin/images/payment-methods/alipay.png', 'Alipay', 'alipay', 1, 10000, 0, 0, 0, 'USD', '0', '{\"partnerId\":\"\",\"privateKey\":\"\"}', 12, NULL),
(13, 'PayU', 'https://excelcdn.in/smm/admin/images/payment-methods/payu.png', 'PayU', 'payU', 1, 10000, 0, 0, 0, 'INR', '0', '{\"merchantKey\":\"\",\"merchantSalt\":\"\"}', 13, NULL),
(14, 'UpiApi', 'https://excelcdn.in/smm/admin/images/payment-methods/upiapi.png', 'UpiApi', 'upiapi', 1, 10000, 0, 0, 0, 'INR', '1', '{\"productionAPIToken\":\"\",\"productionAPISecretKey\":\"\"}', 2, ''),
(15, 'Opay Express Checkout', 'https://excelcdn.in/smm/admin/images/payment-methods/opay.png', 'Opay Express Checkout', 'opay', 1, 10000, 0, 0, 0, 'USD', '0', '{\"merchantId\":\"\",\"publicKey\":\"\",\"secretKey\":\"\"}', 3, ''),
(16, 'Flutterwave', 'https://excelcdn.in/smm/admin/images/payment-methods/flutterwave.png', 'Flutterwave', 'flutterwave', 1, 1000, 0, 0, 0, 'USD', '0', '{\"secretKey\":\"\"}', 3, ''),
(17, 'Stripe', 'https://excelcdn.in/smm/admin/images/payment-methods/stripe.png', 'Stripe', 'stripe', 1, 1000, 0, 0, 0, 'USD', '0', '{\"publishableKey\":\"\",\"secretKey\":\"\"}', 1, ''),
(18, 'Payeer', 'https://excelcdn.in/smm/admin/images/payment-methods/payeer.png', 'Payeer', 'payeer', 1, 1000, 0, 0, 0, 'USD', '0', '{\"shopId\":\"\",\"secretKey\":\"\"}', 1, ''),
(100, 'Manual One', 'https://excelcdn.in/smm/admin/images/payment-methods/manual.jpg', 'Manual One', NULL, 1, 1, 0, 0, 0, NULL, '0', NULL, 2, NULL),
(101, 'Manual Two', 'https://excelcdn.in/smm/admin/images/payment-methods/manual.jpg', 'Manual Two', NULL, 1, 1, 0, 0, 0, NULL, '0', NULL, 3, NULL),
(102, 'Manual Three', 'https://excelcdn.in/smm/admin/images/payment-methods/manual.jpg', 'Manual Three', NULL, 1, 1, 0, 0, 0, NULL, '0', NULL, 4, NULL),
(103, 'Manual Four', 'https://excelcdn.in/smm/admin/images/payment-methods/manual.jpg', 'Manual Four', NULL, 1, 1, 0, 0, 0, NULL, '0', NULL, 2, NULL),
(104, 'Manual Five', 'https://excelcdn.in/smm/admin/images/payment-methods/manual.jpg', 'Manual Five', NULL, 1, 1, 0, 0, 0, NULL, '0', NULL, 18, NULL),
(105, 'Manual Six', 'https://excelcdn.in/smm/admin/images/payment-methods/manual.jpg', 'Manual Six', NULL, 1, 1, 0, 0, 0, NULL, '0', NULL, 19, NULL),
(106, 'Manual Seven', 'https://excelcdn.in/smm/admin/images/payment-methods/manual.jpg', 'Manual Seven', NULL, 1, 1, 0, 0, 0, NULL, '0', NULL, 20, NULL),
(107, 'Manual Eight', 'https://excelcdn.in/smm/admin/images/payment-methods/manual.jpg', 'Manual Eight', NULL, 1, 1, 0, 0, 0, NULL, '0', NULL, 21, NULL),
(108, 'Manual Nine', 'https://excelcdn.in/smm/admin/images/payment-methods/manual.jpg', 'Manual Nine', NULL, 1, 1, 0, 0, 0, NULL, '0', NULL, 22, NULL),
(109, 'Manual Ten', 'https://excelcdn.in/smm/admin/images/payment-methods/manual.jpg', 'Manual Ten', NULL, 1, 1, 0, 0, 0, NULL, '0', NULL, 23, NULL);

-- --------------------------------------------------------

--
-- Table structure for table "payments"
--

CREATE TABLE "payments" (
  "payment_id" INTEGER NOT NULL,
  "client_id" INTEGER NOT NULL,
  "client_balance" decimal(15,2) NOT NULL DEFAULT 0.00,
  "payment_amount" decimal(15,4) NOT NULL,
  "payment_privatecode" DOUBLE PRECISION DEFAULT NULL,
  "payment_method" INTEGER NOT NULL,
  "payment_status" VARCHAR(50) NOT NULL DEFAULT '1',
  "payment_delivery" VARCHAR(50) NOT NULL DEFAULT '1',
  "payment_note" varchar(255) NOT NULL DEFAULT 'No',
  "payment_mode" VARCHAR(50) NOT NULL DEFAULT 'Automatic',
  "payment_create_date" TIMESTAMP NOT NULL,
  "payment_update_date" TIMESTAMP NOT NULL,
  "payment_ip" varchar(225) NOT NULL,
  "payment_extra" text NOT NULL,
  "payment_bank" INTEGER NOT NULL,
  "t_id" varchar(255) DEFAULT NULL
);

--
-- Dumping data for table "payments"
--

INSERT INTO "payments" ("payment_id", "client_id", "client_balance", "payment_amount", "payment_privatecode", "payment_method", "payment_status", "payment_delivery", "payment_note", "payment_mode", "payment_create_date", "payment_update_date", "payment_ip", "payment_extra", "payment_bank", "t_id") VALUES
(1, 1, 46.26, 10.0000, NULL, 1, '3', '2', 'No', 'Manual', '2023-09-07 05:02:12', NULL, '27.57.99.60', '', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table "referral"
--

CREATE TABLE "referral" (
  "referral_id" INTEGER NOT NULL,
  "referral_client_id" INTEGER NOT NULL,
  "referral_clicks" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "referral_sign_up" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "referral_totalFunds_byReffered" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "referral_earned_commision" DOUBLE PRECISION DEFAULT 0,
  "referral_requested_commision" varchar(225) DEFAULT '0',
  "referral_total_commision" DOUBLE PRECISION DEFAULT 0,
  "referral_status" VARCHAR(50) NOT NULL DEFAULT '1',
  "referral_code" text NOT NULL,
  "referral_rejected_commision" DOUBLE PRECISION NOT NULL
);

--
-- Dumping data for table "referral"
--

INSERT INTO "referral" ("referral_id", "referral_client_id", "referral_clicks", "referral_sign_up", "referral_totalFunds_byReffered", "referral_earned_commision", "referral_requested_commision", "referral_total_commision", "referral_status", "referral_code", "referral_rejected_commision") VALUES
(1, 1, 0, 0, 0, 0, '0', 0, '1', '612682', 0);

-- --------------------------------------------------------

--
-- Table structure for table "referral_payouts"
--

CREATE TABLE "referral_payouts" (
  "r_p_id" INTEGER NOT NULL,
  "r_p_code" text NOT NULL,
  "r_p_status" VARCHAR(50) NOT NULL DEFAULT '0',
  "r_p_amount_requested" DOUBLE PRECISION NOT NULL,
  "r_p_requested_at" TIMESTAMP NOT NULL,
  "r_p_updated_at" TIMESTAMP NOT NULL,
  "client_id" INTEGER NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "serviceapi_alert"
--

CREATE TABLE "serviceapi_alert" (
  "id" INTEGER NOT NULL,
  "service_id" INTEGER NOT NULL,
  "serviceapi_alert" text NOT NULL,
  "servicealert_extra" text NOT NULL,
  "servicealert_date" TIMESTAMP NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "services"
--

CREATE TABLE "services" (
  "service_id" INTEGER NOT NULL,
  "service_api" INTEGER NOT NULL DEFAULT 0,
  "api_service" INTEGER NOT NULL DEFAULT 0,
  "api_servicetype" VARCHAR(50) NOT NULL DEFAULT '2',
  "api_detail" text NOT NULL,
  "category_id" INTEGER NOT NULL,
  "service_line" DOUBLE PRECISION NOT NULL,
  "service_type" VARCHAR(50) NOT NULL DEFAULT '2',
  "service_package" VARCHAR(50) NOT NULL,
  "service_name" text NOT NULL,
  "service_description" TEXT DEFAULT NULL,
  "service_price" varchar(225) NOT NULL,
  "service_min" DOUBLE PRECISION NOT NULL,
  "service_max" DOUBLE PRECISION NOT NULL,
  "service_dripfeed" VARCHAR(50) NOT NULL DEFAULT '1',
  "service_autotime" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "service_autopost" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "service_speed" VARCHAR(50) NOT NULL,
  "want_username" VARCHAR(50) NOT NULL DEFAULT '1',
  "service_secret" VARCHAR(50) NOT NULL DEFAULT '2',
  "price_type" VARCHAR(50) NOT NULL DEFAULT 'normal',
  "price_cal" text DEFAULT NULL,
  "instagram_second" VARCHAR(50) NOT NULL DEFAULT '2',
  "start_count" VARCHAR(50) NOT NULL,
  "instagram_private" VARCHAR(50) NOT NULL,
  "name_lang" TEXT DEFAULT NULL,
  "description_lang" TEXT DEFAULT NULL,
  "time_lang" varchar(225) NOT NULL DEFAULT 'Not enough data',
  "time" varchar(225) NOT NULL DEFAULT 'Not enough data',
  "cancelbutton" VARCHAR(50) NOT NULL DEFAULT '2',
  "show_refill" VARCHAR(50) NOT NULL DEFAULT 'false',
  "service_profit" varchar(225) NOT NULL,
  "refill_days" varchar(225) NOT NULL DEFAULT '30',
  "refill_hours" varchar(225) NOT NULL DEFAULT '24',
  "avg_days" INTEGER NOT NULL,
  "avg_hours" INTEGER NOT NULL,
  "avg_minutes" INTEGER NOT NULL,
  "avg_many" INTEGER NOT NULL,
  "price_profit" INTEGER NOT NULL,
  "service_overflow" INTEGER NOT NULL DEFAULT 0,
  "service_sync" VARCHAR(50) NOT NULL DEFAULT '1',
  "service_deleted" VARCHAR(50) NOT NULL DEFAULT '0'
);

-- --------------------------------------------------------

--
-- Table structure for table "service_api"
--

CREATE TABLE "service_api" (
  "id" INTEGER NOT NULL,
  "api_name" varchar(225) NOT NULL,
  "api_url" text NOT NULL,
  "api_key" varchar(225) NOT NULL,
  "api_type" INTEGER NOT NULL,
  "api_limit" DOUBLE PRECISION NOT NULL DEFAULT 0,
  "currency" varchar(200) DEFAULT NULL,
  "api_alert" VARCHAR(50) NOT NULL DEFAULT '2',
  "status" VARCHAR(50) NOT NULL DEFAULT '2',
  "api_sync" VARCHAR(50) NOT NULL DEFAULT '1',
  "api_login_credentials" varchar(255) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "settings"
--

CREATE TABLE "settings" (
  "id" INTEGER NOT NULL,
  "site_seo" text NOT NULL,
  "site_title" text DEFAULT NULL,
  "site_description" text DEFAULT NULL,
  "site_keywords" text DEFAULT NULL,
  "site_logo" text DEFAULT NULL,
  "site_name" text DEFAULT NULL,
  "site_currency" varchar(2555) NOT NULL DEFAULT 'try',
  "site_base_currency" varchar(20) DEFAULT NULL,
  "site_currency_converter" SMALLINT NOT NULL DEFAULT 0,
  "site_update_rates_automatically" INTEGER NOT NULL DEFAULT 0,
  "last_updated_currency_rates" TIMESTAMP DEFAULT NULL,
  "favicon" text DEFAULT NULL,
  "site_language" varchar(225) NOT NULL DEFAULT 'tr',
  "site_theme" text NOT NULL,
  "site_theme_alt" text DEFAULT NULL,
  "recaptcha" VARCHAR(50) NOT NULL DEFAULT '1',
  "recaptcha_key" text DEFAULT NULL,
  "recaptcha_secret" text DEFAULT NULL,
  "custom_header" text DEFAULT NULL,
  "custom_footer" text DEFAULT NULL,
  "ticket_system" VARCHAR(50) NOT NULL DEFAULT '2',
  "register_page" VARCHAR(50) NOT NULL DEFAULT '2',
  "service_speed" VARCHAR(50) NOT NULL,
  "service_list" VARCHAR(50) NOT NULL,
  "dolar_charge" DOUBLE PRECISION NOT NULL,
  "euro_charge" DOUBLE PRECISION NOT NULL,
  "smtp_user" text NOT NULL,
  "smtp_pass" text NOT NULL,
  "smtp_server" text NOT NULL,
  "smtp_port" varchar(225) NOT NULL,
  "smtp_protocol" VARCHAR(50) NOT NULL,
  "alert_type" VARCHAR(50) NOT NULL,
  "alert_apimail" VARCHAR(50) NOT NULL,
  "alert_newmanuelservice" VARCHAR(50) NOT NULL,
  "alert_newticket" VARCHAR(50) NOT NULL,
  "alert_apibalance" VARCHAR(50) NOT NULL,
  "alert_serviceapialert" VARCHAR(50) NOT NULL,
  "sms_provider" varchar(225) NOT NULL,
  "sms_title" varchar(225) NOT NULL,
  "sms_user" varchar(225) NOT NULL,
  "sms_pass" varchar(225) NOT NULL,
  "sms_validate" VARCHAR(50) NOT NULL DEFAULT '0',
  "admin_mail" varchar(225) NOT NULL,
  "admin_telephone" varchar(225) NOT NULL,
  "resetpass_page" VARCHAR(50) NOT NULL,
  "resetpass_sms" VARCHAR(50) NOT NULL,
  "resetpass_email" VARCHAR(50) NOT NULL,
  "site_maintenance" VARCHAR(50) NOT NULL DEFAULT '2',
  "servis_siralama" varchar(255) NOT NULL,
  "bronz_statu" INTEGER NOT NULL,
  "silver_statu" INTEGER NOT NULL,
  "gold_statu" INTEGER NOT NULL,
  "bayi_statu" INTEGER NOT NULL,
  "child_panel_nameservers" varchar(255) NOT NULL DEFAULT '{"ns1":"ns1.scriptlux.com","ns2":"ns2.scriptlux.com"}',
  "childpanel_price" DOUBLE PRECISION DEFAULT NULL,
  "snow_effect" VARCHAR(50) NOT NULL DEFAULT '2',
  "snow_colour" text NOT NULL,
  "promotion" VARCHAR(50) DEFAULT '2',
  "referral_commision" DOUBLE PRECISION NOT NULL,
  "referral_payout" DOUBLE PRECISION NOT NULL,
  "referral_status" VARCHAR(50) NOT NULL DEFAULT '1',
  "childpanel_selling" VARCHAR(50) NOT NULL DEFAULT '1',
  "tickets_per_user" DOUBLE PRECISION NOT NULL DEFAULT 5,
  "name_fileds" VARCHAR(50) NOT NULL DEFAULT '1',
  "skype_feilds" VARCHAR(50) NOT NULL DEFAULT '1',
  "otp_login" VARCHAR(50) NOT NULL DEFAULT '0',
  "auto_deactivate_payment" VARCHAR(50) NOT NULL DEFAULT '1',
  "service_avg_time" VARCHAR(50) NOT NULL DEFAULT '0',
  "alert_orderfail" VARCHAR(50) NOT NULL DEFAULT '2',
  "alert_welcomemail" VARCHAR(50) NOT NULL DEFAULT '2',
  "freebalance" VARCHAR(50) NOT NULL DEFAULT '1',
  "freeamount" DOUBLE PRECISION DEFAULT 0,
  "alert_newmessage" VARCHAR(50) NOT NULL DEFAULT '1',
  "email_confirmation" VARCHAR(50) NOT NULL DEFAULT '2',
  "resend_max" INTEGER NOT NULL,
  "status" varchar(255) NOT NULL DEFAULT '1',
  "fundstransfer_fees" varchar(10) NOT NULL,
  "permissions" text DEFAULT NULL,
  "fake_order_service_enabled" SMALLINT NOT NULL DEFAULT 0,
  "fake_order_min" INTEGER DEFAULT NULL,
  "fake_order_max" INTEGER DEFAULT NULL,
  "panel_orders" INTEGER DEFAULT NULL,
  "panel_orders_pattern" varchar(255) NOT NULL DEFAULT '{"panel_orders_prefix":"","panel_orders_suffix":""}',
  "downloaded_category_icons" SMALLINT NOT NULL DEFAULT 0,
  "summary_card_background_color" varchar(100) DEFAULT 'theme_colour',
  "google_login" varchar(100) NOT NULL DEFAULT '{"purchased":"1","status":"1"}',
  "services_average_time" SMALLINT NOT NULL DEFAULT 1
);

--
-- Dumping data for table "settings"
--

INSERT INTO "settings" ("id", "site_seo", "site_title", "site_description", "site_keywords", "site_logo", "site_name", "site_currency", "site_base_currency", "site_currency_converter", "site_update_rates_automatically", "last_updated_currency_rates", "favicon", "site_language", "site_theme", "site_theme_alt", "recaptcha", "recaptcha_key", "recaptcha_secret", "custom_header", "custom_footer", "ticket_system", "register_page", "service_speed", "service_list", "dolar_charge", "euro_charge", "smtp_user", "smtp_pass", "smtp_server", "smtp_port", "smtp_protocol", "alert_type", "alert_apimail", "alert_newmanuelservice", "alert_newticket", "alert_apibalance", "alert_serviceapialert", "sms_provider", "sms_title", "sms_user", "sms_pass", "sms_validate", "admin_mail", "admin_telephone", "resetpass_page", "resetpass_sms", "resetpass_email", "site_maintenance", "servis_siralama", "bronz_statu", "silver_statu", "gold_statu", "bayi_statu", "child_panel_nameservers", "childpanel_price", "snow_effect", "snow_colour", "promotion", "referral_commision", "referral_payout", "referral_status", "childpanel_selling", "tickets_per_user", "name_fileds", "skype_feilds", "otp_login", "auto_deactivate_payment", "service_avg_time", "alert_orderfail", "alert_welcomemail", "freebalance", "freeamount", "alert_newmessage", "email_confirmation", "resend_max", "status", "fundstransfer_fees", "permissions", "fake_order_service_enabled", "fake_order_min", "fake_order_max", "panel_orders", "panel_orders_pattern", "downloaded_category_icons", "summary_card_background_color", "google_login", "services_average_time") VALUES
(1, '', '', '', '', '', '', '', 'INR', 1, 1, '2023-09-18 11:22:01', '', 'en', 'modified', 'pink', '1', '', '', '', '', '1', '2', '1', '2', 0, 0, '', '', '', '', '0', '2', '2', '2', '2', '2', '2', 'bizimsms', '', '', '', '1', '', '', '2', '1', '2', '2', 'asc', 500, 2500, 10000, 15000, '{\"ns1\":\"ns1.scriptlux.com\",\"ns2\":\"ns2.scriptlux.com\"}', 100, '', '', '2', 10, 10, '2', '2', 9999999999, '2', '2', '0', '1', '1', '2', '2', '1', 2, '2', '2', 2, '0', '3', '{\"admin access\":{\"admin_access\":{\"name\":\"Admin Access\",\"value\":\"admin_access\"}},\"pages\":{\"users\":{\"name\":\"Users\",\"value\":\"users\"},\"services\":{\"name\":\"Services\",\"value\":\"services\"},\"update-prices\":{\"name\":\"Update Prices\",\"value\":\"update-prices\"},\"bulk\":{\"name\":\"Bulk Services Editor\",\"value\":\"bulk\"},\"bulkc\":{\"name\":\"Bulk Category Editor\",\"value\":\"services\"},\"synced-logs\":{\"name\":\"Seller Sync Logs\",\"value\":\"synced-logs\"},\"orders\":{\"name\":\"Orders\",\"value\":\"orders\"},\"subscriptions\":{\"name\":\"Subscriptions\",\"value\":\"subscriptions\"},\"dripfeed\":{\"name\":\"Dripfeed\",\"value\":\"dripfeed\"},\"tasks\":{\"name\":\"Order Refill and Cancel Tasks\",\"value\":\"tasks\"},\"payments\":{\"name\":\"Payments\",\"value\":\"payments\"},\"tickets\":{\"name\":\"Tickets\",\"value\":\"tickets\"}},\"additionals\":{\"additionals\":{\"name\":\"Additionals\",\"value\":\"additionals\"},\"referral\":{\"name\":\"Affiliates\",\"value\":\"referral\"},\"broadcast\":{\"name\":\"Broadcasts\",\"value\":\"broadcast\"},\"logs\":{\"name\":\"Panel Logs\",\"value\":\"logs\"},\"reports\":{\"name\":\"Reports\",\"value\":\"reports\"},\"videop\":{\"name\":\"Promotion\",\"value\":\"videop\"},\"coupon\":{\"name\":\"Coupons\",\"value\":\"coupon\"},\"child-panels\":{\"name\":\"Child Panels\",\"value\":\"child-panels\"},\"updates\":{\"name\":\"Updates\",\"value\":\"updates\"}},\"appearance\":{\"appearance\":{\"name\":\"Appearance\",\"value\":\"appearance\"},\"themes\":{\"name\":\"Themes\",\"value\":\"themes\"},\"new_year\":{\"name\":\"New Year\",\"value\":\"new_year\"},\"pages\":{\"name\":\"Pages\",\"value\":\"pages\"},\"news\":{\"name\":\"Announcements\",\"value\":\"news\"},\"meta\":{\"name\":\"Meta (SEO) Settings\",\"value\":\"meta\"},\"blog\":{\"name\":\"Blogs\",\"value\":\"blog\"},\"menu\":{\"name\":\"Menu\",\"value\":\"menu\"},\"inte\":{\"name\":\"Integrations\",\"value\":\"inte\"},\"language\":{\"name\":\"Languages\",\"value\":\"language\"},\"files\":{\"name\":\"Uploaded Images\",\"value\":\"files\"}},\"settings\":{\"settings\":{\"name\":\"Settings\",\"value\":\"settings\"},\"general_settings\":{\"name\":\"General Settings\",\"value\":\"general_settings\"},\"providers\":{\"name\":\"Sellers\",\"value\":\"providers\"},\"payments_settings\":{\"name\":\"Payment Methods\",\"value\":\"payments_settings\"},\"bank_accounts\":{\"name\":\"Bank Accounts\",\"value\":\"bank_accounts\"},\"modules\":{\"name\":\"Modules\",\"value\":\"modules\"},\"subject\":{\"name\":\"Support Settings\",\"value\":\"subject\"},\"payments_bonus\":{\"name\":\"Payment Bonuses\",\"value\":\"payments_bonus\"},\"currency-manager\":{\"name\":\"Site Currency Manager\",\"value\":\"currency-manager\"},\"alert_settings\":{\"name\":\"Notification Settings\",\"value\":\"alert_settings\"},\"site_count\":{\"name\":\"Fake Orders\",\"value\":\"site_count\"},\"manager\":{\"name\":\"Manager\",\"value\":\"manager\"}}}', 0, 1, 3, 3, '{\"panel_orders_prefix\":\"\",\"panel_orders_suffix\":\"\"}', 0, 'fixed_colour', '{\"purchased\":\"1\",\"status\":\"1\"}', 0);

-- --------------------------------------------------------

--
-- Table structure for table "sync_logs"
--

CREATE TABLE "sync_logs" (
  "id" INTEGER NOT NULL,
  "service_id" INTEGER NOT NULL,
  "action" varchar(225) NOT NULL,
  "date" TIMESTAMP NOT NULL,
  "description" varchar(225) NOT NULL,
  "api_id" INTEGER NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "tasks"
--

CREATE TABLE "tasks" (
  "task_id" INTEGER NOT NULL,
  "client_id" INTEGER DEFAULT NULL,
  "order_id" INTEGER DEFAULT NULL,
  "service_id" INTEGER DEFAULT NULL,
  "task_api" INTEGER DEFAULT NULL,
  "task_type" varchar(225) DEFAULT NULL,
  "task_status" varchar(225) DEFAULT 'pending',
  "task_response" text DEFAULT NULL,
  "task_created_at" TIMESTAMP DEFAULT NULL,
  "task_updated_at" TIMESTAMP DEFAULT NULL,
  "task_by" text DEFAULT NULL,
  "check_refill_status" INTEGER DEFAULT NULL,
  "refill_orderid" varchar(225) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "themes"
--

CREATE TABLE "themes" (
  "id" INTEGER NOT NULL,
  "theme_name" text NOT NULL,
  "theme_dirname" text NOT NULL,
  "theme_extras" text NOT NULL,
  "last_modified" TIMESTAMP NOT NULL,
  "newpage" text NOT NULL,
  "colour" VARCHAR(50) NOT NULL DEFAULT '1'
);

--
-- Dumping data for table "themes"
--

INSERT INTO "themes" ("id", "theme_name", "theme_dirname", "theme_extras", "last_modified", "newpage", "colour") VALUES
(5, 'Super Rental panel', 'modified', '', '2023-11-07 09:29:47', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table "tickets"
--

CREATE TABLE "tickets" (
  "ticket_id" INTEGER NOT NULL,
  "client_id" INTEGER NOT NULL,
  "subject" varchar(225) NOT NULL,
  "time" TIMESTAMP NOT NULL,
  "lastupdate_time" TIMESTAMP NOT NULL,
  "client_new" VARCHAR(50) NOT NULL DEFAULT '2',
  "status" VARCHAR(50) NOT NULL DEFAULT 'pending',
  "support_new" VARCHAR(50) NOT NULL DEFAULT '1',
  "canmessage" VARCHAR(50) NOT NULL DEFAULT '2'
);

-- --------------------------------------------------------

--
-- Table structure for table "ticket_reply"
--

CREATE TABLE "ticket_reply" (
  "id" INTEGER NOT NULL,
  "ticket_id" INTEGER NOT NULL,
  "client_id" INTEGER NOT NULL,
  "time" TIMESTAMP NOT NULL,
  "support" VARCHAR(50) NOT NULL DEFAULT '1',
  "message" text NOT NULL,
  "readed" VARCHAR(50) NOT NULL DEFAULT '1'
);

-- --------------------------------------------------------

--
-- Table structure for table "ticket_subjects"
--

CREATE TABLE "ticket_subjects" (
  "subject_id" INTEGER NOT NULL,
  "subject" varchar(225) NOT NULL,
  "content" text DEFAULT NULL,
  "auto_reply" VARCHAR(50) NOT NULL DEFAULT '0'
);

--
-- Dumping data for table "ticket_subjects"
--

INSERT INTO "ticket_subjects" ("subject_id", "subject", "content", "auto_reply") VALUES
(1, 'Order', '', '0'),
(2, 'Payment', '', '0'),
(4, 'Complaint & Suggestion', '', '0'),
(6, 'Others', 'You will be answered within minutes', '1');

-- --------------------------------------------------------

--
-- Table structure for table "units_per_page"
--

CREATE TABLE "units_per_page" (
  "id" INTEGER NOT NULL,
  "unit" INTEGER NOT NULL,
  "page" text NOT NULL
);

--
-- Dumping data for table "units_per_page"
--

INSERT INTO "units_per_page" ("id", "unit", "page") VALUES
(1, 50, 'clients'),
(2, 50, 'orders'),
(3, 50, 'payments'),
(4, 50, 'refill'),
(5, 50, 'bulk'),
(6, 8, 'services');

-- --------------------------------------------------------

--
-- Table structure for table "updates"
--

CREATE TABLE "updates" (
  "u_id" INTEGER NOT NULL,
  "service_id" INTEGER NOT NULL,
  "action" varchar(225) NOT NULL,
  "date" TIMESTAMP NOT NULL,
  "description" varchar(225) NOT NULL DEFAULT 'Not enough data'
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table "admins"
--
ALTER TABLE "admins"
  ADD PRIMARY KEY ("admin_id");

--
-- Indexes for table "admin_constants"
--
ALTER TABLE "admin_constants"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "article"
--
ALTER TABLE "article"
  ADD PRIMARY KEY ("id"),

--
-- Indexes for table "bank_accounts"
--
ALTER TABLE "bank_accounts"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "blogs"
--
ALTER TABLE "blogs"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "bulkedit"
--
ALTER TABLE "bulkedit"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "categories"
--
ALTER TABLE "categories"
  ADD PRIMARY KEY ("category_id");

--
-- Indexes for table "childpanels"
--
ALTER TABLE "childpanels"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "clients"
--
ALTER TABLE "clients"
  ADD PRIMARY KEY ("client_id");

--
-- Indexes for table "clients_category"
--
ALTER TABLE "clients_category"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "clients_price"
--
ALTER TABLE "clients_price"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "clients_service"
--
ALTER TABLE "clients_service"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "client_report"
--
ALTER TABLE "client_report"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "currencies"
--
ALTER TABLE "currencies"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "decoration"
--
ALTER TABLE "decoration"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "earn"
--
ALTER TABLE "earn"
  ADD PRIMARY KEY ("earn_id");

--
-- Indexes for table "files"
--
ALTER TABLE "files"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "General_options"
--
ALTER TABLE "General_options"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "integrations"
--
ALTER TABLE "integrations"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "kuponlar"
--
ALTER TABLE "kuponlar"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "kupon_kullananlar"
--
ALTER TABLE "kupon_kullananlar"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "languages"
--
ALTER TABLE "languages"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "Mailforms"
--
ALTER TABLE "Mailforms"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "menus"
--
ALTER TABLE "menus"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "news"
--
ALTER TABLE "news"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "notifications_popup"
--
ALTER TABLE "notifications_popup"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "orders"
--
ALTER TABLE "orders"
  ADD PRIMARY KEY ("order_id"),

--
-- Indexes for table "pages"
--
ALTER TABLE "pages"
  ADD PRIMARY KEY ("page_id");

--
-- Indexes for table "panel_categories"
--
ALTER TABLE "panel_categories"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "panel_info"
--
ALTER TABLE "panel_info"
  ADD PRIMARY KEY ("panel_id");

--
-- Indexes for table "paymentmethods"
--
ALTER TABLE "paymentmethods"
  ADD PRIMARY KEY ("methodId"),

--
-- Indexes for table "payments"
--
ALTER TABLE "payments"
  ADD PRIMARY KEY ("payment_id");

--
-- Indexes for table "referral"
--
ALTER TABLE "referral"
  ADD PRIMARY KEY ("referral_id");

--
-- Indexes for table "referral_payouts"
--
ALTER TABLE "referral_payouts"
  ADD PRIMARY KEY ("r_p_id");

--
-- Indexes for table "serviceapi_alert"
--
ALTER TABLE "serviceapi_alert"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "services"
--
ALTER TABLE "services"
  ADD PRIMARY KEY ("service_id");

--
-- Indexes for table "service_api"
--
ALTER TABLE "service_api"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "settings"
--
ALTER TABLE "settings"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "sync_logs"
--
ALTER TABLE "sync_logs"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "tasks"
--
ALTER TABLE "tasks"
  ADD PRIMARY KEY ("task_id");

--
-- Indexes for table "themes"
--
ALTER TABLE "themes"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "tickets"
--
ALTER TABLE "tickets"
  ADD PRIMARY KEY ("ticket_id");

--
-- Indexes for table "ticket_reply"
--
ALTER TABLE "ticket_reply"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "ticket_subjects"
--
ALTER TABLE "ticket_subjects"
  ADD PRIMARY KEY ("subject_id");

--
-- Indexes for table "units_per_page"
--
ALTER TABLE "units_per_page"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "updates"
--
ALTER TABLE "updates"
  ADD PRIMARY KEY ("u_id");

--
--  for dumped tables
--

--
--  for table "admins"
--
ALTER TABLE "admins"
  MODIFY "admin_id" INTEGER NOT NULL , =35;

--
--  for table "article"
--
ALTER TABLE "article"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "bank_accounts"
--
ALTER TABLE "bank_accounts"
  MODIFY "id" INTEGER NOT NULL , =2;

--
--  for table "blogs"
--
ALTER TABLE "blogs"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "bulkedit"
--
ALTER TABLE "bulkedit"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "categories"
--
ALTER TABLE "categories"
  MODIFY "category_id" INTEGER NOT NULL ;

--
--  for table "childpanels"
--
ALTER TABLE "childpanels"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "clients"
--
ALTER TABLE "clients"
  MODIFY "client_id" INTEGER NOT NULL ;

--
--  for table "clients_category"
--
ALTER TABLE "clients_category"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "clients_price"
--
ALTER TABLE "clients_price"
  MODIFY "id" INTEGER NOT NULL , =39;

--
--  for table "clients_service"
--
ALTER TABLE "clients_service"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "client_report"
--
ALTER TABLE "client_report"
  MODIFY "id" INTEGER NOT NULL , =15;

--
--  for table "currencies"
--
ALTER TABLE "currencies"
  MODIFY "id" INTEGER NOT NULL , =15;

--
--  for table "earn"
--
ALTER TABLE "earn"
  MODIFY "earn_id" INTEGER NOT NULL ;

--
--  for table "files"
--
ALTER TABLE "files"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "General_options"
--
ALTER TABLE "General_options"
  MODIFY "id" INTEGER NOT NULL , =2;

--
--  for table "integrations"
--
ALTER TABLE "integrations"
  MODIFY "id" INTEGER NOT NULL , =15;

--
--  for table "kuponlar"
--
ALTER TABLE "kuponlar"
  MODIFY "id" INTEGER NOT NULL , =2;

--
--  for table "kupon_kullananlar"
--
ALTER TABLE "kupon_kullananlar"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "languages"
--
ALTER TABLE "languages"
  MODIFY "id" INTEGER NOT NULL , =3;

--
--  for table "Mailforms"
--
ALTER TABLE "Mailforms"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "menus"
--
ALTER TABLE "menus"
  MODIFY "id" INTEGER NOT NULL , =36;

--
--  for table "news"
--
ALTER TABLE "news"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "notifications_popup"
--
ALTER TABLE "notifications_popup"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "orders"
--
ALTER TABLE "orders"
  MODIFY "order_id" INTEGER NOT NULL ;

--
--  for table "pages"
--
ALTER TABLE "pages"
  MODIFY "page_id" INTEGER NOT NULL , =913;

--
--  for table "panel_categories"
--
ALTER TABLE "panel_categories"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "panel_info"
--
ALTER TABLE "panel_info"
  MODIFY "panel_id" INTEGER NOT NULL , =2;

--
--  for table "paymentmethods"
--
ALTER TABLE "paymentmethods"
  MODIFY "methodId" INTEGER NOT NULL , =110;

--
--  for table "payments"
--
ALTER TABLE "payments"
  MODIFY "payment_id" INTEGER NOT NULL , =2;

--
--  for table "referral"
--
ALTER TABLE "referral"
  MODIFY "referral_id" INTEGER NOT NULL , =2;

--
--  for table "referral_payouts"
--
ALTER TABLE "referral_payouts"
  MODIFY "r_p_id" INTEGER NOT NULL ;

--
--  for table "serviceapi_alert"
--
ALTER TABLE "serviceapi_alert"
  MODIFY "id" INTEGER NOT NULL , =53367;

--
--  for table "services"
--
ALTER TABLE "services"
  MODIFY "service_id" INTEGER NOT NULL ;

--
--  for table "service_api"
--
ALTER TABLE "service_api"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "settings"
--
ALTER TABLE "settings"
  MODIFY "id" INTEGER NOT NULL , =2;

--
--  for table "sync_logs"
--
ALTER TABLE "sync_logs"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "tasks"
--
ALTER TABLE "tasks"
  MODIFY "task_id" INTEGER NOT NULL ;

--
--  for table "themes"
--
ALTER TABLE "themes"
  MODIFY "id" INTEGER NOT NULL , =8;

--
--  for table "tickets"
--
ALTER TABLE "tickets"
  MODIFY "ticket_id" INTEGER NOT NULL ;

--
--  for table "ticket_reply"
--
ALTER TABLE "ticket_reply"
  MODIFY "id" INTEGER NOT NULL ;

--
--  for table "ticket_subjects"
--
ALTER TABLE "ticket_subjects"
  MODIFY "subject_id" INTEGER NOT NULL , =7;

--
--  for table "units_per_page"
--
ALTER TABLE "units_per_page"
  MODIFY "id" INTEGER NOT NULL , =7;

--
--  for table "updates"
--
ALTER TABLE "updates"
  MODIFY "u_id" INTEGER NOT NULL ;
COMMIT;

;
;
;
