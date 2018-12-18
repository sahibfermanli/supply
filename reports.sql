-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 17, 2018 at 05:51 PM
-- Server version: 5.7.24-0ubuntu0.18.04.1-log
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reports`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(5) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `account_doc` varchar(255) DEFAULT NULL,
  `company_id` int(5) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_no`, `account_doc`, `company_id`, `deleted`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '12345678', '/uploads/files/accounts/account_12345678_PN83_0.83695100 1544701278.docx', 6, 0, NULL, '2018-12-13 14:41:01', '2018-12-17 12:19:03'),
(2, '5312012', '/uploads/files/accounts/account_5312012_pkyg.docx', 0, 1, '2018-12-13 14:46:31', '2018-12-13 14:45:16', '2018-12-13 14:46:31'),
(3, '5312012', '/uploads/files/accounts/account_5312012_I5k3_0.14526300 1544701302.docx', 5, 0, NULL, '2018-12-13 15:41:42', '2018-12-17 12:19:11'),
(4, '451155454', '/uploads/files/accounts/account_451155454_lFMF_0.44045700 1544788841.docx', 5, 1, '2018-12-17 12:19:24', '2018-12-14 16:00:41', '2018-12-17 12:19:24'),
(5, '000000000364-02.05.2018', '/uploads/files/accounts/account_000000000364-02.05.2018_XK0p_0.62752200 1544789049.docx', 5, 0, NULL, '2018-12-14 16:04:09', '2018-12-17 12:19:20');

-- --------------------------------------------------------

--
-- Table structure for table `authorities`
--

