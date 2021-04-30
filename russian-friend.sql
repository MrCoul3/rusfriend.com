-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Апр 30 2021 г., 15:18
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `russian-friend`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin-data`
--

CREATE TABLE `admin-data` (
  `id` int(11) NOT NULL,
  `private` int(11) NOT NULL,
  `sclub` int(11) NOT NULL,
  `gmt` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admin-data`
--

INSERT INTO `admin-data` (`id`, `private`, `sclub`, `gmt`) VALUES
(1, 26, 21, 'GMT -03:00');

-- --------------------------------------------------------

--
-- Структура таблицы `bookstime`
--

CREATE TABLE `bookstime` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `day` varchar(12) NOT NULL,
  `time` varchar(256) NOT NULL,
  `type` varchar(10) NOT NULL,
  `payment` varchar(12) NOT NULL,
  `confirmation` tinyint(1) NOT NULL,
  `price` int(11) NOT NULL,
  `gmt` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bookstime`
--

INSERT INTO `bookstime` (`id`, `name`, `day`, `time`, `type`, `payment`, `confirmation`, `price`, `gmt`) VALUES
(241, 'user6', '30.04.2021', ' 11:00  - 12:00', 'private', 'payed', 1, 26, 'GMT +03:00'),
(242, 'user6', '30.04.2021', ' 7:00  - 8:00', 'private', 'unpayed', 1, 26, 'GMT +03:00'),
(243, 'user6', '1.05.2021', ' 8:00  - 9:00', 'private', 'unpayed', 1, 26, 'GMT +03:00'),
(248, 'User3', '2.05.2021', ' 7:00  ', 'free', 'free', 1, 21, 'GMT +03:00'),
(249, 'User3', '2.05.2021', ' 8:00  - 9:00', 's-club', 'unpayed', 0, 21, 'GMT +03:00'),
(250, 'user6', '30.04.2021', ' 21:00  - 22:00', 'private', 'unpayed', 1, 26, 'GMT +03:00'),
(251, 'user6', '1.05.2021', ' 1:00  - 2:00', 'private', 'unpayed', 0, 26, 'GMT -03:00'),
(252, 'user6', '1.05.2021', '0:00  - 1:00', 'private', 'unpayed', 0, 26, 'GMT -03:00');

-- --------------------------------------------------------

--
-- Структура таблицы `temp-gmt`
--

CREATE TABLE `temp-gmt` (
  `id` int(11) NOT NULL,
  `day` varchar(32) NOT NULL,
  `time` varchar(512) NOT NULL,
  `gmt` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `temp-gmt`
--

INSERT INTO `temp-gmt` (`id`, `day`, `time`, `gmt`) VALUES
(1, '27.04.2021', '10:00  - 11:00', 'GMT -03:00'),
(2, '29.04.2021', '0:00  - 1:00, 8:00  - 9:00, 10:00  - 11:00, 11:00  - 12:00', 'GMT -03:00'),
(3, '26.04.2021', '5:00  - 6:00, 12:00  - 13:00', 'GMT -03:00'),
(4, '28.04.2021', '2:00  - 3:00', 'GMT -03:00'),
(5, '1.05.2021', '0:00  - 1:00, 1:00  - 2:00, 2:00  - 3:00', 'GMT -03:00'),
(6, '2.05.2021', '0:00  - 1:00, 1:00  - 2:00, 2:00  - 3:00, 3:00  - 4:00', 'GMT -03:00'),
(7, '30.04.2021', '0:00  - 1:00, 1:00  - 2:00, 5:00  - 6:00, 15:00  - 16:00', 'GMT -03:00');

-- --------------------------------------------------------

--
-- Структура таблицы `time-intervals`
--

CREATE TABLE `time-intervals` (
  `id` int(11) NOT NULL,
  `day` varchar(12) NOT NULL,
  `time` text NOT NULL,
  `gmt` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `time-intervals`
--

INSERT INTO `time-intervals` (`id`, `day`, `time`, `gmt`) VALUES
(420, '27.04.2021', '16:00 - 17:00', 'GMT +03:00'),
(424, '29.04.2021', '06:00 - 07:00, 14:00 - 15:00, 16:00 - 17:00, 17:00 - 18:00', 'GMT +03:00'),
(425, '26.04.2021', '11:00 - 12:00, 18:00 - 19:00', 'GMT +03:00'),
(426, '28.04.2021', '10:00 - 11:00', 'GMT +05:00'),
(428, '1.05.2021', '06:00 - 07:00, 07:00 - 08:00, 08:00 - 09:00', 'GMT +03:00'),
(429, '2.05.2021', '06:00 - 07:00, 07:00 - 08:00, 08:00 - 09:00, 09:00 - 10:00', 'GMT +03:00'),
(430, '30.04.2021', '06:00 - 07:00, 07:00 - 08:00, 11:00 - 12:00, 21:00 - 22:00', 'GMT +03:00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `skype` varchar(64) NOT NULL,
  `register` date NOT NULL,
  `status` varchar(8) NOT NULL,
  `avatar` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `skype`, `register`, `status`, `avatar`) VALUES
(44, 'Николай', '466d588e92d61003dfcf4c1922c6a488', 'mr.coul@inbox.ru', '', '0000-00-00', 'admin', ''),
(45, 'Светлана', '1507a5bd580d9b34def09677deb2da0b', 'svetlanatotr@inbox.ru', ' ', '0000-00-00', 'admin', ''),
(53, 'User1', 'd9a6f01b8f6cf1746e8a55a21cdcd8b3', 'user1@mail.ru', 'user1Skype', '0000-00-00', 'active', ''),
(54, 'User2', '0010a38b5261aacf88210dadd31b4d6e', 'user2@mail.ru', 'user2', '0000-00-00', 'active', ''),
(55, 'User3', 'b19ba10ceff95fa68e0fa733dcb1cd76', 'hobbit_baggins@mail.ru', 'user3Skype', '0000-00-00', 'active', ''),
(56, 'User4', '11b60668c36c9555103a9a27d6d6d1fe', 'user4@mail.ru', 'user4', '0000-00-00', 'active', '/images/user-avatars/29df3edf_56_min.png'),
(57, 'User5', '325c157a8b18499f5969aec11f505d2a', 'user5@mail.ru', 'user5', '0000-00-00', 'active', '/images/user-avatars/c9d450b8_57_min.png'),
(60, 'user6', '656e3bf368d83524bd14da9a1db7bc70', 'user6@mail.ru', 'user7', '2021-04-04', 'active', '/images/user-avatars/7be79ab3_60_min.png'),
(61, 'user7', '064c8247bd68155d7e4ea3f8b198e15b', 'user7@mail.ru', 'user7Skype', '2021-04-05', 'active', '/images/user-avatars/03f417d8_61_min.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin-data`
--
ALTER TABLE `admin-data`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bookstime`
--
ALTER TABLE `bookstime`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `temp-gmt`
--
ALTER TABLE `temp-gmt`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `time-intervals`
--
ALTER TABLE `time-intervals`
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
-- AUTO_INCREMENT для таблицы `admin-data`
--
ALTER TABLE `admin-data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `bookstime`
--
ALTER TABLE `bookstime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT для таблицы `temp-gmt`
--
ALTER TABLE `temp-gmt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `time-intervals`
--
ALTER TABLE `time-intervals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=431;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
