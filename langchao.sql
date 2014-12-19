-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2014-12-16 01:09:23
-- 服务器版本： 5.5.8-log
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `langchao`
--

-- --------------------------------------------------------

--
-- 表的结构 `ldb_sms_captcha`
--

CREATE TABLE IF NOT EXISTS `ldb_sms_captcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `captcha` varchar(25) NOT NULL COMMENT '验证码',
  `task_id` varchar(50) NOT NULL COMMENT '短信发送任务ID',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0无效;1有效',
  `created` int(11) NOT NULL COMMENT '生成时间戳',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `ldb_sms_captcha`
--

INSERT INTO `ldb_sms_captcha` (`id`, `uid`, `captcha`, `task_id`, `status`, `created`) VALUES
(1, 1, 'aabbcc', '', '1', 2014),
(2, 1, 'ccddee', '', '1', 2011),
(3, 1, 'asdfadf', '', '1', 2013),
(4, 1, '192477', '233109', '1', 1417710112),
(5, 1, '897964', '233110', '1', 1417715857),
(6, 1, '381881', '233109', '1', 1427938783);

-- --------------------------------------------------------

--
-- 表的结构 `ldb_sms_setting`
--

CREATE TABLE IF NOT EXISTS `ldb_sms_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(50) NOT NULL COMMENT '短信平台用ID',
  `account` varchar(50) NOT NULL COMMENT '短信平台帐号',
  `passwd` varchar(50) NOT NULL COMMENT '短信平台密码',
  `url` varchar(255) NOT NULL COMMENT '短信平台地址',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0无效;1有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ldb_sms_setting`
--

INSERT INTO `ldb_sms_setting` (`id`, `userid`, `account`, `passwd`, `url`, `status`) VALUES
(1, '1038', 'lcgm', '666888', 'http://115.238.169.140:9999/sms.aspx', '1');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_user`
--

CREATE TABLE IF NOT EXISTS `ldb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `roles` enum('1','2','3','4','5') NOT NULL COMMENT '用户角色',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `short_num` varchar(50) NOT NULL COMMENT '企业短号',
  `department` varchar(50) NOT NULL COMMENT '部门',
  `position` varchar(50) NOT NULL COMMENT '职位',
  `email` varchar(100) NOT NULL COMMENT '企业邮箱',
  `addr` int(11) NOT NULL COMMENT '工作地点id',
  `work_type` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0非驻场/1驻场',
  `expenses` float NOT NULL DEFAULT '0' COMMENT '基础报销，单位元',
  `work_time` int(11) NOT NULL COMMENT '上下班时间id',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0离职/1在职',
  `img` varchar(200) NOT NULL COMMENT '图片地址',
  `login_time` datetime NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `ldb_user`
--

INSERT INTO `ldb_user` (`id`, `username`, `password`, `name`, `roles`, `mobile`, `short_num`, `department`, `position`, `email`, `addr`, `work_type`, `expenses`, `work_time`, `status`, `img`, `login_time`, `created`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '测试1', '1', '13661850643', '13360', '研发中心', '工程师', 'xxx@126.com', 0, '1', 0, 0, '1', 'user_admin.jpg', '2014-12-03 23:26:47', '2014-12-03 15:26:47'),
(2, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test', '1', '111', '222', '333', '444', '11@11', 0, '1', 0, 9, '1', '', '0000-00-00 00:00:00', '2014-12-10 16:40:14'),
(3, '三代富贵 ', '3d70ef0237e5b8ff729cc83277364056', '阿斯顿发', '1', '阿斯顿发', '', '', '', '', 0, '1', 0, 9, '1', 'user_.jpg', '0000-00-00 00:00:00', '2014-12-14 15:46:01'),
(7, '阿斯顿发生的', '9f10648f089cc3ba57c5ae46ba98e57a', '阿斯顿发生的', '1', '阿斯顿发', '', '阿斯顿发', '', '', 0, '1', 0, 9, '1', 'user_阿斯顿发生的.jpg', '0000-00-00 00:00:00', '2014-12-14 15:55:26'),
(8, 'test2', 'fb351247ccb4bcaeadb70cf72a957699', '啊', '1', '啊', '啊', '啊', ' 啊', ' 啊', 0, '0', 0, 9, '1', 'user_test2.jpg', '0000-00-00 00:00:00', '2014-12-15 16:27:37');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
