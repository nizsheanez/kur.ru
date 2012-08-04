-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 31 2012 г., 09:20
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.14-1~dotdeb.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- База данных: `diplom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sector_id` int(11) unsigned DEFAULT NULL,
  `metric_id` int(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Дамп данных таблицы `data`
--

INSERT INTO `data` (`id`, `sector_id`, `metric_id`, `value`) VALUES
(1, 1, 1, '10'),
(2, 2, 1, '20'),
(3, 3, 1, '30'),
(4, 4, 1, '40'),
(5, 5, 1, '30'),
(7, 1, 6, '9900'),
(8, 2, 6, '9900'),
(9, 3, 6, '12000'),
(10, 4, 6, '7200'),
(11, 5, 6, '10200'),
(12, 1, 3, '1'),
(13, 2, 3, '1'),
(14, 3, 3, '1'),
(15, 4, 3, '1'),
(16, 5, 3, '1'),
(22, 1, 5, '58'),
(23, 2, 5, '71'),
(24, 3, 5, '82'),
(25, 4, 5, '54'),
(26, 5, 5, '76'),
(27, 1, 4, '4'),
(28, 2, 4, '4'),
(29, 3, 4, '3'),
(30, 4, 4, '1'),
(31, 5, 4, '7'),
(32, 1, 7, NULL),
(33, 2, 7, NULL),
(34, 3, 7, NULL),
(35, 4, 7, NULL),
(36, 5, 7, NULL),
(37, 1, 2, '0'),
(38, 2, 2, '0'),
(39, 3, 2, '1'),
(40, 4, 2, '0'),
(41, 5, 2, '0'),
(42, 6, 1, '1'),
(43, 6, 2, '0'),
(44, 6, 3, '0'),
(45, 6, 4, '3'),
(46, 6, 5, '67\r\n'),
(47, 6, 6, '5700'),
(48, 6, 7, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `metrics`
--

DROP TABLE IF EXISTS `metrics`;
CREATE TABLE IF NOT EXISTS `metrics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `formula` text,
  `min` varchar(255) DEFAULT NULL,
  `norma` varchar(255) DEFAULT NULL,
  `max` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `metrics`
--

INSERT INTO `metrics` (`id`, `title`, `name`, `formula`, `min`, `norma`, `max`, `type`, `lft`, `rgt`, `depth`) VALUES
(1, 'Детские сады', 'detsad', 'peoples * 0.06 * (3 / 5) / metric', '1', '300', '450', '2', 5, 6, 5),
(2, 'Поликлиники', 'policlinic', NULL, NULL, NULL, NULL, '2', 4, 7, 4),
(3, 'Школы', 'school', 'metric', 'peoples *  0.2/ 2200', 'peoples *  0.2/ 1200', 'peoples *  0.2/ 400', '2', 3, 8, 3),
(4, 'Спорт площадки', 'sportplace', NULL, NULL, NULL, NULL, '2', 9, 10, 3),
(5, 'Мусорные контейнеры', 'garbagecontainer', 'metric * 1.1 * 365', 'peoples * 1.4 / 2', 'peoples * 1.4', 'peoples * 1.4 * 2', '1', 2, 11, 2),
(6, 'Население', 'peoples', NULL, NULL, NULL, NULL, NULL, 12, 13, 2),
(7, 'Количество участковых', 'policemans', 'peoples / metric', '2000', '3000', '4000', '1', 14, 15, 2),
(8, 'root', 'root', NULL, NULL, NULL, NULL, NULL, 1, 16, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `polygons`
--

DROP TABLE IF EXISTS `polygons`;
CREATE TABLE IF NOT EXISTS `polygons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sector_id` int(11) DEFAULT NULL,
  `lat` decimal(16,10) DEFAULT NULL,
  `lng` decimal(16,10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `LatLng` (`lat`,`lng`,`sector_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=624 ;

--
-- Дамп данных таблицы `polygons`
--

INSERT INTO `polygons` (`id`, `sector_id`, `lat`, `lng`) VALUES
(120, 1, '51.1512212709', '71.4561081639'),
(119, 1, '51.1524864645', '71.4607859365'),
(118, 1, '51.1490407494', '71.4635754338'),
(117, 1, '51.1489330667', '71.4656353704'),
(116, 1, '51.1461130353', '71.4655495397'),
(115, 1, '51.1461063048', '71.4598847142'),
(177, 2, '51.1490542097', '71.4636183492'),
(176, 2, '51.1489061459', '71.4657212010'),
(175, 2, '51.1461063048', '71.4656353703'),
(174, 2, '51.1457832353', '71.4697123281'),
(173, 2, '51.1463755277', '71.4721585027'),
(172, 2, '51.1540746372', '71.4666653386'),
(171, 2, '51.1525133832', '71.4608717672'),
(623, 3, '51.1460793825', '71.4599920026'),
(622, 3, '51.1461197659', '71.4655709974'),
(621, 3, '51.1457428514', '71.4696264974'),
(620, 3, '51.1463889888', '71.4722014180'),
(619, 3, '51.1445313195', '71.4734030477'),
(618, 3, '51.1416504382', '71.4629317037'),
(401, 5, '51.1445851661', '71.4734245053'),
(400, 5, '51.1475735504', '71.4837885610'),
(399, 5, '51.1518538720', '71.4806986562'),
(398, 5, '51.1498820121', '71.4740575067'),
(485, 4, '51.1529575386', '71.4739502184'),
(484, 4, '51.1499022026', '71.4741326086'),
(483, 4, '51.1517865749', '71.4808274022'),
(482, 4, '51.1563625865', '71.4774370900'),
(481, 4, '51.1567124982', '71.4761496297'),
(397, 5, '51.1489869080', '71.4702916852'),
(396, 5, '51.1469947344', '71.4718044511'),
(148, NULL, '51.1488792252', '71.4703131429'),
(149, NULL, '51.1498483620', '71.4738322011'),
(150, NULL, '51.1473985603', '71.4757204763'),
(151, NULL, '51.1464293721', '71.4721585027'),
(581, 6, '51.1542899785', '71.4676416627'),
(580, 6, '51.1540477195', '71.4667189828'),
(579, 6, '51.1490643049', '71.4703399649'),
(578, 6, '51.1492897647', '71.4712036363'),
(480, 4, '51.1559251932', '71.4732206575'),
(479, 4, '51.1552051677', '71.4736712686'),
(478, 4, '51.1544312958', '71.4740306846'),
(577, 6, '51.1495286836', '71.4722389690'),
(576, 6, '51.1499560425', '71.4740896932'),
(575, 6, '51.1523451414', '71.4741218797'),
(574, 6, '51.1544111074', '71.4739824048'),
(573, 6, '51.1558915474', '71.4732099286'),
(572, 6, '51.1550571234', '71.4701414814'),
(571, 6, '51.1546937406', '71.4689076654'),
(570, 6, '51.1544784012', '71.4682639352');

-- --------------------------------------------------------

--
-- Структура таблицы `sectors`
--

DROP TABLE IF EXISTS `sectors`;
CREATE TABLE IF NOT EXISTS `sectors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `square_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `sectors`
--

INSERT INTO `sectors` (`id`, `title`, `square_id`) VALUES
(1, '1-й', 1),
(2, '2-й', 1),
(3, '3-й', 1),
(4, '4-й', 1),
(5, '5-й', 1),
(6, 'ТЦ "Евразия"', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `squares`
--

DROP TABLE IF EXISTS `squares`;
CREATE TABLE IF NOT EXISTS `squares` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `squares`
--

INSERT INTO `squares` (`id`, `title`) VALUES
(1, 'Алматинский');
