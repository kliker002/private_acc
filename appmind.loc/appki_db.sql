-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 24 2017 г., 22:10
-- Версия сервера: 5.7.20-0ubuntu0.16.04.1
-- Версия PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `appki_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bet_history`
--

CREATE TABLE `bet_history` (
  `user_id` int(11) NOT NULL,
  `thing_id` int(11) NOT NULL,
  `count_money` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bet_history`
--

INSERT INTO `bet_history` (`user_id`, `thing_id`, `count_money`) VALUES
(5, 41, '0.05'),
(5, 42, '0.05');

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `balance` varchar(20) NOT NULL,
  `balance_referal` varchar(255) NOT NULL DEFAULT '0' COMMENT 'баланс пользователя от его рефералов',
  `balance_referal_minus` varchar(255) NOT NULL DEFAULT '0',
  `date_reg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ref_code` varchar(20) DEFAULT NULL,
  `referer` varchar(40) DEFAULT NULL,
  `varification` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `login`, `password`, `status`, `balance`, `balance_referal`, `balance_referal_minus`, `date_reg`, `ref_code`, `referer`, `varification`) VALUES
(9, 'admin@mail.ru', '$2y$10$3GJl6mbq0SP9KaGMPmBiWuSV.IG2I5rf623.nqpKiusTC/16Vy6Ny', '1', '10', '5.15', '103', '2017-11-19 00:46:13', '371008', NULL, NULL),
(31, 'sdkgjsdligfjsdopjerlgrfjgrsjge@mail.ru', '$2y$10$4100w18Qw6LE5B4JyA9goulenAypLIf/8R/d.JWgfcHlzLhudepEK', NULL, '0', '0', '0', '2017-11-19 20:41:03', '891236', NULL, NULL),
(32, 'gdugh89@Mail.ru', '$2y$10$2ElWUVdg/VS1HFSSrz1BKeumv9TxBQ0fevpSdkEn.UxQx/TP2Shcy', NULL, '0', '0', '0', '2017-11-19 21:07:59', '973988', NULL, NULL),
(33, 'dasaoifkop@mail.ru', '$2y$10$MfpsMeWn7IWTKwmbscBWUuNkkzsdk9IXMY9l4nUyZaXBo8djgFFRq', NULL, '103', '0', '0', '2017-11-19 21:08:40', '530892', '9', NULL),
(34, 'skfjsof@mail.ru', '$2y$10$lYstvuDMYUr4hCJzbF4mne3DSXCmOVbZ3DQ6xYGGd1HYAnkQFDs5u', NULL, '0', '0', '0', '2017-11-19 21:10:01', '126257', '9', NULL),
(35, 'soigjsog@mail.ru', '$2y$10$6Zl1pOQzdh1eeVheGngPBeYv0Uk3tpLm7zZMCM4TQkXuDlXSjNwyy', NULL, '0', '0', '0', '2017-11-19 21:10:52', '139732', NULL, NULL),
(36, 'sdfoijsoifsio@mas.ru', '$2y$10$Tcdio054nNX7MXBM0SRxyuLY4aQumHsq11nQOrcT9yvKO.6IOqodO', NULL, '0', '0', '0', '2017-11-19 21:11:30', '762772', NULL, NULL),
(37, '3213123dasd@mail.ru', '$2y$10$HjxU4FJmJVbonuFEONKn/u33bsBKvzKh/1jrfOZB/aRoNpDsOLuXS', NULL, '0', '0', '0', '2017-11-19 21:12:23', '86920', NULL, NULL),
(38, 'sadadasd@mail.ru', '$2y$10$TpjzxlttysZOja8QOMaUZOEa..xBMCb0cc73E.svM2Jm.QKnuGn/e', NULL, '0', '0', '0', '2017-11-19 21:12:52', '495332', '9', NULL),
(39, 'dasdasd@mail.ru', '$2y$10$PPa2jZLL73G2nTsUy0wW6uQsiN5lVrwWMAPGo9eHE1.WsohdnjFbi', NULL, '0', '0', '0', '2017-11-19 21:13:20', '653826', '9', NULL),
(40, 'oaspdkpoaskd@mail.ru', '$2y$10$0dVzzUaAv9l.xCmTbd78muZF6VCnNT77llmbaicSeYSsuewK2zkL6', NULL, '0', '0', '0', '2017-11-19 21:14:06', '844255', '37', NULL),
(41, 'dfjsio@mail.ru', '$2y$10$MK1M.2B9OlpmkW0hdewlqeTxDUnGrogMtAwJuqDZQN.tBiSF8KaFq', NULL, '0', '0', '0', '2017-11-20 19:05:04', '935739', NULL, NULL),
(42, 'adminss@mail.ru', '$2y$10$k.r6wI8l02FjgRwQTkSvl.L7KaEwADIhgKsLSmY/6IEx29Arv9M6q', NULL, '0', '0', '0', '2017-11-21 23:24:42', '530600', NULL, NULL),
(43, '1ok@mail.ru', '$2y$10$bHsyAkBl0jhIQNN/UQNf7.ydqdzydz/lKM6aomms/jJc4jWmNk2o6', NULL, '0', '0', '0', '2017-12-06 14:43:51', '51904', NULL, NULL),
(44, '1@mail.ru', '$2y$10$IVUwjHcxaHLUK32OwgIDzO3jufT7yE.etyz3cmirs7gA67S79SvSq', NULL, '0', '0', '0', '2017-12-06 14:44:13', '360977', NULL, NULL),
(45, 'klidasd@mail.ru', '$2y$10$i7DW3Hn41hF3e7ApAHPjHOUCwZYpJ2kTgKscFsQ7yrL5XN7GTRpMe', NULL, '0', '0', '0', '2017-12-06 14:46:41', '867036', NULL, NULL),
(46, 'x@mail.ru', '$2y$10$6X4BZMQxS5NOq7MALaWm.eviEWhmYSu.Z5rEuDtNmCKr4mk/RRlqa', NULL, '0', '0', '0', '2017-12-06 14:46:56', '129067', NULL, NULL),
(47, 'kla@mail.ru', '$2y$10$3BYenSeXTwIHciZmIo7erO0wcR/3nZtxmCAGBn/OgAZh12WUsp9Nq', NULL, '0', '0', '0', '2017-12-06 14:47:39', '112692', NULL, NULL),
(48, 'grezzzle@yandex.ru', '$2y$10$qq.5nsMOkMM2vfz8ZfQSuOA7H0l34csgQQi8yZzBNY8O8N/bI4hw.', NULL, '0', '0', '0', '2017-12-07 11:14:05', '665503', NULL, NULL),
(49, 'igordeveloper19@gmail.com', '$2y$10$CN98x8o1Dl4cLHHhx7wXDuIaHPQ/VgdQfqP/T1OakP7HF9Qv9aihy', NULL, '0', '0', '0', '2017-12-07 12:15:40', '710168', NULL, NULL),
(50, '123456qwerty@mail.ru', '$2y$10$E13SDkeElZWnstD2vaNJcubtfBQl7Hj66a.mgsR3BnLDkOttNghAq', NULL, '0', '0', '0', '2017-12-07 15:07:30', '743418', NULL, NULL),
(51, 'mail.qqqq@mail.ru', '$2y$10$.xEnbRzfOzwYYZroGb4ECOx25x4iVedmAMNQJHMZS2TnQbDyDj/qe', NULL, '0', '0', '0', '2017-12-07 22:01:40', '147134', NULL, NULL),
(52, 'rkbrth02@mail.ru', '$2y$10$5BpTO1qYWx0fW4oTLI3vSeZHkBko8Ze.qp45gDN5zMBQiVn38zCKm', NULL, '0', '0', '0', '2017-12-07 22:02:48', '49336', NULL, NULL),
(53, 'qqasdolaidaois@mail.ru', '$2y$10$0AZwfcHL01qyQu5k5SBrH.x3pYKAe5QcrV0cc4y/NkBhqV4xsdN1G', NULL, '0', '0', '0', '2017-12-12 18:32:49', '676999', NULL, NULL),
(54, 'flyshift1@yandex.ru', '$2y$10$wzO15d0W70MfhHR/0tNjueJ0HCcSAh.M3eQOcfhqLmIqQDK4bRtHy', NULL, '0', '0', '0', '2017-12-17 11:36:52', '262930', NULL, NULL),
(58, 'savely.bolikov@yandex.ru', '$2y$10$Y.bMe6y.eZ8PLGM1920Q8.j7fyGtVNEIAWJdQz.NVPeIK0KwOyyB.', NULL, '0', '0', '0', '2017-12-17 19:55:59', '629006', NULL, NULL),
(59, 'general.members@mail.ru', '$2y$10$Y3Izrm3T3yLvZxY8ECBdwe4./56x96ypU5U4E8YUiuo7TBGG82pFO', NULL, '0', '0', '0', '2017-12-17 20:06:48', '189477', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `earning_history`
--

CREATE TABLE `earning_history` (
  `user_id` int(11) NOT NULL,
  `type` varchar(5) NOT NULL,
  `orders_id` int(11) DEFAULT NULL,
  `current_day` varchar(10) NOT NULL DEFAULT '-1',
  `revenue` varchar(10) NOT NULL DEFAULT '0',
  `start_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `etc`
--

CREATE TABLE `etc` (
  `user_id` int(11) NOT NULL,
  `cashback` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `package` varchar(100) NOT NULL,
  `cost` varchar(20) NOT NULL,
  `cost_install` varchar(10) NOT NULL,
  `cost_retention` varchar(10) NOT NULL,
  `geo` varchar(50) NOT NULL,
  `retention` varchar(20) NOT NULL,
  `app_key` varchar(40) NOT NULL DEFAULT '',
  `comment` int(1) DEFAULT NULL,
  `comment_key` varchar(50) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `count_daily` text NOT NULL,
  `count_started` text NOT NULL,
  `count_installed` text NOT NULL,
  `count_completed` text NOT NULL,
  `description` text NOT NULL,
  `title` varchar(50) NOT NULL,
  `icon_link` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'moderation',
  `balance` varchar(10) NOT NULL DEFAULT '0',
  `start_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `link` varchar(100) NOT NULL DEFAULT '',
  `title_order` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int(255) NOT NULL,
  `argument` varchar(30) NOT NULL,
  `value` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `argument`, `value`) VALUES
(1, 'count_install_max', '100000'),
(2, 'default_cost_install', '2'),
(3, 'default_cost_retention', '0.5'),
(4, 'default_extra_charge_install', '2'),
(5, 'default_extra_charge_retention', '0.5'),
(6, 'referal_percent', '0.05'),
(7, 'info_block', 'Admin 1337'),
(8, 'default_cost_review', '2');

-- --------------------------------------------------------

--
-- Структура таблицы `things`
--

CREATE TABLE `things` (
  `id` int(11) NOT NULL,
  `cost` varchar(10) NOT NULL,
  `steam_name` text NOT NULL,
  `hero` varchar(20) NOT NULL,
  `rarity` varchar(20) NOT NULL,
  `image_link` text NOT NULL,
  `type` varchar(5) NOT NULL,
  `min_participants` varchar(10) NOT NULL,
  `date_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_finish` datetime NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `user_id` int(11) DEFAULT NULL,
  `is_transfer` varchar(10) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `things`
--

INSERT INTO `things` (`id`, `cost`, `steam_name`, `hero`, `rarity`, `image_link`, `type`, `min_participants`, `date_add`, `date_finish`, `status`, `user_id`, `is_transfer`) VALUES
(41, '0.05', 'Ancient Rhythms Screen', 'Other', 'Uncommon', 'http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KW1Zwwo4NUX4oFJZEHLbXP7g1bJ4Q1lgheXknVSffi1sHQWlh6MTtFvqOxIwpf3_zJdTRM6-Oll5KOkvnLP7rDkW4f6Zckj-vE99yk3lCyr0tuYTihIteccQE_NQ3Z_Qe4lefv1pa8u5_InWwj5Hd4hpzTSA/330x192', '1', '0', '2017-12-24 21:49:26', '2017-12-27 12:00:00', 'active', -1, 'false'),
(42, '0.05', 'Shield of Screaming Souls', 'Chaos Knight', 'Common', 'http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KW1Zwwo4NUX4oFJZEHLbXK9QlSPcUxoRpSX3PbSe2q39ucQVRnLApQibmtKghz7ODAeDhO6JOknZOCmfDLMLPQmXhu-814j-XFyoD0mlOx5UE4ZWjxcoHGcQE5aFvZ8wC2wu26gpO0vZScmCA2uCJw53reyRCyhR9SLrs4i1_J038/330x192', '2', '0', '2017-12-24 21:51:52', '2017-12-27 14:00:00', 'active', -1, 'false'),
(43, '0.05', 'Longbow of the Boreal Watch', 'Drow Ranger', 'Uncommon', 'http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KW1Zwwo4NUX4oFJZEHLbXK9QlSPcU2uxRKA0DfSeOv2NjsXFtLMQxSibiqOQJh38zfcClB5JO6m46MlfjjDLTXqX9Z7fpzhfvE9IDKn1WgqBsDPzixc9OLJgU5aVzW-VDqyOq9hJ-67sjIm3dmuCYitHrdzRbmgh4dP7No1vfNHELeWfKBGtrOQA/330x192', '2', '0', '2017-12-24 21:54:06', '2017-12-27 16:00:00', 'active', -1, 'false'),
(44, '0.25', 'Sword of the Eleven Curses', 'Doom', 'Rare', 'http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KW1Zwwo4NUX4oFJZEHLbXK9QlSPcU2phRQA0ncQvKo2fDQRk9nIBdoiamyJBVknPbEdCtH4uO1gZKYkuTLDKjGmXlV18lwmO7Eu96t3QfgqEZpNT3xcYHBIwBtZQrUqVa4xujsgJG0u5uawXIy7nNx4HvD30vgHCMGQWw/330x192', '2', '0', '2017-12-24 22:01:57', '2017-12-27 18:01:00', 'active', -1, 'false');

-- --------------------------------------------------------

--
-- Структура таблицы `transfer`
--

CREATE TABLE `transfer` (
  `user_id` int(11) NOT NULL,
  `trade_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `transfer`
--

INSERT INTO `transfer` (`user_id`, `trade_url`) VALUES
(3, 'https://steamcommunity.com/jdjfh'),
(1, '1'),
(4, '4'),
(5, '5'),
(6, '6'),
(7, '7'),
(8, '8');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `balance` varchar(20) NOT NULL DEFAULT '1',
  `date_reg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ref_code` varchar(40) DEFAULT NULL,
  `referer` varchar(40) DEFAULT 'undef',
  `geo` varchar(50) NOT NULL,
  `google_person_id` varchar(50) NOT NULL,
  `google_person_name` varchar(40) NOT NULL,
  `google_person_photo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `balance`, `date_reg`, `ref_code`, `referer`, `geo`, `google_person_id`, `google_person_name`, `google_person_photo`) VALUES
(2, '0', '2017-10-26 11:46:16', '0', 'undef', 'ru', '0', 'Логан', 'https://www.circleof6app.com/wp-content/uploads/2015/12/thomas_cabus1.png'),
(3, '1544.5', '2017-11-09 16:56:36', '108933', 'undef', 'ru', '118393797393017227590', 'Антон Фомин', 'undef'),
(5, '15.35', '2017-11-11 14:06:50', '108935', '108933 ', 'ru', '117045893604118020575', 'Ilya KRN', 'https://lh3.googleusercontent.com/-soyu6PzFrlE/AAAAAAAAAAI/AAAAAAAAABU/BTiXEAlgiVU/photo.jpg'),
(6, '1545.5', '2017-11-11 15:02:48', '108936', '108933', 'ru', '104750646849795179328', 'Оксана Елькина', 'undef'),
(7, '0.3', '2017-11-18 18:39:39', '108937', 'undef', 'ru', '114956151637102893933', 'Алёна Скутина', 'https://lh4.googleusercontent.com/-9SBPcZ2HrYE/AAAAAAAAAAI/AAAAAAAAFco/fjOckEp5BNU/photo.jpg'),
(8, '0', '2017-10-26 11:46:16', '0', 'undef', 'ru', '0', 'Логан2', 'https://www.circleof6app.com/wp-content/uploads/2015/12/thomas_cabus1.png'),
(9, '0', '2017-10-26 11:46:16', '0', 'undef', 'ru', '0', 'Логан3', 'https://www.circleof6app.com/wp-content/uploads/2015/12/thomas_cabus1.png'),
(10, '0', '2017-10-26 11:46:16', '0', 'undef', 'ru', '0', 'Логан4', 'https://www.circleof6app.com/wp-content/uploads/2015/12/thomas_cabus1.png'),
(11, '0', '2017-10-26 11:46:16', '0', 'undef', 'ru', '0', 'Логан5', 'https://www.circleof6app.com/wp-content/uploads/2015/12/thomas_cabus1.png'),
(12, '0', '2017-10-26 11:46:16', '0', 'undef', 'ru', '0', 'Логан6', 'https://www.circleof6app.com/wp-content/uploads/2015/12/thomas_cabus1.png'),
(13, '0', '2017-10-26 11:46:16', '0', 'undef', 'ru', '0', 'Логан7', 'https://www.circleof6app.com/wp-content/uploads/2015/12/thomas_cabus1.png'),
(14, '2.95', '2017-11-28 20:53:02', '1089314', 'undef', 'ru', '105855936776125387433', 'Gleb Moros', 'undef'),
(15, '0.5', '2017-12-09 20:43:26', '1089315', 'undef', 'ru', '112222602586764842690', 'Aleninka Sky', 'undef'),
(16, '0.8', '2017-12-16 09:18:33', '1089316', 'undef', 'ru', '109170825695182133755', 'Савелий Боликов', 'undef');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `things`
--
ALTER TABLE `things`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `things`
--
ALTER TABLE `things`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
