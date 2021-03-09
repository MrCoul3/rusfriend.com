-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Мар 09 2021 г., 19:49
-- Версия сервера: 8.0.22-0ubuntu0.20.04.3
-- Версия PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `id` int NOT NULL,
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
(12, 'Vader702', '9.03.2021', '06:00 - 06:30', 'private', 'payed'),
(13, 'Vader702', '9.03.2021', ' 06:30 - 07:00', 'private', 'unpayed'),
(14, 'User1', '10.03.2021', '06:00 - 06:30', 'private', 'payed'),
(16, 'User2', '10.03.2021', ' 06:30 - 07:00', 'private', 'payed'),
(17, 'User2', '11.03.2021', '06:00 - 06:30', 'private', 'payed'),
(18, 'User2', '9.03.2021', ' 07:00 - 07:30', 'private', 'payed'),
(19, 'User2', '10.03.2021', ' 06:30 - 07:00', 'private', 'payed'),
(20, 'User2', '11.03.2021', '06:00 - 06:30', 'private', 'payed');

-- --------------------------------------------------------

--
-- Структура таблицы `time-intervals`
--

CREATE TABLE `time-intervals` (
  `id` int NOT NULL,
  `day` varchar(12) NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `time-intervals`
--

INSERT INTO `time-intervals` (`id`, `day`, `time`) VALUES
(276, '4.08.2022', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30, 07:30 - 08:00, 08:00 - 08:30, 08:30 - 09:00, 09:00 - 09:30'),
(277, '3.08.2022', '13:30 - 14:30, 14:00 - 15:00'),
(283, '18.03.2021', '06:00 - 06:30, 06:30 - 07:00'),
(290, '26.03.2021', '06:00 - 06:30, 06:30 - 07:00'),
(291, '25.03.2021', '06:00 - 06:30, 06:30 - 07:00'),
(292, '24.03.2021', '06:00 - 06:30'),
(301, '4.03.2021', '06:00 - 06:30'),
(302, '3.03.2021', '06:00 - 06:30, 06:30 - 07:00'),
(304, '11.03.2021', '06:00 - 06:30'),
(305, '10.03.2021', '06:00 - 06:30, 06:30 - 07:00'),
(307, '2.03.2021', '06:00 - 06:30, 06:30 - 07:00'),
(308, '9.03.2021', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30'),
(313, '19.03.2021', '06:00 - 06:30, 06:30 - 07:00, 07:00 - 07:30');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `skype` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `skype`) VALUES
(44, 'Николай', '466d588e92d61003dfcf4c1922c6a488', 'mr.coul@inbox.ru', ''),
(45, 'Светлана', '1507a5bd580d9b34def09677deb2da0b', 'svetlanatotr@inbox.ru', ' '),
(46, 'Vader702', '466d588e92d61003dfcf4c1922c6a488', 'hobbit@mail.ru', 'new'),
(47, 'User1', 'd9a6f01b8f6cf1746e8a55a21cdcd8b3', 'user1@mail.ru', 'userskype'),
(48, 'xcdadew', '2bf0d27f5dd83ef94b78cfab04656458', 'adfs@mail.ru', ' '),
(49, 'User2', '0010a38b5261aacf88210dadd31b4d6e', 'user2@mail.ru', 'user2');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `time-intervals`
--
ALTER TABLE `time-intervals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
