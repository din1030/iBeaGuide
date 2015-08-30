-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2015 年 08 月 30 日 09:24
-- 伺服器版本: 5.5.36
-- PHP 版本： 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `ibeaguide`
--

-- --------------------------------------------------------

--
-- 資料表結構 `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `exh_id` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `object_type` enum('exh','item') DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `rate` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `exhibitions`
--

CREATE TABLE IF NOT EXISTS `exhibitions` (
  `id` int(11) NOT NULL,
  `curator_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `description` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `daily_open_time` time DEFAULT NULL,
  `daily_close_time` time DEFAULT NULL,
  `web_link` varchar(255) DEFAULT NULL,
  `main_pic` varchar(255) DEFAULT NULL,
  `push_content` varchar(255) DEFAULT NULL,
  `ibeacon_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `exhibitions`
--

INSERT INTO `exhibitions` (`id`, `curator_id`, `title`, `subtitle`, `venue`, `description`, `start_date`, `end_date`, `daily_open_time`, `daily_close_time`, `web_link`, `main_pic`, `push_content`, `ibeacon_id`) VALUES
(1, 1, '政大奇觀特展', NULL, '政治大學', '歡迎光臨政大奇觀特展！', '2015-08-01', '2015-08-31', '09:00:00', '22:00:00', 'http://www.nccu.edu.tw/', 'main.png', '歡迎光臨政大奇觀特展！', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `facilities`
--

CREATE TABLE IF NOT EXISTS `facilities` (
  `id` int(11) NOT NULL,
  `exh_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `main_pic` varchar(255) DEFAULT NULL,
  `push_content` varchar(255) DEFAULT NULL,
  `ibeacon_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `facilities`
--

INSERT INTO `facilities` (`id`, `exh_id`, `title`, `description`, `main_pic`, `push_content`, `ibeacon_id`) VALUES
(4, 1, 'FAC', 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `favlist`
--

CREATE TABLE IF NOT EXISTS `favlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fav_item_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `ibeacons`
--

CREATE TABLE IF NOT EXISTS `ibeacons` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `uuid` char(36) DEFAULT NULL,
  `major` int(11) DEFAULT NULL,
  `minor` int(11) DEFAULT NULL,
  `link_type` enum('exh','item','fac') DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `ibeacons`
--

INSERT INTO `ibeacons` (`id`, `owner_id`, `title`, `uuid`, `major`, `minor`, `link_type`) VALUES
(1, NULL, NULL, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', 1, 1, 'fac');

-- --------------------------------------------------------

--
-- 資料表結構 `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL,
  `exh_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `creator` varchar(255) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `brief` text,
  `main_pic` varchar(255) DEFAULT NULL,
  `audio` varchar(255) DEFAULT NULL,
  `description` text,
  `pic1` varchar(255) DEFAULT NULL,
  `pic2` varchar(255) DEFAULT NULL,
  `pic3` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `publisher` varbinary(255) DEFAULT NULL,
  `finished_time` date DEFAULT NULL,
  `creation_type` varchar(255) DEFAULT NULL,
  `format` varchar(255) DEFAULT NULL,
  `media` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `more_info` text,
  `creator_info` varchar(255) DEFAULT NULL,
  `ibeacon_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL,
  `exh_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `main_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `routes_items`
--

CREATE TABLE IF NOT EXISTS `routes_items` (
  `id` int(11) NOT NULL,
  `r_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) DEFAULT NULL,
  `exh_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `user_type` enum('visitor','admin') DEFAULT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `user_type`, `birthday`) VALUES
(1, 'din1030@gmail.com', 'ad771030', 'CHIA-TING', 'CHENG', 'admin', '1988-10-30');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `object_id_idxfk` (`object_id`),
  ADD KEY `user_id_idxfk` (`user_id`);

--
-- 資料表索引 `exhibitions`
--
ALTER TABLE `exhibitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curator_id_idxfk` (`curator_id`),
  ADD KEY `ibeacon_id_idxfk_2` (`ibeacon_id`);

--
-- 資料表索引 `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exh_id_idxfk_1` (`exh_id`),
  ADD KEY `ibeacon_id_idxfk_1` (`ibeacon_id`);

--
-- 資料表索引 `favlist`
--
ALTER TABLE `favlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_idxfk_1` (`user_id`),
  ADD KEY `fav_item_id_idxfk` (`fav_item_id`);

--
-- 資料表索引 `ibeacons`
--
ALTER TABLE `ibeacons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id_idxfk` (`owner_id`);

--
-- 資料表索引 `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exh_id_idxfk` (`exh_id`),
  ADD KEY `ibeacon_id_idxfk` (`ibeacon_id`);

--
-- 資料表索引 `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exh_id_idxfk_2` (`exh_id`);

--
-- 資料表索引 `routes_items`
--
ALTER TABLE `routes_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `r_id_idxfk` (`r_id`),
  ADD KEY `item_id_idxfk` (`item_id`);

--
-- 資料表索引 `sections`
--
ALTER TABLE `sections`
  ADD KEY `exh_id_idxfk_3` (`exh_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `exhibitions`
--
ALTER TABLE `exhibitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- 使用資料表 AUTO_INCREMENT `favlist`
--
ALTER TABLE `favlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `ibeacons`
--
ALTER TABLE `ibeacons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `routes_items`
--
ALTER TABLE `routes_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`object_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- 資料表的 Constraints `exhibitions`
--
ALTER TABLE `exhibitions`
  ADD CONSTRAINT `exhibitions_ibfk_1` FOREIGN KEY (`curator_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `exhibitions_ibfk_2` FOREIGN KEY (`ibeacon_id`) REFERENCES `ibeacons` (`id`);

--
-- 資料表的 Constraints `facilities`
--
ALTER TABLE `facilities`
  ADD CONSTRAINT `facilities_ibfk_1` FOREIGN KEY (`exh_id`) REFERENCES `exhibitions` (`id`),
  ADD CONSTRAINT `facilities_ibfk_2` FOREIGN KEY (`ibeacon_id`) REFERENCES `ibeacons` (`id`);

--
-- 資料表的 Constraints `favlist`
--
ALTER TABLE `favlist`
  ADD CONSTRAINT `favlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favlist_ibfk_2` FOREIGN KEY (`fav_item_id`) REFERENCES `items` (`id`);

--
-- 資料表的 Constraints `ibeacons`
--
ALTER TABLE `ibeacons`
  ADD CONSTRAINT `ibeacons_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

--
-- 資料表的 Constraints `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`exh_id`) REFERENCES `exhibitions` (`id`),
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`ibeacon_id`) REFERENCES `ibeacons` (`id`);

--
-- 資料表的 Constraints `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`exh_id`) REFERENCES `exhibitions` (`id`);

--
-- 資料表的 Constraints `routes_items`
--
ALTER TABLE `routes_items`
  ADD CONSTRAINT `routes_items_ibfk_1` FOREIGN KEY (`r_id`) REFERENCES `routes` (`id`),
  ADD CONSTRAINT `routes_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- 資料表的 Constraints `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`exh_id`) REFERENCES `exhibitions` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
