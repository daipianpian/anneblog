-- phpMyAdmin SQL Dump
-- version 4.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 11 月 01 日 10:37
-- 服务器版本: 5.5.31
-- PHP 版本: 5.4.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `anne_blog`
--

-- --------------------------------------------------------

--
-- 表的结构 `anne_admin`
--

CREATE TABLE IF NOT EXISTS `anne_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理员名称',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '邮箱',
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `authority` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户权限',
  `avator` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '管理员头像',
  `createTime` datetime NOT NULL COMMENT '创建时间',
  `updateTime` datetime NOT NULL COMMENT '更新时间',
  `status` int(1) NOT NULL COMMENT '状态',
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '30位不重复的随机数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `anne_admin`
--

INSERT INTO `anne_admin` (`id`, `name`, `email`, `password`, `authority`, `avator`, `createTime`, `updateTime`, `status`, `token`) VALUES
(1, 'admin', '1195997183@qq.com', '123456', '777', NULL, '2018-04-27 20:00:00', '2018-11-01 17:53:39', 1, '39abf915-8ebf-eb76-a069-9f5e894a05e4');

-- --------------------------------------------------------

--
-- 表的结构 `anne_article`
--

CREATE TABLE IF NOT EXISTS `anne_article` (
  `id` int(30) NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '文章title',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '文章内容',
  `adminId` int(11) NOT NULL COMMENT '管理员id',
  `typeId` int(11) NOT NULL COMMENT '类别id：1-原创；2-转载',
  `classifyId` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类Id集合',
  `tagId` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '标签Id集合',
  `createTime` datetime NOT NULL COMMENT '创建时间',
  `updateTime` datetime NOT NULL COMMENT '更新时间',
  `status` int(1) NOT NULL COMMENT '状态：0-删除；1-发布；2-审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `anne_article`
--

INSERT INTO `anne_article` (`id`, `title`, `content`, `adminId`, `typeId`, `classifyId`, `tagId`, `createTime`, `updateTime`, `status`) VALUES
(1, '文章1', '1-文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容', 1, 1, '1', NULL, '2018-04-24 06:00:00', '2018-10-17 14:19:20', 1),
(2, '测试文章1', '<p>测试文章内容1</p>', 1, 1, '2', NULL, '2018-10-16 09:47:35', '2018-10-16 09:47:35', 1),
(3, '文章3', '<p>测试文章内容2</p>', 1, 2, '2,7', '3,2', '2018-10-16 09:49:16', '2018-10-17 17:23:02', 1),
(4, '多个方法', '<p>稳定繁荣</p>', 1, 1, '7', '', '2018-10-19 11:36:11', '2018-10-19 11:36:11', 1),
(5, '大范甘迪', '<p>多个方法</p>', 1, 1, '7', '', '2018-10-19 11:36:59', '2018-10-19 11:36:59', 1),
(6, '放烟花', '<p>铁观音</p>', 1, 1, '7', '', '2018-10-19 11:37:54', '2018-10-19 11:37:54', 1),
(7, '让他让他', '<p>同一天</p>', 1, 1, '7', '', '2018-10-19 11:39:20', '2018-10-19 11:39:20', 1),
(8, '分隔符', '<p>更换</p>', 1, 1, '7', '', '2018-10-19 11:40:02', '2018-10-19 11:40:02', 1),
(9, '分隔符', '<p>回寄</p>', 1, 1, '7', '', '2018-10-19 11:40:55', '2018-10-19 11:40:55', 1),
(10, '发给他', '<p>原因</p>', 1, 1, '7', '', '2018-10-19 11:42:34', '2018-10-19 11:42:34', 1),
(11, '发他', '<p>分隔符</p>', 1, 2, '7', '', '2018-10-19 11:43:24', '2018-10-19 11:43:24', 1),
(12, '陈v', '<p>共和国</p>', 1, 1, '7', '', '2018-10-19 11:48:44', '2018-10-19 11:48:44', 1),
(13, '黑科技', '<p>就看见</p>', 1, 1, '7,6,2', '', '2018-10-19 11:51:09', '2018-10-19 11:51:09', 1),
(14, '风格', '<p>就看见</p>', 1, 1, '7', '', '2018-10-19 11:51:29', '2018-10-21 15:17:30', 2),
(15, '润体乳', '<p>好</p>', 1, 1, '7', '', '2018-10-19 11:55:16', '2018-10-21 14:37:49', 0);

-- --------------------------------------------------------

--
-- 表的结构 `anne_article_classify`
--

CREATE TABLE IF NOT EXISTS `anne_article_classify` (
  `id` int(30) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类名',
  `desc` text COLLATE utf8_unicode_ci COMMENT '分类描述',
  `adminId` int(11) NOT NULL COMMENT '创建者',
  `createTime` datetime NOT NULL COMMENT '创建时间',
  `updateTime` datetime NOT NULL COMMENT '更新时间',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态：0-删除；1-发布；2-审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `anne_article_classify`
--

INSERT INTO `anne_article_classify` (`id`, `name`, `desc`, `adminId`, `createTime`, `updateTime`, `status`) VALUES
(1, '前端', '', 1, '2018-10-12 17:21:39', '2018-10-13 16:36:46', 0),
(2, 'VueJs', 'VueJs分类', 1, '2018-10-12 17:24:24', '2018-10-12 17:24:24', 1),
(3, 'ThinkPHP', '', 1, '2018-10-12 17:25:02', '2018-10-13 14:12:04', 0),
(4, '数据库', '', 1, '2018-10-12 17:31:35', '2018-10-13 14:10:10', 0),
(5, '数据结构', '共和国', 1, '2018-10-13 14:18:26', '2018-10-13 17:03:51', 0),
(6, 'rtrt', '', 1, '2018-10-13 17:04:02', '2018-10-13 17:04:02', 1),
(7, 'tuyu', '', 1, '2018-10-13 17:05:26', '2018-10-21 14:55:13', 0),
(8, '菜单', '地方', 1, '2018-10-21 14:55:20', '2018-10-21 14:55:25', 1);

-- --------------------------------------------------------

--
-- 表的结构 `anne_article_tag`
--

CREATE TABLE IF NOT EXISTS `anne_article_tag` (
  `id` int(30) NOT NULL AUTO_INCREMENT COMMENT '标签id',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '标签名',
  `desc` text COLLATE utf8_unicode_ci COMMENT '标签描述',
  `adminId` int(11) NOT NULL COMMENT '创建者',
  `createTime` datetime NOT NULL COMMENT '创建时间',
  `updateTime` datetime NOT NULL COMMENT '更新时间',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态：0-删除；1-发布；2-审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `anne_article_tag`
--

INSERT INTO `anne_article_tag` (`id`, `name`, `desc`, `adminId`, `createTime`, `updateTime`, `status`) VALUES
(1, '前端', '前端描述', 1, '2018-10-13 23:58:43', '2018-10-14 00:00:31', 0),
(2, '后台', '', 1, '2018-10-14 00:00:42', '2018-10-14 00:00:42', 1),
(3, 'vue', '的v', 1, '2018-10-14 00:00:47', '2018-10-21 15:17:04', 0),
(4, '的v', '', 1, '2018-10-21 15:17:09', '2018-10-21 15:17:09', 1);

-- --------------------------------------------------------

--
-- 表的结构 `anne_article_type`
--

CREATE TABLE IF NOT EXISTS `anne_article_type` (
  `id` int(30) NOT NULL AUTO_INCREMENT COMMENT '类别id',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '类别名',
  `desc` text COLLATE utf8_unicode_ci COMMENT '类别描述',
  `adminId` int(11) NOT NULL COMMENT '创建者',
  `createTime` datetime NOT NULL COMMENT '创建时间',
  `updateTime` datetime NOT NULL COMMENT '更新时间',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态：0-删除；1-发布；2-审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `anne_article_type`
--

INSERT INTO `anne_article_type` (`id`, `name`, `desc`, `adminId`, `createTime`, `updateTime`, `status`) VALUES
(1, '原创', '原创文章', 1, '2018-10-13 21:45:08', '2018-10-21 15:07:11', 1),
(2, '转载', '转载文章', 1, '2018-10-13 21:48:18', '2018-10-21 15:07:08', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
