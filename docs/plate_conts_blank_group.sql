-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2026-06-14 22:10:17
-- 服务器版本： 5.6.50-log
-- PHP 版本： 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `test_elccc_cn`
--

-- --------------------------------------------------------

--
-- 表的结构 `plate_conts_blank_group`
--

CREATE TABLE `plate_conts_blank_group` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `ratio` decimal(10,6) NOT NULL DEFAULT '1.000000',
  `sort` int(11) NOT NULL DEFAULT '0',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `up_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `plate_conts_blank_group`
--

INSERT INTO `plate_conts_blank_group` (`id`, `pid`, `name`, `ratio`, `sort`, `add_time`, `up_time`) VALUES
(1, 0, '标准1选项卡', '1.000000', 1, 1781435857, 1781435857),
(2, 0, '标准2选项卡', '1.000000', 2, 1781435857, 1781435857),
(3, 0, '标准3选项卡', '1.000000', 3, 1781435857, 1781435857),
(4, 0, '标准4选项卡', '1.000000', 4, 1781435857, 1781435857),
(5, 0, '标准5选项卡', '1.000000', 5, 1781435857, 1781435857),
(6, 0, '标准6选项卡', '1.000000', 6, 1781435857, 1781435857),
(7, 0, '标准7选项卡', '1.000000', 7, 1781435857, 1781435857),
(8, 0, '标准8选项卡', '1.000000', 8, 1781435857, 1781435857),
(9, 0, '标准9选项卡', '1.000000', 9, 1781435857, 1781435857),
(10, 0, '标准10选项卡', '1.000000', 10, 1781435857, 1781435857);

--
-- 转储表的索引
--

--
-- 表的索引 `plate_conts_blank_group`
--
ALTER TABLE `plate_conts_blank_group`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `plate_conts_blank_group`
--
ALTER TABLE `plate_conts_blank_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
