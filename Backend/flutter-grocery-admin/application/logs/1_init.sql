-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 27, 2018 at 05:49 AM
-- Server version: 5.6.28
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ps_wallpaper`
--

-- --------------------------------------------------------

--
-- Table structure for table `core_images`
--

CREATE TABLE `core_images` (
  `img_id` varchar(255) NOT NULL,
  `img_parent_id` varchar(255) NOT NULL,
  `img_type` varchar(100) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `Img_width` varchar(20) NOT NULL,
  `img_height` varchar(20) NOT NULL,
  `img_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_images`
--

INSERT INTO `core_images` (`img_id`, `img_parent_id`, `img_type`, `img_path`, `Img_width`, `img_height`, `img_desc`) VALUES
('img1843861b7547b14dca8925eff9c547fa', 'cat5a770d139ce93876fa4b140e6598e179', 'category', 'Cover15.png', '600', '400', ''),
('img1dbbc76494f65bf5894fbf09a46e315a', 'abt1', 'about', 'cover1(2).png', '600', '400', 'test '),
('img4c19a501ea7460644963a44ba0900634', 'cat202ebed062bda65e0230168e5ee6c412', 'category', 'Cover19.png', '600', '400', ''),
('img6d4421199d3a001e6a0cb11398a7794e', 'cat512ec440fcb6a0cf6ec4a2a170bc0821', 'category', 'Cover13.png', '600', '400', ''),
('img854d8c6e93fd37f6df0303314e4aca14', 'cat3fa6c66f2fdd9d396c9e857050540f5f', 'category', 'Cover14.png', '600', '400', ''),
('img8cad8fb15478bd27e9e71ceb775d4841', 'cat01a99387bf1588b4c42fa6229725d081', 'category', 'Cover16.png', '600', '400', ''),
('img9591b14020f0bd2c1b9abc1c5a7e8881', 'cataac89da8f95cbe9b3e4c656cfac0d2f8', 'category', 'Cover11.png', '600', '400', ''),
('imgbec65f37f48d51a23546972e9c664b8b', 'cat7bd5806ed94661108946e2f7742907c2', 'category', 'cover1.png', '600', '400', ''),
('imgbfcf9336e8b6788748f90a6090f27814', 'cat342ecde97db1fe4779498ed7afe40495', 'category', 'cover12.png', '600', '400', ''),
('imgdfd9f5a6dff02ebd0ef23629bf2a6697', 'catc89337f32ce2dc3f6fcdbcd1d1c54350', 'category', 'Cover18.png', '600', '400', ''),
('imgeacec31d7f6b5f35ebf4fee801bcdd63', 'catc8b2fade7c6c706dabd9412f83e9f24a', 'category', 'Cover17.png', '600', '400', '');

-- --------------------------------------------------------

--
-- Table structure for table `core_menu_groups`
--

CREATE TABLE `core_menu_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_menu_groups`
--

INSERT INTO `core_menu_groups` (`group_id`, `group_name`, `group_icon`) VALUES
(1, 'Entry', 'fa-pencil-square-o'),
(2, 'Users Feedback', 'fa-list-alt'),
(3, 'Users Management', 'fa-users'),
(4, 'Miscellaneous', 'fa-cogs');

-- --------------------------------------------------------

--
-- Table structure for table `core_modules`
--

CREATE TABLE `core_modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `module_desc` text NOT NULL,
  `module_icon` varchar(100) NOT NULL,
  `ordering` int(3) NOT NULL,
  `is_show_on_menu` tinyint(1) NOT NULL,
  `group_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_modules`
--

