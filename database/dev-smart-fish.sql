-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 02, 2024 at 09:30 AM
-- Server version: 8.0.36-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev-smart-fish`
--

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(189) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Slug for the title',
  `sub_title` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `parent_id` bigint UNSIGNED DEFAULT '0',
  `lft` int DEFAULT '0',
  `rgt` int DEFAULT '0',
  `depth` int DEFAULT '0',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_in_home_button` tinyint(1) NOT NULL DEFAULT '0',
  `is_in_home_card` tinyint(1) NOT NULL DEFAULT '0',
  `home_card_icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_card_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abouts`
--

INSERT INTO `abouts` (`id`, `title`, `slug`, `sub_title`, `image`, `description`, `parent_id`, `lft`, `rgt`, `depth`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `is_in_home_button`, `is_in_home_card`, `home_card_icon`, `home_card_description`) VALUES
(1, 'Our Inception', 'our-inception', 'Know how we started our magical journey', 'uploads/Jol Rong.jpg', '<p>Our story began in 1981, in the hands of visionary Major General Amjad Khan Chowdhury. He saw an excellent business opportunity in Bangladesh&rsquo;s optimal cultivating environment. This inspired him to create an epoch-making business to redefine the nation&rsquo;s food manufacturing industry while serving society and its people. And that&rsquo;s how was born.</p>\n\n<p>Later in 1986, extended its operations by entering into agriculture through contract farming, and in 1992, with its food processing plant in Ghorashal, further established its position in the industry.</p>', 4, 23, 24, 2, 1, '2022-10-15 13:11:35', '2022-10-26 22:41:18', NULL, 0, 1, 'uploads/abouts/221026-223312.png', 'The journey of started from 1981 and its evolution to one of the top food manufacturing companies that have set the grounds for development for any potentialities.'),
(2, 'Mission & Vision', 'mission-vision', NULL, 'uploads/Jol Rong.jpg', '<h2><em>Our Vision</em></h2>\n\n<p>Improving Livelihood</p>\n\n<h2><em>Our Mission</em></h2>\n\n<p>Poverty &amp; hunger are curses. Our aim is to generate employment and&nbsp;earn dignity &amp;&nbsp;self-respect for our compatriots through profitable enterprises.</p>', 4, 5, 6, 2, 1, '2022-10-15 14:31:56', '2022-10-26 22:41:33', NULL, 0, 1, 'uploads/abouts/221026-223343.png', 'At we aspire to generate employment and earn dignity and self-respect for our compatriots through profitable enterprises.'),
(3, 'Corporate Values', 'corporate-values', 'Our principles are the driving force behind our success.', 'uploads/Jol Rong.jpg', '<p>We take pride in our hard work and continuous efforts that made us become &mdash; a name, a face, an organization of marvelous performance, leaving positive marks on the native, as well as on global grounds in the course.</p>\n\n<p>is a corporation that firmly believes in providing equal opportunity for everyone, and our talent management has ensured the perfect atmosphere for the workforce, enabling them to work together as a team. Besides, we take every complaint and suggestion with the utmost sincerity to improve the workplace for all. Professional integrity is highly maintained and is, in fact, the core of our work policy.</p>\n\n<p>Above all, as a company, truly believes in dedicating itself for the benefit of its stakeholders and society at large. We practice the values we uphold and therefore, through our actions, we help the economic progress, and with its growth, the people living inside the economy also advance.</p>', 4, 11, 12, 2, 1, '2022-10-15 14:39:15', '2022-10-26 22:41:59', NULL, 0, 1, 'uploads/abouts/221026-223351.png', 'We view our consumers as our king and us as their partners. Our consumers have given us great success over the years.'),
(4, 'M/S Maher Brothers', 'maher-brothers', 'An organization of all strength', 'uploads/Jol Rong.jpg', '<p>The main aim of this organization is to supply good quality products &amp; gain customers Trust. We have very strong brands, core values &amp; trusted business partners which gives us the strength to move forward to gain valuable customers</p>', NULL, 2, 31, 1, 1, '2022-10-15 21:39:51', '2022-10-26 22:42:15', NULL, 1, 1, 'uploads/abouts/221026-223409.png', 'lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
(6, 'Education', 'education', 'lorem ipsum dolor sit amet, consectetur adipiscing elit', 'uploads/Jol Rong.jpg', '<p>lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\n\n<p><img alt=\"\" src=\"https://www.pranfoods.net/sites/default/files/rsz_education_11zon_1.jpg\" /></p>\n\n<p>Public School</p>', 4, 15, 16, 2, 1, '2022-10-15 14:42:12', '2022-10-26 21:54:29', NULL, 0, 0, NULL, NULL),
(7, 'Community Development', 'community-development', 'We’ve dedicated ourselves to uphold the communities, to improve their livelihood.', 'uploads/Jol Rong.jpg', '<p>Life is always about helping each other and lifting up one another when in need. Community development is one core objective that we rely on. We at, love to engage with millions of people in our daily life starting from the farmers, employers, clients and the consumers.&nbsp;&nbsp;</p>\n\n<p>We&rsquo;re always involved in helping people come together to have a better community.&nbsp; In addition, we always explore all opportunities that&rsquo;ll help individuals, families and communities to achieve long-lasting goals.</p>\n\n<p>Whether by repairing and developing the transportation network, extending supports to the poor, distributing relief among flood victims, or supporting all religious institutions was always ready to come forward and support.&nbsp;</p>\n\n<p>The ones who are in greatest need we always held our main focus towards them and their growth. Which is why we&rsquo;ve introduced contract farming, a new concept in Bangladesh, to enhance their livelihood by creating employment opportunities. More than 100,000 contract farmers are growing the ingredients for. We provide them with assistance, tools and financial supports.</p>\n\n<p>Nutrition has been our great concern which is why we established Dairy Hub to support the dairy farmers. We&rsquo;re currently working with more than 100,000 farmers of 87 villages from 18 different districts in North Bengal.&nbsp; We are supporting backward supplier through agro farming and also helping with the production of different crops, fruits and vegetable, as a whole which is called contract farming.&nbsp; Through these, we can help the underprivileged lift themselves out of poverty and lead the nation to prosperity.</p>', 4, 17, 18, 2, 1, '2022-10-15 14:43:07', '2022-10-26 22:42:29', NULL, 0, 1, 'uploads/abouts/221026-223417.png', 'The Newsroom is the source of news and information related to Foods. From company announcements to latest brands, all updated information can be found here.'),
(8, 'Environment', 'environment', 'Our motto is to grow in a way that helps to minimize our environmental impacts and promotes a clean, healthy and hygienic ecosystem.', 'uploads/Jol Rong.jpg', '<p>prioritizes environmental sustainability were we think green and work green. Our motto is to achieve a Sustainable Green Planet someday. To protect and conserve this beautiful mother earth we are taking few green initiatives into account.&nbsp;</p>\n\n<p>1. Energy Conservation and preservation</p>\n\n<p>2. ETP</p>\n\n<p>3. The 3R&rsquo;s ( Reduce, Reuse &amp;Recycle)&nbsp;</p>\n\n<p>4. Tree plantation</p>\n\n<p>Furthermore, we have also generated three Effluent Treatment Plants (ETP) to ensure safe factory.</p>\n\n<p>Wastage disposal, community forestation program to balance out carbon dioxide amount in the air, heat recovery boiler for efficient reuse of the heat from production and we&rsquo;ve also switched to fossil fuel and powered trucks to reduce air pollution. Additionally, we utilize daylight with sky-light roof and CFL Bulbs at all our offices and factories to reduce power consumption.</p>', 4, 21, 22, 2, 1, '2022-10-15 14:44:01', '2022-10-26 22:42:47', NULL, 0, 1, 'uploads/abouts/221026-223359.png', 'In the global market, we truly strive to exceed ourselves every year. Therefore, we are growing in whichever market we operate.'),
(9, 'Career', 'career', 'Join to evolve professionally and be a part of our success.', 'uploads/Jol Rong.jpg', '<p>We believe in growth, accomplishment and passion. We are always on a talent hunt for people who have any of these three beliefs in them.</p>\n\n<p>We test our employees with challenges so that they can explore their inner talent about how far they could go and mark themselves out to be different from the rest of the others.&nbsp;</p>\n\n<p>We don&rsquo;t differentiate rather we welcome everyone who has the willingness to bring in change to the company and help it grow.</p>', 4, 25, 26, 2, 1, '2022-10-15 14:44:34', '2022-10-26 21:54:29', NULL, 1, 0, NULL, NULL),
(10, 'Subscribe', 'subscribe', 'Stay close to us and stay connected to us. For regular updates please subscribe!', 'uploads/Jol Rong.jpg', NULL, 4, 29, 30, 2, 1, '2022-10-15 14:45:28', '2022-10-26 21:54:29', NULL, 0, 0, NULL, NULL),
(11, 'Contact Us', 'contact-us', 'You’ve got questions? We have your answers. You can reach us through……', 'uploads/Jol Rong.jpg', NULL, 4, 27, 28, 2, 1, '2022-10-15 14:46:16', '2022-10-26 21:54:29', NULL, 1, 0, NULL, NULL),
(12, 'Who We Are', 'who-we-are', 'is the largest food-beverage company in Bangladesh and admired by millions of people globally. Know our story and who we are.', 'uploads/Jol Rong.jpg', '<p>means life, and we stand for the taste of life. Every day we&rsquo;re sending out this taste to 145 countries with our numerous agro-food products of 10 different categories, including snacks, confectionery, dairy, juices, carbonated beverages, mineral water, baked items, culinary, drinks and biscuits. We&rsquo;re the largest food-beverage company in Bangladesh and admired by millions of people globally.</p>\n\n<p>Since the beginning of in 1981, we&rsquo;ve been working to improve rural livelihood by contributing to the rural and national economies, creating employment and exporting.</p>\n\n<p>has devoted itself to the betterment of society and environment. That&rsquo;s why we&rsquo;re continuously extending our help to the communities and finding ways to reduce our environmental footprints to achieve a greener earth.</p>', 4, 19, 20, 2, 1, '2022-10-18 16:14:57', '2022-10-26 21:54:29', NULL, 0, 0, NULL, NULL),
(13, 'Founder & MD', 'founder', 'Alhaj Mir Mohibur Rahman', 'uploads/Screenshot_3.png', '<p>&nbsp;</p>\n\n<h3><strong>Alhaj Mir Mohibur Rahman</strong></h3>\n\n<p><br />\n<img alt=\"\" src=\"/uploads/221026-203850.png\" style=\"float:left; height:100px; margin-left:10px; margin-right:10px; width:84px\" />Founder &amp; MD of M/S Maher Brother&rsquo;s. In 1986 he establishes this great organization focusing the demand of the customers &amp; be a trustable business partner for all. Day by day many reputed companies &amp; organizations joined Maher brothers to increase the strength of the organization.</p>\n\n<p>&nbsp;</p>', 4, 3, 4, 2, 1, '2022-10-26 20:28:33', '2022-11-01 02:36:19', NULL, 0, 0, NULL, NULL),
(14, 'General Information', 'general-information', 'An organization of all strength', 'uploads/Jol Rong.jpg', '<p><strong>M/S Maher Brothers</strong><br />\nLaldhigirpar Road, Kalighat, Sylhet, Bangladesh.<br />\nTelephone: 02996635946 Zip Code: 3100<br />\nWeb: www.maherbrothers.com.bd<br />\n<br />\n<strong>Managing Director</strong>: Alhaj Mir Mohibur Rahman<br />\nPermanent Address: House # 15, Road # 2911, Block # D, Shahjalal Uposhohar, Sylhet.<br />\n<br />\n<strong>Chief Executive Director</strong>: Taher Ahmed<br />\nE-mail: taher.ahmed3t@gmail.com<br />\nDate of Birth: 27 Nov 1991<br />\nContact Number: +8801711041232<br />\n<strong><em>Educational Qualification</em></strong>:<br />\nMSc in Chemistry, Sylhet<br />\nMC College. BSc in Chemistry, Sylhet MC College.<br />\nHSC from Sylhet MC College.<br />\nSSC From Sylhet Govt. Pilot High School.</p>', 4, 13, 14, 2, 1, '2022-10-26 20:52:18', '2022-10-26 21:54:29', NULL, 0, 0, NULL, NULL),
(15, 'Business Information', 'business-information', 'Exclusive Distributor of Basundhara group since 2018', 'uploads/Jol Rong.jpg', '<p><u><b>Bulk Dealer Of:<br></b></u><span style=\"font-size: 1rem;\">• Meghna Group of Industries.<br></span><span style=\"font-size: 1rem;\">• City Group of Industries.<br></span><span style=\"font-size: 1rem;\">• 3. T.K Group of Industries.<br></span><span style=\"font-size: 1rem;\">• ACI Group of Industries.<br></span><span style=\"font-size: 1rem;\">• Bashundhara Group of Industries.<br></span><span style=\"font-size: 1rem;\">• Deshbandhu Group of Industries.<br></span><span style=\"font-size: 1rem;\">• Bangladesh Edible Oil Limited.</span></p><p><u><b>Manpower Status:<br></b></u><span style=\"font-size: 1rem;\">• Total SR 05.<br></span><span style=\"font-size: 1rem;\">• Total Delivery man 20.<br></span><span style=\"font-size: 1rem;\">• Total Manager 04.<br></span><span style=\"font-size: 1rem;\">• Office Assistant 2.</span></p><p><u style=\"\"><b>Ware House:<br></b></u><span style=\"font-size: 1rem;\">• Number of warehouses 08.</span></p><p><u style=\"\"><b>Banking Partner:<br></b></u><span style=\"font-size: 1rem;\">1. Pubali Bank.<br></span><span style=\"font-size: 1rem;\">2. IFIC Bank.<br></span><span style=\"font-size: 1rem;\">3. Bank ASIA.<br></span><span style=\"font-size: 1rem;\">4. Premier Bank.<br></span><span style=\"font-size: 1rem;\">5. National Bank.<br></span><span style=\"font-size: 1rem;\">6. City Bank.<br></span><span style=\"font-size: 1rem;\">7. Uttara Bank.<br></span><span style=\"font-size: 1rem;\">8. One Bank.<br></span><span style=\"font-size: 1rem;\">9. UCB Bank.</span></p><p><u style=\"\"><b> Yearly Turnover:<br></b></u><span style=\"font-size: 1rem;\">• Yearly turnover from Business 1.5 million.</span></p>', 4, 7, 8, 2, 1, '2022-10-26 21:12:12', '2022-10-26 21:54:29', NULL, 0, 0, NULL, NULL),
(16, 'Why JTI?', 'why-jti', 'Why we want to do business with JTI?', 'uploads/Jol Rong.jpg', '<p>JTI is a multinational organization where they have good cultures,\nworld leading international brands, employee-oriented company &amp;\nrenowned as 2nd largest tobacco company in the world. Being a part\nof their business, our strength will be enriched &amp; our heritage will go\nup. M/S Maher Brother’s reputation &amp; JTI brands-values will help both\nof us to build strong markets in Sylhet. Especially we believe in\nhonesty and hard work. We always love to take new Challenges &amp;\nopportunities. We are currently leading locally. Our efforts will always\ncontinue.<br></p>', 4, 9, 10, 2, 1, '2022-10-26 21:54:12', '2022-10-26 21:54:29', NULL, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aerators`
--

CREATE TABLE `aerators` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `run_status` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aerators`
--

INSERT INTO `aerators` (`id`, `name`, `serial_number`, `slug`, `description`, `run_status`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Aerator 1', 'aerator-1', 'aerator-1', NULL, 'off', 'active', 4, '2024-03-12 20:19:30', '2024-03-12 20:19:30', NULL),
(2, 'Aerator 2', 'aerator-2', 'aerator-2', NULL, 'off', 'active', 4, '2024-03-12 20:19:30', '2024-03-12 20:19:30', NULL),
(3, 'Aerator 3', 'aerator-3', 'aerator-3', NULL, 'off', 'active', 4, '2024-03-12 20:19:30', '2024-03-12 20:19:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aerator_project`
--

CREATE TABLE `aerator_project` (
  `aerator_id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aerator_project`
--

INSERT INTO `aerator_project` (`aerator_id`, `project_id`) VALUES
(1, 1),
(3, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `controllers`
--

CREATE TABLE `controllers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `controllers`
--

INSERT INTO `controllers` (`id`, `name`, `slug`, `description`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Controller 1', 'controller-1', NULL, 'active', 4, '2024-03-06 01:47:39', '2024-03-06 01:47:39', NULL),
(2, 'Controller 2', 'controller-2', NULL, 'active', 4, '2024-03-06 01:48:48', '2024-03-06 01:48:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `controller_project`
--

CREATE TABLE `controller_project` (
  `controller_id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `controller_project`
--

INSERT INTO `controller_project` (`controller_id`, `project_id`) VALUES
(1, 1),
(2, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `controller_sensor`
--

CREATE TABLE `controller_sensor` (
  `sensor_id` bigint UNSIGNED NOT NULL,
  `controller_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `controller_sensor`
--

INSERT INTO `controller_sensor` (`sensor_id`, `controller_id`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feeders`
--

CREATE TABLE `feeders` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `run_status` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feeders`
--

INSERT INTO `feeders` (`id`, `name`, `serial_number`, `slug`, `description`, `run_status`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Feeder 1', 'feeder-1', 'feeder-1', NULL, 'off', 'active', 4, '2024-03-12 20:19:30', '2024-03-12 20:19:30', NULL),
(2, 'Feeder 2', 'feeder-2', 'feeder-2', NULL, 'off', 'active', 4, '2024-03-12 20:19:30', '2024-03-12 20:19:30', NULL),
(3, 'Feeder 3', 'feeder-3', 'feeder-3', NULL, 'off', 'active', 4, '2024-03-12 20:19:30', '2024-03-12 20:19:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feeder_histories`
--

CREATE TABLE `feeder_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `feeder_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `run_time` decimal(8,2) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `unit` enum('kg','g') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kg',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feeder_histories`
--

INSERT INTO `feeder_histories` (`id`, `feeder_id`, `date`, `time`, `run_time`, `amount`, `unit`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2024-03-16', '00:47:00', '2.00', '12.00', 'kg', 4, '2024-03-16 00:47:14', '2024-03-16 00:47:14', NULL),
(2, 2, '2024-03-16', '00:47:00', '3.00', '13.00', 'kg', 4, '2024-03-16 00:47:29', '2024-03-16 00:47:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feeder_project`
--

CREATE TABLE `feeder_project` (
  `feeder_id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feeder_project`
--

INSERT INTO `feeder_project` (`feeder_id`, `project_id`) VALUES
(2, 1),
(2, 2),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `fishes`
--

CREATE TABLE `fishes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fishes`
--

INSERT INTO `fishes` (`id`, `name`, `slug`, `image`, `description`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Fish 1', 'fish-1', 'uploads/fish/download.jpeg', '<p>&nbsp;</p>\n<div id=\"inspect-element-top-layer\" style=\"pointer-events: none; border: unset; padding: 0px;\" data-inspect-element=\"inspectElement\"></div>', 'active', 4, '2024-03-12 15:45:00', '2024-03-12 15:45:00', NULL),
(2, 'Fish 2', 'fish-2', 'uploads/fish/product_1584685121.jpg', '<p>&nbsp;</p>\n<div id=\"inspect-element-top-layer\" style=\"pointer-events: none; border: unset; padding: 0px;\" data-inspect-element=\"inspectElement\"></div>', 'active', 4, '2024-03-12 15:45:14', '2024-03-12 15:45:14', NULL),
(3, 'Fish 3', 'fish-3', 'uploads/fish/tilapia-fish1.jpg', '<p>&nbsp;</p>\n<div id=\"inspect-element-top-layer\" style=\"pointer-events: none; border: unset; padding: 0px;\" data-inspect-element=\"inspectElement\"></div>', 'active', 4, '2024-03-12 15:45:30', '2024-03-12 15:45:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fish_weights`
--

CREATE TABLE `fish_weights` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `fish_id` bigint UNSIGNED NOT NULL,
  `weight` decimal(8,2) NOT NULL DEFAULT '0.00',
  `weight_in_24_hours` decimal(8,2) NOT NULL DEFAULT '0.00',
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fish_weights`
--

INSERT INTO `fish_weights` (`id`, `date`, `time`, `fish_id`, `weight`, `weight_in_24_hours`, `description`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2024-03-12', '15:55:00', 2, '12.00', '12.00', '<p>&nbsp;</p>\n<div id=\"inspect-element-top-layer\" style=\"pointer-events: none; border: unset; padding: 0px;\" data-inspect-element=\"inspectElement\"></div>', 'active', 4, '2024-03-12 15:53:01', '2024-03-12 15:53:01', NULL),
(2, '2024-03-12', '15:55:00', 1, '12.00', '12.00', '<p>&nbsp;</p>\n<div id=\"inspect-element-top-layer\" style=\"pointer-events: none; border: unset; padding: 0px;\" data-inspect-element=\"inspectElement\"></div>', 'active', 4, '2024-03-12 15:53:01', '2024-03-12 15:53:01', NULL),
(3, '2024-03-12', '15:55:00', 3, '12.00', '12.00', '<p>&nbsp;</p>\n<div id=\"inspect-element-top-layer\" style=\"pointer-events: none; border: unset; padding: 0px;\" data-inspect-element=\"inspectElement\"></div>', 'active', 4, '2024-03-12 15:53:01', '2024-03-12 15:53:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `footer_links`
--

CREATE TABLE `footer_links` (
  `id` bigint UNSIGNED NOT NULL,
  `footer_link_group_id` bigint UNSIGNED NOT NULL,
  `title` varchar(189) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT '0',
  `lft` int DEFAULT '0',
  `rgt` int DEFAULT '0',
  `depth` int DEFAULT '0',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_links`
--

INSERT INTO `footer_links` (`id`, `footer_link_group_id`, `title`, `url`, `parent_id`, `lft`, `rgt`, `depth`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 2, 'Standard License 1', '/pricing/purchase/standard-license-1', 0, 0, 0, 0, 1, '2022-10-19 21:44:33', '2023-01-14 21:22:09', NULL),
(5, 2, 'Extended License', '/pricing/purchase/extended-license', 0, 0, 0, 0, 1, '2022-10-19 21:44:59', '2023-01-14 21:23:03', NULL),
(6, 2, 'Extended License 1', '/pricing/purchase/extended-license-1', 0, 0, 0, 0, 1, '2022-10-19 21:46:33', '2023-01-14 21:23:02', NULL),
(7, 2, 'Standard License', '/pricing/purchase/standard-license', 0, 0, 0, 0, 1, '2022-10-19 21:47:06', '2023-01-14 21:21:54', NULL),
(8, 3, 'Achievements', '/achievements', 0, 0, 0, 0, 1, '2022-10-19 21:47:28', '2022-10-19 21:47:28', NULL),
(9, 3, 'Global Footprint', '/global-footprint', 0, 0, 0, 0, 1, '2022-10-19 21:47:43', '2022-10-19 21:47:43', NULL),
(10, 3, 'Exported Regions', '/exported-regions', 0, 0, 0, 0, 1, '2022-10-19 21:48:04', '2022-10-19 21:48:04', NULL),
(11, 4, 'Latest News', '/latest-news', 0, 0, 0, 0, 1, '2022-10-19 21:50:50', '2022-10-19 21:51:43', NULL),
(12, 4, 'Newsletters', '/newsletters', 0, 0, 0, 0, 1, '2022-10-19 21:51:02', '2022-10-19 21:51:02', NULL),
(13, 4, 'Media', '/media', 0, 0, 0, 0, 1, '2022-10-19 21:51:16', '2022-10-19 21:51:16', NULL),
(14, 1, 'Privacy Policy', '/privacy-policy', 0, 0, 0, 0, 1, '2023-01-01 06:42:50', '2023-01-01 06:42:50', NULL),
(15, 1, 'Terms of Condition', '/terms-of-condition', 0, 0, 0, 0, 1, '2023-01-01 06:43:16', '2023-01-01 06:43:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `footer_link_groups`
--

CREATE TABLE `footer_link_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(189) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` enum('top','bottom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'top',
  `parent_id` bigint UNSIGNED DEFAULT '0',
  `lft` int DEFAULT '0',
  `rgt` int DEFAULT '0',
  `depth` int DEFAULT '0',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_link_groups`
--

INSERT INTO `footer_link_groups` (`id`, `title`, `slug`, `position`, `parent_id`, `lft`, `rgt`, `depth`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'About', 'about', 'top', NULL, 6, 7, 1, 1, '2022-10-19 21:41:50', '2022-10-20 01:30:22', NULL),
(2, 'Pricings', 'products', 'top', NULL, 4, 5, 1, 1, '2022-10-19 21:42:07', '2023-01-14 21:23:52', NULL),
(3, 'Global Reach', 'global-reach', 'top', NULL, 8, 9, 1, 1, '2022-10-19 21:42:17', '2022-10-20 01:30:22', NULL),
(4, 'News & Events', 'news-events', 'top', NULL, 2, 3, 1, 1, '2022-10-19 21:42:26', '2022-10-20 01:30:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2015_08_04_131614_create_settings_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2020_03_31_114745_remove_backpackuser_model', 1),
(7, '2022_06_01_104720_create_route_lists_table', 1),
(8, '2022_09_11_134122_create_orders_table', 1),
(9, '2022_10_14_192623_create_permission_tables', 1),
(10, '2022_10_15_123632_create_abouts_table', 1),
(11, '2022_10_18_175147_create_socials_table', 1),
(12, '2022_10_19_130816_create_footer_link_groups_table', 1),
(13, '2022_10_19_140354_create_footer_links_table', 1),
(14, '2022_11_01_173734_create_contact_us_table', 1),
(15, '2022_12_20_041513_create_jobs_table', 1),
(16, '2023_01_17_234129_create_user_details_table', 1),
(17, '2024_03_05_222311_create_sensor_types_table', 1),
(18, '2024_03_05_222312_create_sensors_table', 1),
(19, '2024_03_05_222313_create_sensor_units_table', 1),
(20, '2024_03_05_224244_create_projects_table', 1),
(21, '2024_03_05_232259_create_controllers_table', 1),
(22, '2024_03_06_011831_create_controller_sensor_table', 1),
(23, '2024_03_06_011927_create_controller_project_table', 1),
(24, '2024_03_06_011927_create_project_sensor_table', 1),
(25, '2024_03_12_152018_create_fishes_table', 1),
(26, '2024_03_12_152032_create_fish_weights_table', 1),
(27, '2024_03_12_200354_create_feeders_table', 1),
(28, '2024_03_12_200403_create_aerators_table', 1),
(29, '2024_03_12_225855_create_aerator_project_table', 1),
(30, '2024_03_12_225916_create_feeder_project_table', 1),
(31, '2024_03_16_002210_create_feeder_histories_table', 1),
(32, '2024_03_23_162629_create_switch_types_table', 1),
(33, '2024_03_23_162630_create_switches_table', 1),
(34, '2024_03_23_162631_create_switch_units_table', 1),
(35, '2024_03_23_162915_create_ponds_table', 1),
(36, '2024_03_23_194056_create_sensor_type_sensor_unit_table', 1),
(37, '2024_03_23_194056_create_switch_type_switch_unit_table', 1),
(38, '2024_03_23_195141_create_pond_sensor_unit_table', 1),
(39, '2024_03_23_195141_create_pond_switch_unit_table', 1),
(40, '2024_04_01_002246_create_mqtt_data_table', 2),
(41, '2024_04_01_235657_create_mqtt_data_histories_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 5),
(5, 'App\\Models\\User', 6),
(5, 'App\\Models\\User', 7);

-- --------------------------------------------------------

--
-- Table structure for table `mqtt_data`
--

CREATE TABLE `mqtt_data` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('sensor','switch') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The type of the data',
  `project_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The data from the MQTT response',
  `created_by` bigint UNSIGNED DEFAULT NULL COMMENT 'History created by the user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mqtt_data_histories`
--

CREATE TABLE `mqtt_data_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `mqtt_data_id` bigint UNSIGNED NOT NULL,
  `pond_id` bigint UNSIGNED NOT NULL,
  `sensor_unit_id` bigint UNSIGNED DEFAULT NULL,
  `sensor_type_id` bigint UNSIGNED DEFAULT NULL,
  `switch_unit_id` bigint UNSIGNED DEFAULT NULL,
  `switch_type_id` bigint UNSIGNED DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The value of the data',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The message of the data using the value from the helper method',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'backup.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(2, 'backup.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(3, 'backup.download', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(4, 'backup.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(5, 'log.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(6, 'log.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(7, 'log.download', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(8, 'log.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(9, 'menu-item.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(10, 'menu-item.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(11, 'menu-item.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(12, 'menu-item.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(13, 'menu-item.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(14, 'menu-item.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(15, 'menu-item.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(16, 'menu-item.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(17, 'menu-item.reorder', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(18, 'menu-item.save.reorder', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(19, 'page.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(20, 'page.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(21, 'page.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(22, 'page.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(23, 'page.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(24, 'page.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(25, 'page.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(26, 'page.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(27, 'backpack.auth.login', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(28, 'backpack.auth.logout', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(29, 'backpack.auth.register', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(30, 'backpack.auth.password.reset', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(31, 'backpack.auth.password.reset.token', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(32, 'backpack.auth.password.email', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(33, 'backpack.dashboard', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(34, 'backpack', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(35, 'backpack.account.info', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(36, 'backpack.account.info.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(37, 'backpack.account.password', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(38, 'backup.table', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(39, 'shell.command.git.config', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(40, 'shell.command.git.status', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(41, 'shell.command.git.stash', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(42, 'shell.command.git.pull', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(43, 'shell.command.git.commit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(44, 'shell.command.git.push', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(45, 'shell.command.git.commit.push', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(46, 'shell.command.artisan.migrate.fresh.seed', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(47, 'shell.command.any.command', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(48, 'route-list.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(49, 'route-list.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(50, 'route-list.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(51, 'route-list.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(52, 'route-list.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(53, 'route-list.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(54, 'route-list.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(55, 'route-list.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(56, 'route-list.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(57, 'contact-us.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(58, 'contact-us.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(59, 'contact-us.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(60, 'contact-us.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(61, 'contact-us.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(62, 'contact-us.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(63, 'contact-us.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(64, 'contact-us.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(65, 'contact-us.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(66, 'social.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(67, 'social.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(68, 'social.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(69, 'social.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(70, 'social.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(71, 'social.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(72, 'social.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(73, 'social.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(74, 'social.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(75, 'footer-link-group.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(76, 'footer-link-group.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(77, 'footer-link-group.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(78, 'footer-link-group.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(79, 'footer-link-group.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(80, 'footer-link-group.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(81, 'footer-link-group.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(82, 'footer-link-group.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(83, 'footer-link-group.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(84, 'footer-link-group.reorder', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(85, 'footer-link-group.save.reorder', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(86, 'footer-link.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(87, 'footer-link.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(88, 'footer-link.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(89, 'footer-link.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(90, 'footer-link.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(91, 'footer-link.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(92, 'footer-link.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(93, 'footer-link.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(94, 'footer-link.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(95, 'footer-link.reorder', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(96, 'footer-link.save.reorder', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(97, 'customer.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(98, 'customer.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(99, 'customer.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(100, 'customer.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(101, 'customer.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(102, 'customer.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(103, 'customer.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(104, 'customer.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(105, 'project.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(106, 'project.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(107, 'project.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(108, 'project.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(109, 'project.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(110, 'project.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(111, 'project.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(112, 'project.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(113, 'project.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(114, 'project-inline-create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(115, 'project-inline-create-save', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(116, 'project.fetchSensors', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(117, 'project.fetchAerators', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(118, 'project.fetchFeeders', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(119, 'project.fetchPonds', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(120, 'project.fetchUsers', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(121, 'controller.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(122, 'controller.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(123, 'controller.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(124, 'controller.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(125, 'controller.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(126, 'controller.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(127, 'controller.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(128, 'controller.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(129, 'controller.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(130, 'sensor-type.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(131, 'sensor-type.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(132, 'sensor-type.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(133, 'sensor-type.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(134, 'sensor-type.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(135, 'sensor-type.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(136, 'sensor-type.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(137, 'sensor-type.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(138, 'sensor-type.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(139, 'sensor.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(140, 'sensor.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(141, 'sensor.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(142, 'sensor.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(143, 'sensor.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(144, 'sensor.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(145, 'sensor.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(146, 'sensor.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(147, 'sensor.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(148, 'sensor-inline-create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(149, 'sensor-inline-create-save', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(150, 'fish.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(151, 'fish.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(152, 'fish.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(153, 'fish.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(154, 'fish.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(155, 'fish.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(156, 'fish.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(157, 'fish.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(158, 'fish.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(159, 'fish-inline-create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(160, 'fish-inline-create-save', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(161, 'fish-weight.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(162, 'fish-weight.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(163, 'fish-weight.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(164, 'fish-weight.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(165, 'fish-weight.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(166, 'fish-weight.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(167, 'fish-weight.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(168, 'fish-weight.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(169, 'fish-weight.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(170, 'feeder.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(171, 'feeder.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(172, 'feeder.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(173, 'feeder.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(174, 'feeder.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(175, 'feeder.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(176, 'feeder.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(177, 'feeder.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(178, 'feeder.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(179, 'feeder-inline-create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(180, 'feeder-inline-create-save', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(181, 'aerator.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(182, 'aerator.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(183, 'aerator.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(184, 'aerator.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(185, 'aerator.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(186, 'aerator.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(187, 'aerator.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(188, 'aerator.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(189, 'aerator.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(190, 'aerator-inline-create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(191, 'aerator-inline-create-save', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(192, 'feeder-history.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(193, 'feeder-history.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(194, 'feeder-history.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(195, 'feeder-history.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(196, 'feeder-history.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(197, 'feeder-history.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(198, 'feeder-history.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(199, 'feeder-history.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(200, 'feeder-history.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(201, 'pond.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(202, 'pond.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(203, 'pond.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(204, 'pond.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(205, 'pond.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(206, 'pond.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(207, 'pond.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(208, 'pond.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(209, 'pond.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(210, 'pond.fetchProject', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(211, 'pond.fetchSensorUnits', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(212, 'pond.fetchSwitchUnits', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(213, 'sensor-unit.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(214, 'sensor-unit.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(215, 'sensor-unit.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(216, 'sensor-unit.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(217, 'sensor-unit.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(218, 'sensor-unit.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(219, 'sensor-unit.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(220, 'sensor-unit.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(221, 'sensor-unit.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(222, 'sensor-unit-inline-create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(223, 'sensor-unit-inline-create-save', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(224, 'switch-unit.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(225, 'switch-unit.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(226, 'switch-unit.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(227, 'switch-unit.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(228, 'switch-unit.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(229, 'switch-unit.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(230, 'switch-unit.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(231, 'switch-unit.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(232, 'switch-unit.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(233, 'switch-unit-inline-create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(234, 'switch-unit-inline-create-save', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(235, 'switch-type.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(236, 'switch-type.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(237, 'switch-type.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(238, 'switch-type.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(239, 'switch-type.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(240, 'switch-type.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(241, 'switch-type.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(242, 'switch-type.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(243, 'switch-type.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(244, 'switch.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(245, 'switch.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(246, 'switch.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(247, 'switch.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(248, 'switch.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(249, 'switch.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(250, 'switch.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(251, 'switch.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(252, 'switch.show', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(253, 'elfinder.theme', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(254, 'permission.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(255, 'permission.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(256, 'permission.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(257, 'permission.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(258, 'permission.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(259, 'permission.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(260, 'permission.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(261, 'permission.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(262, 'role.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(263, 'role.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(264, 'role.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(265, 'role.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(266, 'role.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(267, 'role.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(268, 'role.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(269, 'role.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(270, 'user.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(271, 'user.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(272, 'user.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(273, 'user.create', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(274, 'user.store', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(275, 'user.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(276, 'user.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(277, 'user.destroy', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(278, 'setting.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(279, 'setting.search', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(280, 'setting.showDetailsRow', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(281, 'setting.edit', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(282, 'setting.update', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(283, 'elfinder.index', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(284, 'elfinder.connector', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(285, 'elfinder.popup', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(286, 'elfinder.filepicker', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(287, 'elfinder.tinymce', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(288, 'elfinder.tinymce4', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(289, 'elfinder.tinymce5', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30'),
(290, 'elfinder.ckeditor', 'backpack', '2024-03-30 16:09:30', '2024-03-30 16:09:30');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ponds`
--

CREATE TABLE `ponds` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `project_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ponds`
--

INSERT INTO `ponds` (`id`, `name`, `slug`, `address`, `description`, `status`, `project_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pond 1', 'pond-1', 'Dhaka', NULL, 'active', 1, 4, '2024-03-24 01:09:35', '2024-03-25 15:15:31', NULL),
(2, 'Pond 2', 'pond-2', 'Dhaka', NULL, 'active', 2, 4, '2024-03-24 01:09:35', '2024-03-25 15:15:02', NULL),
(3, 'Pond 3', 'pond-3', 'Dhaka', NULL, 'active', 3, 4, '2024-03-24 01:09:35', '2024-03-25 15:15:15', NULL),
(4, 'Pond 4', 'pond-4', 'Dhaka', NULL, 'active', 1, 4, '2024-03-24 01:09:35', '2024-03-25 15:15:31', NULL),
(5, 'Pond 5', 'pond-5', 'Dhaka', NULL, 'active', 1, 4, '2024-03-24 01:09:35', '2024-03-25 15:15:31', NULL),
(6, 'Pond 6', 'pond-6', 'Dhaka', NULL, 'active', 3, 4, '2024-03-24 01:09:35', '2024-03-25 15:15:15', NULL),
(7, 'Pond 7', 'pond-7', 'Dhaka', NULL, 'active', 1, 4, '2024-03-24 01:09:35', '2024-03-25 15:15:31', NULL),
(8, 'Pond 8', 'pond-8', 'Dhaka', NULL, 'active', 2, 4, '2024-03-24 01:09:35', '2024-03-25 15:15:02', NULL),
(9, 'Pond 9', 'pond-9', 'Dhaka', NULL, 'active', 3, 4, '2024-03-24 01:09:35', '2024-03-25 15:15:15', NULL),
(10, 'Pond 10', 'pond-10', 'Dhaka', NULL, 'active', 2, 4, '2024-03-24 01:09:35', '2024-03-25 15:15:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pond_sensor_unit`
--

CREATE TABLE `pond_sensor_unit` (
  `pond_id` bigint UNSIGNED NOT NULL,
  `sensor_unit_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pond_sensor_unit`
--

INSERT INTO `pond_sensor_unit` (`pond_id`, `sensor_unit_id`) VALUES
(7, 3),
(1, 12),
(4, 3),
(3, 5),
(2, 7),
(4, 11),
(1, 9),
(5, 3),
(5, 4),
(10, 11),
(10, 2),
(9, 6),
(8, 5),
(3, 10),
(6, 7),
(10, 8),
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pond_switch_unit`
--

CREATE TABLE `pond_switch_unit` (
  `pond_id` bigint UNSIGNED NOT NULL,
  `switch_unit_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pond_switch_unit`
--

INSERT INTO `pond_switch_unit` (`pond_id`, `switch_unit_id`) VALUES
(4, 5),
(6, 12),
(9, 11),
(1, 6),
(3, 8),
(7, 2),
(4, 4),
(4, 3),
(5, 4),
(8, 8),
(9, 9),
(1, 7),
(4, 10),
(4, 1),
(2, 9),
(10, 3);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `customer_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Customer who is assigned to this project',
  `gateway_name` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_serial_number` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL COMMENT 'User who created this project',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `slug`, `description`, `status`, `customer_id`, `gateway_name`, `gateway_serial_number`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Project 1', 'project-1', NULL, 'active', 6, 'gt-1', 'gts-1', 2, '2024-03-06 02:03:32', '2024-03-25 15:15:31', NULL),
(2, 'Project 2', 'project-2', NULL, 'active', 7, 'gt-2', 'gts-2', 7, '2024-03-06 02:17:23', '2024-03-25 15:15:02', NULL),
(3, 'Project 3', 'project-3', NULL, 'active', 5, 'gt-3', 'gts-3', 1, '2024-03-25 14:25:06', '2024-03-25 15:15:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_sensor`
--

CREATE TABLE `project_sensor` (
  `sensor_id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_sensor`
--

INSERT INTO `project_sensor` (`sensor_id`, `project_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', 'backpack', '2022-02-24 12:02:53', '2022-02-24 12:02:53'),
(2, 'Admin', 'backpack', '2022-02-24 12:02:58', '2022-02-24 12:02:58'),
(3, 'User', 'backpack', '2022-02-24 12:03:03', '2022-02-24 12:03:03'),
(4, 'ShellAdmin', 'backpack', '2022-02-24 12:02:58', '2022-02-24 12:02:58'),
(5, 'Customer', 'backpack', '2022-02-24 12:02:58', '2022-02-24 12:02:58');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(151, 1),
(152, 1),
(153, 1),
(154, 1),
(155, 1),
(156, 1),
(157, 1),
(158, 1),
(159, 1),
(160, 1),
(161, 1),
(162, 1),
(163, 1),
(164, 1),
(165, 1),
(166, 1),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(171, 1),
(172, 1),
(173, 1),
(174, 1),
(175, 1),
(176, 1),
(177, 1),
(178, 1),
(179, 1),
(180, 1),
(181, 1),
(182, 1),
(183, 1),
(184, 1),
(185, 1),
(186, 1),
(187, 1),
(188, 1),
(189, 1),
(190, 1),
(191, 1),
(192, 1),
(193, 1),
(194, 1),
(195, 1),
(196, 1),
(197, 1),
(198, 1),
(199, 1),
(200, 1),
(201, 1),
(202, 1),
(203, 1),
(204, 1),
(205, 1),
(206, 1),
(207, 1),
(208, 1),
(209, 1),
(210, 1),
(211, 1),
(212, 1),
(213, 1),
(214, 1),
(215, 1),
(216, 1),
(217, 1),
(218, 1),
(219, 1),
(220, 1),
(221, 1),
(222, 1),
(223, 1),
(224, 1),
(225, 1),
(226, 1),
(227, 1),
(228, 1),
(229, 1),
(230, 1),
(231, 1),
(232, 1),
(233, 1),
(234, 1),
(235, 1),
(236, 1),
(237, 1),
(238, 1),
(239, 1),
(240, 1),
(241, 1),
(242, 1),
(243, 1),
(244, 1),
(245, 1),
(246, 1),
(247, 1),
(248, 1),
(249, 1),
(250, 1),
(251, 1),
(252, 1),
(253, 1),
(254, 1),
(255, 1),
(256, 1),
(257, 1),
(258, 1),
(259, 1),
(260, 1),
(261, 1),
(262, 1),
(263, 1),
(264, 1),
(265, 1),
(266, 1),
(267, 1),
(268, 1),
(269, 1),
(270, 1),
(271, 1),
(272, 1),
(273, 1),
(274, 1),
(275, 1),
(276, 1),
(277, 1),
(278, 1),
(279, 1),
(280, 1),
(281, 1),
(282, 1),
(283, 1),
(284, 1),
(285, 1),
(286, 1),
(287, 1),
(288, 1),
(289, 1),
(290, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(86, 2),
(87, 2),
(88, 2),
(89, 2),
(90, 2),
(91, 2),
(92, 2),
(93, 2),
(94, 2),
(95, 2),
(96, 2),
(97, 2),
(98, 2),
(99, 2),
(100, 2),
(101, 2),
(102, 2),
(103, 2),
(104, 2),
(105, 2),
(106, 2),
(107, 2),
(108, 2),
(109, 2),
(110, 2),
(111, 2),
(112, 2),
(113, 2),
(114, 2),
(115, 2),
(116, 2),
(117, 2),
(118, 2),
(119, 2),
(120, 2),
(121, 2),
(122, 2),
(123, 2),
(124, 2),
(125, 2),
(126, 2),
(127, 2),
(128, 2),
(129, 2),
(130, 2),
(131, 2),
(132, 2),
(133, 2),
(134, 2),
(135, 2),
(136, 2),
(137, 2),
(138, 2),
(139, 2),
(140, 2),
(141, 2),
(142, 2),
(143, 2),
(144, 2),
(145, 2),
(146, 2),
(147, 2),
(148, 2),
(149, 2),
(150, 2),
(151, 2),
(152, 2),
(153, 2),
(154, 2),
(155, 2),
(156, 2),
(157, 2),
(158, 2),
(159, 2),
(160, 2),
(161, 2),
(162, 2),
(163, 2),
(164, 2),
(165, 2),
(166, 2),
(167, 2),
(168, 2),
(169, 2),
(170, 2),
(171, 2),
(172, 2),
(173, 2),
(174, 2),
(175, 2),
(176, 2),
(177, 2),
(178, 2),
(179, 2),
(180, 2),
(181, 2),
(182, 2),
(183, 2),
(184, 2),
(185, 2),
(186, 2),
(187, 2),
(188, 2),
(189, 2),
(190, 2),
(191, 2),
(192, 2),
(193, 2),
(194, 2),
(195, 2),
(196, 2),
(197, 2),
(198, 2),
(199, 2),
(200, 2),
(201, 2),
(202, 2),
(203, 2),
(204, 2),
(205, 2),
(206, 2),
(207, 2),
(208, 2),
(209, 2),
(210, 2),
(211, 2),
(212, 2),
(213, 2),
(214, 2),
(215, 2),
(216, 2),
(217, 2),
(218, 2),
(219, 2),
(220, 2),
(221, 2),
(222, 2),
(223, 2),
(224, 2),
(225, 2),
(226, 2),
(227, 2),
(228, 2),
(229, 2),
(230, 2),
(231, 2),
(232, 2),
(233, 2),
(234, 2),
(235, 2),
(236, 2),
(237, 2),
(238, 2),
(239, 2),
(240, 2),
(241, 2),
(242, 2),
(243, 2),
(244, 2),
(245, 2),
(246, 2),
(247, 2),
(248, 2),
(249, 2),
(250, 2),
(251, 2),
(252, 2),
(253, 2),
(265, 2),
(266, 2),
(267, 2),
(268, 2),
(269, 2),
(270, 2),
(271, 2),
(272, 2),
(273, 2),
(274, 2),
(275, 2),
(276, 2),
(277, 2),
(278, 2),
(279, 2),
(280, 2),
(281, 2),
(282, 2),
(283, 2),
(284, 2),
(285, 2),
(286, 2),
(287, 2),
(288, 2),
(289, 2),
(290, 2),
(27, 3),
(28, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 3),
(37, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 4),
(11, 4),
(12, 4),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 4),
(22, 4),
(23, 4),
(24, 4),
(25, 4),
(26, 4),
(27, 4),
(28, 4),
(29, 4),
(30, 4),
(31, 4),
(32, 4),
(33, 4),
(34, 4),
(35, 4),
(36, 4),
(37, 4),
(38, 4),
(39, 4),
(40, 4),
(41, 4),
(42, 4),
(43, 4),
(44, 4),
(45, 4),
(46, 4),
(47, 4),
(48, 4),
(49, 4),
(50, 4),
(51, 4),
(52, 4),
(53, 4),
(54, 4),
(55, 4),
(56, 4),
(57, 4),
(58, 4),
(59, 4),
(60, 4),
(61, 4),
(62, 4),
(63, 4),
(64, 4),
(65, 4),
(66, 4),
(67, 4),
(68, 4),
(69, 4),
(70, 4),
(71, 4),
(72, 4),
(73, 4),
(74, 4),
(75, 4),
(76, 4),
(77, 4),
(78, 4),
(79, 4),
(80, 4),
(81, 4),
(82, 4),
(83, 4),
(84, 4),
(85, 4),
(86, 4),
(87, 4),
(88, 4),
(89, 4),
(90, 4),
(91, 4),
(92, 4),
(93, 4),
(94, 4),
(95, 4),
(96, 4),
(97, 4),
(98, 4),
(99, 4),
(100, 4),
(101, 4),
(102, 4),
(103, 4),
(104, 4),
(105, 4),
(106, 4),
(107, 4),
(108, 4),
(109, 4),
(110, 4),
(111, 4),
(112, 4),
(113, 4),
(114, 4),
(115, 4),
(116, 4),
(117, 4),
(118, 4),
(119, 4),
(120, 4),
(121, 4),
(122, 4),
(123, 4),
(124, 4),
(125, 4),
(126, 4),
(127, 4),
(128, 4),
(129, 4),
(130, 4),
(131, 4),
(132, 4),
(133, 4),
(134, 4),
(135, 4),
(136, 4),
(137, 4),
(138, 4),
(139, 4),
(140, 4),
(141, 4),
(142, 4),
(143, 4),
(144, 4),
(145, 4),
(146, 4),
(147, 4),
(148, 4),
(149, 4),
(150, 4),
(151, 4),
(152, 4),
(153, 4),
(154, 4),
(155, 4),
(156, 4),
(157, 4),
(158, 4),
(159, 4),
(160, 4),
(161, 4),
(162, 4),
(163, 4),
(164, 4),
(165, 4),
(166, 4),
(167, 4),
(168, 4),
(169, 4),
(170, 4),
(171, 4),
(172, 4),
(173, 4),
(174, 4),
(175, 4),
(176, 4),
(177, 4),
(178, 4),
(179, 4),
(180, 4),
(181, 4),
(182, 4),
(183, 4),
(184, 4),
(185, 4),
(186, 4),
(187, 4),
(188, 4),
(189, 4),
(190, 4),
(191, 4),
(192, 4),
(193, 4),
(194, 4),
(195, 4),
(196, 4),
(197, 4),
(198, 4),
(199, 4),
(200, 4),
(201, 4),
(202, 4),
(203, 4),
(204, 4),
(205, 4),
(206, 4),
(207, 4),
(208, 4),
(209, 4),
(210, 4),
(211, 4),
(212, 4),
(213, 4),
(214, 4),
(215, 4),
(216, 4),
(217, 4),
(218, 4),
(219, 4),
(220, 4),
(221, 4),
(222, 4),
(223, 4),
(224, 4),
(225, 4),
(226, 4),
(227, 4),
(228, 4),
(229, 4),
(230, 4),
(231, 4),
(232, 4),
(233, 4),
(234, 4),
(235, 4),
(236, 4),
(237, 4),
(238, 4),
(239, 4),
(240, 4),
(241, 4),
(242, 4),
(243, 4),
(244, 4),
(245, 4),
(246, 4),
(247, 4),
(248, 4),
(249, 4),
(250, 4),
(251, 4),
(252, 4),
(253, 4),
(254, 4),
(255, 4),
(256, 4),
(257, 4),
(258, 4),
(259, 4),
(260, 4),
(261, 4),
(262, 4),
(263, 4),
(264, 4),
(265, 4),
(266, 4),
(267, 4),
(268, 4),
(269, 4),
(270, 4),
(271, 4),
(272, 4),
(273, 4),
(274, 4),
(275, 4),
(276, 4),
(277, 4),
(278, 4),
(279, 4),
(280, 4),
(281, 4),
(282, 4),
(283, 4),
(284, 4),
(285, 4),
(286, 4),
(287, 4),
(288, 4),
(289, 4),
(290, 4),
(1, 5),
(2, 5),
(3, 5),
(4, 5),
(5, 5),
(6, 5),
(7, 5),
(8, 5),
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(13, 5),
(14, 5),
(15, 5),
(16, 5),
(17, 5),
(18, 5),
(19, 5),
(20, 5),
(21, 5),
(22, 5),
(23, 5),
(24, 5),
(25, 5),
(26, 5),
(27, 5),
(28, 5),
(29, 5),
(30, 5),
(31, 5),
(32, 5),
(33, 5),
(34, 5),
(35, 5),
(36, 5),
(37, 5),
(38, 5),
(39, 5),
(40, 5),
(41, 5),
(42, 5),
(43, 5),
(44, 5),
(45, 5),
(46, 5),
(47, 5),
(57, 5),
(58, 5),
(59, 5),
(60, 5),
(61, 5),
(62, 5),
(63, 5),
(64, 5),
(65, 5),
(66, 5),
(67, 5),
(68, 5),
(69, 5),
(70, 5),
(71, 5),
(72, 5),
(73, 5),
(74, 5),
(75, 5),
(76, 5),
(77, 5),
(78, 5),
(79, 5),
(80, 5),
(81, 5),
(82, 5),
(83, 5),
(84, 5),
(85, 5),
(86, 5),
(87, 5),
(88, 5),
(89, 5),
(90, 5),
(91, 5),
(92, 5),
(93, 5),
(94, 5),
(95, 5),
(96, 5),
(97, 5),
(98, 5),
(99, 5),
(100, 5),
(101, 5),
(102, 5),
(103, 5),
(104, 5),
(105, 5),
(106, 5),
(107, 5),
(108, 5),
(109, 5),
(110, 5),
(111, 5),
(112, 5),
(113, 5),
(114, 5),
(115, 5),
(116, 5),
(117, 5),
(118, 5),
(119, 5),
(120, 5),
(121, 5),
(122, 5),
(123, 5),
(124, 5),
(125, 5),
(126, 5),
(127, 5),
(128, 5),
(129, 5),
(130, 5),
(131, 5),
(132, 5),
(133, 5),
(134, 5),
(135, 5),
(136, 5),
(137, 5),
(138, 5),
(139, 5),
(140, 5),
(141, 5),
(142, 5),
(143, 5),
(144, 5),
(145, 5),
(146, 5),
(147, 5),
(148, 5),
(149, 5),
(150, 5),
(151, 5),
(152, 5),
(153, 5),
(154, 5),
(155, 5),
(156, 5),
(157, 5),
(158, 5),
(159, 5),
(160, 5),
(161, 5),
(162, 5),
(163, 5),
(164, 5),
(165, 5),
(166, 5),
(167, 5),
(168, 5),
(169, 5),
(170, 5),
(171, 5),
(172, 5),
(173, 5),
(174, 5),
(175, 5),
(176, 5),
(177, 5),
(178, 5),
(179, 5),
(180, 5),
(181, 5),
(182, 5),
(183, 5),
(184, 5),
(185, 5),
(186, 5),
(187, 5),
(188, 5),
(189, 5),
(190, 5),
(191, 5),
(192, 5),
(193, 5),
(194, 5),
(195, 5),
(196, 5),
(197, 5),
(198, 5),
(199, 5),
(200, 5),
(201, 5),
(202, 5),
(203, 5),
(204, 5),
(205, 5),
(206, 5),
(207, 5),
(208, 5),
(209, 5),
(210, 5),
(211, 5),
(212, 5),
(213, 5),
(214, 5),
(215, 5),
(216, 5),
(217, 5),
(218, 5),
(219, 5),
(220, 5),
(221, 5),
(222, 5),
(223, 5),
(224, 5),
(225, 5),
(226, 5),
(227, 5),
(228, 5),
(229, 5),
(230, 5),
(231, 5),
(232, 5),
(233, 5),
(234, 5),
(235, 5),
(236, 5),
(237, 5),
(238, 5),
(239, 5),
(240, 5),
(241, 5),
(242, 5),
(243, 5),
(244, 5),
(245, 5),
(246, 5),
(247, 5),
(248, 5),
(249, 5),
(250, 5),
(251, 5),
(252, 5),
(253, 5),
(278, 5),
(279, 5),
(280, 5),
(281, 5),
(282, 5),
(283, 5),
(284, 5),
(285, 5),
(286, 5),
(287, 5),
(288, 5),
(289, 5),
(290, 5);

-- --------------------------------------------------------

--
-- Table structure for table `route_lists`
--

CREATE TABLE `route_lists` (
  `id` bigint UNSIGNED NOT NULL,
  `domain` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `action` text COLLATE utf8mb4_unicode_ci,
  `middleware` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sensors`
--

CREATE TABLE `sensors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sensor_type_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint UNSIGNED DEFAULT NULL COMMENT 'Customer creates his own sensor',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sensors`
--

INSERT INTO `sensors` (`id`, `name`, `serial_number`, `slug`, `sensor_type_id`, `description`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Oxygen Sensor - 1', '13423223', 'oxygen-sensor', 1, NULL, 'active', 4, '2024-03-06 01:41:24', '2024-03-06 01:41:24', NULL),
(2, 'TDS Sensor - 1', '2108755', 'tds-sensor', 2, NULL, 'active', 4, '2024-03-06 01:41:29', '2024-03-06 01:41:29', NULL),
(3, 'Temperature Sensor - 1', '32345623', 'temperature-sensor', 3, NULL, 'active', 4, '2024-03-06 01:41:40', '2024-03-06 01:41:40', NULL),
(4, 'PH Sensor - 1', '4856545', 'ph-sensor', 4, NULL, 'active', 4, '2024-03-06 01:41:47', '2024-03-06 01:41:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_types`
--

CREATE TABLE `sensor_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `customer_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Customer who is assigned to this sensor type',
  `remote_name` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sensor_types`
--

INSERT INTO `sensor_types` (`id`, `name`, `slug`, `description`, `status`, `customer_id`, `remote_name`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Oxygen Sensor', 'oxygen-sensor', NULL, 'active', NULL, 'ox-s', 4, '2024-03-06 01:41:24', '2024-03-25 00:24:07', NULL),
(2, 'TDS Sensor', 'tds-sensor', NULL, 'active', NULL, 'tds-s', 4, '2024-03-06 01:41:29', '2024-03-25 00:24:39', NULL),
(3, 'Temperature Sensor', 'temperature-sensor', NULL, 'active', NULL, 'tr-s', 4, '2024-03-06 01:41:40', '2024-03-25 00:24:31', NULL),
(4, 'PH Sensor', 'ph-sensor', NULL, 'active', NULL, 'ph-s', 4, '2024-03-06 01:41:47', '2024-03-25 00:24:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_type_sensor_unit`
--

CREATE TABLE `sensor_type_sensor_unit` (
  `sensor_type_id` bigint UNSIGNED NOT NULL,
  `sensor_unit_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sensor_type_sensor_unit`
--

INSERT INTO `sensor_type_sensor_unit` (`sensor_type_id`, `sensor_unit_id`) VALUES
(3, 8),
(3, 4),
(2, 5),
(2, 1),
(3, 5),
(2, 7),
(2, 8),
(4, 9),
(3, 1),
(1, 2),
(4, 1),
(4, 6),
(4, 10),
(1, 12),
(4, 4),
(4, 5),
(3, 12),
(1, 8),
(4, 11),
(4, 8),
(2, 10),
(1, 9),
(3, 11),
(2, 3),
(4, 7),
(3, 7),
(4, 2),
(3, 9),
(1, 5),
(2, 4),
(3, 6),
(4, 12),
(1, 6),
(2, 6),
(2, 11),
(3, 2),
(4, 3),
(2, 2),
(1, 11),
(3, 3),
(3, 10),
(1, 10),
(1, 1),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_units`
--

CREATE TABLE `sensor_units` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint UNSIGNED DEFAULT NULL COMMENT 'Customer creates his own sensor unit',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sensor_units`
--

INSERT INTO `sensor_units` (`id`, `name`, `serial_number`, `slug`, `description`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sensor Unit 1', '195', 'sensor-unit-1', NULL, 'active', 2, '2024-03-23 19:56:39', '2024-03-23 19:56:39', NULL),
(2, 'Sensor Unit 2', '769', 'sensor-unit-2', NULL, 'active', 4, '2024-03-23 20:10:19', '2024-03-23 20:10:19', NULL),
(3, 'Sensor Unit 3', '507', 'sensor-unit-3', NULL, 'active', 2, '2024-03-23 19:56:39', '2024-03-23 19:56:39', NULL),
(4, 'Sensor Unit 4', '908', 'sensor-unit-4', NULL, 'active', 2, '2024-03-23 19:56:39', '2024-03-23 19:56:39', NULL),
(5, 'Sensor Unit 5', '348', 'sensor-unit-5', NULL, 'active', 2, '2024-03-23 19:56:39', '2024-03-23 19:56:39', NULL),
(6, 'Sensor Unit 6', '225', 'sensor-unit-6', NULL, 'active', 2, '2024-03-23 19:56:39', '2024-03-23 19:56:39', NULL),
(7, 'Sensor Unit 7', '200', 'sensor-unit-7', NULL, 'active', 2, '2024-03-23 19:56:39', '2024-03-23 19:56:39', NULL),
(8, 'Sensor Unit 8', '183', 'sensor-unit-8', NULL, 'active', 2, '2024-03-23 19:56:39', '2024-03-23 19:56:39', NULL),
(9, 'Sensor Unit 9', '779', 'sensor-unit-9', NULL, 'active', 2, '2024-03-23 19:56:39', '2024-03-23 19:56:39', NULL),
(10, 'Sensor Unit 10', '385', 'sensor-unit-10', NULL, 'active', 2, '2024-03-23 19:56:39', '2024-03-23 19:56:39', NULL),
(11, 'Sensor Unit 11', '230', 'sensor-unit-11', NULL, 'active', 2, '2024-03-23 19:56:39', '2024-03-23 19:56:39', NULL),
(12, 'Sensor Unit 12', '583', 'sensor-unit-12', NULL, 'active', 2, '2024-03-23 19:56:39', '2024-03-23 19:56:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `field` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `name`, `description`, `value`, `field`, `active`, `created_at`, `updated_at`) VALUES
(1, 'contact_info', 'Contact Info', 'Contact Information of Smart Fish BD', '[{\"title\":\"Smart Fish - Manage and Monitor Your Aquarium with Smart Fish\",\"favicon\":\"uploads\\/favicon.png\",\"address\":\"Calash, Dhanbari, Tangail, 1997 Bangladesh\\r\\nMohammadpur, Dhaka\",\"phone\":\"+880 1710-011072\",\"email\":\"smartfishbd2024@gmail.com\",\"description\":null}]', '{\"name\":\"value\",\"label\":\"Setting\",\"type\":\"repeatable\",\"subfields\":[{\"name\":\"title\",\"type\":\"text\",\"tab\":\"basic\"},{\"name\":\"favicon\",\"type\":\"browse\",\"tab\":\"media\"},{\"name\":\"address\",\"type\":\"textarea\",\"tab\":\"basic\"},{\"name\":\"phone\",\"type\":\"text\",\"tab\":\"basic\"},{\"name\":\"email\",\"type\":\"email\",\"tab\":\"basic\"},{\"name\":\"description\",\"type\":\"ckeditor\",\"tab\":\"basic\"}],\"init_rows\":1,\"min_rows\":1,\"max_rows\":1}', 1, NULL, NULL),
(2, 'about', 'About', 'Website About Information', '[{\"image\":\"uploads\\/products\\/fish.jpeg\",\"description\":\"<p>Welcome to Smart Fish BD, a pioneering initiative established in 2024 by a team of exceptional individuals comprising scientists, engineers, software developers, and mobile app developers. Our mission is clear: to spearhead the development of a smart fishery system that spans across our entire nation.<\\/p>\\r\\n\\r\\n<p>At Smart Fish BD, we recognize the critical importance of sustainable fisheries management for the well-being of our ecosystems, communities, and future generations. Through the integration of cutting-edge technology and interdisciplinary expertise, we aim to revolutionize the way fisheries are managed, monitored, and sustained.<\\/p>\\r\\n\\r\\n<p>With a focus on innovation, efficiency, and environmental stewardship, our platform endeavors to empower fishermen, policymakers, and stakeholders with intelligent tools and insights. By harnessing the power of data analytics, IoT devices, and mobile applications, we strive to optimize fishing practices, mitigate risks, and promote responsible resource utilization.<\\/p>\\r\\n\\r\\n<p>Join us on this transformative journey as we work tirelessly to build a smarter, more resilient fishery network that ensures the long-term viability of our aquatic ecosystems while supporting the livelihoods of fishing communities nationwide. Together, let&#39;s shape a future where technology and sustainability converge to foster thriving marine environments and prosperous societies.<\\/p>\"}]', '{\"name\":\"value\",\"label\":\"About\",\"type\":\"repeatable\",\"subfields\":[{\"name\":\"image\",\"type\":\"browse\"},{\"name\":\"description\",\"type\":\"ckeditor\"}],\"init_rows\":1,\"min_rows\":1,\"max_rows\":1}', 1, NULL, '2024-04-01 21:20:19'),
(3, 'privacy_policy', 'Privacy Policy', 'Privacy Policy', '[{\"title\":\"Privacy Policy for smart-fish-bd\",\"description\":\"<div class=\\\"translations-content-container\\\">\\r\\n<div class=\\\"container\\\">\\r\\n<div class=\\\"tab-content translations-content-item en visible\\\" id=\\\"en\\\">\\r\\n<h1>Privacy Policy<\\/h1>\\r\\n<p>Last updated: January 01, 2023<\\/p>\\r\\n<p>This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.<\\/p>\\r\\n<p>We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy.<\\/p>\\r\\n<h1>Interpretation and Definitions<\\/h1>\\r\\n<h2>Interpretation<\\/h2>\\r\\n<p>The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.<\\/p>\\r\\n<h2>Definitions<\\/h2>\\r\\n<p>For the purposes of this Privacy Policy:<\\/p>\\r\\n<ul>\\r\\n<li>\\r\\n<p><strong>Account<\\/strong> means a unique account created for You to access our Service or parts of our Service.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Company<\\/strong> (referred to as either \\\"the Company\\\", \\\"We\\\", \\\"Us\\\" or \\\"Our\\\" in this Agreement) refers to smart-fish-bd.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Cookies<\\/strong> are small files that are placed on Your computer, mobile device or any other device by a website, containing the details of Your browsing history on that website among its many uses.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Country<\\/strong> refers to: Bangladesh<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Device<\\/strong> means any device that can access the Service such as a computer, a cellphone or a digital tablet.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Personal Data<\\/strong> is any information that relates to an identified or identifiable individual.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Service<\\/strong> refers to the Website.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Service Provider<\\/strong> means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Third-party Social Media Service<\\/strong> refers to any website or any social network website through which a User can log in or create an account to use the Service.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Usage Data<\\/strong> refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Website<\\/strong> refers to smart-fish-bd, accessible from <a href=\\\"https:\\/\\/www.smart-fish-bd.com\\\" rel=\\\"external nofollow noopener\\\" target=\\\"_blank\\\">https:\\/\\/www.smart-fish-bd.com<\\/a><\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>You<\\/strong> means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.<\\/p>\\r\\n<\\/li>\\r\\n<\\/ul>\\r\\n<h1>Collecting and Using Your Personal Data<\\/h1>\\r\\n<h2>Types of Data Collected<\\/h2>\\r\\n<h3>Personal Data<\\/h3>\\r\\n<p>While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:<\\/p>\\r\\n<ul>\\r\\n<li>\\r\\n<p>Email address<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p>First name and last name<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p>Phone number<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p>Address, State, Province, ZIP\\/Postal code, City<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p>Usage Data<\\/p>\\r\\n<\\/li>\\r\\n<\\/ul>\\r\\n<h3>Usage Data<\\/h3>\\r\\n<p>Usage Data is collected automatically when using the Service.<\\/p>\\r\\n<p>Usage Data may include information such as Your Device\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.<\\/p>\\r\\n<p>When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.<\\/p>\\r\\n<p>We may also collect information that Your browser sends whenever You visit our Service or when You access the Service by or through a mobile device.<\\/p>\\r\\n<h3>Information from Third-Party Social Media Services<\\/h3>\\r\\n<p>The Company allows You to create an account and log in to use the Service through the following Third-party Social Media Services:<\\/p>\\r\\n<ul>\\r\\n<li>Google<\\/li>\\r\\n<li>Facebook<\\/li>\\r\\n<li>Twitter<\\/li>\\r\\n<li>LinkedIn<\\/li>\\r\\n<\\/ul>\\r\\n<p>If You decide to register through or otherwise grant us access to a Third-Party Social Media Service, We may collect Personal data that is already associated with Your Third-Party Social Media Service\'s account, such as Your name, Your email address, Your activities or Your contact list associated with that account.<\\/p>\\r\\n<p>You may also have the option of sharing additional information with the Company through Your Third-Party Social Media Service\'s account. If You choose to provide such information and Personal Data, during registration or otherwise, You are giving the Company permission to use, share, and store it in a manner consistent with this Privacy Policy.<\\/p>\\r\\n<h3>Tracking Technologies and Cookies<\\/h3>\\r\\n<p>We use Cookies and similar tracking technologies to track the activity on Our Service and store certain information. Tracking technologies used are beacons, tags, and scripts to collect and track information and to improve and analyze Our Service. The technologies We use may include:<\\/p>\\r\\n<ul>\\r\\n<li><strong>Cookies or Browser Cookies.<\\/strong> A cookie is a small file placed on Your Device. You can instruct Your browser to refuse all Cookies or to indicate when a Cookie is being sent. However, if You do not accept Cookies, You may not be able to use some parts of our Service. Unless you have adjusted Your browser setting so that it will refuse Cookies, our Service may use Cookies.<\\/li>\\r\\n<li><strong>Web Beacons.<\\/strong> Certain sections of our Service and our emails may contain small electronic files known as web beacons (also referred to as clear gifs, pixel tags, and single-pixel gifs) that permit the Company, for example, to count users who have visited those pages or opened an email and for other related website statistics (for example, recording the popularity of a certain section and verifying system and server integrity).<\\/li>\\r\\n<\\/ul>\\r\\n<p>Cookies can be \\\"Persistent\\\" or \\\"Session\\\" Cookies. Persistent Cookies remain on Your personal computer or mobile device when You go offline, while Session Cookies are deleted as soon as You close Your web browser. Learn more about cookies on the <a href=\\\"https:\\/\\/www.freeprivacypolicy.com\\/blog\\/sample-privacy-policy-template\\/#Use_Of_Cookies_And_Tracking\\\" target=\\\"_blank\\\">Free Privacy Policy website<\\/a> article.<\\/p>\\r\\n<p>We use both Session and Persistent Cookies for the purposes set out below:<\\/p>\\r\\n<ul>\\r\\n<li>\\r\\n<p><strong>Necessary \\/ Essential Cookies<\\/strong><\\/p>\\r\\n<p>Type: Session Cookies<\\/p>\\r\\n<p>Administered by: Us<\\/p>\\r\\n<p>Purpose: These Cookies are essential to provide You with services available through the Website and to enable You to use some of its features. They help to authenticate users and prevent fraudulent use of user accounts. Without these Cookies, the services that You have asked for cannot be provided, and We only use these Cookies to provide You with those services.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Cookies Policy \\/ Notice Acceptance Cookies<\\/strong><\\/p>\\r\\n<p>Type: Persistent Cookies<\\/p>\\r\\n<p>Administered by: Us<\\/p>\\r\\n<p>Purpose: These Cookies identify if users have accepted the use of cookies on the Website.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>Functionality Cookies<\\/strong><\\/p>\\r\\n<p>Type: Persistent Cookies<\\/p>\\r\\n<p>Administered by: Us<\\/p>\\r\\n<p>Purpose: These Cookies allow us to remember choices You make when You use the Website, such as remembering your login details or language preference. The purpose of these Cookies is to provide You with a more personal experience and to avoid You having to re-enter your preferences every time You use the Website.<\\/p>\\r\\n<\\/li>\\r\\n<\\/ul>\\r\\n<p>For more information about the cookies we use and your choices regarding cookies, please visit our Cookies Policy or the Cookies section of our Privacy Policy.<\\/p>\\r\\n<h2>Use of Your Personal Data<\\/h2>\\r\\n<p>The Company may use Personal Data for the following purposes:<\\/p>\\r\\n<ul>\\r\\n<li>\\r\\n<p><strong>To provide and maintain our Service<\\/strong>, including to monitor the usage of our Service.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>To manage Your Account:<\\/strong> to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>For the performance of a contract:<\\/strong> the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>To contact You:<\\/strong> To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application\'s push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>To provide You<\\/strong> with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>To manage Your requests:<\\/strong> To attend and manage Your requests to Us.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>For business transfers:<\\/strong> We may use Your information to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which Personal Data held by Us about our Service users is among the assets transferred.<\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p><strong>For other purposes<\\/strong>: We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service, products, services, marketing and your experience.<\\/p>\\r\\n<\\/li>\\r\\n<\\/ul>\\r\\n<p>We may share Your personal information in the following situations:<\\/p>\\r\\n<ul>\\r\\n<li><strong>With Service Providers:<\\/strong> We may share Your personal information with Service Providers to monitor and analyze the use of our Service, to contact You.<\\/li>\\r\\n<li><strong>For business transfers:<\\/strong> We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of Our business to another company.<\\/li>\\r\\n<li><strong>With Affiliates:<\\/strong> We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.<\\/li>\\r\\n<li><strong>With business partners:<\\/strong> We may share Your information with Our business partners to offer You certain products, services or promotions.<\\/li>\\r\\n<li><strong>With other users:<\\/strong> when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside. If You interact with other users or register through a Third-Party Social Media Service, Your contacts on the Third-Party Social Media Service may see Your name, profile, pictures and description of Your activity. Similarly, other users will be able to view descriptions of Your activity, communicate with You and view Your profile.<\\/li>\\r\\n<li><strong>With Your consent<\\/strong>: We may disclose Your personal information for any other purpose with Your consent.<\\/li>\\r\\n<\\/ul>\\r\\n<h2>Retention of Your Personal Data<\\/h2>\\r\\n<p>The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.<\\/p>\\r\\n<p>The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.<\\/p>\\r\\n<h2>Transfer of Your Personal Data<\\/h2>\\r\\n<p>Your information, including Personal Data, is processed at the Company\'s operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to \\u2014 and maintained on \\u2014 computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.<\\/p>\\r\\n<p>Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.<\\/p>\\r\\n<p>The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.<\\/p>\\r\\n<h2>Delete Your Personal Data<\\/h2>\\r\\n<p>You have the right to delete or request that We assist in deleting the Personal Data that We have collected about You.<\\/p>\\r\\n<p>Our Service may give You the ability to delete certain information about You from within the Service.<\\/p>\\r\\n<p>You may update, amend, or delete Your information at any time by signing in to Your Account, if you have one, and visiting the account settings section that allows you to manage Your personal information. You may also contact Us to request access to, correct, or delete any personal information that You have provided to Us.<\\/p>\\r\\n<p>Please note, however, that We may need to retain certain information when we have a legal obligation or lawful basis to do so.<\\/p>\\r\\n<h2>Disclosure of Your Personal Data<\\/h2>\\r\\n<h3>Business Transactions<\\/h3>\\r\\n<p>If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.<\\/p>\\r\\n<h3>Law enforcement<\\/h3>\\r\\n<p>Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).<\\/p>\\r\\n<h3>Other legal requirements<\\/h3>\\r\\n<p>The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:<\\/p>\\r\\n<ul>\\r\\n<li>Comply with a legal obligation<\\/li>\\r\\n<li>Protect and defend the rights or property of the Company<\\/li>\\r\\n<li>Prevent or investigate possible wrongdoing in connection with the Service<\\/li>\\r\\n<li>Protect the personal safety of Users of the Service or the public<\\/li>\\r\\n<li>Protect against legal liability<\\/li>\\r\\n<\\/ul>\\r\\n<h2>Security of Your Personal Data<\\/h2>\\r\\n<p>The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.<\\/p>\\r\\n<h1>Children\'s Privacy<\\/h1>\\r\\n<p>Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from anyone under the age of 13 without verification of parental consent, We take steps to remove that information from Our servers.<\\/p>\\r\\n<p>If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from a parent, We may require Your parent\'s consent before We collect and use that information.<\\/p>\\r\\n<h1>Links to Other Websites<\\/h1>\\r\\n<p>Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You will be directed to that third party\'s site. We strongly advise You to review the Privacy Policy of every site You visit.<\\/p>\\r\\n<p>We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.<\\/p>\\r\\n<h1>Changes to this Privacy Policy<\\/h1>\\r\\n<p>We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.<\\/p>\\r\\n<p>We will let You know via email and\\/or a prominent notice on Our Service, prior to the change becoming effective and update the \\\"Last updated\\\" date at the top of this Privacy Policy.<\\/p>\\r\\n<p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.<\\/p>\\r\\n<h1>Contact Us<\\/h1>\\r\\n<p>If you have any questions about this Privacy Policy, You can contact us:<\\/p>\\r\\n<ul>\\r\\n<li>\\r\\n<p>By email: <a href=\\\"mailto:info@smart-fish-bd.com\\\" title=\\\"Mail to : info@smart-fish-bd.com\\\">info@smart-fish-bd.com</a> <\\/p>\\r\\n<\\/li>\\r\\n<li>\\r\\n<p>By visiting this page on our website: <a href=\\\"http:\\/\\/www.smart-fish-bd.com\\/contact-us\\\" title=\\\"Contact us\\\" rel=\\\"external nofollow noopener\\\" target=\\\"_blank\\\">http:\\/\\/www.smart-fish-bd.com\\/contact-us<\\/a><\\/p>\\r\\n<\\/li>\\r\\n<\\/ul>\\r\\n<\\/div>\\r\\n<\\/div>\\r\\n<\\/div>\"}]', '{\"name\":\"value\",\"label\":\"Privacy Policy\",\"type\":\"repeatable\",\"subfields\":[{\"name\":\"title\",\"label\":\"Title\",\"type\":\"text\"},{\"name\":\"description\",\"label\":\"Description\",\"type\":\"ckeditor\"}],\"min_rows\":1,\"max_rows\":1,\"init_rows\":1}', 1, NULL, NULL),
(4, 'terms_of_condition', 'Terms of Condition', 'Terms of Condition', '[{\"title\":\"Terms and Conditions\",\"description\":\"<p>Welcome to smart-fish-bd!<\\/p>\\r\\n\\r\\n<p>These terms and conditions outline the rules and regulations for the use of smart-fish-bd&#39;s Website, located at https:\\/\\/www.smart-fish-bd.com.<\\/p>\\r\\n\\r\\n<p>By accessing this website we assume you accept these terms and conditions. Do not continue to use smart-fish-bd if you do not agree to take all of the terms and conditions stated on this page.<\\/p>\\r\\n\\r\\n<p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and all Agreements: &quot;Client&quot;, &quot;You&quot; and &quot;Your&quot; refers to you, the person log on this website and compliant to the Company&rsquo;s terms and conditions. &quot;The Company&quot;, &quot;Ourselves&quot;, &quot;We&quot;, &quot;Our&quot; and &quot;Us&quot;, refers to our Company. &quot;Party&quot;, &quot;Parties&quot;, or &quot;Us&quot;, refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client&rsquo;s needs in respect of provision of the Company&rsquo;s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and\\/or he\\/she or they, are taken as interchangeable and therefore as referring to same.<\\/p>\\r\\n\\r\\n<h3><strong>Cookies<\\/strong><\\/h3>\\r\\n\\r\\n<p>We employ the use of cookies. By accessing smart-fish-bd, you agreed to use cookies in agreement with the smart-fish-bd&#39;s Privacy Policy.<\\/p>\\r\\n\\r\\n<p>Most interactive websites use cookies to let us retrieve the user&rsquo;s details for each visit. Cookies are used by our website to enable the functionality of certain areas to make it easier for people visiting our website. Some of our affiliate\\/advertising partners may also use cookies.<\\/p>\\r\\n\\r\\n<h3><strong>License<\\/strong><\\/h3>\\r\\n\\r\\n<p>Unless otherwise stated, smart-fish-bd and\\/or its licensors own the intellectual property rights for all material on smart-fish-bd. All intellectual property rights are reserved. You may access this from smart-fish-bd for your own personal use subjected to restrictions set in these terms and conditions.<\\/p>\\r\\n\\r\\n<p>You must not:<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Republish material from smart-fish-bd<\\/li>\\r\\n\\t<li>Sell, rent or sub-license material from smart-fish-bd<\\/li>\\r\\n\\t<li>Reproduce, duplicate or copy material from smart-fish-bd<\\/li>\\r\\n\\t<li>Redistribute content from smart-fish-bd<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>This Agreement shall begin on the date hereof. Our Terms and Conditions were created with the help of the <a href=\\\"https:\\/\\/www.termsandconditionsgenerator.com\\/\\\">Free Terms and Conditions Generator<\\/a>.<\\/p>\\r\\n\\r\\n<p>Parts of this website offer an opportunity for users to post and exchange opinions and information in certain areas of the website. smart-fish-bd does not filter, edit, publish or review Comments prior to their presence on the website. Comments do not reflect the views and opinions of smart-fish-bd,its agents and\\/or affiliates. Comments reflect the views and opinions of the person who post their views and opinions. To the extent permitted by applicable laws, smart-fish-bd shall not be liable for the Comments or for any liability, damages or expenses caused and\\/or suffered as a result of any use of and\\/or posting of and\\/or appearance of the Comments on this website.<\\/p>\\r\\n\\r\\n<p>smart-fish-bd reserves the right to monitor all Comments and to remove any Comments which can be considered inappropriate, offensive or causes breach of these Terms and Conditions.<\\/p>\\r\\n\\r\\n<p>You warrant and represent that:<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>You are entitled to post the Comments on our website and have all necessary licenses and consents to do so;<\\/li>\\r\\n\\t<li>The Comments do not invade any intellectual property right, including without limitation copyright, patent or trademark of any third party;<\\/li>\\r\\n\\t<li>The Comments do not contain any defamatory, libelous, offensive, indecent or otherwise unlawful material which is an invasion of privacy<\\/li>\\r\\n\\t<li>The Comments will not be used to solicit or promote business or custom or present commercial activities or unlawful activity.<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>You hereby grant smart-fish-bd a non-exclusive license to use, reproduce, edit and authorize others to use, reproduce and edit any of your Comments in any and all forms, formats or media.<\\/p>\\r\\n\\r\\n<h3><strong>Hyperlinking to our Content<\\/strong><\\/h3>\\r\\n\\r\\n<p>The following organizations may link to our Website without prior written approval:<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Government agencies;<\\/li>\\r\\n\\t<li>Search engines;<\\/li>\\r\\n\\t<li>News organizations;<\\/li>\\r\\n\\t<li>Online directory distributors may link to our Website in the same manner as they hyperlink to the Websites of other listed businesses; and<\\/li>\\r\\n\\t<li>System wide Accredited Businesses except soliciting non-profit organizations, charity shopping malls, and charity fundraising groups which may not hyperlink to our Web site.<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>These organizations may link to our home page, to publications or to other Website information so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products and\\/or services; and (c) fits within the context of the linking party&rsquo;s site.<\\/p>\\r\\n\\r\\n<p>We may consider and approve other link requests from the following types of organizations:<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>commonly-known consumer and\\/or business information sources;<\\/li>\\r\\n\\t<li>dot.com community sites;<\\/li>\\r\\n\\t<li>associations or other groups representing charities;<\\/li>\\r\\n\\t<li>online directory distributors;<\\/li>\\r\\n\\t<li>internet portals;<\\/li>\\r\\n\\t<li>accounting, law and consulting firms; and<\\/li>\\r\\n\\t<li>educational institutions and trade associations.<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>We will approve link requests from these organizations if we decide that: (a) the link would not make us look unfavorably to ourselves or to our accredited businesses; (b) the organization does not have any negative records with us; (c) the benefit to us from the visibility of the hyperlink compensates the absence of smart-fish-bd; and (d) the link is in the context of general resource information.<\\/p>\\r\\n\\r\\n<p>These organizations may link to our home page so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products or services; and (c) fits within the context of the linking party&rsquo;s site.<\\/p>\\r\\n\\r\\n<p>If you are one of the organizations listed in paragraph 2 above and are interested in linking to our website, you must inform us by sending an e-mail to smart-fish-bd. Please include your name, your organization name, contact information as well as the URL of your site, a list of any URLs from which you intend to link to our Website, and a list of the URLs on our site to which you would like to link. Wait 2-3 weeks for a response.<\\/p>\\r\\n\\r\\n<p>Approved organizations may hyperlink to our Website as follows:<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>By use of our corporate name; or<\\/li>\\r\\n\\t<li>By use of the uniform resource locator being linked to; or<\\/li>\\r\\n\\t<li>By use of any other description of our Website being linked to that makes sense within the context and format of content on the linking party&rsquo;s site.<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>No use of smart-fish-bd&#39;s logo or other artwork will be allowed for linking absent a trademark license agreement.<\\/p>\\r\\n\\r\\n<h3><strong>iFrames<\\/strong><\\/h3>\\r\\n\\r\\n<p>Without prior approval and written permission, you may not create frames around our Webpages that alter in any way the visual presentation or appearance of our Website.<\\/p>\\r\\n\\r\\n<h3><strong>Content Liability<\\/strong><\\/h3>\\r\\n\\r\\n<p>We shall not be hold responsible for any content that appears on your Website. You agree to protect and defend us against all claims that is rising on your Website. No link(s) should appear on any Website that may be interpreted as libelous, obscene or criminal, or which infringes, otherwise violates, or advocates the infringement or other violation of, any third party rights.<\\/p>\\r\\n\\r\\n<h3><strong>Your Privacy<\\/strong><\\/h3>\\r\\n\\r\\n<p>Please read Privacy Policy<\\/p>\\r\\n\\r\\n<h3><strong>Reservation of Rights<\\/strong><\\/h3>\\r\\n\\r\\n<p>We reserve the right to request that you remove all links or any particular link to our Website. You approve to immediately remove all links to our Website upon request. We also reserve the right to amen these terms and conditions and it&rsquo;s linking policy at any time. By continuously linking to our Website, you agree to be bound to and follow these linking terms and conditions.<\\/p>\\r\\n\\r\\n<h3><strong>Removal of links from our website<\\/strong><\\/h3>\\r\\n\\r\\n<p>If you find any link on our Website that is offensive for any reason, you are free to contact and inform us any moment. We will consider requests to remove links but we are not obligated to or so or to respond to you directly.<\\/p>\\r\\n\\r\\n<p>We do not ensure that the information on this website is correct, we do not warrant its completeness or accuracy; nor do we promise to ensure that the website remains available or that the material on the website is kept up to date.<\\/p>\\r\\n\\r\\n<h3><strong>Disclaimer<\\/strong><\\/h3>\\r\\n\\r\\n<p>To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website. Nothing in this disclaimer will:<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>limit or exclude our or your liability for death or personal injury;<\\/li>\\r\\n\\t<li>limit or exclude our or your liability for fraud or fraudulent misrepresentation;<\\/li>\\r\\n\\t<li>limit any of our or your liabilities in any way that is not permitted under applicable law; or<\\/li>\\r\\n\\t<li>exclude any of our or your liabilities that may not be excluded under applicable law.<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>The limitations and prohibitions of liability set in this Section and elsewhere in this disclaimer: (a) are subject to the preceding paragraph; and (b) govern all liabilities arising under the disclaimer, including liabilities arising in contract, in tort and for breach of statutory duty.<\\/p>\\r\\n\\r\\n<p>As long as the website and the information and services on the website are provided free of charge, we will not be liable for any loss or damage of any nature.<\\/p>\"}]', '{\"name\":\"value\",\"label\":\"Terms of Condition\",\"type\":\"repeatable\",\"subfields\":[{\"name\":\"title\",\"label\":\"Title\",\"type\":\"text\"},{\"name\":\"description\",\"label\":\"Description\",\"type\":\"ckeditor\"}],\"min_rows\":1,\"max_rows\":1,\"init_rows\":1}', 1, NULL, NULL),
(5, 'banner_images', 'Banner Images', 'Top Banner Images of Smart Fish BD', '[\"uploads/banners/b1.jpeg\",\"uploads/banners/b2.jpeg\",\"uploads/banners/b3.jpeg\",\"uploads/banners/b4.jpeg\",\"uploads/banners/b5.jpeg\"]', '{\"name\":\"value\",\"label\":\"Banner Images\",\"type\":\"browse_multiple\",\"min_rows\":1,\"init_rows\":1}', 1, NULL, '2024-04-01 21:21:36'),
(6, 'welcome_message', 'Welcome Message', 'Welcome Message of Smart Fish BD', '<p>Welcome to Smart Fish BD, where innovation swims with purpose! Established in 2024, we are a team of brilliant minds, including scientists, engineers, software, and mobile app developers, dedicated to revolutionizing the fisheries industry across our country. Dive into our platform to discover cutting-edge solutions aimed at creating a smarter, more sustainable future for fishery management. Join us in our mission to harness technology and expertise to ensure the prosperity of our aquatic resources. Together, let&#39;s pave the way for a brighter tomorrow for both fishermen and fish alike.</p>', '{\"name\":\"value\",\"label\":\"Welcome Message\",\"type\":\"ckeditor\"}', 1, NULL, NULL),
(7, 'services', 'Services', 'Services', '[{\"title\":\"Fishery Automation\",\"image\":\"uploads\\/product\\/p1.jpeg\",\"description\":\"Welcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\\r\\n\\r\\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\\r\\n\\r\\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\\r\\n\\r\\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living.\"},{\"title\":\"Full System Automation\",\"image\":\"uploads\\/product\\/p2.jpeg\",\"description\":\"Welcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\\r\\n\\r\\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\\r\\n\\r\\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\\r\\n\\r\\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living.\"},{\"title\":\"Software Solution\",\"image\":\"uploads\\/product\\/p3.jpeg\",\"description\":\"Welcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\\r\\n\\r\\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\\r\\n\\r\\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\\r\\n\\r\\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living.\"},{\"title\":\"Mobile Application\",\"image\":\"uploads\\/services\\/banner-4.jpg\",\"description\":\"Welcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\\r\\n\\r\\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\\r\\n\\r\\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\\r\\n\\r\\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living.\"}]', '{\"name\":\"value\",\"label\":\"Services\",\"type\":\"repeatable\",\"subfields\":[{\"name\":\"title\",\"label\":\"Title\",\"type\":\"text\"},{\"name\":\"image\",\"label\":\"Image\",\"type\":\"browse\"},{\"name\":\"description\",\"label\":\"Description\",\"type\":\"textarea\",\"attributes\":{\"rows\":\"4\"}}],\"min_rows\":1,\"init_rows\":1}', 1, NULL, '2024-04-01 21:28:23'),
(8, 'teams', 'Teams', 'Our Team', '[{\"name\":\"Mr. Juwel Ahmed\",\"image\":\"uploads\\/teams\\/Md Juwel Ahmed.jpeg\",\"designation\":\"Consultant\"},{\"name\":\"Mr. Roni Saha\",\"image\":\"uploads\\/teams\\/rony saha.jpeg\",\"designation\":\"Consultant\"},{\"name\":\"Mr. Tofail Ahmed\",\"image\":\"uploads\\/teams\\/tofayil ahmed.jpeg\",\"designation\":\"Consultant\"},{\"name\":\"Engr. Mehedi Hasan\",\"image\":\"uploads\\/teams\\/mehedi hasan.jpeg\",\"designation\":\"Team Coordinator\"},{\"name\":\"Engr. Erfan Mahmud Tushar\",\"image\":\"uploads\\/teams\\/download.png\",\"designation\":\"IOT Engineer\"},{\"name\":\"Engr. Ekramul Islam Sumon\",\"image\":\"uploads\\/teams\\/download.png\",\"designation\":\"Software Developer\"},{\"name\":\"Engr. Haraprashad Bishwas Niloy\",\"image\":\"uploads\\/teams\\/niloy.jpeg\",\"designation\":\"Mobile App Developer\"}]', '{\"name\":\"value\",\"label\":\"Teams\",\"type\":\"repeatable\",\"subfields\":[{\"name\":\"name\",\"label\":\"Name\",\"type\":\"text\"},{\"name\":\"image\",\"label\":\"Image\",\"type\":\"browse\",\"hint\":\"Image size should be 1:1 ratio\"},{\"name\":\"designation\",\"label\":\"Designation\",\"type\":\"select_from_array\",\"options\":{\"Consultant\":\"Consultant\",\"Team Coordinator\":\"Team Coordinator\",\"IOT Engineer\":\"IOT Engineer\",\"Software Developer\":\"Software Developer\",\"Mobile App Developer\":\"Mobile App Developer\"}}],\"min_rows\":1,\"init_rows\":1}', 1, NULL, '2024-04-01 22:09:22'),
(9, 'products', 'Products', 'Product List', '[{\"title\":\"Automated Aerator Solutions - 1\",\"image\":\"uploads\\/products\\/product-1.jpg\",\"description\":null},{\"title\":\"Automated Aerator Solutions - 2\",\"image\":\"uploads\\/products\\/product-2.jpg\",\"description\":null},{\"title\":\"Automated Feeder Solutions - 3\",\"image\":\"uploads\\/products\\/product-3.jpg\",\"description\":null},{\"title\":\"Automated Aerator Solutions - 4\",\"image\":\"uploads\\/products\\/product-4.jpg\",\"description\":null},{\"title\":\"Automated Aerator Solutions-5\",\"image\":\"uploads\\/products\\/product-5.jpg\",\"description\":null},{\"title\":\"Automated Aerator Solutions-6\",\"image\":\"uploads\\/products\\/product-6.jpg\",\"description\":null},{\"title\":\"Automated Aerator Solutions-7\",\"image\":\"uploads\\/products\\/product-7.jpg\",\"description\":null},{\"title\":\"Automated Aerator Solutions-8\",\"image\":\"uploads\\/products\\/product-8.jpg\",\"description\":null}]', '{\"name\":\"value\",\"label\":\"Services\",\"type\":\"repeatable\",\"subfields\":[{\"name\":\"title\",\"label\":\"Title\",\"type\":\"text\"},{\"name\":\"image\",\"label\":\"Image\",\"type\":\"browse\"},{\"name\":\"description\",\"label\":\"Description\",\"type\":\"textarea\",\"attributes\":{\"rows\":\"4\"}}],\"min_rows\":1,\"init_rows\":1}', 1, NULL, '2024-04-01 21:37:06');

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(189) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `socials`
--

INSERT INTO `socials` (`id`, `title`, `slug`, `url`, `icon`, `og_title`, `og_image`, `og_description`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Facebook', 'facebook', 'https://facebook.com/#facebook', 'fab fa-facebook-f', NULL, NULL, NULL, 'active', 1, '2022-10-19 01:08:28', '2022-10-19 01:11:52', NULL),
(2, 'LinkedIn', 'linkedin', 'https://linkedin.com/#linkedin', 'fab fa-linkedin-in', NULL, NULL, NULL, 'active', 1, '2022-10-19 01:10:00', '2022-10-19 01:11:47', NULL),
(3, 'Youtube', 'youtube', 'https://youtube.com/#youtube', 'fab fa-youtube', NULL, NULL, NULL, 'active', 1, '2022-10-19 01:10:47', '2022-10-19 01:10:47', NULL),
(4, 'Instagram', 'instagram', 'https://instagram.com/#instagram', 'fab fa-instagram', NULL, NULL, NULL, 'active', 1, '2022-10-19 01:11:26', '2022-10-19 01:11:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `switches`
--

CREATE TABLE `switches` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `switch_type_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint UNSIGNED DEFAULT NULL COMMENT 'Customer creates his own switch',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `switch_types`
--

CREATE TABLE `switch_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `customer_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Customer who is assigned to this switch type',
  `remote_name` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `switch_types`
--

INSERT INTO `switch_types` (`id`, `name`, `slug`, `description`, `status`, `customer_id`, `remote_name`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Aerator', 'aerator', NULL, 'active', NULL, 'aerator', 4, '2024-03-23 23:45:34', '2024-03-25 00:22:54', NULL),
(2, 'Feeder', 'feeder', NULL, 'active', NULL, 'feeder', 4, '2024-03-23 23:45:41', '2024-03-25 00:22:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `switch_type_switch_unit`
--

CREATE TABLE `switch_type_switch_unit` (
  `switch_type_id` bigint UNSIGNED NOT NULL,
  `switch_unit_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `switch_units`
--

CREATE TABLE `switch_units` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `switches` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint UNSIGNED DEFAULT NULL COMMENT 'Customer creates his own sensor unit',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `switch_units`
--

INSERT INTO `switch_units` (`id`, `name`, `serial_number`, `slug`, `switches`, `description`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Switch Unit 1', 'switch-unit-1', 'switch-unit-1', '[{\"number\":\"1\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:12:57', '2024-03-24 01:01:35', NULL),
(2, 'Switch Unit 2', 'switch-unit-2', 'switch-unit-2', '[{\"number\":\"1\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:13:19', '2024-03-24 01:03:35', NULL),
(3, 'Switch Unit 3', 'switch-unit-3', 'switch-unit-3', '[{\"number\":\"1\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:13:19', '2024-03-24 01:03:35', NULL),
(4, 'Switch Unit 4', 'switch-unit-4', 'switch-unit-4', '[{\"number\":\"1\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:13:19', '2024-03-24 01:03:35', NULL),
(5, 'Switch Unit 5', 'switch-unit-5', 'switch-unit-5', '[{\"number\":\"1\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:13:19', '2024-03-24 01:03:35', NULL),
(6, 'Switch Unit 6', 'switch-unit-6', 'switch-unit-6', '[{\"number\":\"1\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:13:19', '2024-03-24 01:03:35', NULL),
(7, 'Switch Unit 7', 'switch-unit-7', 'switch-unit-7', '[{\"number\":\"1\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:13:19', '2024-03-24 01:03:35', NULL),
(8, 'Switch Unit 8', 'switch-unit-8', 'switch-unit-8', '[{\"number\":\"1\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:13:19', '2024-03-24 01:03:35', NULL),
(9, 'Switch Unit 9', 'switch-unit-9', 'switch-unit-9', '[{\"number\":\"1\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:13:19', '2024-03-24 01:03:35', NULL),
(10, 'Switch Unit 10', 'switch-unit-10', 'switch-unit-10', '[{\"number\":\"1\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:13:19', '2024-03-24 01:03:35', NULL),
(11, 'Switch Unit 11', 'switch-unit-11', 'switch-unit-11', '[{\"number\":\"1\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:13:19', '2024-03-24 01:03:35', NULL),
(12, 'Switch Unit 12', 'switch-unit-12', 'switch-unit-12', '[{\"number\":\"1\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C1\"},{\"number\":\"2\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"3\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"4\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"5\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"6\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"7\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":null},{\"number\":\"8\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C8\"},{\"number\":\"9\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"10\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":\"C10\"},{\"number\":\"11\",\"switchType\":\"1\",\"status\":\"on\",\"comment\":null},{\"number\":\"12\",\"switchType\":\"2\",\"status\":\"on\",\"comment\":\"C12\"}]', NULL, 'active', 4, '2024-03-24 00:13:19', '2024-03-30 16:36:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Afzalur Rahman Sabbir', 'afzalbd1@gmail.com', 'afzalbd1', '2023-01-18 21:05:15', '$2y$10$G0obDvT5v6fRNM.JUNYTLOZbHvBtB2eIuTAQra5GZ3PzBmQLg.lWW', 1, 'Cx7loqLMDsHwXeh9izEE7WcAGPjL2HvUNKkAXymMMgd4pHKWLW92AlXar40M', NULL, NULL, NULL),
(2, 'Admin', 'admin@gmail.com', 'admin@gmail.com', NULL, '$2y$10$5XPBl1lMO1rSQIGPPcx.Ku27E4BaRCZ658OmE02w8DNLV801w10HC', 1, 'AAhIiE3fiNRi4E4vx56p0KxLCHrPiSFkGy1nIIh4Qefu1ak8OEFZQdQ3HqMp', NULL, NULL, NULL),
(3, 'User', 'user@yopmail.com', 'user', NULL, '$2y$10$jxfSScf5ClZRPSy76ZNedudsd7pUBYeUnVUMzPxHBJEPsYS/RuIlq', 0, NULL, NULL, NULL, NULL),
(4, 'Super Admin', 'superadmin@yopmail.com', 'superadmin', NULL, '$2a$12$NMYqJXW3s8.LSURNY9lhfuXwDccCLPrZxQ.G81KL3M45J93KBrzXy', 1, 'qh0I7pcSMCQVXvDczMALStOUPW8pPZsrOtwDanvPhMddDY59TDoNeCS6nBJn', NULL, NULL, NULL),
(5, 'Customer-1 Yopmail', 'customer-1@yopmail.com', 'customer-1', NULL, '$2y$10$t.2zItf1QrcH0hMzM70GOeTfc/oMRD1/6PVnGqJNm8SRKuf47BCVK', 0, NULL, '2024-03-06 02:12:38', '2024-03-25 14:29:22', NULL),
(6, 'Customer-2 Yopmail', 'customer-2@yopmail.com', 'customer-2', NULL, '$2y$10$NU9MdxQrPHKp8RgEkH3fzOpeq.p.QT09ds.P.sw33tpEw0hlGgw5e', 0, NULL, '2024-03-06 02:13:02', '2024-03-25 14:29:36', NULL),
(7, 'Customer-3 Yopmail', 'customer-3@yopmail.com', 'customer-3', NULL, '$2y$10$.p8iJocWTeH8kMm94Z5Tr.xCD5lO/LNUMJ6R1YLaJ/FXPqJJ7ZXZC', 0, NULL, '2024-03-06 02:13:20', '2024-03-25 14:28:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `farm_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `n_id_photos` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `first_name`, `last_name`, `farm_name`, `phone`, `phone_verified_at`, `address`, `photo`, `n_id_photos`, `account_holder_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'User', 'Last 1', 'Farm 1', '01721571954', NULL, 'Dhaka, Bangladesh', 'http://smart-fish-bd.test/uploads/user/profile/c4ca4238a0b923820dcc509a6f75849b_wloiiU9AUfLbf8BAdr3Bwd0nUdjAjs74iPN6B63E.png', NULL, NULL, NULL, '2021-01-01 00:00:00', '2023-01-22 15:24:48'),
(2, 2, 'User', 'Last 2', 'Farm 2', '01556616878', NULL, 'Dhaka, Bangladesh', NULL, NULL, NULL, NULL, '2021-01-01 00:00:00', '2021-01-01 00:00:00'),
(3, 3, 'User', 'Last 3', 'Farm 3', '01234567898', NULL, 'Dhaka, Bangladesh', NULL, NULL, NULL, NULL, '2021-01-01 00:00:00', '2021-01-01 00:00:00'),
(4, 4, 'User', 'Last 4', 'Farm 4', '03234567890', NULL, 'Dhaka, Bangladesh', NULL, NULL, NULL, NULL, '2021-01-01 00:00:00', '2021-01-01 00:00:00'),
(5, 7, 'Customer-3', 'Yopmail', 'Oprah Adkins', '017215719541', NULL, 'Ex magna est nostrum', 'uploads/user/profile/c4ca4238a0b923820dcc509a6f75849b_wloiiU9AUfLbf8BAdr3Bwd0nUdjAjs74iPN6B63E.png', '\"null\"', 'Expedita et soluta s', 4, '2024-03-19 00:51:56', '2024-03-25 14:28:26'),
(6, 6, 'Customer-2', 'Yopmail', 'Oprah Adkins', '017215719542', NULL, 'Ex magna est nostrum', 'uploads/user/profile/c4ca4238a0b923820dcc509a6f75849b_wloiiU9AUfLbf8BAdr3Bwd0nUdjAjs74iPN6B63E.png', '\"null\"', 'Expedita et soluta s', 4, '2024-03-19 00:51:56', '2024-03-25 14:29:36'),
(7, 5, 'Customer-1', 'Yopmail', 'Oprah Adkins', '017215719543', NULL, 'Ex magna est nostrum', 'uploads/user/profile/c4ca4238a0b923820dcc509a6f75849b_wloiiU9AUfLbf8BAdr3Bwd0nUdjAjs74iPN6B63E.png', '\"null\"', 'Expedita et soluta', 4, '2024-03-19 00:51:56', '2024-03-25 14:29:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `abouts_slug_unique` (`slug`),
  ADD KEY `abouts_created_by_foreign` (`created_by`);

--
-- Indexes for table `aerators`
--
ALTER TABLE `aerators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aerators_slug_unique` (`slug`),
  ADD KEY `aerators_created_by_foreign` (`created_by`);

--
-- Indexes for table `aerator_project`
--
ALTER TABLE `aerator_project`
  ADD KEY `aerator_project_aerator_id_foreign` (`aerator_id`),
  ADD KEY `aerator_project_project_id_foreign` (`project_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_us_created_by_foreign` (`created_by`);

--
-- Indexes for table `controllers`
--
ALTER TABLE `controllers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `controllers_slug_unique` (`slug`),
  ADD KEY `controllers_created_by_foreign` (`created_by`);

--
-- Indexes for table `controller_project`
--
ALTER TABLE `controller_project`
  ADD KEY `controller_project_controller_id_foreign` (`controller_id`),
  ADD KEY `controller_project_project_id_foreign` (`project_id`);

--
-- Indexes for table `controller_sensor`
--
ALTER TABLE `controller_sensor`
  ADD KEY `controller_sensor_sensor_id_foreign` (`sensor_id`),
  ADD KEY `controller_sensor_controller_id_foreign` (`controller_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feeders`
--
ALTER TABLE `feeders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `feeders_slug_unique` (`slug`),
  ADD KEY `feeders_created_by_foreign` (`created_by`);

--
-- Indexes for table `feeder_histories`
--
ALTER TABLE `feeder_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feeder_histories_feeder_id_foreign` (`feeder_id`),
  ADD KEY `feeder_histories_created_by_foreign` (`created_by`);

--
-- Indexes for table `feeder_project`
--
ALTER TABLE `feeder_project`
  ADD KEY `feeder_project_feeder_id_foreign` (`feeder_id`),
  ADD KEY `feeder_project_project_id_foreign` (`project_id`);

--
-- Indexes for table `fishes`
--
ALTER TABLE `fishes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fishes_slug_unique` (`slug`),
  ADD KEY `fishes_created_by_foreign` (`created_by`);

--
-- Indexes for table `fish_weights`
--
ALTER TABLE `fish_weights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fish_weights_fish_id_foreign` (`fish_id`),
  ADD KEY `fish_weights_created_by_foreign` (`created_by`);

--
-- Indexes for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `footer_links_title_unique` (`title`),
  ADD KEY `footer_links_footer_link_group_id_foreign` (`footer_link_group_id`),
  ADD KEY `footer_links_created_by_foreign` (`created_by`);

--
-- Indexes for table `footer_link_groups`
--
ALTER TABLE `footer_link_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `footer_link_groups_title_unique` (`title`),
  ADD UNIQUE KEY `footer_link_groups_slug_unique` (`slug`),
  ADD KEY `footer_link_groups_created_by_foreign` (`created_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `mqtt_data`
--
ALTER TABLE `mqtt_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mqtt_data_project_id_foreign` (`project_id`),
  ADD KEY `mqtt_data_created_by_foreign` (`created_by`);

--
-- Indexes for table `mqtt_data_histories`
--
ALTER TABLE `mqtt_data_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mqtt_data_histories_mqtt_data_id_foreign` (`mqtt_data_id`),
  ADD KEY `mqtt_data_histories_pond_id_foreign` (`pond_id`),
  ADD KEY `mqtt_data_histories_sensor_unit_id_foreign` (`sensor_unit_id`),
  ADD KEY `mqtt_data_histories_sensor_type_id_foreign` (`sensor_type_id`),
  ADD KEY `mqtt_data_histories_switch_unit_id_foreign` (`switch_unit_id`),
  ADD KEY `mqtt_data_histories_switch_type_id_foreign` (`switch_type_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ponds`
--
ALTER TABLE `ponds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ponds_slug_unique` (`slug`),
  ADD KEY `ponds_project_id_foreign` (`project_id`),
  ADD KEY `ponds_created_by_foreign` (`created_by`);

--
-- Indexes for table `pond_sensor_unit`
--
ALTER TABLE `pond_sensor_unit`
  ADD KEY `pond_sensor_unit_pond_id_foreign` (`pond_id`),
  ADD KEY `pond_sensor_unit_sensor_unit_id_foreign` (`sensor_unit_id`);

--
-- Indexes for table `pond_switch_unit`
--
ALTER TABLE `pond_switch_unit`
  ADD KEY `pond_switch_unit_pond_id_foreign` (`pond_id`),
  ADD KEY `pond_switch_unit_switch_unit_id_foreign` (`switch_unit_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_slug_unique` (`slug`),
  ADD KEY `projects_customer_id_foreign` (`customer_id`),
  ADD KEY `projects_created_by_foreign` (`created_by`);

--
-- Indexes for table `project_sensor`
--
ALTER TABLE `project_sensor`
  ADD KEY `project_sensor_sensor_id_foreign` (`sensor_id`),
  ADD KEY `project_sensor_project_id_foreign` (`project_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `route_lists`
--
ALTER TABLE `route_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_lists_created_by_foreign` (`created_by`);

--
-- Indexes for table `sensors`
--
ALTER TABLE `sensors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sensors_slug_unique` (`slug`),
  ADD KEY `sensors_sensor_type_id_foreign` (`sensor_type_id`),
  ADD KEY `sensors_created_by_foreign` (`created_by`);

--
-- Indexes for table `sensor_types`
--
ALTER TABLE `sensor_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sensor_types_slug_unique` (`slug`),
  ADD KEY `sensor_types_customer_id_foreign` (`customer_id`),
  ADD KEY `sensor_types_created_by_foreign` (`created_by`);

--
-- Indexes for table `sensor_type_sensor_unit`
--
ALTER TABLE `sensor_type_sensor_unit`
  ADD KEY `sensor_type_sensor_unit_sensor_type_id_foreign` (`sensor_type_id`),
  ADD KEY `sensor_type_sensor_unit_sensor_unit_id_foreign` (`sensor_unit_id`);

--
-- Indexes for table `sensor_units`
--
ALTER TABLE `sensor_units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sensor_units_slug_unique` (`slug`),
  ADD KEY `sensor_units_created_by_foreign` (`created_by`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `socials_title_unique` (`title`),
  ADD UNIQUE KEY `socials_slug_unique` (`slug`),
  ADD KEY `socials_created_by_foreign` (`created_by`);

--
-- Indexes for table `switches`
--
ALTER TABLE `switches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `switches_slug_unique` (`slug`),
  ADD KEY `switches_switch_type_id_foreign` (`switch_type_id`),
  ADD KEY `switches_created_by_foreign` (`created_by`);

--
-- Indexes for table `switch_types`
--
ALTER TABLE `switch_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `switch_types_slug_unique` (`slug`),
  ADD KEY `switch_types_customer_id_foreign` (`customer_id`),
  ADD KEY `switch_types_created_by_foreign` (`created_by`);

--
-- Indexes for table `switch_type_switch_unit`
--
ALTER TABLE `switch_type_switch_unit`
  ADD KEY `switch_type_switch_unit_switch_type_id_foreign` (`switch_type_id`),
  ADD KEY `switch_type_switch_unit_switch_unit_id_foreign` (`switch_unit_id`);

--
-- Indexes for table `switch_units`
--
ALTER TABLE `switch_units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `switch_units_slug_unique` (`slug`),
  ADD KEY `switch_units_created_by_foreign` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_details_phone_unique` (`phone`),
  ADD KEY `user_details_user_id_foreign` (`user_id`),
  ADD KEY `user_details_created_by_foreign` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `aerators`
--
ALTER TABLE `aerators`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `controllers`
--
ALTER TABLE `controllers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feeders`
--
ALTER TABLE `feeders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feeder_histories`
--
ALTER TABLE `feeder_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fishes`
--
ALTER TABLE `fishes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fish_weights`
--
ALTER TABLE `fish_weights`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `footer_links`
--
ALTER TABLE `footer_links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `footer_link_groups`
--
ALTER TABLE `footer_link_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `mqtt_data`
--
ALTER TABLE `mqtt_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mqtt_data_histories`
--
ALTER TABLE `mqtt_data_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ponds`
--
ALTER TABLE `ponds`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `route_lists`
--
ALTER TABLE `route_lists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sensors`
--
ALTER TABLE `sensors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sensor_types`
--
ALTER TABLE `sensor_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sensor_units`
--
ALTER TABLE `sensor_units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `switches`
--
ALTER TABLE `switches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `switch_types`
--
ALTER TABLE `switch_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `switch_units`
--
ALTER TABLE `switch_units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `abouts`
--
ALTER TABLE `abouts`
  ADD CONSTRAINT `abouts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `aerators`
--
ALTER TABLE `aerators`
  ADD CONSTRAINT `aerators_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `aerator_project`
--
ALTER TABLE `aerator_project`
  ADD CONSTRAINT `aerator_project_aerator_id_foreign` FOREIGN KEY (`aerator_id`) REFERENCES `aerators` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `aerator_project_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD CONSTRAINT `contact_us_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `controllers`
--
ALTER TABLE `controllers`
  ADD CONSTRAINT `controllers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `controller_project`
--
ALTER TABLE `controller_project`
  ADD CONSTRAINT `controller_project_controller_id_foreign` FOREIGN KEY (`controller_id`) REFERENCES `controllers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `controller_project_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `controller_sensor`
--
ALTER TABLE `controller_sensor`
  ADD CONSTRAINT `controller_sensor_controller_id_foreign` FOREIGN KEY (`controller_id`) REFERENCES `controllers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `controller_sensor_sensor_id_foreign` FOREIGN KEY (`sensor_id`) REFERENCES `sensors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feeders`
--
ALTER TABLE `feeders`
  ADD CONSTRAINT `feeders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feeder_histories`
--
ALTER TABLE `feeder_histories`
  ADD CONSTRAINT `feeder_histories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feeder_histories_feeder_id_foreign` FOREIGN KEY (`feeder_id`) REFERENCES `feeders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feeder_project`
--
ALTER TABLE `feeder_project`
  ADD CONSTRAINT `feeder_project_feeder_id_foreign` FOREIGN KEY (`feeder_id`) REFERENCES `feeders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feeder_project_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fishes`
--
ALTER TABLE `fishes`
  ADD CONSTRAINT `fishes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fish_weights`
--
ALTER TABLE `fish_weights`
  ADD CONSTRAINT `fish_weights_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fish_weights_fish_id_foreign` FOREIGN KEY (`fish_id`) REFERENCES `fishes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD CONSTRAINT `footer_links_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `footer_links_footer_link_group_id_foreign` FOREIGN KEY (`footer_link_group_id`) REFERENCES `footer_link_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `footer_link_groups`
--
ALTER TABLE `footer_link_groups`
  ADD CONSTRAINT `footer_link_groups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mqtt_data`
--
ALTER TABLE `mqtt_data`
  ADD CONSTRAINT `mqtt_data_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mqtt_data_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mqtt_data_histories`
--
ALTER TABLE `mqtt_data_histories`
  ADD CONSTRAINT `mqtt_data_histories_mqtt_data_id_foreign` FOREIGN KEY (`mqtt_data_id`) REFERENCES `mqtt_data` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mqtt_data_histories_pond_id_foreign` FOREIGN KEY (`pond_id`) REFERENCES `ponds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mqtt_data_histories_sensor_type_id_foreign` FOREIGN KEY (`sensor_type_id`) REFERENCES `sensor_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mqtt_data_histories_sensor_unit_id_foreign` FOREIGN KEY (`sensor_unit_id`) REFERENCES `sensor_units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mqtt_data_histories_switch_type_id_foreign` FOREIGN KEY (`switch_type_id`) REFERENCES `switch_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mqtt_data_histories_switch_unit_id_foreign` FOREIGN KEY (`switch_unit_id`) REFERENCES `switch_units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ponds`
--
ALTER TABLE `ponds`
  ADD CONSTRAINT `ponds_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ponds_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pond_sensor_unit`
--
ALTER TABLE `pond_sensor_unit`
  ADD CONSTRAINT `pond_sensor_unit_pond_id_foreign` FOREIGN KEY (`pond_id`) REFERENCES `ponds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pond_sensor_unit_sensor_unit_id_foreign` FOREIGN KEY (`sensor_unit_id`) REFERENCES `sensor_units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pond_switch_unit`
--
ALTER TABLE `pond_switch_unit`
  ADD CONSTRAINT `pond_switch_unit_pond_id_foreign` FOREIGN KEY (`pond_id`) REFERENCES `ponds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pond_switch_unit_switch_unit_id_foreign` FOREIGN KEY (`switch_unit_id`) REFERENCES `switch_units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_sensor`
--
ALTER TABLE `project_sensor`
  ADD CONSTRAINT `project_sensor_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_sensor_sensor_id_foreign` FOREIGN KEY (`sensor_id`) REFERENCES `sensors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `route_lists`
--
ALTER TABLE `route_lists`
  ADD CONSTRAINT `route_lists_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sensors`
--
ALTER TABLE `sensors`
  ADD CONSTRAINT `sensors_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sensors_sensor_type_id_foreign` FOREIGN KEY (`sensor_type_id`) REFERENCES `sensor_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sensor_types`
--
ALTER TABLE `sensor_types`
  ADD CONSTRAINT `sensor_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sensor_types_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sensor_type_sensor_unit`
--
ALTER TABLE `sensor_type_sensor_unit`
  ADD CONSTRAINT `sensor_type_sensor_unit_sensor_type_id_foreign` FOREIGN KEY (`sensor_type_id`) REFERENCES `sensor_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sensor_type_sensor_unit_sensor_unit_id_foreign` FOREIGN KEY (`sensor_unit_id`) REFERENCES `sensor_units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sensor_units`
--
ALTER TABLE `sensor_units`
  ADD CONSTRAINT `sensor_units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `socials`
--
ALTER TABLE `socials`
  ADD CONSTRAINT `socials_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `switches`
--
ALTER TABLE `switches`
  ADD CONSTRAINT `switches_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `switches_switch_type_id_foreign` FOREIGN KEY (`switch_type_id`) REFERENCES `switch_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `switch_types`
--
ALTER TABLE `switch_types`
  ADD CONSTRAINT `switch_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `switch_types_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `switch_type_switch_unit`
--
ALTER TABLE `switch_type_switch_unit`
  ADD CONSTRAINT `switch_type_switch_unit_switch_type_id_foreign` FOREIGN KEY (`switch_type_id`) REFERENCES `switch_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `switch_type_switch_unit_switch_unit_id_foreign` FOREIGN KEY (`switch_unit_id`) REFERENCES `switch_units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `switch_units`
--
ALTER TABLE `switch_units`
  ADD CONSTRAINT `switch_units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