CREATE TABLE `authorities` (
  `id` int(11) NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime(3) DEFAULT NULL,
  `deleted_at` datetime(3) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `authorities`
--

INSERT INTO `authorities` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'Admin', '2018-10-12 11:37:03.017', '2018-10-12 11:38:38.993', NULL, 0),
(2, 'Rəhbər', '2018-10-12 11:39:07.137', '2018-10-12 12:16:57.257', '2018-10-12 12:16:57.253', 1),
(3, 'İstifadəçi', '2018-10-12 11:39:32.880', '2018-10-12 11:39:32.880', NULL, 0),
(4, 'Təchizatçı', '2018-10-12 11:39:46.707', '2018-10-12 11:39:46.707', NULL, 0),
(5, 'Direktor', '2018-10-12 11:41:13.770', '2018-10-12 11:41:13.770', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `zip_code` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `fax` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `local` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted` int(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `zip_code`, `phone`, `fax`, `local`, `created_at`, `updated_at`, `deleted`, `deleted_at`) VALUES
(1, 'SW GHC', 'Baku', 'AZ1104', '0777220075', '', 1, '2018-09-21 17:37:42', '2018-12-17 11:58:07', 1, '2018-12-17 11:58:07'),
(2, 'SW BCT', 'Baku', 'AZ1104', '0515534105', '', 1, '2018-09-21 17:39:44', '2018-12-17 11:52:29', 1, '2018-12-17 11:52:29'),
(5, 'Aktif elektrik MMC', 'Bakı şəhəri Nərimanov rayonu, Nəcəf Nərimanov, ev 5A, m. 25', 'AZ1106', '+994125649101', '+994125648734', 0, '2018-12-17 11:56:56', '2018-12-17 11:56:56', 0, NULL),
(6, 'SLA GROUP MMC', 'Bakı şəhəri Nərimanov rayonu, Nəcəf Nərimanov, ev 5A, m. 25', 'Az1000', '+994125649101', '+994125649101', 0, '2018-12-17 12:04:44', '2018-12-17 12:07:30', 0, NULL),
(7, 'vgf', 'hgfhgf', 'hgfg', 'gfhgh', 'hgjgj', 1, '2018-12-17 12:08:31', '2018-12-17 12:09:14', 1, '2018-12-17 12:09:14');

-- --------------------------------------------------------

--
-- Table structure for table `deadlines`
--

CREATE TABLE `deadlines` (
  `id` int(11) NOT NULL,
  `deadline` int(11) DEFAULT NULL,
  `color` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime(3) DEFAULT NULL,
  `deleted_at` datetime(3) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `deadlines`
--

INSERT INTO `deadlines` (`id`, `deadline`, `color`, `created_at`, `updated_at`, `deleted_at`, `deleted`, `type`) VALUES
(1, 15, 'green', '2018-10-16 17:28:37.453', '2018-10-16 17:40:52.397', NULL, 0, 0),
(2, 30, 'yellow', '2018-10-16 17:35:46.693', '2018-12-05 18:28:35.000', NULL, 0, 0),
(3, 45, 'red', '2018-10-16 17:41:39.137', '2018-10-16 17:41:46.270', NULL, 0, 0),
(4, 15, 'green', '2018-10-16 17:42:05.050', '2018-10-16 17:46:49.137', NULL, 0, 1),
(5, 60, 'yellow', '2018-10-16 17:46:59.203', '2018-10-16 17:46:59.203', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Departments`
--

CREATE TABLE `Departments` (
  `id` int(11) NOT NULL,
  `Department` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Company` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `edited_by` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `edited_date` datetime DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime(3) DEFAULT NULL,
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime(3) DEFAULT NULL,
  `authority_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Departments`
--

INSERT INTO `Departments` (`id`, `Department`, `Company`, `edited_by`, `edited_date`, `deleted`, `deleted_at`, `created_at`, `updated_at`, `authority_id`) VALUES
(6, 'Admin', 'SWGH', 'RaportUser', '2018-10-12 11:55:00', 0, NULL, '2018-10-12 11:53:33.903', '2018-10-12 11:53:33.903', 1),
(5, 'Rəhbərlik', 'SWGH', 'BCT\nbalayev', '2018-10-02 16:56:00', 0, NULL, '2018-10-02 16:54:33.623', '2018-11-14 12:21:17.000', 5),
(1, 'Əməliyyat məlumatlarının tətbiqi və mübadiləsi', 'SWGH', 'BCT\nbalayev', '2018-09-17 17:12:00', 0, NULL, NULL, '2018-11-14 12:21:29.000', 3),
(2, 'Xüsusi texnika və yerüstü xidmət avadanlıqları', 'SWGH', 'BCT\nbalayev', '2018-09-18 14:07:00', 0, NULL, NULL, '2018-11-14 12:22:12.000', 3),
(3, 'İstehsalatın planlaşdırılması və hüquqi məsələlələr', 'SWGH', 'BCT\nbalayev', '2018-09-18 14:10:00', 0, NULL, NULL, '2018-11-14 12:22:20.000', 3),
(4, 'Təchizat və logistika üzrə şöbə', 'SWGH', 'RaportUser', '2018-10-02 16:56:00', 0, NULL, '2018-10-02 16:54:33.623', '2018-11-14 12:22:04.000', 4),
(7, 'Perron xidmeti uzre departement', 'Silk way aviasirketini', NULL, NULL, 0, NULL, '2018-12-11 16:49:19.000', '2018-12-11 16:49:19.000', 3);

-- --------------------------------------------------------

--
-- Table structure for table `lb_Alternatives`
--

CREATE TABLE `lb_Alternatives` (
  `id` int(11) NOT NULL,
  `Brend` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Model` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `PartSerialNo` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `date` date DEFAULT NULL,
  `cost` decimal(18,2) DEFAULT NULL,
  `pcs` decimal(18,2) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `total_cost` decimal(18,2) GENERATED ALWAYS AS ((`cost` * `pcs`)) VIRTUAL,
  `Remark` varchar(4000) CHARACTER SET utf8 DEFAULT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `deleted` bit(1) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `store_type` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `DirectorRemark` varchar(4000) CHARACTER SET utf8 DEFAULT NULL,
  `confirm_chief` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AVG_ROW_LENGTH=97 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_Alternatives`
--

INSERT INTO `lb_Alternatives` (`id`, `Brend`, `Model`, `PartSerialNo`, `date`, `cost`, `pcs`, `unit_id`, `Remark`, `OrderID`, `deleted`, `deleted_at`, `created_at`, `updated_at`, `store_type`, `currency_id`, `country_id`, `company_id`, `DirectorRemark`, `confirm_chief`) VALUES
(1, 'marka', 'model', 'partno', '2018-11-13', '40.00', '4.00', 10, 'alinmali', 27, b'0', NULL, '2018-11-13 12:29:37', '2018-11-13 12:29:37', 'Bazar', 1, 15, 4, NULL, 0),
(2, 'qelem1', 'sdfds', 'dsf', '2016-03-22', '6.00', '5.00', 13, 'asdf', 44, b'0', NULL, '2018-12-04 19:21:00', '2018-12-12 15:13:19', 'Yerli', 3, 15, 2, NULL, 1),
(3, 'qelem2', 'sdfds', 'dsf', '2016-03-22', '6.00', '5.00', 13, 'asdf', 44, b'0', NULL, '2018-12-04 19:21:03', '2018-12-12 15:13:20', 'Yerli', 3, 15, 2, NULL, 1),
(4, 'qelem3', 'sdfds', 'dsf', '2016-03-22', '6.00', '5.00', 13, 'asdf', 44, b'0', NULL, '2018-12-04 19:21:06', '2018-12-12 15:13:21', 'Yerli', 3, 15, 2, NULL, 1),
(5, 'SPS-Adpt Ext Ac Norton-R 120Wt RT ANG con', 'Norton', '665470-001', '2018-11-12', '115.00', '1.00', 10, 'best comp', 64, b'0', NULL, '2018-12-11 16:59:06', '2018-12-11 17:00:10', 'Yerli', 2, 15, 2, NULL, 1),
(6, 'dell', 'dell', '665050', '2018-11-12', '200.00', '1.00', 10, 'dell', 64, b'0', NULL, '2018-12-11 16:59:42', '2018-12-11 17:00:43', 'Yerli', 2, 15, 1, NULL, 1),
(7, 'dell', 'dell', '56565005', '2018-12-12', '600.00', '1.00', 10, 'fdg', 62, b'0', NULL, '2018-12-11 17:15:43', '2018-12-11 17:16:10', 'Xarici', 2, 5, 1, NULL, 1),
(8, 'acerr', 'acerr', '56565005', '2018-12-12', '600.00', '1.00', 10, 'fdg', 62, b'0', NULL, '2018-12-11 17:15:51', '2018-12-11 17:16:09', 'Xarici', 2, 5, 1, NULL, 1),
(9, 'fdgff', 'gfhgfh', 'gfhgfh', '2018-02-05', '1.00', '5.00', 10, 'jhgj', 46, b'0', NULL, '2018-12-12 16:12:31', '2018-12-12 16:25:55', 'Yerli', 3, 15, 2, NULL, 0),
(10, 'ad1', 'gth', 'yth', '2018-02-05', '6.00', '5.00', 10, 'fgdgdf', 46, b'0', NULL, '2018-12-12 16:25:55', '2018-12-12 16:25:55', 'Yerli', 1, 15, 2, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lb_categories`
--

CREATE TABLE `lb_categories` (
  `id` int(11) NOT NULL,
  `process` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime(3) DEFAULT NULL,
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime(3) DEFAULT NULL,
  `ctgr` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
  `orders_count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_categories`
--

INSERT INTO `lb_categories` (`id`, `process`, `deleted`, `deleted_at`, `created_at`, `updated_at`, `ctgr`, `orders_count`) VALUES
(10, 'Təkər', 0, NULL, NULL, NULL, 'T', NULL),
(1, 'Xüsusi texnika', 0, NULL, NULL, NULL, 'XT', NULL),
(2, 'Xidməti', 0, NULL, NULL, NULL, 'X', NULL),
(3, 'Servis', 0, NULL, NULL, NULL, 'S', NULL),
(4, 'Məsrəf', 0, NULL, NULL, NULL, 'M', NULL),
(5, 'İnventar', 0, NULL, NULL, NULL, 'I', NULL),
(6, 'Akkumlyator', 0, NULL, NULL, NULL, 'A', NULL),
(7, 'Forma', 0, NULL, NULL, NULL, 'F', NULL),
(8, 'Dəftərxana', 0, NULL, NULL, NULL, 'D', NULL),
(9, 'Blank', 0, NULL, NULL, NULL, 'B', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lb_countries`
--

CREATE TABLE `lb_countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `country_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime(3) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_countries`
--

INSERT INTO `lb_countries` (`id`, `country_code`, `country_name`, `created_at`, `updated_at`, `deleted`, `deleted_at`) VALUES
(1, 'AF', 'Afghanistan', NULL, NULL, 0, NULL),
(2, 'AL', 'Albania', NULL, NULL, 0, NULL),
(3, 'DZ', 'Algeria', NULL, NULL, 0, NULL),
(4, 'DS', 'American Samoa', NULL, NULL, 0, NULL),
(5, 'AD', 'Andorra', NULL, NULL, 0, NULL),
(6, 'AO', 'Anla', NULL, NULL, 0, NULL),
(7, 'AI', 'Anguilla', NULL, NULL, 0, NULL),
(8, 'AQ', 'Antarctica', NULL, NULL, 0, NULL),
(9, 'AG', 'Antigua and Barbuda', NULL, NULL, 0, NULL),
(10, 'AR', 'Argentina', NULL, NULL, 0, NULL),
(11, 'AM', 'Armenia', NULL, NULL, 0, NULL),
(12, 'AW', 'Aruba', NULL, NULL, 0, NULL),
(13, 'AU', 'Australia', NULL, NULL, 0, NULL),
(14, 'AT', 'Austria', NULL, NULL, 0, NULL),
(15, 'AZ', 'Azerbaijan', NULL, NULL, 0, NULL),
(16, 'BS', 'Bahamas', NULL, NULL, 0, NULL),
(17, 'BH', 'Bahrain', NULL, NULL, 0, NULL),
(18, 'BD', 'Bangladesh', NULL, NULL, 0, NULL),
(19, 'BB', 'Barbados', NULL, NULL, 0, NULL),
(20, 'BY', 'Belarus', NULL, NULL, 0, NULL),
(21, 'BE', 'Belgium', NULL, NULL, 0, NULL),
(22, 'BZ', 'Belize', NULL, NULL, 0, NULL),
(23, 'BJ', 'Benin', NULL, NULL, 0, NULL),
(24, 'BM', 'Bermuda', NULL, NULL, 0, NULL),
(25, 'BT', 'Bhutan', NULL, NULL, 0, NULL),
(26, 'BO', 'Bolivia', NULL, NULL, 0, NULL),
(27, 'BA', 'Bosnia and Herzevina', NULL, NULL, 0, NULL),
(28, 'BW', 'Botswana', NULL, NULL, 0, NULL),
(29, 'BV', 'Bouvet Island', NULL, NULL, 0, NULL),
(30, 'BR', 'Brazil', NULL, NULL, 0, NULL),
(31, 'IO', 'British Indian Ocean Territory', NULL, NULL, 0, NULL),
(32, 'BN', 'Brunei Darussalam', NULL, NULL, 0, NULL),
(33, 'BG', 'Bulgaria', NULL, NULL, 0, NULL),
(34, 'BF', 'Burkina Faso', NULL, NULL, 0, NULL),
(35, 'BI', 'Burundi', NULL, NULL, 0, NULL),
(36, 'KH', 'Cambodia', NULL, NULL, 0, NULL),
(37, 'CM', 'Cameroon', NULL, NULL, 0, NULL),
(38, 'CA', 'Canada', NULL, NULL, 0, NULL),
(39, 'CV', 'Cape Verde', NULL, NULL, 0, NULL),
(40, 'KY', 'Cayman Islands', NULL, NULL, 0, NULL),
(41, 'CF', 'Central African Republic', NULL, NULL, 0, NULL),
(42, 'TD', 'Chad', NULL, NULL, 0, NULL),
(43, 'CL', 'Chile', NULL, NULL, 0, NULL),
(44, 'CN', 'China', NULL, NULL, 0, NULL),
(45, 'CX', 'Christmas Island', NULL, NULL, 0, NULL),
(46, 'CC', 'Cocos (Keeling) Islands', NULL, NULL, 0, NULL),
(47, 'CO', 'Colombia', NULL, NULL, 0, NULL),
(48, 'KM', 'Comoros', NULL, NULL, 0, NULL),
(49, 'CG', 'Con', NULL, NULL, 0, NULL),
(50, 'CK', 'Cook Islands', NULL, NULL, 0, NULL),
(51, 'CR', 'Costa Rica', NULL, NULL, 0, NULL),
(52, 'HR', 'Croatia (Hrvatska)', NULL, NULL, 0, NULL),
(53, 'CU', 'Cuba', NULL, NULL, 0, NULL),
(54, 'CY', 'Cyprus', NULL, NULL, 0, NULL),
(55, 'CZ', 'Czech Republic', NULL, NULL, 0, NULL),
(56, 'DK', 'Denmark', NULL, NULL, 0, NULL),
(57, 'DJ', 'Djibouti', NULL, NULL, 0, NULL),
(58, 'DM', 'Dominica', NULL, NULL, 0, NULL),
(59, 'DO', 'Dominican Republic', NULL, NULL, 0, NULL),
(60, 'TP', 'East Timor', NULL, NULL, 0, NULL),
(61, 'EC', 'Ecuador', NULL, NULL, 0, NULL),
(62, 'EG', 'Egypt', NULL, NULL, 0, NULL),
(63, 'SV', 'El Salvador', NULL, NULL, 0, NULL),
(64, 'GQ', 'Equatorial Guinea', NULL, NULL, 0, NULL),
(65, 'ER', 'Eritrea', NULL, NULL, 0, NULL),
(66, 'EE', 'Estonia', NULL, NULL, 0, NULL),
(67, 'ET', 'Ethiopia', NULL, NULL, 0, NULL),
(68, 'FK', 'Falkland Islands (Malvinas)', NULL, NULL, 0, NULL),
(69, 'FO', 'Faroe Islands', NULL, NULL, 0, NULL),
(70, 'FJ', 'Fiji', NULL, NULL, 0, NULL),
(71, 'FI', 'Finland', NULL, NULL, 0, NULL),
(72, 'FR', 'France', NULL, NULL, 0, NULL),
(73, 'FX', 'France, Metropolitan', NULL, NULL, 0, NULL),
(74, 'GF', 'French Guiana', NULL, NULL, 0, NULL),
(75, 'PF', 'French Polynesia', NULL, NULL, 0, NULL),
(76, 'TF', 'French Southern Territories', NULL, NULL, 0, NULL),
(77, 'GA', 'Gabon', NULL, NULL, 0, NULL),
(78, 'GM', 'Gambia', NULL, NULL, 0, NULL),
(79, 'GE', 'Georgia', NULL, NULL, 0, NULL),
(80, 'DE', 'Germany', NULL, NULL, 0, NULL),
(81, 'GH', 'Ghana', NULL, NULL, 0, NULL),
(82, 'GI', 'Gibraltar', NULL, NULL, 0, NULL),
(83, 'GK', 'Guernsey', NULL, NULL, 0, NULL),
(84, 'GR', 'Greece', NULL, NULL, 0, NULL),
(85, 'GL', 'Greenland', NULL, NULL, 0, NULL),
(86, 'GD', 'Grenada', NULL, NULL, 0, NULL),
(87, 'GP', 'Guadeloupe', NULL, NULL, 0, NULL),
(88, 'GU', 'Guam', NULL, NULL, 0, NULL),
(89, 'GT', 'Guatemala', NULL, NULL, 0, NULL),
(90, 'GN', 'Guinea', NULL, NULL, 0, NULL),
(91, 'GW', 'Guinea-Bissau', NULL, NULL, 0, NULL),
(92, 'GY', 'Guyana', NULL, NULL, 0, NULL),
(93, 'HT', 'Haiti', NULL, NULL, 0, NULL),
(94, 'HM', 'Heard and Mc Donald Islands', NULL, NULL, 0, NULL),
(95, 'HN', 'Honduras', NULL, NULL, 0, NULL),
(96, 'HK', 'Hong Kong', NULL, NULL, 0, NULL),
(97, 'HU', 'Hungary', NULL, NULL, 0, NULL),
(98, 'IS', 'Iceland', NULL, NULL, 0, NULL),
(99, 'IN', 'India', NULL, NULL, 0, NULL),
(100, 'IM', 'Isle of Man', NULL, NULL, 0, NULL),
(101, 'ID', 'Indonesia', NULL, NULL, 0, NULL),
(102, 'IR', 'Iran (Islamic Republic of)', NULL, NULL, 0, NULL),
(103, 'IQ', 'Iraq', NULL, NULL, 0, NULL),
(104, 'IE', 'Ireland', NULL, NULL, 0, NULL),
(105, 'IL', 'Israel', NULL, NULL, 0, NULL),
(106, 'IT', 'Italy', NULL, NULL, 0, NULL),
(107, 'CI', 'Ivory Coast', NULL, NULL, 0, NULL),
(108, 'JE', 'Jersey', NULL, NULL, 0, NULL),
(109, 'JM', 'Jamaica', NULL, NULL, 0, NULL),
(110, 'JP', 'Japan', NULL, NULL, 0, NULL),
(111, 'JO', 'Jordan', NULL, NULL, 0, NULL),
(112, 'KZ', 'Kazakhstan', NULL, NULL, 0, NULL),
(113, 'KE', 'Kenya', NULL, NULL, 0, NULL),
(114, 'KI', 'Kiribati', NULL, NULL, 0, NULL),
(115, 'KP', 'Korea, Democratic Peoples Republic of', NULL, NULL, 0, NULL),
(116, 'KR', 'Korea, Republic of', NULL, NULL, 0, NULL),
(117, 'XK', 'Kosovo', NULL, NULL, 0, NULL),
(118, 'KW', 'Kuwait', NULL, NULL, 0, NULL),
(119, 'KG', 'Kyrgyzstan', NULL, NULL, 0, NULL),
(120, 'LA', 'Lao Peoples Democratic Republic', NULL, NULL, 0, NULL),
(121, 'LV', 'Latvia', NULL, NULL, 0, NULL),
(122, 'LB', 'Lebanon', NULL, NULL, 0, NULL),
(123, 'LS', 'Lesotho', NULL, NULL, 0, NULL),
(124, 'LR', 'Liberia', NULL, NULL, 0, NULL),
(125, 'LY', 'Libyan Arab Jamahiriya', NULL, NULL, 0, NULL),
(126, 'LI', 'Liechtenstein', NULL, NULL, 0, NULL),
(127, 'LT', 'Lithuania', NULL, NULL, 0, NULL),
(128, 'LU', 'Luxembourg', NULL, NULL, 0, NULL),
(129, 'MO', 'Macau', NULL, NULL, 0, NULL),
(130, 'MK', 'Macedonia', NULL, NULL, 0, NULL),
(131, 'MG', 'Madagascar', NULL, NULL, 0, NULL),
(132, 'MW', 'Malawi', NULL, NULL, 0, NULL),
(133, 'MY', 'Malaysia', NULL, NULL, 0, NULL),
(134, 'MV', 'Maldives', NULL, NULL, 0, NULL),
(135, 'ML', 'Mali', NULL, NULL, 0, NULL),
(136, 'MT', 'Malta', NULL, NULL, 0, NULL),
(137, 'MH', 'Marshall Islands', NULL, NULL, 0, NULL),
(138, 'MQ', 'Martinique', NULL, NULL, 0, NULL),
(139, 'MR', 'Mauritania', NULL, NULL, 0, NULL),
(140, 'MU', 'Mauritius', NULL, NULL, 0, NULL),
(141, 'TY', 'Mayotte', NULL, NULL, 0, NULL),
(142, 'MX', 'Mexico', NULL, NULL, 0, NULL),
(143, 'FM', 'Micronesia, Federated States of', NULL, NULL, 0, NULL),
(144, 'MD', 'Moldova, Republic of', NULL, NULL, 0, NULL),
(145, 'MC', 'Monaco', NULL, NULL, 0, NULL),
(146, 'MN', 'Monlia', NULL, NULL, 0, NULL),
(147, 'ME', 'Montenegro', NULL, NULL, 0, NULL),
(148, 'MS', 'Montserrat', NULL, NULL, 0, NULL),
(149, 'MA', 'Morocco', NULL, NULL, 0, NULL),
(150, 'MZ', 'Mozambique', NULL, NULL, 0, NULL),
(151, 'MM', 'Myanmar', NULL, NULL, 0, NULL),
(152, 'NA', 'Namibia', NULL, NULL, 0, NULL),
(153, 'NR', 'Nauru', NULL, NULL, 0, NULL),
(154, 'NP', 'Nepal', NULL, NULL, 0, NULL),
(155, 'NL', 'Netherlands', NULL, NULL, 0, NULL),
(156, 'AN', 'Netherlands Antilles', NULL, NULL, 0, NULL),
(157, 'NC', 'New Caledonia', NULL, NULL, 0, NULL),
(158, 'NZ', 'New Zealand', NULL, NULL, 0, NULL),
(159, 'NI', 'Nicaragua', NULL, NULL, 0, NULL),
(160, 'NE', 'Niger', NULL, NULL, 0, NULL),
(161, 'NG', 'Nigeria', NULL, NULL, 0, NULL),
(162, 'NU', 'Niue', NULL, NULL, 0, NULL),
(163, 'NF', 'Norfolk Island', NULL, NULL, 0, NULL),
(164, 'MP', 'Northern Mariana Islands', NULL, NULL, 0, NULL),
(165, 'NO', 'Norway', NULL, NULL, 0, NULL),
(166, 'OM', 'Oman', NULL, NULL, 0, NULL),
(167, 'PK', 'Pakistan', NULL, NULL, 0, NULL),
(168, 'PW', 'Palau', NULL, NULL, 0, NULL),
(169, 'PS', 'Palestine', NULL, NULL, 0, NULL),
(170, 'PA', 'Panama', NULL, NULL, 0, NULL),
(171, 'PG', 'Papua New Guinea', NULL, NULL, 0, NULL),
(172, 'PY', 'Paraguay', NULL, NULL, 0, NULL),
(173, 'PE', 'Peru', NULL, NULL, 0, NULL),
(174, 'PH', 'Philippines', NULL, NULL, 0, NULL),
(175, 'PN', 'Pitcairn', NULL, NULL, 0, NULL),
(176, 'PL', 'Poland', NULL, NULL, 0, NULL),
(177, 'PT', 'Portugal', NULL, NULL, 0, NULL),
(178, 'PR', 'Puerto Rico', NULL, NULL, 0, NULL),
(179, 'QA', 'Qatar', NULL, NULL, 0, NULL),
(180, 'RE', 'Reunion', NULL, NULL, 0, NULL),
(181, 'RO', 'Romania', NULL, NULL, 0, NULL),
(182, 'RU', 'Russian Federation', NULL, NULL, 0, NULL),
(183, 'RW', 'Rwanda', NULL, NULL, 0, NULL),
(184, 'KN', 'Saint Kitts and Nevis', NULL, NULL, 0, NULL),
(185, 'LC', 'Saint Lucia', NULL, NULL, 0, NULL),
(186, 'VC', 'Saint Vincent and the Grenadines', NULL, NULL, 0, NULL),
(187, 'WS', 'Samoa', NULL, NULL, 0, NULL),
(188, 'SM', 'San Marino', NULL, NULL, 0, NULL),
(189, 'ST', 'Sao Tome and Principe', NULL, NULL, 0, NULL),
(190, 'SA', 'Saudi Arabia', NULL, NULL, 0, NULL),
(191, 'SN', 'Senegal', NULL, NULL, 0, NULL),
(192, 'RS', 'Serbia', NULL, NULL, 0, NULL),
(193, 'SC', 'Seychelles', NULL, NULL, 0, NULL),
(194, 'SL', 'Sierra Leone', NULL, NULL, 0, NULL),
(195, 'SG', 'Singapore', NULL, NULL, 0, NULL),
(196, 'SK', 'Slovakia', NULL, NULL, 0, NULL),
(197, 'SI', 'Slovenia', NULL, NULL, 0, NULL),
(198, 'SB', 'Solomon Islands', NULL, NULL, 0, NULL),
(199, 'SO', 'Somalia', NULL, NULL, 0, NULL),
(200, 'ZA', 'South Africa', NULL, NULL, 0, NULL),
(201, 'GS', 'South Georgia South Sandwich Islands', NULL, NULL, 0, NULL),
(202, 'SS', 'South Sudan', NULL, NULL, 0, NULL),
(203, 'ES', 'Spain', NULL, NULL, 0, NULL),
(204, 'LK', 'Sri Lanka', NULL, NULL, 0, NULL),
(205, 'SH', 'St. Helena', NULL, NULL, 0, NULL),
(206, 'PM', 'St. Pierre and Miquelon', NULL, NULL, 0, NULL),
(207, 'SD', 'Sudan', NULL, NULL, 0, NULL),
(208, 'SR', 'Suriname', NULL, NULL, 0, NULL),
(209, 'SJ', 'Svalbard and Jan Mayen Islands', NULL, NULL, 0, NULL),
(210, 'SZ', 'Swaziland', NULL, NULL, 0, NULL),
(211, 'SE', 'Sweden', NULL, NULL, 0, NULL),
(212, 'CH', 'Switzerland', NULL, NULL, 0, NULL),
(213, 'SY', 'Syrian Arab Republic', NULL, NULL, 0, NULL),
(214, 'TW', 'Taiwan', NULL, NULL, 0, NULL),
(215, 'TJ', 'Tajikistan', NULL, NULL, 0, NULL),
(216, 'TZ', 'Tanzania, United Republic of', NULL, NULL, 0, NULL),
(217, 'TH', 'Thailand', NULL, NULL, 0, NULL),
(218, 'TG', 'To', NULL, NULL, 0, NULL),
(219, 'TK', 'Tokelau', NULL, NULL, 0, NULL),
(220, 'TO', 'Tonga', NULL, NULL, 0, NULL),
(221, 'TT', 'Trinidad and Toba', NULL, NULL, 0, NULL),
(222, 'TN', 'Tunisia', NULL, NULL, 0, NULL),
(223, 'TR', 'Turkey', NULL, NULL, 0, NULL),
(224, 'TM', 'Turkmenistan', NULL, NULL, 0, NULL),
(225, 'TC', 'Turks and Caicos Islands', NULL, NULL, 0, NULL),
(226, 'TV', 'Tuvalu', NULL, NULL, 0, NULL),
(227, 'UG', 'Uganda', NULL, NULL, 0, NULL),
(228, 'UA', 'Ukraine', NULL, NULL, 0, NULL),
(229, 'AE', 'United Arab Emirates', NULL, NULL, 0, NULL),
(230, 'GB', 'United Kingdom', NULL, NULL, 0, NULL),
(231, 'US', 'United States', NULL, NULL, 0, NULL),
(232, 'UM', 'United States minor outlying islands', NULL, NULL, 0, NULL),
(233, 'UY', 'Uruguay', NULL, NULL, 0, NULL),
(234, 'UZ', 'Uzbekistan', NULL, NULL, 0, NULL),
(235, 'VU', 'Vanuatu', NULL, NULL, 0, NULL),
(236, 'VA', 'Vatican City State', NULL, NULL, 0, NULL),
(237, 'VE', 'Venezuela', NULL, NULL, 0, NULL),
(238, 'VN', 'Vietnam', NULL, NULL, 0, NULL),
(239, 'VG', 'Virgin Islands (British)', NULL, NULL, 0, NULL),
(240, 'VI', 'Virgin Islands (U.S.)', NULL, NULL, 0, NULL),
(241, 'WF', 'Wallis and Futuna Islands', NULL, NULL, 0, NULL),
(242, 'EH', 'Western Sahara', NULL, NULL, 0, NULL),
(243, 'YE', 'Yemen', NULL, NULL, 0, NULL),
(244, 'ZR', 'Zaire', NULL, NULL, 0, NULL),
(245, 'ZM', 'Zambia', NULL, NULL, 0, NULL),
(246, 'ZW', 'Zimbabwe', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lb_currencies_list`
--

CREATE TABLE `lb_currencies_list` (
  `id` int(11) NOT NULL,
  `cur_name` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `cur_value` int(11) DEFAULT NULL,
  `cur_rate` decimal(18,4) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime(3) DEFAULT NULL,
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_currencies_list`
--

INSERT INTO `lb_currencies_list` (`id`, `cur_name`, `cur_value`, `cur_rate`, `deleted`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 'EUR', 1, '1.9325', 0, NULL, NULL, NULL),
(2, 'USD', 1, '1.7000', 0, NULL, NULL, NULL),
(1, 'AZN', 1, '1.0000', 0, NULL, NULL, NULL),
(6, 'TRY', 1, '0.3007', 0, NULL, NULL, NULL),
(5, 'IRR', 100, '0.0040', 0, NULL, NULL, NULL),
(4, 'RUB', 1, '0.0259', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lb_positions`
--

CREATE TABLE `lb_positions` (
  `id` int(11) NOT NULL,
  `position` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime(3) DEFAULT NULL,
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_positions`
--

INSERT INTO `lb_positions` (`id`, `position`, `deleted`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'position 1', 0, NULL, NULL, NULL),
(2, 'position 2', 0, NULL, NULL, NULL),
(3, 'position 3', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lb_status`
--

CREATE TABLE `lb_status` (
  `id` int(11) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime(3) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_status`
--

INSERT INTO `lb_status` (`id`, `status`, `color`, `created_at`, `updated_at`, `deleted`, `deleted_at`) VALUES
(1, 'Gözləmədə', '#f0ad4e', '2018-11-01 13:50:02.000', '2018-11-01 13:50:02.000', 0, NULL),
(2, 'Təsdiqləndi', 'green', '2018-11-01 13:50:18.000', '2018-11-08 16:07:42.000', 0, NULL),
(3, 'test', 'blue', '2018-11-01 13:50:29.000', '2018-11-01 13:50:48.000', 1, '2018-11-01 13:50:48.000'),
(4, 'Təchizatçı baxışındadır', 'blue', '2018-11-01 13:50:44.000', '2018-11-01 13:50:44.000', 0, NULL),
(5, 'Alımlara əlavə olundu', '#D931A7', '2018-11-01 13:51:00.000', '2018-11-02 10:37:34.000', 0, NULL),
(6, 'test', 'jdnd', '2018-11-01 13:51:19.000', '2018-11-01 13:51:24.000', 1, '2018-11-01 13:51:24.000'),
(7, 'Təchizatçıya geri göndərildi', 'red', '2018-11-01 13:51:31.000', '2018-11-01 13:51:31.000', 0, NULL),
(8, 'Alternativ yaradılıb', 'green', '2018-11-01 13:51:42.000', '2018-11-02 15:49:50.000', 0, NULL),
(9, 'İstifadəçiyə geri göndərildi', 'red', '2018-11-01 13:51:53.000', '2018-11-01 13:51:53.000', 0, NULL),
(10, 'Direktora göndərilib', 'green', '2018-11-02 15:50:08.000', '2018-11-02 15:50:08.000', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lb_units_list`
--

CREATE TABLE `lb_units_list` (
  `id` int(11) NOT NULL,
  `Unit` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Remark` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime(3) DEFAULT NULL,
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime(3) DEFAULT NULL,
  `use_count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_units_list`
--

INSERT INTO `lb_units_list` (`id`, `Unit`, `Remark`, `deleted`, `deleted_at`, `created_at`, `updated_at`, `use_count`) VALUES
(1, 'metr', NULL, 0, NULL, NULL, '2018-12-05 12:25:54.000', 2),
(2, 'kv. m.', NULL, 0, NULL, NULL, '2018-11-12 14:00:53.000', 9),
(5, 'paket', NULL, 0, NULL, NULL, '2018-12-05 12:31:43.000', 2),
(7, 'cüt', NULL, 0, NULL, NULL, '2018-10-08 15:19:11.807', 2),
(9, 'qram', NULL, 0, NULL, NULL, '2018-10-04 05:42:46.507', 1),
(10, 'ədəd', NULL, 0, NULL, NULL, '2018-12-11 16:53:13.000', 55),
(11, 'vərəq', NULL, 0, NULL, NULL, '2018-10-19 16:41:46.273', 4),
(12, 'ton', NULL, 0, NULL, NULL, '2018-10-04 05:42:46.507', 1),
(13, 'dəst', NULL, 0, NULL, NULL, '2018-11-15 12:05:37.000', 10),
(17, 'sm', NULL, 0, NULL, NULL, '2018-10-04 05:42:46.507', 1),
(20, 'rulon', NULL, 0, NULL, NULL, '2018-11-01 12:37:07.000', 3),
(21, 'qab', NULL, 0, NULL, NULL, '2018-10-04 05:42:46.507', 1),
(22, 'qutu', NULL, 0, NULL, NULL, '2018-10-04 05:42:46.507', 1),
(23, 'top', NULL, 0, NULL, NULL, '2018-10-04 05:42:46.507', 1),
(26, 'balon', NULL, 0, NULL, NULL, '2018-10-04 05:42:46.507', 1),
(27, 'kisə', NULL, 0, NULL, NULL, '2018-12-05 12:30:05.000', 6),
(28, 'flakon', NULL, 0, NULL, NULL, '2018-10-04 05:42:46.507', 1),
(29, 'kq', NULL, 0, NULL, NULL, '2018-10-04 05:42:46.507', 1),
(31, 'bağlama', NULL, 0, NULL, NULL, '2018-10-08 15:28:44.593', 2),
(32, 'litr', NULL, 0, NULL, NULL, '2018-10-04 05:45:50.640', 2);

-- --------------------------------------------------------

--
-- Table structure for table `lb_vehicles_list`
--

CREATE TABLE `lb_vehicles_list` (
  `id` int(11) NOT NULL,
  `Marka` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `QN` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Tipi` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `SN` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `DNN` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `buraxilish_il` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_vehicles_list`
--

INSERT INTO `lb_vehicles_list` (`id`, `Marka`, `QN`, `Tipi`, `SN`, `DNN`, `buraxilish_il`) VALUES
(22, 'Mitsubishi Lancer', 'G90AB461', 'avto', 'müh: 4G13HS4129        şassi: JMYSRCS1A7U', '90AB461 Ganja', '2006'),
(23, 'Mitsubishi Lancer', '90AB465', 'avto', 'müh: 4G13HS4129        şassi: JMYSRCS1A7U', NULL, NULL),
(24, 'NBL', '434', 'lentli yükləyici', 'T25110', NULL, NULL),
(25, 'NBL', '437', 'lentli yükləyici', 'T25113', NULL, NULL),
(26, 'NBL', '438', 'lentli yükləyici', 'T25114', NULL, NULL),
(27, 'Neoplan', '102', 'S.Avtobusu', 'WAG 290122WSF27038', NULL, NULL),
(21, 'Mitsubishi Lancer', '10JH007', 'avto', '2211871A366575', '10 JH 007', '2006'),
(20, 'Mercedes', '10AN807', 'h.avtobusu', 'WDF63981513117573', NULL, NULL),
(1, 'JET 16', '338', 'Y.traktoru', 'T25940', NULL, NULL),
(2, 'JET 16', '339', 'Y.traktoru', 'T25941', NULL, NULL),
(3, 'JET 16', '340', 'Y.traktoru', 'T25942', NULL, NULL),
(4, 'JET 16', '341', 'Y.traktoru', 'T25943', NULL, NULL),
(5, 'JST25', '334', 'Y.traktoru', 'T17231', NULL, NULL),
(6, 'JST25', '335', 'Y.traktoru', 'T17232 Deutz 2011 LO04 N 10636356', NULL, NULL),
(7, 'JST25', '342', 'Y.traktoru', 'T25938', NULL, NULL),
(8, 'Karsan ', '116', 'h.avtobusu', 'NLNOR710107100054', NULL, NULL),
(9, 'Kobit', '813', 'Yanacaq maşını', 'AVİA CN-5k', NULL, NULL),
(10, 'Kocoverk Delta IV', '911', 'Enerji mənbəyi', '', NULL, '2013'),
(11, 'LSP900', '609', 'Assenizasiya', 'T17271 Perkins GN65614U927098', NULL, NULL),
(12, 'LSP900', '610', 'Assenizasiya', 'T17272', NULL, NULL),
(13, 'LSP900', '613', 'Assenizasiya', 'T25922', NULL, NULL),
(14, 'LSP900', '614', 'Assenizasiya', 'T25916', NULL, NULL),
(15, 'Mallaghan', '707', 'Xəstə maşını', '0715321 Medilift 3100D', NULL, NULL),
(16, 'MARZ52661', '113', 'S.Avtobusu', 'XVG52661030500691', NULL, NULL),
(18, 'MAZ 171075', '108', 'S.Avtobusu', 'Y3M1710755000002', NULL, NULL),
(19, 'MAZ 171076', '109', 'S.Avtobusu', 'Y3M1710755000003', NULL, NULL),
(28, 'Neoplan', '106', 'S.Avtobusu', 'WAG 290122WSF24983', NULL, NULL),
(29, 'Niva', '001', 'Avto', '1745623', NULL, NULL),
(30, 'Niva', '002', 'avto', '1663827', NULL, NULL),
(31, 'Niva', '009', 'avto', '1745623', NULL, NULL),
(32, 'VAZ 21214 «Niva»', '99AL354', 'Minik  avtomobili', 'XTA21214031706184', '99AL354', '2004'),
(33, ' VAZ 21214 «Niva»', '10JX454', 'minik', 'mühərrik 7174209 şassi XTA21214031706184', '10 JX 454', '2003'),
(34, 'Peugeot Partner', '10JU978', 'Minik avtomobili', 'VF3GJKFWB95203012', '10JU978', '2005'),
(35, 'Peugeot Partner', '10JT639', 'Yük avtomobili', 'VF3GJKFWB95133297', '10JT639', '2005'),
(36, 'Peugeot Partner', '10JS680', 'Minik avtomobili', 'VF3GJKWB95133297', '10JS680', '2005'),
(37, 'Peugeot Partner', '10JS679', 'minik', 'VF3GJKFW95172088', '10JS679', '2005'),
(54, 'Tiger', '323', 'Baqaj traktoru', 'SW Helicopter', NULL, NULL),
(53, 'Tempest', '809', 'antiobledenitel', NULL, NULL, NULL),
(55, 'TİGER', '311', 'Y.traktoru', 'Ser N 52464', NULL, NULL),
(56, 'TİGER', '312', 'Y.traktoru', 'Ser N 51618390300035', NULL, NULL),
(57, 'TİGER', '313', 'Y.traktoru', 'AA70339*U757746B', NULL, NULL),
(58, 'TİGER', '314', 'Y.traktoru', 'Perkins 1996/2400 AR36516*U249342J*', NULL, NULL),
(59, 'TİGER', '315', 'Y.traktoru', 'Ser N 52350390902098', NULL, NULL),
(60, 'TİGER', '316', 'Y.traktoru', 'Ser N 52350390902099', NULL, NULL),
(61, 'TİGER', '317', 'Y.traktoru', 'Ser N 52350390902099', NULL, NULL),
(62, 'TİGER', '318', 'Y.traktoru', 'Ser N 52618', NULL, NULL),
(63, 'TİGER', '319', 'Y.traktoru', '52618', NULL, NULL),
(64, 'TİGER', '321', 'Y.traktoru', NULL, NULL, NULL),
(65, 'TLD121', '442', 'HİGHLOADER', 'T25923\r\nCaterpillar 44412641', NULL, NULL),
(66, 'TLD4090', '511', 'Enerji mənbəyi', 'T17280', NULL, NULL),
(67, 'TMD150/180/250', '908', 'Enerji mənbəyi', '18282G10DAK', NULL, NULL),
(68, 'TMD-250', '901', 'Enerji mənbəyi', 'Ser N TMD250-58', NULL, NULL),
(69, 'TMX-30', '328', 'Baqaj traktoru', '06206816520249F8\r\nDeutz 10244530', NULL, NULL),
(71, 'TMX-30', '331', 'Baqaj traktoru', '06206816520249F1\r\nDeutz 10380482', NULL, NULL),
(72, 'Toyota 62-8 FD30', '9', 'Yükləyici', NULL, 'Cargo ramp', '2010'),
(73, 'Toyota 62-8 FD30', '10', 'Yükləyici', NULL, 'Cargo ramp', '2010'),
(74, 'TPX200S', '300', 'Tyaqaç ', 'T17068 Deutz 2013 L042V N10552471', NULL, NULL),
(75, 'TPX200S', '332', 'Tyaqaç ', '17154', NULL, NULL),
(76, 'TPX500S', '343', 'Tyaqaç ', 'T26007', NULL, NULL),
(77, 'TUG', '310', 'Y.traktoru', 'Ser N 2666', NULL, NULL),
(78, 'TUG', '345', 'Y.traktoru', 'T25938', NULL, NULL),
(79, 'TUG', '346', 'Y.traktoru', 'T25938', NULL, NULL),
(80, 'TUG', '401', 'lentli yükləyici', 'Ser N 6508279', NULL, NULL),
(81, 'TUG', '402', 'lentli yükləyici', 'Ser N 6508280', NULL, NULL),
(82, 'TUG', '403', 'lentli yükləyici', 'Ser N 7680', NULL, NULL),
(83, 'TUG', '404', 'lentli yükləyici', 'Perkins 1996/2400 AR70433*U193709H*', NULL, NULL),
(84, 'TUG', '407', 'lentli yükləyici', NULL, NULL, NULL),
(85, 'TUG', '408', 'lentli yükləyici', '6712H4A/8', NULL, NULL),
(86, 'TUG', '409', NULL, NULL, NULL, NULL),
(87, 'TUG', '410', 'lentli yükləyici', 'Gəncə', NULL, NULL),
(88, 'TUG', '411', 'lentli yükləyici', NULL, NULL, NULL),
(89, 'TUG', '430', 'lentli yükləyici', 'Lənkəran', NULL, NULL),
(90, 'TUG M1A-60', '309', 'Y.traktoru', 'Ser N 7002982', NULL, NULL),
(91, 'TugM1A', 'T02', 'Baqaj traktoru', 'Biznes Aviation', NULL, NULL),
(92, 'TugM1A', 'T01', 'Y.traktoru', 'Biznes Aviation', NULL, NULL),
(93, 'TUGM1A60-34', '13', 'Y.traktoru', NULL, 'Cargo ramp', '2013'),
(94, 'TUGM1A60-34', '14', 'Y.traktoru', '7002983', 'Cargo ramp', '2013'),
(95, 'TUGM1A60-34', '15', 'Y.traktoru', 'Deutz 2011LO4 N 11301781', 'Cargo ramp', '2013'),
(96, 'TXL 737', '440', 'HİGHLOADER', '33023090111975', NULL, NULL),
(97, 'TXL 737', '441', 'HİGHLOADER', '030AC025\r\nCR2016E103517', NULL, NULL),
(98, 'TXL727', '433', 'HİGHLOADER', 'Deutz 0427 1689K 51 451 001 24 V', NULL, NULL),
(99, 'TXL838', '439', 'HİGHLOADER', 'T25017', NULL, NULL),
(202, 'JET 16', '337', 'Y.traktoru', 'T25939', NULL, NULL),
(201, 'İsuzu Boqdan', '119', 'S.Avtobusu', NULL, NULL, NULL),
(200, 'TUG', '308', 'Y.traktoru', 'Ser N 7002983 müh RE38247 U285154N', NULL, NULL),
(199, 'TUG M1A60-34', 'G12', 'Y.traktoru', 'TUG M1AN', 'Ganja', '2013'),
(198, 'Trielektron 5050D', '903', 'Enerji mənbəyi', 'Ser N 20329', NULL, NULL),
(38, 'Peugeot Partner', '10JS165', 'minik', 'V3GCWJYB96131753', '10JS165', '2005'),
(39, 'Peugeot Partner', '10JS164', 'Minik avtomobili', 'VF3GJKFWB951172089', '10JS164', '2005'),
(41, 'Qazel', '107', 'h.avtobusu', '322100x0130468', NULL, NULL),
(42, 'QAZEL', '117', 'h.avtobusu', '1020755', NULL, NULL),
(43, 'QAZEL', '708', 'h.avtobusu', '33023090111975', NULL, NULL),
(44, 'QAZEL', '711', 'h.avtobusu', '10220755', NULL, NULL),
(45, 'QAZEL 3302-18', '90JA408', 'Yük avtomobili', 'X9633020072203559\r\n40630C73019370', '90JA408', '2007'),
(46, 'SCHOPF-220', '304', 'Tyaqaç ', '2002033 UUH', NULL, NULL),
(47, 'SCHOPF-396', '303', 'Tyaqaç ', '88038', NULL, NULL),
(48, 'T-400', '501', 'Enerji mənbəyi', 'SWMG01037-3\r\nCummens 46108794', NULL, NULL),
(49, 'T-400', '502', 'Enerji mənbəyi', 'M1037-1\r\nCummens 46111679', NULL, NULL),
(50, 'Tempest', '806', 'antiobledenitel', 'TP08023', NULL, NULL),
(51, 'Tempest', '807', 'antiobledenitel', 'TP08026', NULL, NULL),
(52, 'Tempest', '808', 'antiobledenitel', 'TP08027', NULL, NULL),
(70, 'TMX-30', '329', 'Baqaj traktoru', '06206816520249F4\r\nDeutz 10380480', NULL, NULL),
(100, 'Volkswagen', '120', 'h.avtobusu', 'WV2ZZZ70ZSH022701', NULL, NULL),
(102, '120T400', '503', 'Enerji mənbəyi', NULL, NULL, NULL),
(103, '120T400', '507', 'Enerji mənbəyi', NULL, NULL, NULL),
(104, 'ABS580', '200', 'S.Trapı', 'T17220', NULL, NULL),
(105, 'ABS580', '217', 'S.Trapı', 'T20516', NULL, NULL),
(106, 'ABS580', '219', 'S.Trapı', 'T24367', NULL, NULL),
(107, 'ABS580', '220', 'S.Trapı', 'T24368', NULL, NULL),
(108, 'ABS580', '225', 'trap', 'T24367', NULL, NULL),
(109, 'ABS580', 'S01', 'trap', 'Biznes Aviation', NULL, NULL),
(110, 'ABS580', '221', 'trap', 'T24367', NULL, NULL),
(111, 'ASP-250', '902', 'Enerji mənbəyi', NULL, NULL, NULL),
(112, 'ASP270', '905', 'Enerji mənbəyi', '2002 buraxılış', NULL, NULL),
(113, 'ASU-600-400DDP', '909', 'Enerji mənbəyi', 'Detroit Diesel Model 12V2000C21R\r\nSeriya N 5352010702', NULL, NULL),
(115, 'Challenger', '344', 'Tyaqaç ', NULL, NULL, NULL),
(116, 'Niva Chevrolet', '10JO461', 'minik', 'X9L21230040052654', '10 JO 461', '2004'),
(117, 'Clarck', '412', 'Yükləyici', 'SMP570D0705K0F6882', NULL, NULL),
(118, 'Clark CMP-70', '11', 'Yükləyici', 'CMP570D-1501-9590 KF\r\nRE38400/U51730', 'Cargo ramp', '2011'),
(119, 'Clark GEX-16', '17', 'Yükləyici', NULL, 'Anbar/warehouse', '2013'),
(120, 'Clark GEX-16', 'G18', 'Yükləyici', NULL, 'Ganja', '2013'),
(121, 'Clark GEX-16', '20', 'Yükləyici', 'GEX-16', 'Anbar/warehouse', '2013'),
(122, 'Clark GEX-16', '24', 'Yükləyici', 'GEX-16', 'Anbar/warehouse', '2013'),
(123, 'Clark GTX-70', '27', 'Yükləyici', 'GTX-70', 'Anbar/warehouse', '2013'),
(124, 'Clark GTX-70', '28', 'Yükləyici', 'GTX-70', 'Anbar/warehouse', '2013'),
(125, 'CMP-70', '413', 'Forklift', 'CMP570D001359686KF\r\n1101044T T1104018A', NULL, NULL),
(126, 'COBUS', '100', 'S.Avtobusu', 'WDAB019368N134590', NULL, NULL),
(127, 'COBUS', '101', 'S.Avtobusu', 'WDB6703741N082731', NULL, NULL),
(128, 'COBUS', '103', 'S.Avtobusu', 'TAW6985301U951525\r\ns/n 35691510473052', NULL, NULL),
(129, 'COBUS', '104', 'S.Avtobusu', 'TAW6985101U950965\r\n s/n 35691510360358', NULL, NULL),
(130, 'Cobus', '105', 'S.Avtobusu', 'TAW6985201U951296', NULL, NULL),
(131, 'DAC090', '906', 'Enerji mənbəyi', '223597', NULL, NULL),
(132, 'DAC090', '907', 'Enerji mənbəyi', 'Perkins WS4486n1502058', NULL, NULL),
(133, 'Doblo Panorama', '010', 'avto', 'NM426300007181963', NULL, NULL),
(134, 'Doosan', '432', 'Yükləyici', 'F1-00080', NULL, NULL),
(135, 'Douglas', '301', 'Tyaqaç ', 'DT2644/DC8-44/5065 BF4M1013EC\r\nN 01075147', NULL, NULL),
(136, 'Douglas', '302', 'Tyaqaç ', 'DT2479/DC10-4H/N4846', NULL, NULL),
(137, 'Douglas', '330', 'Tyaqaç ', 'DT2644/DC8-44/5066 BF4M1013EC\r\nN 01075147', NULL, NULL),
(138, 'Douglas DC12', '327', 'Tyaqaç ', '2666', NULL, NULL),
(139, 'Fiat Doblo', '011', 'avto', 'NM426300009129782', NULL, NULL),
(140, 'Fiat Doblo', '012', 'avto', 'NM426300009129662', NULL, NULL),
(141, 'Fiat Doblo', '013', 'avto', 'NM426300009129570', NULL, NULL),
(142, 'Fiat Doblo', '014', 'avto', 'NM426300009129595', NULL, NULL),
(143, 'Fiat doblo', '015', 'avto', 'NM426300009129576', NULL, NULL),
(144, 'Fiat doblo', '016', 'avto', 'NM42630000912871', NULL, NULL),
(145, 'Fiat doblo', '017', 'avto', 'NM42630000912817', NULL, NULL),
(146, 'Fiat Doblo', '018 VİP', 'avto', 'NM426300009129575', NULL, NULL),
(147, 'Fiat Doblo', '019', 'Avto', 'NM426300009129662', NULL, NULL),
(148, 'Fiat Doblo', '180', 'avto', 'NM426300009129576', NULL, NULL),
(149, 'Fiat Doblo', '181', 'avto', 'NM4263000091429576', NULL, NULL),
(150, 'Fiat Doblo', '182', 'avto', 'NM4263000091429576', NULL, NULL),
(151, 'Fiat Doblo', '190', 'avto', 'NM426300009128271', NULL, NULL),
(152, 'Fiat Doblo', '90AN477', 'avto', 'ZFA223005667499', '90AN477', NULL),
(153, 'Ford Transit', '114', 'h.avtobusu', '322100x0130468', NULL, NULL),
(154, 'Ford-350', '201', 'Trap 3518', '1FDWF36P57EA41084', NULL, NULL),
(155, 'Ford-350', '202', 'Trap 3518', NULL, NULL, NULL),
(156, 'Ford-350', '203', 'Trap 3518', '1FDWF36P97EA41086', NULL, NULL),
(157, 'Ford-350', '204', 'Trap 3518', '1FDWF36P57EA41085', NULL, NULL),
(158, 'Ford-350', '205', 'Trap 3518', '1FDWF36P04EC85446', NULL, NULL),
(159, 'Ford-350', '206', 'Trap', '1FDWF36F9YEC85427', NULL, NULL),
(160, 'Ford-350', '207', 'Trap 3518', '1FDWF36P76EA39514', NULL, NULL),
(161, 'Ford-350', '208', 'Trap 3518', '1FDWF36P95EB92717', NULL, NULL),
(162, 'Ford-350', '210', 'Trap 3518', '1FDWF36P53EC55745', NULL, NULL),
(163, 'Ford-350', '211', 'trap', '1FDWF36P75EB92716', NULL, NULL),
(164, 'Ford-350', '212', 'Trap 3518', '1FDWF36P76EA39514', NULL, NULL),
(165, 'Ford-350', '214', 'S.Trapı', '1FDWF36P93EC55748', NULL, NULL),
(166, 'Ford-350', '603', 'su maşını', '1FDWF36P64EB23711', NULL, NULL),
(167, 'Ford-350', '604', 'Assenizasiya', 'Gəncə', NULL, NULL),
(168, 'Ford-350', '605', 'Assenizasiya', '1FDWF36P44EB23710', NULL, NULL),
(169, 'Ford-350', '612', 'trap', '1FDRF3GT5BEA88066', NULL, NULL),
(170, 'Ford-450', '218', 'Trap 6018', '1FDUF4GT7BEA88876', NULL, NULL),
(171, 'Ford-650', '706', 'Avtolift ', '3FRNF65B37V509831', NULL, NULL),
(172, 'Forland', '90JD209', 'h.avtobusu', 'LVBV81E667E003804', '90JD209', NULL),
(173, 'GPU', '514', 'Enerji mənbəyi', 's/n  3387833', NULL, NULL),
(174, 'GPU 400/140', '515', 'Enerji mənbəyi', 'Gummens 3971615', NULL, NULL),
(175, 'GPU4090', '500', 'Enerji mənbəyi', 'Gummens 46881201', NULL, NULL),
(176, 'GT-110', '336', 'Tyaqaç ', 'GT-110-452\r\n Deutz10867218', NULL, NULL),
(177, 'Hobart', '504', 'Enerji mənbəyi', NULL, NULL, NULL),
(178, 'Hobart', '505', 'Enerji mənbəyi', 'Ser N 404PS08669', NULL, NULL),
(179, 'Hobart', '506', 'Enerji mənbəyi', 'Engine model: B5.9C Cummens № 46441198', NULL, NULL),
(180, 'Houchin BS9', '510', 'Enerji mənbəyi', 'Ser N 103365', NULL, NULL),
(181, 'hundai ', '006', 'h.avtobusu', 'XTH27050010219482', NULL, NULL),
(182, 'Hundai ', '110', 'H.avtobusu', 'KMJHD17C37C034059', NULL, NULL),
(183, 'Hundai ', '115', 'h.avtobusu', 'KMJHD17EP3C016442', NULL, NULL),
(184, 'Hundai ', '118', 'H.avtobusu', 'KMJHD17FP4C021826', NULL, NULL),
(185, 'Hundai ', '123', 'h.avtobusu', 'KMJHD17CP8C041520', NULL, NULL),
(186, 'Hundai ', '125', 'h.avtobusu', 'KMJHD17CP9C044465', NULL, NULL),
(187, 'Hundai ', '126', 'h.avtobusu', 'KMJHD17BPBC052093', NULL, NULL),
(188, ' Hyundai H-1', '10JN935', 'h.avtobusu', 'NLJWWH7HP4Z011705', '10 JN 935', '2004'),
(189, 'trap', '232', 'mexaniki ', NULL, NULL, NULL),
(190, 'Trepel Champ300', '16', 'HİGHLOADER', 'S/N 350683876', 'Cargo ramp', '2013'),
(191, 'Trepel', '416', 'HİGHLOADER', 'Ser N 360181', NULL, NULL),
(192, 'Trepel', '417', 'HİGHLOADER', 'Deutz BFL1011F\r\nN 00501330', NULL, NULL),
(193, 'Trepel', '418', 'HİGHLOADER', '63000571152\r\n Deutz.00906555', NULL, NULL),
(194, 'Trepel', '419', 'HİGHLOADER', '350683876\r\nDeutz .00595465', NULL, NULL),
(195, 'Trepel', '421', 'HİGHLOADER', 'Champ 70U', NULL, NULL),
(196, 'Trepel', '422', 'HİGHLOADER', 'Champ 70U', NULL, NULL),
(197, 'Trepel', '423', 'HİGHLOADER', '6350095', NULL, NULL),
(203, 'Rang-Rover ', '10AZ886', 'minik', NULL, '10 AZ 886', '2006'),
(213, 'BMW-540', '10PE302', 'Minik avtomobili', 'WBADN61090GG89595', '10PE302', '2000'),
(215, 'Volkswagen Passat', '10PS559', 'Minik avtomobili', NULL, '10PS 559', '2014'),
(217, ' Mercedes-Benz ', '130', 'Minik  avtomobili', NULL, '10AN807', '2004'),
(218, 'Fiat doblo Panorama', '4', 'Minik  avtomobili', NULL, '90AX057', '2007'),
(219, 'Fiat doblo Panorama', '5', 'Minik  avtomobili', NULL, '90AX058', '2007'),
(101, 'Linde', '1', NULL, NULL, 'Cargo ramp  4,8t', '2004'),
(216, 'Linde R-16', '3', NULL, NULL, 'Cargo ramp  1,6t', '2004'),
(214, 'Toyota-VRE -125', '1S', NULL, NULL, 'Cargo ramp', '2013'),
(212, 'Toyota-VRE -125', '2S', NULL, NULL, 'Cargo ramp', '2013'),
(209, 'Toyota-VRE -125', '3S', NULL, NULL, 'Cargo ramp', '2013'),
(210, 'Clark GEX-16', '19', 'Yükləyici', NULL, 'Anbar/warehouse', '2013'),
(207, 'Clark GEX-16', '21', NULL, NULL, 'Anbar/warehouse', '2013'),
(208, 'Clark GEX-16', '22', NULL, NULL, 'Anbar/warehouse', '2013'),
(206, 'Clark GEX-16', '23', NULL, NULL, 'Anbar/warehouse', '2013'),
(211, 'Clark GEX-16', '25', NULL, NULL, 'Anbar/warehouse', '2013'),
(205, 'Clark GEX-16', '26', NULL, NULL, 'Anbar/warehouse', '2013'),
(204, 'VAZ 21214 «Niva»', '2', NULL, NULL, NULL, '2002'),
(221, 'VAZ 21213 «Niva»', 'G9', NULL, NULL, 'Ganja', '2003'),
(220, 'Fiat Doblo', '10PD186', 'avto', NULL, '10PD186', '2011');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL,
  `migration` varchar(191) CHARACTER SET utf8 NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2014_10_12_000000_create_users_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `id` int(11) NOT NULL,
  `Product` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `Translation_Brand` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `Part` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `WEB_link` varchar(2000) CHARACTER SET utf8 DEFAULT NULL,
  `image` longtext COLLATE utf8_unicode_ci,
  `unit_id` int(11) DEFAULT NULL,
  `situation_id` int(11) DEFAULT NULL,
  `Remark` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `MainPerson` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `deffect_doc` longtext COLLATE utf8_unicode_ci,
  `Pcs` decimal(18,2) DEFAULT NULL,
  `SupplyID` int(11) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `confirmed` int(1) NOT NULL DEFAULT '0',
  `confirmed_at` datetime DEFAULT NULL,
  `ChiefID` int(11) DEFAULT NULL,
  `ReportDocument` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ReportNo` int(8) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`id`, `Product`, `Translation_Brand`, `Part`, `WEB_link`, `image`, `unit_id`, `situation_id`, `Remark`, `deleted`, `deleted_at`, `created_at`, `updated_at`, `MainPerson`, `DepartmentID`, `category_id`, `vehicle_id`, `position_id`, `deffect_doc`, `Pcs`, `SupplyID`, `deadline`, `confirmed`, `confirmed_at`, `ChiefID`, `ReportDocument`, `ReportNo`) VALUES
(57, 'UPS', 'müasir tipli', NULL, NULL, '/uploads/files/orders/images/order_koAw_0.80837200 1542696401.jpg', 10, 1, '4 ədə “UPS”  1-ci yük terminalında, 2 ədəd “UPS” isə “GHC” filianın inzibati binasında quraşdırılacaq', 0, NULL, '2018-11-20', '2018-11-20', 18, 2, 5, NULL, NULL, NULL, '6.00', NULL, NULL, 0, NULL, NULL, '/uploads/files/reports/report_ZDhj.pdf', NULL),
(58, 'Hərəkətin idarə etmə bloku +30-A1', 'Mobil controller CR 0032', '000.579.5182', NULL, NULL, 10, 1, NULL, 0, NULL, '2018-11-27', '2018-11-27', 18, 2, 1, 115, NULL, '/uploads/files/orders/defects/defect_us2M.pdf', '1.00', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(4, 'Kompüter', 'müasir tipli', 'i7', 'samsung.az', '/uploads/files/orders/images/order_sZyV_0.12748200 1540292568.jpg', 10, 2, NULL, 0, NULL, '2018-10-23', '2018-10-23', 18, 2, 5, NULL, NULL, NULL, '4.00', NULL, NULL, 0, NULL, 0, NULL, NULL),
(5, 'Printer', 'müasir tipli', 'xerox', 'samsung.az', NULL, 10, 2, NULL, 0, NULL, '2018-10-23', '2018-10-23', 18, 2, 5, NULL, NULL, NULL, '1.00', NULL, NULL, 0, NULL, 0, NULL, NULL),
(6, 'printer', 'melumat', 'marka', 'www.facebook.com', NULL, 22, 2, 'qeyd2', 1, NULL, '2018-10-23', '2018-11-01', 11, 1, 5, NULL, NULL, NULL, '2.00', 14, NULL, 0, NULL, 0, NULL, NULL),
(7, 'Kapotun petləsi', 'Hinge/charniere', '4133166', NULL, NULL, 10, 1, 'Tempest markalı buzlaşmaya qarşı emal maşınında da istifadə olunduğu üçün 18 ədəd ehtiyat', 1, '2018-11-02', '2018-10-23', '2018-11-02', 18, 2, 1, 75, NULL, NULL, '20.00', NULL, NULL, 0, NULL, 0, NULL, NULL),
(22, 'kitab', NULL, NULL, 'bsdf', NULL, 2, 9, NULL, 1, NULL, '2018-11-01', '2018-11-01', 11, 1, 3, 31, NULL, NULL, '5.00', NULL, NULL, 0, NULL, 0, NULL, NULL),
(25, 'Sürətlər qutusunun ön kipliyi', NULL, NULL, NULL, '/uploads/files/orders/images/order_juUm_0.55596400 1541159575.JPG', 10, 2, NULL, 0, NULL, '2018-11-02', '2018-11-05', 18, 2, 1, 14, NULL, '/uploads/files/orders/defects/report__1rAE.pdf', '1.00', NULL, NULL, 0, NULL, 0, NULL, NULL),
(26, 'Su nasosu (boruları ilə birlikdə)', 'null', 'null', NULL, '/uploads/files/orders/images/order_6RPo_0.24571700 1541159770.JPG', 13, 2, NULL, 0, NULL, '2018-11-02', '2018-11-05', 18, 2, 1, 45, NULL, '/uploads/files/orders/defects/report__233o.pdf', '1.00', NULL, NULL, 0, NULL, 0, NULL, NULL),
(27, 'Kapotun petləsi', 'Hinge/charniere', '4133166', NULL, '/uploads/files/orders/images/order_ONHO_0.35915900 1541160352.JPG', 10, 8, 'Tempest markalı buzlaşmaya qarşı emal maşınında da istifadə olunduğu üçün 18 ədəd ehtiyat', 0, NULL, '2018-11-02', '2018-11-13', 18, 2, 1, 75, NULL, '/uploads/files/orders/defects/report__8nsv.pdf', '20.00', 32, NULL, 1, '2018-11-12 14:31:08', 19, NULL, 20180005),
(28, 'Planşet', 'müasir tipli', 'iPad 6 (2018) Wi-Fi 32Gb Space Grey', 'https://maxi.az/telefonlar-ve-plansetler/plansetler/ipad-6-2018-wi-fi-32gb-space-grey/', NULL, 10, 1, 'Alınan yeni texnikaların hidravlik və elektrik sisteminin sxemlərinin oxunması məqsədi ilə,', 1, '2018-11-05', '2018-11-05', '2018-11-05', 18, 2, 5, NULL, NULL, NULL, '1.00', NULL, NULL, 0, NULL, 0, NULL, NULL),
(29, 'Planşet', 'müasir tipli', 'iPad 6 (2018) Wi-Fi 32Gb', 'https://maxi.az/telefonlar-ve-plansetler/plansetler/ipad-6-2018-wi-fi-32gb-space-grey/', '/uploads/files/orders/images/order_vqXT_0.94184800 1541407222.jpg', 10, 2, 'Alınan yeni texnikaların hidravlik və elektrik sisteminin manualı, elektron variantda olduğu üçün, sxemlərin planşet vasitəsi ilə oxunması', 0, NULL, '2018-11-05', '2018-11-05', 18, 2, 5, NULL, NULL, NULL, '1.00', NULL, NULL, 0, NULL, 0, NULL, NULL),
(30, '8.25-15', 'Tökmə təkər', NULL, NULL, '/uploads/files/orders/images/order_iybO_0.22513500 1541578399.JPG', 10, 1, NULL, 0, NULL, '2018-11-07', '2018-11-07', 18, 2, 10, 125, NULL, '/uploads/files/orders/defects/report__kyBM.pdf', '6.00', NULL, NULL, 0, NULL, 0, NULL, NULL),
(31, 'Əyləc sisteminin hava klapanı (pnevmatik)', NULL, NULL, NULL, '/uploads/files/orders/images/order_PwtP_0.36332100 1541578584.JPG', 10, 2, NULL, 0, NULL, '2018-11-07', '2018-11-13', 18, 2, 1, 53, NULL, '/uploads/files/orders/defects/report__HdQD.pdf', '2.00', 28, NULL, 1, '2018-11-12 14:31:07', 19, NULL, 20180004),
(32, '28 x 9 - 15', 'Təkər', NULL, NULL, '/uploads/files/orders/images/order_A3h5_0.02511100 1541670731.JPG', 10, 1, NULL, 0, NULL, '2018-11-08', '2018-11-08', 18, 2, 10, 72, NULL, '/uploads/files/orders/defects/report__0p9X.pdf', '2.00', NULL, NULL, 0, NULL, 0, NULL, NULL),
(33, '28 x 9 - 15', 'Təkər', NULL, NULL, '/uploads/files/orders/images/order_yEjq_0.05939600 1541670887.JPG', 10, 1, NULL, 0, NULL, '2018-11-08', '2018-11-08', 18, 2, 10, 73, NULL, '/uploads/files/orders/defects/report__eevW.pdf', '2.00', NULL, NULL, 0, NULL, 0, NULL, NULL),
(34, 'Hidravlik sisteminin solenoidi (PCP MCV116A3201)', NULL, '6500198-100', NULL, '/uploads/files/orders/images/order_e5A6_0.35823600 1541671197.PNG', 10, 2, NULL, 0, NULL, '2018-11-08', '2018-11-13', 18, 2, 1, 97, NULL, '/uploads/files/orders/defects/report__xC7z.pdf', '1.00', 28, NULL, 1, '2018-11-12 14:31:06', 19, NULL, 20180003),
(38, 'Siqnal ötürücü blok', NULL, '7900169', NULL, '/uploads/files/orders/images/order_eOPW_0.02682000 1542198709.jpg', 10, 1, '1 ədəd ehtiyat', 0, NULL, '2018-11-14', '2018-11-14', 18, 2, 1, 76, NULL, '/uploads/files/orders/defects/defect_BZv4.pdf', '2.00', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(39, 'Hava yastığı', NULL, NULL, NULL, '/uploads/files/orders/images/order_tmwX_0.70867800 1542198891.JPG', 10, 1, NULL, 0, NULL, '2018-11-14', '2018-11-14', 18, 2, 1, 19, NULL, '/uploads/files/orders/defects/defect_YAP1.pdf', '1.00', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(40, 'Kompüter', 'Kompüter ( minimum tələblər –Intel Core I7, 12 GB RAM, 1TB HDD, 2 monitorlu,monitor 28’, 25’)', 'HP', NULL, NULL, 13, 2, '2 monitorlu', 0, NULL, '2018-11-15', '2018-11-20', 12, 1, 5, NULL, NULL, NULL, '1.00', 30, NULL, 1, '2018-11-15 12:10:23', 33, '/uploads/files/reports/report_7AWD.docx', NULL),
(41, 'Kompüter', 'Kompüter ( minimum tələblər –Intel Core I7, 8 GB RAM, 1 TB HDD, monitor 22’)', 'HP', NULL, NULL, 13, 2, NULL, 0, NULL, '2018-11-15', '2018-11-20', 12, 1, 5, NULL, NULL, NULL, '2.00', 30, NULL, 1, '2018-11-15 12:10:22', 33, NULL, NULL),
(42, 'Kompüter mouse-u', 'usb mouse', 'HP', NULL, NULL, 10, 2, NULL, 0, NULL, '2018-11-15', '2018-11-20', 12, 1, 5, NULL, NULL, NULL, '2.00', 30, NULL, 1, '2018-11-15 12:10:21', 33, NULL, NULL),
(43, 'RAM', 'Kompüter üçün RAM (4GB PC3-12800 1600Mhz DDR3 SDRAM DİMM 240-pin)', 'any', NULL, NULL, 10, 2, NULL, 0, NULL, '2018-11-15', '2018-11-20', 12, 1, 5, NULL, NULL, NULL, '2.00', 30, NULL, 1, '2018-11-15 12:10:19', 33, NULL, NULL),
(44, 'qələm', NULL, 'diyircəkli', NULL, '/uploads/files/orders/images/order_wMGZ_0.43686800 1542268850.jpg', 10, 5, '10 göy, 5 qırmızı', 0, NULL, '2018-11-15', '2018-12-12', 12, 1, 8, NULL, NULL, NULL, '15.00', 14, '2018-12-12', 1, '2018-11-15 12:11:24', 33, NULL, NULL),
(45, 'korrektor (ağardıcı)', NULL, 'sadə', NULL, NULL, 10, 2, NULL, 0, NULL, '2018-11-15', '2018-11-15', 12, 1, 8, NULL, NULL, NULL, '3.00', NULL, NULL, 1, '2018-11-15 12:11:23', 33, NULL, NULL),
(46, 'stepler', NULL, NULL, NULL, NULL, 10, 8, NULL, 0, NULL, '2018-11-15', '2018-12-12', 12, 1, 8, NULL, NULL, NULL, '2.00', 14, NULL, 1, '2018-11-15 12:11:22', 33, NULL, NULL),
(47, 'karandaş', NULL, 'sadə', NULL, NULL, 10, 2, NULL, 0, NULL, '2018-11-15', '2018-11-15', 12, 1, 8, NULL, NULL, NULL, '5.00', NULL, NULL, 1, '2018-11-15 12:11:21', 33, NULL, NULL),
(48, 'sticker', NULL, 'kiçik vərəqlər', NULL, NULL, 13, 2, NULL, 0, NULL, '2018-11-15', '2018-12-05', 12, 1, 8, NULL, NULL, NULL, '3.00', 22, NULL, 1, '2018-11-15 12:11:20', 33, NULL, NULL),
(49, 'bloknot', NULL, 'adi, kiçik ölçülü', NULL, NULL, 10, 2, NULL, 0, NULL, '2018-11-15', '2018-11-15', 12, 1, 8, NULL, NULL, NULL, '5.00', NULL, NULL, 1, '2018-11-15 12:11:19', 33, NULL, NULL),
(50, 'xətkeş', NULL, '30 sm və ya 50 sm', NULL, NULL, 10, 2, NULL, 0, NULL, '2018-11-15', '2018-11-15', 12, 1, 8, NULL, NULL, NULL, '2.00', NULL, NULL, 1, '2018-11-15 12:11:18', 33, NULL, NULL),
(51, 'yapışqan vərəq', NULL, NULL, NULL, NULL, 13, 2, NULL, 0, NULL, '2018-11-15', '2018-11-15', 12, 1, 8, NULL, NULL, NULL, '3.00', NULL, NULL, 1, '2018-11-15 12:11:17', 33, NULL, NULL),
(52, 'pozan', NULL, NULL, NULL, NULL, 10, 2, NULL, 0, NULL, '2018-11-15', '2018-11-15', 12, 1, 8, NULL, NULL, NULL, '3.00', NULL, NULL, 1, '2018-11-15 12:11:16', 33, NULL, NULL),
(53, 'qələm yonan', NULL, NULL, NULL, NULL, 10, 2, NULL, 0, NULL, '2018-11-15', '2018-11-15', 12, 1, 8, NULL, NULL, NULL, '3.00', NULL, NULL, 1, '2018-11-15 12:11:15', 33, NULL, NULL),
(54, 'marker', NULL, 'lövhə üçün', NULL, NULL, 10, 2, NULL, 0, NULL, '2018-11-15', '2018-11-15', 12, 1, 8, NULL, NULL, NULL, '5.00', NULL, NULL, 1, '2018-11-15 12:11:13', 33, NULL, NULL),
(55, 'silgi', NULL, 'lövhə üçün', NULL, NULL, 10, 2, NULL, 0, NULL, '2018-11-15', '2018-11-15', 12, 1, 8, NULL, NULL, NULL, '2.00', NULL, NULL, 1, '2018-11-15 12:11:12', 33, NULL, NULL),
(56, 'qelem', NULL, 'goy', NULL, NULL, 10, 2, NULL, 0, NULL, '2018-11-16', '2018-12-04', 11, 1, 8, NULL, NULL, NULL, '5.00', NULL, NULL, 1, '2018-12-04 14:57:16', 11, NULL, NULL),
(59, 'defter', '54', 'fenf', 'link', NULL, 1, 2, 'sbf', 0, NULL, '2018-12-05', '2018-12-05', 22, 4, 5, NULL, NULL, NULL, '5.00', 22, NULL, 1, '2018-12-05 12:26:32', 22, NULL, NULL),
(60, 'kitab', 'dfd', 'fgfgfd', 'dsnm', NULL, 27, 2, 'fdsfdsgdfgfdgfdghfhgfhgfhgfhfhghghjgjhgjhgjhgjhg', 0, NULL, '2018-12-05', '2018-12-11', 22, 4, 5, NULL, NULL, NULL, '5.00', 22, NULL, 1, '2018-12-11 16:45:14', 22, NULL, NULL),
(61, 'forma', '58', 'lc', 'linkas', NULL, 5, 1, 'qeyd', 0, NULL, '2018-12-05', '2018-12-05', 22, 4, 7, NULL, 2, NULL, '5.00', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(62, 'komp', 'asdf', 'dfd', 'test', '/uploads/files/orders/images/order_A8a1_0.08967500 1544531124.png', 10, 5, 'qeyd edirem', 0, NULL, '2018-12-10', '2018-12-11', 14, 4, 5, NULL, NULL, NULL, '54.00', 30, '2018-12-11', 1, '2018-12-11 16:43:49', 22, NULL, NULL),
(63, 'test', 'dfbds', 'sdds', 'dmfef', '/uploads/files/orders/images/order_vzrU_0.13186000 1544531552.png', 10, 1, 'qeyd', 0, NULL, '2018-12-10', '2018-12-11', 22, 4, 5, NULL, NULL, NULL, '5.00', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(64, 'cerayan bloku', '120 Wt;  100-240V; output 18,5V 6,5A', 'Norton', 'https://www.amazon.co.uk/HP-665470-001-SPS-ADPT-NORTON-R-120W/dp/B008G42ABE', '/uploads/files/orders/images/order_A6CP_0.97157100 1544532792.jpg', 10, 5, NULL, 0, NULL, '2018-12-11', '2018-12-11', 44, 7, 5, NULL, NULL, NULL, '2.00', 30, '2018-12-11', 1, '2018-12-11 16:53:21', 44, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) CHARACTER SET utf8 NOT NULL,
  `token` varchar(191) CHARACTER SET utf8 NOT NULL,
  `created_at` datetime(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Purchases`
--

CREATE TABLE `Purchases` (
  `id` int(11) NOT NULL,
  `account_id` int(5) DEFAULT NULL,
  `muqavile_doc` longtext COLLATE utf8_unicode_ci,
  `muqavile_doc_date` date DEFAULT NULL,
  `odenish_date` date DEFAULT NULL,
  `qaime_doc` longtext COLLATE utf8_unicode_ci,
  `qaime_doc_date` date DEFAULT NULL,
  `AWB_Akt_doc` longtext COLLATE utf8_unicode_ci,
  `AWB_Akt_doc_date` date DEFAULT NULL,
  `icrachi_doc` longtext COLLATE utf8_unicode_ci,
  `icrachi_doc_date` date DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `delivery_person_id` int(11) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `Verilib_MHIS` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `Verilib_MHIS_date` date DEFAULT NULL,
  `Verilib_MS` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `Verilib_MS_date` date DEFAULT NULL,
  `AlternativeID` int(11) DEFAULT NULL,
  `Remark` longtext COLLATE utf8_unicode_ci,
  `status_id` int(11) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=MyISAM AVG_ROW_LENGTH=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Purchases`
--

INSERT INTO `Purchases` (`id`, `account_id`, `muqavile_doc`, `muqavile_doc_date`, `odenish_date`, `qaime_doc`, `qaime_doc_date`, `AWB_Akt_doc`, `AWB_Akt_doc_date`, `icrachi_doc`, `icrachi_doc_date`, `company_id`, `delivery_person_id`, `delivery_date`, `Verilib_MHIS`, `Verilib_MHIS_date`, `Verilib_MS`, `Verilib_MS_date`, `AlternativeID`, `Remark`, `status_id`, `deleted`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, 0, NULL, '2018-12-11', '2018-12-14'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, 0, NULL, '2018-12-11', '2018-12-14'),
(3, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, 0, NULL, '2018-12-12', '2018-12-14');

-- --------------------------------------------------------

--
-- Table structure for table `Reports`
--

CREATE TABLE `Reports` (
  `id` int(11) NOT NULL,
  `ReportNo` int(11) DEFAULT NULL,
  `MainPerson` int(11) DEFAULT NULL,
  `Subject` varchar(200) DEFAULT NULL,
  `Text` longtext,
  `ReportDocument` varchar(400) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(191) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(191) CHARACTER SET utf8 NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8 NOT NULL,
  `email` varchar(191) CHARACTER SET utf8 NOT NULL,
  `password` varchar(191) CHARACTER SET utf8 NOT NULL,
  `confirmed` tinyint(4) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `chief` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `slug`, `email`, `password`, `confirmed`, `deleted`, `deleted_at`, `remember_token`, `created_at`, `updated_at`, `DepartmentID`, `chief`) VALUES
(1, 'Sahib', 'Fermanli', 'sahib-fermanli-091666000-1537188393', 'sfermanli@swgh.az', '$2y$10$5WblgMR.T3fiI1TX.8OB4exH3KI2MMXbEkyq2UEnNE2tGd7901kzS', 1, 0, NULL, 'wBhQtxALQPzRFwo8m5yZXhTaerVWgyBCfiWpCZE0fml3IvCBP2FbhZJzfx1l', '2018-09-17', '2018-10-12', 6, 0),
(5, 'Nail', 'BALAYEV', 'nail-balayev-014991900-1537258165', 'nbalayev@swgh.az', '$2y$10$ui2Maq3vp8xdk63HwNQMfeWqLvHHhO9kftJ6l72pf6QQ.YGPpbx4W', 1, 0, NULL, 'GafbJ4X9klRX3fqqvcfLkczMSlJTOlkNdt5VzjlbqIw6x2inTypNNsQAhz4d', '2018-09-18', '2018-09-18', 6, 0),
(11, 'Department', 'DEPARTMENT', 'chief-chief-045639900-1537771612', 'department@swgh.az', '$2y$10$GSxB0.OMbjiZAEbasD2Nied6ZkMRSkU7w3xy7vgFqMzH7gfB215aq', 1, 0, NULL, '3le3mtTH8ukHo3stSUNXsCvX9lsSIXcB4zEHE0asi9ExaP4M0du2DE8uwyYF', '2018-09-24', '2018-10-04', 1, 1),
(12, 'Nail', 'BALAYEV', 'user-user-037764800-1537771688', 'EDIuser@swgh.az', '$2y$10$EQ5VKECbgSsda6xvNMkYP.Ff3c1ALNX48L/AlPq/qOkbuTnHeiFx2', 1, 0, NULL, 'tUz10M4wOAdQvxeIZQpXuilsm19tLP1mXFkMyEPQ7aFm4YxlB9ndYCTbSmFL', '2018-09-24', '2018-09-24', 1, 0),
(14, 'Test', 'Supply', 'tech-user-034794900-1537774299', 'supply@swgh.az', '$2y$10$VJXgI9dfKthhsGi7gAzlYOUXRwwOOOqY09IXZYz0vAGdS2oixsohq', 1, 0, NULL, 'b9vvPbEFlRlPGbdjeQPQjE9E2S8VoOR53R5Z1Mppb0Bn6lSCNeIGTw2PMpv0', '2018-09-24', '2018-10-12', 4, 0),
(33, 'Vüqar', 'NOVRUZOV', 'vuqar-novruzov-014855500-1539262094', 'vnovruzov@swgh.az', '$2y$10$mtuaKgkB0V4ipl732FED8ObREOmBbbrM9MvX3PNTEt8aHNz4FHK5S', 1, 0, NULL, 'g6AEHFDVtNLL2vafnnt8aF4tKzax1fYQXDy3wIPgMczxTrFrQUVimSv6tBZq', '2018-10-11', '2018-11-15', 1, 1),
(32, 'Mirzə', 'HÜSEYNOV', 'mirze-huseynov-029784200-1539261854', 'MiHuseynov@swgh.az', '$2y$10$Lu/kSMaFXBOyl67ahMJ36.CxvoUFLVgyz.EeNsLQgdICirUAGIm9e', 1, 0, NULL, 'doDueghz5B4QeP3ZZFeVjAOeVmQ7VpI4VkQVopi7f5wsePT3Cq68zQSiYqZA', '2018-10-11', '2018-11-02', 4, 0),
(31, 'Mahir', 'QURBANOV', 'mahir-qurbanov-002300400-1539261151', 'mgurbanov@swgh.az', '$2y$10$A9F1RtEirewULfgd/ShBtO0LgAk36oBC3UWU6BaNhTctuhFcKYA7G', 1, 0, NULL, 'jyG9Zp2BiLyIx2uLO8qhDG34kVyNOBhvN9mD7I3tnelH99Ur3alspeUGeLMG', '2018-10-11', '2018-10-11', 4, 0),
(30, 'Vüqar', 'FƏRƏCOV', 'vuqar-ferecov-099383400-1539261111', 'vfaradjov@swgh.az', '$2y$10$5WblgMR.T3fiI1TX.8OB4exH3KI2MMXbEkyq2UEnNE2tGd7901kzS', 1, 0, NULL, 'kDtNnOgzj60iq35n0U6ZWoXB2kNmEq1TuC4P8IPQhamTWx2GdkECtF8cpehu', '2018-10-11', '2018-10-12', 4, 0),
(29, 'Toğrul', 'BAYRAMOV', 'togrul-bayramov-049793400-1539261070', 'tbayramov@swgh.az', '$2y$10$WUoBBguhaqQz2O4psMrb4OIAVeMlxy1TuaCW0MSucKa7s5RInm7O6', 1, 0, NULL, 'w8esUF4mpp2qMqeQmFb98Gv1ZlKsNZwUcyswhKXUzNwPqRVKLHX8nfOKy2W1', '2018-10-11', '2018-10-11', 4, 0),
(28, 'Abbas', 'MEHTİZADƏ', 'abbas-mehtizade-096648300-1539261020', 'amehtizade@swgh.az', '$2y$10$er3xD9p/fj5QGykiMGafQe2N2Bj0/Ca8VB6xgZM8m2bcaAKS4n7Z6', 1, 0, NULL, 'tLtfxNvGCj6OsxKRFFqHDrYjW07WUiMY6RC0EK14f7L2hhvAlfQMJ82rlNXT', '2018-10-11', '2018-10-16', 4, 0),
(22, 'Elman', 'MUSAYEV', 'elman-musayev-019502500-1539257621', 'ElMusayev@swgh.az', '$2y$10$5WblgMR.T3fiI1TX.8OB4exH3KI2MMXbEkyq2UEnNE2tGd7901kzS', 1, 0, NULL, 'QntpHgSEhyTjQbBmgNHipRXB98DDQQCByqtV3sr2taICVIOujneKB5qTcZKg', '2018-10-11', '2018-10-11', 4, 1),
(21, 'Həmid', 'AXUNDLU', 'hemid-axundlu-004136100-1539257529', 'Akhundlu@swgh.az', '$2y$10$H/UMb/YACsSfhsgftSGc5Om0zSnVb42LrZmDX.BXeJeAWqgCH61e2', 1, 0, NULL, 'NmSSb86ecMcYg7UiRKpU8DpwtJv9Ww5MINTrinrXldqhAXNvxgyXdvteOL9o', '2018-10-11', '2018-10-23', 5, 0),
(20, 'Musa', 'ƏLİYEV', 'musa-eliyev-061918000-1539257318', 'MAliyev@swgh.az', '$2y$10$YIxDZUOMYehEhnTXsdMuCOnioYPvCs2U7MqOB6LXy1qoYg7C/92', 1, 0, NULL, 'GGValzsNbul0uCHRIB2v7KNbNDNZImc5CJEEBmriTqC938RlOVOcOsEi3DF4', '2018-10-11', '2018-10-11', 2, 1),
(19, 'Elsevər', 'XƏLİLOV', 'elsever-xelilov-052376900-1539257191', 'exalilov@swgh.az', '$2y$10$my/3hR.giqo9bRU.rx9FGu3dTVeR73MK6mP2ys/8lR2QV3t/2EIoC', 1, 0, NULL, 'U7IhB9zKOlG33uNOKdYEB5x3ZhiVyf9AWOLfNymW0bhP0WacS6ToYLIBK1uW', '2018-10-11', '2018-10-23', 2, 1),
(18, 'Elçin', 'HƏSƏNOV', 'elcin-hesenov-039641500-1539257130', 'e.hasanov@swgh.az', '$2y$10$Rlq.x54uW/XYyqfedbF64eNDh6IU7aum6mjQs.Acd8IsVGUaBrygq', 1, 0, NULL, 'KVyy4yL2ZjQwqiEq6foYFaYwGwAF3QVLIFToRN9kdoOXS0pzFuDIrUiX3d', '2018-10-11', '2018-10-11', 2, 0),
(16, 'Director', 'DİREKTOR', 'director-director-084599400-1538138215', 'director@swgh.az', '$2y$10$whd.leOBrmpVNlgNhYZMfehiBd5wVLEv4klkAQJqupqaE2Xsote9i', 1, 0, NULL, '6VHqPMOgyEOF00fpt8FhY3Jy8YxufS12OpY8zhFzlZzYmOjttek74BOYGS0s', '2018-09-28', '2018-09-28', 5, 0),
(43, 'Farid', 'Bayramov', 'farid-bayramov-041255300-1542550027', 'bayramoff.farid@gmail.com', '$2y$10$/Mccqacrf5GLMtJ8sAhJoe02vR8i9X/YztNbdKDAetcBbd3GFRQga', 1, 1, NULL, 'wUTxaPS7bCUdLYGitaMapTqOBw6g9abTmLaJxk0J49bI0Bk1toeD4f4lkiDg', '2018-11-18', '2018-12-04', 1, 0),
(38, 'sahib_cargos', 'cargos', 'sahib-cargos-cargos-066363800-1541072996', 'swgsw@swgh.az', '$2y$10$CgsH9gzKZZwL6g6ByR0.g.dF.JlpR6kklFwS0H.LhjSkbNpTKv8fq', 0, 0, NULL, 'NexjJw0VtEoGR7PYdM0pigUnFrObHo8h89fXcbjUJZ6IPlyTFUHz8Y1gFUOu', '2018-11-01', '2018-11-01', 5, 0),
(39, 'Fərhad', 'Ezizov', 'ferhad-ezizov-060497500-1541073122', 'ferrane1889@mail.ru', '$2y$10$FAdZ8gruTyUsjOHrD7a4DO6AcF9xjv0Vii.D7PziUckmDshcsqKVy', 1, 1, NULL, 'lQtmr0ZYbSkxVxCG3X8Tro2vvVoXAeN3XWJhTit8FCYjPI126lU6fIWmIMi3', '2018-11-01', '2018-12-04', 1, 0),
(44, 'Emil', 'Elibalayev', 'emil-elibalayev-024929700-1544532588', 'emil@swgh.az', '$2y$10$jpxESP55H7YSQCRvuJqreeW/uasl1Qe4OrS5yyki6iyuDn57hblnS', 1, 0, NULL, 'ZnNYk7NzkRHkgaXjdKzNMbAhHW4jt5mpu6xFYy33kOjdP3rxcqZyR5IPpElo', '2018-12-11', '2018-12-11', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `___Dislocation`
--

CREATE TABLE `___Dislocation` (
  `id` int(11) NOT NULL,
  `Dislocation` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Terminal` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Zone` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Floor` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Room` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `EquipmentID` int(11) DEFAULT NULL,
  `MountingDate` date DEFAULT NULL,
  `Status` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `Remark` longtext COLLATE utf8_unicode_ci,
  `edited_by` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime(3) DEFAULT NULL,
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `___Equipments`
--

CREATE TABLE `___Equipments` (
  `id` int(11) NOT NULL,
  `Equipment` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `PartNo` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `SerialNo` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `category` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `PurchaseID` int(11) DEFAULT NULL,
  `Status` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Remark` longtext COLLATE utf8_unicode_ci,
  `edited_by` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime(3) DEFAULT NULL,
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `authorities`
--
ALTER TABLE `authorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deadlines`
--
ALTER TABLE `deadlines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Departments`
--
ALTER TABLE `Departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_Alternatives`
--
ALTER TABLE `lb_Alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_categories`
--
ALTER TABLE `lb_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_countries`
--
ALTER TABLE `lb_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_currencies_list`
--
ALTER TABLE `lb_currencies_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_positions`
--
ALTER TABLE `lb_positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_status`
--
ALTER TABLE `lb_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_units_list`
--
ALTER TABLE `lb_units_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_vehicles_list`
--
ALTER TABLE `lb_vehicles_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Purchases`
--
ALTER TABLE `Purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Reports`
--
ALTER TABLE `Reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `___Dislocation`
--
ALTER TABLE `___Dislocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `___Equipments`
--
ALTER TABLE `___Equipments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `authorities`
--
ALTER TABLE `authorities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `deadlines`
--
ALTER TABLE `deadlines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Departments`
--
ALTER TABLE `Departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `lb_Alternatives`
--
ALTER TABLE `lb_Alternatives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `lb_categories`
--
ALTER TABLE `lb_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `lb_countries`
--
ALTER TABLE `lb_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT for table `lb_currencies_list`
--
ALTER TABLE `lb_currencies_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `lb_positions`
--
ALTER TABLE `lb_positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `lb_status`
--
ALTER TABLE `lb_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `lb_units_list`
--
ALTER TABLE `lb_units_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `lb_vehicles_list`
--
ALTER TABLE `lb_vehicles_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `Purchases`
--
ALTER TABLE `Purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Reports`
--
ALTER TABLE `Reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `___Dislocation`
--
ALTER TABLE `___Dislocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `___Equipments`
--
ALTER TABLE `___Equipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
