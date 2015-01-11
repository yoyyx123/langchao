-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 01 月 11 日 15:04
-- 服务器版本: 5.5.40
-- PHP 版本: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `langchao`
--

-- --------------------------------------------------------

--
-- 表的结构 `ldb_city_list`
--

CREATE TABLE IF NOT EXISTS `ldb_city_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `display` enum('0','1') NOT NULL DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ldb_city_list`
--

INSERT INTO `ldb_city_list` (`id`, `name`, `display`, `sort`) VALUES
(2, '北京', '1', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ldb_ctl_list`
--

CREATE TABLE IF NOT EXISTS `ldb_ctl_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `ctl_file` varchar(255) NOT NULL COMMENT '控制器名称',
  `ctl_act` varchar(255) DEFAULT NULL COMMENT '控制器动作',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '组id',
  `display` enum('0','1') NOT NULL DEFAULT '1' COMMENT '左边显示',
  `istopmenu` enum('0','1') NOT NULL DEFAULT '0',
  `type` enum('ctl','business') NOT NULL DEFAULT 'ctl',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `ldb_ctl_list`
--

INSERT INTO `ldb_ctl_list` (`id`, `name`, `ctl_file`, `ctl_act`, `pid`, `display`, `istopmenu`, `type`, `sort`) VALUES
(1, '登录首页', 'home', 'index', 0, '1', '0', 'ctl', NULL),
(2, '首页个人信息', 'home', 'index', 1, '1', '0', 'ctl', NULL),
(3, '个人设置', 'user', 'info', 1, '1', '0', 'ctl', NULL),
(4, '账户模块', '', NULL, 0, '1', '0', 'ctl', NULL),
(5, '账户添加', 'user', 'add', 4, '1', '0', 'ctl', NULL),
(6, '账户管理', 'user', 'manage', 4, '1', '0', 'ctl', NULL),
(7, '后台模块', 'system', 'index', 0, '1', '0', 'ctl', NULL),
(8, '角色管理', 'system', 'role_list', 7, '1', '0', 'ctl', NULL),
(9, '角色添加', 'system', 'role_add', 7, '1', '0', 'ctl', NULL),
(10, '工作地点', 'system', 'city_list', 7, '1', '0', 'ctl', NULL),
(11, '客户属性', 'system', 'custom_list', 7, '1', '0', 'ctl', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ldb_custom_type_list`
--

CREATE TABLE IF NOT EXISTS `ldb_custom_type_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `display` enum('0','1') NOT NULL DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ldb_custom_type_list`
--

INSERT INTO `ldb_custom_type_list` (`id`, `name`, `display`, `sort`) VALUES
(2, '分行', '1', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ldb_department_list`
--

CREATE TABLE IF NOT EXISTS `ldb_department_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `display` enum('0','1') NOT NULL DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ldb_department_list`
--

INSERT INTO `ldb_department_list` (`id`, `name`, `display`, `sort`) VALUES
(2, '研发', '1', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ldb_event_list`
--

CREATE TABLE IF NOT EXISTS `ldb_event_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `department_id` varchar(100) NOT NULL,
  `display` enum('0','1') NOT NULL DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ldb_event_list`
--

INSERT INTO `ldb_event_list` (`id`, `name`, `department_id`, `display`, `sort`) VALUES
(2, '研发项目', 'all', '1', NULL),
(3, '网络部署', '4', '1', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ldb_member`
--

CREATE TABLE IF NOT EXISTS `ldb_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL COMMENT '客户编号',
  `name` varchar(200) NOT NULL COMMENT '客户全称',
  `short_name` varchar(200) NOT NULL COMMENT '客户简称',
  `city` int(11) NOT NULL COMMENT '城市id',
  `member_type` int(11) NOT NULL COMMENT '客户属性id',
  `addr` varchar(200) NOT NULL COMMENT '地址',
  `bus` varchar(500) NOT NULL COMMENT '公交/地铁',
  `contacts` varchar(200) NOT NULL COMMENT '客户联系人',
  `mobile` varchar(50) NOT NULL COMMENT '联系电话',
  `fax` varchar(50) NOT NULL COMMENT '传真',
  `project_man` varchar(50) NOT NULL COMMENT '工程项目负责人',
  `project_mobile` varchar(50) NOT NULL COMMENT '工程项目负责人联系电话',
  `business_man` varchar(50) NOT NULL COMMENT '日常业务负责人',
  `business_mobile` varchar(50) NOT NULL COMMENT '日常业务负责人联系电话',
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ldb_member`
--

INSERT INTO `ldb_member` (`id`, `code`, `name`, `short_name`, `city`, `member_type`, `addr`, `bus`, `contacts`, `mobile`, `fax`, `project_man`, `project_mobile`, `business_man`, `business_mobile`, `addtime`) VALUES
(1, 'abc', '工行北京支行', '北京支行', 5, 9, '3里屯28号', '一号线3号出口一号线3号出口一号线3号出口一号线3号出口', '张三', '111111', '2342342', '李四', '22222', '王五', '3333', '2015-01-04 07:55:31'),
(2, '111', '李四', '小李', 6, 10, '1号线', '1号线', '1', '123132123', '1', '1', '123', '1', '1', '2015-01-08 15:09:53');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_setting_list`
--

CREATE TABLE IF NOT EXISTS `ldb_setting_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `display` enum('0','1') NOT NULL DEFAULT '1',
  `type` enum('city','custom','department','worktime','performance','filetype','membertype') NOT NULL DEFAULT 'city',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `ldb_setting_list`
--

INSERT INTO `ldb_setting_list` (`id`, `name`, `display`, `type`, `sort`) VALUES
(2, '研发部', '1', 'department', NULL),
(3, '设备签收单', '1', 'performance', NULL),
(4, '信息部', '1', 'department', NULL),
(5, '北京市', '1', 'city', NULL),
(6, '上海市', '1', 'city', NULL),
(7, '9-12', '1', 'worktime', NULL),
(8, '6-18', '1', 'worktime', NULL),
(9, '分行', '1', 'membertype', NULL),
(10, '支行', '1', 'membertype', NULL);

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
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '测试1', '1', '13661850643', '13360', '研发中心', '工程师', 'xxx@126.com', 0, '1', 0, 0, '1', 'user_admin.jpg', '2014-12-03 23:26:47', '2014-12-03 07:26:47'),
(2, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test', '1', '111', '222', '333', '444', '11@11', 0, '1', 0, 9, '1', '', '0000-00-00 00:00:00', '2014-12-10 08:40:14'),
(3, '三代富贵 ', '3d70ef0237e5b8ff729cc83277364056', '阿斯顿发', '1', '阿斯顿发', '', '', '', '', 0, '1', 0, 9, '1', 'user_.jpg', '0000-00-00 00:00:00', '2014-12-14 07:46:01'),
(7, '阿斯顿发生的', '9f10648f089cc3ba57c5ae46ba98e57a', '阿斯顿发生的', '1', '阿斯顿发', '', '阿斯顿发', '', '', 0, '1', 0, 9, '1', 'user_阿斯顿发生的.jpg', '0000-00-00 00:00:00', '2014-12-14 07:55:26'),
(8, 'test2', 'fb351247ccb4bcaeadb70cf72a957699', '啊', '1', '啊', '啊', '啊', ' 啊', ' 啊', 0, '0', 0, 9, '1', 'user_test2.jpg', '0000-00-00 00:00:00', '2014-12-15 08:27:37');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_user_roles`
--

CREATE TABLE IF NOT EXISTS `ldb_user_roles` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  `role_memo` text NOT NULL,
  `permission` text,
  `disabled` enum('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `ldb_user_roles`
--

INSERT INTO `ldb_user_roles` (`role_id`, `role_name`, `role_memo`, `permission`, `disabled`) VALUES
(15, '管理员', '有所有权限啊啊', 'a:8:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";i:5;s:1:"6";i:6;s:1:"7";i:7;s:1:"8";}', 'false'),
(16, 'test', 'xx', 'a:3:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";}', 'false');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
