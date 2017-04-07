-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 07 2017 г., 12:43
-- Версия сервера: 5.5.54-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `raduga`
--

-- --------------------------------------------------------

--
-- Структура таблицы `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(250) DEFAULT NULL,
  `href` varchar(250) DEFAULT NULL,
  `blocks_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `banners`
--

INSERT INTO `banners` (`id`, `img`, `href`, `blocks_id`) VALUES
(2, '170407021940_.jpeg', 'http://svyazcom.ru', 4),
(3, '170407021954_.png', 'http://svyazcom.ru/', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `blocks`
--

CREATE TABLE IF NOT EXISTS `blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `types` varchar(100) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `blocks`
--

INSERT INTO `blocks` (`id`, `name`, `types`, `users_id`, `sort`) VALUES
(1, 'Логотип', 'logo', 1, 1),
(2, 'Заголовок', 'headers', 1, 2),
(3, 'Текст', 'text', 1, 3),
(4, 'Баннеры', 'banners', 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `headers`
--

CREATE TABLE IF NOT EXISTS `headers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `blocks_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `headers`
--

INSERT INTO `headers` (`id`, `name`, `blocks_id`) VALUES
(1, 'Вас приветствует компания "Радуга"', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `logo`
--

CREATE TABLE IF NOT EXISTS `logo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `blocks_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `logo`
--

INSERT INTO `logo` (`id`, `name`, `blocks_id`) VALUES
(4, '170407021250_.jpeg', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(200) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `admin` int(11) DEFAULT '1',
  `gruppa` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `modules`
--

INSERT INTO `modules` (`id`, `tag`, `name`, `description`, `admin`, `gruppa`, `sort`) VALUES
(1, 'admin', 'admin', 'Админка', 0, 0, 0),
(2, 'modules', 'Модули', 'Модули в админке', 1, 3, 1),
(3, 'users', 'Пользователи', 'Пользователи', 1, 2, 0),
(4, 'groupus', 'Группы пользователей', 'Группы пользователей', 1, 2, 0),
(5, 'settings', 'Настройки', 'Настройки сайта', 1, 3, 0),
(6, 'blocks', 'Блоки', 'Блоки', 1, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `modules_roles`
--

CREATE TABLE IF NOT EXISTS `modules_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `modules_roles`
--

INSERT INTO `modules_roles` (`id`, `module_id`, `role_id`) VALUES
(1, 5, 5),
(2, 6, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `gruppa` int(11) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `name_menu` varchar(250) NOT NULL,
  `translit` varchar(255) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `tizer` text NOT NULL,
  `text` longtext NOT NULL,
  `seo` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FK_user` int(11) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `in_menu` int(11) NOT NULL DEFAULT '1',
  `in_route` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `tag`, `name`, `description`, `status`) VALUES
(1, 'user', 'Пользователь', 'Пользователь, зарегистрировавшийся на сайте', 1),
(4, 'moderator', 'Модератор', 'Модератор', 1),
(5, 'admin', 'Администратор', 'Бог сайта', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(250) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `color`, `count`) VALUES
(1, 'F6A6FF', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `subscribe`
--

CREATE TABLE IF NOT EXISTS `subscribe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `subscribe`
--

INSERT INTO `subscribe` (`id`, `email`, `status`) VALUES
(1, 'mail@mail.ru', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `text`
--

CREATE TABLE IF NOT EXISTS `text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text,
  `blocks_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `text`
--

INSERT INTO `text` (`id`, `text`, `blocks_id`) VALUES
(1, '<p>&laquo;Радуга&raquo; - разработчик платформенных VAS-решений и&nbsp;специализированного программного обеспечения для операторов сотовой связи и&nbsp;сервис-провайдеров.</p>\n\n<p>Начиная с&nbsp;2006 года компания развивалась в&nbsp;трех направлениях: платформенные VAS-продукты, приложения для мобильных устройств, разработка социальных сетей. Компания выполнила более 100 инсталляций для компаний России, стран СНГ и&nbsp;Европы, а&nbsp;в&nbsp;направлении социальных сетей нашла партнеров по&nbsp;всему миру.</p>\n\n<p>На&nbsp;сегодняшний день решения от&nbsp;&laquo;Радуга&raquo; обслуживают более 250 миллионов абонентов.</p>\n\n<p>Тестовый текст с <strong>выделением жирным текстом</strong>, <em>курсивом</em> и <s>зачеркиванием</s></p>\n', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nick` varchar(16) NOT NULL DEFAULT '',
  `photo` varchar(250) DEFAULT NULL,
  `ext` varchar(5) DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `salt` varchar(32) NOT NULL,
  `confirm` varchar(32) DEFAULT NULL COMMENT 'код подтверждения для email',
  `code_sms` int(11) DEFAULT NULL,
  `date_sms` datetime DEFAULT NULL COMMENT 'Дата подтверждения по смс',
  `reset` varchar(255) DEFAULT NULL,
  `reset_data` datetime DEFAULT NULL,
  `hash` varchar(40) NOT NULL,
  `os` int(11) NOT NULL,
  `email` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(32) DEFAULT NULL,
  `descr` text,
  `surname` varchar(32) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `lord` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0 - не подтвержден; 1 - подтвержден; 2 - удален; 3 - забанен;',
  `ban` int(11) unsigned DEFAULT NULL,
  `range_for` int(11) DEFAULT '0',
  `range_all` int(11) DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `interests` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `nick`, `photo`, `ext`, `password`, `salt`, `confirm`, `code_sms`, `date_sms`, `reset`, `reset_data`, `hash`, `os`, `email`, `name`, `descr`, `surname`, `adress`, `phone`, `url`, `type`, `lord`, `status`, `ban`, `range_for`, `range_all`, `date`, `interests`) VALUES
(1, 'book', NULL, '', 'ce1e01af9eb58ee0d102482ad2bfdd23', 'c8085abf7538c85b0af980c22c40ab33', '18d56d53cba0faef9655bea887204e9b', NULL, NULL, NULL, NULL, '0cd3c8a744c5e96ac5e11050f16f3476', 0, '', 'Админ', NULL, NULL, NULL, 'book', NULL, 0, 1, 1, NULL, 0, 0, '2016-09-28 23:16:13', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users_roles`
--

CREATE TABLE IF NOT EXISTS `users_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users_roles`
--

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
