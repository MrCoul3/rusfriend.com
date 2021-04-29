-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Апр 29 2021 г., 11:40
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
(240, 'user6', '29.04.2021', ' 5:00  - 6:00', 's-club', 'unpayed', 0, 20, 'GMT +00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `private` int(11) NOT NULL,
  `sclub` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `prices`
--

INSERT INTO `prices` (`id`, `private`, `sclub`) VALUES
(1, 30, 20);

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
(1, '27.04.2021', '5:00  - 6:00', 'GMT +02:00'),
(2, '30.04.2021', '7:00  - 8:00', 'GMT +02:00'),
(3, '26.04.2021', '5:00  - 6:00', 'GMT +02:00'),
(4, '29.04.2021', '7:00  - 8:00', 'GMT +02:00'),
(5, '28.04.2021', '19:00  - 20:00', 'GMT +02:00');

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
(55, 'User3', 'b19ba10ceff95fa68e0fa733dcb1cd76', 'hobbit_baggins@mail.ru', 'user3Skype', '0000-00-00', 'new', ''),
(56, 'User4', '11b60668c36c9555103a9a27d6d6d1fe', 'user4@mail.ru', 'user4', '0000-00-00', 'active', '/images/user-avatars/29df3edf_56_min.png'),
(57, 'User5', '325c157a8b18499f5969aec11f505d2a', 'user5@mail.ru', 'user5', '0000-00-00', 'active', '/images/user-avatars/c9d450b8_57_min.png'),
(60, 'user6', '656e3bf368d83524bd14da9a1db7bc70', 'user6@mail.ru', 'user7', '2021-04-04', 'active', '/images/user-avatars/7be79ab3_60_min.png'),
(61, 'user7', '064c8247bd68155d7e4ea3f8b198e15b', 'user7@mail.ru', 'user7Skype', '2021-04-05', 'active', '/images/user-avatars/03f417d8_61_min.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookstime`
--
ALTER TABLE `bookstime`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `prices`
--
ALTER TABLE `prices`
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
-- AUTO_INCREMENT для таблицы `bookstime`
--
ALTER TABLE `bookstime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT для таблицы `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `temp-gmt`
--
ALTER TABLE `temp-gmt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `time-intervals`
--
ALTER TABLE `time-intervals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=418;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
