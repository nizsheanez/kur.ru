-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 16 2012 г., 03:57
-- Версия сервера: 5.1.40
-- Версия PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- БД: `diplom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `metrics`
--
use diplom;
SET NAMES utf8;
drop table IF EXISTS  `metrics`;
CREATE TABLE IF NOT EXISTS `metrics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `formula` text,
  `norma` decimal(12,4) DEFAULT NULL,
  `critical` decimal(12,4) DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `metrics`
--

INSERT INTO `metrics` (`id`, `title`, `name`, `formula`, `norma`, `critical`, `type`) VALUES
(1, 'Детские сады', 'detsad', NULL, 0.0000, 50.0000, NULL),
(2, 'Поликлиники', 'policlinic', NULL, 0.0000, 100.0000, NULL),
(3, 'Школы', 'school', NULL, 0.0000, 100.0000, NULL),
(4, 'Спорт площадки', 'sportplace', NULL, 0.0000, 100.0000, NULL),
(5, 'Мусорные контейнеры', 'garbagecontainer', NULL, 0.0000, 100.0000, NULL),
(6, 'Население', 'peoples', NULL, 0.0000, 100.0000, NULL),
(7, 'Парковочные места', 'parking', NULL, 0.0000, 100.0000, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `polygons`
--
drop table IF EXISTS  `polygons`;
CREATE TABLE IF NOT EXISTS `polygons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `square_id` int(11) DEFAULT NULL,
  `lat` decimal(16,10) DEFAULT NULL,
  `lng` decimal(16,10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Дамп данных таблицы `polygons`
--

INSERT INTO `polygons` (`id`, `square_id`, `lat`, `lng`) VALUES
(120, 1, 51.1512212709, 71.4561081639),
(119, 1, 51.1524864645, 71.4607859365),
(118, 1, 51.1490407494, 71.4635754338),
(117, 1, 51.1489330667, 71.4656353704),
(116, 1, 51.1461130353, 71.4655495397),
(115, 1, 51.1461063048, 71.4598847142),
(127, 2, 51.1525133832, 71.4608717672),
(126, 2, 51.1540746372, 71.4665795079),
(125, 2, 51.1463755277, 71.4721585027),
(124, 2, 51.1457832353, 71.4697123281),
(123, 2, 51.1461063048, 71.4656353703),
(122, 2, 51.1489061459, 71.4657212010),
(121, 2, 51.1490542097, 71.4636183492),
(45, 3, 51.1461197660, 71.4598847142),
(46, 3, 51.1460389988, 71.4655495397),
(47, 3, 51.1457428514, 71.4696264974),
(48, 3, 51.1463889888, 71.4722014180),
(49, 3, 51.1445313195, 71.4734030477),
(50, 3, 51.1416504382, 71.4629317037),
(131, 5, 51.1446120893, 71.4733601323),
(130, 5, 51.1475735504, 71.4837885610),
(129, 5, 51.1518538720, 71.4806986562),
(128, 5, 51.1489465270, 71.4703775159),
(70, 4, 51.1540477195, 71.4665365926),
(69, 4, 51.1567124982, 71.4761496297),
(68, 4, 51.1563625865, 71.4774370900),
(67, 4, 51.1517865749, 71.4808274022),
(66, 4, 51.1489869084, 71.4703131429);

-- --------------------------------------------------------

--
-- Структура таблицы `squares`
--
drop table IF EXISTS  `squares`;
CREATE TABLE IF NOT EXISTS `squares` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `squares`
--

INSERT INTO `squares` (`id`, `name`) VALUES
(1, '1-й'),
(2, '2-й'),
(3, '3-й'),
(4, '4-й'),
(5, '5-й');

-- --------------------------------------------------------

--
-- Структура таблицы `square_data`
--
drop table IF EXISTS  `square_data`;
CREATE TABLE IF NOT EXISTS `square_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `square_id` int(11) unsigned DEFAULT NULL,
  `metric_id` int(255) DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `square_data`
--

INSERT INTO `square_data` (`id`, `square_id`, `metric_id`, `value`) VALUES
(1, 1, 1, '10'),
(2, 2, 1, '20'),
(3, 3, 1, '30'),
(4, 4, 1, '40'),
(5, 5, 1, '30'),
(7, 1, 6, '1000'),
(8, 2, 6, '2000'),
(9, 3, 6, '3000'),
(10, 4, 6, '4000'),
(11, 5, 6, '5000');