INSERT INTO `core_modules` (`module_id`, `module_name`, `module_desc`, `module_icon`, `ordering`, `is_show_on_menu`, `group_id`) VALUES
(1, 'categories', 'Categories', '', 1, 1, 1),
(2, 'wallpapers', 'Wallpapers', '', 2, 1, 1),
(7, 'contacts', 'Contact Us Message', '', 7, 1, 2),
(8, 'system_users', 'System Users', '', 9, 1, 3),
(9, 'registered_users', 'Registered Users', '', 9, 1, 3),
(10, 'abouts', 'About & Setting', '', 10, 1, 4),
(11, 'notis', 'Push Notification', '', 11, 1, 4),
(12, 'analytics', 'Analytics', '', 12, 1, 4),
(13, 'dashboard/exports', 'Export Database', '', 13, 1, 4),
(14, 'Contacts', 'Contacts', '', 3, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `core_permissions`
--

CREATE TABLE `core_permissions` (
  `user_id` varchar(255) NOT NULL,
  `module_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_permissions`
--

INSERT INTO `core_permissions` (`user_id`, `module_id`) VALUES
('c4ca4238a0b923820dcc509a6f75849b', '1'),
('c4ca4238a0b923820dcc509a6f75849b', '10'),
('c4ca4238a0b923820dcc509a6f75849b', '11'),
('c4ca4238a0b923820dcc509a6f75849b', '12'),
('c4ca4238a0b923820dcc509a6f75849b', '13'),
('c4ca4238a0b923820dcc509a6f75849b', '2'),
('c4ca4238a0b923820dcc509a6f75849b', '4'),
('c4ca4238a0b923820dcc509a6f75849b', '5'),
('c4ca4238a0b923820dcc509a6f75849b', '6'),
('c4ca4238a0b923820dcc509a6f75849b', '7'),
('c4ca4238a0b923820dcc509a6f75849b', '8'),
('c4ca4238a0b923820dcc509a6f75849b', '9'),
('usr0cc2e9b1c2575aca1d984f8c8872004a', '1'),
('usr0cc2e9b1c2575aca1d984f8c8872004a', '2'),
('usr0cc2e9b1c2575aca1d984f8c8872004a', '3'),
('usr0cc2e9b1c2575aca1d984f8c8872004a', '4'),
('usr0cc2e9b1c2575aca1d984f8c8872004a', '5'),
('usr0cc2e9b1c2575aca1d984f8c8872004a', '7'),
('usr0cc2e9b1c2575aca1d984f8c8872004a', '8'),
('usr366968441c53d9f1119ebb01118aad1a', '1'),
('usr366968441c53d9f1119ebb01118aad1a', '10'),
('usr366968441c53d9f1119ebb01118aad1a', '11'),
('usr366968441c53d9f1119ebb01118aad1a', '12'),
('usr366968441c53d9f1119ebb01118aad1a', '2'),
('usr366968441c53d9f1119ebb01118aad1a', '3'),
('usr366968441c53d9f1119ebb01118aad1a', '4'),
('usr366968441c53d9f1119ebb01118aad1a', '5'),
('usr366968441c53d9f1119ebb01118aad1a', '7'),
('usr5e35c56629400c6efeadba4031450b17', '1'),
('usra2986a582495b8c76fc66a556c0a1297', '1'),
('usra2986a582495b8c76fc66a556c0a1297', '2'),
('usrcaae20b484a3039c2f4307cb854a42a9', '2');

-- --------------------------------------------------------

--
-- Table structure for table `core_reset_codes`
--

CREATE TABLE `core_reset_codes` (
  `code_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `core_roles`
--

CREATE TABLE `core_roles` (
  `role_id` varchar(255) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_roles`
--

INSERT INTO `core_roles` (`role_id`, `role_name`, `role_desc`) VALUES
('1', 'admin', 'Administrator'),
('2', 'editor', 'Editor'),
('3', 'author', 'Author'),
('4', 'normal', 'Normal');

-- --------------------------------------------------------

--
-- Table structure for table `core_role_access`
--

CREATE TABLE `core_role_access` (
  `role_id` varchar(255) NOT NULL,
  `action_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_role_access`
--

INSERT INTO `core_role_access` (`role_id`, `action_id`) VALUES
('1', 'add'),
('1', 'ban'),
('1', 'delete'),
('1', 'edit'),
('1', 'module'),
('1', 'publish'),
('2', 'add'),
('2', 'delete'),
('2', 'edit'),
('2', 'publish'),
('3', 'add'),
('3', 'edit');

-- --------------------------------------------------------

--
-- Table structure for table `core_sessions`
--

CREATE TABLE `core_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `core_users`
--

CREATE TABLE `core_users` (
  `user_id` varchar(255) NOT NULL,
  `user_is_sys_admin` int(11) NOT NULL DEFAULT '0',
  `facebook_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_about_me` text NOT NULL,
  `user_cover_photo` varchar(255) NOT NULL,
  `user_profile_photo` varchar(255) NOT NULL,
  `role_id` varchar(255) NOT NULL DEFAULT '4',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_users`
--

INSERT INTO `core_users` (`user_id`, `user_is_sys_admin`, `facebook_id`, `user_name`, `user_email`, `user_phone`, `user_password`, `user_about_me`, `user_cover_photo`, `user_profile_photo`, `role_id`, `status`, `is_banned`, `added_date`) VALUES
('c4ca4238a0b923820dcc509a6f75849b', 1, '', 'PS News Admin', 'admin@psnews.com', '12345678', '21232f297a57a5a743894a0e4a801fc3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur a dapibus justo. Pellentesque ultricies placerat velit, id vehicula arcu venenatis vel. Donec massa ante, blandit efficitur risus vel, euismod tempus mi. Aliquam porta ullamcorper venenatis. Ut elementum eu lacus lobortis hendrerit.', '', 'people_icon.jpg', '1', 1, 0, '2017-10-25 06:49:55'),
('usr0cc2e9b1c2575aca1d984f8c8872004a', 0, '', 'PS Editor', 'editor@psnews.com', '', '5aee9dbd2a188839105073571bee1b1f', '', '', '', '2', 1, 0, '2018-01-21 05:28:44'),
('usr366968441c53d9f1119ebb01118aad1a', 0, '', 'PS Editor', 'pseditor@gmail.com', '12345', 'b75e6e09627da048baac2a4a466d42c5', '', '', '', '2', 1, 0, '2018-01-03 06:20:35'),
('usr722250fcc5ce4b6e91f4d34098c4b33b', 0, '', 'PS Web User', 'pswebuser@gmail.com', '99887766', '8f5bf5c1ae1f4f262bb010698fca5e23', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '', 'backhem5.png', '4', 1, 0, '2018-01-03 06:34:46'),
('usr7d43ef256d028978d61af28d08572a8e', 0, '', 'Naing Linn Thet', 'fokhwar@gmail.com', '', '81dc9bdb52d04dc20036dbd8313ed055', '', '', '', '4', 1, 0, '2018-01-26 05:28:04'),
('usrcaae20b484a3039c2f4307cb854a42a9', 0, '', 'PS Author', 'psauthor@gmail.com', '', 'b0840fe0a323551b1f94d573130ab4f5', '', '', '', '3', 1, 0, '2018-01-03 06:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `psn_about`
--

CREATE TABLE `psn_about` (
  `about_id` varchar(225) NOT NULL,
  `about_title` varchar(225) NOT NULL,
  `about_description` longtext NOT NULL,
  `about_email` varchar(255) NOT NULL,
  `about_phone` varchar(255) NOT NULL,
  `about_website` varchar(255) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_description` text NOT NULL,
  `seo_keywords` varchar(255) NOT NULL,
  `ads_on` tinyint(1) NOT NULL DEFAULT '0',
  `ads_client` text NOT NULL,
  `ads_slot` text NOT NULL,
  `analyt_on` tinyint(1) NOT NULL DEFAULT '0',
  `analyt_track_id` text NOT NULL,
  `facebook` text NOT NULL,
  `google_plus` text NOT NULL,
  `instagram` text NOT NULL,
  `youtube` text NOT NULL,
  `pinterest` text NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `theme_style` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `psn_about`
--

INSERT INTO `psn_about` (`about_id`, `about_title`, `about_description`, `about_email`, `about_phone`, `about_website`, `seo_title`, `seo_description`, `seo_keywords`, `ads_on`, `ads_client`, `ads_slot`, `analyt_on`, `analyt_track_id`, `facebook`, `google_plus`, `instagram`, `youtube`, `pinterest`, `twitter`, `theme_style`) VALUES
('abt1', 'Nice Product Powered By Panacea-Soft', 'Panacea-Soft is a software development team that focuses on helping your business with mobile and web technology.We tried our best to delivery quality product on time according clientâ€™s requirements and exceptions. We are technology oriented team so before we code, we analyse for your requirements and brain storm then start for development. We donâ€™t over promise to client and trying our best to deliver awesome product package. Thanks for reaching out to us. We are happy to listen your world and enjoy to solve the problem using technology.', 'teamps.is.cool@gmail.com', '+9592540942**', 'http://www.panacea-soft.com', 'Software Development', 'Panacea-Soft is a software development team that focuses on helping your business with mobile and web technology.', 'web, mobile, technology', 1, 'ca-pub-7127831079008160', '6882887537', 1, 'UA-79164209-2', 'fb1', 'gp1', 'in1', 'yo1', 'pi1', 'tw1', 'default');

-- --------------------------------------------------------

--
-- Table structure for table `psn_categories`
--

CREATE TABLE `psn_categories` (
  `cat_id` varchar(255) NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_ordering` int(11) NOT NULL,
  `cat_is_published` tinyint(1) NOT NULL DEFAULT '1',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `psn_categories`
--

INSERT INTO `psn_categories` (`cat_id`, `cat_name`, `cat_ordering`, `cat_is_published`, `added_date`) VALUES
('cat01a99387bf1588b4c42fa6229725d081', 'Real Estate', 7, 1, '2017-12-03 06:25:18'),
('cat202ebed062bda65e0230168e5ee6c412', 'Travel', 10, 1, '2017-12-03 06:27:21'),
('cat342ecde97db1fe4779498ed7afe40495', 'Entertainment', 3, 1, '2017-12-03 06:22:08'),
('cat3fa6c66f2fdd9d396c9e857050540f5f', 'Life Style', 5, 1, '2017-12-03 06:23:28'),
('cat512ec440fcb6a0cf6ec4a2a170bc0821', 'Health', 4, 1, '2017-11-23 06:18:42'),
('cat5a770d139ce93876fa4b140e6598e179', 'Politics', 6, 1, '2017-12-03 06:24:07'),
('cat7bd5806ed94661108946e2f7742907c2', 'Business', 1, 1, '2017-12-03 06:18:18'),
('cataac89da8f95cbe9b3e4c656cfac0d2f8', 'Commentary', 2, 1, '2017-12-03 06:19:03'),
('catc89337f32ce2dc3f6fcdbcd1d1c54350', 'Technology', 9, 1, '2017-11-23 06:18:30'),
('catc8b2fade7c6c706dabd9412f83e9f24a', 'Sport', 8, 1, '2017-12-03 06:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `psn_contact`
--

CREATE TABLE `psn_contact` (
  `contact_id` varchar(255) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_message` text NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `psn_contact`
--

INSERT INTO `psn_contact` (`contact_id`, `contact_name`, `contact_email`, `contact_phone`, `contact_message`, `added_date`) VALUES
('con0d43e8b9ab0e3ffde1d3d56ae819b3b1', 'ha ha', 'pphmit@gmail.com', '13123', 'this is msg.', '2017-12-05 18:34:14'),
('con1a702afcd322e22d79c45d6f912f7319', 'naing', 'fokhwar@gmail.com', '09950212121', 'Hello', '2018-02-07 08:47:48'),
('con3ed59453322f9ed52faef12e66a4cb31', 'ha ha 2', 'pphmit@gmail.com', '13123', 'this is msg.', '2017-12-05 18:35:22'),
('con885841ce59b584d546b9fe5208e3250d', 'ps client', 'psclient@gmail.com', '11223344', 'Duis aute irure dolor in reprehenderit in voluptate velit esse\ncillum dolore eu fugiat nulla pariatur', '2018-01-03 07:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `psn_push_notification_tokens`
--

CREATE TABLE `psn_push_notification_tokens` (
  `push_noti_token_id` varchar(255) NOT NULL,
  `device_id` text,
  `os_type` varchar(50) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `psn_touches`
--

CREATE TABLE `psn_touches` (
  `touch_id` varchar(255) NOT NULL,
  `wallpaper_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `psn_wallpapers`
--

CREATE TABLE `psn_wallpapers` (
  `wallpaper_id` varchar(255) NOT NULL,
  `cat_id` varchar(255) NOT NULL,
  `wallpaper_title` varchar(255) NOT NULL,
  `wallpaper_desc` longtext NOT NULL,
  `wallpaper_is_published` tinyint(4) NOT NULL COMMENT '1=pub, 0=unpub',
  `wallpaper_search_tags` varchar(255) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `seo_keywords` text NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `core_images`
--
ALTER TABLE `core_images`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `core_menu_groups`
--
ALTER TABLE `core_menu_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `core_modules`
--
ALTER TABLE `core_modules`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `core_permissions`
--
ALTER TABLE `core_permissions`
  ADD PRIMARY KEY (`user_id`,`module_id`);

--
-- Indexes for table `core_reset_codes`
--
ALTER TABLE `core_reset_codes`
  ADD PRIMARY KEY (`code_id`);

--
-- Indexes for table `core_roles`
--
ALTER TABLE `core_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `core_role_access`
--
ALTER TABLE `core_role_access`
  ADD PRIMARY KEY (`role_id`,`action_id`);

--
-- Indexes for table `core_users`
--
ALTER TABLE `core_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `psn_about`
--
ALTER TABLE `psn_about`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `psn_categories`
--
ALTER TABLE `psn_categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `psn_contact`
--
ALTER TABLE `psn_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `psn_push_notification_tokens`
--
ALTER TABLE `psn_push_notification_tokens`
  ADD PRIMARY KEY (`push_noti_token_id`);

--
-- Indexes for table `psn_touches`
--
ALTER TABLE `psn_touches`
  ADD PRIMARY KEY (`touch_id`);

--
-- Indexes for table `psn_wallpapers`
--
ALTER TABLE `psn_wallpapers`
  ADD PRIMARY KEY (`wallpaper_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `core_modules`
--
ALTER TABLE `core_modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
