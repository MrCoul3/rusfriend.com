-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Мар 23 2021 г., 16:12
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

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
-- Структура таблицы `bookstime`
--

CREATE TABLE `bookstime` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `day` varchar(12) NOT NULL,
  `time` varchar(256) NOT NULL,
  `type` varchar(10) NOT NULL,
  `payment` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bookstime`
--

INSERT INTO `bookstime` (`id`, `name`, `day`, `time`, `type`, `payment`) VALUES
(30, 'User1', '25.03.2021', ' 06:30 - 07:00', 'private', 'payed'),
(35, 'User1', '25.03.2021', ' 08:00 - 08:30', 'private', 'payed'),
(36, 'User1', '25.03.2021', ' 08:30 - 09:00', 'private', 'payed'),
(38, 'User1', '26.03.2021', ' 06:30 - 07:30', 'private', 'payed'),
(39, 'User1', '26.03.2021', ' 07:00 - 07:00', 'private', 'payed'),
(40, 'User2', '25.03.2021', ' 07:00 - 07:30', 'private', 'payed'),
(41, 'User2', '25.03.2021', ' 07:30 - 08:00', 'private', 'payed'),
(42, 'User2', '26.03.2021', ' 07:30 - 08:00', 'private', 'payed'),
(64, 'Nikolay Ivanov', '26.03.2021', ' 17:30 - 18:30', 'private', 'payed'),
(66, 'User2', '26.03.2021', ' 19:00 - 20:00', 'private', 'payed'),
(73, 'Nikolay Ivanov', '27.03.2021', ' 08:30 - 09:00', 'private', 'payed'),
(74, 'User2', '27.03.2021', ' 07:00 - 07:30', 'private', 'payed'),
(78, 'User2', '27.03.2021', ' 11:00 - 11:30', 'private', 'payed'),
(79, 'Nikolay Ivanov', '28.03.2021', ' 07:00 - 07:30', 'private', 'payed'),
(80, 'Nikolay Ivanov', '28.03.2021', ' 06:30 - 07:00', 's-club', 'payed'),
(81, 'User1', '28.03.2021', '06:00 - 06:30', 's-club', 'payed');

-- --------------------------------------------------------

--
-- Структура таблицы `time-intervals`
--

CREATE TABLE `time-intervals` (
  `id` int(11) NOT NULL,
  `day` varchar(12) NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `time-intervals`
--

INSERT INTO `time-intervals` (`id`, `day`, `time`) VALUES
(276, '4.08.2022', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30, 07:30 - 08:00, 08:00 - 08:30, 08:30 - 09:00, 09:00 - 09:30'),
(277, '3.08.2022', '13:30 - 14:30, 14:00 - 15:00'),
(301, '4.03.2021', '06:00 - 06:30'),
(302, '3.03.2021', '06:00 - 06:30, 06:30 - 07:00'),
(304, '11.03.2021', '06:00 - 06:30'),
(305, '10.03.2021', '06:00 - 06:30, 06:30 - 07:00'),
(307, '2.03.2021', '06:00 - 06:30, 06:30 - 07:00'),
(316, '9.03.2021', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30, 07:30 - 08:00'),
(321, '2.04.2021', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30, 07:30 - 08:00'),
(329, '23.03.2021', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30, 07:30 - 08:00, 08:00 - 08:30, 08:30 - 09:00, 09:00 - 09:30'),
(330, '24.03.2021', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30, 07:30 - 08:00, 08:00 - 08:30, 08:30 - 09:00, 09:00 - 09:30, 09:30 - 10:00'),
(331, '25.03.2021', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30, 07:30 - 08:00, 08:00 - 08:30, 08:30 - 09:00'),
(332, '27.03.2021', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30, 07:30 - 08:00, 08:00 - 08:30, 08:30 - 09:00, 09:00 - 09:30, 09:30 - 10:00, 10:00 - 10:30, 10:30 - 11:00, 11:00 - 11:30'),
(333, '26.03.2021', '06:00 - 06:30, 06:30 - 07:30, 07:00 - 07:00, 07:30 - 08:00, 08:00 - 08:30, 08:30 - 09:00, 17:30 - 18:30, 19:00 - 20:00'),
(335, '22.03.2021', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30, 07:30 - 08:00, 08:00 - 08:30'),
(336, '28.03.2021', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30, 07:30 - 08:00, 08:00 - 08:30, 13:00 - 14:00');

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
  `status` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `skype`, `status`) VALUES
(44, 'Николай', '466d588e92d61003dfcf4c1922c6a488', 'mr.coul@inbox.ru', '', 'admin'),
(45, 'Светлана', '1507a5bd580d9b34def09677deb2da0b', 'svetlanatotr@inbox.ru', ' ', 'admin'),
(46, 'Vader702', '466d588e92d61003dfcf4c1922c6a488', 'hobbit@mail.ru', 'new', 'active'),
(47, 'User1', 'd9a6f01b8f6cf1746e8a55a21cdcd8b3', 'user1@mail.ru', 'userskype', 'active'),
(48, 'xcdadew', '2bf0d27f5dd83ef94b78cfab04656458', 'adfs@mail.ru', ' ', 'active'),
(49, 'User2', '0010a38b5261aacf88210dadd31b4d6e', 'user2@mail.ru', 'user2', 'active'),
(50, 'Nikolay Ivanov', '466d588e92d61003dfcf4c1922c6a488', 'ivanov@mail.ru', 'ivanov', 'active'),
(51, 'User3', 'b19ba10ceff95fa68e0fa733dcb1cd76', 'user3@mail.ru', 'user3', 'active');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookstime`
--
ALTER TABLE `bookstime`
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
-- AUTO_INCREMENT для таблицы `bookstime`
--
ALTER TABLE `bookstime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT для таблицы `time-intervals`
--
ALTER TABLE `time-intervals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=337;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
